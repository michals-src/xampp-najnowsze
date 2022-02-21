<?php


if( ! defined( "ABSPATH" ) ){
    exit;
}

Class Sf_Post_type{

    public static function init(){      
        add_action( 'init', array( __CLASS__, "register" ) );
    }

    public function register(){

      self::post_type();
      self::taxonomy();

    }

    private function post_type(){

        $timetable_singular = "Timetable";
        $timetable_plural = "Timetable";

        $exercises_singular = "Ćwiczenie";
        $exercises_plural = "Zajęcia";
    
        register_post_type( 'exercises', self::post_type_args( $exercises_plural, $exercises_singular ) );
        register_post_type( 'timetable', self::post_type_args( $timetable_plural, $timetable_singular ) );
        register_post_type( 'monitor_stats', self::post_type_args( "Statystyk", "Statystyki" ) );
    
      }
    
      private function taxonomy(){
        
        $plural = "Godziny";
        $singular = "Godzina";
    
        $labels = array(
          'name'                       => $plural,
              'singular_name'              => $singular,
              'search_items'               => 'Search ' . $plural,
              'popular_items'              => 'Popular ' . $plural,
              'all_items'                  => 'All ' . $plural,
              'parent_item'                => null,
              'parent_item_colon'          => null,
              'edit_item'                  => 'Edit ' . $singular,
              'update_item'                => 'Update ' . $singular,
              'add_new_item'               => 'Add New ' . $singular,
              'new_item_name'              => 'New ' . $singular . ' Name',
              'separate_items_with_commas' => 'Separate ' . $plural . ' with commas',
              'add_or_remove_items'        => 'Add or remove ' . $plural,
              'choose_from_most_used'      => 'Choose from the most used ' . $plural,
              'not_found'                  => 'No ' . $plural . ' found.',
              'menu_name'                  => $plural,
        );
    
        $args = array(
              'hierarchical'          => true,
              'labels'                => $labels,
              'show_ui'               => true,
              'show_admin_column'     => true,
              'update_count_callback' => '_update_post_term_count',
              'query_var'             => true,
              'rewrite'               => array( 'slug' => $slug ),
        );

        $plural = "Poziom";
        $singular = "Poziomy";
    
        $labels = array(
          'name'                       => $plural,
              'singular_name'              => $singular,
              'search_items'               => 'Search ' . $plural,
              'popular_items'              => 'Popular ' . $plural,
              'all_items'                  => 'All ' . $plural,
              'parent_item'                => null,
              'parent_item_colon'          => null,
              'edit_item'                  => 'Edit ' . $singular,
              'update_item'                => 'Update ' . $singular,
              'add_new_item'               => 'Add New ' . $singular,
              'new_item_name'              => 'New ' . $singular . ' Name',
              'separate_items_with_commas' => 'Separate ' . $plural . ' with commas',
              'add_or_remove_items'        => 'Add or remove ' . $plural,
              'choose_from_most_used'      => 'Choose from the most used ' . $plural,
              'not_found'                  => 'No ' . $plural . ' found.',
              'menu_name'                  => $plural,
        );
    
        $args = array(
              'hierarchical'          => true,
              'labels'                => $labels,
              'show_ui'               => true,
              'show_admin_column'     => true,
              'update_count_callback' => '_update_post_term_count',
              'query_var'             => true,
              'rewrite'               => array( 'slug' => $slug ),
        );

        register_taxonomy('exercises-level', 'exercises', $args);
        register_taxonomy('timetable-time', 'timetable', $args);
    
      }

      private function post_type_args( $plural, $singular ){

        $labels = array(
          'name'      => $plural,
          'singular_name'   => $singular,
          'add_new'     => 'Add New',
          'add_new_item'    => 'Add New ' . $singular,
          'edit'            => 'Edit',
          'edit_item'         => 'Edit ' . $singular,
          'new_item'          => 'New ' . $singular,
          'view'      => 'View ' . $singular,
          'view_item'     => 'View ' . $singular,
          'search_term'     => 'Search ' . $plural,
          'parent'    => 'Parent ' . $singular,
          'not_found'     => 'No ' . $plural .' found',
          'not_found_in_trash'  => 'No ' . $plural .' in Trash'
        );
    
        $args = array(
          'labels'              => $labels,
            'public'              => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'show_in_nav_menus'   => false,
            'show_ui'             => false,
            'show_in_menu'        => false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 10,
            'menu_icon'           => 'dashicons-businessman',
            'can_export'          => true,
            'delete_with_user'    => false,
            'hierarchical'        => false,
            'has_archive'         => true,
            'query_var'           => true,
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            // 'capabilities' => array(),
            'rewrite'             => array(
                'slug' => $slug,
                'with_front' => true,
                'pages' => true,
                'feeds' => true,
            ),
            'supports'            => array()
        );

        return $args;

      }

}

Sf_Post_type::init();