<?php 
echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
?>
<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">

    <channel>
    
    <title><?php echo $feed_name; ?></title>

    <link><?php echo $feed_url; ?></link>
    <description><?php echo $page_description; ?></description>
    <dc:language><?php echo $page_language; ?></dc:language>
    <dc:creator><?php echo $creator_email; ?></dc:creator>

    <dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
    <admin:generatorAgent rdf:resource="http://www.huntdrop.com/" />


    <?php foreach($all_posts as $i=>$r): ?>
    
        <item>

          <title><?php echo xml_convert($type_list[$r->type_id].' - '.$post[$i]['title']); ?></title>
          <link><?php echo site_url( $links[$r->type_id]. '/' . $r->ref_id . '/' . $post[$i]['alias']) ?></link>
          <guid><?php echo site_url( $links[$r->type_id]. '/' . $r->ref_id . '/' . $post[$i]['alias']) ?></guid>

          <description><?php echo substr(strip_tags($post[$i]['content']),0,147); if(strlen(strip_tags($post[$i]['content']))>150){ echo "...";}?></description>
      <pubDate><?php echo pretty_date($r->entry_date);?></pubDate>
        </item>

        
    <?php endforeach; ?>
    
    </channel></rss> 
