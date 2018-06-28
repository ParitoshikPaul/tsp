<?php
/* ==========================================================================
	THEME COMPATIBILITY WITH WP VERSIONS,
	Prevents Skin from running on WordPress versions prior to 4.7,
	since this theme is not meant to be backward compatible beyond that and
	relies on many newer functions and markup changes introduced since 4.7.
	
	Skin - Premium WordPress Theme, by NordWood
============================================================================= */
/*
	Prevent switching to Skin on old versions of WordPress.
	Switches to the default theme.
*/
	add_action( 'after_switch_theme', 'skin_switch_theme' );
	
	function skin_switch_theme() {
		switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
		unset( $_GET['activated'] );

		add_action( 'admin_notices', 'skin_upgrade_notice' );
	}

/*
	Adds a message for unsuccessful theme switch.
	Prints an update nag after an unsuccessful attempt to switch to Skin on WordPress versions prior to 4.7.
*/
	function skin_upgrade_notice() {
		$message = sprintf(
			esc_html__( 'Skin requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'skin' ),
			$GLOBALS['wp_version']
		);
		
		printf(
			'<div class="error"><p>%s</p></div>',
			esc_html( $message )
		);
	}

/*
	Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
*/
add_action( 'load-customize.php', 'skin_prevent_customize' );

function skin_prevent_customize() {
	wp_die(
		sprintf(
			esc_html__( 'Skin requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'skin' ),
			$GLOBALS['wp_version']
		),
		'',
		array(
			'back_link' => true,
		)
	);
}

/*
	Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
*/
add_action( 'template_redirect', 'skin_prevent_preview' );

function skin_prevent_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die(
			sprintf(
				esc_html__( 'Skin requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'skin' ),
				$GLOBALS['wp_version']
			)
		);
	}
}
?>