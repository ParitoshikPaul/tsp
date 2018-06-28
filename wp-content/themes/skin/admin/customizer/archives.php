<?php
/* ===============================================
	SKIN ARCHIVES, Customizer section
	Skin - Premium WordPress Theme, by NordWood
================================================== */
/*	Category Archive
======================= */
    $wp_customize->add_setting( 'skin_category_archive', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_category_archive', array(
		'section'	=> 'skin_archives',
		'label'		=> esc_html__( 'Category', 'skin' ),
		'divider'	=> false,
		'large'		=> true
	)));
	
// Category layout type
	$wp_customize->add_setting(	'skin_category_layout', array(
		'default'			=> 'masonry-3',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_category_layout', array(
		'label'      => esc_html__( 'Layout type', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_category_layout',
		'type'       => 'radio',
		'choices'    => array(
			'masonry-2-sidebar'		=> esc_html__( 'Masonry in 2 columns + sidebar', 'skin' ),
			'masonry-3'				=> esc_html__( 'Masonry in 3 columns', 'skin' ),
			'masonry-4-full-width'	=> esc_html__( 'Masonry in 4 columns (full width)', 'skin' ),
			'masonry-5-full-width'	=> esc_html__( 'Masonry in 5 columns (full width)', 'skin' ),
			'standard-list'			=> esc_html__( 'Standard list', 'skin' ),
			'standard-list-sidebar'	=> esc_html__( 'Standard list + sidebar', 'skin' )
		)
	));
	
// Category archive pagination
	$wp_customize->add_setting(	'skin_category_pagination', array(
		'default'			=> 'infinite',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_category_pagination', array(
		'label'      => esc_html__( 'Pagination', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_category_pagination',
		'type'       => 'radio',
		'choices'    => array(
			'infinite'				=> esc_html__( 'Infinite scroll', 'skin' ),
			'standard-pagination'	=> esc_html__( 'Standard pagination', 'skin' )
		)
	));
	
    $wp_customize->add_setting( 'skin_category_specials', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_category_specials', array(
		'section'	=> 'skin_archives',
		'label'		=> esc_html__( 'Special boxes', 'skin' ),
		'divider'	=> false
	)));
	
// Popout link on category archive	
	$wp_customize->add_setting( 'skin_category_specials_popout', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_category_specials_popout', array(
		'label'      => esc_html__( 'Popout link', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_category_specials_popout',
		'type'       => 'checkbox'
	));
	
// Checkbox for each of the 5 image banners available
	for ( $i = 1; $i <= 5; $i++ ) {
	// Image Banner i on category archive	
		$wp_customize->add_setting( 'skin_category_specials_bnnr_'.$i, array(
			'default'        	=> false,
			'capability'     	=> 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'sanitize_callback' => 'skin_sanitize_checkbox',
		));
		
		$wp_customize->add_control( 'skin_category_specials_bnnr_'.$i, array(
			'label'		=> sprintf(
								esc_html__( 'Image Banner %u', 'skin' ),
								$i
							),
			'section'	=> 'skin_archives',
			'settings'	=> 'skin_category_specials_bnnr_'.$i,
			'type'		=> 'checkbox'
		));
	}
	
// Social profiles on category archive	
	$wp_customize->add_setting( 'skin_category_specials_social', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_category_specials_social', array(
		'label'      => esc_html__( 'Social profiles', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_category_specials_social',
		'type'       => 'checkbox'
	));

// Popular/Latest posts on category archive
	$wp_customize->add_setting( 'skin_category_specials_topposts', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_category_specials_topposts', array(
		'label'      => esc_html__( 'Popular/Latest posts', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_category_specials_topposts',
		'type'       => 'checkbox'
	));

/*	Archive by tag
===================== */
    $wp_customize->add_setting( 'skin_tag', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_tag', array(
		'section'	=> 'skin_archives',
		'label'		=> esc_html__( 'Tag', 'skin' ),
		'large'		=> true
	)));
	
