<div id="p-0">

    <div class="mb-3"><h5><strong>Raporty aktywności</strong></h5></div>
    <div id="sf-dashboard-settings" class="list-group">
		
    	<?php 

    		$raport_view = ( ! empty( $_GET['raport_view'] ) ) ? $_GET['raport_view'] : date("Y-m-d");

    	?>

    	<form action="<?php echo get_permalink(); ?>" method="get">
    		<input type="hidden" name="page" value="client_manager.raport">
    		<label>Wyświetl raport z dnia</label>
    		<div class="form-group row">
    			<div class="col-12">
    				<input type="date" name="raport_view" value="<?php echo $raport_view; ?>" class="form-control">
    			</div>
    			<label class="col-12 mt-3">Rodzaj raportów</label>
    			<div class="col-9">
    				<select name="raport_type" class="form-control">

    					<?php 

    						$options = array( 
    							"all" => "Wszystko",
    							"entries" => "Wejścia",
    							"errors" => "Anulowane operacje"
    						);

    						$raport_type = ( ! empty( $_GET['raport_type'] ) ) ? $_GET['raport_type'] : 'all';

    						foreach( $options as $value => $option ):
    							$selected_attr = ( $raport_type === $value ) ? 'selected' : '';

    					?>
    						<option value="<?php echo $value; ?>" <?php echo $selected_attr; ?>><?php echo $option ?></option>
    					<?php endforeach; ?>
    				</select>
    			</div>
    			<div class="col-3">
    				<button class="btn btn-primary" style="width:100%;">Pokaż</button>
    			</div>
    		</div>
    	</form>

    	<div class="mt-3 mb-3">
    		<h4>Raport z <?php echo $raport_view; ?></h4>
    		<?php 

				$args = array(
					'post_type'        => 'monitor_stats',
					'post_status'      => 'publish',
				);
				$raports_post = get_posts( $args );
				$ID = $raports_post[0]->ID;

				$raports_meta = get_post_meta( $ID, 'monitor_stats' );

				$dt = date( "d-m-Y", strtotime( $raport_view ));

				if( ! empty( $raports_meta ) ){

					
					if( array_key_exists( $dt , $raports_meta[0] ) ){
					echo '<ul>';
						foreach( $raports_meta[0][$dt] as $key => $raport ){

							switch( $raport_type ){

								case 'entries':
									if( $raport["type"] === "entry" ){
										echo '<li>' . $raport["msg"] . '</li>';
									}
								break;

								case 'errors':
									if( $raport["type"] === "error" ){
										echo '<li>' . $raport["msg"] . '</li>';
									}
								break;

								case 'all':
								default:
									echo '<li>' . $raport["msg"] . '</li>';
								break;

							}
						}

					echo '</ul>';

					}else{
						echo 'Brak aktywności';
					}

				}else{
					echo 'Brak';
				}

    		?>
    	</div>

	</div>

</div>