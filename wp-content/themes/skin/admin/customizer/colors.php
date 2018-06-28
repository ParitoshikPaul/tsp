<?php
/* ===============================================
	SKIN COLOR SCHEME, Customizer section
	Skin - Premium WordPress Theme, by NordWood
================================================== */
/* Main colors
================= */
	$wp_customize->get_control( 'background_color' )->label = esc_html__( 'Site background', 'skin' );
	
// Site background pattern
	$wp_customize->add_setting( 'skin_bgr_pattern', array(
		'capability'     	=> 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'transport' 		=> 'postMessage',
		'type'           	=> 'theme_mod'
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'skin_bgr_pattern', array(
		'label'			=> esc_html__( 'Pattern over the site background', 'skin' ),
		'section'		=> 'colors',
		'settings'		=> 'skin_bgr_pattern'
	)));
	
// Opacity for the pattern over the site background
	$wp_customize->add_setting( 'skin_bgr_pattern_opacity', array(
		'capability'     	=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'type'           	=> 'theme_mod',
		'default'           => esc_attr__( '20', 'skin' ),
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_bgr_pattern_opacity', array(
		'label'      	=> esc_html__( 'Opacity for the pattern over the site background (%)', 'skin' ),
		'section'    	=> 'colors',
		'settings'   	=> 'skin_bgr_pattern_opacity',
		'type'       	=> 'number'
	));
	
// Content pad background
    $wp_customize->add_setting( 'skin_content_pad', array(
        'default'           => '#fff',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage',
        'type'				=> 'theme_mod' 
    ));
	
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_content_pad', array(
        'label'			=> esc_html__( 'Content pad background', 'skin' ),
        'section'  		=> 'colors',
        'settings' 		=> 'skin_content_pad'
    )));
	
// Main text color
    $wp_customize->add_setting( 'skin_main_txt_color', array(
        'default'           => '#353535',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage',
        'type'				=> 'theme_mod'
    ));
	
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_main_txt_color', array(
        'label'		=> esc_html__( 'Text color', 'skin' ),
        'section'  	=> 'colors',
        'settings' 	=> 'skin_main_txt_color'
    )));
	
// Main text link color on hover
    $wp_customize->add_setting( 'skin_main_txt_color_hover', array(
        'default'           => '#f18597',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage',
        'type'				=> 'theme_mod'
    ));
	
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_main_txt_color_hover', array(
        'label'		=> esc_html__( 'Link color on hover', 'skin' ),
        'section'  	=> 'colors',
        'settings' 	=> 'skin_main_txt_color_hover'
    )));

/* Gradient background
========================= */
    $wp_customize->add_setting( 'skin_gradient_colors', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_gradient_colors', array(
		'section'		=> 'colors',
		'label'			=> esc_html__( 'Gradient background', 'skin' ),
		'description'	=> esc_html__( 'Pick up two colors that will form the gradient background.', 'skin' )
	)));
	
// Gradient color 1
    $wp_customize->add_setting( 'skin_gradient_color_1', array(
        'default'           => '#f4d7de',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage',
        'type'				=> 'theme_mod' 
    ));
	
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_gradient_color_1', array(
        'label'		=> esc_html__( 'Color 1', 'skin' ),
        'section'  	=> 'colors',
        'settings' 	=> 'skin_gradient_color_1'
    )));
	
// Gradient color 2
    $wp_customize->add_setting( 'skin_gradient_color_2', array(
        'default'           => '#cecfe6',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage',
        'type'				=> 'theme_mod' 
    ));
	
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_gradient_color_2', array(
        'label'		=> esc_html__( 'Color 2', 'skin' ),
        'section'  	=> 'colors',
        'settings' 	=> 'skin_gradient_color_2'
    )));
	
// Text color over gradient background
    $wp_customize->add_setting( 'skin_txt_on_gradient_color', array(
        'default'           => '#353535',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage',
        'type'				=> 'theme_mod' 
    ));
	
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_txt_on_gradient_color', array(
        'label'		=> esc_html__( 'Text over gradient background', 'skin' ),
        'section'  	=> 'colors',
        'settings' 	=> 'skin_txt_on_gradient_color'
    )));
	
// Link color on gradient background
    $wp_customize->add_setting( 'skin_txt_on_gradient_color_hover', array(
        'default'           => '#fff',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage',
        'type'				=> 'theme_mod'
    ));
	
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_txt_on_gradient_color_hover', array(
        'label'			=> esc_html__( 'Link color over gradient background', 'skin' ),
        'description'	=> esc_html__( '(on hover)', 'skin' ),
        'section'  		=> 'colors',
        'settings' 		=> 'skin_txt_on_gradient_color_hover'
    )));

/* Gradient in top area
========================= */
    $wp_customize->add_setting( 'skin_colors_top_area', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_colors_top_area', array(
		'section'		=> 'colors',
		'label'			=> esc_html__( 'Gradient background in top area', 'skin' )
	)));	
	
// Gradient in top of homepage
	$wp_customize->add_setting( 'skin_top_gradient_home', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_top_gradient_home', array(
		'label'      => esc_html__( 'Apply to top of homepage (blog)', 'skin' ),
		'section'    => 'colors',
		'settings'   => 'skin_top_gradient_home',
		'type'       => 'checkbox'
	));
	
// Gradient in top of archives
	$wp_customize->add_setting( 'skin_top_gradient_archives', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_top_gradient_archives', array(
		'label'      => esc_html__( 'Apply to top of archives', 'skin' ),
		'section'    => 'colors',
		'settings'   => 'skin_top_gradient_archives',
		'type'       => 'checkbox'
	));
	