// Tag archive layout type
	$wp_customize->add_setting(	'skin_tag_layout', array(
		'default'			=> 'masonry-3',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_tag_layout', array(
		'label'      => esc_html__( 'Layout type', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_tag_layout',
		'type'       => 'radio',
		'choices'    => array(
			'masonry-2-sidebar'		=> esc_html__( 'Masonry in 2 columns + sidebar', 'skin' ),
			'masonry-3'				=> esc_html__( 'Masonry in 3 columns', 'skin' ),
			'masonry-4-full-width'	=> esc_html__( 'Masonry in 4 columns (full width)', 'skin' ),
			'masonry-5-full-width'	=> esc_html__( 'Masonry in 5 columns (full width)', 'skin' ),
			'standard-list'			=> esc_html__( 'Standard list', 'skin' ),
			'standard-list-sidebar'	=> esc_html__( 'Standard list + sidebar', 'skin' )
		)
	));
	
// Tag archive pagination
	$wp_customize->add_setting(	'skin_tag_pagination', array(
		'default'			=> 'infinite',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_tag_pagination', array(
		'label'      => esc_html__( 'Pagination', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_tag_pagination',
		'type'       => 'radio',
		'choices'    => array(
			'infinite'				=> esc_html__( 'Infinite scroll', 'skin' ),
			'standard-pagination'	=> esc_html__( 'Standard pagination', 'skin' )
		)
	));
	
// Special boxes on tag archive
    $wp_customize->add_setting( 'skin_tag_specials', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_tag_specials', array(
		'section'	=> 'skin_archives',
		'label'		=> esc_html__( 'Special boxes', 'skin' ),
		'divider'	=> false
	)));
	
// Popout link on tag archive	
	$wp_customize->add_setting( 'skin_tag_specials_popout', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_tag_specials_popout', array(
		'label'      => esc_html__( 'Popout link', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_tag_specials_popout',
		'type'       => 'checkbox'
	));
	
// Checkbox for each of the 5 image banners available
	for ( $i = 1; $i <= 5; $i++ ) {
	// Image Banner i on tag archive	
		$wp_customize->add_setting( 'skin_tag_specials_bnnr_'.$i, array(
			'default'        	=> false,
			'capability'     	=> 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'sanitize_callback' => 'skin_sanitize_checkbox',
		));
		
		$wp_customize->add_control( 'skin_tag_specials_bnnr_'.$i, array(
			'label'		=> sprintf(
								esc_html__( 'Image Banner %u', 'skin' ),
								$i
							),
			'section'	=> 'skin_archives',
			'settings'	=> 'skin_tag_specials_bnnr_'.$i,
			'type'		=> 'checkbox'
		));
	}

// Social profiles on tag archive	
	$wp_customize->add_setting( 'skin_tag_specials_social', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_tag_specials_social', array(
		'label'      => esc_html__( 'Social profiles', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_tag_specials_social',
		'type'       => 'checkbox'
	));

// Popular/Latest posts on tag archive
	$wp_customize->add_setting( 'skin_tag_specials_topposts', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_tag_specials_topposts', array(
		'label'      => esc_html__( 'Popular/Latest posts', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_tag_specials_topposts',
		'type'       => 'checkbox'
	));

/*	Archive by author
======================== */	
    $wp_customize->add_setting( 'skin_author', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_author', array(
		'section'	=> 'skin_archives',
		'label'		=> esc_html__( 'Author', 'skin' ),
		'large'		=> true
	)));
	
// Author archive layout type
	$wp_customize->add_setting(	'skin_author_layout', array(
		'default'			=> 'masonry-3',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_author_layout', array(
		'label'      => esc_html__( 'Layout type', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_author_layout',
		'type'       => 'radio',
		'choices'    => array(
			'masonry-2-sidebar'		=> esc_html__( 'Masonry in 2 columns + sidebar', 'skin' ),
			'masonry-3'				=> esc_html__( 'Masonry in 3 columns', 'skin' ),
			'masonry-4-full-width'	=> esc_html__( 'Masonry in 4 columns (full width)', 'skin' ),
			'masonry-5-full-width'	=> esc_html__( 'Masonry in 5 columns (full width)', 'skin' ),
			'standard-list'			=> esc_html__( 'Standard list', 'skin' ),
			'standard-list-sidebar'	=> esc_html__( 'Standard list + sidebar', 'skin' )
		)
	));
	
// Author archive pagination
	$wp_customize->add_setting(	'skin_author_pagination', array(
		'default'			=> 'infinite',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_author_pagination', array(
		'label'      	=> esc_html__( 'Pagination', 'skin' ),
		'section'    	=> 'skin_archives',
		'settings'   	=> 'skin_author_pagination',
		'type'       	=> 'radio',
		'choices'    	=> array(
			'infinite'				=> esc_html__( 'Infinite scroll', 'skin' ),
			'standard-pagination'	=> esc_html__( 'Standard pagination', 'skin' )
		)
	));
	
// Special boxes on author archive
    $wp_customize->add_setting( 'skin_author_specials', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_author_specials', array(
		'section'	=> 'skin_archives',
		'label'		=> esc_html__( 'Special boxes', 'skin' ),
		'divider'	=> false
	)));
	
