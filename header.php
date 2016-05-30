<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php echo get_bloginfo('name') . wp_title(' > ', false); ?></title>
    <meta name="description" content="<?php bloginfo( 'description' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/app.min.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <link href="css/legacy.css" rel="stylesheet">
    <![endif]-->
    <?php if (has_site_icon()): ?>
        <?php wp_site_icon(); ?>
    <?php else: ?>
        <link type="image/x-icon" rel="icon" href="<?php echo bloginfo('template_url'); ?>/favicon.ico">
    <?php endif; ?>

    <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
    
    <?php wp_head(); ?>

    <?php if(is_admin_bar_showing()): ?>
        <style type="text/css"> .navbar-fixed-top { top: 32px; } </style>
    <?php endif; ?>
</head>
<body>
