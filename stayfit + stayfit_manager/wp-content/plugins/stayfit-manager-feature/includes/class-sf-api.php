<?php

Class Sf_Api{

/**
 * 

@action
   {name} {@int}
	GET 	1
	POST 	2
	UPDATE 	3
	DELETE 	4

@request_method
   {name} {@method}
	GET 	GET
	POST 	POST
	DELETE 	DELETE


GET
  ?query=firstname,lastname,street,phone,email,entries,card
  __user={id}
  access_key={acces_key}
  method={action}
  format={action}

POST
  __user={id}
  firstname={firstname}
  ...
  card={card}
  access_key={acces_key}
  method={action}
  format={action}

UPDATE
  __user={id}
  firstname={firstname}
  ...
  card={card}
  access_key={acces_key}
  method={action}
  format={action}

DELETE
  __user={id}
  firstname={firstname}
  ...
  card={card}
  access_key={acces_key}
  method={action}
  format={action}


 */


	private $__version;
	private $__access_key;
	private $__method;
	private $__format;

	private $client;

	private $__fields;
	private $__user;

	public function __construct( $version = "1.1", $access_key = "", $method = "GET", $format ="json"){

		$this->__version = "1.1";
		$this->__access_key = $access_key;
		$this->__method = $method;
		$this->__format = $format;

		$this->client = (object) array( "user_agent" => null, "request_method" => null, "query_string" => "");
		$this->client->user_agent = $_SERVER["HTTP_USER_AGENT"];
		$this->client->request_method = $_SERVER["REQUEST_METHOD"];
		$this->client->query_string = $_SERVER["QUERY_STRING"];

		/**
		 * Global names of variables
		 * to have access in uri queries
		 */
		$this->__fields = array(
			"publicID", "login_name", "firstname", "lastname", 
			"phone", "email", "card", "monitor", "registered", "card_number"
		);
		$this->validate_version( $version );

	}

	private function validate_version( $version = "" ){
		if( is_string($version) && $version === $this->__version ){
			return true;
		}
		return false;
	}

	public function request(){

		$response_skeleton = array();
		$response_skeleton["error"] = (object) array(
			"message" 	=> "",
			"code" 		=> 0
		);

		if( ! $this->has_access() ){
			$response_skeleton["error"]->message = "Nie uzyskano dostępu. Operacja została odrzucona.";
			$response_skeleton["error"]->code = "401";
			$this->__method = "ABORTION";
		}

		$_GET = array_map(function( $value ){
			return trim(htmlentities( $value, ENT_QUOTES, 'UTF-8'));
		}, $_GET);

		$_POST = array_map(function( $value ){
			return trim(htmlentities( $value, ENT_QUOTES, 'UTF-8'));
		}, $_POST);

		$ID = $_GET['__user'];
		$this->__user = new Sf_User( $ID );

		if( empty( $ID )  ){
			$response_skeleton["error"]->message = "Nie znaleziono użytkownika.";
			$response_skeleton["error"]->code = "404";
			$this->__method = "ABORTION";
		}

		$sensitive_fields = array( "id" );

		switch ($this->__method) {
			case 'GET':
/**
 * array(
	"firstname",
	"lastname",
	"phone",
	"email",
	"card" => [
		"buy","expires","entry_limit","entry_no","number"
	],
 )
 */

 			$response_skeleton = $this->get_method();

				break;
			case 'POST':

				// if( 'POST' === $this->client->request_method ){
				// 	$response_skeleton["error"]->message = "Konflikt metody dostępu.";
				// 	$response_skeleton["error"]->code = "500";
				// 	$this->__method = "ABORTION";
				// 	$this->response = $response_skeleton;
				// 	return;
				// }

				$forbidden_field = array(
					"publicID", 
					"login_name",
					"registered"
				);

				/**
				 * Privates variable
				 * from DB
				 */
				$keys_translates = array(
					"firstname" => "first_name",
					"lastname" 	=> "last_name",
					"email" 	=> "user_email",
				);

 				if( ! empty( $_POST ) ){
 					$user_values = array();
 					$response_fields = array();

 					if( ! empty( $_POST["entry"] ) ){
 						//$entry_date = $_POST["entry"];
 						$entry_date = $_POST["entry"];
 						$monitor = new Sf_Monitor( $this->__user );
				 		$date = date("Y-m-d H:i:s");

				        $month = strtotime( $date );
				        $register_month = date( "m", $month );
 						$user_monitor = $monitor->add( array( $register_month => $date ) );

						$response_skeleton["error"]->message = $user_monitor["error_msg"];
 						$response_skeleton["error"]->code = $user_monitor["error_msg"];

 						$response_skeleton["entry"] = array();
 						$response_skeleton["entry"]["time"] = $user_monitor["time"];
 						$response_skeleton["entry"]["current_entries"] = $user_monitor["current_entries"];
 						$response_skeleton["entry"]["message"] = $user_monitor["msg"];
 						array_push( $response_fields, "card" );

 					}

	 				foreach( $_POST as $field => $value ){
	 					if( is_string( $field ) && in_array( $field, $this->__fields ) )
	 					{
	 						$fname = ( array_key_exists( $field, $keys_translates ) ) ? $keys_translates[$field] : $field;
	 						$user_values[$fname] = $value;
	 						array_push( $response_fields, $field );
	 					}
	 				}

	 				if( ! empty( $user_values ) ){
	 					$this->__user->update( $user_values );
	 					$_GET['query'] = join( ",", $response_fields );
	 					$response_skeleton = array_merge( $this->get_method(), $response_skeleton );
	 				}
	 			}				

				break;
			case 'DELETE':
				# code...
				break;

			default:
				break;
		}

		$this->response = $response_skeleton;

	}

	private function get_method(){
		$response_skeleton = array();
		$query = ( ! empty( $_GET['query'] ) ) ? explode(",", $_GET['query']) : array();
		
		$response_skeleton["firstname"] = $this->__user->firstname();
		$response_skeleton["lastname"] = $this->__user->lastname();
		$response_skeleton["publicID"] = $this->__user->publicID();

		if( ! empty( $query ) ){
			foreach( $query as $field ){
				if( is_string( $field ) && in_array( $field, $this->__fields ) )
				{
					if( method_exists( $this->__user, $field)){
						$response_skeleton[$field] = $this->__user->$field();
					}else{
						$response_skeleton["error"]->message = sprintf(
							"Próba dostępu do nieistniejącej nazwy [%s].",
							$field 
						);
					$response_skeleton["error"]->code = "404";
					$this->__method = "ABORTION";
					break;
					}
					
				}else if($field == "all"){
					$response_skeleton = $this->__user->get();
				}
			}
		}
		return $response_skeleton;
	}

	public function response(){
		return $this->response;
	}

	private function has_access(){
		$stored_acces_key = "5da6ffd62573d3b08762a8e614b6efb19b5351d715fcd398143f73b851dccd8b";
		if( $stored_acces_key !== $this->__access_key ){
			return false;
		}
		return true;
	}

	// public function request( $card_number = 0 ){

	// 	$ID = $card_number;
 //        $date = date("Y-m-d H:i:s");

 //        $month = strtotime( $date );
 //        $register_month = date( "m", $month );

 //        $monitor = new Sf_Monitor( array( $ID ) );
 //        $response = $monitor->add( array( $register_month => $date ) );

 //        return $response;

	// }

}