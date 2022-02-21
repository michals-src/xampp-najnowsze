<?php

if( ! defined( "ABSPATH" ) ){
    exit;
}

Class Sf_Shortcode{
    
    private static $output;

    private static $suffix;

    public function init(){

        $shortcodes = [

            "sf_manager_cennik" => "shortcodes_cennik",
            "sf_manager_grafik" => "shortcodes_grafik",
            "sf_manager_logowanie" => "shortcodes_logowanie",

            "sf_manager_panel_administracyjny" => "shortcodes_panel_administracyjny",
            "sf_manager_panel_uzytkownika" => "shortcodes_panel_uzytkownika",

            "sf_manager_print_person" => "shortcodes_print_person"

        ];

        self::$output = "Sf_shortcode_output";
        self::$suffix = "shortcode";


        foreach( $shortcodes as $shortcode_name => $callback ){
            add_shortcode( $shortcode_name, __CLASS__ . '::' . $callback );
        }

    }
    

    public function shortcodes_cennik( $atts = [] ){

        // $atts = $this->load_atts( $atts, [] );
        // ob_start();

        // $content = ob_get_contents();
        // ob_end_clean();

        // return $content;

    }

    public function shortcodes_grafik( $atts = [] ){

        // $atts = $this->load_atts( $atts, [] );
        // ob_start();

        // $content = ob_get_contents();
        // ob_end_clean();

        // return $content;

        return self::wrapper( 'grafik', $atts );

    }

    public function shortcodes_panel_uzytkownika( $atts = [] ){

        $callback = 'user_panel';
        if( ! empty( $atts ) && $atts['type'] === 'admin' ){
            $callback = 'admin_panel';
        }

        return self::wrapper( $callback, $atts );
    }

    public function shortcodes_print_person( $atts = [] ){
        return self::wrapper( 'print_person', $atts );
    }
    
    private static function load_atts( $atts = [], $defaults = [] ){
        $custom_atts = shortcode_atts( $defaults, $atts );
        return $custom_atts;
    }

    public static function shortcodes_logowanie( $atts = [] ){
        return self::wrapper( 'login', $atts );
    }

    private static function get_output( $slug = '' ){
        $slug = $slug . '_' . self::$suffix;
        return array( self::$output, $slug );
    }

    private static function wrapper( $slug = '', $atts = [] ){

        $atts = self::load_atts( $atts, [] );
        ob_start();

        $output = self::get_output( $slug );
        
        call_user_func( $output, $atts );

        $content = ob_get_contents();
        ob_end_clean();

        return $content;

    }

}