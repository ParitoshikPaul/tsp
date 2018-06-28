<?php
/* ==============================================
	PAGE 404 TEMPLATE
	Skin - Premium WordPress Theme, by NordWood
================================================= */
	get_header();
?>	
	<div class="content-box content-wrapper content-pad"><?php
		if ( $desc = get_theme_mod( 'skin_404_desc', esc_html__( '404 error page', 'skin' ) ) ) {
	?>
		<div class="error-short"><h5><?php echo esc_html( $desc ); ?></h5></div>
	<?php
		}
	?>
		<div class="bummer txt-color-to-svg"><?php echo skin_get_icon_bummer(); ?></div>
	<?php
		if ( $heading = get_theme_mod( 'skin_404_heading', esc_html__( 'Oops! This page is not here anymore', 'skin' ) ) ) {
	?>
		<div class="post-title"><h1><?php echo esc_html( $heading ); ?></h1></div>
	<?php
		}
		
		if ( $backtext = get_theme_mod( 'skin_404_back_button', esc_html__( 'Back to homepage', 'skin' ) ) ) {
	?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="link-button va-middle skin-outlined-bttn skin-anim-bttn"><?php echo esc_html( $backtext ); ?></a>
	<?php
		}
	?></div>
<?php
	get_footer();
?>