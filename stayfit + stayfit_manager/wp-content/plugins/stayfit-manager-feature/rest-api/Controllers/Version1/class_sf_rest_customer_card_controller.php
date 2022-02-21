<?php

defined("ABSPATH") || exit;

class Sf_Rest_Customer_Card_Controllers extends Sf_Rest_Controller{

	/**
	 * @var string
	 */
	protected $namespace = "sf/v1";

	/**
	 *  @var string
	 */
	protected $rest_base = "card";

	/**
	 * @var string
	 */
	//protected $post_type = "user_card";

	/**
	 * Rejestracja routes dla kart użytkowników
	 */
	public function register_routes(){

		register_rest_route( $this->namespace . '/' . $this->rest_base . '/(?P<id>)', array(
			array(
				"methods" => WP_REST_API::READABLE,
				"callback" => array( $this, "get_item" ),
				"permission_callback" => array( $this, "get_item_permission_check" ),
				"args" => array(
					"context" => $this->get_context_param()
				)
			),			
			array(
				"methods" => WP_REST_API::EDITABLE,
				"callback" => array( $this, "update_item" ),
				"permission_callback" => array( $this, "get_item_permission_check" ),
				"args" => $this->get_endpoint_arg_for_item_schema( WP_REST_API::EDITABLE );
			),
			"scheme" => array( $this, "get_public_item_schema" )
		));

	}

	protected function get_object( $id ) {
		return new Sf_Card( $id );
	}

	protected function get_formatted_item_data( Sf_Card $object ){
		$data = $object->get_data();
		return [
			'id'	=> $object->get_id(),
			'user_id' => $object->assignet_to()->get_id(),
			''
		];
	}

	protected function prepare_object_for_response( $object, WP_Rest_Request $request ){
		$data = $this->get_formatted_item_data( $object );
		$context = ! empty( $request['context'] ) ? $request['context'] ? 'view';
		$data = $this->add_additional_fields_to_object( $data, $request );
		$data = $this->filters_response_by_context( $data, $context );
		$response = rest_ensure_response( $data );

		return $response;
	}

}