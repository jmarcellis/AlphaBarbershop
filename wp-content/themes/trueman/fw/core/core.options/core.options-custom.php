<?php
/**
 * Trueman Framework: Theme options custom fields
 *
 * @package	trueman
 * @since	trueman 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'trueman_options_custom_theme_setup' ) ) {
	add_action( 'trueman_action_before_init_theme', 'trueman_options_custom_theme_setup' );
	function trueman_options_custom_theme_setup() {

		if ( is_admin() ) {
			add_action("admin_enqueue_scripts",	'trueman_options_custom_load_scripts');
		}
		
	}
}

// Load required styles and scripts for custom options fields
if ( !function_exists( 'trueman_options_custom_load_scripts' ) ) {
	function trueman_options_custom_load_scripts() {
		wp_enqueue_script( 'trueman-options-custom-script',	trueman_get_file_url('core/core.options/js/core.options-custom.js'), array(), null, true );
	}
}


// Show theme specific fields in Post (and Page) options
if ( !function_exists( 'trueman_show_custom_field' ) ) {
	function trueman_show_custom_field($id, $field, $value) {
		$output = '';
		switch ($field['type']) {
			case 'reviews':
				$output .= '<div class="reviews_block">' . trim(trueman_reviews_get_markup($field, $value, true)) . '</div>';
				break;
	
			case 'mediamanager':
				wp_enqueue_media( );
				$output .= '<a id="'.esc_attr($id).'" class="button mediamanager trueman_media_selector"
					data-param="' . esc_attr($id) . '"
					data-choose="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'trueman') : esc_html__( 'Choose Image', 'trueman')).'"
					data-update="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Add to Gallery', 'trueman') : esc_html__( 'Choose Image', 'trueman')).'"
					data-multiple="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? 'true' : 'false').'"
					data-linked-field="'.esc_attr($field['media_field_id']).'"
					>' . (isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'trueman') : esc_html__( 'Choose Image', 'trueman')) . '</a>';
				break;
		}
		return apply_filters('trueman_filter_show_custom_field', $output, $id, $field, $value);
	}
}
?>