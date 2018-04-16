<?php
class Theme_Product_UpSell extends  ThemeClass_Widget {
	public function __construct() {
		$this->widget_cssclass    = 'widget-product-upsell';
		$this->widget_description = esc_html__( 'Lane Products Widget', 'fatotheme' );
		$this->widget_id          = 'lane-product-upsell';
		$this->widget_name        = esc_html__( 'Lane Products Widget', 'fatotheme' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Title', 'fatotheme' )
			),
			'cats_filter'  => array(
				'type'  => 'text-area',
				'std'   => '',
				'label' => esc_html__( 'Name of Product Categories', 'fatotheme' ),
				'description' => esc_html__( 'Please insert name of product categories follow sample: Computer,Electronics,Phone. Go to Products->Categories on left sidebar for exactly of name.','fatotheme')
			),
			'product_type' => array(
				'type' => 'select',
				'options' => array(
					'upsells'	   	   => 'Upsells Product',
					'best_selling'	   => 'Best Selling',
					'featured_product' => 'Featured Products',
					'top_rate'		   => 'Top Rate',
					'recent_product'   => 'Recent Products',
					'on_sale'		   => 'On Sale',
					'recent_review'	   => 'Recent Review',
					'deals'			   => 'Product Deals'
				),
				'std' => 'Upsells Product',
				'label' => esc_html__( 'Product Type', 'fatotheme' )
			),
			'layout_type' => array(
				'type' => 'select',
				'options' => array(
					'style_1' => 'Style 1',
					'style_2' => 'Style 2'
				),
				'std' => 'Style 1',
				'label' => esc_html__( 'Layout Type', 'fatotheme' )
			),
			'total' => array(
				'type' => 'text',
				'std'  => '6',
				'label' => esc_html__( 'Total Product', 'fatotheme' )
			),
			'number_visible' => array(
				'type' => 'text',
				'std'  => '3',
				'label' => esc_html__( 'Number Product Visible', 'fatotheme' )
			),
			'carousel_interval' => array(
				'type' => 'text',
				'std'  => '5000',
				'label' => esc_html__( 'Number Product Visible', 'fatotheme' ),
				'description' => esc_html__( 'The amount of time to delay between automatically cycling an item. If false, carousel will not automatically cycle.','fatotheme')
			)
		);
		parent::__construct();
	}

	/**
	 * Get product categories
	 *
	 * @return array
	 */
	function lane_product_categories() {
	    $product_categories = get_categories( array(
	        'hide_empty'   => 0,
	        'hierarchical' => 1,
	        'taxonomy'     => 'product_cat'
	    ));
	    $pcategories = array();
	    
	    foreach ($product_categories as $cat) {
	        $pcategories[$cat->name] = $cat->slug;
	    }

	    return $pcategories;
	}

	function widget( $args, $instance ) {

		if ( $this->get_cached_widget( $args ) ) {
			return;
		}
		ob_start();

		extract( $args, EXTR_SKIP );
		
		$title   = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$cats_filter   = empty( $instance['cats_filter'] ) ? '' : apply_filters( 'widget_cats_filter', $instance['cats_filter'] );
		$class_custom   = empty( $instance['class_custom'] ) ? '' : apply_filters( 'widget_class_custom', $instance['class_custom'] );
		$carousel_type  = empty( $instance['carousel_type'] ) ? '' : apply_filters( 'widget_carousel_type', $instance['carousel_type'] );
		$product_type   = empty( $instance['product_type'] ) ? '' : apply_filters( 'widget_product_type', $instance['product_type'] );
		$layout_type   = empty( $instance['layout_type'] ) ? '' : apply_filters( 'widget_layout_type', $instance['layout_type'] );
		$total   = empty( $instance['total'] ) ? '' : apply_filters( 'widget_total', $instance['total'] );
		$number_visible   = empty( $instance['number_visible'] ) ? '' : apply_filters( 'widget_number_visible', $instance['number_visible'] );
		$carousel_interval   = empty( $instance['carousel_interval'] ) ? '' : apply_filters( 'widget_carousel_interval', $instance['carousel_interval'] );
		
		global $product, $wp_query;
		
		$upsells = array();

		if ($product) {
			$upsells = $product->get_upsell_ids();
			if ( sizeof( $upsells ) == 0 )  return;
		}
		if($upsells) {
			$meta_query = WC()->query->get_meta_query();

			$query_args = array(
				'post_type'           => 'product',
				'ignore_sticky_posts' => 1,
				'no_found_rows'       => 1,
				'post__in'            => $upsells,
				'post__not_in'        => array( $product->get_id() ),
				'meta_query'          => $meta_query,
			);

			$products = new WP_Query( $query_args );
		} else {
			$pcats_filter = ($cats_filter) ? explode(',', $cats_filter) : array();
			$all_pcats = $this->lane_product_categories();
			$pcats = array();
			foreach ($all_pcats as $pcat_name => $pcat_id) {
				if (in_array($pcat_name, $pcats_filter)) {
					$pcats[] = $pcat_id;
				}
			}
			$pcats = implode(',',$pcats);
			
			$products = lane_woocommerce_query($product_type,$total,$pcats);
		}
		if ($total>$products->post_count) $total = $products->post_count;
		$_id = fatotheme_make_id();

		if ($products->have_posts()) {
			echo wp_kses_post($args['before_widget']);
			if (!empty($title)) {
				echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
			}
			?>
			<div class="lane-product-widget <?php if($layout_type) echo esc_attr($layout_type); ?>">
			<?php if($carousel_type == '1'): ?>
				<div id="product-upsell-carousel-<?php echo esc_attr($_id) ?>" class="carousel slide"  data-interval="<?php echo esc_attr(intval($carousel_interval)); ?>" data-ride="carousel">
					<div class="next-prev-buttons">
						<!-- Controls -->
						<a class="control left" href="#product-upsell-carousel-<?php echo esc_attr($_id) ?>" role="button" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a class="control right" href="#product-upsell-carousel-<?php echo esc_attr($_id) ?>" role="button" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<?php
							$idx = 1;
							while($products->have_posts()):
								$products->the_post();
								wc_get_template( 'content-widget-product.php', array( 'show_rating' => false, 'show_description' => false ),'','' );
							if ($idx%$number_visible==0 && $idx < $total) echo '</div><div class="item">';
							++$idx;
							endwhile; ?>
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="product_list_widget <?php echo esc_attr($class_custom) ?>">
					<?php while($products->have_posts()) {
						$products->the_post();
						wc_get_template( 'content-widget-product.php', array( 'show_rating' => false, 'show_description' => false ),'','' );
					}?>
				</div>
			<?php endif; ?>
			</div>
			<?php
			echo wp_kses_post($args['after_widget']);
		}
		wp_reset_postdata();
		$content = ob_get_clean();
		echo !empty( $content ) ? $content : '';
		$this->cache_widget( $args, $content );
	}
}
if (!function_exists('fatotheme_register_widget_product_upsell')) {
	function fatotheme_register_widget_product_upsell() {
		register_widget('Theme_Product_UpSell');
	}
	add_action('widgets_init', 'fatotheme_register_widget_product_upsell', 1);
}