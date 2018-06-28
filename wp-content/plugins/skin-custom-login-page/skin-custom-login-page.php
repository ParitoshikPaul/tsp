<?php /* ===========================================
	Plugin Name:    Skin Custom Login Page
	Description:    Custom login page for wp-admin
	Version:		2.0
	Author:         NordWood Themes
	Author URI:		http://nordwoodthemes.com/
	Text Domain:	skin-custom-login-page
==================================================== */
	if ( ! function_exists( 'skin_admin_fonts_url' ) ) :
		function skin_admin_fonts_url() {
			$fonts_url = '';
			
		/* Translators: If there are characters in your language that are not
		* supported by Raleway, translate this to 'off'. Do not translate
		* into your own language.
		*/			
			$raleway = esc_attr_x( 'on', 'Raleway font: on or off', 'skin-custom-login-page' );
 
			if ( 'off' !== $raleway ) {
				$fonts_url = add_query_arg( 'family', rawurlencode( 'Raleway:400,500,600,700&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
			}
			
			return esc_url_raw( $fonts_url );
		}
	endif;

	add_action( 'login_enqueue_scripts', 'skin_login_page' );
	
	if ( ! function_exists( 'skin_login_page' ) ) :
		function skin_login_page() {
			wp_enqueue_style(
				'skin-admin-fonts',
				skin_admin_fonts_url(),
				array(),
				null
			);
			
			wp_enqueue_style(
				'skin_login_page',
				plugins_url( '/css/login.css' , __FILE__ )
			);
			
			wp_register_script(
				'skin_login_page',
				plugins_url( '/js/login.js' , __FILE__ ),
				array('jquery'),
				'',
				true
			);
			
			$logo = get_theme_mod( 'skin_admin_login_logo' );
			
			$bgr = get_theme_mod( 'skin_admin_login_bgr', 'image' );
			$bgr_img = get_theme_mod( 'skin_admin_login_bgr_img', plugins_url( '/img/nordwood/login-page-bgr.jpg' , __FILE__ ) );
			$bgr_color = get_theme_mod( 'skin_admin_login_bgr_color', '#e6e7ec' );
			$text_color = get_theme_mod( 'skin_admin_login_txt_color', '#373c47' );
			
			$fields_bgr_color = get_theme_mod( 'skin_admin_login_fields_bgr', '#fff' );
			$fields_bgr_opacity = get_theme_mod( 'skin_admin_login_fields_opacity', 100 );			
			$fields_bgr = skin_hex2rgba( $fields_bgr_color, 0.01*$fields_bgr_opacity );
			
			$args = array(
				'logo' 					=> esc_url_raw( $logo ),
				'bgr' 					=> esc_attr( $bgr ),
				'bgr_img' 				=> esc_url_raw( $bgr_img ),
				'bgr_color' 			=> esc_attr( $bgr_color ),
				'text_color' 			=> esc_attr( $text_color ),
				'fields_bgr' 			=> esc_attr( $fields_bgr ),
				'fields_solid_color'	=> esc_attr( $fields_bgr_color )
			);
			
			wp_localize_script( 'skin_login_page', 'args', $args );
			wp_enqueue_script( 'skin_login_page' );
		}
	endif;
	
	function skin_admin_logo_url() {
		return esc_url( home_url( '/' ) );
	}
	
	add_filter( 'login_headerurl', 'skin_admin_logo_url' );

	function skin_admin_logo_url_title() {
		$title = get_theme_mod( 'skin_admin_login_title', esc_html__( 'Skin login page', 'skin-custom-login-page' ) );
		
		return esc_attr( $title );
	}
	
	add_filter( 'login_headertitle', 'skin_admin_logo_url_title' );
	
/*	Customizer
================ */  
	if ( !function_exists( 'skin_admin_customizer' ) ) : 
		function skin_admin_customizer( $wp_customize ) {
		// Skin custom login page
			$wp_customize->add_section( 'skin_admin_login', array(
				'title'    => esc_html__( 'Skin Custom Login Page', 'skin-custom-login-page' ),
				'priority' => 20
			));
	
		// Login page title
			$wp_customize->add_setting( 'skin_admin_login_title', array(
				'default'           => esc_html__( 'Skin login page', 'skin-custom-login-page' ),
				'capability'     	=> 'edit_theme_options',
				'transport' 		=> 'postMessage',
				'type'           	=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field'
			));
			
			$wp_customize->add_control( 'skin_admin_login_title', array(
				'label'		=> esc_html__( 'Title', 'skin-custom-login-page' ),
				'section'	=> 'skin_admin_login',
				'settings'	=> 'skin_admin_login_title',
				'type'		=> 'text'
			));
	
		// Login page logo
			$wp_customize->add_setting( 'skin_admin_login_logo', array(
				'capability'     	=> 'edit_theme_options',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'esc_url_raw',
				'type'           	=> 'theme_mod'
			));
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'skin_admin_login_logo', array(
				'label'				=> esc_html__( 'Logo image', 'skin-custom-login-page' ),
				'description'		=> esc_html__( 'To be placed below the title', 'skin-custom-login-page' ),
				'section'			=> 'skin_admin_login',
				'settings'			=> 'skin_admin_login_logo'
			)));
	
		// Login page background
			$wp_customize->add_setting(	'skin_admin_login_bgr', array(
				'default'			=> 'image',
				'transport' 		=> 'postMessage',
				'capability'     	=> 'edit_theme_options',
				'type'           	=> 'theme_mod',
				'sanitize_callback' => 'skin_sanitize_choices'
			));
			
			$wp_customize->add_control( 'skin_admin_login_bgr', array(
				'label'      => esc_html__( 'Background', 'skin-custom-login-page' ),
				'section'    => 'skin_admin_login',
				'settings'   => 'skin_admin_login_bgr',
				'type'       => 'radio',
				'choices'    => array(
									'image'		=> esc_html__( 'Image', 'skin-custom-login-page' ),
									'pattern'	=> esc_html__( 'Pattern', 'skin-custom-login-page' ),
									'color'		=> esc_html__( 'Solid color', 'skin-custom-login-page' )
								)
			));
	
		// Background image
			$wp_customize->add_setting( 'skin_admin_login_bgr_img', array(
				'capability'     	=> 'edit_theme_options',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'esc_url_raw',
				'type'           	=> 'theme_mod'
			));
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'skin_admin_login_bgr_img', array(
				'label'				=> esc_html__( 'Background image', 'skin-custom-login-page' ),
				'section'			=> 'skin_admin_login',
				'settings'			=> 'skin_admin_login_bgr_img',
				'active_callback'	=> 'skin_is_admin_login_bgr_image'
			)));
	
		// Login page background color
			$wp_customize->add_setting( 'skin_admin_login_bgr_color', array(
				'default'           => '#e6e7ec',
				'capability'        => 'edit_theme_options',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
				'type'				=> 'theme_mod'
			));
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_admin_login_bgr_color', array(
				'label'				=> esc_html__( 'Background color', 'skin-custom-login-page' ),
				'section'  			=> 'skin_admin_login',
				'settings' 			=> 'skin_admin_login_bgr_color',
				'active_callback'	=> 'skin_is_admin_login_bgr_color'
			)));
	
		// Text color
			$wp_customize->add_setting( 'skin_admin_login_txt_color', array(
				'default'           => '#373c47',
				'capability'        => 'edit_theme_options',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
				'type'				=> 'theme_mod'
			));
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_admin_login_txt_color', array(
				'label'		=> esc_html__( 'Text color', 'skin-custom-login-page' ),
				'section'  	=> 'skin_admin_login',
				'settings' 	=> 'skin_admin_login_txt_color'
			)));
	
		// Fields background color
			$wp_customize->add_setting( 'skin_admin_login_fields_bgr', array(
				'default'           => '#fff',
				'capability'        => 'edit_theme_options',
				'transport' 		=> 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
				'type'				=> 'theme_mod'
			));
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_admin_login_fields_bgr', array(
				'label'		=> esc_html__( 'Fields background', 'skin-custom-login-page' ),
				'section'  	=> 'skin_admin_login',
				'settings' 	=> 'skin_admin_login_fields_bgr'
			)));
	
		// Fields background opacity
			$wp_customize->add_setting( 'skin_admin_login_fields_opacity', array(
				'capability'     	=> 'edit_theme_options',
				'type'           	=> 'theme_mod',
				'transport' 		=> 'postMessage',
				'default'           => esc_attr__( '100', 'skin-custom-login-page' ),
				'sanitize_callback' => 'absint'
			));
			
			$wp_customize->add_control( 'skin_admin_login_fields_opacity', array(
				'label'      	=> esc_html__( 'Fields background opacity (%)', 'skin-custom-login-page' ),
				'section'    	=> 'skin_admin_login',
				'settings'   	=> 'skin_admin_login_fields_opacity',
				'type'       	=> 'number'
			));
		}
		
	endif;
	
	add_action( 'customize_register', 'skin_admin_customizer' );
	
/*	Customizer callbacks
========================== */ 
// Check the background type
	if ( ! function_exists( 'skin_admin_login_bgr' ) ) :
		function skin_admin_login_bgr( $control ) {
			$bgr_type = $control->manager->get_setting( 'skin_admin_login_bgr' )->value();
			
			return $bgr_type;
		}
	endif;
	
// Background is an image
	if ( ! function_exists( 'skin_is_admin_login_bgr_image' ) ) :
		function skin_is_admin_login_bgr_image( $control ) {			
			if ( 'image' === skin_admin_login_bgr( $control ) || 'pattern' === skin_admin_login_bgr( $control ) ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Background is a solid color
	if ( ! function_exists( 'skin_is_admin_login_bgr_color' ) ) :
		function skin_is_admin_login_bgr_color( $control ) {			
			if ( 'color' === skin_admin_login_bgr( $control ) ) {
				return true;
			}
			
			return false;
		}
	endif;
?>