<?php /* ========================================
	Plugin Name:    Skin Shortcodes
	Description:    Shortcodes for Skin theme
	Version:		1.1
	Author:         NordWood Themes
	Author URI:		http://nordwoodthemes.com/
	Text Domain:	skin-shortcodes
================================================= */	
/*	TinyMCE button for shortcodes
=================================== */
	add_action( 'admin_head', 'skin_sc_mce_bttns' );
	
	function skin_sc_mce_bttns() {
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
			return;
		}
		
		if ( 'true' == get_user_option( 'rich_editing' ) ) {
			add_filter( 'mce_external_plugins', 'skin_shortcodes_add_tinymce_plugin' );
			add_filter( 'mce_buttons', 'skin_shortcodes_register_mce_buttons' );
		}
	}

// Declare scripts for the new button
	function skin_shortcodes_add_tinymce_plugin( $plugin_array ) {
		$plugin_array['skin_sc_mce_bttns'] = plugin_dir_url( __FILE__ ) .'js/mce-buttons.js';
		return $plugin_array;
	}

// Register the new button in the editor
	function skin_shortcodes_register_mce_buttons( $buttons ) {
		array_push( $buttons, 'skin_sc_mce_bttns' );
		return $buttons;
	}	
	
// Add the styles
	add_action( 'admin_print_styles', 'skin_sc_mce_bttns_styles' );
	
	function skin_sc_mce_bttns_styles() {
		$screen = get_current_screen();
		
		if ( null != $screen ) {
			if ( 'page' == $screen->id || 'post' == $screen->id || 'popout' == $screen->id ) {
				wp_enqueue_style(
					'skin_sc_mce_bttns_styles',
					plugin_dir_url( __FILE__ ) . 'css/mce-styles.css'
				);
			}
		}
	}	
	
	add_action( 'admin_init', 'skin_shortcodes_mce_styles' );
	
	function skin_shortcodes_mce_styles() {
		global $editor_styles;		
		$editor_styles[] = plugins_url( '/css/mce-styles.css', __FILE__ );
	}
	
/*	Shortcode: The Link Button
================================ */
	add_shortcode( 'skin-wave-divider', 'skin_shortcodes_wave_divider' );
	
	function skin_shortcodes_wave_divider( $atts ) {
		$atts = shortcode_atts(
			array(
				'position'	=> 'horizontal',
				'align' 	=> 'center',
				'color' 	=> '#353535',
				'animate' 	=> 'true'
			),
			$atts,
			'skin-wave-divider'
		);
		
		$not_skin = 'skin' !== wp_get_theme()->get( 'TextDomain' ) && 'skin-child' !== wp_get_theme()->get( 'TextDomain' );
		
		if ( $not_skin ) {
			return '';
			
		} else {
			$wrapper_class = 'wave-divider skin-shortcodes';
		
			$pos = 'horizontal' === $atts['position'] ? 'hor' : 'ver';
			$wrapper_class .= ' ' . $pos;
			
			$align = $atts['align'];
			$wrapper_class .= ' ' . $align;
			
			$output = '';
			
		// Open container
			$output .= sprintf(
				'<div class="%1$s">',
				esc_attr( $wrapper_class )
			);
			
			$wave_class = 'wave';
			
			$wave_class .= ' ' . $pos;
			
			$wave_color = $atts['color'];
			
			if( 'true' === $atts['animate'] ) {
				$wave_class .= ' anim';
			}
			
			if ( 'hor' === $pos ) {
				$wave = skin_get_icon_wave_hor( $wave_color );
				
				if ( 'true' === $atts['animate'] ) {
					$wave .= skin_get_icon_wave_hor( $wave_color );
				}
				
			} else if ( 'ver' === $pos ) {
				$wave = skin_get_icon_wave_ver( $wave_color );
				
				if ( 'true' === $atts['animate'] ) {
					$wave .= skin_get_icon_wave_ver( $wave_color );
				}
			}
			
		// Insert wave
			$output .= sprintf(
				'<div class="%1$s" data-color="%2$s">%3$s</div>',
				esc_attr( $wave_class ),
				esc_attr( $wave_color ),
				$wave
			);
			
		// Close container	
			$output .= '</div>';
			
			return $output;
		}
	}
	
/*	Shortcode: The Link Button
================================ */	
	add_shortcode( 'skin-link-button', 'skin_shortcodes_link_button' );
	
	function skin_shortcodes_link_button( $atts ) {
		$atts = shortcode_atts(
			array(
				'text' 	=> esc_html__( 'Check this out' , 'skin-shortcodes' ),
				'url' 	=> ''
			),
			$atts,
			'skin-link-button'
		);
		
		$not_skin = 'skin' !== wp_get_theme()->get( 'TextDomain' ) && 'skin-child' !== wp_get_theme()->get( 'TextDomain' );
		
		$txt = $atts['text'];
		$link = $atts['url'];
		
		$atts_missing = !$txt || !$link;
	
	/*
		This shortcode works only with Skin and its child theme,
		so first check if it's active
	*/
		if ( $not_skin || $atts_missing ) {
			return '';
			
		} else {
			$output = '';
			
		// Open the link wrapper
			$output .= sprintf(
				'<a href="%1$s" class="link-button skin-shortcodes va-middle skin-outlined-bttn skin-anim-bttn" target="_blank">%2$s</a>',
				esc_url( $link ),
				esc_html( $txt )
			);
			
			return $output;
		}
	}
	
