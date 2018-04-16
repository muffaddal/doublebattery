<?php
function lane_categorylist_shortcode( $atts, $content = null ){
	$title = $cat_ids = $el_class = $columns_count = $layout = $thumb_size = $autoplay = $show_count = $show_pagination = $show_navigation = $grid_col = '';
	extract(shortcode_atts(array(
	    'title' => '',
	    'cat_ids' => '',
	    'el_class' => '',
	    'columns_count'=>'4',
	    'layout' => 'carousel',
	    'style' => 'style-1',
	    'thumb_size' => 'thumbnail',
	    'autoplay' => '',
	    'show_count' => '',
	    'show_pagination' => '',
		'show_navigation' => ''
	), $atts));

	ob_start();

	$_id = rand();
	$prod_cat_args = array(
	  'taxonomy'     => 'product_cat',
	  'orderby'      => 'name',
	  'empty'        => 0
	);
	switch ($columns_count) {
		case '3':
			$grid_col = ' col-md-4';
			break;
		case '4':
			$grid_col = ' col-md-3';
			break;
		case '5':
			$grid_col = ' col-grid-5';
			break;
		case '6':
			$grid_col = ' col-md-2';
			break;
		default:
			$grid_col = ' col-md-6';
			break;
	}
	$show_count = ($show_count == '')?'false':'true';
	$autoplay = ($autoplay == '')?'false':'true';
	$is_pagination = ($show_pagination == '')?'false':'true';
	$is_navigation = ($show_navigation == '')?'false':'true';
	$data_plugin_options = 'data-plugin-options=\'{"items" : ' . esc_attr($columns_count) . ', "autoPlay": ' . esc_attr($autoplay) . ',"pagination": ' . esc_attr($is_pagination) . ',"navigation": ' . esc_attr($is_navigation) . '}\'';
	$woo_categories = get_categories( $prod_cat_args );

	$product_cats = ($cat_ids) ? array_filter(array_map('trim', explode(',', $cat_ids))) : array();

	if(count($woo_categories)>0){
	?>
	<div class="lane-woo-categories <?php echo isset($style) ? $style : ''; ?> <?php echo esc_attr( 'categories-'.$layout ); ?><?php echo (($el_class!='')?' '.$el_class:''); ?>">
	<?php if($layout=='carousel') { ?>
		<div id="lane-woo-categories-<?php echo esc_attr($_id); ?>" class="owl-carousel" <?php echo wp_kses_post($data_plugin_options); ?>>
	        <?php
			foreach ( $woo_categories as $woo_cat ):
				$thumbnail_id = get_woocommerce_term_meta( $woo_cat->term_id, 'thumbnail_id', true );
				$image_url = wp_get_attachment_url( $thumbnail_id );
				$img = wpb_getImageBySize(array( 'attach_id' => $thumbnail_id, 'thumb_size' => $thumb_size ));
				if ( $img == NULL ) $img['thumbnail'] = '<img class="thumbnail-placeholder" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
				if (count($product_cats)>0){
					if (in_array($woo_cat->slug, $product_cats)) {
					?>
						<div class="item col-sm-12">
							<div class="item-wrap">
								<figure class="image">
									<a class="image-link" href="<?php echo esc_url(get_term_link( $woo_cat->slug, 'product_cat' )); ?>" title="<?php echo esc_attr($woo_cat->name) ?>">
										<?php echo wp_kses_post($img['thumbnail']); ?>
									</a>
								</figure>
								<div class="cat-info">
									<div class="cat-info-wrap">
										<h3 class="cat-name" itemprop="name headline"><a href="<?php echo esc_url(get_term_link( $woo_cat->slug, 'product_cat' )) ?>" title="<?php echo esc_attr($woo_cat->name) ?>">
											<span class="name"><?php echo esc_html( $woo_cat->name ) ?></span>
										</a></h3>
										<?php if($show_count == 'true'): ?>
										<a class="count" href="<?php echo esc_url(get_term_link( $woo_cat->slug, 'product_cat' )); ?>" title="<?php echo esc_attr($woo_cat->name) ?>"><?php echo esc_html( $woo_cat->count ) . esc_html__( ' Products', 'lanethemekit' ) ?></a>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				<?php } else { ?>
					<div class="item col-sm-12">
						<div class="item-wrap">
							<figure class="image">
								<a class="image-link" href="<?php echo esc_url(get_term_link( $woo_cat->slug, 'product_cat' )); ?>" title="<?php echo esc_attr($woo_cat->name) ?>">
									<?php echo wp_kses_post($img['thumbnail']); ?>
								</a>
							</figure>
							<div class="cat-info">
								<div class="cat-info-wrap">
									<h3 class="cat-name" itemprop="name headline"><a href="<?php echo esc_url(get_term_link( $woo_cat->slug, 'product_cat' )) ?>" title="<?php echo esc_attr($woo_cat->name) ?>">
										<span class="name"><?php echo esc_html( $woo_cat->name ) ?></span>
									</a></h3>
									<?php if($show_count == 'true'): ?>
									<a class="count" href="<?php echo esc_url(get_term_link( $woo_cat->slug, 'product_cat' )); ?>" title="<?php echo esc_attr($woo_cat->name) ?>"><?php echo esc_html( $woo_cat->count ) . esc_html__( ' Products', 'lanethemekit' ) ?></a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			<?php endforeach; ?>
			<?php if($columns_count=='1'): ?>
			<script type="text/javascript">
			<!--
			(function($) {
				"use strict";
				$(document).ready(function() {
					var catCarouselSingleItem = $("#lane-woo-categories-<?php echo esc_attr($_id); ?>");
					catCarouselSingleItem.owlCarousel({
						singleItem : true
					});
				});
			})(jQuery);
			-->
			</script>
			<?php endif; ?>
	    </div>
	<?php } else { ?>
		<div class="row">
			<?php
			foreach ($woo_categories as $woo_cat) :
				if (count($product_cats)>0){
					if (in_array($woo_cat->slug, $product_cats)) {
						$thumbnail_id = get_woocommerce_term_meta( $woo_cat->term_id, 'thumbnail_id', true );
						$image_url = wp_get_attachment_url( $thumbnail_id );
						$img = wpb_getImageBySize(array( 'attach_id' => $thumbnail_id, 'thumb_size' => $thumb_size ));
						if ( $img == NULL ) $img['thumbnail'] = '<img class="thumbnail-placeholder" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
					?>
						<div class="item<?php echo esc_attr($grid_col); ?>">
							<div class="item-wrap">
								<figure class="image">
									<a class="image-link" href="<?php echo esc_url(get_term_link( $woo_cat->slug, 'product_cat' )); ?>" title="<?php echo esc_attr($woo_cat->name) ?>">
										<?php echo wp_kses_post($img['thumbnail']); ?>
									</a>
								</figure>
								<div class="cat-info">
									<div class="cat-info-wrap">
										<h3 class="cat-name" itemprop="name headline"><a href="<?php echo esc_url(get_term_link( $woo_cat->slug, 'product_cat' )) ?>" title="<?php echo esc_attr($woo_cat->name) ?>">
											<span class="name"><?php echo esc_html( $woo_cat->name ) ?></span>
										</a></h3>
										<?php if($show_count == 'true'): ?>
										<a class="count" href="<?php echo esc_url(get_term_link( $woo_cat->slug, 'product_cat' )); ?>" title="<?php echo esc_attr($woo_cat->name) ?>"><?php echo esc_html( $woo_cat->count ) . esc_html__( ' Products', 'lanethemekit' ) ?></a>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				<?php } else { ?>
					<div class="item<?php echo esc_attr($grid_col); ?>">
						<?php
						$thumbnail_id = get_woocommerce_term_meta( $woo_cat->term_id, 'thumbnail_id', true );
						$image_url = wp_get_attachment_url( $thumbnail_id );
						$img = wpb_getImageBySize(array( 'attach_id' => $thumbnail_id, 'thumb_size' => $thumb_size ));
						if ( $img == NULL ) $img['thumbnail'] = '<img class="thumbnail-placeholder" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';?>
						<div class="item-wrap">
							<figure class="image">
								<a class="image-link" href="<?php echo esc_url(get_term_link( $woo_cat->slug, 'product_cat' )); ?>" title="<?php echo esc_attr($woo_cat->name) ?>">
									<?php echo wp_kses_post($img['thumbnail']); ?>
								</a>
							</figure>
							<div class="cat-info">
								<div class="cat-info-wrap">
									<h3 class="cat-name" itemprop="name headline"><a href="<?php echo esc_url(get_term_link( $woo_cat->slug, 'product_cat' )) ?>" title="<?php echo esc_attr($woo_cat->name) ?>">
										<span class="name"><?php echo esc_html( $woo_cat->name ) ?></span>
									</a></h3>
									<?php if($show_count == 'true'): ?>
									<a class="count" href="<?php echo esc_url(get_term_link( $woo_cat->slug, 'product_cat' )); ?>" title="<?php echo esc_attr($woo_cat->name) ?>"><?php echo esc_html( $woo_cat->count ) . esc_html__( ' Products', 'lanethemekit' ) ?></a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			<?php endforeach; ?>
		</div>
	    <?php } ?>
	</div>
	<?php
	} // end if
    wp_reset_postdata();
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('lane_categorylist', 'lane_categorylist_shortcode');