<?php
/*
 * userinfo.php
 *
 * @author Chihiro Ishizawa
 * 2012/05/25 Ishizawa: 作成
 */

  if(!isset($admin))
    $admin = false;
?>
<!-- user info -->
<div id="user-info">
  <div class="container">
    <div class="row">
      <img src="<?= $avatar ?>" class="span">
      <div class="span">
        <h1><?= $user->username ?></h1>
        <ul id="user-stats" class="row">
          <li class="span">
            <p><strong><?= $user->getUserPostCount() ?></strong> Posts</p>
          </li>
          <li class="span">
            <p><strong><?= $user->getUserPostLikeCount() ?></strong> Likes</p>
          </li>
        </ul>
      </div>
      <div class="span" id="user-actions">
        <? if($admin){ ?>
        <a href="#edit-user-modal" id="edit-user-info" class="btn" data-toggle="modal">プロフィル情報を変更</a>
        <a href="/profile/newpost" id="upload-post" class="btn">新しいポスト</a>
        <? } ?>
      </div>
    </div>
  </div>
</div>
<!-- //user info -->

<? if($admin){ ?>
<!-- edit info modal -->
<div id="edit-user-modal" class="modal fade">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">x</a>
    <h3>プロフィール情報を変更</h3>
  </div>
  
  <form class="form-horizontal" action="/profile/update" enctype="multipart/form-data" method="post">
  <div class="modal-body">
      <div class="control-group">
        <label class="control-label">プロフィール写真</label>
        <div class="controls">
          <input type="file" name="profilepic">
          <input type="hidden" name="username" value="<?= $user->username ?>">
        </div>
      </div>
  </div>
  <div class="modal-footer">
    <a href="" class="btn">Close</a>
    <input type="submit" class="btn btn-primary" value="Save Changes">
  </div>
  </form>
</div>
<!-- //edit info modal -->

<!-- update post modal -->
<div id="update-post-modal" class="modal fade">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">x</a>
    <h3>新しいポストを投稿</h3> 
  </div>

  <form class="form-horizontal" action="/profile/newpost" enctype="multipart/form-data" method="post">
  <div class="modal-body">
    <div class="control-group">
      <label class="control-label">ポスト</label>
      <div class="controls">
        <textarea name="post-body" rows="6" class="span4"></textarea>
      </div>
    </div>
  
    <div class="control-group">
      <label class="control-label">写真</label>
      <div class="controls">
        <input type="file" name="post-media">        
      </div>
    </div>
  </div>
  
  <div class="modal-footer">
    <a href="" class="btn">Close</a>
    <input type="submit" class="btn btn-primary" value="Upload Post">
  </div>
  </form>
</div>
<!-- //update post modal -->
<? } ?>