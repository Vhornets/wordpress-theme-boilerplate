<?php
add_filter('cmb2_init', 'init_metaboxes');

function init_metaboxes() {
    $prefix = VH_Fields::getPrefix();
}
