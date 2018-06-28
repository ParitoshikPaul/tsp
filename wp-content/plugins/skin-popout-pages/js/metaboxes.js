/* ====================================
	Scripts for Popout page metaboxes
	Skin Popout Pages plugin
======================================= */
jQuery( document ).ready( function($) {
	"use strict";
	
	var metabox 	= $( '#skin_popout_pages_meta_box-skin-popout-pages-meta-boxes' ),
		pages 		= metabox.find( '.skin-pages-list' ),
		chosenPages	= $( '#skin_popout_on_load_pages' ),
		cats 		= metabox.find( '.skin-cats-list' ),
		chosenCats 	= $( '#skin_popout_on_load_cats' );
	
	function updateChosenPages() {
		var newPages = '';
		
		pages.find( '.skin-page' ).each( function() {
			var page = $(this);
			
			if( 'on' === page.attr( 'data-page-on' ) ) {
				var pageID = page.attr( 'data-page-id' );
				
				newPages += pageID + ',';
			}
		});
		
		chosenPages.val( newPages );
		chosenPages.change();
	}
	
	pages.on( 'click', '.skin-page', function() {
		var page = $(this),
			pageID = page.attr( 'data-page-id' );
		
		page.attr( 'data-page-on', function(index, attr) {
			return attr == 'off' ? 'on' : 'off';
		});
		
		updateChosenPages();
	});
	
	function updateChosenCats() {
		var newCats = '';
		
		cats.find( '.skin-cat' ).each( function() {
			var cat = $(this);
			
			if( 'on' === cat.attr( 'data-cat-on' ) ) {
				var catID = cat.attr( 'data-cat-id' );
				
				newCats += catID + ',';
			}
		});
		
		chosenCats.val( newCats );
		chosenCats.change();
	}
		
	cats.on( 'click', '.skin-cat', function() {
		var cat = $(this),
			catID = cat.attr( 'data-cat-id' );
		
		cat.attr( 'data-cat-on', function(index, attr) {
			return attr == 'off' ? 'on' : 'off';
		});
		
		updateChosenCats();
	});
});