// Gradient in top of posts
	$wp_customize->add_setting( 'skin_top_gradient_single', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_top_gradient_single', array(
		'label'      => esc_html__( 'Apply to top of posts', 'skin' ),
		'section'    => 'colors',
		'settings'   => 'skin_top_gradient_single',
		'type'       => 'checkbox'
	));
	
// Gradient in top of 404
	$wp_customize->add_setting( 'skin_top_gradient_404', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_top_gradient_404', array(
		'label'      => esc_html__( 'Apply to page 404', 'skin' ),
		'section'    => 'colors',
		'settings'   => 'skin_top_gradient_404',
		'type'       => 'checkbox'
	));
	
// Height of the gradient background in top
	$wp_customize->add_setting( 'skin_top_gradient_height', array(
		'capability'     	=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'type'           	=> 'theme_mod',
		'default'           => esc_attr__( '0', 'skin' ),
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_top_gradient_height', array(
		'label'      	=> esc_html__( 'Height of gradient at the top (px)', 'skin' ),
		'section'    	=> 'colors',
		'settings'   	=> 'skin_top_gradient_height',
		'type'       	=> 'number'
	));
	
// Pattern over the top area
	$wp_customize->add_setting( 'skin_top_pattern', array(
		'capability'     	=> 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'transport' 		=> 'postMessage',
		'type'           	=> 'theme_mod'
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'skin_top_pattern', array(
		'label'			=> esc_html__( 'Pattern over the top area', 'skin' ),
		'description'	=> esc_html__( 'Applies to all the templates in which the gradient on top in enabled.', 'skin' ),
		'section'		=> 'colors',
		'settings'		=> 'skin_top_pattern'
	)));
	
// Opacity for the pattern over the top area
	$wp_customize->add_setting( 'skin_top_pattern_opacity', array(
		'capability'     	=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'type'           	=> 'theme_mod',
		'default'           => esc_attr__( '20', 'skin' ),
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_top_pattern_opacity', array(
		'label'      	=> esc_html__( 'Opacity for the pattern over the top area (%)', 'skin' ),
		'section'    	=> 'colors',
		'settings'   	=> 'skin_top_pattern_opacity',
		'type'       	=> 'number'
	));

/* Top bar
============= */
    $wp_customize->add_setting( 'skin_colors_top_bar', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_colors_top_bar', array(
		'section'		=> 'colors',
		'label'			=> esc_html__( 'Top bar', 'skin' ),
        'description'	=> esc_html__( 'This color scheme will be inverted on the overlay menu for mobiles.', 'skin' ),
	)));
	
// Top bar background
    $wp_customize->add_setting( 'skin_top_bar_bgr', array(
        'default'           => '#fff',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage',
        'type'				=> 'theme_mod' 
    ));
	
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_top_bar_bgr', array(
        'label'		=> esc_html__( 'Top bar background', 'skin' ),
        'section'  	=> 'colors',
        'settings' 	=> 'skin_top_bar_bgr'
    )));
	
// Top bar content color
    $wp_customize->add_setting( 'skin_top_bar_txt_color', array(
        'default'           => '#353535',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage',
        'type'				=> 'theme_mod' 
    ));
	
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_top_bar_txt_color', array(
        'label'		=> esc_html__( 'Top bar text', 'skin' ),
        'section'  	=> 'colors',
        'settings' 	=> 'skin_top_bar_txt_color'
    )));
	
// Reading progress
    $wp_customize->add_setting( 'skin_colors_reading_progress', array(
        'default'           => '#fbe0e5',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage',
        'type'				=> 'theme_mod' 
    ));
	
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_colors_reading_progress', array(
        'label'		=> esc_html__( 'Reading progress bar', 'skin' ),
        'section'  	=> 'colors',
        'settings' 	=> 'skin_colors_reading_progress'
    )));

/* Small items
================= */
    $wp_customize->add_setting( 'skin_colors_small_items', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_colors_small_items', array(
		'section'		=> 'colors',
		'label'			=> esc_html__( 'Detail color', 'skin' ),
		'description'	=> esc_html__( 'Applies to trending icon, social avatar round decoration, arrow in link post format and some other details.', 'skin' )
	)));
	
// Small item background
    $wp_customize->add_setting( 'skin_small_item_bgr', array(
        'default'           => '#f18597',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage',
        'type'				=> 'theme_mod' 
    ));
	
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_small_item_bgr', array(
        'label'		=> esc_html__( 'Item background', 'skin' ),
        'section'  	=> 'colors',
        'settings' 	=> 'skin_small_item_bgr'
    )));
	
// Small item content color
    $wp_customize->add_setting( 'skin_colors_small_item_content', array(
        'default'           => '#fff',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage',
        'type'				=> 'theme_mod' 
    ));
	
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_colors_small_item_content', array(
        'label'		=> esc_html__( 'Item content color', 'skin' ),
        'section'  	=> 'colors',
        'settings' 	=> 'skin_colors_small_item_content'
    )));
	
/* Categories
================ */
    $wp_customize->add_setting( 'skin_colors_categories', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_colors_categories', array(
		'section' 		=> 'colors',
		'label' 		=> esc_html__( 'Categories', 'skin' ),
		'description' 	=> esc_html__( 'Choose background for each category link.', 'skin' )
	)));
	
// Category color
	$cats = get_categories( array( 'hide_empty' => 0 ) );
	
	foreach ( $cats as $cat ) {
		$cat_name = $cat->name;
		$cat_slug = $cat->slug;
		
		$wp_customize->add_setting( 'skin_colors_cat_'.$cat_slug, array(
			'default'           => '#f18597',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
			'type'				=> 'theme_mod' 
		));
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_colors_cat_'.$cat_slug, array(
			'label'		=> esc_html( $cat_name ),
			'section'  	=> 'colors',
			'settings' 	=> 'skin_colors_cat_'.$cat_slug
		)));
	}
?>