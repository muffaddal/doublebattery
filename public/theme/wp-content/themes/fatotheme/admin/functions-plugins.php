<?php
/**
 * WARNING: This file is part of the theme. DO NOT edit
 * this file under any circumstances.
 */
defined( 'ABSPATH' ) or die();


/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 *
 * @return  void
 */
function nanocare_register_requirement_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
        array(
            'name'                     => 'WooCommerce', // The plugin name
            'slug'                     => 'woocommerce', // The plugin slug (typically the folder name)
            'required'                 => true, // If false, the plugin is only 'recommended' instead of required
        ),
        array(
            'name'                     => 'Redux Framework', // The plugin name
            'slug'                     => 'redux-framework', // The plugin slug (typically the folder name)
            'required'                 => true, // If false, the plugin is only 'recommended' instead of required
        ),
        array(
            'name'                     => 'Contact Form 7', // The plugin name
            'slug'                     => 'contact-form-7', // The plugin slug (typically the folder name)
            'required'                 => true, // If false, the plugin is only 'recommended' instead of required
        ),
        array(
            'name'                     => 'YITH WooCommerce Wishlist', // The plugin name
            'slug'                     => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
            'required'                 => true
        ),
        array(
            'name'                     => 'YITH Woocommerce Compare', // The plugin name
            'slug'                     => 'yith-woocommerce-compare', // The plugin slug (typically the folder name)
            'required'                 => true
        ),
        array(
            'name'                     => 'MailChimp for WordPress', // The plugin name
            'slug'                     => 'mailchimp-for-wp', // The plugin slug (typically the folder name)
            'required'                 => true, // If false, the plugin is only 'recommended' instead of required
        ),
        array(
            'name'                     => 'Meta Box', // The plugin name
            'slug'                     => 'meta-box', // The plugin slug (typically the folder name)
            'required'                 => true
        ),
        array(
            'name'                     => 'WPBakery Visual Composer', // The plugin name
            'slug'                     => 'js_composer', // The plugin slug (typically the folder name)
            'required'                 => true,
            'source'                   => 'http://demo.lanethemes.com/packages/plugins/js_composer.zip', // The plugin source
        ),
        array(
            'name'                     => 'Revolution Slider', // The plugin name
            'slug'                     => 'revslider', // The plugin slug (typically the folder name)
            'required'                 => true, // If false, the plugin is only 'recommended' instead of required
            'source'                   => 'http://demo.lanethemes.com/packages/plugins/revslider.zip', // The plugin source
        ),
		array(
            'name'                     => 'Lanethemekit', // The plugin name
            'slug'                     => 'lanethemekit', // The plugin slug (typically the folder name)
            'required'                 => true,
            'source'                   => 'http://demo.lanethemes.com/packages/plugins/lanethemekit.zip', // The plugin source
        ),
        array(
            'name'                     => 'WezMenu - The Mega Menu For WordPress', // The plugin name
            'slug'                     => 'wezmenu', // The plugin slug (typically the folder name)
            'required'                 => true,
            'source'                   => 'http://demo.lanethemes.com/packages/plugins/wezmenu.zip', // The plugin source
        )
    );

	tgmpa( $plugins, array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => ''
	) );
}
add_action( 'tgmpa_register', 'nanocare_register_requirement_plugins' );
