<?php
/* ===============================================
	SKIN SITE INDENTITY, Customizer section
	Skin - Premium WordPress Theme, by NordWood
================================================== */

/*	Tagline
============== */
// Selective refresh for tagline text
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' => '.tagline',
			'render_callback' => function() {
				if( true === get_theme_mod( 'skin_show_tagline', false ) ) {
					echo get_bloginfo( 'description', 'display' );					
				}
			}
		));
	}
	
/*	Copyright
================ */
	$wp_customize->add_setting( 'skin_copyright', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_copyright', array(
		'label'		=> esc_html__( 'Copyright', 'skin' ),
		'section'	=> 'title_tagline',
		'settings'	=> 'skin_copyright',
		'type'		=> 'text'
	));
	
// Selective refresh for copyright text
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_copyright' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_copyright', array(
			'selector' => '.copyright',
			'render_callback' => function() {
				if ( true === get_theme_mod( 'skin_show_copyright', false ) ) {
					echo esc_html( get_theme_mod( 'skin_copyright' ) );					
				}
			}
		));
	}
	
// Show tagline (in top bar)
	$wp_customize->add_setting( 'skin_show_tagline', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox'
	));
	
	$wp_customize->add_control( 'skin_show_tagline', array(
		'label'		=> esc_html__( 'Show tagline', 'skin' ),
		'section'	=> 'title_tagline',
		'settings'	=> 'skin_show_tagline',
		'type'		=> 'checkbox'
	));
	
// Selective refresh for tagline
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_show_tagline' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_show_tagline', array(
			'selector' => '.tagline',
			'render_callback' => function() {
				if ( true === get_theme_mod( 'skin_show_tagline', false ) ) {
					echo get_bloginfo( 'description', 'display' );					
				}
			}
		));
	}
	
// Show copyright (in mobile menu overlay & site footer)
	$wp_customize->add_setting( 'skin_show_copyright', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox'
	));
	
	$wp_customize->add_control( 'skin_show_copyright', array(
		'label'		=> esc_html__( 'Show copyright', 'skin' ),
		'section'	=> 'title_tagline',
		'settings'	=> 'skin_show_copyright',
		'type'		=> 'checkbox'
	));
	
// Selective refresh for copyright (in mobile menu overlay & site footer)
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_show_copyright' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_show_copyright', array(
			'selector' => '.copyright',
			'render_callback' => function() {
				if ( true === get_theme_mod( 'skin_show_copyright', false ) ) {
					echo esc_html( get_theme_mod( 'skin_copyright' ) );					
				}
			}
		));
	}
	
/* 	API keys
=============== */
    $wp_customize->add_setting( 'skin_api_credentials', array(
		'sanitize_callback' => 'skin_sanitize_custom_html'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_api_credentials', array(
		'section' => 'title_tagline',
		'label' => esc_html__( 'API keys', 'skin' )
	)));
	
// Google Maps
	$wp_customize->add_setting( 'skin_google_maps_api_key', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));	 
	$wp_customize->add_control( 'skin_google_maps_api_key', array(
		'label'      => esc_html__( 'Google Maps', 'skin' ),
		'section'    => 'title_tagline',
		'settings'   => 'skin_google_maps_api_key',
		'type'       => 'text'
	));

/* Site logo
=============== */
    $wp_customize->add_setting( 'skin_logo', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_logo', array(
		'section'	=> 'title_tagline',
		'label'		=> esc_html__( 'Site logo', 'skin' )
	)));
	
// Regular image
	$wp_customize->add_setting( 'skin_logo_regular', array(
		'capability'     	=> 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'type'           	=> 'theme_mod'
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'skin_logo_regular', array(
		'label'		=> esc_html__( 'Upload logo', 'skin' ),
		'section'	=> 'title_tagline',
		'settings'	=> 'skin_logo_regular'
	)));
	
// Selective refresh for logo
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_logo_regular' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_logo_regular', array(
			'selector' => '.top-holder .logo a, #search-overlay .logo a',
			'render_callback' => function() {
				echo skin_get_site_logo();
			}
		));
	}
	
// Retina image
	$wp_customize->add_setting( 'skin_logo_retina', array(
		'capability'		=> 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'type'				=> 'theme_mod'
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'skin_logo_retina', array(
		'label'			=> esc_html__( 'Upload retina logo', 'skin' ),
		'section'		=> 'title_tagline',
		'description'	=> esc_html__( 'Has to be twice the size of a regular image.', 'skin' ),
		'settings'		=> 'skin_logo_retina'
	)));
	
// Selective refresh for logo
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_logo_retina' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_logo_retina', array(
			'selector' => '.top-holder .logo a, #search-overlay .logo a',
			'render_callback' => function() {
				echo skin_get_site_logo();
			}
		));
	}

/* Mobile logo
========================================================================== */
    $wp_customize->add_setting( 'skin_logo_mobile', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_logo_mobile', array(
		'section'	=> 'title_tagline',
		'label'		=> esc_html__( 'Site logo for mobile devices', 'skin' ),
		'divider'	=> false
	)));
	
// Regular image
	$wp_customize->add_setting( 'skin_logo_mobile_regular', array(
		'capability'     	=> 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'type'           	=> 'theme_mod'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'skin_logo_mobile_regular', array(
		'label'		=> esc_html__( 'Upload mobile logo', 'skin' ),
		'section'	=> 'title_tagline',
		'settings'	=> 'skin_logo_mobile_regular'
	)));
	
// Selective refresh for logo
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_logo_mobile_regular' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_logo_mobile_regular', array(
			'selector' => '.top-bar.mobile .logo a',
			'render_callback' => function() {
				echo skin_get_site_logo_mobile();
			}
		));
	}
	
// Retina image
	$wp_customize->add_setting( 'skin_logo_mobile_retina', array(
		'capability'		=> 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'type'				=> 'theme_mod'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'skin_logo_mobile_retina', array(
		'label'			=> esc_html__( 'Upload retina mobile logo', 'skin' ),
		'section'		=> 'title_tagline',
		'description'	=> esc_html__( 'Has to be twice the size of a regular image.', 'skin' ),
		'settings'		=> 'skin_logo_mobile_retina'
	)));
	
// Selective refresh for logo
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_logo_mobile_retina' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_logo_mobile_retina', array(
			'selector' => '.top-bar.mobile .logo a',
			'render_callback' => function() {
				echo skin_get_site_logo_mobile();
			}
		));
	}
	
/*	Modify default settings
============================= */
	$wp_customize->remove_control( 'display_header_text' );
	$wp_customize->get_control( 'site_icon' )->label		= esc_html__( 'Favicon', 'skin' );
	$wp_customize->get_control( 'site_icon' )->description	= esc_html__( 'Favicon should be squared and at least 512px in width and height.', 'skin' );
?>