<?php
/* ===============================================
	SKIN WIDGETS, Customizer section
	Skin - Premium WordPress Theme, by NordWood
================================================== */
/*	Categories
================== */
    $wp_customize->add_setting( 'skin_widgets', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_widgets', array(
		'section'	=> 'skin_sidebars',
		'label'		=> esc_html__( 'Categories widget', 'skin' ),
		'divider'	=> false
	)));
	
// Exclude posts by category
	$wp_customize->add_setting( 'skin_sidebars_cats_widget_hide_cats', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_sidebars_cats_widget_hide_cats', array(
		'label'      	=> esc_html__( 'Exclude categories', 'skin' ),
		'description'  	=> esc_html__( 'Use category ID. For multiple categories, separate ids with comma.', 'skin' ),
		'section'    	=> 'skin_sidebars',
		'settings'   	=> 'skin_sidebars_cats_widget_hide_cats',
		'type'       	=> 'text'
	));
?>