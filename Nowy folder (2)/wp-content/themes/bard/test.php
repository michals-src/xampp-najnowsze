<?php
/**
* Template Name: JSON API
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

/*


POST
 /api/?v=1
 REQUEST
  - access key @type string
  - card number @type integer
   --> Check and register --> send response
 RESPONSE
 @type {json}
  - First & Last name @type string
  - Success or not @type integer
  - Date @type string
  - Number of entries (n/m) @type string

*/

header("Content-type: application/json; charset=utf-8;");


$get_data = $_GET;
$get_post = $_POST;

if( empty( $get_data ) || empty( $get_post ) ){
	return;
}

$access_key = $get_post["access_key"];
$api = new Sf_Api( $access_key );

if( ! array_key_exists("v", $get_data) || ! $api->get_access() || $_SERVER["REQUEST_METHOD"] !== "POST" ){
	//wp_redirect( home_url() );
	//exit;
	return;
}

$card_number = ( ! empty( $get_post["card_number"] ) ) ?: 0;
$response = $api->request( $get_post["card_number"] );

echo json_encode( $response );

//echo hash( "sha256", "PtakiLatajaKluczem" );
//echo 'Code is a poetry.';