// Popout link on author archive	
	$wp_customize->add_setting( 'skin_author_specials_popout', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_author_specials_popout', array(
		'label'      => esc_html__( 'Popout link', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_author_specials_popout',
		'type'       => 'checkbox'
	));
	
// Checkbox for each of the 5 image banners available
	for ( $i = 1; $i <= 5; $i++ ) {
	// Image Banner i on author archive	
		$wp_customize->add_setting( 'skin_author_specials_bnnr_'.$i, array(
			'default'        	=> false,
			'capability'     	=> 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'sanitize_callback' => 'skin_sanitize_checkbox',
		));
		
		$wp_customize->add_control( 'skin_author_specials_bnnr_'.$i, array(
			'label'		=> sprintf(
								esc_html__( 'Image Banner %u', 'skin' ),
								$i
							),
			'section'	=> 'skin_archives',
			'settings'	=> 'skin_author_specials_bnnr_'.$i,
			'type'		=> 'checkbox'
		));
	}

// Social profiles on author archive	
	$wp_customize->add_setting( 'skin_author_specials_social', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_author_specials_social', array(
		'label'      => esc_html__( 'Social profiles', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_author_specials_social',
		'type'       => 'checkbox'
	));

// Popular/Latest posts on author archive
	$wp_customize->add_setting( 'skin_author_specials_topposts', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_author_specials_topposts', array(
		'label'      => esc_html__( 'Popular/Latest posts', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_author_specials_topposts',
		'type'       => 'checkbox'
	));

/*	Archive by date
====================== */	
    $wp_customize->add_setting( 'skin_date', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_date', array(
		'section'	=> 'skin_archives',
		'label'		=> esc_html__( 'Date', 'skin' ),
		'large'		=> true
	)));
	
// Date archive layout type
	$wp_customize->add_setting(	'skin_date_layout', array(
		'default'			=> 'masonry-3',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_date_layout', array(
		'label'      => esc_html__( 'Layout type', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_date_layout',
		'type'       => 'radio',
		'choices'    => array(
			'masonry-2-sidebar'		=> esc_html__( 'Masonry in 2 columns + sidebar', 'skin' ),
			'masonry-3'				=> esc_html__( 'Masonry in 3 columns', 'skin' ),
			'masonry-4-full-width'	=> esc_html__( 'Masonry in 4 columns (full width)', 'skin' ),
			'masonry-5-full-width'	=> esc_html__( 'Masonry in 5 columns (full width)', 'skin' ),
			'standard-list'			=> esc_html__( 'Standard list', 'skin' ),
			'standard-list-sidebar'	=> esc_html__( 'Standard list + sidebar', 'skin' )
		)
	));
	
// Date archive pagination
	$wp_customize->add_setting(	'skin_date_pagination', array(
		'default'			=> 'infinite',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_date_pagination', array(
		'label'      => esc_html__( 'Pagination', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_date_pagination',
		'type'       => 'radio',
		'choices'    => array(
			'infinite'				=> esc_html__( 'Infinite scroll', 'skin' ),
			'standard-pagination'	=> esc_html__( 'Standard pagination', 'skin' )
		)
	));
	
// Special boxes on date archive
    $wp_customize->add_setting( 'skin_date_specials', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_date_specials', array(
		'section'	=> 'skin_archives',
		'label'		=> esc_html__( 'Special boxes', 'skin' ),
		'divider'	=> false
	)));
	
