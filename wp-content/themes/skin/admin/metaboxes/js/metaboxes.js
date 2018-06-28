/* ==============================================
	CONTROLS FOR METABOXES
	Skin - Premium WordPress Theme, by NordWood
================================================= */
jQuery( document ).ready( function($) {
	"use strict";
	
	var metabox			= $( '#skin_meta_box-skin-meta-box' ),
		pageMetabox		= $( '#skin_page_meta_box-skin-page-meta-box' ),
		postMetabox		= $( '#skin_post_meta_box-skin-post-meta-box' ),
		cats			= postMetabox.find( '.skin-cats-list' ),
		prioritizeCats	= $( '#skin_prioritize_cats' ),
		pageTemplate 	= $( '#page_template' ).val();
	
/* Enable color picker */
	if ( 0 < pageMetabox.length ) {
		$( '.meta-color' ).wpColorPicker();		
	}

/* Prioritize categories */
	function updatePrioritized() {
		var newCats = '';
		
		cats.find( '.skin-cat' ).each( function() {
			var cat = $(this);
			
			if( 'on' === cat.attr( 'data-cat-on' ) ) {
				var catID = cat.attr( 'data-cat-id' );
				
				newCats += catID + ',';
			}
		});
		
		prioritizeCats.val( newCats );
		prioritizeCats.change();
	}
	
    $( '#categorychecklist' ).on( 'change', 'input[type=checkbox]', function() {
		var catChanged = $(this).val();
		
        if ( $(this).is(':checked') ) {
			var addCat = '';
			
			addCat += '<span class="skin-choose-cat va-middle">';
			addCat += '<span class="skin-cat" data-cat-id=' + catChanged + ' data-cat-on="off">';
			addCat += $(this).closest('label').text();
			addCat += '</span>';
			addCat += '</span>';
		
			cats.append( addCat );
			
		} else {
			$( '#skin_post_meta_box-skin-post-meta-box .skin-cats-list .skin-cat[data-cat-id='+catChanged+']' ).remove();
			
			updatePrioritized();
		}
    });
		
	cats.on( 'click', '.skin-cat', function() {
		var cat = $(this),
			catID = cat.attr( 'data-cat-id' );
		
		cat.attr( 'data-cat-on', function(index, attr) {
			return attr == 'off' ? 'on' : 'off';
		});
		
		updatePrioritized();
	});

/* Control fields for posts slider on page */
	function sliderOnPageCtrl() {
		var sliderOnPageType = $( 'input[type=radio][name=skin_slider_on_page_type]:checked' ),
			shopSliderOnPage = pageMetabox.find( '.shop-slider-ctrl' ),
			blogSliderOnPage = pageMetabox.find( '.blog-slider-ctrl' ),
			sliderOnPageLatest = pageMetabox.find( '.slider-latest-ctrl' ),
			sliderOnPageFeatured = pageMetabox.find( '.slider-featured-ctrl' );
			
		if ( 'featured-products' === sliderOnPageType.val() ) {
			$.when( blogSliderOnPage.hide( 200, "swing" ) ).then( shopSliderOnPage.show( 200, "swing" ) );
			
		} else {
			$.when( shopSliderOnPage.hide( 200, "swing" ) ).then( blogSliderOnPage.show( 200, "swing" ) );			
			
			if ( 'featured' === sliderOnPageType.val() ) {
				$.when( sliderOnPageLatest.hide( 200, "swing" ) ).then( sliderOnPageFeatured.show( 200, "swing" ) );
				
			} else if ( 'latest' === sliderOnPageType.val() ) {
				$.when( sliderOnPageFeatured.hide( 200, "swing" ) ).then( sliderOnPageLatest.show( 200, "swing" ) );
			}
		}
	}
	
	sliderOnPageCtrl();
	
    $( 'input[type=radio][name=skin_slider_on_page_type]' ).on( 'change', function() {
		sliderOnPageCtrl();
    });
});