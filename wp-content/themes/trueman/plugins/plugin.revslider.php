<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('trueman_revslider_theme_setup')) {
	add_action( 'trueman_action_before_init_theme', 'trueman_revslider_theme_setup', 1 );
	function trueman_revslider_theme_setup() {
		if (trueman_exists_revslider()) {
			add_filter( 'trueman_filter_list_sliders',					'trueman_revslider_list_sliders' );
			add_filter( 'trueman_filter_shortcodes_params',			'trueman_revslider_shortcodes_params' );
			add_filter( 'trueman_filter_theme_options_params',			'trueman_revslider_theme_options_params' );
			if (is_admin()) {
				add_filter( 'trueman_filter_importer_options',			'trueman_revslider_importer_set_options', 10, 2 );
				add_action( 'trueman_action_importer_params',			'trueman_revslider_importer_show_params', 10, 1 );
				add_action( 'trueman_action_importer_clear_tables',	'trueman_revslider_importer_clear_tables', 10, 2 );
				add_action( 'trueman_action_importer_import',			'trueman_revslider_importer_import', 10, 2 );
				add_action( 'trueman_action_importer_import_fields',	'trueman_revslider_importer_import_fields', 10, 1 );
				add_action( 'trueman_action_importer_export',			'trueman_revslider_importer_export', 10, 1 );
				add_action( 'trueman_action_importer_export_fields',	'trueman_revslider_importer_export_fields', 10, 1 );
			}
		}
		if (is_admin()) {
			add_filter( 'trueman_filter_importer_required_plugins',	'trueman_revslider_importer_required_plugins', 10, 2 );
			add_filter( 'trueman_filter_required_plugins',				'trueman_revslider_required_plugins' );
		}
	}
}

