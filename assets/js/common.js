/*
 * common.js
 *
 * @author Chihiro Ishizawa
 * @package nekozin
 * @subpackage js
 */

var isMobile    = false,
    loadingCats = false
    $loadingDiv = null;

$(function(){
  /** mobile detection -------------------**/
  if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)))
    isMobile = true;
  
  /** lazy load on imags -----------------**/
  $(".polaroid_image").lazyload({effect : "fadeIn"});
  
  $loadingDiv = $("#loader");
  
  /** loading more cats ------------------**/
  $(window).scroll(function(){
    if($loadingDiv.length == 0)
      return;
  
    var docTop    = $(window).scrollTop();
    var docBottom = docTop + $(window).height();

    var loaderTop     = $loadingDiv.offset().top;
    var loaderBottom  = loaderTop + $loadingDiv.height();
    
    if((loaderBottom <= docBottom) && (loaderTop >= docTop) && !loadingCats){
      loadingCats = true;
      $loadingDiv.find("p").fadeIn(1000, function(){
        setTimeout(function(){
          if($loadingDiv.attr("data-type") == "user"){
            var ajaxUrl = "/ajax/getUserNextCats/" + $("#loader").attr("data-user") + "/" + $("#loader").attr("data-offset");
          }
          else{
            var ajaxUrl = "/ajax/getNextCats/" + $("#loader").attr("data-type") + "/" + $("#loader").attr("data-offset");
          }
          
          $.getJSON(
            ajaxUrl,
            function(json){
              $boxes = $(json.html);

              $(".polaroid_image", $boxes).lazyload({effect : "fadeIn"});
              $("#main_polaroid_list").append($boxes);
              
              $loadingDiv.attr("data-offset", json.offset);
              
              loadingCats = false;
              $loadingDiv.find("p").hide();
            }
          );
          
        }, 1500);
      });
    }
  });
  
  /** delete post action ----*/
  $(".del-post").live('click', function(e){
    e.preventDefault();
    var $this = $(this),
        href  = $this.attr("href"),
        $mbox = $("#del-post-modal");
    
    $mbox.modal('show');
    
    // Event binding
    var delpost = function(){
      $.getJSON(
        href,
        function(json){
          if(json.result){
            $this.closest(".polaroid_wrapper").fadeOut();
            $mbox.modal('hide');
          }
        }
      );
    };
    
    $(".btn-primary", $mbox).bind('click', delpost);
    
    $mbox.on('hidden', function(){
      $(".btn-primary", $mbox).unbind('click', delpost);
    });
  });
});