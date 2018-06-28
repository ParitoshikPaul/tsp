<?php
/* ===============================================
	SKIN OPTIMIZATION, Customizer section
	Skin - Premium WordPress Theme, by NordWood
================================================== */
/*	WordPress actions and filters
=================================== */
    $wp_customize->add_setting( 'skin_opt_note', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_opt_note', array(
		'section'		=> 'skin_opt',
		'description'	=> esc_html__( 'This section includes just a few basic controls for site optimization and it may be improved with additional settings in future updates. However, if you are already using some plugin for the same manner, you can leave the following settings disabled, as they will probably be already included, among many other options that a specified plugin can provide.', 'skin' ),
		'divider'		=> false
	)));
	
// WP native features
    $wp_customize->add_setting( 'skin_opt_emoji', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_opt_emoji', array(
		'section'		=> 'skin_opt',
		'label'			=> esc_html__( 'WordPress native features', 'skin' )
	)));
	
// Remove WP Emojis
	$wp_customize->add_setting( 'skin_opt_no_emojis', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_opt_no_emojis', array(
		'label'      => esc_html__( 'Disable WordPress Emojis', 'skin' ),
		'section'    => 'skin_opt',
		'settings'   => 'skin_opt_no_emojis',
		'type'       => 'checkbox'
	));
	
// Remove query string from static files
	$wp_customize->add_setting( 'skin_opt_no_queries_on_static_files', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_opt_no_queries_on_static_files', array(
		'label'      => esc_html__( 'Remove query string from static files', 'skin' ),
		'section'    => 'skin_opt',
		'settings'   => 'skin_opt_no_queries_on_static_files',
		'type'       => 'checkbox'
	));
	
/*	Skin elements
==================== */
    $wp_customize->add_setting( 'skin_opt_mobile', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_opt_mobile', array(
		'section'		=> 'skin_opt',
		'label'			=> esc_html__( 'Skin elements', 'skin' )
	)));
	
// Minify dynamic inline css
	$wp_customize->add_setting( 'skin_opt_minify_dynamic_inline_css', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_opt_minify_dynamic_inline_css', array(
		'label'      => esc_html__( 'Minify dynamic inline css', 'skin' ),
		'section'    => 'skin_opt',
		'settings'   => 'skin_opt_minify_dynamic_inline_css',
		'type'       => 'checkbox'
	));
	
// Disable on-load popout for mobiles
	$wp_customize->add_setting( 'skin_opt_no_popout_on_mobile', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_opt_no_popout_on_mobile', array(
		'label'      => esc_html__( 'Disable popout on-load on mobile devices', 'skin' ),
		'section'    => 'skin_opt',
		'settings'   => 'skin_opt_no_popout_on_mobile',
		'type'       => 'checkbox'
	));	
?>