<?php
/*==========================================================================
Woocommerce support
==========================================================================*/
add_theme_support( 'woocommerce' );
add_filter( 'woocommerce_enqueue_styles', 'fatotheme_dequeue_styles_woocommerce' );
function fatotheme_dequeue_styles_woocommerce( $enqueue_styles ) 
{
	unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	return $enqueue_styles;
}

function fatotheme_work_around_pagination_bug($link) 
{
	return str_replace('#038;', '&', $link);
}
add_filter('paginate_links', 'fatotheme_work_around_pagination_bug');

/*==========================================================================
Shop Reset Loop
==========================================================================*/
if (!function_exists('fatotheme_woocommerce_reset_loop')) {
	/**
	 * Reset the loop's index and columns when we're done outputting a product loop.
	 *
	 * @subpackage    Loop
	 */
	function fatotheme_woocommerce_reset_loop()
	{
		global $fatotheme_arhive_product_layout,$fatotheme_arhive_product_style;
		$fatotheme_arhive_product_layout = '';
		$fatotheme_arhive_product_style = '';
	}
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count' ,20);

/*==========================================================================
Catalog Shop Page Layout
==========================================================================*/
if ( ! function_exists( 'fatotheme_shop_catalog_layout' ) ) {
	function fatotheme_shop_catalog_layout() {
        global $fatotheme_theme_option;
        if(!isset($_COOKIE['woo-shop-layout-switch'])) {
            $catalog_layout = $fatotheme_theme_option['woo-shop-layout-switch'];
        } else {
            $catalog_layout =  $_COOKIE['woo-shop-layout-switch'];
        }
		?>
		<div class="catalog-layout-switch">
			<span><?php esc_html_e('View as:','fatotheme'); ?></span>
			<a href="#" class="layout-switch list tip-top<?php echo esc_attr($catalog_layout == 'list' ? ' active' : '');?>" data-layout="list" data-tip="<?php esc_html_e("List Layout", "fatotheme"); ?>"><i class="fa fa-list"></i></a>
			<a href="#" class="layout-switch grid tip-top<?php echo esc_attr($catalog_layout == 'grid' ? ' active' : '');?>" data-layout="grid" data-tip="<?php esc_html_e("Grid Layout", "fatotheme"); ?>"><i class="fa fa-th"></i></a>
		</div>
	<?php }
	add_action( 'woocommerce_before_shop_loop', 'fatotheme_shop_catalog_layout', 10 );
}

/*==========================================================================
Catalog Page Size
==========================================================================*/
add_filter('loop_shop_per_page', 'fatotheme_show_products_per_page');
function fatotheme_show_products_per_page()
{
	global $fatotheme_theme_option;
	$page_size = isset($_GET['page_size']) ? wc_clean($_GET['page_size']) : intval($fatotheme_theme_option['woo-shop-number']);
	return $page_size;
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_before_shop_loop', 'fatotheme_woocommerce_catalog_ordering', 30 );
function fatotheme_woocommerce_catalog_ordering() {
	global $fatotheme_theme_option;
	if ( isset( $_SERVER['QUERY_STRING'] ) ) {
		parse_str( $_SERVER['QUERY_STRING'], $params );

		$query_string = '?' . $_SERVER['QUERY_STRING'];
	} else {
		$query_string = '';
	}

	// replace it with theme option
	$filter_defaul = '6,9,12,24,36,48,60,90,100';
	$number_filter = ($fatotheme_theme_option['woo-shop-filter-show']) ? explode(',', $fatotheme_theme_option['woo-shop-filter-show']) : explode(',', $filter_defaul);
	$page_size = isset( $_GET['page_size'] ) ? wc_clean( $_GET['page_size'] ) : apply_filters( 'woocommerce_default_catalog_page_size', intval($fatotheme_theme_option['woo-shop-number']) );
	$page_size_arr = apply_filters( 'woocommerce_catalog_page_size', $number_filter );
	//$per_page = 9;

	$pob = ! empty( $params['orderby'] ) ? $params['orderby'] : get_option( 'woocommerce_default_catalog_orderby' );

	if ( ! empty( $params['product_order'] ) ) {
		$po = $params['product_order'];
	} else {
		switch ( $pob ) {
			case 'default':
			case 'menu_order':
				$po = 'asc';
				break;
			case 'date':
				$po = 'desc';
				break;
			case 'price':
				$po = 'asc';
				break;
			case 'price-desc':
				$po = 'desc';
				break;
			case 'popularity':
				$po = 'asc';
				break;
			case 'rating':
				$po = 'desc';
				break;
			case 'name':
				$po = 'asc';
				break;
		}
	}

	$order_string = __( 'Default', 'fatotheme' );

	switch ( $pob ) {
		case 'date':
			$order_string = __( 'Date', 'fatotheme' );
			break;
		case 'price':
		case 'price-desc':
			$order_string = __( 'Price', 'fatotheme' );
			break;
		case 'popularity':
			$order_string = __( 'Popularity', 'fatotheme' );
			break;
		case 'rating':
			$order_string = __( 'Rating', 'fatotheme' );
			break;
		case 'name':
			$order_string = __( 'Name', 'fatotheme' );
			break;
	}

	$pc = ! empty( $params['page_size'] ) ? $params['page_size'] : $page_size;
	?>
	<div class="catalog-ordering clearfix">
		<div class="orderby-order-container">
			<ul class="orderby order-dropdown">
				<li>
					<span class="current-li">
						<span class="current-li-content">
							<a aria-haspopup="true"><?php printf( esc_html__( 'Sorting by %s', 'fatotheme' ), '<span>' . $order_string . '</span>' ); ?></a>
						</span>
					</span>
					<ul>
						<li class="<?php echo ( $pob == 'menu_order' ) ? 'current' : ''; ?>">
							<a href="<?php echo fatotheme_add_url_parameter( $query_string, 'orderby', 'default' ); ?>"><?php printf( esc_html__( '%s', 'fatotheme' ), '<span>' . esc_attr__( 'Default Sorting', 'fatotheme' ) . '</span>' ); ?></a>
						</li>
						<li class="<?php echo ( $pob == 'name' ) ? 'current' : ''; ?>">
							<a href="<?php echo fatotheme_add_url_parameter( $query_string, 'orderby', 'name' ); ?>"><?php printf( esc_html__( 'Sort by %s', 'fatotheme' ), '<span>' . esc_attr__( 'Name', 'fatotheme' ) . '</span>' ); ?></a>
						</li>
						<li class="<?php echo ( $pob == 'price' || $pob == 'price-desc' ) ? 'current' : ''; ?>">
							<a href="<?php echo fatotheme_add_url_parameter( $query_string, 'orderby', 'price' ); ?>"><?php printf( esc_html__( 'Sort by %s', 'fatotheme' ), '<span>' . esc_attr__( 'Price', 'fatotheme' ) . '</span>' ); ?></a>
						</li>
						<li class="<?php echo ( $pob == 'date' ) ? 'current' : ''; ?>">
							<a href="<?php echo fatotheme_add_url_parameter( $query_string, 'orderby', 'date' ); ?>"><?php printf( esc_html__( 'Sort by %s', 'fatotheme' ), '<span>' . esc_attr__( 'Date', 'fatotheme' ) . '</span>' ); ?></a>
						</li>
						<li class="<?php echo ( $pob == 'popularity' ) ? 'current' : ''; ?>">
							<a href="<?php echo fatotheme_add_url_parameter( $query_string, 'orderby', 'popularity' ); ?>"><?php printf( esc_html__( 'Sort by %s', 'fatotheme' ), '<span>' . esc_attr__( 'Popularity', 'fatotheme' ) . '</span>' ); ?></a>
						</li>
						<?php if ( 'no' !== get_option( 'woocommerce_enable_review_rating' ) ) : ?>
							<li class="<?php echo ( $pob == 'rating' ) ? 'current' : ''; ?>">
								<a href="<?php echo fatotheme_add_url_parameter( $query_string, 'orderby', 'rating' ); ?>"><?php printf( esc_html__( 'Sort by %s', 'fatotheme' ), '<span>' . esc_attr__( 'Rating', 'fatotheme' ) . '</span>' ); ?></a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
			</ul>
		</div>
		<ul class="sort-count order-dropdown">
			<li>
				<span class="current-li"><a aria-haspopup="true"><?php printf( esc_html__( 'Showing 1-%s Products', 'fatotheme' ), $page_size ); ?></a></span>
				<ul>
					<?php foreach ($page_size_arr as $key => $page_size) { ?>
					<li class="<?php echo ( $pc == $page_size ) ? 'current' : ''; ?>">
						<a href="<?php echo fatotheme_add_url_parameter( $query_string, 'page_size', $page_size ); ?>"><?php printf( esc_html__( 'Showing 1-%s Products', 'fatotheme' ), $page_size ); ?></a>
					</li>
					<?php } //End foreach ?>
				</ul>
			</li>
		</ul>
		<script type="text/javascript">
			<!--
        	jQuery(document).ready(function($) {
				$('.catalog-ordering .sort-count .current-li a').html($('.catalog-ordering .sort-count ul li.current a').html());
			});
			-->
		</script>
	</div>
	<?php
}

/*==========================================================================
Shop Item Layout
==========================================================================*/
remove_action( 'woocommerce_after_shop_loop_item_title' , 'woocommerce_template_loop_price' );
remove_action( 'woocommerce_after_shop_loop_item_title' , 'woocommerce_template_loop_rating',5 );
remove_action( 'woocommerce_single_product_summary' , 'woocommerce_template_single_excerpt',20 );
remove_action( 'woocommerce_single_product_summary' , 'woocommerce_template_single_price',10 );
add_action( 'woocommerce_single_product_summary' , 'woocommerce_template_single_excerpt',8 );
add_action( 'woocommerce_single_product_summary' , 'woocommerce_template_loop_rating',7 );
add_action( 'woocommerce_single_product_summary' , 'woocommerce_template_single_price',6 );

add_action( 'fatotheme_after_shop_loop_item_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'fatotheme_woocommerce_shop_loop_item_price', 'woocommerce_template_loop_price' , 5 );
add_action( 'fatotheme_woocommerce_template_loop_category', 'fatotheme_woocommerce_template_loop_category' , 5 );
function fatotheme_woocommerce_template_loop_category()
{
	global $product;
?>
    <?php echo wp_kses_post($product->get_categories( ', ')); ?>
<?php
}

add_action('woocommerce_before_single_product_quick_view_summary', 'woocommerce_show_product_sale_flash', 10);
add_action('woocommerce_before_single_product_quick_view_summary','fatotheme_woocommerce_show_product_loop_new_flash',5);
add_action('woocommerce_before_single_product_quick_view_summary', 'woocommerce_show_product_images_quick_view', 20);
/*==========================================================================
Quick View
==========================================================================*/
if(isset($fatotheme_theme_option['woo-is-quickview']) && $fatotheme_theme_option['woo-is-quickview'])
{
	add_action('wp_ajax_nopriv_product_quick_view', 'fatotheme_product_quick_view_callback');
	add_action('wp_ajax_product_quick_view', 'fatotheme_product_quick_view_callback');
	function fatotheme_product_quick_view_callback()
	{
		$product_id = $_REQUEST['id'];
		$args = array(
			'post_type' => 'product',
			'post__in' => array($product_id)
		);

		$products = new WP_Query($args);
		ob_start();
		while ($products->have_posts()) : $products->the_post();
			wc_get_template_part('content-product-quickview');
		endwhile; // end of the loop.
		$output = ob_get_contents();
		ob_end_clean();
		echo !empty( $output ) ? $output : '';
		die();
	}
}

/*==========================================================================
Woocommerce Show Attributes
==========================================================================*/
function fatotheme_woocommerce_attributes()
{
	global $product, $post, $woocommerce, $woocommerce_loop;
	
	$all_attributes = array();
	$attributes = $product->get_attributes();
	foreach($attributes as $attr=>$attr_deets){
	    $attribute_label = wc_attribute_label($attr);
	    if ( isset( $attributes[ $attr ] ) || isset( $attributes[ 'pa_' . $attr ] ) ) 
	    {
	        $attribute = isset( $attributes[ $attr ] ) ? $attributes[ $attr ] : $attributes[ 'pa_' . $attr ];
	        if ( $attribute['is_taxonomy'] ) 
	        {
	            $all_attributes[$attribute_label] = implode( ', ', wc_get_product_terms( $product->get_id(), $attribute['name'], array( 'fields' => 'names' ) ) );
	        } 
	        else 
	        {
	            $all_attributes[$attribute_label] = $attribute['value'];
	        }
	    }
	}
	if ($all_attributes) {

		$output = '<div class="custom-attrs">';
		foreach ($all_attributes as $attr_name => $attrs_value) {
			$attr_name = strtolower($attr_name);
			$attrs_value = explode(',', $attrs_value);
			$output .= '<ul class="'.$attr_name.'">';
				foreach ($attrs_value as $key => $attr_value) {
					$output .= '<li class="'.trim(strtolower($attr_value)).'"><span class="attr-value">' . trim($attr_value) . '</span></li>';
				}
			$output .= '</ul>';
		}
		$output .= '</div>';
		echo !empty( $output ) ? $output : '';
	}
}
add_action( 'fatotheme_woocommerce_attributes','fatotheme_woocommerce_attributes' );

/*==========================================================================
Woocommerce Show Availability
==========================================================================*/
add_action( 'woocommerce_product_meta_stock','fatotheme_woocommerce_availability_html',26 );
function fatotheme_woocommerce_availability_html()
{
	global $product;
	$stock = $product->get_total_stock();
	$availability = $product->get_availability();
	if ( $availability['availability'] && $stock>0){
		echo '<div class="product-stock">' . esc_html__('Availability','fatotheme') . ': <span class="stock in-stock">'. esc_html__( 'In stock', 'woocommerce' ) .'</span></div>';
	}
	if($stock==0){
		echo '<div class="product-stock">' . esc_html__('Availability','fatotheme') . ': <span class="stock in-stock">'. esc_html__( 'Out of stock', 'woocommerce' ) .'</span></div>';
	}
}

/*==========================================================================
Change # in stock completely
==========================================================================*/
//add_filter( 'woocommerce_get_availability', 'fatotheme_get_availability', 1, 2);
function fatotheme_get_availability( $availability, $_product ) {
	global $product;
	$stock = $product->get_total_stock();

	if ( $_product->is_in_stock() ) $availability['availability'] = esc_html__('Quantity: ', 'woocommerce') . $stock;
	if ( !$_product->is_in_stock() ) $availability['availability'] = esc_html__('Sold Out', 'woocommerce');

	return $availability;
}

/*==========================================================================
Woocommerce Rating HTML
==========================================================================*/
function fatotheme_get_rating_html( $rating = null ) 
{
	$rating_html = '';

	if ( ! is_numeric( $rating ) ) {
	  $rating = $this->get_average_rating();
	}

	if ( $rating > 0 ) {
	  	$rating_html  = '<div class="star-rating" title="' . printf(esc_html__( 'Rated %s out of 5', 'woocommerce' ), $rating ) . '">';
	  	$rating_html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"><strong class="rating">' . $rating . '</strong> ' . esc_html__( 'out of 5', 'woocommerce' ) . '</span>';
	  	$rating_html .= '</div>';
	}

	return apply_filters( 'woocommerce_product_get_rating_html', $rating_html, $rating );
}

/*==========================================================================
Woocommerce Social Like
==========================================================================*/
//add_action('woocommerce_share','fatotheme_woocommerce_social_like');
function fatotheme_woocommerce_social_like()
{
	global $post;
	echo'
	<div class="lane-wooshare">
	<div class="fb-like" data-href="'.get_permalink().'" data-layout="button_count" data-send="false" data-width="100" data-show-faces="true" style="display:inline"></div>
	<a href="'.esc_url( "https://twitter.com/share" ).'" class="twitter-share-button" data-via="bryanheadrick">Tweet</a>
	<g:plusone size="standard"></g:plusone>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	<a href="http://pinterest.com/pin/create/button/?url='. urlencode(get_permalink()).'&media='.urlencode(wp_get_attachment_url( get_post_thumbnail_id() )).'&description='.apply_filters( 'woocommerce_short_description', $post->post_excerpt ).'" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
	<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>';?>
	<script type="text/javascript">
	  (function() {
	    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	    po.src = 'https://apis.google.com/js/plusone.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=281787978603249";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	</div>
<?php
}

/*==========================================================================
Loop Buttons Action
==========================================================================*/
add_action( 'fatotheme_woocommerce_shop_loop_item_button_action', 'fatotheme_button_action' , 30 );
function fatotheme_button_action()
{
	global $post, $product,$fatotheme_theme_option;
	?>
	<?php 
	// Add to cart buton
	$ajax_add_to_cart = ((get_option('woocommerce_enable_ajax_add_to_cart')=='yes') && ($product->is_type( 'simple' ))) ? ' ajax_add_to_cart' : ' non_ajax_add_to_cart';
	echo apply_filters( 'woocommerce_loop_add_to_cart_link',
		sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s btn-cart'.$ajax_add_to_cart.' btn-addtocart">%s</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( $product->get_id() ),
			esc_attr( $product->get_sku() ),
			esc_attr( isset( $quantity ) ? $quantity : 1 ),
			$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
			'<span class="cart-text"><i class="icons icon-handbag"></i>'.$product->add_to_cart_text().'</span>'
		),
	$product ); 

	// Wishlist Button
	if(class_exists('YITH_WCWL')){ ?>
		<a href="javascript:void(0)" class="btn-wishlist btn-link tip-top" data-tip="<?php echo esc_html__('Wishlist','fatotheme'); ?>" title="<?php echo esc_html__('Wishlist','fatotheme'); ?>">
			<span><i class="icons icon-heart"></i></span></a>
	<?php }

	// Compare Button
	if(class_exists( 'YITH_Woocompare' )){ ?>
		<a href="javascript:void(0)" class="btn-compare btn-link tip-top" data-tip="<?php echo esc_html__('Compare','fatotheme'); ?>" title="<?php echo esc_html__('Compare','fatotheme'); ?>">
			<span><i class="icons icon-shuffle"></i></span></a>
	<?php }

	// Quick View Button
	if( isset($fatotheme_theme_option['woo-is-quickview']) && $fatotheme_theme_option['woo-is-quickview'] ) { ?>
		<a data-tip="<?php esc_html_e('Quick view', 'fatotheme') ?>" class="woo-product-quickview btn-quickview btn-link quickview tip-top" data-product_id="<?php the_ID(); ?>" href="<?php the_permalink(); ?>">
		<span><i class="icons icon-magnifier-add"></i></span></a>
		<?php // End if
	}
	?>
<?php
}

/*==========================================================================
Woocommerce Wishlist Compare Button
==========================================================================*/
add_action( 'woocommerce_single_product_summary','fatotheme_woocommerce_wishlist_compare_button',35 );
function fatotheme_woocommerce_wishlist_compare_button()
{
	global $product;
	$start = $end = '';
	$start = '<div class="wishlist-compare-email single-product-btn-action">';
	$end = '</div>';
	echo wp_kses_post($start);
	// Add to cart buton
	$ajax_add_to_cart = ((get_option('woocommerce_enable_ajax_add_to_cart')=='yes') && ($product->is_type( 'simple' ))) ? ' ajax_add_to_cart' : 'non_ajax_add_to_cart';
	echo apply_filters( 'woocommerce_loop_add_to_cart_link',
		sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s btn-cart'.$ajax_add_to_cart.' btn-addtocart">%s</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( $product->get_id() ),
			esc_attr( $product->get_sku() ),
			esc_attr( isset( $quantity ) ? $quantity : 1 ),
			$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
			'<span class="cart-text"><i class="icons icon-handbag"></i>'.$product->add_to_cart_text().'</span>'
		),
	$product ); ?>
	<?php
	if(class_exists('YITH_WCWL')){ ?>
		<a href="javascript:void(0)" class="btn-wishlist" title="<?php esc_html_e('Wishlist','fatotheme'); ?>">
			<span><i class="icons icon-heart"></i><?php esc_html_e('Add to wishlist','fatotheme'); ?></span></a>
	<?php } ?>
	<?php if(class_exists( 'YITH_Woocompare' )){ ?>
		<a href="javascript:void(0)" class="btn-compare" title="<?php esc_html_e('Compare','fatotheme'); ?>">
			<span><i class="icons icon-shuffle"></i><?php esc_html_e('Compare','fatotheme'); ?></span></a>
	<?php }
	echo wp_kses_post($end);
}

/*==========================================================================
Loop Buttons Action
==========================================================================*/
//add_action( 'woocommerce_single_product_summary','fatotheme_woocommerce_addtocart_bottom_button',35 );
function fatotheme_woocommerce_addtocart_bottom_button()
{
	global $product;
	// Add to cart buton
	$ajax_add_to_cart = ((get_option('woocommerce_enable_ajax_add_to_cart')=='yes') && ($product->is_type( 'simple' ))) ? ' ajax_add_to_cart' : ' non_ajax_add_to_cart';
	echo apply_filters( 'woocommerce_loop_add_to_cart_link',
		sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s btn-cart'.$ajax_add_to_cart.' btn-addtocart">%s</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( $product->get_id() ),
			esc_attr( $product->get_sku() ),
			esc_attr( isset( $quantity ) ? $quantity : 1 ),
			$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
			'<span class="cart-text"><i class="icons icon-handbag"></i>'.$product->add_to_cart_text().'</span>'
		),
	$product );
}

/*==========================================================================
Loop Buttons Action
==========================================================================*/
if(!function_exists('fatotheme_product_loop_btn_quickview'))
{
	function fatotheme_product_loop_btn_quickview()
	{
		global $post, $product, $fatotheme_theme_option;

		if( isset($fatotheme_theme_option['woo-is-quickview']) && $fatotheme_theme_option['woo-is-quickview'] ) { ?>
			<a data-tip="<?php esc_html_e('Quick view', 'fatotheme') ?>" class="woo-product-quickview btn-quickview btn-link quickview tip-top" data-product_id="<?php the_ID(); ?>" href="<?php the_permalink(); ?>">
			<span><i class="pe-7s-search"></i></span></a>
			<?php // End if
		}
	}
	add_action( 'fatotheme_woocommerce_shop_loop_item_button_quickview', 'fatotheme_product_loop_btn_quickview' );
}

/*==========================================================================
Woocommerce Category Image
==========================================================================*/
/* Place your custom functions below */
add_action( 'woocommerce_archive_description', 'fatotheme_woocommerce_category_image', 2 );
function fatotheme_woocommerce_category_image() {
	if ( is_product_category() ){
		global $wp_query;
		$cat = $wp_query->get_queried_object();
		$thumbnail_id = @get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
		$image = wp_get_attachment_url( $thumbnail_id );
		if ( $image ) {
			echo '<div class="category-image"><img src="' . $image . '" alt="'.$cat->name.'" /></div>';
		}
	}
}

/**
 * Add meta New
 *
 * Display Fields
 */
add_action('woocommerce_product_options_general_product_data', 'fatotheme_woocommerce_add_custom_general_fields');
function fatotheme_woocommerce_add_custom_general_fields()
{
	echo '<div class="options_group">';
	woocommerce_wp_checkbox(
		array(
			'id' => 'fatotheme_product_new',
			'label' => esc_html__('Product New', 'fatotheme')
		)
	);
	echo '</div>';
}

// Save Fields
add_action('woocommerce_process_product_meta', 'fatotheme_woo_add_custom_general_fields_save');
function fatotheme_woo_add_custom_general_fields_save($post_id)
{
	//product-new
	$fatotheme_product_new = isset($_POST['fatotheme_product_new']) ? 'yes' : 'no';
	update_post_meta($post_id, 'fatotheme_product_new', $fatotheme_product_new);
}

//Add custom column into Product Page
add_filter('manage_edit-product_columns', 'fatotheme_columns_into_product_list');
function fatotheme_columns_into_product_list($defaults)
{
	$defaults['fatotheme_product_new'] = 'New';
	return $defaults;
}

//Add rows value into Product Page
add_action('manage_product_posts_custom_column', 'fatotheme_column_into_product_list', 10, 2);
function fatotheme_column_into_product_list($column, $post_id)
{
	switch ($column) {
		case 'fatotheme_product_new':
			echo get_post_meta($post_id, 'fatotheme_product_new', true);
			break;
	}
}

add_filter("manage_edit-product_sortable_columns", "fatotheme_sortable_columns");
// Make these columns sortable
function fatotheme_sortable_columns()
{
	return array(
		'fatotheme_product_new' => 'fatotheme_product_new'
	);
}

add_action('pre_get_posts', 'fatotheme_event_column_orderby');
function fatotheme_event_column_orderby($query)
{
	if (!is_admin())
		return;
	$orderby = $query->get('orderby');
	if ('fatotheme_product_new' == $orderby) {
		$query->set('meta_key', 'fatotheme_product_new');
		$query->set('orderby', 'meta_value_num');
	}
}

if (!function_exists('fatotheme_show_product_loop_new_flash')) {
	function fatotheme_show_product_loop_new_flash() {
		wc_get_template( 'loop/new-flash.php' );
	}
	add_action('fatotheme_woocommerce_show_product_loop_new_flash','fatotheme_show_product_loop_new_flash',5);
	add_action('woocommerce_before_single_product_summary','fatotheme_show_product_loop_new_flash',5);
}

// Custom WooCommerce product fields
if(!function_exists('fatotheme_wc_custom_product_data_fields')){

    function fatotheme_wc_custom_product_data_fields(){

        $custom_product_data_fields = array();

        $custom_product_data_fields[] = array(
            'tab_name'    => esc_html__('Additional', 'fatotheme'),
        );
        $custom_product_data_fields[] = array(
            'id'          => '_product_video_link',
            'type'        => 'text',
            'placeholder' => 'https://www.youtube.com/watch?v=videodemolink',
            'label'       => esc_html__('Product Video Link', 'fatotheme'),
            'style'       => 'width:100%;',
            'description' => esc_html__('Enter a Youtube or Vimeo Url of the product video here.', 'fatotheme'),
        );

        return $custom_product_data_fields;
    }
}

if(!function_exists('fatotheme_product_new_tab'))
{	
	global $fatotheme_theme_option, $post, $wc_cpdf;

	function fatotheme_product_new_tab( $tabs ) 
	{
		global $post, $wc_cpdf;
		// Adds the new tab
		if  (function_exists( 'wc_get_product' )) {
			
	    	$product = wc_get_product( $post->ID );

	    	if($wc_cpdf->get_value(get_the_ID(), '_product_video_link')){

				$tabs['product_video_tab'] = array(
					'title' 	=> esc_html__( 'Video', 'fatotheme' ),
					'priority' 	=> 50,
					'callback' 	=> 'fatotheme_product_tab_video'
				);
			}
		}
		return $tabs;
	}
	if(isset($fatotheme_theme_option['product_tab_video']) && $fatotheme_theme_option['product_tab_video']=='1'){
		add_filter( 'woocommerce_product_tabs', 'fatotheme_product_new_tab' );
	}
}

function fatotheme_product_tab_video() 
{
	global $fatotheme_theme_option, $wc_cpdf; $content = '';
	// The new tab content
	if($wc_cpdf->get_value(get_the_ID(), '_product_video_link')){
		$content = '<div class="video-responsive">'.wp_oembed_get($wc_cpdf->get_value(get_the_ID(), '_product_video_link')).'</div>';
	}
	echo !empty($content) ? $content : '';
}

/*==========================================================================
Related Products
==========================================================================*/
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
function fatotheme_related_products()
{

	global $fatotheme_theme_option;

	ob_start();

	$args = apply_filters( 'woocommerce_related_products_args', array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'no_found_rows'       => 1,
		'posts_per_page'	  => (int) $fatotheme_theme_option['woo-related-number'],
		'columns'			  => (int) $fatotheme_theme_option['woo-related-column'],
		'meta_query'          => WC()->query->get_meta_query(),
		'tax_query'           => WC()->query->get_tax_query()
	) );
	$related_products = new WP_Query( $args );
	$_id = uniqid();
	$data_plugin_options = 'data-plugin-options=\'{"items" : ' . $args['columns'] . ',"autoPlay": false,"pagination": false,"navigation": true}\'';

	if($args['posts_per_page']>0) :
	?>
	<div class="related-products">
		<h2 class="widget-title"><span><?php esc_html_e( 'Related Products', 'woocommerce' ); ?></span></h2>
		<?php if ( $related_products->have_posts() ) : ?>
		<div id="related-<?php echo esc_attr($_id) ?>" class="owl-carousel" <?php echo wp_kses_post($data_plugin_options); ?>>
			<?php
			while ( $related_products->have_posts() ) : $related_products->the_post(); ?>
				<div class="item col-sm-12 product-grid product-carousel">
					<?php
						wc_get_template_part( 'content', 'product-carousel' );
					?>
				</div>
			<?php
			endwhile; ?>
		</div>
		<?php else: ?>
			<p><?php echo esc_html_e('Have no product!', 'fatotheme') ?></p>
		<?php endif; ?>
	</div>
	<?php
	endif;

	$content = ob_get_clean();

	return $content;
}

/*==========================================================================
Upsells Products
==========================================================================*/
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );
if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
	function woocommerce_output_upsells() {
		global $fatotheme_theme_option;
	    woocommerce_upsell_display( $fatotheme_theme_option['woo-upsells-number'], $fatotheme_theme_option['woo-upsells-column'] ); // Display 3 products in rows of 3
	}
}
remove_action('woocommerce_cart_collaterals','woocommerce_cross_sell_display');
remove_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display',15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_cross_sell_display',22 );
remove_action('woocommerce_before_cart_totals','woocommerce_shipping_calculator',5);

