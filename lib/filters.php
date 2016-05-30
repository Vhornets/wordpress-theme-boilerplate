<?php
add_filter('wp_mail_content_type', 'mail_content_type_custom');
function mail_content_type_custom() { return 'text/html'; }

add_filter( 'wp_mail_from', 'mail_from_custom' );
function mail_from_custom( $email ) { return get_bloginfo('admin_email'); }

// Для страниц вида single-blog, single-[catname]
// add_filter('single_template', function($the_template) {
//     foreach( (array) get_the_category() as $cat ) {
//         if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") )
//         return TEMPLATEPATH . "/single-{$cat->slug}.php"; 
//     }
//     return $the_template;
// });
// Для страниц-субкатегорий в категории (blog заменить на нужную категорию)
// add_action('template_redirect', function() {
//     if (is_category() && !is_feed()) {
//         if (is_category(get_cat_id('blog')) || cat_is_ancestor_of(get_cat_id('blog'), get_query_var('cat'))) {
//             load_template(TEMPLATEPATH . '/category-blog.php');
//             exit;
//         }
//     }
// });

add_filter('embed_oembed_html', 'flex_video');
function flex_video( $code ){
    if(stripos($code, 'iframe') !== FALSE) {
        $code = '<div class="embed-responsive embed-responsive-16by9">'.$code.'</div>';
    }

    return $code;
}

add_filter('shortcode_atts_gallery', 'gallery_atts', 10, 3 );
function gallery_atts($out, $pairs, $atts) {
   
    $atts = shortcode_atts( array(
        'size' => 'medium',
         ), $atts );

    $out['size'] = $atts['size'];

    return $out;
}

add_filter( 'post_gallery', 'vh_post_gallery', 10, 2 );
function vh_post_gallery( $output, $attr ) {
 
    // Initialize
    global $post, $wp_locale;
 
    // Gallery instance counter
    static $instance = 0;
    $instance++;
 
    // Validate the author's orderby attribute
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( ! $attr['orderby'] ) unset( $attr['orderby'] );
    }
 
    // Get attributes from shortcode
    extract( shortcode_atts( array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'large',
        'include'    => '',
        'exclude'    => ''
    ), $attr ) );
 
    // Initialize
    $id = intval( $id );
    $attachments = array();
    if ( $order == 'RAND' ) $orderby = 'none';
 
    if ( ! empty( $include ) ) {
 
        // Include attribute is present
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
 
        // Setup attachments array
        foreach ( $_attachments as $key => $val ) {
            $attachments[ $val->ID ] = $_attachments[ $key ];
        }
 
    } else if ( ! empty( $exclude ) ) {
 
        // Exclude attribute is present 
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
 
        // Setup attachments array
        $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
    } else {
        // Setup attachments array
        $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
    }
 
    if ( empty( $attachments ) ) return '';
 
    // Filter gallery differently for feeds
    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment ) $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
        return $output;
    }
 
    // Filter tags and attributes
    $itemtag = tag_escape( $itemtag );
    $captiontag = tag_escape( $captiontag );
    $columns = intval( $columns );
    $itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
    $float = is_rtl() ? 'right' : 'left';
    $selector = "gallery-{$instance}";
 
    // Filter gallery CSS
    $output = "<div id='$selector' class='gallery galleryid-{$id}' data-gallery-type='image'>";
 
    // Iterate through the attachments in this gallery instance
    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $gallery_item_src = wp_get_attachment_image_src($id, 'large');
        $gallery_item_src = $gallery_item_src[0];
 
        // Attachment link
        $link = isset( $attr['link'] ) && 'file' == $attr['link'] ? wp_get_attachment_link( $id, $size, false, false ) : wp_get_attachment_link( $id, $size, true, false ); 
 
        // Start itemtag
        $output .= "<{$itemtag} class='gallery-item'>";
 
        // icontag
        $output .= "<a href='$gallery_item_src'>";
        $output .= "<div class='gallery-item__body' style='background-image: url($gallery_item_src);'>";
        $output .= "</div>";
        $output .= "</a>";

 
        // End itemtag
        $output .= "</{$itemtag}>";
    }
 
    // End gallery output
    $output .= "</div>\n";
 
    return $output;
}