<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'trueman_template_header_2_theme_setup' ) ) {
	add_action( 'trueman_action_before_init_theme', 'trueman_template_header_2_theme_setup', 1 );
	function trueman_template_header_2_theme_setup() {
		trueman_add_template(array(
			'layout' => 'header_2',
			'mode'   => 'header',
			'title'  => esc_html__('Header 2', 'trueman'),
			'icon'   => trueman_get_file_url('templates/headers/images/2.jpg')
			));
	}
}

// Template output
if ( !function_exists( 'trueman_template_header_2_output' ) ) {
	function trueman_template_header_2_output($post_options, $post_data) {

		// WP custom header
		$header_css = '';
        $header_image = trueman_get_custom_option('top_panel_image');
        if (!empty($header_image)) {
            // Uncomment next rows if you want crop image
            //$thumb_sizes = trueman_get_thumb_sizes(array( 'layout' => $post_options['layout'] ));
            //$header_image = trueman_get_resized_image_url($header_image, $thumb_sizes['w'], $thumb_sizes['h'], null, false, false, true);
            $header_css = ' style="background-image: url('.esc_url($header_image).')"';
        }
		?>

		<div class="top_panel_fixed_wrap"></div>

		<header class="top_panel_wrap top_panel_style_2 scheme_<?php echo esc_attr($post_options['scheme']); ?>">
			<div class="top_panel_wrap_inner top_panel_inner_style_2 top_panel_position_<?php echo esc_attr(trueman_get_custom_option('top_panel_position')); ?>" <?php trueman_show_layout($header_css); ?>>
			
			<?php if (trueman_get_custom_option('show_top_panel_top')=='yes') { ?>
				<div class="top_panel_top">
					<div class="content_wrap clearfix">
						<?php
						trueman_template_set_args('top-panel-top', array(
							'top_panel_top_components' => array('contact_info', 'open_hours', 'socials')
						));
						get_template_part(trueman_get_file_slug('templates/headers/_parts/top-panel-top.php'));
						?>
					</div>
				</div>
			<?php } ?>

			<div class="top_panel_middle" >
				<div class="content_wrap">
					<div class="columns_wrap columns_fluid"><?php
						// Phone
						$contact_phone=trim(trueman_get_custom_option('contact_phone'));
						if (!empty($contact_phone)) {
							?><div class="column-1_3 contact_field contact_phone">
								<span class="contact_label contact_phone"><a href="tel:<?php trueman_show_layout($contact_phone); ?>"><span class="phone_label"><?php esc_html_e('call us:', 'trueman'); ?></span> <?php trueman_show_layout($contact_phone); ?></a> </span>
							</div><?php
						}
						?><div class="column-1_3 contact_logo">
							<?php trueman_show_logo(); ?>
						</div><div class="column-1_3 contact_field right_part"><?php
                            if (trueman_get_custom_option('show_appointments_button')=='yes' && function_exists('trueman_sc_button')) {
                                trueman_show_layout(trueman_sc_button(array('size'=>"small", 'link'=>esc_attr(trueman_get_custom_option('appointments_button_link'))), esc_attr(trueman_get_custom_option('appointments_button_caption'))));
                            }
						// Woocommerce Cart
						if (function_exists('trueman_exists_woocommerce') && trueman_exists_woocommerce() && (trueman_is_woocommerce_page() && trueman_get_custom_option('show_cart')=='shop' || trueman_get_custom_option('show_cart')=='always') && !(is_checkout() || is_cart() || defined('WOOCOMMERCE_CHECKOUT') || defined('WOOCOMMERCE_CART'))) {
							?><div class="contact_cart"><?php get_template_part(trueman_get_file_slug('templates/headers/_parts/contact-info-cart.php')); ?></div><?php
						}
						?></div>
                    </div>
				</div>
			</div>

			<div class="top_panel_bottom">
				<div class="content_wrap clearfix">
                    <div class="menu_main_wrap clearfix"><nav class="menu_main_nav_area menu_hover_<?php echo esc_attr(trueman_get_theme_option('menu_hover')); ?>">
                            <?php
                            $menu_main = trueman_get_nav_menu('menu_main');
                            if (empty($menu_main)) $menu_main = trueman_get_nav_menu();
                            trueman_show_layout($menu_main);
                            ?>
                        </nav>
                    </div></div></div>
            <?php

            // Top of page section: page title and breadcrumbs

            $show_title = trueman_get_custom_option('show_page_title')=='yes';
            $show_navi = apply_filters('trueman_filter_show_post_navi', false);
            $show_breadcrumbs = trueman_get_custom_option('show_breadcrumbs')=='yes';
            $top_panel_style = trueman_get_custom_option('top_panel_style');
            $top_panel_position = trueman_get_custom_option('top_panel_position');
            $top_panel_scheme = trueman_get_custom_option('top_panel_scheme');
            if ($show_title || $show_breadcrumbs) {
                ?>
                <div class="top_panel_title top_panel_style_<?php echo esc_attr(str_replace('header_', '', $top_panel_style)); ?> <?php echo (!empty($show_title) ? ' title_present'.  ($show_navi ? ' navi_present' : '') : '') . (!empty($show_breadcrumbs) ? ' breadcrumbs_present' : ''); ?> scheme_<?php echo esc_attr($top_panel_scheme); ?>">
                    <div class="top_panel_title_inner top_panel_inner_style_<?php echo esc_attr(str_replace('header_', '', $top_panel_style)); ?> <?php echo (!empty($show_title) ? ' title_present_inner' : '') . (!empty($show_breadcrumbs) ? ' breadcrumbs_present_inner' : ''); ?>">
                        <div class="content_wrap">
                            <?php
                            if ($show_title) {
                                if ($show_navi) {
                                    ?><div class="post_navi"><?php
                                    previous_post_link( '<span class="post_navi_item post_navi_prev">%link</span>', '%title', true, '', 'product_cat' );
                                    next_post_link( '<span class="post_navi_item post_navi_next">%link</span>', '%title', true, '', 'product_cat' );
                                    ?></div><?php
                                } else {
                                    ?><h1 class="page_title"><?php echo strip_tags(trueman_get_blog_title()); ?></h1><?php
                                }
                            }
                            if ($show_breadcrumbs) {
                                ?><div class="breadcrumbs"><?php if (!is_404()) trueman_show_breadcrumbs(); ?></div><?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

			</div>
		</header>

		<?php
		trueman_storage_set('header_mobile', array(
				 'open_hours' => false,
				 'login' => false,
				 'socials' => false,
				 'bookmarks' => false,
				 'contact_address' => false,
				 'contact_phone_email' => false,
				 'woo_cart' => false,
				 'search' => false
			)
		);
	}
}
?>