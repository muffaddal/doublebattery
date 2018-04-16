<?php
// Block direct requests
if ( !defined('ABSPATH') )
    die('-1');

//PHP 5.3+ only: 
//add_action( 'widgets_init', function(){
//    register_widget( 'Lane_Posts_Widget' );
//});

//PHP 5.2+:
//add_action('widgets_init',
//    create_function('', 'return register_widget("Lane_Posts_Widget");')
//);

// register Foo_Widget widget
function register_lane_posts_widget() {
    register_widget( 'Lane_Posts_Widget' );
}
add_action( 'widgets_init', 'register_lane_posts_widget' );

class Lane_Posts_Widget extends WP_Widget 
{
    public function __construct() 
    {
        parent::__construct(
            // Base ID of your widget
            'lane_posts_widget',
            // Widget name will appear in UI
            esc_html__('Lane Posts Widget', 'lanethemekit'),
            // Widget description
            array( 'description' => esc_html__( 'Recent posts widget.', 'lanethemekit' ), )
        );

        add_action('after_setup_theme', array($this,'post_register_image_size'));
    }

    function post_register_image_size(){
        add_image_size('thumbnailsize-blog-widget',370,230,true);
    }

    static function setup_widget_form( $instance, $widget ) {
        $widget->id_base    .= self::get_widget_id_base( $instance, $widget );
        $widget->name       .= self::get_widget_name( $instance, $widget );
    }
 
    static function get_widget_id_base( $instance, $widget ) {
        global $my_config_object;

        return get_option( 'my_widget_id_base_prefix' ) . '_' . $my_config_object['current_site']['widgets']['id_base'];
    }
 
    static function get_widget_name( $instance, $widget ) {
        $name = '';
        // ... arbitrary processing to arrive at a $name
        return $name;
    }

