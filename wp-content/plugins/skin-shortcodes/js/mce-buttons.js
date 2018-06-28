/* ===========================
	SCRIPTS FOR MCE BUTTONS
	Skin Shortcodes plugin
	Version: 1.0
	Author: NordWood Themes
=============================== */
jQuery( function($) {
    "use strict";
/*
	Helper function to insert each shortcode in editor, with the selected attributes
*/
	function setAtts( editor, atts ) {
		var shcTitle = !_.isUndefined( atts.title ) ? atts.title : 'Add a shortcode';
		var shcTag = !_.isUndefined( atts.shcTag ) ? atts.shcTag : false;

		var insertShc = function() {
			editor.windowManager.open({
				title: shcTitle,
				body: atts.body,
				onsubmit: function(e) {
					var shcContent = '[' + shcTag;
					
					for ( var attr in e.data ) {
						shcContent += ' ' + attr + '="' + e.data[ attr ] + '"';
					}
					
					shcContent += '/]';					
					editor.insertContent( shcContent );
				},
			});
		};
		
		return insertShc;
	}
  
	function createColorPickAction( editor ) {
		var colorPickerCallback = editor.settings.color_picker_callback;

		if ( colorPickerCallback ) {
			return function() {
				var self = this;

				colorPickerCallback.call(
					editor,
					function(value) {
						self.value(value).fire('change');
					},
					self.value()
				);
			};
		}
	}

	tinymce.PluginManager.add( 'skin_sc_mce_bttns', function( editor, url ) {
	// Add the shortcodes menu button
		editor.addButton( 'skin_sc_mce_bttns', {
			text: 'Shortcodes',
			icon: 'icon nordwood-button-icon',
            type: 'menubutton',
			classes: 'nordwood-editor-button',
			menu: [
		// Wave divider
				{
					text: 'Wave Divider',
					onclick: setAtts( editor, {
						title: 'Wave Divider',
						plugins: 'colorpicker',
						body: [
							{
								type: 'listbox',
								name: 'position',
								label: 'Position',
								values : [
									{ text: 'Horizontal', value: 'horizontal', selected: true },
									{ text: 'Vertical', value: 'vertical' }
								]
							},
							{
								type: 'listbox',
								name: 'align',
								label: 'Align',
								values : [
									{ text: 'Left', value: 'left' },
									{ text: 'Center', value: 'center', selected: true },
									{ text: 'Right', value: 'right' }
								]
							},
							{
								type   : 'colorbox',
								name   : 'color',
								label  : 'Color',
								onaction: createColorPickAction( editor ),
								value: '#353535'
							},
							{
								type: 'checkbox',
								name: 'animate',
								label: 'Animate',
								checked: true
							}
						],
						shcTag: 'skin-wave-divider'
					}),
				},
		// Link button
				{
					text: 'Link Button',
					onclick: setAtts( editor, {
						title: 'Link Button',
						body: [
							{
								type: 'textbox',
								name: 'text',
								label: 'Button text',
								value: 'Check this out'
							},
							{
								type: 'textbox',
								minWidth: 320,
								name: 'url',
								label: 'Full URL',
								value: ''
							}
						],
						shcTag: 'skin-link-button'
					}),
				},
			// Social Profiles
				{
					text: 'Social Profiles',
					onclick: setAtts( editor, {
						title: 'Links to social profiles',
						plugins: 'autoresize',
						body: [
							{
								type: 'listbox',
								name: 'align',
								label: 'Align',
								values : [
									{ text: 'Left', value: 'left' },
									{ text: 'Center', value: 'center', selected: true },
									{ text: 'Right', value: 'right' }
								]
							}
						],
						shcTag: 'skin-social-profiles'
					}),
				},
			// Share buttons
				{
					text: 'Share buttons',
					onclick: setAtts( editor, {
						title: 'Share buttons',
						plugins: 'autoresize',
						body: [
							{
								type: 'textbox',
								name: 'heading',
								label: 'Heading',
								value: 'Share'
							},							
							{
								type: 'listbox',
								name: 'align',
								label: 'Align',
								values : [
									{ text: 'Left', value: 'left' },
									{ text: 'Center', value: 'center', selected: true },
									{ text: 'Right', value: 'right' }
								]
							}
						],
						shcTag: 'skin-share-buttons'
					}),
				},
			// Google map
				{
					text: 'Google map',
					onclick: setAtts( editor, {
						title: 'Google Map',
						plugins: 'autoresize',
						body: [
							{
								type: 'textbox',
								name: 'latitude',
								label: 'Latitude',
								value: ''
							},
							{
								type: 'textbox',
								name: 'longitude',
								label: 'Longitude',
								value: ''
							},
							{
								type: 'textbox',
								name: 'address',
								label: 'Full address',
								value: ''
							},
							{
								type: 'textbox',
								name: 'pin_title',
								label: 'Pin title',
								value: ''
							},
							{
								type: 'textbox',
								name: 'pin_url',
								label: 'Pin image url',
								value: ''
							},
							{
								type: 'textbox',
								name: 'zoom',
								label: 'Map zoom (1-20, default: 15)',
								value: '15'
							},
							{
								type: 'textbox',
								name: 'height',
								label: 'Map height (default: 300)',
								value: '300'
							},
							{
								type: 'checkbox',
								name: 'enlarge',
								label: 'Enlarge map',
								checked: false
							}
						],
						shcTag: 'skin-map'
					}),
				},
			// Related Posts
				{
					text: 'Related Posts',
					onclick: setAtts( editor, {
						title: 'Related Posts',
						plugins: 'autoresize',
						body: [
							{
								type: 'textbox',
								name: 'heading',
								label: 'Heading',
								value: 'You may also like'
							},
							{
								type: 'textbox',
								name: 'qty',
								label: 'Max number of posts',
								value: '6'
							}
						],
						shcTag: 'skin-related-posts'
					}),
				}
			]
		});
	
	/*
		Helper function to get the inserted values for shortcode attributes,
		or empty string, if no value is assigned
	*/
		function getShcAtts( str, name ) {
			name = new RegExp( name + '=\"([^\"]+)\"' ).exec( str );
			
			return name ? window.decodeURIComponent( name[1] ) : '';
		}
	
	/*
		Enable custom render for each shortcode inserted in the editor
	*/
		var errSign = ' <span class="err">&xotime;</span>',
			errMssg = '<p class="err">Something is missing :( Check out the fields again, please.</p>';

	// Wave divider
		window.wp.mce.views.register( 'skin-wave-divider', {
		// Create shortcode wrapper	
		    initialize: function() {
				var position	= getShcAtts( this.text, 'position' ),
					color		= getShcAtts( this.text, 'color' );
					
				var waveClass = 'wave';
				
				if ( 'vertical' === position ) {
					waveClass += ' ver';
				}
					
			    var preview = '<div class="skin-sc-wrapper">';
				
			    preview += '<h6>Wave Divider</h6>';				
				preview += '<div style="color:' + color + '" class="' + waveClass + '"></div>';				
				preview += '</div>';
				
			    this.render( preview );
			},
			edit: function( text, update ) {
				editor.windowManager.open( {
					plugins: 'colorpicker',
					title: 'Wave Divider',
					body: [
						{
							type: 'listbox',
							name: 'position',
							label: 'Position',
							values : [
								{ text: 'Horizontal', value: 'horizontal' },
								{ text: 'Vertical', value: 'vertical' }
							],
							value: getShcAtts( text, 'position' )
						},
						{
							type: 'listbox',
							name: 'align',
							label: 'Align',
							values : [
								{ text: 'Left', value: 'left' },
								{ text: 'Center', value: 'center' },
								{ text: 'Right', value: 'right' }
							],
							value: getShcAtts( text, 'align' )
						},
						{
							type   : 'colorbox',
							name   : 'color',
							label  : 'Color',
							onaction: createColorPickAction( editor ),
							value: getShcAtts( text, 'color' )
						},
						{
							type: 'checkbox',
							name: 'animate',
							label: 'Animate',
							checked: getShcAtts( text, 'animate' ) == 'true'
						}
					],
					onsubmit: function( e ) {
						var shcContent = '[skin-wave-divider';
						
						for ( var attr in e.data ) {
							shcContent += ' ' + attr + '="' + e.data[ attr ] + '"';
						}
						
						shcContent += '/]';
						
						update( shcContent );
					}
				});
			},
		});
		
	// Link Button
		window.wp.mce.views.register( 'skin-link-button', {
		// Create shortcode wrapper	
		    initialize: function() {
				var txt = getShcAtts( this.text, 'text' ),
					link = getShcAtts( this.text, 'url' ),
					success = true;
					
				if ( !txt || !link ) {
					success = false;
				}
					
			    var preview = '<div class="skin-sc-wrapper">';
				
			    preview += '<h6>Link Button';
			    
				if ( !success ) {
					preview += errSign;
				}
				
			    preview += '</h6>';
				
				if ( !success ) {
					preview += errMssg;
					
				} else {
					preview += '<p>« ' + txt + ' »</p>';
				}
				
				preview += '</div>';
				
			    this.render( preview );
			},
			edit: function( text, update ) {
				editor.windowManager.open( {
					title: 'Link button',
					body: [
						{
							type: 'textbox',
							name: 'text',
							label: 'Button Text',
							value: getShcAtts( text, 'text' )
						},
						{
							type: 'textbox',
							name: 'url',
							label: 'Full URL',
							value: getShcAtts( text, 'url' )
						}
					],
					onsubmit: function( e ) {
						if( '' === e.data.text || '' === e.data.url ) {
							var windowID = this._id;
							var inputs = jQuery('#' + windowID + '-body').find( '.mce-formitem input' );
					 
							editor.windowManager.alert( 'Please fill in all the fields in this popup.' );
					 
							if( '' === e.data.text ) {
								$( inputs.get(0) ).css( 'border-color', '#f00' );
							}
					 
							if( '' === e.data.url ) {
								$( inputs.get(1) ).css( 'border-color', '#f00' );
							}
					 
							return false;
						}

						var shcContent = '[skin-link-button';
						
						for ( var attr in e.data ) {
							shcContent += ' ' + attr + '="' + e.data[ attr ] + '"';
						}
						
						shcContent += '/]';
						
						update( shcContent );
					}
				});
			},
		});
		
	// Social Profiles
		window.wp.mce.views.register( 'skin-social-profiles', {
		    initialize: function() {
			    var preview = '<div class="skin-sc-wrapper">';
			    
				preview += '<h6>Social Profiles</h6>';
				preview += '</div>';
				
			    this.render( preview );
			},
			edit: function( text, update ) {
				editor.windowManager.open( {
					plugins: 'autoresize',
					title: 'Social profiles',
					body: [
						{
							type: 'listbox',
							name: 'align',
							label: 'Align',
							values : [
								{ text: 'Left', value: 'left' },
								{ text: 'Center', value: 'center' },
								{ text: 'Right', value: 'right' }
							],
							value: getShcAtts( text, 'align' )
						}
					],
					onsubmit: function( e ) {
						var shcContent = '[skin-social-profiles';
						
						for ( var attr in e.data ) {
							shcContent += ' ' + attr + '="' + e.data[ attr ] + '"';
						}
						
						shcContent += '/]';
						
						update( shcContent );
					},
				});
			},
		});
		
	// Share buttons
		window.wp.mce.views.register( 'skin-share-buttons', {
		    initialize: function() {
			    var preview = '<div class="skin-sc-wrapper">';			    
				preview += '<h6>Share Buttons</h6>';
				
			    var txt = getShcAtts( this.text, 'heading' );
				
			    if ( txt ) {
			    	preview += '<p>« ' + txt + ' »</p>';
			    }

				preview += '</div>';
				
			    this.render( preview );
			},
			edit: function( text, update ) {
				editor.windowManager.open( {
					plugins: 'autoresize',
					title: 'Share buttons',
					body: [
						{
							type: 'textbox',
							name: 'heading',
							label: 'Heading',
							value: getShcAtts( text, 'heading' )
						},							
						{
							type: 'listbox',
							name: 'align',
							label: 'Align',
							values : [
								{ text: 'Left', value: 'left' },
								{ text: 'Center', value: 'center' },
								{ text: 'Right', value: 'right' }
							],
							value: getShcAtts( text, 'align' )
						}
					],
					onsubmit: function( e ) {
						var shcContent = '[skin-share-buttons';
						
						for ( var attr in e.data ) {
							shcContent += ' ' + attr + '="' + e.data[ attr ] + '"';
						}
						
						shcContent += '/]';
						
						update( shcContent );
					},
				});
			},
		});
		
	// Google Map
		window.wp.mce.views.register( 'skin-map', {
		    initialize: function() {
				var lat = getShcAtts( this.text, 'latitude' ),
					lng = getShcAtts( this.text, 'longitude' ),
					addr = getShcAtts( this.text, 'address' ),
					success = true;
					
				if ( !(lat && lng) && !addr ) {
					success = false;
				}
					
			    var preview = '<div class="skin-sc-wrapper">';
				
			    preview += '<h6>Google Map';
			    
				if ( !success ) {
					preview += errSign;
				}
				
			    preview += '</h6>';
				
				if ( !success ) {
					preview += errMssg;
					
				} else {
					if ( lat && lng ) {
						preview += '<p>« Latitude: ' + lat + ' | Longitude:  ' + lng + ' »</p>';
						
					} else if( addr ) {	
						preview += '<p>« Address: ' + addr + ' »</p>';
					}					
				}
				
				preview += '</div>';
			    this.render( preview );				
			},
			edit: function( text, update ) {
				editor.windowManager.open( {
					plugins: 'autoresize',
					title: 'Google Map',
					body: [
						{
							type: 'textbox',
							name: 'latitude',
							label: 'Latitude',
							value: getShcAtts( text, 'latitude' )
						},
						{
							type: 'textbox',
							name: 'longitude',
							label: 'Longitude',
							value: getShcAtts( text, 'longitude' )
						},
						{
							type: 'textbox',
							name: 'address',
							label: 'Full address',
							value: getShcAtts( text, 'address' )
						},
						{
							type: 'textbox',
							name: 'pin_title',
							label: 'Pin title',
							value: getShcAtts( text, 'pin_title' )
						},
						{
							type: 'textbox',
							name: 'pin_url',
							label: 'Pin image url',
							value: getShcAtts( text, 'pin_url' )
						},
						{
							type: 'textbox',
							name: 'zoom',
							label: 'Map zoom (1-20, default: 15)',
							value: getShcAtts( text, 'zoom' )
						},
						{
							type: 'textbox',
							name: 'height',
							label: 'Map height (default: 300)',
							value: getShcAtts( text, 'height' )
						},
						{
							type: 'checkbox',
							name: 'enlarge',
							label: 'Enlarge map',
							checked: getShcAtts( text, 'enlarge' ) == 'true'
						}
					],
					onsubmit: function(e) {						
						if ( '' === e.data.address && ( '' === e.data.latitude || '' === e.data.longitude ) ) {
							var windowID = this._id;
							var inputs = jQuery('#' + windowID + '-body').find( '.mce-formitem input' );
					 
							editor.windowManager.alert( 'Please fill in either both coordinates or full address.' );
							
							$( inputs.get(0) ).css( 'border-color', '#f00' );
							$( inputs.get(1) ).css( 'border-color', '#f00' );
							$( inputs.get(2) ).css( 'border-color', '#f00' );
							
							return false;		
						}

						var shcContent = '[skin-map';
						
						for ( var attr in e.data ) {
							shcContent += ' ' + attr + '="' + e.data[ attr ] + '"';
						}
						
						shcContent += '/]';
						
						update( shcContent );
					}
				} );
			}
		});
		
	// Related Posts
		window.wp.mce.views.register( 'skin-related-posts', {
		    initialize: function() {				
			    var preview = '<div class="skin-sc-wrapper">';				
			    var heading = getShcAtts( this.text, 'heading' );
				
			    preview += '<h6>Related Posts</h6>';
				
				if( heading ) {				
					preview += '<p>« ' + heading + ' »</p>';					
				}
				
				preview += '</div>';
				
			    this.render( preview );				
			},
			edit: function( text, update ) {
				editor.windowManager.open( {
					plugins: 'autoresize',
					title: 'Related Posts',
					body: [
						{
							type: 'textbox',
							name: 'heading',
							label: 'Heading',
							value: getShcAtts( text, 'heading' )
						},
						{
							type: 'textbox',
							name: 'qty',
							label: 'Max number of posts',
							value: getShcAtts( text, 'qty' )
						}
					],
					onsubmit: function( e ) {
						var shcContent = '[skin-related-posts';
						
						for ( var attr in e.data ) {
							shcContent += ' ' + attr + '="' + e.data[ attr ] + '"';
						}
						
						shcContent += '/]';
						
						update( shcContent );
					}
				});
			}
		});
	});
});