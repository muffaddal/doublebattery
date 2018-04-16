<?php
/**
 * Single Product Sale Flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$fatotheme_theme_option = fatotheme_get_theme_option();
$product = fatotheme_get_product();
$post = fatotheme_get_post();
$woocommerce_loop = fatotheme_get_woocommerce_loop();
?>
<?php if ( $product->is_on_sale() ) : ?>

	<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale"><span>' . esc_html__( 'Sale', 'woocommerce' ) . '</span></span>', $post, $product ); ?>

<?php endif; ?>