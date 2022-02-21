<?php
/**
 * demo import
 *
 * @package drape
 */

/**
 * Imports predefine demos.
 * @return [type] [description]
 */
function drape_intro_text( $default_text ) {
    $default_text .= sprintf( '<p class="about-description">%1$s <a href="%2$s">%3$s</a></p>', esc_html__( 'Demo content files for Drape Theme.', 'drape' ),
    esc_url( 'https://drive.google.com/open?id=1CQMrM5GfDHC1YO7eFCFOxDOrcgk6bCse' ), esc_html__( 'Click here to download Demo Data', 'drape' ) );

    return $default_text;
}
add_filter( 'pt-ocdi/plugin_intro_text', 'drape_intro_text' );