<?php
/*
 * post.php Post model
 *
 * @author Chihiro Ishizawa
 * @package model
 */

class Post extends CI_Model{
  private static $db;
  private static $cache_folder;
  
  function __construct(){
    parent::__construct();
    self::$db = &get_instance()->db;
    self::$cache_folder = $_SERVER['DOCUMENT_ROOT'] . "/assets/img_cache/";
  }
  
  /*
   * 一つのポストオブジェクトを返す
   * @param (int) id
   * @return (mixed)
   */
  public static function get($id){
    $options = array();
    $options['ids']       = array($id);
    $options['limit_row'] = 1;
    
    $posts = Post::getPosts($options);
    
    return count($posts) > 0 ? $posts[0] : null;
  }
  
  /*
   *　ポストを返す
   * @param (array) options
   * @return (array)
   */
  public static function getPosts($options = array()){
    $def_options = array(
      "statuses"  => array(1),
      "skip_row"  => 0,
      "limit_row" => 9,
      "order_by"  => "tweet_date desc",
      "get_count" => false
    );
    
    $options = array_merge($def_options, $options);
    
    // Manually setting all the columns as using * removes the id field when
    // there is not match on the likes table
    $query = self::$db->select('post.id, post.username, post.body, post.picurl, post.type, post.tweet_date, post_stat.likes, post_stat.views')
      ->from('post')
      ->join('post_stat', 'post_stat.id = post.id', 'left')
      ->where_in('post.status', $options['statuses']);
    
    if(isset($options['ids']))
      $query->where_in('post.id', $options['ids']);
  
    // 検索条件
    if(isset($options['usernames']))
      $query->where_in('username', $options['usernames']);
    
    if(isset($options['types']))
      $query->where_in('type', $options['types']);
    
    $order  = explode(" ", $options['order_by']);
    $by     = $order[0];
    $dir    = $order[1] ? $order[1] : "desc";
    
    $query->order_by($by, $dir)
      ->limit($options['limit_row'], $options['skip_row']);
      
    if($options['get_count']){
      return $query->count_all_results();
    }
    else{
      return $query->get()->result('Post');
    }
  }
  
  /*
   * Returns the latest posts from this user while excluding the current post
   * @param (int) number of related posts to return
   * @return (array)
   */
  public function getRelatedPosts($count = 9){
    $query = self::$db->select('*')
      ->from('post')
      ->where('username', $this->username)
      ->where_not_in('post.id', $this->id)
      ->order_by("tweet_date", "desc")
      ->limit($count, 0)
      ->get();
      
    return $query->result('Post');
  }
  
  /*
   * Returns the most popular posts
   * @param (int) number of posts to return
   * @return (array)
   */
  public static function getPopularPosts($count = 4){
    $query = self::$db->select('post.id, post.username, post.body, post.picurl, post.type, post.tweet_date, post_stat.likes, post_stat.views')
      ->from('post')
      ->join('post_stat', 'post_stat.id = post.id', 'left')
      ->limit($count, 0)
      ->order_by('post_stat.views', 'desc')
      ->get();
    
    return $query->result('Post');
  }
  
  /*
   * Returns the thumbnail image path.
   * Priority to the cache file is given and if no cache file is found then
   * an ajax call is triggered to create the cache files
   * @return (string)
   */
  public function getThumbImage(){
    $img_url    = base_url() . "assets/img_cache/thumb/thumb_" . $this->id . ".jpg";
    $cache_file = self::$cache_folder . "thumb/thumb_" . $this->id . ".jpg";
    
    if(!file_exists($cache_file)){
      self::sendAsyncRequest(base_url() . "ajax/createImageCache/" . $this->id);
      
      // Return the image link directly from the server
      switch($this->type){
        case "twitter":
          $img_url = $this->picurl;
        
          if(stripos($img_url, "instagr.am") !== false){
            $img_url = $img_url .= "media/?size=m";
          }
          else{
            $img_url = str_ireplace("http://twitpic.com/", "http://twitpic.com/show/large/", $img_url);
          }
          break;
        
        case "instagram":
          $img_url = $this->picurl . "media/?size=m";
          break;
      }
    }
    
    return $img_url;
  }
  
