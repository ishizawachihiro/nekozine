<?php
  /*
   * layout-mini.php
   *
   * @author Chihiro Ishizawa
   * @package views
   * @subpackage templates
   */
  
  $header     = isset($header) ? $header : "parts/header";
  $footer     = isset($footer) ? $footer : "parts/footer";
  $title      = isset($title) ? $title : "nekozine.net";
  $meta_title = isset($post) ? "[nekozine]".htmlspecialchars($post->body) : $title;
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
  <?= generate_og_tags($post); ?>
  
  <title><?= $meta_title ?></title>
  
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css" media="all">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/common.css" media="all">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/iconfont.css" media="all">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/common-smartphone.css" media="all and (max-width: 480px)">

  <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.1.7.1.min.js"></script>
  <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.masonry.min.js"></script>
  <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.lazyload.min.js"></script>
</head>
<body>
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
  <!-- header -->
  <header>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a href="<?= base_url() ?>" class="brand">
            <img src="<?= base_url() ?>assets/imgs/logo.png" alt="nekozine">
            <span>ねこ好きあつまれ〜</span>
          </a>
          <ul class="nav">
            <li><a href="<?= base_url() ?>">HOME</a></li>
            <li><a href="<?= base_url() ?>about">ABOUT</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  
  <!-- content -->
  <div id="content">
    <div class="container">
      <?= $this->load->view($view); ?>
    </div>
  </div>
  <!-- //content -->
  
  <!-- javascripts -->
  <script type="text/javascript" src="<?= base_url() ?>assets/js/jqueryRotate.min.2.1.js"></script>
  <script type="text/javascript" src="<?= base_url() ?>assets/js/common.js"></script>
  <?
    if(isset($javascripts) && is_array($javascripts)){
      foreach($javascripts as $javascript){
  ?>
  <script type="text/javascript" src="<?= $javascript ?>"></script>
  <?
      }
    }
  ?>
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-7022291-3']);
    _gaq.push(['_trackPageview']);
  
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
  <!-- //javascripts -->
</body>
</html>