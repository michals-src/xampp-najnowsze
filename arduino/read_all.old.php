<?php
 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


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
$type = $properties["type"];
$type_settings = json_decode($properties["type_settings"]);
$time_settings = json_decode($properties["time_settings"]);

$response["data"]["availability"] = $availability;
$response["data"]["type"] = $type;
$response["data"]["type_settings"] = $type_settings;




 
// Include data base connect class
// $filepath = realpath (dirname(__FILE__));
// require_once($filepath."/db_connect.php");
 // Connecting to database
// $db = new DB_CONNECT();
 
// Check if we got the field from the user


    
    $start_time = date("Y-m-d H:i:s", strtotime($time_settings[0]) );
    $full_time = date("Y-m-d H:i:s", strtotime($time_settings[1]) );
    $off_time = date("Y-m-d H:i:s", strtotime($time_settings[2]) );

    $current_time = date("Y-m-d H:i:s");

    if( ( strtotime($current_time) - strtotime($off_time) ) < 0 && ( strtotime($current_time) - strtotime($start_time) ) > 0 ){
        //Rozpoczęcie ten sam dzień
        
        if( ( strtotime($current_time) - strtotime($full_time) ) > 0 ){
            $response["data"]["time_status"] = 2;

        }else{
            $response["data"]["time_status"] = 1;
        }
               
    }

    if( ( strtotime($current_time) - strtotime($off_time) ) < 0 && ( strtotime($current_time) - strtotime($start_time) ) < 0 ){

        if( strtotime($full_time) - strtotime($start_time) < 0 &&  strtotime($full_time) - strtotime($current_time) < 0 ){
            //Trwanie ten przejście godziny 00:00
            $response["data"]["time_status"] = 2;
        }elseif( strtotime($full_time) - strtotime($start_time) > 0 &&  strtotime($full_time) - strtotime($current_time) > 0 ){
            //Aktywne przed 00:00
            $response["data"]["time_status"] = 2;
        }else{
            $response["data"]["time_status"] = 1;
        }
        //Trwanie ten przejście godziny 00:00
    }
    
    if( ( strtotime($current_time) - strtotime($off_time) ) > 0 && ( strtotime($current_time) - strtotime($start_time) ) < 0 ){
         $response["data"]["time_status"] = 0;
        //Wyłączenie przejście godziny 00:00
    }
    
    if( ( strtotime($current_time) - strtotime($off_time) ) > 0 && ( strtotime($current_time) - strtotime($start_time) ) > 0 ){
        $response["data"]["time_status"] = 0;
        //Wyłączenie ten sam dzień
    }





    // echoing JSON response
    echo json_encode($response);

?>