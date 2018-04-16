<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$woocommerce = fatotheme_get_woocommerce();
$qty = WC()->cart->get_cart_contents_count();
do_action( 'woocommerce_before_mini_cart' ); ?>

<div class="cart-toggler icon-toggler">
	<a class="get-cart" href="javascript:void(0)">
		<span class="mini-cart-link">
			<i class="icons icon-handbag"></i><span class="cart-title"><?php esc_html_e('My cart: ', 'woocommerce');?></span>
			<span class="cart-quantity">
				<?php echo esc_html($qty); ?><span class="quantity-label"><?php esc_html_e('Items','fatotheme') ?></span>
			</span>
			<span class="total"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
		</span>
	</a>
	<div class="mini_cart_content content-toggler">
		<div class="mini_cart_inner">
			<div class="mini_cart_arrow"></div>
			<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
				<ul class="cart_list product_list_widget">
					<?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

							$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
							$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
							$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );

							?>
							<li id="mcitem-<?php echo esc_attr($cart_item_key); ?>">
								<?php if (!$_product->is_visible()) { ?>
									<?php echo str_replace(array('http:', 'https:'), '', $thumbnail) . $product_name; ?>
								<?php } else { ?>
									<a href="<?php echo get_permalink($product_id); ?>">
										<?php echo str_replace(array('http:', 'https:'), '', $thumbnail) . $product_name; ?>
									</a>
								<?php } ?>

								<?php echo WC()->cart->get_item_data($cart_item); ?>

								<?php echo apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], $product_price) . '</span>', $cart_item, $cart_item_key); ?>

								<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" onclick="Theme_MiniCart_Remove(\'%s\', \'%s\');return false;" class="cart-item-remove" title="%s">x</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), $cart_item_key, esc_html__( 'Remove this item', 'woocommerce' ) ), $cart_item_key ); ?>
							</li>
							<?php
						}
					}
					?>
				</ul><!-- end product list -->
			<?php else: ?>
				<ul class="cart_empty">
					<li class="empty"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></li>
					<li class="total"><?php esc_html_e( 'Total', 'woocommerce' ); ?>: <?php echo WC()->cart->get_cart_subtotal(); ?></li>
				</ul>
			<?php endif; ?>

			<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

				<p class="total"><?php esc_html_e( 'Total', 'woocommerce' ); ?>: <?php echo WC()->cart->get_cart_subtotal(); ?></p>

				<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

				<p class="buttons">
					<a href="<?php echo esc_url(WC()->cart->get_checkout_url()); ?>" class="button checkout"><?php esc_html_e( 'Checkout', 'woocommerce' ); ?></a>
					<a href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" class="button cart"><?php esc_html_e( 'View Cart', 'woocommerce' ); ?></a>
				</p>

			<?php endif; ?>
		</div>
		<div class="loading"></div>
	</div>
</div>
<?php do_action( 'woocommerce_after_mini_cart' ); ?>