  /*
   * Returns the full image path. See above for caching
   * @return (string)
   */
  public function getFullImage(){
    $img_url    = base_url() . "assets/img_cache/large/large_" . $this->id . ".jpg";
    $cache_file = self::$cache_folder . "large/large_" . $this->id . ".jpg";
    
    if(!file_exists($cache_file)){
      self::sendAsyncRequest(base_url() . "ajax/createImageCache/" . $this->id);
      
      // Return the image link directly from the server
      switch($this->type){
        case "twitter":
          $img_url = $this->picurl;
        
          if(stripos($img_url, "instagr.am") !== false){
            $img_url = $img_url . "media/?size=l";
          }
          else{
            $img_url = str_ireplace("http://twitpic.com/", "http://twitpic.com/show/large/", $img_url);  
          }
          break;
        
        case "instagram":
          $img_url = $this->picurl . "media/?size=l";
          break;
      }
    }
    
    return $img_url;
  }
  
  /*
   * Triggers an ajax type call
   * @param (string) url
   */
  private function sendAsyncRequest($url){
    $parts = parse_url($url);
    $port  = $parts['port'] ? $parts['port'] : 80;
    
    $fp = fsockopen($parts['host'], $port, $errno, $errstr, 30);
    
    if($fp){
      $out = "POST ".$parts['path']." HTTP/1.1\r\n";
      $out.= "Host: ".$parts['host']."\r\n";
      $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
      $out.= "Connection: Close\r\n\r\n";
    
      fwrite($fp, $out);
      fclose($fp);
    }
  }
  
  /*
   * Precursor to the actual function that creates the image cache.
   * This is to handle future types
   */
  public function createImageCache(){
    switch($this->type){
      case "twitter":
        // Deal with multiple twitter picture types
        $url = $this->picurl;

        if(stripos($url, "instagr.am") !== false){
          $this->createInstagramCache();
        }
        else if(stripos($url, "p.twimg.com") !== false){
          $this->createTwimgCache(); 
        }
        else{
          $this->createTwitpicImageCache(); 
        }
        break;
      
      case "instagram":
        $this->createInstagramCache();
        break;
      
      default:
        break;
    }
  }
  
  /*
   * Creates the image cache from the instagram image
   */
  private function createInstagramCache(){
    $url  = "http://api.instagram.com/oembed?url=" . $this->picurl;

    $curl = curl_init();
    
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    
    $_json = curl_exec($curl);
    curl_close($curl);
    
    $json = json_decode($_json);
    
    // Cache url
    $img  = $json->url;
    $blob = file_get_contents($img);
    
    $i = new Imagick();
    
    // Thumbnail image
    $i->readImageBlob($blob);
    $i->cropThumbnailImage(200, 200);
    try{
      $result = $i->writeImage(self::$cache_folder . "thumb/thumb_" . $this->id . ".jpg");
    }
    catch(ImagickException $e){
      
    }
    
    // Full image
    $i->readImageBlob($blob);
    try{
      $result = $i->writeImage(self::$cache_folder . "large/large_" . $this->id . ".jpg");
    }
    catch(ImagickException $e){
      
    }
  }
  
  /*
   * Creates the image cache from the twitpic image
   */
  private function createTwitpicImageCache(){
    // Step 1 get the twitpic url
    $curl = curl_init();
   
    curl_setopt($curl, CURLOPT_URL, $this->picurl);
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    
    $html = curl_exec($curl);
    
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $totaltime = curl_getinfo($curl, CURLINFO_TOTAL_TIME);
    $image_url = "";
    
    curl_close($ch);
  
    if($http_code == 200 && $html){
      $dom = new DOMDocument();
      @$dom->loadHTML($html);
      
      // grab all the on the page
      $xpath = new DOMXPath($dom);
      $hrefs = $xpath->evaluate("/html/body//img");
      
      foreach($hrefs as $href){
        $url = $href->getAttribute('src');
        
        if(stripos($url, "/photos/large/") || stripos($url, "photos/full")){
          $image_url = $url;
          break;
        }
      }
    }
    
    if($image_url){
      $blob = file_get_contents($image_url);
      
      // Using imagick to create the thumbnail and full image cache
      $i = new Imagick();
      
      // Thumbnail image
      $i->readImageBlob($blob);
      $i->cropThumbnailImage(200, 200);
      $result = $i->writeImage(self::$cache_folder . "thumb/thumb_" . $this->id . ".jpg");
      
      // Full image
      $i->readImageBlob($blob);
      $result = $i->writeImage(self::$cache_folder . "large/large_" . $this->id . ".jpg");
    }
  }
  
