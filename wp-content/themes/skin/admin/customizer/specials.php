<?php
/* ===============================================
	SKIN SPECIAL BOXES, Customizer section
	Skin - Premium WordPress Theme, by NordWood
================================================== */
/*	Note
=========== */
    $wp_customize->add_setting( 'skin_specials_note', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_specials_note', array(
		'section'		=> 'skin_specials',
		'description'	=> esc_html__( 'Available only on post lists with masonry layout.', 'skin' ),
		'divider'		=> false
	)));
	
/*	Popout page
================== */
    $wp_customize->add_setting( 'skin_specials_popout', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_specials_popout', array(
		'section'		=> 'skin_specials',
		'label'			=> esc_html__( 'Popout link', 'skin' ),
		'description'	=> esc_html__( 'Skin Popout Pages plugin must be activated.', 'skin' )
	)));
	
// Popout box switch
	$wp_customize->add_setting( 'skin_specials_popout_on', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_specials_popout_on', array(
		'label'      => esc_html__( 'Turn on', 'skin' ),
		'section'    => 'skin_specials',
		'settings'   => 'skin_specials_popout_on',
		'type'       => 'checkbox'
	));
	
	$pop_args = array(
		'post_type' 	=> 'popout',
		'post_status'	=> 'publish'
	);
	
	$pops = get_posts( $pop_args );
	
	if ( !$pops || !function_exists( 'skin_popout_init' ) ) {
		$wp_customize->add_setting( 'skin_specials_popout_err', array(
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( new Skin_Customizer_Err_Notice( $wp_customize, 'skin_specials_popout_err', array(
			'section'	=> 'skin_specials',
			'label'		=> esc_html__( 'Oops!', 'skin' )
		)));
			
		if ( ! function_exists( 'skin_popout_init' ) ) {
			$wp_customize->get_control( 'skin_specials_popout_err' )->description = esc_html__( 'You need to activate the Skin Popout Page plugin first.', 'skin' );
			
		} else {
			$wp_customize->get_control( 'skin_specials_popout_err' )->description = esc_html__( 'It seems like you don\'t have any Popout page yet.', 'skin' );
		}
		
	} else {
	// Popout starting position
		$wp_customize->add_setting( 'skin_specials_popout_s', array(
			'capability'		=> 'edit_theme_options',
			'type'				=> 'theme_mod',
			'default'			=> esc_attr__( '3', 'skin' ),
			'sanitize_callback' => 'absint'
		));
		
		$wp_customize->add_control( 'skin_specials_popout_s', array(
			'label'      		=> esc_html__( 'Starting position:', 'skin' ),
			'input_attrs' 		=> array(
										'placeholder' => esc_attr__( '3', 'skin' )
									),
			'section'    		=> 'skin_specials',
			'settings'   		=> 'skin_specials_popout_s',
			'type'       		=> 'number',
			'active_callback' 	=> 'skin_check_specials_have_popout'
		));
		
	// Popout repeating interval
		$wp_customize->add_setting( 'skin_specials_popout_i', array(
			'capability'     	=> 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'default'			=> esc_attr__( '5', 'skin' ),
			'sanitize_callback' => 'absint'
		));
		
		$wp_customize->add_control( 'skin_specials_popout_i', array(
			'label'      		=> esc_html__( 'Repeat on every x posts:', 'skin' ),
			'input_attrs' 		=> array(
										'placeholder' => esc_attr__( '5', 'skin' )
									),
			'section'    		=> 'skin_specials',
			'settings'   		=> 'skin_specials_popout_i',
			'type'       		=> 'number',
			'active_callback'	=> 'skin_check_specials_have_popout'
		));
		
	// Popout page
		$pops_selection = array();					
		
		foreach ( $pops as $pop ) {			
			$pop_name = $pop->post_title;
			$pop_id = $pop->ID;
			
			$pops_selection[esc_attr( $pop_id )] = esc_html( $pop_name );
		}
		
		$wp_customize->add_setting(	'skin_specials_popout_id', array(
			'default'			=> 'skip',
			'capability'     	=> 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'sanitize_callback' => 'skin_sanitize_choices'
		));
		
		$wp_customize->add_control( 'skin_specials_popout_id', array(
			'label'		=> esc_html__( 'Choose a popout:', 'skin' ),
			'section'	=> 'skin_specials',
			'settings'	=> 'skin_specials_popout_id',
			'type'		=> 'radio',
			'choices'	=> $pops_selection,
			'active_callback' 	=> 'skin_check_specials_have_popout'
		));
		
	// Popout button label
		$wp_customize->add_setting( 'skin_specials_popout_label', array(
			'capability'     	=> 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'default'			=> '',
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( 'skin_specials_popout_label', array(
			'label'      		=> esc_html__( 'Popout link title:', 'skin' ),
			'section'    		=> 'skin_specials',
			'settings'   		=> 'skin_specials_popout_label',
			'type'       		=> 'text',
			'active_callback'	=> 'skin_check_specials_have_popout'
		));
	
	// Background
		$wp_customize->add_setting(	'skin_specials_popout_bgr', array(
			'default'			=> 'content-pad',
			'capability'     	=> 'edit_theme_options',
		'transport'        	=> 'postMessage',
			'type'           	=> 'theme_mod',
			'sanitize_callback' => 'skin_sanitize_choices'
		));
		
		$wp_customize->add_control( 'skin_specials_popout_bgr', array(
			'label'      => esc_html__( 'Background', 'skin' ),
			'section'    => 'skin_specials',
			'settings'   => 'skin_specials_popout_bgr',
			'type'       => 'radio',
			'choices'    => array(
								'content-pad'	=> esc_html__( 'Same as content pad', 'skin' ),
								'gradient-bgr'	=> esc_html__( 'Gradient background', 'skin' ),
								'no-bgr'		=> esc_html__( 'No background', 'skin' )
							),
			'active_callback'	=> 'skin_check_specials_have_popout'
		));
	}
	
/*	Image
============ */
    $wp_customize->add_setting( 'skin_specials_bnnr', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_specials_bnnr', array(
		'section'	=> 'skin_specials',
		'label'		=> esc_html__( 'Image banner', 'skin' )
	)));
	
// Image banner switch
	$wp_customize->add_setting( 'skin_specials_bnnr_on', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_specials_bnnr_on', array(
		'label'      => esc_html__( 'Turn on', 'skin' ),
		'section'    => 'skin_specials',
		'settings'   => 'skin_specials_bnnr_on',
		'type'       => 'checkbox'
	));
	
// Set of image options for each of the 5 banners available
	for ( $i = 1; $i <= 5; $i++ ) {
	// Upload image i
		$wp_customize->add_setting( 'skin_specials_bnnr_'.$i, array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
			'type'           	=> 'theme_mod'
		));
		
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'skin_specials_bnnr_'.$i, array(
			'label'				=> sprintf( esc_html__( 'Image: %u', 'skin' ), $i ),
			'section'			=> 'skin_specials',
			'settings'			=> 'skin_specials_bnnr_'.$i,
			'active_callback'	=> 'skin_check_specials_have_bnnr'
		)));
		
	// Image i link
		$wp_customize->add_setting( 'skin_specials_bnnr_link_'.$i, array(
			'capability'		=> 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
			'type'           	=> 'theme_mod'
		));
		
		$wp_customize->add_control( 'skin_specials_bnnr_link_'.$i, array(
			'label'				=> sprintf( esc_html__( 'Image %u links to:', 'skin' ), $i ),
			'section'  			=> 'skin_specials',
			'settings' 			=> 'skin_specials_bnnr_link_'.$i,
			'type'       		=> 'url',
			'active_callback'	=> 'skin_check_specials_have_bnnr_'.$i
		));
	
	// Image i target
		$wp_customize->add_setting( 'skin_specials_bnnr_newtab_'.$i, array(
			'default'        	=> true,
			'capability'     	=> 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'sanitize_callback' => 'skin_sanitize_checkbox',
		));
		
		$wp_customize->add_control( 'skin_specials_bnnr_newtab_'.$i, array(
			'label'      		=> esc_html__( 'Open link in new tab', 'skin' ),
			'section'    		=> 'skin_specials',
			'settings'   		=> 'skin_specials_bnnr_newtab_'.$i,
			'type'       		=> 'checkbox',
			'active_callback'	=> 'skin_check_specials_have_bnnr_'.$i
		));
		
	// Image i starting position
		$wp_customize->add_setting( 'skin_specials_bnnr_s_'.$i, array(
			'capability'		=> 'edit_theme_options',
			'type'				=> 'theme_mod',
			'default'			=> esc_attr__( '3', 'skin' ),
			'sanitize_callback' => 'absint'
		));
		
		$wp_customize->add_control( 'skin_specials_bnnr_s_'.$i, array(
			'label'				=> sprintf( esc_html__( 'Image %u starting position:', 'skin' ), $i ),
			'input_attrs' 		=> array(
										'placeholder' => esc_attr__( '3', 'skin' )
									),
			'section'    		=> 'skin_specials',
			'settings'   		=> 'skin_specials_bnnr_s_'.$i,
			'type'       		=> 'number',
			'active_callback' 	=> 'skin_check_specials_have_bnnr_'.$i
		));
		
	// Image i repeating interval
		$wp_customize->add_setting( 'skin_specials_bnnr_i_'.$i, array(
			'capability'     	=> 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'default'			=> esc_attr__( '5', 'skin' ),
			'sanitize_callback' => 'absint'
		));
		
		$wp_customize->add_control( 'skin_specials_bnnr_i_'.$i, array(
			'label'				=> sprintf( esc_html__( 'Image %u repeats on every x posts:', 'skin' ), $i ),
			'input_attrs' 		=> array(
										'placeholder' => esc_attr__( '5', 'skin' )
									),
			'section'    		=> 'skin_specials',
			'settings'   		=> 'skin_specials_bnnr_i_'.$i,
			'type'       		=> 'number',
			'active_callback'	=> 'skin_check_specials_have_bnnr_'.$i
		));
	}
	
