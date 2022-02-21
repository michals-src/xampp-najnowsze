<?php

    if( ! defined("ABSPATH") ){
        exit;
    }

?>
<div>
    <?php
        //do_action( "sf_manager_form_notices" );

        if( ! empty( $is_logged_in ) ){

    ?>

        <h3>Jesteś już zalogowany.</h3>
        <?php echo sprintf( '<a href="%s">%s</a>',  wp_logout_url( home_url(), true ), "Wyloguj się" );?>

    <?php

      }else{
      ?>
      <div class="text-center">
        <h1><strong>Zaloguj się i sprawdź siebie</strong></h1>
        <p>Wpisz dane logowania, aby sprawdzić swoją aktywność oraz zarządzać profilem.</p>
      </div>
      <div style="background: #000 url(<?php echo get_home_url() . '/wp-content/themes/bard/assets/images/test.jpg'; ?>) right bottom no-repeat;">
      <div style="margin-left:auto;margin-right:auto;padding:100px;max-width:650px;color:#fff;border-bottom:1px solid #ccc;border-radius:10px;">
        <div>
            <?php echo $form; ?>
        </div>
      </div>
      </div>
      <?php
      }
    ?>

</div>
