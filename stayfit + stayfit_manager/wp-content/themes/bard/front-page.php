<?php get_header(); ?>

<header class="site-content-header" style="height:650px;overflow:hidden;margin-top:0;background:url(<?php echo get_permalink(); ?>/wp-content/themes/bard/324r23r34.png);">
	<div class="mt-5">
		<div class="row no-gutters mt-5">
		<div class="col-7" >
				<img src="http://localhost/wp-content/themes/bard/slider-image2.png" style="margin-right: auto;">
			</div>
			<div class="col-md-5" style="padding-top:120px;margin-bottom: -150px;">
				<h3 class="mb-3">Klub fitness Białystok</h3>
				<h1 style="font-size: 2.5rem;">Profesjonalni instruktorzy</h1>
				<h1 style="font-size: 2.5rem;">Kameralne grupy fitness</h1>
				<h1 class="mb-3" style="font-size: 2.5rem;">Miła atmosfera</h1>
				<a href="<?php echo get_permalink( get_page_by_title('Cennik') ); ?>" style="    padding: 12px 25px; font-weight: 800; color: #000; border: 3px solid #000; border-radius: 25px; margin-top: 20px; display: inline-block;">
					Nasza oferta
				</a>
			</div>
		</div>
	</div>
</header>

<section class="site-container" style="margin-top:100px;margin-bottom: 100px;">
	<div class="side-margins">
		<div class="row">
			<div class="col-md-5 d-flex align-items-center" style="height:400px;">
				<div>
					<h2 class="mb-4" style="font-weight:800;font-size:2.5rem;">Dołącz do nas</h2>
					<p style="color:#555;letter-spacing:1.3px;">
						<?php 
							$options = Sf_Options::Instance();
							echo $options->get('site/description');
						?>
					</p>
				</div>
			</div>
			<div class="col-md-6 offset-1">
				<div style="height:300px;background:purple;max-width:100%;">
					<img src="http://localhost/wp-content/themes/bard/653245367342.jpg" style="width:100%;height:400px;">
				</div>
			</div>
		</div>
	</div>
</section>

<section>
	<div>
	<div class="site-container side-margins">
		<h5 style="padding-bottom:50px;letter-spacing:0.1rem;font-weight:800;text-transform:uppercase;">Zajęcia</h5>
		<div class="row">



		</div>
	</div>
	<div class="row no-gutters" style="position:relative;">
		<div style="width:100%;text-align:center;position:absolute;height:100%;z-index:21;">
			<h1 style="color:#fff;margin-top:150px;font-size:3.5rem;text-shadow:0 10px 20px #333;font-weight:800;">Nasza oferta zajęć</h1>
			<h1 style="color:#fff;margin-top:10px;font-size:3.5rem;text-shadow:0 10px 20px #333;font-weight:800;">Zyskaj siłę</h1>
		</div>
		<div class="col-md-3" style="height:600px;background:#6e6ec1 url(http://localhost/wp-content/themes/bard/324567521345.jpg) left;">
			<div  style="height:600px;">
				<div class="d-flex align-items-end" style="height:500px;text-align:center;width:100%;">
					<div style="width:100%;text-align:center;position:relative;z-index:25;">
						<h2 style="text-shadow: 2px 2px 15px #333;color:#fff;margin-bottom:35px;">Zajęcia grupowe</h2>
						<a href="<?php echo get_permalink( get_page_by_title('Zajęcia grupowe') ); ?>" style="border-radius:20px;padding: 12px 25px;background:#fff;color:#000;margin-top:15px;font-weight:800;">Czytaj więcej</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3" style="height:600px;background:#a76184 url(http://localhost/wp-content/themes/bard/65432134t6.jpg) center no-repeat;">
			<div  style="height:600px;">
			<div class="d-flex align-items-end" style="height:500px;text-align:center;width:100%;">
					<div style="width:100%;text-align:center;position:relative;z-index:25;">
						<h2 style="text-shadow: 2px 2px 15px #333;color:#fff;margin-bottom:35px;">Trening personalny</h2>
						<a href="<?php echo get_permalink( get_page_by_title('Trening personalny') ); ?>" style="border-radius:20px;padding: 12px 25px;background:#fff;color:#000;margin-top:15px;font-weight:800;">Czytaj więcej</a>
					</div>
				</div>
			</div>
		</div>	
		<div class="col-md-3" style="height:600px;background:#a76184 url(http://localhost/wp-content/themes/bard/2rwefdsafsda.jpg) center no-repeat;">
			<div  style="height:600px;">
			<div class="d-flex align-items-end" style="height:500px;text-align:center;width:100%;">
					<div style="width:100%;text-align:center;position:relative;z-index:25;">
						<h2 style="text-shadow: 2px 2px 15px #333;color:#fff;margin-bottom:35px;">Masaż</h2>
						<a href="<?php echo get_permalink( get_page_by_title('Masaż') ); ?>" style="border-radius:20px;padding: 12px 25px;background:#fff;color:#000;margin-top:15px;font-weight:800;">Czytaj więcej</a>
					</div>
				</div>
			</div>
		</div>	
		<div class="col-md-3" style="height:600px;background:#a76184 url(http://localhost/wp-content/themes/bard/2435765456745.jpg) center no-repeat;">
			<div  style="height:600px;">
			<div class="d-flex align-items-end" style="height:500px;text-align:center;width:100%;">
					<div style="width:100%;text-align:center;position:relative;z-index:25;">
						<h2 style="text-shadow: 2px 2px 15px #333;color:#fff;margin-bottom:35px;">Kinesiotaping</h2>
						<a href="<?php echo get_permalink( get_page_by_title('Kinesiotaping') ); ?>" style="border-radius:20px;padding: 12px 25px;background:#fff;color:#000;margin-top:15px;font-weight:800;">Czytaj więcej</a>
					</div>
				</div>
			</div>
		</div>	

	</div>
	</div>
</section>

<section class="site-section site-container side-margins">
<h5 style="padding-bottom:25px;letter-spacing:0.1rem;font-weight:800;">AKTUALNOŚCI</h5>



<?php
	$posts = get_posts(array('numberposts' => 2, 'post_type' => 'post','exclude'=>array(get_the_ID())));
	if(!empty($posts)){
		?>
		<div class="row">
		<?php
		foreach($posts as $post => $data){
			$post_meta = get_post_meta( $data->ID, 'post_color' );
			$color = (!empty($post_meta)) ? $post_meta[0] : '#86dc91';
			?>
					<div class="col-md-6 col-xs-12 col-sm-12 mb-3">
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
	}else{
		echo '<p>Brak</p>';
	}
?>

</section>

<!-- 
<section class="site-container site-section">
	<div class="container text-center">
		<header class="mb-md-4 mb-sm-3">
			<h3>Panie i Panowie, prosimy o uwagę</h3>
			<h1>Dla każdego coś dobrego</h1>
		</header>
		<p class="lead">
			Trening personalny, masaż oraz kinesiotaping są przeznaczone dla kobieta jak również dla mężczyzn. Wyłączenie zajęcia grupowe odbywają się w gronie pań.
		</p>
	</div>
</section> -->

<?php get_footer(); ?>