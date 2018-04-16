<?php
function wezmenu_get_transition() {
	return array(
		'none' => __('None','wezmenu'),
		'wez-animate-slide-up' => __('Slide Up','wezmenu'),
		'wez-animate-slide-down' => __('Slide Down','wezmenu'),
		'wez-animate-slide-left' => __('Slide Left','wezmenu'),
		'wez-animate-slide-right' => __('Slide Right','wezmenu'),
		'wez-animate-sign-flip' => __('Sign Flip','wezmenu'),
	);
}

function wezmenu_get_grid () {
	return array(
		'basic' => array(
			'text' => __('Basic','wezmenu'),
			'options' => array(
				'auto' => __('Automatic','wezmenu'),
				'wez-col wez-col-12-12' => __('Full Width','wezmenu'),
			)
		),
		'halves' => array(
			'text' => __('Halves','wezmenu'),
			'options' => array(
				'wez-col wez-col-6-12' => __('1/2','wezmenu'),
			)
		),
		'thirds' => array(
			'text' => __('Thirds','wezmenu'),
			'options' => array(
				'wez-col wez-col-4-12' => __('1/3','wezmenu'),
				'wez-col wez-col-8-12' => __('2/3','wezmenu'),
			)
		),
		'quarters' => array(
			'text' => __('Quarters','wezmenu'),
			'options' => array(
				'wez-col wez-col-3-12' => __('1/4','wezmenu'),
				'wez-col wez-col-9-12' => __('3/4','wezmenu'),
			)
		),
		'fifths' => array(
			'text' => __('Fifths','wezmenu'),
			'options' => array(
				'wez-col wez-col-2-10' => __('1/5','wezmenu'),
				'wez-col wez-col-4-10' => __('2/5','wezmenu'),
				'wez-col wez-col-6-10' => __('3/5','wezmenu'),
				'wez-col wez-col-8-10' => __('4/5','wezmenu'),
			)
		),
		'sixths' => array(
			'text' => __('Sixths','wezmenu'),
			'options' => array(
				'wez-col wez-col-2-12' => __('1/6','wezmenu'),
				'wez-col wez-col-10-12' => __('5/6','wezmenu'),
			)
		),
		'sevenths' => array(
			'text' => __('Sevenths','wezmenu'),
			'options' => array(
				'wez-col wez-col-1-7' => __('1/7','wezmenu'),
				'wez-col wez-col-2-7' => __('2/7','wezmenu'),
				'wez-col wez-col-3-7' => __('3/7','wezmenu'),
				'wez-col wez-col-4-7' => __('4/7','wezmenu'),
				'wez-col wez-col-5-7' => __('5/7','wezmenu'),
				'wez-col wez-col-6-7' => __('6/7','wezmenu'),
			)
		),
		'eighths' => array(
			'text' => __('Eighths','wezmenu'),
			'options' => array(
				'wez-col wez-col-1-8' => __('1/8','wezmenu'),
				'wez-col wez-col-3-8' => __('3/8','wezmenu'),
				'wez-col wez-col-5-8' => __('5/8','wezmenu'),
				'wez-col wez-col-7-8' => __('7/8','wezmenu'),
			)
		),
		'ninths' => array(
			'text' => __('Ninths','wezmenu'),
			'options' => array(
				'wez-col wez-col-1-9' => __('1/9','wezmenu'),
				'wez-col wez-col-2-9' => __('2/9','wezmenu'),
				'wez-col wez-col-4-9' => __('4/9','wezmenu'),
				'wez-col wez-col-5-9' => __('5/9','wezmenu'),
				'wez-col wez-col-7-9' => __('7/9','wezmenu'),
				'wez-col wez-col-8-9' => __('8/9','wezmenu'),
			)
		),
		'tenths' => array(
			'text' => __('Tenths','wezmenu'),
			'options' => array(
				'wez-col wez-col-1-10' => __('1/10','wezmenu'),
				'wez-col wez-col-3-10' => __('3/10','wezmenu'),
				'wez-col wez-col-7-10' => __('7/10','wezmenu'),
				'wez-col wez-col-9-10' => __('9/10','wezmenu'),
			)
		),
		'elevenths' => array(
			'text' => __('Elevenths','wezmenu'),
			'options' => array(
				'wez-col wez-col-1-11' => __('1/11','wezmenu'),
				'wez-col wez-col-2-11' => __('2/11','wezmenu'),
				'wez-col wez-col-3-11' => __('3/11','wezmenu'),
				'wez-col wez-col-4-11' => __('4/11','wezmenu'),
				'wez-col wez-col-5-11' => __('5/11','wezmenu'),
				'wez-col wez-col-6-11' => __('6/11','wezmenu'),
				'wez-col wez-col-7-11' => __('7/11','wezmenu'),
				'wez-col wez-col-8-11' => __('8/11','wezmenu'),
				'wez-col wez-col-9-11' => __('9/11','wezmenu'),
				'wez-col wez-col-10-11' => __('10/11','wezmenu'),
			)
		),
		'twelfths' => array(
			'text' => __('Twelfths','wezmenu'),
			'options' => array(
				'wez-col wez-col-1-12' => __('1/12','wezmenu'),
				'wez-col wez-col-5-12' => __('5/12','wezmenu'),
				'wez-col wez-col-7-12' => __('7/12','wezmenu'),
				'wez-col wez-col-11-12' => __('11/12','wezmenu'),
			)
		),
	);
}


