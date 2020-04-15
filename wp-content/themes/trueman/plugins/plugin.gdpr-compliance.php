<?php
/* The GDPR Framework support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('trueman_gdpr_compliance_theme_setup')) {
    add_action( 'trueman_action_before_init_theme', 'trueman_gdpr_compliance_theme_setup', 1 );
    function trueman_gdpr_compliance_theme_setup() {
        if (is_admin()) {
            add_filter( 'trueman_filter_required_plugins', 'trueman_gdpr_compliance_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'trueman_exists_gdpr_compliance' ) ) {
    function trueman_exists_gdpr_compliance() {
        return defined( 'WP_GDPR_C_SLUG' );
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'trueman_gdpr_compliance_required_plugins' ) ) {
    //Handler of add_filter('trueman_filter_required_plugins',    'trueman_gdpr_compliance_required_plugins');
    function trueman_gdpr_compliance_required_plugins($list=array()) {
        if (in_array('gdpr-compliance', (array)trueman_storage_get('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('WP GDPR Compliance', 'trueman'),
                'slug'         => 'wp-gdpr-compliance',
                'required'     => false
            );
        return $list;
    }
}