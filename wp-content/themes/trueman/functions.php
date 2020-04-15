<?php
/**
 * Theme sprecific functions and definitions
 */

/* Theme setup section
------------------------------------------------------------------- */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */

// Prepare demo data
$trueman_demo_data_url = esc_url('http://trueman.ancorathemes.com/demo/');


// Add theme specific actions and filters
// Attention! Function were add theme specific actions and filters handlers must have priority 1
if ( !function_exists( 'trueman_theme_setup' ) ) {
	add_action( 'trueman_action_before_init_theme', 'trueman_theme_setup', 1 );
	function trueman_theme_setup() {

        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );

        // Enable support for Post Thumbnails
        add_theme_support( 'post-thumbnails' );

        // Custom header setup
        add_theme_support( 'custom-header', array('header-text'=>false));

        // Custom backgrounds setup
        add_theme_support( 'custom-background');

        // Supported posts formats
        add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat') );

        // Autogenerate title tag
        add_theme_support('title-tag');

        // Add user menu
        add_theme_support('nav-menus');

        // WooCommerce Support
        add_theme_support( 'woocommerce' );

		// Register theme menus
		add_filter( 'trueman_filter_add_theme_menus',		'trueman_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'trueman_filter_add_theme_sidebars',	'trueman_add_theme_sidebars' );

		// Set options for importer
		add_filter( 'trueman_filter_importer_options',		'trueman_set_importer_options' );

		// Add theme required plugins
		add_filter( 'trueman_filter_required_plugins',		'trueman_add_required_plugins' );
		
		// Add preloader styles
		add_filter('trueman_filter_add_styles_inline',		'trueman_head_add_page_preloader_styles');

		// Init theme after WP is created
		add_action( 'wp',									'trueman_core_init_theme' );

		// Add theme specified classes into the body
		add_filter( 'body_class', 							'trueman_body_classes' );

		// Add data to the head and to the beginning of the body
		add_action('wp_head',								'trueman_head_add_page_meta', 0);
		add_action('before',								'trueman_body_add_toc');
		add_action('before',								'trueman_body_add_page_preloader');

		// Add data to the footer (priority 1, because priority 2 used for localize scripts)
		add_action('wp_footer',								'trueman_footer_add_views_counter', 1);
		add_action('wp_footer',								'trueman_footer_add_theme_customizer', 1);
		add_action('wp_footer',								'trueman_footer_add_scroll_to_top', 1);
		add_action('wp_footer',								'trueman_footer_add_custom_html', 1);

        function wpb_move_comment_field_to_bottom( $fields ) {
            $comment_field = $fields['comment'];
            unset( $fields['comment'] );
            $fields['comment'] = $comment_field;
            return $fields;
        }

        add_filter( 'comment_form_fields', 'wpb_move_comment_field_to_bottom' );

		// Set list of the theme required plugins
		trueman_storage_set('required_plugins', array(
			'booked',
			'essgrids',
			'revslider',
			'trx_utils',
			'visual_composer',
			'woocommerce',
            'instagram_feed',
            'gdpr-compliance',
            'contact-form-7'
			)
		);

        if ( is_dir(TRUEMAN_THEME_PATH . 'demo/') ) {
            trueman_storage_set('demo_data_url',  TRUEMAN_THEME_PATH . 'demo/');
        } else {
            trueman_storage_set('demo_data_url',  esc_url(trueman_get_protocol().'://trueman.ancorathemes.com/demo') ); // Demo-site domain
        }

	}
}


