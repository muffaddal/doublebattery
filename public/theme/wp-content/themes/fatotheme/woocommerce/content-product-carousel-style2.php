<?php
$product = fatotheme_get_product();
$time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
?>
<div class="product<?php if($time_sale) echo ' product-deals-carousel'; ?>">
    <div class="product-block">
        <div class="product-block-inner">
            <div class="image">
                <?php woocommerce_show_product_loop_sale_flash(); ?>
                <?php do_action('fatotheme_woocommerce_show_product_loop_new_flash'); ?>
                <a class="product-thumbnail" href="<?php the_permalink(); ?>">
                    <?php
                    /**
                     * @hooked woocommerce_template_loop_product_thumbnail - 10
                     */
                    do_action( 'fatotheme_woocommerce_template_loop_product_thumbnail' );
                    ?>
                </a>
                <?php do_action('fatotheme_woocommerce_attributes') ?>
                <?php do_action('fatotheme_woocommerce_shop_loop_item_button_quickview'); ?>
            </div>
            <div class="product-info">
                <?php if ($time_sale): ?>
                <div class="deal-time">
                        <span class="countdown" data-countdown="<?php echo esc_attr(date('M j Y H:i:s O',$time_sale)); ?>"></span>
                </div>
                <?php endif; ?>
                <h4 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                <?php 
                    /**
                     * fatotheme_woocommerce_shop_loop_item_excerpt hook
                     */
                    woocommerce_template_single_excerpt();
                 ?>
                <div class="product-cat">
                    <?php
                    /**
                     * fatotheme_woocommerce_template_loop_category hook
                     */
                    do_action('fatotheme_woocommerce_template_loop_category');
                    ?>
                </div>
                <?php 
                    /**
                     * fatotheme_woocommerce_shop_loop_item_price hook
                     */
                    woocommerce_template_loop_rating();
                    do_action( 'fatotheme_woocommerce_shop_loop_item_price' );
                 ?>
                <div class="product-button-action button-func">
                    <?php do_action( 'fatotheme_woocommerce_shop_loop_item_button_action' ); ?>
                </div>
            </div>
        </div>
    </div>
</div>