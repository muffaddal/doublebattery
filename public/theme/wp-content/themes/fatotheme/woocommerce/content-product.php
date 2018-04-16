<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$product = fatotheme_get_product();
$post = fatotheme_get_post();
global $woocommerce_loop;

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
    return;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) || (isset($_GET['layout']) && $_GET['layout']==1) )
    $woocommerce_loop['columns'] = apply_filters( 'wc_loop_shop_columns', 3 );

// Extra post classes
$classes = array(); 
if (isset($_GET['layout']) && $_GET['layout']==1) $woocommerce_loop['columns']=4;
if (isset($_GET['layout']) && ($_GET['layout']==4 || $_GET['layout']==5 || $_GET['layout']==6)) $woocommerce_loop['columns']=2;
$classes = apply_filters( 'fatotheme_woocommerce_column_class' , $classes );
$time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
?>
<div <?php post_class( $classes ); ?>>
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
            <?php if ($time_sale) { ?>
                <span class="countdown" data-countdown="<?php echo esc_attr(date('M j Y H:i:s O',$time_sale)); ?>"></span>
            <?php } ?>
            <?php do_action('fatotheme_woocommerce_attributes') ?>
            <div class="product-button-action button-func">
                <?php do_action( 'fatotheme_woocommerce_shop_loop_item_button_action' ); ?>
                <?php //do_action('fatotheme_woocommerce_shop_loop_item_button_quickview'); ?>
            </div>
        </div>
        <div class="product-info">
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
                woocommerce_template_single_excerpt();
            ?>
            <div class="addtocart-bottom-button"><?php fatotheme_woocommerce_addtocart_bottom_button(); ?></div>
        </div>
    </div>
</div>