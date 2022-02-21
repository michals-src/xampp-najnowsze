<?php if ( bard_options( 'main_nav_label' ) === true ) : ?>
	
<div id="main-nav" class="clear-fix">

	<div class="container">	

		<!-- Mobile Menu Button -->
<!-- 		<span class="mobile-menu-btn">
			<i class="fas fa-chevron-down"></i>
		</span> -->

		<?php // Navigation Menus

		wp_nav_menu( array(
			'theme_location' 	=> 'main',
			'menu_id'        	=> 'main-menu',
			'menu_class' 		=> '',
			'container' 	 	=> 'nav',
			'container_class'	=> 'main-menu-container',
			'fallback_cb' 		=> 'bard_main_menu_fallback'
		) );
		
		$mobile_menu_location = 'main';
		$mobile_menu_items = '';

		if ( bard_options( 'main_nav_merge_menu' ) === true ) {
			$mobile_menu_items = wp_nav_menu( array(
				'theme_location' => 'top',
				'container'		 => '',
				'items_wrap' 	 => '%3$s',
				'echo'			 => false,
				'fallback_cb'	 => false,
			) );

			if ( ! has_nav_menu('main') ) {
				$mobile_menu_location = 'top';
				$mobile_menu_items = '';
			}
		}
		

		?>

	</div>

</div><!-- #main-nav -->

<?php endif; ?>