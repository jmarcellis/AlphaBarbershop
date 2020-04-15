<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'trueman_template_form_1_theme_setup' ) ) {
	add_action( 'trueman_action_before_init_theme', 'trueman_template_form_1_theme_setup', 1 );
	function trueman_template_form_1_theme_setup() {
		trueman_add_template(array(
			'layout' => 'form_1',
			'mode'   => 'forms',
			'title'  => esc_html__('Contact Form 1', 'trueman')
			));
	}
}

// Template output
if ( !function_exists( 'trueman_template_form_1_output' ) ) {
	function trueman_template_form_1_output($post_options, $post_data) {
		$form_style = trueman_get_theme_option('input_hover');
        static $cnt = 0;
        $cnt++;
        $privacy = trueman_get_privacy_text();
		?>
		<form <?php echo !empty($post_options['id']) ? ' id="'.esc_attr($post_options['id']).'_form"' : ''; ?>
			class="sc_input_hover_<?php echo esc_attr($form_style); ?>"
			data-formtype="<?php echo esc_attr($post_options['layout']); ?>"
			method="post"
			action="<?php echo esc_url($post_options['action'] ? $post_options['action'] : admin_url('admin-ajax.php')); ?>">
			<?php if(function_exists('trueman_sc_form_show_fields')) trueman_sc_form_show_fields($post_options['fields']); ?>
            <div class="sc_form_info">
                <div class="sc_form_item sc_form_field label_over"><input id="sc_form_username" type="text" name="username"<?php if ($form_style=='default') echo ' placeholder="'.esc_attr__('Name', 'trueman').'"'; ?> aria-required="true"><?php
                    if ($form_style!='default') {
                        ?><label class="required" for="sc_form_username"><?php
                        if ($form_style == 'path') {
                            ?><svg class="sc_form_graphic" preserveAspectRatio="none" viewBox="0 0 404 77" height="100%" width="100%"><path d="m0,0l404,0l0,77l-404,0l0,-77z"></svg><?php
                        } else if ($form_style == 'iconed') {
                            ?><i class="sc_form_label_icon icon-user"></i><?php
                        }
                        ?><span class="sc_form_label_content" data-content="<?php esc_html_e('Name', 'trueman'); ?>"><?php esc_html_e('Name', 'trueman'); ?></span><?php
                        ?></label><?php
                    }
                    ?></div>
                <div class="sc_form_item sc_form_field label_over"><input id="sc_form_phone" type="text" name="phone"<?php if ($form_style=='default') echo ' placeholder="'.esc_attr__('Phone', 'trueman').'"'; ?> aria-required="true"><?php
                    if ($form_style!='default') {
                        ?><label class="required" for="sc_form_phone"><?php
                        if ($form_style == 'path') {
                            ?><svg class="sc_form_graphic" preserveAspectRatio="none" viewBox="0 0 404 77" height="100%" width="100%"><path d="m0,0l404,0l0,77l-404,0l0,-77z"></svg><?php
                        } else if ($form_style == 'iconed') {
                            ?><i class="sc_form_label_icon icon-mail-empty"></i><?php
                        }
                        ?><span class="sc_form_label_content" data-content="<?php esc_html_e('Phone', 'trueman'); ?>"><?php esc_html_e('Phone', 'trueman'); ?></span><?php
                        ?></label><?php
                    }
                    ?></div>
            </div>
            <div class="sc_form_item sc_form_message"><textarea id="sc_form_message" name="message"<?php if ($form_style=='default') echo ' placeholder="'.esc_attr__('Message', 'trueman').'"'; ?> aria-required="true"></textarea><?php
                if ($form_style!='default') {
                    ?><label class="required" for="sc_form_message"><?php
                    if ($form_style == 'path') {
                        ?><svg class="sc_form_graphic" preserveAspectRatio="none" viewBox="0 0 404 77" height="100%" width="100%"><path d="m0,0l404,0l0,77l-404,0l0,-77z"></svg><?php
                    } else if ($form_style == 'iconed') {
                        ?><i class="sc_form_label_icon icon-feather"></i><?php
                    }
                    ?><span class="sc_form_label_content" data-content="<?php esc_html_e('Message', 'trueman'); ?>"><?php esc_html_e('Message', 'trueman'); ?></span><?php
                    ?></label><?php
                }
                ?></div>
                <?php
            if (!empty($privacy)) {
            ?><div class="sc_form_field sc_form_field_checkbox"><?php
                ?><input type="checkbox" id="i_agree_privacy_policy_sc_form_<?php echo esc_attr($cnt); ?>" name="i_agree_privacy_policy" class="sc_form_privacy_checkbox" value="1">
                <label for="i_agree_privacy_policy_sc_form_<?php echo esc_attr($cnt); ?>"><?php trueman_show_layout($privacy); ?></label>
            </div><?php
            } ?>
			<div class="sc_form_item sc_form_button"><button class="sc_button_hoverstyle_border" <?php
                if (!empty($privacy)) echo ' disabled="disabled"'
                ?>><?php esc_html_e('Send a Message', 'trueman'); ?></button></div>
			<div class="result sc_infobox"></div>
		</form>
		<?php
	}
}
?>