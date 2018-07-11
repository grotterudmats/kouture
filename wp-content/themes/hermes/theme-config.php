<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Hermes_Theme_Config')) {

    class Hermes_Theme_Config {

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
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => esc_html__('Section via hook', 'hermes'),
                'desc' => esc_html__('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'hermes'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
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

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(esc_html__('Customize &#8220;%s&#8221;', 'hermes'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'hermes'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'hermes'); ?>" />
                <?php endif; ?>

                <h4><?php echo esc_html($this->theme->display('Name')); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(esc_html__('By %s', 'hermes'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(esc_html__('Version %s', 'hermes'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . esc_html__('Tags', 'hermes') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo esc_html($this->theme->display('Description')); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . esc_html__('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'hermes') . '</p>', esc_html__('http://codex.wordpress.org/Child_Themes', 'hermes'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
           
            // General
            $this->sections[] = array(
                'title'     => esc_html__('General', 'hermes'),
                'desc'      => esc_html__('General theme options', 'hermes'),
                'icon'      => 'el-icon-cog',
                'fields'    => array(

                    array(
                        'id'        => 'logo_main',
                        'type'      => 'media',
                        'title'     => esc_html__('Logo', 'hermes'),
                        'compiler'  => 'true',
                        'mode'      => false,
                        'desc'      => esc_html__('Upload logo here.', 'hermes'),
                    ),
					array(
                        'id'        => 'opt-favicon',
                        'type'      => 'media',
                        'title'     => esc_html__('Favicon', 'hermes'),
                        'compiler'  => 'true',
                        'mode'      => false,
                        'desc'      => esc_html__('Upload favicon here.', 'hermes'),
                    ),
					array(
                        'id'        => 'background_opt',
                        'type'      => 'background',
                        'output'    => array('body'),
                        'title'     => esc_html__('Body background', 'hermes'),
                        'subtitle'  => esc_html__('Upload image or select color. Only work with box layout', 'hermes'),
						'default'   => array('background-color' => '#fff'),
                    ),
					array(
                        'id'        => 'back_to_top',
                        'type'      => 'switch',
                        'title'     => esc_html__('Back To Top', 'hermes'),
						'desc'      => esc_html__('Show back to top button on all pages', 'hermes'),
						'default'   => true,
                    ),
					array(
                        'id'        => 'use_mailchimp_form',
                        'type'      => 'switch',
                        'title'     => esc_html__('Use mailchimp Form', 'hermes'),
                        'subtitle'  => esc_html__('This apply for footer form too, if you install and connected to mailchimp, you can fill MC form ID in above field.', 'hermes'),
						'default'   => false,
                    ),
                ),
            );
			
			// Colors
            $this->sections[] = array(
                'title'     => esc_html__('Colors', 'hermes'),
                'desc'      => esc_html__('Color options', 'hermes'),
                'icon'      => 'el-icon-tint',
                'fields'    => array(
					array(
                        'id'        => 'primary_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Primary Color', 'hermes'),
                        'subtitle'  => esc_html__('default: #ba933e, skin 2: #808f66, skin 3: #6dc5ee, skin 4: #12a170, skin 5: #FC7001', 'hermes'),
						'transparent' => false,
                        'default'   => '#ba933e',
                        'validate'  => 'color',
                    ),
					array(
                        'id'        => 'sale_color',
                        'type'      => 'color',
                        //'output'    => array(),
                        'title'     => esc_html__('Sale Label BG Color', 'hermes'),
                        'subtitle'  => esc_html__('Pick a color for bg sale label (default: #333).', 'hermes'),
						'transparent' => true,
                        'default'   => '#333333',
                        'validate'  => 'color',
                    ),
					
					array(
                        'id'        => 'saletext_color',
                        'type'      => 'color',
                        //'output'    => array(),
                        'title'     => esc_html__('Sale Label Text Color', 'hermes'),
                        'subtitle'  => esc_html__('Pick a color for sale label text (default: #ffffff).', 'hermes'),
						'transparent' => false,
                        'default'   => '#ffffff',
                        'validate'  => 'color',
                    ),
					
					array(
                        'id'        => 'rate_color',
                        'type'      => 'color',
                        //'output'    => array(),
                        'title'     => esc_html__('Rating Star Color', 'hermes'),
                        'subtitle'  => esc_html__('Pick a color for star of rating (default: #181818).', 'hermes'),
						'transparent' => false,
                        'default'   => '#181818',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'        => 'button_bg',
                        'type'      => 'color',
                        'title'     => esc_html__('Button background', 'hermes'),
                        'subtitle'  => esc_html__('Apply for almost button (default: #2f2f2f).', 'hermes'),
                        'transparent' => false,
                        'default'   => '#2f2f2f',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'        => 'button_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Button text color', 'hermes'),
                        'subtitle'  => esc_html__('Apply for almost button (default: #ffffff).', 'hermes'),
                        'transparent' => false,
                        'default'   => '#ffffff',
                        'validate'  => 'color',
                    ),
                ),
            );
			
			//Header
			$this->sections[] = array(
                'title'     => esc_html__('Header', 'hermes'),
                'desc'      => esc_html__('Header options', 'hermes'),
                'icon'      => 'el-icon-tasks',
                'fields'    => array(

					array(
                        'id'        => 'header_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Header Layout', 'hermes'),

                        //Must provide key => value pairs for select options
                        'options'   => array(
                            'default' => 'Default',
                            'second' => 'Second',
							'third' => 'Third',
							'fourth' => 'Fourth',
							'fifth' => 'Fifth',
                        ),
                        'default'   => 'default'
                    ),
					array(
                        'id'        => 'sticky_header',
                        'type'      => 'switch',
                        'title'     => esc_html__('Sticky Header', 'hermes'),
						'default'   => true,
                    ),
                    array(
                        'id'        => 'sticky_header_bg',
                        'type'      => 'color_rgba',
                        'title'     => esc_html__('Sticky background', 'hermes'),
                        'default'   => array('color' => '#242424', 'alpha' => 0.86),
                        'clickout_fires_change' => true,
                    ),
					array(
                        'id'        => 'header_background',
                        'type'      => 'background',
                        'title'     => esc_html__('Header background', 'hermes'),
                        'background-color' => false
                    ),
                    array(
                        'id'        => 'header_bg_color',
                        'type'      => 'color_rgba',
                        'title'     => esc_html__('Header background color', 'hermes'),
                        'subtitle'  => esc_html__('default: rgba(36,36,36,0.86) , skin 3 & 5: #ffffff, skin 4: #333333', 'hermes'),
                        'default'   => array('color' => '#242424', 'alpha' => 0.86),
                        'clickout_fires_change' => true,
                    ),
					array(
                        'id'        => 'header_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Header color', 'hermes'),
                        'subtitle'  => esc_html__('default: #bbbbbb, skin 2: #ffffff, skin 3: #555555, skin 4: #dddddd', 'hermes'),
						'default'   => '#bbbbbb',
                        'transparent' => false,
                    ),
					array(
                        'id'        => 'enable_topbar',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable topbar', 'hermes'),
						'default'   => true,
                    ),
                    array(
                        'id'        => 'topbar_background',
                        'type'      => 'color_rgba',
                        'title'     => esc_html__('Topbar background color', 'hermes'),
                        'default'   => array(),
                    ),
					array(
                        'id'        => 'topbar_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Topbar color', 'hermes'),
                        'subtitle'  => esc_html__('default: #aaaaaa, skin 3: #888888, skin 4: #dddddd, skin5: #eeeeee', 'hermes'),
						'default'   => '#AAAAAA',
                        'transparent' => false,
                    ),
					array(
                        'id'        => 'topbar_hvcolor',
                        'type'      => 'color',
                        'title'     => esc_html__('Topbar hover color', 'hermes'),
                        'subtitle'  => esc_html__('default: #ba933e, skin 2: #808f66, skin 3: #333333, skin 4: #12a170, skin5: #FC7001', 'hermes'),
						'default'   => '#ba933e',
                    ),
                    array(
                        'id'        => 'topbar_border_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Topbar border color', 'hermes'),
                        'subtitle'  => esc_html__('default: #444444, skin 3: #dddddd', 'hermes'),
                        'default'   => '#444',
                    ),
					array(
                        'id'        => 'show_topsearch',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show top product search', 'hermes'),
						'default'   => true,
                    ),
					array(
                        'id'        => 'show_topcart',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show top mini cart', 'hermes'),
						'default'   => true,
                    ),
                    array(
                        'id'        => 'menu_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Menu first level color', 'hermes'),
                        'subtitle'  => esc_html__('default: #fff, skin 3: #555555, skin 4: #dddddd, skin 5: #333333', 'hermes'),
                        'default'   => '#FFF',
                        'transparent' => false,
                    ),
                    array(
                        'id'        => 'sub_menu_bg',
                        'type'      => 'color',
                        'title'     => esc_html__('Submenu background', 'hermes'),
                        'subtitle'  => esc_html__('default: #ffffff, skin 2, 3, 4, 5: #2c2c2c', 'hermes'),
                        'transparent' => false,
                        'default'   => '#fff',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'        => 'sub_menu_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Submenu color', 'hermes'),
                        'subtitle'  => esc_html__('default: #333333, skin 2, 3, 4, 5: #cfcfcf', 'hermes'),
                        'transparent' => false,
                        'default'   => '#333333',
                        'validate'  => 'color',
                    ),
                ),
            );
			$this->sections[] = array(
				'icon'       => 'el-icon-website',
				'title'      => esc_html__( 'Social Icons', 'hermes' ),
				'subsection' => true,
				'fields'     => array(
				
				 array(
									'id'        => 'follow_us',
									'type'      => 'text',
									'title'     => esc_html__('follow_us', 'hermes'),
									'default'   => 'Follow Us'
								),
				 
				 array(
				  'id'       => 'social_icons',
				  'type'     => 'sortable',
				  'title'    => esc_html__('Social Icons', 'hermes'),
				  'subtitle' => esc_html__('Enter social links', 'hermes'),
				  'desc'     => esc_html__('Drag/drop to re-arrange', 'hermes'),
				  'mode'     => 'text',
				  'options'  => array(
					'twitter'     => '',
					'skype'     => '',
					'vine'     => '',
					'facebook'     => '',
					'instagram' => '',
					'tumblr'     => '',
					'pinterest'     => '',
					'google-plus'     => '',
					'linkedin'     => '',
					'behance'     => '',
					'dribbble'     => '',
					'youtube'     => '',				   
					'rss'     => '',
					'vk'     => '',
					'yahoo'     => '',
					'qq'     => '',				   
					'weibo'     => '',
				  ),
				  'default' => array(					 
					   'twitter'     => '#twitter.com',
					   'skype'     => '#skype',
					   'vine'     => '#vine',				   
					   'facebook'     => '#facebook',
				  ),
				 ),
				)
			);
			   
			$form_options = array();
			if(class_exists('WYSIJA')){
				$wysija_model_forms = WYSIJA::get('forms', 'model');
				$wysija_forms = $wysija_model_forms->getRows();
				foreach($wysija_forms as $wysija_form){
					$form_options[$wysija_form['form_id']] = esc_html($wysija_form['name']);
				}
			}
			//Footer
			$this->sections[] = array(
                'title'     => esc_html__('Footer', 'hermes'),
                'desc'      => esc_html__('Footer options', 'hermes'),
                'icon'      => 'el-icon-cog',
                'fields'    => array(
					array(
                        'id'        => 'footer_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Footer Layout', 'hermes'),
                        'options'   => array(
                            'default' => 'Default',
							'second' => 'Second',
							'third' => 'Third',
							'fourth' => 'Fourth',
							'fifth' => 'Fifth',
                        ),
                        'default'   => 'default'
                    ),
                    array(
                        'id'        => 'footer_bg',
                        'type'      => 'background',
                        'output'    => array(''),
                        'title'     => esc_html__('Footer background', 'hermes'),
                        'subtitle'  => esc_html__('Upload image or select color. Default: "../images/bkg_footer.jpg", skin 3: #ffffff, skin 4, 5: #222222', 'hermes'),
                        'background-attachment' => false,
                        'default'   => array(
                            'background-image' => '../images/bkg_footer.jpg'
                        ),
                    ),
                    array(
                        'id'        => 'footer_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Text & link color', 'hermes'),
                        'subtitle'  => esc_html__('Default: #bbbbbb, skin 3: #888888', 'hermes'),
                        'transparent' => false,
                        'default'   => '#BBB',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'        => 'footer_heading_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Heading color', 'hermes'),
                        'subtitle'  => esc_html__('Default: #dddddd, skin 3: #333333', 'hermes'),
                        'transparent' => false,
                        'default'   => '#dddddd',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'        => 'footer_top_border',
                        'type'      => 'background',
                        'output'    => array(''),
                        'title'     => esc_html__('Top border background', 'hermes'),
                        'subtitle'  => esc_html__('Upload image or select color. The height of border is 6px by design, this option only use for default footer layout.', 'hermes'),
                        'background-attachment' => false,
                        'default'   => array(
                            'background-image' => '../images/boder_product_group.png',
							'background-repeat' => 'repeat-x'
                        ),
                    ),
                    array(
                        'id'        => 'footer_border',
                        'type'      => 'color_rgba',
                        'title'     => esc_html__('Border color', 'hermes'),
                        'subtitle'  => esc_html__('Default: rgba(255, 255, 255, 0.15), skin 3: #eeeeee, skin 4: #444444, skin 5: #393939', 'hermes'),
                        'default'   => array('color' => '#ffffff', 'alpha' => 0.15),
                    ),
					array(
                        'id'        => 'copyright_bg',
                        'type'      => 'color',
                        'title'     => esc_html__('Footer bottom background', 'hermes'),
                        'subtitle'  => esc_html__('Default: transparent, skin 4, 5: #181818', 'hermes'),
                        'default'   => 'transparent',
                        'validate'  => 'color',
                    ),
					array(
                        'id'        => 'newletter_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Newletter Title', 'hermes'),
                        'desc'  => esc_html__('Move to widgets manager from version 1.6', 'hermes'),
                        'default'   => ''
                    ),
					array(
                        'id'        => 'newsletter_form',
                        'type'      => 'text',
                        'title'     => esc_html__('Newsletter Form ID', 'hermes'),
                        'desc'  => esc_html__('Move to widgets manager from version 1.6', 'hermes'),
						'default'   => '',
                    ),
					array(
                        'id'        => 'newsletter_form4',
                        'type'      => 'text',
                        'title'     => esc_html__('Newsletter Form ID for layout 4', 'hermes'),
                        'desc'  => esc_html__('Move to widgets manager from version 1.6', 'hermes'),
						'default'   => '',
                    ),
					array(
						'id'               => 'copyright',
						'type'             => 'editor',
						'title'    => esc_html__('Copyright information', 'hermes'),
                        'subtitle'         => esc_html__('HTML tags allowed: a, br, em, strong', 'hermes'),
						'desc'         => esc_html__('Move to widgets manager from version 1.6', 'hermes'),
						'default'          => 'Copyright &copy; 2016 Hermesthemes All Rights Reserved.',
						'args'   => array(
							'teeny'            => true,
							'textarea_rows'    => 5,
							'media_buttons'	=> false,
						)
					),
					array(
						'id'               => 'payment_icons',
						'type'             => 'editor',
						'title'    => esc_html__('Payment icons', 'hermes'),
                        'subtitle'         => esc_html__('HTML tags allowed: a, img', 'hermes'),
						'desc'         => esc_html__('Move to widgets manager from version 1.6', 'hermes'),
						'default'          => '',
						'args'   => array(
							'teeny'            => true,
							'textarea_rows'    => 5,
							'media_buttons'	=> true,
						)
					),
                ),
            );
			
			$this->sections[] = array(
				'icon'       => 'el-icon-website',
				'title'      => esc_html__( 'About Us', 'hermes' ),
				'subsection' => true,
				'fields'     => array(

					array(
						'id'=>'about_us',
						'type' => 'editor',
						'title' => esc_html__('About Us', 'hermes'), 
                        'subtitle'         => esc_html__('HTML tags allowed: a, img, br, em, strong, p, ul, li', 'hermes'),
						'desc'         => esc_html__('Move to widgets manager from version 1.6', 'hermes'),
						'default' => '',
						'args'   => array(
							'teeny'            => true,
							'textarea_rows'    => 10
						)
					),
					
					array(
						'id'=>'about_us2',
						'type' => 'editor',
						'title' => esc_html__('About Us 2', 'hermes'), 
                        'subtitle'         => esc_html__('HTML tags allowed: a, img, br, em, strong, p, ul, li', 'hermes'),
						'desc'         => esc_html__('Move to widgets manager from version 1.6', 'hermes'),
						'default' => '',
						'args'   => array(
							'teeny'            => true,
							'textarea_rows'    => 10
						)
					),
				)
			);

            $this->sections[] = array(
                'icon'       => 'el-icon-website',
                'title'      => esc_html__( 'Menus', 'hermes' ),
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'       => 'footer_menu1',
                        'type'     => 'select',
                        'data'     => 'menus',
                        'title'    => esc_html__( 'Menu #1', 'hermes' ),
                        'subtitle' => esc_html__( 'Select a menu', 'hermes' ),
                        'desc' => esc_html__( 'Move to widgets manager from version 1.6', 'hermes' ),
                    ),
                    array(
                        'id'       => 'footer_menu2',
                        'type'     => 'select',
                        'data'     => 'menus',
                        'title'    => esc_html__( 'Menu #2', 'hermes' ),
                        'subtitle' => esc_html__( 'Select a menu', 'hermes' ),
                        'desc' => esc_html__( 'Move to widgets manager from version 1.6', 'hermes' ),
                    ),
                     array(
                        'id'       => 'footer_menu3',
                        'type'     => 'select',
                        'data'     => 'menus',
                        'title'    => esc_html__( 'Menu #3', 'hermes' ),
                        'subtitle' => esc_html__( 'Select a menu', 'hermes' ),
                        'desc' => esc_html__( 'Move to widgets manager from version 1.6', 'hermes' ),
                    ),
					array(
                        'id'       => 'footer_menu4',
                        'type'     => 'select',
                        'data'     => 'menus',
                        'title'    => esc_html__( 'Menu #4', 'hermes' ),
                        'subtitle' => esc_html__( 'Select a menu', 'hermes' ),
                        'desc' => esc_html__( 'Move to widgets manager from version 1.6', 'hermes' ),
                    ),
                )
            );
			
			//Newsletter Popup
			$this->sections[] = array(
				'icon'       => 'el-icon-website',
				'title'      => esc_html__( 'Newsletter Popup', 'hermes' ),
				'desc'      => esc_html__('Content show up on home page loaded', 'hermes'),
				'fields'     => array(
					array(
                        'id'        => 'enable_popup',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable', 'hermes'),
						'default'   => true,
                    ),
					array(
                        'id'        => 'background_popup',
                        'type'      => 'background',
                        'output'    => array(''),
                        'title'     => esc_html__('Popup background', 'hermes'),
                        'subtitle'  => esc_html__('Upload image or select color.', 'hermes'),
						'default'   => array('background-color' => '#eee'),
                    ),
					array(
						'id'=>'popup_onload_content',
						'type' => 'editor',
						'title' => esc_html__('Content', 'hermes'), 
						'subtitle'         => esc_html__('HTML tags allowed: a, img, br, em, strong, p, ul, li', 'hermes'),
						'default' => '<h3>Newsletter</h3>
									Subscribe to the Hermes mailing list to receive updates on new arrivals, special offers
									and other discount information.',
						'args'   => array(
							'teeny'            => true,
							'textarea_rows'    => 10,
							'media_buttons'	=> true,
						)
					),
					array(
                        'id'        => 'popup_onload_form',
                        'type'      => 'text',
                        'title'     => esc_html__('Newsletter Form ID', 'hermes'),
						'default'   => '1',
                    ),
					array(
						'id'        => 'popup_onload_expires',
						'type'      => 'slider',
						'title'     => esc_html__('Time expires', 'hermes'),
						'desc'      => esc_html__('Time expires after tick not show again defaut: 7 days', 'hermes'),
						'default'   => 1,
						'min'       => 1,
						'step'      => 1,
						'max'       => 7,
						'display_value' => 'text'
					),
				)
			);
			
			//Fonts
			$this->sections[] = array(
                'title'     => esc_html__('Fonts', 'hermes'),
                'desc'      => esc_html__('Fonts options', 'hermes'),
                'icon'      => 'el-icon-font',
                'fields'    => array(
                    array(
                        'id'        => 'use_design_font',
                        'type'      => 'switch',
                        'title'     => esc_html__('Use design font', 'hermes'),
                        'default'   => true,
                    ),
                    array(
                        'id'            => 'bodyfont',
                        'type'          => 'typography',
                        'title'         => esc_html__('Body font', 'hermes'),
                        //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                        'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => false,    // Select a backup non-google font in addition to a google font
                        //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => false, // Only appears if google is true and subsets not set to false
						'text-align'   => false,
                        //'font-size'     => false,
                        //'line-height'   => false,
                        //'word-spacing'  => true,  // Defaults to false
                        //'letter-spacing'=> true,  // Defaults to false
                        //'color'         => false,
                        //'preview'       => false, // Disable the previewer
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'output'        => array('body'), // An array of CSS selectors to apply this font style to dynamically
                        //'compiler'      => array('h2.site-description-compiler'), // An array of CSS selectors to apply this font style to dynamically
                        'units'         => 'px', // Defaults to px
                        'subtitle'      => esc_html__('Main body font.', 'hermes'),
                        'default'       => array(
                            'color'         => '#333',
                            'font-weight'    => '400',
                            'font-family'   => 'Lato',
                            'google'        => true,
                            'font-size'     => '13px',
                            'line-height'   => '24px'
						),
                    ),
					array(
                        'id'            => 'headingfont',
                        'type'          => 'typography',
                        'title'         => esc_html__('Heading font', 'hermes'),
                        //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                        'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => false,    // Select a backup non-google font in addition to a google font
                        //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => false, // Only appears if google is true and subsets not set to false
                        'font-size'     => false,
                        'line-height'   => false,
						'text-align'   => false,
                        //'word-spacing'  => true,  // Defaults to false
                        //'letter-spacing'=> true,  // Defaults to false
                        //'color'         => false,
                        //'preview'       => false, // Disable the previewer
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        //'output'        => array('h1, h2, h3, h4, h5, h6'), // An array of CSS selectors to apply this font style to dynamically
                        //'compiler'      => array('h2.site-description-compiler'), // An array of CSS selectors to apply this font style to dynamically
                        'units'         => 'px', // Defaults to px
                        'subtitle'      => esc_html__('Heading font.', 'hermes'),
                        'default'       => array(
							'color'         => '#666',
                            'font-weight'    => '700',
                            'font-family'   => 'Montserrat',
                            'google'        => true,
						),
                    ),
					array(
                        'id'            => 'menufont',
                        'type'          => 'typography',
                        'title'         => esc_html__('Menu font', 'hermes'),
                        //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                        'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => false,    // Select a backup non-google font in addition to a google font
                        //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => false, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => false,
						'text-align'   => false,
						'color'         => false,
                        //'word-spacing'  => true,  // Defaults to false
                        //'letter-spacing'=> true,  // Defaults to false
                        //'color'         => false,
                        //'preview'       => false, // Disable the previewer
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        //'output'        => array('h1, h2, h3, h4, h5, h6'), // An array of CSS selectors to apply this font style to dynamically
                        //'compiler'      => array('h2.site-description-compiler'), // An array of CSS selectors to apply this font style to dynamically
                        'units'         => 'px', // Defaults to px
                        'subtitle'      => esc_html__('Menu font.', 'hermes'),
                        'default'       => array(
                            'font-weight'    => '400',
                            'font-family'   => 'Montserrat',
							'font-size'     => '15px',
                            'google'        => true,
						),
                    ),
                ),
            );
			
			// Layout
            $this->sections[] = array(
                'title'     => esc_html__('Layout', 'hermes'),
                'desc'      => esc_html__('Select page layout: Box or Full Width', 'hermes'),
                'icon'      => 'el-icon-align-justify',
                'fields'    => array(
					array(
						'id'       => 'page_layout',
						'type'     => 'select',
						'multi'    => false,
						'title'    => esc_html__('Page Layout', 'hermes'),
						'options'  => array(
							'full' => 'Full Width',
							'box' => 'Box'
						),
						'default'  => 'full'
					),
					array(
						'id'        => 'box_layout_width',
						'type'      => 'slider',
						'title'     => esc_html__('Box layout width', 'hermes'),
						'desc'      => esc_html__('Box layout width in pixels, default value: 1200', 'hermes'),
						"default"   => 1200,
						"min"       => 960,
						"step"      => 1,
						"max"       => 1920,
						'display_value' => 'text'
					),
                ),
            );
			
			//Brand logos
			$this->sections[] = array(
                'title'     => esc_html__('Brand Logos', 'hermes'),
                'desc'      => esc_html__('Upload brand logos and links', 'hermes'),
                'icon'      => 'el-icon-briefcase',
                'fields'    => array(
					array(
						'id'          => 'brand_logos',
						'type'        => 'slides',
						'title'       => esc_html__('Logos', 'hermes'),
						'desc'        => esc_html__('Upload logo image and enter logo link.', 'hermes'),
						'placeholder' => array(
							'title'           => esc_html__('Title', 'hermes'),
							'description'     => esc_html__('Description', 'hermes'),
							'url'             => esc_html__('Link', 'hermes'),
						),
					),
					array(
						'id'          => 'brand_logos4',
						'type'        => 'slides',
						'title'       => esc_html__('Logos (home 4)', 'hermes'),
						'desc'        => esc_html__('Upload logo image and enter logo link. Only Use for layout 4', 'hermes'),
						'placeholder' => array(
							'title'           => esc_html__('Title', 'hermes'),
							'description'     => esc_html__('Description', 'hermes'),
							'url'             => esc_html__('Link', 'hermes'),
						),
					),
					array(
                        'id'        => 'brand_show_nav',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show direction control', 'hermes'),
						'default'   => false,
						'desc'        => esc_html__('Only apply for layout 4.', 'hermes'),
                    ),
					array(
                        'id'        => 'brand_autoplay',
                        'type'      => 'switch',
                        'title'     => esc_html__('Auto play', 'hermes'),
						'default'   => true,
						'desc'        => esc_html__('Only apply for layout 4.', 'hermes'),
                    ),
					array(
                        'id'        => 'brand_playtimeout',
                        'type'      => 'text',
                        'title'     => esc_html__('Play timeout', 'hermes'),
						'default'   => '5000',
						'desc'        => esc_html__('Only apply for layout 4.', 'hermes'),
                    ),
					array(
                        'id'        => 'brand_playspeed',
                        'type'      => 'text',
                        'title'     => esc_html__('Play speed', 'hermes'),
						'default'   => '250',
						'desc'        => esc_html__('Only apply for layout 4.', 'hermes'),
                    ),
                ),
            );
			
			// Sidebar
			$this->sections[] = array(
                'title'     => esc_html__('Sidebar', 'hermes'),
                'desc'      => esc_html__('Sidebar options', 'hermes'),
                'icon'      => 'el-icon-cog',
                'fields'    => array(
					
					array(
						'id'       => 'sidebarshop_pos',
						'type'     => 'radio',
						'title'    => esc_html__('Shop Sidebar Position', 'hermes'),
						'subtitle'      => esc_html__('Sidebar on shop page', 'hermes'),
						'options'  => array(
							'left' => 'Left',
							'right' => 'Right'),
						'default'  => 'left'
					),
					array(
						'id'       => 'sidebarpro_pos',
						'type'     => 'radio',
						'title'    => esc_html__('Product Sidebar Position', 'hermes'),
						'subtitle'      => esc_html__('Sidebar on product detail page', 'hermes'),
						'options'  => array(
							'' => 'None',
							'left' => 'Left',
							'right' => 'Right'
						),
						'default'  => ''
					),
					array(
						'id'       => 'sidebarse_pos',
						'type'     => 'radio',
						'title'    => esc_html__('Pages Sidebar Position', 'hermes'),
						'subtitle'      => esc_html__('Sidebar on pages', 'hermes'),
						'options'  => array(
							'left' => 'Left',
							'right' => 'Right'),
						'default'  => 'left'
					),
					array(
						'id'       => 'sidebarblog_pos',
						'type'     => 'radio',
						'title'    => esc_html__('Blog Sidebar Position', 'hermes'),
						'subtitle'      => esc_html__('Sidebar on Blog pages', 'hermes'),
						'options'  => array(
							'left' => 'Left',
							'right' => 'Right'),
						'default'  => 'left'
					)
                ),
            );
			
			// Portfolio
            $this->sections[] = array(
                'title'     => esc_html__('Portfolio', 'hermes'),
                'desc'      => esc_html__('Use this section to select options for portfolio', 'hermes'),
                'icon'      => 'el-icon-bookmark',
                'fields'    => array(
					array(
						'id'        => 'portfolio_columns',
						'type'      => 'slider',
						'title'     => esc_html__('Portfolio Columns', 'hermes'),
						"default"   => 3,
						"min"       => 2,
						"step"      => 1,
						"max"       => 4,
						'display_value' => 'text'
					),
					array(
						'id'        => 'portfolio_per_page',
						'type'      => 'slider',
						'title'     => esc_html__('Projects per page', 'hermes'),
						'desc'      => esc_html__('Amount of projects per page on portfolio page', 'hermes'),
						"default"   => 12,
						"min"       => 4,
						"step"      => 1,
						"max"       => 48,
						'display_value' => 'text'
					),
					array(
                        'id'        => 'related_project_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Related projects title', 'hermes'),
                        'default'   => 'Related Projects'
                    ),
                ),
            );
			
			// Products
            $this->sections[] = array(
                'title'     => esc_html__('Products', 'hermes'),
                'desc'      => esc_html__('Use this section to select options for product', 'hermes'),
                'icon'      => 'el-icon-tags',
                'fields'    => array(
					array(
                        'id'        => 'shop_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Shop Layout', 'hermes'),
                        'options'   => array(
							'sidebar' => 'Sidebar',
                            'fullwidth' => 'Full Width',
                        ),
                        'default'   => 'sidebar'
                    ),
					array(
                        'id'        => 'default_view',
                        'type'      => 'select',
                        'title'     => esc_html__('Shop default view', 'hermes'),
                        'options'   => array(
							'grid-view' => 'Grid View',
                            'list-view' => 'List View',
                        ),
                        'default'   => 'grid-view'
                    ),
					array(
						'id'        => 'product_per_page',
						'type'      => 'slider',
						'title'     => esc_html__('Products per page', 'hermes'),
						'subtitle'      => esc_html__('Amount of products per page on category page', 'hermes'),
						"default"   => 12,
						"min"       => 4,
						"step"      => 1,
						"max"       => 48,
						'display_value' => 'text'
					),
					array(
						'id'        => 'product_per_row',
						'type'      => 'slider',
						'title'     => esc_html__('Product columns', 'hermes'),
						'subtitle'      => esc_html__('Amount of product columns on category page', 'hermes'),
						"default"   => 3,
						"min"       => 1,
						"step"      => 1,
						"max"       => 6,
						'display_value' => 'text'
					),
					array(
						'id'       => 'enable_loadmore',
						'type'     => 'radio',
						'title'    => esc_html__('Load more ajax', 'hermes'),
						'options'  => array(
							'' => esc_html__('Default pagination', 'hermes'),
							'scroll-more' => esc_html__('Scroll to load more', 'hermes'),
							'button-more' => esc_html__('Button load more', 'hermes')
							),
						'default'  => ''
					),
					array(
						'id'       => 'enable_ajaxsearch',
						'type'     => 'switch',
						'title'    => esc_html__('Autocomplete Ajax Search', 'hermes'),
						'desc'      => esc_html__('Apply for woocommerce search form plugin or header search form', 'hermes'),
						'default'  => false
					),
					array(
						'id'        => 'ajaxsearch_result_items',
						'type'      => 'slider',
						'title'     => esc_html__('Number of search results', 'hermes'),
						"default"   => 6,
						"min"       => 2,
						"step"      => 2,
						"max"       => 20,
						'display_value' => 'text'
					),
					array(
						'id'       => 'second_image',
						'type'     => 'switch',
						'title'    => esc_html__('Use secondary product image', 'hermes'),
						'desc'      => esc_html__('Show the secondary image when hover on product on list', 'hermes'),
						'default'  => true,
					),
                    array(
                        'id'        => 'hover_effect',
                        'type'      => 'switch',
                        'title'     => esc_html__('Hover image overlay effect', 'hermes'),
                        'default'   => true,
                    ),
					array(
                        'id'        => 'lazy_load',
                        'type'      => 'switch',
                        'title'     => esc_html__('Lazy load product images', 'hermes'),
						'default'   => false,
                    ),
					array(
                        'id'        => 'always_visible_acts',
                        'type'      => 'switch',
                        'title'     => esc_html__('Always visible actions', 'hermes'),
						'desc'      => esc_html__('Add to cart, wishlist, compare buttons always shows without mouse hover.', 'hermes'),
						'default'   => false,
                    ),
					array(
                        'id'        => 'upsells_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Up-Sells title', 'hermes'),
                        'default'   => 'Up-Sells'
                    ),
					array(
                        'id'        => 'crosssells_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Cross-Sells title', 'hermes'),
                        'default'   => 'Cross-Sells'
                    ),
                ),
            );
			$this->sections[] = array(
				'icon'       => 'el-icon-website',
				'title'      => esc_html__( 'Product page', 'hermes' ),
				'subsection' => true,
				'fields'     => array(
                    array(
                        'id'        => 'gallery_thumbnail_size',
                        'type'      => 'dimensions',
                        'title'     => esc_html__('Gallery thumbnails size', 'hermes'),
                        'subtitle'  => esc_html__('Width x Height : Empty height value to disable crop image.', 'hermes'),
                        'units'     => false,
                        'default'  => array(
                            'width'   => '130', 
                            'height'  => '165'
                        ),
                    ),
					array(
                        'id'        => 'enable_related',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show related products', 'hermes'),
						'default'   => true,
                    ),
					array(
                        'id'        => 'related_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Related products title', 'hermes'),
                        'default'   => 'Related Products'
                    ),
					array(
						'id'        => 'related_amount',
						'type'      => 'slider',
						'title'     => esc_html__('Number of related products', 'hermes'),
						"default"   => 4,
						"min"       => 1,
						"step"      => 1,
						"max"       => 16,
						'display_value' => 'text'
					),
					array(
                        'id'        => 'enable_upsells',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show upsells products', 'hermes'),
						'default'   => true,
                    ),
					array(
                        'id'        => 'upsells_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Up-Sells title', 'hermes'),
                        'default'   => 'Up-Sells'
                    ),
					array(
						'id'       => 'pro_social_share',
						'type'     => 'checkbox',
						'title'    => esc_html__('Social share', 'hermes'), 
						'options'  => array(
							'facebook' => esc_html__('Facebook', 'hermes'),
							'twitter' => esc_html__('Twitter', 'hermes'),
							'pinterest' => esc_html__('Pinterest', 'hermes'),
							'gplus' => esc_html__('Gplus', 'hermes'),
							'linkedin' => esc_html__('LinkedIn', 'hermes')
						),
						'default' => array(
							'facebook' => '1', 
							'twitter' => '1', 
							'pinterest' => '1',
							'gplus' => '1',
							'linkedin' => '1',
						)
					)
				)
			);
			$this->sections[] = array(
				'icon'       => 'el-icon-website',
				'title'      => esc_html__( 'Quick View', 'hermes' ),
				'subsection' => true,
				'fields'     => array(
					array(
                        'id'        => 'enable_quickview',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable quickview', 'hermes'),
						'default'   => true,
                    ),
					array(
                        'id'        => 'detail_link_text',
                        'type'      => 'text',
                        'title'     => esc_html__('View details text', 'hermes'),
                        'default'   => 'View details'
                    ),
					array(
                        'id'        => 'quickview_link_text',
                        'type'      => 'text',
                        'title'     => esc_html__('View all features text', 'hermes'),
						'desc'      => esc_html__('This is the text on quick view box', 'hermes'),
                        'default'   => 'See all features'
                    ),
				)
			);
			// Blog options
            $this->sections[] = array(
                'title'     => esc_html__('Blog', 'hermes'),
                'desc'      => esc_html__('Use this section to select options for blog', 'hermes'),
                'icon'      => 'el-icon-file',
                'fields'    => array(
					array(
                        'id'        => 'blog_header_text',
                        'type'      => 'text',
                        'title'     => esc_html__('Blog header text', 'hermes'),
                        'default'   => 'Blog'
                    ),
					array(
                        'id'        => 'blog_header_subtext',
                        'type'      => 'text',
                        'title'     => esc_html__('Blog header sub-text', 'hermes'),
                        'default'   => 'Text of the printing and typesetting industry'
                    ),
					array(
                        'id'        => 'blog_header_bg',
                        'type'      => 'background',
                        'output'    => array('body.blog header.blog-entry-header'),
                        'title'     => esc_html__('Blog header background', 'hermes'),
						'default'   => array('background-color' => '#ddd'),
                    ),
					array(
                        'id'        => 'blog_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Blog Layout', 'hermes'),
                        'options'   => array(
							'nosidebar' => 'No Sidebar',
							'sidebar' => 'Sidebar',
                        ),
                        'default'   => 'nosidebar'
                    ),
					array(
                        'id'        => 'blog_column',
                        'type'      => 'select',
                        'title'     => esc_html__('Blog Content Column', 'hermes'),
                        'options'   => array(
							12 => 'One Column',
							6 => 'Two Column',
							4 => 'Three Column',
							3 => 'Four Column'
                        ),
                        'default'   => 6
                    ),
					array(
                        'id'        => 'readmore_text',
                        'type'      => 'text',
                        'title'     => esc_html__('Read more text', 'hermes'),
                        'default'   => 'read more'
                    ),
					array(
						'id'        => 'excerpt_length',
						'type'      => 'slider',
						'title'     => esc_html__('Excerpt length on blog page', 'hermes'),
						"default"   => 15,
						"min"       => 10,
						"step"      => 2,
						"max"       => 120,
						'display_value' => 'text'
					),
					array(
						'id'       => 'blog_social_share',
						'type'     => 'checkbox',
						'title'    => esc_html__('Social share', 'hermes'), 
						'options'  => array(
							'facebook' => esc_html__('Facebook', 'hermes'),
							'twitter' => esc_html__('Twitter', 'hermes'),
							'pinterest' => esc_html__('Pinterest', 'hermes'),
							'gplus' => esc_html__('Gplus', 'hermes'),
							'linkedin' => esc_html__('LinkedIn', 'hermes')
						),
						'default' => array(
							'facebook' => '1', 
							'twitter' => '1', 
							'pinterest' => '1',
							'gplus' => '1',
							'linkedin' => '1',
						)
					)
                ),
            );
			
			// Error 404 page
            $this->sections[] = array(
                'title'     => esc_html__('Error 404 Page', 'hermes'),
                'desc'      => esc_html__('Error 404 page options', 'hermes'),
                'icon'      => 'el-icon-cog',
                'fields'    => array(
					array(
                        'id'        => 'background_error',
                        'type'      => 'background',
                        'output'    => array('body.error404'),
                        'title'     => esc_html__('Error 404 background', 'hermes'),
                        'subtitle'  => esc_html__('Upload image or select color.', 'hermes'),
						'default'   => array('background-color' => '#444444'),
                    ),
					array(
                        'id'        => '404-content',
                        'type'      => 'editor',
                        'title'     => esc_html__('404 Content', 'hermes'),
						'default' => '<h3>Component not found</h3>
									<h2>Oh my gosh! You found it!!!</h2>
									<p>The page are looking for has moved or does not exist anymore, If you like you can return our homepage.<br/>If the problem persists, please send us a email to <a href="mailto:lionthemes88@gmail.com">lionthemes88@gmail.com</a></p>',
						'args'   => array(
							'teeny'            => true,
							'textarea_rows'    => 10,
							'media_buttons'	=> true,
						)
                    ),
                ),
            );
			
			// Custom CSS
            $this->sections[] = array(
                'title'     => esc_html__('Custom CSS', 'hermes'),
                'desc'      => esc_html__('Add your Custom CSS code', 'hermes'),
                'icon'      => 'el-icon-pencil',
                'fields'    => array(
					array(
						'id'       => 'custom_css',
						'type'     => 'ace_editor',
						'title'    => esc_html__('CSS Code', 'hermes'),
						'subtitle' => esc_html__('Paste your CSS code here.', 'hermes'),
						'mode'     => 'css',
						'theme'    => 'monokai', //chrome
						'default'  => ""
					),
                ),
            );
			
			// Less Compiler
            $this->sections[] = array(
                'title'     => esc_html__('Less Compiler', 'hermes'),
                'desc'      => esc_html__('Turn on this option to apply all theme options. Turn of when you have finished changing theme options and your site is ready.', 'hermes'),
                'icon'      => 'el-icon-wrench',
                'fields'    => array(
					array(
                        'id'        => 'enable_less',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Less Compiler', 'hermes'),
						'default'   => true,
                    ),
                ),
            );
			
            $theme_info  = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . esc_html__('<strong>Theme URL:</strong> ', 'hermes') . '<a href="' . esc_url($this->theme->get('ThemeURI')) . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . esc_html__('<strong>Author:</strong> ', 'hermes') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . esc_html__('<strong>Version:</strong> ', 'hermes') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . esc_html__('<strong>Tags:</strong> ', 'hermes') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

            $this->sections[] = array(
                'title'     => esc_html__('Import / Export', 'hermes'),
                'desc'      => esc_html__('Import and Export your Redux Framework settings from file, text or URL.', 'hermes'),
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

            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => esc_html__('Theme Information', 'hermes'),
                //'desc'      => esc_html__('<p class="description">This is the Description. Again HTML is allowed</p>', 'hermes'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => esc_html__('Theme Information 1', 'hermes'),
                'content'   => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'hermes')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => esc_html__('Theme Information 2', 'hermes'),
                'content'   => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'hermes')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = esc_html__('<p>This is the sidebar content, HTML is allowed.</p>', 'hermes');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'hermes_opt',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => esc_html__('Theme Options', 'hermes'),
                'page_title'        => esc_html__('Theme Options', 'hermes'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => true,                    // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
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

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                //$this->args['intro_text'] = sprintf(esc_html__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'hermes'), $v);
            } else {
                //$this->args['intro_text'] = esc_html__('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'hermes');
            }

            // Add content after the form.
            //$this->args['footer_text'] = esc_html__('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'hermes');
        }

    }   
    global $reduxConfig;
    $reduxConfig = new Hermes_Theme_Config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
