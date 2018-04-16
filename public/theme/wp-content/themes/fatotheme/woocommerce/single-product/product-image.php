<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;
$index = 0;
$attachment_ids = $product->get_gallery_image_ids();
if ($product->is_type('variable')) {
	$available_variations = $product->get_available_variations();
	$selected_attributes = $product->get_default_attributes();
}
$attachment_count = count($attachment_ids);
if ( $attachment_count > 0 ) {
	$gallery = '[product-gallery]';
} else {
	$gallery = '';
}?>
<div class="single-product-image-inner product-gallery">
	<div id="pmainimages" class="main-images owl-carousel manual">
		<?php if (has_post_thumbnail()) {
			$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
			$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
			$image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	=> $image_title,
				'alt'	=> $image_title
			) );


			echo '<div class="easyzoom first">';
			echo  apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image" title="%s" rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_caption, $image ), $post->ID );
			echo '</div>';
			$index++;
		}
		if($attachment_ids) {
			foreach ( $attachment_ids as $attachment_id ) {
				$image_link = wp_get_attachment_url( $attachment_id );
				if ( ! $image_link ) {
					continue;
				}

				$image_title 	= esc_attr( get_the_title( $attachment_id ) );
				$image_caption 	= get_post( $attachment_id )->post_excerpt;

				$image       	= wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
					'title'	=> $image_title,
					'alt'	=> $image_title
				) );

				echo '<div class="easyzoom">';
				echo  apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image" title="%s" rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_caption, $image ), $post->ID );
				echo '</div>';
				$index++;

			}
		}
		if (isset($available_variations)){
			foreach ($available_variations as $available_variation){
				$variation_id = $available_variation['variation_id'];
				if (has_post_thumbnail($variation_id)) {

					$image_title 	= esc_attr( get_the_title( $variation_id ) );
					$image_caption 	= get_post( $variation_id )->post_excerpt;
					$image_link  	= wp_get_attachment_url(get_post_thumbnail_id($variation_id));
					$image       	= get_the_post_thumbnail( $variation_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
						'title'	=> $image_title,
						'alt'	=> $image_title
					) );

					echo '<div class="easyzoom">';
					echo  apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image" title="%s" rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_caption, $image ), $post->ID );
					echo '</div>';
					$index++;
				}
			}
		}?>
	</div>
	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
</div>