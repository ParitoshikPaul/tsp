/* ==============================================
	POSTS SLIDER scripts
	Skin - Premium WordPress Theme, by NordWood
================================================= */
jQuery( document ).ready( function($) {
	"use strict";
	
	if ( 0 < $( '.skin-posts-slider' ).length ) {
		var container		= $( '.skin-posts-slider' ),
			auto			= ( 'auto' === container.attr( 'data-autoplay' ) ) ? 6000 : '',
			images			= container.find( '.slider-images' ),
			content			= container.find( '.slider-content' ),
			navWheelHref	= container.find( '.nav-wheel a' ),
			timer,
			timerReachEnd,
			j,
			i;
			
		var imagesSlider = new Swiper( images, {
			slidesPerView: 1,
			spaceBetween: 0,
			centeredSlides: false,
			preloadImages: false,
			lazyLoading: true,
			freeModeSticky: true,
			slideToClickedSlide: true,
			onInit: function() {
				var imgs = images.find( '.swiper-slide' );
				
				imgs.each( function(i) {
					timer = setTimeout( function() {
						$( imgs[i] ).addClass( 'show' );
					
						if ( i === imgs.length - 1  ) {
							clearTimeout( timer );
						}						
					}, 120*i );
				});
			}
		});
			
		var contentSlider = new Swiper( content, {
			autoplay: auto,
			autoplayDisableOnInteraction: true,
			slidesPerView: 1,
			effect: 'fade',
			fade: {
				crossFade: true
			},
			nextButton: content.find('.next'),
			prevButton: content.find('.prev'),
			onInit: function() {
				container.addClass( 'start' );
				content.addClass( 'start' );
			}
		});
		
		contentSlider.params.control = imagesSlider;
		imagesSlider.params.control = contentSlider;
		
	/*
		Add the post link attributes to the nav wheel of the first slide and
		to the first image		
	*/
		var postLink = $( contentSlider.slides[0] ).find( '.post-link' ).attr( 'href' ),
			postTarget = $( contentSlider.slides[0] ).find( '.post-link' ).attr( 'target' );
		
		navWheelHref.attr( 'href', postLink );
		navWheelHref.attr( 'target', postTarget );
		$( imagesSlider.slides[0] ).children( 'a' ).attr( 'href', postLink ).attr( 'target', postTarget );
		
	/*
		Dynamically change the post link attributes as slides change
		Remove the classes that are related to slider init
	*/
		contentSlider.on( 'slideChangeStart', function() {
		// Get the current slide and its content
			i = contentSlider.realIndex;
			
			content.removeClass( 'start' );
			images.find( '.swiper-slide' ).removeClass( 'start' ).removeClass( 'show' );
			content.find( '.post-wrapper' ).removeClass( 'show' );
		});
		
		contentSlider.on( 'slideChangeEnd', function() {
		// Get the current slide and its content
			i = contentSlider.realIndex;
			
			postLink = $( contentSlider.slides[i] ).find( '.post-link' ).attr( 'href' );
			postTarget = $( contentSlider.slides[i] ).find( '.post-link' ).attr( 'target' );
			
			navWheelHref.attr( 'href', postLink );
			navWheelHref.attr( 'target', postTarget );			
			$( contentSlider.slides[i] ).find( '.post-wrapper' ).addClass( 'show' );
			images.find( 'a' ).attr( 'href', '#' ).attr( 'target', '_self' );
			$( imagesSlider.slides[i] ).children( 'a' ).attr( 'href', postLink ).attr( 'target', postTarget );
		});
		
		contentSlider.on( 'onReachEnd', function() {
			if ( true === contentSlider.autoplaying ) {
				var timerReachEnd = setTimeout( function() {
					images.find( '.post-image' ).addClass( 'dot' );
				}, auto);
				
			} else {
				clearTimeout( timerReachEnd );
			}
		});
		
		contentSlider.on( 'onReachBeginning', function() {
			images.find( '.post-image' ).removeClass( 'dot' );
			clearTimeout( timerReachEnd );
		});
		
		contentSlider.on( 'click', function() {
			contentSlider.stopAutoplay();
		});
		
		contentSlider.on( 'onTouchStart', function() {
			contentSlider.stopAutoplay();
		});
		
		imagesSlider.on( 'click', function() {
			contentSlider.stopAutoplay();
		});
		
		imagesSlider.on( 'onTouchStart', function() {
			contentSlider.stopAutoplay();
		});
	}
});