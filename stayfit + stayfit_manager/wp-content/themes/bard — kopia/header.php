<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<!-- Preloader -->
	<?php get_template_part( 'templates/header/preloader' ); ?>

	<!-- Page Wrapper -->
	<div id="page-wrap">

		<!-- Boxed Wrapper -->
		<div id="page-header" <?php echo esc_attr(bard_options( 'general_header_width' )) === 'boxed' ? 'class="boxed-wrapper"': ''; ?>>

		<?php

		// Top Bar
		get_template_part( 'templates/header/top', 'bar' );

		// Main Navigation
		get_template_part( 'templates/header/main', 'navigation' );

		if( is_home() || is_front_page() ):
		// Main Navigation
		get_template_part( 'templates/header/start', 'heading' );		

		endif;
		// Page Header
		get_template_part( 'templates/header/page', 'header' );

		
		?>

		</div><!-- .boxed-wrapper -->

		<!-- Page Content -->
		<div class="page-content">
			
			<?php get_template_part( 'templates/sidebars/sidebar', 'alt' ); // Sidebar Alt ?>