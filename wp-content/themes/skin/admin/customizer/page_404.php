<?php
/* =================================================
	THEME CUSTOMIZER SECTION, for "Skin 404 page"
	Skin - Premium WordPress Theme, by NordWood
==================================================== */
// Short description
	$wp_customize->add_setting( 'skin_404_desc', array(
		'default'        	=> esc_attr__( '404 error page', 'skin' ),
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_404_desc', array(
		'label'      	=> esc_html__( 'Short description', 'skin' ),
		'description'	=> esc_html__( 'Text above the heading.', 'skin' ),
		'input_attrs' 	=> array(
								'placeholder' => esc_attr__( '404 error page', 'skin' )
							),
		'section'    	=> 'skin_404_page',
		'settings'   	=> 'skin_404_desc',
		'type'       	=> 'text'
	));
	
// Selective refresh for short description
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_404_desc' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_404_desc', array(
			'selector' => '.error-short h5',
			'render_callback' => function() {
				echo esc_html( get_theme_mod( 'skin_404_desc' ) );
			}
		));
	}
	
// Heading
	$wp_customize->add_setting( 'skin_404_heading', array(
		'default'        	=> esc_attr__( 'Oops! This page is not here anymore', 'skin' ),
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_404_heading', array(
		'label'      	=> esc_html__( 'Heading', 'skin' ),
		'input_attrs' 	=> array(
								'placeholder' => esc_attr__( 'Oops! This page is not here anymore', 'skin' )
							),
		'section'    	=> 'skin_404_page',
		'settings'   	=> 'skin_404_heading',
		'type'       	=> 'text'
	));
	
// Selective refresh for the heading
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_404_heading' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_404_heading', array(
			'selector' => '.post-title h1',
			'render_callback' => function() {
				echo esc_html( get_theme_mod( 'skin_404_heading' ) );
			}
		));
	}
	
// Back to home
	$wp_customize->add_setting( 'skin_404_back_button', array(
		'default'        	=> esc_attr__( 'Back to home', 'skin' ),
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_404_back_button', array(
		'label'      	=> esc_html__( 'Back to home button text', 'skin' ),
		'input_attrs' 	=> array(
								'placeholder' => esc_attr__( 'Back to home', 'skin' )
							),
		'section'    	=> 'skin_404_page',
		'settings'   	=> 'skin_404_back_button',
		'type'       	=> 'text'
	));
	
// Selective refresh for the back button
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_404_back_button' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_404_back_button', array(
			'selector' => '.text h5',
			'render_callback' => function() {
				echo esc_html( get_theme_mod( 'skin_404_back_button' ) );
			}
		));
	}
?>