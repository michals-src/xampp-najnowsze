<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Imagery_Upsell_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		require_once( trailingslashit( get_template_directory() ) . 'customizer-upsell/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Imagery_Upsell_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Imagery_Upsell_Customize_Section_Pro(
				$manager,
				'imagery_upsell',
				array(
					'title'    => esc_html__( 'Imagery Pro', 'imagery' ),
					'description'    => esc_html__( 'Get more customization options and one-to-one support', 'imagery' ),
					'pro_text' => esc_html__( 'Get Pro',         'imagery' ),
					'pro_url'  => 'http://dinevthemes.com/themes/imagery-pro/',
					'priority'    => 0,
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {
		wp_enqueue_script( 'imagery-upsell-customize-controls', trailingslashit( get_template_directory_uri() ) . 'customizer-upsell/customize-controls.js', array( 'customize-controls' ) );
		wp_enqueue_style( 'imagery-upsell-customize-controls', trailingslashit( get_template_directory_uri() ) . 'customizer-upsell/customize-controls.css' );
	}
}

// Doing this customizer thang!
Imagery_Upsell_Customize::get_instance();
