<?php
/* ===============================================
	Welcome page with description
	Skin - Premium WordPress Theme, by NordWood
================================================== */
	
	if ( ! function_exists( 'skin_welcome_screen' ) ) :
		function skin_welcome_screen() {
			add_theme_page(
				esc_html__( 'Welcome to Skin', 'skin' ),
				esc_html__( 'Welcome to Skin', 'skin' ),
				'read',
				'skin-welcome',
				'skin_welcome_page'
			);
		}
	endif;
	
	add_action( 'admin_menu', 'skin_welcome_screen' );
	
	function skin_welcome_page() {
	?>
		<div class="skin-welcome-wrapper clearfix">
			<div class="skin-welcome-img">
				<img src="<?php echo get_template_directory_uri(); ?>/admin/welcome/img/skin-3-0.jpg" alt="Skin 3.0.2" title="Skin 3.0.2" />
			</div>
			
			<div class="skin-welcome-content">
				<div class="skin-welcome-header">
					<h2><?php esc_html_e( 'Welcome to Skin 3.0.2', 'skin' ); ?></h2>
					<h6><a href="https://themeforest.net/user/nordwood/portfolio" target="_blank"><?php esc_html_e( 'By NordWood Themes', 'skin' ); ?></a></h6>
				</div>
				
				<div class="skin-welcome-section">
					<h6><?php
						$current_user = wp_get_current_user();
						$user_name = $current_user->display_name;
						
						printf(
							'%1$s, %2$s!',
							esc_html__( 'Hello', 'skin' ),
							esc_html( $user_name )
						);
					?></h6>
				
					<p><?php esc_html_e( 'We added this panel so you can have a quick overview on theme new options. We hope you\'re gonna enjoy Skin even more now!', 'skin' ); ?></p>				
					<p><?php esc_html_e( 'Please note that you may need to clear your browser\'s cache (hard refresh a page) for all the changes to take effect (in case something looks odd at first glance ;)', 'skin' ); ?></p>
					
					<p><?php esc_html_e( 'So, here\'s what\'s new since Skin 3.0:', 'skin' ); ?></p>
				</div>
				
				<div class="skin-welcome-section">
					<h3><?php esc_html_e( 'Skin 3.0.2', 'skin' ); ?></h3>
					<h4><?php esc_html_e( 'Fixed issues and minor modifications', 'skin' ); ?></h4>
					
					<ul>
						<li><?php esc_html_e( 'Instagram widgets adjusted to be compatible with the recent Instagram update', 'skin' ); ?></li>
						<li><?php esc_html_e( 'WooCommerce templates updated to be compatible with the latest WooCommerce version', 'skin' ); ?></li>
					</ul>
				</div>
				
				<div class="skin-welcome-section">
					<h3><?php esc_html_e( 'Skin 3.0.1', 'skin' ); ?></h3>
					<h4><?php esc_html_e( 'Fixed issues and minor modifications', 'skin' ); ?></h4>
					
					<ul>
						<li><?php esc_html_e( 'Images stopped showing up in Instagram widgets', 'skin' ); ?></li>
						<li><?php esc_html_e( 'Text color for gradient background being pulled in archive header, instead of the main color', 'skin' ); ?></li>
						<li><?php esc_html_e( 'Customizer settings for demo-1 content being ignored after some other demo is imported', 'skin' ); ?></li>
						<li><?php esc_html_e( 'Link color on hover not being applied in lists (ol, ul) inside the post content, \'Archives\' and \'Categories\' widget', 'skin' ); ?></li>
						<li><?php esc_html_e( 'Option added: Editable heading for related posts in ', 'skin' ); $query_soc['autofocus[control]'] = 'skin_post_related_heading'; ?> <a href="<?php echo esc_url( add_query_arg( $query_soc, admin_url( 'customize.php' ) ) ); ?>" target="_blank"><?php esc_html_e( '\'Skin Single Post\' section', 'skin' ); ?></a></li>
					</ul>
				</div>
	
				<div class="skin-welcome-section">
					<h3><?php esc_html_e( 'Skin 3.0', 'skin' ); ?></h3>
					<h4><?php esc_html_e( 'Special Widgets', 'skin' ); ?></h4>
					
					<p><?php esc_html_e( 'Our "Special Boxes" for masonry layout are now extended to support any number of various Special Widgets! You can include an arbitrary set of special widgets in blog page and a different one for the shop. Find out more about this in the', 'skin' ); ?> <a href="<?php echo admin_url( 'widgets.php' ); ?>" target="_blank"><?php esc_html_e( 'Widgets panel', 'skin' ); ?></a>.</p>
					
					<p><?php esc_html_e( 'You can also notice the additional controls for the Open Graph meta tags. In case you\'re not using some social plugin for this feature, you can turn this control on and upload some default image to be displayed as a thumbnail, when no featured image is found.', 'skin' ); ?></p>
				</div>
				
				<div class="skin-welcome-section">
					<h4><?php esc_html_e( 'Extended set of share icons', 'skin' ); ?></h4>
					
					<p><?php esc_html_e( 'Now you can choose which sharing buttons you want to show on posts and there are more than 20 networks available in the ', 'skin' ); $query_soc['autofocus[control]'] = 'skin_sharing_links'; ?> <a href="<?php echo esc_url( add_query_arg( $query_soc, admin_url( 'customize.php' ) ) ); ?>" target="_blank"><?php esc_html_e( '\'Skin Social\' section', 'skin' ); ?></a>.</p>
				</div>
				
				<div class="skin-welcome-section">
					<h4><?php esc_html_e( 'Skin Custom Login Page plugin', 'skin' ); ?></h4>
					
					<p><?php esc_html_e( 'Yep, WP login page no longer has to be so dull. Select your own background image and colors, and paint it as you like. All the controls are now available in the Customizer - if you have this plugin activated, the section will show up.', 'skin' ); ?></p>
				</div>
				
				<div class="skin-welcome-section">
					<h4><?php esc_html_e( 'Minor additional options and modifications', 'skin' ); ?></h4>
					
					<ul>
						<li><?php esc_html_e( 'Link to author\'s archive on Skin author widget', 'skin' ); ?></li>
						<li><?php esc_html_e( 'Customizer controls to be compatible with WP 4.9 AND below', 'skin' ); ?></li>
					</ul>
				</div>
				
				<div class="skin-welcome-section">
					<h4><?php esc_html_e( 'Fixed issues', 'skin' ); ?></h4>
					
					<ul>
						<li><?php esc_html_e( 'Page loading issue in Safari private mode (localStorage issue)', 'skin' ); ?></li>
						<li><?php esc_html_e( 'Customizer behavior on Google Fonts issue', 'skin' ); ?></li>
						<li><?php esc_html_e( 'Issue with single product layout on mobiles (WooCommerce)', 'skin' ); ?></li>
					</ul>
				</div>
				
				<div class="skin-welcome-section clearfix">
					<div class="nw-promo-img">
						<a href="https://creativemarket.com/NordWood/1584708-Skin-Trendy-Social-Blog-Media" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/admin/welcome/img/skin-social-pack.jpg" alt="Skin Social Pack" title="Skin Social Pack" /></a>
					</div>
					
					<div class="nw-promo-content">
						<h4><?php esc_html_e( 'Social Media Pack now compatible with Skin', 'skin' ); ?></h4>
						
						<p><?php esc_html_e( 'Want to run a marketing campaign for your brand, or promote your recent posts?', 'skin' ); ?></p>
						
						<p><a href="https://creativemarket.com/NordWood/1584708-Skin-Trendy-Social-Blog-Media" target="_blank"><?php esc_html_e( 'Skin Social Media', 'skin' ); ?></a> <?php esc_html_e( 'comes with an outstanding pack of banners for sales and discounts, new arrivals, event announcements, quotes, galleries and more!', 'skin' ); ?></p>
					</div>
				</div>
			</div>
		</div>
	<?php
	}	
	
	add_action( 'after_setup_theme', 'skin_theme_on_update' );
	
	function skin_theme_on_update() {
		$current_version = wp_get_theme()->get( 'Version' );
		$old_version = get_option( 'skin_theme_version' );

		if ( $old_version !== $current_version ) {
			update_option( 'skin_theme_version', $current_version );
			
			wp_redirect( admin_url( 'themes.php?page=skin-welcome' ) );
		}
	}
?>