<?php
class Theme_Ajax_Search_Widget extends  ThemeClass_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-search';
        $this->widget_description = esc_html__( "Lane Ajax Search widget", 'fatotheme' );
        $this->widget_id          = 'ajax-search-widget';
        $this->widget_name        = esc_html__( 'Lane Ajax Search Widget', 'fatotheme' );

        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        $class_custom   = empty( $instance['class_custom'] ) ? '' : apply_filters( 'widget_class_custom', $instance['class_custom'] );
        $widget_id = $args['widget_id'];
        ?>
        <div class="widget-search">
            <input type="text" class="input-search" placeholder="<?php echo esc_attr__('Type your search here','fatotheme') ?>">
            <button type="submit" id="search-btn-submit" class="search-btn-submit"><i class="fa fa-search"></i></button>
            <a class="icon-search-menu" href="#"><span class="fa fa-search"></span></a>
            <div class="widget-search-result-wrapper">
                <a class="close" href="#"><span class="fa fa-remove"></span></a>
                <div class="ajax-search-result-widget"></div>
            </div>
        </div>
        <?php
    }
}
if (!function_exists('fatotheme_ajax_register_widget_search')) {
    function fatotheme_ajax_register_widget_search() {
        register_widget('Theme_Ajax_Search_Widget');
    }
    add_action('widgets_init', 'fatotheme_ajax_register_widget_search', 1);
}

