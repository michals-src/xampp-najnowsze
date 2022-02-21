<?php

/**
 * Card -> toUse
 * Karta tworzona podczas rejestracji klienta
 * jako oddzielny objekt, który jest poprzez meta_data
 * przypisywany do konkretnego klienta
 *
 * Zmiana numeru karty podczas edycji danych klienta
 * odpina przypisanie karty do klienta i przypisuje
 * nową kartę ( jeżeli nie ma, tworzy objekt (post))
 *
 * Pokazywanie ile kart jest przypiętych/nieprzypiętych
 * Edycja karty
 * - usuń, nadaj nazwę
 * 
 * Historia karty
 * - we/wy klienta
 * przypisani klienci
 */



class Sf_Card{

	
	protected $data = array(
		'id' 				=> null,
		'key' 				=> '',
		'assigned_to' 		=> null,
		'status' 			=> '',
		'date_buy' 			=> null,
		'date_expires' 		=> null,
		'date_last_entry' 	=> null,
		'entry_maximum' 	=> 0,
		'entry_current' 	=> 0,
		'used_when'			=> array(),
		// 'used_by'			=> array(),
	);

	protected $post_type = "user_card";

	/**
	 * Sf_Card errors
	 * 0 - OK
	 * 1 - Not found
	 * 2 - Already assigned
	 * @var object
	 */
	private $error;

	public function __construct( $data = -1 ){

		if( $data < 0 ){
			return;
		}

		if( $data instanceof Sf_Card )
		{
			$this->set_id( $data->get_id() );
			$this->read_object_from_db( 'id' );
			return;
		}

		$this->error = array( 
			'code'		=> 0,
			'messages'	=> array(
				"Nie znaleziono karnetu",
				"Karnet jest już przypisany"
			)
		);

		// Czytanie karty za pomocą post_id lub klucza karty zapisany w jej pamięci
		if( ! empty( $data ) ){
			if( is_int( $data ) && $this->post_type === get_post_type( $data ) ){
				$this->set_id( $data );
				$search = "id";
			}else if( is_string( $data ) ){
				$this->set_key( $data );
				$search = "key";
			}
			$this->read_object_from_db( $search );
		}else{
			$this->error['code'] = 1;
		}
	}

	protected function id_verification( $id ){
		if( ! empty( $id ) && is_string( $id ) ){
			return true;
		}
		return false;
	}

	public function get_error_msg(){
		return $this->error['messages'][ ( $this->error->code - 1 ) ];
	}

	public function not_found(){
		return $this->get_error_code( 1 );
	}

	private function get_error_code( $code = 0 ){
		return ( $this->error['code'] === $code ) ? true : false;
	}

	public function get_id(){
		return $this->data["id"];
	}

	public function get_key(){
		return $this->data["key"];
	}

	public function get_status(){
		return $this->data["status"];
	}

	public function get_assigned_to(){
		return $this->data["assigned_to"];
	}

	public function get_date_buy(){
		return $this->data["date_buy"];
	}

	public function get_date_last_entry(){
		return $this->data["date_last_entry"];
	}

	public function get_date_expires(){
		return $this->data["date_expires"];
	}

	public function get_entry_maximum(){
		return $this->data["entry_maximum"];
	}

	public function get_entry_current(){
		return $this->data["entry_current"];
	}

	public function get_used_when(){
		return $this->data["used_when"];
	}

	// public function get_used_by(){
	// 	return $this->data["used_by"];
	// }

	public function set_id( $data ){
		$this->data["id"] = $data;
	}

	public function set_key( $data ){
		$this->data["key"] = $data;
	}

	public function set_status( $data ){
		$this->data["status"] = $data;
	}

	public function set_assigned_to( $data ){
		$this->data["assigned_to"] = $data;
	}

	public function set_date_buy( $data ){
		$this->data["date_buy"] = $data;
	}

	public function set_date_last_entry( $data ){
		$this->data["date_last_entry"] = $data;
	}

	public function set_date_expires( $data ){
		$this->data["date_expires"] = $data;
	}

	public function set_entry_maximum( $data ){
		$this->data["entry_maximum"] = $data;
	}

