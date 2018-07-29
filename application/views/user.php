<?php
  /*
   * user.php User view
   *
   * @package nekozine
   * @subpackage views
   */
  
  if(!isset($admin))
    $admin = false;
?>
<div id="main_polaroid_list" class="clearfix">
<?
  for($i = 0; $i < count($posts); $i++){
    $post = $posts[$i];
    $this->load->view('parts/post', array('post' => $post));
  }
?>
</div>
<div id="loader" data-offset="35" data-type="user" data-user="<?= $user->username ?>">
  <p style="display: none"><img src="<?= base_url() ?>assets/imgs/8.gif">Loading more cats...</p>
</div>

<div class="modal fade hide" id="del-post-modal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3>確認</h3>
  </div>
  <div class="modal-body">
    <p>このポストを nekozine から削除しますか？削除すると復活させることはできません。</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">キャンセル</a>
    <a href="#" class="btn btn-primary">削除</a>
  </div>
</div>