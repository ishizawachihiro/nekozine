<?php
/***************
require_once "twitteroauth.php";
************/
require_once "DB.php";

// nekozine OAuth
$consumer_key        = "";
$consumer_secret     = "";
$access_token        = "";
$access_token_secret = "";

// Google Pubsubhubbub ping
$tmp = file_get_contents("http://nekozine.net/instagram/update/");
$tmp = file_get_contents("http://feedburner.google.com/fb/a/pingSubmit?bloglink=http://nekozine.net/");
?>
