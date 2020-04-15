<?php
if (!function_exists('trueman_theme_shortcodes_setup')) {
	add_action( 'trueman_action_before_init_theme', 'trueman_theme_shortcodes_setup', 1 );
	function trueman_theme_shortcodes_setup() {
		add_filter('trueman_filter_googlemap_styles', 'trueman_theme_shortcodes_googlemap_styles');
	}
}


// Add theme-specific Google map styles
if ( !function_exists( 'trueman_theme_shortcodes_googlemap_styles' ) ) {
	function trueman_theme_shortcodes_googlemap_styles($list) {
		$list['simple']		= esc_html__('Simple', 'trueman');
		$list['greyscale']	= esc_html__('Greyscale', 'trueman');
		$list['inverse']	= esc_html__('Inverse', 'trueman');
		$list['apple']		= esc_html__('Apple', 'trueman');
		return $list;
	}
}
?>