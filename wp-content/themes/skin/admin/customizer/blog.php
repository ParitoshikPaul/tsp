<?php
/* ===============================================
	SKIN BLOG PAGE, Customizer section
	Skin - Premium WordPress Theme, by NordWood
================================================== */
/*	Blog layout
================== */
    $wp_customize->add_setting( 'skin_blog', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_blog', array(
		'section'		=> 'skin_blog',
		'description'	=> esc_html__( 'Applied to blog page, or home page when it\'s displaying the latest posts.', 'skin' ),
		'divider'		=> false
	)));
	
// Blog layout type
	$wp_customize->add_setting(	'skin_blog_layout', array(
		'default'			=> 'masonry-3',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_blog_layout', array(
		'label'      => esc_html__( 'Blog layout type', 'skin' ),
		'section'    => 'skin_blog',
		'settings'   => 'skin_blog_layout',
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
	
// Sidebar position
	$wp_customize->add_setting(	'skin_blog_sidebar', array(
		'default'			=> 'sidebar-right',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_blog_sidebar', array(
		'label'      	=> esc_html__( 'Sidebar position', 'skin' ),
		'description'	=> esc_html__( 'Applies to all archive layouts, when sidebar is included.', 'skin' ),
		'section'    	=> 'skin_blog',
		'settings'   	=> 'skin_blog_sidebar',
		'type'       	=> 'radio',
		'choices'    	=> array(
								'sidebar-right'	=> esc_html__( 'On the right', 'skin' ),
								'sidebar-left'	=> esc_html__( 'On the left', 'skin' )
							)
	));
	
// Pagination
	$wp_customize->add_setting(	'skin_blog_pagination_type', array(
		'default'			=> 'infinite',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_blog_pagination_type', array(
		'label'      => esc_html__( 'Pagination', 'skin' ),
		'section'    => 'skin_blog',
		'settings'   => 'skin_blog_pagination_type',
		'type'       => 'radio',
		'choices'    => array(
							'infinite'				=> esc_html__( 'Infinite scroll', 'skin' ),
							'standard-pagination'	=> esc_html__( 'Standard pagination', 'skin' )
						)
	));
	
/* Blog featured area
========================= */
    $wp_customize->add_setting( 'skin_blog_featured_area', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_blog_featured_area', array(
		'section'	=> 'skin_blog',
		'label'		=> esc_html__( 'Blog featured area', 'skin' )
	)));
	
	$wp_customize->add_setting(	'skin_blog_featured', array(
		'default'			=> 'skip',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_blog_featured', array(
		'label'      => esc_html__( 'Show:', 'skin' ),
		'section'    => 'skin_blog',
		'settings'   => 'skin_blog_featured',
		'type'       => 'radio',
		'choices'    => array(
							'welcome-mssg'		=> esc_html__( 'Welcome message (text)', 'skin' ),
							'enlarge-latest'	=> esc_html__( 'Latest post (one)', 'skin' ),
							'grid-latest'		=> esc_html__( 'Latest posts (grid of 3 posts)', 'skin' ),
							'slider-latest'		=> esc_html__( 'Latest posts (slider)', 'skin' ),
							'enlarge-featured'	=> esc_html__( 'Featured post (one)', 'skin' ),
							'grid-featured'		=> esc_html__( 'Featured posts (grid of 3 posts)', 'skin' ),
							'slider-featured'	=> esc_html__( 'Featured posts (slider)', 'skin' ),
							'skip'				=> esc_html__( 'Nothing', 'skin' )
						)
	));
	
// Welcome message
	$wp_customize->add_setting( 'skin_blog_welcome_mssg', array(
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_blog_welcome_mssg', array(
		'label'      		=> esc_html__( 'Welcome message', 'skin' ),
		'section'    		=> 'skin_blog',
		'settings'   		=> 'skin_blog_welcome_mssg',
		'type'       		=> 'text',
		'active_callback'	=> 'skin_check_blog_has_welcome'
	));
	
// Selective refresh for welcome message
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_blog_welcome_mssg' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_blog_welcome_mssg', array(
			'selector' => '.welcome-mssg',
			'render_callback' => function() {
				echo esc_html( get_theme_mod( 'skin_blog_welcome_mssg' ) );
			}
		));
	}
	
// Number of latest posts to show in slider
	$wp_customize->add_setting( 'skin_blog_slider_count', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'           => esc_attr__( '5', 'skin' ),
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_blog_slider_count', array(
		'label'      		=> esc_html__( 'Number of posts in slider', 'skin' ),
		'input_attrs' 		=> array(
									'placeholder' => esc_attr__( '5', 'skin' )
								),
		'section'    		=> 'skin_blog',
		'settings'   		=> 'skin_blog_slider_count',
		'type'       		=> 'number',
		'active_callback'	=> 'skin_check_blog_has_slider_latest'
	));
	
