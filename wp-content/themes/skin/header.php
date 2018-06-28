<?php
/* ================================================
	HEADER TEMPLATE
	Skin - Premium WordPress Theme, by NordWood
=================================================== */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>	
	<div id="fb-root"></div>
<?php
	if ( get_theme_mod( 'skin_bgr_pattern' ) ) {
?>
	<div class="body-pattern"></div>
<?php
	}
?>	
	<div id="search-overlay" class="content-pad">
		<div class="top va-middle clearfix">
			<div class="logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php
					echo skin_get_site_logo();
				?></a>
			</div>			
			
			<div class="close-holder va-middle"><div class="close round va-middle txt-color-to-bgr content-pad-to-svg"><?php
				echo skin_get_icon_close();
			?></div></div>
		</div>
		
		<div class="search-wrapper content-wrapper">
			<?php get_search_form(); ?>			
			<div id="quick-search-results"></div>		
		</div>
	</div>
	
<?php
	$gradient_on_top = false;
	$has_top_pattern = '' !== get_theme_mod( 'skin_top_pattern' ) ? true : false;
	
	if ( is_home() && true === get_theme_mod( 'skin_top_gradient_home', true ) ) {		
		$gradient_on_top = true;
	}
	
	if ( ( is_archive() || is_search() ) && true === get_theme_mod( 'skin_top_gradient_archives', true ) ) {		
		$gradient_on_top = true;
	}
	
	if ( is_single() ) {		
		if( 'ignore' === skin_get_meta( 'skin_ignore_global' ) ) {
			if( 'gradient-bgr' === skin_get_meta( 'skin_top_gradient_single' ) ) {
				$gradient_on_top = true;
			}
			
		} else {
			if( true === get_theme_mod( 'skin_top_gradient_single', true ) ) {
				$gradient_on_top = true;
			}
		}
	}
	
	if ( is_page() ) {
		if( 'gradient-bgr' === skin_get_meta( 'skin_top_gradient_page' ) ) {
			$gradient_on_top = true;
		}
	}
	
	if ( is_404() ) {
		if( true === get_theme_mod( 'skin_top_gradient_404', true ) ) {
			$gradient_on_top = true;
		}
	}
	
	if ( true === $gradient_on_top ) {
?>
	<div class="site-header-bgr">
		<div class="gradient-bgr"></div>
	<?php
		if ( true === $has_top_pattern ) {
	?>
		<div class="pattern"></div>
	<?php
		}
	?>
	</div>
<?php
	}
	
	$tagline_on = ( true === ( get_theme_mod( 'skin_show_tagline', 0 ) ) ) && get_bloginfo('description');
