<?php
/**
 * WARNING: This file is part of the theme. DO NOT edit
 * this file under any circumstances.
 */
defined( 'ABSPATH' ) or exit;

// lib for theme framework
require_once(get_template_directory() . '/lib/metabox/meta-item.php'  );
require_once(get_template_directory() . '/admin/options.php' );
require_once(get_template_directory() . '/lib/lib.php' );
require_once(get_template_directory() . '/admin/class-tgm-plugin-activation.php');
require_once(get_template_directory() . '/lib/function.php' );

//Multiple Sidebars
include_once get_template_directory() . '/lib/widgets/multiple_sidebars.php';

// theme widgets
require_once(get_template_directory() . '/lib/widgets/lane-class-widget.php');
require_once(get_template_directory() . '/lib/widgets/product-upsell.php');
require_once(get_template_directory() . '/lib/widgets/search-widget.php');
require_once(get_template_directory() . '/lib/includes/breadcrumb.php' );
require_once(get_template_directory() . '/lib/includes/filter.php' );
require_once(get_template_directory() . '/lib/includes/search-ajax-action.php' );
require_once(get_template_directory() . '/lib/includes/search-product-ajax-action.php' );

// woocommerce
if(class_exists('WooCommerce')) {
	require_once get_template_directory() . '/lib/includes/class-wc-product-data-fields.php';
	require_once(get_template_directory() . '/lib/woocommerce/woocommerce.php' );
}

if ( version_compare( PHP_VERSION, '5.3', '>=' ) ):
    
    // Classes
    require_once get_template_directory() . '/lib/assets.php';
    require_once get_template_directory() . '/lib/autoload.php';

    // Register class mapping
    LaneThemes_AutoLoad::map( 'LaneThemes_', get_template_directory() . '/lib/classes/' );
    LaneThemes_AutoLoad::register();

    // Initialize the theme
    LaneThemes_Admin::instance();
endif;

if ( is_admin() ) {
    require_once get_template_directory() . '/admin/functions-plugins.php';
}

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since lanethemes 1.0.0
 */
function fatotheme_javascript_detection() {
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'fatotheme_javascript_detection', 0 );

/*==========================================================================
Styles & Scripts
==========================================================================*/
if (file_exists(get_template_directory_uri() .'/assets/css/custom-editor-style.css')) {
    function fatotheme_add_editor_styles() {
        add_editor_style( 'custom-editor-style.css' );
    }
    add_action( 'admin_init', 'fatotheme_add_editor_styles' );
}

