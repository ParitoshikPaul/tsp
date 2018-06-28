/* ==============================================
	SCRIPTS FOR POPULAR/LATEST POSTS
	Skin - Premium WordPress Theme, by NordWood
================================================= */
jQuery( function($){
    "use strict";
	
	var txtDirection = mainLoc.direction;
	
	$.fn.skinTopPostsSlider = function() {
		$(this).each( function() {
			var container	= $(this),
				tabs		= container.find( '.tabs' ),
				slidesList	= container.find( '.top-posts-slides' ),
				slide		= container.find( '.top-posts-slide' ),
				shrinker_clr;
				
			if ( container.hasClass( 'gradient-bgr' ) ) {
				shrinker_clr = 'trans-border';
				
			} else if ( container.hasClass( 'content-pad' ) ) {
				shrinker_clr = 'content-pad-to-border';
				
			} else {
				shrinker_clr = 'body-bgr-to-border';
			}
			
			container.find( '.shrinker' ).addClass( shrinker_clr );
			
			var slideWidth = container.width(),
				slidesListWidth = 2*slideWidth;
				
			slidesList.css({ "width":slidesListWidth });
			slide.width( slideWidth );
				
			$(window).on( 'resize', function() {
				slideWidth = container.width();
				slidesListWidth = 2*slideWidth;
				
				slidesList.css({ "width":slidesListWidth });
				slide.width( slideWidth );
			});
		
		//	Sliding		
			function showLatest() {
				tabs.find( '.popular' ).removeClass( 'active' );
				tabs.find( '.latest' ).addClass( 'active' );
				
				if ( 'rtl' === txtDirection ) {
					slidesList.animate({
						"margin-right": -slideWidth
					}, 300);
					
					
				} else {
					slidesList.animate({
						"margin-left": -slideWidth
					}, 300);
				}
			}
			
			function showPopular() {
				tabs.find( '.latest' ).removeClass( 'active' );
				tabs.find( '.popular' ).addClass( 'active' );
				
				if ( 'rtl' === txtDirection ) {
					slidesList.animate({
						"margin-right": 0
					}, 300);
					
					
				} else {
					slidesList.animate({
						"margin-left": 0
					}, 300);
				}
			}
			
			tabs.on( 'click', '.latest', function(e) {
				showLatest();
			});
				
			tabs.on( 'click', '.popular', function(e) {
				showPopular();
			});
		
		//	Autoplay
			var autoPlay = slidesList.attr( 'data-auto' ),
				slidesTiming;
				
			function autoRevealSlides() {
				showPopular();
				slidesTiming = setTimeout( showLatest, 8000 );
				slidesTiming = setTimeout( autoRevealSlides, 16000 );
			}
			
			if ( 'autoplay' === autoPlay ) {
				autoRevealSlides();
					
			// Pause auto sliding on hover, resume on mouse leave and stop permanently on mouse interaction		
				var clicked = 0;
				
				container.on( 'mouseenter', function() {
					clearTimeout( slidesTiming );
					
				}).on( 'mousedown', function() {
					clicked++;
					
				}).on( 'mouseleave', function() {
					if ( 0 === clicked ) {
						autoRevealSlides();
					}
				});
			}
		});
	}
	
	$( '.skin-widget-top-posts' ).skinTopPostsSlider();
});