/*==========================================================================
Cross Sells Products
==========================================================================*/
add_action( 'woocommerce_cross_sells_columns', 'fatotheme_cross_sells_columns' );
function fatotheme_cross_sells_columns(){
	global $fatotheme_theme_option;
	return $fatotheme_theme_option['woo-cross-sells-column'];
}
add_action( 'woocommerce_cross_sells_total', 'fatotheme_cross_sells_total' );
function fatotheme_cross_sells_total(){
	global $fatotheme_theme_option;
	return $fatotheme_theme_option['woo-cross-sells-number'];
}

function fatotheme_cross_sells_display()
{

	global $fatotheme_theme_option, $product, $woocommerce_loop;

	ob_start();

	$crosssells = $product->get_cross_sell_ids();

	if ( 0 === sizeof( $crosssells ) ) return;

	$meta_query = WC()->query->get_meta_query();

	$posts_per_page = count($crosssells);

	if(intval($fatotheme_theme_option['woo-cross-sells-number']) <= 0){
		$posts_per_page = 0;
	}elseif(intval($fatotheme_theme_option['woo-cross-sells-number']) > count($crosssells)) {
		$posts_per_page = count($crosssells);
	}elseif(intval($fatotheme_theme_option['woo-cross-sells-number']) <= count($crosssells)){
		$posts_per_page = intval($fatotheme_theme_option['woo-cross-sells-number']);
	}
	$columns = ($fatotheme_theme_option['woo-cross-sells-column']) ? intval($fatotheme_theme_option['woo-cross-sells-column']) : $woocommerce_loop['columns'];

	$data_plugin_options = 'data-plugin-options=\'{"items" : ' . esc_attr($columns) . ',"autoPlay": false,"pagination": false,"navigation": true}\'';

	$args = array(
		'post_type'           => 'product',
		'ignore_sticky_posts' => 1,
		'no_found_rows'       => 1,
		'posts_per_page'      => $posts_per_page,
		'orderby'             => 'rand',
		'post__in'            => $crosssells,
		'meta_query'          => $meta_query
	);

	$products = new WP_Query( $args );

	$_id = fatotheme_make_id();

	if ( $products->have_posts() ) : ?>

		<div class="cross-sells">
			<h2 class="widget-title"><span><?php _e( 'You may be interested in&hellip;', 'woocommerce' ) ?></span></h2>
			<div id="cross-sells-<?php echo esc_attr($_id) ?>" class="owl-carousel" <?php echo wp_kses_post($data_plugin_options); ?>>

				<?php
				while ( $products->have_posts() ) : $products->the_post(); ?>
				<div class="item col-sm-12 product-grid product-carousel">
					<?php wc_get_template_part( 'content', 'product-carousel' ); ?>
				</div>
				<?php endwhile; // end of the loop. ?>

			</div>
		</div>

	<?php endif;
	$content = ob_get_clean();

	return $content;
}

