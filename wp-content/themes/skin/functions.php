<?php
/* ===============================================
	THEME FUNCTIONS
	Skin - Premium WordPress Theme, by NordWood
================================================== */
/* WP version compatibility
============================= */
// Skin only works in WordPress 4.7 or later.
	if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
		require get_template_directory() . '/inc/back-compat.php';
	}

/* CONSTANTS
========================== */
// Check if WooCommerce is active
	define( 'SKIN_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );

/* TGM-Plugin-Activation
========================== */
/*
	This file represents an example of the code that themes would use
	to register the required plugins.	
	It is expected that theme authors would copy and paste this code
	into their functions.php file, and amend to suit.
	@see http://tgmpluginactivation.com/configuration/ for detailed documentation.
	
	@package    TGM-Plugin-Activation
	@subpackage Example
	@version    2.6.1 for parent theme Skin for publication on ThemeForest
	@author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
	@copyright  Copyright (c) 2011, Thomas Griffin
	@license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
	@link       https://github.com/TGMPA/TGM-Plugin-Activation
*/

	require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

	add_action( 'tgmpa_register', 'skin_register_required_plugins' );

	function skin_register_required_plugins() {
	/*
		Array of the plugins bundled with a theme. Required keys are name and slug.
		If the source is NOT from the .org repo, then source is also required.
		Guide:
		- 'name' - The plugin name
		- 'slug' - The plugin slug (typically the folder name)
		- 'source' - The plugin source
		- 'required' - If false, the plugin is only 'recommended' instead of required.
		- 'version' - If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
		- 'force_activation' - If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
		- 'force_deactivation' - If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		- 'external_url' - If set, overrides default API URL and points to an external URL.
		- 'is_callable' - If set, this callable will be be checked for availability to determine if a plugin is active.
	*/
		$plugins = array(
			array(
				'name'               => esc_html__( 'Skin Featured Area', 'skin' ),
				'slug'               => 'skin-featured-area',
				'source'             => get_template_directory() . '/plugins/skin-featured-area.zip',
				'required'           => false,
				'version'            => '1.0',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
				'is_callable'        => ''
			),
			
			array(
				'name'               => esc_html__( 'Skin Popout Pages', 'skin' ),
				'slug'               => 'skin-popout-pages',
				'source'             => get_template_directory() . '/plugins/skin-popout-pages.zip',
				'required'           => false,
				'version'            => '1.2',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
				'is_callable'        => ''
			),
			
			array(
				'name'               => esc_html__( 'Skin Shortcodes', 'skin' ),
				'slug'               => 'skin-shortcodes',
				'source'             => get_template_directory() . '/plugins/skin-shortcodes.zip',
				'required'           => false,
				'version'            => '1.1',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
				'is_callable'        => ''
			),
			
			array(
				'name'               => esc_html__( 'Skin Custom Login Page', 'skin' ),
				'slug'               => 'skin-custom-login-page',
				'source'             => get_template_directory() . '/plugins/skin-custom-login-page.zip',
				'required'           => false,
				'version'            => '2.0',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
				'is_callable'        => ''
			),
		);

		/*
			Array of configuration settings.
			Guide:
			- 'id' - Unique ID for hashing notices for multiple instances of TGMPA.
			- 'default_path' - Default absolute path to bundled plugins.
			- 'menu' - Menu slug.
			- 'has_notices' - Show admin notices or not.
			- 'dismissable' - If false, a user cannot dismiss the nag message.
			- 'dismiss_msg' - If 'dismissable' is false, this message will be output at top of nag.
			- 'is_automatic' - Automatically activate plugins after installation or not.
			- 'message' - Message to output right before the plugins table.
		*/
		$config = array(
			'id'           => 'skin',
			'default_path' => '',
			'menu'         => 'tgmpa-install-plugins',
			'has_notices'  => true,
			'dismissable'  => true,
			'dismiss_msg'  => '',
			'is_automatic' => false,
			'message'      => '',
		);

		tgmpa( $plugins, $config );
	}
	
/* Set the maximum content width
================================== */
	if ( ! isset( $content_width ) ) {
		$content_width = 1200;
	}
	
/* Theme setup
================ */
	add_action( 'after_setup_theme', 'skin_theme_setup' );
	
	if ( ! function_exists( 'skin_theme_setup' ) ):
		function skin_theme_setup() {		   
		// Title tag management
			add_theme_support( 'title-tag' );
		
		// Custom image sizes
			update_option( 'thumbnail_size_w', 60 );
			update_option( 'thumbnail_size_h', 60 );
			update_option( 'thumbnail_crop', 1 );
			add_image_size( 'skin_small', 180, 180, true );
			update_option( 'medium_large_size_w', 9999 );
			update_option( 'medium_large_size_h', 640 );
			add_image_size( 'skin_wrapper_width', 1200, 9999, false );
			update_option( 'image_default_align', 'none' );
			update_option( 'image_default_link_type', 'none' );
			update_option( 'image_default_size', 'skin_wrapper_width' );
		   
		// Automatic feed links
			add_theme_support( 'automatic-feed-links' );

		// Post thumbnails
			add_theme_support( 'post-thumbnails' );

		// Post formats
			add_theme_support( 'post-formats', array(
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			));

		// Navigation menus
			register_nav_menus( array(
				'main_menu' => esc_html__( 'Main Menu', 'skin' ),
				'top_menu' 	=> esc_html__( 'Top Menu', 'skin' )
			));
			
			add_theme_support( 'customize-selective-refresh-widgets' );

		// HTML5 markup
			add_theme_support( 'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption'
			));			
			
		// Styles for the editor
			$font_url = '//fonts.googleapis.com/css?family=Quicksand:500,regular';
			$font_url = str_replace( ',', '%2C', $font_url );
			$font_url = str_replace( '|', '%7C', $font_url );
			
			add_editor_style( array( 'editor-style.css', esc_url( $font_url ) ) );

		// Custom background support
			$args = array(
				'default-color' => 'f3f3f3'
			);
			
			add_theme_support( 'custom-background', $args );

		// Custom header support
			add_theme_support( 'custom-header', array() );

		// Translations
			load_theme_textdomain( 'skin', get_template_directory() . '/languages' );
			
		// Add support for WooCommerce plugin and its addons
			if ( SKIN_WOOCOMMERCE_ACTIVE ) {
				add_theme_support( 'woocommerce' );
				add_theme_support( 'wc-product-gallery-slider' );
				add_theme_support( 'wc-product-gallery-zoom' );
				add_theme_support( 'wc-product-gallery-lightbox' );
			}
		}
	endif;
	
