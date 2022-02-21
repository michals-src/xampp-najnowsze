<?php
function add_query_vars_filter( $vars ){
    $vars[] = "abc";
    return $vars;
}

add_filter( 'query_vars', 'add_query_vars_filter' );

function custom_rewrite_rule() {
    add_rewrite_tag( '%abc%', '([^&]+)' );
    add_rewrite_rule('^foo/([^/]*)/?','index.php?page_id=8&abc=$matches[1]','top');



  }
  add_action('init', 'custom_rewrite_rule', 10, 0);

  
  add_action( 'parse_query', 'wpse9870_parse_request' );
function wpse9870_parse_request( &$wp )
{
    if ( array_key_exists( 'abc', $wp->query_vars ) ) {
        echo get_query_var('abc');
        
    }
    return;
}

function ucfirstUtf8($str) {
    if (mb_check_encoding($str, 'UTF-8')) {       
        $first = mb_substr(mb_strtoupper($str, 'UTF-8'), 0, 1, 'UTF-8');       
        return $first . mb_substr(mb_strtolower($str, 'UTF-8'), 1, mb_strlen($str), 'UTF-8');   
    } else {    
        return $str;
    }
}

function email_validate( $data ){
    
    if( ! is_string( $data ) ){
        return;
    }

    $regexp = '/[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z0-9]{2,6}/';
    $match = preg_match( $regexp, $data );
    return $match;
}

/**
 * Conditions
 */
    function is_dashboard(){    
        global $wp;
        return ( !empty( $wp->query_vars["pagename"] ) && $wp->query_vars["pagename"] === "panel-administracyjny") ? true : false;
    }

    function is_dashboard_endpoint(){  
        global $wp;  
        return (is_dashboard() && !empty(  $wp->query_vars['page'] )) ? true : false;
    }

    function is_dashboard_general(){    
        return (is_dashboard_endpoint() && $_GET['page'] === "general") ? true : false;
    }

    function is_dashboard_notices(){    
        return (is_dashboard_endpoint() && $_GET['page'] === "notices") ? true : false;
    }

    function is_dashboard_exercises(){    
        return (is_dashboard_endpoint() && $_GET['page'] === "exercises") ? true : false;
    }

    function is_dashboard_timetable(){    
        return (is_dashboard_endpoint() && $_GET['page'] === "timetable") ? true : false;
    }

    function is_dashboard_pricing(){    
        return (is_dashboard_endpoint() && $_GET['page'] === "pricing") ? true : false;
    }


/**
 * ********************
 *
 *   TEMPLATE
 *
 * ********************
 */
    function sf_manager_dashboard_navigation(){

        $navigation = array(
            "endpoints" => '',
            "permalink" => get_permalink()
        );

        $dashboard = sfm()->Dashboard();
        $current_view = $dashboard->current_view;

        $navigation["endpoints"] = array();

        foreach( $dashboard->endpoints as $key => $endpoint ){
            $endpoint["class"] = "";

            if( $endpoint["slug"] === $current_view ){
                $endpoint["class"] = "active";
            }
            $navigation["endpoints"][] = $endpoint;
        }


        return $navigation;
    }

    function sf_manager_dashboard_content(){

        $dashboard = sfm()->Dashboard();

        if( method_exists( $dashboard, $dashboard->current_view ) ){ // Check if page exists *$endpoint[0]

            $current_view = $dashboard->current_view; // Default view
            $subpage = array();

            // Sprawdzanie widoku, czy podstrona
            if( false !== $dashboard->subpage &&
                is_string( $dashboard->subpage ) ){

                    $subpage = array( $dashboard->subpage );

            }

            call_user_func_array( array( $dashboard, $current_view ), $subpage );
        }


    }
    add_action( "sf_manager_dashboard_content", "sf_manager_dashboard_content" );


    function sf_manager_dashboard_nav(){
        $content = '<ul style="list-style: none;text-align: left;margin: 0;padding:0;">';

        foreach( sf_manager_dashboard_navigation()["endpoints"] as $endpoint_key => $endpoint ){
            $content .= '<li style="display:inline-block;margin-right: 30px;">';
            $content .= '<a class="' . $endpoint['class'] . '" href="' . sf_manager_dashboard_url( $endpoint['slug'] ) . '" style="color: #777;text-decoration: none;">';
            $content .= $endpoint["label"];
            $content .= '</a>';
            $content .= '</li>';
        }

       $content .= '</ul>';
       echo $content; 
    }
    add_action( 'sf_manager_dashboard_nav', 'sf_manager_dashboard_nav' );


    function sf_manager_dashboard_url( $slug = '' ){
        $page = ( ! empty( $slug ) ) ? '?p=' . $slug : '';
        return get_permalink() . $page;
    }

