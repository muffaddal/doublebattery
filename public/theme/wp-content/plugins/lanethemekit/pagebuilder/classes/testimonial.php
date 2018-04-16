<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
if (!class_exists('Lane_Testimonial')) {
	class Lane_Testimonial
	{
		function __construct()
		{
			add_shortcode('lane_testimonial',array($this,'lane_testimonial_shortcode'));
			add_action('init', array($this, 'lane_register_post_types'), 5);
			add_filter('rwmb_meta_boxes', array($this, 'lane_register_meta_boxes'));
			if (is_admin()) {
				add_filter('manage_edit-testimonial_columns', array($this, 'lane_add_columns'));
				add_action('manage_testimonial_posts_custom_column', array($this, 'lane_set_columns_value'), 10, 2);
			}
		}

		function lane_add_columns($columns)
		{
			unset(
				$columns['cb'],
				$columns['title'],
				$columns['date']
			);
			$cols = array_merge(array('cb' => ('')), $columns);
			$cols = array_merge($cols, array('title' => esc_html__('Name', 'lanethemekit')));
			$cols = array_merge($cols, array('job' => esc_html__('Job', 'lanethemekit')));
			$cols = array_merge($cols, array('thumbnail' => esc_html__('Picture', 'lanethemekit')));
			$cols = array_merge($cols, array('date' => esc_html__('Date', 'lanethemekit')));
			return $cols;
		}

		function lane_set_columns_value($column, $post_id)
		{
			switch ($column) {
				case 'id':
				{
					echo wp_kses_post($post_id);
					break;
				}
				case 'job':
				{
					echo get_post_meta($post_id, 'job', true);
					break;
				}
				case 'thumbnail':
				{
					echo get_the_post_thumbnail($post_id, 'thumbnail');
					break;
				}
			}
		}

		function lane_register_meta_boxes($meta_boxes)
		{
			$meta_boxes[] = array(
				'title' => esc_html__('Testimonials', 'lanethemekit'),
				'pages' => array('testimonial'),
				'fields' => array(
					array(
						'name' => esc_html__('Job', 'lanethemekit'),
						'id' => 'job',
						'type' => 'text',
					),
				)
			);
			return $meta_boxes;
		}

		function lane_register_post_types()
		{
			if (post_type_exists('testimonial')) 
			{
				return;
			}

			register_post_type('testimonial',
				array(
					'label' => esc_html__('lane_testimonial', 'lanethemekit'),
					'description' => esc_html__('Testimonial Description', 'lanethemekit'),
					'labels' => array(
						'name' => _x('Testimonials', 'Post Type General Name', 'lanethemekit'),
						'singular_name' => _x('Testimonials', 'Post Type Singular Name', 'lanethemekit'),
						'menu_name' => esc_html__('Testimonials', 'lanethemekit'),
						'all_items' => esc_html__('All Testimonials', 'lanethemekit'),
						'add_new_item' => esc_html__('Add New Testimonial', 'lanethemekit'),
					),
					'supports' => array('title', 'excerpt', 'thumbnail'),
					'public' => true,
					'has_archive' => true
				)
			);
		}

		function lane_getExtraClass( $el_class ) {
            $output = '';
            if ( '' !== $el_class ) {
                $output = ' ' . str_replace( '.', '', $el_class );
            }

            return $output;
        }

		function lane_testimonial_shortcode($atts)
		{
			$navigation = $pagination = $layout = $style = $columns_count = $autoplay = $title = $bg_images = $html = $el_class = $css_animation = $duration = $delay = $el_class = '';
			extract(shortcode_atts(array(
				'title' => '',
				'bg_images' => '',
				'el_class' => '',
				'layout' => 'carousel',
				'style' => 'style-1',
				'columns_count' => '',
				'autoplay' => '',
				'pagination' => '',
				'navigation' => '',
				'css_animation' => '',
				'duration' => '',
				'delay' => '',
				'el_class' => ''
			), $atts));

			ob_start();

			$style_bg_images = '';
			if (!empty($bg_images)) {
				$bg_images_attr = wp_get_attachment_image_src($bg_images, "full");
				if (isset($bg_images_attr)) {
					$style_bg_images = 'style="background-image: url(' . $bg_images_attr[0] . ')"';
				}
			}
			$args = array(
				'posts_per_page' => -1,
				'post_type' => 'testimonial',
				'orderby' => 'date',
				'order' => 'ASC',
				'post_status' => 'publish'
			);
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
					$class_column='col-md-4';
					break;
			}
			$el_class = $this->lane_getExtraClass($el_class);
			$autoplay = ($autoplay == '') ? 'false' : 'true';
			$is_pagination = ($pagination == '') ? 'false' : 'true';
			$is_navigation = ($navigation == '') ? 'false' : 'true';
			$singleItem = ($columns_count=='1') ? 'true' : 'false';
         	$data_plugin_options = 'data-plugin-options=\'{"singleItem": ' . esc_attr($singleItem) . ',"items" : ' . esc_attr($columns_count) . ',"autoPlay": ' . esc_attr($autoplay) . ',"pagination": ' . esc_attr($is_pagination) . ',"navigation": ' . esc_attr($is_navigation) . '}\'';
			$data = new WP_Query($args);

			$rand_id = uniqid(); 


			if ($data->have_posts()) : ?>
			<div <?php echo wp_kses_post($style_bg_images); ?> class="wplane-testimonial <?php if($style) echo $style; ?><?php echo (($el_class!='')?' '.$el_class:''); ?>">
               	<?php if(isset($title) && $title != ''): ?>
               	<h4 class="widget-title"><span><?php echo  esc_html($title); ?></span></h4>
            	<?php endif; ?>
				
				<?php if($layout=='carousel'){ ?>
				   	<div id="testimonial-owl-carousel1-<?php echo esc_attr($rand_id) ?>" class="testimonial-carousel owl-carousel" <?php echo wp_kses_post($data_plugin_options); ?>>
		               	<?php while ($data->have_posts()): $data->the_post();
							$job = get_post_meta(get_the_ID(), 'job', true);
							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image($image_id, 'full img-circle', false, array('alt' => get_the_title(), 'title' => get_the_title()));
		               	?>
	                  	<div class="item col-md-12">
	                     	<div class="content">
	                        	<?php echo wp_kses_post(get_the_excerpt()) ?>
	                     	</div>
							
	                     	<?php if($image_url): ?>
	                     	<div class="image">
		                     	<?php echo wp_kses_post($image_url) ?>
		                  	</div>
		               		<?php endif; ?>

		                  	<div class="info">
								<p class="name"><?php echo get_the_title() ?></p>
								<p class="job"><?php echo esc_html($job) ?></p>
							</div>
	               		</div>
	               		<?php endwhile; ?>
				   	</div>
				   	<?php  if($columns_count=='1'): ?>
					<script type="text/javascript">
					<!--
					(function($) {
						"use strict";
						$(document).ready(function() {
							var carouselSingleItem = $("#testimonial-owl-carousel1-<?php echo esc_attr($rand_id) ?>");
							carouselSingleItem.owlCarousel({
								autoPlay: <?php echo $autoplay ?>,
								singleItem : true,
								navigation: <?php echo $is_navigation ?>,
								pagination: <?php echo $is_pagination ?>,
								navigationText: ["<i class='arrow_left'></i>", "<i class='arrow_right'></i>"],
							});
						});
					})(jQuery);
					-->
					</script>
					<?php endif; ?>
				<?php }else{ ?>
					<div class="testimonial-grid row">
						<?php while ($data->have_posts()): $data->the_post();
								$job = get_post_meta(get_the_ID(), 'job', true);
								$image_id = get_post_thumbnail_id();
								$image_url = wp_get_attachment_image($image_id, 'full img-circle', false, array('alt' => get_the_title(), 'title' => get_the_title()));
			               	?>
			               	<div class="<?php echo esc_attr($class_column) ?>">
			                  	<div class="item">
			                     	<div class="content">
			                        	<?php echo wp_kses_post(get_the_excerpt()) ?>
			                     	</div>
									
			                     	<?php if($image_url): ?>
			                     	<div class="image">
				                     	<?php echo wp_kses_post($image_url) ?>
				                  	</div>
				               		<?php endif; ?>

				                  	<div class="info">
										<p class="name"><?php echo get_the_title() ?></p>
										<p class="job"><?php echo esc_html($job) ?></p>
									</div>
			               		</div>
			               	</div>
		               	<?php endwhile;?>
				   	</div>
				<?php } // End Layout ?>
            </div>
			<?php endif; // End Data Has Post
            wp_reset_postdata();
            $content = ob_get_clean();
            return $content;
		}
	}
	new Lane_Testimonial;
}?>