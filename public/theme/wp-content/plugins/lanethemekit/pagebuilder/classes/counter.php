<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
if(!class_exists('Lane_Counter')){
    class Lane_Counter{
        function __construct(){
            add_shortcode('lane_counter', array($this, 'lane_counter_shortcode'));
        }
        function lane_counter_shortcode($atts){
            $units= $icon=$value = $title = $layout_style = $html = $el_class = '';
            extract( shortcode_atts( array(
                'value' => '',
                'units'=> '',
                'title' => '',
                'icon'	=> '',
                'el_class'       => ''
            ), $atts ) );

            wp_enqueue_script('jquery_countTo_lane_counter',plugins_url('lanethemekit/assets/js/jquery_counter/jquery.countTo.min.js'),true);
            ob_start();?>
            <div class="counter wplane-counter">
                <i class="<?php echo esc_attr($icon) ?>"></i>
                <?php if ( $value != '' ) :?>
                    <span class="counter-percent" data-percentage="<?php echo esc_attr($value) ?>"><?php echo esc_html($value) ?></span>
                    <?php if ( $units != '' ) :?>
                        <span class="counter-units"><?php echo esc_html($units) ?></span>
                    <?php endif;?>
                <?php endif;?>
                <?php if ( $title != '' ) :?>
                    <p class="counter-title"><?php echo esc_html($title)  ?></p>
                <?php endif;?>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new Lane_Counter;
}?>