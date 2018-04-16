<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
if(!class_exists('Lane_Mailchimp'))
{
    class Lane_Mailchimp
    {
        function __construct()
        {
            add_shortcode('lane_mailchimp', array($this, 'lane_mailchimp_shortcode'));
        }
        function lane_mailchimp_shortcode($atts)
        {
            $title= $description = $html = $el_class = $css_animation = $duration = $delay = '';
            extract( shortcode_atts( array(
                'title'         => '',
                'description'   => '',
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => ''
            ), $atts ) );
            ob_start(); ?>
                <div  class="wplane-mailchimp<?php echo (($el_class!='')?' '.$el_class:''); ?>">
                    <div class="mailchimp-container">
                        <?php if($title!='' || $description!='' ) : ?>
                        <div class="mailchimp-heading">
                            <?php if($title!='') : ?>
                                <h2><?php echo  wp_kses_post($title); ?></h2>
                                <div class="heading-line"><span></span></div>
                            <?php endif; ?>
                            <?php if($description!='' ) : ?>
                                <span class="heading-sub-title"><?php echo wp_kses_post($description); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <?php echo do_shortcode('[mc4wp_form]'); ?>
                    </div>
                </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new Lane_Mailchimp;
}