<?php
class VH_Fields {
    protected static $_instance;

    protected static $_fields;

    protected static $_prefix = '_vh_';

    private function __construct(){}

    private function __clone(){}

    private function replaceNewLinesWithBr($text) {
        return str_replace("\n", "<br>", $text);
    }

    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public static function get($name, $id = null, $single = true) {
        if(!$id) {
            $id = get_the_ID();
        }

        return get_post_meta($id, self::$_prefix.$name, $single);
    }

    public function getPseudoRich($name, $id = null) {
        return $this->replaceNewLinesWithBr( self::get($name, $id) );
    }

    public function getRich($name, $id = null) {
        return apply_filters( 'the_content', self::get($name, $id) );
    }

    public function getBlockBg($name, $id = null) {
        $bg = self::get($name, $id);
        $repeat = '';

        if(self::get("$name-repeat")) {
            $repeat = 'background-repeat: repeat; background-size: initial;';
        }

        if($bg) echo "background-image: url($bg); $repeat";

        else echo '';
    }

    public static function getPrefix() {
        return self::$_prefix;
    }

    public static function get_pseudo_rich($text) {
        return self::getInstance()->replaceNewLinesWithBr($text);
    }
}