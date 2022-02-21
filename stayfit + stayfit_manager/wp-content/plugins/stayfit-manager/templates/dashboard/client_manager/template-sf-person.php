<div id="p-0">

    <?php $monitor = new Sf_Monitor( array( $_GET['id'] ) ); ?>

    <div class="mb-3"><h5><strong>Profil użytkownika</strong></h5></div>
    <div class="mt-2"><p>Dodano: <?php echo $monitor->user_registered()[0]; ?></p></div>
    <div class="mt-2"><p>Ilość wejść: <?php echo $current_entries; ?> / <?php echo $max_entries; ?></p></div>
    <div id="sf-dashboard-settings" class="list-group">
		
		<?php echo $form; ?>

        <div class="mt-5">
	        <div class="alert alert-primary" style="border-radius:5px">
	        	<a href="<?php echo get_home_url(); ?>/print?id=<?php echo $id; ?>" target="_blank">
                    <span style="display: inline-table;vertical-align: middle;font-size:20px;margin-right: 8px;padding-top: 2px;"><ion-icon name="print"></ion-icon></span>
                    Informacje do druku
                </a>
	        </div>
        </div>

        <div class="mt-3 p-3 alert alert-warning">
        	<h4><ion-icon name="clipboard" style="margin-right: 8px;margin-bottom: -3px;"></ion-icon>Monitor wejść</h4>
            <?php 

            $months = array(
                   "01" => "Styczeń",
                    "02" => "Luty",
                    "03" => "Marzec",
                    "04" => "Kwiecień",
                    "05" => "Maj",
                    "06" => "Czerwiec",
                    "07" => "Lipiec",
                    "08" => "Sierpiń",
                    "09" => "Wrzesień",
                    "10" => "Październik",
                    "11" => "Listopad",
                    "12" => "Grudzień"
            );

            $get_month = date( "m" );
            $selected = ( ! empty( $_GET["month"] ) ) ? $_GET["month"] : $get_month;

            ?>
            <form action="<?php echo get_permalink(); ?>?page=client_manager.person&id=<?php echo $_GET['id']; ?>" method="get">
                <input type="hidden" name="page" value="client_manager.person">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <div class="form-group row">
                    <div class="col-8">
                        <select name="month" class="form-control">
                        <?php foreach( $months as $key => $month ): 
                            if( is_int( $key ) ){
                                $key = (string) $key;
                            }
                            ?>
                            <option value="<?php echo $key; ?>" <?php echo ( $key === $selected ) ? 'selected' : ''; ?> ><?php echo $month; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </div> <!-- Select -->
                    <div class="col-4">
                        <button class="btn btn-primary" style="width: 100%;">Pokaż</button>
                    </div> <!-- Button -->
                </div>
            </form>
            <div class="mt-3 alert alert-secondary">
                <p style="margin:0;">Ilość wejść w tym miesiącu <span style="font-size:20px;font-style:italic;"><strong> <?php echo count( $monitor->results()[0][0][$selected] ); ?> </strong></span></p>
            </div>
            <ul class="mt-3">
        	<?php

                if( ! empty( $monitor->results() ) ){
                    //echo "<pre>", print_r($monitor->results()[0][0]), "</pre>";
                    if( ! empty( $monitor->results()[0][0][$selected] ) ):
            ?>
            <?php
                    $action_count = count($monitor->results()[0][0][$selected]);

                    for( $x = ($action_count - 1); $x >= 0; $x-- ):      
            ?>
                <li class="mb-1"><?php echo $monitor->results()[0][0][$selected][$x]; ?></li>
            <?php
                    endfor;

                        else:
                            echo 'Brak';
                        endif;
                }else{
                    echo 'Brak';
                }


        	?>
        	
        	</ul>
        </div>

	</div>

</div>