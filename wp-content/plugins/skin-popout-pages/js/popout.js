/* =============================
	SKIN POPOUT PAGES SCRIPTS
	Skin Popout Pages plugin
================================ */
jQuery( function($) {
    "use strict";
	
	$.fn.skinPopout = function() {
	// Remove the previously opened popouts
		if ( $( '.popout-holder' ).length > 0 ) {
			$( '.popout-holder-overlay' ).detach();
		}
		
		var postLink = $(this).attr( 'href' ),
			top,
			topPos,
			contentHeight;
			
	// Build a clone
		var popoutClone = '<div class="popout-clone-holder">';
			popoutClone += '<div class="popout-clone-wrapper"></div>';
			popoutClone += '</div>';
			
		$( 'body' ).prepend( popoutClone );
		
		$( '.popout-clone-wrapper' ).load( postLink, function() {
			$( '.popout-clone-wrapper' ).imagesLoaded( function() {				
			// Insert the content into the clone first
				function buildClone() {
				// Adjust the featured image size
					if ( ! $( '.popout-clone-wrapper' ).find( '.popout' ).hasClass( 'img-circle' ) ) {
						var img			= $( '.popout-clone-wrapper' ).find( '.popout-featured-image' ),
							imgWidth	= $( '.popout-clone-wrapper' ).find( '.popout' ).hasClass( 'img-only' ) ? img.attr( 'data-img-w' ) : img.width(),
							ratio		= img.attr( 'data-img-ratio' );
				
						if ( $( '.popout-clone-wrapper' ).find( '.popout' ).hasClass( 'img-only' ) && ( window.innerWidth - 100 ) < imgWidth ) {
							imgWidth = window.innerWidth - 100;
						}
							
						img.width( imgWidth );				
						img.height( imgWidth/ratio );
					}
					
				// Calculate the clone's height
					contentHeight = $( '.popout-clone-wrapper' ).height();				
				/*
					If the content height can fit into viewport,
					position it in the middle,
					or close to top, otherwise.
				*/
					if ( window.innerHeight > contentHeight ) {
						topPos			= ( window.innerHeight/2 ) - ( contentHeight/2 );
						top				= topPos + 'px';
						contentHeight	= contentHeight-1 + 'px';
						
					} else {
						top = ( window.innerWidth > 1023 ) ? '75px' : '6%';					
						contentHeight = 'auto';
					}
				}
				
				function buildPopout() {
					var popout = '<div class="popout-holder-overlay">';						
					popout += '<div class="popout-holder" style="margin-top:' + top + ';">';
					
					popout += '<span class="close-popout round"><svg class="close-button" width="16.014px" height="16.013px" viewBox="0 0 16.014 16.013" enable-background="new 0 0 16.014 16.013"><path class="svg-fill" d="M0.419,14.09l6.016-6.084L0.419,1.922C-0.128,1.421-0.14,0.909,0.385,0.384c0.523-0.523,1.036-0.513,1.538,0.034 l6.084,6.016l6.084-6.016c0.501-0.547,1.014-0.558,1.538-0.034c0.523,0.524,0.513,1.037-0.034,1.538L9.579,8.006l6.016,6.084 c0.547,0.502,0.558,1.015,0.034,1.538c-0.524,0.524-1.037,0.513-1.538-0.034L8.007,9.579l-6.084,6.016 c-0.502,0.547-1.015,0.559-1.538,0.034C-0.14,15.105-0.128,14.592,0.419,14.09z"/></svg></span>';
					
					popout += '<div class="popout-wrapper content-pad" style="height:' + contentHeight + ';"></div>';						
					popout += '</div>';						
					popout += '</div>';
					
				// Remove the clone and insert the wrapper for the popout
					$( '.popout-clone-holder' ).remove();				
					$( 'html, body' ).addClass( 'popout-active' );
					$( 'body' ).prepend( popout );
					
				// Insert the post content and show it with small delay
					$( '.popout-wrapper' ).html( 'content loading' );
					
					$( '.popout-wrapper' ).load( postLink, function() {
						function adjustPopoutItems() {
							if ( ! $( '.popout-wrapper' ).find( '.popout' ).hasClass( 'img-circle' ) ) {
								var img			= $( '.popout-wrapper' ).find( '.popout-featured-image' ),
									imgWidth	= $( '.popout-wrapper' ).find( '.popout' ).hasClass( 'img-only' ) ? img.attr( 'data-img-w' ) : img.width(),
									ratio		= img.attr( 'data-img-ratio' );
						
								if ( $( '.popout-wrapper' ).find( '.popout' ).hasClass( 'img-only' ) && ( window.innerWidth - 100 ) < imgWidth ) {
									imgWidth = window.innerWidth - 100;
								}
									
								img.width( imgWidth );							
								img.height( imgWidth/ratio );
							}
								
							if ( $.isFunction( $.fn.skinEmbedSupport ) && 0 < $( '.popout-holder' ).find( 'iframe' ).length ) {
								$( '.popout-holder' ).find( 'iframe' ).skinEmbedSupport();
							
								if ( $.isFunction( $.fn.skinAdjustEmbedRatio ) ) {
									$( '.popout-holder iframe.skin-embed' ).skinAdjustEmbedRatio();
								}
							}
							
							if ( $.isFunction( $.fn.skinIconFill2Background ) && 0 < $( '.popout-wrapper' ).find( '.social-icon' ).length ) {
								$( '.popout-wrapper' ).find( '.social-icon' ).addClass( 'self-bouncer' ).skinIconFill2Background();
							}
							
							if ( $.isFunction( $.fn.skinRenderGoogleMap ) && 0 < $( '.popout-wrapper' ).find( '.skin-map-holder' ).length ) {
								$( '.skin-map-holder' ).skinRenderGoogleMap();
							}
							
							if ( $.isFunction( $.fn.skinDrawBttnOutline ) && 0 < $( '.popout-wrapper' ).find( '.skin-outlined-bttn' ).length ) {
								var bttn = $( '.popout-wrapper' ).find( '.skin-outlined-bttn' );
								
								if( bttn.hasClass( 'skin-anim-bttn' ) ) {
									$.when( bttn.skinAnimBttn() ).then( bttn.skinDrawBttnOutline() );
									
								} else {
									bttn.skinDrawBttnOutline();
								}
							}
						}
						
						function setPopout() {
							$( 'body' ).find( '.popout-holder-overlay' ).addClass( 'reveal' );
							$( '.popout-holder' ).addClass( 'reveal' ).find( '.popout-wrapper' ).addClass( 'reveal' );
							$( '.popout-holder' ).find( '.close-popout' ).addClass( 'reveal' );
						}
						
						$.when( adjustPopoutItems() ).then( setPopout() );
						
					// Close the lightbox on close button
						$( '.popout-holder' ).on( 'click', '.close-popout', function(e) {
							$.when( removePopout() ).then( removeOverlay() );
						});
				
					// Close the lightbox on esc
						$(document).keyup( function(e) {
							if ( 27 === e.keyCode ) {
								$.when( removePopout() ).then( removeOverlay() );
							}
						});
						
					// Close the lightbox by clicking outside of it
						$(document).on( 'click', function(e) {
							if ( 0 === $(e.target).closest( '.popout-holder' ).length ) {
								$.when( removePopout() ).then( removeOverlay() );
							}
						});
					});
				}
				
				$.when( buildClone() ).then( buildPopout() );
			});
		});
	}
	
// Helper function to remove the popout
	function removePopout() {
		$( '.popout-wrapper' ).removeClass( 'reveal' );		
		$( '.popout-holder' ).removeClass( 'reveal' ).find( '.close-popout' ).removeClass( 'reveal' );
	}
	
	function removeOverlay() {
		$( '.popout-holder-overlay' ).remove();
		$( 'html, body' ).removeClass( 'popout-active' );
	}
		
	jQuery( document ).ready( function($) {
		var popoutLink = $( '.menu-item-object-popout a, a.popout-page' );
			
		$(document).on( 'click', '.menu-item-object-popout a, a.popout-page', function(e) {
			e.preventDefault();
		});
		
		popoutLink.each( function() {
			$(this).on( "click auxclick contextmenu", function(e) {
				e.preventDefault();
					
				if ( 1 === e.which ) {
					$(this).skinPopout();
				}
				
				return false;
			});
		});
	});
});