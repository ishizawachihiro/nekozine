<?php
class Importer extends CI_Controller{
  // class constructor
  public function __construct(){
    parent::__construct();
  }
  
  public function index(){
    echo "hello world";
  }
  
  public function info(){
    echo "<pre>";print_r($_SERVER);echo "</pre>";
  }
  
  public function test(){
    $id = "45659583389245440";
    $post = Post::get($id);
    $url = $post->getFullImage();
    
    echo $url;
  }
  
  public function importRows(){
    $query    = $this->db->get('tweets');
    $tbl_data = array();
    
    foreach($query->result() as $row){
      $data = array(
        "id"          => $row->id,
        "username"    => $row->username,
        "body"        => $row->body,
        "picurl"      => $row->picurl,
        "type"        => "twitter",
        "tweet_date"  => $row->tweet_date,
        "add_date"    => $row->add_date,
        "status"      => $row->status == "live" ? 1 : 0 
      );
    
      $this->db->insert('post', $data);
      //$this->db->update('post', $data, "id = " . $row->id);
    }
  }
  
  public function setStats(){
    $query    = $this->db->get('tweets');
    $tbl_data = array();
    
    foreach($query->result() as $row){
      $data = array(
        "id"    => $row->id,
        "views" => 0,
        "likes" => 0
      );
      
      $this->db->insert('post_stat', $data);
    }
  }
}
?>