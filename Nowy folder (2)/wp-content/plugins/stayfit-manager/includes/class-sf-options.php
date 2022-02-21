<?php

if( ! defined( "ABSPATH" ) ){
    return;
}

Class Sf_Options{

    protected static $wp_option_name;

		protected static $images_path;
		
		public static $_instance;

    public function instance(){

        if( ! isset( $_instance ) ) self::$_instance = new Sf_Options;
        return self::$_instance;

    }

    public function __construct(){

			$this->wp_option_name = "stayfit_theme";
      $this->$images_path = SF_MANAGER_ABSPATH . 'obrazki/';
        
    }

	public function Update( $options = array() ){
		
		if( empty( $options ) || ! is_array( $options) ){ return ''; }

		update_site_option( $this->wp_option_name, $options );

		return $options;

	}

	public function Receive(){

		$options = get_site_option( $this->wp_option_name );

		if( empty( $options ) || 
			! is_array( $options ) ){
			return [];
		}

		return $options;
	}

	public function get( $option_path = "" ){

		$options = get_site_option( $this->wp_option_name );

		if( empty( $option_path ) || 
			! is_string( $option_path ) ){
			return '';
		}

		$full_path = explode( "/", $option_path );
		$first_level = array_key_exists( $full_path[0] , $options ) ? $options[$full_path[0]] : '';
		
		$path = array_slice( $full_path, 1 );

		$current_level = $first_level;

		if( ! empty( $current_level ) ){
			for( $x = 0; $x < count( $path ); $x++ ){
				$current_level = $current_level[ $path[$x] ];
			}
		}

		return $current_level;
	}

	public function getImage( $option_path = '' ){

		if( empty( $option_path ) || 
		  ! is_string( $option_path ) ){
			return '';
		}

		$option = ( ! empty( $this->get( $option_path ) ) ) ? $this->get( $option_path ) : '';
		$image = ( ! empty( $option["image"] ) ) ? $option["image"] : '';

		if( ! empty( $option["ID"] ) && is_numeric( $option["ID"] ) ){
			$image = wp_get_attachment_image_src( $option["ID"], "medium" );
		}

		return $image;

	}

}