/*	Social box
================= */
    $wp_customize->add_setting( 'skin_specials_social', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_specials_social', array(
		'section'		=> 'skin_specials',
		'label'			=> esc_html__( 'Social profiles', 'skin' ),
		'description'	=> esc_html__( 'Social profiles you chose under Skin Social Options will be used here.', 'skin' )
	)));
	
// Social box switch
	$wp_customize->add_setting( 'skin_specials_social_on', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_specials_social_on', array(
		'label'      => esc_html__( 'Turn on', 'skin' ),
		'section'    => 'skin_specials',
		'settings'   => 'skin_specials_social_on',
		'type'       => 'checkbox'
	));
	
// Social starting position
	$wp_customize->add_setting( 'skin_specials_social_s', array(
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'default'			=> esc_attr__( '3', 'skin' ),
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_specials_social_s', array(
		'label'      		=> esc_html__( 'Starting position:', 'skin' ),
		'input_attrs' 		=> array(
									'placeholder' => esc_attr__( '3', 'skin' )
								),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_social_s',
		'type'       		=> 'number',
		'active_callback' 	=> 'skin_check_specials_have_social'
	));
	
// Social repeating interval
	$wp_customize->add_setting( 'skin_specials_social_i', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'			=> esc_attr__( '5', 'skin' ),
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_specials_social_i', array(
		'label'      		=> esc_html__( 'Repeat on every x posts:', 'skin' ),
		'input_attrs' 		=> array(
									'placeholder' => esc_attr__( '5', 'skin' )
								),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_social_i',
		'type'       		=> 'number',
        'active_callback'	=> 'skin_check_specials_have_social'
	));
	
