<?php
/**
 * Content-Widget-Product
 *
 * Contains the markup for the content-widget-product.
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.5.0
 */

$product = fatotheme_get_product();
$post = fatotheme_get_post();
$class = $is_deals = '';
$time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
if($is_deals){
    $class .= ' is-deal';
}
?>
<div class="product widget-product <?php echo esc_attr($class); ?>">
    <div class="product-block">
        <div class="image">
            <?php woocommerce_show_product_loop_sale_flash(); ?>
            <?php do_action('fatotheme_woocommerce_show_product_loop_new_flash'); ?>
            <a href="<?php the_permalink(); ?>">
                <?php
                /**
                 * @hooked woocommerce_template_loop_product_thumbnail - 10
                 */
                do_action( 'fatotheme_woocommerce_template_loop_product_thumbnail' );
                ?>
            </a>
        </div>
        <div class="product-meta">
            <h4 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <?php woocommerce_template_loop_rating(); ?>
            <div class="price">
                <?php echo wp_kses_post($product->get_price_html()); ?>
            </div>
            <?php woocommerce_template_single_excerpt(); ?>
            <div class="product-button-action btn-cart-action clearfix">
            <?php
                /**
                 * woocommerce_before_shop_loop_item_title hook
                 */
                do_action( 'fatotheme_woocommerce_shop_loop_item_button_action' );
            ?>
            </div>
            <?php if ($time_sale) { ?>
            <div class="time-sale clearfix">
                <span class="countdown" data-countdown="<?php echo esc_attr(date('M j Y H:i:s O',$time_sale)); ?>"></span></div>
            <?php } ?>
        </div>
    </div>
</div>