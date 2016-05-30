<?php $analytics = vh_get_option('analytics'); ?>

<?php if(isset($analytics) && !empty($analytics)): ?>
    <?php foreach($analytics as $script): ?>
        <?php echo $script; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php if(ENV === "development"): ?>
    <?php $bower = get_bloginfo('template_url') . '/bower_components/'; ?>
    <script src="<?php echo $bower; ?>/jquery/jquery.min.js"></script>
    <script src="<?php echo $bower; ?>/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo $bower; ?>/slick-carousel/slick/slick.min.js"></script>
    <script src="<?php echo $bower; ?>/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo $bower; ?>/jquery-validate/dist/jquery.validate.min.js"></script>
    <script src="<?php echo $bower; ?>/scroll-reveal/dist/scrollReveal.min.js"></script>
    <script src="<?php echo $bower; ?>/jquery.maskedinput/dist/jquery.maskedinput.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/settings.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/app.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/main.js"></script>
<?php else: ?>
    <script src="<?php bloginfo('template_url'); ?>/js/app.min.js"></script>
<?php endif; ?>

<?php wp_footer(); ?>
</body>