// Social heading
	$wp_customize->add_setting( 'skin_specials_social_title', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'			=> esc_attr__( 'Connect', 'skin' ),
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_specials_social_title', array(
		'label'      		=> esc_html__( 'Heading:', 'skin' ),
		'input_attrs' 		=> array(
									'placeholder' => esc_attr__( 'Connect', 'skin' )
								),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_social_title',
		'type'       		=> 'text',
        'active_callback'	=> 'skin_check_specials_have_social'
	));
	
// Selective refresh for this heading
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_specials_social_title' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_specials_social_title', array(
			'selector' => '.masonry-item .skin-widget-social-profiles h2',
			'render_callback' => function() {
				echo get_theme_mod( 'skin_specials_social_title' );
			}
		));
	}
	
// Social description
	$wp_customize->add_setting( 'skin_specials_social_desc', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'			=> esc_attr__( 'Follow me', 'skin' ),
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_specials_social_desc', array(
		'label'      		=> esc_html__( 'Short description:', 'skin' ),
		'input_attrs' 		=> array(
									'placeholder' => esc_attr__( 'Follow me', 'skin' )
								),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_social_desc',
		'type'       		=> 'text',
        'active_callback'	=> 'skin_check_specials_have_social'
	));
	
// Selective refresh for description
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_specials_social_desc' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_specials_social_desc', array(
			'selector' => '.masonry-item .skin-widget-social-profiles .text',
			'render_callback' => function() {
				echo get_theme_mod( 'skin_specials_social_desc' );
			}
		));
	}
	
