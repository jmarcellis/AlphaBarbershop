<?php
/**
 * Theme colors and fonts customization via WP Customizer
 */

/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'trueman_core_customizer_wp_theme_setup' ) ) {
	add_action( 'trueman_action_before_init_theme', 'trueman_core_customizer_wp_theme_setup' );
	function trueman_core_customizer_wp_theme_setup() {
		if (is_customize_preview() && !is_admin())
			add_action( 'wp_loaded', 						'trueman_customizer_wp_load_mods' );

		add_action( 'customize_register',					'trueman_customizer_wp_custom_controls' );
		add_action( 'customize_register', 					'trueman_customizer_wp_register_controls', 11 );
		add_action( 'customize_save_after',					'trueman_customizer_wp_action_save_after' );
		add_action( 'customize_controls_enqueue_scripts',	'trueman_customizer_wp_control_js' );
		add_action( 'customize_preview_init',				'trueman_customizer_wp_preview_js' );
	}
}

//--------------------------------------------------------------
//-- Register Customizer Controls
//--------------------------------------------------------------

define('CUSTOMIZE_PRIORITY', 200);		// Start priority for the new controls

if (!function_exists('trueman_customizer_wp_register_controls')) {
	function trueman_customizer_wp_register_controls( $wp_customize ) {

		// Setup standard WP Controls
		// ---------------------------------
		
		// Remove unused sections
		$wp_customize->remove_section( 'colors');
		$wp_customize->remove_section( 'static_front_page');

		// Reorder standard WP sections
		$sec = $wp_customize->get_panel( 'nav_menus' );
		if (is_object($sec)) $sec->priority = 30;
		$sec = $wp_customize->get_panel( 'widgets' );
		if (is_object($sec)) $sec->priority = 40;
		$sec = $wp_customize->get_section( 'title_tagline' );
		if (is_object($sec)) $sec->priority = 50;
		$sec = $wp_customize->get_section( 'background_image' );
		if (is_object($sec)) $sec->priority = 60;
		$sec = $wp_customize->get_section( 'header_image' );
		if (is_object($sec)) $sec->priority = 70;
		
		// Modify standard WP controls
		$sec = $wp_customize->get_setting( 'blogname' );
		if (is_object($sec)) $sec->transport = 'postMessage';

		$sec = $wp_customize->get_setting( 'blogdescription' );
		if (is_object($sec)) $sec->transport = 'postMessage';
		
		$sec = $wp_customize->get_section( 'background_image' );
		if (is_object($sec)) {
			$sec->title = esc_html__('Background', 'trueman');
			$sec->description = esc_html__('Used only if "Content - Body style" equal to "boxed"', 'trueman');
		}
		
		// Move standard option 'Background Color' to the section 'Background Image'
		$wp_customize->add_setting( 'background_color', array(
			'default'        => get_theme_support( 'custom-background', 'default-color' ),
			'theme_supports' => 'custom-background',
			'transport'		 => 'postMessage',
			'sanitize_callback'    => 'sanitize_hex_color_no_hash',
			'sanitize_js_callback' => 'maybe_hash_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
			'label'   => esc_html__( 'Background color', 'trueman' ),
			'section' => 'background_image',
		) ) );


		// Add Theme specific controls
		// ---------------------------------
		
		// Custom colors
		$scheme = trueman_get_custom_option('body_scheme');
		if (empty($scheme) || trueman_storage_empty('custom_colors', $scheme)) $scheme = 'original';

		$options = array(
		
			// Section 'Colors' - choose color scheme and customize separate colors from it
			'scheme' => array(
				"title" => esc_html__('Color scheme', 'trueman'),
				"desc" => wp_kses_data( __("<b>Simple settings</b> - you can change only accented color, used for links, buttons and some accented areas.", 'trueman') )
						. '<br>'
						. wp_kses_data( __("<b>Advanced settings</b> - change all scheme's colors and get full control over the appearance of your site!", 'trueman') ),
				"priority" => 80,
				"type" => "section"
				),
		
			'color_settings' => array(
				"title" => esc_html__('Color settings', 'trueman'),
				"desc" => '',
				"val" => 'simple',
				"options" => array(
					"simple"  => esc_html__("Simple", 'trueman'),
					"advanced" => esc_html__("Advanced", 'trueman')
					),
				"refresh" => false,
				"type" => "switch"
				),
		
			'color_scheme' => array(
				"title" => esc_html__('Color Scheme', 'trueman'),
				"desc" => wp_kses_data( __('Select color scheme to decorate whole site at once', 'trueman') ),
				"val" => $scheme,
				"options" => trueman_get_list_color_schemes(),
				"refresh" => false,
				"type" => "select"
				),
		
			'scheme_storage' => array(
				"title" => esc_html__('Colors storage', 'trueman'),
				"desc" => esc_html__('Hidden storage of the all color from the all color shemes (only for internal usage)', 'trueman'),
				"val" => '',
				"refresh" => false,
				"type" => "hidden"
				),
		
			'scheme_info_main' => array(
				"title" => esc_html__('Colors for the main content', 'trueman'),
				"desc" => wp_kses_data( __('Specify colors for the main content (not for alter blocks)', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"type" => "info"
				),
				
			'bg_color' => array(
				"title" => esc_html__('Background color', 'trueman'),
				"desc" => wp_kses_data( __('Background color of the whole page', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'bg_color'),
				"refresh" => false,
				"type" => "color"
				),
			'bd_color' => array(
				"title" => esc_html__('Border color', 'trueman'),
				"desc" => wp_kses_data( __('Color of the bordered elements, separators, etc.', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'bd_color'),
				"refresh" => false,
				"type" => "color"
				),
		
			'text' => array(
				"title" => esc_html__('Text', 'trueman'),
				"desc" => wp_kses_data( __('Plain text color on single page/post', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'text'),
				"refresh" => false,
				"type" => "color"
				),
			'text_light' => array(
				"title" => esc_html__('Light text', 'trueman'),
				"desc" => wp_kses_data( __('Color of the post meta: post date and author, comments number, etc.', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'text_light'),
				"refresh" => false,
				"type" => "color"
				),
			'text_dark' => array(
				"title" => esc_html__('Dark text', 'trueman'),
				"desc" => wp_kses_data( __('Color of the headers, strong text, etc.', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'text_dark'),
				"refresh" => false,
				"type" => "color"
				),
			'text_link' => array(
				"title" => esc_html__('Links', 'trueman'),
				"desc" => wp_kses_data( __('Color of links and accented areas', 'trueman') ),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'text_link'),
				"refresh" => false,
				"type" => "color"
				),
			'text_hover' => array(
				"title" => esc_html__('Links hover', 'trueman'),
				"desc" => wp_kses_data( __('Hover color for links and accented areas', 'trueman') ),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'text_hover'),
				"refresh" => false,
				"type" => "color"
				),
		
			'scheme_info_alter' => array(
				"title" => esc_html__('Colors for alternative blocks', 'trueman'),
				"desc" => wp_kses_data( __('Specify colors for alternative blocks - rectangular blocks with its own background color (posts in homepage, blog archive, search results, widgets on sidebar, footer, etc.)', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"type" => "info"
				),
		
			'alter_bg_color' => array(
				"title" => esc_html__('Alter background color', 'trueman'),
				"desc" => wp_kses_data( __('Background color of the alternative blocks', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'alter_bg_color'),
				"refresh" => false,
				"type" => "color"
				),
			'alter_bg_hover' => array(
				"title" => esc_html__('Alter hovered background color', 'trueman'),
				"desc" => wp_kses_data( __('Background color for the hovered state of the alternative blocks', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'alter_bg_hover'),
				"refresh" => false,
				"type" => "color"
				),
			'alter_bd_color' => array(
				"title" => esc_html__('Alternative border color', 'trueman'),
				"desc" => wp_kses_data( __('Border color of the alternative blocks', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'alter_bd_color'),
				"refresh" => false,
				"type" => "color"
				),
			'alter_bd_hover' => array(
				"title" => esc_html__('Alternative hovered border color', 'trueman'),
				"desc" => wp_kses_data( __('Border color for the hovered state of the alter blocks', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'alter_bd_hover'),
				"refresh" => false,
				"type" => "color"
				),
			'alter_text' => array(
				"title" => esc_html__('Alter text', 'trueman'),
				"desc" => wp_kses_data( __('Text color of the alternative blocks', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'alter_text'),
				"refresh" => false,
				"type" => "color"
				),
			'alter_light' => array(
				"title" => esc_html__('Alter light', 'trueman'),
				"desc" => wp_kses_data( __('Color of the info blocks inside block with alternative background', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'alter_light'),
				"refresh" => false,
				"type" => "color"
				),
			'alter_dark' => array(
				"title" => esc_html__('Alter dark', 'trueman'),
				"desc" => wp_kses_data( __('Color of the headers inside block with alternative background', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'alter_dark'),
				"refresh" => false,
				"type" => "color"
				),
			'alter_link' => array(
				"title" => esc_html__('Alter link', 'trueman'),
				"desc" => wp_kses_data( __('Color of the links inside block with alternative background', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'alter_link'),
				"refresh" => false,
				"type" => "color"
				),
			'alter_hover' => array(
				"title" => esc_html__('Alter hover', 'trueman'),
				"desc" => wp_kses_data( __('Color of the hovered links inside block with alternative background', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'alter_hover'),
				"refresh" => false,
				"type" => "color"
				),
		
			'scheme_info_input' => array(
				"title" => esc_html__('Colors for the form fields', 'trueman'),
				"desc" => wp_kses_data( __('Specify colors for the form fields and textareas', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"type" => "info"
				),
		
			'input_bg_color' => array(
				"title" => esc_html__('Inactive background', 'trueman'),
				"desc" => wp_kses_data( __('Background color of the inactive form fields', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'input_bg_color'),
				"refresh" => false,
				"type" => "color"
				),
			'input_bg_hover' => array(
				"title" => esc_html__('Active background', 'trueman'),
				"desc" => wp_kses_data( __('Background color of the focused form fields', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'input_bg_hover'),
				"refresh" => false,
				"type" => "color"
				),
			'input_bd_color' => array(
				"title" => esc_html__('Inactive border', 'trueman'),
				"desc" => wp_kses_data( __('Color of the border in the inactive form fields', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'input_bd_color'),
				"refresh" => false,
				"type" => "color"
				),
			'input_bd_hover' => array(
				"title" => esc_html__('Active border', 'trueman'),
				"desc" => wp_kses_data( __('Color of the border in the focused form fields', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'input_bd_hover'),
				"refresh" => false,
				"type" => "color"
				),
			'input_text' => array(
				"title" => esc_html__('Inactive field', 'trueman'),
				"desc" => wp_kses_data( __('Color of the text in the inactive fields', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'input_text'),
				"refresh" => false,
				"type" => "color"
				),
			'input_light' => array(
				"title" => esc_html__('Disabled field', 'trueman'),
				"desc" => wp_kses_data( __('Color of the disabled field', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'input_light'),
				"refresh" => false,
				"type" => "color"
				),
			'input_dark' => array(
				"title" => esc_html__('Active field', 'trueman'),
				"desc" => wp_kses_data( __('Color of the active field', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'input_dark'),
				"refresh" => false,
				"type" => "color"
				),
		
			'scheme_info_inverse' => array(
				"title" => esc_html__('Colors for inverse blocks', 'trueman'),
				"desc" => wp_kses_data( __('Specify colors for inverse blocks, rectangular blocks with background color equal to the links color or one of accented colors (if used in the current theme)', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"type" => "info"
				),
		
			'inverse_text' => array(
				"title" => esc_html__('Inverse text', 'trueman'),
				"desc" => wp_kses_data( __('Color of the text inside block with accented background', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'inverse_text'),
				"refresh" => false,
				"type" => "color"
				),
			'inverse_light' => array(
				"title" => esc_html__('Inverse light', 'trueman'),
				"desc" => wp_kses_data( __('Color of the info blocks inside block with accented background', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'inverse_light'),
				"refresh" => false,
				"type" => "color"
				),
			'inverse_dark' => array(
				"title" => esc_html__('Inverse dark', 'trueman'),
				"desc" => wp_kses_data( __('Color of the headers inside block with accented background', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'inverse_dark'),
				"refresh" => false,
				"type" => "color"
				),
			'inverse_link' => array(
				"title" => esc_html__('Inverse link', 'trueman'),
				"desc" => wp_kses_data( __('Color of the links inside block with accented background', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'inverse_link'),
				"refresh" => false,
				"type" => "color"
				),
			'inverse_hover' => array(
				"title" => esc_html__('Inverse hover', 'trueman'),
				"desc" => wp_kses_data( __('Color of the hovered links inside block with accented background', 'trueman') ),
				"dependency" => array(
					'color_settings' => array('^simple')
				),
				"val" => trueman_storage_get_array('custom_colors', $scheme, 'inverse_hover'),
				"refresh" => false,
				"type" => "color"
				)
		);

		// Custom fonts
		$fonts = trueman_storage_get('custom_fonts');
		if (is_array($fonts) && count($fonts) > 0) {
			$list_fonts = trueman_get_list_fonts(true);
			$list_fonts_names = array();
			if (is_array($list_fonts) && count($list_fonts) > 0) {
				foreach ($list_fonts as $k=>$v)
					$list_fonts_names[$k] = $k;
			}
			$list_styles = trueman_get_list_fonts_styles(true);
			$list_weight = array(
				'inherit' => esc_html__("Inherit", 'trueman'), 
				'100' => esc_html__('100 (Light)', 'trueman'), 
				'300' => esc_html__('300 (Thin)',  'trueman'),
				'400' => esc_html__('400 (Normal)', 'trueman'),
				'500' => esc_html__('500 (Semibold)', 'trueman'),
				'600' => esc_html__('600 (Semibold)', 'trueman'),
				'700' => esc_html__('700 (Bold)', 'trueman'),
				'900' => esc_html__('900 (Black)', 'trueman')
			);
			// Section 'Fonts' - settings for the headers, plain text, logo, menu, etc.
			$options['fonts'] = array(
				"title" => esc_html__('Fonts', 'trueman'),
				"desc" => wp_kses_data( __("Font settings for the headers, plain text, logo, menu, etc.", 'trueman') ),
				"priority" => 90,
				"type" => "panel"
				);
			foreach ($fonts as $slug=>$font) {
				$options["{$slug}-font-info"] = array(
					"title" => isset($font['title']) ? $font['title'] : trueman_strtoproper($slug),
					"desc" => wp_kses_data( sprintf(__('Select font-family, size and style for %s', 'trueman'), isset($font['title']) ? $font['title'] : trueman_strtoproper($slug)) ),
					"type" => "section"
				);
				if (isset($font['font-family'])) {
					$options["{$slug}-font-family"] = array(
						"title" => isset($font['title']) ? $font['title'] : trueman_strtoproper($slug),
						"desc" => isset($font['description']) ? $font['description'] : '',
						"val" => $font['font-family'] ? $font['font-family'] : 'inherit',
						"options" => $list_fonts_names,
						"refresh" => false,
						"type" => "select");
				}
				if (isset($font['font-size'])) {
					$options["{$slug}-font-size"] = array(
						"title" => esc_html__('Size', 'trueman'),
						"desc" => '',
						"val" => trueman_is_inherit_option($font['font-size']) ? '' : $font['font-size'],
						"refresh" => false,
						"type" => "text");
				}
				if (isset($font['line-height'])) {
					$options["{$slug}-line-height"] = array(
						"title" => esc_html__('Line height', 'trueman'),
						"desc" => '',
						"val" => trueman_is_inherit_option($font['line-height']) ? '' : $font['line-height'],
						"refresh" => false,
						"type" => "text");
				}
				if (isset($font['font-weight'])) {
					$options["{$slug}-font-weight"] = array(
						"title" => esc_html__('Weight', 'trueman'),
						"desc" => '',
						"val" => $font['font-weight'] ? $font['font-weight'] : 'inherit',
						"options" => $list_weight,
						"refresh" => false,
						"type" => "select");
				}
				if (isset($font['font-style'])) {
					$options["{$slug}-font-style"] = array(
						"title" => esc_html__('Style', 'trueman'),
						"desc" => '',
						"val" => $font['font-style'] ? $font['font-style'] : 'inherit',
						"options" => $list_styles,
						"refresh" => false,
						"type" => "select");
				}
				if (isset($font['margin-top'])) {
					$options["{$slug}-margin-top"] = array(
						"title" => esc_html__('Margin Top', 'trueman'),
						"desc" => '',
						"val" => trueman_is_inherit_option($font['margin-top']) ? '' : $font['margin-top'],
						"refresh" => false,
						"type" => "text");
				}
				if (isset($font['margin-bottom'])) {
					$options["{$slug}-margin-bottom"] = array(
						"title" => esc_html__('Margin Bottom', 'trueman'),
						"desc" => '',
						"val" => trueman_is_inherit_option($font['margin-bottom']) ? '' : $font['margin-bottom'],
						"refresh" => false,
						"type" => "text");
				}
				$options["{$slug}-font-info-end"] = array(
					"type" => "section_end"
				);
			}
			$options['fonts_end'] = array(
				"type" => "panel_end"
				);
		}

		$panels = array('');
		$p = 0;
		$sections = array('');
		$s = 0;
		$i = 0;
		$depends = array();

		foreach ($options as $id=>$opt) {
			
			$i++;

			if (isset($opt['dependency'])) 
				$depends[$id] = $opt['dependency'];
			
			if (!empty($opt['hidden'])) continue;

			if ($opt['type'] == 'panel') {

				$sec = $wp_customize->get_panel( $id );
				if ( is_object($sec) && !empty($sec->title) ) {
					$sec->title      = $opt['title'];
					$sec->description= $opt['desc'];
					if ( !empty($opt['priority']) )	$sec->priority = $opt['priority'];
				} else {
					$wp_customize->add_panel( esc_attr($id) , array(
						'title'      => $opt['title'],
						'description'=> $opt['desc'],
						'priority'	 => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i
					) );
				}
				array_push($panels, $id);
				$p++;

			} else if ($opt['type'] == 'panel_end') {

				array_pop($panels);
				$p--;

			} else if ($opt['type'] == 'section') {

				$sec = $wp_customize->get_section( $id );
				if ( is_object($sec) && !empty($sec->title) ) {
					$sec->title      = $opt['title'];
					$sec->description= $opt['desc'];
					if ( !empty($opt['priority']) )	$sec->priority = $opt['priority'];
				} else {
					$wp_customize->add_section( esc_attr($id) , array(
						'title'      => $opt['title'],
						'description'=> $opt['desc'],
						'panel'  => esc_attr($panels[$p]),
						'priority'	 => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i
					) );
				}
				array_push($sections, $id);
				$s++;

			} else if ($opt['type'] == 'section_end') {

				array_pop($sections);
				$s--;

			} else if ($opt['type'] == 'select') {

				$wp_customize->add_setting( $id, array(
					'default'           => $opt['val'],
					'sanitize_callback' => 'trueman_sanitize_value',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );
			
				$wp_customize->add_control( $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority'	 => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
					'type'     => 'select',
					'choices'  => $opt['options']
				) );

			} else if ($opt['type'] == 'radio') {

				$wp_customize->add_setting( $id, array(
					'default'           => $opt['val'],
					'sanitize_callback' => 'trueman_sanitize_value',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );
			
				$wp_customize->add_control( $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority'	 => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
					'type'     => 'radio',
					'choices'  => $opt['options']
				) );

			} else if ($opt['type'] == 'switch') {

				$wp_customize->add_setting( $id, array(
					'default'           => $opt['val'],
					'sanitize_callback' => 'trueman_sanitize_value',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );
			
				$wp_customize->add_control( new TRUEMAN_Customize_Switch_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
					'choices'  => $opt['options']
				) ) );

			} else if ($opt['type'] == 'checkbox') {

				$wp_customize->add_setting( $id, array(
					'default'           => $opt['val'],
					'sanitize_callback' => 'trueman_sanitize_value',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );
			
				$wp_customize->add_control( $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority'	 => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
					'type'     => 'checkbox'
				) );

			} else if ($opt['type'] == 'color') {

				$wp_customize->add_setting( $id, array(
					'default'           => $opt['val'],
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );
			
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority'	 => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
				) ) );

			} else if ($opt['type'] == 'image') {

				$wp_customize->add_setting( $id, array(
					'default'           => $opt['val'],
					'sanitize_callback' => 'trueman_sanitize_value',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );
			
				$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
				) ) );

			} else if ($opt['type'] == 'info') {
			
				$wp_customize->add_setting( $id, array(
					'default'           => '',
					'sanitize_callback' => 'trueman_sanitize_value',
					'transport'         => 'postMessage'
				) );

				$wp_customize->add_control( new TRUEMAN_Customize_Info_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
				) ) );

			} else if ($opt['type'] == 'hidden') {
			
				$wp_customize->add_setting( $id, array(
					'default'           => $opt['val'],
					'sanitize_callback' => 'trueman_sanitize_html',
					'transport'         => 'postMessage'
				) );

				$wp_customize->add_control( new TRUEMAN_Customize_Hidden_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
				) ) );

			} else {

				$wp_customize->add_setting( $id, array(
					'default'           => $opt['val'],
					'sanitize_callback' => 'trueman_sanitize_html',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );
			
				$wp_customize->add_control( $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority'	 => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
					'type'     => $opt['type']	//'text'
				) );
			}

		}

		// Store dependencies for JS
		trueman_storage_set('customizer_depends', $depends);
	}
}


// Create custom controls for customizer
if (!function_exists('trueman_customizer_wp_custom_controls')) {
	function trueman_customizer_wp_custom_controls( $wp_customize ) {
	
		class TRUEMAN_Customize_Info_Control extends WP_Customize_Control {
			public $type = 'info';

			public function render_content() {
				?>
				<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<span class="customize-control-description desctiption"><?php echo esc_html( $this->description ); ?></span>
				</label>
				<?php
			}
		}
	
		class TRUEMAN_Customize_Switch_Control extends WP_Customize_Control {
			public $type = 'switch';

			public function render_content() {
				?>
				<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<span class="customize-control-description desctiption"><?php echo esc_html( $this->description ); ?></span>
				<?php
				if (is_array($this->choices) && count($this->choices)>0) {
					foreach ($this->choices as $k=>$v) {
						?><label><input type="radio" name="_customize-radio-<?php echo esc_attr($this->id); ?>" <?php $this->link(); ?> value="<?php echo esc_attr($k); ?>">
						<?php echo esc_html($v); ?></label><?php
					}
				}
				?>
				</label>
				<?php
			}
		}
	
		class TRUEMAN_Customize_Hidden_Control extends WP_Customize_Control {
			public $type = 'hidden';

			public function render_content() {
				?>
				<input type="hidden" name="_customize-hidden-<?php echo esc_attr($this->id); ?>" <?php $this->link(); ?> value="">
				<?php
			}
		}
	
	}
}


// Sanitize plain value
if (!function_exists('trueman_sanitize_value')) {
	function trueman_sanitize_value($value) {
		return empty($value) ? $value : trim(strip_tags($value));
	}
}


// Sanitize html value
if (!function_exists('trueman_sanitize_html')) {
	function trueman_sanitize_html($value) {
		return empty($value) ? $value : wp_kses_data($value);
	}
}


//--------------------------------------------------------------
// Step 2: Load current theme customization mods
//--------------------------------------------------------------
if (!function_exists('trueman_customizer_wp_load_mods')) {
	function trueman_customizer_wp_load_mods() {

		// Store new schemes colors
		$scheme_chg = false;
		$schemes = trueman_storage_get('custom_colors');
		$storage = get_theme_mod('scheme_storage', '');
		if (trueman_substr($storage, 0, 2)=='a:') {
			$storage = trueman_unserialize($storage);
			if (is_array($schemes) && count($schemes) > 0)  {
				foreach ($schemes as $k=>$v) {
					if (is_array($v)) {
						foreach ($v as $k1=>$v1) {
							if (isset($storage[$k][$k1])) {
								$scheme_chg = $scheme_chg || $v1!=$storage[$k][$k1];
								$schemes[$k][$k1] = $storage[$k][$k1];
						}
				}
					} else if (isset($storage[$k])) {
						$scheme_chg = $scheme_chg || $v!=$storage[$k];
						$schemes[$k] = $storage[$k];
					}
				}
				if ($scheme_chg) trueman_storage_set('custom_colors', $schemes);
			}
		}
		// Refresh array with fonts from POST data
		$fonts_chg = false;
		$fonts = trueman_storage_get('custom_fonts');
		if (is_array($fonts) && count($fonts) > 0) {
			foreach ($fonts as $slug=>$font) {
				if (is_array($font) && count($font) > 0) {
					foreach ($font as $key=>$value) {
						$val = get_theme_mod($slug.'-'.$key, $fonts[$slug][$key]);
						$fonts_chg = $fonts_chg || $fonts[$slug][$key] != $val;
						$fonts[$slug][$key] = trueman_is_inherit_option($val) ? '' : $val;
					}
				}
			}
			if ($fonts_chg) trueman_storage_set('custom_fonts', $fonts);
		}
		// Touch theme.less to recompile it with new fonts and colors
		if ( $scheme_chg || $fonts_chg ) {
			if (!empty($_COOKIE[trueman_storage_get('options_prefix').'_compile_less']) ) {
				// Delete cookie "compile_less"
				setcookie(trueman_storage_get('options_prefix').'_compile_less', '', time()-3600*24, '/');
				// Set option to restore less 
				update_option(trueman_storage_get('options_prefix') . '_compile_less', 1);
				// Touch theme.less
				touch(trueman_get_file_dir('css/theme.less'));
			}
		}
	}
}


//--------------------------------------------------------------
// Save custom settings in CSS file
//--------------------------------------------------------------

// Save CSS with custom colors and fonts after save custom options
if (!function_exists('trueman_customizer_wp_action_save_after')) {
	function trueman_customizer_wp_action_save_after($api=false) {
		$settings = $api->settings();

		// Store new schemes colors
		$scheme_chg = false;
		$schemes = trueman_storage_get('custom_colors');
		$storage = $settings['scheme_storage']->value();
		if (trueman_substr($storage, 0, 2)=='a:') {
			$storage = trueman_unserialize($storage);
			if (is_array($schemes) && count($schemes) > 0)  {
				foreach ($schemes as $k=>$v) {
					if (is_array($v)) {
						foreach ($v as $k1=>$v1) {
							if (isset($storage[$k][$k1])) {
								$scheme_chg = $scheme_chg || $v1!=$storage[$k][$k1];
								$schemes[$k][$k1]=$storage[$k][$k1];
							}
						}
					} else if (isset($storage[$k])) {
						$scheme_chg = $scheme_chg || $v!=$storage[$k];
						$schemes[$k] = $storage[$k];
						}
				}
				if ($scheme_chg) {
					$schemes = apply_filters('trueman_filter_save_custom_colors', $schemes);
					trueman_storage_set('custom_colors', $schemes);
					update_option( trueman_storage_get('options_prefix') . '_options_custom_colors', $schemes);
				}
			}
		}

		// Refresh array with fonts from POST data
		$fonts_chg = false;
		$fonts = trueman_storage_get('custom_fonts');
		if (is_array($fonts) && count($fonts) > 0) {
			foreach ($fonts as $slug=>$font) {
				if (is_array($font) && count($font) > 0) {
					foreach ($font as $key=>$value) {
						if (isset($settings[$slug.'-'.$key])) {
							$val = $settings[$slug.'-'.$key]->value();
							$fonts_chg = $fonts_chg || $fonts[$slug][$key] != $val;
							$fonts[$slug][$key] = trueman_is_inherit_option($val) ? '' : $val;
						}
					}
				}
			}
			if ($fonts_chg) {
				$fonts = apply_filters('trueman_filter_save_custom_fonts', $fonts);
				trueman_storage_set('custom_fonts', $fonts);
				update_option( trueman_storage_get('options_prefix') . '_options_custom_fonts', $fonts);
			}
		}
		
		// Save theme.css with new fonts and colors
		if ($scheme_chg || $fonts_chg) {
			if (trueman_get_theme_setting('less_compiler')=='no') {
				// Save custom css
				trueman_fpc( trueman_get_file_dir('css/theme.css'), trueman_get_custom_css());
			} else {
				// Recompile theme.less
				do_action('trueman_action_compile_less');
			}
		}
	}
}


//--------------------------------------------------------------
// Customizer JS and CSS
//--------------------------------------------------------------

// Binds JS listener to make Customizer color_scheme control.
// Passes color scheme data as color_scheme global.
if ( !function_exists( 'trueman_customizer_wp_control_js' ) ) {
	function trueman_customizer_wp_control_js() {
		wp_enqueue_style( 'trueman-customizer-wp', trueman_get_file_url('core/core.customizer.wp/core.customizer.wp.css') );
		wp_enqueue_script( 'trueman-customizer-wp-color-scheme-control', trueman_get_file_url('core/core.customizer.wp/core.customizer.wp.color-scheme.js'), array( 'customize-controls', 'iris', 'underscore', 'wp-util' ) );
		wp_localize_script( 'trueman-customizer-wp-color-scheme-control', 'trueman_color_schemes', trueman_storage_get('custom_colors') );
		wp_localize_script( 'trueman-customizer-wp-color-scheme-control', 'trueman_fonts', trueman_storage_get('custom_fonts') );
		wp_localize_script( 'trueman-customizer-wp-color-scheme-control', 'trueman_dependencies', trueman_storage_get('customizer_depends') );
		wp_localize_script( 'trueman-customizer-wp-color-scheme-control', 'trueman_customizer_vars', array(
			'need_refresh' => trueman_get_theme_setting('less_compiler')!='no',
			'msg_refresh' => esc_html__('Refresh', 'trueman')
		) );
	}
}

// Binds JS handlers to make the Customizer preview reload changes asynchronously.
if ( !function_exists( 'trueman_customizer_wp_preview_js' ) ) {
	function trueman_customizer_wp_preview_js() {
		wp_enqueue_script( 'trueman-customizer-wp-preview', trueman_get_file_url('core/core.customizer.wp/core.customizer.wp.preview.js'), array( 'customize-preview' ) );
		wp_localize_script( 'trueman-customizer-wp-preview', 'trueman_previewer_vars', array(
			'need_refresh' => trueman_get_theme_setting('less_compiler')!='no',
			'options_prefix' => trueman_storage_get('options_prefix')
		) );
	}
}
?>