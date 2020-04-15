<?php
/**
 * Trueman Framework: return lists
 *
 * @package trueman
 * @since trueman 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



// Return styles list
if ( !function_exists( 'trueman_get_list_styles' ) ) {
	function trueman_get_list_styles($from=1, $to=2, $prepend_inherit=false) {
		$list = array();
		for ($i=$from; $i<=$to; $i++)
			$list[$i] = sprintf(esc_html__('Style %d', 'trueman'), $i);
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of the shortcodes margins
if ( !function_exists( 'trueman_get_list_margins' ) ) {
	function trueman_get_list_margins($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_margins'))=='') {
			$list = array(
				'null'		=> esc_html__('0 (No margin)',	'trueman'),
				'tiny'		=> esc_html__('Tiny',		'trueman'),
				'small'		=> esc_html__('Small',		'trueman'),
				'medium'	=> esc_html__('Medium',		'trueman'),
				'large'		=> esc_html__('Large',		'trueman'),
				'huge'		=> esc_html__('Huge',		'trueman'),
				'tiny-'		=> esc_html__('Tiny (negative)',	'trueman'),
				'small-'	=> esc_html__('Small (negative)',	'trueman'),
				'medium-'	=> esc_html__('Medium (negative)',	'trueman'),
				'large-'	=> esc_html__('Large (negative)',	'trueman'),
				'huge-'		=> esc_html__('Huge (negative)',	'trueman')
				);
			$list = apply_filters('trueman_filter_list_margins', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_margins', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of the line styles
if ( !function_exists( 'trueman_get_list_line_styles' ) ) {
	function trueman_get_list_line_styles($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_line_styles'))=='') {
			$list = array(
				'solid'	=> esc_html__('Solid', 'trueman'),
				'dashed'=> esc_html__('Dashed', 'trueman'),
				'dotted'=> esc_html__('Dotted', 'trueman'),
				'double'=> esc_html__('Double', 'trueman'),
				'image'	=> esc_html__('Image', 'trueman')
				);
			$list = apply_filters('trueman_filter_list_line_styles', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_line_styles', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of the animations
if ( !function_exists( 'trueman_get_list_animations' ) ) {
	function trueman_get_list_animations($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_animations'))=='') {
			$list = array(
				'none'			=> esc_html__('- None -',	'trueman'),
				'bounce'		=> esc_html__('Bounce',		'trueman'),
				'elastic'		=> esc_html__('Elastic',	'trueman'),
				'flash'			=> esc_html__('Flash',		'trueman'),
				'flip'			=> esc_html__('Flip',		'trueman'),
				'pulse'			=> esc_html__('Pulse',		'trueman'),
				'rubberBand'	=> esc_html__('Rubber Band','trueman'),
				'shake'			=> esc_html__('Shake',		'trueman'),
				'swing'			=> esc_html__('Swing',		'trueman'),
				'tada'			=> esc_html__('Tada',		'trueman'),
				'wobble'		=> esc_html__('Wobble',		'trueman')
				);
			$list = apply_filters('trueman_filter_list_animations', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_animations', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of the enter animations
if ( !function_exists( 'trueman_get_list_animations_in' ) ) {
	function trueman_get_list_animations_in($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_animations_in'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',			'trueman'),
				'bounceIn'			=> esc_html__('Bounce In',			'trueman'),
				'bounceInUp'		=> esc_html__('Bounce In Up',		'trueman'),
				'bounceInDown'		=> esc_html__('Bounce In Down',		'trueman'),
				'bounceInLeft'		=> esc_html__('Bounce In Left',		'trueman'),
				'bounceInRight'		=> esc_html__('Bounce In Right',	'trueman'),
				'elastic'			=> esc_html__('Elastic In',			'trueman'),
				'fadeIn'			=> esc_html__('Fade In',			'trueman'),
				'fadeInUp'			=> esc_html__('Fade In Up',			'trueman'),
				'fadeInUpSmall'		=> esc_html__('Fade In Up Small',	'trueman'),
				'fadeInUpBig'		=> esc_html__('Fade In Up Big',		'trueman'),
				'fadeInDown'		=> esc_html__('Fade In Down',		'trueman'),
				'fadeInDownBig'		=> esc_html__('Fade In Down Big',	'trueman'),
				'fadeInLeft'		=> esc_html__('Fade In Left',		'trueman'),
				'fadeInLeftBig'		=> esc_html__('Fade In Left Big',	'trueman'),
				'fadeInRight'		=> esc_html__('Fade In Right',		'trueman'),
				'fadeInRightBig'	=> esc_html__('Fade In Right Big',	'trueman'),
				'flipInX'			=> esc_html__('Flip In X',			'trueman'),
				'flipInY'			=> esc_html__('Flip In Y',			'trueman'),
				'lightSpeedIn'		=> esc_html__('Light Speed In',		'trueman'),
				'rotateIn'			=> esc_html__('Rotate In',			'trueman'),
				'rotateInUpLeft'	=> esc_html__('Rotate In Down Left','trueman'),
				'rotateInUpRight'	=> esc_html__('Rotate In Up Right',	'trueman'),
				'rotateInDownLeft'	=> esc_html__('Rotate In Up Left',	'trueman'),
				'rotateInDownRight'	=> esc_html__('Rotate In Down Right','trueman'),
				'rollIn'			=> esc_html__('Roll In',			'trueman'),
				'slideInUp'			=> esc_html__('Slide In Up',		'trueman'),
				'slideInDown'		=> esc_html__('Slide In Down',		'trueman'),
				'slideInLeft'		=> esc_html__('Slide In Left',		'trueman'),
				'slideInRight'		=> esc_html__('Slide In Right',		'trueman'),
				'wipeInLeftTop'		=> esc_html__('Wipe In Left Top',	'trueman'),
				'zoomIn'			=> esc_html__('Zoom In',			'trueman'),
				'zoomInUp'			=> esc_html__('Zoom In Up',			'trueman'),
				'zoomInDown'		=> esc_html__('Zoom In Down',		'trueman'),
				'zoomInLeft'		=> esc_html__('Zoom In Left',		'trueman'),
				'zoomInRight'		=> esc_html__('Zoom In Right',		'trueman')
				);
			$list = apply_filters('trueman_filter_list_animations_in', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_animations_in', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of the out animations
if ( !function_exists( 'trueman_get_list_animations_out' ) ) {
	function trueman_get_list_animations_out($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_animations_out'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',			'trueman'),
				'bounceOut'			=> esc_html__('Bounce Out',			'trueman'),
				'bounceOutUp'		=> esc_html__('Bounce Out Up',		'trueman'),
				'bounceOutDown'		=> esc_html__('Bounce Out Down',	'trueman'),
				'bounceOutLeft'		=> esc_html__('Bounce Out Left',	'trueman'),
				'bounceOutRight'	=> esc_html__('Bounce Out Right',	'trueman'),
				'fadeOut'			=> esc_html__('Fade Out',			'trueman'),
				'fadeOutUp'			=> esc_html__('Fade Out Up',		'trueman'),
				'fadeOutUpBig'		=> esc_html__('Fade Out Up Big',	'trueman'),
				'fadeOutDown'		=> esc_html__('Fade Out Down',		'trueman'),
				'fadeOutDownSmall'	=> esc_html__('Fade Out Down Small','trueman'),
				'fadeOutDownBig'	=> esc_html__('Fade Out Down Big',	'trueman'),
				'fadeOutLeft'		=> esc_html__('Fade Out Left',		'trueman'),
				'fadeOutLeftBig'	=> esc_html__('Fade Out Left Big',	'trueman'),
				'fadeOutRight'		=> esc_html__('Fade Out Right',		'trueman'),
				'fadeOutRightBig'	=> esc_html__('Fade Out Right Big',	'trueman'),
				'flipOutX'			=> esc_html__('Flip Out X',			'trueman'),
				'flipOutY'			=> esc_html__('Flip Out Y',			'trueman'),
				'hinge'				=> esc_html__('Hinge Out',			'trueman'),
				'lightSpeedOut'		=> esc_html__('Light Speed Out',	'trueman'),
				'rotateOut'			=> esc_html__('Rotate Out',			'trueman'),
				'rotateOutUpLeft'	=> esc_html__('Rotate Out Down Left','trueman'),
				'rotateOutUpRight'	=> esc_html__('Rotate Out Up Right','trueman'),
				'rotateOutDownLeft'	=> esc_html__('Rotate Out Up Left',	'trueman'),
				'rotateOutDownRight'=> esc_html__('Rotate Out Down Right','trueman'),
				'rollOut'			=> esc_html__('Roll Out',			'trueman'),
				'slideOutUp'		=> esc_html__('Slide Out Up',		'trueman'),
				'slideOutDown'		=> esc_html__('Slide Out Down',		'trueman'),
				'slideOutLeft'		=> esc_html__('Slide Out Left',		'trueman'),
				'slideOutRight'		=> esc_html__('Slide Out Right',	'trueman'),
				'zoomOut'			=> esc_html__('Zoom Out',			'trueman'),
				'zoomOutUp'			=> esc_html__('Zoom Out Up',		'trueman'),
				'zoomOutDown'		=> esc_html__('Zoom Out Down',		'trueman'),
				'zoomOutLeft'		=> esc_html__('Zoom Out Left',		'trueman'),
				'zoomOutRight'		=> esc_html__('Zoom Out Right',		'trueman')
				);
			$list = apply_filters('trueman_filter_list_animations_out', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_animations_out', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return classes list for the specified animation
if (!function_exists('trueman_get_animation_classes')) {
	function trueman_get_animation_classes($animation, $speed='normal', $loop='none') {
		// speed:	fast=0.5s | normal=1s | slow=2s
		// loop:	none | infinite
		return trueman_param_is_off($animation) ? '' : 'animated '.esc_attr($animation).' '.esc_attr($speed).(!trueman_param_is_off($loop) ? ' '.esc_attr($loop) : '');
	}
}


// Return list of the main menu hover effects
if ( !function_exists( 'trueman_get_list_menu_hovers' ) ) {
	function trueman_get_list_menu_hovers($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_menu_hovers'))=='') {
			$list = array(
				'fade'			=> esc_html__('Fade',		'trueman'),
				'slide_line'	=> esc_html__('Slide Line',	'trueman'),
				'slide_box'		=> esc_html__('Slide Box',	'trueman'),
				'zoom_line'		=> esc_html__('Zoom Line',	'trueman'),
				'path_line'		=> esc_html__('Path Line',	'trueman'),
				'roll_down'		=> esc_html__('Roll Down',	'trueman'),
				'color_line'	=> esc_html__('Color Line',	'trueman'),
				);
			$list = apply_filters('trueman_filter_list_menu_hovers', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_menu_hovers', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of the button's hover effects
if ( !function_exists( 'trueman_get_list_button_hovers' ) ) {
	function trueman_get_list_button_hovers($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_button_hovers'))=='') {
			$list = array(
				'fade'			=> esc_html__('Fade',				'trueman'),
				'slide_left'	=> esc_html__('Slide from Left',	'trueman'),
				'slide_top'		=> esc_html__('Slide from Top',		'trueman'),
				'arrow'			=> esc_html__('Arrow',				'trueman'),
				);
			$list = apply_filters('trueman_filter_list_button_hovers', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_button_hovers', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of the input field's hover effects
if ( !function_exists( 'trueman_get_list_input_hovers' ) ) {
	function trueman_get_list_input_hovers($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_input_hovers'))=='') {
			$list = array(
				'default'	=> esc_html__('Default',	'trueman'),
				'accent'	=> esc_html__('Accented',	'trueman'),
				'path'		=> esc_html__('Path',		'trueman'),
				'jump'		=> esc_html__('Jump',		'trueman'),
				'underline'	=> esc_html__('Underline',	'trueman'),
				'iconed'	=> esc_html__('Iconed',		'trueman'),
				);
			$list = apply_filters('trueman_filter_list_input_hovers', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_input_hovers', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of the search field's styles
if ( !function_exists( 'trueman_get_list_search_styles' ) ) {
	function trueman_get_list_search_styles($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_search_styles'))=='') {
			$list = array(
				'default'	=> esc_html__('Default',	'trueman'),
				'fullscreen'=> esc_html__('Fullscreen',	'trueman'),
				'slide'		=> esc_html__('Slide',		'trueman'),
				'expand'	=> esc_html__('Expand',		'trueman'),
				);
			$list = apply_filters('trueman_filter_list_search_styles', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_search_styles', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of categories
if ( !function_exists( 'trueman_get_list_categories' ) ) {
	function trueman_get_list_categories($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_categories'))=='') {
			$list = array();
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false );
			$taxonomies = get_categories( $args );
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_categories', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'trueman_get_list_terms' ) ) {
	function trueman_get_list_terms($prepend_inherit=false, $taxonomy='category') {
		if (($list = trueman_storage_get('list_taxonomies_'.($taxonomy)))=='') {
			$list = array();
			if ( is_array($taxonomy) || taxonomy_exists($taxonomy) ) {
				$terms = get_terms( $taxonomy, array(
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 0,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => $taxonomy,
					'pad_counts'               => false
					)
				);
			} else {
				$terms = trueman_get_terms_by_taxonomy_from_db($taxonomy);
			}
			if (!is_wp_error( $terms ) && is_array($terms) && count($terms) > 0) {
				foreach ($terms as $cat) {
					$list[$cat->term_id] = $cat->name;	// . ($taxonomy!='category' ? ' /'.($cat->taxonomy).'/' : '');
				}
			}
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_taxonomies_'.($taxonomy), $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list of post's types
if ( !function_exists( 'trueman_get_list_posts_types' ) ) {
	function trueman_get_list_posts_types($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_posts_types'))=='') {
			// Return only theme inheritance supported post types
			$list = apply_filters('trueman_filter_list_post_types', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_posts_types', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'trueman_get_list_posts' ) ) {
	function trueman_get_list_posts($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		$hash = 'list_posts_'.($opt['post_type']).'_'.($opt['taxonomy']).'_'.($opt['taxonomy_value']).'_'.($opt['orderby']).'_'.($opt['order']).'_'.($opt['return']).'_'.($opt['posts_per_page']);
		if (($list = trueman_storage_get($hash))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'trueman');
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => (int) $opt['taxonomy_value'] > 0 ? 'id' : 'slug',
						'terms' => $opt['taxonomy_value']
					)
				);
			}
			$posts = get_posts( $args );
			if (is_array($posts) && count($posts) > 0) {
				foreach ($posts as $post) {
					$list[$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
				}
			}
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set($hash, $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list pages
if ( !function_exists( 'trueman_get_list_pages' ) ) {
	function trueman_get_list_pages($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'page',
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1,
			'orderby'			=> 'title',
			'order'				=> 'asc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));
		return trueman_get_list_posts($prepend_inherit, $opt);
	}
}


// Return list of registered users
if ( !function_exists( 'trueman_get_list_users' ) ) {
	function trueman_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		if (($list = trueman_storage_get('list_users'))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'trueman');
			$args = array(
				'orderby'	=> 'display_name',
				'order'		=> 'ASC' );
			$users = get_users( $args );
			if (is_array($users) && count($users) > 0) {
				foreach ($users as $user) {
					$accept = true;
					if (is_array($user->roles)) {
						if (is_array($user->roles) && count($user->roles) > 0) {
							$accept = false;
							foreach ($user->roles as $role) {
								if (in_array($role, $roles)) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ($accept) $list[$user->user_login] = $user->display_name;
				}
			}
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_users', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return slider engines list, prepended inherit (if need)
if ( !function_exists( 'trueman_get_list_sliders' ) ) {
	function trueman_get_list_sliders($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_sliders'))=='') {
			$list = array(
				'swiper' => esc_html__("Posts slider (Swiper)", 'trueman')
			);
			$list = apply_filters('trueman_filter_list_sliders', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_sliders', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return slider controls list, prepended inherit (if need)
if ( !function_exists( 'trueman_get_list_slider_controls' ) ) {
	function trueman_get_list_slider_controls($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_slider_controls'))=='') {
			$list = array(
				'no'		=> esc_html__('None', 'trueman'),
				'side'		=> esc_html__('Side', 'trueman'),
				'bottom'	=> esc_html__('Bottom', 'trueman'),
				'pagination'=> esc_html__('Pagination', 'trueman')
				);
			$list = apply_filters('trueman_filter_list_slider_controls', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_slider_controls', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return slider controls classes
if ( !function_exists( 'trueman_get_slider_controls_classes' ) ) {
	function trueman_get_slider_controls_classes($controls) {
		if (trueman_param_is_off($controls))	$classes = 'sc_slider_nopagination sc_slider_nocontrols';
		else if ($controls=='bottom')			$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_bottom';
		else if ($controls=='pagination')		$classes = 'sc_slider_pagination sc_slider_pagination_bottom sc_slider_nocontrols';
		else									$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_side';
		return $classes;
	}
}

// Return list with popup engines
if ( !function_exists( 'trueman_get_list_popup_engines' ) ) {
	function trueman_get_list_popup_engines($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_popup_engines'))=='') {
			$list = array(
				"pretty"	=> esc_html__("Pretty photo", 'trueman'),
				"magnific"	=> esc_html__("Magnific popup", 'trueman')
				);
			$list = apply_filters('trueman_filter_list_popup_engines', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_popup_engines', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'trueman_get_list_menus' ) ) {
	function trueman_get_list_menus($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_menus'))=='') {
			$list = array();
			$list['default'] = esc_html__("Default", 'trueman');
			$menus = wp_get_nav_menus();
			if (is_array($menus) && count($menus) > 0) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_menus', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'trueman_get_list_sidebars' ) ) {
	function trueman_get_list_sidebars($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_sidebars'))=='') {
			if (($list = trueman_storage_get('registered_sidebars'))=='') $list = array();
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_sidebars', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return sidebars positions
if ( !function_exists( 'trueman_get_list_sidebars_positions' ) ) {
	function trueman_get_list_sidebars_positions($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_sidebars_positions'))=='') {
			$list = array(
				'none'  => esc_html__('Hide',  'trueman'),
				'left'  => esc_html__('Left',  'trueman'),
				'right' => esc_html__('Right', 'trueman')
				);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_sidebars_positions', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return sidebars class
if ( !function_exists( 'trueman_get_sidebar_class' ) ) {
	function trueman_get_sidebar_class() {
		$sb_main = trueman_get_custom_option('show_sidebar_main');
		$sb_outer = trueman_get_custom_option('show_sidebar_outer');
		return (trueman_param_is_off($sb_main) ? 'sidebar_hide' : 'sidebar_show sidebar_'.($sb_main))
				. ' ' . (trueman_param_is_off($sb_outer) ? 'sidebar_outer_hide' : 'sidebar_outer_show sidebar_outer_'.($sb_outer));
	}
}

// Return body styles list, prepended inherit
if ( !function_exists( 'trueman_get_list_body_styles' ) ) {
	function trueman_get_list_body_styles($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_body_styles'))=='') {
			$list = array(
				'boxed'	=> esc_html__('Boxed',		'trueman'),
				'wide'	=> esc_html__('Wide',		'trueman')
				);
			if (trueman_get_theme_setting('allow_fullscreen')) {
				$list['fullwide']	= esc_html__('Fullwide',	'trueman');
				$list['fullscreen']	= esc_html__('Fullscreen',	'trueman');
			}
			$list = apply_filters('trueman_filter_list_body_styles', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_body_styles', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return css-themes list
if ( !function_exists( 'trueman_get_list_themes' ) ) {
	function trueman_get_list_themes($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_themes'))=='') {
			$list = trueman_get_list_files("css/themes");
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_themes', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return templates list, prepended inherit
if ( !function_exists( 'trueman_get_list_templates' ) ) {
	function trueman_get_list_templates($mode='') {
		if (($list = trueman_storage_get('list_templates_'.($mode)))=='') {
			$list = array();
			$tpl = trueman_storage_get('registered_templates');
			if (is_array($tpl) && count($tpl) > 0) {
				foreach ($tpl as $k=>$v) {
					if ($mode=='' || in_array($mode, explode(',', $v['mode'])))
						$list[$k] = !empty($v['icon']) 
									? $v['icon'] 
									: (!empty($v['title']) 
										? $v['title'] 
										: trueman_strtoproper($v['layout'])
										);
				}
			}
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_templates_'.($mode), $list);
		}
		return $list;
	}
}

// Return blog styles list, prepended inherit
if ( !function_exists( 'trueman_get_list_templates_blog' ) ) {
	function trueman_get_list_templates_blog($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_templates_blog'))=='') {
			$list = trueman_get_list_templates('blog');
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_templates_blog', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return blogger styles list, prepended inherit
if ( !function_exists( 'trueman_get_list_templates_blogger' ) ) {
	function trueman_get_list_templates_blogger($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_templates_blogger'))=='') {
			$list = trueman_array_merge(trueman_get_list_templates('blogger'), trueman_get_list_templates('blog'));
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_templates_blogger', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return single page styles list, prepended inherit
if ( !function_exists( 'trueman_get_list_templates_single' ) ) {
	function trueman_get_list_templates_single($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_templates_single'))=='') {
			$list = trueman_get_list_templates('single');
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_templates_single', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return header styles list, prepended inherit
if ( !function_exists( 'trueman_get_list_templates_header' ) ) {
	function trueman_get_list_templates_header($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_templates_header'))=='') {
			$list = trueman_get_list_templates('header');
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_templates_header', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return form styles list, prepended inherit
if ( !function_exists( 'trueman_get_list_templates_forms' ) ) {
	function trueman_get_list_templates_forms($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_templates_forms'))=='') {
			$list = trueman_get_list_templates('forms');
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_templates_forms', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return article styles list, prepended inherit
if ( !function_exists( 'trueman_get_list_article_styles' ) ) {
	function trueman_get_list_article_styles($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_article_styles'))=='') {
			$list = array(
				"boxed"   => esc_html__('Boxed', 'trueman'),
				"stretch" => esc_html__('Stretch', 'trueman')
				);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_article_styles', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return post-formats filters list, prepended inherit
if ( !function_exists( 'trueman_get_list_post_formats_filters' ) ) {
	function trueman_get_list_post_formats_filters($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_post_formats_filters'))=='') {
			$list = array(
				"no"      => esc_html__('All posts', 'trueman'),
				"thumbs"  => esc_html__('With thumbs', 'trueman'),
				"reviews" => esc_html__('With reviews', 'trueman'),
				"video"   => esc_html__('With videos', 'trueman'),
				"audio"   => esc_html__('With audios', 'trueman'),
				"gallery" => esc_html__('With galleries', 'trueman')
				);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_post_formats_filters', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return portfolio filters list, prepended inherit
if ( !function_exists( 'trueman_get_list_portfolio_filters' ) ) {
	function trueman_get_list_portfolio_filters($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_portfolio_filters'))=='') {
			$list = array(
				"hide"		=> esc_html__('Hide', 'trueman'),
				"tags"		=> esc_html__('Tags', 'trueman'),
				"categories"=> esc_html__('Categories', 'trueman')
				);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_portfolio_filters', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return hover styles list, prepended inherit
if ( !function_exists( 'trueman_get_list_hovers' ) ) {
	function trueman_get_list_hovers($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_hovers'))=='') {
			$list = array();
			$list['circle effect1']  = esc_html__('Circle Effect 1',  'trueman');
			$list['circle effect2']  = esc_html__('Circle Effect 2',  'trueman');
			$list['circle effect3']  = esc_html__('Circle Effect 3',  'trueman');
			$list['circle effect4']  = esc_html__('Circle Effect 4',  'trueman');
			$list['circle effect5']  = esc_html__('Circle Effect 5',  'trueman');
			$list['circle effect6']  = esc_html__('Circle Effect 6',  'trueman');
			$list['circle effect7']  = esc_html__('Circle Effect 7',  'trueman');
			$list['circle effect8']  = esc_html__('Circle Effect 8',  'trueman');
			$list['circle effect9']  = esc_html__('Circle Effect 9',  'trueman');
			$list['circle effect10'] = esc_html__('Circle Effect 10',  'trueman');
			$list['circle effect11'] = esc_html__('Circle Effect 11',  'trueman');
			$list['circle effect12'] = esc_html__('Circle Effect 12',  'trueman');
			$list['circle effect13'] = esc_html__('Circle Effect 13',  'trueman');
			$list['circle effect14'] = esc_html__('Circle Effect 14',  'trueman');
			$list['circle effect15'] = esc_html__('Circle Effect 15',  'trueman');
			$list['circle effect16'] = esc_html__('Circle Effect 16',  'trueman');
			$list['circle effect17'] = esc_html__('Circle Effect 17',  'trueman');
			$list['circle effect18'] = esc_html__('Circle Effect 18',  'trueman');
			$list['circle effect19'] = esc_html__('Circle Effect 19',  'trueman');
			$list['circle effect20'] = esc_html__('Circle Effect 20',  'trueman');
			$list['square effect1']  = esc_html__('Square Effect 1',  'trueman');
			$list['square effect2']  = esc_html__('Square Effect 2',  'trueman');
			$list['square effect3']  = esc_html__('Square Effect 3',  'trueman');
			$list['square effect5']  = esc_html__('Square Effect 5',  'trueman');
			$list['square effect6']  = esc_html__('Square Effect 6',  'trueman');
			$list['square effect7']  = esc_html__('Square Effect 7',  'trueman');
			$list['square effect8']  = esc_html__('Square Effect 8',  'trueman');
			$list['square effect9']  = esc_html__('Square Effect 9',  'trueman');
			$list['square effect10'] = esc_html__('Square Effect 10',  'trueman');
			$list['square effect11'] = esc_html__('Square Effect 11',  'trueman');
			$list['square effect12'] = esc_html__('Square Effect 12',  'trueman');
			$list['square effect13'] = esc_html__('Square Effect 13',  'trueman');
			$list['square effect14'] = esc_html__('Square Effect 14',  'trueman');
			$list['square effect15'] = esc_html__('Square Effect 15',  'trueman');
			$list['square effect_dir']   = esc_html__('Square Effect Dir',   'trueman');
			$list['square effect_shift'] = esc_html__('Square Effect Shift', 'trueman');
			$list['square effect_book']  = esc_html__('Square Effect Book',  'trueman');
			$list['square effect_more']  = esc_html__('Square Effect More',  'trueman');
			$list['square effect_fade']  = esc_html__('Square Effect Fade',  'trueman');
			$list['square effect_pull']  = esc_html__('Square Effect Pull',  'trueman');
			$list['square effect_slide'] = esc_html__('Square Effect Slide', 'trueman');
			$list['square effect_border'] = esc_html__('Square Effect Border', 'trueman');
			$list = apply_filters('trueman_filter_portfolio_hovers', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_hovers', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of the blog counters
if ( !function_exists( 'trueman_get_list_blog_counters' ) ) {
	function trueman_get_list_blog_counters($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_blog_counters'))=='') {
			$list = array(
				'views'		=> esc_html__('Views', 'trueman'),
				'likes'		=> esc_html__('Likes', 'trueman'),
				'rating'	=> esc_html__('Rating', 'trueman'),
				'comments'	=> esc_html__('Comments', 'trueman')
				);
			$list = apply_filters('trueman_filter_list_blog_counters', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_blog_counters', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list of the item sizes for the portfolio alter style, prepended inherit
if ( !function_exists( 'trueman_get_list_alter_sizes' ) ) {
	function trueman_get_list_alter_sizes($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_alter_sizes'))=='') {
			$list = array(
					'1_1' => esc_html__('1x1', 'trueman'),
					'1_2' => esc_html__('1x2', 'trueman'),
					'2_1' => esc_html__('2x1', 'trueman'),
					'2_2' => esc_html__('2x2', 'trueman'),
					'1_3' => esc_html__('1x3', 'trueman'),
					'2_3' => esc_html__('2x3', 'trueman'),
					'3_1' => esc_html__('3x1', 'trueman'),
					'3_2' => esc_html__('3x2', 'trueman'),
					'3_3' => esc_html__('3x3', 'trueman')
					);
			$list = apply_filters('trueman_filter_portfolio_alter_sizes', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_alter_sizes', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return extended hover directions list, prepended inherit
if ( !function_exists( 'trueman_get_list_hovers_directions' ) ) {
	function trueman_get_list_hovers_directions($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_hovers_directions'))=='') {
			$list = array(
				'left_to_right' => esc_html__('Left to Right',  'trueman'),
				'right_to_left' => esc_html__('Right to Left',  'trueman'),
				'top_to_bottom' => esc_html__('Top to Bottom',  'trueman'),
				'bottom_to_top' => esc_html__('Bottom to Top',  'trueman'),
				'scale_up'      => esc_html__('Scale Up',  'trueman'),
				'scale_down'    => esc_html__('Scale Down',  'trueman'),
				'scale_down_up' => esc_html__('Scale Down-Up',  'trueman'),
				'from_left_and_right' => esc_html__('From Left and Right',  'trueman'),
				'from_top_and_bottom' => esc_html__('From Top and Bottom',  'trueman')
			);
			$list = apply_filters('trueman_filter_portfolio_hovers_directions', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_hovers_directions', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of the label positions in the custom forms
if ( !function_exists( 'trueman_get_list_label_positions' ) ) {
	function trueman_get_list_label_positions($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_label_positions'))=='') {
			$list = array(
				'top'		=> esc_html__('Top',		'trueman'),
				'bottom'	=> esc_html__('Bottom',		'trueman'),
				'left'		=> esc_html__('Left',		'trueman'),
				'over'		=> esc_html__('Over',		'trueman')
			);
			$list = apply_filters('trueman_filter_label_positions', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_label_positions', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of the bg image positions
if ( !function_exists( 'trueman_get_list_bg_image_positions' ) ) {
	function trueman_get_list_bg_image_positions($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_bg_image_positions'))=='') {
			$list = array(
				'left top'	   => esc_html__('Left Top', 'trueman'),
				'center top'   => esc_html__("Center Top", 'trueman'),
				'right top'    => esc_html__("Right Top", 'trueman'),
				'left center'  => esc_html__("Left Center", 'trueman'),
				'center center'=> esc_html__("Center Center", 'trueman'),
				'right center' => esc_html__("Right Center", 'trueman'),
				'left bottom'  => esc_html__("Left Bottom", 'trueman'),
				'center bottom'=> esc_html__("Center Bottom", 'trueman'),
				'right bottom' => esc_html__("Right Bottom", 'trueman')
			);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_bg_image_positions', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of the bg image repeat
if ( !function_exists( 'trueman_get_list_bg_image_repeats' ) ) {
	function trueman_get_list_bg_image_repeats($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_bg_image_repeats'))=='') {
			$list = array(
				'repeat'	=> esc_html__('Repeat', 'trueman'),
				'repeat-x'	=> esc_html__('Repeat X', 'trueman'),
				'repeat-y'	=> esc_html__('Repeat Y', 'trueman'),
				'no-repeat'	=> esc_html__('No Repeat', 'trueman')
			);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_bg_image_repeats', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of the bg image attachment
if ( !function_exists( 'trueman_get_list_bg_image_attachments' ) ) {
	function trueman_get_list_bg_image_attachments($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_bg_image_attachments'))=='') {
			$list = array(
				'scroll'	=> esc_html__('Scroll', 'trueman'),
				'fixed'		=> esc_html__('Fixed', 'trueman'),
				'local'		=> esc_html__('Local', 'trueman')
			);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_bg_image_attachments', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}


// Return list of the bg tints
if ( !function_exists( 'trueman_get_list_bg_tints' ) ) {
	function trueman_get_list_bg_tints($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_bg_tints'))=='') {
			$list = array(
				'white'	=> esc_html__('White', 'trueman'),
				'light'	=> esc_html__('Light', 'trueman'),
				'dark'	=> esc_html__('Dark', 'trueman')
			);
			$list = apply_filters('trueman_filter_bg_tints', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_bg_tints', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return custom fields types list, prepended inherit
if ( !function_exists( 'trueman_get_list_field_types' ) ) {
	function trueman_get_list_field_types($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_field_types'))=='') {
			$list = array(
				'text'     => esc_html__('Text',  'trueman'),
				'textarea' => esc_html__('Text Area','trueman'),
				'password' => esc_html__('Password',  'trueman'),
				'radio'    => esc_html__('Radio',  'trueman'),
				'checkbox' => esc_html__('Checkbox',  'trueman'),
				'select'   => esc_html__('Select',  'trueman'),
				'date'     => esc_html__('Date','trueman'),
				'time'     => esc_html__('Time','trueman'),
				'button'   => esc_html__('Button','trueman')
			);
			$list = apply_filters('trueman_filter_field_types', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_field_types', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return Google map styles
if ( !function_exists( 'trueman_get_list_googlemap_styles' ) ) {
	function trueman_get_list_googlemap_styles($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_googlemap_styles'))=='') {
			$list = array(
				'default' => esc_html__('Default', 'trueman')
			);
			$list = apply_filters('trueman_filter_googlemap_styles', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_googlemap_styles', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return iconed classes list
if ( !function_exists( 'trueman_get_list_icons' ) ) {
	function trueman_get_list_icons($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_icons'))=='') {
			$list = trueman_parse_icons_classes(trueman_get_file_dir("css/fontello/css/fontello-codes.css"));
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_icons', $list);
		}
		return $prepend_inherit ? array_merge(array('inherit'), $list) : $list;
	}
}

// Return socials list
if ( !function_exists( 'trueman_get_list_socials' ) ) {
	function trueman_get_list_socials($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_socials'))=='') {
			$list = trueman_get_list_files("images/socials", "png");
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_socials', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return flags list
if ( !function_exists( 'trueman_get_list_flags' ) ) {
	function trueman_get_list_flags($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_flags'))=='') {
			$list = trueman_get_list_files("images/flags", "png");
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_flags', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( !function_exists( 'trueman_get_list_yesno' ) ) {
	function trueman_get_list_yesno($prepend_inherit=false) {
		$list = array(
			'yes' => esc_html__("Yes", 'trueman'),
			'no'  => esc_html__("No", 'trueman')
		);
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( !function_exists( 'trueman_get_list_onoff' ) ) {
	function trueman_get_list_onoff($prepend_inherit=false) {
		$list = array(
			"on" => esc_html__("On", 'trueman'),
			"off" => esc_html__("Off", 'trueman')
		);
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( !function_exists( 'trueman_get_list_showhide' ) ) {
	function trueman_get_list_showhide($prepend_inherit=false) {
		$list = array(
			"show" => esc_html__("Show", 'trueman'),
			"hide" => esc_html__("Hide", 'trueman')
		);
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list with 'Ascending' and 'Descending' items
if ( !function_exists( 'trueman_get_list_orderings' ) ) {
	function trueman_get_list_orderings($prepend_inherit=false) {
		$list = array(
			"asc" => esc_html__("Ascending", 'trueman'),
			"desc" => esc_html__("Descending", 'trueman')
		);
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( !function_exists( 'trueman_get_list_directions' ) ) {
	function trueman_get_list_directions($prepend_inherit=false) {
		$list = array(
			"horizontal" => esc_html__("Horizontal", 'trueman'),
			"vertical" => esc_html__("Vertical", 'trueman')
		);
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list with item's shapes
if ( !function_exists( 'trueman_get_list_shapes' ) ) {
	function trueman_get_list_shapes($prepend_inherit=false) {
		$list = array(
			"round"  => esc_html__("Round", 'trueman'),
			"square" => esc_html__("Square", 'trueman')
		);
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list with item's sizes
if ( !function_exists( 'trueman_get_list_sizes' ) ) {
	function trueman_get_list_sizes($prepend_inherit=false) {
		$list = array(
			"tiny"   => esc_html__("Tiny", 'trueman'),
			"small"  => esc_html__("Small", 'trueman'),
			"medium" => esc_html__("Medium", 'trueman'),
			"large"  => esc_html__("Large", 'trueman')
		);
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list with slider (scroll) controls positions
if ( !function_exists( 'trueman_get_list_controls' ) ) {
	function trueman_get_list_controls($prepend_inherit=false) {
		$list = array(
			"hide" => esc_html__("Hide", 'trueman'),
			"side" => esc_html__("Side", 'trueman'),
			"bottom" => esc_html__("Bottom", 'trueman')
		);
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list with float items
if ( !function_exists( 'trueman_get_list_floats' ) ) {
	function trueman_get_list_floats($prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'trueman'),
			"left" => esc_html__("Float Left", 'trueman'),
			"right" => esc_html__("Float Right", 'trueman')
		);
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list with alignment items
if ( !function_exists( 'trueman_get_list_alignments' ) ) {
	function trueman_get_list_alignments($justify=false, $prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'trueman'),
			"left" => esc_html__("Left", 'trueman'),
			"center" => esc_html__("Center", 'trueman'),
			"right" => esc_html__("Right", 'trueman')
		);
		if ($justify) $list["justify"] = esc_html__("Justify", 'trueman');
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list with horizontal positions
if ( !function_exists( 'trueman_get_list_hpos' ) ) {
	function trueman_get_list_hpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['left'] = esc_html__("Left", 'trueman');
		if ($center) $list['center'] = esc_html__("Center", 'trueman');
		$list['right'] = esc_html__("Right", 'trueman');
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list with vertical positions
if ( !function_exists( 'trueman_get_list_vpos' ) ) {
	function trueman_get_list_vpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['top'] = esc_html__("Top", 'trueman');
		if ($center) $list['center'] = esc_html__("Center", 'trueman');
		$list['bottom'] = esc_html__("Bottom", 'trueman');
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return sorting list items
if ( !function_exists( 'trueman_get_list_sortings' ) ) {
	function trueman_get_list_sortings($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_sortings'))=='') {
			$list = array(
				"date" => esc_html__("Date", 'trueman'),
				"title" => esc_html__("Alphabetically", 'trueman'),
				"views" => esc_html__("Popular (views count)", 'trueman'),
				"comments" => esc_html__("Most commented (comments count)", 'trueman'),
				"author_rating" => esc_html__("Author rating", 'trueman'),
				"users_rating" => esc_html__("Visitors (users) rating", 'trueman'),
				"random" => esc_html__("Random", 'trueman')
			);
			$list = apply_filters('trueman_filter_list_sortings', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_sortings', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list with columns widths
if ( !function_exists( 'trueman_get_list_columns' ) ) {
	function trueman_get_list_columns($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_columns'))=='') {
			$list = array(
				"none" => esc_html__("None", 'trueman'),
				"1_1" => esc_html__("100%", 'trueman'),
				"1_2" => esc_html__("1/2", 'trueman'),
				"1_3" => esc_html__("1/3", 'trueman'),
				"2_3" => esc_html__("2/3", 'trueman'),
				"1_4" => esc_html__("1/4", 'trueman'),
				"3_4" => esc_html__("3/4", 'trueman'),
				"1_5" => esc_html__("1/5", 'trueman'),
				"2_5" => esc_html__("2/5", 'trueman'),
				"3_5" => esc_html__("3/5", 'trueman'),
				"4_5" => esc_html__("4/5", 'trueman'),
				"1_6" => esc_html__("1/6", 'trueman'),
				"5_6" => esc_html__("5/6", 'trueman'),
				"1_7" => esc_html__("1/7", 'trueman'),
				"2_7" => esc_html__("2/7", 'trueman'),
				"3_7" => esc_html__("3/7", 'trueman'),
				"4_7" => esc_html__("4/7", 'trueman'),
				"5_7" => esc_html__("5/7", 'trueman'),
				"6_7" => esc_html__("6/7", 'trueman'),
				"1_8" => esc_html__("1/8", 'trueman'),
				"3_8" => esc_html__("3/8", 'trueman'),
				"5_8" => esc_html__("5/8", 'trueman'),
				"7_8" => esc_html__("7/8", 'trueman'),
				"1_9" => esc_html__("1/9", 'trueman'),
				"2_9" => esc_html__("2/9", 'trueman'),
				"4_9" => esc_html__("4/9", 'trueman'),
				"5_9" => esc_html__("5/9", 'trueman'),
				"7_9" => esc_html__("7/9", 'trueman'),
				"8_9" => esc_html__("8/9", 'trueman'),
				"1_10"=> esc_html__("1/10", 'trueman'),
				"3_10"=> esc_html__("3/10", 'trueman'),
				"7_10"=> esc_html__("7/10", 'trueman'),
				"9_10"=> esc_html__("9/10", 'trueman'),
				"1_11"=> esc_html__("1/11", 'trueman'),
				"2_11"=> esc_html__("2/11", 'trueman'),
				"3_11"=> esc_html__("3/11", 'trueman'),
				"4_11"=> esc_html__("4/11", 'trueman'),
				"5_11"=> esc_html__("5/11", 'trueman'),
				"6_11"=> esc_html__("6/11", 'trueman'),
				"7_11"=> esc_html__("7/11", 'trueman'),
				"8_11"=> esc_html__("8/11", 'trueman'),
				"9_11"=> esc_html__("9/11", 'trueman'),
				"10_11"=> esc_html__("10/11", 'trueman'),
				"1_12"=> esc_html__("1/12", 'trueman'),
				"5_12"=> esc_html__("5/12", 'trueman'),
				"7_12"=> esc_html__("7/12", 'trueman'),
				"10_12"=> esc_html__("10/12", 'trueman'),
				"11_12"=> esc_html__("11/12", 'trueman')
			);
			$list = apply_filters('trueman_filter_list_columns', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_columns', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return list of locations for the dedicated content
if ( !function_exists( 'trueman_get_list_dedicated_locations' ) ) {
	function trueman_get_list_dedicated_locations($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_dedicated_locations'))=='') {
			$list = array(
				"default" => esc_html__('As in the post defined', 'trueman'),
				"center"  => esc_html__('Above the text of the post', 'trueman'),
				"left"    => esc_html__('To the left the text of the post', 'trueman'),
				"right"   => esc_html__('To the right the text of the post', 'trueman'),
				"alter"   => esc_html__('Alternates for each post', 'trueman')
			);
			$list = apply_filters('trueman_filter_list_dedicated_locations', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_dedicated_locations', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return post-format name
if ( !function_exists( 'trueman_get_post_format_name' ) ) {
	function trueman_get_post_format_name($format, $single=true) {
		$name = '';
		if ($format=='gallery')		$name = $single ? esc_html__('gallery', 'trueman') : esc_html__('galleries', 'trueman');
		else if ($format=='video')	$name = $single ? esc_html__('video', 'trueman') : esc_html__('videos', 'trueman');
		else if ($format=='audio')	$name = $single ? esc_html__('audio', 'trueman') : esc_html__('audios', 'trueman');
		else if ($format=='image')	$name = $single ? esc_html__('image', 'trueman') : esc_html__('images', 'trueman');
		else if ($format=='quote')	$name = $single ? esc_html__('quote', 'trueman') : esc_html__('quotes', 'trueman');
		else if ($format=='link')	$name = $single ? esc_html__('link', 'trueman') : esc_html__('links', 'trueman');
		else if ($format=='status')	$name = $single ? esc_html__('status', 'trueman') : esc_html__('statuses', 'trueman');
		else if ($format=='aside')	$name = $single ? esc_html__('aside', 'trueman') : esc_html__('asides', 'trueman');
		else if ($format=='chat')	$name = $single ? esc_html__('chat', 'trueman') : esc_html__('chats', 'trueman');
		else						$name = $single ? esc_html__('standard', 'trueman') : esc_html__('standards', 'trueman');
		return apply_filters('trueman_filter_list_post_format_name', $name, $format);
	}
}

// Return post-format icon name (from Fontello library)
if ( !function_exists( 'trueman_get_post_format_icon' ) ) {
	function trueman_get_post_format_icon($format) {
		$icon = 'icon-';
		if ($format=='gallery')		$icon .= 'pictures';
		else if ($format=='video')	$icon .= 'video';
		else if ($format=='audio')	$icon .= 'note';
		else if ($format=='image')	$icon .= 'picture';
		else if ($format=='quote')	$icon .= 'quote';
		else if ($format=='link')	$icon .= 'link';
		else if ($format=='status')	$icon .= 'comment';
		else if ($format=='aside')	$icon .= 'doc-text';
		else if ($format=='chat')	$icon .= 'chat';
		else						$icon .= 'book-open';
		return apply_filters('trueman_filter_list_post_format_icon', $icon, $format);
	}
}

// Return fonts styles list, prepended inherit
if ( !function_exists( 'trueman_get_list_fonts_styles' ) ) {
	function trueman_get_list_fonts_styles($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_fonts_styles'))=='') {
			$list = array(
				'i' => esc_html__('I','trueman'),
				'u' => esc_html__('U', 'trueman')
			);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_fonts_styles', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return Google fonts list
if ( !function_exists( 'trueman_get_list_fonts' ) ) {
	function trueman_get_list_fonts($prepend_inherit=false) {
		if (($list = trueman_storage_get('list_fonts'))=='') {
			$list = array();
			$list = trueman_array_merge($list, trueman_get_list_font_faces());
			// Google and custom fonts list:
			//$list['Advent Pro'] = array(
			//		'family'=>'sans-serif',																						// (required) font family
			//		'link'=>'Advent+Pro:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic',	// (optional) if you use Google font repository
			//		'css'=>trueman_get_file_url('/css/font-face/Advent-Pro/stylesheet.css')									// (optional) if you use custom font-face
			//		);
			$list = trueman_array_merge($list, array(
				'Advent Pro' => array('family'=>'sans-serif'),
				'Alegreya Sans' => array('family'=>'sans-serif'),
				'Arimo' => array('family'=>'sans-serif'),
				'Asap' => array('family'=>'sans-serif'),
				'Averia Sans Libre' => array('family'=>'cursive'),
				'Averia Serif Libre' => array('family'=>'cursive'),
				'Bree Serif' => array('family'=>'serif',),
				'Cabin' => array('family'=>'sans-serif'),
				'Cabin Condensed' => array('family'=>'sans-serif'),
				'Caudex' => array('family'=>'serif'),
				'Comfortaa' => array('family'=>'cursive'),
				'Cousine' => array('family'=>'sans-serif'),
				'Crimson Text' => array('family'=>'serif'),
				'Cuprum' => array('family'=>'sans-serif'),
				'Dosis' => array('family'=>'sans-serif'),
				'Economica' => array('family'=>'sans-serif'),
				'Exo' => array('family'=>'sans-serif'),
				'Expletus Sans' => array('family'=>'cursive'),
				'Karla' => array('family'=>'sans-serif'),
				'Lato' => array('family'=>'sans-serif'),
				'Lekton' => array('family'=>'sans-serif'),
				'Lobster Two' => array('family'=>'cursive'),
				'Maven Pro' => array('family'=>'sans-serif'),
				'Merriweather' => array('family'=>'serif'),
				'Montserrat' => array('family'=>'sans-serif'),
				'Neuton' => array('family'=>'serif'),
				'Noticia Text' => array('family'=>'serif'),
				'Old Standard TT' => array('family'=>'serif'),
				'Open Sans' => array('family'=>'sans-serif'),
				'Orbitron' => array('family'=>'sans-serif'),
				'Oswald' => array('family'=>'sans-serif'),
				'Overlock' => array('family'=>'cursive'),
				'Oxygen' => array('family'=>'sans-serif'),
				'Philosopher' => array('family'=>'serif'),
				'PT Serif' => array('family'=>'serif'),
				'Puritan' => array('family'=>'sans-serif'),
				'Raleway' => array('family'=>'sans-serif'),
				'Roboto' => array('family'=>'sans-serif'),
				'Roboto Slab' => array('family'=>'sans-serif'),
				'Roboto Condensed' => array('family'=>'sans-serif'),
				'Rosario' => array('family'=>'sans-serif'),
				'Share' => array('family'=>'cursive'),
				'Signika' => array('family'=>'sans-serif'),
				'Signika Negative' => array('family'=>'sans-serif'),
				'Source Sans Pro' => array('family'=>'sans-serif'),
				'Tinos' => array('family'=>'serif'),
				'Ubuntu' => array('family'=>'sans-serif'),
				'Vollkorn' => array('family'=>'serif')
				)
			);
			$list = apply_filters('trueman_filter_list_fonts', $list);
			if (trueman_get_theme_setting('use_list_cache')) trueman_storage_set('list_fonts', $list);
		}
		return $prepend_inherit ? trueman_array_merge(array('inherit' => esc_html__("Inherit", 'trueman')), $list) : $list;
	}
}

// Return Custom font-face list
if ( !function_exists( 'trueman_get_list_font_faces' ) ) {
	function trueman_get_list_font_faces($prepend_inherit=false) {
		static $list = false;
		if (is_array($list)) return $list;
		$list = array();
		$dir = trueman_get_folder_dir("css/font-face");
		if ( is_dir($dir) ) {
			$hdir = @ opendir( $dir );
			if ( $hdir ) {
				while (($file = readdir( $hdir ) ) !== false ) {
					$pi = pathinfo( ($dir) . '/' . ($file) );
					if ( substr($file, 0, 1) == '.' || ! is_dir( ($dir) . '/' . ($file) ) )
						continue;
					$css = file_exists( ($dir) . '/' . ($file) . '/' . ($file) . '.css' ) 
						? trueman_get_folder_url("css/font-face/".($file).'/'.($file).'.css')
						: (file_exists( ($dir) . '/' . ($file) . '/stylesheet.css' ) 
							? trueman_get_folder_url("css/font-face/".($file).'/stylesheet.css')
							: '');
					if ($css != '')
						$list[$file.' ('.esc_html__('uploaded font', 'trueman').')'] = array('css' => $css);
				}
				@closedir( $hdir );
			}
		}
		return $list;
	}
}
?>