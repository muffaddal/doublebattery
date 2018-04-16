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
 * @package  LaneThemes
 */
class LaneThemes_Admin extends LaneThemes_Base
{
	public function __construct() {
		if ( is_admin() ) {
			/**
			 * Initialize sample data installer
			 */
			LaneThemes_SampleData::instance();
		}
	}
}