/*	Social profiles
===================== */
	add_shortcode( 'skin-social-profiles', 'skin_shortcodes_social_profiles' );
	
	function skin_shortcodes_social_profiles($atts) {
		$atts = shortcode_atts(
			array(
				'align' => 'center'
			),
			$atts,
			'skin-social-profiles'
		);
		
		$not_skin = 'skin' !== wp_get_theme()->get( 'TextDomain' ) && 'skin-child' !== wp_get_theme()->get( 'TextDomain' );
	
	/*
		This shortcode works only with Skin and its child theme,
		so first check if it's active
	*/
		if ( $not_skin ) {
			return '';
			
		} else {
			$output = '';
			
			$output .= sprintf(
				'<div class="%s social-profiles skin-shortcodes va-middle">',
				esc_attr( $atts['align'])
			);
			
			$output .= skin_social_profiles();			
			$output .= '</div>';
		
			return $output;
		}
	}

/*	Social share
================== */
	add_shortcode( 'skin-share-buttons', 'skin_shortcodes_share_buttons' );
	
	function skin_shortcodes_share_buttons($atts) {
		$atts = shortcode_atts(
			array(
				'heading'	=> esc_html__( 'Share' , 'skin-shortcodes' ),
				'align'		=> 'center'
			),
			$atts,
			'skin-share-buttons'
		);
		
		$not_skin = 'skin' !== wp_get_theme()->get( 'TextDomain' ) && 'skin-child' !== wp_get_theme()->get( 'TextDomain' );
	
	/*
		This shortcode works only with Skin and its child theme,
		so first check if it's active
	*/
		if ( $not_skin ) {
			return '';
			
		} else {
			$output = '';
			
		// Open the social share wrapper
			$output .= sprintf(
				'<div class="%s share va-middle skin-shortcodes">',
				esc_attr( $atts['align'])
			);
			
		// Add the share heading
			$output .= '<div class="share-heading txt-color-to-svg">';			
			$output .= skin_get_icon_share();
			
			if ( '' != $atts['heading'] ) {
				$output .= sprintf(
					'<h5>%s</h5>',
					esc_html( $atts['heading'] )
				);
			}
			
			$output .= '</div>';
			
		// Add the share icons
			$output .= '<div class="share-icons">';			
			$output .= skin_share_buttons( get_the_ID() );			
			$output .= '</div>';
			
		// Close the social share wrapper
			$output .= '</div>';
			
			return $output;
		}
	}

/*	Google map
================ */
	add_shortcode( 'skin-map', 'skin_shortcodes_map' );
	
	function skin_shortcodes_map($atts) {
		$atts = shortcode_atts(
			array(
				'latitude' 	=> '',
				'longitude' => '',
				'address' 	=> '',
				'pin_title' => '',
				'pin_url' 	=> 'https://chart.googleapis.com/chart?chst=d_map_pin_icon&chld=location|2b2b2b',
				'zoom' 		=> '15',
				'height' 	=> '300',
				'enlarge' 	=> 'false'
			),
			$atts,
			'skin-map'
		);
		
		$not_skin = 'skin' !== wp_get_theme()->get( 'TextDomain' ) && 'skin-child' !== wp_get_theme()->get( 'TextDomain' );
		
		$lat = $atts['latitude'];
		$lng = $atts['longitude'];
		$addr = $atts['address'];
		
		$atts_missing = !($lat && $lng) && !$addr;
	
	/*
		This shortcode works only with Skin and its child theme,
		so first check if it's active
	*/
		if ( $not_skin || $atts_missing ) {
			return '';
			
		} else {
			$output = '';
			
			$pin_url	= $atts['pin_url'] ? $atts['pin_url'] : 'https://chart.googleapis.com/chart?chst=d_map_pin_icon&chld=location|2b2b2b';
			$pin_title	= $atts['pin_title'];
			$zoom		= $atts['zoom'] ? $atts['zoom'] : 15;
			$h			= $atts['height'] ? $atts['height'] : 300;
			$enlarge	= 'true' === $atts['enlarge'] ? 'enlarged' : '';
		
			$output .= sprintf(
				'<div class="skin-map-holder skin-shortcodes clearfix"><div id="%9$s"
					class="google-map %1$s" style="height:%2$dpx"
					data-map-zoom="%3$d"
					data-map-lat="%4$s"
					data-map-lng="%5$s"
					data-map-address="%6$s"
					data-map-pin="%7$s"
					data-map-title="%8$s"></div></div>',
				esc_attr( $enlarge ),
				absint( $h ),
				absint( $zoom ),
				esc_attr( $lat ),
				esc_attr( $lng ),
				esc_attr( $addr ),
				esc_url_raw( $pin_url ),
				esc_attr( $pin_title ),
				esc_attr( uniqid("map_",true) )
			);
		
			return $output;
		}
	}
	
/*	Related posts
=================== */	
	add_shortcode( 'skin-related-posts', 'skin_shortcodes_related_posts' );
	
	function skin_shortcodes_related_posts( $atts ) {
		$atts = shortcode_atts(
			array(
				'heading'	=> '',
				'qty'		=> '6'
			),
			$atts,
			'skin-related-posts'
		);
		
		$not_skin = 'skin' !== wp_get_theme()->get( 'TextDomain' ) && 'skin-child' !== wp_get_theme()->get( 'TextDomain' );
	
	/*
		This shortcode works only with Skin and its child theme,
		so first check if it's active
	*/
		if ( $not_skin ) {
			return '';
			
		} else {
			$output = '';
		
			$heading = $atts['heading'];
			$qty = absint( $atts['qty'] );
			
			$output .= '<div class="skin-shortcodes">';
			$output .= skin_related_posts( $heading, $qty );
			$output .= '</div>';
			
			return $output;
		}
	}
?>