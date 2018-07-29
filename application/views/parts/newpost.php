<?php

?>
<!-- update post -->
<div id="new-post" class="modal">
  <div class="modal-header">
    <h3>新しいポストを入稿</h3> 
  </div>
  
  <form class="form-horizontal" action="/profile/newpost" enctype="multipart/form-data" method="post">
  <div class="modal-body">
    <div class="control-group">
      <label class="control-label">ポスト</label>
      <div class="controls">
        <textarea name="status" rows="6" class="span4"><?= set_value('status'); ?></textarea>
        <?= form_error('status'); ?>
      </div>
    </div>
  
    <div class="control-group">
      <label class="control-label">写真</label>
      <div class="controls">
        <input type="file" name="media"><br>
        <?= form_error('media'); ?>
      </div>
    </div>
  </div>
  
  <div class="modal-footer">
    <a href="/user/<?= $username ?>" class="btn">キャンセル</a>
    <input type="submit" class="btn btn-primary" value="ポスト">
  </div>
  </form>
</div>
<!-- //update post -->