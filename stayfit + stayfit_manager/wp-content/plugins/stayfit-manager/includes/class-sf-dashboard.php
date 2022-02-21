<?php

if( ! defined( "ABSPATH" ) ){
    exit;
}

Class Sf_Dashboard{

    public $endpoints;

    public $default_view;

    public $current_view;

    public $subpage;

    public static $_instance;

    public static function instance(){

        if( ! isset( $_instance ) ) self::$_instance = new Sf_Dashboard;
        return self::$_instance;

    }

    public function __construct(){

        $this->endpoints = Sf_Dashboard::endpoints();
        $this->default_view = $this->endpoints[0]['slug'];
        $this->current_view = $this->default_view;
        $this->subapge = false;

        $this->setView();

    }

    private function page_404(){
        echo 'Page not found. Please contact with your administrator.';
        return false;
    }

    public function getNavigationPagesSlug(){

        return array_map(function( $navigation ){
            return $navigation["slug"];
        }, $this->endpoints);

    }

    public function getNavigationPagesLabel(){

        return array_map(function( $navigation ){
            return $navigation["label"];
        }, $this->endpoints);

    }

    protected function setView(){

        $endpoint = filter_var( str_replace( "/\\", "", $_GET["page"] ), FILTER_SANITIZE_URL );
        $endpoint = explode('.', $endpoint);

        if( empty( $endpoint[0] ) ){
            return;
        }

        if( ! empty( $endpoint[0] ) && in_array( $endpoint[0], $this->getNavigationPagesSlug() ) ) {
            $this->current_view = $endpoint[0];
            if( ! empty( $endpoint[1] ) ){
                $this->subpage = $endpoint[1];
            }
        }

    }

    public static function endpoints(){

        return [
            array( "slug" => "general", "label" => "Ustawienia główne" ),
            array( "slug" => "client_manager", "label" => "Manager klientów" ),
            array( "slug" => "exercises", "label" => "Zajęcia" ),
            array( "slug" => "timetable", "label" => "Rozkład zajęć" ),
            array( "slug" => "pricing", "label" => "Cennik" ),
            array( "slug" => "notices", "label" => "Powiadomienia" ),
        ];
  
    }

    public function general(){

        $options = sfm()->Options();

        $general_form = [
            "name" => "sf_dashboard_general",
            "redirect_url" => get_permalink(),
            "groups" => [
                "O nas" => [
                    "show_name" => true,
                    "build" => [
                        [
                            "fields" => [
                                "type" => "textarea",
                                "name" => "site/description",
                                "rows" => "4",
                                "value" => $options->get('site/description')
                            ],
                            "type" => "single"
                        ]
                    ]
                ],
                "Lokalizacja" => [
                    "show_name" => true,
                    "build" => [
                        [
                            "fields" => [
                                [
                                    "label" => "Ulica",
                                    "type" => "text",
                                    "name" => "site/location/street",
                                    "class" => ["col-md-8"],
                                    "placeholder" => "Ulica",
                                    "value" => $options->get('site/location/street')
                                ],
                                [
                                    "label" => "Numer lokalu",
                                    "type" => "number",
                                    "name" => "site/location/place_no",
                                    "class" => ["col-md-4"],
                                    "placeholder" => "1",
                                    "value" => $options->get('site/location/place_no')
                                ]
                            ],
                            "type" => "row"
                        ],
                        [
                            "fields" => [
                                [
                                    "label" => "Kod pocztowy",
                                    "type" => "text",
                                    "name" => "site/location/postal_code",
                                    "class" => ["col-md-4"],
                                    "placeholder" => "15-001",
                                    "value" => $options->get('site/location/postal_code')
                                ],
                                [
                                    "label" => "Miasto",
                                    "type" => "text",
                                    "name" => "site/location/city",
                                    "class" => ["col-md-8"],
                                    "placeholder" => "Białystok",
                                    "value" => $options->get('site/location/city')
                                ]
                            ],
                            "type" => "row"
                        ]
                    ]
                ],
                "Media społecznościowe" => [
                    "show_name" => true,
                    "build" => [
                        [
                            "fields" => [
                                "label" => "Facebook",
                                "type" => "text",
                                "name" => "socials/fb/url",
                                "placeholder" => "Facebook",
                                "value" => $options->get('socials/fb/url')
                            ],
                            "type" => "single"
                        ]
                    ]
                ],
                "Kontakt" => [
                    "show_name" => true,
                    "build" => [
                        [
                            "fields" => [
                                "label" => "Numer telefonu",
                                "type" => "text",
                                "name" => "site/contact/dialling_code",
                                "placeholder" => "543 219 876",
                                "value" => $options->get('site/contact/dialling_code')
                            ],
                            "type" => "single"
                        ],
                        [
                            "fields" => [
                                "label" => "Adres e-mail",
                                "type" => "text",
                                "name" => "site/contact/email",
                                "placeholder" => "Facebook",
                                "value" => $options->get('site/contact/email')
                            ],
                            "type" => "single"
                        ]
                    ]
                ],
                "Submit" => [
                    "show_name" => false,
                    "build" => [
                        [
                            "fields" => [
                                "type" => "button",
                                "name" => "submit",
                                "value" => "Zapisz"
                            ],
                            "type" => "single"
                        ]
                    ]
                ],
            ]
        ];
        
        //$atts['form'] = new Sf_Form( $general_form )->render();

        $form = new Sf_Form( $general_form );
        echo $form->render();
        //$template = new Sf_template( $template );
       // $template->get( $atts );

    }

    public function client_manager( $subpage = '' ){
       
        require_once dirname( SF_MANAGER_FILE ) . '/includes/dashboard/class-sf-client_manager.php';
        $client_manager = new Stayfit\Dashboard\Sf_Client_Manager();

        $method = 'index';

        if( ! empty( $subpage ) ){
            $method = $subpage;
        }

        if( ! method_exists( $client_manager, $method ) ){
            $this->page_404();
            return;
        }

        call_user_func_array(array( $client_manager, $method ) , array());

    }

    public function client_manager_raport(){
        echo '<div id="interactive" class="viewport"></div>';
    }

    public function notices(){
        echo 'Notices from dashboard';
    }

    public function exercises(){
        $template = new Sf_template( 'dashboard/exercises' );
        $template->get( array() );
    }

    public function timetable(){      
        $template = new Sf_template( 'dashboard/timetable' );
        $template->get( array() );
    }

    public function pricing(){
        echo 'Pricing from dashboard';
    }

    public static function get_timetable_scheme_name(){
        return 'sf_manager_timetable_scheme';
    }
    
    public static function get_timetable_default_scheme(){
        
        $sf_manager_timetable_scheme = array(
            "poniedziałek" => array(
                'schedule' => array(),
                'status' => true
            ), 
            "wtorek" => array(
                'schedule' => array(),
                'status' => true
            ), 
            "środa" => array(
                'schedule' => array(),
                'status' => true
            ), 
            "czwartek" => array(
                'schedule' => array(),
                'status' => true
            ), 
            "piątek" => array(
                'schedule' => array(),
                'status' => true
            ), 
            "sobota" => array(
                'schedule' => array(),
                'status' => false
            ), 
            "niedziela" => array(
                'schedule' => array(),
                'status' => false
            )
        );

        return $sf_manager_timetable_scheme;
    }

    public static function get_timetable_scheme(){
        $args = array(
            'post_type'        => 'timetable',
            'post_status'      => 'publish',
        );
        $posts_array = get_posts( $args );
        $scheme = get_post_meta( $posts_array[0]->ID, Sf_Dashboard::get_timetable_scheme_name() );
        
        return $scheme;
    }

    public static function update_timetable_scheme( $new_scheme ){
        $args = array(
            'post_type'        => 'timetable',
            'post_status'      => 'publish',
        );
        $posts_array = get_posts( $args );
        $scheme = update_post_meta( $posts_array[0]->ID, Sf_Dashboard::get_timetable_scheme_name(), $new_scheme );
        
        return $scheme;
    }

}