<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
// Define a constant to always include the absolute path
define('LANE_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
define('LANE_POST_TYPE_NAME','ourteam');

// Include post types
include ( LANE_PLUGIN_PATH . 'ourteam_inc/post-types.php');
if(!class_exists('WPAlchemy_MetaBox')) {
    include_once ( LANE_PLUGIN_PATH . 'ourteam_inc/libraries/wpalchemy/MetaBox.php');
}
include_once ( LANE_PLUGIN_PATH . 'ourteam_inc/metaboxes/spec.php');

if(!class_exists('Lane_Ourteam'))
{
    class Lane_Ourteam
    {
        function __construct()
        {
            add_shortcode('lane_ourteam',array($this,'lane_ourteam_shortcode'));
            add_filter('rwmb_meta_boxes',array($this,'lane_register_meta_boxes'));
            if (is_admin()) {
                add_filter('manage_edit-ourteam_columns', array($this, 'lane_add_columns'));
                add_action('manage_ourteam_posts_custom_column', array($this, 'lane_set_columns_value'), 10, 2);
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
                'title' => esc_html__('Our Team Job', 'lanethemekit'),
                'pages' => array('ourteam'),
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
        function lane_ourteam_shortcode($atts)
        {
            $title=$style=$text_align=$is_slider=$item_amount=$column = $post_name=$layout_style= $html = $el_class = $css_animation = $duration = $delay = '';
            extract( shortcode_atts( array(
                'title' => '',
                'style' => 'style-1',
                'text_align' => 'text-center',
                'item_amount'   => '4',
                'is_slider'     => false ,
                'column'        => '4' ,
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => ''
            ), $atts ) );
            global $ourteam_metabox;
            global $meta;
            $args = array(
                'posts_per_page' => -1,
                'post_type' => LANE_POST_TYPE_NAME,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_status' => 'publish'
            );
            $data = new WP_Query($args);
            ob_start();
            $class_col='col-lg-'.(12/esc_attr($column)).' col-md-'.(12/esc_attr($column)).' col-sm-6  col-xs-12';
            if ($data->have_posts()) :?>
            <div class="wplane-ourteam <?php echo ($style) ? $style : '' ?> <?php echo ($text_align) ? $text_align : '' ?>">
                <div class="ourteam-container">
                    <?php if(isset($title) && $title != ''): ?>
                    <h4 class="widget-title"><span><?php echo  esc_html($title); ?></span></h4>
                    <?php endif; ?>
                    <?php if  ($is_slider) : ?>
                    <div class="ourteam-slider">
                        <div data-plugin-options='{"items" : <?php echo esc_attr($column) ?>,"itemsDesktop": <?php echo esc_attr($column) ?>,"itemsDesktopSmall":2,"itemsTablet":1,"pagination":false,"autoPlay": true}' class="owl-carousel">
                            <?php while ($data->have_posts()): $data->the_post();
                                $job = get_post_meta(get_the_ID(), 'job', true);
                                $image_id = get_post_thumbnail_id();
                                $image_url = wp_get_attachment_image($image_id, 'full', false, array('alt' => get_the_title(), 'title' => get_the_title()));
                                ?>
                                <div class="item">
                                    <div class="image">
                                        <?php echo wp_kses_post($image_url) ?>
                                        <?php if($image_url==''): ?>
                                        <img class="thumbnail-placeholder" src="<?php echo vc_asset_url( 'vc/no_image.png' ) ?>" />
                                        <?php endif; ?>
                                        <div class="social">
                                            <div class="social-s">
                                                <div class="social-w">
                                                    <?php
                                                    $meta = get_post_meta(get_the_id(), $ourteam_metabox->get_the_id(), TRUE);
                                                    if($meta):
                                                    foreach ($meta['ourteam'] as $col)
                                                    {
                                                        $socialName = isset($col['socialName'])?$col['socialName']:'';
                                                        $socialLink = isset($col['socialLink'])?$col['socialLink']:'';
                                                        $socialIcon = isset($col['socialIcon'])?$col['socialIcon']:'';
                                                        ?>
                                                        <a href="<?php echo esc_url($socialLink) ?>" title="<?php echo esc_url($socialName) ?>"><i class="<?php echo esc_attr($socialIcon) ?>"></i></a>
                                                    <?php
                                                    }
                                                    endif;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <p class="name"><?php echo get_the_title() ?></p>
                                        <p class="job"><?php echo esc_html($job) ?></p>
                                        <div class="social">
                                        <?php
                                        $meta = get_post_meta(get_the_id(), $ourteam_metabox->get_the_id(), TRUE);
                                        if($meta):
                                        foreach ($meta['ourteam'] as $col)
                                        {
                                            $socialName = isset($col['socialName'])?$col['socialName']:'';
                                            $socialLink = isset($col['socialLink'])?$col['socialLink']:'';
                                            $socialIcon = isset($col['socialIcon'])?$col['socialIcon']:'';
                                            ?>
                                            <a href="<?php echo esc_url($socialLink) ?>" title="<?php echo esc_url($socialName) ?>"><i class="<?php echo esc_attr($socialIcon) ?>"></i></a>
                                        <?php
                                        }
                                        endif;
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile;?>
                        </div>
                    </div>
                    <?php else:?>
                    <div class="row ourteam-grid">
                        <?php while ($data->have_posts()): $data->the_post();
                            $job = get_post_meta(get_the_ID(), 'job', true);
                            $image_id = get_post_thumbnail_id();
                            $image_url = wp_get_attachment_image($image_id, 'full', false, array('alt' => get_the_title(), 'title' => get_the_title()));
                            ?>
                            <div class="<?php echo esc_attr($class_col); ?>">
                                <div class="item">
                                    <div class="image">
                                        <?php echo wp_kses_post($image_url) ?>
                                        <?php if($image_url==''): ?>
                                        <img class="thumbnail-placeholder" src="<?php echo vc_asset_url( 'vc/no_image.png' ) ?>" />
                                        <?php endif; ?>
                                        <div class="social">
                                            <div class="social-s">
                                                <div class="social-w">
                                                    <?php
                                                    $meta = get_post_meta(get_the_id(), $ourteam_metabox->get_the_id(), TRUE);
                                                    if($meta):
                                                    foreach ($meta['ourteam'] as $col)
                                                    {
                                                        $socialName = isset($col['socialName'])?$col['socialName']:'';
                                                        $socialLink = isset($col['socialLink'])?$col['socialLink']:'';
                                                        $socialIcon = isset($col['socialIcon'])?$col['socialIcon']:'';
                                                        ?>
                                                        <a href="<?php echo esc_url($socialLink) ?>" title="<?php echo esc_url($socialName) ?>"><i class="<?php echo esc_attr($socialIcon) ?>"></i></a>
                                                    <?php
                                                    }
                                                    endif;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <p class="name"><?php echo get_the_title() ?></p>
                                        <p class="job"><?php echo esc_html($job) ?></p>
                                        <div class="social">
                                        <?php
                                        $meta = get_post_meta(get_the_id(), $ourteam_metabox->get_the_id(), TRUE);
                                        if($meta):
                                        foreach ($meta['ourteam'] as $col)
                                        {
                                            $socialName = isset($col['socialName'])?$col['socialName']:'';
                                            $socialLink = isset($col['socialLink'])?$col['socialLink']:'';
                                            $socialIcon = isset($col['socialIcon'])?$col['socialIcon']:'';
                                            ?>
                                            <a href="<?php echo esc_url($socialLink) ?>" title="<?php echo esc_url($socialName) ?>"><i class="<?php echo esc_attr($socialIcon) ?>"></i></a>
                                        <?php
                                        }
                                        endif;
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;?>
                    </div>
                    <?php endif;?>
                </div>
            </div>
            <?php endif;
            wp_reset_postdata();
            $content = ob_get_clean();
            return $content;
        }
    }
    new Lane_Ourteam;
} ?>
