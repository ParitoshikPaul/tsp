/* ==============================================
	INFINITE SCROLL FOR THE POSTS LIST
	Skin - Premium WordPress Theme, by NordWood
================================================= */
jQuery( document ).ready( function($) {
	"use strict";
	
	var layout 			= infinite.layout_type,
		totalPages 		= infinite.max_pages,
		shareSelections = infinite.share_selection;
	
// Masonry layout
	if ( 'masonry' === layout ) {
		$( '.masonry-item' ).each( function(i, el) {
			var item = $(el);
			
			item.skinSetFeaturedBoxSizePerImgRatio();	
							
			var embeds = item.find( 'iframe' );
			var loaders = item.find( '.content-loading' );
			
			if ( 0 < embeds.length ) {
				$.when( embeds.skinEmbedSupport() ).then( function() {
					embeds.each( function(i, el) {
						item.find( '.content-loading' ).fadeOut();
					});
				});
			}
			
			loaders.each( function(i, el) {
				item.find( '.loading-holder' ).removeClass( 'promised' );
				item.find( '.content-loading' ).fadeOut();
			});
		});
		
		$(window).on( 'load', function() {
			listContainer.imagesLoaded( function() {
				$( '.masonry-item' ).each( function(i, el) {
					var item = $(el);
					
					item.skinSetFeaturedBoxSizePerImgRatio();	
									
					var embeds = item.find( 'iframe' );
					var loaders = item.find( '.content-loading' );
					
					if ( 0 < embeds.length ) {
						$.when( embeds.skinEmbedSupport() ).then( function() {
							embeds.each( function(i, el) {
								item.find( '.content-loading' ).fadeOut();
							});
						});
					}
			
					loaders.each( function(i, el) {
						item.find( '.loading-holder' ).removeClass( 'promised' );
						item.find( '.content-loading' ).fadeOut();
					});
				});
			});
		});
		
		var listContainer = $( '#posts-list.masonry' );
		
		var container = listContainer.masonry({
			initLayout: false,
			itemSelector: '.masonry-item-wrapper',
			columnWidth: '.masonry-item-sizer',
			percentPosition: true,
			originLeft: $('body').hasClass( 'rtl' ) ? false : true
		});
		
		container.masonry( 'once', 'layoutComplete', function(items) {
			var elems = container.masonry( 'getItemElements' );
			$(elems).css({ "visibility":"visible" }).find( '.masonry-content' ).css({ "opacity":1 });
			
			var imageFormat = $(elems).find( '.post.format-image' );
			
			if ( 0 < imageFormat.length ) {
				imageFormat.each( function() {
					var imagePost = $(this),
						imagePostHeader = imagePost.find( '.post-header' ),
						imagePostTitle = imagePost.find( '.post-title' );
						
					if ( 0 < imagePostTitle.length ) {
						var imagePostLink = imagePostTitle.attr( 'href' ),
							imagePostTarget = imagePostTitle.attr( 'target' );
					
						imagePostHeader.wrapInner( '<a class="va-middle" href="'+imagePostLink+'" target="'+imagePostTarget+'"></a>' );
					}
				});
			}
		});
		
		listContainer.imagesLoaded( function() {
			container.masonry();
		});
		
		if ( 1 < totalPages ) {
			$( '.loading.posts-list-pagination' ).show();
			
			listContainer.infinitescroll({
					navSelector: '.posts-list-pagination ul.page-numbers',
					nextSelector: '.posts-list-pagination ul.page-numbers a',
					itemSelector: '.masonry-item-wrapper',
					loading: {
							finishedMsg: '',
							selector: '.loading.posts-list-pagination',		
							msgText: ''
						},		
					maxPage: totalPages,
					localMode: true
				},
				
				function( getNewItems, opts ) {
					if ( opts.state.currPage == totalPages ) {
						$('.posts-list-pagination .loader').hide();
					}
						
					var newItems = $( getNewItems ).css({ "visibility":"hidden" });
					
					newItems.imagesLoaded( listContainer, function() {
						newItems.each( function(i, el) {
							var new_item = $(el);
							
							$(this).find( '.masonry-item' ).each( function() {
								$(this).skinSetFeaturedBoxSizePerImgRatio();
							});
							
							var embeds = new_item.find( 'iframe' );
							var loaders = new_item.find( '.content-loading' );
							
							if ( 0 < embeds.length ) {
								$.when( embeds.skinEmbedSupport() ).then( function() {
									embeds.each( function(i, el) {
										$(el).skinAdjustEmbedRatio();
										new_item.find( '.content-loading' ).fadeOut();
									});
								});
							}
							
							loaders.each( function(i, el) {
								new_item.find( '.loading-holder' ).removeClass( 'promised' );
								new_item.find( '.content-loading' ).fadeOut();
							});
	
							if ( 0 < new_item.find( '.skin-map-holder' ).length ) {
								new_item.find( '.skin-map-holder' ).skinRenderGoogleMap();
							}
	
							if ( 0 < new_item.find( '.skin-carousel' ).length ) {
								new_item.find( '.skin-carousel' ).skinInstagramScrollNarrow();
							}
							
							if ( 0 < new_item.find( '.widget_products' ).length ) {
								new_item.find( '.widget_products' ).productsListWidget();
							}
	
							if ( 0 < new_item.find( '.widget_top_rated_products' ).length ) {
								new_item.find( '.widget_top_rated_products' ).productsListWidget();
							}
	
							if ( 0 < new_item.find( '.widget_recently_viewed_products' ).length ) {
								new_item.find( '.widget_recently_viewed_products' ).productsListWidget();
							}
							
						// Apply square and circle shapes where needed	
							if ( 0 < $(this).find( '.square' ).length ) {
								$(this).find( '.square' ).skinSquarePerWidth();
							}
							
							if ( 0 < $(this).find( '.circle' ).length ) {
								$(this).find( '.circle' ).skinSquarePerWidth();
							}
							
						// Apply button effects where needed
							if ( 0 < $(this).find( '.skin-outlined-bttn' ).length ) {
								var bttn = $(this).find( '.skin-outlined-bttn' );
								
								if ( bttn.hasClass( 'skin-anim-bttn' ) ) {
									$.when( bttn.skinAnimBttn() ).then( bttn.skinDrawBttnOutline() );
									
								} else {
									bttn.skinDrawBttnOutline();
								}
							}
							
						// Take care of a popout if it appears in the list
							if ( 0 < $(this).find( '.skin-widget-pop' ).length ) {
								var popoutlink = $(this).find( '.skin-widget-pop a.popout-page' );
									
								$(document).on( "click", '.skin-widget-pop a.popout-page', function(e){
									e.preventDefault();
								});
								
								popoutlink.each( function() {
									$(this).on( "click auxclick contextmenu", function(e) {
										e.preventDefault();
											
										if ( 1 === e.which ) {				
											$(this).skinPopout();
										}
										
										return false;
									});
								});
							}
							
						// Fire the slider on Popular/Latest box if it appears in the list
							if ( 0 < $(this).find( '.skin-widget-top-posts' ).length ) {
								$(this).find( '.skin-widget-top-posts' ).skinTopPostsSlider();
							}
							
						// Fire the slider on gallery (special) widget
							if ( 0 < $(this).find( '.skin-gallery-slider' ).length ) {
								$(this).find( '.skin-gallery-slider' ).each( function(i, el) {
									$(el).skinHeightPerRatio( 16/9 );
									$(el).initSkinGallerySlider();
								});
							}
							
						// Set the background on social icons in special box							
							if ( 0 < $(this).find( '.social-icon' ).length ) {
								$(this).find( '.social-icon' ).skinIconFill2Background();
								$(this).find( '.social-icon' ).addClass( 'self-bouncer' );
							}
							
						// Allow share cloud for text selection on new items
							if ( shareSelections && 0 < $(this).find( '.shareable-selections' ).length ) {
								$(this).find( '.shareable-selections' ).skinInitShareCloud();
								$(this).find( '.shareable-selections' ).skinOpenShareCloud();
							}
							
						// Trunc text where needed
							if ( 0 < $(this).find( '.cut-by-lines' ).length ) {
								$( '.cut-by-lines' ).skinCutStringPerLinesLimit();
							}
						});
						
						container.masonry( 'on', 'layoutComplete', function( newItems ) {
							var elems = newItems;								
								
							$(elems).each( function() {
								$( $(this)[0].element ).find( '.masonry-content' ).css({ "visibility":"visible", "opacity":1 });
								
								var imagePost = $($(this)[0].element).find( '.post.format-image' );
								
								if ( 0 < imagePost.length ) {
									var imagePostHeader = imagePost.find( '.post-header' ),
										imagePostTitle = imagePost.find( '.post-title' );
										
									if ( 0 < imagePostTitle.length ) {
										var imagePostLink = imagePostTitle.attr( 'href' ),
											imagePostTarget = imagePostTitle.attr( 'target' );
									
										imagePostHeader.wrapInner( '<a class="va-middle" href="'+imagePostLink+'" target="'+imagePostTarget+'"></a>' );
									}
								}
							});
						});
						
						listContainer.imagesLoaded(function(){
							container.masonry( 'appended', newItems, true );
						});
					});
				}
			);
			
		} else {
			$( '.posts-list-pagination .loader' ).hide();
		}
		
		$(window).on( 'resize', function() {
			$( '.masonry-item' ).each( function(i, el) {
				var item = $(el);
				item.skinSetFeaturedBoxSizePerImgRatio();
			});
		}).trigger( 'resize' );
	}
	
// Standard layout
	else if ( 'standard-list' === layout ) {
		var listContainer = $( '#main .standard-list' );
		
		if ( totalPages > 1 ) {
			$( '.loading.posts-list-pagination' ).show();
			
			listContainer.infinitescroll({
					navSelector: '.posts-list-pagination ul.page-numbers',
					nextSelector: '.posts-list-pagination ul.page-numbers a',
					itemSelector: 'article.post',
					loading: {
							finishedMsg: '',
							selector: '.loading.posts-list-pagination',		
							msgText: ''
						},
					maxPage: totalPages,
					localMode: true
				},
				function( getNewItems, opts ) {
					if ( opts.state.currPage == totalPages ) {
						$( '.posts-list-pagination .loader' ).hide();
					}
					
					var newItems = $( getNewItems ).css({ "visibility":"hidden" });
					
					newItems.imagesLoaded( listContainer, function() {
						newItems.each( function() {
						// Apply square and circle shapes where needed
							if ( 0 < $(this).find( '.square' ).length ) {
								$(this).find( '.square' ).skinSquarePerWidth();
							}
							
							if ( 0 < $(this).find( '.circle' ).length ) {
								$(this).find( '.circle' ).skinSquarePerWidth();
							}
							
						// Apply button effects where needed
							if ( 0 < $(this).find( '.skin-outlined-bttn' ).length ) {
								var bttn = $(this).find( '.skin-outlined-bttn' );
								
								if ( bttn.hasClass( 'skin-anim-bttn' ) ) {
									$.when( bttn.skinAnimBttn() ).then( bttn.skinDrawBttnOutline() );
									
								} else {
									bttn.skinDrawBttnOutline();
								}
							}
							
						// Allow share cloud for text selection on new items
							if ( shareSelections && $(this).find( '.shareable-selections' ).length > 0 ) {
								$(this).find('.shareable-selections').skinInitShareCloud();
								$(this).find('.shareable-selections').skinOpenShareCloud();
							}
							
						// Trunc text where needed
							if ( $(this).find( '.cut-by-lines' ).length > 0 ) {
								$( '.cut-by-lines' ).skinCutStringPerLinesLimit();
							}
						});						
						
						$( newItems ).css({ "visibility":"visible", "opacity": 1 });
					});			
				}
			);
			
		} else {
			$( '.posts-list-pagination .loader' ).hide();
		}
	}	
});