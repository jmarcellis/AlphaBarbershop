<?php
/**
 * Attachment page
 */
get_header(); 

while ( have_posts() ) { the_post();

	// Move trueman_set_post_views to the javascript - counter will work under cache system
	if (trueman_get_custom_option('use_ajax_views_counter')=='no') {
		trueman_set_post_views(get_the_ID());
	}

	trueman_show_post_layout(
		array(
			'layout' => 'attachment',
			'sidebar' => !trueman_param_is_off(trueman_get_custom_option('show_sidebar_main'))
		)
	);

}

get_footer();
?>