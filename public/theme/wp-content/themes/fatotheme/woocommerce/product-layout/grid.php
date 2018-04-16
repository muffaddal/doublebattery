<?php
$_count = 1;
$_js = '';
$arraycats = array();
$isotope_class = $grid_isotope = '';
// Load JS
if($show_filters == '1' || $show_loadmore == '1') :
	$pcats = array();
	foreach ($loop->posts as $key => $_product) {
		$pcats[] = get_the_terms($_product->ID, 'product_cat');
	}
	$_arrayc = array();
	foreach ($pcats as $key => $_cats) {
		$_arrayc = array_merge($_arrayc,$_cats);
	}
	//$arraycats = array();
	foreach ($_arrayc as $key => $catfils) {
		$arraycats[$catfils->term_id] = $catfils;
	}
	$isotope_class = 'product-isotope product-isotope-item isotope-item ';
	$grid_isotope = '-isotope';
endif;
$filter_class = 'hidden';
if(count($arraycats) && ($show_filters == '1')){
	$filter_class = 'visible';
}
$_id = fatotheme_make_id();
$data_section_id = uniqid();
?>
<div id="productisotope-<?php echo esc_attr($data_section_id)?>" class="grid-product-isotope <?php if($type) echo ($type); ?><?php if($hide_time_sale=='1') echo ' hide-time-sale'; ?> <?php if($layout) echo ($layout); ?> <?php if($style) echo ($style); ?> clearfix">
	<ul id="filters-product-isotope" class="filters-product-isotope filter-<?php echo esc_attr($filter_class) ?> <?php echo esc_attr($filter_align) ?>">
	  <li class="current"><a class="isotope-product first current" data-section-id="<?php echo esc_attr($data_section_id) ?>" data-group="all" data-filter="*" href="javascript:void(0)"><span><?php esc_html_e('All','fatotheme') ?></span></a></li>
	  <?php foreach ($arraycats as $catid => $_catfil) { ?>
	  	<li><a class="isotope-product" data-section-id="<?php echo esc_attr($data_section_id) ?>" data-group="product_cat-<?php echo esc_attr($_catfil->slug) ?>" data-filter=".product_cat-<?php echo esc_attr($_catfil->slug) ?>" href="javascript:void(0)"><span><?php echo esc_html($_catfil->name) ?></span></a></li>
	  <?php } ?>
	</ul>
	<div id="lane-grid-product<?php echo esc_attr($grid_isotope) ?>" class="lane-grid-product<?php echo esc_attr($grid_isotope) ?> grid row clearfix" data-section-id="<?php echo esc_attr($data_section_id) ?>">
	<?php
	$index = 0;
	while ( $loop->have_posts() ) : $loop->the_post();
		$index++;
	    ?>
		<!-- Product Item -->
		<div <?php post_class(esc_attr($class_column).' product-grid product-'.esc_attr($index).' '.esc_attr($isotope_class).'clearfix') ?>>
			<?php 
				if(isset($is_deals) && $is_deals){
					wc_get_template_part( 'content', 'product-deals' );
				}else{
					wc_get_template_part( 'content', 'product-grid' );
				}
			?>
		</div>
	<?php endwhile; ?>
	</div>
	<?php if(count($arraycats) && ($number_per_page < $_total)): ?>
	<nav id="isotope-ploadmore-<?php echo esc_attr($data_section_id) ?>" class="navigation paging-navigation loadmore<?php echo esc_attr($show_loadmore) ? ' loadmore-visible' : ' loadmore-hidden' ?>" data-role="navigation">
		<span>
			<span class="loadmore-left"></span>
			<a class="btn btn-default isotope-ploadmore" href="javascript:void(0)"
				data-section-id="<?php echo esc_attr($data_section_id) ?>"
               	data-current-page="<?php echo esc_attr($current_page + 1) ?>"
               	data-column = "<?php echo esc_attr($columns_count) ?>"
               	data-post-per-page = "<?php echo esc_attr($number_per_page) ?>">
			</a>
			<span class="loadmore-right"></span>
		</span>
	</nav>
	<?php endif; ?>
</div>