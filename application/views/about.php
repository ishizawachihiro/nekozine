<?php
/*
 * about.php About view
 *
 * @package nekozine
 * @subpackage views
 */
?>
<div class="row">
  <!-- left column -->
  <div id="about_column" class="span9">
    <h3 class="header">About nekozine</h3>
    <img src="<?= base_url() ?>assets/imgs/bg/bg_about.png" title="nekozine">
    <p id="about_intro">
      このサービスは@ishizawachihiroが空き時間で作っているサービスです。
      ねこの写真をTwitterやInstagram経由でシェアし、それをみた、ねこ好きが癒されればいいなと思っています。
      スピーディーな対応は出来ませんが、ご意見・ご要望などあれば@ishizawachihiroまでお知らせください。
    </p>
    <h3 class="header">FAQ</h3>
    <ul id="faqlist">
      <li><a href="#faq1">ねこの写真を nekozine に載せたい。どうやればいいですか？</a></li>
      <li><a href="#faq2">@nekozine にツイートしたけど写真が投稿されない。なぜ？</a></li>
    </ul>
    
    <dl id="faqanswerlist">
      <dt><a name="faq1">ねこの写真を nekozine に載せたい。どうやればいいですか？</a></dt>
      <dd class="row">
        <div class="span">
          <img src="<?= base_url() ?>assets/imgs/sample_nekozine.png" title="ねこじんから投稿する方法。">
        </div>
        <div class="span9">
          <h3>方法１：ねこじんから直接投稿する</h3>
          <p>画面右上の「LOGIN」ボタンからあなたのTwitterアカウントでログインしてください。ログインが成功すると上の写真のような画面が開き、この画面からねこじんへ投稿が出来ます。同時にTwitterにもつぶやかれます。過去に投稿した写真を削除したい場合には、写真横のゴミ箱アインをクリックすると削除が出来ます。</p>
        </div>
      </dd>

      <dd class="row">
        <div class="span">
          <img src="<?= base_url() ?>assets/imgs/sample.png" title="ねこじんに投稿する方法。">
        </div>
        <div class="span5">
          <h3>方法２：Twitterから投稿する</h3>
          <p>Twitterから nekozine にねこの写真を投稿するときは、本文の最後に「@nekozine」を加えてください</p>
          <p>←こんな感じです。</p>
        </div>
      </dd>
      <dd class="row">
        <div class="span">
          <img src="<?= base_url() ?>assets/imgs/sample_instagram.png" title="ねこじんに投稿する方法。">
        </div>
        <div class="span5">
          <h3>方法３：Instagramから投稿する</h3>  
          <p>Instagramから nekozine にねこの写真を投稿するときは、本文の最後に「#nekozine」を加えてください（ハッシュタグになっているので注意！）</p>
          <p>←こんな感じです。</p>
        </div>
      </dd>
      <dt><a name="faq1">@nekozine にツイートしたけど写真が投稿されない。なぜ？</a></dt>
      <dd>Twitterからの投稿の場合、ねこじんは現時点でtwitpicのURLにしか対応していません。twitpic以外の写真共有サービスを使っている場合は取込ができません。ごめんなさい。</dd>
    </dl>
    <h3 class="header">Policy</h3>
    <dl id="policy-list">
      <dt>ねこ写真を勝手にあつめません。</dt>
      <dd>
        nekozineはインターネットから勝手にねこの写真を集めたりしません。例えば、Twitterの「#cat」「#neko」などの一般的なねこ写真を示すハッシュタグなどを使って写真収集はしません。
        ねこを愛する人や飼い主さんが明示的に「nekozine」への掲載を指定してくれた場合に限りねこじんに写真が掲載されるようにしています。
        その為、TwitterやInstagramを経由してnekozineに写真を共有する場合には「@nekozine」や「#nekozine」を指定していただく必要があります。
        「@nekozine」のメイションや「#nekozine」のハッシュタグ（Instagram）を指定されたものをnekozineへの写真掲載に同意されたものとし、写真データの取得を行います。
      </dd>
      <dt>集まったねこ写真などの再利用について</dt>
      <dd>
        nekozineにあつまったコンテンツは、Twitter上の<a href="http://twitter.com/nekozine">@nekozine</a>で紹介されたり、<a href="https://www.facebook.com/nekozine">Facebookファンページ</a>上でシェアされることがあります。
        また、nekozineのサイトに訪れた一般読者から、TwitterやFacebook、Google＋やPinterestへシェアされることもあります。
      </dd>
      <dt>ねこの位置情報サービスについて</dt>
      <dd>
        ねこの写真と地図情報を使って、「どこに行けばねこに会えるかわかるサービスを作って！」とお問い合わせを頂きますが、ねこの個人情報をなるべく守りたいと考えているので、居場所がバレちゃうようなジオロケーションを使ったサービスなどを作る気はありません。
        カメラによっては、撮影した写真データの中に位置情報やカメラの機種などを特定する情報を埋め込んだりするものもありますので、写真から位置情報を抽出するような事は技術的に可能ですがやりません。
      </dd>
    </dl>
  </div>
  <!-- //left column -->
  <!-- right column -->
  <div id="rightcol" class="span3">
    <h3 class="header">ねこじんを<span>フォロー</span></h3>
    <dl id="authorwrapper" class="clearfix">
      <dd class="">
        <a href="https://twitter.com/nekozine" class="twitter-follow-button" data-show-count="false" data-lang="ja" data-size="large">@nekozineをフォロー</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
      </dd>
    </dl>
  </div>
  <!-- //right column -->
</div>