<?php
/**
 * Plugin Name: Stay Fit Gutenberg
 * Version: 1.0.0
 * Description: Bloki dla eydtora Gutenberg oparte o framework css Bootstrap
 * Author: Michał Sierzputowski
 * 
 * @package stayfit-gutenberg
 * 
*/
define( 'WP_DEBUG', true );
if( ! defined("ABSPATH") ){
    exit;
}

function gutenberg_examples_04_register_block() {

	if ( ! function_exists( 'register_block_type' ) ) {
		// Gutenberg is not active.
		return;
	}

	wp_register_script(
		'gutenberg-examples-04',
		plugins_url( 'block.js', __FILE__ ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'block.js' )
	);

	wp_register_style(
		'gutenberg-examples-04-editor',
		plugins_url( 'editor.css', __FILE__ ),
		array( 'wp-edit-blocks' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' )
	);

	wp_register_style(
		'gutenberg-examples-04',
		plugins_url( 'style.css', __FILE__ ),
		array( ),
		filemtime( plugin_dir_path( __FILE__ ) . 'style.css' )
	);

	register_block_type( 'gutenberg-examples/example-04-controls', array(
		'style' => 'gutenberg-examples-04',
		'editor_style' => 'gutenberg-examples-04-editor',
		'editor_script' => 'gutenberg-examples-04',
	) );


}
add_action( 'init', 'gutenberg_examples_04_register_block' );