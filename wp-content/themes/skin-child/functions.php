<?php
/* ===============================================
	Custom functions for Skin child theme
	Skin - Premium WordPress Theme, by NordWood
================================================== */
/* Enqueue parent and child theme stylesheets */
	add_action( 'wp_enqueue_scripts', 'skin_child_theme_enqueue_scripts' );
	
	function skin_child_theme_enqueue_scripts() {
		wp_enqueue_style( 'skin_child',
			get_template_directory_uri() . '/style.css',
			array( 'skin_main' ),
			wp_get_theme()->get('Version')
		);
	}
?>