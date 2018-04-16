<?php
/**
 * WARNING: This file is part of the theme. DO NOT edit
 * this file under any circumstances.
 */

/**
 * Prevent direct access to this file
 */
defined( 'ABSPATH' ) or die();

/**
 * Assets management class
 */
class LaneThemes_Assets
{
	/**
	 * Class instance handler
	 * 
	 * @var  LaneThemes_Advanced
	 */
	private static $instance;

	/**
	 * Initialize advanced theme settings section
	 * 
	 * @return  void
	 */
	public static function instance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
			self::$instance->hooks();
		}

		return self::$instance;
	}

	/**
	 * Method to register actions/filters hooks
	 * 
	 * @return  void
	 */
	private function hooks() {
		add_action( 'init',                 array( $this, 'register' ), 5 );
	}

	/**
	 * Register assets
	 * 
	 * @return  void
	 */
	public function register() {
		$theme = wp_get_theme( get_template_directory() );

		wp_register_style( 'theme-sample-data', get_template_directory_uri() . '/admin/assets/css/sample-data.css', array(), $theme->get( 'Version' ) );
		wp_register_script( 'theme-sample-data', get_template_directory_uri() . '/admin/assets/js/sample-data.js', array( 'jquery' ), $theme->get( 'Version' ), true );
	}
}

/**
 * Initialize assets management
 */
LaneThemes_Assets::instance();
