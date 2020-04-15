<?php
// Disable WP site health test for automatic updates
// This plugin was added by Installatron because Installatron is handling upgrading of this application
function my_filter_site_status_tests($tests) {
    unset($tests['async']['background_updates']);
    return $tests;
}
add_filter('site_status_tests', 'my_filter_site_status_tests');
