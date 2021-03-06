<?php
/**
 * Blover functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package blover
 */

if ( ! function_exists( 'blover_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function blover_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on blover, use a find and replace
		 * to change 'blover' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'blover', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in three location.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Left Menu', 'blover' ),
				'top' => esc_html__( 'Top Menu', 'blover' ),
				'social' => esc_html__( 'Social Menu', 'blover' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support(
			'post-formats',
			array(
				'audio',
				'video',
				'gallery',
			)
		);

		// Enable support for Custom Header.
		add_theme_support(
			'custom-header',
			array(
				'default-text-color' => '#000',
			)
		);

		// Enable support for Site Logo.
		add_theme_support( 'custom-logo' );

		// Enable support for WooCommerce Shopping Cart.
		add_theme_support( 'woocommerce' );
	}

endif; // End of blover_setup.
add_action( 'after_setup_theme', 'blover_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function blover_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'blover_content_width', 738 ); // WPCS: prefix ok.
}

add_action( 'after_setup_theme', 'blover_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function blover_widgets_init() {
	register_sidebar(
		array(
			'name' => esc_html__( 'Right Sidebar', 'blover' ),
			'id' => 'sidebar-1',
			'description' => esc_html__( 'Right Sidebar Widget Area', 'blover' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title"><span>',
			'after_title' => '</span></h2>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__( 'Left Menu (Mobile)', 'blover' ),
			'id' => 'sidebar-2',
			'description' => esc_html__( 'Mobile Menu Widget Area', 'blover' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title"><span>',
			'after_title' => '</span></h2>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__( 'Top', 'blover' ),
			'id' => 'top-1',
			'description' => esc_html__( 'Top Widget Area. Above the content - on home and archive pages', 'blover' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title"><span>',
			'after_title' => '</span></h2>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__( 'Bottom', 'blover' ),
			'id' => 'bottom-1',
			'description' => esc_html__( 'Bottom Widget Area.', 'blover' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title"><span>',
			'after_title' => '</span></h2>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__( 'Footer', 'blover' ),
			'id' => 'footer-1',
			'description' => esc_html__( 'Footer Widget Area.', 'blover' ),
			'before_widget' => '<aside id="%1$s" class="col-xs-12 col-md-6 col-lg-3 widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title"><span>',
			'after_title' => '</span></h2>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__( 'Shop Sidebar', 'blover' ),
			'id' => 'shop-sidebar-1',
			'description' => esc_html__( 'Shop Sidebar Widget Area.', 'blover' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title"><span>',
			'after_title' => '</span></h2>',
		)
	);
}

add_action( 'widgets_init', 'blover_widgets_init' );

if ( ! function_exists( 'blover_fonts_url' ) ) :

	/**
	 * Register Google fonts for Twenty Fifteen.
	 *
	 * @since Twenty Fifteen 1.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function blover_fonts_url() {

		if ( ! get_theme_mod( 'load_google_fonts_from_google', 1 ) ) {
			return get_template_directory_uri() . '/fonts/fonts.css';
		}

		$fonts_url = '';
		$fonts = array();
		$subsets = 'latin';

		/*
		 * Translators: If there are characters in your language that are not supported
		 * by Amiri, translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Amiri font: on or off', 'blover' ) ) {
			$fonts[] = 'Amiri:700,400,400italic';
		}

		/*
		 * Translators: If there are characters in your language that are not supported
		 * by Work Sans, translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Work Sans font: on or off', 'blover' ) ) {
			$fonts[] = 'Work Sans:400';
		}

		/*
		 * Translators: To add an additional character subset specific to your language,
		 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'blover' );

		if ( 'cyrillic' === $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		} elseif ( 'greek' === $subset ) {
			$subsets .= ',greek,greek-ext';
		} elseif ( 'devanagari' === $subset ) {
			$subsets .= ',devanagari';
		} elseif ( 'vietnamese' === $subset ) {
			$subsets .= ',vietnamese';
		}

		if ( $fonts ) {
			$fonts_url = esc_url(
				add_query_arg(
					array(
						'family' => urlencode( implode( '|', $fonts ) ),
						'subset' => urlencode( $subsets ),
					),
					'https://fonts.googleapis.com/css'
				)
			);
		}

		return $fonts_url;
	}

endif;

/**
 * Enqueue scripts and styles.
 */
function blover_scripts() {

	$blover_theme_info = wp_get_theme();
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'blover-fonts', blover_fonts_url(), array(), $blover_theme_info->get( 'Version' ) );

	wp_enqueue_style( 'blover-style', get_stylesheet_uri(), array(), $blover_theme_info->get( 'Version' ) );

	wp_enqueue_script( 'slick', get_template_directory_uri() . '/slick/slick.min.js', array( 'jquery' ), '20150828', true );

	if ( ! is_singular() && ! is_404() && have_posts() ) {
		wp_enqueue_script( 'jquery-infinite-scroll', get_template_directory_uri() . '/js/jquery.infinitescroll.min.js', array( 'jquery', 'masonry' ), '2.1.0', true );
	}

	if ( get_theme_mod( 'sticky_sidebar', 1 ) && is_active_sidebar( 'sidebar-1' ) ) {
		wp_enqueue_script( 'theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.min.js', array( 'jquery' ), '1.2.2', true );
	}

	wp_enqueue_script( 'blover-scripts', get_template_directory_uri() . '/js/blover.min.js', array( 'jquery', 'jquery-effects-core', 'jquery-effects-slide' ), $blover_theme_info->get( 'Version' ), true );

	wp_enqueue_script( 'blover-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.min.js', array(), '20130115', true );

	// Preparing to pass variables to js -> load more posts via ajax call.
	global $wp_query;
	$blover_ajax_max_pages = $wp_query->max_num_pages;
	$blover_ajax_paged = ( get_query_var( 'paged' ) > 1 ) ? get_query_var( 'paged' ) : 1;
	$blover_pagination = get_theme_mod( 'pagination', 'infinite' );
	$blover_home_page_slider_play_speed = get_theme_mod( 'home_page_slider_play_speed', 4000 );
	$blover_home_page_slider_autoplay = ( 0 == $blover_home_page_slider_play_speed ) ? false : true;

	// Passing theme options to blover.js.
	wp_localize_script(
		'blover-scripts',
		'blover',
		array(
			'home_page_slider_img_number' => get_theme_mod( 'home_page_slider_img_number', 2 ),
			'home_page_slider_play_speed' => $blover_home_page_slider_play_speed,
			'home_page_slider_autoplay' => $blover_home_page_slider_autoplay,
			'loadMoreText' => esc_html__( 'Load more posts', 'blover' ),
			'loadingText' => '',
			'noMorePostsText' => esc_html__( 'No More Posts', 'blover' ),
			'expandText' => esc_html__( 'Expand', 'blover' ),
			'closeText' => esc_html__( 'Close', 'blover' ),
			'LoginButtonText' => esc_html__( 'Login', 'blover' ),
			'RegisterButtonText' => esc_html__( 'Create An Account', 'blover' ),
			'startPage' => $blover_ajax_paged,
			'maxPages' => $blover_ajax_max_pages,
			'nextLink' => next_posts( $blover_ajax_max_pages, false ),
			'pagination' => $blover_pagination,
			'getTemplateDirectoryUri' => esc_url( get_template_directory_uri() ),
			'months' => blover_months(),
			'days' => blover_days(),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'blover_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Hybrid Media Grabber for getting media from posts.
 */
require get_template_directory() . '/inc/class-media-grabber.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Some meta fields for category styling.
 */
require get_template_directory() . '/inc/class-blover-meta-for-categories.php';

/**
 * Load TGMPA recommended plugins.
 */
require_once get_template_directory() . '/inc/tgmpa-plugins.php';

/**
 * AMP.
 */
require_once get_template_directory() . '/inc/amp.php';