/**
 * ********************
 *
 *   SF DASHBOARD Zajęcia
 *
 * ********************
 */

    function sf_manager_dashboard_exercises_names(){
        $template = new Sf_template( 'dashboard/exercises/names' );
        $template->get();
    }
      add_action( "sf_manager_dashboard_exercises_names", "sf_manager_dashboard_exercises_names" );

    function sf_manager_dashboard_exercises_levels(){
        $template = new Sf_template( 'dashboard/exercises/levels' );
        $template->get();
    }
      add_action( "sf_manager_dashboard_exercises_levels", "sf_manager_dashboard_exercises_levels" );

    function sf_manager_exercises_get_names(){
        $names = get_posts(array(
            'post_type' => 'exercises',
            'post_status'=> 'publish',
        ));
        return $names;
    }
    function sf_manager_exercises_get_levels(){
        $levels = get_terms( "exercises-level", array(
            "hide_empty" => false,
            'orderby' => 'term_id', 
            'order' => 'DESC',
        ));
        return $levels;
    }
    function sf_manager_exercises_get_level_color( $id ){
        $color = get_term_meta( $id, "level_color" );
        return $color[0];
    }

    function sf_manager_exercises_name_create_form(){
        $levels = array();
        $get_levels = sf_manager_exercises_get_levels();
       
        $form = array(
            "name" => "sf_dashboard_exercises_name_create",
            "redirect_url" => get_permalink(),
            "groups" => array(
                "scheme" => array( "show_name" => false, "build" => array()),
            )
        );

        $description_field = array( "type" => "single", "fields" => array());
        $color_field = array( "type" => "single", "fields" => array());
        $submit_button = array( "type" => "single", "fields" => array());

        $description_field["fields"] = array(
            "label" => "Nazwa zajęć",
            "name" => "exercise_name",
            "type" => "text",
            'placeholder' => 'Nazwa zajęć',
            "disabled" => ( ! empty( $get_levels ) ) ? false : true,
        );

        if( ! empty( $get_levels ) ){
            foreach( $get_levels as $level_key => $props ){
                $levels[$props->term_id] = $props->name;
            }
        }else{
            $levels['null'] = 'Brak poziomów trudności';
        }

        $color_field["fields"] = array(
            "label" => "Poziom Trudności",
            "name" => "exercise_level",
            "type" => "select",
            "disabled" => ( ! empty( $get_levels ) ) ? false : true,
            "options" => $levels
        );

        $submit_button["fields"] = array(
            "name" => "save",
            "type" => "button",
            "disabled" => ( ! empty( $get_levels ) ) ? false : true,
            "value" => "Dodaj"
        );

        array_push( $form["groups"]["scheme"]["build"], $description_field, $color_field, $submit_button );

        $sf_form = new Sf_Form( $form );
        return $sf_form->render();    
    }

    function sf_manager_exercises_level_create_form(){
        $form = array(
            "name" => "sf_dashboard_exercises_level_create",
            "groups" => array(
                "scheme" => array( "show_name" => false, "build" => array()),
            )
        );

        $description_field = array( "type" => "single", "fields" => array());
        $color_field = array( "type" => "single", "fields" => array());
        $submit_button = array( "type" => "single", "fields" => array());

        $description_field["fields"] = array(
            "label" => "Opis",
            "name" => "level_description",
            "type" => "text",
            'placeholder' => 'Nazwa, opis, czas trwania zajęć'
        );

        $color_field["fields"] = array(
            "label" => "Kolor",
            "name" => "level_color",
            "type" => "color"
        );

        $submit_button["fields"] = array(
            "name" => "save",
            "type" => "button",
            "value" => "Dodaj"
        );

        array_push( $form["groups"]["scheme"]["build"], $description_field, $color_field, $submit_button );

        $sf_form = new Sf_Form( $form );
        return $sf_form->render();  
    }

    function sf_manager_exercises_name_data( $term_id, $action, $nonce ){
        $data = array(
            "id" => $term_id,
            "action" => $action,
            "nonce" => wp_create_nonce( $nonce )
        );
        return $data;
    }



