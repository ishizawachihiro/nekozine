<?php
if(!function_exists("h")){
  function h($string){
    return htmlspecialchars($string, ENT_QUOTES);
  }
}

if(!function_exists("generate_og_tags")){
  function generate_og_tags($post = null){
    if($post){
      $title  = h($post->body);
      $url    = "http://nekozine.net/leaf/" . $post->id;
      $image  = $post->getFullImage();
      
return <<<OGTAG
<meta property='og:title' content='$title'>
<meta property='og:type' content='article'>
<meta property='og:site_name' content='nekozine'>
<meta property='og:url' content='$url'>
<meta property='og:image' content='$image'>
OGTAG;
    }
    else{
return <<<OGTAG
<meta property='og:title' content='nekozine.net'>
<meta property='og:type' content='article'>
<meta property='og:site_name' content='nekozine'>
<meta property='og:url' content='http://nekozine.net'>
<meta property='og:image' content='http://nekozine.net/assets/imgs/bg/bg_about.png'>
<meta property="og:description" content="ねこじん - TwitterやInstagramをつかってねこの写真を投稿しよう！">
OGTAG;
    }
  }
}
?>