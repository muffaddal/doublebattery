<?php
$_count = 1;
$_js = $is_deals = '';
$_id = fatotheme_make_id();
$prod_cat_args = array(
  'taxonomy'     => 'product_cat', //woocommerce
  'orderby'      => 'name',
  'empty'        => 0
);
$woo_categories = get_categories( $prod_cat_args );
$data_plugin_options = 'data-plugin-options=\'{"items" : ' . esc_attr($columns_count) . ', "autoPlay": ' . esc_attr($autoplay) . ',"pagination": ' . esc_attr($is_pagination) . ',"navigation": ' . esc_attr($is_navigation) . '}\'';

if(count($woo_categories)>0){
?>
<div class="lane-woo-products-carousel <?php if($type) echo esc_attr($type); ?> <?php if($layout) echo esc_attr($layout); ?><?php if($hide_time_sale=='1') echo ' hide-time-sale'; ?> <?php if($style) echo esc_attr($style); ?>">
	<div id="lane-woo-products-carousel-<?php echo esc_attr($_id) ?>" class="owl-carousel lane-carousel-product-isotope" <?php echo wp_kses_post($data_plugin_options); ?>>
		<?php
		while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<div class="item col-sm-12 product-carousel">
				<?php
					if(isset($style) && $style=='style-2'){
						wc_get_template_part( 'content', 'product-carousel-style2' );
					}else{
						wc_get_template_part( 'content', 'product-carousel' );
					}
				?>
			</div>
		<?php
		endwhile; ?>
	</div>
	<?php if($columns_count=='1'): ?>
	<script type="text/javascript">
	<!--
	(function($) {
		"use strict";
		$(document).ready(function() {
			var carouselSingleItem = $("#lane-woo-products-carousel-<?php echo esc_attr($_id) ?>");
			carouselSingleItem.owlCarousel({
				singleItem : true
			});
		});
	})(jQuery);
	-->
	</script>
	<?php endif; ?>
</div>
<?php 
}