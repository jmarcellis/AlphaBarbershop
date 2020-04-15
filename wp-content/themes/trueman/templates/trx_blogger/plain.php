<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'trueman_template_plain_theme_setup' ) ) {
	add_action( 'trueman_action_before_init_theme', 'trueman_template_plain_theme_setup', 1 );
	function trueman_template_plain_theme_setup() {
		trueman_add_template(array(
			'layout' => 'plain',
			'template' => 'plain',
			'need_terms' => true,
			'mode'   => 'blogger',
			'title'  => esc_html__('Blogger layout: Plain', 'trueman')
			));
	}
}

// Template output
if ( !function_exists( 'trueman_template_plain_output' ) ) {
	function trueman_template_plain_output($post_options, $post_data) {
		?>
		<div class="post_item sc_blogger_item sc_plain_item<?php if ($post_options['number'] == $post_options['posts_on_page'] && !trueman_param_is_on($post_options['loadmore'])) echo ' sc_blogger_item_last'; ?>">
			
			<?php
			if (!empty($post_data['post_terms'][$post_data['post_taxonomy']]->terms_links)) {
				?>
				<div class="post_category">
					<span class="post_category_label"><?php esc_html_e('in', 'trueman'); ?></span> <?php echo join(', ', $post_data['post_terms'][$post_data['post_taxonomy']]->terms_links); ?>
				</div>
				<?php
			}

			if (!isset($post_options['links']) || $post_options['links']) { 
				?><h4 class="post_title"><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php trueman_show_layout($post_data['post_title']); ?></a></h4><?php
			} else {
				?><h4 class="post_title"><?php trueman_show_layout($post_data['post_title']); ?></h4><?php
			}
			
			if (!$post_data['post_protected'] && $post_options['info']) {
				$post_options['info_parts'] = array('counters'=>true, 'terms'=>false, 'author' => false);
				trueman_template_set_args('post-info', array(
					'post_options' => $post_options,
					'post_data' => $post_data
				));
				get_template_part(trueman_get_file_slug('templates/_parts/post-info.php'));
			}
			?>

		</div>		<!-- /.post_item -->

		<?php
	}
}
?>