if ( !function_exists( 'trueman_revslider_settings_theme_setup2' ) ) {
	add_action( 'trueman_action_before_init_theme', 'trueman_revslider_settings_theme_setup2', 3 );
	function trueman_revslider_settings_theme_setup2() {
		if (trueman_exists_revslider()) {

			// Add Revslider specific options in the Theme Options
			trueman_storage_set_array_after('options', 'slider_engine', "slider_alias", array(
				"title" => esc_html__('Revolution Slider: Select slider',  'trueman'),
				"desc" => wp_kses_data( __("Select slider to show (if engine=revo in the field above)", 'trueman') ),
				"override" => "category,services_group,page",
				"dependency" => array(
					'show_slider' => array('yes'),
					'slider_engine' => array('revo')
				),
				"std" => "",
				"options" => trueman_get_options_param('list_revo_sliders'),
				"type" => "select"
				)
			);

		}
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'trueman_exists_revslider' ) ) {
	function trueman_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'trueman_revslider_required_plugins' ) ) {
	function trueman_revslider_required_plugins($list=array()) {
		if (in_array('revslider', (array)trueman_storage_get('required_plugins'))) {
			$path = trueman_get_file_dir('plugins/install/revslider.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('Revolution Slider', 'trueman'),
					'slug' 		=> 'revslider',
					'source'	=> $path,
					'required' 	=> false
					);
			}
		}
		return $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check RevSlider in the required plugins
if ( !function_exists( 'trueman_revslider_importer_required_plugins' ) ) {
	function trueman_revslider_importer_required_plugins($not_installed='', $list='') {
		if (trueman_strpos($list, 'revslider')!==false && !trueman_exists_revslider() )
			$not_installed .= '<br>' . esc_html__('Revolution Slider', 'trueman');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trueman_revslider_importer_set_options' ) ) {
	function trueman_revslider_importer_set_options($options=array()) {
		if (trueman_exists_revslider() && in_array('revslider', trueman_storage_get('required_plugins'))) {
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_revslider'] = str_replace('name.ext', 'revslider.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trueman_revslider_importer_show_params' ) ) {
	function trueman_revslider_importer_show_params($importer) {
		if (!empty($importer->options['files'][$importer->options['demo_type']]['file_with_revslider'])) {
			$importer->show_importer_params(array(
				'slug' => 'revslider',
				'title' => esc_html__('Import Revolution Sliders', 'trueman'),
				'part' => 1
				));
		}
	}
}

// Clear tables
if ( !function_exists( 'trueman_revslider_importer_clear_tables' ) ) {
	function trueman_revslider_importer_clear_tables($importer, $clear_tables) {
		if (trueman_strpos($clear_tables, 'revslider')!==false && $importer->last_slider==0) {
			if ($importer->options['debug']) dfl(esc_html__('Clear Revolution Slider tables', 'trueman'));
			global $wpdb;
			$res = $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "revslider_sliders");
			if ( is_wp_error( $res ) ) dfl( esc_html__( 'Failed truncate table "revslider_sliders".', 'trueman' ) . ' ' . ($res->get_error_message()) );
			$res = $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "revslider_slides");
			if ( is_wp_error( $res ) ) dfl( esc_html__( 'Failed truncate table "revslider_slides".', 'trueman' ) . ' ' . ($res->get_error_message()) );
			$res = $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "revslider_static_slides");
			if ( is_wp_error( $res ) ) dfl( esc_html__( 'Failed truncate table "revslider_static_slides".', 'trueman' ) . ' ' . ($res->get_error_message()) );
		}
	}
}

// Import posts
if ( !function_exists( 'trueman_revslider_importer_import' ) ) {
	function trueman_revslider_importer_import($importer, $action) {
		if ( $action == 'import_revslider' && !empty($importer->options['files'][$importer->options['demo_type']]['file_with_revslider']) ) {
			if (file_exists(WP_PLUGIN_DIR . '/revslider/revslider.php')) {
				require_once WP_PLUGIN_DIR . '/revslider/revslider.php';
				if ($importer->options['debug']) dfl( esc_html__('Import Revolution sliders', 'trueman') );
				// Get last processed slider
				$last_arh = $importer->response['start_from_id'] = isset($_POST['start_from_id']) ? $_POST['start_from_id'] : '';
				// Get list of the sliders
				if ( ($txt = get_option('trueman_import_revsliders')) == '' ) {
					if ( ($txt = $importer->get_file($importer->options['files'][$importer->options['demo_type']]['file_with_revslider'])) === false)
						return;
					else
						update_option('trueman_import_revsliders', $txt);
				}
				$files = trueman_unserialize($txt);
				if (!is_array($files)) $files = explode("\n", str_replace("\r\n", "\n", $files));
				// Process next slider
				$slider = new RevSlider();
				// Process files
				$counter = 0;
				$result = 0;
				if (!is_array($_FILES)) $_FILES = array();
				foreach ($files as $file) {
					$counter++;
					if ( ($file = trim($file)) == '' )
						continue;
					if (!empty($last_arh)) {
						if ($file==$last_arh) 
							$last_arh = '';
						continue;
					}
					$need_del = false;
					// Load single file into system temp folder
					if ( ($zip = $importer->download_file($file, round(max(0, $counter-1) / count($files) * 100))) != '') {
						$need_del = substr($zip, 0, 5)=='http:' || substr($zip, 0, 6)=='https:';
						$_FILES["import_file"] = array("tmp_name" => $zip, 'error' => UPLOAD_ERR_OK);
						$response = $slider->importSliderFromPost();
						if ($need_del && file_exists($_FILES["import_file"]["tmp_name"]))
							unlink($_FILES["import_file"]["tmp_name"]);
					if ($response["success"] == false) {
							$msg = sprintf(esc_html__('Revolution Slider "%s" import error.', 'trueman'), $file);
							unset($importer->response['attempt']);
							$importer->response['error'] = $msg;
						if ($importer->options['debug'])  {
							dfl( $msg );
							dfo( $response );
						}
					} else {
							$importer->response['start_from_id'] = $file;
							$importer->response['result'] = min(100, round($counter / count($files) * 100));
						if ($importer->options['debug']) 
								dfl( sprintf(__('Slider "%s" imported', 'trueman'), basename($file)) );
						}
					}
					break;
				}
				if ($counter == count($files)) {
					update_option('trueman_import_revsliders', '');
				}
			} else {
				if ($importer->options['debug']) 
					dfl( sprintf(__('Can not locate plugin Revolution Slider: %s', 'trueman'), WP_PLUGIN_DIR.'/revslider/revslider.php') );
			}
		}
	}
}

// Display import progress
if ( !function_exists( 'trueman_revslider_importer_import_fields' ) ) {
	function trueman_revslider_importer_import_fields($importer) {
		$importer->show_importer_fields(array(
			'slug' => 'revslider',
			'title' => esc_html__('Revolution Slider', 'trueman')
			));
	}
}

// Export posts
if ( !function_exists( 'trueman_revslider_importer_export' ) ) {
	function trueman_revslider_importer_export($importer) {
		// Sliders list
		trueman_fpc(trueman_get_file_dir('core/core.importer/export/revslider.txt'), join("\n", array_keys(trueman_get_list_revo_sliders())));
	}
}

// Display exported data in the fields
if ( !function_exists( 'trueman_revslider_importer_export_fields' ) ) {
	function trueman_revslider_importer_export_fields($importer) {
		$importer->show_exporter_fields(array(
			'slug' => 'revslider',
			'title' => esc_html__('Revolution Sliders', 'trueman')
			));
	}
}


// Lists
//------------------------------------------------------------------------

// Add RevSlider in the sliders list, prepended inherit (if need)
if ( !function_exists( 'trueman_revslider_list_sliders' ) ) {
	function trueman_revslider_list_sliders($list=array()) {
		$list["revo"] = esc_html__("Layer slider (Revolution)", 'trueman');
		return $list;
	}
}

// Return Revo Sliders list, prepended inherit (if need)
if ( !function_exists( 'trueman_get_list_revo_sliders' ) ) {
	function trueman_get_list_revo_sliders($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_revo_sliders'))=='') {
			$list = array();
			if (trueman_exists_revslider()) {
				global $wpdb;
				$rows = $wpdb->get_results( "SELECT alias, title FROM " . esc_sql($wpdb->prefix) . "revslider_sliders" );
				if (is_array($rows) && count($rows) > 0) {
					foreach ($rows as $row) {
						$list[$row->alias] = $row->title;
					}
				}
			}
			$list = apply_filters('trueman_filter_list_revo_sliders', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_revo_sliders', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Add RevSlider in the shortcodes params
if ( !function_exists( 'trueman_revslider_shortcodes_params' ) ) {
	function trueman_revslider_shortcodes_params($list=array()) {
		$list["revo_sliders"] = trueman_get_list_revo_sliders();
		return $list;
	}
}

// Add RevSlider in the Theme Options params
if ( !function_exists( 'trueman_revslider_theme_options_params' ) ) {
	function trueman_revslider_theme_options_params($list=array()) {
		$list["list_revo_sliders"] = array('$trueman_get_list_revo_sliders' => '');
		return $list;
	}
}
?>