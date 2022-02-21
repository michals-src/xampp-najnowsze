<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

date_default_timezone_set('Europe/Warsaw');

$switch = $_GET["switch"];

// $new_availability = $_POST["availability"];
//         $new_type = $_POST["type"];
//         $new_type_settings = $_POST["type_settings"];
//         $new_time_settings = $_POST["time_settings"];

//         if( ! empty( $new_type_settings[0][0] ) && 
//             ! empty( $new_type_settings[0][1] ) && 
//             ! empty( $new_type_settings[0][2] ) && 
//             ! empty( $new_type_settings[1][0] ) && 
//             ! empty( $new_time_settings[0] ) && 
//             ! empty( $new_time_settings[1] ) && 
//             ! empty( $new_time_settings[2] ) ){

//             //echo 'abc';

//             $new_type_settings_rgb = array();
//             $new_type_settings_rgb[0][0] = hex2rgb($new_type_settings[0][0]);
//             $new_type_settings_rgb[0][1] = hex2rgb($new_type_settings[0][1]);
//             $new_type_settings_rgb[0][2] = hex2rgb($new_type_settings[0][2]);
//             $new_type_settings_rgb[1][0] = hex2rgb($new_type_settings[1][0]);

//             $query = "UPDATE `oswietlenie` SET `availability`=?,`type`=?,`type_settings`=?,`time_settings`=?";
//             $create = $dbh->prepare( $query );
//             $create->execute(array(
//                 $new_availability, 
//                 $new_type, 
//                 json_encode($new_type_settings_rgb),
//                 json_encode($new_time_settings)
//             ));
//         }

$response = array();
$response["success"] = 1;

require_once 'db.class.php';

function get_query( $col ){
    return "UPDATE `oswietlenie` SET `" . $col . "`=?";
}


function hex2rgb( $color ){
    list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
    return "R" . $r . "G" . $g . "B" . $b;
}

function update_availability( $value = "" ){

    if( ! is_numeric( $value ) && is_string( $value ) ){
        $new_availability = ( $value === "true" ) ? 1 : 0;

        $db = new dbh();
        $dbh = $db->getConnection();

        $request = $dbh->prepare( get_query("availability") );
        $request->execute(array(
            $new_availability
        ));
    }

}

function update_mode( $value = "" ){

    if( is_numeric( $value ) && is_string( $value ) ){
        $new_mode = (int) $value;

        $db = new dbh();
        $dbh = $db->getConnection();

        $request = $dbh->prepare( get_query("mode") );
        $request->execute(array(
            $new_mode
        ));
    }

}

function update_color( $value = array() ){

    if( ! empty( $value ) ){

        $db = new dbh();
        $dbh = $db->getConnection();

        $color = $value;

        $request = $dbh->prepare( get_query("color_settings") );
        $request->execute(array(
            $color
        ));
    }

}
function update_time( $value = array() ){

    if( ! empty( $value[0] ) && ! empty( $value[1] ) ){
        $db = new dbh();
        $dbh = $db->getConnection();

        $time = array();
        $time[0] = $value[0];
        $time[1] = $value[1];

        $request = $dbh->prepare( get_query("time_settings") );
        $request->execute(array(
            json_encode( $time )
        ));

        $time_refresh = $dbh->prepare( get_query("time") );
        $time_refresh->execute(array(
            strtotime( date("Y-m-d H:i:s", strtotime($time[0]) ) )
        ));  

    }

}

switch( $switch ){

    case "availability":
        $val = $_GET["value"];
        update_availability( $val );
        break;

    case "mode":
        $val = $_GET["value"];
        update_mode( $val );
        break;


    case "colors":
        $val = ( isset( $_GET["color"] ) ) ? $_GET["color"] : "";
        update_color( $val );
        break;

    case "time":
        $val = array();
        $val[0] = ( isset( $_GET["time0"] ) ) ? $_GET["time0"] : "";
        $val[1] = ( isset( $_GET["time1"] ) ) ? $_GET["time1"] : "";
        update_time( $val );
        break;
    
    default:
        $response["success"] = 1;
        break;

}

echo json_encode( $response );

?>