/*==========================================================================
init woocommerce
==========================================================================*/
function fatotheme_woocommerce_init(){
	remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb',20 );
}
add_action('init','fatotheme_woocommerce_init');

/*==========================================================================
Custom js add to cart
==========================================================================*/
add_action('wp_enqueue_scripts','fatotheme_woocoomerce_countdown');
function fatotheme_woocoomerce_countdown() 
{ 
   wp_enqueue_script('fatotheme-countdown', get_template_directory_uri() .'/lib/woocommerce/js/countdown.js', array( 'jquery' ),true );
   wp_localize_script('fatotheme-countdown', 'lane_countdown_l10n', array(
						    	'days' => esc_html__('Days','fatotheme'),
						    	'months' => esc_html__('Months','fatotheme'),
						    	'weeks' => esc_html__('Weeks','fatotheme'),
						    	'years' => esc_html__('Years','fatotheme'),
						    	'hours' => esc_html__('Hrs','fatotheme'),
						    	'minutes' => esc_html__('Mins','fatotheme'),
						    	'seconds' => esc_html__('Secs','fatotheme'),
						    	'day' => esc_html__('Day','fatotheme'),
						    	'month' => esc_html__('Month','fatotheme'),
						    	'week' => esc_html__('Week','fatotheme'),
						    	'year' => esc_html__('Year','fatotheme'),
						    	'hour' => esc_html__('Hr','fatotheme'),
						    	'minute' => esc_html__('Miute','fatotheme'),
						    	'second' => esc_html__('Sec','fatotheme'),
						    ) );
}

