<?php
$product = fatotheme_get_product();
$time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
?>
<div class="product<?php if($time_sale) echo ' product-deals-carousel'; ?>">
    <div class="product-block">
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
            <?php if ($time_sale) { ?>
                <span class="countdown" data-countdown="<?php echo esc_attr(date('M j Y H:i:s O',$time_sale)); ?>"></span>
            <?php } ?>
            <?php do_action('fatotheme_woocommerce_attributes'); ?>
            <div class="product-button-action button-func">
                <?php do_action( 'fatotheme_woocommerce_shop_loop_item_button_action' ); ?>
                <?php //do_action('fatotheme_woocommerce_shop_loop_item_button_quickview'); ?>
            </div>
        </div>
        <div class="product-cat">
            <?php
            /**
             * fatotheme_woocommerce_template_loop_category hook
             */
            do_action('fatotheme_woocommerce_template_loop_category');
            ?>
        </div>
        <h4 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        <?php 
            /**
             * fatotheme_woocommerce_shop_loop_item_price hook
             */
            do_action( 'fatotheme_woocommerce_shop_loop_item_price' );
            woocommerce_template_loop_rating();
         ?>
        <div class="addtocart-bottom-button"><?php fatotheme_woocommerce_addtocart_bottom_button(); ?></div>
        <?php 
            /**
             * _woocommerce_shop_loop_excerpt hook
            */
            woocommerce_template_single_excerpt();
         ?>
    </div>
</div>