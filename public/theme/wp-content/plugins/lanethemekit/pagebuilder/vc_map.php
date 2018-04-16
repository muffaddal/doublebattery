<?php
global $wpdb;
/*==========================================================================
Product Collection Element
==========================================================================*/
vc_map( array(
    "name" => esc_html__("Lane Collection", 'lanethemekit'),
    "base" => "lane_productcollection",
    "class" => "",
    "category" => esc_html__('LaneShortcodes','lanethemekit'),
    "params" => array(
	    array(
			"type" => "textfield",
			"heading" => esc_html__("Title", 'lanethemekit'),
			"param_name" => "title",
			'admin_label' => true,
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", 'lanethemekit'),
			"param_name" => "style",
			"value" => array(
				'Style 1' => 'style-1',
				'Style 2' => 'style-2'
			),
			"admin_label" => true
		),
		array(
            "type" => "textarea_html",
            "holder" => "div",
            "class" => "",
            "heading" => __("Text", "js_composer"),
            "param_name" => "content",
            "value" => __("I'm hello world", "js_composer"),
            "description" => __("Enter your content.", "js_composer"),
            "admin_label" => false
        ),
		array(
	        'type' => 'attach_image',
	        'heading' => esc_html__( 'Image', 'js_composer' ),
	        'param_name' => 'image',
	        'value' => '',
	        'description' => esc_html__( 'Select image from media library.', 'js_composer' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Image size', 'lanethemekit'),
			'param_name' => 'img_size',
			'std' => 'full',
			'description' => esc_html__('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'lanethemekit')
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Text Link", 'lanethemekit'),
			"param_name" => "text_link",
			"value" => 'Shop Now'				
		),
		array(
			"type" => "vc_link",
			"heading" => esc_html__("URL (Link)", 'js_composer'),
			"param_name" => "link"
		),
		array(
			"type" => "colorpicker",
			"heading" => esc_html__("Background Text Link", 'lanethemekit'),
			"param_name" => "bg_text_link",
			"value" => ''
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Extra class name", 'lanethemekit'),
			"param_name" => "el_class",
			"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'lanethemekit')
		)
   	)
));

/*==========================================================================
Element Products
==========================================================================*/
vc_map( array(
    "name" => esc_html__("Lane Products", 'lanethemekit'),
    "base" => "lane_products",
    "class" => "",
    "category" => esc_html__('LaneShortcodes','lanethemekit'),
    "params" => array(
    	array(
			"type" => "textfield",
			"heading" => esc_html__("Title", 'lanethemekit'),
			"param_name" => "title"
		),
    	array(
			"type" => "dropdown",
			"heading" => esc_html__("Type", 'lanethemekit'),
			"param_name" => "type",
			"value" => array('Best Selling'=>'best_selling','Featured Products'=>'featured_product','Top Rate'=>'top_rate','Recent Products'=>'recent_product','On Sale'=>'on_sale','Recent Review' => 'recent_review','Product Deals'=> 'deals' ),
			"admin_label" => true,
			"description" => esc_html__("Select columns count.", 'lanethemekit')
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Layout", 'lanethemekit'),
			"param_name" => "layout",
			"value" => array('Grid'=>'grid','List'=>'list','Carousel'=>'carousel')
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", 'lanethemekit'),
			"param_name" => "style",
			"value" => array(
				'Style 1' => 'style-1',
				'Style 2' => 'style-2'
			),
			"admin_label" => true
		),
		array(
			"type" => "checkbox",
			"heading" => esc_html__("Hidden time sale",'lanethemekit'),
			"param_name" => "hide_time_sale",
			"value" => array(
						'Yes, please' => true
					),
			"description" => esc_html__("Show/Hide time sale.", 'lanethemekit')
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Total products", 'lanethemekit'),
			"param_name" => "number",
			"value" => 8,
			"description"=>esc_html__("Set max limit for products in grid or enter -1 to display all (limited to 100).", 'lanethemekit')
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Columns count", 'lanethemekit'),
			"param_name" => "columns_count",
			"value" => array(6, 5, 4, 3, 2, 1),
			"std"	=> 4,
			"admin_label" => true,
			"description" => esc_html__("Select columns count.", 'lanethemekit')
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Products per page", 'lanethemekit'),
			"param_name" => "number_per_page",
			"value" => 4,
			"description"=>esc_html__("Number of products to show per page.", 'lanethemekit')
		),
		array(
			"type" => "checkbox",
			"heading" => esc_html__("Show Filters",'lanethemekit'),
			"param_name" => "show_filters",
			"value" => array(
						'Yes, please' => true
					),
			"description" => esc_html__("Append filter to grid.", 'lanethemekit')
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Filter Align", 'lanethemekit'),
			"param_name" => "filter_align",
			"value" => array(
				'Align Center' => 'align-center',
				'Align Left'   => 'align-left',
				'Align Right'  => 'align-right'
			)
		),
		array(
			"type" => "checkbox",
			"heading" => esc_html__("Show Loadmore",'lanethemekit'),
			"param_name" => "show_loadmore",
			"value" => array(
						'Yes, please' => true
					),
			"description" => esc_html__("Append filter to grid.", 'lanethemekit')
		),
		array(
			"type" => "checkbox",
			"heading" => esc_html__("Autoplay",'lanethemekit'),
			"param_name" => "autoplay",
			"value" => array(
						'Yes, please' => true
					),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'carousel' ),
			),
			"description" => esc_html__("Autoplay for Carousel layout only.", 'lanethemekit')
		),
		array(
			"type" => "checkbox",
			"heading" => esc_html__("Show Pagination",'lanethemekit'),
			"param_name" => "show_pagination",
			"value" => array(
						'Yes, please' => true
					),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'carousel' ),
			),
			"description" => esc_html__("Show Pagination for Carousel layout only.", 'lanethemekit')
		),
		array(
			"type" => "checkbox",
			"heading" => esc_html__("Show Navigation",'lanethemekit'),
			"param_name" => "show_navigation",
			"value" => array(
						'Yes, please' => true
					),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'carousel' ),
			),
			"description" => esc_html__("Show Navigation for Carousel layout only.", 'lanethemekit')
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Extra class name", 'lanethemekit'),
			"param_name" => "el_class",
			"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'lanethemekit')
		)
   	)
));

