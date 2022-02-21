<?php 
add_action( 'wp_enqueue_scripts', 'journalist_feedly_enqueue_styles' );
function journalist_feedly_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); 
} 


function journalist_blogily_load_google_fonts() {
	wp_enqueue_style( 'journalist-blogily-google-fonts', '//fonts.googleapis.com/css?family=Lato:400,700,900' ); 
}
add_action( 'wp_enqueue_scripts', 'journalist_blogily_load_google_fonts' ); 



/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Read More' link.
 */
if ( ! function_exists( 'journalist_feedly_excerpt_more' ) && ! is_admin() ) :
function journalist_feedly_excerpt_more( $more ) {
	$link = sprintf( '<div class="readmore-wrapper"><a href="%1$s" class="more-link">%2$s</a></div>',
		esc_url( get_permalink( get_the_ID() ) ),
		__( 'Read More', 'journalist-feedly' )
		); 
	return '&hellip; ' . $link;
}
add_filter( 'excerpt_more', 'journalist_feedly_excerpt_more', 99 );
endif;


function journalist_feedly_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'sidebar', array(
		'title'      => __('Sidebar Settings','journalist-blogfeedly'),
		'priority'   => 1,
		'capability' => 'edit_theme_options',
		) );
	$wp_customize->add_setting( 'hide_sidebar', array(
		'default' => 1,
		'sanitize_callback' => 'sanitize_text_field',
		) );
	$wp_customize->add_control( 'hide_sidebar', array(
		'label'    => __( 'Hide Sidebar', 'journalist-blogfeedly' ),
		'section'  => 'sidebar',
		'priority' => 1,
		'settings' => 'hide_sidebar',
		'type'     => 'checkbox',
		) );
	$wp_customize->add_section( 'logo_tagline_remove', array(
		'title'      => __('Hide logo & Top Bar','journalist-blogfeedly'),
		'priority'   => 1,
		'capability' => 'edit_theme_options',
		) );
	$wp_customize->add_setting( 'hide_logo', array(
		'default' => 0,
		'sanitize_callback' => 'sanitize_text_field',
		) );

	$wp_customize->add_control( 'hide_logo', array(
		'label'    => __( 'Hide logo & Top Bar', 'journalist-blogfeedly' ),
		'section'  => 'logo_tagline_remove',
		'priority' => 1,
		'settings' => 'hide_logo',
		'type'     => 'checkbox',
		) );
}

add_action( 'customize_register', 'journalist_feedly_customize_register', 99 );


if(! function_exists('journalist_feedly_customizer_styling' ) ):
	function journalist_feedly_customizer_styling(){
		?>

		<style type="text/css">

			<?php if ( get_theme_mod( 'hide_sidebar' ) == '0' ) : ?>
			aside#secondary.featured-sidebar {
				display:none !important;
			}
			.main-has-sidebar {
				max-width:100%;
			}
			.site-content .inner.main-with-sidebar {
				max-width: 780px;
				display:block;
			}
		<?php endif; ?>

		<?php if ( get_theme_mod( 'hide_logo' ) == '1' ) : ?>
		header.site-header {display:none;}
	<?php endif; ?>



</style>
<?php } 
add_action( 'wp_head', 'journalist_feedly_customizer_styling' );
endif;
