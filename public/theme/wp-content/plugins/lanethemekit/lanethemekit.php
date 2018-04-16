<?php
/**
 * Plugin Name: Lanethemekit
 * Plugin URI: http://lanethemes.com/
 * Description: Lanethemekit
 * Version: 1.0.1
 * Author: Lanethemekit
 * Author URI: http://lanethemes.com/
 * License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: lanethemekit
 * Domain Path: /languages
 */

// include WXR file parsers
$lanethemekit_path = dirname( __FILE__ );
$lanethemekit_url = plugin_dir_url( __FILE__ );

define( 'LANETHEMEKIT_PLUGIN_PATH', $lanethemekit_path );
define( 'LANETHEMEKIT_PLUGIN_URL', $lanethemekit_url );
define( 'PLG_VISUAL_COMPOSER_ACTIVED', in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );
define( 'LANETHEMEKIT_PAGEBUILDER_URI', plugin_dir_url( __FILE__ ). 'pagebuilder/' );

// Extend widgets
require_once $lanethemekit_path . '/widgets/widget_posts.php';
require_once $lanethemekit_path . '/extendpost/footer.php';

// Page builder
if(PLG_VISUAL_COMPOSER_ACTIVED)
{
	require_once $lanethemekit_path . '/pagebuilder/vc_map.php';
	$_path = $lanethemekit_path.'/pagebuilder/classes/';
	$files = glob($_path.'*.php');
	foreach ($files as $key => $file) {
		if(is_file($file)){
			require_once($file);
		}
	}
}

//load textdomain
add_action( 'plugins_loaded' , 'lanethemekit_load_textdomain' );
function lanethemekit_load_textdomain(){
    load_plugin_textdomain( 'lanethemekit' , false , LANETHEMEKIT_PLUGIN_PATH.'/languages' );
}

