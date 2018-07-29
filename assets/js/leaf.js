/*
 * leaf.js leaf related JavaScript
 *
 * @package nekozine
 * @subpackage javascripts
 */

$(function(){
  var postid = $("#photowrapper").attr("data-nekoid");
  
  // View increment
  if(BrowserDetect.OS && BrowserDetect.browser && postid){
    $.getJSON(
      "../ajax/incrementView/" + postid,
      function(json){
        if(json){
          $("#postviews .fonticon_stat em").text(json.count);
        }
      }
    );
  }
  
  // Like increment
  $(".like_btn").click(function(){
    if(postid){
      $.getJSON(
        "../ajax/incrementLike/" + postid,
        function(json){
          if(json){
            $("#postlikes .fonticon_stat em").text(json.count);
          }
        }   
      );
    }
  });
});