<?php


class Server{

	/**
	 * REST API namespaces and endpoints
	 *
	 * @var array
	 */
	protected $controllers = [];

	public function __construct(){
		add_action( "rest_api_init", array( $this, "register_rest_routes"), 10 );
	}

	/**
	 * Register REST API routes
	 */
	public function register_rest_routes(){
		foreach( $this->get_rest_namespaces() as $namespace => $controllers ){
			foreach( $controllers as $controller_name => $controller_class ){
				require_once dirname( SF_MANAGER_FILE ) . '/rest-api/Controllers/Version1/class_' . strtolower( $controller_class ) . '.php';
				$this->controllers[ $namespace ][ $controller_name ] = new $controller_class;
				$this->controllers[ $namespace ][ $controller_name ]->register_routes();
			}
		}
	}

	/**
	 * @return array
	 */
	protected function get_rest_namespaces(){
		return [
			"sf/v1"	=>	$this->get_v1_controllers()
		]
	}

	/**
	 * @return array
	 */
	protected function get_v1_controllers(){
		return [
			'customer-card' => 'SF_Rest_Customer_Card_Controller',
			// 'customers' => 'SF_Rest_Customers_Controller',
			// 'timetable' => 'SF_Rest_Timetable_Controller',
			// 'exercises' => 'SF_Rest_Exercises_Controller',
		]
	}


}