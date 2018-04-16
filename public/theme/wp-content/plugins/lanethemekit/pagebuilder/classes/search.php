<?php
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if (!class_exists('Lane_Search')) 
{
	class Lane_Search 
	{
		function __construct() 
		{
			add_shortcode('lane_search', array($this, 'lane_search_shortcode' ));
		}
		function lane_front_scripts() 
		{
            $min_suffix = defined( 'LANE_SCRIPT_DEBUG' ) && LANE_SCRIPT_DEBUG ? '' : '.min';
            wp_enqueue_script('wplane-search',plugins_url() . '/lanethemekit/assets/js/search_wc.js', false, true);
        }
		function lane_search_shortcode($atts) 
		{
			$title = $el_class = '';
			extract(shortcode_atts(array(
				'title' => '',
				'el_class'      => ''
			), $atts));

			global $woocommerce_loop;
			ob_start();
			?>
			<?php if( class_exists('WC_Widget_Product_Categories') && class_exists('WC_Widget_Product_Search') ) { ?>
			<div class="wplane-search-element">
				<?php if(isset($title) && $title!=''): ?>
					<h3><?php echo wp_kses_post($title) ?></h3>
				<?php endif; ?>
				<?php get_template_part( 'templates/filter','search' ); ?>
			</div>
			<?php }else{ ?>
			<div class="wplane-search-element">
				<p><?php esc_html_e('Woocommerce is not exit!','lanethemekit')  ?></p>
			</div>
			<?php } ?>
			<?php
			$content = ob_get_clean();
			return $content;
		}
	}
	new Lane_Search;
}