    public function widget( $args, $instance ) 
    {
        extract( $args );
        extract( $instance );

        $title = apply_filters('widget_title', $instance['title']);
        $style = empty($instance['style']) ? '' : $instance['style'];
        $posts = intval($instance['posts']);
        $author_post = $instance['author_post'];
        $cate_post = $instance['cate_post'];
        $comment_post = $instance['comment_post'];
        $date_post = $instance['date_post'];
        $content_posts = $instance['content_posts'];
        $limit_word_posts = intval($instance['limit_word_posts']);

        echo wp_kses_post($before_widget);
        if ( $title ) {
            echo wp_kses_post($before_title . $title . $after_title);
        }

        $sticky = get_option('sticky_posts');
        $args = array(
            'showposts' => intval($posts),
            'post__not_in'  => $sticky,
            'orderby' => 'post_date',
            'order' => 'desc',
            'post_status' => 'publish'
        );
        $recent_posts = new WP_Query($args);

        if($recent_posts->have_posts()): ?>
            <div class="recent-post-widget <?php echo esc_attr($style); ?>">
                <?php  while( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
                    <article class="post clearfix">
                        <?php if(get_the_post_thumbnail()) : ?>
                        <div class="thumb">
                        <?php if($style=='style-1') : ?>
                            <?php the_post_thumbnail('thumbnail'); ?>
                        <?php else: ?>
                            <?php the_post_thumbnail('thumbnailsize-blog-widget'); ?>
                        <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <div class="post-body">
                            <h2 class="title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <div class="meta">
                                <?php if($author_post=='1'): ?>
                                <span class="author-link">
                                    <i class="fa fa-user"></i>
                                    <?php the_author_posts_link(); ?>
                                </span>
                                <?php endif; ?>
                                <?php if($cate_post=='1'): ?>
                                <span class="category">
                                    <i class="fa fa-edit"></i>
                                    <?php the_category( ', ' ); ?>
                                </span>
                                <?php endif; ?>
                                <?php if($comment_post=='1'): ?>
                                <span class="comment-count">
                                    <i class="fa fa-comment-o"></i>
                                    <?php comments_popup_link(esc_html__(' 0 comment', 'lanethemekit'), esc_html__(' 1 comment', 'lanethemekit'), esc_html__(' % comments', 'lanethemekit')); ?>
                                </span>
                                <?php endif; ?>
                                <?php if($date_post=='1'): ?>
                                <span class="published">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <?php the_time( 'M, d, Y' ); ?>
                                </span>
                                <?php endif; ?>
                            </div>
                            <?php if($content_posts): ?>
                            <div class="content">
                                <p class="text"><?php echo lane_limit_get_excerpt(intval($limit_word_posts),''); ?></p>
                                <p class="text-readmore"><a class="readmore" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More','lanethemekit'); ?></a></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php endif;
        wp_reset_query();
        echo wp_kses_post($after_widget);
    }
    // Widget Backend
    public function form( $instance ) 
    {
        $title = @apply_filters('widget_title', $instance['title']);
        $style = @$instance['style'];   
        $posts = @intval($instance['posts']);
        $author_post = @esc_attr($instance['author_post']);
        $cate_post = @esc_attr($instance['cate_post']);
        $comment_post = @esc_attr($instance['comment_post']);
        $date_post = @esc_attr($instance['date_post']);
        $content_posts = @esc_attr($instance['content_posts']);
        $limit_word_posts = @intval($instance['limit_word_posts']);
        ?>
         <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo esc_html('Title:'); ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('text'); ?>">Style: 
                <select class='widefat' id="<?php echo $this->get_field_id('style'); ?>"
                name="<?php echo $this->get_field_name('style'); ?>" type="text">
                    <option value='style-1'<?php echo ($style=='style-1')?'selected':''; ?>>Style 1</option>
                    <option value='style-2'<?php echo ($style=='style-2')?'selected':''; ?>>Style 2</option>
                </select>                
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('posts'); ?>"><?php echo esc_html('Number of posts:'); ?></label>
            <input class="widefat" type="text" style="width: 30px;" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo esc_attr($posts) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('author_post'); ?>"><?php echo esc_html('Show author
             post:'); ?></label>
            <input id="<?php echo $this->get_field_id('author_post'); ?>" name="<?php echo $this->get_field_name('author_post'); ?>" type="checkbox" value="1" <?php checked( '1', $author_post ); ?>/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('cate_post'); ?>"><?php echo esc_html('Show Category
             post:'); ?></label>
            <input id="<?php echo $this->get_field_id('cate_post'); ?>" name="<?php echo $this->get_field_name('cate_post'); ?>" type="checkbox" value="1" <?php checked( '1', $cate_post ); ?>/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('comment_post'); ?>"><?php echo esc_html('Show comment
             post:'); ?></label>
            <input id="<?php echo $this->get_field_id('comment_post'); ?>" name="<?php echo $this->get_field_name('comment_post'); ?>" type="checkbox" value="1" <?php checked( '1', $comment_post ); ?>/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('date_post'); ?>"><?php echo esc_html('Show date
             post:'); ?></label>
            <input id="<?php echo $this->get_field_id('date_post'); ?>" name="<?php echo $this->get_field_name('date_post'); ?>" type="checkbox" value="1" <?php checked( '1', $date_post ); ?>/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content_posts'); ?>"><?php echo esc_html('Show content
             posts:'); ?></label>
            <input id="<?php echo $this->get_field_id('content_posts'); ?>" name="<?php echo $this->get_field_name('content_posts'); ?>" type="checkbox" value="1" <?php checked( '1', $content_posts ); ?>/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('limit_word_posts'); ?>"><?php echo esc_html('Number word of posts:'); ?></label>
            <input class="widefat" type="text" style="width: 30px;" id="<?php echo $this->get_field_id('limit_word_posts'); ?>" name="<?php echo $this->get_field_name('limit_word_posts'); ?>" value="<?php echo esc_attr($limit_word_posts) ?>" />
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['style'] = $new_instance['style'];
        $instance['posts'] = intval($new_instance['posts']);
        $instance['author_post'] = $new_instance['author_post'];
        $instance['cate_post'] = $new_instance['cate_post'];
        $instance['comment_post'] = $new_instance['comment_post'];
        $instance['date_post'] = $new_instance['date_post'];
        $instance['content_posts'] = $new_instance['content_posts'];
        $instance['limit_word_posts'] = intval($new_instance['limit_word_posts']);

        return $instance;
    }
}