// Choose posts for slider (by tag)
	$wp_customize->add_setting( 'skin_blog_feature_recent_by_tag', array(
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_blog_feature_recent_by_tag', array(
		'label'      		=> esc_html__( 'Show posts with tag(s):', 'skin' ),
		'description'  		=> esc_html__( 'Separate tags with comma.', 'skin' ),
		'section'    		=> 'skin_blog',
		'settings'   		=> 'skin_blog_feature_recent_by_tag',
		'type'       		=> 'text',
		'active_callback'	=> 'skin_check_blog_has_featured_recent'
	));
	
// Choose featured post
	$wp_customize->add_setting( 'skin_blog_enlarged_id', array(
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_blog_enlarged_id', array(
		'label'      		=> esc_html__( 'Featured post ID:', 'skin' ),
		'section'    		=> 'skin_blog',
		'settings'   		=> 'skin_blog_enlarged_id',
		'type'       		=> 'number',
		'active_callback'	=> 'skin_check_blog_has_enlarged_custom'
	));
	
// Selective refresh for featured post
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_blog_enlarged_id' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_blog_enlarged_id', array(
			'selector' => '.blog-featured',
			'render_callback' => function() {
				$id = get_theme_mod( 'skin_blog_enlarged_id' );
				
				if ( 0 != $id && skin_post_exist( $id ) && ( 'post' === get_post_type( $id ) || 'page' === get_post_type( $id ) ) ) {
					skin_post_enlarged( $id );					
				}
			}
		));
	}
	
// Choose posts for grid
	$wp_customize->add_setting( 'skin_blog_grid_ids', array(
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_blog_grid_ids', array(
		'label'      		=> esc_html__( 'IDs of posts for the grid', 'skin' ),
		'description'  		=> esc_html__( 'There should be exactly 3 of them, separated with coma.', 'skin' ),
		'section'    		=> 'skin_blog',
		'settings'   		=> 'skin_blog_grid_ids',
		'type'       		=> 'text',
		'active_callback'	=> 'skin_check_blog_has_featured_grid'
	));
	
// Selective refresh for featured posts grid
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_blog_grid_ids' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_blog_grid_ids', array(
			'selector' => '.blog-featured',
			'render_callback' => function() {
				$grid_of = get_theme_mod( 'skin_blog_grid_ids' );
				$filter = explode( ',', $grid_of );
				$ids = array();
				
				if ( is_array( $filter ) && 3 === sizeof( $filter ) ) {
					foreach ( $filter as $key => $val ) {
						$id = $filter[$key];
						
						if ( 0 != $id && skin_post_exist( $id ) && ( 'post' === get_post_type( $id ) || 'page' === get_post_type( $id ) ) ) {
							$ids[] = $id;							
						}
					}
					
					skin_posts_grid( $ids );
				}
			}
		));
	}
	
// Choose posts for slider (by ID)
	$wp_customize->add_setting( 'skin_blog_slider_ids', array(
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_blog_slider_ids', array(
		'label'      		=> esc_html__( 'IDs of posts for the slider', 'skin' ),
		'description'  		=> esc_html__( 'Separate ids with comma.', 'skin' ),
		'section'    		=> 'skin_blog',
		'settings'   		=> 'skin_blog_slider_ids',
		'type'       		=> 'text',
		'active_callback'	=> 'skin_check_blog_has_slider_custom'
	));
	
// Allow autoplay
	$wp_customize->add_setting( 'skin_blog_slider_auto', array(
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_blog_slider_auto', array(
		'label'      		=> esc_html__( 'Autoplay', 'skin' ),
		'section'    		=> 'skin_blog',
		'settings'   		=> 'skin_blog_slider_auto',
		'type'       		=> 'checkbox',
		'active_callback'	=> 'skin_check_blog_has_slider'
	));
	
// Post details
    $wp_customize->add_setting( 'skin_blog_featured_details', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_blog_featured_details', array(
		'section'			=> 'skin_blog',
		'label'				=> esc_html__( 'Post details for featured posts', 'skin' ),
		'active_callback'	=> 'skin_check_blog_has_featured',
		'divider'			=> false
	)));
	
// Show category
	$wp_customize->add_setting( 'skin_featured_show_cat', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_featured_show_cat', array(
		'label'      		=> esc_html__( 'Show category', 'skin' ),
		'section'    		=> 'skin_blog',
		'settings'   		=> 'skin_featured_show_cat',
		'type'       		=> 'checkbox',
		'active_callback'	=> 'skin_check_blog_has_enlarged_or_grid'
	));
	
