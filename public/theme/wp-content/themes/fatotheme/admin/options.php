<?php
/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 **/
if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }
        
        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field   set with compiler=>true is changed.

         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            $sections[] = array(
                'title' => esc_html__('Section via hook', 'fatotheme'),
                'desc'  => wp_kses_post('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>'),
                'icon'  => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = wp_kses_post('Customize &#8220;'.$this->theme->display('Name').'&#8221;');
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo esc_url(wp_customize_url()); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'fatotheme'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'fatotheme'); ?>" />
                <?php endif; ?>

                <h4><?php echo wp_kses_post($this->theme->display('Name')); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php echo wp_kses_post('By '.$this->theme->display('Author')); ?></li>
                        <li><?php echo wp_kses_post('Version '.$this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . esc_html__('Tags', 'fatotheme') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo wp_kses_post($this->theme->display('Description')); ?></p>
            <?php
            if ($this->theme->parent()) {
               echo wp_kses_post('<p class="howto">This <a href="http://codex.wordpress.org/Child_Themes">child theme</a> requires its parent theme.</p>'); 
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(plugin_dir_path(__FILE__) . '/info-html.html')) {
                Redux_Functions::initWpFilesystem();
                
                global $wp_filesystem;

                $sampleHTML = $wp_filesystem->get_contents(plugin_dir_path(__FILE__) . '/info-html.html');
            }

            $imagepath = get_template_directory_uri().'/assets/images/';

            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'title'     => esc_html__('General Settings', 'fatotheme'),
                'desc'      => '',
                'icon'      => 'el-icon-home',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(
                    array(
                        'id'        => 'logo_type',
                        'type'      => 'select',
                        'title'     => esc_html__('Layout Type', 'fatotheme'),
                        'desc'      => esc_html__('Choose Your Logo Type.', 'fatotheme'),
                        'options'   => array(
                            'image' => 'Image', 
                            'text' => 'Text'
                        ),
                        'default'   => 'image'
                    ),
                    array(
                        'id'        => 'logo_image',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => esc_html__('Logo Image', 'fatotheme'),
                        'compiler'  => 'true',
                        'required'  => array('logo_type', '=', 'image'),
                        'default'   => array('url' => $imagepath. 'logo.png')
                    ),
                    array(
                        'id'        => 'logo_height',
                        'type'      => 'text',
                        'title'     => esc_html__('Logo Height', 'fatotheme'),
                        'required'  => array('logo_type', '=', 'image'),
                        'validate'  => 'numeric',
                        'default'   => '58',
                    ),
                    array(
                        'id'        => 'logo_sticky_height',
                        'type'      => 'text',
                        'title'     => esc_html__('Logo Sticky Height', 'fatotheme'),
                        'required'  => array('logo_type', '=', 'image'),
                        'validate'  => 'numeric',
                        'default'   => '58',
                    ),
                    array(
                        'id'        => 'logo_text',
                        'type'      => 'text',
                        'title'     => esc_html__('Logo Text', 'fatotheme'),
                        'required'  => array('logo_type', '=', 'text'),
                        'default'   => esc_html__("FATO", 'fatotheme')
                    ),
                    array(
                        'id'          => 'logo-font',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Logo Font', 'fatotheme'),
                        'google'      => true, 
                        'font-backup' => false,
                        'font-style'  => true,
                        'text-align'  => false,
                        'line-height' => true,
                        'color'       => true,
                        'font-size'   => true,
                        'units'       => 'px',
                        'font_family_clear' => true,
                        'required'  => array('logo_type', '=', 'text'),
                        'output' => array('.logo-box .logo a'),
                        'default' => array(
                            'color' => '#333333',
                            'font-size' => '36px',
                            'font-weight' => '400',
                            'font-family' => 'Poppins'
                        )
                    ),
                    array(
                        'id'        => '404_text',
                        'type'      => 'editor',
                        'title'     => esc_html__('404 text', 'fatotheme'),
                        'subtitle'  => esc_html__('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'fatotheme'),
                        'default'   => esc_html__("This is Not The Web Page You are Looking For", 'fatotheme'),
                    ),
                    array(
                        'id'        => 'underconstruction_time',
                        'type'      => 'date',
                        'title'     => esc_html__('Date', 'fatotheme'),
                        'subtitle'  => esc_html__('Date to release!', 'fatotheme'),
                        'default'   => "12/01/2016",
                    ),
                    array(
                        'id'        => 'is-effect-scroll',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable effect scroll', 'fatotheme'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'is-back-to-top',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable back to top button', 'fatotheme'),
                        'default'   => true
                    ),
                ),
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-website',
                'title'     => esc_html__('Promo Popup', 'fatotheme'),
                'fields'    => array(
                    array(
                        'id'        => 'promo_popup',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Promo Popup', 'fatotheme'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'promo_popup_width',
                        'type'      => 'text',
                        'title'     => esc_html__('Promo Popup Width', 'fatotheme'),
                        'required'  => array('promo_popup', '=', '1'),
                        'desc'   => esc_html__("Promo Popup Width", 'fatotheme'),
                        'default'   => '970'
                    ),
                    array(
                        'id'        => 'promo_popup_height',
                        'type'      => 'text',
                        'title'     => esc_html__('Promo Popup Height', 'fatotheme'),
                        'required'  => array('promo_popup', '=', '1'),
                        'desc'   => esc_html__("Promo Popup Height", 'fatotheme'),
                        'default'   => '541'
                    ),
                    array(
                        'id'        => 'promo_popup_background',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => esc_html__('Promo Popup Background', 'fatotheme'),
                        'compiler'  => 'true',
                        'required'  => array('promo_popup', '=', '1'),
                        'default'   => array('url' => $imagepath. 'promopopup-bg.jpg')
                    ),
                    array(
                        'id'        => 'promo_popup_content',
                        'type'      => 'textarea',
                        'required'  => array('promo_popup', '=', '1'),
                        'title'     => esc_html__('Promo Popup Content', 'fatotheme'),
                        'default'   => '<h2>GET OUR EMAIL LETTER</h2><p class="primary-color">Subscribe to the Futurelife mailing list to receive updates on new arrivals, special offers and other discount information.</p>[contact-form-7 id="602" title="Get Letter"]', 'fatotheme'
                    ),
                )
            );

            $path_image = get_template_directory_uri() .'/admin/assets/images/';
            
            $this->sections[] = array(
                'icon'      => 'el-icon-website',
                'title'     => esc_html__('Styling Options', 'fatotheme'),
                'fields'    => array(
                    array(
                        'id'        => 'enable_sswitcher',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show style switcher', 'fatotheme'),
                        'subtitle'     => esc_html__('The style switcher is only for preview on front-end', 'fatotheme'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'style_layout',
                        'type'      => 'button_set',
                        'title'     => esc_html__('Layout style', 'fatotheme'),
                        'desc'      => esc_html__('Choose your layout style.', 'fatotheme'),
                        'options'   => array(
                            'wide' => 'Wide', 
                            'boxed' => 'Boxed', 
                        ),
                        'default'   => 'wide'
                    ),
                    array(
                        'id'        => 'style_body_background',
                        'type'      => 'background',
                        'output'    => array('body'),
                        'title'     => esc_html__('Body Background', 'fatotheme')
                    ),
                    array(
                        'id'        => 'style_bodybox_background',
                        'type'      => 'background',
                        'output'    => array('body.boxed'),
                        'required'  => array('style_layout', '=', 'boxed'),
                        'title'     => esc_html__('Body Boxed Background', 'fatotheme')
                    ),
                    array(
                        'id'        => 'style_box_background',
                        'type'      => 'background',
                        'output'    => array('body.boxed .lane-wrapper'),
                        'required'  => array('style_layout', '=', 'boxed'),
                        'title'     => esc_html__('Boxed Area Background', 'fatotheme')
                    ),
                    array(
                        'id'       => 'body_text_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Body text color', 'fatotheme'), 
                        'default'  => '#747474',
                        'validate' => 'color',
                        'output'    => array('body'),
                        'transparent' => false,
                        'subtitle'  => esc_html__('Select your themes alternative text color scheme.', 'fatotheme'),
                    ),
                    array(
                        'id'        => 'style_main_color',
                        'type'      => 'image_select',
                        'compiler'  => true,
                        'title'     => esc_html__('Main color', 'fatotheme'),
                        'options'   => array(
                            '#9ed9be' => array( 'img' => $path_image . '06.jpg'),
                            '#dd4e4e' => array( 'img' => $path_image . '01.jpg'),
                            '#3598db' => array( 'img' => $path_image . '02.jpg'),
                            '#c2a772' => array( 'img' => $path_image . '03.jpg'),
                            '#36c877' => array( 'img' => $path_image . '04.jpg'),
                            '#e99b1f' => array( 'img' => $path_image . '05.jpg'),
                            '#a57bcd' => array( 'img' => $path_image . '07.jpg'),
                            '#e9bf1d' => array( 'img' => $path_image . '08.jpg'),
                            'custom' => array( 'img' => $path_image . '09.jpg'),
                        ),
                        'default'   => 'custom'
                    ),
                    array(
                        'id'       => 'style_main_custom',
                        'type'     => 'color',
                        'title'    => esc_html__('Main color custom', 'fatotheme'), 
                        'default'  => '#96b76c',
                        'validate' => 'color',
                        'transparent' => false,
                        'required'  => array('style_main_color', '=', 'custom'),
                        'subtitle'  => esc_html__('Select your themes alternative color scheme.', 'fatotheme'),
                    ),
                    array(
                        'id'    => 'opt-divide',
                        'type'  => 'divide'
                    ),
                    array(
                        'id'        => 'custom-css',
                        'type'      => 'ace_editor',
                        'title'     => esc_html__('CSS code', 'fatotheme'),
                        'subtitle'  => esc_html__('Paste your CSS code here.', 'fatotheme'),
                        'mode'      => 'css',
                        'theme'     => 'monokai',
                        'desc'      => 'Possible modes can be found at ace(dot)c9(dot)io.',
                        'default'   => ""
                    ),
                    array(
                        'id'        => 'custom-js',
                        'type'      => 'ace_editor',
                        'title'     => esc_html__('JS code', 'fatotheme'),
                        'subtitle'  => esc_html__('Paste your JS code here.', 'fatotheme'),
                        'mode'      => 'js',
                        'theme'     => 'monokai',
                        'desc'      => 'Possible modes can be found at ace(dot)c9(dot)io.',
                        'default'   => ""
                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-font',
                'title'     => esc_html__('Fonts Options', 'fatotheme'),
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id'          => 'font-main',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Main font', 'fatotheme'),
                        'google'      => true, 
                        'font-backup' => false,
                        'font-style'  => true,
                        'text-align'  => false,
                        'line-height' => false,
                        'color'       => false,
                        'font-size'   => true,
                        'units'       => 'px',
                        'font_family_clear' => true,
                        'output' => array('body'),
                        'default' => array(
                            'font-size' => '14px',
                            'font-weight' => '400',
                            'font-family' => 'Poppins'
                        )
                    ),
                    array(
                        'id'          => 'font-mainnav',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Main menu font', 'fatotheme'),
                        'google'      => true, 
                        'font-backup' => false,
                        'font-style'  => false,
                        'text-align'  => false,
                        'line-height' => false,
                        'color'       => false,
                        'font-size'   => true,
                        'units'       => 'px',
                        'font_family_clear' => true,
                        'output' => array('.wez-nav-menu','.wez-nav-menu.wez-nav-menu-horizontal > li > a'),
                        'default' => array(
                            'font-size' => '14px',
                            'font-weight' => '400',
                            'font-family' => 'Poppins'
                        )
                    ),
                    array(
                        'id'          => 'font-h1',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading 1 (H1)', 'fatotheme'),
                        'google'      => true, 
                        'font-backup' => false,
                        'font-style'  => false,
                        'text-align'  => false,
                        'line-height' => false,
                        'color'       => false,
                        'font-size'   => true,
                        'units'       => 'px',
                        'font_family_clear' => true,
                        'output' => array('h1'),
                        'default' => array(
                            'font-size' => '36px',
                            'font-weight' => '400',
                            'font-family' => 'Poppins'
                        )
                    ),
                    array(
                        'id'          => 'font-h2',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading 2 (H2)', 'fatotheme'),
                        'google'      => true, 
                        'font-backup' => false,
                        'font-style'  => false,
                        'text-align'  => false,
                        'line-height' => false,
                        'color'       => false,
                        'font-size'   => true,
                        'units'       => 'px',
                        'font_family_clear' => true,
                        'output' => array('h2'),
                        'default' => array(
                            'font-size' => '30px',
                            'font-weight' => '400',
                            'font-family' => 'Poppins'
                        )
                    ),
                    array(
                        'id'          => 'font-h3',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading 3 (H3)', 'fatotheme'),
                        'google'      => true, 
                        'font-backup' => false,
                        'font-style'  => false,
                        'text-align'  => false,
                        'line-height' => false,
                        'color'       => false,
                        'font-size'   => true,
                        'units'       => 'px',
                        'font_family_clear' => true,
                        'output' => array('h3'),
                        'default' => array(
                            'font-size' => '24px',
                            'font-weight' => '400',
                            'font-family' => 'Poppins'
                        )
                    ),
                    array(
                        'id'          => 'font-h4',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading 4 (H4)', 'fatotheme'),
                        'google'      => true, 
                        'font-backup' => false,
                        'font-style'  => false,
                        'text-align'  => false,
                        'line-height' => false,
                        'color'       => false,
                        'font-size'   => true,
                        'units'       => 'px',
                        'font_family_clear' => true,
                        'output' => array('h4'),
                        'default' => array(
                            'font-size' => '18px',
                            'font-weight' => '400',
                            'font-family' => 'Poppins'
                        )
                    ),
                    array(
                        'id'          => 'font-h5',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading 5 (H5)', 'fatotheme'),
                        'google'      => true, 
                        'font-backup' => false,
                        'font-style'  => false,
                        'text-align'  => false,
                        'line-height' => false,
                        'color'       => false,
                        'font-size'   => true,
                        'units'       => 'px',
                        'font_family_clear' => true,
                        'output' => array('h5'),
                        'default' => array(
                            'font-size' => '14px',
                            'font-weight' => '400',
                            'font-family' => 'Poppins'
                        )
                    ),
                    array(
                        'id'          => 'font-h6',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading 6 (H6)', 'fatotheme'),
                        'google'      => true, 
                        'font-backup' => false,
                        'font-style'  => false,
                        'text-align'  => false,
                        'line-height' => false,
                        'color'       => false,
                        'font-size'   => true,
                        'units'       => 'px',
                        'font_family_clear' => true,
                        'output' => array('h6'),
                        'default' => array(
                            'font-size' => '12px',
                            'font-weight' => '400',
                            'font-family' => 'Poppins'
                        )
                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-qrcode',
                'title'     => esc_html__('Header Settings', 'fatotheme'),
                'fields'    => array(
                    array(
                        'id'        => 'header_is_sticky',
                        'type'      => 'switch',
                        'title'     => esc_html__('Header Sticky', 'fatotheme'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'header',
                        'type'      => 'select',
                        'title'     => esc_html__('Header Layout', 'fatotheme'),
                        'options'   => array(
                            'global'   => esc_html__( 'Use Global', 'fatotheme' ),
                            '1'   => esc_html__( 'Style 1', 'fatotheme' ),
                            '2'   => esc_html__( 'Style 2', 'fatotheme' ),
                            '3'   => esc_html__( 'Style 3', 'fatotheme' ),
                            '4'   => esc_html__( 'Style 4', 'fatotheme' )
                        ),
                        'default'   => 'global'
                    ),
                    array(
                        'id'        => 'header_absolute',
                        'type'      => 'switch',
                        'title'     => esc_html__('Header Absolute', 'fatotheme'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'header_topbar',
                        'type'      => 'switch',
                        'title'     => esc_html__('Header Topbar', 'fatotheme'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'header_topbar_text',
                        'type'      => 'editor',
                        'required'  => array('header_topbar', '=', '1'),
                        'title'     => esc_html__('Header 1 Topbar Text', 'fatotheme'),
                        'default'   => '<span class="btn btn-rounded">Use voucher sale 25%</span><span>Best discounts and voucher codes for online stores</span>',
                        'subtitle'      => 'For Header style only.'
                    ),
                    array(
                        'id'        => 'page_title_fullwidth',
                        'type'      => 'switch',
                        'title'     => esc_html__('Page Title Full Width', 'fatotheme'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'page_title',
                        'type'      => 'switch',
                        'title'     => esc_html__('Page Title', 'fatotheme'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'page_title_bg',
                        'type'      => 'media',
                        'url'       => true,
                        'required'  => array('page_title', '=', '1'),
                        'title'     => esc_html__('Page Title Background', 'fatotheme'),
                        'compiler'  => 'true',
                        'default'   => array('url' => $imagepath. 'header-page-bg.jpg')
                    ),
                    array(
                        'id'        => 'page_title_align',
                        'type'      => 'select',
                        'title'     => esc_html__('Page Title Align', 'fatotheme'),
                        'options'   => array(
                            'text-center'   => esc_html__( 'Align Center', 'fatotheme' ),
                            'text-left'   => esc_html__( 'Align Left', 'fatotheme' ),
                            'text-right'   => esc_html__( 'Align Right', 'fatotheme' )
                        ),
                        'required'  => array('page_title', '=', '1'),
                        'default'   => 'text-center'
                    ),
                    array(
                        'id'          => 'page_title_font',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Page Title Font', 'fatotheme'),
                        'google'      => true, 
                        'font-backup' => false,
                        'font-style'  => false,
                        'text-align'  => false,
                        'line-height' => false,
                        'color'       => false,
                        'font-size'   => true,
                        'units'       => 'px',
                        'font_family_clear' => true,
                        'required'  => array('page_title', '=', '1'),
                        'output' => array('.page-title h1'),
                        'default' => array(
                            'font-size' => '40px',
                            'font-weight' => '700',
                            'font-family' => 'Arial, Helvetica, sans-serif'
                        )
                    ),
                    array(
                        'id'       => 'page_title_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Page Title Color', 'fatotheme'), 
                        'default'  => '#ffffff',
                        'validate' => 'color',
                        'transparent' => false,
                        'output'    => array('.page-title-container'),
                        'required'  => array('page_title', '=', '1'),
                        'subtitle'  => esc_html__('Select your themes alternative page heading text color.', 'fatotheme'),
                    ),
                    array(
                        'id'        => 'page_breadcrumbs',
                        'type'      => 'switch',
                        'title'     => esc_html__('Page Breadcrumbs', 'fatotheme'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'page_breadcrumbs_align',
                        'type'      => 'select',
                        'title'     => esc_html__('Page Breadcrumbs Align', 'fatotheme'),
                        'options'   => array(
                            'text-center'   => esc_html__( 'Align Center', 'fatotheme' ),
                            'text-left'   => esc_html__( 'Align Left', 'fatotheme' ),
                            'text-right'   => esc_html__( 'Align Right', 'fatotheme' )
                        ),
                        'required'  => array('page_breadcrumbs', '=', '1'),
                        'default'   => 'text-center'
                    ),
                    array(
                        'id'        => 'header_is_switch_language',
                        'type'      => 'switch',
                        'title'     => esc_html__('Switch Languages', 'fatotheme'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'header_is_switch_currency',
                        'type'      => 'switch',
                        'title'     => esc_html__('Switch Currency', 'fatotheme'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'header_is_cart',
                        'type'      => 'switch',
                        'title'     => esc_html__('Header Cart', 'fatotheme'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'header_is_search',
                        'type'      => 'switch',
                        'title'     => esc_html__('Header Search', 'fatotheme'),
                        'default'   => true
                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-website',
                'title'     => esc_html__('Sidebar Settings', 'fatotheme'),
                'fields'    => array(
                    array(
                        'id'        => 'sidebar-on-tablet',
                        'type'      => 'switch',
                        'title'     => esc_html__('Sidebar on tablet', 'fatotheme'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'sidebar-on-mobile',
                        'type'      => 'switch',
                        'title'     => esc_html__('Sidebar on mobile', 'fatotheme'),
                        'default'   => false
                    )
                )
            );

            $footers_type = get_posts( array('posts_per_page'=>-1,'post_type'=>'footer') );
            $footers_option = array();
            foreach ($footers_type as $key => $value) {
                $footers_option[$value->ID] = $value->post_title;
            }
            
            $this->sections[] = array(
                'icon'      => 'el-icon-list-alt',
                'title'     => esc_html__('Footer Settings', 'fatotheme'),
                'fields'    => array(
                    array(
                        'id'        => 'custom_footer_background',
                        'type'      => 'switch',
                        'title'     => esc_html__('Custom footer background', 'fatotheme'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'style_footer_background',
                        'type'      => 'background',
                        'output'    => array('.clear-footer .vc_section','.clear-footer .footer-blocks'),
                        'required'  => array('custom_footer_background', '=', '1'),
                        'title'     => esc_html__('Footer background', 'fatotheme'),
                        'default' => array(
                            'background-color'=>'#171717'
                        )
                    ),
                    array(
                        'id'        => 'style_copyright_background',
                        'type'      => 'background',
                        'output'    => array('.footer-copyright'),
                        'required'  => array('custom_footer_background', '=', '1'),
                        'title'     => esc_html__('Copyright background', 'fatotheme'),
                        'default' => array(
                            'background-color'=>'#000000'
                        )
                    ),
                    array(
                        'id'       => 'footer_text_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Footer text color', 'fatotheme'), 
                        'default'  => '#454545',
                        'validate' => 'color',
                        'transparent' => false,
                        'output'    => array('.clear-footer .vc_section','.clear-footer .footer-blocks'),
                        'required'  => array('custom_footer_background', '=', '1'),
                        'subtitle'  => esc_html__('Select your themes alternative footer text color.', 'fatotheme'),
                    ),
                    array(
                        'id'        => 'is-footer-custom',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable footer customize', 'fatotheme'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'footer_id',
                        'type'      => 'select',
                        'required'  => array('is-footer-custom', '=', '1'),
                        'title'     => esc_html__('Footer item', 'fatotheme'),
                        'options'   => $footers_option,
                        'default'   => ''
                    ),
                    array(
                        'id'        => 'footer-copyright',
                        'type'      => 'editor',
                        'title'     => esc_html__('Footer copyright', 'fatotheme'),
                        'subtitle'  => esc_html__('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'fatotheme'),
                        'default'   => '&copy; 2017 Fato. All Rights Reserved. Designed with love by Bily',
                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-bold',
                'title'     => esc_html__('Blog Settings', 'fatotheme'),
                'fields'    => array(
                    array(
                        'id'        => 'blog-layout',
                        'type'      => 'image_select',
                        'title'     => esc_html__('Images Option For Layout', 'fatotheme'),
                        'subtitle'  => esc_html__('No validation can be done on this field type', 'fatotheme'),
                        'desc'      => esc_html__('This uses some of the built in images, you can use them for layout options.', 'fatotheme'),
                        //Must provide key => value(array:title|img) pairs for radio options
                        'options'   => array(
                            '1' => array('alt' => '1 Column',        'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column Left',   'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            '3' => array('alt' => '2 Column Right',  'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                            '4' => array('alt' => '3 Column Middle', 'img' => ReduxFramework::$_url . 'assets/img/3cm.png'),
                            '5' => array('alt' => '3 Column Left',   'img' => ReduxFramework::$_url . 'assets/img/3cl.png'),
                            '6' => array('alt' => '3 Column Right',  'img' => ReduxFramework::$_url . 'assets/img/3cr.png')
                        ), 
                        'default' => '3'
                    ),
                    array(
                        'id'        => 'blog-left-sidebar',
                        'type'      => 'select',
                        'title'     => esc_html__('Sidebar Left', 'fatotheme'),
                        'data'      => 'sidebars',
                        'default'   => 'blog-sidebar'
                    ),
                    array(
                        'id'        => 'blog-right-sidebar',
                        'type'      => 'select',
                        'title'     => esc_html__('Sidebar Right', 'fatotheme'),
                        'data'      => 'sidebars',
                        'default'   => 'blog-sidebar'
                    ),
                    array(
                        'id'        => 'blog-widget-limittext',
                        'type'      => 'text',
                        'title'     => esc_html__('Limit Introtext of Blog Widget Type', 'fatotheme'),
                        'validate'  => 'numeric',
                        'default'   => '0',
                    ),
                    array(
                        'id'        => 'blog-masonry-limittext',
                        'type'      => 'text',
                        'title'     => esc_html__('Limit Introtext of Blog Masonry Type', 'fatotheme'),
                        'validate'  => 'numeric',
                        'default'   => '20',
                    ),
                    array(
                        'id'        => 'blog-list-limittext',
                        'type'      => 'text',
                        'title'     => esc_html__('Limit Introtext of Blog List Type', 'fatotheme'),
                        'validate'  => 'numeric',
                        'default'   => '50',
                    ),
                    array(
                        'id'        => 'blog-mini-limittext',
                        'type'      => 'text',
                        'title'     => esc_html__('Limit Introtext of Blog Mini Type', 'fatotheme'),
                        'validate'  => 'numeric',
                        'default'   => '50',
                    ),
                    array(
                        'id'        => 'blog-visual-limittext',
                        'type'      => 'text',
                        'title'     => esc_html__('Limit Introtext of Blog Visual Type', 'fatotheme'),
                        'validate'  => 'numeric',
                        'default'   => '25',
                    ),
                )
            );

            $this->sections[] = array(
                'title'     => esc_html__('Single Post', 'fatotheme'),
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id'        => 'single_page_header',
                        'type'      => 'switch',
                        'title'     => esc_html__('Single Post Header', 'fatotheme'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'single_is_author',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Author Bio', 'fatotheme'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'single_is_share',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Sharbox', 'fatotheme'),
                        'default'   => true
                    ),
                )
            );

            $WooCurrencies = array();
            if (class_exists('WooCommerce')){
                $WooCurrencies = get_woocommerce_currencies();
            }

            $this->sections[] = array(
                'icon'      => 'el-icon-shopping-cart',
                'title'     => esc_html__('Woocommerce', 'fatotheme'),
                'fields'    => array(
                    array(
                        'id'       => 'woo-currencies',
                        'type'     => 'select',
                        'multi'    => true,
                        'title'    => esc_html__('Select Currency', 'fatotheme'),
                        'options'  => $WooCurrencies,
                        'default'  => array('USD','EUR')
                    ),
                    array(
                        'id'        => 'woo-is-quickview',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable quickview', 'fatotheme'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'woo-is-effect-thumbnail',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable effect image', 'fatotheme'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'woo-effect-thumbnail-skin',
                        'type'      => 'select',
                        'required'  => array('woo-is-effect-thumbnail', '=', '1'),
                        'title'     => esc_html__('Effect skin', 'fatotheme'),
                        'options'   => array(
                            'we-fade' => 'Fade',
                            'we-bottom-to-top' => 'Bottom to Top',
                            'we-flip-horizontal' => 'Flip Horizontal',
                            'we-flip-vertical' => 'Flip Vertical',
                        ),
                        'default'   => 'we-flip-horizontal'
                    )
                ),
            );
            $this->sections[] = array(
                'title'     => esc_html__('Product Archives', 'fatotheme'),
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id'        => 'woo-shop-layout',
                        'type'      => 'image_select',
                        'compiler'  => true,
                        'title'     => esc_html__('Shop layout', 'fatotheme'),
                        'subtitle'  => esc_html__('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'fatotheme'),
                        'options'   => array(
                            '1' => array('alt' => '1 Column',       'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            '3' => array('alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                        ),
                        'default'   => '2'
                    ),
                    array(
                        'id'        => 'shop-cat-headerbg',
                        'type'      => 'switch',
                        'title'     => esc_html__('Shop Category Header Background', 'fatotheme'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'woo-shop-sidebar',
                        'type'      => 'select',
                        'title'     => esc_html__('Shop sidebar', 'fatotheme'),
                        'data'      => 'sidebars',
                        'default'   => 'shop-sidebar'
                    ),
                    array(
                        'id'        => 'woo-shop-layout-switch',
                        'type'      => 'select',
                        'title'     => esc_html__('Select Grid or List', 'fatotheme'),
                        'options'   => array(
                            'grid' => 'Grid', 
                            'list' => 'List'
                        ),
                        'default'   => 'grid'
                    ),
                    array(
                        'id'        => 'woo-shop-filter-show',
                        'type'      => 'text',
                        'title'     => esc_html__('Shop filter show', 'fatotheme'),
                        'desc'      => esc_html__('To change filter of products displayed per page.', 'fatotheme'),
                        'default'   => '9,12,24,36,48,60,90,100',
                    ),
                    array(
                        'id'        => 'woo-shop-number',
                        'type'      => 'text',
                        'title'     => esc_html__('Shop show products', 'fatotheme'),
                        'desc'      => esc_html__('To change number of products displayed per page.', 'fatotheme'),
                        'validate'  => 'numeric',
                        'default'   => '9',
                    ),
                    array(
                        'id'        => 'woo-shop-column',
                        'type'      => 'select',
                        'title'     => esc_html__('Shop columns', 'fatotheme'),
                        'options'   => array(
                            '1' => '1 Column', 
                            '2' => '2 Columns', 
                            '3' => '3 Columns',
                            '4' => '4 Columns', 
                            '6' => '6 Columns',
                        ),
                        'default'   => '3'
                    ),
                )
            );
            $this->sections[] = array(
                'title'     => esc_html__('Product Details', 'fatotheme'),
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id'        => 'woo-single-layout',
                        'type'      => 'image_select',
                        'compiler'  => true,
                        'title'     => esc_html__('Single layout', 'fatotheme'),
                        'subtitle'  => esc_html__('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'fatotheme'),
                        'options'   => array(
                            '1' => array('alt' => '1 Column',       'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            '3' => array('alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                        ),
                        'default'   => '1'
                    ),
                    array(
                        'id'        => 'product_tab_video',
                        'type'      => 'switch',
                        'title'     => esc_html__('Product Tab Video', 'fatotheme'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'woo-single-sidebar',
                        'type'      => 'select',
                        'title'     => esc_html__('Single sidebar', 'fatotheme'),
                        'data'      => 'sidebars',
                        'default'   => 'shop-single-sidebar'
                    ),
                    array(
                        'id'        => 'woo-related-number',
                        'type'      => 'text',
                        'title'     => esc_html__('Related show products', 'fatotheme'),
                        'desc'      => esc_html__('To change number of products displayed related.', 'fatotheme'),
                        'validate'  => 'numeric',
                        'default'   => '0',
                    ),
                    array(
                        'id'        => 'woo-related-column',
                        'type'      => 'select',
                        'title'     => esc_html__('Related columns', 'fatotheme'),
                        'options'   => array(
                            '1' => '1 Column', 
                            '2' => '2 Columns', 
                            '3' => '3 Columns',
                            '4' => '4 Columns', 
                            '6' => '6 Columns',
                        ),
                        'default'   => '4'
                    ),
                    array(
                        'id'        => 'woo-upsells-number',
                        'type'      => 'text',
                        'title'     => esc_html__('Up-Sells show products', 'fatotheme'),
                        'desc'      => esc_html__('To Change number of products displayed up-sell.', 'fatotheme'),
                        'validate'  => 'numeric',
                        'default'   => '8',
                    ),
                    array(
                        'id'        => 'woo-upsells-column',
                        'type'      => 'select',
                        'title'     => esc_html__('Up-Sells columns', 'fatotheme'),
                        'options'   => array(
                            '1' => '1 Column', 
                            '2' => '2 Columns', 
                            '3' => '3 Columns',
                            '4' => '4 Columns', 
                            '6' => '6 Columns',
                        ),
                        'default'   => '4'
                    ),
                    array(
                        'id'        => 'woo-cross-sells-number',
                        'type'      => 'text',
                        'title'     => esc_html__('Cross-Sells show products', 'fatotheme'),
                        'desc'      => esc_html__('To change number of products displayed cross sells.', 'fatotheme'),
                        'validate'  => 'numeric',
                        'default'   => '0',
                    ),
                    array(
                        'id'        => 'woo-cross-sells-column',
                        'type'      => 'select',
                        'title'     => esc_html__('Cross-Sells columns', 'fatotheme'),
                        'options'   => array(
                            '1' => '1 Column', 
                            '2' => '2 Columns', 
                            '3' => '3 Columns',
                            '4' => '4 Columns', 
                            '6' => '6 Columns',
                        ),
                        'default'   => '3'
                    ),
                )
            );
            $this->sections[] = array(
                'icon'       => 'el el-network',
                'title'      => esc_html__( 'Social icons', 'fatotheme' ),
                'fields'     => array(
                    array(
                        'id'        => 'follow_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Follow Us title', 'fatotheme'),
                        'default'   => 'Follow Us'
                    ),
                    array(
                        'id'       => 'social_icons',
                        'type'     => 'sortable',
                        'title'    => esc_html__('Social icons', 'fatotheme'),
                        'subtitle' => esc_html__('Enter social links', 'fatotheme'),
                        'desc'     => esc_html__('Drag/drop to re-arrange', 'fatotheme'),
                        'mode'     => 'text',
                        'options'  => array(
                            'facebook'     => '',
                            'twitter'     => '',
                            'tumblr'     => '',
                            'pinterest'     => '',
                            'google-plus'     => '',
                            'linkedin'     => '',
                            'behance'     => '',
                            'dribbble'     => '',
                            'youtube'     => '',
                            'vimeo'     => '',
                            'rss'     => '',
                        ),
                        'default' => array(
                            'facebook'     => 'https://www.facebook.com/',
                            'twitter'     => 'https://twitter.com/',
                            'tumblr'     => 'https://www.tumblr.com/',
                            'pinterest'     => '',
                            'google-plus'     => 'https://plus.google.com/',
                            'linkedin'     => '',
                            'behance'     => '',
                            'dribbble'     => 'https://dribbble.com/',
                            'youtube'     => '',
                            'vimeo'     => '',
                            'rss'     => '',
                        ),
                    ),
                )
            );
            $this->sections[] = array(
                'type' => 'divide',
            );

             $this->sections[] = array(
                'title'     => esc_html__('Import / Export', 'fatotheme'),
                'desc'      => esc_html__('Import and Export theme settings from file, text or URL.', 'fatotheme'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => esc_html__('Theme Information 1', 'fatotheme'),
                'content'   => wp_kses_post('<p>This is the tab content, HTML is allowed.</p>')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => esc_html__('Theme Information 2', 'fatotheme'),
                'content'   => wp_kses_post('<p>This is the tab content, HTML is allowed.</p>')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = wp_kses_post('<p>This is the sidebar content, HTML is allowed.</p>');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'fatotheme_theme_option',// This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => esc_html__('Theme Options', 'fatotheme'),
                'page_title'        => esc_html__('Theme Options', 'fatotheme'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => false,                    // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = wp_kses_post('<p>Did you know that theme sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$'.$v.'</strong></p>');
            } else {
                $this->args['intro_text'] = wp_kses_post('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>');
            }

            // Add content after the form.
            $this->args['footer_text'] = wp_kses_post('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>');
        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}