  private function createTwimgCache(){
    $blob = file_get_contents($this->picurl);
    
    $i = new Imagick();
    
    // Thumbnail image
    $i->readImageBlob($blob);
    $i->cropThumbnailImage(200, 200);
    $result = $i->writeImage(self::$cache_folder . "thumb/thumb_" . $this->id . ".jpg");
    
    // Full image
    $i->readImageBlob($blob);
    $result = $i->writeImage(self::$cache_folder . "large/large_" . $this->id . ".jpg");
  }
  
  /*
   * Increments the like count for given the post id
   * @param (string) post id
   * @return (int) updated count
   */
  public static function incrementLike($id){
    $count  = 0;
    $query  = self::$db->get_where('post_stat', array('id' => $id));
    $row    = $query->row();
    
    if($row){
      $count = $row->likes;
      $count++;
      
      $query = self::$db->update('post_stat', array('likes' => $count), array('id' => $id));
    }
    
    return $count;
  }
  
  /*
   * Increments the view count for the given post id
   * @param (string) post id
   * @return (int) updated count
   */
  public static function incrementView($id){
    $count  = 0;
    $query  = self::$db->get_where('post_stat', array('id' => $id));
    $row    = $query->row();
    
    if($row){
      $count = $row->views;
      $count++;
      
      $query = self::$db->update('post_stat', array('views' => $count), array('id' => $id));
    }
    
    return $count;
  }
  
  /*
   * Returns the user's avatar
   * @param (string) username
   * @return (string)
   */
  public static function getUserAvatar($username){
    $url = "";
    
    $query  = self::$db->get_where('users', array('username' => $username));
    $row    = $query->row();
    
    if($row)
      $url = $row->imageurl;
  
    return $url;
  }
  
  /*
   * Saves the current post state as a new object
   */
  public function save(){
    $query  = self::$db->get_where('post', array('id' => $this->id));
    $row    = $query->row();
    
    if(!$row){
      // Update
      $data = array(
        'body'    => $this->body,
        'picurl'  => $this->picurl,
        ''
      );
    }
    else{
      // Create
      self::$db->insert('post', $this);
    }
  }
  
  /*
   * Called to add a new item after a successful api call
   * (via the input form)
   */
  public static function insertNewTweet($json){
    $result = false;
    
    $status = $json->text;
    $status = preg_replace("#via @nekozine#","", $status);
    $status = preg_replace("#httpi?:\/\/t.co\/[_a-zA-Z0-9]+#", "", $status);
    $status = trim($status);

    $data = array(
      "id"         => $json->id_str,
      "username"   => $json->user->screen_name,
      "body"       => $status,
      "picurl"     => $json->entities->media[0]->media_url,
      "type"       => "twitter",
      "tweet_date" => date('Y-m-d H:i:s', strtotime($json->created_at)),
      "add_date"   => date('Y-m-d H:i:s'),
      "status"     => 1, 
    );

    $query  = self::$db->get_where('post', array('id' => $json->id_str));
    $row    = $query->row();
    
    if(!$row){
      $query = self::$db->insert('post', $data);
      
      // Create the stats for this item
      $data = array(
        'id'    => $json->id_str,
        'likes' => 0,
        'views' => 0
      );
      
      $query = self::$db->insert('post_stat', $data);
      $result = true;
    }
      
    return $result;
  }
}
?>