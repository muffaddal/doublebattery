<?php
require_once( 'wezmenu-settings.php' );

// Dynamic Widget Areas for Menu Item
add_action( 'widgets_init', 'wezmenu_register_item_menu_widget_areas', 1000 );
function wezmenu_register_item_menu_widget_areas() {
	$widgets = get_option(WEZMENU_MENU_ITEM_WIDGET_AREAS, array());
	if (!isset($widgets) && !($widgets)) return;
	foreach ($widgets as $item_id => $widget_title) {
		register_sidebar( array(
			'name'          => __("[WEZMENU] ",'wezmenu') . esc_html($widget_title),
			'id'            => WEZMENU_MENU_WIDGET_AREAS_ID . $item_id,
			'description'   => __("Widget Area for Menu Item: ",'wezmenu') . $item_id,
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title"><span>',
			'after_title'   => '</span></h4>',
		) );
	}
}

// bind setting item
function wezmenu_bind_setting_item($key, $item, $value) {
	switch ($item['type']) {
		case 'heading':
			?>
			<tr>
				<th colspan="2" class="heading"><?php echo esc_html($item['text']); ?></th>
			</tr>
			<?php
			break;
		case 'checkbox':
			?>
			<tr>
				<th class="row"><?php echo esc_html($item['text']); ?></th>
				<td class="">
					<fieldset>
						<label for="<?php echo WEZMENU_SETTING_OPTIONS . '[' . esc_attr($key) . ']'; ?>">
							<input name="<?php echo WEZMENU_SETTING_OPTIONS . '[' . esc_attr($key) . ']'; ?>" type="checkbox" id="<?php echo WEZMENU_SETTING_OPTIONS . '[' . esc_attr($key) . ']'; ?>" value="1" <?php checked( $value, 1 ); ?> />
							<?php echo esc_html($item['label']) ?>
						</label>
					</fieldset>
					<?php if (isset($item['des']) && !empty($item['des'])): ?>
						<div class="wez-description color2"><?php echo wp_kses_post($item['des'])?></div>
					<?php endif; ?>
				</td>
			</tr>
			<?php
			break;
		case 'select':
			?>
			<tr>
				<th class="row">
					<label for="<?php echo WEZMENU_SETTING_OPTIONS . '[' . esc_attr($key) . ']'; ?>"><?php echo esc_html($item['text']); ?></label>
				</th>
				<td class="">
					<select name="<?php echo WEZMENU_SETTING_OPTIONS . '[' . esc_attr($key) . ']'; ?>" id="<?php echo WEZMENU_SETTING_OPTIONS . '[' . esc_attr($key) . ']'; ?>">
						<?php foreach($item['options'] as $op_key => $op_value): ?>
							<option <?php selected( $op_key, $value ); ?> value="<?php echo esc_attr($op_key)?>"><?php echo esc_attr($op_value)?></option>
						<?php endforeach; ?>
					</select>
					<?php if (isset($item['des']) && !empty($item['des'])): ?>
						<div class="wez-description color2"><?php echo wp_kses_post($item['des'])?></div>
					<?php endif; ?>
				</td>
			</tr>
			<?php
			break;
		case 'text':
			?>
			<tr>
				<th class="row">
					<label for="<?php echo WEZMENU_SETTING_OPTIONS . '[' . esc_attr($key) . ']'; ?>"><?php echo esc_html($item['text']); ?></label>
				</th>
				<td class="">
					<input type="text" value="<?php echo esc_attr($value)?>"  name="<?php echo WEZMENU_SETTING_OPTIONS . '[' . esc_attr($key) . ']'; ?>" id="<?php echo WEZMENU_SETTING_OPTIONS . '[' . esc_attr($key) . ']'; ?>"/>
					<?php if (isset($item['des']) && !empty($item['des'])): ?>
						<div class="wez-description color2"><?php echo wp_kses_post($item['des'])?></div>
					<?php endif; ?>
				</td>
			</tr>
			<?php
			break;
		case 'list-checkbox':
			?>
			<tr>
				<th class="row"><?php echo esc_html($item['text']); ?></th>
				<td class="">
					<?php foreach($item['options'] as $op_key => $op_value): ?>
						<?php
							$op_selected = '';
							if (isset($value[$op_key])) {
								$op_selected = $value[$op_key];
							}
						?>
						<fieldset>
							<label>
								<input name="<?php echo WEZMENU_SETTING_OPTIONS . '[' . esc_attr($key) . '][' . esc_attr($op_key) .']'; ?>" type="checkbox" value="1" <?php checked( $op_selected, 1 ); ?> />
								<?php echo esc_html($op_value) ?>
							</label>
						</fieldset>
					<?php endforeach; ?>
					<?php if (isset($item['des']) && !empty($item['des'])): ?>
						<div class="wez-description color2"><?php echo wp_kses_post($item['des'])?></div>
					<?php endif; ?>
				</td>
			</tr>
			<?php
			break;
	}
}