/*==========================================================================
Ajax Remove Cart
==========================================================================*/
add_action( 'wp_ajax_cart_remove_product', 'fatotheme_woocommerce_cart_remove_product' );
add_action( 'wp_ajax_nopriv_cart_remove_product', 'fatotheme_woocommerce_cart_remove_product' );
function fatotheme_woocommerce_cart_remove_product() 
{
    $cart = WC()->instance()->cart;
	$id = $_POST['product_id'];
	$cart_id = $cart->generate_cart_id($id);
	$cart_item_id = $cart->find_product_in_cart($cart_id);

	if($cart_item_id){
	   $cart->set_quantity($cart_item_id,0);
	}
	$output = array();
	$output['subtotal'] = $cart->get_cart_subtotal();
	$output['count'] = $cart->cart_contents_count;
	print_r( json_encode( $output ) );
    exit();
}

/*==========================================================================
Layout Shop : sidebar
==========================================================================*/
function fatotheme_woocommerce_layout_shop_sidebar($value)
{
	global $fatotheme_theme_option;
	return $fatotheme_theme_option['woo-shop-sidebar'];
}
add_filter( 'fatotheme_woocommerce_shop_sidebar' ,'fatotheme_woocommerce_layout_shop_sidebar' );

/*==========================================================================
Layout Single Product : sidebar 
==========================================================================*/
function fatotheme_woocommerce_layout_single_sidebar($value)
{
	global $fatotheme_theme_option;
	return $fatotheme_theme_option['woo-single-sidebar'];
}
add_filter( 'fatotheme_woocommerce_single_sidebar' ,'fatotheme_woocommerce_layout_single_sidebar' );

