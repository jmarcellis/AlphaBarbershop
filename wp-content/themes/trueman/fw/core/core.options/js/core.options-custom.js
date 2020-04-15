/* global jQuery:false */

jQuery(document).ready(function() {
	TRUEMAN_STORAGE['media_frame'] = null;
	TRUEMAN_STORAGE['media_link'] = '';
	jQuery('.trueman_media_selector').on('click', function(e) {
		trueman_show_media_manager(this);
		e.preventDefault();
		return false;
	});
});

function trueman_show_media_manager(el) {
	"use strict";

	TRUEMAN_STORAGE['media_link'] = jQuery(el);
	// If the media frame already exists, reopen it.
	if ( TRUEMAN_STORAGE['media_frame'] ) {
		TRUEMAN_STORAGE['media_frame'].open();
		return false;
	}

	// Create the media frame.
	TRUEMAN_STORAGE['media_frame'] = wp.media({
		// Set the title of the modal.
		title: TRUEMAN_STORAGE['media_link'].data('choose'),
		// Tell the modal to show only images.
		library: {
			type: 'image'
		},
		// Multiple choise
		multiple: TRUEMAN_STORAGE['media_link'].data('multiple')===true ? 'add' : false,
		// Customize the submit button.
		button: {
			// Set the text of the button.
			text: TRUEMAN_STORAGE['media_link'].data('update'),
			// Tell the button not to close the modal, since we're
			// going to refresh the page when the image is selected.
			close: true
		}
	});

	// When an image is selected, run a callback.
	TRUEMAN_STORAGE['media_frame'].on( 'select', function(selection) {
		"use strict";
		// Grab the selected attachment.
		var field = jQuery("#"+TRUEMAN_STORAGE['media_link'].data('linked-field')).eq(0);
		var attachment = '';
		if (TRUEMAN_STORAGE['media_link'].data('multiple')===true) {
			TRUEMAN_STORAGE['media_frame'].state().get('selection').map( function( att ) {
				attachment += (attachment ? "\n" : "") + att.toJSON().url;
			});
			var val = field.val();
			attachment = val + (val ? "\n" : '') + attachment;
		} else {
			attachment = TRUEMAN_STORAGE['media_frame'].state().get('selection').first().toJSON().url;
		}
		field.val(attachment);
		if (field.siblings('img').length > 0) field.siblings('img').attr('src', attachment);
		field.trigger('change');
	});

	// Finally, open the modal.
	TRUEMAN_STORAGE['media_frame'].open();
	return false;
}