// Background
	$wp_customize->add_setting(	'skin_specials_social_bgr', array(
		'default'			=> 'content-pad',
		'capability'     	=> 'edit_theme_options',
		'transport'        	=> 'postMessage',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_specials_social_bgr', array(
		'label'      => esc_html__( 'Background', 'skin' ),
		'section'    => 'skin_specials',
		'settings'   => 'skin_specials_social_bgr',
		'type'       => 'radio',
		'choices'    => array(
							'content-pad'	=> esc_html__( 'Same as posts in masonry', 'skin' ),
							'gradient-bgr'	=> esc_html__( 'Gradient background', 'skin' ),
							'no-bgr'		=> esc_html__( 'No background', 'skin' )
						),
		'active_callback'	=> 'skin_check_specials_have_social'
	));

/* Popular/Latest posts
========================== */
    $wp_customize->add_setting( 'skin_specials_topposts', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_specials_topposts', array(
		'section'		=> 'skin_specials',
		'label'			=> esc_html__( 'Popular/Latest posts', 'skin' )
	)));
	
// Popular/Latest posts switch
	$wp_customize->add_setting( 'skin_specials_topposts_on', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_specials_topposts_on', array(
		'label'      => esc_html__( 'Turn on', 'skin' ),
		'section'    => 'skin_specials',
		'settings'   => 'skin_specials_topposts_on',
		'type'       => 'checkbox'
	));
	
// Starting position
	$wp_customize->add_setting( 'skin_specials_topposts_s', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'           => esc_attr__( '3', 'skin' ),
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_specials_topposts_s', array(
		'label'      		=> esc_html__( 'Starting position:', 'skin' ),
		'input_attrs'		=> array(
									'placeholder' => esc_attr__( '3', 'skin' )
								),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_topposts_s',
		'type'       		=> 'number',
		'active_callback' 	=> 'skin_check_specials_have_popular'
	));
	
// Repeating interval
	$wp_customize->add_setting( 'skin_specials_topposts_i', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'           => esc_attr__( '5', 'skin' ),
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_specials_topposts_i', array(
		'label'      		=> esc_html__( 'Repeat on every x posts:', 'skin' ),
		'input_attrs' 		=> array(
									'placeholder' => esc_attr__( '5', 'skin' )
								),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_topposts_i',
		'type'       		=> 'number',
        'active_callback' 	=> 'skin_check_specials_have_popular',
	));
	
// Number of posts
	$wp_customize->add_setting( 'skin_specials_topposts_qty', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'           => esc_attr__( '4', 'skin' ),
		'sanitize_callback' => 'absint'
	));	 
	
	$wp_customize->add_control( 'skin_specials_topposts_qty', array(
		'label'      		=> esc_html__( 'Number of posts to show:', 'skin' ),
		'input_attrs' 		=> array(
									'placeholder' => esc_attr__( '4', 'skin' )
								),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_topposts_qty',
		'type'       		=> 'number',
        'active_callback' 	=> 'skin_check_specials_have_popular',
	));
	
// Exclude category
	$wp_customize->add_setting( 'skin_specials_topposts_skip_cat', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_specials_topposts_skip_cat', array(
		'label'      		=> esc_html__( 'Skip posts from category:', 'skin' ),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_topposts_skip_cat',
		'type'       		=> 'text',
        'active_callback'	=> 'skin_check_specials_have_popular'
	));
	
// Exclude author
	$wp_customize->add_setting( 'skin_specials_topposts_skip_author', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_specials_topposts_skip_author', array(
		'label'      		=> esc_html__( 'Skip posts by author:', 'skin' ),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_topposts_skip_author',
		'type'       		=> 'text',
        'active_callback'	=> 'skin_check_specials_have_popular'
	));
	
// Allow autoplay
	$wp_customize->add_setting( 'skin_specials_topposts_auto', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_specials_topposts_auto', array(
		'label'      		=> esc_html__( 'Allow autoplay', 'skin' ),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_topposts_auto',
		'type'       		=> 'checkbox',
        'active_callback'	=> 'skin_check_specials_have_popular'
	));
	
// Show popular posts
	$wp_customize->add_setting( 'skin_specials_topposts_popular', array(
		'default'        	=> true,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_specials_topposts_popular', array(
		'label'      		=> esc_html__( 'Show popular posts', 'skin' ),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_topposts_popular',
		'type'       		=> 'checkbox',
        'active_callback'	=> 'skin_check_specials_have_popular'
	));
	
