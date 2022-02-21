
<?php if ( bard_options('header_image_label') === true ) : ?>
<!-- <div style="width: 100%;height:1000px;margin:0;padding:0;background: url(http://localhost/wp-content/themes/bard/assets/images/header-wall-fp.png) no-repeat;background-size:100%;"> -->
<?php $attr = ( has_post_thumbnail() ) ? 'style="background-image: url('. get_the_post_thumbnail_url( get_the_ID(), 'bard-full-thumbnail') .');"' : ''; ?>
<!-- 	<div class="entry-header container" data-parallax="" <?php //echo $attr; ?>> -->
<!-- 		<div class="cv-outer">
		<div class="cv-inner">

			<div class="header-logo">
					
				
			</div>

		</div>
		</div>
	</div> -->
<?php endif; ?>
<!-- </div> -->

<?php if( is_front_page() || is_home() ): ?>
<div id="main-header">
	<div class="container">
		<div class="text-center" style="color: #ffff;">
			<div class="main-header--text">
				<h1 style="color: #fff;">Klub fitness StayFit</h1>
				<p><span>Stay active.</span><span>Be Fit.</span></p>
			</div>
			<div class="main-header--refs">
				<a href="#">Oferta zajęć</a>
				<a href="#">Cennik</a>
			</div>
		</div>
	</div>
</div>
<?php else: ?>
<div id="subpage-header" style="background: url(http://localhost/wp-content/themes/bard/assets/images/header-background-1.png) center no-repeat;background-size: 1200px 430px;height:430px;">
	<div class="container d-flex align-content-center flex-wrap" style="width: 100%;height: 430px;text-align: center;">
		<h2 class="section-subheadline" style="color: #ffff;margin-left:auto;margin-right:auto;font-size:40px;">
			<?php 
				if ( get_the_title() !== '' ) {
						echo get_the_title() ;
				}
			?>
		</h2>
	</div>
</div>	
<?php endif; ?>