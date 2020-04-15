<?php 
if (is_singular()) {
	if (trueman_get_theme_option('use_ajax_views_counter')=='yes') {
		trueman_storage_set_array('js_vars', 'ajax_views_counter', array(
			'post_id' => get_the_ID(),
			'post_views' => trueman_get_post_views(get_the_ID())
		));
	} else
		trueman_set_post_views(get_the_ID());
}
?>