<?php
/**
 * Trueman Framework: messages subsystem
 *
 * @package	trueman
 * @since	trueman 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('trueman_messages_theme_setup')) {
	add_action( 'trueman_action_before_init_theme', 'trueman_messages_theme_setup' );
	function trueman_messages_theme_setup() {
		// Core messages strings
		add_filter('trueman_filter_localize_script', 'trueman_messages_localize_script');
	}
}


/* Session messages
------------------------------------------------------------------------------------- */

if (!function_exists('trueman_get_error_msg')) {
	function trueman_get_error_msg() {
		return trueman_storage_get('error_msg');
	}
}

if (!function_exists('trueman_set_error_msg')) {
	function trueman_set_error_msg($msg) {
		$msg2 = trueman_get_error_msg();
		trueman_storage_set('error_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('trueman_get_success_msg')) {
	function trueman_get_success_msg() {
		return trueman_storage_get('success_msg');
	}
}

if (!function_exists('trueman_set_success_msg')) {
	function trueman_set_success_msg($msg) {
		$msg2 = trueman_get_success_msg();
		trueman_storage_set('success_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('trueman_get_notice_msg')) {
	function trueman_get_notice_msg() {
		return trueman_storage_get('notice_msg');
	}
}

if (!function_exists('trueman_set_notice_msg')) {
	function trueman_set_notice_msg($msg) {
		$msg2 = trueman_get_notice_msg();
		trueman_storage_set('notice_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}


/* System messages (save when page reload)
------------------------------------------------------------------------------------- */
if (!function_exists('trueman_set_system_message')) {
	function trueman_set_system_message($msg, $status='info', $hdr='') {
		update_option(trueman_storage_get('options_prefix') . '_message', array('message' => $msg, 'status' => $status, 'header' => $hdr));
	}
}

if (!function_exists('trueman_get_system_message')) {
	function trueman_get_system_message($del=false) {
		$msg = get_option(trueman_storage_get('options_prefix') . '_message', false);
		if (!$msg)
			$msg = array('message' => '', 'status' => '', 'header' => '');
		else if ($del)
			trueman_del_system_message();
		return $msg;
	}
}

if (!function_exists('trueman_del_system_message')) {
	function trueman_del_system_message() {
		delete_option(trueman_storage_get('options_prefix') . '_message');
	}
}


/* Messages strings
------------------------------------------------------------------------------------- */

if (!function_exists('trueman_messages_localize_script')) {
	function trueman_messages_localize_script($vars) {
		$vars['strings'] = array(
			'ajax_error'		=> esc_html__('Invalid server answer', 'trueman'),
			'bookmark_add'		=> esc_html__('Add the bookmark', 'trueman'),
            'bookmark_added'	=> esc_html__('Current page has been successfully added to the bookmarks. You can see it in the right panel on the tab \'Bookmarks\'', 'trueman'),
            'bookmark_del'		=> esc_html__('Delete this bookmark', 'trueman'),
            'bookmark_title'	=> esc_html__('Enter bookmark title', 'trueman'),
            'bookmark_exists'	=> esc_html__('Current page already exists in the bookmarks list', 'trueman'),
			'search_error'		=> esc_html__('Error occurs in AJAX search! Please, type your query and press search icon for the traditional search way.', 'trueman'),
			'email_confirm'		=> esc_html__('On the e-mail address "%s" we sent a confirmation email. Please, open it and click on the link.', 'trueman'),
			'reviews_vote'		=> esc_html__('Thanks for your vote! New average rating is:', 'trueman'),
			'reviews_error'		=> esc_html__('Error saving your vote! Please, try again later.', 'trueman'),
			'error_like'		=> esc_html__('Error saving your like! Please, try again later.', 'trueman'),
			'error_global'		=> esc_html__('Global error text', 'trueman'),
			'name_empty'		=> esc_html__('The name can\'t be empty', 'trueman'),
			'name_long'			=> esc_html__('Too long name', 'trueman'),
			'email_empty'		=> esc_html__('Too short (or empty) email address', 'trueman'),
			'email_long'		=> esc_html__('Too long email address', 'trueman'),
			'email_not_valid'	=> esc_html__('Invalid email address', 'trueman'),
			'subject_empty'		=> esc_html__('The subject can\'t be empty', 'trueman'),
			'subject_long'		=> esc_html__('Too long subject', 'trueman'),
			'text_empty'		=> esc_html__('The message text can\'t be empty', 'trueman'),
			'text_long'			=> esc_html__('Too long message text', 'trueman'),
			'send_complete'		=> esc_html__("Send message complete!", 'trueman'),
			'send_error'		=> esc_html__('Transmit failed!', 'trueman'),
			'login_empty'		=> esc_html__('The Login field can\'t be empty', 'trueman'),
			'login_long'		=> esc_html__('Too long login field', 'trueman'),
			'login_success'		=> esc_html__('Login success! The page will be reloaded in 3 sec.', 'trueman'),
			'login_failed'		=> esc_html__('Login failed!', 'trueman'),
			'password_empty'	=> esc_html__('The password can\'t be empty and shorter then 4 characters', 'trueman'),
			'password_long'		=> esc_html__('Too long password', 'trueman'),
			'password_not_equal'	=> esc_html__('The passwords in both fields are not equal', 'trueman'),
			'registration_success'	=> esc_html__('Registration success! Please log in!', 'trueman'),
			'registration_failed'	=> esc_html__('Registration failed!', 'trueman'),
			'geocode_error'			=> esc_html__('Geocode was not successful for the following reason:', 'trueman'),
			'googlemap_not_avail'	=> esc_html__('Google map API not available!', 'trueman'),
			'editor_save_success'	=> esc_html__("Post content saved!", 'trueman'),
			'editor_save_error'		=> esc_html__("Error saving post data!", 'trueman'),
			'editor_delete_post'	=> esc_html__("You really want to delete the current post?", 'trueman'),
			'editor_delete_post_header'	=> esc_html__("Delete post", 'trueman'),
			'editor_delete_success'	=> esc_html__("Post deleted!", 'trueman'),
			'editor_delete_error'	=> esc_html__("Error deleting post!", 'trueman'),
			'editor_caption_cancel'	=> esc_html__('Cancel', 'trueman'),
			'editor_caption_close'	=> esc_html__('Close', 'trueman')
			);
		return $vars;
	}
}
?>