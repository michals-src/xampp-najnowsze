<?php if( ! defined( "ABSPATH" ) ) exit; ?>
<div class="p-0">

    <div class="row">

        <div class="col-md-12">
            <div class="row" style="list-style-type:none;">
                <?php 
                
                    foreach( sf_manager_client_manager_navigation() as $endpoint_key => $endpoint ){ ?>
                       
                        <div class="col-6" style="margin-bottom: 10px;">
                        	<a href="<?php echo get_permalink() . '?p=' . $endpoint['slug']; ?>" style="display: block; padding: 10px 0 7px 0; border: 1px solid #aaa; border-radius: 5px;text-align: center;"> <div style="padding: 5px;font-size: 42px;vertical-align: middle;"><ion-icon name="<?php echo $endpoint['icon']; ?>"></ion-icon></div>
	                               <p style="margin-top:10px;"> <?php echo $endpoint["label"]; ?> </p>
	                        </a>
                        </div>
                        

                <?php } ?>
            </div>
        </div>
    
    </div>

</div>