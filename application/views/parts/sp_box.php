<?php
/*
 * sp_box.php 共通特集枠
 */
?>
<div class="well col2 box-shadow">
  <h3><a href="<?= $link ?>"><?= $title ?></a></h3>
  <?
    for($i = 0; $i < count($posts); $i++){
      $post = $posts[$i];
      $last = ($i + 1) == count($posts) ? " last" : "";
      $url  = base_url() . "leaf/" . $post->id;
  ?>
  <div class="well_item clearfix<?= $last ?>">
    <div class="polaroid_wrapper mini">
      <a href="<?= $url ?>"><img src="<?= $post->getThumbImage() ?>" class="nekoimg"></a>
    </div>
    <p class="blurb"><a href="<?= $url ?>"><?= mb_strimwidth($post->body, 0, 120, "..."); ?></a></p>
    <p class="author"><a href="<?= $url ?>"><img src="<?= Post::getUserAvatar($post->username); ?>"><?= $post->username ?></a></p>
  </div>
  <? } ?>
</div>