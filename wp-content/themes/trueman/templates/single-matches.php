<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'trueman_template_single_matches_theme_setup' ) ) {
	add_action( 'trueman_action_before_init_theme', 'trueman_template_single_matches_theme_setup', 1 );
	function trueman_template_single_matches_theme_setup() {
		trueman_add_template(array(
			'layout' => 'single-matches',
			'mode'   => 'matches',
			'need_content' => true,
			'need_terms' => true,
			'title'  => esc_html__('Single matches', 'trueman'),
			'thumb_title'  => esc_html__('Fullwidth image (crop)', 'trueman'),
			'w'		 => 1170,
			'h'		 => 659
		));
	}
}

// Template output
if ( !function_exists( 'trueman_template_single_matches_output' ) ) {
	function trueman_template_single_matches_output($post_options, $post_data) {
		$post_data['post_views']++;
		$avg_author = 0;
		$avg_users  = 0;
		if (!$post_data['post_protected'] && $post_options['reviews'] && trueman_get_custom_option('show_reviews')=='yes') {
			$avg_author = $post_data['post_reviews_author'];
			$avg_users  = $post_data['post_reviews_users'];
		}
		$show_title = trueman_get_custom_option('show_post_title')=='yes' && (trueman_get_custom_option('show_post_title_on_quotes')=='yes' || !in_array($post_data['post_format'], array('aside', 'chat', 'status', 'link', 'quote')));
		$title_tag = trueman_get_custom_option('show_page_title')=='yes' ? 'h3' : 'h1';

		trueman_open_wrapper('<article class="' 
				. join(' ', get_post_class('itemscope'
					. ' post_item post_item_single'
					. ' post_featured_' . esc_attr($post_options['post_class'])
					. ' post_format_' . esc_attr($post_data['post_format'])))
				. '"'
				. ' itemscope itemtype="http://schema.org/'.($avg_author > 0 || $avg_users > 0 ? 'Review' : 'Article')
				. '">');

		if ($show_title && $post_options['location'] == 'center' && trueman_get_custom_option('show_page_title')=='no') {
			?>
			<<?php echo esc_html($title_tag); ?> itemprop="<?php echo (float) $avg_author > 0 || (float) $avg_users > 0 ? 'itemReviewed' : 'headline'; ?>" class="post_title entry-title"><span class="post_icon <?php echo esc_attr($post_data['post_icon']); ?>"></span><?php trueman_show_layout($post_data['post_title']); ?></<?php echo esc_html($title_tag); ?>>
		<?php 
		}

		if (!$post_data['post_protected'] && (
			!empty($post_options['dedicated']) ||
			(trueman_get_custom_option('show_featured_image')=='yes' && $post_data['post_thumb'])	// && $post_data['post_format']!='gallery' && $post_data['post_format']!='image')
		)) {
			?>
			<section class="post_featured">
			<?php
			if (!empty($post_options['dedicated'])) {
				trueman_show_layout($post_options['dedicated']);
			} else {
				trueman_enqueue_popup();
				?>
				<div class="post_thumb" data-image="<?php echo esc_url($post_data['post_attachment']); ?>" data-title="<?php echo esc_attr($post_data['post_title']); ?>">
					<a class="hover_icon hover_icon_view" href="<?php echo esc_url($post_data['post_attachment']); ?>" title="<?php echo esc_attr($post_data['post_title']); ?>"><?php trueman_show_layout($post_data['post_thumb']); ?></a>
				</div>
				<?php 
			}
			?>
			</section>
			<?php
		}
			
		
		trueman_open_wrapper('<section class="post_content'.(!$post_data['post_protected'] && $post_data['post_edit_enable'] ? ' '.esc_attr('post_content_editor_present') : '').'" itemprop="'.($avg_author > 0 || $avg_users > 0 ? 'reviewBody' : 'articleBody').'">');

		if ($show_title && $post_options['location'] != 'center' && trueman_get_custom_option('show_page_title')=='no') {
			?>
			<<?php echo esc_html($title_tag); ?> itemprop="<?php echo (float) $avg_author > 0 || (float) $avg_users > 0 ? 'itemReviewed' : 'headline'; ?>" class="post_title entry-title"><span class="post_icon <?php echo esc_attr($post_data['post_icon']); ?>"></span><?php trueman_show_layout($post_data['post_title']); ?></<?php echo esc_html($title_tag); ?>>
			<?php 
		}

		if (!$post_data['post_protected'] && trueman_get_custom_option('show_post_info')=='yes') {
			$post_options['info_parts'] = array('snippets'=>true);
			trueman_template_set_args('post-info', array(
				'post_options' => $post_options,
				'post_data' => $post_data
			));
			get_template_part(trueman_get_file_slug('templates/_parts/post-info.php'));
		}
		
		trueman_template_set_args('reviews-block', array(
			'post_options' => $post_options,
			'post_data' => $post_data,
			'avg_author' => $avg_author,
			'avg_users' => $avg_users
		));
		get_template_part(trueman_get_file_slug('templates/_parts/reviews-block.php'));
			
		if (!$post_data['post_protected']) {
			$post_options['info_parts'] = array('snippets'=>true);
			trueman_template_set_args('post-info', array(
				'post_options' => $post_options,
				'post_data' => $post_data
			));
			get_template_part(trueman_get_file_slug('templates/trx_matches/_parts/match-info.php'));
		}
		
		// Post content
		if ($post_data['post_protected']) {
            trueman_show_layout($post_data['post_excerpt']);
			echo get_the_password_form(); 
		} else {
			if (!trueman_storage_empty('reviews_markup') && trueman_strpos($post_data['post_content'], trueman_get_reviews_placeholder())===false)
                if(function_exists('trueman_sc_form_show_fields')){
                    $post_data['post_content'] = trueman_sc_reviews(array()) . ($post_data['post_content']);
                } else{
                    $post_data['post_content'] = ''.$post_data['post_content'];
                }
            trueman_show_layout(trueman_gap_wrapper(trueman_reviews_wrapper($post_data['post_content'])));
			wp_link_pages( array( 
				'before' => '<nav class="pagination_single"><span class="pager_pages">' . esc_html__( 'Pages:', 'trueman' ) . '</span>', 
				'after' => '</nav>',
				'link_before' => '<span class="pager_numbers">',
				'link_after' => '</span>'
				)
			); 
			if ( trueman_get_custom_option('show_post_tags') == 'yes' && !empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_links)) {
				?>
				<div class="post_info post_info_bottom">
					<span class="post_info_item post_info_tags"><?php esc_html_e('Tags:', 'trueman'); ?> <?php echo join(', ', $post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_links); ?></span>
				</div>
				<?php 
			}
		} 
		$post_meta = get_post_meta($post_data['post_id'], trueman_storage_get('options_prefix') . '_post_options', true);
		$match_preview =(!empty($post_meta['match_link']) ? $post_meta['match_link'] : '');	
		if(!empty($match_preview)){
		?>
			<div class="match_preview"><a href="<?php echo esc_url($match_preview); ?>"><?php echo esc_html__("Go to the announcement &#8594;", 'trueman'); ?></a></div>
		<?php
		} 
		
		// Prepare args for all rest template parts
		// This parts not pop args from storage!
		trueman_template_set_args('single-footer', array(
			'post_options' => $post_options,
			'post_data' => $post_data
		));

		if (!$post_data['post_protected'] && $post_data['post_edit_enable']) {
			get_template_part(trueman_get_file_slug('templates/_parts/editor-area.php'));
		}
			
		trueman_close_wrapper();	// .post_content
			
		if (!$post_data['post_protected']) {
			get_template_part(trueman_get_file_slug('templates/_parts/author-info.php'));
			get_template_part(trueman_get_file_slug('templates/_parts/share.php'));
		}

		$sidebar_present = !trueman_param_is_off(trueman_get_custom_option('show_sidebar_main'));
		if (!$sidebar_present) trueman_close_wrapper();	// .post_item
		get_template_part(trueman_get_file_slug('templates/_parts/related-posts.php'));
		if ($sidebar_present) trueman_close_wrapper();		// .post_item

		// Show comments
		if ( !$post_data['post_protected'] && (comments_open() || get_comments_number() != 0) ) {
			comments_template();
		}

		// Manually pop args from storage
		// after all single footer templates
		trueman_template_get_args('single-footer');
	}
}
?>