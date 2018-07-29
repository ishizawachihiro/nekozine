<?php
/*
 * simple.php
 *
 * @package views
 * @subpackage templates
 */

   $title      = isset($title) ? $title : "nekozine.net";
   $meta_title = $title;
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="title" content="<?= $meta_title ?>">
  <meta name="description" content="">
  <meta name="google-site-verification" content="cdGYE-MeR8UNXl0cULyu7Is7EjcXcim90aDLJKK_VZ0" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="fb:app_id" content="276537725750565"/>

  <title><?= $meta_title ?></title>
  
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css" media="all">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-responsive.min.css" media="all">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/common.css" media="all">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/common-smartphone.css" media="all and (max-width: 480px)">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/iconfont.css" media="all">
  
  <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.1.7.1.min.js"></script>
</head>
<body>
  <!-- content -->
  <div id="content">
    <div class="container">
      <?= $this->load->view($view); ?>
    </div>
  </div>
  <!-- //content -->
</body>
</html>