?>
	<div class="top-bar mobile top-bar-color">
		<div class="top-holder clearfix">
			<div class="logo va-middle">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php
					echo skin_get_site_logo_mobile();
				?></a>
			</div>
			
		<?php
			if ( SKIN_WOOCOMMERCE_ACTIVE ) {
				if ( true === get_theme_mod( 'skin_woo_mini_cart_top_bar', false ) ) {
			?>
				<div class="mini-cart-button-wrapper va-middle">
					<span class="skin-tooltip"><span class="cloud small-item-bgr small-item-color"><span class="count mini-cart-mini-total"><?php echo WC()->cart->get_cart_contents_count(); ?></span></span></span>
					<div class="mini-cart-button rounded-button-outline round">
						<div class="outline-pale top-bar-color-pale-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
						<div class="outline-full top-bar-color-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
						<div class="top-bar-color-to-svg mini-cart-icon"><?php echo skin_woo_get_icon_bag(); ?></div>
					</div>
				
					<div class="top-cart">
					<?php			
						$widget_args = 'before_widget=<div class="widget woocommerce widget_shopping_cart content-pad pad-shadow">';
						
						the_widget( 'WC_Widget_Cart', 'title=', $widget_args );
					?>
					</div>
				</div>
			<?php
				}
			}
		?>
			
		<?php
			if ( true === get_theme_mod( 'skin_search_in_topbar', true ) ) {
		?>
			<div class="quick-search-holder va-middle"><div class="quick-search-button rounded-button-outline round">
				<div class="outline-pale top-bar-color-pale-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
				<div class="outline-full top-bar-color-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
				<div class="icon top-bar-color-to-svg"><?php echo skin_get_icon_search(); ?></div>
			</div></div>
		<?php
			}
		?>
			<div class="menu-button-holder va-middle"><div class="menu-button rounded-button-outline round va-middle">
				<div class="outline-pale top-bar-color-pale-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
				<div class="outline-full top-bar-color-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
				<div class="icon top-bar-color-to-svg"><?php echo skin_get_icon_menu(); ?></div>
			</div></div>
		</div>
	</div><!-- Mobile top bar -->
	<div class="progress"></div>
	
	<div class="overlay-menu mobile top-bar-bgr-to-svg top-bar-bgr-to-color top-bar-color-to-bgr">
	<?php
		if ( has_nav_menu( 'main_menu' ) ) {
	?>
		<nav class="main-menu" aria-label="<?php esc_attr_e( 'Main Menu', 'skin' ); ?>">
			<div class="v-line top-bar-bgr-light"></div>
			<?php
				wp_nav_menu( array(
					'theme_location' 	=> 'main_menu',
					'container'			=> '',
					'menu_class'		=> 'clearfix'
				));
			?>
		</nav>
	<?php
		}
	
		if ( true === get_theme_mod( 'skin_social_profiles_in_topbar', 0 ) ) {
	?>
		<div class="social-profiles"><?php echo skin_social_profiles(); ?></div>
	<?php
		}		
		
		if ( has_nav_menu( 'top_menu' ) ) {
	?>
		<nav class="top-menu small-text top-bar-bgr-light-to-border" aria-label="<?php esc_attr_e( 'Top Menu', 'skin' ); ?>"><?php
			wp_nav_menu( array(
				'theme_location'	=> 'top_menu',
				'depth' 			=> 1,
				'container'			=> ''
			));
		?></nav>
	<?php
		}
	
		if ( true === get_theme_mod( 'skin_show_copyright', 0 ) && $copyright = get_theme_mod( 'skin_copyright' ) ) {
	?>
		<div class="copyright small-text top-bar-bgr-light-to-border"><?php echo esc_html( $copyright ); ?></div>
	<?php
		}
	?>
	</div><!-- Mobile menu overlay -->	
	
	<div class="top-bar desktop top-bar-color"><?php
		if ( $tagline_on || has_nav_menu( 'top_menu' ) ) {
		?>
		<div class="top top-bar-color-pale-to-border clearfix">
		<?php
			if ( $tagline_on ) {
		?>
			<div class="tagline small-text"><span><?php echo get_bloginfo( 'description', 'display' ); ?></span></div>
		<?php
			}
			
			if ( has_nav_menu( 'top_menu' ) ) {
		?>
			<nav class="top-menu small-text" aria-label="<?php esc_attr_e( 'Top Menu', 'skin' ); ?>"><?php
				wp_nav_menu( array(
					'theme_location'	=> 'top_menu',
					'depth' 			=> 1,
					'container'			=> ''
				));
			?></nav>
		<?php
			}
		?>
		</div>
		<?php
		}
	?>
		<div class="top-holder va-middle clearfix">		
			<div class="logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo skin_get_site_logo(); ?></a>
			</div>
			
			<div class="right-side va-middle">
			<?php
				if ( has_nav_menu( 'main_menu' ) ) {
			?>
				<nav class="main-menu" aria-label="<?php esc_attr_e( 'Main Menu', 'skin' ); ?>"><?php
					wp_nav_menu( array(
						'theme_location' 	=> 'main_menu',
						'container'			=> ''
					));
				?></nav>
			<?php
				}
			?>
	
			<?php
				if ( true === get_theme_mod( 'skin_social_profiles_in_topbar', false ) ) {
					$social_img_url = skin_get_theme_mod_img_src( 'skin_social_avatar' );
			?>
				<div class="social va-middle">
					<div class="social-links">
						<div class="dot round small-item-bgr"></div>
						<div class="social-links-img round"><?php
							if ( '' != $social_img_url ) {
						?>
							<div class="bgr-cover va-middle" style="background-image:url('<?php echo esc_url_raw( $social_img_url ); ?>');"></div>
						<?php
							} else {
						?>
							<div class="top-bar-color-to-bgr top-bar-bgr-light-to-svg"><?php echo skin_get_icon_profile(); ?></div>
						<?php
							}
						?></div>
						
						<div class="social-links-holder"><?php echo skin_social_profiles(); ?></div>
					</div>
				</div>
			<?php
				}
			?>
				
			<?php
				if ( true === get_theme_mod( 'skin_search_in_topbar', true ) ) {
			?>
				<div class="quick-search-holder va-middle"><div class="quick-search-button rounded-button-outline round">
					<div class="outline-pale top-bar-color-pale-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
					<div class="outline-full top-bar-color-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
					<div class="icon top-bar-color-to-svg"><?php echo skin_get_icon_search(); ?></div>
				</div></div>
			<?php
				}
			?>			
			
			<?php
				if ( SKIN_WOOCOMMERCE_ACTIVE ) {
					if ( true === get_theme_mod( 'skin_woo_mini_cart_top_bar', false ) ) {
				?>
					<div class="mini-cart-button-wrapper va-middle">
						<span class="skin-tooltip"><span class="cloud small-item-bgr small-item-color"><span class="count mini-cart-mini-total"><?php echo WC()->cart->get_cart_contents_count(); ?></span></span></span>
						<div class="mini-cart-button rounded-button-outline round">
							<div class="outline-pale top-bar-color-pale-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
							<div class="outline-full top-bar-color-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
							<div class="top-bar-color-to-svg mini-cart-icon"><?php echo skin_woo_get_icon_bag(); ?></div>
						</div>
					
						<div class="top-cart content-pad">
						<?php
							$widget_args = 'before_widget=<div class="widget woocommerce widget_shopping_cart content-pad pad-shadow">';
							
							the_widget( 'WC_Widget_Cart', 'title=', $widget_args );
						?>
						</div>
					</div>
				<?php
					}
				}
			?>
			</div>
		</div>
	<?php
		if ( is_single() ) {
	?>
		<div class="top-holder-single top-bar-bgr clearfix">
			<div class="menu-button-holder top-bar-color-pale-to-border"><div class="menu-button rounded-button-outline round va-middle">
				<div class="outline-pale top-bar-color-pale-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
				<div class="outline-full top-bar-color-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
				<div class="icon top-bar-color-to-svg"><?php echo skin_get_icon_menu(); ?></div>
			</div></div>
			
			<div class="reading">
				<div class="post-title va-middle"><h3><?php echo get_the_title(); ?></h3></div>
			</div>
			
		<?php
			if ( true === get_theme_mod( 'skin_share_in_topbar', true ) ) {
		?>
			<div class="share va-middle top-bar-color-pale-to-border">
				<div class="share-buttons">
					<div class="share-icon-holder"><div class="rounded-button-outline round va-middle">
						<div class="outline-pale top-bar-color-pale-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
						<div class="outline-full top-bar-color-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
						<div class="icon top-bar-color-to-svg"><?php echo skin_get_icon_share(); ?></div>
					</div></div>
					
					<div class="share-buttons-holder"><?php echo skin_share_buttons(); ?></div>
				</div>
			</div>
		<?php
			}
		?>
			
		<?php
			if ( true === get_theme_mod( 'skin_related_in_topbar', true ) && 0 < get_theme_mod( 'skin_related_in_topbar_qty', 3 ) ) {
		?>
			<div class="related top-bar-color-pale-to-border"><?php
				echo skin_related_posts_tabs();
			?></div>
		<?php
			}
		?>
		</div>
		
		<div class="progress"></div>
	<?php
		}
	?>
	</div>
	
	<div class="push-content"></div>
	
<?php
	// Get the sidebar '2' if it has active widgets
	if ( is_active_sidebar( 'sidebar-2' )  ) {
?>
	<div id="sidebar-2" class="sidebar"><?php dynamic_sidebar( 'sidebar-2' ); ?></div>
<?php
	}
?>
	<!-- Open the main wrapper -->
	<div id="main-wrapper">