<?php 
	/**	
	 * Template name: T.p.
	 */
?>
<?php get_header(); ?>

<header  style="overflow:hidden;margin-top:0;background:url(http://localhost/wp-content/themes/bard/sport-2260736_1920.jpg) center;">

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
					<h1 style="font-size: 3rem;color:#fff;">Możesz i zrobisz.</h1>
					<h1 style="font-size: 5rem;color:#fff;font-weight:800;">Trening personalny</h1>
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
					Otrzymaj profesjonalną pomoc
					</h2>
				</div>
				<div class="col-md-5" style="letter-spacing:2px;">
					<h2 class="mb-1" style="font-size:3rem;font-weight:700;color:#000;">
						Osiągnij niemożliwe dzięki wsółpracy z trenerem personalnym
					</h2>
				</div>
				<div class="col-md-6 offset-1 mt-3">
					<p style="letter-spacing:2px;">
						Dostosowany plan treningu do Twoich oczekiwań przez trenera, 
						pomaga maksymalnie wykorzystać każdą minutę Twojego cennego czasu.
						Trening skupia się na czym Ci najbardziej zależy, ale również na tym co jest Twoją najsłabszą stroną
					</p>
				</div>
			</div>



		<div class="row" style="margin-top:100px;">
			<div class="col-md-5 d-flex align-items-center" style="height:500px;">
				<div>
					<h2 class="mb-3" style="font-size:1.5rem;font-weight:500;">
						Radość i satysfakcja
					</h2>
					<p style="color:#555;">
						Indywidualny program treningowy który pozwala czerpać dużo radości i satysfakcji z podejmowanej aktywności fizycznej. Trening personalny pozwala tworzyć indywidualne rozwiązania do Twoich potrzeb i możliwości, uwzględniając Twój stan zdrowia, dzięki którym można wyznaczyć najskuteczniejszą drogę do osiągnięcia pożądanych celów: w tym modelowania sylwetki, poprawę kondycji fizycznej, profilaktykę zdrowotną. 
					</p>
					<div>
						<p style="display:table;font-weight:500;background:#000;padding:5px 15px;color:#fff;border-radius:10px;margin-top:50px;font-size:0.8rem;">
							Zapisz się już dziś
						</p>			
					</div>
					<div>
						<p style="display:table;font-weight:500;background:#000;padding:5px 15px;color:#fff;border-radius:10px;font-size:0.8rem;">
							Telefonicznie lub odwiedź nasz klub w celu ustalenia terminu treningu.
						</p>
					</div>
				</div>
			</div>
			<div class="col-md-6 offset-1">
				<div style="background:purple url(http://localhost/wp-content/themes/bard/morgan-petroski-rx6wXNsXUOE-unsplash.jpg) center;background-size:cover;height:500px;max-width:100%;">
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>