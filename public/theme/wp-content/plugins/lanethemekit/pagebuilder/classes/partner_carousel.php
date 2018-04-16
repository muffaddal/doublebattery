<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
if (!class_exists('Lane_Partnercarousel')) {
	class Lane_Partnercarousel
	{
		function __construct()
		{
			add_shortcode('lane_partnercarousel', array($this, 'lane_partnercarousel_shortcode'));
		}

		function lane_partnercarousel_shortcode($atts)
		{
			$navigation = $pagination = $img_size = $autoplay = $column = $custom_links_target = $custom_links = $images = $layout = $style = $html = $el_class = $css_animation = $duration = $delay = '';
			extract(shortcode_atts(array(
				'title' => '',
				'images' => '',
				'custom_links' => '',
				'custom_links_target' => '_blank',
				'img_size' => 'thumbnail',
				'layout' => 'carousel',
				'style' => 'style-1',
				'column' => 5,
				'autoplay' => '',
				'pagination' => '',
				'navigation' => '',
				'el_class' => '',
				'css_animation' => '',
				'duration' => '',
				'delay' => ''
			), $atts));

			ob_start();
			
			if ($images == '') $images = '-1,-2,-3';

			$custom_links = explode(',', $custom_links);

			$images = explode(',', $images);
			$i = -1;
			$irow = 0;
			$autoplay = ($autoplay == 'yes') ? 'true' : 'false';
			$pagination = ($pagination == 'yes') ? 'true' : 'false';
			$navigation = ($navigation == 'yes') ? 'true' : 'false';
            $data_plugin_options = 'data-plugin-options=\'{"items" : ' . esc_attr($column) . ', "autoPlay": ' . esc_attr($autoplay) . ',"pagination": ' . esc_attr($pagination) . ',"navigation": ' . esc_attr($navigation) . '}\'';
            ?>
			<div class="wplane-partner-carousel <?php echo esc_attr($layout) ?> <?php if($style) echo $style; ?><?php echo (($el_class!='')?' '.$el_class:''); ?>">
				<?php if(isset($title) && $title != ''): ?>
               	<h4 class="widget-title"><span><?php echo  esc_html($title); ?></span></h4>
            	<?php endif; ?>
				<?php if($layout=='carousel'){ ?>
				    <div class="owl-carousel" <?php echo wp_kses_post($data_plugin_options); ?>>
	                <?php foreach ($images as $attach_id):
	                    $i++;
	                    if ($attach_id > 0) {
	                        $post_thumbnail = wpb_getImageBySize(array('attach_id' => $attach_id, 'thumb_size' => $img_size));
	                    } else {
	                        $post_thumbnail = array();
	                        $post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url('vc/no_image.png') . '" />';
	                        $post_thumbnail['p_img_large'][0] = vc_asset_url('vc/no_image.png');
	                    }
	                    $thumbnail = $post_thumbnail['thumbnail'];
	                    if (isset($custom_links[$i]) && $custom_links[$i] != ''):?>
	                        <div class="partner">
	                            <a href="<?php echo esc_url($custom_links[$i]) ?>" target="<?php echo esc_attr($custom_links_target) ?>">
	                                <?php echo wp_kses_post($thumbnail) ?>
	                            </a>
	                        </div>
	                    <?php else:?>
	                        <div class="partner"><?php echo wp_kses_post($thumbnail) ?></div>
	                    <?php endif;
					endforeach;?>
				    </div>
				<?php }else{ ?>
					<div class="row">
						<?php
							foreach ($images as $attach_id):
		                    $i++;$irow++;
		                    $count = count($images);
		                    $col = ' col-sm-'.floor(12/$column);
		                    if ($attach_id > 0) {
		                        $post_thumbnail = wpb_getImageBySize(array('attach_id' => $attach_id, 'thumb_size' => $img_size));
		                    } else {
		                        $post_thumbnail = array();
		                        $post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url('vc/no_image.png') . '" />';
		                        $post_thumbnail['p_img_large'][0] = vc_asset_url('vc/no_image.png');
		                    }
		                    $thumbnail = $post_thumbnail['thumbnail'];
		                    if (isset($custom_links[$i]) && $custom_links[$i] != ''):?>
		                        <div class="partner<?php echo esc_attr($col); ?>">
		                            <a href="<?php echo esc_url($custom_links[$i]) ?>" target="<?php echo esc_attr($custom_links_target) ?>">
		                                <?php echo wp_kses_post($thumbnail) ?>
		                            </a>
		                        </div>
		                    <?php else:?>
		                        <div class="partner<?php echo esc_attr($col); ?>">
		                        	<?php echo wp_kses_post($thumbnail) ?>
		                        </div>
		                    <?php endif;
		                    if ($irow%intval($column)==0 && $irow<$count) echo '</div><div class="row">';
					endforeach; ?>
					</div>
				<?php } ?>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
		}
	}
	new Lane_Partnercarousel;
}?>