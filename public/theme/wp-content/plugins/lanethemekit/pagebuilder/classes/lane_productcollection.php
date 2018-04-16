<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
if(!class_exists('Lane_Productcollection'))
{
    class Lane_Productcollection
    {
        function __construct()
        {
            add_shortcode('lane_productcollection', array($this, 'lane_productcollection_shortcode'));
        }
        function lane_getExtraClass( $el_class ) {
            $output = '';
            if ( '' !== $el_class ) {
                $output = ' ' . str_replace( '.', '', $el_class );
            }

            return $output;
        }
        function lane_productcollection_shortcode( $atts, $content = null ){
            $output = $title = $style = $image = $link = $el_class = $text_link = $bg_text_link = '';
            extract(shortcode_atts(array(
                'title' => '',
                'style' => 'style-1',
                'image' => '',
                'img_size' => 'full',
                'link' => '',
                'el_class' => '',
                'text_link' => 'Shop Now',
                'bg_text_link' => '',
            ), $atts));

            ob_start();

            $bg_style = ($bg_text_link == '') ? '' : ' style="background-color:'.$bg_text_link.'"';
            $img_id = preg_replace('/[^\d]/', '', $image);
            $img = wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'img-responsive' ));
            $el_class = $this->lane_getExtraClass($el_class);
            $link = vc_build_link($link); $link = $link['url'];
            ?>
            <div class="product-collection <?php if($style) echo $style; ?><?php echo (($el_class!='')?' '.$el_class:''); ?>">
                <?php if($title!=''){ ?>
                    <h3 class="widget-title"><span><?php echo esc_html($title); ?></span></h3>
                <?php } ?>
                <div class="collection">
                    <div class="image">
                        <a href="<?php echo esc_url($link); ?>"><?php echo wp_kses_post($img['thumbnail']); ?></a>
                    </div>
                    <?php if($content!='' || $text_link!=''): ?>
                    <div class="collection-inner">
                        <div class="collection-description">
                            <div class="content">
                                <?php echo wpb_js_remove_wpautop($content, true); ?>
                                <?php if($text_link!='') : ?>
                                    <p class="btn-readmore"><a class="btn btn-default"<?php echo wp_kses_post($bg_style); ?> href="<?php echo esc_url($link); ?>"><?php echo esc_html($text_link); ?></a></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php
            wp_reset_postdata();
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }
    }
    new Lane_Productcollection;
}