global $wezmenu_item_settings;
$wezmenu_item_settings = array(
	'general' => array(
		'text' => __('General','wezmenu'),
		'icon' => 'fa fa-cogs',
		'config' => array(
			'general-heading' => array(
				'text' => __('General','wezmenu'),
				'type' => 'heading'
			),
			'general-url' => array(
				'text' => __('URL','wezmenu'),
				'type' => 'text',
				'std'  => '',
			),
			'general-title' => array(
				'text' => __('Navigation Label','wezmenu'),
				'type' => 'text',
				'std'  => '',
			),
			'general-attr-title' => array(
				'text' => __('Title Attribute','wezmenu'),
				'type' => 'text',
				'std'  => '',
			),
			'general-target' => array(
				'text' => __('Open link in a new window/tab','wezmenu'),
				'type' => 'checkbox',
				'std'  => '',
				'value' => '_blank',
			),
			'general-classes' => array(
				'text' => __('CSS Classes (optional)','wezmenu'),
				'type' => 'array',
				'std'  => '',
			),
			'general-xfn' => array(
				'text' => __('Link Relationship (XFN)','wezmenu'),
				'type' => 'text',
				'std'  => '',
			),
			'general-description' => array(
				'text' => __('Description','wezmenu'),
				'type' => 'textarea',
				'std'  => '',
			),
			'general-other-heading' => array(
				'text' => __('Other','wezmenu'),
				'type' => 'heading'
			),
			'other-disable-text' => array(
				'text' => __('Disable Text','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			'other-disable-menu-item' => array(
				'text' => __('Disable Menu Item','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			'other-disable-link' => array(
				'text' => __('Disable Link','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			'other-display-header-column' => array(
				'text' => __('Display as a Sub Menu column header','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			'other-disable-caret-icon' => array(
				'text' => __('Disable Caret Icon','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			'other-feature-text' => array(
				'text' => __('Menu Feature Text','wezmenu'),
				'type' => 'text',
				'std' => ''
			),
		)
	),
	'icon' => array(
		'text' => __('Icon','wezmenu'),
		'icon' => 'fa fa-qrcode',
		'config' => array(
			'icon-heading' => array(
				'text' => __('Icon','wezmenu'),
				'type' => 'heading'
			),
			'icon-value' => array(
				'text' => __('Set Icon','wezmenu'),
				'type' => 'icon',
				'std'  => '',
			),
			'icon-position' => array(
				'text' => __('Icon Position','wezmenu'),
				'type' => 'select',
				'std'  => 'left',
				'options' => array(
					'left' => __('Left of Menu Text','wezmenu'),
					'right' => __('Right of Menu Text','wezmenu'),
				)
			),
			'icon-padding' => array(
				'text' => __('Padding Icon and Text Menu','wezmenu'),
				'type' => 'text',
				'std'  => '',
				'des' => __('Padding between Icon and Text Menu (px). Do not include units','wezmenu')
			)
		)
	),
	'image' => array(
		'text' => __('Image','wezmenu'),
		'icon' => 'fa fa-picture-o',
		'config' => array(
			'image-heading' => array(
				'text' => __('Image','wezmenu'),
				'type' => 'heading'
			),
			'image-url' => array(
				'text' => __('Image Url','wezmenu'),
				'type' => 'image',
				'std'  => '',
			),
			'image-size' => array(
				'text' => __('Image Size','wezmenu'),
				'type' => 'select',
				'std'  => 'inherit',
				'options' => wezmenu_get_image_size()
			),
			'image-dimensions' => array(
				'text' => __('Image Dimensions','wezmenu'),
				'type' => 'select',
				'std'  => 'inherit',
				'options' => array(
					'inherit' => 'Inherit from Menu Settings',
					'custom' => 'Custom',
				)
			),
			'image-width' => array(
				'text' => __('Image Width','wezmenu'),
				'type' => 'text',
				'std'  => '',
				'des' => __('Image width attribute (px). Do not include units. Only valid if "Image Dimension" is set to "Custom" above','wezmenu')
			),
			'image-height' => array(
				'text' => __('Image Height','wezmenu'),
				'type' => 'text',
				'std'  => '',
				'des' => __('Image width attribute (px). Do not include units. Only valid if "Image Dimension" is set to "Custom" above','wezmenu')
			),
			'image-layout' => array(
				'text' => __('Image Layout','wezmenu'),
				'type' => 'select',
				'std'  => 'image-only',
				'options' => array(
					'image-only' => __('Image Only','wezmenu'),
					'left' => __('Image Left','wezmenu'),
					'right' => __('Image Right','wezmenu'),
					'above' => __('Image Above','wezmenu'),
					'below' => __('Image Below','wezmenu'),
				)
			),
			'image-feature' => array(
				'text' => __('Use Feature Image','wezmenu'),
				'type' => 'checkbox',
				'std'  => '',
				'des' => 'Use Feature Image from Post/Page Menu Item',
			),
		)
	),

	'layout' => array(
		'text' => __('Layout','wezmenu'),
		'icon' => 'fa fa-columns',
		'config' => array(
			'layout-heading' => array(
				'text' => __('Layout','wezmenu'),
				'type' => 'heading'
			),
			'layout-width' => array(
				'text' => __('Menu Item Width','wezmenu'),
				'type' => 'select-group',
				'std'  => 'auto',
				'options' => wezmenu_get_grid()
			),
			'layout-text-align' => array(
				'text' => __('Item Content Alignment','wezmenu'),
				'type' => 'select',
				'std'  => 'none',
				'options' => array(
					'none' => __('Default','wezmenu'),
					'left' => __('Text Left','wezmenu'),
					'center' => __('Text Center','wezmenu'),
					'right' => __('Text Right','wezmenu'),
				)
			),
			'layout-padding' => array(
				'text' => __('Padding','wezmenu'),
				'type' => 'text',
				'std'  => '',
				'des' => __('Set padding for menu item. Include the units.','wezmenu'),
			),
			'layout-margin' => array(
				'text' => __('Margin','wezmenu'),
				'type' => 'text',
				'std'  => '',
				'des' => __('Set margin for menu item. Include the units.','wezmenu'),
			),
			'layout-new-row' => array(
				'text' => __('New Row','wezmenu'),
				'type' => 'checkbox',
				'std'  => ''
			),
		)
	),
	'submenu' => array(
		'text' => __('Sub Menu','wezmenu'),
		'icon' => 'fa fa-list-alt',
		'config' => array(
			'submenu-heading' => array(
				'text' => __('Sub Menu','wezmenu'),
				'type' => 'heading'
			),
			'submenu-type' => array(
				'text' => __('Sub Menu Type','wezmenu'),
				'type' => 'select',
				'std'  => 'standard',
				'options' => array(
					'standard' => __('Standard','wezmenu'),
					'multi-column' => __('Multi Column','wezmenu'),
					/*'stack' => __('Stack','wezmenu'),*/
					'tab' => __('Tab','wezmenu'),
				)
			),
			'submenu-position' => array(
				'text' => __('Sub Menu Position','wezmenu'),
				'type' => 'select',
				'std'  => '',
				'options' => array(
					'' => __('Automatic','wezmenu'),
					'pos-left-menu-parent' => __('Left of Menu Parent','wezmenu'),
					'pos-right-menu-parent' => __('Right of Menu Parent','wezmenu'),
					'pos-center-menu-parent' => __('Center of Menu Parent','wezmenu'),
					'pos-left-menu-bar' => __('Left of Menu Bar','wezmenu'),
					'pos-right-menu-bar' => __('Right of Menu Bar','wezmenu'),
					'pos-full' => __('Full Size','wezmenu'),
				)
			),
			'submenu-width-custom' => array(
				'text' => __('Sub Menu Width Custom','wezmenu'),
				'type' => 'text',
				'std'  => '',
				'des' => __('Set custom Sub Menu Width. Include the units (px/em/%).','wezmenu'),
			),
			'submenu-col-width-default' => array(
				'text' => __('Sub Menu Column Width Default','wezmenu'),
				'type' => 'select-group',
				'std'  => 'auto',
				'options' => wezmenu_get_grid()
			),
			'submenu-col-spacing-default' => array(
				'text' => __('Sub Menu Column Spacing Default','wezmenu'),
				'type' => 'text',
				'std'  => '',
				'des' => __('Set sub menu column spacing default. Do not include unit.','wezmenu'),
			),
			'submenu-list-style' => array(
				'text' => __('Sub Menu List Style','wezmenu'),
				'type' => 'select',
				'std'  => 'none',
				'options' => array(
					'none' => __('None','wezmenu'),
					'disc' => __('Disc','wezmenu'),
					'square' => __('Square','wezmenu'),
					'circle' => __('Circle','wezmenu'),
				)
			),
			'submenu-tab-position' => array(
				'text' => __('Tab Position','wezmenu'),
				'type' => 'select',
				'std'  => 'left',
				'des' => __('Tab Position set to "Sub Menu Type" is "TAB".','wezmenu'),
				'options' => array(
					'left' => __('Left','wezmenu'),
					'right' => __('Right','wezmenu'),
				)
			),
			'submenu-animation' => array(
				'text' => __('Sub Menu Animation','wezmenu'),
				'type' => 'select',
				'std'  => 'none',
				'options' => wezmenu_get_transition()
			),
		)
	),
	'custom-content' => array(
		'text' => __('Custom Content','wezmenu'),
		'icon' => 'fa fa-code',
		'config' => array(
			'custom-content-heading' => array(
				'text' => __('Custom Content','wezmenu'),
				'type' => 'heading'
			),
			'custom-content-value' => array(
				'text' => __('Custom Content','wezmenu'),
				'type' => 'textarea',
				'std'  => '',
				'des' => __('Can contain HTML and shortcodes','wezmenu'),
				'height' => '300px'
			),
		)
	),
	'widget' => array(
		'text' => __('Widget Area','wezmenu'),
		'icon' => 'fa-puzzle-piece',
		'config' => array(
			'widget-heading' => array(
				'text' => __('Widget Area','wezmenu'),
				'type' => 'heading'
			),
			'widget-area' => array(
				'text' => __('Widget Area','wezmenu'),
				'type' => 'text',
				'std'  => '',
				'des' => __('Enter a name for your Widget Area, and a widget area specifically for this menu item will be automatically be created in the <a href="widgets.php" target="_blank">Widgets Screen</a>','wezmenu'),
			),
		)
	),
	'customize-style' => array(
		'text' => __('Customize Style','wezmenu'),
		'icon' => 'fa-paint-brush',
		'config' => array(
			'custom-style-menu-heading' => array(
				'text' => __('Menu Item','wezmenu'),
				'type' => 'heading'
			),
			'custom-style-menu-bg-color' => array(
				'text' => __('Background Color','wezmenu'),
				'type' => 'color',
				'std'  => '',
			),
			'custom-style-menu-text-color' => array(
				'text' => __('Text Color','wezmenu'),
				'type' => 'color',
				'std'  => '',
			),
			'custom-style-menu-bg-color-active' => array(
				'text' => __('Background Color [Active]','wezmenu'),
				'type' => 'color',
				'std'  => '',
			),
			'custom-style-menu-text-color-active' => array(
				'text' => __('Text Color [Active]','wezmenu'),
				'type' => 'color',
				'std'  => '',
			),
			'custom-style-menu-bg-image' => array(
				'text' => __('Background Image','wezmenu'),
				'type' => 'image',
				'std'  => '',
			),
			'custom-style-menu-bg-image-repeat' => array(
				'text' => __('Background Image Repeat','cupid'),
				'type' => 'select',
				'std' => 'no-repeat',
				'hide-label' => 'true',
				'options' => array(
					'no-repeat' => 'no-repeat',
					'repeat' => 'repeat',
					'repeat-x' => 'repeat-x',
					'repeat-y' => 'repeat-y'
				)
			),
			'custom-style-menu-bg-image-attachment' => array(
				'text' => __('Background Image Attachment','cupid'),
				'type' => 'select',
				'std' => 'scroll',
				'hide-label' => 'true',
				'options' => array(
					'scroll' => 'scroll',
					'fixed' => 'fixed'
				)
			),
			'custom-style-menu-bg-image-position' => array(
				'text' => __('Background Image Position','cupid'),
				'type' => 'select',
				'std' => 'center',
				'hide-label' => 'true',
				'options' => array(
					'center' => 'center',
					'center left' => 'center left',
					'center right' => 'center right',
					'top left' => 'top left',
					'top center' => 'top center',
					'top right' => 'top right',
					'bottom left' => 'bottom left',
					'bottom center' => 'bottom center',
					'bottom right' => 'bottom right'
				)
			),
			'custom-style-menu-bg-image-size' => array(
				'text' => __('Background Image Size','cupid'),
				'type' => 'select',
				'std' => 'auto',
				'hide-label' => 'true',
				'options' => array(
					'auto' => 'Keep original',
					'100% auto' => 'Stretch to width',
					'auto 100%' => 'Stretch to height',
					'cover' => 'Cover',
					'contain' => 'Contain'
				)
			),
			'custom-style-sub-menu-heading' => array(
				'text' => __('Sub Menu','wezmenu'),
				'type' => 'heading'
			),
			'custom-style-sub-menu-bg-color' => array(
				'text' => __('Background Color','wezmenu'),
				'type' => 'color',
				'std'  => '',
			),
			'custom-style-sub-menu-text-color' => array(
				'text' => __('Text Color','wezmenu'),
				'type' => 'color',
				'std'  => '',
			),
			'custom-style-sub-menu-bg-image' => array(
				'text' => __('Background Image','wezmenu'),
				'type' => 'image',
				'std'  => '',
			),
			'custom-style-sub-menu-bg-image-repeat' => array(
				'text' => __('Background Image Repeat','cupid'),
				'type' => 'select',
				'std' => 'no-repeat',
				'hide-label' => 'true',
				'options' => array(
					'no-repeat' => 'no-repeat',
					'repeat' => 'repeat',
					'repeat-x' => 'repeat-x',
					'repeat-y' => 'repeat-y'
				)
			),
			'custom-style-sub-menu-bg-image-attachment' => array(
				'text' => __('Background Image Attachment','cupid'),
				'type' => 'select',
				'std' => 'scroll',
				'hide-label' => 'true',
				'options' => array(
					'scroll' => 'scroll',
					'fixed' => 'fixed'
				)
			),
			'custom-style-sub-menu-bg-image-position' => array(
				'text' => __('Background Image Position','cupid'),
				'type' => 'select',
				'std' => 'center',
				'hide-label' => 'true',
				'options' => array(
					'center' => 'center',
					'center left' => 'center left',
					'center right' => 'center right',
					'top left' => 'top left',
					'top center' => 'top center',
					'top right' => 'top right',
					'bottom left' => 'bottom left',
					'bottom center' => 'bottom center',
					'bottom right' => 'bottom right'
				)
			),
			'custom-style-sub-menu-bg-image-size' => array(
				'text' => __('Background Image Size','cupid'),
				'type' => 'select',
				'std' => 'auto',
				'hide-label' => 'true',
				'options' => array(
					'auto' => 'Keep original',
					'100% auto' => 'Stretch to width',
					'auto 100%' => 'Stretch to height',
					'cover' => 'Cover',
					'contain' => 'Contain'
				)
			),
			'custom-style-col-min-width' => array(
				'text' => __('Column Min Width','wezmenu'),
				'type' => 'text',
				'std'  => '',
				'des' => __('Set min-width for Sub Menu Column (px). Not include the units.','wezmenu'),
			),
			'custom-style-padding' => array(
				'text' => __('Padding','wezmenu'),
				'type' => 'text',
				'std'  => '',
				'des' => __('Set padding for Sub Menu. Include the units.','wezmenu'),
			),

			'custom-style-feature-menu-text-heading' => array(
				'text' => __('Menu Feature Text','wezmenu'),
				'type' => 'heading'
			),
			'custom-style-feature-menu-text-type' => array(
				'text' => __('Feature Menu Type','wezmenu'),
				'type' => 'select',
				'std'  => '',
				'options' => array(
					'' => __('Standard','wezmenu'),
					'wez-feature-menu-not-float' => __('Not Float','wezmenu')
				)
			),
			'custom-style-feature-menu-text-bg-color' => array(
				'text' => __('Background Color','wezmenu'),
				'type' => 'color',
				'std'  => '',
			),
			'custom-style-feature-menu-text-color' => array(
				'text' => __('Text Color','wezmenu'),
				'type' => 'color',
				'std'  => '',
			),
			'custom-style-feature-menu-text-top' => array(
				'text' => __('Position Top','wezmenu'),
				'type' => 'text',
				'std'  => '',
				'des'  => 'Position Top (px) Feature Menu Text. Do not include units.',
			),
			'custom-style-feature-menu-text-left' => array(
				'text' => __('Position Left','wezmenu'),
				'type' => 'text',
				'std'  => '',
				'des'  => 'Position Left (px) Feature Menu Text. Do not include units.',
			),
		)
	),
	'responsive' => array(
		'text' => __('Responsive','wezmenu'),
		'icon' => 'fa-desktop',
		'config' => array(
			'responsive-heading' => array(
				'text' => __('Responsive','wezmenu'),
				'type' => 'heading'
			),
			'responsive-hide-mobile-css' => array(
				'text' => __('Hide item on mobile via CSS','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			'responsive-hide-desktop-css' => array(
				'text' => __('Hide item on desktop via CSS','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			'responsive-hide-mobile-css-submenu' => array(
				'text' => __('Hide sub menu on mobile via CSS','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			'responsive-remove-mobile' => array(
				'text' => __('Remove this item when mobile device is detected via wp_is_mobile()','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			'responsive-remove-desktop' => array(
				'text' => __('Remove this item when desktop device is NOT detected via wp_is_mobile()','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			'responsive-remove-mobile-submenu' => array(
				'text' => __('Remove sub menu when desktop device is NOT detected via wp_is_mobile()','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
		),
	),
	'responsive' => array(
		'text' => __('Responsive','wezmenu'),
		'icon' => 'fa-desktop',
		'config' => array(
			'responsive-heading' => array(
				'text' => __('Responsive','wezmenu'),
				'type' => 'heading'
			),
			'responsive-hide-mobile-css' => array(
				'text' => __('Hide item on mobile via CSS','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			'responsive-hide-desktop-css' => array(
				'text' => __('Hide item on desktop via CSS','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			'responsive-hide-mobile-css-submenu' => array(
				'text' => __('Hide sub menu on mobile via CSS','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			'responsive-hide-desktop-css-submenu' => array(
				'text' => __('Hide sub menu on desktop via CSS','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			/*'responsive-remove-mobile' => array(
				'text' => __('Remove this item when mobile device is detected via wp_is_mobile()','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			'responsive-remove-desktop' => array(
				'text' => __('Remove this item when desktop device is NOT detected via wp_is_mobile()','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),
			'responsive-remove-mobile-submenu' => array(
				'text' => __('Remove sub menu when desktop device is NOT detected via wp_is_mobile()','wezmenu'),
				'type' => 'checkbox',
				'std' => ''
			),*/
		),
	)
);

global $wezmenu_item_defaults;
$wezmenu_item_defaults = wezmenu_get_item_defaults($wezmenu_item_settings);

function wezmenu_get_item_defaults($items_setting, $defaults = array()) {
	if (!$defaults) {
		$defaults = array(
			'nosave-type_label' => '',
			'nosave-type' => '',
			'nosave-change' => 0
		);
	}

	foreach ($items_setting as $seting_key => $setting) {
		foreach ($setting['config'] as $key => $value) {
			if (isset($value['config']) && $value['config']) {

			}
			else {
				if ($value['type'] != 'heading') {
					$defaults[$key] = $value['std'];
				}
			}

		}
	}
	return $defaults;
}
function wezmenu_get_image_size($is_setting = 0) {
	global $_wp_additional_image_sizes;

	$sizes = array();
	$get_intermediate_image_sizes = get_intermediate_image_sizes();

	// Create the full array with sizes and crop info
	foreach( $get_intermediate_image_sizes as $_size ) {

		if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

			$sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
			$sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
			$sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );

		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

			$sizes[ $_size ] = array(
				'width' => $_wp_additional_image_sizes[ $_size ]['width'],
				'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
			);

		}

	}
	$image_size = array();
	if (!$is_setting) {
		$image_size ['inherit'] = __('Inherit from Menu Setting','wezmenu');
	}
	$image_size ['full'] = __('Full Size','wezmenu');
	foreach ($sizes as $key => $value) {
		$image_size[$key] = ucfirst($key) . ' (' . $value['width'] . ' x ' . $value['height'] .')' . ($value['crop'] ? '[cropped]' : '') ;
	}
	return $image_size;
}