// Popout link on date archive	
	$wp_customize->add_setting( 'skin_date_specials_popout', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_date_specials_popout', array(
		'label'      => esc_html__( 'Popout link', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_date_specials_popout',
		'type'       => 'checkbox'
	));
	
// Checkbox for each of the 5 image banners available
	for ( $i = 1; $i <= 5; $i++ ) {
	// Image Banner i on date archive	
		$wp_customize->add_setting( 'skin_date_specials_bnnr_'.$i, array(
			'default'        	=> false,
			'capability'     	=> 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'sanitize_callback' => 'skin_sanitize_checkbox',
		));
		
		$wp_customize->add_control( 'skin_date_specials_bnnr_'.$i, array(
			'label'		=> sprintf(
								esc_html__( 'Image Banner %u', 'skin' ),
								$i
							),
			'section'    => 'skin_archives',
			'settings'   => 'skin_date_specials_bnnr_'.$i,
			'type'       => 'checkbox'
		));
	}

// Social profiles on date archive	
	$wp_customize->add_setting( 'skin_date_specials_social', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_date_specials_social', array(
		'label'      => esc_html__( 'Social profiles', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_date_specials_social',
		'type'       => 'checkbox'
	));

// Popular/Latest posts on date archive
	$wp_customize->add_setting( 'skin_date_specials_topposts', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_date_specials_topposts', array(
		'label'      => esc_html__( 'Popular/Latest posts', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_date_specials_topposts',
		'type'       => 'checkbox'
	));

/*	Search results
===================== */	
    $wp_customize->add_setting( 'skin_search', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_search', array(
		'section'	=> 'skin_archives',
		'label'		=> esc_html__( 'Search', 'skin' ),
		'large'		=> true
	)));
	
// Search archive layout type
	$wp_customize->add_setting(	'skin_search_layout', array(
		'default'			=> 'masonry-3',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_search_layout', array(
		'label'      => esc_html__( 'Layout type', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_search_layout',
		'type'       => 'radio',
		'choices'    => array(
			'masonry-2-sidebar'		=> esc_html__( 'Masonry in 2 columns + sidebar', 'skin' ),
			'masonry-3'				=> esc_html__( 'Masonry in 3 columns', 'skin' ),
			'masonry-4-full-width'	=> esc_html__( 'Masonry in 4 columns (full width)', 'skin' ),
			'masonry-5-full-width'	=> esc_html__( 'Masonry in 5 columns (full width)', 'skin' ),
			'standard-list'			=> esc_html__( 'Standard list', 'skin' ),
			'standard-list-sidebar'	=> esc_html__( 'Standard list + sidebar', 'skin' )
		)
	));
	
// Search archive pagination
	$wp_customize->add_setting(	'skin_search_pagination', array(
		'default'			=> 'infinite',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_search_pagination', array(
		'label'      => esc_html__( 'Pagination', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_search_pagination',
		'type'       => 'radio',
		'choices'    => array(
			'infinite'				=> esc_html__( 'Infinite scroll', 'skin' ),
			'standard-pagination'	=> esc_html__( 'Standard pagination', 'skin' )
		)
	));
	
// Special boxes on search results
    $wp_customize->add_setting( 'skin_search_specials', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_search_specials', array(
		'section'	=> 'skin_archives',
		'label'		=> esc_html__( 'Special boxes', 'skin' ),
		'divider'	=> false
	)));
	
// Popout link on search results
	$wp_customize->add_setting( 'skin_search_specials_popout', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_search_specials_popout', array(
		'label'      => esc_html__( 'Popout link', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_search_specials_popout',
		'type'       => 'checkbox'
	));
	
// Checkbox for each of the 5 image banners available
	for ( $i = 1; $i <= 5; $i++ ) {
	// Image Banner i on search results	
		$wp_customize->add_setting( 'skin_search_specials_bnnr_'.$i, array(
			'default'        	=> false,
			'capability'     	=> 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'sanitize_callback' => 'skin_sanitize_checkbox',
		));
		
		$wp_customize->add_control( 'skin_search_specials_bnnr_'.$i, array(
			'label'		=> sprintf(
								esc_html__( 'Image Banner %u', 'skin' ),
								$i
							),
			'section'	=> 'skin_archives',
			'settings'	=> 'skin_search_specials_bnnr_'.$i,
			'type'		=> 'checkbox'
		));
	}

