<?php
/*
 * ajax.php ajax controller
 *
 * @package nekozine
 * @subpackage controllers
 */

class Ajax extends CI_Controller{
  // class constructor
  public function __construct(){
    parent::__construct();
  }
  
  public function index(){
    show_404();
  }
  
  /*
   * Creates the image cache based on the post id, mainly used
   * as an ajax call from the Post model
   * @param (char) id
   */
  public function createImageCache($id){
    $post = Post::get($id);
    
    if($post)
      $post->createImageCache();
  }
  
  /*
   * Increments the like count for the particular post
   * @param (char) id
   */
  public function incrementLike($id){
    $count = Post::incrementLike($id);
    
    header("Content-type: application/json");
    echo json_encode(array("count" => $count));
  }
  
  /*
   * Increments the view count for the particular post
   * @param (char) id
   */
  public function incrementView($id){
    $count = Post::incrementView($id);
    
    header("Content-type: application/json");
    echo json_encode(array("count" => $count));
  }
  
  /*
   * Retuns the next set of cats for a user
   * @param (string) username
   * @param (int) offset
   */
  public function getUserNextCats($username, $offset){
    $json = array();
    
    $options = array();
    $options['usernames'] = array($username);
    $options['skip_row']  = $offset;
    $options['limit_row'] = 30;
    
    $posts = Post::getPosts($options);
    
    $html = "";
    for($i = 0; $i < count($posts); $i++){
      $post = $posts[$i];
      $html .= $this->load->view("parts/post", array("post" => $post, "view" => "user"), true);
    }
    
    $json['html']   = $html;
    $json['offset'] = $offset + count($posts);
    
    header("Content-type: application/json");
    echo json_encode($json);
  }
  
  /*
   * Returns the next set of cats
   * @param (string) type
   * @param (int) offset
   */
  public function getNextCats($type, $offset){
    $json = array();
    
    $options = array();
    $options['skip_row']    = $offset;
    $options['limit_row']   = 30;
    
    switch($type){
      case "popular":
        $options['order_by'] = "post_stat.views desc";
        break;
      
      case "liked":
        $options['order_by'] = "post_stat.likes desc";
        break;
      
      case "recent":
      default:
        break;
    }
    
    $posts = Post::getPosts($options);
    
    $html = "";
    for($i = 0; $i < count($posts); $i++){
      $post = $posts[$i];
      $html .= $this->load->view("parts/post", array("post" => $post), true);
    }
    
    $json['html']   = $html;
    $json['offset'] = $offset + count($posts);
    
    header("Content-type: application/json");
    echo json_encode($json);
  }
  
  public function delete_post($id){
    // TODO: check session for logged in user
    $is_admin = true;
    $json     = array();
    
    $post = Post::get($id);
  
    if($post && $is_admin){
      $this->db->where('id', $id)->update('post', array('status' => 0));
      $json['result'] = true;
    }
    else{
      $json['result'] = false;
    }
    
    header("Content-type: application/json");
    echo json_encode($json);
  }
}
?>