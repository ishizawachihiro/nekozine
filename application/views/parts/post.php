<?php
/*
 * post.php 共通ポストテンプレート
 */

  if(!isset($admin))
    $admin = false;
?>
<div class="polaroid_wrapper box-shadow">
  <div class="polaroid_image">
    <? if($admin){ ?>
    <div class="polaroid-actions">
      <a href="<?= base_url() ?>ajax/delete_post/<?= $post->id ?>" class="btn del-post"><i class="icon-trash"></i></a>
    </div>
    <? } ?>
    <a href="<?= base_url() ?>leaf/<?= $post->id ?>"><img class="polaroid_image" src="<?= base_url() ?>assets/imgs/dummycat.png" data-original="<?= $post->getThumbImage(); ?>"></a>
  </div>
  <div class="polaroid_info">
    <? if($view != "user"){ ?>
    <p class="author clearfix">
      <a href="<?= base_url(); ?>user/<?= $post->username ?>"><img src="<?= Post::getUserAvatar($post->username); ?>"><?= $post->username ?></a>
    </p>
    <? } ?>
    <p class="summary"><a href="<?= base_url() ?>leaf/<?= $post->id ?>"><?= mb_strimwidth($post->body, 0, 50, "..."); ?></a></p>
    <ul class="polaroid_stats clearfix">
      <li class="fonticon ico_heart"><span><?= $post->likes ?></span></li>
      <li class="fonticon ico_eye"><span><?= $post->views ?></span></li>
    </ul>
  </div>
</div>