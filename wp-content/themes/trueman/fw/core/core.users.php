<?php
/**
 * Trueman Framework: Registered Users
 *
 * @package	trueman
 * @since	trueman 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('trueman_users_theme_setup')) {
	add_action( 'trueman_action_before_init_theme', 'trueman_users_theme_setup' );
	function trueman_users_theme_setup() {
        add_filter( 'trx_utils_filter_social_login', 'trueman_social_login');

		if ( is_admin() ) {
			// Add extra fields in the user profile
			add_action( 'show_user_profile',		'trueman_add_fields_in_user_profile' );
			add_action( 'edit_user_profile',		'trueman_add_fields_in_user_profile' );
	
			// Save / update additional fields from profile
			add_action( 'personal_options_update',	'trueman_save_fields_in_user_profile' );
			add_action( 'edit_user_profile_update',	'trueman_save_fields_in_user_profile' );
		}

	}
}

// Return Social Login layout (if present)
if (!function_exists('trueman_social_login')) {
    function trueman_social_login($sc) {
        return trueman_get_theme_option('social_login');
    }
}

// Return (and show) user profiles links
if (!function_exists('trueman_show_user_socials')) {
	function trueman_show_user_socials($args) {
		$args = array_merge(array(
			'author_id' => 0,										// author's ID
			'allowed' => array(),									// list of allowed social
			'size' => 'small',										// icons size: tiny|small|big
			'shape' => 'square',									// icons shape: square|round
			'style' => trueman_get_theme_setting('socials_type')=='images' ? 'bg' : 'icons',	// style for show icons: icons|images|bg
			'echo' => true											// if true - show on page, else - only return as string
			), is_array($args) ? $args 
				: array('author_id' => $args));						// If send one number parameter - use it as author's ID
		$output = '';
		$upload_info = wp_upload_dir();
		$upload_url = $upload_info['baseurl'];
		$social_list = trueman_get_theme_option('social_icons');
		$list = array();
		if (is_array($social_list) && count($social_list) > 0) {
			foreach ($social_list as $soc) {
				if ($args['style'] == 'icons') {
					$parts = explode('-', $soc['icon'], 2);
					$sn = isset($parts[1]) ? $parts[1] : $soc['icon'];
				} else {
					$sn = basename($soc['icon']);
					$sn = trueman_substr($sn, 0, trueman_strrpos($sn, '.'));
					if (($pos=trueman_strrpos($sn, '_'))!==false)
						$sn = trueman_substr($sn, 0, $pos);
				}
				if (count($args['allowed'])==0 || in_array($sn, $args['allowed'])) {
					$link = get_the_author_meta('user_' . ($sn), $args['author_id']);
					if ($link) {
						$icon = $args['style']=='icons' || trueman_strpos($soc['icon'], $upload_url)!==false ? $soc['icon'] : trueman_get_socials_url(basename($soc['icon']));
						$list[] = array(
							'icon'	=> $icon,
							'url'	=> $link
						);
					}
				}
			}
		}
		if (count($list) > 0) {
			$output = '<div class="sc_socials sc_socials_size_'.esc_attr($args['size']).' sc_socials_shape_'.esc_attr($args['shape']).' sc_socials_type_' . esc_attr($args['style']) . '">' 
							. trim(trueman_prepare_socials($list, $args['style'])) 
						. '</div>';
			if ($args['echo']) trueman_show_layout($output);
		}
		return $output;
	}
}

// Show additional fields in the user profile
if (!function_exists('trueman_add_fields_in_user_profile')) {
	function trueman_add_fields_in_user_profile( $user ) { 
	?>
		<h3><?php esc_html_e('User Position', 'trueman'); ?></h3>
		<table class="form-table">
			<tr>
				<th><label for="user_position"><?php esc_html_e('User position', 'trueman'); ?>:</label></th>
				<td><input type="text" name="user_position" id="user_position" size="55" value="<?php echo esc_attr(get_the_author_meta('user_position', $user->ID)); ?>" />
					<span class="description"><?php esc_html_e('Please, enter your position in the company', 'trueman'); ?></span>
				</td>
			</tr>
		</table>
	
		<h3><?php esc_html_e('Social links', 'trueman'); ?></h3>
		<table class="form-table">
		<?php
		$socials_type = trueman_get_theme_setting('socials_type');
		$social_list = trueman_get_theme_option('social_icons');
		if (is_array($social_list) && count($social_list) > 0) {
			foreach ($social_list as $soc) {
				if ($socials_type == 'icons') {
					$parts = explode('-', $soc['icon'], 2);
					$sn = isset($parts[1]) ? $parts[1] : $soc['icon'];
				} else {
					$sn = basename($soc['icon']);
					$sn = trueman_substr($sn, 0, trueman_strrpos($sn, '.'));
					if (($pos=trueman_strrpos($sn, '_'))!==false)
						$sn = trueman_substr($sn, 0, $pos);
				}
				if (!empty($sn)) {
					?>
					<tr>
						<th><label for="user_<?php echo esc_attr($sn); ?>"><?php trueman_show_layout(trueman_strtoproper($sn)); ?>:</label></th>
						<td><input type="text" name="user_<?php echo esc_attr($sn); ?>" id="user_<?php echo esc_attr($sn); ?>" size="55" value="<?php echo esc_attr(get_the_author_meta('user_'.($sn), $user->ID)); ?>" />
							<span class="description"><?php echo sprintf(esc_html__('Please, enter your %s link', 'trueman'), trueman_strtoproper($sn)); ?></span>
						</td>
					</tr>
					<?php
				}
			}
		}
		?>
		</table>
	<?php
	}
}

// Save / update additional fields
if (!function_exists('trueman_save_fields_in_user_profile')) {
	function trueman_save_fields_in_user_profile( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;

		if (isset($_POST['user_position'])) 
			update_user_meta( $user_id, 'user_position', $_POST['user_position'] );
		
		$socials_type = trueman_get_theme_setting('socials_type');
		$social_list = trueman_get_theme_option('social_icons');
		if (is_array($social_list) && count($social_list) > 0) {
			foreach ($social_list as $soc) {
				if ($socials_type == 'icons') {
					$parts = explode('-', $soc['icon'], 2);
					$sn = isset($parts[1]) ? $parts[1] : $soc['icon'];
				} else {
					$sn = basename($soc['icon']);
					$sn = trueman_substr($sn, 0, trueman_strrpos($sn, '.'));
					if (($pos=trueman_strrpos($sn, '_'))!==false)
						$sn = trueman_substr($sn, 0, $pos);
				}
				if (isset($_POST['user_'.($sn)]))
					update_user_meta( $user_id, 'user_'.($sn), $_POST['user_'.($sn)] );
			}
		}
	}
}
?>