<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$product = fatotheme_get_product();
$ajax_add_to_cart = ((get_option('woocommerce_enable_ajax_add_to_cart')=='yes') && ($product->is_type( 'simple' ))) ? ' ajax_add_to_cart' : ' non_ajax_add_to_cart';

echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<a href="%s" title="' . esc_attr( $product->add_to_cart_text() ) . '" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s btn-cart'.$ajax_add_to_cart.' btn-addtocart">%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( $product->get_id() ),
		esc_attr( $product->get_sku() ),
		esc_attr( isset( $quantity ) ? $quantity : 1 ),
		$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
		'<span class="cart-text">' . esc_html( $product->add_to_cart_text() ) . '</span>'
	),
$product );