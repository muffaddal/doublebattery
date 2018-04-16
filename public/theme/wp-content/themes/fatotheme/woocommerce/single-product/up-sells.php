<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$fatotheme_theme_option = fatotheme_get_theme_option();
$product = fatotheme_get_product();
$post = fatotheme_get_post();
//$woocommerce_loop = fatotheme_get_woocommerce_loop();
global $woocommerce_loop;

$upsells = $product->get_upsell_ids();

if ( sizeof( $upsells ) == 0 ) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->get_id() ),
	'meta_query'          => $meta_query
);
$products = new WP_Query( $args );
$_id = fatotheme_make_id();
$woocommerce_loop['columns'] = $columns;
$woocommerce_loop['posts_per_page'] = $posts_per_page;
$data_plugin_options = 'data-plugin-options=\'{"items" : ' . esc_attr($columns) . ',"autoPlay": false,"pagination": false,"navigation": true}\'';
if (intval($posts_per_page) > 0):
?>
<div class="up-sells-products">
	<h2 class="widget-title"><span><?php esc_html_e( 'You may also like&hellip;', 'woocommerce' ); ?></span></h2>
	<?php if ( $products->have_posts() ) : ?>
	<div id="up-sells-<?php echo esc_attr($_id) ?>" class="owl-carousel" <?php echo wp_kses_post($data_plugin_options); ?>>
		<?php
		while ( $products->have_posts() ) : $products->the_post(); ?>
			<div class="item col-sm-12 product-carousel">
				<?php
					wc_get_template_part( 'content', 'product-carousel' );
				?>
			</div>
		<?php
		endwhile; ?>
	</div>
	<?php else: ?>
		<p><?php echo esc_html_e('Have no product!', 'woocommerce') ?></p>
	<?php endif; ?>
</div>
<?php
endif;
wp_reset_postdata();