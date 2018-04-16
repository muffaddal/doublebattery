<?php 
$fatotheme_get_theme_option = fatotheme_get_theme_option();
if($fatotheme_get_theme_option['header_is_search']) : ?>
<div class="page-header-search-box">
	<?php if( class_exists('WC_Widget_Product_Categories') && class_exists('WC_Widget_Product_Search') ) { ?>
	<div class="wplane-search">
		<div class="cate-toggler"><?php esc_html_e('All Categories', 'fatotheme');?></div>
		<?php the_widget('WC_Widget_Product_Categories', array('hierarchical' => true, 'title' => 'Categories', 'orderby' => 'order')); ?>
		<?php the_widget('WC_Widget_Product_Search', array('title' => 'Search')); ?>
	</div>
	<?php } ?>
</div>
<?php endif; ?>