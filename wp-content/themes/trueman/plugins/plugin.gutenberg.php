<?php
/* Gutenberg support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('trueman_gutenberg_theme_setup')) {
    add_action( 'trueman_action_before_init_theme', 'trueman_gutenberg_theme_setup', 1 );
    function trueman_gutenberg_theme_setup() {
        if (is_admin()) {
            add_filter( 'trueman_filter_required_plugins', 'trueman_gutenberg_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'trueman_exists_gutenberg' ) ) {
    function trueman_exists_gutenberg() {
        return function_exists( 'the_gutenberg_project' ) && function_exists( 'register_block_type' );
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'trueman_gutenberg_required_plugins' ) ) {
    //Handler of add_filter('trueman_filter_required_plugins',    'trueman_gutenberg_required_plugins');
    function trueman_gutenberg_required_plugins($list=array()) {
        if (in_array('gutenberg', (array)trueman_storage_get('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('Gutenberg', 'trueman'),
                'slug'         => 'gutenberg',
                'required'     => false
            );
        return $list;
    }
}