/*==========================================================================
Set Column class
==========================================================================*/
add_filter( 'fatotheme_woocommerce_column_class', 'fatotheme_set_column_class' );
function fatotheme_set_column_class($value)
{
	global $woocommerce_loop;

	switch ($woocommerce_loop['columns']) {
		case '2':
			$value[] = 'col-md-6';
			break;
		case '3':
			$value[] = 'col-md-4';
			break;
		case '4':
			$value[] = 'col-md-3';
			break;
		case '5':
			$value[] = 'col-grid-5';
			break;
		case '6':
			$value[] = 'col-md-2';
			break;
		default:
			$value[] = 'col-md-12';
			break;
	}
	return $value;
}


/*==========================================================================
Wishlist & Compare
==========================================================================*/
//add_filter( 'yith_wcwl_button_label',		   'fatotheme_woocomerce_icon_wishlist'  );
//add_filter( 'yith-wcwl-browse-wishlist-label', 'fatotheme_woocomerce_icon_wishlist_add' );
function fatotheme_woocomerce_icon_wishlist( $value='' )
{
	return '<i class="fa fa-heart-o"></i>';
}

function fatotheme_woocomerce_icon_wishlist_add()
{
	return '<i class="fa fa-heart"></i>';
}
if(class_exists('YITH_WCWL'))
{
	add_action( 'fatotheme_woocommerce_shop_loop_item_button_action', 'fatotheme_button_wishlist' , 40 );
	function fatotheme_button_wishlist()
	{
	?>
		<?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); ?>
	<?php
	}
}

