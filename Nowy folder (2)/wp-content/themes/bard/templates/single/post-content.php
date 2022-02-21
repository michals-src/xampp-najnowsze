<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="site-container side-margins">
<div class="row">
<div class="col-md-7 col-sm-12">

<?php

if ( have_posts() ) :

	// Loop Start
	while ( have_posts() ) :

		the_post();

?>	

	<div class="post-media">
		<?php the_post_thumbnail('bard-full-thumbnail'); ?>
	</div>

	<header class="post-header">

		<?php if ( bard_options( 'single_page_show_categories' ) === true ) : ?>
		<div class="post-categories"><?php the_category( ',&nbsp;&nbsp;' ); ?></div>
		<?php endif; ?>

		<?php if ( get_the_title() ) : ?>
		<h1 class="post-title"><?php the_title(); ?></h1>
		<?php endif; ?>
		
		<span class="border-divider"></span>

		<div class="post-meta clear-fix">
			<?php if ( bard_options( 'single_page_show_date' ) === true ) : ?>
			<span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
			<?php endif; ?>
		</span>
		
	</header>

	<div class="post-content">

		<?php

		// The Post Content
		the_content('');

		// Post Pagination
		$defaults = array(
			'before' => '<p class="single-pagination">'. esc_html__( 'Pages:', 'bard' ),
			'after' => '</p>'
		);

		wp_link_pages( $defaults );

		?>
	</div>

<?php

	endwhile; // Loop End
endif; // have_posts()

?>
</div>
<div class="col-md-3 offset-md-2 col-ms-12">
<?php
	$posts = get_posts(array('numberposts' => 4, 'post_type' => 'post','exclude'=>array(get_the_ID())));
	if(!empty($posts)){
		?>
		<div class="row">
		<?php
		foreach($posts as $post => $data){
			$post_meta = get_post_meta( $data->ID, 'post_color' );
			$color = (!empty($post_meta)) ? $post_meta[0] : '#86dc91';
			?>
				
					<div class="col-md-12 col-xs-6 col-sm-6 mb-3">
						<article class="d-flex align-items-center" style="text-align:center;height:300px;background:<?php echo $color; ?>">
							<div style="margin:0 auto;">
								<h6><?php echo theme_post_date($data->post_date);?></h6>
								<h4 class="mb-2" style="margin:0 auto;text-align:center;">#<?php echo $data->post_title; ?></h4>
								<a href="<?php echo get_permalink($data->ID); ?>" style=" padding: 8px 15px; font-weight: 800; color: #000; border: 3px solid #000; border-radius: 25px; margin-top: 20px; display: inline-block;">
									Przejdź do artykułu
								</a>
							</div>
						</article>
					</div>
				
			<?php
		}
		?>
		</div>
		<?php
	}
?>

</div>
</div>
</div>
</article>