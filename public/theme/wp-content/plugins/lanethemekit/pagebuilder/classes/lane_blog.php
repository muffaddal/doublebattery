<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Extends VC Posts Class
require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-posts-grid.php' );

if(!class_exists('Lane_Blog'))
{
    class Lane_Blog extends WPBakeryShortCode_VC_Posts_Grid
    {
        function __construct()
        {
            add_shortcode('lane_blog', array($this, 'lane_blog_shortcode'));
        }

        function lane_blog_shortcode( $atts, $content = null )
        {
            $grid_link = $layout_mode = $title = $layout = $style = $filter = $el_class = $loop = $autoplay = $show_pagination = $show_navigation = $post_meta = $post_readmore = '';
            $posts = array();

            extract(shortcode_atts(array(
                'title' => '',
                'columns_count' => 4,
                'layout' => 'grid',
                'visible_items' => 3,
                'style'=>'style-1',
                'el_class' => '',
                'post_meta' => '',
                'post_readmore' => '',
                'orderby' => NULL,
                'order' => 'DESC',
                'loop' => '',
                'autoplay' => '',
                'show_pagination' => '',
                'show_navigation' => ''
            ), $atts));

            ob_start();

            if(empty($loop)) return;
            $loop_args = array();
            $this->getLoop($loop);
            //$sticky = get_option('sticky_posts');
            //$this->loop_args['post__not_in'] = $sticky;
            $my_posts = new WP_Query($this->loop_args);
            $column = floor(12/$columns_count);
            $post_count = 0;
            $_id = rand();
            $post_meta = ($post_meta == '')?'':' hide-post-meta';
            $post_readmore = ($post_readmore == '')?'':' hide-post-readmore';
            $autoplay = ($autoplay == '')?'false':'true';
            $is_pagination = ($show_pagination == '')?'false':'true';
            $is_navigation = ($show_navigation == '')?'false':'true';
            $columns_count = ($layout=='list') ? 1 : $columns_count;
            $data_plugin_options = 'data-plugin-options=\'{"items" : ' . esc_attr($columns_count) . ', "autoPlay": ' . esc_attr($autoplay) . ',"pagination": ' . esc_attr($is_pagination) . ',"navigation": ' . esc_attr($is_navigation) . '}\'';
            ?>
            <div class="blog-posts<?php if($layout=='carousel') echo ' layout-carousel'; ?> <?php if($style) echo $style; ?><?php echo (($el_class!='')?' '.$el_class:''); ?><?php echo esc_attr($post_meta) ?><?php echo esc_attr($post_readmore) ?>">
                
                <?php if(isset($title) && $title != ''): ?>
                    <h3 class="widget-title"><span><?php echo esc_html($title) ?></span></h3>
                <?php endif; ?>
                
                <?php if($layout=='carousel'){ ?>
                    <div id="blog-posts-carousel-<?php echo esc_attr($_id); ?>" class="blog-posts-carousel owl-carousel" <?php echo wp_kses_post($data_plugin_options); ?>>
                        <?php
                        while ( $my_posts->have_posts() ): $my_posts->the_post(); 
                            global $post;
                            $count = $my_posts->post_count;
                            $post_count++;
                             ?>
                            <article id="post-<?php the_ID(); ?>" class="item post post-widget col-sm-12">
                                <?php get_template_part( 'templates/blog/blog-widget' ); ?>
                            </article>
                        <?php
                        endwhile; ?>
                        <?php if($columns_count=='1'): ?>
                        <script type="text/javascript">
                        <!--
                        (function($) {
                            "use strict";
                            $(document).ready(function() {
                                var blogCarouselSingleItem = $("#blog-posts-carousel-<?php echo esc_attr($_id); ?>");
                                blogCarouselSingleItem.owlCarousel({
                                    singleItem : true
                                });
                            });
                        })(jQuery);
                        -->
                        </script>
                        <?php endif; ?>
                    </div>
                <?php }elseif($layout=='grid'){ ?>
                    <div class="row">
                        <?php
                        while ( $my_posts->have_posts() ): $my_posts->the_post(); global $post ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('post post-widget col-sm-'.$column ); ?>>
                                <?php get_template_part( 'templates/blog/blog-widget' ); ?>
                            </article>
                        <?php
                        endwhile; ?>
                    </div>
                <?php }elseif($layout=='list'){ ?>
                    <div id="blog-posts-carousel-<?php echo esc_attr($_id); ?>" class="blog-posts-carousel list owl-carousel" <?php echo $data_plugin_options; ?>>
                        <div class="items">
                            <?php
                            while ( $my_posts->have_posts() ): $my_posts->the_post(); 
                                global $post;
                                $count = $my_posts->post_count;
                                $post_count++;
                                 ?>
                                <article id="post-<?php the_ID(); ?>" class="item post post-widget col-sm-12">
                                    <?php get_template_part( 'templates/blog/blog-widget' ); ?>
                                </article>
                            <?php
                            if ($post_count%$visible_items==0 && $post_count < $count) echo '</div><div class="items">';
                            endwhile; ?>
                        </div>
                    </div>
                    <script type="text/javascript">
                    <!--
                    (function($) {
                        "use strict";
                        $(document).ready(function() {
                            var blogCarouselSingleItem = $("#blog-posts-carousel-<?php echo esc_attr($_id); ?>");
                            blogCarouselSingleItem.owlCarousel({
                                singleItem : true
                            });
                        });
                    })(jQuery);
                    -->
                    </script>
                <?php } ?>
            </div>
            <?php
            wp_reset_postdata();
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }
    }
    new Lane_Blog;
}
