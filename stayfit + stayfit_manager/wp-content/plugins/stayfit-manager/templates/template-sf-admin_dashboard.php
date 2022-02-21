<?php 

    if( ! defined( "ABSPATH" ) ) exit;

?>
<div class="container p-0">

    <div class="row">

        <div class="col-md-4">
            <ul class="list-group list-group-flush">
                <?php 
                    foreach( sf_manager_dashboard_navigation()["endpoints"] as $endpoint_key => $endpoint ){ ?>
                       
                        <a class="list-group-item <?php echo $endpoint['class']; ?>" href="<?php echo sf_manager_dashboard_navigation()["permalink"] . '?page=' . $endpoint['slug']; ?>">
                                <?php echo $endpoint["label"]; ?>
                        </a>
                        

                <?php } ?>
            </ul>
        </div>
        <div class="col-md-8">
            <?php 
                do_action( "sf_manager_dashboard_content" );
            ?>
        </div>
    
    </div>

</div>