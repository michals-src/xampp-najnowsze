<?php get_header(); ?>
<div class="prez _vf-kontakt" style="height: auto !important;">
	<header class="header-normal" role="main">
			<picture class="logo logo-normal">
				<img src="<?php echo get_template_directory_uri(); ?>/images/logo-normal.png" alt="StayFit Białystok">
			</picture>
			<nav class="menu">
				<div class="_ic-nav">
					<div class="_no">
						<div class="glyphicon glyphicon-menu-hamburger"></div>
					</div>
					<div class="_nc">
						<div class="glyphicon glyphicon-remove _ic"></div>
					</div>
				</div>
				<?php 
					wp_nav_menu(array(
						'theme_location' => 'primary',
						'menu_class' => 'nav header-nav'
					));
				?>
			</nav>
	</header>
</div>
<div class="_pvf-kontakt">
<div class="_i01-01">
	<div class="container site-wrapper">
		<div class="site-wrapper-inner">

	<!-- Main Container -->
	<div class="main-container">
		
		<article id="page-<?php the_ID(); ?>" <?php post_class(); ?> style="margin-top: 40px;margin-bottom: 0;">

			<?php

			if ( have_posts() ) :

			// Loop Start
			while ( have_posts() ) : the_post();

				// if ( has_post_thumbnail() ) {
				// 	echo '<div class="post-media">';
				// 		the_post_thumbnail('bard-full-thumbnail');
				// 	echo '</div>';
				// }

				echo '<div class="post-content">';
					the_content('');

					// Post Pagination
					$defaults = array(
						'before' => '<p class="single-pagination">'. esc_html__( 'Pages:', 'bard' ),
						'after' => '</p>'
					);

					wp_link_pages( $defaults );
				echo '</div>';

			endwhile; // Loop End

			endif;

			?>

		</article>

		<?php get_template_part( 'templates/single/comments', 'area' ); ?>

	</div><!-- .main-container -->

		</div>
	</div>
</div>
</div>
<div class="info-view">
	<div class="container">
		<div class="row item-list">
			<div class="col-sm-6 item">
				<i class="glyphicon glyphicon-map-marker"></i>
				<p class="lead">ul. Kręta 2 lok. 4</p>
			</div>
			<div class="col-sm-6 item">
				<i class="glyphicon glyphicon-earphone"></i>
				<p class="lead">518 619 419</p>
			</div>
		</div>
	</div>
</div>
<div class="mapa _i01-00">
	<div class="blok">
		<header>
			<h1>Mapa</h1>
			<p>Sprawdź naszą dokładną lokalizację</p>
		</header>
		<div class="content">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d598.7134694935106!2d23.145828829260328!3d53.11281599874568!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x471ffe7f63f304ed%3A0x552993490380c851!2sStayFit!5e0!3m2!1spl!2spl!4v1474201950512" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
	</div>
</div>



<?php get_footer(); ?>