<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$fatotheme_theme_option = fatotheme_get_theme_option();
$wp_query = fatotheme_get_wp_query();
$post = fatotheme_get_post();
if($post!=null) {
    if( $post->post_type=='product' ) {
      $post_id = get_option( 'woocommerce_shop_page_id' );
    } else {
      $post_id = $post->ID;
    }
}
if($post!=null) {
    $is_breadcrumb = get_post_meta( (int)$post_id, '_fatotheme_show_page_header', true )?true:false;
}
$page_heading = $fatotheme_theme_option['page_title'] ? true : false;
if($post!=null) {
    $page_heading = $is_breadcrumb ? true : false;
}
$option_page_heading_url = $fatotheme_theme_option['page_title_bg']['url'];
if($post!=null) {
    $page_heading_img_url = get_post_meta( (int)$post_id, '_fatotheme_page_heading_background', true );
}
$page_title_bg_url = !empty($page_heading_img_url) ? $page_heading_img_url : $option_page_heading_url;
$page_title_bg = !empty($page_title_bg_url) ? (' style="background-image:url('.$page_title_bg_url.');"') : '';

get_header( 'shop' );

/**
 * woocommerce_before_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action( 'woocommerce_before_main_content' );
?>
<?php get_template_part('archive-product', 'top') ?>
<div class="container main-content-container<?php echo ($page_heading) ? '' : ' main-hasno-pagehead' ?>">
    <div class="row">
        <section id="lane-main-content" class="<?php echo apply_filters( 'fatotheme_main_class', '' ); ?> clearfix">
            <?php do_action( 'woocommerce_archive_description' ); ?>

            <?php if ( have_posts() ) : ?>

                <div id="catalog-layout-switcher" class="category-filter clearfix">
                    <?php
                    /**
                     * woocommerce_before_shop_loop hook
                     *
                     * @hooked woocommerce_result_count - 20
                     * @hooked woocommerce_catalog_ordering - 30
                     */
                    do_action( 'woocommerce_before_shop_loop' );
                    ?>
                </div>

                <?php woocommerce_product_loop_start(); ?>

                <?php woocommerce_product_subcategories(); ?>
                
                <?php while ( have_posts() ) : the_post(); ?>

                    <?php wc_get_template_part( 'content', 'product' ); ?>

                <?php endwhile; // end of the loop. ?>

                <?php woocommerce_product_loop_end(); ?>
                
                <?php if ( $wp_query->max_num_pages > 1 ): ?>
                <div class="lane-paging-footer clearfix">
                    <?php
                    /**
                     * woocommerce_after_shop_loop hook
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    do_action( 'woocommerce_after_shop_loop' );
                    ?>
                </div>
                <?php endif; ?>
            <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

                <?php wc_get_template( 'loop/no-products-found.php' ); ?>

            <?php endif; ?>
        </section>

        <?php do_action('fatotheme_sidebar_render'); ?>
    </div>
</div>
<?php
/**
 * woocommerce_after_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );
?>
<?php get_footer( 'shop' ); ?>