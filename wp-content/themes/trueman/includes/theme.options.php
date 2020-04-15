<?php

/* Theme setup section
-------------------------------------------------------------------- */

// ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
// Framework settings

trueman_storage_set('settings', array(
	
	'less_compiler'		=> 'lessc',								// no|lessc|less|external - Compiler for the .less
																// lessc	- fast & low memory required, but .less-map, shadows & gradients not supprted
																// less		- slow, but support all features
																// external	- used if you have external .less compiler (like WinLess or Koala)
																// no		- don't use .less, all styles stored in the theme.styles.php
	'less_nested'		=> false,								// Use nested selectors when compiling less - increase .css size, but allow using nested color schemes
	'less_prefix'		=> '',									// any string - Use prefix before each selector when compile less. For example: 'html '
	'less_split'		=> false,								// If true - load each file into memory, split it (see below) and compile separate.
																// Else - compile each file without loading to memory
	'less_separator'	=> '/*---LESS_SEPARATOR---*/',			// string - separator inside .less file to split it when compiling to reduce memory usage
																// (compilation speed gets a bit slow)
	'less_map'			=> 'no',								// no|internal|external - Generate map for .less files. 
																// Warning! You need more then 128Mb for PHP scripts on your server! Supported only if less_compiler=less (see above)
	
	'customizer_demo'	=> true,								// Show color customizer demo (if many color settings) or not (if only accent colors used)

	'allow_fullscreen'	=> false,								// Allow fullscreen and fullwide body styles

	'socials_type'		=> 'icons',								// images|icons - Use this kind of pictograms for all socials: share, social profiles, team members socials, etc.
	'slides_type'		=> 'bg',								// images|bg - Use image as slide's content or as slide's background

	'add_image_size'	=> false,								// Add theme's thumb sizes into WP list sizes. 
																// If false - new image thumb will be generated on demand,
																// otherwise - all thumb sizes will be generated when image is loaded

	'use_list_cache'	=> true,								// Use cache for any lists (increase theme speed, but get 15-20K memory)
	'use_post_cache'	=> true,								// Use cache for post_data (increase theme speed, decrease queries number, but get more memory - up to 300K)

	'admin_dummy_style' => 2									// 1 | 2 - Progress bar style when import dummy data
	)
);



