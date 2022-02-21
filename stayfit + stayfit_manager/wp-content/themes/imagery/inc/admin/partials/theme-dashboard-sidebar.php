<?php

/**
 * This file is used to markup the sidebar on the dashboard page.
 * @package Imagery
 */

// Links that are used on this page.
$sidebar_links = array(
    'premium' => 'http://dinevthemes.com/themes/imagery-pro/',
    'demo' => 'http://demos.dinevthemes.com/imagery/',
);

?>

<div class="tab-section">
    <h4 class="section-title"><?php esc_html_e( 'Demo Site', 'imagery' ); ?></h4>

    <p><?php esc_html_e( 'You can look at this theme on the live demo.', 'imagery' ); ?></p>

    <p>
    <?php
        // Display link to the Demo.
        printf( '<a href="%1$s"  class="button" target="_blank">%2$s</a>', esc_url( $sidebar_links['demo'] ), esc_html__( 'View Live Demo', 'imagery' ) );
    ?>
    </p>
</div><!-- .tab-section -->
<div class="tab-section">
    <h4 class="section-title"><?php esc_html_e( 'Imagery Pro', 'imagery' ); ?></h4>

    <p><?php esc_html_e( 'Get more features and one-on-one support with the premium version of this theme.', 'imagery' ); ?></p>

    <p>
    <?php
        // Display link to the Premium.
        printf( '<a href="%1$s"  class="button button-primary" target="_blank">%2$s</a>', esc_url( $sidebar_links['premium'] ), esc_html__( 'Get Premium', 'imagery' ) );
    ?>
    </p>
</div><!-- .tab-section -->
