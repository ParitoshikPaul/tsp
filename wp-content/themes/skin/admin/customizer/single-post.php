<?php
/* ===============================================
	SKIN POST OPTIONS, Customizer section
	Skin - Premium WordPress Theme, by NordWood
================================================== */
    $wp_customize->add_setting( 'skin_single_post_note', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_single_post_note', array(
		'section'		=> 'skin_single_post',
		'description'	=> esc_html__( 'These global settings will be applied on all single posts (unless "Ignore global" option is checked on specific posts).', 'skin' ),
		'divider'		=> false
	)));
	
    $wp_customize->add_setting( 'skin_post_layout', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_post_layout', array(
		'section'	=> 'skin_single_post',
		'label'		=> esc_html__( 'Post layout', 'skin' )
	)));
	
	$wp_customize->add_setting(	'skin_post_sidebar', array(
		'default'			=> 'sidebar-right',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_post_sidebar', array(
		'section'    	=> 'skin_single_post',
		'settings'   	=> 'skin_post_sidebar',
		'type'       	=> 'radio',
		'choices'    	=> array(
								'sidebar-right'	=> esc_html__( 'Sidebar on the right', 'skin' ),
								'sidebar-left'	=> esc_html__( 'Sidebar on the left', 'skin' ),
								'no-sidebar'	=> esc_html__( 'No sidebar', 'skin' )
							)
	));
	
/* 	Post header
================= */
    $wp_customize->add_setting( 'skin_single_post_header', array(
		'sanitize_callback' => 'sanitize_text_field'
	));	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_single_post_header', array(
		'section'	=> 'skin_single_post',
		'label'		=> esc_html__( 'Post header', 'skin' )
	)));
	
// 	Post category in header
	$wp_customize->add_setting( 'skin_cat_in_header', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_cat_in_header', array(
		'label'      => esc_html__( 'Show category', 'skin' ),
		'section'    => 'skin_single_post',
		'settings'   => 'skin_cat_in_header',
		'type'       => 'checkbox'
	));
	
// Selective refresh for category in header
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_cat_in_header' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_cat_in_header', array(
			'selector' => '.single #main > article.post .categories',
			'render_callback' => function() {
				if( true === get_theme_mod( 'skin_cat_in_header' ) ) {
					$p = ( '' !== skin_get_meta( 'skin_prioritize_cats' ) ) ? true : false;
					$l = get_theme_mod( 'skin_post_limit_cats' );
					echo skin_get_post_categories( get_the_ID(), $p, $l );
				}
			}
		));
	}
	
// 	Post date in header
	$wp_customize->add_setting( 'skin_date_in_header', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_date_in_header', array(
		'label'      => esc_html__( 'Show date', 'skin' ),
		'section'    => 'skin_single_post',
		'settings'   => 'skin_date_in_header',
		'type'       => 'checkbox'
	));
	
// Selective refresh for date in header
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_date_in_header' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_date_in_header', array(
			'selector' => '.single #main > article.post .post-date',
			'render_callback' => function() {
				if( true === get_theme_mod( 'skin_date_in_header' ) ) {
					echo skin_post_date();			
				}
			}
		));
	}	
	
// 	Author's name in header
	$wp_customize->add_setting( 'skin_author_in_header', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_author_in_header', array(
		'label'      => esc_html__( 'Show author\'s name', 'skin' ),
		'section'    => 'skin_single_post',
		'settings'   => 'skin_author_in_header',
		'type'       => 'checkbox'
	));
	
// Selective refresh for author's name in header
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_author_in_header' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_author_in_header', array(
			'selector' => '.single #main > article.post .post-author',
			'render_callback' => function() {
				if( true === get_theme_mod( 'skin_author_in_header' ) ) {
					echo skin_post_author();			
				}
			}
		));
	}
	
// 	Social share in post header
	$wp_customize->add_setting( 'skin_share_in_header', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_share_in_header', array(
		'label'      => esc_html__( 'Show social share', 'skin' ),
		'section'    => 'skin_single_post',
		'settings'   => 'skin_share_in_header',
		'type'       => 'checkbox'
	));
	
// 	Featured image
	$wp_customize->add_setting( 'skin_post_featured_img', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_post_featured_img', array(
		'label'      => esc_html__( 'Show featured image', 'skin' ),
		'section'    => 'skin_single_post',
		'settings'   => 'skin_post_featured_img',
		'type'       => 'checkbox'
	));
	
