<?php
/* ===============================================
	SKIN TOP BAR, Customizer section
	Skin - Premium WordPress Theme, by NordWood
================================================== */
// Social profiles
    $wp_customize->add_setting( 'skin_note_social_profiles_in_topbar', array(
		'sanitize_callback' => 'skin_sanitize_custom_html'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_note_social_profiles_in_topbar', array(
		'section'		=> 'skin_top_bar',
		'label'			=> esc_html__( 'Social profiles', 'skin' ),
		'description'	=> esc_html__( 'Set avatar and social profiles under Customizer\'s Skin Social section', 'skin' ),
		'divider'		=> false
	)));
	
// Show social profiles
	$wp_customize->add_setting( 'skin_social_profiles_in_topbar', array(
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));	 
	$wp_customize->add_control( 'skin_social_profiles_in_topbar', array(
		'label'      	=> esc_html__( 'Show social profiles', 'skin' ),
		'section'    	=> 'skin_top_bar',
		'settings'   	=> 'skin_social_profiles_in_topbar',
		'type'       	=> 'checkbox'
	));
	
// Quick search button
    $wp_customize->add_setting( 'skin_note_search_in_topbar', array(
		'sanitize_callback' => 'skin_sanitize_custom_html'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_note_search_in_topbar', array(
		'section'	=> 'skin_top_bar',
		'label'		=> esc_html__( 'Quick search button', 'skin' )
	)));
	
// Show search button
	$wp_customize->add_setting( 'skin_search_in_topbar', array(
		'default'        	=> true,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	$wp_customize->add_control( 'skin_search_in_topbar', array(
		'label'      => esc_html__( 'Show search button', 'skin' ),
		'section'    => 'skin_top_bar',
		'settings'   => 'skin_search_in_topbar',
		'type'       => 'checkbox'
	));
   
// Search field placeholder
	$wp_customize->add_setting( 'skin_search_placeholder', array(
		'capability'     	=> 'edit_theme_options',
		'transport'        	=> 'postMessage',
		'type'           	=> 'theme_mod',
		'default'        	=> esc_attr__( 'Type your search & hit enter', 'skin' ),
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('skin_search_placeholder', array(
		'label'      	=> esc_html__( 'Placeholder text for the search field', 'skin' ),
		'input_attrs' 	=> array(
								'placeholder' => esc_attr__( 'Type your search & hit enter', 'skin' )
							),
		'section'    	=> 'skin_top_bar',
		'settings'   	=> 'skin_search_placeholder',
		'type'       	=> 'text'
	));
	
/* 	Top bar elements on single post
==================================== */
    $wp_customize->add_setting( 'skin_topbar_single', array(
		'sanitize_callback' => 'skin_sanitize_custom_html'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_topbar_single', array(
		'section'	=> 'skin_top_bar',
		'label'		=> esc_html__( 'Top bar elements on single post', 'skin' )
	)));
	
// Share post
	$wp_customize->add_setting( 'skin_share_in_topbar', array(
		'default'        	=> true,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox'
	));
	
	$wp_customize->add_control( 'skin_share_in_topbar', array(
		'label'		=> esc_html__( 'Show share', 'skin' ),
		'section'	=> 'skin_top_bar',
		'settings'	=> 'skin_share_in_topbar',
		'type'		=> 'checkbox'
	));
	
// Related posts
	$wp_customize->add_setting( 'skin_related_in_topbar', array(
		'default'        	=> true,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox'
	));
	
	$wp_customize->add_control( 'skin_related_in_topbar', array(
		'label'		=> esc_html__( 'Show related', 'skin' ),
		'section'	=> 'skin_top_bar',
		'settings'	=> 'skin_related_in_topbar',
		'type'		=> 'checkbox'
	));
   
// Heading for related posts
	$wp_customize->add_setting( 'skin_related_in_topbar_heading', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'        	=> esc_attr__( 'Related posts', 'skin' ),
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('skin_related_in_topbar_heading', array(
		'label'      	=> esc_html__( 'Related posts title', 'skin' ),
		'input_attrs' 	=> array(
								'placeholder' => esc_attr__( 'Related posts', 'skin' )
							),
		'section'    	=> 'skin_top_bar',
		'settings'   	=> 'skin_related_in_topbar_heading',
		'type'       	=> 'text'
	));
	
// Max number of posts to show in these tabs 
	$wp_customize->add_setting( 'skin_related_in_topbar_qty', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'           => esc_attr__( '3', 'skin' ),
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_related_in_topbar_qty', array(
		'label'			=> esc_html__( 'Max number of related posts to show:', 'skin' ),
		'section'		=> 'skin_top_bar',
		'settings'		=> 'skin_related_in_topbar_qty',
		'type'			=> 'number'
	));
?>