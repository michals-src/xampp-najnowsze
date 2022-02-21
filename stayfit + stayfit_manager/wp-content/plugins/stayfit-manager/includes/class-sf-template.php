<?php

if( ! defined( "ABSPATH" ) ){
    exit;
}

Class Sf_Template{

    private static $_instance;

    private $template_prefix;

    private $template_dir;

    private $template;

    private $matches;

    private $error;

    public function __construct( $template_name = '' ){

        $this->template_prefix = 'template-sf';
        $this->template_dir = SF_MANAGER_ABSPATH . '/templates';
        $this->template = '';
        $this->matches = [];

        $template_path = explode( '/', $template_name );
        $template_name = end($template_path);
        
        unset( $template_path[ count($template_path) - 1 ] );
        $template_path = array_values( $template_path );

        if( count( $template_path ) > 0 ){
            $this->template_dir = $this->template_dir . '/' . join( '/', $template_path);
        }

        $file_directory = $this->template_dir . '/' . $this->template_prefix . '-' . $template_name . '.php';
        
        /** 
         * Features
         * 
         * Dodanie komunikatu o braku pliku wzrocowego
         */
        if( ! file_exists( $file_directory ) ){         
            //return 'Brak pliku';
            $error = true;
        }

        $this->template = $file_directory;   

        // if( ! empty( $this->template ) ){
        //     $this->matching();
        // }

    }

    public function get( $params = array() ){

        if( ! empty( $params ) && is_array( $params ) ){
            extract( $params );
        }

        if( ! empty( $error ) ){
            return;
        }

        require_once $this->template;
    }

    // public function response( $class, $method ){
    //     return call_user_func_array( array( $class, $method ), array());
    // }

    // public function with( $match_name = '', $callback = [] ){

    //     if( in_array( $match_name, $this->matches ) ){   
    //         $this->template = str_replace( '{'.$match_name.'}', $this->response($callback[0], $callback[1]), $this->template );
    //     }

    // }

    // private function matching(){

    //     preg_match_all( "/{([a-zA-Z0-9\.\-_]+)}/i", $this->template, $matches );
    //     if( ! empty($matches[1] ) ){
    //         $this->matches = $matches[1];
    //     }

    // }
    

}