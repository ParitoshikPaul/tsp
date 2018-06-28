<?php
/* ===============================================
	SKIN STICKY BANNER, Customizer section
	Skin - Premium WordPress Theme, by NordWood
================================================== */
// Sticky banner image
	$wp_customize->add_setting( 'skin_sticky_banner_img', array(
		'capability'     	=> 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'type'           	=> 'theme_mod'
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'skin_sticky_banner_img', array(
		'label'			=> esc_html__( 'Sticky banner image', 'skin' ),
		'section'		=> 'skin_sticky_banner',
		'settings'		=> 'skin_sticky_banner_img'
	)));
	
// Selective refresh for sticky banner image
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_sticky_banner_img' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_sticky_banner_img', array(
			'selector' => '.sticky-banner-img',
			'render_callback' => function() {
				$sticky_banner = get_theme_mod( 'skin_sticky_banner_img' );
				
				if ( '' === $sticky_banner ) {
					echo '';
					
				} else {
					echo skin_get_giffy_img_by_url( $sticky_banner );
				}
			}
		));
	}
	
// Sticky banner link
	$wp_customize->add_setting( 'skin_sticky_banner_link', array(
		'capability'		=> 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'transport'        	=> 'postMessage',
		'type'           	=> 'theme_mod'
	));
	
	$wp_customize->add_control( 'skin_sticky_banner_link', array(
		'label'		=> esc_html__( 'Sticky banner links to:', 'skin' ),
		'section'	=> 'skin_sticky_banner',
		'settings'	=> 'skin_sticky_banner_link',
		'type'		=> 'url'
	));
	
// Sticky banner height
	$wp_customize->add_setting( 'skin_sticky_banner_height', array(
		'capability'     	=> 'edit_theme_options',
		'default'           => esc_attr__( '78', 'skin' ),
		'transport'        	=> 'postMessage',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_sticky_banner_height', array(
		'label'			=> esc_html__( 'Banner height (px)', 'skin' ),
		'description'	=> esc_html__( 'Image will be resized to the chosen height, while keeping its original ratio.', 'skin' ),
		'input_attrs'	=> array(
								'placeholder' => esc_attr__( '78', 'skin' )
							),
		'section'		=> 'skin_sticky_banner',
		'settings'		=> 'skin_sticky_banner_height',
		'type'			=> 'number'
	));
	
// Sticky banner position
	$wp_customize->add_setting(	'skin_sticky_banner_position', array(
		'default'			=> 'bottom-right',
		'capability'     	=> 'edit_theme_options',
		'transport'        	=> 'postMessage',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_sticky_banner_position', array(
		'label'      	=> esc_html__( 'Sticky banner position', 'skin' ),
		'description'  	=> esc_html__( 'The image will be placed at the chosen corner of the site frame.', 'skin' ),
		'section'    	=> 'skin_sticky_banner',
		'settings'   	=> 'skin_sticky_banner_position',
		'type'       	=> 'radio',
		'choices'    	=> array(
								'bottom-right'	=> esc_html__( 'Bottom right', 'skin' ),
								'bottom-left'	=> esc_html__( 'Bottom left', 'skin' )
							)
	));
	
// Add a close button
	$wp_customize->add_setting( 'skin_sticky_banner_close', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'transport'        	=> 'postMessage',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_sticky_banner_close', array(
		'label'      => esc_html__( 'Add a close button', 'skin' ),
		'section'    => 'skin_sticky_banner',
		'settings'   => 'skin_sticky_banner_close',
		'type'       => 'checkbox'
	));
	
/*	"Scroll to top" button
======================= */
    $wp_customize->add_setting( 'skin_scroll_to_top', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_scroll_to_top', array(
		'section'	=> 'skin_sticky_banner',
		'label'		=> esc_html__( '"Scroll to top" button', 'skin' )
	)));
	
// Enable "Scroll to top"
	$wp_customize->add_setting( 'skin_show_scroll_to_top', array(
		'default'        	=> true,
		'capability'     	=> 'edit_theme_options',
		'transport'        	=> 'postMessage',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_show_scroll_to_top', array(
		'label'      => esc_html__( 'Show "Scroll to top"', 'skin' ),
		'section'    => 'skin_sticky_banner',
		'settings'   => 'skin_show_scroll_to_top',
		'type'       => 'checkbox'
	));
	
// "Scroll to top" position
	$wp_customize->add_setting(	'skin_scroll_to_top_position', array(
		'default'			=> 'bottom-right',
		'capability'     	=> 'edit_theme_options',
		'transport'        	=> 'postMessage',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_scroll_to_top_position', array(
		'label'      	=> esc_html__( '"Scroll to top" position', 'skin' ),
		'section'    	=> 'skin_sticky_banner',
		'settings'   	=> 'skin_scroll_to_top_position',
		'type'       	=> 'radio',
		'choices'    	=> array(
								'bottom-right'	=> esc_html__( 'Bottom right', 'skin' ),
								'bottom-left'	=> esc_html__( 'Bottom left', 'skin' )
							)
	));
?>