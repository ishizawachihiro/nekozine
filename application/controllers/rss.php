<?php
/*
 * rss.php rss controller
 *
 * @package nekozine
 * @subpackage controllers
 */

class Rss extends CI_Controller{
  public function __construct(){
    parent::__construct();
  }
  
  /*
   * Recent items, 20 items
   */
  public function index(){
    $options = array();
    $options['limit_row'] = 20;
    
    $posts = Post::getPosts($options);
    
    $data = array();
    $data['posts'] = $posts;
    
    $this->load->view('templates/rss_feed', $data);
  }
  /*
   * Recent items, 20 items
   */
  public function rdf(){
    $options = array();
    $options['limit_row'] = 20;
    
    $posts = Post::getPosts($options);
    
    $data = array();
    $data['posts'] = $posts;
    
    $this->load->view('templates/rss_rdf', $data);
  }

}
?>