// Add/Remove theme nav menus
if ( !function_exists( 'trueman_add_theme_menus' ) ) {
	function trueman_add_theme_menus($menus) {
		return $menus;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'trueman_add_theme_sidebars' ) ) {
	function trueman_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> esc_html__( 'Main Sidebar', 'trueman' ),
				'sidebar_footer'	=> esc_html__( 'Footer Sidebar', 'trueman' ),
				'sidebar_footer_2'	=> esc_html__( 'Footer Sidebar Style 2', 'trueman' )
			);
			if (function_exists('trueman_exists_woocommerce') && trueman_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = esc_html__( 'WooCommerce Cart Sidebar', 'trueman' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}


// Add theme required plugins
if ( !function_exists( 'trueman_add_required_plugins' ) ) {
	function trueman_add_required_plugins($plugins) {
		$plugins[] = array(
			'name' 		=> esc_html__( 'Trueman Utilities', 'trueman' ),
			'version'	=> '3.1',
			'slug' 		=> 'trx_utils',
			'source'	=> trueman_get_file_dir('plugins/install/trx_utils.zip'),
			'required' 	=> true
		);
		return $plugins;
	}
}

// Return text for the Privacy Policy checkbox
if ( ! function_exists('trueman_get_privacy_text' ) ) {
    function trueman_get_privacy_text() {
        $page = get_option( 'wp_page_for_privacy_policy' );
        $privacy_text = trueman_get_theme_option( 'privacy_text' );
        return apply_filters( 'trueman_filter_privacy_text', wp_kses_post(
                $privacy_text
                . ( ! empty( $page ) && ! empty( $privacy_text )
                    // Translators: Add url to the Privacy Policy page
                    ? ' ' . sprintf( __( 'For further details on handling user data, see our %s', 'trueman' ),
                        '<a href="' . esc_url( get_permalink( $page ) ) . '" target="_blank">'
                        . __( 'Privacy Policy', 'trueman' )
                        . '</a>' )
                    : ''
                )
            )
        );
    }
}

// Return text for the "I agree ..." checkbox
if ( ! function_exists( 'trueman_trx_utils_privacy_text' ) ) {
    add_filter( 'trx_utils_filter_privacy_text', 'trueman_trx_utils_privacy_text' );
    function trueman_trx_utils_privacy_text( $text='' ) {
        return trueman_get_privacy_text();
    }
}

// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'trueman_importer_set_options' ) ) {
    add_filter( 'trx_utils_filter_importer_options', 'trueman_importer_set_options', 9 );
    function trueman_importer_set_options( $options=array() ) {
        if ( is_array( $options ) ) {
            // Save or not installer's messages to the log-file
            $options['debug'] = false;
            // Prepare demo data
            if ( is_dir( TRUEMAN_THEME_PATH . 'demo/' ) ) {
                $options['demo_url'] = TRUEMAN_THEME_PATH . 'demo/';
            } else {
                $options['demo_url'] = esc_url( trueman_get_protocol().'://demofiles.ancorathemes.com/trueman/' ); // Demo-site domain
            }

            // Required plugins
            $options['required_plugins'] =  array(
                'booked',
                'essential-grid',
                'revslider',
                'the-events-calendar',
                'js_composer',
                'woocommerce'
            );

            $options['theme_slug'] = 'trueman';

            // Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
            // Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
            $options['regenerate_thumbnails'] = 3;
            // Default demo
            $options['files']['default']['title'] = esc_html__( 'Trueman Demo', 'trueman' );
            $options['files']['default']['domain_dev'] = esc_url(trueman_get_protocol().'://trueman.ancorathemes.com'); // Developers domain
            $options['files']['default']['domain_demo']= esc_url(trueman_get_protocol().'://trueman.ancorathemes.com'); // Demo-site domain

        }
        return $options;
    }
}


// Add data to the head and to the beginning of the body
//------------------------------------------------------------------------

// Add theme specified classes to the body tag
if ( !function_exists('trueman_body_classes') ) {
	function trueman_body_classes( $classes ) {

		$classes[] = 'trueman_body';
		$classes[] = 'body_style_' . trim(trueman_get_custom_option('body_style'));
		$classes[] = 'body_' . (trueman_get_custom_option('body_filled')=='yes' ? 'filled' : 'transparent');
		$classes[] = 'article_style_' . trim(trueman_get_custom_option('article_style'));
		
		$blog_style = trueman_get_custom_option(is_singular() && !trueman_storage_get('blog_streampage') ? 'single_style' : 'blog_style');
		$classes[] = 'layout_' . trim($blog_style);
		$classes[] = 'template_' . trim(trueman_get_template_name($blog_style));
		
		$body_scheme = trueman_get_custom_option('body_scheme');
		if (empty($body_scheme)  || trueman_is_inherit_option($body_scheme)) $body_scheme = 'original';
		$classes[] = 'scheme_' . $body_scheme;

		$top_panel_position = trueman_get_custom_option('top_panel_position');
		if (!trueman_param_is_off($top_panel_position)) {
			$classes[] = 'top_panel_show';
			$classes[] = 'top_panel_' . trim($top_panel_position);
		} else 
			$classes[] = 'top_panel_hide';
		$classes[] = trueman_get_sidebar_class();

		if (trueman_get_custom_option('show_video_bg')=='yes' && (trueman_get_custom_option('video_bg_youtube_code')!='' || trueman_get_custom_option('video_bg_url')!=''))
			$classes[] = 'video_bg_show';

		if (!trueman_param_is_off(trueman_get_theme_option('page_preloader')))
			$classes[] = 'preloader';

		return $classes;
	}
}


// Add page meta to the head
if (!function_exists('trueman_head_add_page_meta')) {
	function trueman_head_add_page_meta() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1<?php if (trueman_get_theme_option('responsive_layouts')=='yes') echo ', maximum-scale=1'; ?>">
		<meta name="format-detection" content="telephone=no">
	
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php
	}
}

