<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'trueman_template_accordion_theme_setup' ) ) {
	add_action( 'trueman_action_before_init_theme', 'trueman_template_accordion_theme_setup', 1 );
	function trueman_template_accordion_theme_setup() {
		trueman_add_template(array(
			'layout' => 'accordion',
			'template' => 'accordion',
			'container_classes' => 'sc_accordion',
			'mode'   => 'blogger',
			'title'  => esc_html__('Blogger layout: Accordion', 'trueman')
			));
		// Add template specific scripts
		add_action('trueman_action_blog_scripts', 'trueman_template_accordion_add_scripts');
	}
}

// Add template specific scripts
if (!function_exists('trueman_template_accordion_add_scripts')) {
	function trueman_template_accordion_add_scripts($style) {
		if (trueman_substr($style, 0, 9) == 'accordion') {
			wp_enqueue_script('jquery-ui-accordion', false, array('jquery','jquery-ui-core'), null, true);
		}
	}
}

// Template output
if ( !function_exists( 'trueman_template_accordion_output' ) ) {
	function trueman_template_accordion_output($post_options, $post_data) {
		?>
		<div class="post_item sc_blogger_item sc_accordion_item<?php if ($post_options['number'] == $post_options['posts_on_page'] && !trueman_param_is_on($post_options['loadmore'])) echo ' sc_blogger_item_last'; ?>">
			
			<h5 class="post_title sc_title sc_blogger_title sc_accordion_title"><span class="sc_accordion_icon sc_accordion_icon_closed icon-plus"></span><span class="sc_accordion_icon sc_accordion_icon_opened icon-minus"></span><?php trueman_show_layout($post_data['post_title']); ?></h5>
			
			<div class="post_content sc_accordion_content">
				<?php
				if (trueman_param_is_on($post_options['info'])) {
					?>
					<div class="post_info">
						<span class="post_info_item post_info_posted_by"><?php esc_html_e('Posted by', 'trueman'); ?> <a href="<?php echo esc_url($post_data['post_author_url']); ?>" class="post_info_author"><?php echo esc_html($post_data['post_author']); ?></a></span>
						<span class="post_info_item post_info_counters">
							<?php echo 'comments'==$post_options['orderby'] || 'comments'==$post_options['counters'] ? esc_html__('Comments', 'trueman') : esc_html__('Views', 'trueman'); ?>
							<span class="post_info_counters_number"><?php echo 'comments'==$post_options['orderby'] || 'comments'==$post_options['counters'] ? esc_html($post_data['post_comments']) : esc_html($post_data['post_views']); ?></span>
						</span>
					</div>
					<?php
				}
				if ($post_options['descr'] >= 0) {
					?>
					<div class="post_descr">
					<?php
					if (!in_array($post_data['post_format'], array('quote', 'link', 'chat')) && $post_options['descr'] > 0 && trueman_strlen($post_data['post_excerpt']) > $post_options['descr']) {
						$post_data['post_excerpt'] = trueman_strshort($post_data['post_excerpt'], $post_options['descr'], $post_options['readmore'] ? '' : '...');
					}
					trueman_show_layout($post_data['post_excerpt']);
					?>
					</div>
					<?php
				}
				if (empty($post_options['readmore'])) $post_options['readmore'] = esc_html__('READ MORE', 'trueman');
				if (!trueman_param_is_off($post_options['readmore']) && !in_array($post_data['post_format'], array('quote', 'link', 'chat', 'aside', 'status'))) {
					trueman_show_layout(trueman_do_shortcode('[trx_button link="'.esc_url($post_data['post_link']).'"]'.($post_options['readmore']).'[/trx_button]'));
				}
				?>
			
			</div>	<!-- /.post_content -->

		</div>		<!-- /.post_item -->

		<?php
	}
}
?>