// Selective refresh for featured image
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_post_featured_img' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_post_featured_img', array(
			'selector' => '.single #main > article.post .featured-area',
			'render_callback' => function() {
				if ( function_exists( 'skin_featured_area_get_meta' ) ) {
					skin_post_featured_media();
					
				} else if( has_post_thumbnail( get_the_ID() ) && true === get_theme_mod( 'skin_post_featured_img' ) ) {
				?>
					<div class="featured-img"><?php echo skin_get_giffy_featured_img( get_the_ID(), 'skin_wrapper_width' ); ?></div>
				<?php
				}
			}
		));
	}
	
// Limit categories
	$wp_customize->add_setting( 'skin_post_limit_cats', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'           => '',
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_post_limit_cats', array(
		'label'      		=> esc_html__( 'Max number of categories to show:', 'skin' ),
		'description'      	=> esc_html__( 'Leave this blank to display all the categories assigned to post.', 'skin' ),
		'section'    		=> 'skin_single_post',
		'settings'   		=> 'skin_post_limit_cats',
		'type'       		=> 'number',
		'active_callback'	=> 'skin_check_single_shows_cat'
	));
	
// Selective refresh for limitting number of visible categories
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_post_limit_cats' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_post_limit_cats', array(
			'selector' => '.single #main > article.post .categories',
			'render_callback' => function() {
				if( true === get_theme_mod( 'skin_cat_in_header' ) ) {
					$p = ( '' !== skin_get_meta( 'skin_prioritize_cats' ) ) ? true : false;
					$l = get_theme_mod( 'skin_post_limit_cats' );
					echo skin_get_post_categories( get_the_ID(), $p, $l );
				}
			}
		));
	}
	
/* 	Main content
=================== */
    $wp_customize->add_setting( 'skin_post_main', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_post_main', array(
		'section'	=> 'skin_single_post',
		'label'		=> esc_html__( 'Main content', 'skin' )
	)));

// Drop caps
	$wp_customize->add_setting( 'skin_drop_caps', array(
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
		'transport'			=> 'postMessage',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_drop_caps', array(
		'label'      => esc_html__( 'Drop caps', 'skin' ),
		'section'    => 'skin_single_post',
		'settings'   => 'skin_drop_caps',
		'type'       => 'checkbox'
	));

// Enlarge embedded media
	$wp_customize->add_setting( 'skin_enlarge_media', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'transport'			=> 'postMessage',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_enlarge_media', array(
		'label'      => esc_html__( 'Enlarge embedded media', 'skin' ),
		'section'    => 'skin_single_post',
		'settings'   => 'skin_enlarge_media',
		'type'       => 'checkbox'
	));

// Post galleries
	$wp_customize->add_setting(	'skin_post_galleries', array(
		'default'			=> 'skin-gallery-slider',
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_choices'
	));
	
	$wp_customize->add_control( 'skin_post_galleries', array(
		'label'      	=> esc_html__( 'Post galleries type', 'skin' ),
		'description'	=> esc_html__( 'This applies to posts AND pages.', 'skin' ),
		'section'    	=> 'skin_single_post',
		'settings'   	=> 'skin_post_galleries',
		'type'       	=> 'radio',
		'choices'    	=> array(
								'skin-gallery-slider'	=> esc_html__( 'Skin gallery slider', 'skin' ),
								'native-wp-thumbs'		=> esc_html__( 'Native WP thumbnails gallery', 'skin' )
							)
	));
	
/* 	Post footer
================== */
    $wp_customize->add_setting( 'skin_post_footer', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_post_footer', array(
		'section'	=> 'skin_single_post',
		'label'		=> esc_html__( 'Post footer', 'skin' )
	)));
	
// 	Social share in post footer
	$wp_customize->add_setting( 'skin_share_in_post_footer', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_share_in_post_footer', array(
		'label'      => esc_html__( 'Show social share', 'skin' ),
		'section'    => 'skin_single_post',
		'settings'   => 'skin_share_in_post_footer',
		'type'       => 'checkbox'
	));

