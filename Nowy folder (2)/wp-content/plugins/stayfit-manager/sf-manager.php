<?php
/**
 * Plugin Name: Stay Fit Manager
 * Version: 1.0.1
 * Description: Zawiera stronę logowania oraz panel administracyjny. Zarządza cennikiem, grafikiem, zajęciami, oraz podstawowymi wartościami strony.
 * Author: Michał Sierzputowski
 * 
 * @package stayfit-manager
 * 
*/
define( 'WP_DEBUG', true );
if( ! defined("ABSPATH") ){
    exit;
}

if( ! defined( "SF_MANAGER_FILE" ) ){
    define( "SF_MANAGER_FILE", __FILE__ );
}

if( ! class_exists( "Sf_Manager" ) ){
    require_once dirname( SF_MANAGER_FILE ) . '/includes/class-sf-manager.php';
}

function sfm(){
    return Sf_Manager::instance();
}

sfm();