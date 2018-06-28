/* ===============================================
	CUSTOMIZER PREVIEW
	Skin - Premium WordPress Theme, by NordWood
================================================== */
(function($) {
	"use strict";
	$(document).ready( function() {
	// Convert HEX color value to RGBA
		function skin_hex2rgba(hex,op){
			var c;
			
			if ( /^#([A-Fa-f0-9]{3}){1,2}$/.test(hex) ) {
				c = hex.substring(1).split('');
				
				if ( 3 == c.length ) {
					c= [c[0], c[0], c[1], c[1], c[2], c[2]];
				}
				
				c = '0x' + c.join('');
				
				return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+','+op+')';
			}
			
			throw new Error('Bad Hex');
		}
		
	// Body background
		wp.customize( 'background_color', function(value) {
			value.bind( function(v) {
				if ( v ) {
					$('body, .body-bgr').css({ "background-color":v });
					
					$('.body-bgr-to-border').css({ "border-color":v });
				}
			});
		});
		
	// Pattern for site background
		wp.customize( 'skin_bgr_pattern', function(value) {
			value.bind( function(v) {
				if ( v ) {
					$('.body-pattern').css({ "background-image":"url('" + v + "')" });
				}
			});
		});
		
	// Opacity for the pattern in site background
		wp.customize( 'skin_bgr_pattern_opacity', function(value) {
			value.bind( function(v) {
				if ( v ) {
					$('.body-pattern').css({ "opacity":0.01*v });
				}
			});
		});
		
	// Content pad background
		wp.customize( 'skin_content_pad', function(value) {
			value.bind( function(v) {
				if ( v ) {
					$('.content-pad').css({ "background-color":v });
					
					$('.content-pad-to-border').css({ "border-color":v });
					
					$('.content-pad-to-svg').css({ "fill":v });
				}
			});
		});
	
	// Main text color
		wp.customize( 'skin_main_txt_color', function(value) {
			value.bind( function(v) {
				if ( v ) {
					var v_shade = skin_hex2rgba(v,0.4),
						v_light = skin_hex2rgba(v,0.2),
						v_pale = skin_hex2rgba(v,0.05);
					
					$( 'body' ).css({ "color":v });					
					$( '.txt-color-to-svg .svg-fill, #site-footer .social-icon .svg-fill' ).css({ "fill":v });
					$( '.txt-color-to-svg .svg-stroke, #site-footer .social-icon .svg-stroke' ).css({ "stroke":v });
					
					$( '.txt-color-to-bgr' ).css({ "background-color":v });
					
					$( '.post-details' ).css({ "color":v_shade });					
					$( '.txt-color-light-to-border, #site-footer .social-icon' ).css({ "border-color":v_light });					
					$( '.txt-color-light-to-svg .svg-fill' ).css({ "fill":v_light });
					
					$( '.txt-color-pale-to-svg .svg-fill' ).css({ "fill":v_pale });
				}
			});
		});
	
	// Link color on hover - Main
		wp.customize( 'skin_main_txt_color_hover', function(value) {
			value.bind( function(v) {
				if ( v ) {
					$( '.mask-txt, .masked-txt, .post-content > p a:hover, .post-content > ul li a:hover' ).css({ "color":v });
				}
			});
		});
		
	// Gradient colors
		wp.customize( 'skin_gradient_color_1', function(value) {
			value.bind( function(v) {
				if ( v ) {
					var g2 = $('#skin-data').attr( 'data-gradient-2' );
					
					$( '.gradient-bgr' ).css({ "background":"linear-gradient( 125deg, "+v+" 0%, "+g2+" 100% )" });
					$( '.gradient-bgr-vert' ).css({ "background":"linear-gradient( to bottom, "+v+" 0%, "+g2+" 100% )" });
					$( '#skin-data' ).attr( 'data-gradient-1', v );
				}
			});
		});
		
		wp.customize( 'skin_gradient_color_2', function(value) {
			value.bind( function(v) {
				if ( v ) {
					var g1 = $('#skin-data').attr( 'data-gradient-1' );
					
					$( '.gradient-bgr' ).css({ "background":"linear-gradient( 125deg, "+g1+" 0%, "+v+" 100% )" });
					$( '.gradient-bgr-vert' ).css({ "background":"linear-gradient( to bottom, "+g1+" 0%, "+v+" 100% )" });
					$( '#skin-data' ).attr( 'data-gradient-2', v );
				}
			});
		});
		
	// Pattern over the top area
		wp.customize( 'skin_top_pattern', function(value) {
			value.bind( function(v) {
				if ( v ) {
					$( '.site-header-bgr .pattern' ).css({ "background-image":"url('" + v + "')" });
					
				} else {
					$( '.site-header-bgr .pattern' ).css({ "background-image":"none" });
				}
			});
		});
		
	// Opacity for the pattern over the top area
		wp.customize( 'skin_top_pattern_opacity', function(value) {
			value.bind( function(v) {
				if ( v ) {
					$( '.site-header-bgr .pattern' ).css({ "opacity":0.02*v });
				}
			});
		});
		
	// Height of gradient bgr at the top
		wp.customize( 'skin_top_gradient_height', function(value) {
			value.bind( function(v) {
				$( '.site-header-bgr' ).height( v );
			});
		});
	
	// Color of text on gradient background
		wp.customize( 'skin_txt_on_gradient_color', function(value) {
			value.bind( function(v) {
				if ( v ) {
					var v_shade = skin_hex2rgba(v,0.4),
						v_light = skin_hex2rgba(v,0.2),
						v_pale = skin_hex2rgba(v,0.05);
					
					$('.txt-on-gradient').css({ "color":v });
					$('.txt-on-gradient .txt-color-to-svg .svg-fill, #site-footer .txt-on-gradient .social-icon .svg-fill').css({ "fill":v });
					$('.txt-on-gradient .txt-color-to-svg .svg-stroke, #site-footer .txt-on-gradient .social-icon .svg-stroke').css({ "stroke":v });					
					$('.txt-on-gradient .txt-color-to-bgr').css({ "background-color":v });
					
					$('.txt-on-gradient .post-details').css({ "color":v_shade });					
					$('.txt-on-gradient .txt-color-light-to-border, #site-footer .txt-on-gradient .social-icon').css({ "border-color":v_light });					
					$('.txt-on-gradient .txt-color-light-to-svg .svg-fill').css({ "fill":v_light });					
					$('.txt-on-gradient .txt-color-pale-to-svg .svg-fill').css({ "fill":v_pale });
				}
			});
		});
	
	// Link color on hover, over gradient background
		wp.customize( 'skin_txt_on_gradient_color_hover', function(value) {
			value.bind( function(v) {
				if ( v ) {
					$('.txt-on-gradient .mask-txt, .txt-on-gradient .masked-txt').css({ "color":v });
				}
			});
		});
		
	// Change bgr on special boxes
		wp.customize( 'skin_specials_popout_bgr', function(value) {;
			value.bind( function(v) {
				if ( 'content-pad' === v ) {
					$( '.masonry-item .skin-widget-pop' ).removeClass( 'gradient-bgr' ).removeClass( 'txt-on-gradient' ).addClass( 'content-pad' );
					
				} else if ( 'gradient-bgr' === v ) {
					$( '.masonry-item .skin-widget-pop' ).addClass( 'gradient-bgr' ).addClass( 'txt-on-gradient' );
					
				} else {
					$( '.masonry-item .skin-widget-pop' ).removeClass( 'gradient-bgr' ).removeClass( 'txt-on-gradient' ).removeClass( 'content-pad' );					
				}
			});
		});
		
		wp.customize( 'skin_specials_social_bgr', function(value) {;
			value.bind( function(v) {
				if ( 'content-pad' === v ) {
					$( '.masonry-item .skin-widget-social-profiles' ).removeClass( 'gradient-bgr' ).removeClass( 'txt-on-gradient' ).addClass( 'content-pad' );
					
				} else if ( 'gradient-bgr' === v ) {
					$( '.masonry-item .skin-widget-social-profiles' ).addClass( 'gradient-bgr' ).addClass( 'txt-on-gradient' );
					
				} else {
					$( '.masonry-item .skin-widget-social-profiles' ).removeClass( 'gradient-bgr' ).removeClass( 'txt-on-gradient' ).removeClass( 'content-pad' );					
				}
			});
		});
		
		wp.customize( 'skin_specials_topposts_bgr', function(value) {;
			value.bind( function(v) {
				if ( 'content-pad' === v ) {
					$( '.masonry-item .skin-widget-top-posts' ).removeClass( 'gradient-bgr' ).removeClass( 'txt-on-gradient' ).addClass( 'content-pad' );
					
				} else if ( 'gradient-bgr' === v ) {
					$( '.masonry-item .skin-widget-top-posts' ).addClass( 'gradient-bgr' ).addClass( 'txt-on-gradient' );
					
				} else {
					$( '.masonry-item .skin-widget-top-posts' ).removeClass( 'gradient-bgr' ).removeClass( 'txt-on-gradient' ).removeClass( 'content-pad' );					
				}
			});
		});
		
	// Color of top bar background
		wp.customize( 'skin_top_bar_bgr', function(value) {
			value.bind( function(v) {
				if ( v ) {
					var v_light = skin_hex2rgba( v, 0.3 );
					
					$('.top-bar.desktop .main-menu .sub-menu a:before, .top-bar-bgr').css({ "background-color":v });					
					$('.top-bar.desktop .main-menu .sub-menu a:hover, .top-bar-bgr-to-color').css({ "color":v });					
					$('.top-bar-bgr-to-svg .svg-fill').css({ "fill":v });					
					$('.top-bar-bgr-light-to-color').css({ "color":v_light });					
					$('.top-bar-bgr-light-to-border').css({ "border-color":v_light });					
					$('.top-bar-bgr-light').css({ "background-color":v_light });					
					$('.top-bar-bgr-light-to-svg .svg-fill').css({ "fill":v_light });
				}
			});
		});
	
	// Color of top bar content
		wp.customize( 'skin_top_bar_txt_color', function(value) {
			value.bind( function(v) {
				if ( v ) {
					var v_light = skin_hex2rgba( v, 0.5 ),
						v_pale = skin_hex2rgba( v, 0.2 );
					
					$('.top-bar-color').css({ "color":v });					
					$('.top-bar-color-to-bgr').css({ "background-color":v });					
					$('.top-bar-color-to-svg .svg-fill').css({ "fill":v });					
					$('.top-bar-color-to-svg .svg-stroke').css({ "stroke":v });					
					$('.top-bar.desktop .main-menu > ul > li > a > .description').css({ "color":v_light });					
					$('.top-bar-color-pale-to-border').css({ "border-color":v_pale });
					$('.top-bar-color-pale-to-svg .svg-stroke').css({ "stroke":v_pale });
				}
			});
		});
	
	// Background color for reading progress
		wp.customize( 'skin_colors_reading_progress', function(value) {
			value.bind( function(v) {
				if ( v ) {
					$('.top-holder-single .progress, .top-holder-single + .progress').css({ "background-color":v });			
				}
			});
		});
	
	// Color of small item background
		wp.customize( 'skin_small_item_bgr', function(value) {
			value.bind( function(v) {
				if ( v ) {
					var v_light = skin_hex2rgba( v, 0.5 );
					
					$('.small-item-bgr, .widget_calendar tbody td a:before').css({ "background-color":v });					
					$('.widget_calendar tbody td#today, .woocommerce .star-rating:before, .woocommerce .star-rating span:before').css({ "color":v });					
					$('.small-item-bgr-to-svg .svg-fill').css({ "fill":v });					
					$('.small-item-bgr-light').css({ "background-color":v_light });
				}
			});
		});
	
	// Color of small item content
		wp.customize( 'skin_colors_small_item_content', function(value) {
			value.bind( function(v) {
				if ( v ) {
					$('.small-item-color').css({ "color":v });					
					$('.small-item-color .svg-fill').css({ "fill":v });
				}
			});
		});
		
	// Sticky banner height
		wp.customize( 'skin_sticky_banner_height', function(value) {
			value.bind( function(v) {
				if ( v ) {
					$( '.sticky-banner img' ).css({ "height":v });					
				}
			});
		});
		
	// Sticky banner position
		wp.customize( 'skin_sticky_banner_position', function(value) {
			value.bind( function(v) {
				if ( 'bottom-right' === v ) {
					$( '.sticky-banner' ).css({ "right":"7px", "left":"auto" });					
				}
				
				if ( 'bottom-left' === v ) {
					$( '.sticky-banner' ).css({ "left":"7px", "right":"auto" });
				}
			});
		});
		
	// "Scroll to top" button
		wp.customize( 'skin_show_scroll_to_top', function(value) {
			value.bind( function(v) {
				if ( true === v ) {
					$( '#to-top' ).fadeIn();
					
				} else {
					$( '#to-top' ).fadeOut();
				}
			});
		});
		
	// "Scroll to top" position
		wp.customize( 'skin_scroll_to_top_position', function(value) {
			value.bind( function(v) {
				if ( 'bottom-right' === v ) {
					$( '#to-top' ).css({ "right":"30px", "left":"auto" });
				}
				
				if ( 'bottom-left' === v ) {
					$( '#to-top' ).css({ "left":"30px", "right":"auto" });
				}
			});
		});
		
	// Toggle drop caps
		wp.customize( 'skin_drop_caps', function(value) {;
			value.bind( function(v) {
				if ( v ) {
					$( '.single #main > article.post' ).addClass( 'drop-caps' );
					
				} else {
					$( '.single #main > article.post' ).removeClass( 'drop-caps' );
				}				
			});
		});
		
	// Enlarge media
		wp.customize( 'skin_enlarge_media', function(value) {;
			value.bind( function(v) {
				if ( v ) {
					$( ".post-content iframe.skin-embed" ).skin_enlarge_media();
					
				} else {
					$( ".post-content iframe.skin-embed" ).skin_wrap_media();
				}				
			});
		});
		
	// Search placeholder
		wp.customize( 'skin_search_placeholder', function(value) {
			value.bind( function(v) {
				if ( v ) {
					$( '.search-field' ).attr( 'placeholder', v );
				}
			});
		});
		
	// Page 404
		wp.customize( 'skin_404_back_button', function(value) {
			value.bind( function(v) {
				if ( !v ) {
					$( '.error404 .text' ).closest( '.link-button' ).hide();
					
				} else {
					$( '.error404 .text' ).closest( '.link-button' ).show();
				}
			});
		});		
	});
})(jQuery);