<?php if ( bard_options( 'top_bar_label' ) === true ) : ?>

<div id="top-bar" style="padding:18px 0;">
	<div class="container">
		
			<?php

				// Social Icons
				//bard_social_media( 'top-bar-socials', false );

			?>

				<?php 

					$custom_logo_id = get_theme_mod( 'custom_logo' );
					$custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );
					// echo '<span><h2 style="display: inherit;margin-top:-5px;"><strong>Stay</strong> Fit</h2></span>';

				?>


			<div class="row">
				<div id="top-bar--logotype" class="col-12">
					<?php echo '<img src="' . esc_url( $custom_logo_url ) . '" alt="" style="display:inline-table;margin-right:15px;width:60px;margin-bottom: 5px;">'; ?>
					<h3 style="display:inline-table;letter-spacing:1px;color: #000;">Stay Fit</h3>
				</div>
			</div>
			<?php
				// wp_nav_menu( array(
				// 	'theme_location' 	=> 'top',
				// 	'menu_id' 		 	=> 'top-menu',
				// 	'menu_class' 		=> '',
				// 	'container' 	 	=> 'nav',
				// 	'container_class'	=> 'top-menu-container',
				// 	'fallback_cb' 		=> 'bard_top_menu_fallback'
				// ) );


			?>

	</div>
</div><!-- #top-bar -->

<div id="top-bar-mobile" style="padding:18px 0;">
	<div class="top-bar-mobile-overall">
		<div class="top-bar-mobile-courtain"></div>
		<div class="top-bar-mobile-container">
			<div class="container">

				<?php 

					$custom_logo_id = get_theme_mod( 'custom_logo' );
					$custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );

				?>


				<div class="row">
					<div id="top-bar--logotype" class="col-4 col-lg-12" style="text-align: left;">
						<?php echo '<img src="' . esc_url( $custom_logo_url ) . '" alt="" style="display:inline-table;margin-right:15px;width:40px;padding-top:3px;margin-bottom: 5px;">'; ?>
					</div>
					<div id="top-bar--logotype" class="col-4 col-lg-12" style="text-align: center;">
						<h5 style="display:block;padding-top:8px;letter-spacing:1px;color: #000;">Stay Fit</h5>
					</div>
					<div id="top-bar--menu" class="col-4 col-lg-12" style="text-align: right;">
						<div class="hamburger-menu-btn" style="line-height: 45px;">
							<ion-icon name="menu" style="font-size:19px;"></ion-icon>
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="top-bar-mobile-nav">
			
			<?php 

				$mobile_menu_location = 'main';
				$mobile_menu_items = '';

				wp_nav_menu( array(
					'theme_location' 	=> $mobile_menu_location,
					'menu_class' 		=> '',
					'container' 	 	=> 'nav',
					'container_class'	=> 'hamburger-menu-container',
					'items_wrap' 		=> '<ul id="%1$s" class="%2$s">%3$s '. $mobile_menu_items .'</ul>',
					'fallback_cb'	    => false,
				) );
			?>

		</div>
	</div>
</div><!-- #top-bar -->

<?php endif; ?>