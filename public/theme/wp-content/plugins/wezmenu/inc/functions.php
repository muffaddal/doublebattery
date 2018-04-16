<?php
add_action( 'plugins_loaded' , 'wezmenu_load_textdomain' );
function wezmenu_load_textdomain(){
	load_plugin_textdomain( 'wezmenu' , false , WEZMENU_BASEDIR.'/languages' );
}

add_action( 'wp_enqueue_scripts' , 'wezmenu_menu_load_assets' );
function wezmenu_menu_load_assets() {
	$settings = $settings = get_option(WEZMENU_SETTING_OPTIONS);
	$load_plugin_css = 1;
	if ($settings && isset($settings['setting-plugin-css'])) {
		$load_plugin_css = $settings['setting-plugin-css'];
	}

	$load_font_awesome = 1;
	if ($settings && isset($settings['setting-font-awesome'])) {
		$load_font_awesome = $settings['setting-font-awesome'];
	}

	wp_enqueue_style( 'wezmenu-menu-amination', WEZMENU_URL. 'assets/css/amination.css' );

	if ($load_plugin_css) {
		wp_enqueue_style( 'wezmenu-menu-style', WEZMENU_URL. 'assets/css/style.min.css' );
	}

	if ($load_font_awesome) {
		wp_enqueue_style( 'wezmenu_fontawesome_css', WEZMENU_URL. 'assets/css/fonts-awesome/css/font-awesome.min.css' );
	}
}

add_action('wp_footer', 'wezmenu_footer_css');
function wezmenu_footer_css() {
	global $wezmenu_queue_css;
	$settings = $settings = get_option(WEZMENU_SETTING_OPTIONS);
	$load_plugin_css = 1;
	if ($settings && isset($settings['setting-plugin-css'])) {
		$load_plugin_css = $settings['setting-plugin-css'];
	}

	if (isset($wezmenu_queue_css) && is_array($wezmenu_queue_css) && $load_plugin_css) {
		foreach ($wezmenu_queue_css as $key => $value) {
			if ($key == 'wezmenu-default') {
				continue;
			}
			wp_enqueue_style( 'wezmenu-menu-style-' . $key, WEZMENU_URL. 'assets/css/' . $value );
		}
	}

	wp_enqueue_script( 'wezmenu-menu-js', WEZMENU_URL. 'assets/js/app.min.js' , array( 'jquery' ) , WEZMENU_VERSION , true );
	global $wezmenu_queue_script_data;
	if (isset($wezmenu_queue_script_data) && is_array($wezmenu_queue_script_data)) {
		foreach ($wezmenu_queue_script_data as $key => $value) {
			if ($key == 'wezmenu-default') {
				wp_localize_script( 'wezmenu-menu-js' , 'wezmenu_meta' , $wezmenu_queue_script_data[$key] );
				unset($wezmenu_queue_script_data[$key]);
				break;
			}
		}
		wp_localize_script( 'wezmenu-menu-js' , 'wezmenu_meta_custom' , $wezmenu_queue_script_data);
	}


}

function wezmenu_get_attachment_id_from_url( $attachment_url = '' ) {

	global $wpdb;
	$attachment_id = false;

	// If there is no url, return.
	if ( '' == $attachment_url )
		return;

	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();

	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

	}

	return $attachment_id;
}
