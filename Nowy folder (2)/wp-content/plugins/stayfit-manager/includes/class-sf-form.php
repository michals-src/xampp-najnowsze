<?php

if( ! defined( "ABSPATH" ) ){
    exit;
}

Class Sf_Form{
    
    private static $_instance;

    private $action;

    private $method;

    private $form;

    private $view_options;

    private $name;

    public static $error;

    public static function instance( $form_structure = [] ){
        if( ! isset( self::$_instance ) ) self::$_instance = new Sf_Form( $form_structure );
        return self::$_instance;
    }

    public function __construct( $form_structure = [], $view_options = [] ){

        $form_default = [
            "name" => null,
            "redirect" => null,
            "groups" => []
        ];

        $view_options_default = array(
            'title_pattern' => '<h4>%s</h4>'
        );

        if( ! empty( $form_structure ) )
        {  
            $this->view_options = array_replace( $view_options_default, $view_options );
            $this->name = $form_structure["name"];
            $this->form = $this->createForm( $form_structure );
        }

    }

    protected function createForm( $form_structure ){

        $nonce = $this->name . '_submit-nonce';
        //action="'. admin_url('admin-post.php') .'"
        $content = '<form  method="post">';

        if( Sf_Form::hasError( 'error_' . $this->name, 'form_notice/error' )->has_error ){
            $content .= '<div class="alert alert-danger" role="alert">'. Sf_Form::hasError( 'error_' . $this->name, 'form_notice/error' )->message .'</div>';
        }

        if( Sf_Form::hasError( 'error_' . $this->name, 'form_notice/success' )->has_error ){
            $content .= '<div class="alert alert-success" role="alert">'. Sf_Form::hasError( 'error_' . $this->name, 'form_notice/success' )->message .'</div>';
        }


        $content .=	'<input type="hidden" name="action" value="submit_' . $this->name . '">';
        $content .=	'<input type="hidden" name="error" value="error_' . $this->name . '">';
        $content .=	'<input type="hidden" name="redirect_url" value="' . $form_structure["redirect_url"] . '">';
        $content .=	'<input type="hidden" id="' . $nonce . '" name="'. $this->name .'-nonce_field" value="' . wp_create_nonce( $nonce ) . '">';

        foreach( $form_structure["groups"] as $group_name => $properties ){

            if( $properties["show_name"] === true ){
                $title_pattern = sprintf( $this->view_options['title_pattern'], $group_name );
                $content .= sprintf( '<div class="col-xs-12 p-0 mb-2">%s</div>', $title_pattern );
            }
            
            $content .= $this->scan_fields( $properties );

        }


        $content .= '</form>';

        return $content;

    }


    private function scan_fields( $fields = [] ){

        $content = '';

        foreach( $fields["build"] as $field_key => $field_props ){

            if( $field_props["type"] === "row" ){
                $content .= '<div class="form-row">';
                foreach( $field_props['fields'] as $key => $field_row ){
                    $field_row["row"] = "true";
                    $content .= $this->create_field( $field_row );
                }
                $content .= '</div>';
            }

            if( $field_props["type"] === "nav" ){
                $content .= '<div class="nav">';
                foreach( $field_props['fields'] as $key => $field_row ){
                    $field_row["nav"] = "true";
                    $content .= $this->create_field( $field_row );
                }
                $content .= '</div>';
            }
            
            if( $field_props["type"] === "single" ){
                $content .= $this->create_field( $field_props['fields'] );
            }

        }

        return $content;

    }

    private function create_field( $properties = [] ){

        $field = '';

        switch($properties["type"]){

            case "text":
            case "password":
            case "email":
            case "number":
            case "color":
            case "datetime-local":
            case "hidden":
            case "month":
            case "reset":
            case "submit":
            case "tel":
            case "time":
            case "week":
            case "date":
                $field = $this->default_field( $properties );
                break;
            case "textarea":
                $field = $this->textarea_field( $properties );
                break;
            case "select":
                $field = $this->select_field( $properties );
                break;
            case "switch":
            case "checkbox":
            case "radio":
                $field = $this->check_field( $properties );
                break;
            case "file":
                $field = $this->file_field( $properties );
                break;
            case "range":
                $field = $this->range_field( $properties );
                break;
            case "button":
                $field = $this->button_field( $properties );
                break;
            case "a":
                $field = $this->a_field( $properties );
                break;
            
        }

        return $field;

    }

    private function field_classes( $properties = [] ){

        $form_classes = ["form-group"];

        if( ! empty( $properties["class"] ) ){
            $form_classes = array_merge( $form_classes, $properties["class"] );
        }else if( empty( $properties["class"] ) && ! empty( $properties["row"] ) ){
            $form_classes[] = "col";
        }

        return join( ' ', $form_classes );

    }
    
    private function field_name( $name = '' ){

        $content = '';
        $name = explode( "/", $name );

        $content .= '['. $name[0] .']';

        unset( $name[0] );
        $name = array_values( $name );
        if( count( $name ) > 0 ){
            $content .= $this->field_name( join('/', $name) );
        }

        return $content;

    }

    private function field_input_atts( $properties = [], $is_input = true ){

        $atts = [];
        
        if( ! empty( $properties["type"] ) ){
            $atts[] = 'type="' . $properties["type"] . '"';
        }
        if( ! empty( $properties["name"] ) ){
            $atts[] = 'name="' . $this->name . $this->field_name( $properties["name"] ) . '"';
        }
        if( ! empty( $properties["id"] ) ){
            $atts[] = 'id="' . $properties["id"] . '"';
        } 

        $classes = [];
        if( $is_input === true ){
            $classes[] = "form-control";
        }
        if( ! empty( Sf_Form::hasError( 'error_' . $this->name, $properties["name"] )->has_error ) ){
            $classes[] = "is-invalid";
        }
        if( ! empty( $properties["input_class"] ) ){
            $classes = array_merge( $classes, $properties["input_class"] );
        }
        

        $atts[] = 'class="' . join( ' ', $classes ) . '"';

        if( ! empty( $properties["placeholder"] ) ){
            $atts[] = 'placeholder="' . $properties["placeholder"] . '"';
        }
        if( is_numeric( $properties["value"] ) || is_string( $properties["value"] ) ){
            $atts[] = 'value="' . $properties["value"] . '"';
        }
        if( ! empty( $properties["hidden"] ) ){
            $atts[] = 'hidden="' . $properties["hidden"] . '"';
        }
        if( is_numeric( $properties["min"] ) || is_string( $properties["min"] ) ){
            $atts[] = 'min="' . $properties["min"] . '"';
        }
        if( is_numeric( $properties["max"] ) || is_string( $properties["max"] ) ){
            $atts[] = 'max="' . $properties["max"] . '"';
        }  
        if( ! empty( $properties["rows"] ) ){
            $atts[] = 'rows="' . $properties["rows"] . '"';
        }
        if( ! empty( $properties["cols"] ) ){
            $atts[] = 'cols="' . $properties["cols"] . '"';
        }
        if( ! empty( $properties["step"] ) ){
            $atts[] = 'step="' . $properties["step"] . '"';
        }

        if( ! empty( $properties["data"] ) ){
            foreach( $properties["data"] as $data => $value ){
                $atts[] = 'data-'. $data . '="'. $value .'"';
            }
        }

        if( ! empty( $properties["disabled"] ) ){
            $atts[] = 'disabled="' . $properties["disabled"] . '"';
        }
        if( ! empty( $properties["checked"] )){
            $atts[] = 'checked=""';
        }
        if( ! empty( $properties["required"] ) ){
            $atts[] = 'required';
        }

        return join( ' ', $atts );

    }
    
    private function label_field( $properties = [] ){
        $label  = '';
        if( ! empty( $properties["label"] ) ){
            $for = ( ! empty( $properties["id"] ) ) ? 'for="' . $properties["id"] . '"' : '';
            $class = ( ! empty( $properties["label_class"] ) ) ? 'class="' . join( " ", $properties["label_class"] ) . '"' : '';
            $label = "<label ". $class ." ". $for .">". $properties["label"] ."</label>";
        }
        return $label;
    }

    private function default_field( $properties ){

        $content = '<div class="' . $this->field_classes( $properties ) . '">';
        $content .= $this->label_field( $properties );
        $content .= "<input " . $this->field_input_atts( $properties ) . ">";
        if( ! empty( Sf_Form::hasError( 'error_' . $this->name, $properties["name"] )->has_error ) ) {
            $content .= '<div class="invalid-feedback">'. Sf_Form::hasError( 'error_' . $this->name, $properties["name"] )->message .'</div>';
        }
        if( ! empty( $properties['after_field'] ) ){
            $content .= $properties['after_field'];
        }
        $content .= '</div>';

        return $content;

    }


    private function textarea_field( $properties ){
        
        $content = '<div class="' . $this->field_classes( $properties ) . '">';
        $content .= $this->label_field( $properties );
        $content .= "<textarea " . $this->field_input_atts( $properties ) . ">";
        if( ! empty(  $properties["value"] ) ){
            $content .=  $properties["value"];
        }
        $content .= "</textarea>";
        if( ! empty( Sf_Form::hasError( 'error_' . $this->name, $properties["name"] )->has_error ) ) {
            $content .= '<div class="invalid-feedback">'. Sf_Form::hasError( 'error_' . $this->name, $properties["name"] )->message .'</div>';
        }
        $content .= '</div>';

        return $content;

    }
    private function select_field( $properties ){

        $content = '<div class="' . $this->field_classes( $properties ) . '">';
        $content .= $this->label_field( $properties );
        $content .= "<select " . $this->field_input_atts( $properties ) . ">";
        foreach( $properties["options"] as $value => $name ){
            $selected = ( ! empty( $properties["value"] ) && $properties["value"] == $value ) ? "selected" : "";
            if( is_array( $name ) )
            {
                $content .= '<option value="'. $value .'" ' . $this->field_input_atts( $name ) . ' '. $selected .'>'. $name['name'] .'</option>';
            }else{
                $content .= '<option value="'. $value .'" '. $selected .'>'. $name .'</option>';
            }
        }
        $content .= "</select>";
        if( ! empty( Sf_Form::hasError( 'error_' . $this->name, $properties["name"] )->has_error ) ) {
            $content .= '<div class="invalid-feedback">'. Sf_Form::hasError( 'error_' . $this->name, $properties["name"] )->message .'</div>';
        }
        $content .= "</div>";

        return $content;

    }
    private function check_field( $properties ){
       
        $properties["input_class"] = ["custom-control-input"];
        $properties["label_class"] = ["custom-control-label"];

        $content = '<div class="' . $this->field_classes( $properties ) . '">';
        $content .= '<div class="custom-control custom-'. $properties["type"] .'">';
        if( $properties["type"] === "switch" ){
            $properties["type"] = "checkbox";
        }
        $content .= "<input " . $this->field_input_atts( $properties ) . ">";
        $content .= $this->label_field( $properties );
        if( ! empty( Sf_Form::hasError( 'error_' . $this->name, $properties["name"] )->has_error ) ) {
            $content .= '<div class="invalid-feedback">'. Sf_Form::hasError( 'error_' . $this->name, $properties["name"] )->message .'</div>';
        }
        $content .= "</div></div>";

        return $content;

    }
    private function file_field( $properties ){

        $properties["input_class"] = ["custom-file-input"];
        $properties["label_class"] = ["custom-file-label"];

        $content = '<div class="' . $this->field_classes( $properties ) . '"><div class="custom-file">';
        $content .= "<input " . $this->field_input_atts( $properties ) . ">";
        $content .= $this->label_field( $properties );
        if( ! empty( Sf_Form::hasError( 'error_' . $this->name, $properties["name"] )->has_error ) ) {
            $content .= '<div class="invalid-feedback">'. Sf_Form::hasError( 'error_' . $this->name, $properties["name"] )->message .'</div>';
        }
        $content .= "</div></div>";

        return $content;

    }
    private function range_field( $properties ){

        $properties["input_class"] = ["custom-range"];

        $content = '<div class="' . $this->field_classes( $properties ) . '">';
        $content .= $this->label_field( $properties );
        $content .= "<input " . $this->field_input_atts( $properties ) . ">";
        if( ! empty( Sf_Form::hasError( 'error_' . $this->name, $properties["name"] )->has_error ) ) {
            $content .= '<div class="invalid-feedback">'. Sf_Form::hasError( 'error_' . $this->name, $properties["name"] )->message .'</div>';
        }
        $content .= "</div>";

        return $content;

    }
    private function button_field( $properties ){
        
        $content = '';

        if( ! empty( $properties["type"] ) ){
            unset( $properties["type"] );
        }
        
        if( ! empty( $properties['nav'] ) ){
            $content .= '<li class="nav-item">';
        }

        if( empty( $properties["input_class"] ) ){
            $properties["input_class"] = array();
        }

        array_push( $properties["input_class"], 'btn');
        array_push( $properties["input_class"], 'btn-primary');
        
        $content .= '<button type="submit" ' . $this->field_input_atts( $properties, false ) . '>' . $properties["value"] . '</button>';
        
        if( ! empty( $properties['nav'] ) ){
            $content .= '</li>';
        }

        return $content;
    }
    private function a_field( $properties ){
        $content = '';

        if( ! empty( $properties["type"] ) ){
            unset( $properties["type"] );
        }

        if( ! empty( $properties['nav'] ) ){
            $content .= '<li class="nav-item">';
            $properties["input_class"][] = "nav-link";
        }
        
        $content .= '<a href="'. $properties["href"] .'" ' . $this->field_input_atts( $properties, false ) . '>' . $properties["value"] . '</a>';
        
        if( ! empty( $properties['nav'] ) ){
            $content .= '</li>';
        }
        
        return $content;
    }

    private function notice_field( /* $text, $type = "info"  */ ){ }
    private function desc_field( /* $text, $type = "info"  */ ){ }












    public static function addError( $error_name = '', $error_data = '' ){

        if( ! empty( $error_name ) && is_string( $error_name ) ) {
            
            if( ! is_array( self::$error ) ){
                self::$error = array();
            }

            if( ! array_key_exists( $error_name, self::$error ) ){
                self::$error[ $error_name ] = $error_data;
            }
        }

    }

    protected static function getError( $error_name = '' ){

        if( ! empty( $error_name ) && is_string( $error_name ) && is_array( self::$error ) ) {
            if( array_key_exists( $error_name, self::$error ) ){
                return self::$error[ $error_name ];
            }
        }

        return '';

    }

    public static function hasError( $error_name = '', $path = '' ){

        $error = array(
            'has_error' => false,
            'message' => ''
        );

        if( ! is_array( self::$error ) ){
            self::$error = array();
        }

        $errors = self::getError( $error_name );


        if( ! empty( $errors ) )
        {


            $full_path = explode( "/", $path );
            $first_level = array_key_exists( $full_path[0] , $errors ) ? $errors[$full_path[0]] : '';
                
            $path = array_slice( $full_path, 1 );

            $current_level = $first_level;

            if( ! empty( $current_level ) ){
                for( $x = 0; $x < count( $path ); $x++ ){
                    $current_level = $current_level[ $path[$x] ];
                }
                if( ! empty( $current_level ) ){
                    $error['has_error'] = true;
                    $error['message'] = $current_level;
                }
            }
        }

        return (object) $error;

    }

    public static function is_empty( $args = array() ){

        $abc = array();

        foreach( $args as $key => $value){

            if( is_array( $value ) ){
                $child = self::is_empty( $value );
                if( ! empty( $child ) ){
                    $abc[$key] = $child;
                }
            }else{

                if( empty( $value ) ){
                    $abc[$key] = "Pole nie może być puste";
                }

            }
        }

    return $abc;

    }

    public function render(){
        return $this->form;
    }

}
