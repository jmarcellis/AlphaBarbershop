<?php
/**
 * Trueman Framework: Admin functions
 *
 * @package	trueman
 * @since	trueman 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Admin actions and filters:
------------------------------------------------------------------------ */

if (is_admin()) {

	/* Theme setup section
	-------------------------------------------------------------------- */
	
	if ( !function_exists( 'trueman_admin_theme_setup' ) ) {
		add_action( 'trueman_action_before_init_theme', 'trueman_admin_theme_setup', 11 );
		function trueman_admin_theme_setup() {
			if ( is_admin() ) {
				add_filter("trueman_filter_localize_script_admin", 'trueman_admin_localize_script');
				add_action("admin_enqueue_scripts",	'trueman_admin_load_scripts');
				add_action("admin_footer",			'trueman_admin_add_js_vars', 2);
				add_action('tgmpa_register',		'trueman_admin_register_plugins');

				// AJAX: Get terms for specified post type
				add_action('wp_ajax_trueman_admin_change_post_type', 		'trueman_callback_admin_change_post_type');
				add_action('wp_ajax_nopriv_trueman_admin_change_post_type','trueman_callback_admin_change_post_type');
			}
		}
	}
	
	// Load required styles and scripts for admin mode
	if ( !function_exists( 'trueman_admin_load_scripts' ) ) {
		function trueman_admin_load_scripts() {
			wp_enqueue_style( 'trueman-admin-style', trueman_get_file_url('css/core.admin.css'), array(), null );
			if (trueman_strpos(add_query_arg(array()), 'widgets.php')!==false) {
				wp_enqueue_style( 'trueman-fontello-style', trueman_get_file_url('css/fontello-admin/css/fontello-admin.css'), array(), null );
				wp_enqueue_style( 'trueman-animations-style', trueman_get_file_url('css/fontello-admin/css/animation.css'), array(), null );
			}
            if (trueman_get_theme_option('debug_mode')=='yes') {
			    wp_enqueue_script( 'trueman-debug-script', trueman_get_file_url('js/core.debug.js'), array('jquery'), null, true );
            }
			wp_enqueue_script( 'trueman-admin-script', trueman_get_file_url('js/core.admin.js'), array('jquery'), null, true );
		}
	}
	
	// Prepare required styles and scripts for admin mode
	if ( !function_exists( 'trueman_admin_localize_script' ) ) {
		function trueman_admin_localize_script($vars) {
			$vars['admin_mode'] = true;
			$vars['user_logged_in'] = true;
			$vars['ajax_nonce'] = wp_create_nonce(admin_url('admin-ajax.php'));
			$vars['ajax_url'] = esc_url(admin_url('admin-ajax.php'));
			$vars['ajax_error'] = esc_html__('Invalid server answer', 'trueman');
			$vars['importer_error_msg'] = esc_html__('Errors that occurred during the import process:', 'trueman');
			return $vars;
		}
	}

	//  Localize scripts in the footer hook
	if ( !function_exists( 'trueman_admin_add_js_vars' ) ) {
		function trueman_admin_add_js_vars() {
			$vars = apply_filters( 'trueman_filter_localize_script_admin', trueman_storage_empty('js_vars') ? array() : trueman_storage_get('js_vars'));
			if (!empty($vars)) wp_localize_script( 'trueman-admin-script', 'TRUEMAN_STORAGE', $vars);
			if (!trueman_storage_empty('js_code')) {
				$holder = 'script';
				?><<?php trueman_show_layout($holder); ?>>
					jQuery(document).ready(function() {
						<?php trueman_show_layout(trueman_minify_js(trueman_storage_get('js_code'))); ?>
					}
				</<?php trueman_show_layout($holder); ?>><?php
			}
		}
	}
	
	// AJAX: Get terms for specified post type
	if ( !function_exists( 'trueman_callback_admin_change_post_type' ) ) {
		function trueman_callback_admin_change_post_type() {
			if ( !wp_verify_nonce( trueman_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
				die();
			$post_type = $_REQUEST['post_type'];
			$terms = trueman_get_list_terms(false, trueman_get_taxonomy_categories_by_post_type($post_type));
			$terms = trueman_array_merge(array(0 => esc_html__('- Select category -', 'trueman')), $terms);
			$response = array(
				'error' => '',
				'data' => array(
					'ids' => array_keys($terms),
					'titles' => array_values($terms)
				)
			);
			echo json_encode($response);
			die();
		}
	}

	// Return current post type in dashboard
	if ( !function_exists( 'trueman_admin_get_current_post_type' ) ) {
		function trueman_admin_get_current_post_type() {
			global $post, $typenow, $current_screen;
			if ( $post && $post->post_type )							//we have a post so we can just get the post type from that
				return $post->post_type;
			else if ( $typenow )										//check the global $typenow — set in admin.php
				return $typenow;
			else if ( $current_screen && $current_screen->post_type )	//check the global $current_screen object — set in sceen.php
				return $current_screen->post_type;
			else if ( isset( $_REQUEST['post_type'] ) )					//check the post_type querystring
				return sanitize_key( $_REQUEST['post_type'] );
			else if ( isset( $_REQUEST['post'] ) ) {					//lastly check the post id querystring
				$post = get_post( sanitize_key( $_REQUEST['post'] ) );
				return !empty($post->post_type) ? $post->post_type : '';
			} else														//we do not know the post type!
				return '';
		}
	}

	// Add admin menu pages
	if ( !function_exists( 'trueman_admin_add_menu_item' ) ) {
		function trueman_admin_add_menu_item($mode, $item, $pos='100') {
			static $shift = 0;
			if ($pos=='100') $pos .= '.'.$shift++;
			$fn = join('_', array('add', $mode, 'page'));
			if (empty($item['parent']))
				$fn($item['page_title'], $item['menu_title'], $item['capability'], $item['menu_slug'], $item['callback'], $item['icon'], $pos);
			else
				$fn($item['parent'], $item['page_title'], $item['menu_title'], $item['capability'], $item['menu_slug'], $item['callback'], $item['icon'], $pos);
		}
	}
	
	// Register optional plugins
	if ( !function_exists( 'trueman_admin_register_plugins' ) ) {
		function trueman_admin_register_plugins() {

			$plugins = apply_filters('trueman_filter_required_plugins', array());
			$config = array(
				'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',                      // Default absolute path to bundled plugins.
				'menu'         => 'tgmpa-install-plugins', // Menu slug.
				'parent_slug'  => 'themes.php',            // Parent menu slug.
				'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
				'has_notices'  => true,                    // Show admin notices or not.
				'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => true,                    // Automatically activate plugins after installation or not.
				'message'      => ''                       // Message to output right before the plugins table.
			);
	
			tgmpa( $plugins, $config );
		}
	}

	require_once trailingslashit( get_template_directory() ) . TRUEMAN_FW_DIR . '/lib/tgm/class-tgm-plugin-activation.php';
}

?>