/* ==============================================
	IMAGE UPLOAD SCRIPTS
	Skin - Premium WordPress Theme, by NordWood
================================================= */
jQuery( function($){
	"use strict";
	
	var frame,
		addImgBttn,
		removeImgBttn;
		
// Add image		
	$(document).on( 'click', '.upload-img', function( event ) {		
		addImgBttn = $(this);
		
		event.preventDefault();
		
		if (frame) {
			frame.open();
			return;
		}
		
		frame = wp.media({
			title: 'Select or upload your image',
			button: {
				text: 'Use this image'
			},
			multiple: false
		});
		
		frame.on( 'select', function() {			
			var attachment = frame.state().get( 'selection' ).first().toJSON(),
				imgPreview = addImgBttn.siblings( '.img-preview' ),
				imgID = addImgBttn.siblings( '.img-id' ),
				attachment_url = attachment.url;
			
			if( undefined != attachment.sizes.thumbnail ) {
				attachment_url = attachment.sizes.thumbnail.url;
			}
				
			removeImgBttn = addImgBttn.siblings( '.remove-img' );
				
			imgPreview.append( '<img src="'+attachment_url+'" alt="'+attachment.alt+'" />' );
			
			imgID.val( attachment.id );
			addImgBttn.addClass( 'hidden' );
			removeImgBttn.removeClass( 'hidden' );
		});
		
		frame.open();
	});
  
// Remove image		
	$(document).on( 'click', '.remove-img', function(event) {		
		removeImgBttn = $(this);
		
		event.preventDefault();
		
		var imgPreview = removeImgBttn.siblings( '.img-preview' ),
			imgID = removeImgBttn.siblings( '.img-id' );
		
		addImgBttn = removeImgBttn.siblings( '.upload-img' );
		
		imgPreview.html('');		
		imgID.val('');
		removeImgBttn.addClass( 'hidden' );
		addImgBttn.removeClass( 'hidden' );
	});
});