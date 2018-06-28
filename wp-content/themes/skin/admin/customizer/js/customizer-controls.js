/* ==============================================
	CUSTOMIZER CONTROLS
	Skin - Premium WordPress Theme, by NordWood
================================================= */
(function($) {
	"use strict";
	$(document).ready( function() {		
		var ctrlParent = customizer_args.ctrl_parent;
		
	/* Customize autocomplete field for tags
	========================================== */
		$('#customize-control-skin_blog_feature_recent_by_tag').find( 'input[type="text"]' ).suggest( window.ajaxurl + "?action=ajax-tag-search&tax=post_tag", {delay: 200, minchars: 2, multiple:true, multipleSep: ","});
		
	/* Customize checkbox and radio buttons	
	========================================== */
	// Customize checkbox	
		var checkboxCtrl = $( '.customize-control-checkbox' );
		checkboxCtrl.find( 'label' ).addClass( 'va-middle' ).append( '<span class="switch"></span>' );
			
		checkboxCtrl.each( function() {
			var checkbox = $(this),
				field = checkbox.find( 'input[type="checkbox"]' );
			
			if ( 'checked' === field.attr("checked") ) {
				checkbox.addClass("chckd");
				
			} else {
				checkbox.removeClass("chckd");
			}
				
			checkbox.on( "change", function() {
				if ( 'checked' === field.attr("checked") ) {
					checkbox.addClass("chckd");
					
				} else {
					checkbox.removeClass("chckd");
				}
			});
		});
		
	// Customize radio	
		var radio_control = $( '.customize-control-radio' );
		radio_control.find( 'label' ).addClass( 'va-middle' ).prepend( '<span class="switch"></span>' );
			
		radio_control.each( function() {
			var control = $(this),
				fields = control.find( 'input[type="radio"]' );
				
			fields.each( function() {
				var field = $(this);
				
				if ( 'row' === ctrlParent ) {				
					if( 'checked' === field.attr("checked") ) {
						field.closest('.customize-inside-control-row').addClass("chckd");
						
					} else {
						field.closest('.customize-inside-control-row').removeClass("chckd");
					}
						
					control.on( "change", function() {
						if( 'checked' === field.attr("checked") ) {
							field.closest('.customize-inside-control-row').addClass("chckd");
							
						} else {
							field.closest('.customize-inside-control-row').removeClass("chckd");
						}
					});
					
				} else {
					if ( 'checked' === field.attr("checked") ) {
						field.closest('label').addClass("chckd");
						
					} else {
						field.closest('label').removeClass("chckd");
					}
						
					control.on( "change", function() {
						if ( 'checked' === field.attr("checked") ) {
							field.closest('label').addClass("chckd");
							
						} else {
							field.closest('label').removeClass("chckd");
						}
					});
				}
			} );
		});
		
	/* Typography controls
	========================= */
		$( '.skin-typo-controls' ).each( function() {
			var typoGroup			= $(this),
				defaultValues		= $(this).find('.skin-typo-default').val().split('|'),
				families			= $(this).find('.skin-typo-font-family'),
				variants			= $(this).find('.skin-typo-font-variants'),
				subsets				= $(this).find('.skin-typo-lang-subsets'),
				fontSize			= $(this).find('.skin-typo-font-size'),
				lineHeight			= $(this).find('.skin-typo-line-height'),
				letterSpacing		= $(this).find('.skin-typo-letter-spacing'),
				txtTransform		= $(this).find('.skin-typo-text-transform'),
				typoCombined		= $(this).find('.skin-typo-controls-combined'),
				activeTypoSet		= typoCombined.val().split('|'),
				availableVariants	= families.find('option:selected').attr('data-font-variants').split(','),
				selectedVariants	= activeTypoSet[1].split(','),
				availableSubsets	= families.find('option:selected').attr('data-lang-subsets').split(','),
				selectedSubsets		= activeTypoSet[2].split(',');
				
		// Get the active font size value from the combined typo values
			fontSize.val( parseInt( activeTypoSet[3] ) );
			
		// Get the active line height value from the combined typo values
			lineHeight.val( parseInt( activeTypoSet[4] ) );
			
		// Get the active letter spacing value from the combined typo values
			letterSpacing.val( parseInt( activeTypoSet[5] ) );
			
		// Get the active text transform option from the combined typo values
			txtTransform.val( activeTypoSet[6] );
			
		// Show the available font variants		
			$.each( availableVariants, function( k, v ) {
				var selected = ( $.inArray( v, selectedVariants ) > -1 ) ? 'selected' : '';
				variants.append( '<option value="' + v + '" ' + selected + '>' + v + '</option>' );
			});
			
		// Show the available language subsets
			$.each( availableSubsets, function( k, v ) {
				var selected = ( $.inArray( v, selectedSubsets ) > -1 ) ? 'selected' : '';
				subsets.append( '<option value="'+v+'" ' + selected + '>' + v + '</option>' );
			});
				
		// When the font family selection is changed, update the font variants and the language subset field 	
			typoGroup.on( 'change', '.skin-typo-font-family', function() {
				var getNewVariants = $(this).find('option:selected').attr('data-font-variants'),
					getNewSubsets = $(this).find('option:selected').attr('data-lang-subsets');
				
			// Update the font variants options
				getNewVariants = getNewVariants.split(',');				
				variants.html('');
				
				$.each( getNewVariants, function( k, v ) {
					variants.append( '<option value="'+v+'">'+v+'</option>' );
				});
				
				variants.val('regular');
				
			// Update the language subsets options
				getNewSubsets = getNewSubsets.split(',');				
				subsets.html('');
				
				$.each( getNewSubsets, function( k, v ) {
					subsets.append('<option value="'+v+'">'+v+'</option>');
				});
				
				subsets.val('latin');
			
			// Update the combined field with new family selection and default variant and subsets
				updateTypoCombined();
			});
			
		// Update the combined field when any of the typography fields is changed
			typoGroup.on( 'change', '.skin-typo-font-variants', function() {	
				updateTypoCombined();
			});
	
			typoGroup.on( 'change', '.skin-typo-lang-subsets', function() {	
				updateTypoCombined();
			});
	
			typoGroup.on( 'keyup', '.skin-typo-font-size', function() {	
				updateTypoCombined();
			});
	
			typoGroup.on( 'keyup', '.skin-typo-line-height', function() {	
				updateTypoCombined();
			});
	
			typoGroup.on( 'keyup', '.skin-typo-letter-spacing', function() {	
				updateTypoCombined();
			});
	
			typoGroup.on( 'change', '.skin-typo-text-transform', function() {	
				updateTypoCombined();
			});
			
		// Reset all the fields to default values, when the "Default" button is clicked
			typoGroup.on( 'click', '.skin-typo-reset', function() {
				families.val( defaultValues[0] );
				variants.val( defaultValues[1] );
				subsets.val( defaultValues[2] );				
				fontSize.val( parseInt( defaultValues[3] ) );				
				lineHeight.val( parseInt( defaultValues[4] ) );				
				letterSpacing.val( parseInt( defaultValues[5] ) );				
				txtTransform.val( defaultValues[6] );
				
				updateTypoCombined();
			});
	
			function updateTypoCombined() {
				var newTypoCombined = families.val() + '|' + variants.val() + '|' + subsets.val() + '|' + fontSize.val().toString() +
					'|' + lineHeight.val().toString() + '|' + letterSpacing.val().toString() + '|' + txtTransform.val();
					
				typoCombined.val( newTypoCombined );
				
				typoCombined.change();
			}
		});
		
	/* Social profiles controls
	============================== */
		$( '.skin-social-profiles-controls' ).each( function() {
			var socialsCtrl		= $(this),
				iconsList		= $(this).find('.skin-social-profiles-icon'),
				overlay			= $(this).find('.skin-social-profiles-popout'),
				profile			= overlay.find('label'),
				profileField	= $(this).find('.skin-social-profiles-active'),
				socialsCombined	= $(this).find('.skin-social-profiles-combined'),
				activeNetwork,
				networkName,
				newSocials,
				icon;
			
			socialsCtrl.on( 'click', '.skin-social-profiles-icon', function(e) {				
			// Prepare popout for chosen network	
				activeNetwork = $(e.target).closest( '.skin-social-profiles-icon' );				
				networkName = activeNetwork.attr( 'data-network-name' );				
				profile.text( networkName + 'profile URL:' );
				profileField.val( '' );
				
				if ( activeNetwork.attr( 'data-profile-url' ) ) {
					profileField.val( activeNetwork.attr( 'data-profile-url' ) );					
				}
				
				profile.text( networkName + ' profile URL:' );
				
			// Open popout
				overlay.fadeIn(200);
				profileField.focus();
	
			// Update data value on change
				overlay.on( 'keyup', '.skin-social-profiles-active', function() {
					activeNetwork.attr( "data-profile-url", profileField.val() );
					
					update_socialsCombined();
				});				
			});
	
			function update_socialsCombined() {
				newSocials = '';
				
				iconsList.each( function() {
					icon = $(this);
					
					if ( icon.attr( 'data-profile-url' ) ) {
						icon.attr( 'data-has-profile', 'active' );
						newSocials += '-network-' + icon.attr( 'data-network-name' ) + '-link-' + icon.attr( 'data-profile-url' );
					
					} else {
						icon.attr( 'data-has-profile', '' );
					}
				});
				
				socialsCombined.val( newSocials );
				socialsCombined.change();
			}
			
		// Close when close button is clicked
			overlay.on( 'click', '.skin-close-button', function(e) {
				overlay.fadeOut(100);
			});
			
		// Close on click outside the popout	
			$(document).on( 'click', function(e) {
				if ( $(e.target).closest( $('.skin-social-profiles-icon') ).length === 0 && $(e.target).closest( $('.skin-social-profiles-popout') ).length === 0 ) {
					overlay.fadeOut(100);
				}
			});
			
		// Close on hitting the "Enter" key
			$(document).keypress(function(e) {
				if ( e.keyCode == 10 || e.keyCode == 13 ) {
					e.preventDefault();
					overlay.fadeOut(100);
				}
			});
		});
	
// Control sharing links
	$( '.skin-sharing-links-controls' ).each( function() {
		var socialsCtrl		= $(this),
			iconsList		= $(this).find('.skin-sharing-links-icon'),
			socialsCombined	= $(this).find('.skin-sharing-links-combined'),
			activeNetwork,
			newSocials,
			icon;
		
		socialsCtrl.on( 'click', '.skin-sharing-links-icon', function(e) {			
		// Prepare popout for chosen network	
			icon = $( this );
				
			if ( 'on' === icon.attr( 'data-is-active' ) ) {
				icon.attr( 'data-is-active', 'off' );
				
			} else if ( 'off' === icon.attr( 'data-is-active' ) ) {
				icon.attr( 'data-is-active', 'on' );
			}

					
		// Update data value on change
			updateSharingButtons();
		});

		function updateSharingButtons() {
			newSocials = '';
			
			iconsList.each( function() {
				icon = $(this);
				
				if ( 'on' === icon.attr( 'data-is-active' ) ) {
					newSocials += '-network-' + icon.attr( 'data-network-name' );				
				}
			});
			
			socialsCombined.val( newSocials );
			socialsCombined.change();
		}
	});
	});
})(jQuery);