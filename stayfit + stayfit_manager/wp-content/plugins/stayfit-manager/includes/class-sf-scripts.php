<?php

Class Sf_Scripts{

	    protected static $wp_option_name;

		protected static $images_path;
			
		protected static $scripts;

    	public static function init(){


			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_scripts') );
			add_action( 'wp_head',  array( __CLASS__, 'load_head_scripts' ));
        
		}

		private function get_assets_url( $path ){
			return plugins_url( $path, SF_MANAGER_FILE );
		}

		private function enqueue_style(){
			
		}

		private static function register_script( $handle, $path, $deps = array(), $version = "1.0.1", $in_footer = true ){
			self::$scripts[] = $handle;
			wp_register_script( $handle, $path, $deps, $version, $in_footer );
		}

		private function enqueue_script( $handle ){
			wp_enqueue_script( $handle );
		}

		private function register_scripts(){
			
			$sf_scripts = array(
				"jquery" => array(
					"src" => "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js",
					"deps" => array(),
					"version" => "3.4.1"
				),		
				"ionicons" => array(
					"src" => "https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js",
					"deps" => array(),
					"version" => "4.5.10"
				),				
				"timetable" => array(
					"src" => self::get_assets_url( 'assets/js/dashboard/script-sf-timetable.js' ),
					"deps" => array(),
					"version" => "1.0.2"
				),
				// "adapter" => array(
				// 	"src" => "//webrtc.github.io/adapter/adapter-latest.js",
				// 	"deps" => array(),
				// 	"version" => "1.0.1"
				// ),
				// "quagga" => array(
				// 	"src" => self::get_assets_url( 'assets/js/quagga.min.js' ),
				// 	"deps" => array(),
				// 	"version" => "1.0.1"
				// ),				
				"scanner" => array(
					"src" => self::get_assets_url( 'assets/js/dashboard/scanner.js' ),
					"deps" => array("jquery"),
					"version" => "1.0.2"
				),
			);

			foreach( $sf_scripts as $script => $values ){
				self::register_script( $script, $values["src"], $values["deps"], $values["version"] );
			}

		}

		public static function load_scripts(){
			
			//global $wp;

			self::register_scripts();
			//wp_enqueue_script( "jquery-3", "//webrtc.github.io/adapter/adapter-latest.js", array(), false, false );
			self::enqueue_script( "ionicons" );


			wp_enqueue_style( "bootstrap-cdn-", "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css", array(), '4.3' );
			//wp_enqueue_script( "jquery", "https://code.jquery.com/jquery-3.3.1.min.js", array(), "3.3.1", true );
			//wp_enqueue_script( "script", STAYFIT_THEME_ASSETS_URL . "js/script.js", array(), false, true );


			if( is_dashboard() ){
				
				self::localize_script( "timetable", "sf_manager_endpoint", array(
					"ajax_url" => sfm()->ajax_url(),
					"sf_ajax_url" => remove_query_arg( array( 'remove_item', 'add-to-cart', 'added-to-cart', 'order_again', '_wpnonce' ), home_url( '/', 'relative' ) )
				));

				self::enqueue_script( "timetable" );

				$dashboard = sfm()->Dashboard();

				if( $dashboard->subpage === "scanner" ){
					self::enqueue_script( "adapter" );
					self::enqueue_script( "quagga" );
					self::enqueue_script( "scanner" );
				}


			}

			/**
			 * if( is_dashboard_general() ){
			 * 	// Scripts only for endpoint general in dashboard
			 * }
			 * 
			 * ETC.
			 */

		}

		public static function load_head_scripts(){
			$custom_css = '<style type="text/css">
			.sf-dashboard-settings-item-active{
				background: #f7fafd;
			}</style>';

			if( is_dashboard() ){
				echo $custom_css;
			}
		}

		private static function localize_script( $handle, $object, $data = array() ){
			wp_localize_script( $handle, $object, $data );
		}

}

Sf_Scripts::init();