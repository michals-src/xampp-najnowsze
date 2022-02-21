<?php

Class Sf_User{

	
	private $data = array(
		'id'				=> -1,
		'first_name' 		=> '',
		'last_name'			=> '',
		'phone'				=> 0,
		'user_email'		=> '',
		'date_registered' 	=> null,
		'user_login'		=> '',
		'card_id'			=> -1,
		// 'card_buy_date' => null,
		// 'card_expires_date' => null,
		// 'card_max_exntries' => null,
		// 'card_current_entries' => null,
		// 'card_buy_date' => null,
	);

	private $__first_name;
	private $__last_name;
	private $__phone;
	private $__email;
	private $__registered;
	private $__login;
	private $__monitor;

	private $__cardBuy;
	private $__cardExpires;
	private $__cardLimit;
	private $__cardNo;
	private $__cardId;

	private $__publicId;
	private $__ID;

	protected $post_type = "user_card";

	/**
	 * Sf_Card errors
	 * 0 - OK
	 * 1 - Not found
	 * 2 - username already exists
	 * 3 - email already exists
	 * @var object
	 */
	private $error;

	public function __construct( $data = -1 ){

		// $error_message = (object) array(
		// 	"notfound" => "Nie znaleziono użytkownika",
		// 	"user_exists" => "Użytkownik o takiej nazwie już istnieje",
		// 	"email_exists" => "Podany adres email jest już zarejestrowany"
		// );

		if( $data < 0 ){
			return;
		}

		if( $data instanceof Sf_User )
		{
			$this->set_id( $data->get_id() );
			$this->read_object_from_db( 'id' );
			return;
		}

		$this->error = array( 
			'code'		=> 0,
			'messages'	=> array(
				"Nie znaleziono użytkownika",
				"Użytkownik o takiej nazwie już istnieje"
			)
		);

		// Czytanie karty za pomocą post_id lub klucza karty zapisany w jej pamięci
		if( ! empty( $data ) ){
			if( is_int( $data ) ){
				$this->set_id( $data );
				$search = "id";
			}else if( is_string( $data ) ){
				$this->set_user_email( $data );
				$search = "user_email";
			}
			$this->read_user_from_db( $search );
		}else{
			$this->error['code'] = 1;
			return;
		}

		// if( ! empty( $ID ) && $ID !== null ){
		// 	$this->user_before( $ID );
		// }

	}

	private function get_user_by( $search ){

		$user_results = array();
		switch( $search ){
			case 'id':
				$user_results = get_user_by( 'id', $this->get_id() );
			  break;
			case 'user_email':
				$user_results = get_user_by( 'email', $this->get_user_email() );
			  break;
		}

		return $user_results;

	}

	protected function read_user_from_db( $search_by ){

		$user = $this->get_user_by( $search_by );
		$result = $user->data;

		if( empty( $result ) ){
			$this->error['code'] = 1;
			return;
		}

		if( ! $this->get_id() ){
			$this->set_id( $result->ID );
		}else if( ! $this->get_user_email() ){
			$this->set_user_email( $result->email );
		}

		foreach( $this->data as $field => $value ){
			$wp_post_name_translated = str_replace( 
				array('id', 'date_registered'), 
				array('ID', 'user_registered'), 
				$field 
			);

			if( in_array( $field, array('id', 'user_login', 'user_email', 'date_registered') ) ){
				$value = $result->$wp_post_name_translated;
			}else{
				$value = get_user_meta( $this->get_id(), $field )[0];
			}
			
			if( ! empty( $value ) ){
				$this->{'set_' . $field}( $value );
			}
		}

	}

	public function set_id( $data ){
		$this->data['id'] = $data;
	}

	public function set_user_email( $data ){
		$this->data['user_email'] = $data;
	}

	public function set_first_name( $data ){
		$this->data['first_name'] = $data;
	}
	
	public function set_last_name( $data ){
		$this->data['last_name'] = $data;
	}
	
	public function set_phone( $data ){
		$this->data['phone'] = $data;
	}
	
	public function set_date_registered( $data ){
		$this->data['date_registered'] = $data;
	}
	
	public function set_user_login( $data ){
		$this->data['user_login'] = $data;
	}
	
	public function set_card_id( $data ){
		$this->data['card_id'] = $data;
	}

	public function get_id(){
		return $this->data['id'];
	}

	public function get_user_email(){
		return $this->data['user_email'];
	}

	public function get_first_name(){
		return $this->data['first_name'];
	}
	
	public function get_last_name(){
		return $this->data['last_name'];
	}
	
	public function get_phone(){
		return $this->data['phone'];
	}
	
	public function get_date_registered(){
		return $this->data['date_registered'];
	}
	
	public function get_user_login(){
		return $this->data['user_login'];
	}
	
	public function get_card_id(){
		return $this->data['card_id'];
	}

	// private function user_before( $id ){

 //        $user_query = get_user_by( 'id', $id );
 //        $user = $user_query->data;

 //        if( empty( $user ) ){
 //        	$this->error_code = 1;
 //            return;
 //        }

 //        $this->__ID  		= $user->ID;
 //        $this->__publicId  	= get_user_meta( $user->ID, 'public_id' )[0];
 //        $this->__login  	= $user->user_login;
 //        $this->__email  	= $user->user_email;
 //        $this->__registered	= $user->user_registered;
 //        $this->__first_name 	= get_user_meta( $user->ID, 'first_name' )[0];
 //        $this->__last_name 	= get_user_meta( $user->ID, 'last_name' )[0];
 //        $this->__phone 		= get_user_meta( $user->ID, 'phone' )[0];
 //        $this->__cardId 	= get_user_meta( $user->ID, 'card_number' )[0];
        
 //        $user_card 			= get_user_meta( $user->ID, 'card' );
 //        $this->__cardLimit 	= ( ! empty( $user_card ) ) ? $user_card[0]["max_entries"] : "0";
 //        $this->__cardNo 	= ( ! empty( $user_card ) ) ? $user_card[0]["current_entries"] : "0";
 //        $this->__cardBuy	= ( ! empty( $user_card ) ) ? $user_card[0]["buy_date"] : date('Y-m-d');
 //        $this->__cardExpires = ( ! empty( $user_card ) ) ? $user_card[0]["expires"] : date('Y-m-d', strtotime("+1 month"));

 //        $this->__monitor 	= get_user_meta( $user->ID, 'user_monitor' );

	// }

	public function get(){
		$details = array(
			"ID" => $this->get_id(),
			"publicID" => $this->publicID(),
			"first_name" => $this->first_name(),
			"last_name" => $this->last_name(),
			"phone" => $this->phone(),
			"email" => $this->email(),
			"registered" => $this->registered(),
			"login_name" => $this->login_name(),
			"card" => $this->card(),
			"monitor" => $this->monitor(),
		);

		return $details;
	}

	public function first_name(){
		return $this->__first_name;
	}
	public function last_name(){
		return $this->__last_name;
	}
	public function phone(){
		return $this->__phone;
	}
	public function email(){
		return $this->__email;
	}
	public function registered(){
		return $this->__registered;
	}
	public function login_name(){
		return $this->__login;
	}
	public function card(){

		$details = array(
			"buy_date" => $this->__cardBuy,
			"expires" => $this->__cardExpires,
			"max_entries" => $this->__cardLimit,
			"current_entries" => $this->__cardNo,
			"card_number" => $this->__cardId,
		);

		return $details;
	}
	public function monitor(){
		return $this->__monitor;
	}
	public function publicID(){
		return $this->__publicId;
	}
	public function ID(){
		return $this->__ID;
	}

	/**
	 * depreaced 1.0.1
	 * @var WP_User ID
	 * @return (int) public id
	 */
	private function generatePublicID( $ID = 0 ){
		return (150000 + $ID  + ( ( ( $ID * 2 ) * 2 ) / 2 ));
	}








	public function get_error_msg(){
		if( $this->error['code'] <= count( $this->error['messages'] ) && $this->error['code'] > 1 ){
			return $this->error['messages'][ ( $this->error['code'] - 1 ) ];
		}
		return 'Wystąpił nieoczekiwany błąd';
	}

	public function not_found(){
		return $this->get_error_code( 1 );
	}

	private function get_error_code( $code = 0 ){
		return ($this->error['code'] === $code) ? true : false;
	}






	public function create( $user_login, $user_pass, $user_email, $user_meta ){

		if( false === $this->not_found() ){
            return;
		}

	    $user_id = wp_create_user( 
	    	$user_login, 
	    	$user_pass, 
	    	$user_email 
	    );

	    if( is_wp_error( $user_id ) ){
	    	return;
	    }

	    $user_meta_values = array(
	    	"first_name" 	=> $user_meta["first_name"],
	    	"last_name" 	=> $user_meta["last_name"],
	    	"phone" 		=> $user_meta["phone"],
	    	// "public_id" 	=> $user_public_id,
	    	// "card_number" 	=> $user_meta["card_number"],
	    	// "card" 			=> array(
		    //     "max_entries" => $user_meta["card"]["max_entries"],
		    //     "current_entries" => 0,
		    //     "buy_date" 	=> $user_meta["card"]["buy_date"],
		    //     "expires" 	=> $user_meta["card"]["expires"],
		    // ),
	    	// "user_monitor" 	=> array(
		    //     "01" => array(), "02" => array(),
		    //     "03" => array(), "04" => array(),
		    //     "05" => array(), "06" => array(),
		    //     "07" => array(), "08" => array(),
		    //     "09" => array(), "10" => array(),
		    //     "11" => array(), "12" => array(), 
		    //     "last" => null
		    // )
	    );

	    $this->set_id( $user_id );
	    $this->update( $user_meta_values );

	    return $this;

	}


	public function update( $fields = array() ){

		if( empty( $fields ) ){
			return;
		}

		$intersect = array_intersect( array( 'user_login', 'user_email'), array_keys( $fields ) );

		if( ! empty( $intersect ) ){
			$user_data = array(
		    	'user_login'		=> ! empty( $fields['user_login'] ) ? $fields['user_login'] : $this->get_user_login(),
		    	'user_email'		=> ! empty( $fields['user_email'] ) ? $fields['user_email'] : $this->get_user_email(),
			);
			
			wp_update_user( array_merge( array( 'ID' => $this->get_id() ), $user_data ) );
		}

		$this->update_user_meta( $fields );
		$this->apply_changes( $fields );

	}

	public function update_user_meta( $fields ){
		
		if( empty( $fields ) ){
			return;
		}

		$valid_fields = array( "first_name", "last_name", "phone", 'card_id',
			// "card_number", "card", "user_monitor", "public_id"
		);

		foreach( $fields as $field => $value ){
			if( in_array( $field, $valid_fields )){
				update_user_meta( $this->get_id(), $field, $value );
			}
		}

	}

	protected function apply_changes( $new_data ){
		$this->data = array_replace( $this->data, $new_data );
	}

	public function delete(){

		include_once(ABSPATH.'wp-admin/includes/user.php' );

		$meta = get_user_meta( $this->get_id() );
		foreach( $meta as $key => $value ){
			delete_user_meta( $this->get_id(), $key );
		}

		return wp_delete_user( $this->get_id() );
	}

	private function existsBy( $field = "", $value = "" ){
		
		$result = false;
		
		switch( $field ){
			case "user_login":

				$user_login_exists = username_exists( $value );
				if( ! empty( $user_login_exists ) ){
					$result = true;
					$this->error_code = 2;
				}

				break;
			case "user_email":

				$user_email_exists = email_exists( $value );
				if( ! empty( $user_email_exists ) ){
					if( $user_email_exists !== $this->get_id() ){
						$result = true;
						$this->error_code = 3;
					}
				}

				break;
			// case "card_number":

			// 	$user_card_exists  = new Sf_User( $value );

			// 	if( $user_card_exists->notFound() === false ){
			// 		if( $value !== $this->card()["card_number"] ){
			//             $result = true;
			//            	$this->error_code = 4;
			// 		}
			// 	}

			// 	break;
		}

		return $result;

	}

}