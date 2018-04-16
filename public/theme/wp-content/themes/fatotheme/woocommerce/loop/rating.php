<?php
/**
 * Single Product Rating
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$product = fatotheme_get_product();
$post = fatotheme_get_post();
if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating(); 
?>
<div class="woocommerce-product-rating on">
	<div class="star">
		<div class="star-rating" title="<?php printf(esc_attr__( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
			<span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
				<strong class="rating"><?php echo wp_kses_post( $average ); ?></strong> 
				<?php printf(esc_html__('out of %s5%s', 'woocommerce' ), '<span>', '</span>' ); ?>
				<?php echo esc_html__('based on','woocommerce'); ?>
				<span class="rating"><?php echo wp_kses_post($rating_count); ?></span>
				<?php echo esc_html__('customer rating(s)','woocommerce'); ?>
			</span>
		</div>
	</div>
	<?php if ( comments_open() ) : ?>
		<a href="<?php echo get_permalink( $product->get_id() ) ?>#reviews" class="woocommerce-review-link" rel="nofollow">
		<span class="count"><?php echo wp_kses_post($review_count); ?></span>
		<?php echo esc_html__('Review(s) / Add Your Review', 'woocommerce'); ?>
		</a>
	<?php endif ?>
</div>
