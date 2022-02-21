<?php

if( ! defined( "ABSPATH" ) ){
    exit;
}

Class Sf_Ajax{

    private static $_instance;

    public static function init(){
        add_action( 'init', array( __CLASS__, 'define_ajax' ), 0 );
        add_action( "template_redirect", array( __CLASS__, "do_sf_ajax" ), 0 );
        self::add_sf_events();
    }

    public static function define_ajax(){
        if ( ! empty( $_GET['sf-ajax'] ) ) {
            if( ! defined( "DOING_AJAX" ) ){
                define( "DOING_AJAX", true );
            }
			if ( ! WP_DEBUG || ( WP_DEBUG && ! WP_DEBUG_DISPLAY ) ) {
				@ini_set( 'display_errors', 0 ); // Turn off display_errors during AJAX events to prevent malformed JSON.
			}
		}
    }

    public static function do_sf_ajax(){

        global $wp_query;

        if( ! empty( $_GET['sf-ajax'] ) ){
            $wp_query->set( 'sf-ajax', sanitize_text_field( wp_unslash( $_GET['sf-ajax'] ) ) );
        }

        $action = $wp_query->get( 'sf-ajax' );

        if( ! empty( $action ) ){
            send_origin_headers();
            @header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );
            @header( 'X-Robots-Tag: noindex' );
            send_nosniff_header();
            status_header( 200 );
            $action = sanitize_text_field( $action );
            do_action( 'wp_ajax_' . $action );
            wp_die();
        }

    }

    private static function add_sf_events(){

        $sf_events = array(
            "exercises_get_name_content" => false,
            "exercises_get_level_content" => false,
            "timetable_get_day_content" => false,
            "timetable_get_time_content" => false,
            "client_manager_monitor_add" => false,
        );

        foreach( $sf_events as $event => $nopriv ){
            add_action( 'wp_ajax_sf_manager_' . $event, array( __CLASS__, $event ) );
        }

    }

    public static function timetable_get_day_content(){

        if( ! check_ajax_referer( 'sf_manager_timetable_day_content_nonce', 'nonce' ) ){
            return wp_send_json_error( "Błędny klucz weryfikacyjny." );
        }

        $name = $_POST['name'];
        $status = $_POST['status'];
        $schedule = $_POST['schedule'];

        $zajęcia = get_posts( array( "post_type" => "exercises", 'status' => 'publish' ) );
        $godziny = get_terms( "timetable-time" );

        $title = sprintf( 'Edytuj %s', ucfirstUtf8($name) );

        $response = sprintf( '<h6><strong>%s</strong></h6></div>', $title );

        if( empty( $zajęcia ) ){
            $response .= sprintf( '<p><strong>%s</p>', 'Nie dodano jeszcze ćwiczeń.' );
        }

        $structure = array(
            'name' => 'sf_dashboard_timetable_day_edit',
            'redirect_url' => '',
            'groups' => array()
        );
        
        $structure['groups'][$title] = array();
        $structure['groups'][$title]["show_name"] = false;
        $structure['groups'][$title]["build"] = array();
    
        $structure['groups']["submit"] = array();
        $structure['groups']["submit"]["show_name"] = false;
        $structure['groups']["submit"]["build"] = array();
        $structure['groups']["submit"]["build"][0] = array( "type" => "nav", "fields" => array());

        $day_hidden = array(
            'type' => 'single',
            'fields' => array(
                'type' => 'hidden',
                'name' => 'day_name',
                'value' => $name
            )
        );
        array_push( $structure['groups'][$title]["build"], $day_hidden );
        
        if( ! empty( $zajęcia ) )
        {
            //return wp_send_json_success( array( "sf_manager_tec" => $schedule ) );
            foreach( $godziny as $godzina_key => $godzina ){
                
                $day_time = array(
                    'type' => 'single',
                    'fields' => array(
                        'type' => 'select',
                        'options' => array(
                            '' => array(
                                'name' => 'Brak'
                            ),
                        )
                    )
                );

                foreach( $zajęcia as $key => $ćwiczenie ){
                    $day_time["fields"]["options"][$ćwiczenie->ID] = $ćwiczenie->post_title;
                }

                $day_time["fields"]["value"] = $schedule[$godzina->term_id];
                $day_time["fields"]["label"] = sprintf( 'Godzina %s', $godzina->name );
                $day_time["fields"]["name"] = sprintf( 'time/%s', $godzina->term_id );

                array_push( $structure['groups'][$title]["build"], $day_time );

            }


        }

        $switch = array(
            "type" => "single",
            "fields" => array(
                "label" => "Wyświetlaj dzień",
                "type" => "switch",
                "id" => "day-status",
                "name" => "day_status",
                "checked" => ( $status === "true" ) ? true : false
            )
        );
        array_push( $structure['groups'][$title]["build"], $switch );

        $button_status = array(
            'type' => 'button',
            'name' => 'save',
            'value' => 'Zapisz',
        );

        array_push( $structure['groups']["submit"]["build"][0]["fields"], $button_status );

        $form = new Sf_Form( $structure, array( 'title_pattern' => '<h6><strong>%s</strong></h6>' ) );
        $response .= $form->render();

        $response .= sprintf( '<div class="mt-3"><a href="#" data-cancel="true">%s</a></div>', 'Zamknij' );

        return wp_send_json_success( array( "sf_manager_tec" => $response ) );

    }

    public static function timetable_get_time_content(){
        if( ! check_ajax_referer( 'sf_manager_timetable_time_get_content_nonce', 'nonce' ) ){
            return wp_send_json_error( "Błędny klucz weryfikacyjny." );
        }

        $term_id = $_POST['id'];
        $term_value = get_term( $term_id, 'timetable-time' );
        $title = sprintf( 'Edytuj %s', ucfirstUtf8($name) );

        $response = sprintf( '<h6><strong>%s</strong></h6></div>', $title );

        $structure = array(
            'name' => 'sf_dashboard_timetable_time_edit',
            'groups' => array()
        );
        
        $structure['groups']["editor"] = array( "show_name" => false, "build" => array() );
        $hidden_id_field = array( "type" => "single", "fields" => array());
        $hidden_id_field["fields"] = array(
            "name" => "term_id",
            "type" => "hidden",
            "value" => $term_id
        );

        $time_field = array( "type" => "single", "fields" => array());
        $time_field["fields"] = array(
            "label" => "Godzina : Minuta",
            "name" => "clock",
            "type" => "time",
            "value" => $term_value->name
        );
        array_push( $structure['groups']["editor"]["build"], $hidden_id_field, $time_field );
    
        $structure['groups']["submit"] = array( "show_name" => false, "build" => array() );
        $structure['groups']["submit"]["build"][0] = array( "type" => "nav", "fields" => array());
        
        $save_button = array(
            'type' => 'button',
            'name' => 'save',
            'value' => 'Zapisz',
        );

        $delete_button = array(
            'type' => 'button',
            'input_class' => array( 'btn-danger'),
            'name' => 'delete',
            'value' => 'Usuń',
        );

        array_push( $structure['groups']["submit"]["build"][0]["fields"], $save_button, $delete_button );

        $form = new Sf_Form( $structure, array( 'title_pattern' => '<h6><strong>%s</strong></h6>' ) );
        $response .= $form->render();

        $response .= sprintf( '<div class="mt-3"><a href="#" data-cancel="true">%s</a></div>', 'Zamknij' );

        return wp_send_json_success( array( "sf_manager_tec" =>  $response ) );
    }
 
    public static function exercises_get_name_content(){
        if( ! check_ajax_referer( 'sf_manager_exercises_get_name_content_nonce', 'nonce' ) ){
            return wp_send_json_error( "Błędny klucz weryfikacyjny." );
        }

        $post_id = $_POST['id'];

        $post = get_post( $post_id );
        $selection = wp_get_object_terms( $post_id, 'exercises-level' );
        
        $levels = array();
        $get_levels = get_terms( "exercises-level", array(
            "hide_empty" => false,
            'orderby' => 'term_id', 
            'order' => 'DESC',
        ));

        $response = sprintf( '<h6><strong>%s</strong></h6></div>', "Poziom zajęć" );

        $structure = array(
            'name' => 'sf_dashboard_exercises_name_edit',
            'groups' => array()
        );
        
        $structure['groups']["editor"] = array( "show_name" => false, "build" => array() );
        $hidden_id_field = array( "type" => "single", "fields" => array());
        $hidden_id_field["fields"] = array(
            "name" => "post_id",
            "type" => "hidden",
            "value" => $post_id
        );
        $hidden_term_id_field = array( "type" => "single", "fields" => array());
        $hidden_term_id_field["fields"] = array(
            "name" => "old_term_id",
            "type" => "hidden",
            "value" => $selection[0]->term_id
        );


        $description_field = array( "type" => "single", "fields" => array());
        $color_field = array( "type" => "single", "fields" => array());
        $submit_button = array( "type" => "single", "fields" => array());
    
        $description_field["fields"] = array(
            "label" => "Nazwa zajęć",
            "name" => "exercise_name",
            "type" => "text",
            "value" => $post->post_title
        );
    
        foreach( $get_levels as $level_key => $props ){
            $levels[$props->term_id] = $props->name;
        }
    
        $color_field["fields"] = array(
            "label" => "Poziom Trudności",
            "name" => "exercise_level",
            "type" => "select",
            "options" => $levels,
            "value" => $selection[0]->term_id
        );

        array_push( $structure['groups']["editor"]["build"], $hidden_id_field, $hidden_term_id_field, $description_field, $color_field );
    
        $structure['groups']["submit"] = array( "show_name" => false, "build" => array() );
        $structure['groups']["submit"]["build"][0] = array( "type" => "nav", "fields" => array());
        
        $save_button = array(
            'type' => 'button',
            'name' => 'save',
            'value' => 'Zapisz',
        );

        $delete_button = array(
            'type' => 'button',
            'input_class' => array( 'btn-danger'),
            'name' => 'delete',
            'value' => 'Usuń',
        );

        array_push( $structure['groups']["submit"]["build"][0]["fields"], $save_button, $delete_button );

        $form = new Sf_Form( $structure, array( 'title_pattern' => '<h6><strong>%s</strong></h6>' ) );
        $response .= $form->render();

        $response .= sprintf( '<div class="mt-3"><a href="#" data-cancel="true">%s</a></div>', 'Zamknij' );

        return wp_send_json_success( array( "sf_manager_tec" => $response ) );
    }

    public static function exercises_get_level_content(){
        if( ! check_ajax_referer( 'sf_manager_exercises_get_level_content_nonce', 'nonce' ) ){
            return wp_send_json_error( "Błędny klucz weryfikacyjny." );
        }

        $term_id = $_POST['id'];
        $term_value = get_term( $term_id, 'exercises-level' );
        $term_color = get_term_meta( $term_id, 'level_color' );

        $response = sprintf( '<h6><strong>%s</strong></h6></div>', "Poziom zajęć" );

        $structure = array(
            'name' => 'sf_dashboard_exercises_level_edit',
            'groups' => array()
        );
        
        $structure['groups']["editor"] = array( "show_name" => false, "build" => array() );
        $hidden_id_field = array( "type" => "single", "fields" => array());
        $hidden_id_field["fields"] = array(
            "name" => "term_id",
            "type" => "hidden",
            "value" => $term_id
        );

        $description_field = array( "type" => "single", "fields" => array());
        $color_field = array( "type" => "single", "fields" => array());
        $submit_button = array( "type" => "single", "fields" => array());
    
        $description_field["fields"] = array(
            "label" => "Opis",
            "name" => "level_description",
            "type" => "text",
            "value" => $term_value->name
        );
    
        $color_field["fields"] = array(
            "label" => "Kolor",
            "name" => "level_color",
            "type" => "color",
            "value" => $term_color[0]
        );
        array_push( $structure['groups']["editor"]["build"], $hidden_id_field, $description_field, $color_field );
    
        $structure['groups']["submit"] = array( "show_name" => false, "build" => array() );
        $structure['groups']["submit"]["build"][0] = array( "type" => "nav", "fields" => array());
        
        $save_button = array(
            'type' => 'button',
            'name' => 'save',
            'value' => 'Zapisz',
        );

        $delete_button = array(
            'type' => 'button',
            'input_class' => array( 'btn-danger'),
            'name' => 'delete',
            'value' => 'Usuń',
        );

        array_push( $structure['groups']["submit"]["build"][0]["fields"], $save_button, $delete_button );

        $form = new Sf_Form( $structure, array( 'title_pattern' => '<h6><strong>%s</strong></h6>' ) );
        
        $response .= $form->render();
        $response .= sprintf( '<div class="mt-3"><a href="#" data-cancel="true">%s</a></div>', 'Zamknij' );

        return wp_send_json_success( array( "sf_manager_tec" =>  $response ) );
    }

    public static function client_manager_monitor_add(){
       
        if( ! check_ajax_referer( 'client_manager_monitor_add_nonce', 'nonce' ) ){
            return wp_send_json_error( "Błędny klucz weryfikacyjny." );
        }

        $public_id = (int) mb_substr($_POST['ean'], 0, -1);
        $date = ( ! empty( $_POST['date' ] ) ) ? $_POST['date'] : '';

        if( $public_id < 150000 ){
            $monitor_data["error"] = true;
            $monitor_data["msg"] = "Nie znaleziono użytkownika.";

            return wp_send_json_error( $monitor_data );
        }

        $month = strtotime( $date );
        $register_month = date( "m", $month );

        $monitor = new Sf_Monitor( array( $public_id ) );
        $register = $monitor->add( array( $register_month => $date ) );

        return wp_send_json_success( $register );
          
    }

}