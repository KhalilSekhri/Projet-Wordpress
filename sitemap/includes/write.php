<?php
$handle = fopen("sitemap.xml", "w");
fwrite($handle, "<urlset>");
fwrite($handle,"<?xml version=\"1.0\" encoding=\"UTF-8\"?>");
fwrite($handle, $_POST['xml']);
fwrite($handle, "</urlset>");

fclose($handle);

echo "success";

/*

<div class="wrap" id="in" >
    <h1>SiteMap XML Generator</h1>

    <h3 id="txt"></h3>

    <?php
    header("Content-type: text/xml");
    header('HTTP/1.1 200 OK');
    $posts_to_show = 1000;

    $txt = "";

    $txt .= '<?xml version="1.0" encoding="UTF-8"?>';
    $txt .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    $txt .= "<!-- generated-on=".get_lastpostdate('blog')."-->";

    $ltime = get_lastpostmodified(GMT);$ltime = gmdate('Y-m-d\TH:i:s+00:00', strtotime($ltime));
    $txt .= "
        <url>
            <loc>".get_home_url()."</loc>
            <lastmod>".$ltime."</lastmod>
            <changefreq>daily</changefreq>
            <priority>1.0</priority>
        </url>
        ";


    $myposts = get_posts( "numberposts=" . $posts_to_show );
    foreach( $myposts as $post ) {
        $txt .= "
            <url>
                <loc>".the_permalink()."</loc>
                <lastmod>".the_time('c')."</lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.6</priority>
            </url>
            ";
    }
    $mypages = get_pages();
    if(count($mypages) > 0) {
        foreach($mypages as $page) {
            $txt .= "
                <url>
                    <loc>".get_page_link($page->ID)."</loc>
                    <lastmod>".str_replace(" ","T",get_page($page->ID)->post_modified)."+00:00</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.6</priority>
                </url>
                ";
        }
    }


    $terms = get_terms('category', 'orderby=name&hide_empty=0' );
    $count = count($terms);
    if($count > 0){
        foreach ($terms as $term) {
            foreach($mypages as $page) {
                $txt .= "
                    <url>
                        <loc>".get_term_link($term, $term->slug)."</loc>
                        <changefreq>weekly</changefreq>
                        <priority>0.8</priority>
                    </url>
                    ";
            }
        }
    }
    $tags = get_terms("post_tag");
    foreach ( $tags as $key => $tag ) {
        $link = get_term_link( intval($tag->term_id), "post_tag" );
        if ( is_wp_error( $link ) )
            return false;
        $tags[ $key ]->link = $link;

        $txt .= "
                    <url>
                        <loc>".$link."</loc>
                        <changefreq>monthly</changefreq>
                        <priority>0.4</priority>
                    </url>
                    ";

    }


    $txt .= "</urlset>";

    echo $txt;
    $handle = fopen("sitemap.xml", "a+");
    fwrite($handle, $txt);
    fclose($handle);
    ?>
    <button onclick="sitemap()">Download Sitemap</button>
</div>

<script>

    function sitemap() {
        var sitemap = document.getElementsByTagName("urlset")[0];

        console.log(sitemap);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function(){
            if(request.readyState == 4){
                var container = document.getElementById("txt");
                container.innerHTML="Success !";
            }
        };

        request.open("GET", "write.php");
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("xml="+ sitemap);
    }

</script>
*/