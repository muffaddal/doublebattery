<?php
if ( ! defined( 'ABSPATH' ) ) die( '-1' );

if ( ! defined( 'LANE_PORTFOLIO_CATEGORY_TAXONOMY' ) )
    define( 'LANE_PORTFOLIO_CATEGORY_TAXONOMY', 'portfolio-category');

if ( ! defined( 'LANE_PORTFOLIO_POST_TYPE' ) )
    define( 'LANE_PORTFOLIO_POST_TYPE', 'portfolio');

if(! defined( 'LANE_PORTFOLIO_DIR_PATH' ))
    define( 'LANE_PORTFOLIO_DIR_PATH', plugin_dir_path( __FILE__ ));

if(!class_exists('Lane_Portfolio')) 
{
    class Lane_Portfolio 
    {
        function __construct() 
        {
            add_action('wp_enqueue_scripts',array($this,'lane_front_scripts'),11);
            add_action('init', array($this, 'lane_register_taxonomies' ), 5 );
            add_action('init', array($this, 'lane_register_post_types' ), 6 );
            add_filter('rwmb_meta_boxes', array($this,'lane_register_meta_boxes' ));
            add_action('after_setup_theme', array($this,'lane_register_image_size'));
            add_shortcode('lane_portfolio', array($this, 'lane_portfolio_shortcode' ));
            add_filter('single_template',array($this,'lane_get_portfolio_single_template' ) );
            add_filter('template_include', array($this,'lane_get_portfolio_taxonomy_template'));

            if(is_admin()){
                add_filter('manage_edit-'.LANE_PORTFOLIO_POST_TYPE.'_columns' , array($this,'lane_add_portfolios_columns'));
                add_action( 'manage_'.LANE_PORTFOLIO_POST_TYPE.'_posts_custom_column' ,array($this,'lane_set_portfolios_columns_value'), 10, 2 );
                add_action('restrict_manage_posts',array($this,'lane_portfolio_manage_posts'));
                add_filter('parse_query',array($this,'lane_convert_taxonomy_term_in_query'));
            }

            $this->lane_includes();
        }

        function lane_front_scripts() 
        {
            $min_suffix = defined( 'LANE_SCRIPT_DEBUG' ) && LANE_SCRIPT_DEBUG ? '' : '.min';
            wp_enqueue_style( 'wplane-pretty-css', plugins_url() . '/lanethemekit/pagebuilder/classes/portfolio/assets/css/prettyPhoto.css', array() );
            wp_enqueue_script('wplane-pretty-js',plugins_url() . '/lanethemekit/pagebuilder/classes/portfolio/assets/js/prettyPhoto/jquery.prettyPhoto.js', false, true);

            wp_enqueue_script('wplane-isotope',plugins_url() . '/lanethemekit/pagebuilder/classes/portfolio/assets/js/isotope/isotope.pkgd.min.js', false, true);
            wp_enqueue_script('wplane-imagesLoaded',plugins_url() . '/lanethemekit/pagebuilder/classes/portfolio/assets/js/imagesLoaded/imagesloaded.pkgd.min.js', false, true);
            
            wp_enqueue_script('wplane-modernizr',plugins_url() . '/lanethemekit/pagebuilder/classes/portfolio/assets/js/hoverdir/modernizr.js', false, true);
            wp_enqueue_script('wplane-hoverdir',plugins_url() . '/lanethemekit/pagebuilder/classes/portfolio/assets/js/hoverdir/jquery.hoverdir.js', false, true);
            wp_enqueue_script('wplane-portfolio-ajax-action',plugins_url() . '/lanethemekit/pagebuilder/classes/portfolio/assets/js/ajax-action.js', false, true);
        }

        function lane_register_post_types() 
        {
            if ( post_type_exists('portfolio') ) 
            {
                return;
            }
            register_post_type('portfolio',
                array(
                    'label' => esc_html__('Portfolio','lanethemekit'),
                    'description' => esc_html__( 'Portfolio Description', 'lanethemekit' ),
                    'labels' => array(
                        'name'					=> 'Portfolio',
                        'singular_name' 		=> 'Portfolio',
                        'menu_name'    			=> esc_html__( 'Portfolio', 'lanethemekit' ),
                        'parent_item_colon'  	=> esc_html__( 'Parent Item:', 'lanethemekit' ),
                        'all_items'          	=> esc_html__( 'All Portfolio', 'lanethemekit' ),
                        'view_item'          	=> esc_html__( 'View Item', 'lanethemekit' ),
                        'add_new_item'       	=> esc_html__( 'Add New Portfolio', 'lanethemekit' ),
                        'add_new'            	=> esc_html__( 'Add New', 'lanethemekit' ),
                        'edit_item'          	=> esc_html__( 'Edit Item', 'lanethemekit' ),
                        'update_item'        	=> esc_html__( 'Update Item', 'lanethemekit' ),
                        'search_items'       	=> esc_html__( 'Search Item', 'lanethemekit' ),
                        'not_found'          	=> esc_html__( 'Not found', 'lanethemekit' ),
                        'not_found_in_trash' 	=> esc_html__( 'Not found in Trash', 'lanethemekit' ),
                    ),
                    'supports'    => array( 'title', 'editor', 'excerpt', 'thumbnail'),
                    'public'      => true,
                    'show_ui'     => true,
                    '_builtin'    => false,
                    'has_archive' => true,
                    'menu_icon'   => 'dashicons-screenoptions'
                )
            );
        }

        function lane_register_taxonomies() 
        {
            if ( taxonomy_exists( LANE_PORTFOLIO_CATEGORY_TAXONOMY ) ) 
            {
                return;
            }
            register_taxonomy( LANE_PORTFOLIO_CATEGORY_TAXONOMY,  LANE_PORTFOLIO_POST_TYPE, array( 'hierarchical' => true, 'label' => esc_html__('Portfolio Categories','lanethemekit'), 'query_var' => true, 'rewrite' => true ) );
        }

        function lane_portfolio_shortcode($atts) 
        {
            $offset = $current_page = $overlay_style =$show_pagging = $show_category = $category = $column = $item = $padding = $layout_type = $el_class = $css_animation = $duration = $delay = '';
            extract( shortcode_atts( array(
                'show_pagging'   => '0',
                'show_category' => '',
                'category'     => '',
                'column'  => '2',
                'item' => '8',
                'padding' => '',
                'layout_type'  => 'grid',
                'schema_style' => '',
                'overlay_style' => 'icon',
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => '',
                'current_page' => '1'
            ), $atts ) );

            $post_per_page = $item;
            if($category!='')
                $show_category = 0;

            $offset = ($current_page-1) * $item;
            
            $plugin_path =  untrailingslashit( plugin_dir_path( __FILE__ ) );
            $template_path = $plugin_path . '/portfolio/templates/listing.php';

            ob_start();

            include($template_path);
            $ret = ob_get_contents();
            ob_end_clean();
            return $ret;
        }

        function lane_get_portfolio_single_template($single) 
        {
            global $post;
            /* Checks for single template by post type */
            if ($post->post_type == LANE_PORTFOLIO_POST_TYPE){
                $plugin_path =  untrailingslashit( LANE_PORTFOLIO_DIR_PATH );
                $template_path = $plugin_path . '/portfolio/templates/single/single-portfolio.php';
                if(file_exists($template_path))
                    return $template_path;
            }
            return $single;
        }

        function lane_get_portfolio_taxonomy_template($template) 
        {
            if( !is_single() && is_tax(LANE_PORTFOLIO_CATEGORY_TAXONOMY)){
                $plugin_path =  untrailingslashit( LANE_PORTFOLIO_DIR_PATH );
                $template_path = $plugin_path . '/portfolio/templates/taxonomy/taxonomy-portfolio.php';
                if(file_exists($template_path)){
                    return $template_path;
                }
            }
            return $template;
        }

        function lane_register_image_size()
        {
            add_image_size( 'thumbnail-500x600', 500, 600, true );
            add_image_size( 'thumbnail-480x370', 480, 370, true );
            add_image_size( 'thumbnail-1170x730', 1170, 730, true );
        }

        function lane_add_portfolios_columns($columns) 
        {
            unset(
                $columns['cb'],
                $columns['title'],
                $columns['date']
            );
            $cols = array_merge(array('cb'=>('')),$columns);
            $cols = array_merge($cols,array('title'=>esc_html__('Porfolio Name','lanethemekit')));
            $cols = array_merge($cols,array('thumbnail'=>esc_html__('Thumbnail','lanethemekit')));
            $cols = array_merge($cols,array(LANE_PORTFOLIO_CATEGORY_TAXONOMY=>esc_html__('Categories','lanethemekit')));
            $cols = array_merge($cols,array('date'=>esc_html__('Date','lanethemekit')));
            return $cols;
        }

        function lane_set_portfolios_columns_value( $column, $post_id ) 
        {
            switch($column){
                case 'id':{
                    echo wp_kses_post($post_id);
                    break;
                }
                case 'thumbnail':
                {
                    echo get_the_post_thumbnail($post_id,'thumbnail');
                    break;
                }
                case LANE_PORTFOLIO_CATEGORY_TAXONOMY:
                {
                    $terms = wp_get_post_terms( get_the_ID(), array( LANE_PORTFOLIO_CATEGORY_TAXONOMY));
                    $cat = '<ul>';
                    foreach ( $terms as $term ){
                        $cat .= '<li><a href="'.get_term_link( $term, LANE_PORTFOLIO_CATEGORY_TAXONOMY ).'">'.$term->name.'<a/></li>';
                    }
                    $cat .= '</ul>';
                    echo wp_kses_post($cat);
                    break;
                }
            }
        }

        function lane_register_meta_boxes($meta_boxes)
        {
            $meta_boxes[] = array(
                'title'  => esc_html__( 'Portfolio Extra', 'lanethemekit' ),
                'id'     => 'lane-meta-box-portfolio-format-gallery',
                'pages'  => array( LANE_PORTFOLIO_POST_TYPE ),
                'fields' => array(
                    array(
                        'name' => esc_html__( 'Gallery', 'lanethemekit' ),
                        'id'   => 'portfolio-format-gallery',
                        'type' => 'image_advanced',
                    )
                )
            );
            return $meta_boxes;
        }

        function lane_portfolio_manage_posts() 
        {
            global $typenow;
            if ($typenow==LANE_PORTFOLIO_POST_TYPE){
                $selected = isset($_GET[LANE_PORTFOLIO_CATEGORY_TAXONOMY]) ? $_GET[LANE_PORTFOLIO_CATEGORY_TAXONOMY] : '';
                $args = array(
                    'show_count' => true,
                    'show_option_all' => esc_html__('Show All Categories','lanethemekit'),
                    'taxonomy'        => LANE_PORTFOLIO_CATEGORY_TAXONOMY,
                    'name'               => LANE_PORTFOLIO_CATEGORY_TAXONOMY,
                    'selected' => $selected,

                );
                wp_dropdown_categories($args);
            }
        }

        function lane_convert_taxonomy_term_in_query($query) 
        {
            global $pagenow;
            $qv = &$query->query_vars;
            if ($pagenow=='edit.php' &&
                isset($qv[LANE_PORTFOLIO_CATEGORY_TAXONOMY])  &&
                is_numeric($qv[LANE_PORTFOLIO_CATEGORY_TAXONOMY])) {
                $term = get_term_by('id',$qv[LANE_PORTFOLIO_CATEGORY_TAXONOMY],LANE_PORTFOLIO_CATEGORY_TAXONOMY);
                $qv[LANE_PORTFOLIO_CATEGORY_TAXONOMY] = $term->slug;
            }
        }

        private function lane_includes()
        {
            include_once('portfolio/utils/ajax-action.php');
        }
    }
    new Lane_Portfolio();
}