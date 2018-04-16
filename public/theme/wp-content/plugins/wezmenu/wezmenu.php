<?php
/*
Plugin Name: WezMenu - The Mega Menu For WordPress
Plugin URI: http://wordpress.org
Description: Easily create beautiful, flexible, responsive mega menus
Author: Wez
Author URI: http://wordpress.org
Version: 1.0.0
*/
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'WezMenu' ) ) :
final class WezMenu {
	private static $instance;

	public static function init() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new WezMenu;
			self::$instance->define_constants();
			self::$instance->includes();
			self::$instance->process_filter();
		}

		return self::$instance;
	}

	private function define_constants(){
		// Plugin version
		if( ! defined( 'WEZMENU_VERSION' ) ) { define( 'WEZMENU_VERSION', '1.0.0' ); }
		// Plugin prefix
		if( ! defined( 'WEZMENU_PREFIX' ) ) { define( 'WEZMENU_PREFIX', 'wezmenu_' ); }
		// Plugin Folder URL
		if( ! defined( 'WEZMENU_URL' ) ) {define( 'WEZMENU_URL', plugin_dir_url( __FILE__ ) );}
		//if( ! defined( 'WEZMENU_URL' ) ) {define( 'WEZMENU_URL', plugins_url() . '/wezmenu/' );}
		// Plugin Folder Path
		if( ! defined( 'WEZMENU_DIR' ) ){define( 'WEZMENU_DIR', plugin_dir_path( __FILE__ ) );}
		if( ! defined( 'WEZMENU_BASENAME' ) ){ define( 'WEZMENU_BASENAME' , plugin_basename(__FILE__) );}
		if( ! defined( 'WEZMENU_BASEDIR' ) ){define( 'WEZMENU_BASEDIR' , dirname( plugin_basename(__FILE__) ) );}

		if( ! defined( 'WEZMENU_MENU_ITEM_WIDGET_AREAS' ) ){define( 'WEZMENU_MENU_ITEM_WIDGET_AREAS' , 'wezmenu_menu_item_widget_areas' );}
		if( ! defined( 'WEZMENU_MENU_WIDGET_AREAS_ID' ) ){define( 'WEZMENU_MENU_WIDGET_AREAS_ID' , 'wezmenu_menu_item_' );}
		if( ! defined( 'WEZMENU_SETTING_OPTIONS' ) ){define( 'WEZMENU_SETTING_OPTIONS' , 'wezmenu_setting_option' );}

	}

	private function includes() {
		require_once WEZMENU_DIR . 'inc/global.php';
		require_once WEZMENU_DIR . 'inc/toolbar.php';
		require_once WEZMENU_DIR . 'inc/menu-item.php';
		require_once WEZMENU_DIR . 'inc/functions.php';
		require_once WEZMENU_DIR . 'inc/WezMenuWalker.class.php';
		require_once WEZMENU_DIR . 'admin/admin.php';
	}

	private function process_filter() {
		add_filter('wp_nav_menu_args',array($this, 'replace_walker_to_wezmenu'));
		add_filter('wezmenu_custom_content', 'do_shortcode');
	}

	function replace_walker_to_wezmenu($args) {
		$settings = get_option(WEZMENU_SETTING_OPTIONS);
		$is_wezmenu = false;
		$menu_slug = '';

		if (isset($settings['integration-nav_menu']) && $args['menu']) {
			if (is_object($args['menu'])) {
				if (array_key_exists($args['menu']->slug, $settings['integration-nav_menu'])) {
					$menu_slug = $args['menu']->slug;
					$is_wezmenu = true;
				}
			}
			else {
				$term = get_term($args['menu'], 'nav_menu');

				if (!$term) {
					$term = get_term_by('slug', $args['menu'], 'nav_menu');
				}
				if ($term) {
					if ((array_key_exists($term->slug, $settings['integration-nav_menu']))) {
						$menu_slug = $term->slug;
						$is_wezmenu = true;
					}
				}
			}
		}


		if (isset($settings['integration-theme_location']) && !empty($args['theme_location']) && !$is_wezmenu) {
			if (array_key_exists($args['theme_location'], $settings['integration-theme_location'])) {
				$theme_locations = get_nav_menu_locations();
				if (isset($theme_locations[$args['theme_location']])) {
					$menu_obj = get_term( $theme_locations[$args['theme_location']], 'nav_menu' );
					if ($menu_obj) {
						$menu_slug = $menu_obj->slug;
						$is_wezmenu = true;
					}
				}
			}
		}
		if ($is_wezmenu) {
			$settings = get_option(WEZMENU_SETTING_OPTIONS. '_' . $menu_slug);
			if ($settings === false) {
				$settings = get_option(WEZMENU_SETTING_OPTIONS);
			}
			ob_start();
			?>
				<div class="wez-nav-menu-toggle">
					<?php echo apply_filters('wezmenu_toggle_inner_before',''); ?>
					<div class="wez-nav-menu-toggle-inner" data-ref="menu-<?php echo esc_attr($menu_slug) ?>">
						<?php echo apply_filters('wezmenu_filter_mobile_toggle_icon', '<div class="wez-nav-menu-toggle-icon"> <span></span></div>');?> <?php echo apply_filters('wezmenu_filter_mobile_toggle_text', '<span>'. __('Menu','wezmenu')) . '</span>';?>
					</div>
					<?php echo apply_filters('wezmenu_toggle_inner_after',''); ?>
				</div>
			<?php
			$wezmenu_toggle = ob_get_clean();

			$wezmenu_attrs = array();
			$wezmenu_attrs['data-breakpoint'] = isset($settings['setting-responsive-breakpoint']) && !empty($settings['setting-responsive-breakpoint']) ? $settings['setting-responsive-breakpoint'] : '991';

			$wezmenu_attr_str = '';
			foreach ($wezmenu_attrs as $key => $value) {
				$wezmenu_attr_str .= $key . '="'. esc_attr($value) . '" ';
			}

			$args['walker'] = new WezMenuWalker();
			$args['menu_id'] = 'menu-' . $menu_slug;
			$args['menu_class'] = 'wez-nav-menu wez-nav-menu-horizontal';
			$args['menu_class'] .= ' wez-nav-menu' . (empty($menu_slug) ? '' : '_' . $menu_slug );
			$args['items_wrap'] =
				apply_filters('wezmenu_filter_toggle', $wezmenu_toggle)
				. apply_filters('wezmenu_nav_filter_before', '')
				. '<ul id="%1$s" class="%2$s" ' . $wezmenu_attr_str . '>' . apply_filters('wezmenu_filter_before','') . '%3$s' . apply_filters('wezmenu_filter_after','')
				. '</ul>'
				. apply_filters('wezmenu_nav_filter_after', '');

			if ($settings !== false) {
				if (isset($settings['transition']) && $settings['transition'] != 'none') {
					$args['menu_class'] .= ' ' . $settings['transition'];
				}
				if (isset($settings['transition']) && !empty($settings['menu-bar-align'])) {
					$args['menu_class'] .= ' ' . $settings['menu-bar-align'];
				}
			}
		}
		return $args;
	}
}
endif;

if( !function_exists( '_WEZMENU' ) ){
	function _WEZMENU() {
		return WezMenu::init();
	}
	_WEZMENU();
}