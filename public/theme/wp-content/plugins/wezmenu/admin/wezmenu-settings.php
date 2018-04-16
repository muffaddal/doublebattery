<?php
if ( !class_exists('WezMenu_Setting_Options' ) ):
	class WezMenu_Setting_Options {
		private static $instance;
		public $setting_options;
		public static function init() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new WezMenu_Setting_Options;
			}

			return self::$instance;
		}
		function __construct() {
			$theme_location = get_registered_nav_menus();
			$nav_menus = wp_get_nav_menus();
			$nav_menu_arr = array();
			foreach ($nav_menus as $nav_key => $nav_value) {
				$nav_menu_arr[$nav_value->slug] = $nav_value->name;
			}
			$this->setting_options = array(
				'integration' => array(
					'text' => 'Integration',
					'config' => array(
						'integration-heading' => array(
							'text' => __('Integration Settings For WezMenu','wezmenu'),
							'type' => 'heading',
						),
						'integration-theme_location' => array(
							'text' => __('Theme Location','wezmenu'),
							'type' => 'list-checkbox',
							'std' => '',
							'options' => $theme_location,
							'des' => __('Select the Theme locations to active WezMenu','wezmenu')
						),
						'integration-nav_menu' => array(
							'text' => __('Navigation Menu','wezmenu'),
							'type' => 'list-checkbox',
							'std' => '',
							'options' => $nav_menu_arr,
							'des' => __('Select the Navigation Menu to active WezMenu','wezmenu')
						),
					),
				),
				'settings' => array(
					'text' => 'Settings',
					'config' => array(
						'setting-heading' => array(
							'text' => __('Asset Settings','wezmenu'),
							'type' => 'heading',
						),
						'setting-plugin-css' => array(
							'text' => __('Plugin Css','wezmenu'),
							'type' => 'checkbox',
							'std' => '1',
							'label' => __('Load Css','wezmenu'),
						),
						'setting-font-awesome' => array(
							'text' => __('Font Awesome','wezmenu'),
							'type' => 'checkbox',
							'std' => '1',
							'label' => __('Load Font Awesome','wezmenu'),
						),
						'setting-responsive-breakpoint' => array(
							'text' => __('Responsive Breakpoint','wezmenu'),
							'type' => 'text',
							'std' => '',
							'des' => 'The viewport width at which the menu will collapse to mobile menu. Do not include units. By default 991',
						),
					),
				),
				'images' => array(
					'text' => 'Images',
					'config' => array(
						'image-heading' => array(
							'text' => __('Images Settings','wezmenu'),
							'type' => 'heading',
						),
						'image-size' => array(
							'text' => __('Image Size','wezmenu'),
							'type' => 'select',
							'std' => 'none',
							'options' => wezmenu_get_image_size(1)
						),
						'image-width' => array(
							'text' => __('Image Width','wezmenu'),
							'type' => 'text',
							'std' => '',
							'des' => 'The width attribute value for item images! Do not include units',
						),
						'image-height' => array(
							'text' => __('Image Height','wezmenu'),
							'type' => 'text',
							'std' => '',
							'des' => 'The height attribute value for item images! Do not include units',
						),
					),
				),
				'other' => array(
					'text' => 'Other',
					'config' => array(
						'other-heading' => array(
							'text' => __('Other Settings','wezmenu'),
							'type' => 'heading',
						),
						'menu-bar-align' => array(
							'text' => __('Menu Bar Align','wezmenu'),
							'type' => 'select',
							'std' => 'wez-menubar-none',
							'options' => array(
								'wez-menubar-none' => __('None','wezmenu'),
								'wez-menubar-left' => __('Left','wezmenu'),
								'wez-menubar-right' => __('Right','wezmenu'),
								'wez-menubar-center' => __('Center','wezmenu'),
							)
						),
						'transition' => array(
							'text' => __('Select Menu Transition','wezmenu'),
							'type' => 'select',
							'std' => 'none',
							'options' => wezmenu_get_transition()
						),
						'transition-duration' => array(
							'text' => __('Transition Duration','wezmenu'),
							'type' => 'text',
							'std' => '',
							'des' => 'The transition duration. By default 0.5s',
						),
					),
				),
			);
			add_action( 'admin_menu', array($this, 'admin_menu') );
			add_action( 'wp_ajax_wezmenu_setting_create', array($this, 'wezmenu_setting_create') );
			add_action( 'wp_ajax_wezmenu_setting_save', array($this, 'wezmenu_setting_save') );
			add_action( 'wp_ajax_wezmenu_delete_setting', array($this, 'wezmenu_delete_setting') );
		}

		function get_setting_defaults() {
			$setting_default = array();
			foreach($this->setting_options as $setting_key => $setting_value) {
				foreach($setting_value['config'] as $key => $value) {
					if ($value['type'] != 'heading') {
						if ($value['type'] == 'list-checkbox') {
							$setting_default[$key] = array();
						}
						else {
							$setting_default[$key] = $value['std'];
						}
					}
					else {
						$setting_default[$key] = '';
					}

				}
			}
			return $setting_default;
		}

		function admin_menu() {
			add_submenu_page(
				'themes.php',
				__('WezMenu Settings','wezmenu'),
				__('WezMenu Settings','wezmenu'),
				'manage_options',
				'wezmenu-settings',
				array($this, 'control_panel')
			);
		}

		function control_panel() {
			if (isset( $_POST['do'])) {
				echo '<h1>POST</h1>';
			}
			if( !isset( $_GET['do'] ) ){
				$this->plugin_page();
			}
			else {
				switch ($_GET['do']) {
					case 'widget':
						$this->widget_manager();
						break;
					default:
						$this->plugin_page();
						break;
				}
			}

		}

		function plugin_page() {
			$current_menu = '';
			$current_menu_separate = '';
			if (isset($_GET['menu']) && !empty($_GET['menu'])) {
				$current_menu_separate = '_';
				$current_menu = $_GET['menu'];
				unset($this->setting_options['settings']);
				unset($this->setting_options['integration']);
			}

			$setting_default = $this->get_setting_defaults();

			$settings = get_option(WEZMENU_SETTING_OPTIONS .  $current_menu_separate . $current_menu);
			if (isset($settings) && $settings) {
				$settings = array_merge($setting_default, $settings);
			}
			else {
				$settings = $setting_default;
			}

			$terms = get_terms( 'nav_menu', array( 'hide_empty' => false ));
			$setting_menus = array();
			$setting_not_create = array();
			foreach ($terms as $term_value) {
				if (get_option(WEZMENU_SETTING_OPTIONS . '_' . $term_value->slug) !== false) {
					$setting_menus[] = $term_value->slug;
				}
				else {
					$setting_not_create[$term_value->slug] = $term_value->name;
				}
			}

			?>
			<div class="wezmenu-settings">
				<h2>
					<a class="tab <?php echo ($current_menu == '' ? 'active' : '') ?>" href="themes.php?page=wezmenu-settings"><strong><?php _e('WezMenu','wezmenu') ?></strong> <?php _e('Setting','wezmenu') ?></a>
					<?php foreach ($setting_menus as $setting_menu): ?>
						<a class="tab <?php echo ($current_menu == $setting_menu ? 'active' : '') ?>" href="themes.php?page=wezmenu-settings&menu=<?php echo $setting_menu ?>"><strong><?php echo ($setting_menu); ?></strong> <?php _e('Setting','wezmenu') ?></a>
					<?php endforeach; ?>
					<a class="tab" href="themes.php?page=wezmenu-settings&do=widget"><strong><?php _e('WezMenu','wezmenu') ?></strong> <?php _e('Widget Manager','wezmenu') ?></a>
					<button id="setting-add-menu" type="button" class="button button-primary wez-fr"><?php _e('Add Menu Setting','wezmenu') ?></button>
				</h2>
				<form method="post" action="themes.php?page=wezmenu-settings" novalidate="novalidate" id="wezmenu_settings">
					<div class="wezmenu-settings-inner">
						<ul class="setting-left">
							<?php $is_first = true;?>
							<?php foreach($this->setting_options as $setting_key => $setting_value): ?>
								<li class="<?php echo ($is_first ? 'active':'') ?>" data-ref="<?php echo esc_attr($setting_key)?>"><?php echo esc_html($setting_value['text']) ?></li>
								<?php $is_first = false;?>
							<?php endforeach; ?>
						</ul>
						<div class="setting-right">
							<?php $is_first = true;?>
							<?php foreach($this->setting_options as $setting_key => $setting_value): ?>
								<table class="form-table <?php echo ($is_first ? 'active':'') ?>" data-ref="<?php echo esc_attr($setting_key)?>">
									<tbody>
									<?php foreach($setting_value['config'] as $key => $item): ?>
										<?php wezmenu_bind_setting_item($key, $item, $settings[$key]);?>
									<?php endforeach;?>
									</tbody>
								</table>
								<?php $is_first = false;?>
							<?php endforeach; ?>
						</div>
						<div style="clear: both"></div>
					</div>
					<p class="submit">
						<input type="hidden" name="action" value="wezmenu_setting_save" />
						<button type="button" id="wezmenu-save-setting" class="button button-primary"><i class="fa fa-save"></i> <?php echo __('Save Changes','wezmenu')?></button>
						<?php if (!empty($current_menu)): ?>
							<input id="wezmenu_menu_slug" type="hidden" name="menu_slug" value="<?php echo esc_attr($current_menu) ?>"/>
							<button type="button" class="button button-primary" id="wezmenu-delete-setting"><i class="fa fa-remove"></i> <?php echo __('Delete Settings','wezmenu')?></button>
						<?php endif;?>
					</p>
				</form>
				<div class="wez-popup" id="wezmenu-setting-popup">
					<div class="wez-popup-inner">
						<h3><?php _e('Select Menu for your new settings','wezmenu') ?> <i id="setting-add-menu-close" class="fa fa-close"></i></h3>
						<div class="wez-popup-select">
							<select id="wezmenu-select-create">
								<?php foreach($setting_not_create as $setting_not_create_key => $setting_not_create_value): ?>
									<option value="<?php echo esc_attr($setting_not_create_key)?>"><?php echo esc_html($setting_not_create_value)?></option>
								<?php endforeach; ?>
							</select>
							<button id="wezmenu-create-button" type="button"><?php _e('Create Menu Setting','wezmenu') ?></button>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		function widget_manager() {
			$widgets = get_option(WEZMENU_MENU_ITEM_WIDGET_AREAS, array());
			$sidebars = get_option('sidebars_widgets');
			if (isset($_POST['submit']) && ($_POST['submit'])) {
				if (isset($_POST['widget_area_id'])) {
					$widget_area_id = $_POST['widget_area_id'];
					foreach( $widget_area_id as $id ){
						if( isset( $widgets[$id] ) ){
							unset( $widgets[$id] );
						}
						if (isset($sidebars) & is_array($sidebars) && isset($sidebars[WEZMENU_MENU_WIDGET_AREAS_ID . $id])) {
							unset($sidebars[WEZMENU_MENU_WIDGET_AREAS_ID . $id]);
						}
					}
					update_option('sidebars_widgets', $sidebars);
					update_option( WEZMENU_MENU_ITEM_WIDGET_AREAS , $widgets );
				}
			}

			$terms = get_terms( 'nav_menu', array( 'hide_empty' => false ));
			$setting_menus = array();
			foreach ($terms as $term_value) {
				if (get_option(WEZMENU_SETTING_OPTIONS . '_' . $term_value->slug) !== false) {
					$setting_menus[] = $term_value->slug;
				}
			}
			?>
			<div class="wezmenu-settings">
				<h2>
					<a class="tab" href="themes.php?page=wezmenu-settings"><strong><?php _e('WezMenu','wezmenu') ?></strong> <?php _e('Setting','wezmenu') ?></a>
					<?php foreach ($setting_menus as $setting_menu): ?>
						<a class="tab" href="themes.php?page=wezmenu-settings&menu=<?php echo $setting_menu ?>"><strong><?php echo ($setting_menu); ?></strong> <?php _e('Setting','wezmenu') ?></a>
					<?php endforeach; ?>
					<a class="tab active" href="themes.php?page=wezmenu-settings&do=widget"><strong><?php _e('WezMenu','wezmenu') ?></strong> <?php _e('Widget Manager','wezmenu') ?></a>
				</h2>
				<form action="themes.php?page=wezmenu-settings&do=widget" method="post">
					<table class="form-table">
						<tbody>
							<?php foreach( $widgets as $menu_item_id => $widget_title ):?>
								<tr>
									<td class="w20px">
										<fieldset>
											<label for="widget_area_id_<?php echo esc_attr($menu_item_id); ?>">
												<input id="widget_area_id_<?php echo esc_attr($menu_item_id); ?>" name="widget_area_id[]" type="checkbox" value="<?php echo esc_attr($menu_item_id); ?>" />
											</label>
										</fieldset>
									</td>
									<td><?php echo esc_html($widget_title) . __(' [Menu Item ', 'wezmenu') . esc_html($menu_item_id) .']'; ?></td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
					<p><?php _e('Choose which Custom Widget Areas to delete', 'wezmenu') ?></p>
					<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __('Delete Widget Areas','wezmenu')?>"></p>
				</form>
			</div>
			<?php
		}

		function generate_css_file($option_key) {
			require_once WEZMENU_DIR . 'inc/generate-less/Less.php';
			$setting_default = $this->get_setting_defaults();

			$settings = get_option(WEZMENU_SETTING_OPTIONS . $option_key);
			if (isset($settings) && $settings) {
				$settings = array_merge($setting_default, $settings);
			}
			else {
				$settings = $setting_default;
			}
			try {
				$regex = array(
					"`^([\t\s]+)`ism"                       => '',
					"`^\/\*(.+?)\*\/`ism"                   => "",
					"`([\n\A;]+)\/\*(.+?)\*\/`ism"          => "$1",
					"`([\n\A;\s]+)//(.+?)[\n\r]`ism"        => "$1\n",
					"`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism" => "\n"
				);
				$css = '';
				$responsive_breakpoint = 991;
				if (isset($settings['setting-responsive-breakpoint']) && !empty($settings['setting-responsive-breakpoint']) && is_numeric($settings['setting-responsive-breakpoint'])) {
					$responsive_breakpoint = $settings['setting-responsive-breakpoint'];
				}

				$animation_duration = '.5s';
				if (isset($settings['transition-duration']) && !empty($settings['transition-duration'])) {
					$animation_duration = $settings['transition-duration'];
				}

				$css .= '@wez_nav_menu_type:wez-nav-menu-horizontal;';
				$css .= '@wez_nav_menu_slug:' . (empty($option_key) ? '' : 'wez-nav-menu' . $option_key) . ';';
				$css .= '@wez_nav_menu_dot:'. (empty($option_key) ? '': '.') .';';
				$css .= '@responsive_breakpoint:'. $responsive_breakpoint . 'px;';
				$css .= '@animation_duration:' . $animation_duration . ';';

				WP_Filesystem();
				global $wp_filesystem;
				$options = array( 'compress'=>true );
				$parser = new Less_Parser($options);
				$parser->parse($css);
				$parser->parseFile(WEZMENU_DIR . 'assets/css/style.less');
				$css = $parser->getCss();
				$css   = preg_replace( array_keys( $regex ), $regex, $css );
				$wp_filesystem->put_contents( WEZMENU_DIR .   'assets/css/style' . $option_key . '.css', $css, FS_CHMOD_FILE);
			}
			catch (Exception $e) {
				?>
				<div class="error">
					<?php echo __('Caught exception:','') . esc_html($e->getMessage()) ?>
				</div>
				<?php
			}
		}
		function wezmenu_setting_create() {
			$error_result = array(
				'code' => '-1',
				'message' => __('Create menu settings fail','wezmenu'),
			);

			$menu_slug = '';
			if (isset($_POST['menu_slug'])) {
				$menu_slug = $_POST['menu_slug'];
			}

			if (empty($menu_slug)) {
				echo json_encode($error_result);
				die();
			}

			if (get_option(WEZMENU_SETTING_OPTIONS . '_' . $menu_slug) !== false) {
				echo json_encode($error_result);
				die();
			}

			$menu_ops = array();
			update_option(WEZMENU_SETTING_OPTIONS . '_' . $menu_slug, $menu_ops);

			$error_result = array(
				'code' => '1',
				'message' => '',
			);
			echo json_encode($error_result);
			die();
		}
		function wezmenu_setting_save(){
			$error_result = array(
				'code' => '-1',
				'message' => __('Create menu settings fail','wezmenu'),
			);

			try{
				$current_menu = '';
				$current_menu_separate = '';
				if (isset($_POST['menu_slug']) && !empty($_POST['menu_slug'])) {
					$current_menu_separate = '_';
					$current_menu = $_POST['menu_slug'];
					unset($this->setting_options['settings']);
					unset($this->setting_options['integration']);
				}

				$setting_default = $this->get_setting_defaults();

				$settings = array();
				if (isset($_POST[WEZMENU_SETTING_OPTIONS])) {
					$settings = $_POST[WEZMENU_SETTING_OPTIONS];
				}
				foreach($this->setting_options as $setting_key => $setting_value) {
					foreach($setting_value['config'] as $key => $value) {
						if (!isset($settings[$key]) && ($value['type'] == 'checkbox')) {
							$settings[$key] = '';
						}
						if (!isset($settings[$key]) && ($value['type'] == 'list-checkbox')) {
							$settings[$key] = array();
						}
					}
				}

				$settings = array_merge($setting_default, $settings);

				update_option(WEZMENU_SETTING_OPTIONS .  $current_menu_separate . $current_menu, $settings);

				$this->generate_css_file($current_menu_separate . $current_menu);

				$error_result['code'] = 1;
				$error_result['message'] = '';
				echo json_encode($error_result);
				die();
			}
			catch (Exception $e) {
				$error_result['message'] = $e->getMessage();
			}


			echo json_encode($error_result);
			die();
		}
		function wezmenu_delete_setting() {
			$error_result = array(
				'code' => '-1',
				'message' => __('Delete menu settings fail','wezmenu'),
			);

			if (isset($_POST['menu_slug']) && !empty($_POST['menu_slug'])) {
				$current_menu_separate = '_';
				$current_menu = $_POST['menu_slug'];
				delete_option(WEZMENU_SETTING_OPTIONS .  $current_menu_separate . $current_menu);

				try {
					WP_Filesystem();
					global $wp_filesystem;

					$file_name = WEZMENU_DIR .   'assets/css/style' .  $current_menu_separate . $current_menu . '.css';
					if(!$wp_filesystem->is_dir($file_name)) {
						$wp_filesystem->delete($file_name);
					}
				}
				catch (Exception $e) {}

				$error_result['code'] = '1';
				$error_result['message'] = '';
			}

			echo json_encode($error_result);
			die();
		}
	}
endif;
if( !function_exists( '_WEZMENU_SETTING' ) ){
	add_action('init', '_WEZMENU_SETTING');
	function _WEZMENU_SETTING() {
		return WezMenu_Setting_Options::init();
	}
}