// Show excerpt
	$wp_customize->add_setting( 'skin_featured_show_excerpt', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_featured_show_excerpt', array(
		'label'      		=> esc_html__( 'Show excerpt', 'skin' ),
		'section'    		=> 'skin_blog',
		'settings'   		=> 'skin_featured_show_excerpt',
		'type'       		=> 'checkbox',
		'active_callback'	=> 'skin_check_blog_has_enlarged'
	));
	
// Show author's name
	$wp_customize->add_setting( 'skin_featured_show_author', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_featured_show_author', array(
		'label'      		=> esc_html__( 'Show author\'s name', 'skin' ),
		'section'    		=> 'skin_blog',
		'settings'   		=> 'skin_featured_show_author',
		'type'       		=> 'checkbox',
		'active_callback'	=> 'skin_check_blog_has_featured'
	));
	
// Show date
	$wp_customize->add_setting( 'skin_featured_show_date', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_featured_show_date', array(
		'label'      		=> esc_html__( 'Show date', 'skin' ),
		'section'    		=> 'skin_blog',
		'settings'   		=> 'skin_featured_show_date',
		'type'       		=> 'checkbox',
		'active_callback'	=> 'skin_check_blog_has_featured'
	));
	
/*	Posts to exclude
======================= */
    $wp_customize->add_setting( 'skin_blog_exclude_posts', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_blog_exclude_posts', array(
		'section'	=> 'skin_blog',
		'label'		=> esc_html__( 'Posts to skip in the list', 'skin' )
	)));
	
// Exclude posts that are already shown in featured area
	$wp_customize->add_setting( 'skin_blog_skip_featured', array(
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_blog_skip_featured', array(
		'label'      => esc_html__( 'Exclude featured posts', 'skin' ),
		'section'    => 'skin_blog',
		'settings'   => 'skin_blog_skip_featured',
		'type'       => 'checkbox'
	));
	
// Exclude posts by category
	$wp_customize->add_setting( 'skin_blog_skip_category', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_blog_skip_category', array(
		'label'      	=> esc_html__( 'Exclude posts by category', 'skin' ),
		'description'  	=> esc_html__( 'Use category ID. For multiple categories, separate ids with comma. This option will also affect the featured area.', 'skin' ),
		'section'    	=> 'skin_blog',
		'settings'   	=> 'skin_blog_skip_category',
		'type'       	=> 'text'
	));
	
// Exclude posts by author
	$wp_customize->add_setting( 'skin_blog_skip_author', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_blog_skip_author', array(
		'label'      	=> esc_html__( 'Exclude posts by author', 'skin' ),
		'description'  	=> esc_html__( 'Use author ID. For more authors, separate ids with comma. This option will also affect the featured area.', 'skin' ),
		'section'    	=> 'skin_blog',
		'settings'   	=> 'skin_blog_skip_author',
		'type'       	=> 'text'
	));
	
/*	Trendy posts
=================== */
    $wp_customize->add_setting( 'skin_blog_trendy_posts', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_blog_trendy_posts', array(
		'section'		=> 'skin_blog',
		'label'			=> esc_html__( 'Trendy posts', 'skin' ),
		'description'	=> esc_html__( 'They will be automatically chosen by the number of views.', 'skin' )
	)));
	
// Show trendy posts
	$wp_customize->add_setting( 'skin_blog_trendy', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_blog_trendy', array(
		'label'      => esc_html__( 'Mark the most popular posts', 'skin' ),
		'section'    => 'skin_blog',
		'settings'   => 'skin_blog_trendy',
		'type'       => 'checkbox'
	));
	
// Number of trendy posts
	$wp_customize->add_setting( 'skin_blog_trendy_qty', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'           => esc_attr__( '5', 'skin' ),
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_blog_trendy_qty', array(
		'label'      	=> esc_html__( 'Number of trendy posts to mark:', 'skin' ),
		'input_attrs' 	=> array(
								'placeholder' => esc_attr__( '5', 'skin' )
							),
		'section'    	=> 'skin_blog',
		'settings'   	=> 'skin_blog_trendy_qty',
		'type'       	=> 'number'
	));
	
/*	Featured image
===================================== */
    $wp_customize->add_setting( 'skin_blog_featured_img', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_blog_featured_img', array(
		'section'			=> 'skin_blog',
		'label'				=> esc_html__( 'Featured images', 'skin' ),
		'active_callback'	=> 'skin_check_layout_has_img_shape_ctrls'
	)));
	
// Featured image on standard, audio and video post
	$wp_customize->add_setting(	'skin_blog_featured_img_shape', array(
		'default'			=> 'natural',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_blog_featured_img_shape', array(
		'label'      		=> esc_html__( 'Featured image shape', 'skin' ),
		'description'		=> esc_html__( 'Applies to standard, audio and video posts, for masonry list only.', 'skin' ),
		'section'    		=> 'skin_blog',
		'settings'   		=> 'skin_blog_featured_img_shape',
		'type'       		=> 'radio',
		'choices'    		=> array(
									'circle'	=> esc_html__( 'Circle', 'skin' ),
									'square'	=> esc_html__( 'Square', 'skin' ),
									'natural'	=> esc_html__( 'Natural', 'skin' ),
									'hidden'	=> esc_html__( 'Hide featured image', 'skin' )
								),
		'active_callback'	=> 'skin_check_layout_has_img_shape_ctrls'
	));
	
