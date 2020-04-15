<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'trueman_template_no_articles_theme_setup' ) ) {
	add_action( 'trueman_action_before_init_theme', 'trueman_template_no_articles_theme_setup', 1 );
	function trueman_template_no_articles_theme_setup() {
		trueman_add_template(array(
			'layout' => 'no-articles',
			'mode'   => 'internal',
			'title'  => esc_html__('No articles found', 'trueman')
		));
	}
}

// Template output
if ( !function_exists( 'trueman_template_no_articles_output' ) ) {
	function trueman_template_no_articles_output($post_options, $post_data) {
		?>
		<article class="post_item">
			<div class="post_content">
				<h2 class="post_title"><?php esc_html_e('No posts found', 'trueman'); ?></h2>
				<p><?php esc_html_e( 'Sorry, but nothing matched your search criteria.', 'trueman' ); ?></p>
				<p><?php echo wp_kses_data( sprintf(__('Go back, or return to <a href="%s">%s</a> home page to choose a new page.', 'trueman'), esc_url(home_url('/')), get_bloginfo()) ); ?>
				<br><?php esc_html_e('Please report any broken links to our team.', 'trueman'); ?></p>
				<?php trueman_show_layout(trueman_sc_search(array('state'=>"fixed"))); ?>
			</div>	<!-- /.post_content -->
		</article>	<!-- /.post_item -->
		<?php
	}
}
?>