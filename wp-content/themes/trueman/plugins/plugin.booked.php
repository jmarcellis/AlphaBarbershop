<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('trueman_booked_theme_setup')) {
	add_action( 'trueman_action_before_init_theme', 'trueman_booked_theme_setup', 1 );
	function trueman_booked_theme_setup() {
		// Register shortcode in the shortcodes list
		if (trueman_exists_booked()) {
			add_action('trueman_action_add_styles', 					'trueman_booked_frontend_scripts');
			add_action('trueman_action_shortcodes_list',				'trueman_booked_reg_shortcodes');
			if (function_exists('trueman_exists_visual_composer') && trueman_exists_visual_composer())
				add_action('trueman_action_shortcodes_list_vc',		'trueman_booked_reg_shortcodes_vc');
			if (is_admin()) {
				add_filter( 'trueman_filter_importer_options',			'trueman_booked_importer_set_options' );
			}
		}
		if (is_admin()) {
			add_filter( 'trueman_filter_importer_required_plugins',	'trueman_booked_importer_required_plugins', 10, 2);
			add_filter( 'trueman_filter_required_plugins',				'trueman_booked_required_plugins' );
		}
	}
}


// Check if plugin installed and activated
if ( !function_exists( 'trueman_exists_booked' ) ) {
	function trueman_exists_booked() {
		return class_exists('booked_plugin');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'trueman_booked_required_plugins' ) ) {
	function trueman_booked_required_plugins($list=array()) {
		if (in_array('booked', trueman_storage_get('required_plugins'))) {
			$path = trueman_get_file_dir('plugins/install/booked.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__( 'Booked', 'trueman' ),
					'slug' 		=> 'booked',
					'source'	=> $path,
					'required' 	=> false
					);
			}
            $path = trueman_get_file_dir( 'plugins/install/booked-calendar-feeds.zip' );
            if ( !empty($path) && file_exists($path) ) {
                $list[] = array(
                    'name'     => esc_html__( 'Booked Calendar Feeds', 'trueman' ),
                    'slug'     => 'booked-calendar-feeds',
                    'source'   => $path,
                    'version'  => '1.1.5',
                    'required' => false,
                );
            }
            $path = trueman_get_file_dir( 'plugins/install/booked-frontend-agents.zip' );
            if ( !empty($path) && file_exists($path) ) {
                $list[] = array(
                    'name'     => esc_html__( 'Booked Front-End Agents', 'trueman' ),
                    'slug'     => 'booked-frontend-agents',
                    'source'   => $path,
                    'version'  => '1.1.15',
                    'required' => false,
                );
            }
            $path = trueman_get_file_dir( 'plugins/install/booked-woocommerce-payments.zip' );
            if ( !empty($path) && file_exists($path) ) {
                $list[] = array(
                    'name'     => esc_html__( 'WooCommerce addons - Booked Payments with WooCommerce', 'trueman' ),
                    'slug'     => 'booked-woocommerce-payments',
                    'source'   => $path,
                    'version'  => '1.4.9',
                    'required' => false,
                );
            }
		}
		return $list;
	}
}

