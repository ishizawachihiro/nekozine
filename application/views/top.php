<?php
  /*
   * top.php Top view
   *
   * @package nekozine
   * @subpackage views
   */
  
  $menu_items = array(
    "recent"  => array("最新",  base_url()),
    "popular" => array("人気", base_url() . "popular"),
    "liked"   => array("好き", base_url() . "liked")
  );
?>
<div id="category-nav" class="subnav subnav-fixed">
  <div class="container">
    <div class="nav">
      <?
        foreach($menu_items as $name => $info){
          $class = $name == $selected ? "selected" : "";
      ?>
      <span class="<?= $class ?>"><a href="<?= $info[1] ?>"><?= $info[0] ?></a></span>
      <? } ?>
    </div>
  </div>
</div>

<div id="intro_blurb">
  <p class="large">ねこの写真を nekozine でシェアしよう</p>
  <p><span>好きなねこ写真を nekozine へ<a href="<?= base_url() ?>about">アップロード</a></span></p>
</div>
<div id="main_polaroid_list" class="clearfix">
  <?
    for($i = 0; $i < count($posts); $i++){
      $post = $posts[$i];
      $last = ($i + 1) % 5;
      $this->load->view('parts/post', array('post' => $post, 'last' => $last));
    }
  ?>
</div>
<div id="loader" data-offset="35" data-type="<?= $selected ?>">
  <p style="display:none"><img src="<?= base_url() ?>assets/imgs/8.gif">Loading more cats...</p>
</div>