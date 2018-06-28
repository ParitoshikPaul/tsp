/* ==============================================
	MAIN SCRIPTS
	Skin - Premium WordPress Theme, by NordWood
================================================= */
/*	TABLE OF CONTENTS
======================= */
/*
	1.0 CONTROL COLOR STYLES AND EFFECTS FOR PARTICULAR ELEMENTS
	1.1 Content color in site header if it has gradient background
	1.2 Color and effect related classes for some items
	1.3 Set the background color for svg icons, based on their fill/stroke attribute
	1.4 Apply special rules for social icons in site footer
	1.5 Add animated outline effect and enable on-hover animation for particular items
	1.6 Add loading animation to particular items
	1.7 Add bounce-on-hover effect to particular items
	
	2.0 CONTROL LAYOUT STYLES ON PARTICULAR ELEMENTS
	2.1 List display in some default WP widgets
	2.2 Quantity display in some Categories and Archives widgets
	2.3 Pagination styles
	2.4 Blockquote styles
	2.5 Site footer position
	2.6 Assign data attribute to each cell for responsive tables
	
	3.0 CONTROL THE SIZE OF PARTICULAR ELEMENTS
	3.1 Cut string per lines limit
	3.2 Spread item to max width, related to available space in parent holder
	3.3 Add skin-embed class to all the embed-supported media
	3.4 Resize content item that should be wider than the content wrapper
	3.5 Resize element height per given ratio
	3.6 Resize element height to same value as its width
	3.7 Resize embedded media to its original proportion
	3.8 Set content item width to wrapper width
	3.9 Find featured image box and resize it per img ratio

	4.0 SLIDERS
	4.1 Gallery slider
	4.2 Related posts
	4.3 Instagram carousel in main sidebar
	4.4 Instagram carousel in footer and other sidebar areas
	
	5.0 TOP BAR
	5.1 Quick Search overlay
	5.2 Overlay menu for mobiles
	5.3 Control social links in desktop top bar
	5.4 Adjust main menu items alignment
	5.5 Control main menu dropdown
	5.6 Control main menu hover effect (on top level)
	
	6.0 TOP BAR SWITCH ON SINGLE POSTS
	6.1 Maximize the reading progress wrapper
	6.2 Control related posts in top bar switch
	6.3 Control the share buttons in top bar switch
	6.4 Switch top bar on menu button click
	
	7.0 WINDOW SCROLL
	7.1 Smooth scroll
	7.2 Control the top bar appearance and the reading progress
	7.3 Scroll to top
	
	8.0 STICKY BANNER
	8.1 Close sticky banner
	
	9.0 GOOGLE MAP
	9.1 Render map
	
	10.0 ON WINDOW RESIZE	
*/
jQuery( function($) {
    "use strict";
	
	var txtDirection = mainLoc.direction;

/*	1.0 CONTROL COLOR STYLES FOR PARTICULAR ELEMENTS
====================================================== */
/* 1.1 Content color in site header if it has gradient background */
	var adjustTopGradient = function() {
		var topGradient = $( '.site-header-bgr .gradient-bgr' );	
		
		if ( 0 < $( '.site-header-bgr .gradient-bgr' ).length ) {
			var topGradientEndsAt = topGradient.position().top + topGradient.offset().top + topGradient.outerHeight();
			
			var welcomeMessage	= $( '.welcome-mssg' ),
				postsSlider		= $( '.skin-posts-slider' ),
				topBarTop		= $( '.top-bar.desktop' ).find( '.top' ),
				noBgrItems		= $( '.no-bgr' );
			
			if ( 0 < noBgrItems.length ) {
				if ( noBgrItems.position().top < topGradientEndsAt ) {
					noBgrItems.addClass( 'txt-on-gradient' );
					
				} else {
					noBgrItems.removeClass( 'txt-on-gradient' );
				}
			}
			
			if ( 0 < topBarTop.length ) {
				if ( topBarTop.position().top < topGradientEndsAt ) {
					topBarTop.addClass( 'txt-on-gradient' );
					
				} else {
					topBarTop.removeClass( 'txt-on-gradient' );
				}
			}
			
			if ( 0 < welcomeMessage.length ) {
				if ( welcomeMessage.position().top < topGradientEndsAt ) {
					welcomeMessage.addClass( 'txt-on-gradient' );
					
				} else {
					welcomeMessage.removeClass( 'txt-on-gradient' );
				}
			}
			
			if ( 0 < postsSlider.length ) {
				if ( postsSlider.find( '.post-title' ).offset().top + postsSlider.find( '.post-title' ).outerHeight() < topGradientEndsAt ) {
					postsSlider.find( '.post-title' ).addClass( 'txt-on-gradient' );
					postsSlider.find( '.details' ).addClass( 'txt-on-gradient' );
					
				} else {
					postsSlider.find( '.post-title' ).removeClass( 'txt-on-gradient' );
					postsSlider.find( '.details' ).removeClass( 'txt-on-gradient' );
				}
			}
		}
	}
	
	adjustTopGradient();
	
/* 1.2 Color and effect related classes for some items */
	$( '.wp-comments .page-numbers, .wp-comments .comment-respond, .posts-list-pagination ul.page-numbers a, select' ).addClass( 'content-pad' );
	
	$( '.widget_calendar table thead, .widget_calendar table tbody, .widget_tag_cloud a, input, select, textarea' ).addClass( 'txt-color-light-to-border' );
	
	$( '.wp-comments .page-numbers.current, .posts-list-pagination ul.page-numbers .page-numbers.current, .post-content .post-pagination .pages > .link-button' ).addClass( 'small-item-bgr' );
	
	$( '.wp-comments .page-numbers.current, .posts-list-pagination ul.page-numbers .page-numbers.current, .post-content .post-pagination .pages > .link-button' ).addClass( 'small-item-color' );
	
	$( '.top-bar.desktop .main-menu .sub-menu' ).addClass( 'top-bar-color-to-bgr' ).addClass( 'top-bar-bgr-medium-to-color' );
	
	$( '.top-bar.desktop .top-menu a' ).addClass( 'link-hov-main' );
	
	$( '.overlay-menu.mobile .main-menu > ul > li' ).addClass( 'top-bar-bgr-light-to-border' );
	
	$( '.post-pagination .pages a .link-button' ).addClass( 'skin-outlined-bttn' );
	
	$( '.wp-comments .comments-nav .prev, .wp-comments .comments-nav .next' ).addClass( 'va-middle' ).addClass( 'hover-trigger' );
	
/* 1.3 Set the background color for svg icons, based on their fill/stroke attribute */
	$.fn.skinIconFill2Background = function() {
		$(this).each( function() {	
			var fill 	= $(this).find( '.svg-fill' ),
				stroke 	= $(this).find( '.svg-stroke' );
				
			if ( 0 < fill.length ) {
				$(this).css({ 'background-color':fill.attr('fill') });
				
			} else if ( 0 < stroke.length ) {
				$(this).css({ 'background-color':stroke.attr('stroke') });
			}
		});
	}
	
	$( '#main-wrapper .social-icon' ).skinIconFill2Background();
	$( '.top-bar.desktop .social-icon' ).skinIconFill2Background();
	$( '.overlay-menu.mobile .social-icon' ).skinIconFill2Background();

/* 1.4 Apply special rules for social icons in site footer */
	$( '#site-footer .social-icon' ).each( function() {
		var fill 	= $(this).find( '.svg-fill' ),
			stroke 	= $(this).find( '.svg-stroke' );
				
		$(this).on( 'mouseenter', function() {
			if ( 0 < fill.length ) {
				$(this).css({ 'background-color':fill.attr('fill'), 'border-width':0 });
				
			} else if ( 0 < stroke.length ) {
				$(this).css({ 'background-color':stroke.attr('stroke'), 'border-width':0 });
			}
			
		}).on( 'mouseleave', function() {				
			if ( 0 < fill.length ) {
				$(this).css({ 'background-color':'transparent', 'border-width':'1px' });
				
			} else if ( 0 < stroke.length ) {
				$(this).css({ 'background-color':'transparent', 'border-width':'1px' });
			}
		});
	});
	
/* 1.5 Add animated outline effect and enable on-hover animation for particular items */
	$.fn.skinAnimBttn = function() {
		$(this).each( function() {
			var bttn = $(this);
				
			bttn.wrapInner( '<span class="txt"></span>' );
			
			if ( 'rtl' === txtDirection ) {
				bttn.append( '<span class="line-holder"><span class="line txt-color-to-bgr"></span></span>' );
				
			} else {
				bttn.prepend( '<span class="line-holder"><span class="line txt-color-to-bgr"></span></span>' );
			}
			bttn.wrapInner( '<span class="inner"></span>' );
		});
	}
	
/* Add svg outline */
	$.fn.skinDrawBttnOutline = function() {
		$(this).each( function() {
			var item = $(this),
				svgBorder,
				svgOutline,
				path,
				pathLength,
				timer;
				
			var itemW = item.outerWidth(),
				itemH = item.outerHeight(),
				hor = itemW - 10,
				ver = itemH - 10;
				
			path = 'M5,0 l' + hor + ',0 a5,5 0 0 1 5,5 l0,' + ver + 'a5,5 0 0 1 -5,5 l' + -hor + ',0 a5,5 0 0 1 -5,-5 l0,' + -ver + 'a5,5 0 0 1 5,-5';
				
			svgBorder = '<svg class="svg-border txt-color-light-to-svg" width="' + itemW + '" height="' + itemH + '" style="width:' + itemW + 'px; height:' + itemH + 'px;"><path class="svg-stroke" stroke-width="2" fill="none" d="' + path + '" /></svg>';
				
			svgOutline = '<svg class="svg-outline txt-color-to-svg" width="' + itemW + '" height="' + itemH + '" style="width:' + itemW + 'px; height:' + itemH + 'px;"><path class="svg-stroke" stroke-width="2" fill="none" d="' + path + '" /></svg>';
			
			item.append( svgBorder ).append( svgOutline );
			
			pathLength = item.find( 'path' ).get(0).getTotalLength();
			
			item.find( '.svg-outline path' ).attr( 'stroke-dasharray', pathLength ).attr( 'stroke-dashoffset', pathLength );
			
			item.on( 'mouseenter', function(e) {
				clearTimeout( timer );
				
				timer = setTimeout( function() {
					item.find( '.svg-outline path' ).animate({
						'stroke-dashoffset': 0
						
					}, 300, 'swing' );
					
				}, 100 );
				
			}).on( "mouseleave", function() {
				clearTimeout( timer );
				
				timer = setTimeout( function() {
					item.find( '.svg-outline path' ).animate({
						'stroke-dashoffset': item.find( '.svg-outline path' ).attr( 'stroke-dashoffset' )
						
					}, 200, 'swing' );
					
				}, 100 );
			});			
		});
	}
	
	if ( 0 < $( '.skin-outlined-bttn' ).length ) {
		var bttn = $( '.skin-outlined-bttn' );
		
		if ( bttn.hasClass( 'skin-anim-bttn' ) ) {
			$.when( bttn.skinAnimBttn() ).then( bttn.skinDrawBttnOutline() );
			
		} else {
			bttn.skinDrawBttnOutline();
		}
	}
	
	$( '.rounded-button-outline' ).each( function() {
		var bttn = $(this),
			timer;
	
		bttn.on( 'mouseenter', function(e) {
			clearTimeout( timer );
			
			timer = setTimeout( function() {
				bttn.removeClass( 'out' ).addClass( 'in' );
				
			}, 200 );
			
		}).on( "mouseleave", function() {
			clearTimeout( timer );
			
			timer = setTimeout( function() {
				bttn.removeClass( 'in' ).addClass( 'out' );
				
			}, 400 );
		});
	});
	
/* 1.6 Add loading animation to particular items */
	$.fn.skinLoadingItem = function() {
		$(this).each( function(i, el) {
			var worker = $(el).find( '.worker' ),
				loader = $(el).find( '.content-loading' ),
				timer;
				
			if ( 1 > worker.length ) {
				worker = $(el).find( 'iframe' );
			}
		
			worker.promise().done( function() {
				clearTimeout( timer );
					
				timer = setTimeout( function() {
					$.when( loader.addClass( 'done' ) ).then( function() {
						loader.fadeOut();
						$(el).removeClass( 'promised' );
					});
				}, 1000 );			
			});
		});
	}
	
	$( '.loading-holder' ).skinLoadingItem();
	
/* 1.7 Add bounce-on-hover effect to particular items */
	$( '.overlay-menu .social-profiles, .skin-shortcodes.social-profiles, .skin-shortcodes.share, .share-details .share, .post-footer .share, .skin-widget-social-profiles' ).find( '.social-icon' ).each( function() {
		$(this).addClass( 'self-bouncer' );
	});
	
	$( '.top-bar' ).find( '.social-icon' ).each( function() {
		$(this).addClass( 'self-shifter' );
	});
	
/*	2.0 CONTROL LAYOUT STYLES ON PARTICULAR ELEMENTS
======================================================= */
/* 2.1 List display in some default WP widgets */
	$( '.widget_categories li, .widget_archive li, .widget_pages li, .widget_meta li, .widget_recent_comments li, .widget_recent_entries li, .widget_rss li, .widget_nav_menu li' ).each( function(i, v) {		
		$(v).find('a').wrapInner( '<h5></h5>' );
	});
	
/* 2.2 Quantity display in some Categories and Archives widgets */
	$('.widget_categories li, .widget_archive li').each( function(i, v) {
		$(v).contents().eq(1).wrap('<span class="qty va-middle"/>');
		
		$(v).find('.qty').text( $(v).find('.qty').text().replace('(', '') );
		$(v).find('.qty').text( $(v).find('.qty').text().replace(')', '') );
		
		$(v).find('.qty').wrapInner( '<h5></h5>' );
	});
	
/* 2.3 Pagination styles */
	$('.posts-list-pagination' ).find( 'a' ).addClass( 'va-middle' );	
	$('.posts-list-pagination .pages').children( '.page-numbers' ).addClass( 'clearfix' ).find( 'li' ).addClass( 'va-middle' );
	
/* 2.4 Blockquote styles */
	var quote = '<span class="quote-mark txt-color-light-to-svg">'+mainLoc.quoteSVG+'</span>';
	
	$( 'blockquote' ).each( function() {
		$(this).addClass( 'clearfix' );
		$(this).wrapInner( '<span class="quotation"></span>' );
		$(this).prepend( quote );
	});
	
/* 2.5 Site footer position */
	if ( 0 < $( '#site-footer' ).length ) {
		var minH = window.innerHeight - $( '#site-footer' ).outerHeight() - 300;
		$( '#main-wrapper' ).css({ "min-height":minH });
	}
	
/* 2.6 Assign data attribute to each cell for responsive tables */
	$( '.post-content table' ).each( function() {
		var table = $(this),
			thead = table.find( 'thead' ),
			theaders = thead.find( 'th' ),
			trows = table.find( 'tr' );
			
		trows.each( function (index) {
			$(this).children().attr( 'data-th', function () {
				if ( !theaders.eq( $(this).index() ).text().trim().length ) {
					return ' ';
					
				} else {
					return theaders.eq( $(this).index() ).text();
				}
			});
		});
	});
	
/*	3.0 CONTROL THE SIZE OF PARTICULAR ELEMENTS
============================================== */
/* 3.1 Cut string per lines limit */
	$.fn.skinCutStringPerLinesLimit = function() {
		$(this).each( function() {
			var str = $(this),
				limit = parseFloat( str.attr( 'data-lines-limit' ) ),
				strLineHeight = parseFloat( str.css( 'line-height' ) ),
				strHeight = str.outerHeight();
				
			if ( strHeight > limit*strLineHeight ) {
				str.css({ "overflow":"hidden", "height":limit*strLineHeight });
				
				var holder = str,
					size = [holder.width(), holder.height()],
					words = $.trim(holder.text()).split(/\s+/);
					
				var newString = '';
				
				for ( var i = 0, len = words.length; i < len; i++ ) {
					var holderClone = holder.clone().text( words.join(' ') ).insertAfter( holder );
					holderClone.contents().wrap('<span />');
					var holderChildren = holderClone.children('span');
					
					if ( holderChildren.width() < size[0] && holderChildren.height() < size[1] ) {
						holderClone.remove();
						
						break;
					}
					
					holderClone.remove();
				}
				
				words.pop();
				if ( undefined !== words[words.length-1] ) {
					words[words.length-1] = "...";
				}
				
				newString = words.join(' ');
				
				str.text( newString );
			}
		});
	}
	
// Apply to all elements with 'cut-by-lines' class and given 'data-lines-limit' attribute	
	$(window).on( 'load', function() {
		if ( 0 < $( '.cut-by-lines' ).length ) {
			$( '.cut-by-lines' ).skinCutStringPerLinesLimit();
		}
	});
	
/* 3.2 Spread item to max width, related to available space in parent holder */
	$.fn.skinSpreadCell = function() {
		$(this).each( function() {	
			var cell = $(this),
				parentWidth = cell.parent().outerWidth(),
				cellWidth = parentWidth,
				cellSiblings = cell.siblings(),
				takeAway = 0;
				
			if ( 0 < cellSiblings.length ) {
				cellSiblings.each( function() {
					takeAway += $(this).outerWidth();
				});
			}
			
			cellWidth -= Math.ceil( takeAway + 1 );
			
			cell.width( cellWidth );
		});
	}

/* 3.3 Add skin-embed class to all the embed-supported media */
	$.fn.skinEmbedSupport = function() {
		$(this).each( function() {
			var media = $(this);

			if ( 1 > media.length || undefined === media.attr("src") ) {
				return;
			}
			
			function getIframeSource(term) {
				return ( media.attr("src").indexOf(term) >= 0 );
			}
			
			var supported = ["vimeo.com", "youtube.com", "ted.com", "dailymotion.com", "animoto.com", "wordpress.tv", "kickstarter.com", "vine.co", "soundcloud.com", "mixcloud.com", "audiomack.com"];
			
			for ( var i = 0; i < supported.length; i++ ) {
				if ( getIframeSource( supported[i] ) ) {
					media.addClass('skin-embed');
				}
			}
		});
	}
	
	if ( 0 < $( '.post-content iframe' ).length ) {	
		$( '.post-content iframe' ).skinEmbedSupport();
	}
	
	if ( 0 < $( '.featured-media iframe' ).length ) {	
		$( '.featured-media iframe' ).skinEmbedSupport();
	}
	
	if ( 0 < $( '.widget iframe' ).length ) {
		$( '.widget iframe' ).skinEmbedSupport();
	}
	
/* 3.4 Resize content item that should be wider than the content wrapper */
	$.fn.skinEnlargeItem = function() {
		var mainWrapperWidth = $('#main').width(),
			enlargedItemPos = -( mainWrapperWidth - $('#main .post-content').width() )/2;
		
		$(this).each( function(i, el) {				
			var itemFigureWrapper = $(el).closest( 'figure' );
			
			var holder = $(el).closest( '.skin-embed-holder' ),
				loader = holder.find( '.content-loading' );			
			
			if ( 0 < itemFigureWrapper.length ) {
				if ( 'rtl' === txtDirection ) {
					if ( $(el).hasClass( 'skin-embed' ) && 0 < holder.length ) {
						$.when( loader.addClass( 'done' ) ).then( function() {
							$.when( $(el).unwrap( '.skin-embed-holder' ) ).then( function() {
								loader.fadeOut();
								itemFigureWrapper.width( mainWrapperWidth ).css({ "max-width":mainWrapperWidth, "marginRight":enlargedItemPos });						
							});
						});
						
					} else {
						itemFigureWrapper.width( mainWrapperWidth ).css({ "max-width":mainWrapperWidth, "marginRight":enlargedItemPos });
					}
					
				} else {
					if ( $(el).hasClass( 'skin-embed' ) && 0 < holder.length ) {
						$.when( loader.addClass( 'done' ) ).then( function() {
							$.when( $(el).unwrap( '.skin-embed-holder' ) ).then( function() {
								loader.fadeOut();
								itemFigureWrapper.width( mainWrapperWidth ).css({ "max-width":mainWrapperWidth, "marginLeft":enlargedItemPos });						
							});
						});
						
					} else {
						itemFigureWrapper.width( mainWrapperWidth ).css({ "max-width":mainWrapperWidth, "marginLeft":enlargedItemPos });
					}
				}
				
			} else {
				if ( 'rtl' === txtDirection ) {
					if ( $(el).hasClass( 'skin-embed' ) && 0 < holder.length ) {
						$.when( loader.addClass( 'done' ) ).then( function() {
							$.when( $(el).unwrap( '.skin-embed-holder' ) ).then( function() {
								loader.fadeOut();
								$(el).width( mainWrapperWidth ).css({ "max-width":mainWrapperWidth, "marginRight":enlargedItemPos });
							});
						});
						
					} else {
						$(el).width( mainWrapperWidth ).css({ "max-width":mainWrapperWidth, "marginRight":enlargedItemPos });
					}
					
				} else {
					if ( $(el).hasClass( 'skin-embed' ) && 0 < holder.length ) {
						$.when( loader.addClass( 'done' ) ).then( function() {
							$.when( $(el).unwrap( '.skin-embed-holder' ) ).then( function() {
								loader.fadeOut();
								$(el).width( mainWrapperWidth ).css({ "max-width":mainWrapperWidth, "marginLeft":enlargedItemPos });
							});
						});
						
					} else {
						$(el).width( mainWrapperWidth ).css({ "max-width":mainWrapperWidth, "marginLeft":enlargedItemPos });
					}
				}
			}
		});
	};
	
// Apply to galleries, embedded media, maps and images
	if ( 0 < $( '.post-content img.size-skin_wrapper_width' ).length ) {
		$( '.post-content img.size-skin_wrapper_width' ).skinEnlargeItem();
	}
	
	if ( 0 < $( '.skin-gallery.enlarged' ).length ) {
		$( '.skin-gallery.enlarged' ).skinEnlargeItem();
	}
	
	if ( 0 < $( '.google-map.enlarged' ).length ) {
		$( '.google-map.enlarged' ).skinEnlargeItem();
	}
	
	if ( 0 < $( '.enlarge-media .post-content iframe.skin-embed' ).length ) {
		$( '.enlarge-media .post-content iframe.skin-embed' ).skinEnlargeItem();
	}
	
/* 3.5 Resize element height per given ratio */
	$.fn.skinHeightPerRatio = function( ratio ) {
		$(this).each( function() {
			$(this).height( $(this).width()/ratio );
		});
	}

// Apply to Skin Galleries
	if ( 0 < $( '.skin-gallery .skin-gallery-slider' ).length ) {
		$( '.skin-gallery .skin-gallery-slider' ).skinHeightPerRatio( 16/9 );
	}	
	
/* 3.6 Resize element height to same value as its width */
/*
	Make sure that all the siblings (if there are any) end up with equal heights,
	to avoid line break.
*/
	$.fn.skinSquarePerWidth = function() {
		var minHeight,
			h;
		
		$(this).each( function( index ) {
			$(this).height( $(this).innerWidth() );
		
			if ( 0 < $(this).siblings().length ) {
				h = $(this).height();
				
				if ( 0 === index ) {
					minHeight = h;
					
				} else {
					minHeight = ( h < minHeight ) ? h : minHeight;
				}
			}
		});
		
		if ( 1 < $(this).length ) {
			$(this).height( minHeight );
		}
	}
	
// Apply to "square" and "circle" items
	if ( 0 < $( '.square' ).length ) {
		$('.square').skinSquarePerWidth();
	}
	
	if ( 0 < $( '.circle' ).length ) {
		$('.circle').skinSquarePerWidth();
	}
	
/* 3.7 Resize embedded media to its original proportion */
	$.fn.skinAdjustEmbedRatio = function() {
		$(this).each( function(i, el) {			
			var holder = $(el).closest( '.skin-embed-holder' ),
				loader = $(el).siblings( '.content-loading' ),
				h;
				
			if ( 1 > $(el).length ) {
				return;
			}
			
			var getIframeSource = function( term ) {
				return ( $(el).attr("src").indexOf( term ) >= 0 );
			}
			
			var renderIframe = function( height ) {
				if (  false === $.isNumeric( height ) ) {
					height = 270;
				}
				
				if ( 0 < holder.length ) {
					$.when( $(el).css({ "height":height }).attr({ "height":height }) ).then( function() {
						$.when( loader.fadeOut() ).then( function() {							
							holder.removeClass( 'promised' );
							$(el).unwrap( '.skin-embed-holder' );
						});
					});
					
				} else {
					$(el).css({ "height":height }).attr({ "height":height });
				}
			}
			
			// Ratio 16/9: Vimeo, YouTube, TED, DailyMotion, Animoto, WordPress.tv
			var ratio16x9 = getIframeSource("vimeo.com") ||
				getIframeSource("youtube.com") ||
				getIframeSource("ted.com") ||
				getIframeSource("dailymotion.com") ||
				getIframeSource("animoto.com") ||
				getIframeSource("kickstarter.com") ||
				getIframeSource("wordpress.tv");
			
			if ( ratio16x9 ) {
				h = $(el).width()*(9/16);
				renderIframe( h );
			}
			
			// Ratio 8/5: FunnyOrDie
			var ratio8x5 = getIframeSource("funnyordie.com");
			
			if ( ratio8x5 ) {
				h = $(el).width()*(5/8);
				renderIframe( h );
			}
			
			// Ratio 1/1: Vine
			if ( getIframeSource("vine.co") ) {
				h = $(el).width();
				renderIframe( h );
			}
			
			// Issuu
			if ( getIframeSource("issuu.com") ) {
				h = $(el).width()*(250/441);
				renderIframe( h );
			}	
			
			// SoundCloud
			if ( getIframeSource("soundcloud.com") ) {
				if ( getIframeSource("visual=true") ) {
					h = 450;
					
				} else {
					h = 166;
				}
				
				renderIframe( h );
			}			
			
			// MixCloud
			if ( getIframeSource("mixcloud.com") ) {
				if ( getIframeSource("hide_cover=1") ) {
					if ( getIframeSource("mini=1") ) {
						h = 60;
						
					} else {
						h = 120;
					}
					
				} else {
					h = 400;
				}
				
				renderIframe( h );
			}
			
			// AudioMack
			if ( getIframeSource("audiomack.com") ) {
				$("#wrap.embed").css({ "max-width":"none" });
				
				if ( getIframeSource("large") ) {
					h = 250;
					
				} else if ( getIframeSource("thin") ) {
					h = 62;
					
				} else {
					h = 110;
				}
				
				renderIframe( h );
			}
		});
	}
	
	if ( 0 < $( '.skin-embed-holder' ).length ) {
		$( '.skin-embed-holder' ).each( function(i, el) {
			if ( !$(el).find( '.skin-embed' ).length ) {
				var loader = $(el).find( '.content-loading' ),
					emb = $(el).find( 'iframe' );
					
				$.when( loader.addClass( 'done' ) ).then( function() {
					loader.fadeOut();
					$(el).removeClass( 'promised' );
					emb.unwrap( '.skin-embed-holder' );
				});
			}
		});
	}
	
	if ( 0 < $( 'iframe.skin-embed' ).length ) {
		$( 'iframe.skin-embed' ).skinAdjustEmbedRatio();
	}
	
	if ( 0 < $( '.enlarge-media .post-content iframe.skin-embed' ).length ) {
		$( '.enlarge-media .post-content iframe.skin-embed' ).skinEnlargeItem();
	}	
	
/* 3.8 Set content item width to wrapper width */
	$.fn.skinFitItem = function () {
		var mainWrapperWidth = $('#main .post-content').width();
		
		$(this).each( function() {				
			var itemFigureWrapper = $(this).closest( 'figure' );
			
			if ( 0 < itemFigureWrapper.length ) {
				if ( 'rtl' === txtDirection ) {
					itemFigureWrapper.width( mainWrapperWidth ).css({ "max-width":mainWrapperWidth, "marginRight":0 });
					
				} else {
					itemFigureWrapper.width( mainWrapperWidth ).css({ "max-width":mainWrapperWidth, "marginLeft":0 });
				}
				
			} else {
				if ( 'rtl' === txtDirection ) {
					$(this).width( mainWrapperWidth ).css({ "max-width":mainWrapperWidth, "marginRight":0 });
					
				} else {
					$(this).width( mainWrapperWidth ).css({ "max-width":mainWrapperWidth, "marginLeft":0 });
				}
			}
		});
	};

/* 3.9 Find featured image box and resize it per img ratio (stored as data attribute) */
/*
	Img ratio is stored as data attribute and
	the function is being used in case when img is
	displayed as background of a box that needs to
	retain the same proportion
*/
	$.fn.skinSetFeaturedBoxSizePerImgRatio = function() {
		var imgNatural = $(this).find( '.featured-img.natural' );
		
		if ( 0 < imgNatural.length ) {
			var imgNaturalWidth = imgNatural.width(),
				ratio			= imgNatural.attr( 'data-img-ratio' );
			
			imgNatural.height( imgNaturalWidth/ratio );
		}
	}
	
/*	4.0 SLIDERS
================= */
/* 4.1 Gallery slider */	
	$.fn.initSkinGallerySlider = function() {
		var gallerySlider = new Swiper( $(this), {
			grabCursor: true,
			keyboardControl: true,
			loop: true,
			preloadImages: false,
			lazyLoading: true,				
			nextButton: $(this).find('.swiper-button-next'),
			prevButton: $(this).find('.swiper-button-prev')
		});
		
		var thumbs = $(this).next(".skin-gallery-thumbs");
		
		thumbs.on( 'click', '.gallery-thumb', function(){
			$(this).fadeTo( 100, 0.4 ).siblings().fadeTo( 100, 1 );
			gallerySlider.slideTo( $(this).index()+1, 500 );
		});
		
		gallerySlider.on( 'onTransitionEnd', function() {
			thumbs.find('.gallery-thumb').eq( gallerySlider.realIndex ).fadeTo( 50, 0.4 ).siblings().fadeTo( 50, 1 );
		});
		
		thumbs.find( '.gallery-thumb' ).skinSquarePerWidth();			
		
		$(window).on( 'resize', function() {
			thumbs.find( '.gallery-thumb' ).skinSquarePerWidth();
		});
	}
	
	if ( 0 < $('.skin-gallery-slider').length ) {
		var gallerySliderList = $('.skin-gallery-slider');
		
		gallerySliderList.each( function(i, el) {
			$(el).initSkinGallerySlider();
		});
	}
	
/* 4.2 Related posts */	
	if ( 0 < $('.related-posts').length ) {
		var relatedPostsList = $('.related-posts');
		
		relatedPostsList.each( function(){
			if ( $(this).hasClass( 'carousel' ) ) {
				var relatedPosts = new Swiper( $(this), {
					loop: false,
					preloadImages: false,
					lazyLoading: true,
					nextButton: $(this).find('.next'),
					prevButton: $(this).find('.prev'),
					freeMode: true,
					freeModeSticky: true
				});
			}
		});
	}
	
/* 4.3 Instagram carousel in main sidebar */
	$.fn.skinInstagramScrollNarrow = function() {
		var carousel = $(this);
		
		carousel.each( function() {
			var smallCarousel = new Swiper( $(this), {
				grabCursor: true,
				loop: true,
				preloadImages: false,
				lazyLoading: true,
				slidesPerView: 1,
				freeMode: true,
				freeModeSticky: true
			});
		});
	}
	
	if ( 0 < $( '#sidebar .skin-carousel' ).length ) {
		$( '#sidebar .skin-carousel' ).skinInstagramScrollNarrow();
	}
	
	if ( 0 < $( '.masonry-item .skin-carousel' ).length ) {
		$( '.masonry-item .skin-carousel' ).skinInstagramScrollNarrow();
	}
	
/* 4.4 Instagram carousel in footer and other sidebar areas */
	$.fn.skinInstagramScrollWide = function() {
		var carousel = $(this);
		
		carousel.each( function() {
			var wideCarousel = new Swiper( $(this), {
				grabCursor: true,
				loop: true,
				preloadImages: false,
				lazyLoading: true,
				slidesPerView: 6,
				freeMode: true,
				freeModeSticky: true,
				breakpoints: {
					480: {
						slidesPerView: 2
					},
					768: {
						slidesPerView: 3
					},
					1024: {
						slidesPerView: 4
					}
				}
			});
		});
	}
	
	if ( 0 < $('.sidebar .skin-carousel').length ) {
		$('.sidebar .skin-carousel').skinInstagramScrollWide();
	}
	
/*	5.0 TOP BAR
================= */	
/* 5.1 Quick Search overlay */		
	if ( 0 < $( '.quick-search-button' ).length ) {
		$( '.quick-search-button' ).on( 'click', function(e) {
			e.preventDefault();
			
			var currentScroll	= $(window).scrollTop(),
				topOnTop		= $( '.top-bar .top' );
		
		// Open overlay and mark current scroll position as data attribute
			$( '#quick-search-results' ).html('');
			$( '#search-overlay' ).fadeIn();
			$( '#search-overlay' ).attr( 'data-scroll', currentScroll );
			
		// Adjust html and body css to avoid overflow
			$( 'html, body' ).addClass( 'overlay-on' );
			
		/* Position the top of search overlay to match position of search button in top bar */
			if ( 0 < topOnTop.length && 0 === currentScroll ) {
				$( '#search-overlay .top' ).css({ "margin-top":topOnTop.outerHeight() });
				
			} else {
				$( '#search-overlay .top' ).css({ "margin-top":0 });
			}
			
		// Prepare the search field and let it do its magic
			$( '#search-overlay .search-field' ).focus();
			
			$( '#search-overlay .search-field' ).keyup( function(e) {
				e.preventDefault();
				
				var term = $( '#search-overlay .search-field' ).val();
				
			// but do nothing if the searched query is less than 3 characters long	
				if ( '' === term || 3 > term.length ) {
					$('#quick-search-results').html('');
					
				} else {
					$.ajax({
						type:"POST",
						url: mainLoc.ajaxurl,
						data: {
							action: 'skin_ajax_quick_search',
							search_string: term
						},
						success:function(data){			
							$( '#quick-search-results' ).html('');
							$( '#quick-search-results' ).append(data);
							$( '#quick-search-results .cut-by-lines' ).skinCutStringPerLinesLimit();
						}
					});
				}			
			});
		});
	}	
	
// Remove the search overlay and get back to same scroll position
	var removeSearchOverlay = function() {
		$( '#quick-search-results' ).html('');
		$( '#search-overlay' ).fadeOut();
		
		$('html, body').removeClass( 'overlay-on' );
		
		$(window).scrollTop( $( '#search-overlay' ).attr( 'data-scroll' ) );
	}
	
// Remove the search overlay when close button is clicked
	$('#search-overlay').on( 'click', '.close', function(e) {
		removeSearchOverlay();
	});
	
// Remove the search overlay on hitting the Esc key
	$(document).keyup(function(e) {
		if ( 27 === e.keyCode ) {
			removeSearchOverlay();
		}
	});
	
/* 5.2 Overlay menu for mobiles */
	var submenuIcon = mainLoc.submenuSVG;
	
	$( '.overlay-menu.mobile .main-menu li a' ).wrapInner( '<span></span>' );
	
	$( '.overlay-menu.mobile' ).find( 'li.menu-item-has-children' ).children( 'a' ).children( 'span' ).append( submenuIcon );
	
	$('.top-bar.mobile').on( 'click', '.menu-button', function(e) {
		e.preventDefault();
		
		var currentScroll = $(window).scrollTop();		
		$( 'html, body' ).toggleClass( 'overlay-on' );
		$(window).scrollTop(0);
		
		$( '.overlay-menu.mobile' ).toggleClass( 'menu-on' );
		
		if ( 0 < $('#wpadminbar').length && 'none' != $( '#wpadminbar' ).css( 'display' ) && 'fixed' === $( '#wpadminbar' ).css( 'position' ) ) {
			$( '.overlay-menu.mobile' ).css({ "height":window.innerHeight - 70 - $( '#wpadminbar' ).innerHeight() });
			
		} else {
			$( '.overlay-menu.mobile' ).css({ "height":window.innerHeight - 70 });
		}
		
		$( '.overlay-menu.mobile' ).attr( 'data-scroll', currentScroll );
	});
	
	$( '.overlay-menu.mobile' ).on( 'click', '.menu-item-has-children > a', function(e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		$(this).toggleClass('active').next('.sub-menu').slideToggle(200);
	});
	
// Remove menu overlay
	var removeMenuOverlay = function() {
		$( 'html, body' ).removeClass( 'overlay-on' );
		$( '.overlay-menu.mobile' ).removeClass( 'menu-on' );
		
		$(window).scrollTop( $( '.overlay-menu.mobile' ).attr( 'data-scroll' ) );
	}
	
// Remove menu overlay on click on the top bar
	$(document).on( 'click', '.top-bar.mobile', function(e) {
		if ( 0 === $(e.target).closest( $( '.top-bar.mobile .menu-button' ) ).length && 0 === $(e.target).closest( $( '.top-bar .quick-search-button' ) ).length ) {
			removeMenuOverlay();
		}
	});	
	
// Remove menu overlay on hitting the Esc key
	$(document).keyup(function(e) {
		if ( 27 === e.keyCode ) {
			removeMenuOverlay();
		}
	});
	
/* 5.3 Control social links in desktop top bar */
	if ( 0 < $( '.top-bar.desktop .social-links' ).length ) {
		var socialWrapper = $( '.top-bar.desktop .top-holder .social-links' ),
			socialLinksWrapper = $( '.top-bar.desktop .top-holder .social-links .social-links-holder' ),
			staggerSocialLinks,
			timer;
			
		socialWrapper.on( "mouseenter", function() {
			clearTimeout( timer );
			
			timer = setTimeout( function() {
				socialLinksWrapper.show();
				
				socialLinksWrapper.children( '.social-icon' ).each( function(i) {
					var item = $(this);
					
					staggerSocialLinks = setTimeout( function() {
						item.fadeTo( 400, 1 );
						
					}, 100*i );
				});
				
			}, 400 );
			
		}).on( "mouseleave", function() {
			clearTimeout( timer );
			
			timer = setTimeout( function() {
				socialLinksWrapper.children( '.social-icon' ).fadeOut(400);
				socialLinksWrapper.fadeOut(400);
					
				clearTimeout( staggerSocialLinks );
			}, 600 );
		});
	}
	
/* 5.4 Adjust main menu items alignment */
	var skinMenuDescription = function() {
		if ( 0 < $( '.top-bar.desktop' ).length ) {
			var item,
				desc;
			
			if ( 0 === $( '.top-bar.desktop .main-menu .description' ).length ) {
				$( '.top-bar.desktop .main-menu > ul > li > a' ).each( function() {
					item = $(this);
					
					if ( undefined !== item.attr( 'data-description' ) ) {
						desc = item.attr( 'data-description' );
						
					} else {
						desc = '';
					}
					
					item.wrapInner( '<span class="title"></span>' ).append( '<span class="description">' + desc + '</span><span class="line top-bar-color-to-bgr"></span>' );
				});
			}
			
			if ( 0 < $( '.top-bar.desktop .main-menu > ul > li > a[data-description]' ).length ) {
				$( '.top-bar.desktop .main-menu .description' ).height( $( '.top-bar.desktop .main-menu .description' ).css( 'line-height' ) );
				
			} else {
				$( '.top-bar.desktop .main-menu .description' ).height( 0 );
			}
		}
	}
	
	skinMenuDescription();
	
/* 5.5 Control main menu dropdown */	
	if ( 0 < $( '.top-bar.desktop .main-menu .sub-menu' ).length ) {
		$( '.top-bar.desktop .main-menu .sub-menu' ).each( function() {
			var submenu = $(this),
				staggerSubmenuItems,
				submenuPos,
				diff,
				timer,
				expire;		
			
			submenu.closest( 'li' ).on( "mouseenter", function(e) {
				clearTimeout( timer );
				
				timer = setTimeout( function() {
					submenu.slideDown( 200 );
					
					submenuPos = submenu.offset().left;
					diff = window.innerWidth - submenuPos;					
					
					if ( 266 > diff ) {
						if ( 0 < submenu.parents( '.sub-menu' ).length ) {
							submenu.css({ "left":"auto", "right":"100%" });
							
						} else {
							submenu.css({ "left":"auto", "right":"0" });
						}
					}
					
					submenu.children( 'li' ).each( function(i) {
						var item = $(this);						 
						
						staggerSubmenuItems = setTimeout( function() {
							item.fadeTo( 200, 1 )
						}, 60*i );
					});
					
				}, 400 );
				
			}).on( "mouseleave", function() {
				clearTimeout( timer );
				
				if ( 0 < submenu.parents( '.sub-menu' ).length ) {
					expire = 400;
					
				} else {
					expire = 200;
				}
				
				timer = setTimeout( function() {
					submenu.children( 'li' ).fadeTo( 50, 0 );
					submenu.slideUp( 100 );
					
					clearTimeout( staggerSubmenuItems );
					
				}, expire );
			});
		});
	}
	
/* 5.6 Control main menu hover effect (on top level) */	
	if ( 0 < $( '.top-bar.desktop .main-menu > ul > li' ).length ) {
		$( '.top-bar.desktop .main-menu > ul > li' ).each( function() {
			var item = $(this),
				current,
				line,
				timer;		
			
			item.on( "mouseenter", function(e) {
				current = $(this);
				line = current.find( '.line' );
				
				clearTimeout( timer );
				
				timer = setTimeout( function() {					
					if ( !( current.hasClass( 'current-menu-item' ) || current.hasClass( 'current-menu-parent' ) ) ) {
						line.css({ "transform":"translateY( 100% )" });
					}
					
				}, 400 );
				
			}).on( "mouseleave", function() {
				current = $(this);
				line = current.find( '.line' );
				
				clearTimeout( timer );
				
				timer = setTimeout( function() {					
					if ( !( current.hasClass( 'current-menu-item' ) || current.hasClass( 'current-menu-parent' ) ) ) {
						line.css({ "transform":"translateY( 0 )" });
					}
					
				}, 400 );
			});
		});
	}
	
/*	6.0 TOP BAR SWITCH ON SINGLE POSTS
======================================== */
	if ( $('body').hasClass( 'single-post' ) && 0 < $( '.top-bar.desktop .top-holder-single' ).length ) {
	/* 6.1 Maximize the reading progress wrapper */
		$( '.top-bar .reading' ).skinSpreadCell();
		
	/* 6.2 Control related posts in top bar switch */
		if ( 0 < $( '.top-holder-single .related' ).length ) {
			var relatedPosts = $( '.top-holder-single .related' ),
				relatedPostsContent = $( '.top-holder-single .related .content-box' ),
				relatedPostTab = $( '.top-holder-single .related .thumb' ),
				relatedPostTitle = $( '.top-holder-single .related .post-title h5' ),
				showContent;
				
			relatedPostTab.on( "mouseenter", function() {
				if ( 'none' === relatedPostsContent.css( 'display' ) ) {
					relatedPostTitle.text( '' );
					relatedPostsContent.fadeIn( 500 );
				}
				
				var title = $(this).find( '.title.hidden' ).text(),
					link = $(this).find( 'a' ).attr( 'href' ),
					target = $(this).find( 'a' ).attr( 'target' ),
					activeTab = $(this);
					
				relatedPostTitle.fadeTo( 150, 0 );
				relatedPostTitle.closest( 'a' ).attr( 'href', link );
				relatedPostTitle.closest( 'a' ).attr( 'target', target );
				
				showContent = setTimeout( function() {
					relatedPostTitle.fadeTo( 150, 1 ).text( title );
					relatedPostTitle.skinCutStringPerLinesLimit();
					relatedPostTab.not( activeTab ).fadeTo( 150, 0.4 );
					activeTab.fadeTo( 150, 1 );
				}, 150);				
			});		
				
			relatedPostTab.on( "mouseleave", function() {
				clearTimeout(showContent);
			});
				
			relatedPosts.on( "mouseleave", function() {
				relatedPostsContent.fadeOut( 500 );
				relatedPostTab.fadeTo( 150, 1 );
			});
		}
		
	/* 6.3 Control the share buttons in top bar switch	*/
		if ( 0 < $( '.top-bar.desktop .share' ).length ) {
			var shareHolder			= $( '.top-bar.desktop .share-buttons' ),
				shareButtonsWrapper	= $( '.top-bar.desktop .share-buttons-holder' ),
				staggerShareButtons,			
				timer;			
			
			shareHolder.on( "mouseenter", function() {
				clearTimeout( timer );
				
				timer = setTimeout( function() {
					shareButtonsWrapper.show();			
					
					shareButtonsWrapper.children( '.social-icon' ).each( function(i) {
						var item = $(this);						 
						
						staggerShareButtons = setTimeout( function() {
							item.fadeTo( 400, 1 )
						}, 100*i );
					});
					
				}, 400 );
				
			}).on( "mouseleave", function() {
				clearTimeout( timer );
				
				timer = setTimeout( function() {
					shareButtonsWrapper.children( '.social-icon' ).fadeOut(400);
					shareButtonsWrapper.fadeOut(400);
						
					clearTimeout( staggerShareButtons );
				}, 600 );
			});
		}
	
	/* 6.4 Switch top bar on menu button click	*/
		$( '.top-bar.desktop .top-holder-single' ).on( 'click', '.menu-button', function() {
			clearTimeout( switchTopBarOnClick );
			
			var switchTopBarOnClick = setTimeout( function() {
				$( '.top-bar.desktop .top-holder-single' ).fadeOut();
				$( '.top-bar.desktop .top-holder' ).fadeIn();
			}, 200);
		});
	}
	
/*	7.0 WINDOW SCROLL
========================== */
/* 7.1 Smooth scroll */
	$( '.smooth-scroll' ).on( 'click', function(event) {
		if ( "" !== this.hash ) {
			event.preventDefault();

			var hash = this.hash;

			$( 'html, body' ).animate({
				scrollTop: $(hash).offset().top
				
			}, 200, function(){
				window.location.hash = hash;
			});
		}
	});
	
/* 7.2 Control the top bar appearance and the reading progress */
	if ( $('body').hasClass( 'single-post' ) ) {
	// Hide site header on scroll down, show on scroll up
		var topBar			= $('.top-bar'),
			top				= topBar.find( '.top' ),
			previousScroll	= 0,
			headerOffset	= topBar.outerHeight(),
			currentScroll	= $(window).scrollTop(),
			contentPos;
		
		if ( 0 === currentScroll ) {
			if ( 0 < top.length ) {
				top.slideDown(200);
			}
			
			topBar.addClass( 'edge' );
			
		} else {
			if ( topBar.hasClass( 'edge' ) ) {
				topBar.removeClass( 'edge' ).addClass( 'drop-shadow' );
				$( '.top-holder' ).addClass( 'top-bar-bgr' );
			}
			
			top.slideUp(600);
		}
		
		contentPos = $( '#main > article > .featured-area' ).offset().top;	

		var toRead = $('.main-content').outerHeight() - window.innerHeight + 180;
		
		var progress = $('.progress'),
			contentScroll,
			perc = 0;
		
		if ( 0 < $( '#wpadminbar' ).length && 'none' != $( '#wpadminbar' ).css( 'display' ) && 'fixed' === $( '#wpadminbar' ).css( 'position' ) ) {
			$( '.top-bar' ).css({ "top": $( '#wpadminbar' ).innerHeight() });
			progress.css({ "margin-top": $( '#wpadminbar' ).innerHeight() });
			
		} else {
			$( '.top-bar' ).css({ "top": 0 });
			progress.css({ "margin-top": 0 });
		}
		
		$(window).on( 'scroll', function () {
			currentScroll = $(this).scrollTop();
			
			if ( currentScroll > headerOffset ) {
				if ( 'rtl' === txtDirection ) {
					progress.css({ "transform":"translateX( " + -perc*100 + "% )" });
					
				} else {
					progress.css({ "transform":"translateX( " + perc*100 + "% )" });
				}
				
				if ( currentScroll > previousScroll ) {
					// Scrolling Down
					if ( currentScroll > headerOffset ) {
						topBar.removeClass( 'edge' ).addClass( 'drop-shadow' );
						$( '.top-holder' ).addClass( 'top-bar-bgr' );
					}
					
					if ( 0 < top.length ) {
						top.slideUp( 200 );
					}					
					
					if ( currentScroll > contentPos ) {
						if ( 'none' === $( '.top-holder-single' ).css( 'display' ) ) {
							clearTimeout( switchTopBar );
							
							var switchTopBar = setTimeout( function() {
								$( '.top-holder-single' ).fadeIn();
								$( '.top-bar.desktop .top-holder' ).fadeOut();
								$( '.top-bar .reading' ).skinSpreadCell();
								$( '.top-bar .reading' ).find( '.cut-by-lines' ).skinCutStringPerLinesLimit();								
							}, 200);							
						}
						
						contentScroll = currentScroll - $( '.main-content' ).offset().top;
						
						if ( 0 < toRead ) {
							perc = Math.max( 0, Math.min( 1, contentScroll/toRead ) );
							
							if ( 'rtl' === txtDirection ) {
								progress.css({ "transform":"translateX( " + -perc*100 + "% )" });
								
							} else {
								progress.css({ "transform":"translateX( " + perc*100 + "% )" });
							}
						}
					}
					
				} else {
					// Scrolling Up						
					contentScroll = currentScroll - $( '.main-content' ).offset().top;
					
					if ( 0 < toRead ) {
						perc = Math.max( 0, Math.min( 1, contentScroll/toRead ) );
						
						if ( 'rtl' === txtDirection ) {
							progress.css({ "transform":"translateX( " + -perc*100 + "% )" });
							
						} else {
							progress.css({ "transform":"translateX( " + perc*100 + "% )" });
						}
					}
					
					if ( currentScroll < contentPos ) {
						if ( 'none' === $( '.top-bar.desktop .top-holder' ).css( 'display' ) ) {
							clearTimeout( switchTopBar );
							
							var switchTopBar = setTimeout( function() {
								$( '.top-bar.desktop .top-holder' ).fadeIn();
								$( '.top-holder-single' ).fadeOut();								
							}, 200);							
						}
					}
				}
			}
			
			previousScroll = currentScroll;
			
			if ( 0 === currentScroll ) {
				if ( 0 < top.length ) {
					top.slideDown(400);
				}
				
				topBar.addClass( 'edge' ).removeClass( 'drop-shadow' );
			}
		});
		
	} else {
	// Hide site header on scroll down, show on scroll up
		var topBar = $('.top-bar'),
			top = topBar.find( '.top' ),
			previousScroll = 0,
			headerOffset = topBar.outerHeight(),
			currentScroll = $(window).scrollTop();
		
		if ( 0 === currentScroll ) {
			if ( 0 < top.length ) {
				top.fadeIn(200);
			}
			
			topBar.addClass( 'edge' ).removeClass( 'drop-shadow' );
			
		} else {
			if ( topBar.hasClass( 'edge' ) ) {
				topBar.removeClass( 'edge' ).addClass( 'drop-shadow' );
				$( '.top-holder' ).addClass( 'top-bar-bgr' );
			}
			
			top.fadeOut(600);		
		}
		
		$(window).on( 'scroll', function () {
			currentScroll = $(this).scrollTop();
			
			if ( currentScroll > headerOffset ) {
				if ( currentScroll > previousScroll ) {
					// Scrolling Down
					if ( currentScroll > window.innerHeight ) {
						topBar.addClass( 'fix' );
						topBar.removeClass( 'show' );
						topBar.removeClass( 'edge' ).addClass( 'drop-shadow' );
						$( '.top-holder' ).addClass( 'top-bar-bgr' );
					}
					
					if ( 0 < top.length ) {
						top.fadeOut(200);
					}
					
				} else {
					// Scrolling Up
					if ( currentScroll + $(window).height() < $(document).height() && currentScroll > window.innerHeight ) {					
						topBar.addClass( 'fix' ).addClass( 'show' );
					}
				}
			}
			
			previousScroll = currentScroll;
			
			if ( 0 === currentScroll ) {
				if ( 0 < top.length ) {
					top.fadeIn(400);
				}
				
				topBar.addClass( 'edge' ).removeClass( 'drop-shadow' );
				topBar.removeClass( 'fix' );
		
				$( '.top-bar' ).css({ "margin-top": 0 });
			}
		
			if ( 0 < $( '#wpadminbar' ).length && 'none' != $( '#wpadminbar' ).css( 'display' ) && 'fixed' === $( '#wpadminbar' ).css( 'position' ) && $( '.top-bar' ).hasClass( 'fix' ) ) {
				$( '.top-bar' ).css({ "margin-top": $( '#wpadminbar' ).innerHeight() });
			}
		});
		
		if ( 0 < $( '#wpadminbar' ).length && 'none' != $( '#wpadminbar' ).css( 'display' ) && 'fixed' === $( '#wpadminbar' ).css( 'position' ) && $( '.top-bar' ).hasClass( 'fix' ) ) {
			$( '.top-bar' ).css({ "margin-top": $( '#wpadminbar' ).innerHeight() });
		}
	}
	
	if ( $( 'body' ).hasClass( 'single-post' ) ) {
		$.when( $( '.top-bar .reading' ).skinSpreadCell() ).then( function() {
			$( '.top-bar .reading' ).find( '.cut-by-lines' ).skinCutStringPerLinesLimit();
		});
	}
	
/* 7.3 Scroll to top */
	if ( 'yes' === $('#to-top').attr( 'data-banner-below' ) ) {
		var sticky_banner_h = $( '.sticky-banner' ).outerHeight();		
		var to_top_pos = 30 + sticky_banner_h;
		
		$( '#to-top' ).css({ "bottom":to_top_pos });
		
	} else {		
		$( '#to-top' ).css({ "bottom":"20px" });
	}
	
	$(window).scroll(function(){
		if ( $(this).scrollTop() > 768 ) {
			$( '#to-top' ).fadeIn();
			
		} else {
			$( '#to-top' ).fadeOut();
		}
	});
	
	$('#to-top').click(function(){
		$( 'html, body' ).animate({scrollTop : 0},400);
		return false;
	});
	
/*	8.0 STICKY BANNER
========================== */
/* 8.1 Close sticky banner */
	$( '.sticky-banner' ).on( 'click', '.close', function(e) {
		$(this).closest( '.sticky-banner' ).fadeOut();
		
		$('#to-top').css({ "bottom":"20px" });
	});
	
/*	9.0 GOOGLE MAP
========================== */
/* 9.1 Render map */	
	$.fn.skinRenderGoogleMap = function() {
		var map,
			key = mainLoc.api_key,
			holder = $(this);
			
		if ( 5 > key.length ) {
			holder.addClass( 'map-blocked' );
			return '';
		}
	
		if ( 0 < holder.length ) {
			holder.each( function() {
				var gmap		= $(this).find(".google-map"),
					pin			= gmap.data("map-pin"),
					title		= gmap.data("map-title"),
					id			= gmap.attr("id"),
					zoomLevel	= gmap.data("map-zoom"),
					latitude	= gmap.data("map-lat"),
					longitude	= gmap.data("map-lng"),
					address		= gmap.data("map-address");
				
				if ( '' != latitude && '' != longitude ) {
					map = new google.maps.Map (
						document.getElementById(id), {
						zoom: zoomLevel,
						center: {lat: latitude, lng: longitude},
						scrollwheel: false,
						zoomControl: true,
						mapTypeControl: true,
						scaleControl: false,
						streetViewControl: false,
						rotateControl: false,
						fullscreenControl: false
					});
					
					if ( '' != pin ) {
						var marker = new google.maps.Marker({
							map: map,
							position: {lat: latitude, lng: longitude},
							icon: pin,
							title: title
						});
					}
					
				} else if ( '' != address ) {
					var geocoder = new google.maps.Geocoder();
					
					geocoder.geocode({'address': address}, function(results, status) {
						if ( status === google.maps.GeocoderStatus.OK ) {
							map = new google.maps.Map(
								document.getElementById(id), {
								zoom: zoomLevel,
								center: results[0].geometry.location,
								scrollwheel: false,
								zoomControl: true,
								mapTypeControl: true,
								scaleControl: false,
								streetViewControl: false,
								rotateControl: false,
								fullscreenControl: false
							});
					
							if ( '' != pin ) {
								var marker = new google.maps.Marker({
									map: map,
									position: results[0].geometry.location,
									icon: pin,
									title: title
								});
							}

						} else {
							console.log( 'Geocode was not successful for the following reason: ' + status );
						}
					});
					
				} else {
					console.log( 'Some data is missing for Google Map to render successfully.' );
				}		
			});
		}
	}
	
	if ( 0 < $( '.skin-map-holder' ).length ) {
		$( '.skin-map-holder' ).skinRenderGoogleMap();
	}
	
/*	10.0 ON WINDOW RESIZE
========================== */
	$(window).on( 'resize', function() {
		adjustTopGradient();		
		skinMenuDescription();
	
		if ( 0 < $( '.post-content img.size-skin_wrapper_width' ).length ) {
			$( '.post-content img.size-skin_wrapper_width' ).skinEnlargeItem();
		}
		
		if ( 0 < $( '.skin-gallery.enlarged' ).length ) {
			$('.skin-gallery.enlarged' ).skinEnlargeItem();
		}
		
		if ( 0 < $( '.google-map.enlarged' ).length ) {
			$('.google-map.enlarged' ).skinEnlargeItem();
		}
		
		if ( 0 < $( '.enlarge-media .post-content iframe.skin-embed' ).length ) {
			$('.enlarge-media .post-content iframe.skin-embed' ).skinEnlargeItem();
		}
		
		if ( 0 < $( '.skin-gallery .skin-gallery-slider' ).length ) {
			$( '.skin-gallery .skin-gallery-slider' ).skinHeightPerRatio( 16/9 );
		}
	
		if ( 0 < $( '.square' ).length ) {
			$( '.square' ).skinSquarePerWidth();
		}
		
		if ( 0 < $( '.circle' ).length ) {
			$( '.circle' ).skinSquarePerWidth();
		}
		
		if ( 0 < $( 'iframe.skin-embed' ).length ) {
			$( 'iframe.skin-embed' ).skinAdjustEmbedRatio();
		}
		
		if ( 0 < $( '.featured-area iframe' ).length ) {
			$( '.featured-area iframe' ).skinAdjustEmbedRatio();
		}
		
		if ( 0 < $( '.cut-by-lines' ).length ) {
			$( '.cut-by-lines' ).skinCutStringPerLinesLimit();
		}
		
		if ( $( 'body' ).hasClass( 'single-post' ) ) {
			$.when( $( '.top-bar .reading' ).skinSpreadCell() ).then( function() {
				$( '.top-bar .reading' ).find( '.cut-by-lines' ).skinCutStringPerLinesLimit();
			});
		}
	});
});