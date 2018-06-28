<?php
/* ===============================================
	SKIN SOCIAL OPTIONS, Customizer section
	Skin - Premium WordPress Theme, by NordWood
================================================== */

/* Social profiles avatar
============================ */	
    $wp_customize->add_setting( 'skin_social_avatar_h', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_social_avatar_h', array(
		'section'	=> 'skin_social',
		'label'		=> esc_html__( 'Avatar image for social links', 'skin' ),
		'divider'	=> false
	)));
	
	$wp_customize->add_setting( 'skin_social_avatar', array(
		'capability'     	=> 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'type'           	=> 'theme_mod'
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'skin_social_avatar', array(
		'label'		=> esc_html__( 'Upload image', 'skin' ),
		'section'	=> 'skin_social',
		'settings'	=> 'skin_social_avatar'
	)));
	
// Selective refresh for avatar image
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_social_avatar' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_social_avatar', array(
			'selector' => '.top-holder .social-links-img',
			'render_callback' => function() {
				if ( '' != get_theme_mod( 'skin_social_avatar' ) ) {
					printf(
						'<div class="bgr-cover va-middle" style="background-image:url(%s);"></div>',
						esc_url( get_theme_mod( 'skin_social_avatar' ) )
					);
					
				} else {
					printf(
						'<div class="top-bar-color-to-bgr top-bar-bgr-light-to-svg">%s</div>',
						skin_get_icon_profile()
					);
				}
			}
		));
	}

/* Social profiles
===================== */
    $wp_customize->add_setting( 'skin_social_profiles_d', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_social_profiles_d', array(
		'section' => 'skin_social'
	)));
	
    $wp_customize->add_setting( 'skin_social_profiles', array(
        'default' 			=> '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
	
    $wp_customize->add_control( new Skin_Customize_Social_Profiles( $wp_customize, 'skin_social_profiles', array(
        'label'		=> esc_html__( 'Social profiles', 'skin' ),
        'section'	=> 'skin_social',
        'settings'	=> 'skin_social_profiles'
    )));
	
/* Social share
================== */
    $wp_customize->add_setting( 'skin_social_share', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_social_share', array(
		'section'	=> 'skin_social',
		'label'		=> esc_html__( 'Sharing options', 'skin' )
	)));
	
    $wp_customize->add_setting( 'skin_sharing_links', array(
        'default' 			=> '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
	
    $wp_customize->add_control( new Skin_Customize_Sharing_Links( $wp_customize, 'skin_sharing_links', array(
        'description'	=> esc_html__( 'Choose the networks you want enable for sharing', 'skin' ),
        'section'		=> 'skin_social',
        'settings'		=> 'skin_sharing_links'
    )));
	
// 	Social share heading
	$wp_customize->add_setting( 'skin_share_heading', array(
		'default'        	=> esc_html__( 'Share', 'skin' ),
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_share_heading', array(
		'label'			=> esc_html__( 'Heading for share buttons', 'skin' ),
		'input_attrs'	=> array(
								'placeholder' => esc_attr__( 'Share', 'skin' )
							),
		'section'		=> 'skin_social',
		'settings'		=> 'skin_share_heading',
		'type'			=> 'text'
	));
	
// Share selection
    $wp_customize->add_setting( 'skin_note_share_selection', array(
		'sanitize_callback' => 'skin_sanitize_custom_html'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_note_share_selection', array(
		'section'		=> 'skin_social',
		'label'			=> esc_html__( 'Share text selection', 'skin' ),
		'description'	=> esc_html__( 'On Twitter and Facebook.', 'skin' ),
		'divider'		=> false
	)));
	
// Allow share selection
	$wp_customize->add_setting( 'skin_share_selection', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_share_selection', array(
		'label'      	=> esc_html__( 'Allow text selection share', 'skin' ),
		'section'    	=> 'skin_social',
		'settings'   	=> 'skin_share_selection',
		'type'       	=> 'checkbox'
	));
	
// Open Graph
    $wp_customize->add_setting( 'skin_note_open_graph', array(
		'sanitize_callback' => 'skin_sanitize_custom_html'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_note_open_graph', array(
		'section'		=> 'skin_social',
		'label'			=> esc_html__( 'Open Graph', 'skin' ),
		'divider'		=> false
	)));
	
// Include Open Graph meta tags
	$wp_customize->add_setting( 'skin_open_graph', array(
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_open_graph', array(
		'label'      	=> esc_html__( 'Include OG meta tags', 'skin' ),
		'section'    	=> 'skin_social',
		'settings'   	=> 'skin_open_graph',
		'type'       	=> 'checkbox'
	));
	
// Default thumbnail for Open Graph
	$wp_customize->add_setting( 'skin_open_graph_img', array(
		'capability'     	=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
		'type'           	=> 'theme_mod'
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'skin_open_graph_img', array(
		'label'		=> esc_html__( 'Default thumbnail for Open Graph', 'skin' ),
		'section'	=> 'skin_social',
		'settings'	=> 'skin_open_graph_img'
	)));
		
/* 	Discussion
================= */
// Facebook comments
    $wp_customize->add_setting( 'skin_fb_comments', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_fb_comments', array(
		'section'		=> 'skin_social',
		'label'			=> esc_html__( 'Facebook comments for posts', 'skin' ),
		'description'	=> esc_html__( 'For static pages, use the comments options for each individual page.', 'skin' )
	)));
	
// Allow Facebook comments
	$wp_customize->add_setting( 'skin_allow_fb_comments', array(
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_allow_fb_comments', array(
		'label'		=> esc_html__( 'Allow Facebook comments', 'skin' ),
		'section'	=> 'skin_social',
		'settings'	=> 'skin_allow_fb_comments',
		'type'		=> 'checkbox'
	));
	
// Facebook comments color scheme
	$wp_customize->add_setting(	'skin_fb_comments_color', array(
		'default'			=> 'light',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_fb_comments_color', array(
		'label'      	=> esc_html__( 'Color scheme', 'skin' ),
		'section'    	=> 'skin_social',
		'settings'   	=> 'skin_fb_comments_color',
		'type'       	=> 'radio',
		'choices'    	=> array(
								'light'	=> esc_html__( 'Light', 'skin' ),
								'dark'	=> esc_html__( 'Dark', 'skin' )
							)
	));
	
// WordPress comments
    $wp_customize->add_setting( 'skin_wp_comments', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_wp_comments', array(
		'section'		=> 'skin_social',
		'label'			=> esc_html__( 'WordPress comments', 'skin' ),
		'description'	=> esc_html__( 'If WP comments are closed on a single post/page, there will still be a note \'Comments are closed\' below the post/page. To disable this feature completely, turn on the checkboxes below.', 'skin' )
	)));
	
// Disable WordPress comments on posts
	$wp_customize->add_setting( 'skin_disable_wp_comments_on_posts', array(
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_disable_wp_comments_on_posts', array(
		'label'		=> esc_html__( 'Disable WP comments on all posts', 'skin' ),
		'section'	=> 'skin_social',
		'settings'	=> 'skin_disable_wp_comments_on_posts',
		'type'		=> 'checkbox'
	));
	
// Disable WordPress comments on pages
	$wp_customize->add_setting( 'skin_disable_wp_comments_on_pages', array(
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_disable_wp_comments_on_pages', array(
		'label'		=> esc_html__( 'Disable WP comments on all pages', 'skin' ),
		'section'	=> 'skin_social',
		'settings'	=> 'skin_disable_wp_comments_on_pages',
		'type'		=> 'checkbox'
	));
?>