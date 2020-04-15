<?php
/* WPBakery PageBuilder support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('trueman_vc_theme_setup')) {
	add_action( 'trueman_action_before_init_theme', 'trueman_vc_theme_setup', 1 );
	function trueman_vc_theme_setup() {
		if (trueman_exists_visual_composer()) {
			if (is_admin()) {
				add_filter( 'trueman_filter_importer_options',				'trueman_vc_importer_set_options' );
			}
			add_action('trueman_action_add_styles',		 				'trueman_vc_frontend_scripts' );
		}
		if (is_admin()) {
			add_filter( 'trueman_filter_importer_required_plugins',		'trueman_vc_importer_required_plugins', 10, 2 );
			add_filter( 'trueman_filter_required_plugins',					'trueman_vc_required_plugins' );
		}
	}
}

// Check if WPBakery PageBuilder installed and activated
if ( !function_exists( 'trueman_exists_visual_composer' ) ) {
	function trueman_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}

// Check if WPBakery PageBuilder in frontend editor mode
if ( !function_exists( 'trueman_vc_is_frontend' ) ) {
	function trueman_vc_is_frontend() {
		return (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true')
			|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'trueman_vc_required_plugins' ) ) {
	function trueman_vc_required_plugins($list=array()) {
		if (in_array('visual_composer', trueman_storage_get('required_plugins'))) {
			$path = trueman_get_file_dir('plugins/install/js_composer.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__( 'WPBakery PageBuilder', 'trueman' ),
					'slug' 		=> 'js_composer',
					'source'	=> $path,
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Enqueue VC custom styles
if ( !function_exists( 'trueman_vc_frontend_scripts' ) ) {
	function trueman_vc_frontend_scripts() {
		if (file_exists(trueman_get_file_dir('css/plugin.visual-composer.css')))
			wp_enqueue_style( 'trueman-plugin.visual-composer-style',  trueman_get_file_url('css/plugin.visual-composer.css'), array(), null );
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check VC in the required plugins
if ( !function_exists( 'trueman_vc_importer_required_plugins' ) ) {
	function trueman_vc_importer_required_plugins($not_installed='', $list='') {
		if (!trueman_exists_visual_composer() )		// && trueman_strpos($list, 'visual_composer')!==false
			$not_installed .= '<br>WPBakery PageBuilder';
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'trueman_vc_importer_set_options' ) ) {
	function trueman_vc_importer_set_options($options=array()) {
		if ( in_array('visual_composer', trueman_storage_get('required_plugins')) && trueman_exists_visual_composer() ) {
			// Add slugs to export options for this plugin
			$options['additional_options'][] = 'wpb_js_templates';
		}
		return $options;
	}
}
?>