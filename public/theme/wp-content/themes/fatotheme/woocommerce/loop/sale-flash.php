<?php
/**
 * Product loop sale flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$product = fatotheme_get_product();
$post = fatotheme_get_post();
?>
<?php 
if ( $product->is_on_sale() ) :
	echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale"><span>' . esc_html__( 'Sale', 'woocommerce' ) . '</span></span>', $post, $product ); 
endif; ?>