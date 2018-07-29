<?php
/*
 * logout.php
 *
 * @package views
 * @subpackage profile
 */
?>
<div id="login-box">
  <h1><img src="<?= base_url() ?>assets/imgs/logo_lrg.png"></h1>
  <h3>Logout successfully. Redirecting to the top page</h3>
  <h3>ログアウトしました。トップページにもどります。</h3>
</div>
<script type="text/javascript">
$(function(){
  setTimeout(function(){window.location = "/"}, 3000);
});
</script>