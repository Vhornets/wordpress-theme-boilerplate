<?php
function is_subcategory($category = null) {
    if (is_category()) {
        if (null != $category){
            $cat = get_category($category);
        }else{
            $cat = get_category(get_query_var('cat'),false);
        }
        if ($cat->parent == 0 ){
            return false;
        }else{
            return true;
        }
    }
    return false;
}

function the_pagination() {
    global $wp_query, $wp_rewrite;

    $max = $wp_query->max_num_pages;

    if (!$current = get_query_var('paged')) $current = 1;

    $a = array(
        'type'      => 'array',
        'base'      => str_replace(999999999, '%#%', get_pagenum_link(999999999)),
        'total'     => $max,
        'current'   => $current,
        'mid_size'  => 3,
        'end_size'  => 1,
        'prev_text' => 'Назад',
        'next_text' => 'Вперед'
    );

    $pages = paginate_links($a);
    ?>

    <?php if(is_array($pages)): ?>
        <ul class="pagination">
            <?php foreach($pages as $page): ?>
                <li><?php echo $page; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php
    endif;
}

function the_breadcrumb() {
    global $post;
    echo '<ul id="breadcrumbs">';
    if (!is_home()) {
        echo '<li><a href="';
        echo get_option('home');
        echo '">';
        echo 'Главная';
        echo '</a></li><li class="separator"> / </li>';
        if (is_category() || is_single()) {
            echo '<li>';
            the_category(' </li><li class="separator"> / </li><li> ');
            if (is_single()) {
                echo '</li><li class="separator"> / </li><li>';
                the_title();
                echo '</li>';
            }
        } elseif (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
                    $output = '<li><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a></li> <li class="separator">/</li>';
                }
                echo $output;
                echo '<strong title="'.$title.'"> '.$title.'</strong>';
            } else {
                echo '<li><strong> '.get_the_title().'</strong></li>';
            }
        }
    }
    elseif (is_tag()) {single_tag_title();}
    elseif (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';}
    elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>';}
    elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>';}
    elseif (is_author()) {echo"<li>Author Archive"; echo'</li>';}
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}
    elseif (is_search()) {echo"<li>Search Results"; echo'</li>';}
    echo '</ul>';
}

/**
 * Получает ссылку на миниатюру записи
 *
 * @param int $size Размер миниатюры (thumb, medium, large, full)
 * @param int $post_id ID или объект поста
 * @return string $src URL изображения
 */
function get_thumbnail_src($size = 'medium', $post_id = null){
    $post_id = ($post_id == null ? get_the_ID() : $post_id);

    $thumb_id = get_post_thumbnail_id($post_id);
    $src = wp_get_attachment_image_src($thumb_id, $size);

    return $src[0];
}

/**
 * Проверяет является страница дочерней по отношению к указанной странице
 *
 * @param int $pageID ID страницы
 * @return bool
 */
function is_child($pageID) {
    global $post;

    if(is_page() && ($post->post_parent == $pageID)) {
        return true;
    }

    return false;
}

/**
 * Получает адреса изображений из галереи поста
 *
 * @param string $image_size Размер изображений (small, medium, large, full)
 * @param int $post_id ID или объект поста
 * @return array $images Массив адресов изобрежний
 */
function get_gallery_images($images_size = 'large', $post_id) {
    $images = array();

    if(!$post_id) $post_id = get_the_ID();

    if (!get_post_gallery($post_id)) return false;

    $gallery = get_post_galleries($post_id, false);

    foreach(explode(',', $gallery[0]['ids']) AS $id) {
        $url = wp_get_attachment_image_src($id, $images_size);
        $images[] = $url[0];
    }

    return $images;
}

/**
 * Устанавливает/получает количество просмотров поста
 * @param  int $postId      ID Поста
 * @param  string $method   Метод (get или set)
 * @return int $count       Количество просмотров
 */
function the_post_views($postId = false, $method = 'get') {
    if(!$postId) $postId = get_the_ID();
    $count_key = '_post_views';
    $count = get_post_meta($postId, $count_key, true);

    if($count == ''){
        if($method == 'set') $count = 0;
        delete_post_meta($postId, $count_key);
        add_post_meta($postId, $count_key, '0');
    }
    else {
        if($method == 'set') {
            $count++;
            update_post_meta($postId, $count_key, $count);
        }
    }

    return $count;
}

function sendmail($subj, $body) {
    $to = array('mailbackup@nextpage.com.ua', get_bloginfo('admin_email'));
    $subj = get_bloginfo('name') . ' - ' . $subj;

    if(wp_mail($to, $subj, $body)) return true;
    else return false;
}

/**
 * Like get_template_part() put lets you pass args to the template file
 * Args are available in the tempalte as $template_args array
 * @param string filepart
 * @param mixed wp_args style argument list
 */
function hm_get_template_part( $file, $template_args = array(), $cache_args = array() ) {
	$template_args = wp_parse_args( $template_args );
	$cache_args = wp_parse_args( $cache_args );
	if ( $cache_args ) {
		foreach ( $template_args as $key => $value ) {
			if ( is_scalar( $value ) || is_array( $value ) ) {
				$cache_args[$key] = $value;
			} else if ( is_object( $value ) && method_exists( $value, 'get_id' ) ) {
				$cache_args[$key] = call_user_method( 'get_id', $value );
			}
		}
		if ( ( $cache = wp_cache_get( $file, serialize( $cache_args ) ) ) !== false ) {
			if ( ! empty( $template_args['return'] ) )
				return $cache;
			echo $cache;
			return;
		}
	}
	$file_handle = $file;
	do_action( 'start_operation', 'hm_template_part::' . $file_handle );
	if ( file_exists( get_stylesheet_directory() . '/' . $file . '.php' ) )
		$file = get_stylesheet_directory() . '/' . $file . '.php';
	elseif ( file_exists( get_template_directory() . '/' . $file . '.php' ) )
		$file = get_template_directory() . '/' . $file . '.php';
	ob_start();
	$return = require( $file );
	$data = ob_get_clean();
	do_action( 'end_operation', 'hm_template_part::' . $file_handle );
	if ( $cache_args ) {
		wp_cache_set( $file, $data, serialize( $cache_args ), 3600 );
	}
	if ( ! empty( $template_args['return'] ) )
		if ( $return === false )
			return false;
		else
			return $data;
	echo $data;
}

function get_youtube_thumb($youtube_url, $size = 'maxresdefault') {
    $video_id = explode('?v=', $youtube_url);
    return "http://img.youtube.com/vi/{$video_id[1]}/$size.jpg";
}

function get_post_var($var) {
    return (isset($_POST[$var]) && $_POST[$var]) ? filter_var($_POST[$var], FILTER_SANITIZE_STRING) : '';
}