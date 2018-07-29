<?php
/*
 * instagram.php
 *
 * @author Chihiro Ishizawa
 * 2012/01/22 created
 */

class Instagram extends CI_Controller{
  private $_consumer_key        = "";
  private $_consumer_secret     = "";
  private $_access_token        = "";
  private $_secret_access_token = "";
  private $_code                = "";
  
  public function __construct(){
    parent::__construct();
    
    $this->load->library('instagram_api');
  }
  
  /*
   * The normal OAuth flow, once we get the access key show the 404 status
   */
  public function index(){
    $loginurl = $this->instagram_api->instagramLogin();
    redirect($loginurl);
    show_404();
  }
  
  /*
   * OAuth redirect - called after the instagram login
   */
  public function oauthredirect(){
    $obj = $this->instagram_api->authorize($_GET['code']);
    var_dump($obj);
  }
  
  public function update(){
    $options = array();
    $options['types']     = array('instagram');
    $options['limit_row'] = 1;
    
    $posts  = Post::getPosts($options);
    $min_id = null;
    
    if(count($posts) > 0)
      $min_id = $posts[0]->id;
    
    // Getting the posts by tags
    $obj = $this->instagram_api->authorize($this->_code);
    $this->instagram_api->access_token = $this->_access_token;
    
    $obj  = $this->instagram_api->tagsRecent("nekozine", null, $min_id);
    $feed = $obj->data;
    
    echo "Items retrieved: " . count($feed) . "<br>";
    
    foreach($feed as $item){
      // Save the post, use the link instead of the actual image link
      // to keep in line with twitter 'instagram' links
      $data = array();
      $data['id']         = $item->id;
      $data['username']   = $item->user->username;
      $data['body']       = $item->caption->text; 
      $data['picurl']     = $item->link;  
      $data['type']       = "instagram";
      $data['tweet_date'] = date('Y-m-d H:i:s', $item->created_time);
      $data['add_date']   = date('Y-m-d H:i:s');
      $data['status']     = 1;
      
      // Insert/Update
      $query = $this->db->get_where('post', array('id' => $item->id), 1, 0);
      
      if($query->num_rows() == 0){
        $this->db->insert('post', $data);
        echo "Inserted " . $item->id . "<br>";
        
        // Create the stats
        $stats = array();
        $stats['id']    = $item->id;
        $stats['likes'] = 0;
        $stats['views'] = 0;
        
        $this->db->insert('post_stat', $stats);
      }
      else{
        $this->db->update('post', $data, array('id' => $item->id));
        echo "Updated " . $item->id . "<br>";
      }
      
      // User information
      $data = array();
      $data['username'] = $item->user->username;
      $data['imageurl'] = $item->user->profile_picture;
      
      // Insert/Update
      $query = $this->db->get_where('users', array('username' => $item->user->username), 1, 0);
      
      if($query->num_rows() == 0){
        $this->db->insert('users', $data);
      }
      else{
        $this->db->update('users', $data, array('username' => $item->user->username));
      }
    }
  }
}
?>