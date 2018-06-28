/* ================================================
	SCRPITS FOR POSTS LIST IN MASONRY LAYOUT
	Skin - Premium WordPress Theme, by NordWood
=================================================== */
jQuery( document ).ready( function($) {
	"use strict";
		
// Resize featured image box inside masonry item
	$( '.masonry-item').each( function (i, el) {
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
	
	$(window).on( 'load', function(){
		listContainer.imagesLoaded( function(){				
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
	
	var listContainer = $( '.posts-list.masonry' );
	
	listContainer.each( function(i, el) {
		var container = $(el).masonry({
			initLayout:			false,
			itemSelector: 		'.masonry-item-wrapper',
			columnWidth: 		'.masonry-item-sizer',
			percentPosition:	true,
			originLeft: $('body').hasClass( 'rtl' ) ? false : true
		});

		container.masonry( 'once', 'layoutComplete', function(items) {
			var elems = container.masonry( 'getItemElements' );
				
			$(elems).find( '.masonry-content' ).css({ "visibility":"visible", "opacity":1 });
				
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

		$(el).imagesLoaded( function(){
			container.masonry();	
		});
	});
	
    $(window).on('resize', function() {
		$( '.masonry-item' ).each(function() {
			$(this).skinSetFeaturedBoxSizePerImgRatio();
		});
		
    }).trigger('resize');
});