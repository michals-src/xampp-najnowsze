<?php


if( ! defined( "ABSPATH" ) ){
    exit;
}

Class Sf_Install{

    private static $wp_option_name;

    private static $images_path;

    public static function init(){

		self::$wp_option_name = "stayfit_theme";
		self::$images_path = SF_MANAGER_URL . '/assets/images/';

		$options = array();
		$options["banner"] = array();
			$options["banner"]["before_title"] = "Klub fitness";
			$options["banner"]["title"] = ( ! empty( get_bloginfo( "name" ) ) ) ? get_bloginfo( "name" ) : "Stay Fit";
			$options["banner"]["label"] = ( ! empty( get_bloginfo( "description" ) ) ) ? get_bloginfo( "description" ) : "Profesjonalni instruktorzy, kamerlane grupy fitness, miła atmosfera";
			$options["banner"]["background"] = array(
				"image"	=> self::$images_path . "site-banner-bg-1800-700.jpg",
				"ID"	=> false
			);
			$options["banner"]["images"] = array(
				"site-banner-image-lg"	=> array(
					"image"	=> self::$images_path . "site-header-image-568-760.png",
					"ID"	=> false
				),
				"site-banner-image-md"	=> array(
					"image"	=> self::$images_path . "site-header-image-450-662.png",
					"ID"	=> false
				),
				"site-banner-image-sm"	=> array(
					"image"	=> self::$images_path . "site-header-image-356-487.png",
					"ID"	=> false
				),
			);

		$options["socials"] = array();
			$options["socials"]["fb"] = array(
				"url"	=> "https://www.facebook.com/stayfit.bialystok/",
				"image"	=> "http://www.myiconfinder.com/uploads/iconsets/256-256-671dcbd218ad978e77115f7e3475e454-facebook.png",
				"ID"	=> false
			);

		$options["site"] = array();
			$options["site"]["logo"] = array();
				$options["site"]["logo"]["image"] = "https://www.freeiconspng.com/uploads/courses-icon-10.png";
				$options["site"]["logo"]["width"] = 35;
				$options["site"]["logo"]["height"] = 35;
				$options["site"]["logo"]["ID"] = false;

			$options["site"]["description"] = "Klub prowadzi szereg zajęć fitness poprawiające wygląd sylwetki, wzmocnienia mięśni, zmniejszenia obwodu ud, ujędrnienia ciała, pozbycia się cellulitu czy poprawy kondycji. Nasz klub wyróżnia się mniejszymi grupami dzięki czemu instruktor może poświecić więcej czasu dla osoby ćwiczącej. Doświadczeni instruktorzy pomogą dla Twojego ciała i zdrowia nabrać swietnej kondycji oraz wspaniałego wyglądu.";
			$options["site"]["map"] = "";
			$options["site"]["location"] = array();
				$options["site"]["location"]["street"] = "Przytulna 1";
				$options["site"]["location"]["place_no"] = "4";
				$options["site"]["location"]["postal_code"] = "15-001";
				$options["site"]["location"]["city"] = "Białystok";
			$options["site"]["contact"] = array();
				$options["site"]["contact"]["dialling_code"] = "510 231 237";
				$options["site"]["contact"]["phone_number"] = "510 231 237";
				$options["site"]["contact"]["email"] = "stayfit.bialystok@wp.pl";

			if( get_site_option( self::$wp_option_name ) === false ){
				add_site_option( self::$wp_option_name, $options );
			}

		add_action( 'sf_manager_before_dashboard', array( __CLASS__, 'install_dashboard' ) );

	}

	public static function install_dashboard(){
		self::install_roles();
		self::install_dashboard_timetable();
		self::install_monitor_stats();
	}

	public static function install_roles(){
		add_role( 'customer', 'Klient', array( 
			'read' => true
			) 
		);
	}
	
	private static function install_dashboard_timetable(){
		
		$args = array(
			'post_type'        => 'timetable',
			'post_status'      => 'publish',
		  );

		$posts_array = get_posts( $args );
	  
		if( empty( $posts_array ) ){
			wp_insert_post(array(
				'post_title' => 'Timetable',
				'post_content' => 'Wpis zawierający dane grafiku',
				'post_type' => 'timetable',
				'post_status' => 'publish'
			));
		}

		if( ! empty( $posts_array ) && ! get_post_meta( $posts_array[0]->ID, 'sf_manager_timetable_scheme' ) ){
			add_post_meta( $posts_array[0]->ID, Sf_Dashboard::get_timetable_scheme_name(), Sf_Dashboard::get_timetable_default_scheme() );
		}

	}	

	private static function install_monitor_stats(){
		
		$args = array(
			'post_type'        => 'monitor_stats',
			'post_status'      => 'publish',
		  );

		$posts_array = get_posts( $args );
	  
		if( empty( $posts_array ) ){
			wp_insert_post(array(
				'post_title' => 'Statystyki monitor',
				'post_content' => 'Wpis zawierający dane aktywności klientów',
				'post_type' => 'monitor_stats',
				'post_status' => 'publish'
			));
		}

		if( ! empty( $posts_array ) && ! get_post_meta( $posts_array[0]->ID, 'sf_manager_monitor_stats' ) ){
			add_post_meta( $posts_array[0]->ID, "sf_manager_monitor_stats", array());
		}

	}

}

Sf_Install::init();