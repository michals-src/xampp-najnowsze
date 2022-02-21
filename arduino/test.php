<?php


$off_time = date("01:55:00");
$start_time = date("00:40:00");
$full_time = date("00:57:00");
$current_time = date("H:i:s");

if( ( strtotime($current_time) - strtotime($off_time) ) < 0 && ( strtotime($current_time) - strtotime($start_time) ) > 0 ){
	
	if( ( strtotime($current_time) - strtotime($full_time) ) > 0 ){
		echo 'Włączone 2';
		return;
	}
	echo 'Włączone 1';
}else{
	echo 'Wyłączone';
}