	public function set_entry_current( $data ){
		$this->data["entry_current"] = $data;
	}

	public function set_used_when( $data ){
		$this->data["used_when"] = $data;
	}


	/**
	 * Raport zakupu / odnowień dla danego klienta
	 * Dane "imię i nazwisko", data zakupu / odnowienia karnetu "od - do"
	 *
	 * @var Sf_User object
	 */
	// public function set_used_by( $data ){
	// 	$this->data["used_by"] = $data;
	// }

	// protected function add_used_by( $customer, $date_buy, $date_expires ){
	// 	$date_buy1 = date( 'Y-m-d H:i:s', strtotime( $date_buy ) );
	// 	$date_expires1 = date( 'Y-m-d H:i:s', strtotime( $date_expires ) );

 //    	$customer_name = $customer->firstname() . ' ' . $customer->lastname();
 //   		$raport_owner = sprintf( "%s : data zakupu %s, data wygaśnięcia %s", 
 //    	$customer_name, $date_buy1, $date_expires1 );

 //   		$raports = $this->get_used_by();
 //   		$push_raport = array_push( $raports, $raport_owner );

	// 	$this->set_used_by( $push_raport );		
	// }

	protected function add_used_when( $date ){
		if( ! is_array( $date ) ){
			return;
		}

		$raports = $this->get_used_when();
		foreach( $date as $month => $full_date){
			$raports[$month][] = $full_date;
		}
		$this->set_used_when( $raports );

	}

	private function get_card_by( $search ){

		$query = array(
			'post_type'		=> $this->post_type,
			'post_status'	=> 'publish'
		);
		switch( $search ){
			case 'id':
				$query["ID"] = $this->get_id();
			  break;
			case 'key':
				$query["title"] = $this->get_key();
			  break;
		}

		$card = new WP_Query( $query );
		return $card;

	}

	protected function read_object_from_db( $search_by ){

		$card = $this->get_card_by( $search_by );
		$result = $card->get_posts();

		if( empty( $result ) ){
			$this->error['code'] = 1;
			return;
		}

		$customer_card = $result[0];

		if( ! $this->get_id() ){
			$this->set_id( $customer_card->ID );
		}else if( ! $this->get_key() ){
			$this->set_key( $customer_card->post_title );
		}



		// 'id' 				=> null,
		// 'key' 				=> '',
		// 'assigned_to' 		=> null,
		// 'date_buy' 			=> null,
		// 'date_expires' 		=> null,
		// 'date_modified' 	=> null,
		// 'entry_maximum' 	=> 0,
		// 'entry_current' 	=> 0,
		// 'raport_entries'	=> array(),
		// 'raport_owners'		=> array(),

		foreach( $this->data as $field => $value ){
			$wp_post_name_translated = str_replace( 
				array('key', 'status', 'assigned_to', 'date_buy'), 
				array('post_title', 'post_status', 'post_author', 'post_date'), 
				$field 
			);

			if( in_array( $field, array('key', 'assigned_to', 'date_buy', 'status') ) ){
				$value = $customer_card->$wp_post_name_translated;
			}else{
				$value = get_post_meta( $this->get_id(), $field )[0];
			}
			
			if( ! empty( $value ) ){
				$this->{'set_' . $field}( $value );
			}
		}

	}

	// public function assign_to( Sf_User $customer_id, $card_meta ){
	// 	if( ! empty( $this->get_id() ) && ! empty( $this->get_key() ) ){
	// 		//Próba przypisania karnetu, który jest w użyciu
	// 		$this->error['code'] = 2;
	// 	}else{
	// 		//Utworzenie nowego karnetu
	// 		$this->create( $customer_id, $card_meta );
	// 	}
	// 	return $this;
	// }