/*==========================================================================
Element Category List
==========================================================================*/
vc_map( array(
    "name" => esc_html__("Lane Categories",'lanethemekit'),
    "base" => "lane_categorylist",
    "class" => "",
    "category" => esc_html__('LaneShortcodes','lanethemekit'),
    "params" => array(
    	array(
			"type" => "textfield",
			"heading" => esc_html__("Title", 'lanethemekit'),
			"param_name" => "title"
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Layout", 'lanethemekit'),
			"param_name" => "layout",
			"value" => array(
				'Carousel' => 'carousel',
				'Grid'     => 'grid',
			),
			"admin_label" => true,
			"description" => esc_html__("Select layout to display.", 'lanethemekit')
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", 'lanethemekit'),
			"param_name" => "style",
			"value" => array(
				'Style 1' => 'style-1',
				'Style 2' => 'style-2'
			),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'grid' ),
			),
			"admin_label" => true
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Thumbnail size', 'js_composer' ),
			'param_name' => 'thumb_size',
			'description' => esc_html__( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'js_composer' )
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Columns count", 'lanethemekit'),
			"param_name" => "columns_count",
			"value" => array(6, 5, 4, 3, 2),
			"admin_label" => true,
			"description" => esc_html__("Select columns count.", 'lanethemekit')
		),
		array(
			"type" => "checkbox",
			"heading" => esc_html__("Show Count",'lanethemekit'),
			"param_name" => "show_count",
			"value" => array(
						'Yes, please' => true
					),
			"description" => esc_html__("Show/Hide Counter products.", 'lanethemekit')
		),
		array(
			"type" => "checkbox",
			"heading" => esc_html__("Autoplay",'lanethemekit'),
			"param_name" => "autoplay",
			"value" => array(
						'Yes, please' => true
					),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'carousel' ),
			),
			"description" => esc_html__("Autoplay for Carousel layout only.", 'lanethemekit')
		),
		array(
			"type" => "checkbox",
			"heading" => esc_html__("Show Pagination",'lanethemekit'),
			"param_name" => "show_pagination",
			"value" => array(
						'Yes, please' => true
					),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'carousel' ),
			),
			"description" => esc_html__("Show Pagination for Carousel layout only.", 'lanethemekit')
		),
		array(
			"type" => "checkbox",
			"heading" => esc_html__("Show Navigation",'lanethemekit'),
			"param_name" => "show_navigation",
			"value" => array(
						'Yes, please' => true
					),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'carousel' ),
			),
			"description" => esc_html__("Show Navigation for Carousel layout only.", 'lanethemekit')
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Extra class name", 'lanethemekit'),
			"param_name" => "el_class",
			"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'lanethemekit')
		)
   	)
));