function fatotheme_init_styles_scripts()
{
    global $fatotheme_theme_option;
    $theme = wp_get_theme( get_template_directory() );
	$protocol = is_ssl() ? 'https:' : 'http:';
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){
  		wp_enqueue_script( 'comment-reply' );
	}
    wp_enqueue_style('fatotheme-icons', get_template_directory_uri() .'/assets/icons/icons.css', array(), $theme->get( 'Version' ), 'all');
    wp_enqueue_style('bootstrap', get_template_directory_uri() .'/assets/lib/bootstrap/css/bootstrap.min.css', array(), $theme->get( 'Version' ), 'all');
    wp_enqueue_style('bootstrap-theme', get_template_directory_uri() .'/assets/lib/bootstrap/css/bootstrap-theme.min.css', array(), $theme->get( 'Version' ), 'all');
    if(class_exists('WooCommerce'))
    {
	   wp_enqueue_style('fatotheme-woocommerce', get_template_directory_uri() .'/assets/css/woocommerce.css', array(), $theme->get( 'Version' ), 'all');
    }
    if ($fatotheme_theme_option['promo_popup']=='1') {
        wp_enqueue_style('magnific-popup', get_template_directory_uri() .'/assets/lib/magnific-popup/magnific-popup.css', array(), $theme->get( 'Version' ), 'all');
        wp_enqueue_script('magnific-popup', get_template_directory_uri() .'/assets/lib/magnific-popup/jquery.magnific-popup.js', array('jquery'), $theme->get( 'Version' ), true);
    }
    //Owl Carousel Assets
    wp_enqueue_style('owl-carousel', get_template_directory_uri() .'/assets/lib/owl-carousel/owl.carousel.css', array(), $theme->get( 'Version' ), 'all');
    wp_enqueue_style('owl-theme', get_template_directory_uri() .'/assets/lib/owl-carousel/owl.theme.css', array(), $theme->get( 'Version' ), 'all');
    wp_enqueue_style('owl-transitions', get_template_directory_uri() .'/assets/lib/owl-carousel/owl.transitions.css', array(), $theme->get( 'Version' ), 'all');
    if ($fatotheme_theme_option['header_is_search']=='1') {
        wp_enqueue_style('perfect-scrollbar', get_template_directory_uri() .'/assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css', array(), $theme->get( 'Version' ), 'all');
        wp_enqueue_script('perfect-scrollbar-jquery', get_template_directory_uri() .'/assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js', array('jquery'), $theme->get( 'Version' ), true);
    }   
    wp_enqueue_style('fatotheme-main', get_template_directory_uri() .'/assets/css/style.css', array(), $theme->get( 'Version' ), 'all');
    if(is_rtl()){
        wp_enqueue_style('fatotheme-rtl', get_template_directory_uri() .'/assets/css/rtl.css', array(), $theme->get( 'Version' ), 'all');
    }
    // Load the html5 shiv.
    wp_enqueue_script( 'html5', get_template_directory_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
    wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
    wp_enqueue_script('bootstrap', get_template_directory_uri() .'/assets/lib/bootstrap/js/bootstrap.min.js', array('jquery'), $theme->get( 'Version' ), true);
    wp_enqueue_script('jquery-tipr', get_template_directory_uri() .'/assets/lib/jquery-tipr/jquery.tipr.js', array('jquery'), $theme->get( 'Version' ), true);
    if(!class_exists('Vc_Manager') || !class_exists('WooCommerce')){
    wp_enqueue_script('jquery-prettyPhoto', get_template_directory_uri() .'/assets/js/jquery.prettyPhoto.js', array('jquery'), $theme->get( 'Version' ), true);
    }
    wp_enqueue_script('owl-carousel', get_template_directory_uri() .'/assets/lib/owl-carousel/owl.carousel.min.js', array('jquery'), $theme->get( 'Version' ), true);
    if($fatotheme_theme_option['is-effect-scroll']=='1'){
        wp_enqueue_script('jquery-wow', get_template_directory_uri() .'/assets/js/jquery.wow.min.js', array('jquery'), $theme->get( 'Version' ), true);
    }
    wp_enqueue_script('jquery-cookie', get_template_directory_uri() .'/assets/js/jquery.cookie.js', array('jquery'), $theme->get( 'Version' ), true);
	wp_enqueue_script('fatotheme-theme', get_template_directory_uri() .'/assets/js/theme.js', array('jquery'), $theme->get( 'Version' ), true);
	
    /*==========================================================================
    Style Switcher
    ==========================================================================*/
    if ($fatotheme_theme_option['enable_sswitcher']=='1') {
        // Add styleswitcher.js file
        wp_enqueue_script('fatotheme-styleswitcher', get_template_directory_uri() .'/assets/js/styleswitcher.js', array('jquery'), $theme->get( 'Version' ), true);
        // Load styleswitcher css style
        wp_enqueue_style('fatotheme-styleswitcher', get_template_directory_uri() .'/assets/css/styleswitcher.css', array(), $theme->get( 'Version' ), 'all' );
    }
}
add_action( 'wp_enqueue_scripts','fatotheme_init_styles_scripts' );

/**
 * @snippet       Display Product Height, Length, Width @ Shop Page - WooCommerce
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=21982
 * @author        Rodolfo Melogli
 * @compatible    WC 2.6.14, WP 4.7.2, PHP 5.5.9
 */
 
add_action( 'woocommerce_single_product_summary', 'cj_show_dimensions', 40 );
function cj_show_dimensions() {
    global $product;
    $dimensions = $product->get_dimensions();
        if ( ! empty( $dimensions ) ) {
                echo '<span class="dimensions">' . $dimensions . '</span>';
        }
}
//print_r(get_template_directory_uri());die;
if (is_woocommerce() && is_archive()) {
    wp_enqueue_script( 'theme', get_template_directory_uri() . '/assets/js/theme.js', array("jquery"));
    add_thickbox();
}
