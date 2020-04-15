<?php
/**
 * Single post
 */
get_header(); 

$single_style = trueman_storage_get('single_style');
if (empty($single_style)) $single_style = trueman_get_custom_option('single_style');

while ( have_posts() ) { the_post();
	trueman_show_post_layout(
		array(
			'layout' => $single_style,
			'sidebar' => !trueman_param_is_off(trueman_get_custom_option('show_sidebar_main')),
			'content' => trueman_get_template_property($single_style, 'need_content'),
			'terms_list' => trueman_get_template_property($single_style, 'need_terms')
		)
	);
}

get_footer();
?>