/*==========================================================================
Blog Element
==========================================================================*/
vc_map( array(
	'name' => esc_html__( 'Lane Posts', 'js_composer' ),
	'base' => 'lane_blog',
	"category" => esc_html__('LaneShortcodes','lanethemekit'),
	'description' => esc_html__( 'Posts in grid view', 'js_composer' ),
	'params' => array(
		array(
			"type" => "textfield",
			"heading" => esc_html__("Title", 'lanethemekit'),
			"param_name" => "title"
		),
		array(
			'type' => 'loop',
			'heading' => esc_html__( 'Grids content', 'js_composer' ),
			'param_name' => 'loop',
			'value' => 'size:10|order_by:date',
			'settings' => array(
				'size' => array(
					'hidden' => false,
					'value' => 10,
				),
				'order_by' => array( 'value' => 'date' ),
			),
			'description' => esc_html__( 'Create WordPress loop, to populate content from your site.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Layout', 'js_composer' ),
			'param_name' => 'layout',
			'admin_label' => true,
			'value' => array(
				'Grid' => 'grid',
				'List' => 'list',
				'Carousel' => 'carousel'
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns count', 'js_composer' ),
			'param_name' => 'columns_count',
			'value' => array( 6, 5, 4, 3, 2, 1 ),
			'std' => 3,
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'grid','carousel' ),
			),
			'description' => esc_html__( 'Select columns count.', 'js_composer' )
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Visible items on list layout", 'lanethemekit'),
			"param_name" => "visible_items",
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'list' ),
			),
			"description" => esc_html__("For list layout only", 'lanethemekit')
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", 'lanethemekit'),
			"param_name" => "style",
			"value" => array(
				'Style 1' => 'style-1',
				'Style 2' => 'style-2'
			),
			"admin_label" => true
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Thumbnail size', 'js_composer' ),
			'param_name' => 'thumb_size',
			'description' => esc_html__( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'js_composer' )
		),
		array(
			"type" => "checkbox",
			"heading" => esc_html__("Hide Meta",'lanethemekit'),
			"param_name" => "post_meta",
			"value" => array(
						'Yes, please' => true
					),
			"description" => esc_html__("Meta of post.", 'lanethemekit')
		),
		array(
			"type" => "checkbox",
			"heading" => esc_html__("Hide Readmore",'lanethemekit'),
			"param_name" => "post_readmore",
			"value" => array(
						'Yes, please' => true
					),
			"description" => esc_html__("Readmore button.", 'lanethemekit')
		),
		array(
			"type" => "checkbox",
			"heading" => esc_html__("Autoplay",'lanethemekit'),
			"param_name" => "autoplay",
			"value" => array(
						'Yes, please' => true
					),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'list','carousel' ),
			),
			"description" => esc_html__("Autoplay for Carousel layout only.", 'lanethemekit')
		),
		array(
			"type" => "checkbox",
			"heading" => esc_html__("Show Pagination",'lanethemekit'),
			"param_name" => "show_pagination",
			"value" => array(
						'Yes, please' => true
					),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'list','carousel' ),
			),
			"description" => esc_html__("Show Pagination for Carousel layout only.", 'lanethemekit')
		),
		array(
			"type" => "checkbox",
			"heading" => esc_html__("Show Navigation",'lanethemekit'),
			"param_name" => "show_navigation",
			"value" => array(
						'Yes, please' => true
					),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'list','carousel' ),
			),
			"description" => esc_html__("Show Navigation for Carousel layout only.", 'lanethemekit')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );
