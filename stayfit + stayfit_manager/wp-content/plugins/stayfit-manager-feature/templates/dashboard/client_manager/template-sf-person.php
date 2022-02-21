<div id="p-0">

    <div class="mb-3"><h4><strong>Użytkownik: <?php echo $firstname . ' ' . $lastname; ?></strong></h4></div>
    <div class="row mt-2">
         <div class="col-6">
            <div><p>Ilość wejść: <?php echo $current_entries; ?> / <?php echo $max_entries; ?></p></div>
        </div>
        <div class="col-6 text-right">
            <div><p>Dodano: <?php echo $registered; ?></p></div>
        </div>
    </div>
    <div id="sf-dashboard-settings" class="list-group">
		
        <div class="row">

        <div class="col-sm-12 col-md-8">
    		<?php echo $form; ?>
        </div>
        
        <div class="col-sm-12 col-md-4">
        <div class="mt-3 p-3 alert alert-warning">
        	<h4><ion-icon name="clipboard" style="margin-right: 8px;margin-bottom: -3px;"></ion-icon>
            <span>Raport wejść użytkownika</span>
        </h4>

            <form action="<?php echo get_permalink(); ?>?page=client_manager.person&id=<?php echo $_GET['id']; ?>" method="get">
                <input type="hidden" name="page" value="client_manager.person">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <div class="form-group row">
                    <div class="col-8">
                        <select name="month" class="form-control">
                        <?php 
                        foreach( $raport["months"] as $key => $month ): 
                            if( is_int( $key ) ){ $key = (string) $key; }
                        ?>
                            <option value="<?php echo $key; ?>" <?php echo ( $key === $raport["selected"] ) ? 'selected' : ''; ?> ><?php echo $month; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </div> <!-- Select -->
                    <div class="col-4">
                        <button class="btn btn-primary" style="width: 100%;">Pokaż</button>
                    </div> <!-- Button -->
                </div>
            </form>
            <div class="mt-3 alert alert-secondary">
                <div class="row">
                    <div class="col-8">
                        <p style="margin:0;">Ilość wejść w wybranym miesiącu</p>
                    </div>
                    <div class="col-4 text-right">
                        <h4 style="margin: 0;"><strong> <?php echo $raport["count"]; ?> </strong></h4>
                    </div>
                </div>
            </div>
            <ul class="mt-3">
        	<?php

                if( $raport["count"] !== 0 ):
                    for( $x = ($raport["count"] - 1); $x >= 0; $x-- ):      
            ?>
                <li class="mb-1"><?php echo $raport["data"][$x]; ?></li>
            <?php
                    endfor;
                else:
                    echo 'Brak';
                endif;

        	?>
        	
        	</ul>
        </div>

        </div>
        </div>
	</div>
</div>