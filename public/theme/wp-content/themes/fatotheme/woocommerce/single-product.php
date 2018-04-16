<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$fatotheme_theme_option = fatotheme_get_theme_option();
$product = fatotheme_get_product();
$post = fatotheme_get_post();
$woocommerce_loop = fatotheme_get_woocommerce_loop();
if($post!=null) {
    if( $post->post_type=='product' ) {
      $post_id = get_option( 'woocommerce_shop_page_id' );
    } else {
      $post_id = $post->ID;
    }
}
if($post!=null) {
    $is_breadcrumb = get_post_meta( $post_id, '_fatotheme_show_page_header', true )?true:false;
}
$page_heading = $fatotheme_theme_option['page_title'] ? true : false;
if($post!=null) {
    $page_heading = $is_breadcrumb ? true : false;
}
$option_page_heading_url = $fatotheme_theme_option['page_title_bg']['url'];
if($post!=null) {
    $page_heading_img_url = get_post_meta( $post_id, '_fatotheme_page_heading_background', true );
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
<?php get_template_part('single-product', 'top') ?>
<div class="container main-content-container<?php echo ($page_heading) ? '' : ' main-hasno-pagehead' ?>">
	<div class="row">
		<section id="lane-main-content" class="<?php echo apply_filters( 'fatotheme_main_class', '' ); ?>">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php wc_get_template_part( 'content', 'single-product' ); ?>

			<?php endwhile; // end of the loop. ?>
		</section>		
		<?php do_action('fatotheme_sidebar_render'); ?>
	</div>
</div>

<?php 
//echo "1";die;
	/**
	 * woocommerce_after_main_content hook
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action( 'woocommerce_after_main_content' );
?>
<?php get_footer( 'shop' ); ?>