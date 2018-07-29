<?php

class Test extends CI_Controller{
  public function __construct(){
    parent::__construct();
  }
  
  public function index(){
    show_404();
  }
  
  public function twitpicGet(){
    $ch = curl_init();
    
    curl_setopt_array($ch, array(
      CURLOPT_URL => "http://twitpic.com/4681c5",
      CURLOPT_AUTOREFERER => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 10
    ));
    
    $html = curl_exec($ch);
    
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $totaltime = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
    
    echo "code " . $http_code . " <br> time " . $totaltime . "<br>"; 
  
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
    
    var_dump($image_url);
    
    $blob = file_get_contents($image_url);
      
      // Using imagick to create the thumbnail and full image cache
      $i = new Imagick();
      
      // Thumbnail image
      $i->readImageBlob($blob);
      $i->cropThumbnailImage(200, 200);
      
      //echo $i;
  }
}
?>