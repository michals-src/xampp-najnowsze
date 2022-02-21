<?php

Class Sf_shortcode_output{

    public static function login_shortcode( $atts = array() ){

        $atts = array(
            "form" => '',
            "is_logged_in" => false
        );

        if( ! is_user_logged_in() ){

            // Formularz logowania
            $form = [
                "name" => "sf_login",
                "redirect_url" => home_url(),
                "groups" => [
                    "Logowanie" => [
                        "show_name" => false,
                        "build" => [
                            [
                                "fields" => [
                                    "label" => "Nazwa użytkownika",
                                    "name" => "username",
                                    "type" => "text",
                                    "placeholder" => "Nazwa użytkownika",
                                    "id" => "username"
                                ],
                                "type" => "single"
                            ],
                            [
                                "fields" => [
                                    "label" => "Hasło",
                                    "name" => "password",
                                    "type" => "password",
                                    "placeholder" => "Hasło",
                                    "id" => "password"
                                ],
                                "type" => "single"
                            ]
                        ]
                    ],
                    "zapamiętaj" => [
                        "show_name" => false,
                        "build" => [
                            [
                                "fields" => [
                                    "label" => "Zapamiętaj mnie",
                                    "type" => "checkbox",
                                    "id" => "remember-me",
                                    "name" => "rememberme"
                                ],
                                "type" => "single"
                            ]
                        ]
                            ],
                    "submit" => [
                        "show_name" => false,
                        "build" => [
                            [
                                "fields" => [
                                    "type" => "button",
                                    "name" => "submit",
                                    "value" => "Zaloguj się"
                                ],
                                "type" => "single"
                            ]
                        ]
                    ]
                ]     
            ];
    
            $formularz = new Sf_Form( $form );
            $atts["form"] = $formularz->render();

        }else{
            $atts["is_logged_in"] = true;
        }
        
        $template = new Sf_template( 'login' );
        $template->get( $atts );
    }

    public static function grafik_shortcode( $atts = array() ){
        
        $template = "pages/grafik";

        $template = new Sf_template( $template );
        $template->get( $atts );

    }

    public static function admin_panel_shortcode( $atts = array() ){
        
        $template = "admin_dashboard";

        if( ! is_user_logged_in() ){
            $template = "dashboard/unauthorized";
        }

        if( ! current_user_can( 'manage_options' ) ){
            $template = "dashboard/unauthorized";
        }

        $template = new Sf_template( $template );
        $template->get( $atts );

    }

    public static function user_panel_shortcode( $atts = array() ){
        
        $template = "user_dashboard";

        if( ! is_user_logged_in() ){
            $template = "dashboard/unauthorized";
        }

        $template = new Sf_template( $template );
        $template->get( $atts );

    }

    public static function print_person_shortcode( $atts = array() ){
        $template = "print_person";

        if( ! is_user_logged_in() || ! current_user_can( "manage_options" ) ){
            $template = "dashboard/unauthorized";
        }

        $template = new Sf_template( $template );
        $template->get( $atts );       
    }

}