	public function create( $customer, $card_meta ){

		if( false === $this->not_found() || ! $customer instanceof Sf_User ){
            return;
		}

		$date_buy = date( 'Y-m-d H:i:s', strtotime( $card_meta['date_buy'] ) );
		$date_expires = date( 'Y-m-d H:i:s', strtotime( $card_meta['date_expires'] ) );
		$customer_id = $customer->get_id();

	    $card_id = wp_insert_post(array(
	    	'post_title'		=> $this->get_key(),
	    	'post_content'		=> '',
	    	'post_author'		=> $customer_id,
	    	'post_status'		=> 'publish',
	    	'post_type'			=> $this->post_type,
	    	'post_date'			=> date( 'Y-m-d H:i:s', strtotime( $date_buy ) ),
	    ));

	    for( $x = 0; $x < 12; $x++ ){
	    	$month = $x < 10 ? '0' . ($x + 1) : $x + 1;
	    	$card_meta[ 'used_when' ][ $month ] = array();
	    }

	    $this->set_id( $card_id );
	    $this->set_assigned_to( $customer_id );
	   // $this->add_used_by( $customer, $date_buy, $date_expires );
	    $this->update_meta_data( $card_meta );

	    $customer->update(array(
	    	'card_id'	=> $card_id
	    ));

	    return $this;
	}

	public function update( $fields = array() ){

		if( empty( $fields )) return;

		$intersect = array_intersect( array( 'key', 'date_buy', 'status' ), array_keys( $fields ) );
		$post_meta = $fields;

		if( ! empty( $intersect ) ){
			$post_data = array(
		    	'post_title'		=> ! empty( $fields['key'] ) ? $fields['key'] : $this->get_key(),
		    	'post_author'		=> $this->get_assigned_to(),
		    	'post_status'		=> ! empty( $fields['status'] ) ? $fields['status'] : $this->get_status(),
		    	'post_date'			=> ! empty( $fields['date_buy'] ) ? $fields['date_buy'] : $this->get_date_buy(),
			);
			
			wp_update_post( array_merge( array( 'ID' => $this->get_id() ), $post_data ) );
			foreach( $intersect as $key => $value ){
				unset($post_meta[$key]);
			}
		}

		if( ! empty( $post_meta['used_when'] ) ){
			$this->add_used_when( $post_meta['used_when'] );
			$post_meta['used_when'] = $this->get_used_when();
		}

		//Aktualizacja raportu właścicieli w przypadku, gdy karnet już istneiej
		// i jest do niego przypisywany inny klient, wtedy i tylko wtedy, gdy
		// karnet jest zamrożony (draft)
		//$post_meta['used_by'] = $this->get_used_by();

		$this->update_meta_data( $post_meta );
		$this->apply_changes( $fields );
	}

	protected function update_meta_data( $fields = array() ){
		if( ! $this->get_id() ){
			return;
		}

		foreach( $fields as $field => $value ){
			if( in_array( $field, array( 'date_expires', 'date_last_entry', 'entry_maximum', 'entry_current', 'used_when', 'used_by' ) )){
				
				switch ($field) {
					case 'date_expires':
					case 'date_last_entry':
					case 'entry_maximum':
						$value = ! ( empty( $value ) ) ? $value : 'null';
						break;
					
					case 'date_expires':
					case 'date_last_entry':
					case 'entry_maximum':
						$value = ! ( empty( $value ) ) ? $value : '0';
						break;
				}

				update_post_meta( $this->get_id(), $field, $value );
			}
		}
	}

	protected function apply_changes( $data = array() ){
		$this->data = array_replace_recursive( $this->data, $data );
	}

	public function delete_all(){
		$card_posts = new WP_Query(array( 'post_type' => $this->post_type, 'post_status' => array( 'draft', 'publish' ) ));
		$posts = $card_posts->get_posts();
		foreach( $posts as $post => $props){
			$meta = get_post_meta( $props->ID );
			if( ! empty( $meta ) ){
				foreach( $meta as $key => $value ){
					delete_post_meta( $props->ID, $key );
				}
			}
			wp_delete_post( $props->ID );
		}
	}

	public function delete(){
		require_once(ABSPATH.'wp-admin/includes/user.php' );
		$meta = get_user_meta( $this->ID() );
		if( ! empty( $meta ) ){
			foreach( $meta as $key => $value ){
				delete_user_meta( $this->ID(), $key );
			}
		}
		return wp_delete_user( $this->ID() );
	}


}