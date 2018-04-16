<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( array $meta_boxes ) 
{
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_fatotheme_';
	$footers_type = get_posts( array('posts_per_page'=>-1,'post_type'=>'footer') );
    $footers_option = array();
    $footers_option['global'] = 'Use Global';
    foreach ($footers_type as $key => $value) {
        $footers_option[$value->ID] = $value->post_title;
    }

    $page_configs = array();
    $page_configs[] = array(
		'name' => esc_html__( 'Layout', 'fatotheme' ),
		'desc' => esc_html__( 'Select Layout', 'fatotheme' ),
		'id'   => $prefix . 'page_layout',
		'type' => 'layout',
		'default' => '1'
	);

    $page_configs[] = array(
		'name' => esc_html__( 'Left Sidebar', 'fatotheme' ),
		'id'   => $prefix . 'page_left_sidebar',
		'type' => 'sidebar',
	);

    $page_configs[] = array(
		'name' => esc_html__( 'Right Sidebar', 'fatotheme' ),
		'id'   => $prefix . 'page_right_sidebar',
		'type' => 'sidebar',
	);

    $page_configs[] = array(
		'name' => esc_html__( 'Blog Post Per Page', 'fatotheme' ),
		'id'   => $prefix . 'blog_count',
		'type' => 'text_number',
		'std'  => 6
	);

    $page_configs[] = array(
		'name'    => esc_html__( 'Blog Skin', 'fatotheme' ),
		'id'      => $prefix . 'blog_skin',
		'type'    => 'select',
		'options' => array(
			'default'  	=> 'Blog default',
			'list' 	  	=> 'Blog list',
			'mini' 	  	=> 'Blog mini sidebar',
			'masonry'  	=> 'Blog masonry',
		),
		'std' => 'global'
	);

    $page_configs[] = array(
		'name' => esc_html__( 'Blog Masonry Column', 'fatotheme' ),
		'id'   => $prefix . 'blog_masonry_column_count',
		'type' => 'text_number',
		'std'  => 3
	);
    $page_configs[] = array(
		'name' => esc_html__( 'Override Theme Options', 'fatotheme' ),
		'id'   => $prefix . 'override_options',
		'type' => 'title',
	);
    $page_configs[] = array(
	    'name' 	=> esc_html__('Override Logo', 'fatotheme'),
	    'desc' 	=> 'Upload an image or enter an URL.',
	    'id' 	=> $prefix . 'logo_override',
	    'type' 	=> 'file',
	    'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
	);
    $page_configs[] = array(
		'name'    => esc_html__( 'Page Title Full Width', 'fatotheme' ),
		'id'      => $prefix . 'page_title_fullwidth',
		'type'    => 'select',
		'options' => array(
			'inherit'   => esc_html__( 'Inherit From Theme Options', 'fatotheme' ),
			'fullwidth'   => esc_html__( 'Full Width', 'fatotheme' ),
			'no-fullwidth'   => esc_html__( 'No Full Width', 'fatotheme' )
		),
		'std' => 'inherit'
	);
	$page_configs[] = array(
	    'name'             => 'Show Page Title',
	    'id'   			   => $prefix . 'show_page_title',
	    'type'             => 'radio_inline',
	    'show_option_none' => true,
	    'options'          => array(
	        'yes' => esc_html__( 'Yes', 'fatotheme' ),
	        'no'   => esc_html__( 'No', 'fatotheme' )
	    ),
	    'std' => 'yes'
	);
	$page_configs[] = array(
	    'name' 	=> esc_html__('Page Title Background', 'fatotheme'),
	    'desc' 	=> 'Upload an image or enter an URL.',
	    'id' 	=> $prefix . 'page_title_bg',
	    'type' 	=> 'file',
	    'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
	);
	$page_configs[] = array(
	    'name'             => 'Show Breadcrumbs',
	    'id'   			   => $prefix . 'show_breadcrumbs',
	    'type'             => 'radio_inline',
	    'show_option_none' => true,
	    'options'          => array(
	        'yes' => esc_html__( 'Yes', 'fatotheme' ),
	        'no'   => esc_html__( 'No', 'fatotheme' )
	    ),
	    'std' => 'yes'
	);
    $page_configs[] = array(
		'name'    => esc_html__( 'Header Style', 'fatotheme' ),
		'id'      => $prefix . 'header_style',
		'type'    => 'select',
		'options' => array(
			'global'   => esc_html__( 'Use Global', 'fatotheme' ),
			'1'   => esc_html__( 'Style 1', 'fatotheme' ),
			'2'   => esc_html__( 'Style 2', 'fatotheme' ),
			'3'   => esc_html__( 'Style 3', 'fatotheme' ),
			'4'   => esc_html__( 'Style 4', 'fatotheme' )
		),
		'std' => 'global'
	);
	$page_configs[] = array(
	    'name'             => 'Header Absolute',
	    'id'   			   => $prefix . 'header_absolute',
	    'type'             => 'radio_inline',
	    'show_option_none' => true,
	    'options'          => array(
	        'yes' => esc_html__( 'Yes', 'fatotheme' ),
	        'no'   => esc_html__( 'No', 'fatotheme' )
	    ),
	    'std' => 'no'
	);
	$page_configs[] = array(
		'name'    => esc_html__( 'Sidebar on Top of Mainbody', 'fatotheme' ),
		'id'      => $prefix . 'mainbody_topsidebar',
		'type'    => 'sidebar',
		'desc' => esc_html__('For default page only', 'fatotheme')
	);

	$page_configs[] = array(
		'name'    => esc_html__( 'Sidebar on Bottom of Mainbody', 'fatotheme' ),
		'id'      => $prefix . 'mainbody_bottomsidebar',
		'type'    => 'sidebar',
		'desc' => esc_html__('For default page only', 'fatotheme')
	);

    $page_configs[] = array(
		'name'    => esc_html__( 'Footer Style', 'fatotheme' ),
		'id'      => $prefix . 'footer_style',
		'type'    => 'select',
		'options' => $footers_option,
		'std' => 'global'
	);

	$page_configs[] = array(
		'name'    => esc_html__( 'Main Color of Page', 'fatotheme' ),
		'id'      => $prefix . 'main_color_of_page',
		'type'    => 'colorpicker',
		'std' => '',
		'desc' => esc_html__('For demo only', 'fatotheme')
	);

	$meta_boxes['page_config'] = array(
		'id'         => 'page_config',
		'title'      => esc_html__( 'Page Configuration', 'fatotheme' ),
		'pages'      => array( 'page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => $page_configs
	);

	$meta_boxes['post_config'] = array(
		'id'         => 'post_config',
		'title'      => esc_html__( 'Post Config', 'fatotheme' ),
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'name' => esc_html__( 'Link Video or Audio', 'fatotheme' ),
				'desc' => wp_kses_post( 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.'),
				'id'   => $prefix . 'post_video',
				'type' => 'oembed',
			),
			array(
			    'name' => esc_html__('Gallery Images', 'fatotheme'),
			    'desc' => '',
			    'id' => $prefix . 'post_gallery',
			    'type' => 'file_list',
			    // 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
			),
			array(
			    'name' => esc_html__('Status', 'fatotheme'),
			    'desc' => '',
			    'id' => $prefix . 'post_status',
			    'type' => 'textarea',
			),
		)
	);

	// Add other metaboxes as needed
	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) ){
		get_template_part( 'lib/metabox/init' );
		get_template_part( 'lib/metabox/meta-custom' );
	}
}
