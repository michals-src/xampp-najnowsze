
<?php 

//echo "<pre>", print_r( sf_manager_timetable_days() ), "</pre>";

$timetable = sf_manager_timetable_days();
$zajęcia = get_posts( array( "post_type" => "exercises", 'status' => 'publish' ) );
$godziny = get_terms( "timetable-time" );

$active_days = array_map(function($data){
	return ($data["status"] === true) ? $data : null;
}, $timetable);
$active_days = array_filter($active_days);
$days = array_keys($active_days);

?>
<div class="grafik _i01-00">
	<div class="container">


<div class="row">

	<div class="col-md-12">
		<div class="row">
			<div class="offset-md-2"></div>
			<?php 
				for($x=0;$x<count($active_days);$x++){
			?>
				<div class="col">
					<div style="padding:15px;text-align:center;font-size:18px;">
						<?php echo ucfirst($days[$x]);?>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>

<?php foreach( $godziny as $godzina_key => $godzina ): ?>
<?php 
	$divide = $godzina_key / 2;
	$bg = (floor($divide) === $divide || $godzina_key === 0) ? 'background: #ecf1f3;' : '';
?>
	<div class="col-md-12 mb-3">
		<div class="row">
			<div class="col" style="<?php echo $bg;?>">
				<?php 
					$time = explode(':', $godzina->name);	
				?>
				<div class="d-flex align-items-center" style="height:150px;widht:100%;">
					<div style="width:100%;text-align:center;">
						<p style="display:inline-block;font-weight:800;font-size:2rem;"><?php echo $time[0]; ?></p>
						<p style="display:inline-block;font-weight:400;vertical-align:top;"><?php echo $time[1]; ?></p>
					</div>
				</div>
			</div>
	<?php foreach( $active_days as $name => $data ){ ?>
		<?php
				$current_time_exercise = (int) $data["schedule"][$godzina->term_id];
				if(empty($current_time_exercise)){
					echo '<div class="col" style="height:150px;"></div>';
				}

				foreach( $zajęcia as $key => $exercise ){
					
					if( $current_time_exercise !== $exercise->ID ){
						continue;
					}

					$exercise_level = wp_get_object_terms( $exercise->ID, 'exercises-level' );
					if( ! empty( $exercise_level ) ){

						echo '<div class="col" style="'.$bg.'">';

						$level_color = get_term_meta( $exercise_level[0]->term_id, 'level_color' );
						echo '<div class="d-flex align-items-center" style="height:150px;border-top:5px solid '.$level_color[0].';">';
						echo '<p style="width:100%;text-align:center;">' . $exercise->post_title . '</p>';
						echo '</div>';

						echo '</div>';
					}

				}
		?>
	<?php } ?>
</div>
</div>
<?php endforeach; ?>	

</div>
	
	
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
									echo '<td style="text-align:center;font-weight:700;border:5px solid '.$level_color[0].';">' . $exercise->post_title . '</td>';
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
							<div class="col-sm-2" style="background-color: <?php echo $color[0]; ?>;color:transparent;border-radius:5px;width:100%;height:30px;">Color</div>
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