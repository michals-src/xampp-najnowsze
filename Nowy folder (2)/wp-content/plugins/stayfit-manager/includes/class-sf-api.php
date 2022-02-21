<?php

Class Sf_Api{

	private $version;
	private $stored_acces_key;
	private $received_acces_key;

	public function __construct( $acces_key = "" ){

		$this->stored_acces_key = "5da6ffd62573d3b08762a8e614b6efb19b5351d715fcd398143f73b851dccd8b";
		$this->received_acces_key = $acces_key;
		$this->version = "1";

	}

	public function get_access(){
		if( $this->stored_acces_key !== $this->received_acces_key ){
			return false;
		}
		return true;
	}

	public function request( $card_number = 0 ){

		$ID = $card_number;
        $date = date("Y-m-d H:i:s");

        $month = strtotime( $date );
        $register_month = date( "m", $month );

        $monitor = new Sf_Monitor( array( $ID ) );
        $response = $monitor->add( array( $register_month => $date ) );

        return $response;

	}

}