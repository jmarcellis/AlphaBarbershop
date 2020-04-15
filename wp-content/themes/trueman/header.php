<?php
/**
 * The Header for our theme.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php
		// Add class 'scheme_xxx' into <html> because it used as context for the body classes!
		$body_scheme = trueman_get_custom_option('body_scheme');
		if (empty($body_scheme) || trueman_is_inherit_option($body_scheme)) $body_scheme = 'original';
		echo 'scheme_' . esc_attr($body_scheme); 
		?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class();?>>

	<?php do_action( 'before' ); ?>

	<?php if ( !trueman_param_is_off(trueman_get_custom_option('show_sidebar_outer')) ) { ?>
	<div class="outer_wrap">
	<?php } ?>

	<?php get_template_part(trueman_get_file_slug('sidebar_outer.php')); ?>

	<?php
		$body_style  = trueman_get_custom_option('body_style');
		$class = $style = '';
		if (trueman_get_custom_option('bg_custom')=='yes' && ($body_style=='boxed' || trueman_get_custom_option('bg_image_load')=='always')) {
			if (($img = trueman_get_custom_option('bg_image_custom')) != '')
				$style = 'background: url('.esc_url($img).') ' . str_replace('_', ' ', trueman_get_custom_option('bg_image_custom_position')) . ' repeat-y fixed;';
			else if (($img = trueman_get_custom_option('bg_pattern_custom')) != '')
				$style = 'background: url('.esc_url($img).') 0 0 repeat fixed;';
			else if (($img = trueman_get_custom_option('bg_image')) > 0)
				$class = 'bg_image_'.($img);
			else if (($img = trueman_get_custom_option('bg_pattern')) > 0)
				$class = 'bg_pattern_'.($img);
			if (($img = trueman_get_custom_option('bg_color')) != '')
				$style .= 'background-color: '.($img).';';
		}
	?>

	<div class="body_wrap<?php echo !empty($class) ? ' '.esc_attr($class) : ''; ?>"<?php echo !empty($style) ? ' style="'.esc_attr($style).'"' : ''; ?>>

		<?php
		$video_bg_show = trueman_get_custom_option('show_video_bg')=='yes';
		$youtube = trueman_get_custom_option('video_bg_youtube_code');
		$video   = trueman_get_custom_option('video_bg_url');
		$overlay = trueman_get_custom_option('video_bg_overlay')=='yes';
		if ($video_bg_show && (!empty($youtube) || !empty($video))) {
			if (!empty($youtube)) {
				?>
				<div class="video_bg<?php echo !empty($overlay) ? ' video_bg_overlay' : ''; ?>" data-youtube-code="<?php echo esc_attr($youtube); ?>"></div>
				<?php
			} else if (!empty($video)) {
				$info = pathinfo($video);
				$ext = !empty($info['extension']) ? $info['extension'] : 'src';
				?>
				<div class="video_bg<?php echo !empty($overlay) ? ' video_bg_overlay' : ''; ?>"><video class="video_bg_tag" width="1280" height="720" data-width="1280" data-height="720" data-ratio="16:9" preload="metadata" autoplay loop src="<?php echo esc_url($video); ?>"><source src="<?php echo esc_url($video); ?>" type="video/<?php echo esc_attr($ext); ?>"></source></video></div>
				<?php
			}
		}
		?>

		<div class="page_wrap">

			<?php
			$top_panel_style = trueman_get_custom_option('top_panel_style');
			$top_panel_position = trueman_get_custom_option('top_panel_position');
			$top_panel_scheme = trueman_get_custom_option('top_panel_scheme');
			// Top panel 'Above' or 'Over'
			if (in_array($top_panel_position, array('above', 'over'))) {
				trueman_show_post_layout(array(
					'layout' => $top_panel_style,
					'position' => $top_panel_position,
					'scheme' => $top_panel_scheme
					), false);
				// Mobile Menu
				get_template_part(trueman_get_file_slug('templates/headers/_parts/header-mobile.php'));
			}

			// Slider
			get_template_part(trueman_get_file_slug('templates/headers/_parts/slider.php'));
			
			// Top panel 'Below'
			if ($top_panel_position == 'below') {
				trueman_show_post_layout(array(
					'layout' => $top_panel_style,
					'position' => $top_panel_position,
					'scheme' => $top_panel_scheme
					), false);
				// Mobile Menu
				get_template_part(trueman_get_file_slug('templates/headers/_parts/header-mobile.php'));
			}


			?>

			<div class="page_content_wrap page_paddings_<?php echo esc_attr(trueman_get_custom_option('body_paddings')); ?>">

				<?php
				// Content and sidebar wrapper
				if ($body_style!='fullscreen') trueman_open_wrapper('<div class="content_wrap">');
				
				// Main content wrapper
				trueman_open_wrapper('<div class="content">');
				?>