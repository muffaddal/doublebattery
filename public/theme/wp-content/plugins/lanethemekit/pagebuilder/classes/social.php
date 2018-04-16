<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
if (!class_exists('Lane_Social')) 
{
	class Lane_Social 
	{

		function __construct() 
		{
			add_shortcode('lane_social', array($this,'lane_social_shortcode'));
		}

		function lane_social_shortcode($atts) 
		{
			global $bozon_theme_option;
			$title = '';
			extract(shortcode_atts(array(
				'title' => ''
			), $atts));
	        ob_start();?>
	        <div class="lane-social-icons">
	            <?php if(isset($title) && $title!=''): ?>
					<h3 class="widget-title"><span><?php echo wp_kses_post($title) ?></span></h3>
				<?php elseif(isset($bozon_theme_option['follow_title']) && $bozon_theme_option['follow_title']!=''): ?>
					<h3 class="widget-title"><span><?php echo wp_kses_post($bozon_theme_option['follow_title']); ?></span></h3>
				<?php endif; ?>
				<ul class="social-icons">
					<?php
					if(isset($bozon_theme_option['social_icons'])) :
			        	foreach($bozon_theme_option['social_icons'] as $key=>$value ) : 
			        		if($value!='') : 
			        			if($key=='vimeo') : ?>
									<li><a class="<?php echo esc_attr($key) ?> social-icon" data-tooltip="<?php echo esc_attr($key) ?>" href="<?php echo esc_url($value) ?>" title="<?php echo ucwords(esc_attr($key)) ?>" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>
								<?php else: ?>
									<li><a class="<?php echo esc_attr($key) ?> social-icon" data-tooltip="<?php echo esc_attr($key) ?>" href="<?php echo esc_url($value) ?>" title="<?php echo ucwords(esc_attr($key)) ?>" target="_blank"><i class="fa fa-<?php echo esc_attr($key) ?>"></i></a></li>
								<?php endif; ?>
					<?php
							endif;
						endforeach;
					endif; ?>
				</ul>
			</div>
            <?php
            $content = ob_get_clean();
            return $content;
		}
	}
	new Lane_Social;
}