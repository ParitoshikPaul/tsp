/* ==================================
	ADMIN LOGIN PAGE SCRIPTS
	Skin Custom Login Page plugin
===================================== */
jQuery( document ).ready( function($) {
	"use strict";
	
	var logoImgSRC 			= args.logo,
		bgr 				= args.bgr,
		bgrClr 				= args.bgr_color,
		bgrImgSRC 			= args.bgr_img,
		txtClr 				= args.text_color,
		fieldsBgr			= args.fields_bgr,
		fieldsSolidClr		= args.fields_solid_color;
	
	if ( undefined != logoImgSRC && '' !== logoImgSRC ) {
		var logo = '<img class="logo" src="' + logoImgSRC + '" />';
		
		$( 'body.login h1 a' ).append(logo);
	}
		
	$( 'body.login' ).find( '*' ).css({ 'color':txtClr, 'border-color':txtClr });
	$( 'body.login' ).find( '.message' ).css({ 'background-color':fieldsBgr });
	$( 'body.login' ).find( 'input' ).css({ 'background-color':fieldsBgr });
	$( 'body.login' ).find( 'input#wp-submit' ).css({ 'color':fieldsSolidClr, 'background-color':txtClr });
	
	if ( ( 'image' === bgr || 'pattern' === bgr ) && undefined != bgrImgSRC ) {
		$( 'body.login' ).css({ 'background-image':'url(' + bgrImgSRC + ')' });
		
		if ( 'pattern' === bgr ) {
			$( 'body.login' ).addClass( 'pattern' );
			
		} else {
			$( 'body.login' ).removeClass( 'pattern' );
		}
		
	} else {
		$( 'body.login' ).css({ 'background-color':bgrClr });
	}
});