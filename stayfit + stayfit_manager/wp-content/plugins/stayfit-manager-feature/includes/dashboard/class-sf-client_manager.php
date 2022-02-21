<?php

class Sf_Client_Manager{

	public function index(){
		$template = new \Sf_template( 'dashboard/client_manager' );
        $template->get( array() );
	}

	public function lista(){
        $template = new \Sf_template( 'dashboard/client_manager/list' );
        $template->get( array() );
	}

	public function person(){

        // $user = new Sf_User(18);
        // $card = new Sf_Card( $user->get_card_id() );
        // $card->reassign_to( $new_key, $card_meta );
        
        // // print_r(array_intersect( array( 'a', 'b', 'c' ), array( 'a', 'b' ) ));
        // $user = new Sf_User(18);
        // $card_meta = array(
        //     'entry_maximum' => 10,
        //     'date_buy' => date('Y-m-d H:i:s', strtotime('2020-02-10 11:00:00')),
        //     'date_expires' => date('Y-m-t H:i:s', strtotime('2020-02-10 11:00:00')),
        //     'date_last_entry' => date('Y-m-t H:i:s'),
        //     'entry_current'   => 2,
        //     'status' => 'publish'
        // );
        // $card->reassign_to( $user, 'karnet_1', $card_meta );
        // echo "<pre>", print_r($card), "</pre>";

        try {
            if( empty( $_GET['id'] ) ){
                throw new Exception('Nie znalezino użytkownika.');
            }
            $user = new Sf_User( (int) $_GET['id'] );
            $card = new Sf_Card( (int) $user->get_card_id() );
            $monitor = new Sf_Monitor( $user );
        } catch (Exception $e) {
            echo $e->getMessage();
            echo '<p><a href="?page=client_manager.lista">Powrót do listy klientów</a></p>';
            return;
        }

        //echo "<pre>", print_r($card), "</pre>";

        $months = array(
               "01" => "Styczeń",
                "02" => "Luty",
                "03" => "Marzec",
                "04" => "Kwiecień",
                "05" => "Maj",
                "06" => "Czerwiec",
                "07" => "Lipiec",
                "08" => "Sierpiń",
                "09" => "Wrzesień",
                "10" => "Październik",
                "11" => "Listopad",
                "12" => "Grudzień"
        );

        $dateTime = new DateTime( 'now' );
        $month = $dateTime->format('m');
        $month_selected = ( ! empty( $_GET["month"] ) ) ? $_GET["month"] : $month;

		// $id = (int) $_GET['id'];
        
  //       if( ! is_integer( $id ) || $id < 150000 ){
  //           echo 'Nie znaleziono użytkownika.';
  //           return;
  //       }

  //       $user_query = new \WP_User_Query( array(
  //           'meta_key' => 'public_id',
  //           'meta_value' => $id,
  //           'fields' => array( 'ID', 'user_login', 'user_email' ),
  //           'number' => 1
  //       ));

  //       $user = $user_query->get_results();

  //       if( empty( $user ) ){
  //           echo 'Nie znaleziono użytkownika';
  //           return;
  //       }


  //       $first_name = get_user_meta( $user[0]->ID, 'first_name' );
  //       $last_name = get_user_meta( $user[0]->ID, 'last_name' );
  //       $user_phone = get_user_meta( $user[0]->ID, 'phone' );
  //       $user_card_number = get_user_meta( $user[0]->ID, 'card_number' );
  //       $user_card = get_user_meta( $user[0]->ID, 'card' );

  //       $max_entries = $user_card[0]["max_entries"];
  //       $current_entries = $user_card[0]["current_entries"];
  //       $card_buy_date = $user_card[0]["buy_date"];
  //       $card_expires = $user_card[0]["expires"];

  //       if( empty( $user_card ) ){
  //           $max_entries = '0';
  //           $current_entries = '0';
  //           $card_buy_date = date('Y-m-d');
  //           $card_expires = date('Y-m-d', strtotime("+1 month"));
  //       }

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
                                "name" => "user_id",
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
                                    "value" => $user->get_first_name()
                                ],
                                [
                                    "label" => "Nazwisko",
                                    "type" => "text",
                                    "name" => "surname",
                                    "class" => ["col-md-7"],
                                    "placeholder" => "Kowalska",
                                    "value" => $user->get_last_name(),
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
                                "value" => $user->get_phone()
                            ],
                            "type" => "single"
                        ],
                        [                              
                            "fields" => [
                                "label" => "Adres e-mail",
                                "type" => "email",
                                "name" => "email",
                                "placeholder" => "adres@email.pl",
                                "value" => $user->get_user_email()
                            ],
                            "type" => "single"
                        ],
                        [                              
                            "fields" => [
                                 [
                                    "label" => "Obecna ilość wejść",
                                    "type" => "number",
                                    "name" => "current_entries",
                                    "class" => array( 'col-sm-6' ),
                                    "min" => 0,
                                    "max" => 100,
                                    "value" => $card->get_entry_current()
                                ],
                                [
                                    "label" => "Max. ilość wejść",
                                    "type" => "number",
                                    "name" => "number_of_entries",
                                    "class" => array( 'col-sm-6' ),
                                    "min" => 0,
                                    "max" => 100,
                                    "value" => $card->get_entry_maximum()
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
                                    "value" => date( 'Y-m-d', strtotime( $card->get_date_buy() ) )
                                ],
                                [
                                    "label" => "Data ważności karnetu",
                                    "type" => "date",
                                    "name" => "card_expires",
                                    "class" => array( 'col-sm-6' ),
                                    "value" => date( 'Y-m-d', strtotime( $card->get_date_expires() ) )
                                ],
                            ],
                            "type" => "row"
                        ],
                        [                              
                            "fields" => [
                                "label" => "Numer karty",
                                "type" => "text",
                                "name" => "card_number",
                                "value" => $card->get_key()
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
                                    "value" => $user->get_user_login()
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
            'firstname' => $user->get_first_name(), 
            'lastname' => $user->get_last_name(), 
            'form' => $form, 
            'id' => $id,
            'registered' => $user->get_date_registered(),
            'max_entries' => $card->get_entry_maximum(), 
            'current_entries' => $card->get_entry_current(),
            'raport' => array(
                'months' => $months,
                'selected' => $month_selected,
                'count' => count( $card->get_used_when()[$month_selected] ),
                'data' => $card->get_used_when()[$month_selected]
            )
        ) );

	}

	public function create(){
        //$user = new Sf_User('hello@world.eu');
       // echo "<pre>", print_r($user), "</pre>";
        //echo "<pre>", print_r(get_user_meta(18)), "</pre>";

        $card_buy_date = date( "Y-m-d" );
        $card_expires = date( "Y-m-t" );

        $general_form = [
            "name" => "sf_dashboard_client-manager-creator",
            "redirect_url" => get_permalink(),
            "groups" => [
                "Dane osobowe klienta" => [
                    "show_name" => true,
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
                "Własności karnetu" => [
                    "show_name" => true,
                    "build" => [
                        [                              
                            "fields" => [
                                    [
                                    "label" => "Ilość wykupionych wejść",
                                    "type" => "number",
                                    "name" => "number_of_entries",
                                    "value" => "1",
                                    "min" => 1,
                                    "max" => 30,
                                    "class" => ['col-sm-4']
                                ],
                                [                              
                                    "label" => "Numer karnetu",
                                    "type" => "text",
                                    "name" => "card_key",
                                    "class" => ['col-sm-8']
                                ],
                            ],
                            "type" => "row"
                        ],
                        [                              
                            "fields" => [
                                [
                                    "label" => "Data wykupienia karnetu",
                                    "type" => "date",
                                    "name" => "card_date_buy",
                                    "class" => array( 'col-sm-6' ),
                                    "value" => $card_buy_date,
                                ],
                                [
                                    "label" => "Data ważności karnetu",
                                    "type" => "date",
                                    "name" => "card_date_expires",
                                    "class" => array( 'col-sm-6' ),
                                    "value" => $card_expires,
                                ],
                            ],
                            "type" => "row"
                        ],
                    ]
                ],
                "Dane logowania" => [
                    "show_name" => true,
                    'description' => 'Wartości pola generowane są automatycznie, ale możliwa jest ich ręczna zmiana.',
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
            'title_pattern' => '<h3>%s</h3>',
            'group_class'   => ['mb-5']
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
        //$template = new \Sf_template( 'dashboard/client_manager/scanner' );
        //$template->get();
	}

}