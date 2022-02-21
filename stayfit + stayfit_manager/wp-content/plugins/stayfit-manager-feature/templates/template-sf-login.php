<?php

    if( ! defined("ABSPATH") ){
        exit;
    }

?>
<div class="container-fluid p-0">
    <?php 
        //do_action( "sf_manager_form_notices" );

        if( ! empty( $is_logged_in ) ){ 
        
    ?>

        <h3>Jesteś już zalogowany.</h3>
        <?php echo sprintf( '<a href="%s">%s</a>',  wp_logout_url( home_url(), true ), "Wyloguj się" );?>

    <?php 
    
        }

        echo $form;
    ?>

</div>