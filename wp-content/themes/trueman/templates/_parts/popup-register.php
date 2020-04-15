<div id="popup_registration" class="popup_wrap popup_registration bg_tint_light">
	<a href="#" class="popup_close"></a>
	<div class="form_wrap">
		<form name="registration_form" method="post" class="popup_form registration_form">
			<input type="hidden" name="redirect_to" value="<?php echo esc_attr(esc_url(home_url('/'))); ?>"/>
			<div class="form_left">
				<div class="popup_form_field login_field iconed_field icon-user"><input type="text" id="registration_username" name="registration_username"  value="" placeholder="<?php esc_attr_e('User name (login)', 'trueman'); ?>"></div>
				<div class="popup_form_field email_field iconed_field icon-mail"><input type="text" id="registration_email" name="registration_email" value="" placeholder="<?php esc_attr_e('E-mail', 'trueman'); ?>"></div>
				<div class="popup_form_field agree_field">
					<input type="checkbox" value="agree" id="registration_agree" name="registration_agree">
					<label for="registration_agree"><?php esc_html_e('I agree with', 'trueman'); ?></label> <a href="#"><?php esc_html_e('Terms &amp; Conditions', 'trueman'); ?></a>
				</div>
                <?php
                $trueman_privacy = trueman_get_privacy_text();
                if (!empty($trueman_privacy)) {
                    ?><div class="popup_form_field agree_field">
                    <input type="checkbox" value="1" id="i_agree_privacy_policy_registration" name="i_agree_privacy_policy"><label for="i_agree_privacy_policy_registration"> <?php echo wp_kses_post($trueman_privacy); ?></label>
                    </div><?php
                }
                ?>
				<div class="popup_form_field submit_field"><input type="submit" class="submit_button" value="<?php esc_attr_e('Sign Up', 'trueman'); ?>"<?php
                    if ( !empty($trueman_privacy) ) {
                        ?> disabled="disabled"<?php
                    }
                    ?>>></div>
			</div>
			<div class="form_right">
				<div class="popup_form_field password_field iconed_field icon-lock"><input type="password" id="registration_pwd"  name="registration_pwd"  value="" placeholder="<?php esc_attr_e('Password', 'trueman'); ?>"></div>
				<div class="popup_form_field password_field iconed_field icon-lock"><input type="password" id="registration_pwd2" name="registration_pwd2" value="" placeholder="<?php esc_attr_e('Confirm Password', 'trueman'); ?>"></div>
				<div class="popup_form_field description_field"><?php esc_html_e('Minimum 6 characters', 'trueman'); ?></div>
			</div>
		</form>
		<div class="result message_block"></div>
	</div>	<!-- /.registration_wrap -->
</div>		<!-- /.user-popUp -->