// Show tagcloud
	$wp_customize->add_setting( 'skin_show_tagcloud', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_show_tagcloud', array(
		'label'      => esc_html__( 'Show tagcloud', 'skin' ),
		'section'    => 'skin_single_post',
		'settings'   => 'skin_show_tagcloud',
		'type'       => 'checkbox'
	));
	
// Selective refresh for tagcloud
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_show_tagcloud' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_show_tagcloud', array(
			'selector' => '.single #main > article.post .tagcloud',
			'render_callback' => function() {
				if ( true === get_theme_mod( 'skin_show_tagcloud' ) ) {
					echo skin_post_tag_cloud();
				}
			}
		));
	}

// Show related posts
	$wp_customize->add_setting( 'skin_post_show_related', array(
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_post_show_related', array(
		'label'      => esc_html__( 'Show related posts', 'skin' ),
		'section'    => 'skin_single_post',
		'settings'   => 'skin_post_show_related',
		'type'       => 'checkbox'
	));
	
// Selective refresh for related posts
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_post_show_related' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_post_show_related', array(
			'selector' => '.single #main > .related-posts-box',
			'render_callback' => function() {
				if ( true === get_theme_mod( 'skin_post_show_related' ) ) {
					$h = get_theme_mod( 'skin_post_related_heading', esc_html__( 'You may also like', 'skin' ) );
					echo skin_related_posts( $h );
				}
			}
		));
	}
	
// Heading for related posts
	$wp_customize->add_setting( 'skin_post_related_heading', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( 'skin_post_related_heading', array(
		'label'		=> esc_html__( 'Heading for related posts', 'skin' ),
		'section'	=> 'skin_single_post',
		'settings'	=> 'skin_post_related_heading',
		'type'		=> 'text'
	));
	
// Selective refresh for copyright text
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_post_related_heading' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_post_related_heading', array(
			'selector' => '.single #main > .related-posts-box .related-header h3',
			'render_callback' => function() {
				echo get_theme_mod( 'skin_post_related_heading', esc_html__( 'You may also like', 'skin' ) );
			}
		));
	}
	
// Max number of posts to show in related
	$wp_customize->add_setting( 'skin_related_qty', array(
		'capability'     	=> 'edit_theme_options',
		'type'           	=> 'theme_mod',
		'default'           => esc_attr__( '6', 'skin' ),
		'sanitize_callback' => 'absint'
	));
	
	$wp_customize->add_control( 'skin_related_qty', array(
		'label'			=> esc_html__( 'Max number of related posts to show:', 'skin' ),
		'section'		=> 'skin_single_post',
		'settings'		=> 'skin_related_qty',
		'type'			=> 'number'
	));
	
/* 	Author bio
================= */
    $wp_customize->add_setting( 'skin_post_author_bio', array(
		'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new Skin_Customizer_Section_Block( $wp_customize, 'skin_post_author_bio', array(
		'section'		=> 'skin_single_post',
		'label'			=> esc_html__( 'Author\'s bio', 'skin' ),
		'description'   => esc_html__( 'The biographical info in "Users" admin section should be filled.', 'skin' )
	)));
	
// Show author bio box
	$wp_customize->add_setting( 'skin_show_author_bio', array(
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'skin_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 'skin_show_author_bio', array(
		'label'      => esc_html__( 'Show author\'s bio', 'skin' ),
		'section'    => 'skin_single_post',
		'settings'   => 'skin_show_author_bio',
		'type'       => 'checkbox'
	));
	
// Selective refresh for author bio
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'skin_show_author_bio' )->transport = 'postMessage';
		
		$wp_customize->selective_refresh->add_partial( 'skin_show_author_bio', array(
			'selector' => '.single #main > .author-bio',
			'render_callback' => function() {
				$id = get_post_field( 'post_author', get_the_ID() );
				
				if ( true === get_theme_mod( 'skin_show_author_bio' ) && ( '' !== get_the_author_meta( 'description', $id ) ) ) {
					$avatar = get_avatar_url( $id, array( 'size' => 118 ) );
				?>
					<div class="photo"><div class="avatar round bgr-cover" style="background-image:url('<?php echo esc_url( $avatar ); ?>');"></div></div>
					<div class="text">
						<h3><?php the_author_meta( 'nickname', $id ) ?></h3>
						<p><?php the_author_meta( 'description', $id ) ?></p>
					</div>
				<?php
				}
			}
		));
	}
?>