function wezmenu_admin_setting_assets($hook){
	if( $hook == 'appearance_page_wezmenu-settings' ){
		wp_enqueue_style( 'wezmenu-menu-fontawesome', WEZMENU_URL. 'assets/css/fonts-awesome/css/font-awesome.min.css' );
		wp_enqueue_style( 'wezmenu-menu-admin', WEZMENU_URL. 'admin/assets/css/admin.css' );
		wp_enqueue_script( 'wezmenu-menu-admin', WEZMENU_URL. 'admin/assets/js/setting.min.js' , array( 'jquery' ) , WEZMENU_VERSION , true );
		wp_localize_script( 'wezmenu-menu-admin' , 'wezmenu_meta' , array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'delete_setting_confirm' => __('Are you sure delete this Settings?','wezmenu')
		) );

	}
}
add_action( 'admin_enqueue_scripts' , 'wezmenu_admin_setting_assets' );

add_action( 'admin_print_styles-nav-menus.php' , 'wezmenu_admin_menu_load_assets' );
function wezmenu_admin_menu_load_assets() {

	wp_enqueue_media();
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script('wp-color-picker');
	wp_enqueue_script( 'jquery' );

	wp_enqueue_style( 'wezmenu-menu-admin', WEZMENU_URL. 'admin/assets/css/admin.css' );
	wp_enqueue_style( 'wezmenu-menu-fontawesome', WEZMENU_URL. 'assets/css/fonts-awesome/css/font-awesome.min.css' );
	wp_enqueue_script( 'wezmenu-menu-jquery-mouse-wheel', WEZMENU_URL. 'admin/assets/js/jquery.mousewheel.js' , array( 'jquery' ) , WEZMENU_VERSION , true );
	wp_enqueue_script( 'wezmenu-menu-media-init', WEZMENU_URL. 'admin/assets/js/media-init.js' , array( 'jquery' ) , WEZMENU_VERSION , true );
	wp_enqueue_script( 'wezmenu-menu-admin', WEZMENU_URL. 'admin/assets/js/admin.min.js' , array( 'jquery' ) , WEZMENU_VERSION , true );

	$wezmenu_menu_data = wezmenu_get_menu_items_data();
	global $wezmenu_item_defaults;
	wp_localize_script( 'wezmenu-menu-admin' , 'wezmenu_menu_item_data' , $wezmenu_menu_data );
	wp_localize_script( 'wezmenu-menu-admin' , 'wezmenu_menu_item_default' , $wezmenu_item_defaults );
	wp_localize_script( 'wezmenu-menu-admin' , 'wezmenu_meta' , array(
		'ajax_url' => admin_url( 'admin-ajax.php' )
	) );
}

function wezmenu_get_menu_items_data($post_status = 'any') {
	global $nav_menu_selected_id, $wezmenu_item_defaults;
	$menu_items = wp_get_nav_menu_items( $nav_menu_selected_id, array( 'post_status' => $post_status ) );
	$wezmenu_data = array();
	if (!$menu_items) return $wezmenu_item_defaults;
	foreach ($menu_items as $key => $item) {
		$menu = array(
			'nosave-type_label' => $item->type_label,
			'nosave-type' => $item->type,
			'general-url' => $item->url,
			'general-title' => $item->title,
			'general-attr-title' => $item->attr_title,
			'general-target' => $item->target,
			'general-classes' => join(' ',$item->classes),
			'general-xfn' => $item->xfn,
			'general-description' => $item->description,
		);
		$menu_item_meta = get_post_meta( $item->ID, '_menu_item_wezmenu_config', true );
		if ($menu_item_meta) {
			$menu = array_merge($menu_item_meta, $menu);
		}
		$wezmenu_data [$item->ID] = array_merge($wezmenu_item_defaults, $menu);
	}
	return $wezmenu_data;
}