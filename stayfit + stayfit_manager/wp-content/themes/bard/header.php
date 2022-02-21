<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>


<!-- Page Wrapper -->
<div id="page-wrap">

<section id="site_navbar" class="site-navbar">
	
	<!-- <div style="background:rgba(0,0,0,.8);font-size:0.75rem;">
	
		<div class="site-container site-navbar-informations side-margins">
			<div class="row" style="padding-bottom:5px;">
				<div class="col-4">
					<p>543 754 203</p>
				</div>
				<div class="col-4 text-center">
					<p>0 zł wpisowego</p>
				</div>
				<div class="col-4 text-right">
					<p>stayfit.bialystok@wp.pl</p>
				</div>
			</div>
		</div>
	
	</div> -->
	
	<div class="site-container">
		<div class="site-navbar-menu side-margins">
<style>
.site-navbar-user-menu a{
	border-radius: 20px;
    padding: 6px 20px 7px 20px;
    font-size: 14px;
    color: #fff !important;
    font-weight: 700;
    background: #0072ff;
}
</style>

				<div class="row">
					<div class="col-8">
						<h3 class="site-brand">	
							Stay Fit
						</h3>
						<?php 
							wp_nav_menu( array(
								'theme_location'			=> 'primary',
								'menu_class'	=> 'site-navbar-menu--nav',
								'container'		=> 'ul',
							) );
						?>
					</div>
					<div class="col-4 text-right">
						<div style="margin-top: 5px;">
							<?php 
								wp_nav_menu( array(
									'theme_location' => 'umenu',
									'menu_class'	=> 'site-navbar-menu--nav site-navbar-user-menu',
									'container'		=> 'ul',
								) );
							?>
						</div>
					</div>
				</div>		
		</div>
	</div>
</section>
<div class="site-navbar-menu--clearfix"></div>

		<!-- Page Content -->
		<div class="page-content">
			