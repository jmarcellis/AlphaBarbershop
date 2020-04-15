<?php
// Get template args
extract(trueman_template_last_args('single-footer'));

$show_share = trueman_get_custom_option("show_share");
if (!trueman_param_is_off($show_share) && function_exists('trueman_show_share_links')) {
    $rez='';
    $post_id = isset($post_data['post_id']) ? $post_data['post_id'] : '';
    $post_link = isset($post_data['post_link']) ? $post_data['post_link'] : '';
    $post_title = isset($post_data['post_title']) ? $post_data['post_title'] : '';
    $post_descr = isset($post_data['post_excerpt']) ? strip_tags($post_data['post_excerpt']) : '';
    $post_thumb = isset($post_data['post_attachment']) ? $post_data['post_attachment'] : '';
    $rez = trueman_show_share_links(array(
        'post_id'    => $post_id,
        'post_link'  => $post_link,
        'post_title' => $post_title,
        'post_descr' => $post_descr,
        'post_thumb' => $post_thumb,
        'type'		 => 'block',
        'echo'		 => false
    ));
	if ($rez) {
		?>
		<div class="post_info post_info_bottom post_info_share post_info_share_<?php echo esc_attr($show_share); ?>"><?php trueman_show_layout(trim($rez)); ?></div>
		<?php
	}
}
?>