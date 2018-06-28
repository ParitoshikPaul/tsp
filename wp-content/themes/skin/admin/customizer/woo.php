<?php
/* ===============================================
	SKIN SHOP PAGE, Customizer section
	Skin - Premium WordPress Theme, by NordWood
================================================== */
/*	Shop layout
================== */
// Shop layout type
	$wp_customize->add_setting(	'skin_woo_layout', array(
		'default'			=> 'masonry-2-sidebar',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_woo_layout', array(
		'label'      => esc_html__( 'Shop layout type', 'skin' ),
		'section'    => 'skin_woo',
		'settings'   => 'skin_woo_layout',
		'type'       => 'radio',
		'choices'    => array(
							'masonry-2-sidebar' => esc_html__( 'Masonry in 2 columns + sidebar', 'skin' ),
							'masonry-3'			=> esc_html__( 'Masonry in 3 columns', 'skin' )
						)
	));
	
// Sidebar position
	$wp_customize->add_setting(	'skin_woo_sidebar', array(
		'default'			=> 'sidebar-right',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_woo_sidebar', array(
		'label'      	=> esc_html__( 'Sidebar position', 'skin' ),
		'description'	=> esc_html__( 'Applies to products list on shop page.', 'skin' ),
		'section'    	=> 'skin_woo',
		'settings'   	=> 'skin_woo_sidebar',
		'type'       	=> 'radio',
		'choices'    	=> array(
								'sidebar-right'	=> esc_html__( 'On the right', 'skin' ),
								'sidebar-left'	=> esc_html__( 'On the left', 'skin' )
							)
	));
	
/*	Mini cart
=============== */
    $wp_customize->add_setting( 'skin_woo_mini_cart', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_woo_mini_cart', array(
		'section'		=> 'skin_woo',
		'label'			=> esc_html__( 'Mini cart', 'skin' )
	)));
	
// Mini cart in top bar
	$wp_customize->add_setting( 'skin_woo_mini_cart_top_bar', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_woo_mini_cart_top_bar', array(
		'label'      => esc_html__( 'Show mini cart in top bar', 'skin' ),
		'section'    => 'skin_woo',
		'settings'   => 'skin_woo_mini_cart_top_bar',
		'type'       => 'checkbox'
	));
	
/*	Images
============ */
    $wp_customize->add_setting( 'skin_woo_images', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_woo_images', array(
		'section'		=> 'skin_woo',
		'label'			=> esc_html__( 'Images', 'skin' )
	)));
	
	$wp_customize->add_setting( 'skin_woo_img_placeholder', array(
		'capability'     	=> 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'type'           	=> 'theme_mod'
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'skin_woo_img_placeholder', array(
		'label'			=> esc_html__( 'Placeholder image', 'skin' ),
		'description'	=> esc_html__( 'To show when no image is found.', 'skin' ),
		'section'		=> 'skin_woo',
		'settings'		=> 'skin_woo_img_placeholder'
	)));
	
/* Shop featured area
========================= */
    $wp_customize->add_setting( 'skin_woo_shop_featured_area', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_woo_shop_featured_area', array(
		'section'	=> 'skin_woo',
		'label'		=> esc_html__( 'Shop featured area', 'skin' )
	)));
	
	$wp_customize->add_setting(	'skin_woo_shop_featured', array(
		'default'			=> 'skip',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_woo_shop_featured', array(
		'label'      => esc_html__( 'Show:', 'skin' ),
		'section'    => 'skin_woo',
		'settings'   => 'skin_woo_shop_featured',
		'type'       => 'radio',
		'choices'    => array(
							'slider-featured'	=> esc_html__( 'Featured products (slider)', 'skin' ),
							'skip'				=> esc_html__( 'Nothing', 'skin' )
						)
	));
	
// Number of products to show in slider
	$wp_customize->add_setting( 'skin_woo_shop_slider_count', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'           => esc_attr__( '5', 'skin' ),
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_woo_shop_slider_count', array(
		'label'      		=> esc_html__( 'Number of products in slider', 'skin' ),
		'input_attrs' 		=> array(
									'placeholder' => esc_attr__( '5', 'skin' )
								),
		'section'    		=> 'skin_woo',
		'settings'   		=> 'skin_woo_shop_slider_count',
		'type'       		=> 'number',
		'active_callback'	=> 'skin_woo_shop_has_slider'
	));
	
