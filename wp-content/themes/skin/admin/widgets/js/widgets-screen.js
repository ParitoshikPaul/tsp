/* ==============================================
	WIDGETS SCREEN SCRPITS
	Skin - Premium WordPress Theme, by NordWood
================================================= */	
jQuery( function($){
	"use strict";
		
	var specials = [ "categories", "search", "custom_html", "media_image", "text", "media_gallery", "skin_image_banner", "skin_social_profiles", "skin_author", "skin_pop", "skin_audio_video", "skin_top_posts", "skin_contact", "skin_instagram_grid", "skin_instagram_carousel", "woocommerce_product_categories", "woocommerce_products", "woocommerce_product_search", "woocommerce_top_rated_products", "woocommerce_recent_reviews" ];
	
	$( '#widgets-left, #widgets-right' ).find( '.widget' ).each( function(i, el) {
		var widget = $(el),
			widgetID = widget.attr('id'),
			widgetBase = widget.find( 'input[name="id_base"]' ).attr( 'value' ),
			widgetTitle = widget.find( 'h3' );
		
		if ( -1 != $.inArray( widgetBase, specials ) ) {
			widget.addClass( 'skin-special' );
		}
		
		if ( widgetID.includes('skin') ) {
			widgetTitle.addClass( 'skin-widget' );
		}
	});
	
	$( '#sidebar-specials' ).find( '.sidebar-name' ).find( 'h2' ).html( function() {
		return $(this).html().replace( $(this)[0].innerHTML.charAt(0), "<span class='skin-mark-special'>" + $(this)[0].innerHTML.charAt(0) + "</span>"); 
	} );
	
	var desc 				= areas.desc,
		specDesc 			= areas.spec_desc,
		listGuideTitle		= areas.l_title,
		listGuideImg		= areas.l_preview,
		singleGuideTitle	= areas.s_title,
		singleGuideImg		= areas.s_preview;
	
	var guide = '<div class="clearfix"></div>';
	
// Open Help wrapper
	guide += '<div class="skin-widgets-help clearfix">';
	
// Specials description
	guide += specDesc;
	
// Help description
	guide += desc;
	
// Help images
	guide += '<div class="positions"><h4>' + listGuideTitle + '</h4><img src="' + listGuideImg + '" /></div>';
	guide += '<div class="positions"><h4>' + singleGuideTitle + '</h4><img src="' + singleGuideImg + '" /></div>';
	
// Close Help wrapper
	guide += '</div>';
	
// Append the Help to Widgets screen
	$( '#widgets-right' ).append( guide );
});