<?php
/**
 * Theme custom styles
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if (!function_exists('trueman_action_theme_styles_theme_setup')) {
	add_action( 'trueman_action_before_init_theme', 'trueman_action_theme_styles_theme_setup', 1 );
	function trueman_action_theme_styles_theme_setup() {
	
		// Add theme fonts in the used fonts list
		add_filter('trueman_filter_used_fonts',			'trueman_filter_theme_styles_used_fonts');
		// Add theme fonts (from Google fonts) in the main fonts list (if not present).
		add_filter('trueman_filter_list_fonts',			'trueman_filter_theme_styles_list_fonts');

		// Add theme stylesheets
		add_action('trueman_action_add_styles',			'trueman_action_theme_styles_add_styles');
		// Add theme inline styles
		add_filter('trueman_filter_add_styles_inline',		'trueman_filter_theme_styles_add_styles_inline');

		// Add theme scripts
		add_action('trueman_action_add_scripts',			'trueman_action_theme_styles_add_scripts');
		// Add theme scripts inline
		add_filter('trueman_filter_localize_script',		'trueman_filter_theme_styles_localize_script');

		// Add theme less files into list for compilation
		add_filter('trueman_filter_compile_less',			'trueman_filter_theme_styles_compile_less');


		/* Color schemes
		
		// Block's border and background
		bd_color		- border for the entire block
		bg_color		- background color for the entire block
		// Next settings are deprecated
		//bg_image, bg_image_position, bg_image_repeat, bg_image_attachment  - first background image for the entire block
		//bg_image2,bg_image2_position,bg_image2_repeat,bg_image2_attachment - second background image for the entire block
		
		// Additional accented colors (if need)
		accent2			- theme accented color 2
		accent2_hover	- theme accented color 2 (hover state)		
		accent3			- theme accented color 3
		accent3_hover	- theme accented color 3 (hover state)		
		
		// Headers, text and links
		text			- main content
		text_light		- post info
		text_dark		- headers
		text_link		- links
		text_hover		- hover links
		
		// Inverse blocks
		inverse_text	- text on accented background
		inverse_light	- post info on accented background
		inverse_dark	- headers on accented background
		inverse_link	- links on accented background
		inverse_hover	- hovered links on accented background
		
		// Input colors - form fields
		input_text		- inactive text
		input_light		- placeholder text
		input_dark		- focused text
		input_bd_color	- inactive border
		input_bd_hover	- focused borde
		input_bg_color	- inactive background
		input_bg_hover	- focused background
		
		// Alternative colors - highlight blocks, form fields, etc.
		alter_text		- text on alternative background
		alter_light		- post info on alternative background
		alter_dark		- headers on alternative background
		alter_link		- links on alternative background
		alter_hover		- hovered links on alternative background
		alter_bd_color	- alternative border
		alter_bd_hover	- alternative border for hovered state or active field
		alter_bg_color	- alternative background
		alter_bg_hover	- alternative background for hovered state or active field 
		// Next settings are deprecated
		//alter_bg_image, alter_bg_image_position, alter_bg_image_repeat, alter_bg_image_attachment - background image for the alternative block
		
		*/

		// Add color schemes
		trueman_add_color_scheme('original', array(

			'title'					=> esc_html__('Original', 'trueman'),
			
			// Whole block border and background
			'bd_color'				=> '#e4e7e8',
			'bg_color'				=> '#ffffff', //+
			
			// Headers, text and links colors
			'text'					=> '#666a6d', //+
			'text_light'			=> '#acb4b6',
			'text_dark'				=> '#323c42', //+
			'text_link'				=> '#aaa555', //+
			'text_hover'			=> '#928e49', //+

			// Inverse colors
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#ffffff',
		
			// Input fields
			'input_text'			=> '#666a6d', //+
			'input_light'			=> '#acb4b6',
			'input_dark'			=> '#232a34',
			'input_bd_color'		=> '#dddddd',
			'input_bd_hover'		=> '#bbbbbb',
			'input_bg_color'		=> '#eeeeee', //+
			'input_bg_hover'		=> '#f0f0f0',
		
			// Alternative blocks (submenu items, etc.)
			'alter_text'			=> '#a3a7a9', //+
			'alter_light'			=> '#acb4b6',
			'alter_dark'			=> '#232a34',
			'alter_link'			=> '#20c7ca',
			'alter_hover'			=> '#189799',
			'alter_bd_color'		=> '#dddddd',
			'alter_bd_hover'		=> '#bbbbbb',
			'alter_bg_color'		=> '#353535', //+
			'alter_bg_hover'		=> '#f0f0f0',
			)
		);

		/* Font slugs:
		h1 ... h6	- headers
		p			- plain text
		link		- links
		info		- info blocks (Posted 15 May, 2015 by John Doe)
		menu		- main menu
		submenu		- dropdown menus
		logo		- logo text
		button		- button's caption
		input		- input fields
		*/

		// Add Custom fonts
		trueman_add_custom_font('h1', array(
			'title'			=> esc_html__('Heading 1', 'trueman'),
			'description'	=> '',
			'font-family'	=> 'Squada One',
			'font-size' 	=> '6.667em',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.5em',
			'margin-bottom'	=> '0.4em'
			)
		);
		trueman_add_custom_font('h2', array(
			'title'			=> esc_html__('Heading 2', 'trueman'),
			'description'	=> '',
			'font-family'	=> 'Squada One',
			'font-size' 	=> '4em',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.6667em',
			'margin-bottom'	=> '0.4em'
			)
		);
		trueman_add_custom_font('h3', array(
			'title'			=> esc_html__('Heading 3', 'trueman'),
			'description'	=> '',
			'font-family'	=> 'Squada One',
			'font-size' 	=> '2em',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.6667em',
			'margin-bottom'	=> '0.4em'
			)
		);
		trueman_add_custom_font('h4', array(
			'title'			=> esc_html__('Heading 4', 'trueman'),
			'description'	=> '',
			'font-family'	=> 'Squada One',
			'font-size' 	=> '1.667em',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '1.2em',
			'margin-bottom'	=> '0.7em'
			)
		);
		trueman_add_custom_font('h5', array(
			'title'			=> esc_html__('Heading 5', 'trueman'),
			'description'	=> '',
			'font-family'	=> 'Squada One',
			'font-size' 	=> '1.667em',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '1.2em',
			'margin-bottom'	=> '0.725em'
			)
		);
		trueman_add_custom_font('h6', array(
			'title'			=> esc_html__('Heading 6', 'trueman'),
			'description'	=> '',
			'font-family'	=> 'Squada One',
			'font-size' 	=> '0.933em',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '1.25em',
			'margin-bottom'	=> '1.15em'
			)
		);
		trueman_add_custom_font('p', array(
			'title'			=> esc_html__('Text', 'trueman'),
			'description'	=> '',
			'font-family'	=> 'PT Serif',
			'font-size' 	=> '15px',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.6em',
			'margin-top'	=> '',
			'margin-bottom'	=> '1em'
			)
		);
		trueman_add_custom_font('link', array(
			'title'			=> esc_html__('Links', 'trueman'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> ''
			)
		);
		trueman_add_custom_font('info', array(
			'title'			=> esc_html__('Post info', 'trueman'),
			'description'	=> '',
			'font-family'	=> 'Squada One',
			'font-size' 	=> '1em',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1em',
			'margin-top'	=> '',
			'margin-bottom'	=> '1.5em'
			)
		);
		trueman_add_custom_font('menu', array(
			'title'			=> esc_html__('Main menu items', 'trueman'),
			'description'	=> '',
			'font-family'	=> 'Squada One',
			'font-size' 	=> '1.2em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1em',
			'margin-top'	=> '1.4em',
			'margin-bottom'	=> '1.05em'
			)
		);
		trueman_add_custom_font('submenu', array(
			'title'			=> esc_html__('Dropdown menu items', 'trueman'),
			'description'	=> '',
			'font-family'	=> 'Squada One',
			'font-size' 	=> '',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1em',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
		trueman_add_custom_font('logo', array(
			'title'			=> esc_html__('Logo', 'trueman'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '2.8571em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '0.75em',
			'margin-top'	=> '1.8em',
			'margin-bottom'	=> '0.15em'
			)
		);
		trueman_add_custom_font('button', array(
			'title'			=> esc_html__('Buttons', 'trueman'),
			'description'	=> '',
			'font-family'	=> 'Squada One',
			'font-size' 	=> '1.2em',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.2857em'
			)
		);
		trueman_add_custom_font('input', array(
			'title'			=> esc_html__('Input fields', 'trueman'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.2857em'
			)
		);

	}
}





//------------------------------------------------------------------------------
// Theme fonts
//------------------------------------------------------------------------------

// Add theme fonts in the used fonts list
if (!function_exists('trueman_filter_theme_styles_used_fonts')) {
	function trueman_filter_theme_styles_used_fonts($theme_fonts) {
		$theme_fonts['PT Serif'] = 1;
		$theme_fonts['Squada One'] = 1;
		return $theme_fonts;
	}
}

// Add theme fonts (from Google fonts) in the main fonts list (if not present).
// To use custom font-face you not need add it into list in this function
// How to install custom @font-face fonts into the theme?
// All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!
// Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.
// Create your @font-face kit by using Fontsquirrel @font-face Generator (http://www.fontsquirrel.com/fontface/generator)
// and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install
if (!function_exists('trueman_filter_theme_styles_list_fonts')) {
	function trueman_filter_theme_styles_list_fonts($list) {
		 if (!isset($list['Advent Pro'])) {
				$list['Advent Pro'] = array(
					'family' => 'serif',																						// (required) font family
					'link'   => 'PT+Serif:400,400italic,700,700italic',																// (optional) if you use Google font repository
					);
		 }
		 if (!isset($list['Squada One'])) {
				$list['Squada One'] = array(
					'family' => 'cursive',																							// (required) font family
					'link'   => 'Squada+One',																						// (optional) if you use Google font repository
					);
		 }
		return $list;
	}
}



//------------------------------------------------------------------------------
// Theme stylesheets
//------------------------------------------------------------------------------

// Add theme.less into list files for compilation
if (!function_exists('trueman_filter_theme_styles_compile_less')) {
	function trueman_filter_theme_styles_compile_less($files) {
		if (file_exists(trueman_get_file_dir('css/theme.less'))) {
		 	$files[] = trueman_get_file_dir('css/theme.less');
		}
		return $files;	
	}
}

// Add theme stylesheets
if (!function_exists('trueman_action_theme_styles_add_styles')) {
	function trueman_action_theme_styles_add_styles() {
		// Add stylesheet files only if LESS supported
		if ( trueman_get_theme_setting('less_compiler') != 'no' ) {
			wp_enqueue_style( 'trueman-theme-style', trueman_get_file_url('css/theme.css'), array(), null );
			wp_add_inline_style( 'trueman-theme-style', trueman_get_inline_css() );
		}
	}
}

// Add theme inline styles
if (!function_exists('trueman_filter_theme_styles_add_styles_inline')) {
	function trueman_filter_theme_styles_add_styles_inline($custom_style) {
		// Todo: add theme specific styles in the $custom_style to override
		//       rules from style.css and shortcodes.css
		// Example:
		//		$scheme = trueman_get_custom_option('body_scheme');
		//		if (empty($scheme)) $scheme = 'original';
		//		$clr = trueman_get_scheme_color('text_link');
		//		if (!empty($clr)) {
		// 			$custom_style .= '
		//				a,
		//				.bg_tint_light a,
		//				.top_panel .content .search_wrap.search_style_default .search_form_wrap .search_submit,
		//				.top_panel .content .search_wrap.search_style_default .search_icon,
		//				.search_results .post_more,
		//				.search_results .search_results_close {
		//					color:'.esc_attr($clr).';
		//				}
		//			';
		//		}

		// Submenu width
		$menu_width = trueman_get_theme_option('menu_width');
		if (!empty($menu_width)) {
			$custom_style .= "
				/* Submenu width */
				.menu_side_nav > li ul,
				.menu_main_nav > li ul {
					width: ".intval($menu_width)."px;
				}
				.menu_side_nav > li > ul ul,
				.menu_main_nav > li > ul ul {
					left:".intval($menu_width+4)."px;
				}
				.menu_side_nav > li > ul ul.submenu_left,
				.menu_main_nav > li > ul ul.submenu_left {
					left:-".intval($menu_width+1)."px;
				}
			";
		}
	
		// Logo height
		$logo_height = trueman_get_custom_option('logo_height');
		if (!empty($logo_height)) {
			$custom_style .= "
				/* Logo header height */
				.sidebar_outer_logo .logo_main,
				.top_panel_wrap .logo_main,
				.top_panel_wrap .logo_fixed {
					height:".intval($logo_height)."px;
				}
			";
		}
	
		// Logo top offset
		$logo_offset = trueman_get_custom_option('logo_offset');
		if (!empty($logo_offset)) {
			$custom_style .= "
				/* Logo header top offset */
				.top_panel_wrap .logo {
					margin-top:".intval($logo_offset)."px;
				}
			";
		}

		// Logo footer height
		$logo_height = trueman_get_theme_option('logo_footer_height');
		if (!empty($logo_height)) {
			$custom_style .= "
				/* Logo footer height */
				.contacts_wrap .logo img {
					height:".intval($logo_height)."px;
				}
			";
		}

		// Custom css from theme options
		$custom_style .= trueman_get_custom_option('custom_css');

		return $custom_style;	
	}
}


//------------------------------------------------------------------------------
// Theme scripts
//------------------------------------------------------------------------------

// Add theme scripts
if (!function_exists('trueman_action_theme_styles_add_scripts')) {
	function trueman_action_theme_styles_add_scripts() {
		if (trueman_get_theme_option('show_theme_customizer') == 'yes' && file_exists(trueman_get_file_dir('js/theme.customizer.js')))
			wp_enqueue_script( 'trueman-theme_styles-customizer-script', trueman_get_file_url('js/theme.customizer.js'), array(), null );
	}
}

// Add theme scripts inline
if (!function_exists('trueman_filter_theme_styles_localize_script')) {
	function trueman_filter_theme_styles_localize_script($vars) {
		if (empty($vars['theme_font']))
			$vars['theme_font'] = trueman_get_custom_font_settings('p', 'font-family');
		$vars['theme_color'] = trueman_get_scheme_color('text_dark');
		$vars['theme_bg_color'] = trueman_get_scheme_color('bg_color');
		return $vars;
	}
}
?>