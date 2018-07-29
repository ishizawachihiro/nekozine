<?php
/*
 * rss_rdf.php RSS
 *
 */
header("Content-type: application/xml");
echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
$post = $posts[0];
?>
<rdf:RDF
 xmlns="http://purl.org/rss/1.0/"
 xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
 xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
 xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel rdf:about="http://japan.cnet.com">
    <title>nekozine</title>
    <description>ねこじんはTwitterやInstagramを経由してねこの写真を投稿し共有できるサービスです。</description>
    <link>http://nekozine.net/</link>
    <dc:date><?= date('r', strtotime($post->tweet_date)) ;?></dc:date>
    <language>ja</language>
    <rights>Copyright <?= gmdate("Y", time()); ?></rights>
    <items>
      <rdf:Seq>
   <?
   foreach($posts as $post){
    $url      = base_url() . "leaf/" . $post->id;
    echo '                <rdf:li rdf:resource="' . $url . '"/>' . "\n";
   }
   ?>
      </rdf:Seq>>
    </items>
  </channel>
  <?
  foreach($posts as $post){
    $url      = base_url() . "leaf/" . $post->id;
    $title    = $post->username."さんの投稿：". mb_strimwidth($post->body, 0, 20, "...");
    $date     = date('r', strtotime($post->tweet_date));
    $desc     = $post->body . "<br clear='left'><a href='" .$url . "'><img src='" . $post->getThumbImage() . "'></a>";
  ?>
  <item rdf:about="<?= $url ?>">
    <dc:format>text/html</dc:format>
    <dc:date><?= $date ?></dc:date>
    <title><?= $title ?></title>
    <link><?= $url ?></link>
    <description><?= htmlspecialchars($desc) ?></description>
  </item>
  <?
  }
  ?>
</rdf:RDF> 