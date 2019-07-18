<h1>SiteMap XML Generator</h1>

<h3 id="txt"></h3>

<div class="wrap" id="in" style="display: none">

    <?php
    header("Content-type: text/xml");
    header('HTTP/1.1 200 OK');
    $posts_to_show = 1000;
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
    ?>
        <!-- generated-on=<?php echo get_lastpostdate('blog'); ?>-->
        <url>
            <loc><?php echo get_home_url(); ?></loc>
            <lastmod><?php $ltime = get_lastpostmodified(GMT);$ltime = gmdate('Y-m-d\TH:i:s+00:00', strtotime($ltime)); echo $ltime; ?></lastmod>
            <changefreq>daily</changefreq>
            <priority>1.0</priority>
        </url>
        <?php
        /* Articles */
        $myposts = get_posts( "numberposts=" . $posts_to_show );
        foreach( $myposts as $post ) { ?>
            <url>
                <loc><?php the_permalink(); ?></loc>
                <lastmod><?php the_time('c') ?></lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.6</priority>
            </url>
        <?php } /* FIn articles */ ?>
        <?php
        /* Page */
        $mypages = get_pages();
        if(count($mypages) > 0) {
        foreach($mypages as $page) { ?>
            <url>
                <loc><?php echo get_page_link($page->ID); ?></loc>
                <lastmod><?php echo str_replace(" ","T",get_page($page->ID)->post_modified); ?>+00:00</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.6</priority>
            </url>
    <?php }} /* Fin page */ ?>
        <?php
        /* Category */
        $terms = get_terms('category', 'orderby=name&hide_empty=0' );
        $count = count($terms);
        if($count > 0){
            foreach ($terms as $term) { ?>
                <url>
                    <loc><?php echo get_term_link($term, $term->slug); ?></loc>
                    <changefreq>weekly</changefreq>
                    <priority>0.8</priority>
                </url>
            <?php }} /* Fin category */?>
        <?php
        /* Tag */
        $tags = get_terms("post_tag");
        foreach ( $tags as $key => $tag ) {
            $link = get_term_link( intval($tag->term_id), "post_tag" );
            if ( is_wp_error( $link ) )
                return false;
            $tags[ $key ]->link = $link;
            ?>
            <url>
                <loc><?php echo $link ?></loc>
                <changefreq>monthly</changefreq>
                <priority>0.4</priority>
            </url>
        <?php } /* Fin tag */ ?>
    </urlset>
</div>

<button onclick="sitemap()">Generator Sitemap</button>
<a href="sitemap.xml" download>Download sitemap</a>

<script>

    function sitemap() {
        var sitemap = document.getElementsByTagName("urlset")[0];

        console.log(sitemap);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function(){
            if(request.readyState == 4){
                var container = document.getElementById("txt");
                container.innerHTML="Success !";
                console.log(request.response);
            }
        };

        request.open("POST", "/wp-content/plugins/sitemap/includes/write.php");
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("xml="+ sitemap.innerHTML);
    }

</script>