/*==========================================================================
IconBox Element
==========================================================================*/
vc_map(
	array(
		'name' => esc_html__('Lane Icon Box', 'lanethemekit'),
		'base' => 'lane_iconbox',
		'category' => esc_html__('LaneShortcodes', 'lanethemekit'),
		'description' => esc_html__('Adds icon box with font icons','lanethemekit'),
		'params' => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Style", 'lanethemekit'),
				"param_name" => "style",
				"value" => array(
					'Style 1' => 'style-1',
					'Style 2' => 'style-2'
				),
				"admin_label" => true
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Text align", 'lanethemekit'),
				"param_name" => "text_align",
				"value" => array(
					'Align Center' => 'text-center',
					'Align Left' => 'text-left',
					'Align Right' => 'text-right'
				)
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Icon Type", 'lanethemekit'),
				"param_name" => "icon_type",
				"value" => array(
					'Icon Awesome' => 'awesome',
					'Open Iconic' => 'openiconic',
					'Typicons' => 'typicons',
					'Entypo' => 'entypo',
					'Linecons' => 'linecons',
					'Mono Social' => 'monosocial',
					'Material' => 'material',
					'Icon 7 Stroke' => 'font_7stroke',
					'Icon Image' => 'icon_type_image'
				),
				"admin_label" => true
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__('Select Icon:', 'lanethemekit'),
				'param_name' => 'font_awesome',
				'std'	=> 'fa fa-adjust',
				'dependency' => array(
					'element' => 'icon_type',
					'value' => array( 'awesome' ),
				),
				'description' => esc_html__('Select the icon from the list.', 'lanethemekit')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'icon_openiconic',
				'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'openiconic',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => array('openiconic'),
				),
				'description' => __( 'Select icon from library.', 'js_composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'icon_typicons',
				'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'typicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => array('typicons'),
				),
				'description' => __( 'Select icon from library.', 'js_composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'icon_entypo',
				'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'entypo',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => array('entypo'),
				),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'icon_linecons',
				'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'linecons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => array('linecons'),
				),
				'description' => __( 'Select icon from library.', 'js_composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'icon_monosocial',
				'value' => 'vc-mono vc-mono-fivehundredpx', // default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'monosocial',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => array('monosocial'),
				),
				'description' => __( 'Select icon from library.', 'js_composer' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'icon_material',
				'value' => 'vc-material vc-material-cake', // default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'material',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => array('material'),
				),
				'description' => __( 'Select icon from library.', 'js_composer' ),
			),
			array(
                "type" => "textfield",
                "heading" => esc_html__("Extra Icon", 'lanethemekit'),
                "param_name" => "extra_icon",
                "description" => esc_html__("Enter icon class name. You can find it at http://themes-pixeden.com/font-demos/7-stroke/", 'lanethemekit'),
                'dependency' => array(
					'element' => 'icon_type',
					'value' => array( 'font_7stroke' ),
				),
            ),
            array(
		        'type' => 'attach_images',
		        'heading' => esc_html__( 'Icon Image', 'js_composer' ),
		        'param_name' => 'icon_images',
		        'value' => '',
		        'description' => esc_html__( 'Image first for icon, image second for hover icon.', 'js_composer' ),
		        'dependency' => array(
					'element' => 'icon_type',
					'value' => array( 'icon_type_image' ),
				),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Size', 'lanethemekit'),
				'param_name' => 'icon_size',
				'value' => '',
				'description' => esc_html__('Enter number only, it will display follow pixels unit, example: 14, 15, 16...','lanethemekit')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Link (url)', 'lanethemekit'),
				'param_name' => 'link',
				'value' => '#'
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Title', 'lanethemekit'),
				'param_name' => 'title',
				'value' => '',
				'description' => esc_html__('Provide the title for this icon box.', 'lanethemekit')
			),
			array(
				'type' => 'textarea',
				'heading' => esc_html__('Description', 'lanethemekit'),
				'param_name' => 'description',
				'value' => '',
				'description' => esc_html__('Provide the description for this icon box.', 'lanethemekit')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
			)
		)
	)
);
/*==========================================================================
Mailchimp Element
==========================================================================*/
vc_map( array(
    'name'     => esc_html__( 'Lane Mailchimp', 'lanethemekit' ),
    'base'     => 'lane_mailchimp',
    'category' => esc_html__( 'LaneShortcodes', 'lanethemekit' ),
    'params'   => array(
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Title', 'lanethemekit' ),
            'param_name'  => 'title',
            'value'       => '',
        ),
        array(
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Description', 'lanethemekit' ),
            'param_name'  => 'description',
            'value'       => ''
        ),
        array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
    )
) );