// Social profiles on search results	
	$wp_customize->add_setting( 'skin_search_specials_social', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_search_specials_social', array(
		'label'      => esc_html__( 'Social profiles', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_search_specials_social',
		'type'       => 'checkbox'
	));

// Popular/Latest posts on search results
	$wp_customize->add_setting( 'skin_search_specials_topposts', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_search_specials_topposts', array(
		'label'      => esc_html__( 'Popular/Latest posts', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_search_specials_topposts',
		'type'       => 'checkbox'
	));

/*	Other archives
===================== */
    $wp_customize->add_setting( 'skin_archive', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_archive', array(
		'section'	=> 'skin_archives',
		'label'		=> esc_html__( 'Other archives', 'skin' ),
		'large'		=> true
	)));	
	
// Archive layout type
	$wp_customize->add_setting(	'skin_archive_layout', array(
		'default'			=> 'masonry-3',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_archive_layout', array(
		'label'      => esc_html__( 'Layout type', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_archive_layout',
		'type'       => 'radio',
		'choices'    => array(
			'masonry-2-sidebar'		=> esc_html__( 'Masonry in 2 columns + sidebar', 'skin' ),
			'masonry-3'				=> esc_html__( 'Masonry in 3 columns', 'skin' ),
			'masonry-4-full-width'	=> esc_html__( 'Masonry in 4 columns (full width)', 'skin' ),
			'masonry-5-full-width'	=> esc_html__( 'Masonry in 5 columns (full width)', 'skin' ),
			'standard-list'			=> esc_html__( 'Standard list', 'skin' ),
			'standard-list-sidebar'	=> esc_html__( 'Standard list + sidebar', 'skin' )
		)
	));
	
// Archive pagination
	$wp_customize->add_setting(	'skin_archive_pagination', array(
		'default'			=> 'infinite',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_archive_pagination', array(
		'label'      => esc_html__( 'Pagination', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_archive_pagination',
		'type'       => 'radio',
		'choices'    => array(
			'infinite'				=> esc_html__( 'Infinite scroll', 'skin' ),
			'standard-pagination'	=> esc_html__( 'Standard pagination', 'skin' )
		)
	));
	
// Special boxes on other archives
    $wp_customize->add_setting( 'skin_archive_specials', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_archive_specials', array(
		'section'	=> 'skin_archives',
		'label'		=> esc_html__( 'Special boxes', 'skin' ),
		'divider'	=> false
	)));
	
// Popout link on other archives
	$wp_customize->add_setting( 'skin_archive_specials_popout', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_archive_specials_popout', array(
		'label'      => esc_html__( 'Popout link', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_archive_specials_popout',
		'type'       => 'checkbox'
	));
	
// Checkbox for each of the 5 image banners available
	for ( $i = 1; $i <= 5; $i++ ) {
	// Image Banner i on other archives	
		$wp_customize->add_setting( 'skin_archive_specials_bnnr_'.$i, array(
			'default'        	=> false,
			'capability'     	=> 'edit_theme_options',
			'type'           	=> 'theme_mod',
			'sanitize_callback' => 'skin_sanitize_checkbox',
		));
		
		$wp_customize->add_control( 'skin_archive_specials_bnnr_'.$i, array(
			'label'		=> sprintf(
								esc_html__( 'Image Banner %u', 'skin' ),
								$i
							),
			'section'    => 'skin_archives',
			'settings'   => 'skin_archive_specials_bnnr_'.$i,
			'type'       => 'checkbox'
		));
	}

// Social profiles on other archives
	$wp_customize->add_setting( 'skin_archive_specials_social', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_archive_specials_social', array(
		'label'      => esc_html__( 'Social profiles', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_archive_specials_social',
		'type'       => 'checkbox'
	));

// Popular/Latest posts on archives
	$wp_customize->add_setting( 'skin_archive_specials_topposts', array(
		'default'        	=> false,
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_archive_specials_topposts', array(
		'label'      => esc_html__( 'Popular/Latest posts', 'skin' ),
		'section'    => 'skin_archives',
		'settings'   => 'skin_archive_specials_topposts',
		'type'       => 'checkbox'
	));
?>