/**
 * ********************
 *
 *   SF DASHBOARD Grafik
 *
 * ********************
 */

    function sf_manager_timetable_days(){
        $days = Sf_Dashboard::get_timetable_scheme()[0];
        return $days;
    }

    function sf_manager_timetable_day_data( $name, $status, $schedule, $action, $nonce ){
        $schedule = ( ! empty( $schedule ) ) ? $schedule : false;
        $data = array(
            'name' => $name,
            'status' => $status,
            'schedule' => $schedule,
            "action" => $action,
            "nonce" => wp_create_nonce( $nonce )
        );
        
        return $data; 
    }

    function sf_manager_dashboard_timetable_days(){
        $template = new Sf_template( 'dashboard/timetable/days' );
        $template->get();
    }
      add_action( 'sf_manager_dashboard_timetable_days', 'sf_manager_dashboard_timetable_days' );

    function sf_manager_timetable_get_time(){
        $time = get_terms( 'timetable-time' );
        return $time; 
    }

    function sf_manager_timetable_time_create_form(){

        $form = array(
            "name" => "sf_dashboard_timetable_time_create",
            "groups" => array(
                "scheme" => array( "show_name" => false, "build" => array()),
            )
        );

        $time_field = array( "type" => "single", "fields" => array());
        $submit_button = array( "type" => "single", "fields" => array());

        $time_field["fields"] = array(
            "label" => "Godzina : Minuta",
            "name" => "clock",
            "type" => "time"
        );

        $submit_button["fields"] = array(
            "name" => "save",
            "type" => "button",
            "value" => "Dodaj"
        );

        array_push( $form["groups"]["scheme"]["build"], $time_field, $submit_button );

        $sf_form = new Sf_Form( $form );
        return $sf_form->render();

    }

    function sf_manager_timetable_time_data( $term_id, $action, $nonce ){
        $data = array(
            "id" => $term_id,
            "action" => $action,
            "nonce" => wp_create_nonce( $nonce )
        );
        return $data;
    }

    function sf_manager_dashboard_timetable_time(){
        $template = new Sf_template( 'dashboard/timetable/time' );
        $template->get();
    }
      add_action( 'sf_manager_dashboard_timetable_time', 'sf_manager_dashboard_timetable_time' );










function sf_manager_client_manager_navigation(){
    $nav = array(
        array( 
            "slug"  => "client_manager.lista",
            "label" => "Lista osób",
            "icon"  => "people",
            'url'   => 'lista'
        ),
        array( 
            "slug"  => "client_manager.create",
            "label" => "Dodaj osobę",
            "icon"  => "person-add",
            'url'   => 'dodaj'
        ),
        array( 
            "slug"  => "client_manager.raport",
            "label" => "Raport aktywności",
            "icon"  => "stats",
            'url'   => 'raporty'
        ),
        array( 
            "slug"  => "client_manager.scanner",
            "label" => "Skaner",
            "icon"  => "barcode",
            'url'   => 'skaner'
        )
    );

    return $nav;
}

function sf_manager_dashboard_client_manager_list(){
    
    $template = new Sf_template( 'dashboard/timetable/days' );
    $template->get();

}
add_action( 'sf_manager_dashboard_client-manager-list', 'sf_manager_dashboard_client_manager_list' );

function sf_manager_ajax_data( $action = '', $nonce = '', $extra = array() ){

    if( empty( $action ) || empty( $nonce ) || ! is_string( $action ) || ! is_string( $nonce ) ){
        wp_die( '<strong>sf_manager_ajax_data</strong> : \"Nazwa akcji lub/i chwilowy jest pusty lub złego typu.\"' );
    }

    $default = array(
        "action" => $action,
        "nonce" => wp_create_nonce( $nonce )
    );

    $data = array_merge( $default, $extra );


    return $data;
}