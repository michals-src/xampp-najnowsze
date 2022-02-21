
<?php 

//echo "<pre>", print_r( sf_manager_timetable_days() ), "</pre>";

$timetable = sf_manager_timetable_days();
$zajęcia = get_posts( array( "post_type" => "exercises", 'status' => 'publish' ) );
$godziny = get_terms( "timetable-time" );


?>
<div class="grafik _i01-00">
	<div class="container">
		<div>
		<table class="overflow-auto" style="width:100%;height:300px;">
			<thead>
				<th></th>
				<?php foreach( $timetable as $day => $day_data ):
						if( $day_data["status"] === true ): ?>
							<th><?php echo ucfirst( $day ); ?></th>
				<?php endif; endforeach; ?>
			</thead>
			<tbody>

				<?php foreach( $godziny as $godzina_key => $godzina ): ?>
					<tr>
						<td><?php echo $godzina->name; ?></td>
					<?php foreach( $timetable as $day => $day_data ){

						if( $day_data["status"] === true ){

							$current_time_exercise = (int) $day_data["schedule"][$godzina->term_id];
								
							if( empty( $current_time_exercise ) ){
								echo '<td></td>';
							}

							foreach( $zajęcia as $key => $exercise ){

								if( $current_time_exercise !== $exercise->ID ){
									continue;
								}

								$exercise_level = wp_get_object_terms( $exercise->ID, 'exercises-level' );
								if( ! empty( $exercise_level ) ){
									$level_color = get_term_meta( $exercise_level[0]->term_id, 'level_color' );
									echo '<td style="background-color: ' . $level_color[0] . ';">' . $exercise->post_title . '</td>';
								}


							}

						}

					}

					?>
				    
					</tr>

				<?php endforeach; ?>

			</tbody>
		</table>
		</div>


<?php

	$get_levels = get_terms( "exercises-level", array(
	    "hide_empty" => false,
	    'orderby' => 'term_id', 
	    'order' => 'DESC',
	));

?>

		<div class="legenda">
			<div class="row">
				<?php foreach( $get_levels as $key => $level ): 
					$color = get_term_meta( $level->term_id, 'level_color' );
				?>
					<div class="col-sm-4 col-xs-12">
						<div class="row">
							<div class="col-sm-2" style="background-color: <?php echo $color[0]; ?>;color:transparent;">Color</div>
							<p class="col-sm-10"><?php echo $level->name; ?></p>
						</div>
					</div>
				<?php endforeach; ?>
		
				<!--
				<div class="col-sm-12 col-xs-12 _litm" style="margin-top: 35px;">
					<p style="display:block;">Zajęcia <strong>Pilates</strong> odbywają się w 1 i 3 Piątek miesiąca</p>
					<p style="display:block;">Zajęcia <strong>Power Pilates</strong> odbywają się w 2 i 4 Piątek miesiąca</p>
				</div>
				-->
			</div>
		</div>
	</div>
</div>