<?php
/*
 * postimage.php Post image model
 *
 * @author Chhiro Ishizawa
 * @package model
 */

class PostImage extends CI_Model{
  private static $db;
  private static $cache_dir;
  
  function __construct(){
    parent::__construct();
    self::$db = &get_instance()->db;
    self::$cache_dir = $_SERVER['DOCUMENT_ROOT'] . "/imgcache/";
  }
  
}
?>