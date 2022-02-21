<?php

namespace Stayfit\Dashboard;

Class Sf_Client_Manager{

	public function index(){
		$template = new \Sf_template( 'dashboard/client_manager' );
        $template->get( array() );
	}

	public function lista(){
        $template = new \Sf_template( 'dashboard/client_manager/list' );
        $template->get( array() );
	}

	public function person(){

		    $id = (int) $_GET['id'];

        if( ! is_integer( $id ) || $id < 150000 ){
            echo 'Nie znaleziono użytkownika.';
            return;
        }

        $user_query = new \WP_User_Query( array(
            'meta_key' => 'public_id',
            'meta_value' => $id,
            'fields' => array( 'ID', 'user_login', 'user_email' ),
            'number' => 1
        ));

        $user = $user_query->get_results();

        if( empty( $user ) ){
            echo 'Nie znaleziono użytkownika';
            return;
        }


        $first_name = get_user_meta( $user[0]->ID, 'first_name' );
        $last_name = get_user_meta( $user[0]->ID, 'last_name' );
        $user_phone = get_user_meta( $user[0]->ID, 'phone' );
        $user_card_number = get_user_meta( $user[0]->ID, 'card_number' );
        $user_card = get_user_meta( $user[0]->ID, 'card' );

        $max_entries = $user_card[0]["max_entries"];
        $current_entries = $user_card[0]["current_entries"];
        $card_buy_date = $user_card[0]["buy_date"];
        $card_expires = $user_card[0]["expires"];

        if( empty( $user_card ) ){
            $max_entries = '0';
            $current_entries = '0';
            $card_buy_date = date('Y-m-d');
            $card_expires = date('Y-m-d', strtotime("+1 month"));
        }

        $general_form = [
            "name" => "sf_dashboard_client-manager-person",
            "redirect_url" => get_permalink(),
            "groups" => [
                "hidden_info" => [
                    "show_name" => false,
                    "build" => [
                        [
                            "fields" => [
                                "type" => "hidden",
                                "name" => "user_public_id",
                                "value" => $_GET['id']
                            ],
                            "type" => "single"
                        ]
                    ]
                ],
                "Dane osobowe" => [
                    "show_name" => false,
                    "build" => [
                        [
                            "fields" => [
                                [
                                    "label" => "Imię",
                                    "type" => "text",
                                    "name" => "name",
                                    "class" => ["col-md-5"],
                                    "placeholder" => "Milena",
                                    "value" => $first_name[0]
                                ],
                                [
                                    "label" => "Nazwisko",
                                    "type" => "text",
                                    "name" => "surname",
                                    "class" => ["col-md-7"],
                                    "placeholder" => "Kowalska",
                                    "value" => $last_name[0],
                                ]
                            ],
                            "type" => "row"
                        ],
                        [
                            "fields" => [
                                "label" => "Numer telefonu",
                                "type" => "text",
                                "name" => "phone",
                                "placeholder" => "+48 123 456 789",
                                "value" => $user_phone[0]
                            ],
                            "type" => "single"
                        ],
                        [
                            "fields" => [
                                "label" => "Adres e-mail",
                                "type" => "email",
                                "name" => "email",
                                "placeholder" => "adres@email.pl",
                                "value" => $user[0]->user_email
                            ],
                            "type" => "single"
                        ],
                        [
                            "fields" => [
                                [
                                    "label" => "Max. ilość wejść",
                                    "type" => "number",
                                    "name" => "number_of_entries",
                                    "class" => array( 'col-sm-6' ),
                                    "min" => 0,
                                    "max" => 30,
                                    "value" => $max_entries
                                ],
                                [
                                    "label" => "Obecna ilość wejść",
                                    "type" => "number",
                                    "name" => "current_entries",
                                    "class" => array( 'col-sm-6' ),
                                    "min" => 0,
                                    "max" => 30,
                                    "value" => $current_entries
                                ],
                            ],
                            "type" => "row"
                        ],
                        [
                            "fields" => [
                                [
                                    "label" => "Data wykupienia karnetu",
                                    "type" => "date",
                                    "name" => "card_buy_date",
                                    "class" => array( 'col-sm-6' ),
                                    "value" => $card_buy_date
                                ],
                                [
                                    "label" => "Data ważności karnetu",
                                    "type" => "date",
                                    "name" => "card_expires",
                                    "class" => array( 'col-sm-6' ),
                                    "value" => $card_expires
                                ],
                            ],
                            "type" => "row"
                        ],
                        [
                            "fields" => [
                                "label" => "Numer karty",
                                "type" => "text",
                                "name" => "card_number",
                                "value" => $user_card_number[0]
                            ],
                            "type" => "single"
                        ],
                    ]
                ],
                "Dane logowania" => [
                    "show_name" => true,
                    "build" => [
                        [
                            "fields" => [
                                    "label" => "Nazwa użytkownika",
                                    "type" => "text",
                                    "name" => "login/rand_username",
                                    "value" => "Brak",
                                    "disabled" => "disabled",
                                    "input_class" => ["form-control-sm"],
                                    "value" => $user[0]->user_login
                            ],
                            "type" => "single"
                        ],
                    ]
                ],
                "Submit" => [
                    "show_name" => false,
                    "build" => [
                        [
                            "fields" => [
                                [
                                "type" => "button",
                                "name" => "save",
                                "value" => "Zapisz"
                            ],
                            [
                                "type" => "button",
                                "name" => "delete",
                                "input_class" => array( "btn-danger", "ml-2" ),
                                "value" => "Usuń profil"
                            ]
                            ],
                            "type" => "row"
                        ]
                    ]
                ],
            ]
        ];

        //$atts['form'] = new Sf_Form( $general_form )->render();

        $form_build = new \Sf_Form( $general_form, array(
            'title_pattern' => '<div class="mt-5"><h5>%s</h5></div>'
        ) );
        $form = $form_build->render();

        $template = new \Sf_template( 'dashboard/client_manager/person' );
        $template->get( array(
            'form' => $form,
            'id' => $id,
            'max_entries' => $max_entries,
            'current_entries' => $current_entries
        ) );

	}

	public function create(){

        $card_buy_date = date( "Y-m-d" );
        $card_expires = date( "Y-m-d", strtotime("+1 month") );

        $general_form = [
            "name" => "sf_dashboard_client-manager-creator",
            "redirect_url" => get_permalink(),
            "groups" => [
                "Dane osobowe" => [
                    "show_name" => false,
                    "build" => [
                        [
                            "fields" => [
                                [
                                    "label" => "Imię",
                                    "type" => "text",
                                    "name" => "name",
                                    "class" => ["col-md-5"],
                                    "placeholder" => "Milena",
                                ],
                                [
                                    "label" => "Nazwisko",
                                    "type" => "text",
                                    "name" => "surname",
                                    "class" => ["col-md-7"],
                                    "placeholder" => "Kowalska",
                                ]
                            ],
                            "type" => "row"
                        ],
                        [
                            "fields" => [
                                "label" => "Numer telefonu",
                                "type" => "text",
                                "name" => "phone",
                                "placeholder" => "+48 123 456 789",
                            ],
                            "type" => "single"
                        ],
                        [
                            "fields" => [
                                "label" => "Adres e-mail",
                                "type" => "email",
                                "name" => "email",
                                "placeholder" => "adres@email.pl",
                            ],
                            "type" => "single"
                        ],
                    ]
                ],
                "Karnet" => [
                    "show_name" => true,
                    "build" => [
                        [
                            "fields" => [
                                "label" => "Ilość wykupionych wejść",
                                "type" => "number",
                                "name" => "number_of_entries",
                                "value" => "1",
                                "min" => 1,
                                "max" => 30
                            ],
                            "type" => "single"
                        ],
                        [
                            "fields" => [
                                [
                                    "label" => "Data wykupienia karnetu",
                                    "type" => "date",
                                    "name" => "card_buy_date",
                                    "class" => array( 'col-sm-6' ),
                                    "value" => $card_buy_date,
                                ],
                                [
                                    "label" => "Data ważności karnetu",
                                    "type" => "date",
                                    "name" => "card_expires",
                                    "class" => array( 'col-sm-6' ),
                                    "value" => $card_expires,
                                ],
                            ],
                            "type" => "row"
                        ],
                        [
                            "fields" => [
                                "label" => "Numer karty",
                                "type" => "text",
                                "name" => "card_number"
                            ],
                            "type" => "single"
                        ],
                    ]
                ],
                "Dane logowania" => [
                    "show_name" => true,
                    "build" => [
                        [
                            "fields" => [
                                [
                                    "label" => "Nazwa użytkownika",
                                    "type" => "text",
                                    "name" => "login/rand_username",
                                    "value" => "Brak",
                                    "disabled" => "disabled",
                                    "input_class" => ["form-control-sm"],
                                    "after_field" => '<small class="form-text text-muted">Zawartość generowana automatycznie.</small>',
                                ],
                                [
                                    "label" => "Hasło",
                                    "type" => "text",
                                    "name" => "login/secret_password",
                                    "value" => "Brak",
                                    "enabled" => "enabled",
                                    "input_class" => ["form-control-sm"],
                                    "value" => wp_generate_password( 7 ),
                                    "after_field" => '<small class="form-text text-muted">Zawartość generowana automatycznie.</small>',
                                ],
                                [
                                    "type" => "button",
                                    "name" => "generate",
                                    "input_class" => ["col-sm-12", "mb-3", "btn-warning"],
                                    "value" => "Generuj"
                                ],
                            ],
                            "type" => "row"
                        ],
                    ]
                ],
                "Submit" => [
                    "show_name" => false,
                    "build" => [
                        [
                            "fields" => [
                                "type" => "button",
                                "name" => "save",
                                "disabled" => "disabled",
                                "value" => "Utwórz profil"
                            ],
                            "type" => "single"
                        ]
                    ]
                ],
            ]
        ];

        //$atts['form'] = new Sf_Form( $general_form )->render();

        $form = new \Sf_Form( $general_form, array(
            'title_pattern' => '<div class="mt-5"><h5>%s</h5></div>'
        ) );
        echo $form->render();

        // $template = new Sf_template( 'dashboard/client_manager/create' );
        // $template->get( array() );

	}

	public function raport(){
        $template = new \Sf_template( 'dashboard/client_manager/raport' );
        $template->get();
	}

	public function scanner(){
        $template = new \Sf_template( 'dashboard/client_manager/scanner' );
        $template->get();
	}

}