// Popular posts title
	$wp_customize->add_setting( 'skin_specials_topposts_popular_title', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'			=> esc_attr__( 'Popular posts', 'skin' ),
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_specials_topposts_popular_title', array(
		'label'      		=> esc_html__( 'Title for Popular posts tab:', 'skin' ),
		'input_attrs' 		=> array(
									'placeholder' => esc_attr__( 'Popular posts', 'skin' )
								),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_topposts_popular_title',
		'type'       		=> 'text',
        'active_callback'	=> 'skin_check_specials_have_popular'
	));
	
// Selective refresh for 'Popular' title
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_specials_topposts_popular_title' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_specials_topposts_popular_title', array(
			'selector' => '.masonry-item .skin-widget-top-posts .tabs .popular h3',
			'render_callback' => function() {
				echo get_theme_mod( 'skin_specials_topposts_popular_title' );
			}
		));
	}
	
// Show views on popular posts
	$wp_customize->add_setting( 'skin_specials_topposts_views', array(
		'default'        	=> true,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_specials_topposts_views', array(
		'label'      		=> esc_html__( 'Show views count', 'skin' ),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_topposts_views',
		'type'       		=> 'checkbox',
        'active_callback'	=> 'skin_check_specials_have_popular'
	));
	
// Selective refresh for the views
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_specials_topposts_views' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_specials_topposts_views', array(
			'selector' => '.masonry-item .top-posts-slide.popular .post-details',
			'render_callback' => function() {
				if( true === get_theme_mod( 'skin_specials_topposts_views' ) ) {
					esc_html_e( '10 views (preview)', 'skin' );
					
				} else {
					echo '';
				}
			}
		));
	}
	
// Show latest posts
	$wp_customize->add_setting( 'skin_specials_topposts_latest', array(
		'default'        	=> true,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_specials_topposts_latest', array(
		'label'      		=> esc_html__( 'Show latest posts', 'skin' ),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_topposts_latest',
		'type'       		=> 'checkbox',
        'active_callback'	=> 'skin_check_specials_have_popular'
	));
	
// Latest posts title
	$wp_customize->add_setting( 'skin_specials_topposts_latest_title', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'			=> esc_attr__( 'Latest posts', 'skin' ),
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_specials_topposts_latest_title', array(
		'label'      		=> esc_html__( 'Title for Latest posts tab:', 'skin' ),
		'input_attrs' 		=> array(
									'placeholder' => esc_attr__( 'Latest posts', 'skin' )
								),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_topposts_latest_title',
		'type'       		=> 'text',
        'active_callback'	=> 'skin_check_specials_have_popular'
	));
	
// Selective refresh for 'Latest' title
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_specials_topposts_latest_title' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_specials_topposts_latest_title', array(
			'selector' => '.masonry-item .skin-widget-top-posts .tabs .latest h3',
			'render_callback' => function() {
				echo get_theme_mod( 'skin_specials_topposts_latest_title' );
			}
		));
	}
	
// Show dates on latest posts
	$wp_customize->add_setting( 'skin_specials_topposts_dates', array(
		'default'        	=> true,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_specials_topposts_dates', array(
		'label'      		=> esc_html__( 'Show dates', 'skin' ),
		'section'    		=> 'skin_specials',
		'settings'   		=> 'skin_specials_topposts_dates',
		'type'       		=> 'checkbox',
        'active_callback'	=> 'skin_check_specials_have_popular'
	));
	
// Selective refresh for dates
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_specials_topposts_dates' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_specials_topposts_dates', array(
			'selector' => '.masonry-item .top-posts-slide.latest .post-details',
			'render_callback' => function() {
				if( true === get_theme_mod( 'skin_specials_topposts_dates' ) ) {
					esc_html_e( 'May 17, 2017 (preview)', 'skin' );
					
				} else {
					echo '';
				}
			}
		));
	}
	
// Background
	$wp_customize->add_setting(	'skin_specials_topposts_bgr', array(
		'default'			=> 'content-pad',
		'capability'     	=> 'edit_theme_options',
		'transport'        	=> 'postMessage',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_specials_topposts_bgr', array(
		'label'      => esc_html__( 'Background', 'skin' ),
		'section'    => 'skin_specials',
		'settings'   => 'skin_specials_topposts_bgr',
		'type'       => 'radio',
		'choices'    => array(
							'content-pad'	=> esc_html__( 'Same as posts in masonry', 'skin' ),
							'gradient-bgr'	=> esc_html__( 'Gradient background', 'skin' ),
							'no-bgr'		=> esc_html__( 'No background', 'skin' )
						),
		'active_callback'	=> 'skin_check_specials_have_popular'
	));
?>