if(class_exists( 'YITH_Woocompare' ))
{
	add_action( 'fatotheme_woocommerce_shop_loop_item_button_action', 'fatotheme_button_compare' , 50 );
	function fatotheme_button_compare()
	{
		global $product;
		$action_add = 'yith-woocompare-add-product';
        $url_args = array(
            'action' => $action_add,
            'id' => $product->get_id()
        );
	?>
		<a href="<?php echo esc_url(wp_nonce_url( add_query_arg( $url_args ), $action_add )); ?>" style="display:none!important;" data-product_id="<?php echo esc_attr($product->get_id()); ?>" class="compare">
		</a>
	<?php
	}
}
function fatotheme_update_wishlist_count(){
    if( function_exists( 'YITH_WCWL' ) ){
        wp_send_json( YITH_WCWL()->count_products() );
    }
}
add_action( 'wp_ajax_fatotheme_update_wishlist_count', 'fatotheme_update_wishlist_count' );
add_action( 'wp_ajax_nopriv_fatotheme_update_wishlist_count', 'fatotheme_update_wishlist_count' );

/*==========================================================================
Effect Hover Image Product
==========================================================================*/
remove_action('fatotheme_woocommerce_shop_loop_item_button_action', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('fatotheme_woocommerce_template_loop_product_thumbnail', 'fatotheme_woocommerce_template_loop_product_thumbnail' ,10);
if (!function_exists('fatotheme_woocommerce_template_loop_product_thumbnail')) 
{
	function  fatotheme_woocommerce_template_loop_product_thumbnail()
	{
		global $post, $product, $woocommerce;
		$shop_catalog_image_size = get_option('shop_catalog_image_size');
		$placeholder_width = $shop_catalog_image_size['width'];
		$placeholder_height = $shop_catalog_image_size['height'];
		$output=''; $class=''; $variable_img='';
		$attachment_ids    = $product->get_gallery_image_ids();
		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
		$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
		$image_title       = get_post_field( 'post_excerpt', $post_thumbnail_id );
		$available_variations = ($product->is_type('variable')) ? $product->get_available_variations() : '';

		$attributes = array(
			'title'                   => $image_title,
			'data-src'                => $full_size_image[0],
			'data-large_image'        => $full_size_image[0],
			'data-large_image_width'  => $full_size_image[1],
			'data-large_image_height' => $full_size_image[2],
		);
		
		if(has_post_thumbnail() && sizeof($attachment_ids)==0){
			$output .= '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image image-effect-none"><a href="' . esc_url( $full_size_image[0] ) . '">';
			$output .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
			$output .= '</a></div>';
		}else if(has_post_thumbnail() && $attachment_ids){
			$output.='<div class="pimage-effect">'.wp_get_attachment_image($attachment_ids[0],'shop_catalog',false,array('class'=>"attachment-shop_catalog image-effect")).'</div>';
			$output.=get_the_post_thumbnail( $post->ID,'shop_catalog',array('class'=> ($attachment_ids) ? 'post-featured-image' : 'image-effect-none' ) );
		}else if((has_post_thumbnail()==false) && $attachment_ids){
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
				$output .= apply_filters( 'woocommerce_single_product_image_html', sprintf( '<span itemprop="image" class="woocommerce-main-image" title="%s">%s</span>', $image_caption, $image ), $post->ID );
			}
		}else if (isset($available_variations) && $available_variations!=''){
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
					$output .= apply_filters( 'woocommerce_single_product_image_html', sprintf( '<span itemprop="image" class="woocommerce-main-image" title="%s">%s</span>', $image_caption, $image ), $post->ID );
				}
			}
		} else{
			$output .= '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" class="'.esc_attr($class).'" width="'.esc_attr($placeholder_width).'" height="'.esc_attr($placeholder_height).'" />';
		}
		echo !empty( $output ) ? $output : '';
	}
}


