function trueman_googlemap_init(dom_obj, coords) {
	"use strict";
	if (typeof TRUEMAN_STORAGE['googlemap_init_obj'] == 'undefined') trueman_googlemap_init_styles();
	TRUEMAN_STORAGE['googlemap_init_obj'].geocoder = '';
	try {
		var id = dom_obj.id;
		TRUEMAN_STORAGE['googlemap_init_obj'][id] = {
			dom: dom_obj,
			markers: coords.markers,
			geocoder_request: false,
			opt: {
				zoom: coords.zoom,
				center: null,
				scrollwheel: false,
				scaleControl: false,
				disableDefaultUI: false,
				panControl: true,
				zoomControl: true, //zoom
				mapTypeControl: false,
				streetViewControl: false,
				overviewMapControl: false,
				styles: TRUEMAN_STORAGE['googlemap_styles'][coords.style ? coords.style : 'default'],
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
		};
		
		trueman_googlemap_create(id);

	} catch (e) {
		
		dcl(TRUEMAN_STORAGE['strings']['googlemap_not_avail']);

	};
}

function trueman_googlemap_create(id) {
	"use strict";

	// Create map
	TRUEMAN_STORAGE['googlemap_init_obj'][id].map = new google.maps.Map(TRUEMAN_STORAGE['googlemap_init_obj'][id].dom, TRUEMAN_STORAGE['googlemap_init_obj'][id].opt);

	// Add markers
	for (var i in TRUEMAN_STORAGE['googlemap_init_obj'][id].markers)
		TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].inited = false;
	trueman_googlemap_add_markers(id);
	
	// Add resize listener
	jQuery(window).resize(function() {
		if (TRUEMAN_STORAGE['googlemap_init_obj'][id].map)
			TRUEMAN_STORAGE['googlemap_init_obj'][id].map.setCenter(TRUEMAN_STORAGE['googlemap_init_obj'][id].opt.center);
	});
}

function trueman_googlemap_add_markers(id) {
	"use strict";
	for (var i in TRUEMAN_STORAGE['googlemap_init_obj'][id].markers) {
		
		if (TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].inited) continue;
		
		if (TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].latlng == '') {
			
			if (TRUEMAN_STORAGE['googlemap_init_obj'][id].geocoder_request!==false) continue;
			
			if (TRUEMAN_STORAGE['googlemap_init_obj'].geocoder == '') TRUEMAN_STORAGE['googlemap_init_obj'].geocoder = new google.maps.Geocoder();
			TRUEMAN_STORAGE['googlemap_init_obj'][id].geocoder_request = i;
			TRUEMAN_STORAGE['googlemap_init_obj'].geocoder.geocode({address: TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].address}, function(results, status) {
				"use strict";
				if (status == google.maps.GeocoderStatus.OK) {
					var idx = TRUEMAN_STORAGE['googlemap_init_obj'][id].geocoder_request;
					if (results[0].geometry.location.lat && results[0].geometry.location.lng) {
						TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[idx].latlng = '' + results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng();
					} else {
						TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[idx].latlng = results[0].geometry.location.toString().replace(/\(\)/g, '');
					}
					TRUEMAN_STORAGE['googlemap_init_obj'][id].geocoder_request = false;
					setTimeout(function() { 
						trueman_googlemap_add_markers(id); 
						}, 200);
				} else
					dcl(TRUEMAN_STORAGE['strings']['geocode_error'] + ' ' + status);
			});
		
		} else {
			
			// Prepare marker object
			var latlngStr = TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].latlng.split(',');
			var markerInit = {
				map: TRUEMAN_STORAGE['googlemap_init_obj'][id].map,
				position: new google.maps.LatLng(latlngStr[0], latlngStr[1]),
				clickable: TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].description!=''
			};
			if (TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].point) markerInit.icon = TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].point;
			if (TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].title) markerInit.title = TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].title;
			TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].marker = new google.maps.Marker(markerInit);
			
			// Set Map center
			if (TRUEMAN_STORAGE['googlemap_init_obj'][id].opt.center == null) {
				TRUEMAN_STORAGE['googlemap_init_obj'][id].opt.center = markerInit.position;
				TRUEMAN_STORAGE['googlemap_init_obj'][id].map.setCenter(TRUEMAN_STORAGE['googlemap_init_obj'][id].opt.center);				
			}
			
			// Add description window
			if (TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].description!='') {
				TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].infowindow = new google.maps.InfoWindow({
					content: TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].description
				});
				google.maps.event.addListener(TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].marker, "click", function(e) {
					var latlng = e.latLng.toString().replace("(", '').replace(")", "").replace(" ", "");
					for (var i in TRUEMAN_STORAGE['googlemap_init_obj'][id].markers) {
						if (latlng == TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].latlng) {
							TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].infowindow.open(
								TRUEMAN_STORAGE['googlemap_init_obj'][id].map,
								TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].marker
							);
							break;
						}
					}
				});
			}
			
			TRUEMAN_STORAGE['googlemap_init_obj'][id].markers[i].inited = true;
		}
	}
}

function trueman_googlemap_refresh() {
	"use strict";
	for (id in TRUEMAN_STORAGE['googlemap_init_obj']) {
		trueman_googlemap_create(id);
	}
}

function trueman_googlemap_init_styles() {
	// Init Google map
	TRUEMAN_STORAGE['googlemap_init_obj'] = {};
	TRUEMAN_STORAGE['googlemap_styles'] = {
		'default': []
	};
	if (window.trueman_theme_googlemap_styles!==undefined)
		TRUEMAN_STORAGE['googlemap_styles'] = trueman_theme_googlemap_styles(TRUEMAN_STORAGE['googlemap_styles']);
}