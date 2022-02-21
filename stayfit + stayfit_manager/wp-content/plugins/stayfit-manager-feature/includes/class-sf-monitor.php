<?php

Class Sf_Monitor{

	private $user;

	public function __construct( Sf_User $user ){

		if( ! is_object( $user ) || empty( $user ) ){
			return;
		}

		$this->user = $user;

	}

	private function get_user(){

		// $users = array();

		// for( $x = 0; $x < count( $this->public_ids ); $x++ ){
		// 	$user = new Sf_User($this->public_ids[$x]);
		// 	// $user_query = new WP_User_Query(
		// 	// 	array("meta_query" => array(
		// 	// 		"relation" => "OR",
		// 	// 			array(
		// 	// 				'number' => 1,
		// 	// 				'key' => 'public_id',
		// 	// 				'value' => $this->public_ids[$x],
		// 	// 				'fields' => array( 'ID', 'user_registered' ),
		// 	// 				'compare' => '='
		// 	// 			),
		// 	// 			array(
		// 	// 				'number' => 1,
		// 	// 				'key' => 'card_number',
		// 	// 				'value' => $this->public_ids[$x],
		// 	// 				'fields' => array( 'ID', 'user_registered' ),
		// 	// 				'compare' => '='
		// 	// 			)
		// 	// 	))
		// 	// );			
		// 	if( false === $user->notFound() ){
		// 		$users[] = $user->get();
		// 	}
		// }

		// return $users;

	}

	public function raport(){
		return $this->user->monitor();
	}

	public function add( $args = array() ){

		$monitor_data = array(
			"error_msg" 	=> false,
			"error_code" 	=> "success",
			"msg" 		=> '',
			"current_entries" => 0,
			"time" 		=> array(
				"minutes" => 0,
				"seconds" => 0,
			),
			"date"		=> "", // w razie ustawienia ręcznie daty w programie
		);

		    // update_user_meta( "22", "user_monitor", array(
      //           "01" => array(), "02" => array(),
      //           "03" => array(), "04" => array(),
      //           "05" => array(), "06" => array(),
      //           "07" => array(), "08" => array(),
      //           "09" => array(), "10" => array(),
      //           "11" => array(), "12" => array(),
      //           "last" => null
      //       ));
		

			$data = $this->user->monitor()[0];
			$card = $this->user->card();

			$first_name = $this->user->firstname();
			$last_name = $this->user->lastname();

			$arg_date = '';
			foreach ($args as $month => $date) {
				$data[$month][] = $date;
				$arg_date = $date;
			}

			$monitor_data["date"] = $arg_date;
			$monitor_data["first_name"] = $first_name;
			$monitor_data["last_name"] = $last_name;

			if( $data["last"] !== null ){

				// Ważność karnetu
				if( $this->card_expired( $card["expires"], date( "Y-m-d", strtotime( $arg_date )) )->error === true ){
					
					$monitor_data["error_code"] = 901;
					$monitor_data["error_msg"] = "expired";
					// $monitor_data["time"] = array(
					// 	"expires" => $card["expires"],
					// 	"buy_date" => $card["buy_date"],
					// );
					// $monitor_data["max_entries"] = $card["max_entries"];
					$monitor_data["current_entries"] = $card["current_entries"];
					$monitor_data["msg"] = sprintf( '%s %s upłynął termin ważności karnetu %s. Data zakupu %s. Akcja anulowana. ( %s )', $first_name, $last_name, $card["expires"], $card["buy_date"], $arg_date );

					$this->save_raport( $arg_date, $monitor_data['msg'], 'error' );
					return $monitor_data;
				}	

				// Ilość wejść
				if( $card["max_entries"] <= $card["current_entries"] ){
					$monitor_data["error_code"] = 902;
					$monitor_data["error_msg"] = "maximum";				
					// $monitor_data["max_entries"] = $card["max_entries"];
					$monitor_data["current_entries"] = $card["current_entries"];

					$monitor_data["msg"] = sprintf( '%s %s wykorzystał/a maksymalną ilość wejść. Akcja anulowana. ( %s )', $first_name, $last_name, $arg_date );

					$this->save_raport( $arg_date, $monitor_data['msg'], 'error' );
					return $monitor_data;
				}

				// Zabeczpieczenie przed doublowaniem akcji
				$time_interval = $this->time_interval( $data["last"] );
				if( $time_interval->error && ! empty( $time_interval->msg ) ){
					
					$monitor_data["error_code"] = 903;
					$monitor_data["error_msg"] = "blocked";
					$monitor_data["time"]["minutes"] = floor($time_interval->minutes);
					$monitor_data["time"]["seconds"] = $time_interval->seconds;
					// $monitor_data["max_entries"] = $card["max_entries"];
					 $monitor_data["current_entries"] = $card["current_entries"];
					$monitor_data["msg"] = str_replace( '@ID', $first_name . ' ' . $last_name, $time_interval->msg );

					return $monitor_data;
				}
			}

			$data['last'] = $arg_date;
			$current_entries = $card["current_entries"] + 1;

			$card["max_entries"] = $card["max_entries"];
			$card["current_entries"] = $current_entries;
			$card["buy_date"] = $card["buy_date"];
			$card["expires"] = $card["expires"];

			$this->user->update(array(
				"user_monitor" 	=> $data,
				"card" 			=> $card
			));

			$monitor_data['msg'] = sprintf( 
				"\"%s %s\" zarejestrowano akcję. ( %s ) ",
				$first_name,
				$last_name,
				$arg_date
			);

			//$monitor_data["max_entries"] = $card["max_entries"];
			$monitor_data["current_entries"] = $current_entries;

			$this->save_raport( $arg_date, $monitor_data['msg'], 'entry' );
			return $monitor_data;
	}

	private function save_raport( $arg_date, $message = '', $type = '' ){

		$post_args = array(
			'post_type'        => 'monitor_stats',
			'post_status'      => 'publish',
		);
		$raports_post = get_posts( $post_args );
		$ID = $raports_post[0]->ID;

		$raports_meta = get_post_meta( $ID, 'monitor_stats' );

		$raport_key = date( "d-m-Y", strtotime( $arg_date ) );
		if( array_key_exists( $raport_key , $raports_meta[0] ) ){
			$raports = $raports_meta[0][$raport_key];
			$raports[] = array(
				"msg" => $message,
				"type" => $type
			);	
		}else{
			$raports = $raports_meta[0][$raport_key];
			$raports[0] = array(
				"msg" => $message,
				"type" => $type
			);
		}

		$raports_meta[0][$raport_key] = $raports;
		update_post_meta( $ID, "monitor_stats", $raports_meta[0] );

	}

	private function card_expired( $expires, $register_date ){

		$czas_zarejestrowania_akcji = strtotime( $register_date );
	  	$czas_wygasniescia = strtotime( $expires );

	  	$card_data = (object) array(
	  		"error" => false,
	  	);

	  	$okres_waznosci = ( $czas_wygasniescia - $czas_zarejestrowania_akcji );

	  	if( $okres_waznosci < 0 ){
		  	$card_data = (object) array(
		  		"error" => true,
		  	);
	  	}

	  	return $card_data;

	}

	private function time_interval( $old_date ){

		$czas_jeden = strtotime( $old_date );
	  	$czas_dwa = strtotime(date("Y-m-d H:i:s"));

	  	// Minuty * @sekund
	  	$czas_limit = 2 * 60;

	  	$interval = $czas_dwa - $czas_jeden;

	  	$czas_oczekiwania = array(
	  		"text" => "minut",
	  		"minutes" => ( ( $czas_limit - $interval ) / 60),
	  		"seconds" => ( ( 60 * ceil( ( $interval / 60 ) ) ) - $interval )
	  	);


	  	$time_data = (object) array(
	  		"error" => false,
	  		"msg" => '',
	  		"minutes" => $czas_oczekiwania["minutes"],
	  		"seconds" => $czas_oczekiwania["seconds"],
	  	);

	  	if( $interval <= $czas_limit ){
	  		$time_data->error = true;
	  		$time_data->msg = sprintf( 
	  			'"@ID" już zostało zarejestrowane %s. Proszę odczekać %d minut %d sekund', 
	  			$old_date, 
	  			$czas_oczekiwania["minutes"], 
	  			$czas_oczekiwania["seconds"] 
	  		);
	  	}

	  	return $time_data;

	}

}