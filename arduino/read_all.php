<?php
 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

date_default_timezone_set('Europe/Warsaw');

require_once 'db.class.php';

if( ! class_exists("dbh") ){
    echo "<h2>Błąd ładowania<0></h2>";
    return;
}

$db = new dbh();
$dbh = $db->getConnection();
$response = array(
    "success" => true,
    "data"  => array()
);

if( $db->Exception() === true ){
    $response["success"] = false;
    echo json_encode($response);
    return;
}

$data = $dbh->query("SELECT * FROM oswietlenie");

$properties = $data->fetch();
$availability = $properties["availability"];
$mode = $properties["mode"];
$type_settings = $properties["color_settings"];
$time_settings = json_decode($properties["time_settings"]);


$response["data"]["availability"] = $availability;
$response["data"]["mode"] = $mode;
$response["data"]["color"] = $type_settings;

$start_time = date("Y-m-d H:i:s", $properties["time"] );

if( empty($start_time) ){
    $start_time = date("Y-m-d H:i:s", strtotime($time_settings[0]) );
    $query = "UPDATE `oswietlenie` SET `time`=?";
    $create = $dbh->prepare( $query );
    $create->execute(array(
        strtotime($start_time)
    ));
}

//$full_time = date("Y-m-d H:i:s", strtotime($start_time + ($time_settings[1] - $start_time)) );

$delta = 0;

if( $time_settings[1] > $time_settings[0] ){
    $delta = (strtotime($time_settings[1]) - strtotime($time_settings[0]));
}else if( $time_settings[1] <= $time_settings[0] ){
    $delta = (86400 - (( strtotime($time_settings[0]) - strtotime($time_settings[1]) )));
}


$current_time = strtotime( date("Y-m-d H:i:s") );
$off_time = strtotime( date("Y-m-d H:i:s", strtotime("+".$delta." seconds", strtotime( $start_time )) ) );

if( ( $current_time - $off_time ) < 0 && ( $current_time - strtotime( $start_time ) ) >= 0 ){
    $response["data"]["time_status"] = 1;
}

if( ( $current_time - $off_time ) >= 0 && ( $current_time - strtotime( $start_time ) ) > 0 )
{
    //$start_time = date("Y-m-d H:i:s", strtotime("+1 days" . $start_time) );
    
    if( $time_settings[1] > $time_settings[0] ){
        $delta = (strtotime($time_settings[1]) - strtotime($time_settings[0]));
    }else if( $time_settings[1] <= $time_settings[0] ){
        $delta = (86400 - (( strtotime($time_settings[0]) - strtotime($time_settings[1]) )));
    }


    $off_time = strtotime( date("Y-m-d H:i:s", strtotime("+".$delta." seconds", strtotime( $start_time )) ) );
    $query = "UPDATE `oswietlenie` SET `time`=?";
    $create = $dbh->prepare( $query );
    $create->execute(array(
        strtotime($start_time)
    ));
    $response["data"]["time_status"] = 0;
}

if( ( $current_time - $off_time ) < 0 && ( $current_time - strtotime( $start_time ) ) < 0 ){
    $response["data"]["time_status"] = 0;
}

$response["start_time"] = date("Y-m-d H:i:s", strtotime( $start_time ) );
$response["delta"] = $delta;
$response["test"] = $current_time - strtotime( $start_time );
$response["off"] =  date("Y-m-d H:i:s", $off_time );

echo json_encode($response);

?>