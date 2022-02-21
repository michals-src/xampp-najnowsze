<?php 

    if( ! defined( "ABSPATH" ) ) exit;

?>
<div style="margin-bottom: 100px;">
    <div class="row">
        <div class="col-10">
            <h3 class="mb-1">Panel administracyjny</h3>
            <h4>Zalogowano jako
            Imię Nazwisko</h4>       
        </div>
        <div class="col-2">
            <div style="text-align:right;">
                <a href="<?php echo wp_logout_url( get_home_url() ); ?>">Wyloguj się</a>
            </div>
        </div>
        <div class="col-12">
            <?php do_action( 'sf_manager_dashboard_nav' ); ?>      
        </div>
    </div>
</div>

<div class=" p-0">
    <?php do_action( "sf_manager_dashboard_content" ); ?>
</div>