/*==========================================================================
Search Element
==========================================================================*/
vc_map(
	array(
		'name' => esc_html__('Lane Search', 'lanethemekit'),
		'base' => 'lane_search',
		'category' => esc_html__('LaneShortcodes', 'lanethemekit'),
		'description' => 'Search box with category filter.',
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Title', 'lanethemekit'),
				'param_name' => 'title',
				'value' => ''
			)
		)
	)
);
/*==========================================================================
Counter Element
==========================================================================*/
vc_map( array(
    'name'     => esc_html__( 'Lane Counter', 'lanethemekit' ),
    'base'     => 'lane_counter',
    'category' => esc_html__( 'LaneShortcodes', 'lanethemekit' ),
    'params'   => array(
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__( 'Value', 'lanethemekit' ),
            'param_name' => 'value',
            'value'      => '',
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Units', 'lanethemekit' ),
            'param_name' => 'units',
            'description' => esc_html__( 'Enter measurement units (if needed) Eg. %, px, +, etc.', 'lanethemekit' )
        ),
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__( 'Title', 'lanethemekit' ),
            'param_name' => 'title',
            'value'      => '',
        ),
        array(
            'type'        => 'iconpicker',
            'heading'     => esc_html__( 'Select Icon:', 'lanethemekit' ),
            'param_name'  => 'icon',
            'std'	=> 'fa fa-adjust',
            'admin_label' => true
        )
    )
) );
/*==========================================================================
Partner Carousel Element
==========================================================================*/
$target_arr = array(
	esc_html__('Same window', 'lanethemekit') => '_self',
	esc_html__('New window', 'lanethemekit') => '_blank'
);
vc_map(array(
	'name' => esc_html__('Lane Brands', 'lanethemekit'),
	'base' => 'lane_partnercarousel',
	'icon' => 'icon-wpb-title',
	'category' => esc_html__('LaneShortcodes', 'lanethemekit'),
	'description' => esc_html__('Animated carousel with images', 'lanethemekit'),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Title', 'lanethemekit'),
			'param_name' => 'title',
			'value' => '',
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Layout", 'lanethemekit'),
			"param_name" => "layout",
			"value" => array(
				'Carousel' => 'carousel',
				'Grid'     => 'grid',
			),
			"admin_label" => true,
			"description" => esc_html__("Select columns count.", 'lanethemekit')
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", 'lanethemekit'),
			"param_name" => "style",
			"value" => array(
				'Style 1' => 'style-1',
				'Style 2' => 'style-2'
			),
			"admin_label" => true
		),
		array(
			'type' => 'attach_images',
			'heading' => esc_html__('Images', 'lanethemekit'),
			'param_name' => 'images',
			'value' => '',
			'description' => esc_html__('Select images from media library.', 'lanethemekit')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Image size', 'lanethemekit'),
			'param_name' => 'img_size',
			'description' => esc_html__('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'lanethemekit')
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__('Custom links', 'lanethemekit'),
			'param_name' => 'custom_links',
			'description' => esc_html__('Enter links for each slide here. Divide links with linebreaks (Enter) . ', 'lanethemekit')
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Custom link target', 'lanethemekit'),
			'param_name' => 'custom_links_target',
			'description' => esc_html__('Select where to open custom links.', 'lanethemekit'),
			'value' => $target_arr
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Slides per view', 'lanethemekit'),
			'param_name' => 'column',
			'admin_label' => true,
			'value' => '5',
			'description' => esc_html__('Set numbers of slides you want to display', 'lanethemekit')
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Slider autoplay', 'lanethemekit'),
			'param_name' => 'autoplay',
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'carousel' ),
			),
			'description' => esc_html__('Enables Autoplay for Carousel layout only.', 'lanethemekit'),
			'value' => array(esc_html__('Yes, please', 'lanethemekit') => 'yes')
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Show Pagination', 'lanethemekit'),
			'param_name' => 'pagination',
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'carousel' ),
			),
			'value' => array(esc_html__('Yes, please', 'lanethemekit') => 'yes'),
			'description' => esc_html__('Show Pagination for Carousel layout only.', 'lanethemekit'),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Show Navigation', 'lanethemekit'),
			'param_name' => 'navigation',
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'carousel' ),
			),
			'value' => array(esc_html__('Yes, please', 'lanethemekit') => 'yes'),
			'description' => esc_html__('Show Navigation for Carousel layout only.', 'lanethemekit'),
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Extra class name", 'lanethemekit'),
			"param_name" => "el_class",
			"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'lanethemekit')
		)
	)
));
/*==========================================================================
Element Testimonials
==========================================================================*/
vc_map(array(
	'name' => esc_html__('Lane Testimonial', 'lanethemekit'),
	'base' => 'lane_testimonial',
	'category' => esc_html__('LaneShortcodes', 'lanethemekit'),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Title', 'lanethemekit'),
			'param_name' => 'title',
			'value' => '',
		),
		array(
			'type' => 'attach_image',
			'heading' => esc_html__('Background Images', 'lanethemekit'),
			'param_name' => 'bg_images',
			'value' => '',
			'description' => esc_html__('Select images from media library.', 'lanethemekit')
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Layout", 'lanethemekit'),
			"param_name" => "layout",
			"value" => array(
				'Carousel' => 'carousel',
				'Grid'     => 'grid'
			),
			"admin_label" => true,
			"description" => esc_html__("Select columns count.", 'lanethemekit')
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", 'lanethemekit'),
			"param_name" => "style",
			"value" => array(
				'Style 1' => 'style-1',
				'Style 2' => 'style-2'
			),
			"admin_label" => true
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Columns count", 'lanethemekit'),
			"param_name" => "columns_count",
			"value" => array(1, 2, 3, 4, 5, 6),
			"std"	=> 3,
			"description" => esc_html__("Select columns count.", 'lanethemekit')
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Slider autoplay', 'lanethemekit'),
			'param_name' => 'autoplay',
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'carousel' ),
			),
			'description' => esc_html__('Enables Autoplay for Carousel layout only.', 'lanethemekit'),
			'value' => array(esc_html__('Yes, please', 'lanethemekit') => 'yes')
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Show Pagination', 'lanethemekit'),
			'param_name' => 'pagination',
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'carousel' ),
			),
			'value' => array(esc_html__('Yes, please', 'lanethemekit') => 'yes'),
			'description' => esc_html__('Show Pagination for Carousel layout only.', 'lanethemekit'),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Show Navigation', 'lanethemekit'),
			'param_name' => 'navigation',
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'carousel' ),
			),
			'value' => array(esc_html__('Yes, please', 'lanethemekit') => 'yes'),
			'description' => esc_html__('Show Navigation for Carousel layout only.', 'lanethemekit'),
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Extra class name", 'lanethemekit'),
			"param_name" => "el_class",
			"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'lanethemekit')
		)
	)
));
/*==========================================================================
OurTeam Element
==========================================================================*/
vc_map(array(
    'name' => esc_html__('Lane OurTeam', 'lanethemekit'),
    'base' => 'lane_ourteam',
    'category' => esc_html__('LaneShortcodes', 'lanethemekit'),
    'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Title', 'lanethemekit'),
			'param_name' => 'title',
			'value' => ''
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", 'lanethemekit'),
			"param_name" => "style",
			"value" => array(
				'Style 1' => 'style-1',
				'Style 2' => 'style-2'
			),
			"admin_label" => true
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Text align", 'lanethemekit'),
			"param_name" => "text_align",
			"value" => array(
				'Align Center' => 'text-center',
				'Align Left' => 'text-left',
				'Align Right' => 'text-right'
			)
		),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Item Amount', 'lanethemekit'),
            'param_name' => 'item_amount',
            'std' => '4',
            'value' => '4'
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Column', 'lanethemekit'),
            'param_name' => 'column',
            'std' => '4',
            'value' => '4'
        ),
        array(
            'type'        => 'checkbox',
            'heading'     => esc_html__( 'Slider Style', 'lanethemekit' ),
            'param_name'  => 'is_slider',
            'admin_label' => false,
            'value' => array( esc_html__( 'Yes, please', 'lanethemekit' ) => 'yes' )
        )
    )
));
/*==========================================================================
Element Portfolio
==========================================================================*/
$sql = "SELECT a.name,a.slug,a.term_id FROM $wpdb->terms a JOIN  $wpdb->term_taxonomy b ON (a.term_id= b.term_id ) where b.taxonomy = 'portfolio-category'";
$portfolio_categories = $wpdb->get_results($sql);
$portfolio_cat = null;
$portfolio_cat['All'] = '';
foreach ($portfolio_categories as $cat) {
	$portfolio_cat[$cat->name] = $cat->slug;
}
vc_map( array(
    'name'     => esc_html__( 'Lane Portfolio', 'lanethemekit' ),
    'base'     => 'lane_portfolio',
    'category' => esc_html__( 'LaneShortcodes', 'lanethemekit' ),
    'params'   => array(
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Portfolio Category Filter', 'lanethemekit' ),
            'param_name'  => 'category',
            'admin_label' => true,
            'value'       => $portfolio_cat
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Show Category', 'lanethemekit' ),
            'param_name'  => 'show_category',
            'admin_label' => true,
            'value'       => array( 'None' => '', 
            						esc_html__('Show in left','lanethemekit') => 'left', 
            						esc_html__('Show in center','lanethemekit') => 'center', 
            						esc_html__('Show in right','lanethemekit') => 'right'
            )
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Number of column', 'lanethemekit' ),
            'param_name'  => 'column',
            'value'       => array( '2' => '2', '3' => '3', '4' => '4', '5' => '5')
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Number of item (or number of item per page if choose show paging)', 'lanethemekit' ),
            'param_name'  => 'item',
            'value'       => ''
        ),
        array(
            'type'        => 'checkbox',
            'heading'     => esc_html__( 'Show Paging (or show loading more)', 'lanethemekit' ),
            'param_name'  => 'show_pagging',
            'admin_label' => true,
            'value'       => array( esc_html__( 'Show', 'lanethemekit' ) => '1')
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Padding', 'lanethemekit' ),
            'param_name'  => 'padding',
            'value'       =>  array( esc_html__( 'No padding', 'lanethemekit' ) => '', '10 px' => 'col-padding-10', '15 px' => 'col-padding-15', '20 px' => 'col-padding-20', '40 px' => 'col-padding-40')
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Layout Type', 'lanethemekit' ),
            'param_name'  => 'layout_type',
            'admin_label' => true,
            'value'       => array(esc_html__( 'Grid', 'lanethemekit' ) => 'grid',esc_html__( 'Info', 'lanethemekit' ) => 'info')
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Overlay Style', 'lanethemekit' ),
            'param_name'  => 'overlay_style',
            'admin_label' => true,
            'value'       => array( esc_html__( 'Icon', 'lanethemekit' ) => 'icon', esc_html__( 'Title & Category', 'lanethemekit' ) => 'title',
                esc_html__( 'Icon & Title', 'lanethemekit' ) => 'icon-view', esc_html__('Zoom Out','lanethemekit') => 'zoom-out'
            )
        )
    )
));