// Enqueue custom styles
if ( !function_exists( 'trueman_booked_frontend_scripts' ) ) {
	function trueman_booked_frontend_scripts() {
		if (file_exists(trueman_get_file_dir('css/plugin.booked.css')))
			wp_enqueue_style( 'trueman-plugin.booked-style',  trueman_get_file_url('css/plugin.booked.css'), array(), null );
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check in the required plugins
if ( !function_exists( 'trueman_booked_importer_required_plugins' ) ) {
	function trueman_booked_importer_required_plugins($not_installed='', $list='') {
		if (trueman_strpos($list, 'booked')!==false && !trueman_exists_booked() )
			$not_installed .= '<br>Booked Appointments';
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'trueman_booked_importer_set_options' ) ) {
	function trueman_booked_importer_set_options($options=array()) {
		if (in_array('booked', trueman_storage_get('required_plugins')) && trueman_exists_booked()) {
			$options['additional_options'][] = 'booked_%';		// Add slugs to export options for this plugin
		}
		return $options;
	}
}


// Lists
//------------------------------------------------------------------------

// Return booked calendars list, prepended inherit (if need)
if ( !function_exists( 'trueman_get_list_booked_calendars' ) ) {
	function trueman_get_list_booked_calendars($prepend_inherit=false) {
		return trueman_exists_booked() ? trueman_get_list_terms($prepend_inherit, 'booked_custom_calendars') : array();
	}
}



// Register plugin's shortcodes
//------------------------------------------------------------------------

// Register shortcode in the shortcodes list
if (!function_exists('trueman_booked_reg_shortcodes')) {
	function trueman_booked_reg_shortcodes() {
		if (trueman_storage_isset('shortcodes')) {

			$booked_cals = trueman_get_list_booked_calendars();

			trueman_sc_map('booked-appointments', array(
				"title" => esc_html__("Booked Appointments", 'trueman'),
				"desc" => esc_html__("Display the currently logged in user's upcoming appointments", 'trueman'),
				"decorate" => true,
				"container" => false,
				"params" => array()
				)
			);

			trueman_sc_map('booked-calendar', array(
				"title" => esc_html__("Booked Calendar", 'trueman'),
				"desc" => esc_html__("Insert booked calendar", 'trueman'),
				"decorate" => true,
				"container" => false,
				"params" => array(
					"calendar" => array(
						"title" => esc_html__("Calendar", 'trueman'),
						"desc" => esc_html__("Select booked calendar to display", 'trueman'),
						"value" => "0",
						"type" => "select",
						"options" => trueman_array_merge(array(0 => esc_html__('- Select calendar -', 'trueman')), $booked_cals)
					),
					"year" => array(
						"title" => esc_html__("Year", 'trueman'),
						"desc" => esc_html__("Year to display on calendar by default", 'trueman'),
						"value" => date("Y"),
						"min" => date("Y"),
						"max" => date("Y")+10,
						"type" => "spinner"
					),
					"month" => array(
						"title" => esc_html__("Month", 'trueman'),
						"desc" => esc_html__("Month to display on calendar by default", 'trueman'),
						"value" => date("m"),
						"min" => 1,
						"max" => 12,
						"type" => "spinner"
					)
				)
			));
		}
	}
}


// Register shortcode in the VC shortcodes list
if (!function_exists('trueman_booked_reg_shortcodes_vc')) {
	function trueman_booked_reg_shortcodes_vc() {

		$booked_cals = trueman_get_list_booked_calendars();

		// Booked Appointments
		vc_map( array(
				"base" => "booked-appointments",
				"name" => esc_html__("Booked Appointments", 'trueman'),
				"description" => esc_html__("Display the currently logged in user's upcoming appointments", 'trueman'),
				"category" => esc_html__('Content', 'trueman'),
				'icon' => 'icon_trx_booked',
				"class" => "trx_sc_single trx_sc_booked_appointments",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array()
			) );
			
		class WPBakeryShortCode_Booked_Appointments extends TRUEMAN_VC_ShortCodeSingle {}

		// Booked Calendar
		vc_map( array(
				"base" => "booked-calendar",
				"name" => esc_html__("Booked Calendar", 'trueman'),
				"description" => esc_html__("Insert booked calendar", 'trueman'),
				"category" => esc_html__('Content', 'trueman'),
				'icon' => 'icon_trx_booked',
				"class" => "trx_sc_single trx_sc_booked_calendar",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "calendar",
						"heading" => esc_html__("Calendar", 'trueman'),
						"description" => esc_html__("Select booked calendar to display", 'trueman'),
						"admin_label" => true,
						"class" => "",
						"std" => "0",
						"value" => array_flip(trueman_array_merge(array(0 => esc_html__('- Select calendar -', 'trueman')), $booked_cals)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "year",
						"heading" => esc_html__("Year", 'trueman'),
						"description" => esc_html__("Year to display on calendar by default", 'trueman'),
						"admin_label" => true,
						"class" => "",
						"std" => date("Y"),
						"value" => date("Y"),
						"type" => "textfield"
					),
					array(
						"param_name" => "month",
						"heading" => esc_html__("Month", 'trueman'),
						"description" => esc_html__("Month to display on calendar by default", 'trueman'),
						"admin_label" => true,
						"class" => "",
						"std" => date("m"),
						"value" => date("m"),
						"type" => "textfield"
					)
				)
			) );
			
		class WPBakeryShortCode_Booked_Calendar extends TRUEMAN_VC_ShortCodeSingle {}

	}
}
?>