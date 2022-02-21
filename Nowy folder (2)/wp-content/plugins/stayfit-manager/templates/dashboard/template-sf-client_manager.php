<?php if( ! defined( "ABSPATH" ) ) exit; ?>
<div class="container p-0">

    <div class="row">

        <div class="col-md-12">
            <ul style="list-style-type:none;">
                <?php 
                
                    foreach( sf_manager_client_manager_navigation() as $endpoint_key => $endpoint ){ ?>
                       
                        <li style="margin-bottom: 10px;">
                        	<a href="<?php echo get_permalink() . '?page=' . $endpoint['slug']; ?>" style="display: block; padding: 2px 15px 0px 15px; border: 1px solid #aaa; border-radius: 5px;"> <span style="padding: 5px;font-size: 26px;display: inline-table;vertical-align: middle;"><ion-icon name="<?php echo $endpoint['icon']; ?>"></ion-icon></span>
	                                <?php echo $endpoint["label"]; ?>
	                        </a>
                        </li>
                        

                <?php } ?>
            </ul>
        </div>
    
    </div>

</div>