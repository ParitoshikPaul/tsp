/* ==========================================
	SCRIPTS FOR FEATURED AREA CUSTOM FIELDS
	Skin Featured Area plugin
============================================= */
jQuery(document).ready( function($) {
	"use strict";
	
	var featuredAreaCtrl	= $( "#skin_featured_area_meta_box-skin-featured-area-meta-box" ),
		imgField			= featuredAreaCtrl.find( "#skin-featured-image" ),
		videoField			= featuredAreaCtrl.find( "#skin-featured-video" ),
		audioField			= featuredAreaCtrl.find( "#skin-featured-audio" ),
		quoteField			= featuredAreaCtrl.find( "#skin-featured-quote" ),
		linkField			= featuredAreaCtrl.find( "#skin-featured-link" ),
		galleryField		= featuredAreaCtrl.find( "#skin-featured-gallery" ),
		postFormat			= $( "input:radio[name=post_format]:checked" ).val();
	
// Hide all metaboxes initially
	$( ".skin-featured-metabox" ).hide();
	
// If the post has a post format assigned, open its metabox
	switch( postFormat ) {
		case "image":
			featuredAreaCtrl.show();
			imgField.show();
			break;
			
		case "video":
			featuredAreaCtrl.show();
			videoField.show();
			break;
			
		case "audio":
			featuredAreaCtrl.show();
			audioField.show();
			break;
			
		case "quote":
			featuredAreaCtrl.show();
			quoteField.show();
			break;
			
		case "link":
			featuredAreaCtrl.show();
			linkField.show();
			break;
			
		case "gallery":
			featuredAreaCtrl.show();
			galleryField.show();
			break;
			
		default:
			featuredAreaCtrl.hide();
	}	
	
// Replace the metabox if the post format changes
	$( "input:radio[name=post_format]" ).change( function() {
		$( ".skin-featured-metabox" ).hide( 100, "swing" );
		
		switch( $(this).val() ) {		
			case "image":
				featuredAreaCtrl.show();
				imgField.show( 300, "swing" );
				break;
				
			case "video":
				featuredAreaCtrl.show();
				videoField.show( 300, "swing" );
				break;
				
			case "audio":
				featuredAreaCtrl.show();
				audioField.show( 300, "swing" );
				break;
				
			case "quote":
				featuredAreaCtrl.show();
				quoteField.show( 300, "swing" );
				break;
				
			case "link":
				featuredAreaCtrl.show();
				linkField.show( 300, "swing" );
				break;
				
			case "gallery":
				featuredAreaCtrl.show();
				galleryField.show( 300, "swing" );
				break;
				
			default:
				featuredAreaCtrl.hide( 100, "swing" );
		}
	});
});