// Image placeholder
	$wp_customize->add_setting( 'skin_img_placeholder', array(
		'capability'     	=> 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'type'           	=> 'theme_mod'
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'skin_img_placeholder', array(
		'label'			=> esc_html__( 'Image placeholder', 'skin' ),
		'description'	=> esc_html__( 'To show when no image is found. When no placeholder is uploaded either, gradient background will be used.', 'skin' ),
		'section'		=> 'skin_blog',
		'settings'		=> 'skin_img_placeholder'
	)));

/*	Details in posts list
============================ */
    $wp_customize->add_setting( 'skin_blog_details', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_blog_details', array(
		'section'		=> 'skin_blog',
		'label'			=> esc_html__( 'Post details', 'skin' ),
		'description'	=> esc_html__( 'Choose the elements to show/hide on each post in blog list.', 'skin' )
	)));
	
// Category
	$wp_customize->add_setting( 'skin_blog_show_category', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_blog_show_category', array(
		'label'      => esc_html__( 'Show category', 'skin' ),
		'section'    => 'skin_blog',
		'settings'   => 'skin_blog_show_category',
		'type'       => 'checkbox'
	));
	
// Author
	$wp_customize->add_setting( 'skin_blog_show_author', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_blog_show_author', array(
		'label'      => esc_html__( 'Show post author', 'skin' ),
		'section'    => 'skin_blog',
		'settings'   => 'skin_blog_show_author',
		'type'       => 'checkbox'
	));
	
// Date
	$wp_customize->add_setting( 'skin_blog_show_date', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_blog_show_date', array(
		'label'      => esc_html__( 'Show post date', 'skin' ),
		'section'    => 'skin_blog',
		'settings'   => 'skin_blog_show_date',
		'type'       => 'checkbox'
	));
	
// Limit categories
	$wp_customize->add_setting( 'skin_blog_limit_cats', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'           => '',
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_blog_limit_cats', array(
		'label'      		=> esc_html__( 'Max number of categories to show:', 'skin' ),
		'description'      	=> esc_html__( 'Leave this blank to display all the categories assigned to posts', 'skin' ),
		'section'    		=> 'skin_blog',
		'settings'   		=> 'skin_blog_limit_cats',
		'type'       		=> 'number',
		'active_callback'	=> 'skin_check_blog_shows_cat'
	));

/*	Post title
================== */
    $wp_customize->add_setting( 'skin_blog_post_title', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_blog_post_title', array(
		'section'	=> 'skin_blog',
		'label'		=> esc_html__( 'Post title length', 'skin' )
	)));
	
// Post title length
	$wp_customize->add_setting( 'skin_blog_title_length', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'           => esc_attr__( '13', 'skin' ),
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_blog_title_length', array(
		'label'      	=> esc_html__( 'Post title word count:', 'skin' ),
		'input_attrs' 	=> array(
								'placeholder' => esc_attr__( '13', 'skin' )
							),
		'section'    	=> 'skin_blog',
		'settings'   	=> 'skin_blog_title_length',
		'type'       	=> 'number'
	));

/*	Post excerpt
=================== */
    $wp_customize->add_setting( 'skin_blog_excerpts', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_blog_excerpts', array(
		'section'	=> 'skin_blog',
		'label'		=> esc_html__( 'Post excerpt', 'skin' )
	)));
	
// Post excerpt visibility
	$wp_customize->add_setting( 'skin_blog_show_excerpt', array(
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_blog_show_excerpt', array(
		'label'      => esc_html__( 'Show post excerpt', 'skin' ),
		'section'    => 'skin_blog',
		'settings'   => 'skin_blog_show_excerpt',
		'type'       => 'checkbox'
	));
	
// Post excerpt length
	$wp_customize->add_setting( 'skin_blog_excerpt_length', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'           => esc_attr__( '15', 'skin' ),
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_blog_excerpt_length', array(
		'label'      	=> esc_html__( 'Auto excerpt word count:', 'skin' ),
		'description'	=> esc_html__( 'Applied when Excerpt field is empty and "more" tag is not used in post content.', 'skin' ),
		'input_attrs' 	=> array(
								'placeholder' => esc_attr__( '15', 'skin' )
							),
		'section'    	=> 'skin_blog',
		'settings'   	=> 'skin_blog_excerpt_length',
		'type'       	=> 'number'
	));
?>