if( isset($fatotheme_theme_option['woo-is-effect-thumbnail']) && $fatotheme_theme_option['woo-is-effect-thumbnail'])
{
	add_filter('body_class','fatotheme_woocommerce_effect_hover_skin_func');
	function fatotheme_woocommerce_effect_hover_skin_func($classes)
	{
		global $fatotheme_theme_option;
		if( isset($fatotheme_theme_option['woo-effect-thumbnail-skin']) && $fatotheme_theme_option['woo-effect-thumbnail-skin']!='' ){
			$classes[] = $fatotheme_theme_option['woo-effect-thumbnail-skin'];
		}
		return $classes;
	}
}

/*==========================================================================
Woocommerce Category Column
==========================================================================*/
add_filter( 'loop_shop_columns', 'fatotheme_woocoomerce_wc_loop_shop_columns', 1 );
function fatotheme_woocoomerce_wc_loop_shop_columns()
{
	global $fatotheme_theme_option;
	$columns = ($fatotheme_theme_option['woo-shop-column']!='') ? $fatotheme_theme_option['woo-shop-column'] : 3;
	return $columns;
}

/*==========================================================================
Add Scripts
==========================================================================*/
add_action( 'wp_enqueue_scripts', 'fatotheme_woocoomerce_initScripts' );
function fatotheme_woocoomerce_initScripts()
{
	wp_enqueue_script('fatotheme-woo-quickview-script', get_template_directory_uri().'/lib/woocommerce/js/woocommerce.js',array(),true);
}


