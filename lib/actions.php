<?php
add_action('wp_ajax_sendmail', function () { });
add_action('wp_ajax_nopriv_sendmail', function () { });

// Add Facebook Open Graph metatags
add_action('wp_head', 'fb_opengraph', 5);
function fb_opengraph() {
    global $post;

    $img_src = '';
    $excerpt = get_bloginfo('description');
 
    if(is_single()) {
        if(has_post_thumbnail($post->ID)) {
            $img_src = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'medium');
            $img_src = $img_src[0];
        } 
        // else {
        //     $img_src = get_stylesheet_directory_uri() . '/img/opengraph_image.jpg';
        // }
        if($excerpt = $post->post_excerpt) {
            $excerpt = strip_tags($post->post_excerpt);
            $excerpt = str_replace("", "'", $excerpt);
        }
        ?>
        <meta property="og:title" content="<?php echo the_title(); ?>"/>
        <meta property="og:description" content="<?php echo $excerpt; ?>"/>
        <meta property="og:type" content="article"/>
        <meta property="og:url" content="<?php echo the_permalink(); ?>"/>
        <meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
        <meta property="og:image" content="<?php echo $img_src; ?>"/>
 
<?php
    } else {
        return;
    }
}

// Посты из какой категории выводит во front-page.php
// add_action('pre_get_posts', 'ad_filter_categories');
// function ad_filter_categories($query) {
//     if ($query->is_main_query() && is_home()) {
//         $query->set('post_type','release');
//     }
// }