/*==========================================================================
Override Class column
==========================================================================*/
//add_filter( 'vc_shortcodes_css_class', 'lane_vc_custom_column_builder', 10,2);
function lane_vc_custom_column_builder($class_string,$tag)
{
	if ($tag=='vc_column' || $tag=='vc_column_inner') {
		$class_string = preg_replace('/vc_col-sm-(\w)/', 'vc_col-md-$1', $class_string);
	}
	return $class_string;
}

/*==========================================================================
Extend Element Base
==========================================================================*/
add_action( 'init', 'lane_vc_edit_element_base',100 );
function lane_vc_edit_element_base()
{
	//Categories List
	vc_add_param("lane_categorylist", array(
	    'type' => 'autocomplete',
	    'heading' => esc_html__( 'Select Category. Show all category if empty select.', 'js_composer' ),
	    'param_name' => 'cat_ids',
	    'settings'  => array(
	        'multiple' => true,
	        'sortable' => true,
	        'min_length' => 1,
	        //'no_hide' => true, // In UI after select doesn't hide an select list
	        'groups' => true, // In UI show results grouped by groups
	        'unique_values' => true, // In UI show results except selected. NB! You should manually check values in backend
	        'display_inline' => true,
	        'values' => lane_product_categories() 
	    ),
	    'save_always' => true,
	    'description' => esc_html__( 'Click here and start typing...', 'js_composer' ),
	    'weight' => 2
	));

	//Products by category
	vc_add_param("lane_products", array(
	    'type' => 'autocomplete',
	    'heading' => esc_html__( 'Select Category', 'js_composer' ),
	    'param_name' => 'cat_ids',
	    'settings'  => array(
	        'multiple' => true,
	        'sortable' => true,
	        //'min_length' => 1,
	        //'no_hide' => true, // In UI after select doesn't hide an select list
	        //'groups' => true, // In UI show results grouped by groups
	        //'unique_values' => true, // In UI show results except selected. NB! You should manually check values in backend
	        'display_inline' => true,
	        'values' => lane_product_categories()
	    ),
	    'save_always' => true,
	    'description' => esc_html__( 'Click here and start typing...', 'js_composer' ),
	    'weight' => 2
	));

	// Element Title
	vc_add_param( 'vc_text_separator', array(
        "type" => "textarea",
        "heading" => esc_html__("Description",'lanethemekit'),
        "param_name" => "descript",
        "value" => ''
	));

	// Column Animation
	vc_add_param( 'vc_column', array(
		"type" => "dropdown",
		"heading" => __('Effect','lanethemekit'),
		"param_name" => "col_wowanimation",
		"std" => "wow fadeIn",
		"value"   => array(
			'none' => 'none',
            'bounce' => 'wow bounce',
            'flash' => 'wow flash',
            'pulse' => 'wow pulse',
            'rubberBand' => 'wow rubberBand',
            'shake' => 'wow shake',
            'swing' => 'wow swing',
            'tada' => 'wow tada',
            'wobble' => 'wow wobble',
            'bounceIn' => 'wow bounceIn',
            'fadeIn' => 'wow fadeIn',
            'fadeInDown' => 'wow fadeInDown',
            'fadeInDownBig' => 'wow fadeInDownBig',
            'fadeInLeft' => 'wow fadeInLeft',
            'fadeInLeftBig' => 'wow fadeInLeftBig',
            'fadeInRight' => 'wow fadeInRight',
            'fadeInRightBig' => 'wow fadeInRightBig',
            'fadeInUp' => 'wow fadeInUp',
            'fadeInUpBig' => 'wow fadeInUpBig',
            'flip' => 'wow flip',
            'flipInX' => 'wow flipInX',
            'flipInY' => 'wow flipInY',
            'lightSpeedIn' => 'wow lightSpeedIn',
            'rotateInrotateIn' => 'wow rotateIn',
            'rotateInDownLeft' => 'wow rotateInDownLeft',
            'rotateInDownRight' => 'wow rotateInDownRight',
            'rotateInUpLeft' => 'wow rotateInUpLeft',
            'rotateInUpRight' => 'wow rotateInUpRight',
            'slideInDown' => 'wow slideInDown',
            'slideInLeft' => 'wow slideInLeft',
            'slideInRight' => 'wow slideInRight',
            'rollIn' => 'wow rollIn'
        )
	));
	vc_add_param( 'vc_column', array(
		"type" => "textfield",
		"heading" => __('Duration','lanethemekit'),
		"param_name" => "col_wowduration",
		"std" => "1000",
		'weight' => 0
	));
	vc_add_param( 'vc_column', array(
		"type" => "textfield",
		"heading" => __('Delay','lanethemekit'),
		"param_name" => "col_wowdelay",
		"std" => "300",
		'weight' => 0
	));

	// Column Inner Animation
	vc_add_param( 'vc_column_inner', array(
		"type" => "dropdown",
		"heading" => __('Effect','lanethemekit'),
		"param_name" => "col_wowanimation",
		"std" => "wow fadeIn",
		"value"   => array(
			'none' => 'none',
            'bounce' => 'wow bounce',
            'flash' => 'wow flash',
            'pulse' => 'wow pulse',
            'rubberBand' => 'wow rubberBand',
            'shake' => 'wow shake',
            'swing' => 'wow swing',
            'tada' => 'wow tada',
            'wobble' => 'wow wobble',
            'bounceIn' => 'wow bounceIn',
            'fadeIn' => 'wow fadeIn',
            'fadeInDown' => 'wow fadeInDown',
            'fadeInDownBig' => 'wow fadeInDownBig',
            'fadeInLeft' => 'wow fadeInLeft',
            'fadeInLeftBig' => 'wow fadeInLeftBig',
            'fadeInRight' => 'wow fadeInRight',
            'fadeInRightBig' => 'wow fadeInRightBig',
            'fadeInUp' => 'wow fadeInUp',
            'fadeInUpBig' => 'wow fadeInUpBig',
            'flip' => 'wow flip',
            'flipInX' => 'wow flipInX',
            'flipInY' => 'wow flipInY',
            'lightSpeedIn' => 'wow lightSpeedIn',
            'rotateInrotateIn' => 'wow rotateIn',
            'rotateInDownLeft' => 'wow rotateInDownLeft',
            'rotateInDownRight' => 'wow rotateInDownRight',
            'rotateInUpLeft' => 'wow rotateInUpLeft',
            'rotateInUpRight' => 'wow rotateInUpRight',
            'slideInDown' => 'wow slideInDown',
            'slideInLeft' => 'wow slideInLeft',
            'slideInRight' => 'wow slideInRight',
            'rollIn' => 'wow rollIn'
        )
	));
	vc_add_param( 'vc_column_inner', array(
		"type" => "textfield",
		"heading" => __('Duration','lanethemekit'),
		"param_name" => "col_wowduration",
		"std" => "1000",
		'weight' => 0
	));
	vc_add_param( 'vc_column_inner', array(
		"type" => "textfield",
		"heading" => __('Delay','lanethemekit'),
		"param_name" => "col_wowdelay",
		"std" => "300",
		'weight' => 0
	));
	
	// Post Grid
	$param = WPBMap::getParam('vc_posts_grid', 'grid_layout');
	$param['type']='dropdown';
	$param['heading']='Layout Style';
	$param['value']=array(
						'Grid'=>'grid',
						'Carousel'=>'carousel'
					);
	WPBMap::mutateParam('vc_posts_grid', $param);
}

function lane_product_categories() {
    $product_categories = get_categories( array(
        'hide_empty'   => 0,
        'hierarchical' => 1,
        'taxonomy'     => 'product_cat'
    ));
    $categories = array();
    
    foreach ($product_categories as $cat) {
        $categories[] = array(
            'value'  => @$cat->slug,
            'label' => @$cat->cat_name
        );
    }

    return $categories;
}
