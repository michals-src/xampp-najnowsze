<?php

if( ! defined( "ABSPATH" ) ){
    exit;
}

Class Sf_Form_Handle{

    public static function init(){
        
        add_action( "wp_loaded", array( __CLASS__, 'login_proccess_handler' ), 20 );
        
        add_action( "wp_loaded", array( __CLASS__, 'dashboard_general_proccess_handler' ), 20 );

        add_action( "wp_loaded", array( __CLASS__, 'dashboard_client_manager_create_handler' ), 20 );
        add_action( "wp_loaded", array( __CLASS__, 'dashboard_client_manager_person_handler' ), 20 );

        add_action( "wp_loaded", array( __CLASS__, 'dashboard_exercises_name_create_proccess_handler' ), 20 );
        add_action( "wp_loaded", array( __CLASS__, 'dashboard_exercises_name_edit_proccess_handler' ), 20 );
        add_action( "wp_loaded", array( __CLASS__, 'dashboard_exercises_level_create_proccess_handler' ), 20 );
        add_action( "wp_loaded", array( __CLASS__, 'dashboard_exercises_level_edit_proccess_handler' ), 20 );


        add_action( "wp_loaded", array( __CLASS__, 'dashboard_timetable_day_edit_proccess_handler' ), 20 );
        add_action( "wp_loaded", array( __CLASS__, 'dashboard_timetable_time_create_proccess_handler' ), 20 );
        add_action( "wp_loaded", array( __CLASS__, 'dashboard_timetable_time_edit_proccess_handler' ), 20 );
        add_action( "wp_loaded", array( __CLASS__, 'dashboard_timetable_time_delete_proccess_handler' ), 20 );

    }

    public static function login_proccess_handler(){
        if( ! empty( $_POST['sf_login']['submit'] ) && isset( $_POST['sf_login-nonce_field'] ) && wp_verify_nonce( $_POST['sf_login-nonce_field'], 'sf_login_submit-nonce' ) ){
            
            $login_fileds = $_POST['sf_login'];
            $empty = Sf_Form::is_empty( $login_fileds );

            if( ! empty( $empty ) ){
                Sf_Form::addError( $_POST['error'], $empty );
                return;
            }
            
            $data = [];
            
            $data["user_login"] = $login_fileds["username"];
            $data["user_password"] = $login_fileds["password"];
            $data["remember"] = $login_fileds["rememberme"];

            $secure_cookies = is_ssl() ? true : false;

            $wp_signon = wp_signon( $data, $secure_cookies );

            if( is_wp_error( $wp_signon ) ){
                Sf_Form::addError( $_POST['error'], [ 'form_notice' => [ "error" => $wp_signon->get_error_message() ] ] );
                return;
            }else{
                wp_redirect( home_url() );
                exit;
            }

        }
    }

    public static function dashboard_general_proccess_handler(){
        if( ! empty( $_POST['sf_dashboard_general']['submit'] ) && isset( $_POST['sf_dashboard_general-nonce_field'] ) && wp_verify_nonce( $_POST['sf_dashboard_general-nonce_field'], 'sf_dashboard_general_submit-nonce' ) ){

            $options = sfm()->Options();

            $current_options = $options->Receive();
            $new_options = $_POST['sf_dashboard_general'];
            $replaced_options = array_replace( $current_options, $new_options );
        
            $is_empty = Sf_Form::is_empty( $new_options );
            
        
            if( ! empty( $is_empty ) ){
                Sf_Form::addError( $_POST['error'], $is_empty );
                return;
            }
            
            $options->Update( $replaced_options );
            Sf_Form::addError( $_POST['error'], [ 'form_notice' => [ "success" => "Pomyślnie zaktualizowano ustawienia." ] ] );

        }
    }

    public static function dashboard_client_manager_create_handler(){
        if( ! empty( $_POST['sf_dashboard_client-manager-creator']['save'] ) 
            && isset( $_POST['sf_dashboard_client-manager-creator-nonce_field'] ) 
            && wp_verify_nonce( $_POST['sf_dashboard_client-manager-creator-nonce_field'], 'sf_dashboard_client-manager-creator_submit-nonce' ) ){

            $data = $_POST['sf_dashboard_client-manager-creator'];

            $user = new Sf_User( $data['email'] );
            $card = new Sf_Card( $data['card_key'] );


            $empty_fields_required = array(
                'name'      => $data['name'],
                'surname'   => $data['surname'],
                'email'     => $data['email']
            );

            $has_empty = Sf_Form::is_empty( $empty_fields_required );

            if( ! empty( $has_empty ) ){
                return Sf_Form::addError( $_POST['error'], $has_empty );
            }elseif( false === $user->not_found() || false === $card->not_found() ) {

                $exists_error = array(
                    'form_notice' => [ "error" => "Wystąpił błąd podczas tworzenia konta." ]
                );

                if( false === $user->not_found() ){
                    $exists_error['email'] = 'Podany adres email jest już zajęty.';
                }
                if( false === $card->not_found() ){
                    $exists_error['card_key'] = 'Wpisany numer karnetu jest zajęty.';
                }

                return Sf_Form::addError( $_POST['error'], $exists_error );
            }


            $user_meta = array(
                "first_name"    => $data["name"],
                "last_name"     => $data["surname"],
                "phone"         => $data["phone"],
                // "email"         => $data["email"],
                // "card_number"   => $data["card_number"],
                // "card" => array(
                //     "max_entries" => $data["number_of_entries"],
                //     "buy_date"  => $data["card_buy_date"],
                //     "expires"   => $data["card_expires"],
                // )
            );
            $user_creation = $user->create( $data['login']['rand_username'], $data['login']['secret_password'], $data['email'], $user_meta );
            if( empty( $user_creation ) ){
                $exists_error = array(
                    'form_notice' => [ "error" => "Wystąpił nieoczekiwany błąd podczas tworzenia konta. Daj mi znać." ]
                );
                
                return Sf_Form::addError( $_POST['error'], $exists_error );                
            }

            $card_meta = array(
                'entry_maximum'  => $data['card_entry_maximum'],
                'date_buy'       => $data['card_date_buy'],
                'date_expires'   => $data['card_date_expires'],
                'date_last_entry'=> '',
                'entry_maximum'  => $data['number_of_entries'],
                'entry_current'  => 0,
                'status'         => 'publish'
            );
            $card_assignation = $card->create( $user_creation, $card_meta );


            // $user_id = wp_create_user( $data['login']['rand_username'], $data['login']['secret_password'], $data['email'] );

            // update_user_meta( $user_id, "first_name", $data["name"] );
            // update_user_meta( $user_id, "last_name", $data["surname"] );
            // update_user_meta( $user_id, "phone", $data["phone"] );
            // update_user_meta( $user_id, "public_id", $user_public_id );
            // update_user_meta( $user_id, "card_number", $data["card_number"] ); //Numer zapisany w pamięci karty RFID
            // update_user_meta( $user_id, "card", array(
            //     "max_entries" => $data["number_of_entries"],
            //     "current_entries" => 0,
            //     "buy_date" => $data["card_buy_date"],
            //     "expires" => $data["card_expires"],
            // ));
            // update_user_meta( $user_id, "user_monitor", array(
            //     "01" => array(), "02" => array(),
            //     "03" => array(), "04" => array(),
            //     "05" => array(), "06" => array(),
            //     "07" => array(), "08" => array(),
            //     "09" => array(), "10" => array(),
            //     "11" => array(), "12" => array(), 
            //     "last" => null
            // ));

            wp_redirect( home_url() . '/panel-administracyjny/?page=client_manager.person&id=' . $user->get_id() );
            exit;

        }

    }


    public static function dashboard_client_manager_person_handler(){
        if( ! empty( $_POST['sf_dashboard_client-manager-person']['save'] ) 
            && isset( $_POST['sf_dashboard_client-manager-person-nonce_field'] ) 
            && wp_verify_nonce( $_POST['sf_dashboard_client-manager-person-nonce_field'], 'sf_dashboard_client-manager-person_submit-nonce' ) ){

            $data = $_POST['sf_dashboard_client-manager-person'];
            $empty_fields_required = array(
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'card_number' => $data['card_number'],
            );


            $public_id = (int) $data['user_id'];
            $user = new Sf_User( $public_id );
            $card = new Sf_Card( (int) $user->get_card_id() );

            $has_empty = Sf_Form::is_empty( $empty_fields_required );

            if( ! empty( $has_empty ) ){
                return Sf_Form::addError( $_POST['error'], $has_empty );
            }

            if( $data['email'] !== $user->get_user_email() ){
                $other_user = new Sf_User( $data['email'] );

                if( false === $other_user->not_found() ) {

                    $exists_error = array(
                        'form_notice' => [ "error" => "Wystąpił błąd podczas tworzenia konta." ]
                    );

                    if( false === $other_user->not_found() ){
                        $exists_error['email'] = 'Podany adres email jest już zajęty.';
                    }

                    return Sf_Form::addError( $_POST['error'], $exists_error );
                }
            }

            if( $data['card_number'] !== $card->get_key() ){
                $other_card = new Sf_Card( $data['card_number'] );

                if( false === $other_card->not_found() ) {

                    $exists_error = array(
                        'form_notice' => [ "error" => "Wystąpił błąd podczas tworzenia konta." ]
                    );

                    if( false === $card->not_found() ){
                        $exists_error['card_number'] = 'Wpisany numer karnetu jest zajęty.';
                    }

                    return Sf_Form::addError( $_POST['error'], $exists_error );
                }
            }

            $user_meta = array(
                "user_email"    => $data["email"],
                "user_login"    => str_replace('@', '.', $data["email"]),
                "first_name"    => $data["name"],
                "last_name"     => $data["surname"],
                "phone"         => $data["phone"],
                // "card_number"   => $data["card_number"],
                // "card"  =>  array(
                //     "max_entries" => $data["number_of_entries"],
                //     "current_entries" => $data["current_entries"],
                //     "buy_date" => $data["card_buy_date"],
                //     "expires" => $data["card_expires"],
                // ),
            );

            $card_meta = array(
                'key'               => $data['card_number'],
                'entry_current'     => $data['current_entries'],
                'entry_maximum'     => $data['number_of_entries'],
                'date_buy'          => $data['card_buy_date'],
                'date_expires'      => $data['card_expires'],
            );

            $user->update( $user_meta );
            $card->update( $card_meta );

            // if( $user->emailExists() || $user->cardExists() ) {

            //     $exists_error = array(
            //         'form_notice' => [ "error" => "Wystąpił błąd podczas zapisu wszystkich danych." ]
            //     );

            //     if( false !== $user->emailExists() ){
            //         $exists_error['email'] = 'Podany adres email jest już zajęty.';
            //     }
            //     if( false !== $user->cardExists() ){
            //         $exists_error['card_number'] = 'Wpisany numer karty jest zajęty.';
            //     }

            //     return Sf_Form::addError( $_POST['error'], $exists_error );
            // }

            // $user_query = new WP_User_Query( array(
            //     'meta_key' => 'public_id',
            //     'meta_value' => $data['user_public_id'],
            //     'fields' => array( 'ID' ),
            //     'number' => 1
            // ));

            // $user = $user_query->get_results();

            // wp_update_user( array( 
            //     'ID' => $user[0]->ID, 
            //     'user_email' => $data["email"],
            //     "first_name" => $data["name"],
            //     "last_name" => $data["surname"]
            // ) );
 
            // update_user_meta( $user[0]->ID, "phone", $data["phone"] );
            // update_user_meta( $user[0]->ID, "card_number", $data["card_number"] );
            // update_user_meta( $user[0]->ID, "card", array(
            //     "max_entries" => $data["number_of_entries"],
            //     "current_entries" => $data["current_entries"],
            //     "buy_date" => $data["card_buy_date"],
            //     "expires" => $data["card_expires"],
            // ));

            Sf_Form::addError( $_POST['error'], [ 'form_notice' => [ "success" => "Pomyślnie zapisano zmiany. " ] ] );
        }

        if( ! empty( $_POST['sf_dashboard_client-manager-person']['delete'] ) 
            && isset( $_POST['sf_dashboard_client-manager-person-nonce_field'] ) 
            && wp_verify_nonce( $_POST['sf_dashboard_client-manager-person-nonce_field'], 'sf_dashboard_client-manager-person_submit-nonce' ) ){

            $data = $_POST['sf_dashboard_client-manager-person'];
            $public_id = (int) $data['user_public_id'];
            $user = new Sf_User( $public_id );

            if( ! $user->delete() ) {

                $exists_error = array(
                    'form_notice' => [ "error" => "Nie udało się usunąć konta." ]
                );

                return Sf_Form::addError( $_POST['error'], $exists_error );
            }

            wp_redirect( home_url() . '/panel-administracyjny/?page=client_manager.lista' );
            exit;

        }

    }

    public static function dashboard_exercises_name_create_proccess_handler(){
        if( ! empty( $_POST['sf_dashboard_exercises_name_create']['save'] ) 
            && isset( $_POST['sf_dashboard_exercises_name_create-nonce_field'] ) 
            && wp_verify_nonce( $_POST['sf_dashboard_exercises_name_create-nonce_field'], 'sf_dashboard_exercises_name_create_submit-nonce' ) ){
            
            $name_data = $_POST['sf_dashboard_exercises_name_create'];
            $empty_data = Sf_Form::is_empty( $name_data );
            $term_value = get_term( $name_data['exercise_level'], 'exercises-level' );

            $name_exists = get_page_by_title( $name_data["exercise_name"], OBJECT, 'exercises' );

            if( ! empty( $empty_data ) ){
                return Sf_Form::addError( $_POST['error'], $empty_data );
            }else if( empty( $term_value ) ){
                return Sf_Form::addError( $_POST['error'], [ 'form_notice' => [ "error" => "Wystąpił problem z weryfikacją poziomu trudności." ] ] );
            }else if( ! empty( $name_exists ) ){
                return Sf_Form::addError( $_POST['error'], [ 'exercise_name' => "Istnieją już zajęcia o takiej samej nazwie." ] );
            }

            $result = wp_insert_post(array(
				'post_title' => $name_data['exercise_name'],
				'post_content' => 'zajęcia',
				'post_type' => 'exercises',
				'post_status' => 'publish'
            ));

            if( is_wp_error( $result ) ){
                return Sf_Form::addError( $_POST['error'], [ 'form_notice' => [ "error" => $result->get_error_message() ] ] );
            }

            wp_set_object_terms( $result, $term_value->term_id, 'exercises-level', true );

            $url = add_query_arg(
                array(
                    'page' => 'exercises',
                ),
                $_POST['redirect_url']
            );
            wp_redirect($url);
            exit;

        }        
    }

    public static function dashboard_exercises_name_edit_proccess_handler(){
        if( ! empty( $_POST['sf_dashboard_exercises_name_edit'] ) 
            && isset( $_POST['sf_dashboard_exercises_name_edit-nonce_field'] ) 
            && wp_verify_nonce( $_POST['sf_dashboard_exercises_name_edit-nonce_field'], 'sf_dashboard_exercises_name_edit_submit-nonce' ) ){
            
                $post_id = $_POST['sf_dashboard_exercises_name_edit']['post_id'];
                $name = $_POST['sf_dashboard_exercises_name_edit']['exercise_name'];
                
                $old_term_id = $_POST['sf_dashboard_exercises_name_edit']['old_term_id'];
                $new_term_id = $_POST['sf_dashboard_exercises_name_edit']['exercise_level'];
                $post_value = get_post( $post_id );
                $term_value = get_term( $new_term_id, 'exercises-level');

                if( ! empty( $post_value ) ){
                    if( ! empty( $_POST['sf_dashboard_exercises_name_edit']['save'] ) ){

                        $empty_data = Sf_Form::is_empty( $_POST['sf_dashboard_exercises_name_edit'] );
    
                        if( empty( $empty_data ) ){

                            wp_update_post( array(
                                'ID' => $post_value->ID,
                                'post_title' => $name
                            ));
                            wp_set_object_terms( $post_value->ID, $term_value->term_id, 'exercises-level' );
                            return true;
                        }
                        
                    }else if( ! empty( $_POST['sf_dashboard_exercises_name_edit']['delete'] ) ){
                        return wp_delete_post( $post_value->ID );
                    }
                }    
        }
    }

    public static function dashboard_exercises_level_create_proccess_handler(){
        if( ! empty( $_POST['sf_dashboard_exercises_level_create']['save'] ) 
            && isset( $_POST['sf_dashboard_exercises_level_create-nonce_field'] ) 
            && wp_verify_nonce( $_POST['sf_dashboard_exercises_level_create-nonce_field'], 'sf_dashboard_exercises_level_create_submit-nonce' ) ){
            
            $level_data = $_POST['sf_dashboard_exercises_level_create'];
            $empty_data = Sf_Form::is_empty( $level_data );

            if( ! empty( $empty_data ) ){
                return Sf_Form::addError( $_POST['error'], $empty_data );
            }

            $result = wp_insert_term( $level_data['level_description'], 'exercises-level' );
            
            if( is_wp_error( $result ) ){
                return Sf_Form::addError( $_POST['error'], ['level_description' => $result->get_error_message() ] );
            }else if( empty( $level_data["level_color"] ) ){
                return Sf_Form::addError( $_POST['error'], ['level_color' => "Proszę wybrać kolor" ] );
            }

            $meta = add_term_meta( $result['term_id'], 'level_color', $level_data["level_color"] );

            return Sf_Form::addError( $_POST['error'], [ 'form_notice' => [ "success" => "Pomyślnie dodano poziom trudności." ] ] );

        }        
    }

    public static function dashboard_exercises_level_edit_proccess_handler(){
        if( ! empty( $_POST['sf_dashboard_exercises_level_edit'] ) 
            && isset( $_POST['sf_dashboard_exercises_level_edit-nonce_field'] ) 
            && wp_verify_nonce( $_POST['sf_dashboard_exercises_level_edit-nonce_field'], 'sf_dashboard_exercises_level_edit_submit-nonce' ) ){
            
                $term_id = $_POST['sf_dashboard_exercises_level_edit']['term_id'];
                $description = $_POST['sf_dashboard_exercises_level_edit']['level_description'];
                $color = $_POST['sf_dashboard_exercises_level_edit']['level_color'];
                $term_value = get_term( $term_id, 'exercises-level' );

                if( ! empty( $term_value ) ){
                    if( ! empty( $_POST['sf_dashboard_exercises_level_edit']['save'] ) ){
                        
                        $empty_data = Sf_Form::is_empty( $_POST['sf_dashboard_exercises_level_edit'] );
        
                        if( empty( $empty_data ) ){
                            wp_update_term( $term_id, 'exercises-level', array( "name" => $description ) );
                            update_term_meta( $term_id, 'level_color', $color );
                            return true;
                        }
                        
                    }else if( ! empty( $_POST['sf_dashboard_exercises_level_edit']['delete'] ) ){
                        return wp_delete_term( $term_id, 'exercises-level' );
                    }
                }    
        }
    }
    
    public static function dashboard_timetable_day_edit_proccess_handler(){
        if( ! empty( $_POST['sf_dashboard_timetable_day_edit']['save'] ) 
            && isset( $_POST['sf_dashboard_timetable_day_edit-nonce_field'] ) 
            && wp_verify_nonce( $_POST['sf_dashboard_timetable_day_edit-nonce_field'], 'sf_dashboard_timetable_day_edit_submit-nonce' ) ){
            
            
            $edit_data = $_POST['sf_dashboard_timetable_day_edit'];
            $day_name = $edit_data['day_name'];
            $status = ( ! empty( $edit_data['day_status'] ) ) ? true : false;
            $times = $edit_data['time'];

            $global_scheme = Sf_Dashboard::get_timetable_scheme()[0];
            $day_scheme = $global_scheme[$day_name];
            $changed = false;

            if( $day_scheme["status"] !== $status ){
                $changed = true;
                if( in_array( $day_name, array_keys( Sf_Dashboard::get_timetable_default_scheme() ) ) ){
                    $day_scheme["status"] = $status;
                }
            }
            
            if( ! empty( $times ) ){
                $changed = true;
                $local_schedule = array();
                foreach( $times as $time_id => $exercise_id ){

                    $local_schedule[$time_id] = $exercise_id;
    
                }
                $day_scheme["schedule"] = $local_schedule;
                $global_scheme[$day_name] = $day_scheme;

            }

            if( ! empty( $changed ) ){
                Sf_Dashboard::update_timetable_scheme( $global_scheme );
            }

        }
    }

    public static function dashboard_timetable_time_create_proccess_handler(){
        if( ! empty( $_POST['sf_dashboard_timetable_time_create']['save'] ) 
            && isset( $_POST['sf_dashboard_timetable_time_create-nonce_field'] ) 
            && wp_verify_nonce( $_POST['sf_dashboard_timetable_time_create-nonce_field'], 'sf_dashboard_timetable_time_create_submit-nonce' ) ){
            
            $time_data = $_POST['sf_dashboard_timetable_time_create'];
            $empty_data = Sf_Form::is_empty( $time_data );

            if( ! empty( $empty_data ) ){
                return Sf_Form::addError( $_POST['error'], $empty_data );
            }

            $result = wp_insert_term( $time_data['clock'], 'timetable-time' );
            if( is_wp_error( $result ) ){
                Sf_Form::addError( $_POST['error'], ['clock' => $result->get_error_message() ] );
            }else{
              $args = array(
                'post_type'        => 'timetable',
                'post_status'      => 'publish',
              );
              $posts_array = get_posts( $args );
              $a = wp_set_object_terms( $posts_array[0]->ID, $result['term_id'], 'timetable-time', true );
            }

            return Sf_Form::addError( $_POST['error'], [ 'form_notice' => [ "success" => "Pomyślnie dodano godzinę." ] ] );

        }
    }

    public static function dashboard_timetable_time_edit_proccess_handler(){
        if( ! empty( $_POST['sf_dashboard_timetable_time_edit']['save'] ) 
            && isset( $_POST['sf_dashboard_timetable_time_edit-nonce_field'] ) 
            && wp_verify_nonce( $_POST['sf_dashboard_timetable_time_edit-nonce_field'], 'sf_dashboard_timetable_time_edit_submit-nonce' ) ){
                
                $term_id = $_POST['sf_dashboard_timetable_time_edit']['term_id'];
                $value = $_POST['sf_dashboard_timetable_time_edit']['clock'];
                $term_value = get_term( $term_id, 'timetable-time' );

                if( ! empty( $term_value ) ){
                    $empty_data = Sf_Form::is_empty( $_POST['sf_dashboard_timetable_time_edit'] );

                    if( empty( $empty_data ) ){
                        wp_update_term( $term_id, 'timetable-time', array( "name" => $value ) );
                    }
                }
                
        }
    }

    public static function dashboard_timetable_time_delete_proccess_handler(){
        if( ! empty( $_POST['sf_dashboard_timetable_time_edit']['delete'] ) 
            && isset( $_POST['sf_dashboard_timetable_time_edit-nonce_field'] ) 
            && wp_verify_nonce( $_POST['sf_dashboard_timetable_time_edit-nonce_field'], 'sf_dashboard_timetable_time_edit_submit-nonce' ) ){
                
                $term_id = $_POST['sf_dashboard_timetable_time_edit']['term_id'];
                $term_value = get_term( $term_id, 'timetable-time' );

                if( ! empty( $term_value ) ){
                    return wp_delete_term( $term_id, 'timetable-time' );
                }
                
        }
    }

}