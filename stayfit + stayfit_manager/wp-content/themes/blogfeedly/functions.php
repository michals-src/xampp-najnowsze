<?php

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 780;

if ( ! function_exists( 'stsblogfeedly_setup' ) ) :
/**
 * Run stsblogfeedly_setup() when the after_setup_theme hook is run.
 */
function stsblogfeedly_setup() {

	// Make theme available for translation.
	load_theme_textdomain( 'blogfeedly', get_template_directory() . '/languages' );

	// Style the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', stsblogfeedly_font_url() ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Register a menu location.
	register_nav_menu( 'primary', __( 'Navigation Menu', 'blogfeedly' ) );

	// Add support for featured images.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1560, 9999 );

	// Enable support for custom logo.
	add_theme_support( 'custom-logo', array(
		'height'      => '240',
		'width'       => '400',
		'flex-width' => true,
		'flex-height' => true,
		) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption'
		) );

}
endif;
add_action( 'after_setup_theme', 'stsblogfeedly_setup' );

/**
 * Register four widget areas in the footer.
 */
function stsblogfeedly_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Footer Widget Area 1', 'blogfeedly' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears in the footer section of the site', 'blogfeedly' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
		) );
	register_sidebar( array(
		'name' => __( 'Footer Widget Area 2', 'blogfeedly' ),
		'id' => 'sidebar-2',
		'description' => __( 'Appears in the footer section of the site', 'blogfeedly' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
		) );
	register_sidebar( array(
		'name' => __( 'Footer Widget Area 3', 'blogfeedly' ),
		'id' => 'sidebar-3',
		'description' => __( 'Appears in the footer section of the site', 'blogfeedly' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
		) );
	register_sidebar( array(
		'name' => __( 'Footer Widget Area 4', 'blogfeedly' ),
		'id' => 'sidebar-4',
		'description' => __( 'Appears in the footer section of the site', 'blogfeedly' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
		) );

	register_sidebar( array(
		'name' => __( 'Sidebar Widget Area', 'blogfeedly' ),
		'id' => 'right-sidebar-1',
		'description' => __( 'Appears in the sidebar section of the site', 'blogfeedly' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
		) ); 
	
}
add_action( 'widgets_init', 'stsblogfeedly_widgets_init' );

/**
 * Register Karla Google font.
 */
function stsblogfeedly_font_url() {
	$font_url = add_query_arg( 'family', urlencode( 'Karla:400,400i,700,700i' ), "https://fonts.googleapis.com/css" );
	return $font_url;
}

/**
 * Handle JavaScript detection.
 */
function stsblogfeedly_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'stsblogfeedly_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 */
function stsblogfeedly_scripts_styles() {

	// Add Karla font, used in the main stylesheet.
	wp_enqueue_style( 'stsblogfeedly-fonts', stsblogfeedly_font_url(), array(), null );

	// Load the main stylesheet.
	wp_enqueue_style( 'stsblogfeedly-style', get_stylesheet_uri() );

	// Load the IE specific stylesheet.
	wp_enqueue_style( 'stsblogfeedly-ie', get_template_directory_uri() . '/css/ie.css', array( 'stsblogfeedly-style' ), '1.6.0' );
	wp_style_add_data( 'stsblogfeedly-ie', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'stsblogfeedly-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'stsblogfeedly-html5', 'conditional', 'lt IE 9' );

	// Add JS to pages with the comment form to support sites with threaded comments (when in use).
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Add custom scripts.
	wp_enqueue_script( 'stsblogfeedly-script', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '1.6.0', true );
}
add_action( 'wp_enqueue_scripts', 'stsblogfeedly_scripts_styles' );

/**
 * Change wp_nav_menu() fallback, wp_page_menu(), container class and depth.
 */
function stsblogfeedly_page_menu_args( $args ) {
	$args['depth'] = 1;
	$args['menu_class'] = 'menu-wrap';
	return $args;
}
add_filter( 'wp_page_menu_args', 'stsblogfeedly_page_menu_args' );

/**
 * Add custom classes to the array of body classes.
 */
function stsblogfeedly_body_class( $classes ) {
	// Check if it is a single author blog.
	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	// Check if animated navigation option is checked.
	if ( stsblogfeedly_get_option( 'animated_nav' ) )
		$classes[] = 'animated-navigation';

	// Add a class of no-avatars if avatars are disabled.
	if ( ! get_option( 'show_avatars' ) ) {
		$classes[] = 'no-avatars';
	}

	// Add a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'stsblogfeedly_body_class' );

/**
 * Customize the archive title.
 */
function stsblogfeedly_archive_title( $title ) {
	if ( is_category() ) {
		$title = sprintf( __( 'All posts in %s', 'blogfeedly' ), '<span class="highlight">' . single_cat_title( '', false ) . '</span>' );
	} elseif ( is_tag() ) {
		$title = sprintf( __( 'All posts tagged %s', 'blogfeedly' ), '<span class="highlight">' . single_tag_title( '', false ) . '</span>' );
	} elseif ( is_author() ) {
		$title = sprintf( __( 'All posts by %s', 'blogfeedly' ), '<span class="vcard highlight">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( __( 'All posts in %s', 'blogfeedly' ), '<span class="highlight">' . get_the_date( _x( 'Y', 'yearly archives date format', 'blogfeedly' ) ) . '</span>' );
	} elseif ( is_month() ) {
		$title = sprintf( __( 'All posts in %s', 'blogfeedly' ), '<span class="highlight">' . get_the_date( _x( 'F Y', 'monthly archives date format', 'blogfeedly' ) ) . '</span>' );
	} elseif ( is_day() ) {
		$title = sprintf( __( 'All posts dated %s', 'blogfeedly' ), '<span class="highlight">' . get_the_date( _x( 'F j, Y', 'daily archives date format', 'blogfeedly' ) ) . '</span>' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'stsblogfeedly_archive_title' );

/**
 * Customize tag cloud widget.
 */
function stsblogfeedly_custom_tag_cloud_widget( $args ) {
	$args['number'] = 0;
	$args['largest'] = 14;
	$args['smallest'] = 14;
	$args['unit'] = 'px';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'stsblogfeedly_custom_tag_cloud_widget' );

if ( ! function_exists( 'stsblogfeedly_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Read More' link.
 */
function stsblogfeedly_excerpt_more( $more ) {
	$link = sprintf( '<div class="readmore-wrapper"><a href="%1$s" class="more-link">%2$s</a></div>',
		esc_url( get_permalink( get_the_ID() ) ),
		__( 'Read ', 'blogfeedly' )
		); 
	return '&hellip; ' . $link;
}
add_filter( 'excerpt_more', 'stsblogfeedly_excerpt_more' );
endif;

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/template-tags.php';

/**
 * Theme options.
 */
require get_template_directory() . '/includes/theme-options.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/customizer.php';

/**
 * Gutenberg additions.
 */
require get_template_directory() . '/includes/gutenberg.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/includes/jetpack.php';




/**
 * Copyright and License for Upsell button by Justin Tadlock - 2016 © Justin Tadlock. customizer button https://github.com/justintadlock/trt-customizer-pro
 */
require_once( trailingslashit( get_template_directory() ) . 'justinadlock-customizer-button/class-customize.php' );



/**
 * Compare page CSS
 */

function blogfeedly_comparepage_css($hook) {
	if ( 'appearance_page_blogfeedly-info' != $hook ) {
		return;
	}
	wp_enqueue_style( 'blogfeedly-custom-style', get_template_directory_uri() . '/css/compare.css' );
}
add_action( 'admin_enqueue_scripts', 'blogfeedly_comparepage_css' );

/**
 * Compare page content
 */

add_action('admin_menu', 'blogfeedly_themepage');
function blogfeedly_themepage(){
	$theme_info = add_theme_page( __('Blog Feedly Info','blogfeedly'), __('Blog Feedly Info','blogfeedly'), 'manage_options', 'blogfeedly-info.php', 'blogfeedly_info_page' );
}

function blogfeedly_info_page() {
	$user = wp_get_current_user();
	?>
	<div class="wrap about-wrap blogfeedly-add-css">
		<div>
			<h1>
				<?php echo __('Welcome to Blog Feedly!','blogfeedly'); ?>
			</h1>

			<div class="feature-section three-col">
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php echo __("Contact Support", "blogfeedly"); ?></h3>
						<p><?php echo __("Getting started with a new theme can be difficult, if you have issues with Blog Feedly then throw us an email.", "blogfeedly"); ?></p>
						<p><a target="blank" href="<?php echo esc_url('https://superbthemes.com/help-contact/', 'blogfeedly'); ?>" class="button button-primary">
							<?php echo __("Contact Support", "blogfeedly"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php echo __("Review Blog Feedly", "blogfeedly"); ?></h3>
						<p><?php echo __("Nothing motivates us more than feedback, are you are enjoying Blog Feedly? We would love to hear what you think.", "blogfeedly"); ?></p>
						<p><a target="blank" href="<?php echo esc_url('https://wordpress.org/support/theme/blogfeedly/reviews/?filter=5', 'blogfeedly'); ?>" class="button button-primary">
							<?php echo __("Submit A Review", "blogfeedly"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php echo __("Premium Edition", "blogfeedly"); ?></h3>
						<p><?php echo __("If you enjoy Blog Feedly and want to take your website to the next step, then check out our premium edition here.", "blogfeedly"); ?></p>
						<p><a target="blank" href="<?php echo esc_url('https://superbthemes.com/blogfeedly/', 'blogfeedly'); ?>" class="button button-primary">
							<?php echo __("Read More", "blogfeedly"); ?>
						</a></p>
					</div>
				</div>
			</div>
		</div>
		<hr>

		<h2><?php echo __("Free Vs Premium","blogfeedly"); ?></h2>
		<div class="blogfeedly-button-container">
			<a target="blank" href="<?php echo esc_url('https://superbthemes.com/blogfeedly/', 'blogfeedly'); ?>" class="button button-primary">
				<?php echo __("Read Full Description", "blogfeedly"); ?>
			</a>
			<a target="blank" href="<?php echo esc_url('https://superbthemes.com/demo/blogfeedly/', 'blogfeedly'); ?>" class="button button-primary">
				<?php echo __("View Theme Demo", "blogfeedly"); ?>
			</a>
		</div>


		<table class="wp-list-table widefat">
			<thead>
				<tr>
					<th><strong><?php echo __("Theme Feature", "blogfeedly"); ?></strong></th>
					<th><strong><?php echo __("Basic Version", "blogfeedly"); ?></strong></th>
					<th><strong><?php echo __("Premium Version", "blogfeedly"); ?></strong></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><?php echo __("Custom Navigation Logo Or Text", "blogfeedly"); ?></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Custom Footer Colors", "blogfeedly"); ?></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Footer & Sidebar Widgets", "blogfeedly"); ?></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Social Media Icons", "blogfeedly"); ?></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>

				<tr>
					<td><?php echo __("Premium Support", "blogfeedly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Recent Posts Widget", "blogfeedly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Reveal Buttons", "blogfeedly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Easy Google Fonts", "blogfeedly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Optimal Pagespeed", "blogfeedly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Optimal SEO", "blogfeedly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Custom Footer Copyright Text	", "blogfeedly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("HD Logo	", "blogfeedly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Custom Header Colors", "blogfeedly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Custom Post & Page Colors", "blogfeedly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Custom Sidebar Colors", "blogfeedly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Custom Footer Colors", "blogfeedly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Hide/Show Tagline", "blogfeedly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Hide/Show Title", "blogfeedly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
				<tr>
					<td><?php echo __("Retina Logo", "blogfeedly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "blogfeedly"); ?>" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "blogfeedly"); ?>" /></span></td>
				</tr>
			</tbody>
		</table>

	</div>
	<?php
}



