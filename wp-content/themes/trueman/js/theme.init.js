/* global jQuery:false */
/* global TRUEMAN_STORAGE:false */


// Theme-specific first load actions
//==============================================
function trueman_theme_ready_actions() {
	"use strict";
	// Put here your init code with theme-specific actions
	// It will be called before core actions
}


// Theme-specific scroll actions
//==============================================
function trueman_theme_scroll_actions() {
	"use strict";
	// Put here your theme-specific code with scroll actions
	// It will be called when page is scrolled (before core actions)
}


// Theme-specific resize actions
//==============================================
function trueman_theme_resize_actions() {
	"use strict";
	// Put here your theme-specific code with resize actions
	// It will be called when window is resized (before core actions)
}


// Theme-specific shortcodes init
//=====================================================
function trueman_theme_sc_init(cont) {
	"use strict";
	// Put here your theme-specific code to init shortcodes
	// It will be called before core init shortcodes
	// @param cont - jQuery-container with shortcodes (init only inside this container)
}


// Theme-specific post-formats init
//=====================================================
function trueman_theme_init_post_formats() {
	"use strict";
	// Put here your theme-specific code to init post-formats
	// It will be called before core init post_formats when page is loaded or after 'Load more' or 'Infinite scroll' actions

	// Tribe Events buttons decoration (add 'sc_button' class)
	jQuery('a.tribe-events-read-more,.tribe-events-button,.tribe-events-nav-previous a,.tribe-events-nav-next a,.tribe-events-widget-link a,.tribe-events-viewmore a')
		.addClass('sc_button sc_button_style_filled');

	// All other buttons decoration (add 'hover' class)
	if (TRUEMAN_STORAGE['button_hover']) {
		jQuery('button:not(.search_submit):not([class*="sc_button_hover_"]),\
				.sc_button:not(.sc_button_style_border):not([class*="sc_button_hover_"]),\
				.woocommerce .button:not([class*="sc_button_hover_"]),.woocommerce-page .button:not([class*="sc_button_hover_"]),\
				#buddypress a.button:not([class*="sc_button_hover_"])'
				).addClass('sc_button_hover_'+TRUEMAN_STORAGE['button_hover']);
		if (TRUEMAN_STORAGE['button_hover']!='arrow')
			jQuery('input[type="submit"]:not([class*="sc_button_hover_"]),\
					input[type="button"]:not([class*="sc_button_hover_"]),\
					.isotope_filters_button,\
					.scroll_to_top:not([class*="sc_button_hover_"]),\
					.sc_slider_prev:not([class*="sc_button_hover_"]),.sc_slider_next:not([class*="sc_button_hover_"]),\
					.tagcloud > a:not([class*="sc_button_hover_"])'
					).addClass('sc_button_hover_'+TRUEMAN_STORAGE['button_hover']);
	}

	// All text fields decoration (except Calculated Fields Forms)
	//if (TRUEMAN_STORAGE['input_hover'])
	//	jQuery('form:not([class*="cp_cff_"]):not([class*="sc_input_hover_"])').addClass('sc_input_hover_'+TRUEMAN_STORAGE['input_hover']);

	// Mark field as 'filled' on keypress
	jQuery('[class*="sc_input_hover_"] input, [class*="sc_input_hover_"] textarea').each(function() {
		if (jQuery(this).val()!='')
			jQuery(this).addClass('filled');
		else
			jQuery(this).removeClass('filled');
	});
	jQuery('[class*="sc_input_hover_"] input, [class*="sc_input_hover_"] textarea').on('keypress', function() {
		if (jQuery(this).val()!='')
			jQuery(this).addClass('filled');
		else
			jQuery(this).removeClass('filled');
	});
}


// Theme-specific GoogleMap styles
//=====================================================
function trueman_theme_googlemap_styles($styles) {
	"use strict";
	// Put here your theme-specific code to add GoogleMap styles
	// It will be called before GoogleMap init when page is loaded
	$styles['greyscale'] = [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#efeeed"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#f2f0f1"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#c2b698"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#b7b2a6"},{"lightness":17}]}];
	$styles['inverse'] = [
		{ "stylers": [
			{ "invert_lightness": true },
			{ "visibility": "on" }
			]
		}
	];
	$styles['simple'] = [
    	{ stylers: [
        	{ hue: "#00ffe6" },
            { saturation: -20 }
			]
		},
		{ featureType: "road",
          elementType: "geometry",
          stylers: [
			{ lightness: 100 },
           	{ visibility: "simplified" }
            ]
		},
		{ featureType: "road",
          elementType: "labels",
          stylers: [
          	{ visibility: "off" }
            ]
		}
	];
	$styles['apple'] = [
		{ "featureType": "landscape.man_made",
		  "elementType": "geometry",
		  "stylers": [
			{"color":"#f7f1df"}
			]
		},
		{ "featureType": "landscape.natural",
		  "elementType": "geometry",
		  "stylers": [
		  	{"color":"#d0e3b4"}
			]
		},
		{ "featureType": "landscape.natural.terrain",
		  "elementType": "geometry",
		  "stylers": [
		  	{"visibility":"off"}
			]
		},
		{ "featureType": "poi",
		  "elementType": "labels",
		  "stylers": [
		  	{"visibility":"off"}
			]
		},
		{ "featureType": "poi.business",
		  "elementType": "all",
		  "stylers": [
		  	{"visibility":"off"}
			]
		},
		{ "featureType": "poi.medical",
		  "elementType": "geometry",
		  "stylers": [
		  	{"color":"#fbd3da"}
			]
		},
		{ "featureType": "poi.park",
		  "elementType": "geometry",
		  "stylers": [
		  	{"color":"#bde6ab"}
			]
		},
		{ "featureType": "road",
		  "elementType": "geometry.stroke",
		  "stylers": [
		  	{"visibility":"off"}
			]
		},
		{ "featureType": "road",
		  "elementType": "labels",
		  "stylers": [
		  	{"visibility":"off"}
			]
		},
		{ "featureType": "road.highway",
		  "elementType": "geometry.fill",
		  "stylers": [
		  	{"color":"#ffe15f"}
			]
		},
		{ "featureType": "road.highway",
		  "elementType":"geometry.stroke",
		  "stylers": [
		  	{"color":"#efd151"}
		  	]
		},
		{ "featureType": "road.arterial",
		  "elementType": "geometry.fill",
		  "stylers": [
		  	{"color":"#ffffff"}
			]
		},
		{ "featureType": "road.local",
		  "elementType": "geometry.fill",
		  "stylers": [
		  	{"color":"black"}
			]
		},
		{ "featureType": "transit.station.airport",
		  "elementType": "geometry.fill",
		  "stylers": [
		  	{"color":"#cfb2db"}
			]
		},
		{ "featureType": "water",
		  "elementType": "geometry",
		  "stylers": [
		  	{"color":"#a2daf2"}
			]
		}
	];
	return $styles;
}
