<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$product = fatotheme_get_product();
$post = fatotheme_get_post();
$woocommerce = fatotheme_get_woocommerce();
?>
<div class="product-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
	<p class="price"><?php echo wp_kses_post($product->get_price_html()); ?></p>
	<meta itemprop="price" content="<?php echo esc_attr($product->get_price()); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo wp_kses_post($product->is_in_stock()) ? 'InStock' : 'OutOfStock'; ?>" />
</div>