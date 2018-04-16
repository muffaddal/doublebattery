<?php
function lane_products_shortcode( $atts, $content = null )
{
	global $woocommerce;
    
    if(!$woocommerce) 
        return '';

	$title = $cat_ids = $show_rating = $_id = $loop = $columns_count = $class_column = $_total = $number = $is_deals = $show_filters = $filter_align = $show_loadmore = $number_per_pag = $autoplay = $show_pagination = $show_navigation = $layout = $style = $hide_time_sale = '';
	extract( shortcode_atts( array(
		'title'	=> '',
		'cat_ids'	=> '',
		'number'=> 4,
		'columns_count'=>'4',
		'el_class' => '',
		'type'=>'',
		'layout'=>'grid',
		'style'=>'style-1',
		'show_filters'=>'',
		'hide_time_sale'=>'',
		'filter_align'=>'align-center',
		'show_loadmore' => '',
		'number_per_page'=> 4,
		'autoplay' => '',
	    'show_pagination' => '',
		'show_navigation' => ''
	), $atts ) );

	ob_start();

	switch ($columns_count) {
		case '6':
			$class_column='col-md-2';
			break;
		case '5':
			$class_column='col-grid-5';
			break;
		case '4':
			$class_column='col-md-3';
			break;
		case '3':
			$class_column='col-md-4';
			break;
		case '2':
			$class_column='col-md-6';
			break;
		default:
			$class_column='col-md-12';
			break;
	}
	if($type=='') return;
	$_id = rand();
	$_count = 1;
	$show_rating = $is_deals = false;
	$autoplay = ($autoplay == '')?'false':'true';
	$is_pagination = ($show_pagination == '')?'false':'true';
	$is_navigation = ($show_navigation == '')?'false':'true';
	if($type=='top_rate') $show_rating=true;
	if($type=='deals') $is_deals=true;
	$loop = lane_woocommerce_query($type,$number,$cat_ids);

	if ( $loop->have_posts() ) : ?>

		<?php $_total = $loop->found_posts; ?>
	  	<div class="woocommerce lane-products <?php echo esc_attr($layout); ?> <?php if($style) echo $style; ?><?php echo (($el_class!='')?' '.$el_class:''); ?>">
	  		<?php if(isset($title) && $title != ''): ?>
	  			<h3 class="widget-title"><span><?php echo esc_html($title) ?></span></h3>
	  		<?php endif; ?>
			<?php @wc_get_template( 'product-layout/'.$layout.'.php', array( 
						'title'	=> $title,
						'show_rating' => $show_rating,
						'cat_ids' => $cat_ids,
						'_id'=>$_id,
						'loop'=>$loop,
						'type'=>$type,
						'layout'=>$layout,
						'style'=>$style,
						'hide_time_sale'=>$hide_time_sale,
						'columns_count'=>$columns_count,
						'class_column' => $class_column,
						'_total'=>$_total,
						'number'=>$number,
						'is_deals'=>$is_deals,
						'show_filters'=>$show_filters,
						'filter_align'=>$filter_align,
						'show_loadmore'=>$show_loadmore,
						'number_per_page'=>$number_per_page,
						'autoplay' => $autoplay,
						'is_pagination' => $is_pagination,
						'is_navigation' => $is_navigation
					) ); ?>
		</div>
	<?php 
	endif;
    wp_reset_postdata();
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('lane_products', 'lane_products_shortcode');
