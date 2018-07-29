<?php
/*
 * top.php base controller
 *
 * @package nekozine
 * @subpackage controllers
 */

class Top extends CI_Controller{
  // class constructor
  public function __construct(){
    parent::__construct();  
  }
  
  // Landing page
  public function index(){
    $this->recent();
  }
  
  // Shows the most recent posts
  public function recent(){
    $options = array();
    $options['limit_row'] = 35;
    
    $posts = Post::getPosts($options);
    
    $data = array();
    $data['view']     = "top";
    $data['selected'] = "recent";
    $data['posts']    = $posts; 
    
    $this->load->view('templates/layout', $data);
  }
  
  // Shows the most popular posts
  public function popular(){
    $options = array();
    $options['limit_row'] = 35;
    $options['order_by']  = "post_stat.views desc";
    
    $posts = Post::getPosts($options);
    
    $data = array();
    $data['view']     = "top";
    $data['selected'] = "popular";
    $data['posts']    = $posts;
    
    $this->load->view('templates/layout', $data);
  }
  
  // Shows the most 'liked' posts
  public function liked(){
    $options = array();
    $options['limit_row'] = 35;
    $options['order_by']  = "post_stat.likes desc";
    
    $posts = Post::getPosts($options);
    
    $data = array();
    $data['view']     = "top";
    $data['selected'] = "liked";
    $data['posts']    = $posts;
    
    $this->load->view('templates/layout', $data);
  }
  
  // Leaf page for a single post
  // @param (int) id - post id
  public function post($id){
    $post = Post::get($id);
    
    if(!$post){
      show_404();
    }
    else{
      // ソーシャル系
      $social_info = array();
      $social_info['url']    = "http://nekozine.net/" . $this->uri->uri_string();
      $social_info['title']  = $post->body;
      $social_info['image']  = $post->getFullImage();
      
      $data = array();
      $data['view'] = "leaf";
      $data['post'] = $post;
      $data['user'] = User::get($post->username);
      $data['social_info']    = $social_info;
      $data['related_posts']  = $post->getRelatedPosts(4);
      $data['popular_posts']  = Post::getPopularPosts(2);
      $data['javascripts']    = array(
        base_url() . "assets/js/browserDetect.js",
        base_url() . "assets/js/leaf.js"
      );
      
      $data['fluid'] = false;
      
      //var_dump($data);
      
      $this->load->view('templates/layout', $data);
    }  
  }
  
  // User post page
  // @param (string) username
  // @param (int) offset - post offset returned by the pagination
  public function user($username, $offset = 0){
    $user = User::get($username);
    
    if($user){
      $options = array();
      $options['usernames'] = array($username);
      $options['limit_row'] = 35;
      
      $posts = Post::getPosts($options);
      
      $data = array();
      $data['title']  = $username . "のポスト";
      $data['view']   = "user";
      $data['user']   = $user;
      $data['posts']  = $posts;
      $data['avatar'] = Post::getUserAvatar($username);
      
      // Check loggined in user with current user
      $logged_in_user = $this->session->userdata('logged_in_user');
      
      if($logged_in_user == $username)
        $data['admin']  = true;
      
      $this->load->view('templates/layout', $data);
    }
    else{
      show_404();
    }  
  }
  
  // About page
  public function about(){
    $username = "ishizawachihiro";
    $user     = User::get($username);
    $count    = $user->getUserPostCount();
    
    $data = array();
    $data['view']       = "about";
    $data['user']       = $user;
    $data['username']   = $username;
    $data['avatar']     = Post::getUserAvatar($username);
    $data['post_count'] = $count;
    $data['fluid']      = false;
    
    $this->load->view('templates/layout', $data);
  }
}
?>