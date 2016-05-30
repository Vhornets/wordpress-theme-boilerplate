<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class VH_Admin {

    private $key = 'vh_options';

    private $metabox_id = 'vh_option_metabox';

    protected $title = '';

    protected $options_page = '';

    public function __construct() {
        $this->title = 'Настройки темы';
    }

    public function hooks() {
        add_action( 'admin_init', array( $this, 'init' ) );
        add_action( 'admin_menu', array( $this, 'add_options_page' ) );
        add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );
        add_action( 'admin_bar_menu', array( $this, 'add_admin_toolbar_link' ), 999 );
    }

    public function init() {
        register_setting( $this->key, $this->key );
    }

    public function add_options_page() {
        $this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ), 'dashicons-desktop');
        // add_action( "admin_head-{$this->options_page}", array( $this, 'enqueue_js' ) );
    }

    public function add_admin_toolbar_link($wp_admin_bar) {
        $wp_admin_bar->add_node(array(
            'id'    => $this->key,
            'title' => $this->title,
            'href'  => admin_url('/admin.php?page='.$this->key)
        ));
    }

    public function admin_page_display() {
        ?>
        <div class="wrap cmb2-options-page <?php echo $this->key; ?>">
            <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
            <?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
        </div>
        <?php
    }

    function add_options_page_metabox() {

        $cmb = new_cmb2_box( array(
            'id'      => $this->metabox_id,
            'hookup'  => false,
            'show_on' => array(
                // These are important, don't remove
                'key'   => 'options-page',
                'value' => array( $this->key, )
            ),
        ) );

        $cmb->add_field( array(
            'name' => 'Логотип',
            'id'   => 'header_logo',
            'type' => 'file',
        ) );

        $cmb->add_field( array(
            'name' => 'ссылка на страницу instagram',
            'id'   => 'link_instagram',
            'type' => 'text',
            'default' => 'http://instagram.com/',
        ) );

        $cmb->add_field( array(
            'name' => 'ссылка на страницу vkontakte',
            'id'   => 'link_vkontakte',
            'type' => 'text',
            'default' => 'http://vk.com/',
        ) );

        $cmb->add_field( array(
            'name' => 'ссылка на страницу facebook',
            'id'   => 'link_facebook',
            'type' => 'text',
            'default' => 'http://facebook.com/',
        ) );

        $cmb->add_field( array(
            'name' => 'ссылка на страницу twitter',
            'id'   => 'link_twitter',
            'type' => 'text',
            'default' => 'http://twitter.com/',
        ) );

        $cmb->add_field( array(
            'name' => 'Аналитика',
            'id'   => 'analytics',
            'before_row' =>' <hr/>',
            'type' => 'textarea_code',
            'repeatable' => true
        ) );

    }

    public function __get( $field ) {
        // Allowed fields to retrieve
        if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
            return $this->{$field};
        }

        throw new Exception( 'Invalid property: ' . $field );
    }

}


function vh_admin() {
    static $object = null;
    if ( is_null( $object ) ) {
        $object = new VH_Admin();
        $object->hooks();
    }

    return $object;
}


function vh_get_option( $key = '' ) {
    return cmb2_get_option( vh_admin()->key, $key );
}

// Get it started
vh_admin();