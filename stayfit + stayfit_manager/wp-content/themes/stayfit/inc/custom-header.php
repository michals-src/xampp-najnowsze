<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
    <?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package drape
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses drape_header_style()
 */
function drape_custom_header_setup() {
    add_theme_support( 'custom-header', apply_filters( 'drape_custom_header_args', array(
        'default-image'          => '',
        'default-text-color'     => '101020',
        'width'                  => 1920,
        'height'                 => 800,
        'flex-height'            => true,
        'wp-head-callback'       => 'drape_header_style',
    ) ) );
}
add_action( 'after_setup_theme', 'drape_custom_header_setup' );

if ( ! function_exists( 'drape_header_style' ) ) :
    /**
     * Styles the header image and text displayed on the blog.
     *
     * @see drape_custom_header_setup().
     */
    function drape_header_style() {
        $header_text_color = get_header_textcolor();


        if( ! is_user_logged_in() ){
            return;
        }

        ?><style type="text/css">
            body{
                padding-top:25px;
            }
        </style><?php

    }
    
endif;
