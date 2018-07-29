<?php
/*
 * image.php image controller
 *
 * @package nekozine
 * @subpackage controllers
 */

class Image extends CI_Controller{
  private static $cache_folder;
  
  // class constructor
  public function __construct(){
    parent::__construct();
    self::$cache_folder = $_SERVER['DOCUMENT_ROOT'] . "/assets/img_cache/";
  }
  
  public function index(){
    show_404();
  }
  
  /*
   * Creates the image cache based on the post id, mainly used
   * as an ajax call from the Post model
   * @param (var char) id
   */
  public function createImageCache($id){
    $post = Post::get($id);
    
    if($post){
      $post->createImageCache();
    }
  }
}
?>
