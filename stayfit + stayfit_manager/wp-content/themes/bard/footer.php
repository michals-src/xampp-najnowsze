		</div><!-- .page-content -->

		<!-- Page Footer -->
		<footer id="page-footer">
<?php $options = Sf_Options::instance(); ?>
<?php 
	$site_options = $options->Receive();
?>
<section>
	<div class="section-info site-container side-margins">
		
		
		<div class="row">
			<div class="col-6 text-center mb-5" style="margin: 0 auto;">
				<h2 class="mb-3" style="font-weight:500;">Potrzebujesz więcej informacji</h2>
				<p style="font-size:1rem;">
					W przypadku, gdy na stronie nie znajduje się szukana informacjia, prosimy o kontakt drogą mailową lub telefoniczny
				</p>
			</div>
			<div class="col-12">
				<div class="row">
					<div class="col-6 text-center">
						<h3 class="mb-2" style="font-weight:500;">Adres e-mail</h3>
						<p class="lead"><?php echo $options->get('site/contact/email'); ?></p>
					</div>
					<div class="col-6 text-center">
						<h3 class="mb-2" style="font-weight:500;">Kontakt telefoniczny</h3>
						<p class="lead">+48 <?php echo $options->get('site/contact/dialling_code'); ?></p>
					</div>				
				</div>
			</div>
		</div>
	</div>
	<div class="footer_banner side-margins" style="background:#000;">
		<img src="<?php echo get_home_url() . '/wp-content/themes/bard/assets/images/footer_banner.jpg'; ?>">
	</div>
</section>		
<section class="site-container side-margins footer-text">
	<div>
		<div class="row">
			<div class="col-6">
				<p class="lead">
					W celu uzyskania informacji istnieje możliwość skontaktowania się z nami drogą mailową oraz telefonicznie. Jeżeli przez dłuższy czas nie została przesłana odpowiedź proszę skontaktować się z nami na facebooku
				</p>
			</div>
		</div>
	</div>
	<div class="footer-middle">
		<div class="row">
			<div class="col-3">
				<div>
					<h4 class="mb-0"><strong>Email</strong></h4>
					<p class="lead"><?php echo $options->get('site/contact/email'); ?></p>
				</div>
				<div>
					<h4 class="mb-0"><strong>Kontakt telefoniczny</strong></h4>
					<p class="lead">+48 <?php echo $options->get('site/contact/dialling_code'); ?></p>
				</div>				
			</div>
			<div class="col-4">
				<h3 class="mb-3">Gdzie jesteśmy ?</h3>
				<div>
					<p class="lead mb-0">ul. <?php echo $options->get('site/location/street'); ?> lok. <?php echo $options->get('site/location/place_no'); ?></p>
					<p>oś. Osiedle nazwa</p>
				</div>
				<div>
					<p class="lead"><?php echo $options->get('site/location/city'); ?>, <?php echo $options->get('site/location/postal_code'); ?></p>
				</div>
			</div>
			<div class="col-5">
				<h1>Odwiedź nasz profil na facebook</h1>
				<div>
					<a href="#">Kliknij tutaj</a>
				</div>
			</div>
		</div>
	</div>
	<div>
		<?php 
			wp_nav_menu( array(
				'theme_location'			=> 'footer',
				'menu_class'	=> 'site-navbar-menu--nav',
				'container'		=> 'ul',
			) );
		?>
	</div>
	<div>
		<p>Stay Fit Białystok &copy; <?php echo date('Y'); ?></p>
	</div>
</section>

		</footer><!-- #page-footer -->

	</div><!-- #page-wrap -->

<?php wp_footer(); ?>

</body>
</html>