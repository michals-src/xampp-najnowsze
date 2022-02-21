<?php 
	/**	
	 * Template name: Masaż
	 */
?>
<?php get_header(); ?>

<header  style="overflow:hidden;margin-top:0;background:url(http://localhost/wp-content/themes/bard/assets/images/16389165_10209494039641257_1183055834_o.jpg) center;">

<div style="position:absolute;width:100%;height:60px;background:rgba(0,0,0,0.8);z-index:50;">
		<div class="site-container side-margins" style="width:100%;border: 1px solid #000;border-top: 0px;">
			<a href="<?php echo get_permalink( get_page_by_title( 'Zajęcia grupowe' ) ) ?>" style="padding:15px 15px;display:inline-block;color:#fff;">Zajęcia grupowe</a>
			<a href="<?php echo get_permalink( get_page_by_title( 'Trening personalny' ) ) ?>" style="padding:15px 15px;display:inline-block;color:#fff;">Trening personalny</a>
			<a href="<?php echo get_permalink( get_page_by_title( 'Masaż' ) ) ?>" style="padding:15px 15px;display:inline-block;color:#fff">Masaż</a>
			<a href="<?php echo get_permalink( get_page_by_title( 'Kinesiotaping' ) ) ?>" style="padding:15px 15px;display:inline-block;color:#fff;">Kinesiotaping</a>
		</div>
	</div>

	<div class="site-container side-margins">
		<div>
			<div class="row no-gutters d-flex align-items-center" style="height:600px;">
				<div class="col-md-12">
					<h1 style="font-size: 3rem;color:#fff;">Chwila relaksu.</h1>
					<h1 style="font-size: 5rem;color:#fff;font-weight:800;">Masaż sportowo relaksacyjny</h1>
				</div>
			</div>
		</div>

	</div>
</header>

<!-- CENNIK -->
<div style="background:#fff;padding-top:100px;padding-bottom:00px;">
	<div class="site-container side-margins">

			<div class="row">
				<div class="col-md-12 mb-3" style="letter-spacing:2px;">
					<h2 class="mb-1" style="font-size:4rem;font-weight:700;color:#ccc;">
						Czas odprężenia
					</h2>
				</div>
				<div class="col-md-5" style="letter-spacing:2px;">
					<h2 class="mb-1" style="font-size:3rem;font-weight:700;color:#000;">
						Zdobądź dla siebie chwilę przerwy
					</h2>
				</div>
				<div class="col-md-6 offset-1 mt-3">
					<p style="letter-spacing:2px;">
						Idealny sposób na zmęczenie zarówno fizyczne, jak i psychiczne. 
						W chwili przemęczeni i pozbawieni energii dobry masaż relaksacyjny leczy obolałe i napięte mięśnie, 
						a także jest prawdziwą przyjemnością dla ciała.
					</p>
				</div>
			</div>

	</div>
</div>

<?php get_footer(); ?>