/* ==========================================
	SCRIPTS FOR ADDING IMAGES TO GALLERY
	Skin Featured Area plugin
============================================= */
jQuery( function($){
	"use strict";
	
	var frame,
		galleryField	= $( '#skin_featured_area_meta_box-skin-featured-area-meta-box' ),
		galleryPreview	= galleryField.find( '.gallery-preview' ),
		imgIDs			= galleryField.find( '.gallery-ids' ),	
		getActiveIDs	= gallargs.get_images;
							
// Insert selected images from media library into gallery
	galleryField.on( 'click', '.add-images', function( event ) {
		event.preventDefault();

		if ( frame ) {
			frame.open();
			return;
		}

		frame = wp.media({
			title: 'Select or upload images for the gallery',
			library: {
				type: 'image'
			},
			button: {
				text: 'Add to gallery'
			},
			multiple: true
		});

		frame.on( 'select', function() {
			var selectedIDsArr = [],
				imgSelection = frame.state().get('selection');
				
			imgSelection.map( function( attachment ) {
				selectedIDsArr.push( attachment.toJSON() );
			});			
			
			var newImage = '';
			
			for( var i in selectedIDsArr ) {
			// Append the new ids to the current array
				imgIDs.val(
					imgIDs.val() +
					( imgIDs.val() ? ', ' : '' ) +
					selectedIDsArr[i].id
				);
				
				getActiveIDs.push( selectedIDsArr[i].id.toString() );
			
			// Preview the chosen images
				newImage = '';
				newImage += '<div class="img-wrapper">';
				newImage += '<img src="'+selectedIDsArr[i].sizes.thumbnail.url+'" class="gallery-img" />';
				
				newImage += '<input type="hidden" class="img-id"';
				newImage += 'id="img-id-' + selectedIDsArr[i].id + '"';
				newImage += 'name="img-id-' + selectedIDsArr[i].id + '"';
				newImage += 'value="' + selectedIDsArr[i].id + '"';
				newImage += '>';
				
				newImage += '<span class="remove-image"><span class="close-button dashicons dashicons-no-alt"></span></span>';
				
				newImage += '</div>';
				
				galleryPreview.append( newImage );				
			} 
		});

		frame.open();
	});
	
// Remove a single image
	galleryPreview.on( 'click', '.remove-image', function( event ) {
		event.preventDefault();

		var imgID = $(this).siblings( '.img-id' ).val();

		$(this).parent().fadeOut( 200, function() {
			$(this).remove();
		});
		
		getActiveIDs.splice( getActiveIDs.indexOf( imgID ), 1 );
		imgIDs.val( getActiveIDs.join(", ") );
	});
	
// Remove all images
	galleryField.on( 'click', '.remove-all', function( event ) {
		event.preventDefault();

		galleryPreview.html( '' );
		imgIDs.val( '' );
	});

// Make images sortable
	galleryPreview.sortable().bind( 'sortupdate', function( e, ui ) {
		var newOrder = [];
		
		$( '.img-wrapper' ).each( function() {
			var $el = $(this).find( '.img-id' ).val();
			newOrder.push($el);
		});
		
		imgIDs.val('');
		imgIDs.val(newOrder.join(", "));
	});
});