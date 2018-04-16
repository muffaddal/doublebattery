<?php $product = fatotheme_get_product(); ?>
<div class="product">
    <div class="product-block">
		<div class="image">
	        <?php woocommerce_show_product_loop_sale_flash(); ?>
	        <?php do_action( 'fatotheme_woocommerce_show_product_loop_new_flash' ); ?>
	        <a href="<?php the_permalink(); ?>">
	            <?php
                    /**
                     * woocommerce_template_loop_product_thumbnail hooked
                     */
                    do_action( 'fatotheme_woocommerce_template_loop_product_thumbnail' );
                 ?>
	        </a>
            <?php do_action('fatotheme_woocommerce_attributes') ?>
		</div>
		<div class="product-meta">
            <h4 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <?php woocommerce_template_loop_rating(); ?>
            <div class="price">
                <?php echo wp_kses_post($product->get_price_html()); ?>
            </div>
            <?php woocommerce_template_single_excerpt(); ?>
            <div class="product-button-action clearfix">
            <?php 
                //do_action( 'woocommerce_after_shop_loop_item' ); 
                do_action('fatotheme_after_shop_loop_item_add_to_cart');
                do_action( 'fatotheme_woocommerce_shop_loop_item_button_action' );
            ?>
            </div>
        </div>
	</div>
</div>