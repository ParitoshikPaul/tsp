/* ==============================================
	SHARE SELECTION scripts
	Skin - Premium WordPress Theme, by NordWood
================================================= */
jQuery(document).ready(function($) {
	"use strict";
	
	var fb = icons.icon_fb,
		tw = icons.icon_tw;
	
	function getRightClick(e) {
		var rightclick;
		
		if ( !e ) {
			var e = window.event;
		}
		
		if ( e.which ) {
			rightclick = (3 == e.which);
			
		} else if ( e.button ) {
			rightclick = ( 2 == e.button );
		}
		
		return rightclick;
	}

	function getSelectionText() {
	    var text = "";
		
	    if ( window.getSelection ) {
	        text = window.getSelection().toString();
			
	    } else if ( document.selection && "Control" != document.selection.type ) {
	        text = document.selection.createRange().text;
	    }
		
	    return text;
	}
	
// Init the share cloud when the user starts the selection
	$.fn.skinInitShareCloud = function() {
		$(this).mousedown( function (event) {
		/*
			Take the position of the mouse,
			set up the top and the left value as attribute on body tag.
		*/
			$('body').attr( 'mouse-top', event.clientY+window.pageYOffset );
			$('body').attr( 'mouse-left', event.clientX );

		/*
			Remove share button and the old selection.
			( Happens only if the user clicks the left button of the mouse,
			so the right click is still reserved for the genuine browser menu. )
		*/
			if ( !getRightClick(event) && 0 < getSelectionText().length ) {
				$('.share-cloud').remove();
				document.getSelection().removeAllRanges();
			}
		});
	}
	
// Open the share cloud when the user ends the selection
	$.fn.skinOpenShareCloud = function() {
		$(this).mouseup( function (event) {
			var t = $(event.target),
				st = getSelectionText();
		/*
			Continue with action,
			only if the user's click is a left mouse click
			and the selection length is grater than 3 characters.
		*/
			if ( 3 < st.length && ! getRightClick( event ) ) {
			// Get the top mouse position
				var mts = $('body').attr( 'mouse-top' ),
					mte = event.clientY+window.pageYOffset,
					mt;
				
				if( parseInt(mts) < parseInt(mte) ) {
					mt = mts;
					
				} else {
					mt = mte;
				}

			// Get the left mouse position
				var mlp = $('body').attr( 'mouse-left' ),
					mrp = event.clientX,
					ml = parseInt(mlp) + ( parseInt(mrp) - parseInt(mlp) )/2;
			
			/*
				Create the sharing link parameter that will be passed to social network,
				and set the maximum number of characters for the selection.
			*/
				var	sl = window.location.href.split('?')[0],
					maxl = 107;
					
				st = st.substring( 0, maxl );
			
			// Create the share cloud
				var share_cloud = '<span class="share-cloud">';
	
			// Twitter
				share_cloud += '<a class="social-icon round va-middle" href="https://twitter.com/intent/tweet?url=' + encodeURIComponent(sl) + '&text=' + encodeURIComponent(st) + '" target="_blank" onclick="window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600\');return false;">';
				share_cloud += tw;
				share_cloud += '</a>';
				
			// Facebook
				share_cloud += '<a class="social-icon round va-middle" onClick="window.open(\'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(sl) + '&picture=&title=&quote=' + encodeURIComponent(st) + '\',\'sharer\',\'toolbar=0,status=0,width=548,height=500\');" href="javascript: void(0)">';
				share_cloud += fb;
				share_cloud += '</a>';
				
				share_cloud += '</span>';
				
				$( 'body' ).append( share_cloud );
				
				var cloud_w = $( '.share-cloud' ).outerWidth();
				$( '.share-cloud .social-icon' ).skinIconFill2Background();
			/*
				Position the share cloud on calculated position,
				(top of selection and middle of it horizontaly)
				and show it when its ready.
			*/	
				$( '.share-cloud' ).css({
					position: 'absolute',
					top: parseInt(mt) - 60,
					left: parseInt(ml) - cloud_w/2
					
				}).delay(10).queue(function(){					
					$( '.share-cloud .social-icon' ).show(200).dequeue();
				});
			}
		});
	}	
	
	$( '.shareable-selections' ).skinInitShareCloud();
	$( '.shareable-selections' ).skinOpenShareCloud();
	
// Remove the share button on clicking outside the popout
	$(document).on( 'click', function(e) {
		if ( 0 === $(e.target).closest( $( '.shareable-selections' ) ).length ) {
			$( '.share-cloud .social-icon' ).hide(200).delay(100).queue(function(){
				$( '.share-cloud' ).remove().dequeue();
			});
		}
	});	
  
// Remove the share cloud on hitting the Esc key
	$(document).keyup(function(e) {
		if ( 27 === e.keyCode ) {
			$( '.share-cloud .social-icon' ).hide(200).delay(100).queue(function(){
				$( '.share-cloud' ).remove().dequeue();
			});
		}
	});
});