// Allow autoplay
	$wp_customize->add_setting( 'skin_woo_shop_slider_auto', array(
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_woo_shop_slider_auto', array(
		'label'      		=> esc_html__( 'Autoplay', 'skin' ),
		'section'    		=> 'skin_woo',
		'settings'   		=> 'skin_woo_shop_slider_auto',
		'type'       		=> 'checkbox',
		'active_callback'	=> 'skin_woo_shop_has_slider'
	));
	
// Show product category
	$wp_customize->add_setting( 'skin_woo_featured_show_cat', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_woo_featured_show_cat', array(
		'label'      		=> esc_html__( 'Show category', 'skin' ),
		'section'    		=> 'skin_woo',
		'settings'   		=> 'skin_woo_featured_show_cat',
		'type'       		=> 'checkbox',
		'active_callback'	=> 'skin_woo_shop_has_slider'
	));
	
// Show product price
	$wp_customize->add_setting( 'skin_woo_featured_show_price', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_woo_featured_show_price', array(
		'label'      		=> esc_html__( 'Show price', 'skin' ),
		'section'    		=> 'skin_woo',
		'settings'   		=> 'skin_woo_featured_show_price',
		'type'       		=> 'checkbox',
		'active_callback'	=> 'skin_woo_shop_has_slider'
	));
	
/*	Breadcrumbs
================= */
    $wp_customize->add_setting( 'skin_woo_breadcrumbs', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_woo_breadcrumbs', array(
		'section'		=> 'skin_woo',
		'label'			=> esc_html__( 'Breadcrumbs', 'skin' )
	)));
	
// Show breadcrumbs
	$wp_customize->add_setting( 'skin_woo_breadcrumbs_on', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_woo_breadcrumbs_on', array(
		'label'      => esc_html__( 'Show breadcrumbs', 'skin' ),
		'section'    => 'skin_woo',
		'settings'   => 'skin_woo_breadcrumbs_on',
		'type'       => 'checkbox'
	));

/* Colors
=========== */
    $wp_customize->add_setting( 'skin_woo_colors', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_woo_colors', array(
		'section'		=> 'skin_woo',
		'label'			=> esc_html__( 'Colors', 'skin' )
	)));
	
// Drop shadows
	$wp_customize->add_setting( 'skin_woo_shadows', array(
		'default'        	=> true,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_woo_shadows', array(
		'label'      => esc_html__( 'Show drop shadow on buttons', 'skin' ),
		'section'    => 'skin_woo',
		'settings'   => 'skin_woo_shadows',
		'type'       => 'checkbox'
	));
	
// Shadow color
    $wp_customize->add_setting( 'skin_woo_shadow_color', array(
        'default'           => '#f18597',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
        'type'				=> 'theme_mod' 
    ));
	
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_woo_shadow_color', array(
        'label'		=> esc_html__( 'Shadow color', 'skin' ),
        'section'  	=> 'skin_woo',
        'settings' 	=> 'skin_woo_shadow_color'
    )));
	
// Shadow opacity
	$wp_customize->add_setting( 'skin_woo_shadow_opacity', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'           => esc_attr__( '20', 'skin' ),
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_woo_shadow_opacity', array(
		'label'      	=> esc_html__( 'Shadow opacity (%)', 'skin' ),
		'section'    	=> 'skin_woo',
		'settings'   	=> 'skin_woo_shadow_opacity',
		'type'       	=> 'number'
	));
	
/* Categories
================ */
    $wp_customize->add_setting( 'skin_woo_colors_cats', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_woo_colors_cats', array(
		'section' 		=> 'skin_woo',
		'label' 		=> esc_html__( 'Categories', 'skin' ),
		'description' 	=> esc_html__( 'Choose background color for each category link.', 'skin' )
	)));
	
// Category color
	$cats = get_terms( array(
		'taxonomy' => 'product_cat',
		'hide_empty' => false,
	) );
	
	foreach ( $cats as $cat ) {
		$cat_name = $cat->name;
		$cat_slug = $cat->slug;
		
		$wp_customize->add_setting( 'skin_woo_colors_cat_'.$cat_slug, array(
			'default'           => '#f18597',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
			'type'				=> 'theme_mod' 
		));
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skin_woo_colors_cat_'.$cat_slug, array(
			'label'		=> esc_html( $cat_name ),
			'section'  	=> 'skin_woo',
			'settings' 	=> 'skin_woo_colors_cat_'.$cat_slug
		)));
	}
?>