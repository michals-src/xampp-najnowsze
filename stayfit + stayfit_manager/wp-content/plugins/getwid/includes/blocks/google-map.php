<?php

namespace Getwid\Blocks;

class GoogleMap extends \Getwid\Blocks\AbstractBlock {

	protected static $blockName = 'getwid/map';

    public function __construct() {

        parent::__construct( self::$blockName );

        register_block_type(
            self::$blockName,
            array(
                'render_callback' => [ $this, 'render_callback' ]
            )
        );

		add_action( 'wp_ajax_get_google_api_key', [ $this, 'get_google_api_key'] );

		if ( $this->isEnabled() ) {

			add_filter( 'getwid/editor_blocks_js/dependencies', [ $this, 'block_editor_scripts'] );

			wp_register_script(
				'unescape',
				getwid_get_plugin_url( 'vendors/lodash.unescape/unescape.min.js' ),
				[],
				'4.0.1',
				true
			);

			wp_register_script(
				'getwid-map-styles',
				getwid_get_plugin_url( 'vendors/getwid/map-styles.min.js' ),
				[],
				'1.0.0',
				true
			);
		}
    }

	public function getLabel() {
		return __('Google Maps', 'getwid');
	}

    public function block_editor_scripts($scripts) {

		//map-styles.min.js
        if ( ! in_array( 'getwid-map-styles', $scripts ) ) {
            array_push( $scripts, 'getwid-map-styles' );
        }

        return $scripts;
	}

    public function get_google_api_key() {
        $action = $_POST['option'];
        $data = $_POST['data'];
        $nonce = $_POST['nonce'];

        if ( ! wp_verify_nonce( $nonce, 'getwid_nonce_google_api_key' ) ) {
            wp_send_json_error();
        }

        $response = false;
        if ($action == 'get') {
            $response = get_option( 'getwid_google_api_key', '');
        } elseif ($action == 'set') {
            $response = update_option( 'getwid_google_api_key', $data );
        } elseif ($action == 'delete') {
            $response = delete_option( 'getwid_google_api_key' );
        }

        wp_send_json_success( $response );
    }

    private function block_frontend_assets( $attributes = [], $content = '' ) {

        if ( is_admin() ) {
            return;
        }

		/**
		 * data-map-style="custom"
		 * data-map-style="default"
		 * data-map-style="ultra_light"
		 */
		$has_custom_style = (
			false === strpos( $content, 'data-map-style="default"' ) &&
			false === strpos( $content, 'data-map-style="custom"' )
		);
		//map-styles.js
        if ( $has_custom_style && ! wp_script_is( 'getwid-map-styles', 'enqueued' ) ) {
            wp_enqueue_script( 'getwid-map-styles' );
        }

        $api_key = get_option( 'getwid_google_api_key', '' );

        if ( $api_key ) {
            wp_enqueue_script( 'google_api_key_js', "https://maps.googleapis.com/maps/api/js?key={$api_key}" );
		}

		//unescape.min.js
		if ( ! wp_script_is( 'unescape', 'enqueued' ) ) {
			wp_enqueue_script( 'unescape' );
		}
    }

    public function render_callback( $attributes, $content ) {

        $this->block_frontend_assets( $attributes, $content );

        return $content;
    }
}

\Getwid\BlocksManager::getInstance()->addBlock(
	new \Getwid\Blocks\GoogleMap()
);
