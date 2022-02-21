<?php

Class Sf_Manager{

    public static $_instance;

    public static function instance(){

        if( ! isset( $_instance ) ) self::$_instance = new Sf_Manager;
        return self::$_instance;

    }

    public function __construct(){
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
        /** 
         * 
         * Login page
         * Dashboard
         *  - Ustawienia główne
         *  - Powiadomienia (Notices + Modal)
         *  - Zajęcia (Oferta)
         *  - Grafik (Grafik)
         *  - Karnety (Cennik)
         * 
         * 
         * Frontend view
         * 
        */


        /** 
         * 
         * install (default options)
         * post_type (Register post_types)
         * ajax (Endpoint)
         * shortcodes (Register shortcodes)
         *  - templates (Engine templates)
        */

        $this->constants();
        $this->includes();
        $this->hooks();

    }

    public function hooks(){

        add_action( 'init', array( $this, 'user_settings' ) );
        add_action( 'init', array( 'Sf_Form_Handle', 'init' ) );
        add_action( 'init', array( 'Sf_Ajax', 'init' ) );
        //add_action( 'init', array( $this, 'endpoint' ) );
        //add_action( 'query_vars', array( $this, 'query_vars' ) );
        add_action( 'parse_query', array( 'Sf_Shortcode', 'init' ) );

    }

    public function includes(){
        
        require_once SF_MANAGER_ABSPATH . '/includes/class-sf-ajax.php';
        require_once SF_MANAGER_ABSPATH . '/includes/class-sf-install.php';
        require_once SF_MANAGER_ABSPATH . '/includes/class-sf-post_type.php';
        require_once SF_MANAGER_ABSPATH . '/includes/class-sf-options.php';
        require_once SF_MANAGER_ABSPATH . '/includes/class-sf-form.php';
        require_once SF_MANAGER_ABSPATH . '/includes/class-sf-template.php';
        require_once SF_MANAGER_ABSPATH . '/includes/class-sf-scripts.php';
        require_once SF_MANAGER_ABSPATH . '/includes/class-sf-form-handle.php';
        require_once SF_MANAGER_ABSPATH . '/includes/class-sf-shortcode-output.php';
        require_once SF_MANAGER_ABSPATH . '/includes/class-sf-card.php';
        require_once SF_MANAGER_ABSPATH . '/includes/class-sf-user.php';
        require_once SF_MANAGER_ABSPATH . '/includes/class-sf-monitor.php';
        require_once SF_MANAGER_ABSPATH . '/includes/sf-dashboard-functions.php';
        require_once SF_MANAGER_ABSPATH . '/includes/class-sf-api.php';
        require_once SF_MANAGER_ABSPATH . '/includes/class-sf-dashboard.php';
        require_once SF_MANAGER_ABSPATH . '/includes/class-sf-shortcode.php';

        do_action( 'sf_manager_before_dashboard' );
    }

    public function endpoint(){
        add_rewrite_tag( '%sf_p%', '([^&]+)' );
        add_rewrite_tag( '%sf_u_id%', '([^&]+)' );
        add_rewrite_tag( '%sf_paged%', '([^&]+)' );
        add_rewrite_rule('^panel/([^/]*)/?$','index.php?page_id=8&sf_p=$matches[1]','top');
        add_rewrite_rule('^panel/klienci/([^/]*)/?$','index.php?page_id=8&sf_p=klienci.$matches[1]','top');
        add_rewrite_rule('^panel/klienci/lista/page/([^/]*)/?$','index.php?page_id=8&sf_p=klienci.lista&sf_paged=$matches[1]','top');
        add_rewrite_rule('^panel/klienci/lista/([^/]*)/?$','index.php?page_id=8&sf_p=klienci.person&sf_u_id=$matches[1]','top');
    }

    public function query_vars( $vars ){
        $vars[] = 'sf_p';
        $vars[] = 'sf_u_id';
        $vars[] = 'sf_paged';
        return $vars;
    }

    public function user_settings(){
        if( is_user_logged_in() ){

            $user = wp_get_current_user();
            $roles = $user->roles;
            
            if( ! empty( $roles ) && $roles[0] === 'customer' ){
                add_filter('show_admin_bar', '__return_false');
            }

        }
    }

    public function constants(){
        
        $this->define( "SF_MANAGER_VERSION", "1.0.2" );
        $this->define( "SF_MANAGER_ABSPATH", dirname( SF_MANAGER_FILE ) );
        $this->define( "SF_MANAGER_URL", plugin_dir_url( SF_MANAGER_FILE ) );

    }
    
    protected function define( $name = '', $value = '' ){
        if( ! defined( $name ) ){
            define( $name, $value );
        }
    }

    public function ajax_url(){
        return admin_url( 'admin-ajax.php', 'relative' );
    }

    public function Dashboard(){
        return Sf_Dashboard::instance();
    }

    public function Options(){
        return Sf_Options::instance();
    }

}