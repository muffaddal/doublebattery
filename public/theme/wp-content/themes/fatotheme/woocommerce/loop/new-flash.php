<?php
/**
 * Product loop new flash
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$product = fatotheme_get_product();
$post = fatotheme_get_post();
$product_new = get_post_meta(get_the_ID(),'fatotheme_product_new',true);
?>

<?php if ($product_new == 'yes') : ?>
	<?php echo apply_filters( 'fatotheme_new_flash', '<span class="onnew"><span>' . esc_html__( 'New', 'woocommerce') . '</span></span>', $post, $product ); ?>
<?php endif; ?>