// Add page preloader styles to the head
if (!function_exists('trueman_head_add_page_preloader_styles')) {
	function trueman_head_add_page_preloader_styles($css) {
		if (($preloader=trueman_get_theme_option('page_preloader'))!='none') {
			$image = trueman_get_theme_option('page_preloader_image');
			$bg_clr = trueman_get_scheme_color('bg_color');
			$link_clr = trueman_get_scheme_color('text_link');
			$css .= '
				#page_preloader {
					background-color: '. esc_attr($bg_clr) . ';'
					. ($preloader=='custom' && $image
						? 'background-image:url('.esc_url($image).');'
						: ''
						)
				    . '
				}
				.preloader_wrap > div {
					background-color: '.esc_attr($link_clr).';
				}';
		}
		return $css;
	}
}

// Add TOC anchors to the beginning of the body
if (!function_exists('trueman_body_add_toc')) {
	function trueman_body_add_toc() {
		// Add TOC items 'Home' and "To top"
		if (trueman_get_custom_option('menu_toc_home')=='yes' && function_exists('trueman_sc_anchor'))
            trueman_show_layout(trueman_sc_anchor(array(
				'id' => "toc_home",
				'title' => esc_html__('Home', 'trueman'),
				'description' => esc_html__('{{Return to Home}} - ||navigate to home page of the site', 'trueman'),
				'icon' => "icon-home",
				'separator' => "yes",
				'url' => esc_url(home_url('/'))
				)
			)); 
		if (trueman_get_custom_option('menu_toc_top')=='yes' && function_exists('trueman_sc_anchor'))
            trueman_show_layout(trueman_sc_anchor(array(
				'id' => "toc_top",
				'title' => esc_html__('To Top', 'trueman'),
				'description' => esc_html__('{{Back to top}} - ||scroll to top of the page', 'trueman'),
				'icon' => "icon-double-up",
				'separator' => "yes")
				)); 
	}
}

// Add page preloader to the beginning of the body
if (!function_exists('trueman_body_add_page_preloader')) {
	function trueman_body_add_page_preloader() {
		if ( ($preloader=trueman_get_theme_option('page_preloader')) != 'none' && ( $preloader != 'custom' || ($image=trueman_get_theme_option('page_preloader_image')) != '')) {
			?><div id="page_preloader"><?php
				if ($preloader == 'circle') {
					?><div class="preloader_wrap preloader_<?php echo esc_attr($preloader); ?>"><div class="preloader_circ1"></div><div class="preloader_circ2"></div><div class="preloader_circ3"></div><div class="preloader_circ4"></div></div><?php
				} else if ($preloader == 'square') {
					?><div class="preloader_wrap preloader_<?php echo esc_attr($preloader); ?>"><div class="preloader_square1"></div><div class="preloader_square2"></div></div><?php
				}
			?></div><?php
		}
	}
}

// Add theme required plugins
if ( !function_exists( 'trueman_add_trx_utils' ) ) {
    add_filter( 'trx_utils_active', 'trueman_add_trx_utils' );
    function trueman_add_trx_utils($enable=true) {
        return true;
    }
}


// Add data to the footer
//------------------------------------------------------------------------

// Add post/page views counter
if (!function_exists('trueman_footer_add_views_counter')) {
	function trueman_footer_add_views_counter() {
		// Post/Page views counter
		get_template_part(trueman_get_file_slug('templates/_parts/views-counter.php'));
	}
}

// Add theme customizer
if (!function_exists('trueman_footer_add_theme_customizer')) {
	function trueman_footer_add_theme_customizer() {
		// Front customizer
		if (trueman_get_custom_option('show_theme_customizer')=='yes') {
			get_template_part(trueman_get_file_slug('core/core.customizer/front.customizer.php'));
		}
	}
}

// Add scroll to top button
if (!function_exists('trueman_footer_add_scroll_to_top')) {
	//add_action('wp_footer', 'trueman_footer_add_scroll_to_top');
	function trueman_footer_add_scroll_to_top() {
		?><a href="#" class="scroll_to_top icon-up" title="<?php esc_attr_e('Scroll to top', 'trueman'); ?>"></a><?php
	}
}

// Add custom html
if (!function_exists('trueman_footer_add_custom_html')) {
	//add_action('wp_footer', 'trueman_footer_add_custom_html');
	function trueman_footer_add_custom_html() {
		?><div class="custom_html_section"><?php
			trueman_show_layout(trueman_get_custom_option('custom_code'));
		?></div><?php
	}
}

// Include framework core files
//-------------------------------------------------------------------
require_once trailingslashit( get_template_directory() ) . 'fw/loader.php';
?>