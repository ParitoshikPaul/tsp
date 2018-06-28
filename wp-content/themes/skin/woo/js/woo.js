/* ==============================================
	SCRIPTS FOR WOOCOMMERCE
	Skin - Premium WordPress Theme, by NordWood
================================================= */
jQuery( function($) {
    "use strict";
	
	$( '.up-sells, .related.products, .cross-sells' ).find( 'article' ).addClass( 'hover-trigger' );
	
/* Adjust the heading on cross-sells */
	$.when( $( '.cross-sells' ).find( 'h2' ).replaceWith( function() {
		return $( "<h3 />", { html: $(this).html()} );
		
	}) ).then( $( '.cross-sells' ).find( 'h3' ).wrap( '<header class="heading content-pad"></header>' ) );
	
/* Adjust the heading on related products */
	$.when( $( '.related.products' ).find( 'h2' ).replaceWith( function() {
		return $( "<h3 />", { html: $(this).html()} );
		
	}) ).then( $( '.related.products' ).find( 'h3' ).wrap( '<header class="heading content-pad"></header>' ) );
	
/* Adjust the heading on up-sells products */
	$.when( $( '.up-sells.products' ).find( 'h2' ).replaceWith( function() {
		return $( "<h3 />", { html: $(this).html()} );
		
	}) ).then( $( '.up-sells.products' ).find( 'h3' ).wrap( '<header class="heading content-pad"></header>' ) );
	
/* Adjust the heading on order details */
	$( '.woocommerce-customer-details' ).find( 'h2' ).each( function(i, el) {
		$( el ).replaceWith( function() {
			return $( "<h3 />", { html: $(this).html() } );
		} );
	} );
	
/* Wrap orderby control on shop */
	$( '.loop-controls' ).find( '.woocommerce-ordering' ).wrap( '<div class="order-control"></div>' );
	
/* Wrap no-results notice on search */
	$( '.woocommerce.search-no-results' ).find( '.woocommerce-info' ).wrap( '<div class="no-products-info"></div>' );
	
/* Control the mini cart appearance in top bar */	
	$( '.mini-cart-button-wrapper' ).each( function() {
		var bttn = $(this),
			timer;
	
		bttn.on( 'mouseenter', function(e) {
			clearTimeout( timer );
			
			timer = setTimeout( function() {
				bttn.find( '.top-cart' ).fadeIn( 600 );
				
			}, 200 );
			
		}).on( "mouseleave", function() {
			clearTimeout( timer );
			
			timer = setTimeout( function() {
				bttn.find( '.top-cart' ).fadeOut( 400 );
				
			}, 800 );
		});
	});
	
/* Animate mini cart button when cart total changes */
	function skinUpdateMiniCart() {
		var bttn = $( '.mini-cart-button' ),
			timer;
		
		clearTimeout( timer );
		bttn.removeClass( 'out' ).addClass( 'in' );
			
		timer = setTimeout( function() {
			bttn.removeClass( 'in' ).addClass( 'out' );
			
		}, 500 );
	}
	
    $( document ).on( 'added_to_cart', function() {
		skinUpdateMiniCart();
	});
	
    $( document ).on( 'removed_from_cart', function() {
		skinUpdateMiniCart();
	});
	
    $( document ).on( 'updated_cart_totals', function() {
		skinUpdateMiniCart();
	});
	
/* Enhance select field */
    $('.woocommerce-ordering .orderby').select2({
        minimumResultsForSearch: -1
    });
	
/* Widgets */
	$( '.widget_product_tag_cloud' ).find('a').addClass( 'txt-color-light-to-border' );
	
	$.fn.productsListWidget = function() {
		var container = $(this);
		
		if ( 0 < container.length ) {
			var shrinker_clr;
	
			if ( container.hasClass( 'gradient-bgr' ) ) {
				shrinker_clr = 'trans-border';
				
			} else if ( container.hasClass( 'content-pad' ) ) {
				shrinker_clr = 'content-pad-to-border';
				
			} else {
				shrinker_clr = 'body-bgr-to-border';
			}
			
			container.find( '.shrinker' ).addClass( shrinker_clr );
		}
	}
	
	$( '.widget_products' ).productsListWidget();
	$( '.widget_top_rated_products' ).productsListWidget();
	$( '.widget_recently_viewed_products' ).productsListWidget();
	
	$.fn.productsListWidgetOrder = function() {
		var container = $(this);
		
		if ( 0 < container.length ) {
			container.find( 'tr' ).each( function( i, el ) {
				$( el ).find( '.order' ).find( '.txt' ).html( i + 1 );				
			} );
		}
	}	
	
	$( '.widget_top_rated_products' ).find( '.product_list_widget' ).productsListWidgetOrder();	
	
/* List display in some default WP widgets */
	$( '.widget_product_categories, .widget_layered_nav' ).find( 'li a' ).each( function(i, v) {		
		$(v).wrapInner( '<h5></h5>' );
	});
	
/* Quantity display in some Categories and Archives widgets */
	$('.widget_product_categories, .widget_layered_nav').find( '.count' ).each( function(i, v) {
		$(v).addClass( 'va-middle' );
		
		$(v).text( $(v).text().replace('(', '') );
		$(v).text( $(v).text().replace(')', '') );
		
		$(v).find('.count').wrapInner( '<h5></h5>' );
	});	
});