//limit get excerpt
function lane_limit_get_excerpt($limit,$afterlimit='[...]') 
{
    $excerpt = get_the_excerpt();
    if($excerpt != ''){
       $excerpt = explode(' ', strip_tags($excerpt), $limit);
    }else{
        $excerpt = explode(' ', strip_tags(get_the_content( )), $limit);
    }
    if (count($excerpt)>=$limit) {
        array_pop($excerpt); 
        $excerpt = implode(" ",$excerpt).' '.$afterlimit;
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    if ($afterlimit == '') {
        $excerpt = preg_replace('([?:[!]+|&hellip;])',' ',$excerpt);
    } else {
        $excerpt = trim(preg_replace('([?:[!]+|&hellip;])',' ',$excerpt)).''.$afterlimit;
    }
    return strip_shortcodes( $excerpt );
}

// WooCommerce - Function get Query
function lane_woocommerce_query($type,$post_per_page=-1,$cat_ids='',$paged='')
{
   $query_args = lane_woocommerce_query_args($type,$post_per_page,$cat_ids,$paged);
   return new WP_Query($query_args);
}
// WooCommerce - Function Query Args
function lane_woocommerce_query_args($type,$post_per_page=-1,$cat_ids='',$paged='')
{
    global $woocommerce, $product; $tax_query=array();
    //remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_popularity_post_clauses' ) );
    remove_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
    if($paged == '') {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    }
    switch ($type) {
        case 'upsells':
            $upsells = $product->get_upsell_ids();

            $query_args = array(
                'post_type'           => 'product',
                'ignore_sticky_posts' => 1,
                'no_found_rows'       => 1,
                'post__in'            => $upsells,
                'post__not_in'        => array( $product->get_id() ),
                'meta_query'          => WC()->query->get_meta_query(),
            );
            break;
        case 'best_selling':
            $query_args = array(
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page'      => $post_per_page,
                'meta_key'            => 'total_sales',
                'orderby'             => 'meta_value_num',
                'meta_query'          => WC()->query->get_meta_query(),
                'tax_query'           => WC()->query->get_tax_query(),
            );
            if ( ! empty( $cat_ids ) ) {
                if ( empty( $query_args['tax_query'] ) ) {
                    $query_args['tax_query'] = array();
                }
                $query_args['tax_query'][] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'terms'    => array_map( 'sanitize_title', explode( ',', $cat_ids ) ),
                        'field'    => 'slug',
                        'operator' => 'IN',
                    ),
                );
            }
            break;
        case 'featured_product':
            $meta_query  = WC()->query->get_meta_query();
            $tax_query   = WC()->query->get_tax_query();
            $tax_query[] = array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN',
            );
            $query_args = array(
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page'      => $post_per_page,
                'meta_query'          => $meta_query,
                'tax_query'           => $tax_query,
            );
            if ( ! empty( $cat_ids ) ) {
                if ( empty( $query_args['tax_query'] ) ) {
                    $query_args['tax_query'] = array();
                }
                $query_args['tax_query'][] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'terms'    => array_map( 'sanitize_title', explode( ',', $cat_ids ) ),
                        'field'    => 'slug',
                        'operator' => 'IN',
                    ),
                );
            }
            break;
        case 'top_rate':
            $query_args = array(
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
                'orderby'             => 'title',
                'order'               => 'asc',
                'posts_per_page'      => $post_per_page,
                'meta_query'          => WC()->query->get_meta_query(),
                'tax_query'           => WC()->query->get_tax_query(),
            );
            if ( ! empty( $cat_ids ) ) {
                if ( empty( $query_args['tax_query'] ) ) {
                    $query_args['tax_query'] = array();
                }
                $query_args['tax_query'][] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'terms'    => array_map( 'sanitize_title', explode( ',', $cat_ids ) ),
                        'field'    => 'slug',
                        'operator' => 'IN',
                    ),
                );
            }
            add_filter('posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses'));
            break;
        case 'recent_product':
            $query_args = array(
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page'      => $post_per_page,
                'orderby'             => 'date',
                'order'               => 'desc',
                'meta_query'          => WC()->query->get_meta_query(),
                'tax_query'           => WC()->query->get_tax_query(),
            );
            if ( ! empty( $cat_ids ) ) {
                if ( empty( $query_args['tax_query'] ) ) {
                    $query_args['tax_query'] = array();
                }
                $query_args['tax_query'][] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'terms'    => array_map( 'sanitize_title', explode( ',', $cat_ids ) ),
                        'field'    => 'slug',
                        'operator' => 'IN',
                    ),
                );
            }
            break;
        case 'on_sale':
            $query_args = array(
                'posts_per_page' => $post_per_page,
                'orderby'        => 'title',
                'order'          => 'asc',
                'no_found_rows'  => 1,
                'post_status'    => 'publish',
                'post_type'      => 'product',
                'meta_query'     => WC()->query->get_meta_query(),
                'tax_query'      => WC()->query->get_tax_query(),
                'post__in'       => array_merge( array( 0 ), wc_get_product_ids_on_sale() ),
            );
            if ( ! empty( $cat_ids ) ) {
                if ( empty( $query_args['tax_query'] ) ) {
                    $query_args['tax_query'] = array();
                }
                $query_args['tax_query'][] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'terms'    => array_map( 'sanitize_title', explode( ',', $cat_ids ) ),
                        'field'    => 'slug',
                        'operator' => 'IN',
                    ),
                );
            }
            break;
        case 'recent_review':
            if($post_per_page == -1) $_limit = 4;
            else $_limit = $post_per_page;
            global $wpdb;
            $query = "SELECT c.comment_post_ID FROM {$wpdb->prefix}posts p, {$wpdb->prefix}comments c WHERE p.ID = c.comment_post_ID AND c.comment_approved > 0 AND p.post_type = 'product' AND p.post_status = 'publish' AND p.comment_count > 0 ORDER BY c.comment_date ASC LIMIT 0, ". $_limit;
            $results = $wpdb->get_results($query, OBJECT);
            $_pids = array();
            foreach ($results as $re) {
                $_pids[] = $re->comment_post_ID;
            }

            //$query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            //$query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            $query_args['post__in'] = $_pids;
            break;
        case 'deals':
            $query_args = array(
                'posts_per_page' => $post_per_page,
                'orderby'        => 'title',
                'order'          => 'asc',
                'no_found_rows'  => 1,
                'post_status'    => 'publish',
                'post_type'      => 'product',
                'meta_key'       => '_sale_price_dates_to',
                'meta_value'     => '0',
                'meta_compare'     => '>',
                'meta_query'     => WC()->query->get_meta_query(),
                'tax_query'      => WC()->query->get_tax_query(),
                'post__in'       => array_merge( array( 0 ), wc_get_product_ids_on_sale() ),
            );
            if ( ! empty( $cat_ids ) ) {
                if ( empty( $query_args['tax_query'] ) ) {
                    $query_args['tax_query'] = array();
                }
                $query_args['tax_query'][] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'terms'    => array_map( 'sanitize_title', explode( ',', $cat_ids ) ),
                        'field'    => 'slug',
                        'operator' => 'IN',
                    ),
                );
            }
            break;
    }
    
    return $query_args;
}