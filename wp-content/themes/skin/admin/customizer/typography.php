<?php
/* ===============================================
	SKIN TYPORGAPHY, Customizer section
	Skin - Premium WordPress Theme, by NordWood
================================================== */
/* Main (body) typography
============================ */
/*
	Each Google Font "selection" is made of a font family and font variants
	+ subsets assinged to the family.
	When the Google Fonts URL request is generated, all the subsets are merged into one array.
	
	In case there's a problem with Google Fonts API, typography controls will be blocked.
*/	
	if ( 'font issue' === skin_get_google_fonts() ) {
		$wp_customize->add_setting( 'skin_typo_err', array(
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( new Skin_Customizer_Err_Notice( $wp_customize, 'skin_typo_err', array(
			'section'	=> 'skin_typography',
			'label'		=> esc_html__( 'Oops!', 'skin' )
		)));
			
		$wp_customize->get_control( 'skin_typo_err' )->description = esc_html__( 'It seems like there\'s an issue with fetching Google Fonts. Default ones will be used.', 'skin' );
		
	} else {	
	// Main (body)
		$wp_customize->add_setting( 'skin_typo_main', array(
			'default' 			=> 'Quicksand|regular|latin|15|30|0|none',
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( new Skin_Customize_Typography( $wp_customize, 'skin_typo_main', array(
			'label'      => esc_html__( 'Main', 'skin' ),
			'section'    => 'skin_typography',
			'settings'   => 'skin_typo_main'
		)));

	/* h1
	======= */
		$wp_customize->add_setting( 'skin_typo_h1', array(
			'default' 			=> 'Quicksand|500|latin|40|53|0|none',
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( new Skin_Customize_Typography( $wp_customize, 'skin_typo_h1', array(
			'label'      => esc_html__( 'h1', 'skin' ),
			'section'    => 'skin_typography',
			'settings'   => 'skin_typo_h1'
		)));

	/* h2
	======== */
		$wp_customize->add_setting( 'skin_typo_h2', array(
			'default' 			=> 'Quicksand|500|latin|32|40|0|none',
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( new Skin_Customize_Typography( $wp_customize, 'skin_typo_h2', array(
			'label'      => esc_html__( 'h2', 'skin' ),
			'section'    => 'skin_typography',
			'settings'   => 'skin_typo_h2'
		)));

	/* h3
	======== */
		$wp_customize->add_setting( 'skin_typo_h3', array(
			'default' 			=> 'Quicksand|500|latin|21|30|0|none',
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( new Skin_Customize_Typography( $wp_customize, 'skin_typo_h3', array(
			'label'      => esc_html__( 'h3', 'skin' ),
			'section'    => 'skin_typography',
			'settings'   => 'skin_typo_h3'
		)));

	/* h4
	========= */
		$wp_customize->add_setting( 'skin_typo_h4', array(
			'default' 			=> 'Quicksand|500|latin|18|26|0|none',
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( new Skin_Customize_Typography( $wp_customize, 'skin_typo_h4', array(
			'label'      => esc_html__( 'h4', 'skin' ),
			'section'    => 'skin_typography',
			'settings'   => 'skin_typo_h4'
		)));

	/* h5
	======== */
		$wp_customize->add_setting( 'skin_typo_h5', array(
			'default' 			=> 'Quicksand|500|latin|15|22|0|none',
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( new Skin_Customize_Typography( $wp_customize, 'skin_typo_h5', array(
			'label'      => esc_html__( 'h5', 'skin' ),
			'section'    => 'skin_typography',
			'settings'   => 'skin_typo_h5'
		)));

	/* h6
	======== */
		$wp_customize->add_setting( 'skin_typo_h6', array(
			'default' 			=> 'Quicksand|500|latin|10|18|1|none',
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( new Skin_Customize_Typography( $wp_customize, 'skin_typo_h6', array(
			'label'      => esc_html__( 'h6', 'skin' ),
			'section'    => 'skin_typography',
			'settings'   => 'skin_typo_h6'
		)));

	/* Welcome message
	===================== */
		$wp_customize->add_setting( 'skin_typo_welcome', array(
			'default' 			=> 'Quicksand|500|latin|40|53|0|none',
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( new Skin_Customize_Typography( $wp_customize, 'skin_typo_welcome', array(
			'label'      => esc_html__( 'Welcome message', 'skin' ),
			'section'    => 'skin_typography',
			'settings'   => 'skin_typo_welcome'
		)));

	/* Drop caps
	=============== */
		$wp_customize->add_setting( 'skin_typo_dropcaps', array(
			'default' 			=> 'Quicksand|500|latin|32|30|0|none',
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( new Skin_Customize_Typography( $wp_customize, 'skin_typo_dropcaps', array(
			'label'      => esc_html__( 'Drop caps', 'skin' ),
			'section'    => 'skin_typography',
			'settings'   => 'skin_typo_dropcaps'
		)));

	/* Blockquote
	================ */
		$wp_customize->add_setting( 'skin_typo_blockquote', array(
			'default' 			=> 'Quicksand|500|latin|21|30|0|none',
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( new Skin_Customize_Typography( $wp_customize, 'skin_typo_blockquote', array(
			'label'      => esc_html__( 'Blockquote', 'skin' ),
			'section'    => 'skin_typography',
			'settings'   => 'skin_typo_blockquote'
		)));

	/* Post details
	================== */
		$wp_customize->add_setting( 'skin_typo_details', array(
			'default' 			=> 'Quicksand|500|latin|12|18|0|none',
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( new Skin_Customize_Typography( $wp_customize, 'skin_typo_details', array(
			'label'      => esc_html__( 'Post details', 'skin' ),
			'section'    => 'skin_typography',
			'settings'   => 'skin_typo_details'
		)));

	/* Small text
	================ */
		$wp_customize->add_setting( 'skin_typo_small_text', array(
			'default' 			=> 'Quicksand|regular|latin|13|24|0|none',
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( new Skin_Customize_Typography( $wp_customize, 'skin_typo_small_text', array(
			'label'      => esc_html__( 'Post excerpt', 'skin' ),
			'section'    => 'skin_typography',
			'settings'   => 'skin_typo_small_text'
		)));

	/* Main menu
	=============== */
		$wp_customize->add_setting( 'skin_typo_topbar', array(
			'default' 			=> 'Quicksand|500|latin|17|30|0|none',
			'sanitize_callback' => 'sanitize_text_field'
		));
		
		$wp_customize->add_control( new Skin_Customize_Typography( $wp_customize, 'skin_typo_topbar', array(
			'label'      => esc_html__( 'Main menu', 'skin' ),
			'section'    => 'skin_typography',
			'settings'   => 'skin_typo_topbar'
		)));
	}
?>