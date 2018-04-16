<?php
class WezMenuWalker extends Walker_Nav_Menu {
	public $current_item = array();
	public $items_parent = array();
	public $is_print_custom_style = false;
	public $tab_current = 0;
	public $multi_col_current = 0;
	public $stack_current = 0;

	public $wezmenu_custom_style = '';

	function __construct(){
	}
	function custom_style_menu_item($item_id, $menu_data, $setting_options){
		$item_style = '';
		$submenu_style = '';
		$icon_style = '';

		$item_style_active = '';
		$submenu_style_active = '';

		$item_text_style = '';
		$item_text_style_active = '';

		$item_feature_text_style= '';
		$item_feature_text_style_after= '';

		//icon style
		if (isset($menu_data['icon-padding']) && $menu_data['icon-padding']) {
			if (isset($menu_data['icon-position']) && $menu_data['icon-position'] == 'left') {
				$icon_style .= 'padding-right:' . $menu_data['icon-padding'] . ';';
			}
			else {
				$icon_style .= 'padding-left:' . $menu_data['icon-padding'] . ';';
			}
		}

		//menu-item
		if (isset($menu_data['layout-padding']) && $menu_data['layout-padding']) {
			$item_style .= 'padding:' . $menu_data['layout-padding'] . ';';
		}
		if (isset($menu_data['layout-margin']) && $menu_data['layout-margin']) {
			$item_style .= 'margin:' . $menu_data['layout-margin'] . ';';
		}
		if (isset($menu_data['custom-style-menu-bg-color']) && $menu_data['custom-style-menu-bg-color']) {
			$item_style .= 'color:' . $menu_data['custom-style-menu-bg-color'] . ';';
		}

		if (isset($menu_data['custom-style-menu-text-color']) && $menu_data['custom-style-menu-text-color']) {
			$item_style .= 'color:' . $menu_data['custom-style-menu-text-color'] . ';';
			$item_text_style .= 'color:' . $menu_data['custom-style-menu-text-color'] . ';';
		}

		if (isset($menu_data['custom-style-menu-bg-image']) && $menu_data['custom-style-menu-bg-image']) {
			$bg_image = $menu_data['custom-style-menu-bg-image'];
			$bg_image_attr_attachment = (isset($menu_data['custom-style-menu-bg-image-attachment']) && !empty($menu_data['custom-style-menu-bg-image-attachment']))
				? $menu_data['custom-style-menu-bg-image-attachment'] : 'scroll';
			$bg_image_attr_position = (isset($menu_data['custom-style-menu-bg-image-position']) && !empty($menu_data['custom-style-menu-bg-image-position']))
				? $menu_data['custom-style-menu-bg-image-position'] : 'center';
			$bg_image_attr_repeat = (isset($menu_data['custom-style-menu-bg-image-repeat']) && !empty($menu_data['custom-style-menu-bg-image-repeat']))
				? $menu_data['custom-style-menu-bg-image-repeat'] : 'no-repeat';
			$bg_image_attr_size = (isset($menu_data['custom-style-menu-bg-image-size']) && !empty($menu_data['custom-style-menu-bg-image-size']))
				? $menu_data['custom-style-menu-bg-image-size'] : 'auto';

			$item_style .= "background-image:url('$bg_image');background-attachment:$bg_image_attr_attachment;background-position:$bg_image_attr_position;background-repeat:$bg_image_attr_repeat;background-size:$bg_image_attr_size;";
		}

		//menu-item style ACTIVE/HOVER
		if (isset($menu_data['custom-style-menu-bg-color-active']) && $menu_data['custom-style-menu-bg-color-active']) {
			$item_style_active .= 'background-color:' . $menu_data['custom-style-menu-bg-color-active'] . ';';
		}
		if (isset($menu_data['custom-style-menu-text-color-active']) && $menu_data['custom-style-menu-text-color-active']) {
			$item_style_active .= 'color:' . $menu_data['custom-style-menu-text-color-active'] . ';';
			$item_text_style_active .= 'color:' . $menu_data['custom-style-menu-text-color-active'] . ';';
		}

		//sub menu style
		if (isset($menu_data['submenu-width-custom']) && $menu_data['submenu-width-custom']) {
			$submenu_style .= 'width:' . $menu_data['submenu-width-custom'] . ';';
		}

		if (isset($menu_data['custom-style-col-min-width']) && $menu_data['custom-style-col-min-width']) {
			$submenu_style .= 'min-width:' . $menu_data['custom-style-col-min-width'] . ';';
		}

		if (isset($menu_data['custom-style-padding']) && $menu_data['custom-style-padding']) {
			$submenu_style .= 'padding:' . $menu_data['custom-style-padding'] . ';';
		}
		if (isset($menu_data['custom-style-sub-menu-bg-color']) && $menu_data['custom-style-sub-menu-bg-color']) {
			$submenu_style .= 'background-color:' . $menu_data['custom-style-sub-menu-bg-color'] . ';';
		}

		if (isset($menu_data['custom-style-sub-menu-text-color']) && $menu_data['custom-style-sub-menu-text-color']) {
			$submenu_style .= 'color:' . $menu_data['custom-style-sub-menu-text-color'] . ';';
		}
		if (isset($menu_data['custom-style-sub-menu-bg-image']) && $menu_data['custom-style-sub-menu-bg-image']) {
			$bg_image = $menu_data['custom-style-sub-menu-bg-image'];
			$bg_image_attr_attachment = (isset($menu_data['custom-style-sub-menu-bg-image-attachment']) && !empty($menu_data['custom-style-sub-menu-bg-image-attachment']))
				? $menu_data['custom-style-sub-menu-bg-image-attachment'] : 'scroll';
			$bg_image_attr_position = (isset($menu_data['custom-style-sub-menu-bg-image-position']) && !empty($menu_data['custom-style-sub-menu-bg-image-position']))
				? $menu_data['custom-style-sub-menu-bg-image-position'] : 'center';
			$bg_image_attr_repeat = (isset($menu_data['custom-style-sub-menu-bg-image-repeat']) && !empty($menu_data['custom-style-sub-menu-bg-image-repeat']))
				? $menu_data['custom-style-sub-menu-bg-image-repeat'] : 'no-repeat';
			$bg_image_attr_size = (isset($menu_data['custom-style-sub-menu-bg-image-size']) && !empty($menu_data['custom-style-sub-menu-bg-image-size']))
				? $menu_data['custom-style-sub-menu-bg-image-size'] : 'auto';

			$submenu_style .= "background-image:url('$bg_image');background-attachment:$bg_image_attr_attachment;background-position:$bg_image_attr_position;background-repeat:$bg_image_attr_repeat;background-size:$bg_image_attr_size;";
		}

		// Menu Item Feature
		if (isset($menu_data['other-feature-text']) && !empty($menu_data['other-feature-text'])) {
			if (isset($menu_data['custom-style-feature-menu-text-bg-color']) && !empty($menu_data['custom-style-feature-menu-text-bg-color'])) {
				$item_feature_text_style .= 'background:' . $menu_data['custom-style-feature-menu-text-bg-color'] . ';';
				$item_feature_text_style_after .= 'border-top-color:' . $menu_data['custom-style-feature-menu-text-bg-color'] . ';';
			}
			if (isset($menu_data['custom-style-feature-menu-text-color']) && !empty($menu_data['custom-style-feature-menu-text-color'])) {
				$item_feature_text_style .= 'color:' . $menu_data['custom-style-feature-menu-text-color'] . ';';
			}
			if (isset($menu_data['custom-style-feature-menu-text-top']) && !empty($menu_data['custom-style-feature-menu-text-top'])
				&& is_numeric($menu_data['custom-style-feature-menu-text-top'])) {
				$item_feature_text_style .= 'top:' . $menu_data['custom-style-feature-menu-text-top'] . 'px;';
			}
			if (isset($menu_data['custom-style-feature-menu-text-left']) && !empty($menu_data['custom-style-feature-menu-text-left'])
				&& is_numeric($menu_data['custom-style-feature-menu-text-left'])) {
				$item_feature_text_style .= 'left:' . $menu_data['custom-style-feature-menu-text-left'] . 'px;';
			}
		}

		//add style
		if (!empty($item_style)) {
			$this->wezmenu_custom_style .= '#menu-item-' . $item_id . '{' . $item_style . '}';
		}
		if (!empty($item_text_style)) {
			$this->wezmenu_custom_style .= '#menu-item-' . $item_id . ' > a{' . $item_text_style . '}';
		}
		if (!empty($item_style)) {
			$this->wezmenu_custom_style .= '#menu-item-' . $item_id . ':hover,'
				. '#menu-item-' . $item_id . '.current-menu-item,'
				. '#menu-item-' . $item_id . '.current-menu-ancestor' . '{' . $item_style_active . '}';
		}
		if (!empty($item_text_style_active)) {
			$this->wezmenu_custom_style .= '#menu-item-' . $item_id . ' > a:hover,'
				. '#menu-item-' . $item_id . '.current-menu-item > a,'
				. '#menu-item-' . $item_id . '.current-menu-ancestor > a' . '{' . $item_text_style_active . '}';
		}
		if (!empty($icon_style)) {
			$this->wezmenu_custom_style .= '#menu-item-' . $item_id . ' .wez-menu-icon' .'{' . $icon_style . '}';
		}
		if (!empty($submenu_style)) {
			$this->wezmenu_custom_style .= '#menu-item-' . $item_id . ' > ul.wez-sub-menu' .'{' . $submenu_style . '}';
		}
		if (!empty($submenu_style_active)) {
			$this->wezmenu_custom_style .= '#menu-item-' . $item_id . ':hover > ul.wez-sub-menu,'
				. '#menu-item-' . $item_id . '.current-menu-item > ul.wez-sub-menu,'
				. '#menu-item-' . $item_id . '.current-menu-ancestor > ul.wez-sub-menu'
				.'{' . $submenu_style_active . '}';
		}
		if (!empty($item_feature_text_style)) {
			$this->wezmenu_custom_style .= '#menu-item-' . $item_id . ' span.wez-menu-feature' .'{' . $item_feature_text_style . '}';
		}
		if (!empty($item_feature_text_style_after)) {
			$this->wezmenu_custom_style .= '#menu-item-' . $item_id . ' span.wez-menu-feature:after' .'{' . $item_feature_text_style_after . '}';
		}

		if (isset($menu_data['submenu-col-spacing-default']) && !empty($menu_data['submenu-col-spacing-default'])) {
			$this->wezmenu_custom_style .= '#menu-item-' . $item_id . ' > ul.wez-sub-menu > li+li' .'{padding-left:'. $menu_data['submenu-col-spacing-default'] . 'px}';
		}
	}
	function add_custom_style ($args, $setting_options) {
		// Get the nav menu based on the requested menu
		$menu = wp_get_nav_menu_object( $args->menu );
		// Get the nav menu based on the theme_location
		if ( ! $menu && $args->theme_location && ( $locations = get_nav_menu_locations() ) && isset( $locations[ $args->theme_location ] ) )
			$menu = wp_get_nav_menu_object( $locations[ $args->theme_location ] );

		// get the first menu that has items if we still can't find a menu
		if ( ! $menu && !$args->theme_location ) {
			$menus = wp_get_nav_menus();
			foreach ( $menus as $menu_maybe ) {
				if ( $menu_items = wp_get_nav_menu_items( $menu_maybe->term_id, array( 'update_post_term_cache' => false ) ) ) {
					$menu = $menu_maybe;
					break;
				}
			}
		}

		if ( $menu && ! is_wp_error($menu) && !isset($menu_items) ) {
			$menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );
			if ($menu_items) {
				//get responsive breakpoint
				$responsive_breakpoint = 991;
				if (isset($setting_options['setting-responsive-breakpoint']) && !empty($setting_options['setting-responsive-breakpoint']) && is_numeric($setting_options['setting-responsive-breakpoint'])) {
					$responsive_breakpoint = $setting_options['setting-responsive-breakpoint'];
				}

				$this->wezmenu_custom_style = '@media screen and (min-width: '. ($responsive_breakpoint + 1) . 'px) {';

				foreach	($menu_items as $key => $menu_item) {
					$menu_data = get_post_meta( $menu_item->ID, '_menu_item_wezmenu_config', true );
					$this->custom_style_menu_item($menu_item->ID, $menu_data, $setting_options);
				}
				$this->wezmenu_custom_style .= '}';
			}
			add_action('wp_head', array( &$this, 'print_custom_style' ), 100);
		}
	}

	function print_custom_style() {
		echo '<style id="wezmenu-custom-style">' . $this->wezmenu_custom_style .  '</style>';
	}

	function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		// check whether this item has children, and set $item->hasChildren accordingly
		$element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);
		// continue with normal behavior
		return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}

	// begin: ul
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		global $wezmenu_item_defaults;

		$menu_parent = null;
		if (count($this->items_parent) > 0) {
			$menu_parent = end($this->items_parent);
		}
		array_push($this->items_parent, $this->current_item);
		$wezmenu_meta = get_post_meta( $this->current_item->ID, '_menu_item_wezmenu_config', true );
		if ($wezmenu_meta) {
			$wezmenu_meta = array_merge($wezmenu_item_defaults, $wezmenu_meta);
		}
		else {
			$wezmenu_meta = $wezmenu_item_defaults;
		}

		$wezmenu_parent_meta = array();
		if ($menu_parent) {
			$wezmenu_parent_meta = get_post_meta( $menu_parent->ID, '_menu_item_wezmenu_config', true );
			if ($wezmenu_parent_meta) {
				$wezmenu_parent_meta = array_merge($wezmenu_item_defaults, $wezmenu_parent_meta);
			}
			else {
				$wezmenu_parent_meta = $wezmenu_item_defaults;
			}
		}

		$sub_menu_type = 'standard';

		if (isset($wezmenu_meta['submenu-type']) && !empty($wezmenu_meta['submenu-type'])) {
			$sub_menu_type = $wezmenu_meta['submenu-type'];
		}

		if ($sub_menu_type == 'tab') {
			if ($depth == 0) {
				$sub_menu_type = 'standard';
			}
			else {
				if ($wezmenu_parent_meta && isset($wezmenu_parent_meta['submenu-type']) && ($wezmenu_parent_meta['submenu-type'] != 'multi-column')) {
					$sub_menu_type = 'standard';
				}
			}
		}

		$sub_menu_class = array();
		$sub_menu_class [] = 'wez-sub-menu';
		$sub_menu_class [] = 'wez-sub-menu-' . $sub_menu_type;

		if (isset($wezmenu_meta['responsive-hide-mobile-css-submenu']) && ($wezmenu_meta['responsive-hide-mobile-css-submenu'] == '1')) {
			$sub_menu_class[] = 'wez-hide-sub-menu-mobile';
		}
		if (isset($wezmenu_meta['responsive-hide-desktop-css-submenu']) && ($wezmenu_meta['responsive-hide-desktop-css-submenu'] == '1')) {
			$sub_menu_class[] = 'wez-hide-sub-menu-desktop';
		}

		if (isset($wezmenu_meta['submenu-position']) && !empty($wezmenu_meta['submenu-position'])) {
			$sub_menu_class [] = 'wez-' . $wezmenu_meta['submenu-position'];
		}
		if (isset($wezmenu_meta['submenu-list-style']) && $wezmenu_meta['submenu-list-style']) {
			$sub_menu_class [] = 'wez-list-style-' . $wezmenu_meta['submenu-list-style'];
		}

		if (isset($wezmenu_meta['submenu-type']) && ($wezmenu_meta['submenu-type'] =='tab') && isset($wezmenu_meta['submenu-tab-position']) && $wezmenu_meta['submenu-tab-position']) {
			$sub_menu_class [] = 'wez-tab-position-' . $wezmenu_meta['submenu-tab-position'];
		}
		if (isset($wezmenu_meta['submenu-animation']) && $wezmenu_meta['submenu-animation'] && ($wezmenu_meta['submenu-animation'] != 'none')) {
			$sub_menu_class [] = $wezmenu_meta['submenu-animation'];
		}
		if (isset($wezmenu_meta['custom-content-value']) && $wezmenu_meta['custom-content-value']) {
			$sub_menu_class [] = 'wez-custom-content-wrapper';
		}

		if (isset($wezmenu_meta['widget-area']) && $wezmenu_meta['widget-area']) {
			$sub_menu_class [] = 'wez-widget-area-wrapper';
		}

		if (isset($wezmenu_meta['responsive-hide-mobile-css-submenu']) && $wezmenu_meta['responsive-hide-mobile-css-submenu'] == '1') {
			$sub_menu_class [] = 'wez-responsive-submenu-hide-mobile';
		}
		ob_start();
		?>
			<ul class="<?php echo join(' ', $sub_menu_class)?>">
		<?php
		$output .= ob_get_clean();
	}

	// end: ul
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$item = array_pop($this->items_parent);
		$output .= "</ul>";
	}

	// begin: li
	function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {
		global $wezmenu_item_defaults;
		$this->current_item = $item;
		if (is_array($args)) {
			$args = (object) $args;
		}

		$term_slug = 'wezmenu-default';

		$setting_default = _WEZMENU_SETTING()->get_setting_defaults();

		$terms_current = wp_get_post_terms($item->ID, 'nav_menu');
		if (count($terms_current) > 0) {
			$terms_current = $terms_current[0];
		}
		$setting_options = false;
		if ($terms_current) {
			$setting_options = get_option(WEZMENU_SETTING_OPTIONS . '_' . $terms_current->slug);
			$term_slug = $terms_current->slug;
		}
		if ($setting_options === false) {
			$setting_options = get_option(WEZMENU_SETTING_OPTIONS);
			$term_slug = 'wezmenu-default';
		}
		if ($setting_options) {
			$setting_options = array_merge($setting_default, $setting_options);
		}
		else {
			$setting_options = $setting_default;
		}


		if (!$this->is_print_custom_style) {
			$this->is_print_custom_style = true;
			$this->add_custom_style($args, $setting_options);

			global $wezmenu_queue_css;
			if (!isset($wezmenu_queue_css)) {
				$wezmenu_queue_css = array();
			}

			$wezmenu_queue_css[$term_slug] = ($term_slug == 'wezmenu-default') ? 'style.css' : 'style_' . $term_slug . '.css';
			global $wezmenu_queue_script_data;
			if (!isset($wezmenu_queue_script_data)) {
				$wezmenu_queue_script_data = array();
			}
			$wezmenu_queue_script_data[$term_slug] = array(
				/*'use-affix' => $setting_options['menu-affix'] == '1',
				'affix-top' => $setting_options['menu-affix-offset'],
				'affix-style' => $setting_options['menu-affix-style'],*/
				'setting-responsive-breakpoint' => $setting_options['setting-responsive-breakpoint'],
			);
		}
		$wezmenu_meta = get_post_meta( $this->current_item->ID, '_menu_item_wezmenu_config', true );

		$wezmenu_parent_meta = array();
		if (count($this->items_parent) > 0) {
			$item_parrent = end($this->items_parent);
			$wezmenu_parent_meta = get_post_meta( $item_parrent->ID, '_menu_item_wezmenu_config', true );
		}
		if ($wezmenu_meta) {
			$wezmenu_meta = array_merge($wezmenu_item_defaults, $wezmenu_meta);
		}
		else {
			$wezmenu_meta = $wezmenu_item_defaults;
		}

		// Add Class for li
		$item_classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$a_classes = array('wez-menu-a-text');
		$span_classes = array('wez-menu-text');
		$item_classes [] = 'wez-menu-item';
		if (($wezmenu_meta['submenu-type'] == 'tab') && ($depth > 0)) {
			$item_classes []= 'wez-tabs';
		}

		if (isset($wezmenu_meta['responsive-hide-mobile-css']) && ($wezmenu_meta['responsive-hide-mobile-css'] == '1')) {
			$item_classes[] = 'wez-hide-menu-item-mobile';
		}
		if (isset($wezmenu_meta['responsive-hide-desktop-css']) && ($wezmenu_meta['responsive-hide-desktop-css'] == '1')) {
			$item_classes[] = 'wez-hide-menu-item-desktop';
		}
		if (isset($wezmenu_meta['submenu-position']) && !empty($wezmenu_meta['submenu-position'])) {
			$item_classes [] = 'wez-' . $wezmenu_meta['submenu-position'];
		}

		if (isset($wezmenu_meta['other-disable-menu-item']) && $wezmenu_meta['other-disable-menu-item'] == '1') {
			$a_classes [] = 'wez-disable-menu-item';
		}

		if (isset($wezmenu_meta['other-disable-link']) && $wezmenu_meta['other-disable-link'] == '1') {
			$item_classes [] = 'wez-disable-link';
		}

		if (isset($wezmenu_meta['other-display-header-column']) && $wezmenu_meta['other-display-header-column'] == '1') {
			$item_classes [] = 'wez-header-column';
		}

		if ((isset($wezmenu_meta['image-url']) && !empty($wezmenu_meta['image-url'])) || (isset($wezmenu_meta['image-feature']) && ($wezmenu_meta['image-feature'] == '1'))) {
			$item_classes [] = 'wez-item-image';
			if (isset($wezmenu_meta['image-layout']) && $wezmenu_meta['image-layout']) {
				$item_classes [] = 'wez-image-layout';
				$item_classes [] = 'wez-image-layout-' . $wezmenu_meta['image-layout'];
			}
		}

		if (isset($wezmenu_meta['layout-text-align']) && ($wezmenu_meta['layout-text-align'] != 'none')) {
			$item_classes [] = 'wez-text-align-' . $wezmenu_meta['layout-text-align'];
		}
		if (isset($wezmenu_meta['layout-new-row']) && $wezmenu_meta['layout-new-row'] == '1') {
			$item_classes [] = 'wez-new-row';
		}
		if (isset($wezmenu_meta['custom-content-value']) && $wezmenu_meta['custom-content-value']) {
			$item_classes [] = 'wez-custom-content';
		}
		if (isset($wezmenu_meta['widget-area']) && $wezmenu_meta['widget-area']) {
			if (is_active_sidebar(WEZMENU_MENU_WIDGET_AREAS_ID . $item->post_name)) {
				$item_classes [] = 'wez-widget-area';
			}
		}
		if (isset($wezmenu_meta['responsive-hide-mobile-css']) && $wezmenu_meta['responsive-hide-mobile-css'] == '1') {
			$item_classes [] = 'wez-responsive-hide-mobile';
		}
		if (isset($wezmenu_meta['responsive-hide-desktop-css']) && $wezmenu_meta['responsive-hide-desktop-css'] == '1') {
			$item_classes [] = 'wez-responsive-hide-desktop';
		}

		$sub_menu_type = 'standard';

		if (isset($wezmenu_meta['submenu-type']) && !empty($wezmenu_meta['submenu-type'])) {
			$sub_menu_type = $wezmenu_meta['submenu-type'];
		}

		if ($sub_menu_type == 'tab') {
			if ($depth == 0) {
				$sub_menu_type = 'standard';
			}
			else {
				if ($wezmenu_parent_meta && isset($wezmenu_parent_meta['submenu-type']) && ($wezmenu_parent_meta['submenu-type'] != 'multi-column')) {
					$sub_menu_type = 'standard';
				}
			}
		}

		$item_classes [] = 'wez-sub-menu-' . $sub_menu_type;


		if (isset($wezmenu_meta['layout-width']) && !empty($wezmenu_meta['layout-width'])) {
			if (($wezmenu_meta['layout-width'] == 'auto')){
				if ($wezmenu_parent_meta && isset($wezmenu_parent_meta['submenu-col-width-default'])
					&& !empty($wezmenu_parent_meta['submenu-col-width-default'])
					&& ($wezmenu_parent_meta['submenu-col-width-default'] != 'auto'))
				{
					$item_classes [] = $wezmenu_parent_meta['submenu-col-width-default'] == 'full' ? 'wez-col-12-12' : $wezmenu_parent_meta['submenu-col-width-default'];
				}

			}
			else {
				$item_classes [] = $wezmenu_meta['layout-width'] == 'full' ? 'wez-col-12-12' : $wezmenu_meta['layout-width'];
			}
		}


		if (!empty( $item->description )) {
			$item_classes [] = 'wez-has-description';
		}

		// This is the stock WordPress code that builds the <li> with all of its attributes
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $item_classes ), $item ) );

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' data-rel="'    . esc_attr( $item->xfn        ) .'"' : '';

		if (isset($wezmenu_meta['other-disable-link']) && $wezmenu_meta['other-disable-link'] == '1') {
			$attributes .= '';
		}
		else {
			$attributes .= ! empty( $item->url ) && ($wezmenu_meta['other-disable-link'] != '1') ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		}

		$output .= '<li id="menu-item-'. $item->ID . '" class="' . esc_attr($class_names) .'">';

		if (isset($wezmenu_meta['other-disable-text']) && $wezmenu_meta['other-disable-text'] == '1') {
			$span_classes [] = 'wez-disable-text';
		}

		$icon_content = '';
		if (isset($wezmenu_meta['icon-value']) && $wezmenu_meta['icon-value']) {
			$icon_classes = array();
			$icon_classes[] = 'fa';
			$icon_classes[] = $wezmenu_meta['icon-value'];
			if (isset($wezmenu_meta['other-disable-text']) && $wezmenu_meta['other-disable-text'] == '1') {
				$icon_classes [] = 'wez-disable-text';
			}

			if (isset($wezmenu_meta['icon-position']) && $wezmenu_meta['icon-position']) {
				$icon_classes[] = 'wez-icon-' . $wezmenu_meta['icon-position'];
			}
			$icon_content = '<i class="wez-menu-icon ' . join(' ', $icon_classes) .'"></i>';
		}
		$item_output = $args->before;

		//var_dump($this->get_menu_image($depth, $wezmenu_meta, $setting_options, $item));

		if (isset($wezmenu_meta['image-layout']) && ($wezmenu_meta['image-layout'] != 'below')) {
			$item_output .= $this->get_menu_image($depth, $wezmenu_meta, $setting_options, $item);
		}


		$item_output .= '<a'. $attributes .' class="' . join(' ', $a_classes) . '">';
		if (isset($wezmenu_meta['icon-position']) && $wezmenu_meta['icon-position'] == 'left') {
			$item_output .= $args->link_before . $icon_content . '<span class="' . join(' ', $span_classes) . '">' . apply_filters( 'the_title', $item->title, $item->ID ) . '</span>';
		}
		else {
			$item_output .= $args->link_before . '<span class="' . join(' ', $span_classes) . '">' . apply_filters( 'the_title', $item->title, $item->ID ) . '</span>' . $icon_content;
		}

		$item_output .= $args->link_after;

		$menu_feature_class [] = 'wez-menu-feature';
		if (isset($wezmenu_meta['custom-style-feature-menu-text-type']) && !empty($wezmenu_meta['custom-style-feature-menu-text-type'])) {
			$menu_feature_class [] = $wezmenu_meta['custom-style-feature-menu-text-type'];
		}

		if (isset($wezmenu_meta['icon-position']) && !empty($wezmenu_meta['other-feature-text'])) {
			$item_output .= '<span class="' . join(' ',$menu_feature_class) .'">' . esc_html($wezmenu_meta['other-feature-text']) .'</span>';
		}

		if ($item->hasChildren && (isset($wezmenu_meta['other-disable-caret-icon']) && $wezmenu_meta['other-disable-caret-icon']!='1')) {
			$item_output .= '<b class="wez-caret"></b>';
		}

		$item_output .= '</a>';
		if (!empty( $item->description )) {
			$item_output .= '<p class="wez-description">' . esc_html($item->description) . '</p>';
		}
		if ($depth > 0) {
			if (isset($wezmenu_meta['image-layout']) && ($wezmenu_meta['image-layout'] == 'below')) {
				$item_output .= $this->get_menu_image($depth, $wezmenu_meta, $setting_options, $item);
			}

			if (isset($wezmenu_meta['custom-content-value']) && $wezmenu_meta['custom-content-value']) {
				$item_output .= '<div class="wez-custom-content-wrapper">' .  apply_filters('wezmenu_custom_content', $wezmenu_meta['custom-content-value']) . '</div>';
			}
			if (isset($wezmenu_meta['widget-area']) && $wezmenu_meta['widget-area']) {
				$widgets_arr = get_option(WEZMENU_MENU_ITEM_WIDGET_AREAS, array());
				if (isset($widgets_arr[$item->post_name])) {
					if (is_active_sidebar(WEZMENU_MENU_WIDGET_AREAS_ID . $item->post_name)) {
						ob_start();
						dynamic_sidebar( WEZMENU_MENU_WIDGET_AREAS_ID . $item->post_name );
						$item_output .= '<div class="wez-widget-area-wrapper">' . ob_get_clean() . '</div>';
					}
				}
			}
		}

		$item_output .= $args->after;
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

		if (isset($wezmenu_meta['submenu-type'])) {
			switch ($wezmenu_meta['submenu-type']) {
				case 'multi-column':
					if ($this->multi_col_current == 0) {
						$this->multi_col_current = $item->ID;
					}
					break;
				case 'stack':
					if ($this->stack_current == 0) {
						$this->stack_current = $item->ID;
					}
					break;
				case 'tab':
					if ($this->tab_current == 0) {
						$this->tab_current = $item->ID;
					}

					break;
			}
		}
	}

	// end: li
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if (isset($wezmenu_meta['submenu-type'])) {
			switch ($wezmenu_meta['submenu-type']) {
				case 'multi-column':
					if ($this->multi_col_current == $item->ID) {
						$this->multi_col_current = 0;
					}
					break;
				case 'stack':
					if ($this->tab_current == $item->ID) {
						$this->stack_current = 0;
					}
					break;
				case 'tab':
					if ($this->tab_current == $item->ID) {
						$this->tab_current = 0;
					}
					break;
			}
		}
		$output .= '</li>';
	}

	function get_menu_image($depth, $wezmenu_meta, $setting_options, $item) {
		$output = '';
		if (($depth >= 0) && ((isset($wezmenu_meta['image-url']) && !empty($wezmenu_meta['image-url'])) || (isset($wezmenu_meta['image-feature']) && ($wezmenu_meta['image-feature'] == '1') && ($item->type != 'custom')))) {

			$image_url = $wezmenu_meta['image-url'];
			$attachment_id = 0;
			if ($wezmenu_meta['image-feature'] == '1') {
				$attachment_id = get_post_thumbnail_id( $item->object_id );
			}
			else if (!empty($image_url)){
				$attachment_id = wezmenu_get_attachment_id_from_url($image_url);
			}

			

			if ($attachment_id) {
				$image_thumbnail_name = $wezmenu_meta['image-size'];
				if ($image_thumbnail_name == 'inherit') {
					$image_thumbnail_name = $setting_options['image-size'];
				}
				$image_thumbnail = wp_get_attachment_image_src($attachment_id, $image_thumbnail_name);
				if ($image_thumbnail) {
					$image_url = $image_thumbnail['0'];
				}
			}

			$image_attr = '';
			if ($wezmenu_meta['image-dimensions'] == 'inherit') {
				if (isset($setting_options['image-width']) && !empty($setting_options['image-width'])) {
					$image_attr .= ' width="' . esc_attr(str_replace('px','',$setting_options['image-width'])) . '"';
				}
				if (isset($setting_options['image-height']) && !empty($setting_options['image-height'])) {
					$image_attr .= ' height="' . esc_attr(str_replace('px','',$setting_options['image-height'])) . '"';
				}
			}
			else {
				if (isset($wezmenu_meta['image-width']) && !empty($wezmenu_meta['image-width'])) {
					$image_attr .= ' width="' . esc_attr(str_replace('px','',$wezmenu_meta['image-width'])) . '"';
				}
				if (isset($wezmenu_meta['image-height']) && !empty($wezmenu_meta['image-height'])) {
					$image_attr .= ' height="' . esc_attr(str_replace('px','',$wezmenu_meta['image-height'])) . '"';
				}
			}

			if (!empty($image_url)) {
				$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
				$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
				$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
				if (isset($wezmenu_meta['other-disable-text']) && $wezmenu_meta['other-disable-text'] == '1') {
					$attributes .= '';
				}
				else {
					$attributes .= ! empty( $item->url ) && ($wezmenu_meta['other-disable-link'] != '1') ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
				}
				$output .= '<a class="wez-image" ' . $attributes . ' >';
				$output .= '<img src="' . esc_url($image_url) . '" alt="' . esc_attr( $item->attr_title ) . '"' . $image_attr . '/>';
				$output .= '</a>';
			}
		}
		return $output;
	}
}