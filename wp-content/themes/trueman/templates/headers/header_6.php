<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'trueman_template_header_6_theme_setup' ) ) {
	add_action( 'trueman_action_before_init_theme', 'trueman_template_header_6_theme_setup', 1 );
	function trueman_template_header_6_theme_setup() {
		trueman_add_template(array(
			'layout' => 'header_6',
			'mode'   => 'header',
			'title'  => esc_html__('Header 6', 'trueman'),
			'icon'   => trueman_get_file_url('templates/headers/images/6.jpg')
			));
	}
}

// Template output
if ( !function_exists( 'trueman_template_header_6_output' ) ) {
	function trueman_template_header_6_output($post_options, $post_data) {

		// WP custom header
		$header_css = '';
		if ($post_options['position'] != 'over') {
			$header_image = get_header_image();
			$header_css = $header_image!='' 
				? ' style="background-image: url('.esc_url($header_image).')"' 
				: '';
		}
		?>

		<div class="top_panel_fixed_wrap"></div>

		<header class="top_panel_wrap top_panel_style_6 scheme_<?php echo esc_attr($post_options['scheme']); ?>">
			<div class="top_panel_wrap_inner top_panel_inner_style_6 top_panel_position_<?php echo esc_attr(trueman_get_custom_option('top_panel_position')); ?>">

			<div class="top_panel_middle" <?php trueman_show_layout($header_css); ?>>
				<div class="content_wrap">
					<div class="contact_logo">
						<?php trueman_show_logo(true, true); ?>
					</div>
                    <div class="header_contact_info"><?php
                        // Phone
                        $contact_phone=trim(trueman_get_custom_option('contact_phone'));
                        if (!empty($contact_phone)) {
                            ?><div class="contact_field contact_phone">
                            <span class="contact_label contact_phone"><span class="phone_label"><?php esc_html_e('call us:', 'trueman'); ?></span> <?php trueman_show_layout($contact_phone); ?></span>
                            </div><?php
                        }
                        ?><div class="contact_field right_part"><?php
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
                        <div class="menu_main_wrap clearfix">
                            <nav class="menu_main_nav_area menu_hover_<?php echo esc_attr(trueman_get_theme_option('menu_hover')); ?>">
                                <?php
                                $menu_main = trueman_get_nav_menu('menu_main');
                                if (empty($menu_main)) $menu_main = trueman_get_nav_menu();
                                trueman_show_layout($menu_main);
                                ?>
                            </nav>
                            <?php
                            if (trueman_get_custom_option('show_appointments_button')=='yes' && function_exists('trueman_sc_button')) {
                                ?>
                                <div class="appointment_button_container">
                                    <?php
                                    trueman_show_layout(trueman_sc_button(array('size'=>"small", 'link'=>esc_attr(trueman_get_custom_option('appointments_button_link'))), esc_attr(trueman_get_custom_option('appointments_button_caption'))));
                                    ?>
                                </div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>

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
				 'woo_cart' => true,
				 'search' => false
			)
		);
	}
}
?>