/* SVG icons
============== */
	require_once( get_template_directory() . '/inc/svg-icons.php' );
	
/* Register of scripts and styles
=================================== */
	require_once( get_template_directory() . '/inc/scripts-styles-register.php' );
	
/* Filters & Hooks
==================== */
	require_once( get_template_directory() . '/inc/filters-hooks.php' );
	
/* Helpers and template tags
============================== */
	require_once( get_template_directory() . '/inc/template-tags.php' );
	
/* WooCommerce support
======================== */
	if ( SKIN_WOOCOMMERCE_ACTIVE ) {
		require_once( get_template_directory() . '/woo/woo.php' );
	}
	
/* Widgets
============ */   
// Register widgets areas
	add_action( 'widgets_init', 'skin_widgets_init' );
	
	function skin_widgets_init() {
		register_sidebar( array(
			'name'          => esc_html__( '1. Main sidebar', 'skin' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Drag in the widgets you want to appear in the main sidebar.', 'skin' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s content-pad">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
		
		register_sidebar( array(
			'name'          => esc_html__( '2. Site header', 'skin' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Drag in the widgets you want to appear at the top.', 'skin' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s content-pad">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
		
		register_sidebar( array(
			'name'          => esc_html__( '3. Top of blog', 'skin' ),
			'id'            => 'sidebar-3',
			'description'   => esc_html__( 'Drag in the widgets you want to appear above the posts list.', 'skin' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s content-pad">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
		
		register_sidebar( array(
			'name'          => esc_html__( '4. Area above the site footer', 'skin' ),
			'id'            => 'sidebar-4',
			'description'   => esc_html__( 'Drag in the widgets you want to appear above the footer.', 'skin' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s content-pad">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
		
		register_sidebar( array(
			'name'          => esc_html__( '5. Footer Sidebar', 'skin' ),
			'id'            => 'sidebar-5',
			'description'   => esc_html__( 'Drag in the widgets you want to appear in the footer.', 'skin' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s content-pad">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
		
		register_sidebar( array(
			'name'          => esc_html__( '6. Top of post content', 'skin' ),
			'id'            => 'sidebar-6',
			'description'   => esc_html__( 'Drag in the widgets you want to appear above the post content.', 'skin' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s content-pad">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
		
		register_sidebar( array(
			'name'          => esc_html__( '7. Bottom of post content', 'skin' ),
			'id'            => 'sidebar-7',
			'description'   => esc_html__( 'Drag in the widgets you want to appear below the post content.', 'skin' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s content-pad">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
		
		register_sidebar( array(
			'name'          => '&#9733; ' . esc_html__( 'Blog Specials', 'skin' ),
			'id'            => 'sidebar-specials',
			'description'   => esc_html__( 'Drag in the widgets you want to appear in masonry list on blog page.', 'skin' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s content-pad">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
		
		if ( SKIN_WOOCOMMERCE_ACTIVE ) {
			register_sidebar( array(
				'name'          => esc_html__( '8. WooCommerce Sidebar', 'skin' ),
				'id'            => 'sidebar-woo',
				'description'   => esc_html__( 'Drag in the widgets you want to appear in the sidebar for WooCommerce pages.', 'skin' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s content-pad">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>'
			));
		
			register_sidebar( array(
				'name'          => '&#9733; ' . esc_html__( 'WooCommerce Specials', 'skin' ),
				'id'            => 'sidebar-woo-specials',
				'description'   => esc_html__( 'Drag in the widgets you want to appear in masonry list on shop page.', 'skin' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s content-pad">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>'
			));
		}
	}
	
	require get_template_directory() . '/admin/widgets/facebook-badge.php';
	require get_template_directory() . '/admin/widgets/audio-video.php';
	require get_template_directory() . '/admin/widgets/instagram-carousel.php';
	require get_template_directory() . '/admin/widgets/instagram-grid.php';
	require get_template_directory() . '/admin/widgets/contact.php';
	require get_template_directory() . '/admin/widgets/author.php';
	require get_template_directory() . '/admin/widgets/social-profiles.php';
	require get_template_directory() . '/admin/widgets/image-banner.php';
	require get_template_directory() . '/admin/widgets/top-posts.php';
	
	if ( function_exists( 'skin_popout_init' ) ) {
		require get_template_directory() . '/admin/widgets/pop.php';
	}
   
/* Custom fields
================== */
	require get_template_directory() . '/admin/metaboxes/custom-fields.php';
   
/* Customizer
=============== */
	require get_template_directory() . '/admin/customizer/customizer.php';
	
/* Welcome to Skin
====================== */
	//require get_template_directory() . '/admin/welcome/welcome.php';
?>