<?php
if (file_exists(dirname(__FILE__) . '/lib/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/lib/vendor/autoload.php';
}

require_once 'lib/vendor/webdevstudios/cmb2/init.php';
require_once 'lib/VHFields.php';
require_once 'lib/metaboxes.php';
require_once 'lib/admin-options.php';
require_once 'lib/utils.php';
require_once 'lib/filters.php';
require_once 'lib/actions.php';
require_once 'lib/post-types.php';
require_once 'lib/classes.php';
require_once 'lib/shortcodes.php';

add_theme_support('post-thumbnails');

register_nav_menus(array(
	'main-menu' => 'Главное меню',
	// 'sidebar-menu' =>'Меню в сайдбаре'
));

register_sidebar(array(
	'name' => 'sidebar-main',
	'id' => 'sidebar-main',
	'description' => 'Боковое меню'
));