// Default Theme Options
if ( !function_exists( 'trueman_options_settings_theme_setup' ) ) {
	add_action( 'trueman_action_before_init_theme', 'trueman_options_settings_theme_setup', 2 );	// Priority 1 for add trueman_filter handlers
	function trueman_options_settings_theme_setup() {
		
		// Clear all saved Theme Options on first theme run
		add_action('after_switch_theme', 'trueman_options_reset');

		// Settings 
		$socials_type = trueman_get_theme_setting('socials_type');
				
		// Prepare arrays 
		trueman_storage_set('options_params', apply_filters('trueman_filter_theme_options_params', array(
			'list_fonts'				=> array('$trueman_get_list_fonts' => ''),
			'list_fonts_styles'			=> array('$trueman_get_list_fonts_styles' => ''),
			'list_socials' 				=> array('$trueman_get_list_socials' => ''),
			'list_icons' 				=> array('$trueman_get_list_icons(true)' => ''),
			'list_posts_types' 			=> array('$trueman_get_list_posts_types' => ''),
			'list_categories' 			=> array('$trueman_get_list_categories' => ''),
			'list_menus'				=> array('$trueman_get_list_menus(true)' => ''),
			'list_sidebars'				=> array('$trueman_get_list_sidebars' => ''),
			'list_positions' 			=> array('$trueman_get_list_sidebars_positions' => ''),
			'list_color_schemes'		=> array('$trueman_get_list_color_schemes' => ''),
			'list_bg_tints'				=> array('$trueman_get_list_bg_tints' => ''),
			'list_body_styles'			=> array('$trueman_get_list_body_styles' => ''),
			'list_header_styles'		=> array('$trueman_get_list_templates_header' => ''),
			'list_blog_styles'			=> array('$trueman_get_list_templates_blog' => ''),
			'list_single_styles'		=> array('$trueman_get_list_templates_single' => ''),
			'list_article_styles'		=> array('$trueman_get_list_article_styles' => ''),
			'list_blog_counters' 		=> array('$trueman_get_list_blog_counters' => ''),
			'list_menu_hovers' 			=> array('$trueman_get_list_menu_hovers' => ''),
			'list_button_hovers'		=> array('$trueman_get_list_button_hovers' => ''),
			'list_input_hovers'			=> array('$trueman_get_list_input_hovers' => ''),
			'list_search_styles'		=> array('$trueman_get_list_search_styles' => ''),
			'list_animations_in' 		=> array('$trueman_get_list_animations_in' => ''),
			'list_animations_out'		=> array('$trueman_get_list_animations_out' => ''),
			'list_filters'				=> array('$trueman_get_list_portfolio_filters' => ''),
			'list_hovers'				=> array('$trueman_get_list_hovers' => ''),
			'list_hovers_dir'			=> array('$trueman_get_list_hovers_directions' => ''),
			'list_alter_sizes'			=> array('$trueman_get_list_alter_sizes' => ''),
			'list_sliders' 				=> array('$trueman_get_list_sliders' => ''),
			'list_bg_image_positions'	=> array('$trueman_get_list_bg_image_positions' => ''),
			'list_popups' 				=> array('$trueman_get_list_popup_engines' => ''),
			'list_gmap_styles'		 	=> array('$trueman_get_list_googlemap_styles' => ''),
			'list_yes_no' 				=> array('$trueman_get_list_yesno' => ''),
			'list_on_off' 				=> array('$trueman_get_list_onoff' => ''),
			'list_show_hide' 			=> array('$trueman_get_list_showhide' => ''),
			'list_sorting' 				=> array('$trueman_get_list_sortings' => ''),
			'list_ordering' 			=> array('$trueman_get_list_orderings' => ''),
			'list_locations' 			=> array('$trueman_get_list_dedicated_locations' => '')
			)
		));


		// Theme options array
		trueman_storage_set('options', array(

		
		//###############################
		//#### Customization         #### 
		//###############################
		'partition_customization' => array(
					"title" => esc_html__('Customization', 'trueman'),
					"start" => "partitions",
					"override" => "category,services_group,post,page,custom",
					"icon" => "iconadmin-cog-alt",
					"type" => "partition"
					),
		
		
		// Customization -> Body Style
		//-------------------------------------------------
		
		'customization_body' => array(
					"title" => esc_html__('Body style', 'trueman'),
					"override" => "category,services_group,post,page,custom",
					"icon" => 'iconadmin-picture',
					"start" => "customization_tabs",
					"type" => "tab"
					),
		
		'info_body_1' => array(
					"title" => esc_html__('Body parameters', 'trueman'),
					"desc" => wp_kses_data( __('Select body style and color scheme for entire site. You can override this parameters on any page, post or category', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"
					),

		'body_style' => array(
					"title" => esc_html__('Body style', 'trueman'),
					"desc" => wp_kses_data( __('Select body style:', 'trueman') )
								. ' <br>' 
								. wp_kses_data( __('<b>boxed</b> - if you want use background color and/or image', 'trueman') )
								. ',<br>'
								. wp_kses_data( __('<b>wide</b> - page fill whole window with centered content', 'trueman') )
								. (trueman_get_theme_setting('allow_fullscreen') 
									? ',<br>' . wp_kses_data( __('<b>fullwide</b> - page content stretched on the full width of the window (with few left and right paddings)', 'trueman') )
									: '')
								. (trueman_get_theme_setting('allow_fullscreen') 
									? ',<br>' . wp_kses_data( __('<b>fullscreen</b> - page content fill whole window without any paddings', 'trueman') )
									: ''),
					"info" => true,
					"override" => "category,services_group,post,page,custom",
					"std" => "wide",
					"options" => trueman_get_options_param('list_body_styles'),
					"dir" => "horizontal",
					"type" => "radio"
					),
		
		'body_paddings' => array(
					"title" => esc_html__('Page paddings', 'trueman'),
					"desc" => wp_kses_data( __('Add paddings above and below the page content', 'trueman') ),
					"override" => "post,page,custom",
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"
					),

		"body_scheme" => array(
					"title" => esc_html__('Color scheme', 'trueman'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the entire page', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "original",
					"dir" => "horizontal",
					"options" => trueman_get_options_param('list_color_schemes'),
					"type" => "checklist"),
		
		'body_filled' => array(
					"title" => esc_html__('Fill body', 'trueman'),
					"desc" => wp_kses_data( __('Fill the page background with the solid color or leave it transparend to show background image (or video background)', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"
					),

		'info_body_2' => array(
					"title" => esc_html__('Background color and image', 'trueman'),
					"desc" => wp_kses_data( __('Color and image for the site background', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"
					),

		'bg_custom' => array(
					"title" => esc_html__('Use custom background',  'trueman'),
					"desc" => wp_kses_data( __("Use custom color and/or image as the site background", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"
					),
		
		'bg_color' => array(
					"title" => esc_html__('Background color',  'trueman'),
					"desc" => wp_kses_data( __('Body background color',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "#ffffff",
					"type" => "color"
					),

		'bg_pattern' => array(
					"title" => esc_html__('Background predefined pattern',  'trueman'),
					"desc" => wp_kses_data( __('Select theme background pattern (first case - without pattern)',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "",
					"options" => array(
						0 => trueman_get_file_url('images/spacer.png'),
						1 => trueman_get_file_url('images/bg/pattern_1.jpg'),
						2 => trueman_get_file_url('images/bg/pattern_2.jpg'),
						3 => trueman_get_file_url('images/bg/pattern_3.jpg'),
						4 => trueman_get_file_url('images/bg/pattern_4.jpg'),
						5 => trueman_get_file_url('images/bg/pattern_5.jpg')
					),
					"style" => "list",
					"type" => "images"
					),
		
		'bg_pattern_custom' => array(
					"title" => esc_html__('Background custom pattern',  'trueman'),
					"desc" => wp_kses_data( __('Select or upload background custom pattern. If selected - use it instead the theme predefined pattern (selected in the field above)',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "",
					"type" => "media"
					),
		
		'bg_image' => array(
					"title" => esc_html__('Background predefined image',  'trueman'),
					"desc" => wp_kses_data( __('Select theme background image (first case - without image)',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"options" => array(
						0 => trueman_get_file_url('images/spacer.png'),
						1 => trueman_get_file_url('images/bg/image_1_thumb.jpg'),
						2 => trueman_get_file_url('images/bg/image_2_thumb.jpg'),
						3 => trueman_get_file_url('images/bg/image_3_thumb.jpg')
					),
					"style" => "list",
					"type" => "images"
					),
		
		'bg_image_custom' => array(
					"title" => esc_html__('Background custom image',  'trueman'),
					"desc" => wp_kses_data( __('Select or upload background custom image. If selected - use it instead the theme predefined image (selected in the field above)',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "",
					"type" => "media"
					),
		
		'bg_image_custom_position' => array( 
					"title" => esc_html__('Background custom image position',  'trueman'),
					"desc" => wp_kses_data( __('Select custom image position',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "left_top",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"options" => array(
						'left_top' => "Left Top",
						'center_top' => "Center Top",
						'right_top' => "Right Top",
						'left_center' => "Left Center",
						'center_center' => "Center Center",
						'right_center' => "Right Center",
						'left_bottom' => "Left Bottom",
						'center_bottom' => "Center Bottom",
						'right_bottom' => "Right Bottom",
					),
					"type" => "select"
					),
		
		'bg_image_load' => array(
					"title" => esc_html__('Load background image', 'trueman'),
					"desc" => wp_kses_data( __('Always load background images or only for boxed body style', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "boxed",
					"size" => "medium",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"options" => array(
						'boxed' => esc_html__('Boxed', 'trueman'),
						'always' => esc_html__('Always', 'trueman')
					),
					"type" => "switch"
					),

		
		'info_body_3' => array(
					"title" => esc_html__('Video background', 'trueman'),
					"desc" => wp_kses_data( __('Parameters of the video, used as site background', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"
					),

		'show_video_bg' => array(
					"title" => esc_html__('Show video background',  'trueman'),
					"desc" => wp_kses_data( __("Show video as the site background", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"
					),

		'video_bg_youtube_code' => array(
					"title" => esc_html__('Youtube code for video bg',  'trueman'),
					"desc" => wp_kses_data( __("Youtube code of video", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_video_bg' => array('yes')
					),
					"std" => "",
					"type" => "text"
					),

		'video_bg_url' => array(
					"title" => esc_html__('Local video for video bg',  'trueman'),
					"desc" => wp_kses_data( __("URL to video-file (uploaded on your site)", 'trueman') ),
					"readonly" =>false,
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_video_bg' => array('yes')
					),
					"before" => array(	'title' => esc_html__('Choose video', 'trueman'),
										'action' => 'media_upload',
										'multiple' => false,
										'linked_field' => '',
										'type' => 'video',
										'captions' => array('choose' => esc_html__( 'Choose Video', 'trueman'),
															'update' => esc_html__( 'Select Video', 'trueman')
														)
								),
					"std" => "",
					"type" => "media"
					),

		'video_bg_overlay' => array(
					"title" => esc_html__('Use overlay for video bg', 'trueman'),
					"desc" => wp_kses_data( __('Use overlay texture for the video background', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_video_bg' => array('yes')
					),
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"
					),
		
		
		
		
		
		// Customization -> Header
		//-------------------------------------------------
		
		'customization_header' => array(
					"title" => esc_html__("Header", 'trueman'),
					"override" => "category,services_group,post,page,custom",
					"icon" => 'iconadmin-window',
					"type" => "tab"),
		
		"info_header_1" => array(
					"title" => esc_html__('Top panel', 'trueman'),
					"desc" => wp_kses_data( __('Top panel settings. It include user menu area (with contact info, cart button, language selector and user menu) and main menu area (with logo and main menu).', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"top_panel_style" => array(
					"title" => esc_html__('Top panel style', 'trueman'),
					"desc" => wp_kses_data( __('Select desired style of the page header', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "header_2",
					"options" => trueman_get_options_param('list_header_styles'),
					"style" => "list",
					"type" => "images"),

		"top_panel_image" => array(
					"title" => esc_html__('Top panel image', 'trueman'),
					"desc" => wp_kses_data( __('Select default background image of the page header (if not single post or featured image for current post is not specified)', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'top_panel_style' => array('header_2','header_7')
					),
					"std" => "",
					"type" => "media"),
		
		"top_panel_position" => array( 
					"title" => esc_html__('Top panel position', 'trueman'),
					"desc" => wp_kses_data( __('Select position for the top panel with logo and main menu', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "above",
					"options" => array(
						'hide'  => esc_html__('Hide', 'trueman'),
						'above' => esc_html__('Above slider', 'trueman'),
						'below' => esc_html__('Below slider', 'trueman'),
						'over'  => esc_html__('Over slider', 'trueman')
					),
					"type" => "checklist"),

		"top_panel_scheme" => array(
					"title" => esc_html__('Top panel color scheme', 'trueman'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the top panel', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "original",
					"dir" => "horizontal",
					"options" => trueman_get_options_param('list_color_schemes'),
					"type" => "checklist"),

		"pushy_panel_scheme" => array(
					"title" => esc_html__('Push panel color scheme', 'trueman'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the push panel (with logo, menu and socials)', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'top_panel_style' => array('header_8')
					),
					"std" => "dark",
					"dir" => "horizontal",
					"options" => trueman_get_options_param('list_color_schemes'),
					"type" => "checklist"),
		
		"show_page_title" => array(
					"title" => esc_html__('Show Page title', 'trueman'),
					"desc" => wp_kses_data( __('Show post/page/category title', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_breadcrumbs" => array(
					"title" => esc_html__('Show Breadcrumbs', 'trueman'),
					"desc" => wp_kses_data( __('Show path to current category (post, page)', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"breadcrumbs_max_level" => array(
					"title" => esc_html__('Breadcrumbs max nesting', 'trueman'),
					"desc" => wp_kses_data( __("Max number of the nested categories in the breadcrumbs (0 - unlimited)", 'trueman') ),
					"dependency" => array(
						'show_breadcrumbs' => array('yes')
					),
					"std" => "0",
					"min" => 0,
					"max" => 100,
					"step" => 1,
					"type" => "spinner"),

        "show_appointments_button" => array(
                    "title" => esc_html__('Show Appointments button', 'trueman'),
                    "desc" => wp_kses_data( __('Show Appointments button in header', 'trueman') ),
                    "override" => "category,services_group,post,page,custom",
                    "std" => "no",
                    "options" => trueman_get_options_param('list_yes_no'),
                    "type" => "switch"),

        "appointments_button_caption" => array(
                    "title" => esc_html__('Set Appointments button caption', 'trueman'),
                    "desc" => wp_kses_data( __('Set Appointments button caption in header', 'trueman') ),
                    "dependency" => array(
                        'show_appointments_button' => array('yes')
                    ),
                    "override" => "category,services_group,post,page,custom",
                    "std" => esc_html__('Make an appointment', 'trueman'),
                    "type" => "text"),

        "appointments_button_link" => array(
                    "title" => esc_html__('Set Appointments button link', 'trueman'),
                    "desc" => wp_kses_data( __('Set Appointments button link in header', 'trueman') ),
                    "dependency" => array(
                        'show_appointments_button' => array('yes')
                    ),
                    "override" => "category,services_group,post,page,custom",
                    "std" => esc_attr('/appointment/'),
                    "type" => "text"),

		
		
		
		"info_header_2" => array( 
					"title" => esc_html__('Main menu style and position', 'trueman'),
					"desc" => wp_kses_data( __('Select the Main menu style and position', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"menu_main" => array( 
					"title" => esc_html__('Select main menu',  'trueman'),
					"desc" => wp_kses_data( __('Select main menu for the current page',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "default",
					"options" => trueman_get_options_param('list_menus'),
					"type" => "select"),
		
		"menu_attachment" => array( 
					"title" => esc_html__('Main menu attachment', 'trueman'),
					"desc" => wp_kses_data( __('Attach main menu to top of window then page scroll down', 'trueman') ),
					"std" => "fixed",
					"options" => array(
						"fixed"=>esc_html__("Fix menu position", 'trueman'), 
						"none"=>esc_html__("Don't fix menu position", 'trueman')
					),
					"dir" => "vertical",
					"type" => "radio"),

		"menu_hover" => array( 
					"title" => esc_html__('Main menu hover effect', 'trueman'),
					"desc" => wp_kses_data( __('Select hover effect for the main menu items', 'trueman') ),
					"std" => "fade",
					"type" => "select",
					"options" => trueman_get_options_param('list_menu_hovers')),

		"menu_animation_in" => array( 
					"title" => esc_html__('Submenu show animation', 'trueman'),
					"desc" => wp_kses_data( __('Select animation to show submenu ', 'trueman') ),
					"std" => "fadeIn",
					"type" => "select",
					"options" => trueman_get_options_param('list_animations_in')),

		"menu_animation_out" => array( 
					"title" => esc_html__('Submenu hide animation', 'trueman'),
					"desc" => wp_kses_data( __('Select animation to hide submenu ', 'trueman') ),
					"std" => "fadeOut",
					"type" => "select",
					"options" => trueman_get_options_param('list_animations_out')),
		
		"menu_mobile" => array( 
					"title" => esc_html__('Main menu responsive', 'trueman'),
					"desc" => wp_kses_data( __('Allow responsive version for the main menu if window width less then this value', 'trueman') ),
					"std" => 1024,
					"min" => 320,
					"max" => 1024,
					"type" => "spinner"),
		
		"menu_width" => array( 
					"title" => esc_html__('Submenu width', 'trueman'),
					"desc" => wp_kses_data( __('Width for dropdown menus in main menu', 'trueman') ),
					"step" => 5,
					"std" => "",
					"min" => 180,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"),
		
		
		
		"info_header_3" => array(
					"title" => esc_html__("User's menu area components", 'trueman'),
					"desc" => wp_kses_data( __("Select parts for the user's menu area", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"show_top_panel_top" => array(
					"title" => esc_html__('Show user menu area', 'trueman'),
					"desc" => wp_kses_data( __('Show user menu area on top of page', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"menu_user" => array(
					"title" => esc_html__('Select user menu',  'trueman'),
					"desc" => wp_kses_data( __('Select user menu for the current page',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "default",
					"options" => trueman_get_options_param('list_menus'),
					"type" => "select"),
		
		"show_languages" => array(
					"title" => esc_html__('Show language selector', 'trueman'),
					"desc" => wp_kses_data( __('Show language selector in the user menu (if WPML plugin installed and current page/post has multilanguage version)', 'trueman') ),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "hidden"),
		
		"show_login" => array( 
					"title" => esc_html__('Show Login/Logout buttons', 'trueman'),
					"desc" => wp_kses_data( __('Show Login and Logout buttons in the user menu area', 'trueman') ),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "hidden"),
		
		"show_bookmarks" => array(
					"title" => esc_html__('Show bookmarks', 'trueman'),
					"desc" => wp_kses_data( __('Show bookmarks selector in the user menu', 'trueman') ),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "hidden"),
		
		"show_socials" => array( 
					"title" => esc_html__('Show Social icons', 'trueman'),
					"desc" => wp_kses_data( __('Show Social icons in the user menu area', 'trueman') ),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		

		
		"info_header_4" => array( 
					"title" => esc_html__("Table of Contents (TOC)", 'trueman'),
					"desc" => wp_kses_data( __("Table of Contents for the current page. Automatically created if the page contains objects with id starting with 'toc_'", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"menu_toc" => array( 
					"title" => esc_html__('TOC position', 'trueman'),
					"desc" => wp_kses_data( __('Show TOC for the current page', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "float",
					"options" => array(
						'hide'  => esc_html__('Hide', 'trueman'),
						'fixed' => esc_html__('Fixed', 'trueman'),
						'float' => esc_html__('Float', 'trueman')
					),
					"type" => "checklist"),
		
		"menu_toc_home" => array(
					"title" => esc_html__('Add "Home" into TOC', 'trueman'),
					"desc" => wp_kses_data( __('Automatically add "Home" item into table of contents - return to home page of the site', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'menu_toc' => array('fixed','float')
					),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"menu_toc_top" => array( 
					"title" => esc_html__('Add "To Top" into TOC', 'trueman'),
					"desc" => wp_kses_data( __('Automatically add "To Top" item into table of contents - scroll to top of the page', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'menu_toc' => array('fixed','float')
					),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),

		
		
		
		'info_header_5' => array(
					"title" => esc_html__('Main logo', 'trueman'),
					"desc" => wp_kses_data( __("Select or upload logos for the site's header and select it position", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"
					),

		'logo' => array(
					"title" => esc_html__('Logo image', 'trueman'),
					"desc" => wp_kses_data( __('Main logo image', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "",
					"type" => "media"
					),

		'logo_retina' => array(
					"title" => esc_html__('Logo image for Retina', 'trueman'),
					"desc" => wp_kses_data( __('Main logo image used on Retina display', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "",
					"type" => "media"
					),

		'logo_fixed' => array(
					"title" => esc_html__('Logo image (fixed header)', 'trueman'),
					"desc" => wp_kses_data( __('Logo image for the header (if menu is fixed after the page is scrolled)', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"divider" => false,
					"std" => "",
					"type" => "media"
					),

		'logo_text' => array(
					"title" => esc_html__('Logo text', 'trueman'),
					"desc" => wp_kses_data( __('Logo text - display it after logo image', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => '',
					"type" => "text"
					),

		'logo_height' => array(
					"title" => esc_html__('Logo height', 'trueman'),
					"desc" => wp_kses_data( __('Height for the logo in the header area', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"step" => 1,
					"std" => '',
					"min" => 10,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"
					),

		'logo_offset' => array(
					"title" => esc_html__('Logo top offset', 'trueman'),
					"desc" => wp_kses_data( __('Top offset for the logo in the header area', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"step" => 1,
					"std" => '',
					"min" => 0,
					"max" => 99,
					"mask" => "?99",
					"type" => "spinner"
					),
		
		
		
		
		
		
		
		// Customization -> Slider
		//-------------------------------------------------
		
		"customization_slider" => array( 
					"title" => esc_html__('Slider', 'trueman'),
					"icon" => "iconadmin-picture",
					"override" => "category,services_group,page,custom",
					"type" => "tab"),
		
		"info_slider_1" => array(
					"title" => esc_html__('Main slider parameters', 'trueman'),
					"desc" => wp_kses_data( __('Select parameters for main slider (you can override it in each category and page)', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"type" => "info"),
					
		"show_slider" => array(
					"title" => esc_html__('Show Slider', 'trueman'),
					"desc" => wp_kses_data( __('Do you want to show slider on each page (post)', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
					
		"slider_display" => array(
					"title" => esc_html__('Slider display', 'trueman'),
					"desc" => wp_kses_data( __('How display slider: boxed (fixed width and height), fullwide (fixed height) or fullscreen', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes')
					),
					"std" => "fullwide",
					"options" => array(
						"boxed"=>esc_html__("Boxed", 'trueman'),
						"fullwide"=>esc_html__("Fullwide", 'trueman'),
						"fullscreen"=>esc_html__("Fullscreen", 'trueman')
					),
					"type" => "checklist"),
		
		"slider_height" => array(
					"title" => esc_html__("Height (in pixels)", 'trueman'),
					"desc" => wp_kses_data( __("Slider height (in pixels) - only if slider display with fixed height.", 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes')
					),
					"std" => '',
					"min" => 100,
					"step" => 10,
					"type" => "spinner"),
		
		"slider_engine" => array(
					"title" => esc_html__('Slider engine', 'trueman'),
					"desc" => wp_kses_data( __('What engine use to show slider?', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes')
					),
					"std" => "swiper",
					"options" => trueman_get_options_param('list_sliders'),
					"type" => "radio"),

		"slider_over_content" => array(
					"title" => esc_html__('Put content over slider',  'trueman'),
					"desc" => wp_kses_data( __('Put content below on fixed layer over this slider',  'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes')
					),
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"allow_html" => true,
					"allow_js" => true,
					"type" => "editor"),

		"slider_over_scheme" => array(
					"title" => esc_html__('Color scheme for content above', 'trueman'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the content over the slider', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"std" => "dark",
					"dir" => "horizontal",
					"options" => trueman_get_options_param('list_color_schemes'),
					"type" => "checklist"),
		
		"slider_category" => array(
					"title" => esc_html__('Posts Slider: Category to show', 'trueman'),
					"desc" => wp_kses_data( __('Select category to show in Flexslider (ignored for Revolution and Royal sliders)', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "",
					"options" => trueman_array_merge(array(0 => esc_html__('- Select category -', 'trueman')), trueman_get_options_param('list_categories')),
					"type" => "select",
					"multiple" => true,
					"style" => "list"),
		
		"slider_posts" => array(
					"title" => esc_html__('Posts Slider: Number posts or comma separated posts list',  'trueman'),
					"desc" => wp_kses_data( __("How many recent posts display in slider or comma separated list of posts ID (in this case selected category ignored)", 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "5",
					"type" => "text"),
		
		"slider_orderby" => array(
					"title" => esc_html__("Posts Slider: Posts order by",  'trueman'),
					"desc" => wp_kses_data( __("Posts in slider ordered by date (default), comments, views, author rating, users rating, random or alphabetically", 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "date",
					"options" => trueman_get_options_param('list_sorting'),
					"type" => "select"),
		
		"slider_order" => array(
					"title" => esc_html__("Posts Slider: Posts order", 'trueman'),
					"desc" => wp_kses_data( __('Select the desired ordering method for posts', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "desc",
					"options" => trueman_get_options_param('list_ordering'),
					"size" => "big",
					"type" => "switch"),
					
		"slider_interval" => array(
					"title" => esc_html__("Posts Slider: Slide change interval", 'trueman'),
					"desc" => wp_kses_data( __("Interval (in ms) for slides change in slider", 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => 7000,
					"min" => 100,
					"step" => 100,
					"type" => "spinner"),
		
		"slider_pagination" => array(
					"title" => esc_html__("Posts Slider: Pagination", 'trueman'),
					"desc" => wp_kses_data( __("Choose pagination style for the slider", 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "no",
					"options" => array(
						'no'   => esc_html__('None', 'trueman'),
						'yes'  => esc_html__('Dots', 'trueman'), 
						'over' => esc_html__('Titles', 'trueman')
					),
					"type" => "checklist"),
		
		"slider_infobox" => array(
					"title" => esc_html__("Posts Slider: Show infobox", 'trueman'),
					"desc" => wp_kses_data( __("Do you want to show post's title, reviews rating and description on slides in slider", 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "slide",
					"options" => array(
						'no'    => esc_html__('None',  'trueman'),
						'slide' => esc_html__('Slide', 'trueman'), 
						'fixed' => esc_html__('Fixed', 'trueman')
					),
					"type" => "checklist"),
					
		"slider_info_category" => array(
					"title" => esc_html__("Posts Slider: Show post's category", 'trueman'),
					"desc" => wp_kses_data( __("Do you want to show post's category on slides in slider", 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
					
		"slider_info_reviews" => array(
					"title" => esc_html__("Posts Slider: Show post's reviews rating", 'trueman'),
					"desc" => wp_kses_data( __("Do you want to show post's reviews rating on slides in slider", 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
					
		"slider_info_descriptions" => array(
					"title" => esc_html__("Posts Slider: Show post's descriptions", 'trueman'),
					"desc" => wp_kses_data( __("How many characters show in the post's description in slider. 0 - no descriptions", 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => 0,
					"min" => 0,
					"step" => 10,
					"type" => "spinner"),
		
		
		
		
		
		// Customization -> Sidebars
		//-------------------------------------------------
		
		"customization_sidebars" => array( 
					"title" => esc_html__('Sidebars', 'trueman'),
					"icon" => "iconadmin-indent-right",
					"override" => "category,services_group,post,page,custom",
					"type" => "tab"),
		
		"info_sidebars_1" => array( 
					"title" => esc_html__('Custom sidebars', 'trueman'),
					"desc" => wp_kses_data( __('In this section you can create unlimited sidebars. You can fill them with widgets in the menu Appearance - Widgets', 'trueman') ),
					"type" => "info"),
		
		"custom_sidebars" => array(
					"title" => esc_html__('Custom sidebars',  'trueman'),
					"desc" => wp_kses_data( __('Manage custom sidebars. You can use it with each category (page, post) independently',  'trueman') ),
					"std" => "",
					"cloneable" => true,
					"type" => "text"),
		
		"info_sidebars_2" => array(
					"title" => esc_html__('Main sidebar', 'trueman'),
					"desc" => wp_kses_data( __('Show / Hide and select main sidebar', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		'show_sidebar_main' => array( 
					"title" => esc_html__('Show main sidebar',  'trueman'),
					"desc" => wp_kses_data( __('Select position for the main sidebar or hide it',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "right",
					"options" => trueman_get_options_param('list_positions'),
					"dir" => "horizontal",
					"type" => "checklist"),

		"sidebar_main_scheme" => array(
					"title" => esc_html__("Color scheme", 'trueman'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the main sidebar', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_main' => array('left', 'right')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => trueman_get_options_param('list_color_schemes'),
					"type" => "checklist"),
		
		"sidebar_main" => array( 
					"title" => esc_html__('Select main sidebar',  'trueman'),
					"desc" => wp_kses_data( __('Select main sidebar content',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_main' => array('left', 'right')
					),
					"std" => "sidebar_main",
					"options" => trueman_get_options_param('list_sidebars'),
					"type" => "select"),
		
		"info_sidebars_3" => array(
					"title" => esc_html__('Outer sidebar', 'trueman'),
					"desc" => wp_kses_data( __('Show / Hide and select outer sidebar (sidemenu, logo, etc.', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "hidden"),
		
		'show_sidebar_outer' => array( 
					"title" => esc_html__('Show outer sidebar',  'trueman'),
					"desc" => wp_kses_data( __('Select position for the outer sidebar or hide it',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "hide",
					"options" => trueman_get_options_param('list_positions'),
					"dir" => "horizontal",
					"type" => "hidden"),

		"sidebar_outer_scheme" => array(
					"title" => esc_html__("Color scheme", 'trueman'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the outer sidebar', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => trueman_get_options_param('list_color_schemes'),
					"type" => "hidden"),
		
		"sidebar_outer_show_logo" => array( 
					"title" => esc_html__('Show Logo', 'trueman'),
					"desc" => wp_kses_data( __('Show Logo in the outer sidebar', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "hidden"),
		
		"sidebar_outer_show_socials" => array( 
					"title" => esc_html__('Show Social icons', 'trueman'),
					"desc" => wp_kses_data( __('Show Social icons in the outer sidebar', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "hidden"),
		
		"sidebar_outer_show_menu" => array( 
					"title" => esc_html__('Show Menu', 'trueman'),
					"desc" => wp_kses_data( __('Show Menu in the outer sidebar', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "hidden"),
		
		"menu_side" => array(
					"title" => esc_html__('Select menu',  'trueman'),
					"desc" => wp_kses_data( __('Select menu for the outer sidebar',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right'),
						'sidebar_outer_show_menu' => array('yes')
					),
					"std" => "default",
					"options" => trueman_get_options_param('list_menus'),
					"type" => "hidden"),
		
		"sidebar_outer_show_widgets" => array( 
					"title" => esc_html__('Show Widgets', 'trueman'),
					"desc" => wp_kses_data( __('Show Widgets in the outer sidebar', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "hidden"),

		"sidebar_outer" => array( 
					"title" => esc_html__('Select outer sidebar',  'trueman'),
					"desc" => wp_kses_data( __('Select outer sidebar content',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'sidebar_outer_show_widgets' => array('yes'),
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "sidebar_outer",
					"options" => trueman_get_options_param('list_sidebars'),
					"type" => "hidden"),
		
		
		
		
		// Customization -> Footer
		//-------------------------------------------------
		
		'customization_footer' => array(
					"title" => esc_html__("Footer", 'trueman'),
					"override" => "category,services_group,post,page,custom",
					"icon" => 'iconadmin-window',
					"type" => "tab"),
		
		
		"info_footer_1" => array(
					"title" => esc_html__("Footer components", 'trueman'),
					"desc" => wp_kses_data( __("Select components of the footer, set style and put the content for the user's footer area", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"show_sidebar_footer" => array(
					"title" => esc_html__('Show footer sidebar', 'trueman'),
					"desc" => wp_kses_data( __('Select style for the footer sidebar or hide it', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),

		"sidebar_footer_scheme" => array(
					"title" => esc_html__("Color scheme", 'trueman'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the footer', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_footer' => array('yes')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => trueman_get_options_param('list_color_schemes'),
					"type" => "checklist"),
		
		"sidebar_footer" => array( 
					"title" => esc_html__('Select footer sidebar',  'trueman'),
					"desc" => wp_kses_data( __('Select footer sidebar for the blog page',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_footer' => array('yes')
					),
					"std" => "sidebar_footer",
					"options" => trueman_get_options_param('list_sidebars'),
					"type" => "select"),
		
		"sidebar_footer_columns" => array( 
					"title" => esc_html__('Footer sidebar columns',  'trueman'),
					"desc" => wp_kses_data( __('Select columns number for the footer sidebar',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_footer' => array('yes')
					),
					"std" => 3,
					"min" => 1,
					"max" => 6,
					"type" => "spinner"),
		
		
		"info_footer_2" => array(
					"title" => esc_html__('Testimonials in Footer', 'trueman'),
					"desc" => wp_kses_data( __('Select parameters for Testimonials in the Footer', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),

		"show_testimonials_in_footer" => array(
					"title" => esc_html__('Show Testimonials in footer', 'trueman'),
					"desc" => wp_kses_data( __('Show Testimonials slider in footer. For correct operation of the slider (and shortcode testimonials) you must fill out Testimonials posts on the menu "Testimonials"', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),

		"testimonials_scheme" => array(
					"title" => esc_html__("Color scheme", 'trueman'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the testimonials area', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_testimonials_in_footer' => array('yes')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => trueman_get_options_param('list_color_schemes'),
					"type" => "checklist"),

		"testimonials_count" => array( 
					"title" => esc_html__('Testimonials count', 'trueman'),
					"desc" => wp_kses_data( __('Number testimonials to show', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_testimonials_in_footer' => array('yes')
					),
					"std" => 3,
					"step" => 1,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),
		
		
		"info_footer_3" => array(
					"title" => esc_html__('Twitter in Footer', 'trueman'),
					"desc" => wp_kses_data( __('Select parameters for Twitter stream in the Footer (you can override it in each category and page)', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),

		"show_twitter_in_footer" => array(
					"title" => esc_html__('Show Twitter in footer', 'trueman'),
					"desc" => wp_kses_data( __('Show Twitter slider in footer. For correct operation of the slider (and shortcode twitter) you must fill out the Twitter API keys on the menu "Appearance - Theme Options - Socials"', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),

		"twitter_scheme" => array(
					"title" => esc_html__("Color scheme", 'trueman'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the twitter area', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_twitter_in_footer' => array('yes')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => trueman_get_options_param('list_color_schemes'),
					"type" => "checklist"),

		"twitter_count" => array( 
					"title" => esc_html__('Twitter count', 'trueman'),
					"desc" => wp_kses_data( __('Number twitter to show', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_twitter_in_footer' => array('yes')
					),
					"std" => 3,
					"step" => 1,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),


		"info_footer_4" => array(
					"title" => esc_html__('Google map parameters', 'trueman'),
					"desc" => wp_kses_data( __('Select parameters for Google map (you can override it in each category and page)', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
					
		"show_googlemap" => array(
					"title" => esc_html__('Show Google Map', 'trueman'),
					"desc" => wp_kses_data( __('Do you want to show Google map on each page (post)', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"googlemap_height" => array(
					"title" => esc_html__("Map height", 'trueman'),
					"desc" => wp_kses_data( __("Map height (default - in pixels, allows any CSS units of measure)", 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => 400,
					"min" => 100,
					"step" => 10,
					"type" => "spinner"),
		
		"googlemap_address" => array(
					"title" => esc_html__('Address to show on map',  'trueman'),
					"desc" => wp_kses_data( __("Enter address to show on map center", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "",
					"type" => "text"),
		
		"googlemap_latlng" => array(
					"title" => esc_html__('Latitude and Longitude to show on map',  'trueman'),
					"desc" => wp_kses_data( __("Enter coordinates (separated by comma) to show on map center (instead of address)", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "",
					"type" => "text"),
		
		"googlemap_title" => array(
					"title" => esc_html__('Title to show on map',  'trueman'),
					"desc" => wp_kses_data( __("Enter title to show on map center", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "",
					"type" => "text"),
		
		"googlemap_description" => array(
					"title" => esc_html__('Description to show on map',  'trueman'),
					"desc" => wp_kses_data( __("Enter description to show on map center", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "",
					"type" => "text"),
		
		"googlemap_zoom" => array(
					"title" => esc_html__('Google map initial zoom',  'trueman'),
					"desc" => wp_kses_data( __("Enter desired initial zoom for Google map", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => 16,
					"min" => 1,
					"max" => 20,
					"step" => 1,
					"type" => "spinner"),
		
		"googlemap_style" => array(
					"title" => esc_html__('Google map style',  'trueman'),
					"desc" => wp_kses_data( __("Select style to show Google map", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => 'style1',
					"options" => trueman_get_options_param('list_gmap_styles'),
					"type" => "select"),
		
		"googlemap_marker" => array(
					"title" => esc_html__('Google map marker',  'trueman'),
					"desc" => wp_kses_data( __("Select or upload png-image with Google map marker", 'trueman') ),
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => '',
					"type" => "media"),
		
		
		
		"info_footer_5" => array(
					"title" => esc_html__("Contacts area", 'trueman'),
					"desc" => wp_kses_data( __("Show/Hide contacts area in the footer", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"show_contacts_in_footer" => array(
					"title" => esc_html__('Show Contacts in footer', 'trueman'),
					"desc" => wp_kses_data( __('Show contact information area in footer: site logo, contact info and large social icons', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),

		"contacts_scheme" => array(
					"title" => esc_html__("Color scheme", 'trueman'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the contacts area', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_contacts_in_footer' => array('yes')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => trueman_get_options_param('list_color_schemes'),
					"type" => "checklist"),

		'logo_footer' => array(
					"title" => esc_html__('Logo image for footer', 'trueman'),
					"desc" => wp_kses_data( __('Logo image in the footer (in the contacts area)', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_contacts_in_footer' => array('yes')
					),
					"std" => "",
					"type" => "media"
					),

		'logo_footer_retina' => array(
					"title" => esc_html__('Logo image for footer for Retina', 'trueman'),
					"desc" => wp_kses_data( __('Logo image in the footer (in the contacts area) used on Retina display', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_contacts_in_footer' => array('yes')
					),
					"std" => "",
					"type" => "media"
					),
		
		'logo_footer_height' => array(
					"title" => esc_html__('Logo height', 'trueman'),
					"desc" => wp_kses_data( __('Height for the logo in the footer area (in the contacts area)', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_contacts_in_footer' => array('yes')
					),
					"step" => 1,
					"std" => 30,
					"min" => 10,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"
					),
		
		
		
		"info_footer_6" => array(
					"title" => esc_html__("Copyright and footer menu", 'trueman'),
					"desc" => wp_kses_data( __("Show/Hide copyright area in the footer", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),

		"show_copyright_in_footer" => array(
					"title" => esc_html__('Show Copyright area in footer', 'trueman'),
					"desc" => wp_kses_data( __('Show area with copyright information, footer menu and small social icons in footer', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "plain",
					"options" => array(
						'none' => esc_html__('Hide', 'trueman'),
						'text' => esc_html__('Text', 'trueman'),
						'menu' => esc_html__('Text and menu', 'trueman'),
						'socials' => esc_html__('Text and Social icons', 'trueman')
					),
					"type" => "checklist"),

		"copyright_scheme" => array(
					"title" => esc_html__("Color scheme", 'trueman'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the copyright area', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_copyright_in_footer' => array('text', 'menu', 'socials')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => trueman_get_options_param('list_color_schemes'),
					"type" => "checklist"),
		
		"menu_footer" => array( 
					"title" => esc_html__('Select footer menu',  'trueman'),
					"desc" => wp_kses_data( __('Select footer menu for the current page',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "default",
					"dependency" => array(
						'show_copyright_in_footer' => array('menu')
					),
					"options" => trueman_get_options_param('list_menus'),
					"type" => "select"),

		"footer_copyright" => array(
					"title" => esc_html__('Footer copyright text',  'trueman'),
					"desc" => wp_kses_data( __("Copyright text to show in footer area (bottom of site)", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_copyright_in_footer' => array('text', 'menu', 'socials')
					),
					"allow_html" => true,
					"std" => "Trueman &copy; {Y} All Rights Reserved ",
					"rows" => "10",
					"type" => "editor"),




		// Customization -> Other
		//-------------------------------------------------
		
		'customization_other' => array(
					"title" => esc_html__('Other', 'trueman'),
					"override" => "category,services_group,post,page,custom",
					"icon" => 'iconadmin-cog',
					"type" => "tab"
					),

		'info_other_1' => array(
					"title" => esc_html__('Theme customization other parameters', 'trueman'),
					"desc" => wp_kses_data( __('Animation parameters and responsive layouts for the small screens', 'trueman') ),
					"type" => "info"
					),

		'show_theme_customizer' => array(
					"title" => esc_html__('Show Theme customizer', 'trueman'),
					"desc" => wp_kses_data( __('Do you want to show theme customizer in the right panel? Your website visitors will be able to customise it yourself.', 'trueman') ),
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"
					),

		"customizer_demo" => array(
					"title" => esc_html__('Theme customizer panel demo time', 'trueman'),
					"desc" => wp_kses_data( __('Timer for demo mode for the customizer panel (in milliseconds: 1000ms = 1s). If 0 - no demo.', 'trueman') ),
					"dependency" => array(
						'show_theme_customizer' => array('yes')
					),
					"std" => "0",
					"min" => 0,
					"max" => 10000,
					"step" => 500,
					"type" => "spinner"),
		
		'css_animation' => array(
					"title" => esc_html__('Extended CSS animations', 'trueman'),
					"desc" => wp_kses_data( __('Do you want use extended animations effects on your site?', 'trueman') ),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"
					),
		
		'animation_on_mobile' => array(
					"title" => esc_html__('Allow CSS animations on mobile', 'trueman'),
					"desc" => wp_kses_data( __('Do you allow extended animations effects on mobile devices?', 'trueman') ),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"
					),

		"button_hover" => array( 
					"title" => esc_html__("Buttons hover", 'trueman'),
					"desc" => wp_kses_data( __("Select hover effect for all theme's buttons (and buttons from the thirdparty plugins if possible)", 'trueman') ),
					"std" => "fade",
					"type" => "select",
					"options" => trueman_get_options_param('list_button_hovers')),

		"input_hover" => array( 
					"title" => esc_html__("Input fileds style", 'trueman'),
					"desc" => wp_kses_data( __("Select style for all theme's input fields (and fields from the thirdparty plugins if possible)", 'trueman') ),
					"std" => "default",
					"type" => "select",
					"options" => trueman_get_options_param('list_input_hovers')),

		'remember_visitors_settings' => array(
					"title" => esc_html__("Remember visitor's settings", 'trueman'),
					"desc" => wp_kses_data( __('To remember the settings that were made by the visitor, when navigating to other pages or to limit their effect only within the current page', 'trueman') ),
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"
					),
					
		'responsive_layouts' => array(
					"title" => esc_html__('Responsive Layouts', 'trueman'),
					"desc" => wp_kses_data( __('Do you want use responsive layouts on small screen or still use main layout?', 'trueman') ),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"
					),

		"page_preloader" => array( 
					"title" => esc_html__("Show page preloader", 'trueman'),
					"desc" => wp_kses_data( __("Select one of predefined styles for the page preloader or upload preloader image", 'trueman') ),
					"std" => "none",
					"type" => "select",
					"options" => array(
						'none'   => esc_html__('Hide preloader', 'trueman'),
						'circle' => esc_html__('Circle', 'trueman'),
						'square' => esc_html__('Square', 'trueman'),
						'custom' => esc_html__('Custom', 'trueman'),
					)),
		
		'page_preloader_image' => array(
					"title" => esc_html__('Upload preloader image',  'trueman'),
					"desc" => wp_kses_data( __('Upload animated GIF to use it as page preloader',  'trueman') ),
					"dependency" => array(
						'page_preloader' => array('custom')
					),
					"std" => "",
					"type" => "media"
					),

            'privacy_text' => array(
                "title" => esc_html__("Text with Privacy Policy link", 'trueman'),
                "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'trueman') ),
                "std"   => wp_kses_post( __( 'I agree that my submitted data is being collected and stored.', 'trueman') ),
                "type"  => "text"
            ),


		'info_other_2' => array(
					"title" => esc_html__('Google fonts parameters', 'trueman'),
					"desc" => wp_kses_data( __('Specify additional parameters, used to load Google fonts', 'trueman') ),
					"type" => "info"
					),
		
		"fonts_subset" => array(
					"title" => esc_html__('Characters subset', 'trueman'),
					"desc" => wp_kses_data( __('Select subset, included into used Google fonts', 'trueman') ),
					"std" => "latin,latin-ext",
					"options" => array(
						'latin' => esc_html__('Latin', 'trueman'),
						'latin-ext' => esc_html__('Latin Extended', 'trueman'),
						'greek' => esc_html__('Greek', 'trueman'),
						'greek-ext' => esc_html__('Greek Extended', 'trueman'),
						'cyrillic' => esc_html__('Cyrillic', 'trueman'),
						'cyrillic-ext' => esc_html__('Cyrillic Extended', 'trueman'),
						'vietnamese' => esc_html__('Vietnamese', 'trueman')
					),
					"size" => "medium",
					"dir" => "vertical",
					"multiple" => true,
					"type" => "checklist"),


		'info_other_3' => array(
					"title" => esc_html__('Additional CSS and HTML/JS code', 'trueman'),
					"desc" => wp_kses_data( __('Put here your custom CSS and JS code', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"
					),
					
		'custom_css_html' => array(
					"title" => esc_html__('Use custom CSS/HTML/JS', 'trueman'),
					"desc" => wp_kses_data( __('Do you want use custom HTML/CSS/JS code in your site? For example: custom styles, Google Analitics code, etc.', 'trueman') ),
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"
					),
		
		"gtm_code" => array(
					"title" => esc_html__('Google tags manager or Google analitics code',  'trueman'),
					"desc" => wp_kses_data( __('Put here Google Tags Manager (GTM) code from your account: Google analitics, remarketing, etc. This code will be placed after open body tag.',  'trueman') ),
					"dependency" => array(
						'custom_css_html' => array('yes')
					),
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"allow_html" => true,
					"allow_js" => true,
					"type" => "hidden"),
		
		"gtm_code2" => array(
					"title" => esc_html__('Google remarketing code',  'trueman'),
					"desc" => wp_kses_data( __('Put here Google Remarketing code from your account. This code will be placed before close body tag.',  'trueman') ),
					"dependency" => array(
						'custom_css_html' => array('yes')
					),
					"divider" => false,
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"allow_html" => true,
					"allow_js" => true,
					"type" => "hidden"),
		
		'custom_code' => array(
					"title" => esc_html__('Your custom HTML/JS code',  'trueman'),
					"desc" => wp_kses_data( __('Put here your invisible html/js code: Google analitics, counters, etc',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'custom_css_html' => array('yes')
					),
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"allow_html" => true,
					"allow_js" => true,
					"type" => "textarea"
					),
		
		'custom_css' => array(
					"title" => esc_html__('Your custom CSS code',  'trueman'),
					"desc" => wp_kses_data( __('Put here your css code to correct main theme styles',  'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'custom_css_html' => array('yes')
					),
					"divider" => false,
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"type" => "textarea"
					),
		
		
		
		
		
		
		
		
		
		//###############################
		//#### Blog and Single pages #### 
		//###############################
		"partition_blog" => array(
					"title" => esc_html__('Blog &amp; Single', 'trueman'),
					"icon" => "iconadmin-docs",
					"override" => "category,services_group,post,page,custom",
					"type" => "partition"),
		
		
		
		// Blog -> Stream page
		//-------------------------------------------------
		
		'blog_tab_stream' => array(
					"title" => esc_html__('Stream page', 'trueman'),
					"start" => 'blog_tabs',
					"icon" => "iconadmin-docs",
					"override" => "category,services_group,post,page,custom",
					"type" => "tab"),
		
		"info_blog_1" => array(
					"title" => esc_html__('Blog streampage parameters', 'trueman'),
					"desc" => wp_kses_data( __('Select desired blog streampage parameters (you can override it in each category)', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"blog_style" => array(
					"title" => esc_html__('Blog style', 'trueman'),
					"desc" => wp_kses_data( __('Select desired blog style', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"std" => "excerpt",
					"options" => trueman_get_options_param('list_blog_styles'),
					"type" => "select"),
		
		"hover_style" => array(
					"title" => esc_html__('Hover style', 'trueman'),
					"desc" => wp_kses_data( __('Select desired hover style (only for Blog style = Portfolio)', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'blog_style' => array('portfolio','grid','square','colored')
					),
					"std" => "square effect_shift",
					"options" => trueman_get_options_param('list_hovers'),
					"type" => "select"),
		
		"hover_dir" => array(
					"title" => esc_html__('Hover dir', 'trueman'),
					"desc" => wp_kses_data( __('Select hover direction (only for Blog style = Portfolio and Hover style = Circle or Square)', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'blog_style' => array('portfolio','grid','square','colored'),
						'hover_style' => array('square','circle')
					),
					"std" => "left_to_right",
					"options" => trueman_get_options_param('list_hovers_dir'),
					"type" => "select"),
		
		"article_style" => array(
					"title" => esc_html__('Article style', 'trueman'),
					"desc" => wp_kses_data( __('Select article display method: boxed or stretch', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"std" => "stretch",
					"options" => trueman_get_options_param('list_article_styles'),
					"size" => "medium",
					"type" => "switch"),
		
		"dedicated_location" => array(
					"title" => esc_html__('Dedicated location', 'trueman'),
					"desc" => wp_kses_data( __('Select location for the dedicated content or featured image in the "excerpt" blog style', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"std" => "default",
					"options" => trueman_get_options_param('list_locations'),
					"type" => "select"),
		
		"show_filters" => array(
					"title" => esc_html__('Show filters', 'trueman'),
					"desc" => wp_kses_data( __('What taxonomy use for filter buttons', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'blog_style' => array('portfolio','grid','square','colored')
					),
					"std" => "hide",
					"options" => trueman_get_options_param('list_filters'),
					"type" => "checklist"),
		
		"blog_sort" => array(
					"title" => esc_html__('Blog posts sorted by', 'trueman'),
					"desc" => wp_kses_data( __('Select the desired sorting method for posts', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"std" => "date",
					"options" => trueman_get_options_param('list_sorting'),
					"dir" => "vertical",
					"type" => "radio"),
		
		"blog_order" => array(
					"title" => esc_html__('Blog posts order', 'trueman'),
					"desc" => wp_kses_data( __('Select the desired ordering method for posts', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"std" => "desc",
					"options" => trueman_get_options_param('list_ordering'),
					"size" => "big",
					"type" => "switch"),
		
		"posts_per_page" => array(
					"title" => esc_html__('Blog posts per page',  'trueman'),
					"desc" => wp_kses_data( __('How many posts display on blog pages for selected style. If empty or 0 - inherit system wordpress settings',  'trueman') ),
					"override" => "category,services_group,page,custom",
					"std" => "12",
					"mask" => "?99",
					"type" => "text"),
		
		"post_excerpt_maxlength" => array(
					"title" => esc_html__('Excerpt maxlength for streampage',  'trueman'),
					"desc" => wp_kses_data( __('How many characters from post excerpt are display in blog streampage (only for Blog style = Excerpt). 0 - do not trim excerpt.',  'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'blog_style' => array('excerpt', 'portfolio', 'grid', 'square', 'related')
					),
					"std" => "250",
					"mask" => "?9999",
					"type" => "text"),
		
		"post_excerpt_maxlength_masonry" => array(
					"title" => esc_html__('Excerpt maxlength for classic and masonry',  'trueman'),
					"desc" => wp_kses_data( __('How many characters from post excerpt are display in blog streampage (only for Blog style = Classic or Masonry). 0 - do not trim excerpt.',  'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'blog_style' => array('masonry', 'classic')
					),
					"std" => "150",
					"mask" => "?9999",
					"type" => "text"),
		
		
		
		
		// Blog -> Single page
		//-------------------------------------------------
		
		'blog_tab_single' => array(
					"title" => esc_html__('Single page', 'trueman'),
					"icon" => "iconadmin-doc",
					"override" => "category,services_group,post,page,custom",
					"type" => "tab"),
		
		
		"info_single_1" => array(
					"title" => esc_html__('Single (detail) pages parameters', 'trueman'),
					"desc" => wp_kses_data( __('Select desired parameters for single (detail) pages (you can override it in each category and single post (page))', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"single_style" => array(
					"title" => esc_html__('Single page style', 'trueman'),
					"desc" => wp_kses_data( __('Select desired style for single page', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "single-standard",
					"options" => trueman_get_options_param('list_single_styles'),
					"dir" => "horizontal",
					"type" => "radio"),

		"icon" => array(
					"title" => esc_html__('Select post icon', 'trueman'),
					"desc" => wp_kses_data( __('Select icon for output before post/category name in some layouts', 'trueman') ),
					"override" => "services_group,post,page,custom",
					"std" => "",
					"options" => trueman_get_options_param('list_icons'),
					"style" => "select",
					"type" => "icons"
					),

		"alter_thumb_size" => array(
					"title" => esc_html__('Alter thumb size (WxH)',  'trueman'),
					"override" => "page,post",
					"desc" => wp_kses_data( __("Select thumb size for the alternative portfolio layout (number items horizontally x number items vertically)", 'trueman') ),
					"class" => "",
					"std" => "1_1",
					"type" => "radio",
					"options" => trueman_get_options_param('list_alter_sizes')
					),
		
		"show_featured_image" => array(
					"title" => esc_html__('Show featured image before post',  'trueman'),
					"desc" => wp_kses_data( __("Show featured image (if selected) before post content on single pages", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_post_title" => array(
					"title" => esc_html__('Show post title', 'trueman'),
					"desc" => wp_kses_data( __('Show area with post title on single pages', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_post_title_on_quotes" => array(
					"title" => esc_html__('Show post title on links, chat, quote, status', 'trueman'),
					"desc" => wp_kses_data( __('Show area with post title on single and blog pages in specific post formats: links, chat, quote, status', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_post_info" => array(
					"title" => esc_html__('Show post info', 'trueman'),
					"desc" => wp_kses_data( __('Show area with post info on single pages', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_text_before_readmore" => array(
					"title" => esc_html__('Show text before "Read more" tag', 'trueman'),
					"desc" => wp_kses_data( __('Show text before "Read more" tag on single pages', 'trueman') ),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
					
		"show_post_author" => array(
					"title" => esc_html__('Show post author details',  'trueman'),
					"desc" => wp_kses_data( __("Show post author information block on single post page", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_post_tags" => array(
					"title" => esc_html__('Show post tags',  'trueman'),
					"desc" => wp_kses_data( __("Show tags block on single post page", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_post_related" => array(
					"title" => esc_html__('Show related posts',  'trueman'),
					"desc" => wp_kses_data( __("Show related posts block on single post page", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),

		"post_related_count" => array(
					"title" => esc_html__('Related posts number',  'trueman'),
					"desc" => wp_kses_data( __("How many related posts showed on single post page", 'trueman') ),
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"override" => "category,services_group,post,page,custom",
					"std" => "2",
					"step" => 1,
					"min" => 2,
					"max" => 8,
					"type" => "spinner"),

		"post_related_columns" => array(
					"title" => esc_html__('Related posts columns',  'trueman'),
					"desc" => wp_kses_data( __("How many columns used to show related posts on single post page. 1 - use scrolling to show all related posts", 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"std" => "2",
					"step" => 1,
					"min" => 1,
					"max" => 4,
					"type" => "spinner"),
		
		"post_related_sort" => array(
					"title" => esc_html__('Related posts sorted by', 'trueman'),
					"desc" => wp_kses_data( __('Select the desired sorting method for related posts', 'trueman') ),
		//			"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"std" => "date",
					"options" => trueman_get_options_param('list_sorting'),
					"type" => "select"),
		
		"post_related_order" => array(
					"title" => esc_html__('Related posts order', 'trueman'),
					"desc" => wp_kses_data( __('Select the desired ordering method for related posts', 'trueman') ),
		//			"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"std" => "desc",
					"options" => trueman_get_options_param('list_ordering'),
					"size" => "big",
					"type" => "switch"),
		
		
		
		// Blog -> Other parameters
		//-------------------------------------------------
		
		'blog_tab_other' => array(
					"title" => esc_html__('Other parameters', 'trueman'),
					"icon" => "iconadmin-newspaper",
					"override" => "category,services_group,page,custom",
					"type" => "tab"),
		
		"info_blog_other_1" => array(
					"title" => esc_html__('Other Blog parameters', 'trueman'),
					"desc" => wp_kses_data( __('Select excluded categories, substitute parameters, etc.', 'trueman') ),
					"type" => "info"),
		
		"exclude_cats" => array(
					"title" => esc_html__('Exclude categories', 'trueman'),
					"desc" => wp_kses_data( __('Select categories, which posts are exclude from blog page', 'trueman') ),
					"std" => "",
					"options" => trueman_get_options_param('list_categories'),
					"multiple" => true,
					"style" => "list",
					"type" => "select"),
		
		"blog_pagination" => array(
					"title" => esc_html__('Blog pagination', 'trueman'),
					"desc" => wp_kses_data( __('Select type of the pagination on blog streampages', 'trueman') ),
					"std" => "pages",
					"override" => "category,services_group,page,custom",
					"options" => array(
						'pages'    => esc_html__('Standard page numbers', 'trueman'),
						'slider'   => esc_html__('Slider with page numbers', 'trueman'),
						'viewmore' => esc_html__('"View more" button', 'trueman'),
						'infinite' => esc_html__('Infinite scroll', 'trueman')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"blog_counters" => array(
					"title" => esc_html__('Blog counters', 'trueman'),
					"desc" => wp_kses_data( __('Select counters, displayed near the post title', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"std" => "views",
					"options" => trueman_get_options_param('list_blog_counters'),
					"dir" => "vertical",
					"multiple" => true,
					"type" => "checklist"),
		
		"close_category" => array(
					"title" => esc_html__("Post's category announce", 'trueman'),
					"desc" => wp_kses_data( __('What category display in announce block (over posts thumb) - original or nearest parental', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"std" => "parental",
					"options" => array(
						'parental' => esc_html__('Nearest parental category', 'trueman'),
						'original' => esc_html__("Original post's category", 'trueman')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"show_date_after" => array(
					"title" => esc_html__('Show post date after', 'trueman'),
					"desc" => wp_kses_data( __('Show post date after N days (before - show post age)', 'trueman') ),
					"override" => "category,services_group,page,custom",
					"std" => "30",
					"mask" => "?99",
					"type" => "text"),
		
		
		
		
		
		//###############################
		//#### Reviews               #### 
		//###############################
		"partition_reviews" => array(
					"title" => esc_html__('Reviews', 'trueman'),
					"icon" => "iconadmin-newspaper",
					"override" => "category,services_group,services_group",
					"type" => "partition"),
		
		"info_reviews_1" => array(
					"title" => esc_html__('Reviews criterias', 'trueman'),
					"desc" => wp_kses_data( __('Set up list of reviews criterias. You can override it in any category.', 'trueman') ),
					"override" => "category,services_group,services_group",
					"type" => "info"),
		
		"show_reviews" => array(
					"title" => esc_html__('Show reviews block',  'trueman'),
					"desc" => wp_kses_data( __("Show reviews block on single post page and average reviews rating after post's title in stream pages", 'trueman') ),
					"override" => "category,services_group,services_group",
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"reviews_max_level" => array(
					"title" => esc_html__('Max reviews level',  'trueman'),
					"desc" => wp_kses_data( __("Maximum level for reviews marks", 'trueman') ),
					"std" => "5",
					"options" => array(
						'5'=>esc_html__('5 stars', 'trueman'), 
						'10'=>esc_html__('10 stars', 'trueman'), 
						'100'=>esc_html__('100%', 'trueman')
					),
					"type" => "radio",
					),
		
		"reviews_style" => array(
					"title" => esc_html__('Show rating as',  'trueman'),
					"desc" => wp_kses_data( __("Show rating marks as text or as stars/progress bars.", 'trueman') ),
					"std" => "stars",
					"options" => array(
						'text' => esc_html__('As text (for example: 7.5 / 10)', 'trueman'), 
						'stars' => esc_html__('As stars or bars', 'trueman')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"reviews_criterias_levels" => array(
					"title" => esc_html__('Reviews Criterias Levels', 'trueman'),
					"desc" => wp_kses_data( __('Words to mark criterials levels. Just write the word and press "Enter". Also you can arrange words.', 'trueman') ),
					"std" => esc_html__("bad,poor,normal,good,great", 'trueman'),
					"type" => "tags"),
		
		"reviews_first" => array(
					"title" => esc_html__('Show first reviews',  'trueman'),
					"desc" => wp_kses_data( __("What reviews will be displayed first: by author or by visitors. Also this type of reviews will display under post's title.", 'trueman') ),
					"std" => "author",
					"options" => array(
						'author' => esc_html__('By author', 'trueman'),
						'users' => esc_html__('By visitors', 'trueman')
						),
					"dir" => "horizontal",
					"type" => "radio"),
		
		"reviews_second" => array(
					"title" => esc_html__('Hide second reviews',  'trueman'),
					"desc" => wp_kses_data( __("Do you want hide second reviews tab in widgets and single posts?", 'trueman') ),
					"std" => "show",
					"options" => trueman_get_options_param('list_show_hide'),
					"size" => "medium",
					"type" => "switch"),
		
		"reviews_can_vote" => array(
					"title" => esc_html__('What visitors can vote',  'trueman'),
					"desc" => wp_kses_data( __("What visitors can vote: all or only registered", 'trueman') ),
					"std" => "all",
					"options" => array(
						'all'=>esc_html__('All visitors', 'trueman'), 
						'registered'=>esc_html__('Only registered', 'trueman')
					),
					"dir" => "horizontal",
					"type" => "radio"),
		
		"reviews_criterias" => array(
					"title" => esc_html__('Reviews criterias',  'trueman'),
					"desc" => wp_kses_data( __('Add default reviews criterias.',  'trueman') ),
					"override" => "category,services_group,services_group",
					"std" => "",
					"cloneable" => true,
					"type" => "text"),

		// Don't remove this parameter - it used in admin for store marks
		"reviews_marks" => array(
					"std" => "",
					"type" => "hidden"),
		





		//###############################
		//#### Media                #### 
		//###############################
		"partition_media" => array(
					"title" => esc_html__('Media', 'trueman'),
					"icon" => "iconadmin-picture",
					"override" => "category,services_group,post,page,custom",
					"type" => "partition"),
		
		"info_media_1" => array(
					"title" => esc_html__('Media settings', 'trueman'),
					"desc" => wp_kses_data( __('Set up parameters to show images, galleries, audio and video posts', 'trueman') ),
					"override" => "category,services_group,services_group",
					"type" => "info"),
					
		"retina_ready" => array(
					"title" => esc_html__('Image dimensions', 'trueman'),
					"desc" => wp_kses_data( __('What dimensions use for uploaded image: Original or "Retina ready" (twice enlarged)', 'trueman') ),
					"std" => "1",
					"size" => "medium",
					"options" => array(
						"1" => esc_html__("Original", 'trueman'), 
						"2" => esc_html__("Retina", 'trueman')
					),
					"type" => "switch"),
		
		"images_quality" => array(
					"title" => esc_html__('Quality for cropped images', 'trueman'),
					"desc" => wp_kses_data( __('Quality (1-100) to save cropped images', 'trueman') ),
					"std" => "70",
					"min" => 1,
					"max" => 100,
					"type" => "spinner"),
		
		"substitute_gallery" => array(
					"title" => esc_html__('Substitute standard Wordpress gallery', 'trueman'),
					"desc" => wp_kses_data( __('Substitute standard Wordpress gallery with our slider on the single pages', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"gallery_instead_image" => array(
					"title" => esc_html__('Show gallery instead featured image', 'trueman'),
					"desc" => wp_kses_data( __('Show slider with gallery instead featured image on blog streampage and in the related posts section for the gallery posts', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"gallery_max_slides" => array(
					"title" => esc_html__('Max images number in the slider', 'trueman'),
					"desc" => wp_kses_data( __('Maximum images number from gallery into slider', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'gallery_instead_image' => array('yes')
					),
					"std" => "5",
					"min" => 2,
					"max" => 10,
					"type" => "spinner"),
		
		"popup_engine" => array(
					"title" => esc_html__('Popup engine to zoom images', 'trueman'),
					"desc" => wp_kses_data( __('Select engine to show popup windows with images and galleries', 'trueman') ),
					"std" => "magnific",
					"options" => trueman_get_options_param('list_popups'),
					"type" => "select"),
		
		"substitute_audio" => array(
					"title" => esc_html__('Substitute audio tags', 'trueman'),
					"desc" => wp_kses_data( __('Substitute audio tag with source from soundcloud to embed player', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"substitute_video" => array(
					"title" => esc_html__('Substitute video tags', 'trueman'),
					"desc" => wp_kses_data( __('Substitute video tags with embed players or leave video tags unchanged (if you use third party plugins for the video tags)', 'trueman') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"use_mediaelement" => array(
					"title" => esc_html__('Use Media Element script for audio and video tags', 'trueman'),
					"desc" => wp_kses_data( __('Do you want use the Media Element script for all audio and video tags on your site or leave standard HTML5 behaviour?', 'trueman') ),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		
		
		
		//###############################
		//#### Socials               #### 
		//###############################
		"partition_socials" => array(
					"title" => esc_html__('Socials', 'trueman'),
					"icon" => "iconadmin-users",
					"override" => "category,services_group,page,custom",
					"type" => "partition"),
		
		"info_socials_1" => array(
					"title" => esc_html__('Social networks', 'trueman'),
					"desc" => wp_kses_data( __("Social networks list for site footer and Social widget", 'trueman') ),
					"type" => "info"),
		
		"social_icons" => array(
					"title" => esc_html__('Social networks',  'trueman'),
					"desc" => wp_kses_data( __('Select icon and write URL to your profile in desired social networks.',  'trueman') ),
					"std" => array(array('url'=>'', 'icon'=>'')),
					"cloneable" => true,
					"size" => "small",
					"style" => $socials_type,
					"options" => $socials_type=='images' ? trueman_get_options_param('list_socials') : trueman_get_options_param('list_icons'),
					"type" => "socials"),
		
		"info_socials_2" => array(
					"title" => esc_html__('Share buttons', 'trueman'),
					"desc" => wp_kses_data( __("Add button's code for each social share network.<br>
					In share url you can use next macro:<br>
					<b>{url}</b> - share post (page) URL,<br>
					<b>{title}</b> - post title,<br>
					<b>{image}</b> - post image,<br>
					<b>{descr}</b> - post description (if supported)<br>
					For example:<br>
					<b>Facebook</b> share string: <em>http://www.facebook.com/sharer.php?u={link}&amp;t={title}</em><br>
					<b>Delicious</b> share string: <em>http://delicious.com/save?url={link}&amp;title={title}&amp;note={descr}</em>", 'trueman') ),
					"override" => "category,services_group,page,custom",
					"type" => "info"),
		
		"show_share" => array(
					"title" => esc_html__('Show social share buttons',  'trueman'),
					"desc" => wp_kses_data( __("Show social share buttons block", 'trueman') ),
					"override" => "category,services_group,page,custom",
					"std" => "horizontal",
					"options" => array(
						'hide'		=> esc_html__('Hide', 'trueman'),
						'vertical'	=> esc_html__('Vertical', 'trueman'),
						'horizontal'=> esc_html__('Horizontal', 'trueman')
					),
					"type" => "checklist"),

		"show_share_counters" => array(
					"title" => esc_html__('Show share counters',  'trueman'),
					"desc" => wp_kses_data( __("Show share counters after social buttons", 'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_share' => array('vertical', 'horizontal')
					),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),

		"share_caption" => array(
					"title" => esc_html__('Share block caption',  'trueman'),
					"desc" => wp_kses_data( __('Caption for the block with social share buttons',  'trueman') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_share' => array('vertical', 'horizontal')
					),
					"std" => esc_html__('Share:', 'trueman'),
					"type" => "text"),
		
		"share_buttons" => array(
					"title" => esc_html__('Share buttons',  'trueman'),
					"desc" => wp_kses_data( __('Select icon and write share URL for desired social networks.<br><b>Important!</b> If you leave text field empty - internal theme link will be used (if present).',  'trueman') ),
					"dependency" => array(
						'show_share' => array('vertical', 'horizontal')
					),
					"std" => array(array('url'=>'', 'icon'=>'')),
					"cloneable" => true,
					"size" => "small",
					"style" => $socials_type,
					"options" => $socials_type=='images' ? trueman_get_options_param('list_socials') : trueman_get_options_param('list_icons'),
					"type" => "socials"),
		
		
		"info_socials_3" => array(
					"title" => esc_html__('Twitter API keys', 'trueman'),
					"desc" => wp_kses_data( __("Put to this section Twitter API 1.1 keys.<br>You can take them after registration your application in <strong>https://apps.twitter.com/</strong>", 'trueman') ),
					"type" => "info"),
		
		"twitter_username" => array(
					"title" => esc_html__('Twitter username',  'trueman'),
					"desc" => wp_kses_data( __('Your login (username) in Twitter',  'trueman') ),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_consumer_key" => array(
					"title" => esc_html__('Consumer Key',  'trueman'),
					"desc" => wp_kses_data( __('Twitter API Consumer key',  'trueman') ),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_consumer_secret" => array(
					"title" => esc_html__('Consumer Secret',  'trueman'),
					"desc" => wp_kses_data( __('Twitter API Consumer secret',  'trueman') ),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_token_key" => array(
					"title" => esc_html__('Token Key',  'trueman'),
					"desc" => wp_kses_data( __('Twitter API Token key',  'trueman') ),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_token_secret" => array(
					"title" => esc_html__('Token Secret',  'trueman'),
					"desc" => wp_kses_data( __('Twitter API Token secret',  'trueman') ),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		
		
		
		
		//###############################
		//#### Contact info          #### 
		//###############################
		"partition_contacts" => array(
					"title" => esc_html__('Contact info', 'trueman'),
					"icon" => "iconadmin-mail",
					"type" => "partition"),
		
		"info_contact_1" => array(
					"title" => esc_html__('Contact information', 'trueman'),
					"desc" => wp_kses_data( __('Company address, phones and e-mail', 'trueman') ),
					"type" => "info"),
		
		"contact_info" => array(
					"title" => esc_html__('Contacts in the header', 'trueman'),
					"desc" => wp_kses_data( __('String with contact info in the left side of the site header', 'trueman') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"allow_html" => true,
					"type" => "text"),
		
		"contact_open_hours" => array(
					"title" => esc_html__('Open hours in the header', 'trueman'),
					"desc" => wp_kses_data( __('String with open hours in the site header', 'trueman') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-clock'),
					"allow_html" => true,
					"type" => "text"),
		
		"contact_email" => array(
					"title" => esc_html__('Contact form email', 'trueman'),
					"desc" => wp_kses_data( __('E-mail for send contact form and user registration data', 'trueman') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-mail'),
					"type" => "text"),
		
		"contact_address_1" => array(
					"title" => esc_html__('Company address (part 1)', 'trueman'),
					"desc" => wp_kses_data( __('Company country, post code and city', 'trueman') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),
		
		"contact_address_2" => array(
					"title" => esc_html__('Company address (part 2)', 'trueman'),
					"desc" => wp_kses_data( __('Street and house number', 'trueman') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),
		
		"contact_phone" => array(
					"title" => esc_html__('Phone', 'trueman'),
					"desc" => wp_kses_data( __('Phone number', 'trueman') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-phone'),
					"allow_html" => true,
					"type" => "text"),
		
		"contact_fax" => array(
					"title" => esc_html__('Fax', 'trueman'),
					"desc" => wp_kses_data( __('Fax number', 'trueman') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-phone'),
					"allow_html" => true,
					"type" => "text"),
		
		"info_contact_2" => array(
					"title" => esc_html__('Contact and Comments form', 'trueman'),
					"desc" => wp_kses_data( __('Maximum length of the messages in the contact form shortcode and in the comments form', 'trueman') ),
					"type" => "info"),
		
		"message_maxlength_contacts" => array(
					"title" => esc_html__('Contact form message', 'trueman'),
					"desc" => wp_kses_data( __("Message's maxlength in the contact form shortcode", 'trueman') ),
					"std" => "1000",
					"min" => 0,
					"max" => 10000,
					"step" => 100,
					"type" => "spinner"),
		
		"message_maxlength_comments" => array(
					"title" => esc_html__('Comments form message', 'trueman'),
					"desc" => wp_kses_data( __("Message's maxlength in the comments form", 'trueman') ),
					"std" => "1000",
					"min" => 0,
					"max" => 10000,
					"step" => 100,
					"type" => "spinner"),
		
		"info_contact_3" => array(
					"title" => esc_html__('Default mail function', 'trueman'),
					"desc" => wp_kses_data( __('What function use to send mail: the built-in Wordpress or standard PHP function? Attention! Some plugins may not work with one of them and you always have the ability to switch to alternative.', 'trueman') ),
					"type" => "info"),
		
		"mail_function" => array(
					"title" => esc_html__("Mail function", 'trueman'),
					"desc" => wp_kses_data( __("What function use to send mail? Attention! Only wp_mail support attachment in the mail!", 'trueman') ),
					"std" => "wp_mail",
					"size" => "medium",
					"options" => array(
						'wp_mail' => esc_html__('WP mail', 'trueman'),
						'mail' => esc_html__('PHP mail', 'trueman')
					),
					"type" => "switch"),
		
		
		
		
		
		
		
		//###############################
		//#### Search parameters     #### 
		//###############################
		"partition_search" => array(
					"title" => esc_html__('Search', 'trueman'),
					"icon" => "iconadmin-search",
					"type" => "partition"),
		
		"info_search_1" => array(
					"title" => esc_html__('Search parameters', 'trueman'),
					"desc" => wp_kses_data( __('Enable/disable AJAX search and output settings for it', 'trueman') ),
					"type" => "info"),
		
		"show_search" => array(
					"title" => esc_html__('Show search field', 'trueman'),
					"desc" => wp_kses_data( __('Show search field in the top area and side menus', 'trueman') ),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),

		"search_style" => array( 
					"title" => esc_html__('Select search style', 'trueman'),
					"desc" => wp_kses_data( __('Select style for the search field', 'trueman') ),
					"std" => "default",
					"type" => "select",
					"options" => trueman_get_options_param('list_search_styles')),
		
		"use_ajax_search" => array(
					"title" => esc_html__('Enable AJAX search', 'trueman'),
					"desc" => wp_kses_data( __('Use incremental AJAX search for the search field in top of page', 'trueman') ),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand')
					),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"ajax_search_min_length" => array(
					"title" => esc_html__('Min search string length',  'trueman'),
					"desc" => wp_kses_data( __('The minimum length of the search string',  'trueman') ),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"std" => 4,
					"min" => 3,
					"type" => "spinner"),
		
		"ajax_search_delay" => array(
					"title" => esc_html__('Delay before search (in ms)',  'trueman'),
					"desc" => wp_kses_data( __('How much time (in milliseconds, 1000 ms = 1 second) must pass after the last character before the start search',  'trueman') ),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"std" => 500,
					"min" => 300,
					"max" => 1000,
					"step" => 100,
					"type" => "spinner"),
		
		"ajax_search_types" => array(
					"title" => esc_html__('Search area', 'trueman'),
					"desc" => wp_kses_data( __('Select post types, what will be include in search results. If not selected - use all types.', 'trueman') ),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"std" => "",
					"options" => trueman_get_options_param('list_posts_types'),
					"multiple" => true,
					"style" => "list",
					"type" => "select"),
		
		"ajax_search_posts_count" => array(
					"title" => esc_html__('Posts number in output',  'trueman'),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"desc" => wp_kses_data( __('Number of the posts to show in search results',  'trueman') ),
					"std" => 5,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),
		
		"ajax_search_posts_image" => array(
					"title" => esc_html__("Show post's image", 'trueman'),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"desc" => wp_kses_data( __("Show post's thumbnail in the search results", 'trueman') ),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"ajax_search_posts_date" => array(
					"title" => esc_html__("Show post's date", 'trueman'),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"desc" => wp_kses_data( __("Show post's publish date in the search results", 'trueman') ),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"ajax_search_posts_author" => array(
					"title" => esc_html__("Show post's author", 'trueman'),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"desc" => wp_kses_data( __("Show post's author in the search results", 'trueman') ),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"ajax_search_posts_counters" => array(
					"title" => esc_html__("Show post's counters", 'trueman'),
					"dependency" => array(
						'show_search' => array('yes'),
						'search_style' => array('default', 'slide', 'expand'),
						'use_ajax_search' => array('yes')
					),
					"desc" => wp_kses_data( __("Show post's counters (views, comments, likes) in the search results", 'trueman') ),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		
		
		
		
		//###############################
		//#### Service               #### 
		//###############################
		
		"partition_service" => array(
					"title" => esc_html__('Service', 'trueman'),
					"icon" => "iconadmin-wrench",
					"type" => "partition"),
		
		"info_service_1" => array(
					"title" => esc_html__('Theme functionality', 'trueman'),
					"desc" => wp_kses_data( __('Basic theme functionality settings', 'trueman') ),
					"type" => "info"),
		
		"use_ajax_views_counter" => array(
					"title" => esc_html__('Use AJAX post views counter', 'trueman'),
					"desc" => wp_kses_data( __('Use javascript for post views count (if site work under the caching plugin) or increment views count in single page template', 'trueman') ),
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"allow_editor" => array(
					"title" => esc_html__('Frontend editor',  'trueman'),
					"desc" => wp_kses_data( __("Allow authors to edit their posts in frontend area", 'trueman') ),
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),

		"admin_add_filters" => array(
					"title" => esc_html__('Additional filters in the admin panel', 'trueman'),
					"desc" => wp_kses_data( __('Show additional filters (on post formats, tags and categories) in admin panel page "Posts". <br>Attention! If you have more than 2.000-3.000 posts, enabling this option may cause slow load of the "Posts" page! If you encounter such slow down, simply open Appearance - Theme Options - Service and set "No" for this option.', 'trueman') ),
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),

		"show_overriden_taxonomies" => array(
					"title" => esc_html__('Show overriden options for taxonomies', 'trueman'),
					"desc" => wp_kses_data( __('Show extra column in categories list, where changed (overriden) theme options are displayed.', 'trueman') ),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),

		"show_overriden_posts" => array(
					"title" => esc_html__('Show overriden options for posts and pages', 'trueman'),
					"desc" => wp_kses_data( __('Show extra column in posts and pages list, where changed (overriden) theme options are displayed.', 'trueman') ),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"admin_dummy_data" => array(
					"title" => esc_html__('Enable Dummy Data Installer', 'trueman'),
					"desc" => wp_kses_data( __('Show "Install Dummy Data" in the menu "Appearance". <b>Attention!</b> When you install dummy data all content of your site will be replaced!', 'trueman') ),
					"std" => "yes",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),

		"admin_dummy_timeout" => array(
					"title" => esc_html__('Dummy Data Installer Timeout',  'trueman'),
					"desc" => wp_kses_data( __('Web-servers set the time limit for the execution of php-scripts. By default, this is 30 sec. Therefore, the import process will be split into parts. Upon completion of each part - the import will resume automatically! The import process will try to increase this limit to the time, specified in this field.',  'trueman') ),
					"std" => 120,
					"min" => 30,
					"max" => 1800,
					"type" => "spinner"),
		
		"admin_emailer" => array(
					"title" => esc_html__('Enable Emailer in the admin panel', 'trueman'),
					"desc" => wp_kses_data( __('Allow to use Trueman Emailer for mass-volume e-mail distribution and management of mailing lists in "Appearance - Emailer"', 'trueman') ),
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "hidden"),

		"debug_mode" => array(
					"title" => esc_html__('Debug mode', 'trueman'),
					"desc" => wp_kses_data( __('In debug mode we are using unpacked scripts and styles, else - using minified scripts and styles (if present). <b>Attention!</b> If you have modified the source code in the js or css files, regardless of this option will be used latest (modified) version stylesheets and scripts. You can re-create minified versions of files using on-line services or utilities', 'trueman') ),
					"std" => "no",
					"options" => trueman_get_options_param('list_yes_no'),
					"type" => "switch"),
		

		'api_google' => array(
					"title" => esc_html__('Google API Key', 'trueman'),
					"desc" => wp_kses_data( __("Insert Google API Key for browsers into the field above to generate Google Maps", 'trueman') ),
					"std" => "",
					"type" => "text")

		));

	}
}


// Update all temporary vars (start with $trueman_) in the Theme Options with actual lists
if ( !function_exists( 'trueman_options_settings_theme_setup2' ) ) {
	add_action( 'trueman_action_after_init_theme', 'trueman_options_settings_theme_setup2', 1 );
	function trueman_options_settings_theme_setup2() {
		if (trueman_options_is_used()) {
			// Replace arrays with actual parameters
			$lists = array();
			$tmp = trueman_storage_get('options');
			if (is_array($tmp) && count($tmp) > 0) {
				$prefix = '$trueman_';
				$prefix_len = trueman_strlen($prefix);
				foreach ($tmp as $k=>$v) {
					if (isset($v['options']) && is_array($v['options']) && count($v['options']) > 0) {
						foreach ($v['options'] as $k1=>$v1) {
							if (trueman_substr($k1, 0, $prefix_len) == $prefix || trueman_substr($v1, 0, $prefix_len) == $prefix) {
								$list_func = trueman_substr(trueman_substr($k1, 0, $prefix_len) == $prefix ? $k1 : $v1, 1);
								$inherit = strpos($list_func, '(true)')!==false;
								$list_func = str_replace('(true)', '', $list_func);
								unset($tmp[$k]['options'][$k1]);
								if (isset($lists[$list_func]))
									$tmp[$k]['options'] = trueman_array_merge($tmp[$k]['options'], $lists[$list_func]);
								else {
									if (function_exists($list_func)) {
										$tmp[$k]['options'] = $lists[$list_func] = trueman_array_merge($tmp[$k]['options'], $list_func($inherit));
								   	} else
								   		dfl(sprintf(esc_html__('Wrong function name %s in the theme options array', 'trueman'), $list_func));
								}
							}
						}
					}
				}
				trueman_storage_set('options', $tmp);
			}
		}
	}
}



// Reset old Theme Options while theme first run
if ( !function_exists( 'trueman_options_reset' ) ) {
	function trueman_options_reset($clear=true) {
		$theme_slug = str_replace(' ', '_', trim(trueman_strtolower(get_stylesheet())));
		$option_name = trueman_storage_get('options_prefix') . '_' . trim($theme_slug) . '_options_reset';
		if ( get_option($option_name, false) === false ) {	// && (string) $theme_data->get('Version') == '1.0'
			if ($clear) {
				// Remove Theme Options from WP Options
				global $wpdb;
				$wpdb->query( $wpdb->prepare(
										"DELETE FROM {$wpdb->options} WHERE option_name LIKE %s",
										trueman_storage_get('options_prefix').'_%'
										)
							);
				// Add Templates Options
                $txt = trueman_fgc(trueman_storage_get('demo_data_url') . 'default/templates_options.txt');
				if (!empty($txt)) {
					$data = trueman_unserialize($txt);
					// Replace upload url in options
					if (is_array($data) && count($data) > 0) {
						foreach ($data as $k=>$v) {
							if (is_array($v) && count($v) > 0) {
								foreach ($v as $k1=>$v1) {
									$v[$k1] = trueman_replace_uploads_url(trueman_replace_uploads_url($v1, 'uploads'), 'imports');
								}
							}
							add_option( $k, $v, '', 'yes' );
						}
					}
				}
			}
			add_option($option_name, 1, '', 'yes');
		}
	}
}
?>