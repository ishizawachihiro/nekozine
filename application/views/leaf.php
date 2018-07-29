<?php
  /*
   * leaf.php Leaf view
   *
   * @package nekozine
   * @subpackage views
   */
  
  $this_url      = base_url() . "leaf/" . $post->id;
  $this_body     = htmlspecialchars($post->body);
  $this_img      = $post->getThumbImage();
?>
<div class="row">
  <!-- left column -->
  <div id="leftcol" class="span9">
    <div class="row" id="photoleaf">
      <!-- photoleaf_wrapper -->
      <div class="row clearfix">
        <div id="photowrapper" data-nekoid="<?= $post->id ?>">
          <img src="<?= $post->getFullImage(); ?>">
          <p class="date">POSTED ON: <?= date('Y/m/d H:i', strtotime($post->tweet_date)); ?></p>
          <blockquote><?= $post->body ?></blockquote>
          <!-- disqus -->
          <div id="disqus_thread"></div>
          <script type="text/javascript">
              /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
              var disqus_shortname = 'nekozine'; // required: replace example with your forum shortname
          
              /* * * DON'T EDIT BELOW THIS LINE * * */
              (function() {
                  var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                  dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                  (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
              })();
          </script>
          <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
          <!-- //disqus -->
        </div>
        <dl id="authorwrapper">
          <dt>AUTHOR</dt>
          <dd class="authorinfo imgbox clearfix">
            <div class="img">
              <a href=""><img src="<?= Post::getUserAvatar($post->username) ?>" width="48" height="48"></a>
            </div>
            <div class="blurb" style="font-size:80%"> 
              by&nbsp;@<?= $post->username ?>
              <ul class="authorstats">
                <li><a href="<?= base_url(); ?>user/<?= $post->username ?>"><?= $user->getUserPostCount(); ?> <span>posts</span></a></li>
              </ul>
            </div>
          </dd>
          
          <dd class="like_btn imgbox clearfix">
            <div class="img fonticon ico_heart"></div>
            <div class="blurb">このねこを <br><span>LIKE</span></div>
          </dd>
         
          <dt>PHOTO STATS</dt>
          <dd>
            <ul class="photoleaf_stats clearfix">
              <li class="clearfix" id="postlikes">
                <p class="fonticon ico_heart"></p>
                <p class="fonticon_stat"><em><?= $post->likes ?></em><br><span>LIKES</span></p>
              <li>
              <li class="clearfix last" id="postviews">
                <p class="fonticon ico_eye"></p>
                <p class="fonticon_stat"><em><?= $post->views ?></em><br><span>VIEWS</span></p>
              </li>
            </ul>
          </dd>
                
          <dt>SHARE THIS</dt>
          <dd class="sharebtn">
            <a href="https://twitter.com/share" class="twitter-share-button" data-text="<?= $post->body ?>" data-via="nekozine" data-lang="ja">ツイート</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          </dd>
          <dd class="sharebtn">
            <div class="fb-like" data-send="false" data-layout="button_count" data-width="210" data-show-faces="false"></div>
          </dd>
          <dd class="sharebtn">
            <a href="http://pinterest.com/pin/create/button/?url=<?= h($social_info['url']) ?>&media=<?= h($social_info['image']) ?>&description=<?= h($social_info['title']) ?>" class="pin-it-button" count-layout="horizontal">Pin It</a>
            <script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script>
          </dd>
          <dd class="sharebtn">
            <g:plusone size="medium" annotation="inline" width="210"></g:plusone>
            
            <script type="text/javascript">
              window.___gcfg = {lang: 'ja'};
            
              (function() {
                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                po.src = 'https://apis.google.com/js/plusone.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
              })();
            </script>
          </dd>
        </dl>
      </div>
      <!-- //photoleaf_wrapper -->
    </div>
  </div>
  <!-- //lft column -->
    
  <!-- right column -->
  <div id="rightcol" class="span3">
    <? if(isset($related_posts) && count($related_posts) > 0){ ?>
    <h3 class="header"><a href="<?= base_url(); ?>user/<?= $post->username ?>">関連<span>ポスト</span></a></h3>
    <div class="rel_polaroid_list clearfix">
      <? foreach($related_posts as $rel_post){ ?>
      <div class="polaroid_wrapper">
        <a href="<?= base_url() ?>leaf/<?= $rel_post->id ?>"><img src="<?= $rel_post->getThumbImage(); ?>" width="80" height="80"></a>
      </div>
      <? } ?>
    </div>
    <div class="more"><a href="<?= base_url(); ?>user/<?= $post->username ?>"><?= $post->username ?>　一覧へ</a></div>
    <? } ?>
    
    <? if(isset($popular_posts)){ ?>
    <h3 class="header"><a href="<?= base_url() ?>popular/">人気<span>ポスト</span></a></h3>
    <div class="rel_polaroid_list clearfix">
      <?
        for($i = 0; $i < count($popular_posts) && $i < 2; $i++){
          $post = $popular_posts[$i]; 
          $url  = base_url() . "leaf/" . $post->id;
      ?>
      <div class="polaroid_wrapper">
        <a href="<?= $url ?>"><img src="<?= $post->getThumbImage(); ?>" width="80" height="80"></a>
      </div>
      <? } ?>
    </div>
    <div class="more"><a href="<?= base_url(); ?>popular">もっと見る</a></div>
    <? } ?>
  </div>
  <!-- //right column -->
</div>
