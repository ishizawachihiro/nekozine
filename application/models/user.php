<?php
/*
 * user.php User model
 *
 * @author Chihiro Ishizawa
 * @package model
 */

class User extends CI_Model{
  private static $db;
  
  function __construct(){
    parent::__construct();
    self::$db = &get_instance()->db;
  }
  
  /*
   * 一つユーザーオブジェクトを返す
   * @param (string) username
   * @return (mixed)
   */
  static function get($username){
    $query  = self::$db->get_where('users', array('username' => $username), 1);
    $result = $query->result('User');
    
    return count($result) > 0 ? $result[0] : null;
  }
  
  /*
   * ユーザーポスト数を返す
   * @return (int)
   */ 
  public function getUserPostCount(){
    $query = self::$db->select('*')
      ->from('post')
      ->where('username', $this->username);
      
    return $query->count_all_results();
  }
  
  /*
   * Like されたポスト数を返す
   * @return (int)
   */
  public function getUserPostLikeCount(){
    $query = self::$db->select('post.id, post_stat.likes')
      ->where_in('username', $this->username)
      ->from('post')
      ->join('post_stat', 'post_stat.id = post.id', 'left')
      ->get();
    
    $total = 0;
    foreach($query->result() as $row)
      $total += $row->likes;
      
    return $total;
  }
  
  public function updateProfileImage($file){
    $result       = false;
    $error        = "";
    $valid_mimes  = array("image/jpg", "image/jpeg", "image/png". "image/gif"); 
    
    $file_info    = getimagesize($file['tmp_name']);
    
    if(!in_array($file_info['mime'], $valid_mimes) || !$file_info){
      $error = "Invalid file type";
    }
    else{
      // All profile should be 100px x 100px
      $i = new Imagick();
      $i->readImage($file['tmp_name']);
      
      $save_dir   = $_SERVER['DOCUMENT_ROOT'] . "/assets/avatars/";
      $save_name  = uniqid() . "_" . $file['name'];
      
      $width  = $file_info[0];
      $height = $file_info[1];
      
      if($width > 100 && $height > 100)
        $i->cropThumbnailImage(100, 100);
      
      try{
        $result = $i->writeImage($save_dir . $save_name);
      }
      catch(ImagickException $e){
        $result = false;
      }
      
      if($result){
        // Delete the previous avatar
        $query  = self::$db->get_where('users', array('username' => $this->username));
        $row    = $query->row();
        
        $avatar_path = $row->imageurl;
        
        if(($pos = stripos($avatar_path, "/assets/avatars/")) !== false){
          $actual_path = $_SERVER['DOCUMENT_ROOT'] . substr($avatar_path, $pos);
          unlink($actual_path);
        }
      
        // Update the db
        $imageurl = base_url() . "assets/avatars/" . $save_name;
        $query = self::$db->update('users', array('imageurl' => $imageurl), array('username' => $this->username));
      }
    }
    
    return compact('result', 'error');
  }
}
?>