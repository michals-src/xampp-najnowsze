<?php

if( ! defined( "ABSPATH" ) ){
    exit;
}

Class Sf_Request{

    private static $_instance;

    public static function instance( $template_name = '' ){
        if( ! isset( self::$_instance ) ) self::$_instance = new Sf_Request;
        return self::$_instance;
    }

    public function __construct(){

        add_action( "admin_post_nopriv_submit_sf_login", array( $this, "submit" ) );

    }

    public function submit(){

        $redirect_url = ( isset( $_POST['redirect_url'] ) ) ? $_POST['redirect_url'] : false;
        $is_valid_nonce = ( isset( $_POST['sf_login-nonce_field'] ) && wp_verify_nonce( $_POST['sf_login-nonce_field'], 'sf_login_submit-nonce' ) ) ? true : false;
        
        if( ! $is_valid_nonce ){
            
            //Throw form error

            wp_redirect( $redirect_url );
            exit;

        }
    
        $login = $_POST['sf_login'];
        $is_empty = Sf_Form::is_empty( $login );
    
        print_r($is_empty);

        if( ! empty( $is_empty ) ){
            Sf_Form::CreateError( $_POST['error'], $is_empty );
        }else{

            $data = [];
            
            $data["user_name"] = $login["username"];
            $data["user_password"] = $login["password"];
            $data["remember"] = $login["rememberme"];

            $secure_cookies = is_ssl() ? true : false;

            $wp_signon = wp_signon( $data, $secure_cookies );

            if( is_wp_error( $wp_signon ) ){
                //Throw form error
            }else{
                wp_redirect( home_url() );
                exit;
            }

          //$result = wp_update_term( $_POST['item_id'], 'timetable-clock', array( "name" => $timetable_clock['clock'] ) );
        //   if( is_wp_error( $result ) ){
        //     Form::CreateError( $_POST['error'], ['clock' => $result->get_error_message() ] );
        //   }   
        }
    
        // $redirect_url = add_query_arg(array(
        //   'saved' => $_POST['item_id']
        // ), $redirect_url);
        wp_redirect( $redirect_url );
        exit;

    }
    

}