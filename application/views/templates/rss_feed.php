<?php
/*
 * rss_feed.php RSSテンプレート
 *
 * @package nekozine
 * @subpackage views
 */

header("Content-type: application/xml");
echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";

$post = $posts[0];

?>
<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">
<channel>
  <title>nekozine</title>
  <link>http://nekozine.net</link>
  <description>ねこ好きあつまれー</description>
  
  <language>ja</language>
  <rights>Copyright <?= gmdate("Y", time()); ?></rights>
  <lastBuildDate><?= date('r', strtotime($post->tweet_date)) ;?></lastBuildDate>
  
  <?
    foreach($posts as $post){
      $url      = base_url() . "leaf/" . $post->id;
      $img_link = "<link rel='enclosure' type='image/jpeg' href='" . $post->getThumbImage() . "' />";
      //$img_link = "<img src='" . $post->getThumbImage() . "'>";
  ?>
  <item>
    <title><?= $post->username ?>さんの投稿：<?= mb_strimwidth($post->body, 0, 20, "..."); ?></title>
    <link><?= $url ?></link>
    <guid><?= $url ?></guid>
    <link rel="enclosure" type="image/jpeg" href="<?= $post->getThumbImage() ?>" />
    <description><![CDATA[
      <?= $post->body ?>
    ]]></description>
    <pubDate><?= date('r', strtotime($post->tweet_date)); ?></pubDate>
  </item>
  <? } ?>
</channel>
</rss> 