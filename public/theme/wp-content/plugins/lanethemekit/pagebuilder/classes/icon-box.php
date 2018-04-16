<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
if (!class_exists('Lane_Iconbox')) 
{
	class Lane_Iconbox 
	{

		function __construct() 
		{
			add_shortcode('lane_iconbox', array($this,'lane_iconbox_shortcode'));
		}

		function lane_iconbox_shortcode($atts) 
		{
			$link = $style = $text_align = $icon_size = $description = $title = $icon_type = $iconpicker = $font_awesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_monosocial = $icon_material = $extra_icon = $html = $el_class = $css_animation = $duration = $delay = $is_icon = $icon_images = '';
			extract(shortcode_atts(array(
				'style' => 'style-1',
				'text_align' => 'text-center',
				'icon_type' => 'awesome',
				'font_awesome' => 'fa fa-adjust',
				'icon_openiconic' => 'vc-oi vc-oi-dial',
				'icon_typicons' => 'typcn typcn-adjust-brightness',
				'icon_entypo' => 'entypo-icon entypo-icon-note',
				'icon_linecons' => 'vc_li vc_li-heart',
				'icon_monosocial' => 'vc-mono vc-mono-fivehundredpx',
				'icon_material' => 'vc-material vc-material-cake',
				'extra_icon' => '',
				'icon_images' => '',
				'icon_size' => '',
				'link' => '',
				'title' => '',
				'description' => '',
				'el_class' => '',
				'css_animation' => '',
				'duration' => '',
				'delay' => ''
			), $atts));
            
            ob_start();

            $icon = '';

			switch ( $icon_type ) {
				case 'awesome':
					$icon = $font_awesome;
					break;
				case 'openiconic':
					$icon = $icon_openiconic;
					wp_enqueue_style( 'vc_openiconic' );
					break;
				case 'typicons':
					$icon = $icon_typicons;
					wp_enqueue_style( 'vc_typicons' );
					break;
				case 'entypo':
					$icon = $icon_entypo;
					wp_enqueue_style( 'vc_entypo' );
					break;
				case 'linecons':
					$icon = $icon_linecons;
					wp_enqueue_style( 'vc_linecons' );
					break;
				case 'monosocial':
					$icon = $icon_monosocial;
					wp_enqueue_style( 'vc_monosocialiconsfont' );
					break;
				case 'material':
					$icon = $icon_material;
					wp_enqueue_style( 'vc_material' );
					break;
				default:
					$icon = $font_awesome;
			}
            
            $i = 0;
            $img_class = $post_thumbnail = '';
            $is_icon = isset($icon) ? esc_attr($icon) : 'fa fa-adjust';
            if($icon_type=='font_7stroke') {$is_icon = htmlspecialchars($extra_icon); }
            if($icon_type=='icon_type_image') {
            	if ($icon_images=='') $icon_images = '-1,-2,-3';
            	$icon_images = explode(',', $icon_images);
            }
            if (isset($icon_size) && $icon_size!='') {
            	$icon_size = ' style="font-size:'.intval($icon_size).'px"';
            }
            ?>
			<div class="wplane-icon-box <?php if($style) echo $style; ?> <?php if($text_align) echo $text_align; ?><?php echo (($el_class!='')?' '.$el_class:''); ?>">
				<div class="icon-box">
					<?php if($icon_type=='icon_type_image') : ?>
						<a class="box-icon icon-image" href="<?php echo  esc_url($link) ?>"><span>
							<?php foreach ($icon_images as $attach_id):
			                    $i++;
			                    $img_class = ($i==1) ? 'img-first' : 'img-second';
			                    $post_thumbnail = wpb_getImageBySize(array('attach_id' => $attach_id, 'thumb_size' => 'full', 'class' => $img_class));
			                    // return content
			                    echo wp_kses_post($post_thumbnail['thumbnail']);
							endforeach;?>
						</span></a>
					<?php else: ?>
	                	<a class="box-icon" href="<?php echo  esc_url($link) ?>"><span<?php echo wp_kses_post($icon_size) ?>><i class="<?php echo esc_attr($is_icon) ?>"></i></span></a>
	                <?php endif; ?>
	                <div class="box-info">
		                <a class="box-title" href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
		                <?php if($description!=''):?>
		                    <p class="desc"><?php echo wp_kses_post($description) ?></p>
		                <?php endif;?>
	                </div>
	            </div>
			</div>
            <?php
            $content = ob_get_clean();
            return $content;
		}
	}
	new Lane_Iconbox;
}