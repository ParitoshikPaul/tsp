<?php
/* ===============================================
	FOOTER TEMPLATE
	Skin - Premium WordPress Theme, by NordWood
================================================== */
?>
	</div><!-- Close the main wrapper -->
<?php
	// Get the sidebar '4' if it has active widgets
	if ( is_active_sidebar( 'sidebar-4' )  ) {
?>
	<div id="sidebar-4" class="sidebar"><?php dynamic_sidebar( 'sidebar-4' ); ?></div>
<?php
	}
?>
	<div id="site-footer" class="content-pad"><?php
	// Get the sidebar '5' if it has active widgets
		if ( is_active_sidebar( 'sidebar-5' )  ) {
	?>
		<div id="sidebar-5" class="sidebar"><?php dynamic_sidebar( 'sidebar-5' ); ?></div>
	<?php
		}

		if ( true === get_theme_mod( 'skin_show_copyright', false ) && $copy = get_theme_mod( 'skin_copyright' ) ) {
	?>
		<div class="copyright small-text">
			<p><?php echo esc_html( $copy ); ?></p>
		</div>
	<?php
		}
	?></div>
	
<?php
// Sticky banner	
	if ( $sticky_banner = get_theme_mod( 'skin_sticky_banner_img' ) ) {
		$sticky_banner_pos = get_theme_mod( 'skin_sticky_banner_position', 'bottom-right' );
?>
	<div class="sticky-banner" data-pos="<?php echo esc_attr( $sticky_banner_pos ); ?>"><?php
		if ( $link = get_theme_mod( 'skin_sticky_banner_link' ) ) {
	?>
		<a href="<?php echo esc_url( $link ); ?>" target="_blank"><div class="sticky-banner-img"><?php
			echo skin_get_giffy_img_by_url( esc_url( $sticky_banner ) );
		?></div></a>
	<?php			
		} else {
		?>
		<div class="sticky-banner-img"><?php
			echo skin_get_giffy_img_by_url( esc_url( $sticky_banner ) );
		?></div>
		<?php			
		}
		
		if ( true === get_theme_mod( 'skin_sticky_banner_close', false ) ) {
			printf(
				'<div class="close small-item-bgr small-item-color round">%s</div>',
				skin_get_icon_close()
			);
		}
	?></div>
<?php
	}
	
// Scroll to top
	if ( true === get_theme_mod( 'skin_show_scroll_to_top', true ) ) {
		$to_top_pos = get_theme_mod( 'skin_scroll_to_top_position', 'bottom-right' );
		
		$banner_below = ( get_theme_mod( 'skin_sticky_banner_img' ) && $to_top_pos === get_theme_mod( 'skin_sticky_banner_position', 'bottom-right' ) ) ? "yes" : "no";		
		
		printf(
			'<div id="to-top" class="elastic-arrow top small-item-bgr small-item-color round %1$s" data-banner-below="%2$s">%3$s</div>',
			esc_attr( $to_top_pos ),
			esc_attr( $banner_below ),
			skin_get_icon_elastic_arrow_left()
		);
	}	
	
// Skin info
	printf(
		'<div id="skin-data" data-gradient-1="%1$s" data-gradient-2="%2$s"></div>',
		esc_attr( get_theme_mod( 'skin_gradient_color_1', '#f4d7de' ) ),
		esc_attr( get_theme_mod( 'skin_gradient_color_2', '#cecfe7' ) )
	);
	
	wp_footer();
?>
</body>
</html>