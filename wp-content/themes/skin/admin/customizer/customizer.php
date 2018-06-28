<?php
/* ================================================
	THEME CUSTOMIZER SETTINGS
	Skin - Premium WordPress Theme, by NordWood
=================================================== */
/*	Typography custom controls
================================= */
	if ( ! function_exists( 'skin_get_google_fonts' ) ) :
		function skin_get_google_fonts() {
			if ( get_transient( 'skin_get_google_fonts_list' ) ) {
				$content = get_transient( 'skin_get_google_fonts_list' );
				
			} else {
				$googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha&key=AIzaSyAeMvAd2oCWFkMANI_eIHnvxXhsU2OAVtE';
				$fontContent = wp_remote_get( $googleApi, array('sslverify'   => false) );
				
				if ( is_wp_error( $fontContent ) ) {
					return 'font issue';
				}
				
				$content = json_decode( $fontContent['body'], true );
				set_transient( 'skin_get_google_fonts_list', $content, 0 );
			}
			
			return $content['items'];
		}
	endif;
	
	if ( class_exists( 'WP_Customize_Control' ) && !class_exists( 'Skin_Customize_Typography' ) ) :
		class Skin_Customize_Typography extends WP_Customize_Control {
		 
			public function render_content() {
				global $wp_customize;
				
			// Get all Google Fonts items (as array)
				$google_fonts = skin_get_google_fonts();
				
			// Get the current typography value for the chosen set
				$typo_all_active = explode( '|', $this->value() );
				$family_active = $typo_all_active[0];
				
				if ( isset( $this->label ) ) {
					printf(
						'<span class="customize-control-title"><h3>%s</h3></span>',
						esc_html( $this->label )
					);
				}
				
				if ( isset( $this->description ) ) {
					printf(
						'<span class="customize-control-description">%s</span>',
						esc_html( $this->description )
					);
				}
				
				$setting = $wp_customize->get_setting( $this->id );
			?>
				<div class="skin-typo-controls clearfix">
					<!-- Print the font family options -->
					<fieldset class="skin-typo-fieldset">
						<label class="skin-typo-label" for="<?php echo esc_attr( $this->id ); ?>-font-family"><?php
							esc_html_e( 'font family', 'skin' );
						?></label>
						
						<select class="skin-typo-font-family"
							id="<?php echo esc_attr( $this->id ); ?>-font-family"
							name="<?php echo esc_attr( $this->id ); ?>-font-family"
						>
						<?php
							foreach ( $google_fonts as $k => $v ) {
							// Get font variants for each item
								$variants = '';
								$get_variants = $v['variants'];
								
								foreach ( $get_variants as $get_variant ) {
									$variants .= $get_variant . ",";
								}
								
							// Get language subsets for each item
								$subsets = '';
								$get_subsets = $v['subsets'];
								
								foreach ( $get_subsets as $get_subset ) {
									$subsets .= $get_subset . ",";
								}
								
							// Display all font families as select options, including their variants and subsets as data attributes
								printf(
									'<option value="%1$s" data-font-variants="%2$s" data-lang-subsets="%3$s" %4$s>%5$s</option>',
									esc_attr( $v['family'] ),
									esc_attr( chop( $variants, ',' ) ),
									esc_attr( chop( $subsets, ',' ) ),
									selected( $family_active, $v['family'] ),
									esc_html( $v['family'] )
								);
							}
						?>
						</select>
						
						<input type="button" class="skin-typo-reset button button-small"
							id="<?php echo esc_attr( $this->id ); ?>-reset"
							name="<?php echo esc_attr( $this->id ); ?>-reset"
							value="<?php esc_attr_e( 'Default', 'skin' ); ?>"
						/>
					</fieldset>
					
					<!-- Dinamically print the font variant options for selected font family -->
					<fieldset class="half skin-typo-fieldset">
						<label class="skin-typo-label" for="<?php echo esc_attr( $this->id ); ?>-font-variants"><?php
							esc_html_e( 'font variant', 'skin' );
						?></label>
						
						<select class="skin-typo-font-variants"
							id="<?php echo esc_attr( $this->id ); ?>-font-variants"
							name="<?php echo esc_attr( $this->id ); ?>-font-variants"
						>
						</select>
					</fieldset>
					
					<!-- Print the font size input field for this typography set -->
					<fieldset class="half skin-typo-fieldset">
						<label class="skin-typo-label" for="<?php echo esc_attr( $this->id ); ?>-font-size"><?php
							esc_html_e( 'font size (px)', 'skin' );
						?></label>
						
						<input type="number" class="skin-typo-font-size"
							id="<?php echo esc_attr( $this->id ); ?>-font-size"
							name="<?php echo esc_attr( $this->id ); ?>-font-size"
						>
						</select>
					</fieldset>
					
					<!-- Print the line height input field for this typography set -->
					<fieldset class="half skin-typo-fieldset">
						<label class="skin-typo-label" for="<?php echo esc_attr( $this->id ); ?>-line-height"><?php
							esc_html_e( 'line height (px)', 'skin' );
						?></label>
						
						<input type="number" class="skin-typo-line-height"
							id="<?php echo esc_attr( $this->id ); ?>-line-height"
							name="<?php echo esc_attr( $this->id ); ?>-line-height"
						>
						</select>
					</fieldset>
					
					<!-- Print the letter spacing input field for this typography set -->
					<fieldset class="half skin-typo-fieldset">
						<label class="skin-typo-label" for="<?php echo esc_attr( $this->id ); ?>-letter-spacing"><?php
							esc_html_e( 'letter spacing (px)', 'skin' );
						?></label>
						
						<input type="number" class="skin-typo-letter-spacing"
							id="<?php echo esc_attr( $this->id ); ?>-letter-spacing"
							name="<?php echo esc_attr( $this->id ); ?>-letter-spacing"
						>
						</select>
					</fieldset>
					
					<!-- Print the text transform input field for this typography set -->
					<fieldset class="half skin-typo-fieldset">
						<label class="skin-typo-label" for="<?php echo esc_attr( $this->id ); ?>-text-transform"><?php
							esc_html_e( 'text-transform', 'skin' );
						?></label>
						
						<select class="skin-typo-text-transform"
							id="<?php echo esc_attr( $this->id ); ?>-text-transform"
							name="<?php echo esc_attr( $this->id ); ?>-text-transform"
						>
							<option value="none" selected>none</option>
							<option value="capitalize">capitalize</option>
							<option value="uppercase">uppercase</option>
							<option value="lowercase">lowercase</option>
						</select>
					</fieldset>
					
					<!-- Dinamically print the language subsets options for selected font family -->
					<fieldset class="half skin-typo-fieldset">
						<label class="skin-typo-label" for="<?php echo esc_attr( $this->id ); ?>-lang-subsets"><?php
							esc_html_e( 'language subset', 'skin' );
						?></label>
						
						<select class="skin-typo-lang-subsets"
							id="<?php echo esc_attr( $this->id ); ?>-lang-subsets"
							name="<?php echo esc_attr( $this->id ); ?>-lang-subsets"
						>
						</select>
					</fieldset>
					
					<!-- Combine all of the options above into single string, to be saved as typography control -->
					<fieldset class="skin-typo-fieldset">
						<input type="hidden" class="skin-typo-controls-combined"
							id="<?php echo esc_attr( $this->id ); ?>"
							name="<?php echo esc_attr( $this->id ); ?>"
							value="<?php echo esc_attr( $this->value() ); ?>"
							<?php $this->link(); ?>
						/>
					</fieldset>
					
					<!-- Keep the default values for this set -->
					<fieldset class="skin-typo-fieldset">
						<input type="hidden" class="skin-typo-default"
							id="<?php echo esc_attr( $this->id ); ?>-default"
							name="<?php echo esc_attr( $this->id ); ?>-default"
							value="<?php echo esc_html( $setting->default ); ?>"
						/>
					</fieldset>
				</div>
			<?php
			}
		}
	endif;

/*	Social profiles custom controls
====================================== */
	if ( class_exists( 'WP_Customize_Control' ) && !class_exists( 'Skin_Customize_Social_Profiles' ) ) :
		class Skin_Customize_Social_Profiles extends WP_Customize_Control {
		 
			public function render_content(){
				global $wp_customize;
					
				if ( isset( $this->label ) ) {
					printf(
						'<span class="customize-control-title"><h3>%s</h3></span>',
						esc_html( $this->label )
					);
				}
				
				if ( isset( $this->description ) ) {
					printf(
						'<span class="customize-control-description">%s</span>',
						esc_html( $this->description )
					);
				}
				
				$setting = $wp_customize->get_setting( $this->id );
				
				$networks = array( "Facebook", "Twitter", "Instagram", "Pinterest", "GooglePlus", "500px", "Behance", "Blogger", "BlogLovin", "DailyMotion", "Delicious", "DeviantArt", "Digg", "Dribble", "Envato", "Etsy", "Flickr", "FourSquare", "GitHub", "GrooveShark", "Hypem", "KickStarter", "LastFM", "LinkedIn", "Medium", "MixCloud", "MySpace", "Reddit", "Scribd", "SnapChat", "SoundCloud", "Spotify", "Steam", "StumbleUpon", "TripAdvisor", "Tumblr", "Twitch", "Vimeo", "VK", "XING", "Yelp", "YouTube" );
				
			// Get the active social profiles and generate their name-url pairs
				$profiles = explode( '-network-', $this->value() );
				
				array_shift( $profiles );
				$pairs = array();
				
				foreach ( $profiles as $profile ) {
					$pair = explode( '-link-', $profile );
					$network = $pair[0];
					$profile_url = $pair[1];
					$pairs[$network] = $profile_url;
				}
			?>
				<div class="skin-social-profiles-controls clearfix">					
					<div class="skin-social-profiles-choices clearfix">
						<?php
							foreach ( $networks as $network ) {
								$has_profile = array_key_exists( $network, $pairs );
								
								if ( $has_profile ) {
									$url = $pairs[$network];
									$active = "active";
									
								} else {
									$url = '';
									$active = '';
								}
								
						?>
							<span class="skin-social-profiles-icon"
								title = "<?php echo esc_html( $network ); ?>"
								data-network-name="<?php echo esc_html( $network ); ?>"
								data-has-profile="<?php echo esc_html( $active ); ?>"
								data-profile-url="<?php echo esc_url( $url ); ?>"
							><?php
								echo call_user_func( 'skin_get_icon_'.strtolower( $network ) );
							?></span>
						<?php
							}
						?>
						
						<div class="skin-social-profiles-popout">
							<fieldset class="skin-social-profiles-fieldset">
								<label class="skin-social-profiles-active-label" for="<?php echo esc_attr( $this->id ); ?>-active"></label>
								
								<textarea rows="4" class="skin-social-profiles-active"
									id="<?php echo esc_attr( $this->id ); ?>-active"
									name="<?php echo esc_attr( $this->id ); ?>-active"
								></textarea>
							</fieldset>
							
							<span class="skin-close-button"><?php echo skin_get_icon_close(); ?></span>
						</div>
					</div>
					
					<!-- Combine all of the options above into a single string, to be saved as social profiles control -->
					<fieldset class="skin-social-profiles-fieldset">
						<input type="hidden" class="skin-social-profiles-combined"
							id="<?php echo esc_attr( $this->id ); ?>"
							name="<?php echo esc_attr( $this->id ); ?>"
							value="<?php echo esc_attr( $this->value() ); ?>"
							<?php $this->link(); ?>
						/>
					</fieldset>
				</div>				
			<?php
			}
		}
	endif;

/*	Custom html for sharing links
==================================== */
	if( class_exists( 'WP_Customize_Control' ) && !class_exists( 'Skin_Customize_Sharing_Links' ) ) :
		class Skin_Customize_Sharing_Links extends WP_Customize_Control {		 
			public function render_content(){
				global $wp_customize;
					
				if( isset( $this->label ) ) {
					printf(
						'<span class="customize-control-title"><h3>%s</h3></span>',
						esc_html( $this->label )
					);
				}
				
				if( isset( $this->description ) ) {
					printf(
						'<span class="customize-control-description">%s</span>',
						esc_html( $this->description )
					);
				}
				
				$networks = array( "Facebook", "Twitter", "Pinterest", "GooglePlus", "Blogger", "Digg", "MySpace", "Reddit", "StumbleUpon", "Tumblr", "VK", "XING", "EverNote", "Flattr", "Gmail", "HackerNews", "Line", "LinkedIn", "OKru", "Pocket", "Telegram", "Viber", "WhatsApp" );
				
			// Get the active icons
				$profiles = explode( '-network-', $this->value() );				
				array_shift( $profiles );
			?>
				<div class="skin-sharing-links-controls clearfix">					
					<div class="skin-sharing-links-choices clearfix">
						<?php
							foreach( $networks as $network ) {
								if( in_array( $network, $profiles ) ) {
									$active = "on";
									
								} else {
									$active = "off";
								}
								
						?>
							<span class="skin-sharing-links-icon"
								title = "<?php echo esc_html( $network ); ?>"
								data-network-name="<?php echo esc_html( $network ); ?>"
								data-is-active="<?php echo esc_html( $active ); ?>"
							><?php
								echo call_user_func( 'skin_get_icon_'.strtolower( $network ) );
							?></span>
						<?php
							}
						?>
					</div>
					
					<!-- Combine all of the options above into a single string, to be saved as social profiles control -->
					<fieldset class="skin-sharing-links-fieldset">
						<input type="hidden" class="skin-sharing-links-combined"
							id="<?php echo esc_attr( $this->id ); ?>"
							name="<?php echo esc_attr( $this->id ); ?>"
							value="<?php echo esc_attr( $this->value() ); ?>"
							<?php $this->link(); ?>
						/>
					</fieldset>
				</div>				
			<?php
			}
		}
	endif;
	
/*	Custom HTML for customizer
================================= */
// Section block
	if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Skin_Customizer_Section_Block' ) ) :
		class Skin_Customizer_Section_Block extends WP_Customize_Control {
			public $content = '';
			public $divider = true;
			public $large = false;
			
			public function render_content() {		
				if ( true === $this->divider ) {
					echo '<div class="section-divider"></div>';
				}
				
				if ( isset( $this->label ) ) {
					if( true === $this->large ) {
						printf(
							'<span class="customize-control-title"><h2>%s</h2></span>',
							esc_html( $this->label )
						);
						
					} else {
						printf(
							'<span class="customize-control-title"><h3>%s</h3></span>',
							esc_html( $this->label )
						);
					}
				}
				
				if ( isset( $this->description ) ) {
					printf(
						'<span class="customize-control-description">%s</span>',
						esc_html( $this->description )
					);
				}
			}
		}
	endif;
	
// Error notice
	if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Skin_Customizer_Err_Notice' ) ) :
		class Skin_Customizer_Err_Notice extends WP_Customize_Control {
			public $content = '';
			
			public function render_content() {
				if ( isset( $this->label ) ) {
					printf(
						'<span class="customize-control-title err"><h3>%s</h3></span>',
						esc_html( $this->label )
					);
				}
				
				if ( isset( $this->description ) ) {
					printf(
						'<span class="customize-control-description err">%s</span>',
						esc_html( $this->description )
					);
				}
			}
		}
	endif;

/*	Sections
=============== */  
	if ( !function_exists( 'skin_customizer' ) ) : 
		function skin_customizer( $wp_customize ) {			
		//	Remove some of default sections
			$wp_customize->remove_section( 'background_image' );
			$wp_customize->remove_section( 'header_image' );
			
		// Site identity
			$wp_customize->get_section( 'title_tagline' )->title = esc_html__( 'Skin Site Identity', 'skin' );
			$wp_customize->get_section( 'title_tagline' )->priority = 1;
			
			include_once( get_template_directory() . '/admin/customizer/site-identity.php' );
			
		// Top bar
			$wp_customize->add_section( 'skin_top_bar', array(
				'title'    => esc_html__( 'Skin Top Bar', 'skin' ),
				'priority' => 2
			));
			
			include_once( get_template_directory() . '/admin/customizer/top-bar.php' );
			
		// Social profiles
			$wp_customize->add_section( 'skin_social', array(
				'title'    => esc_html__( 'Skin Social', 'skin' ),
				'priority' => 3
			));
			
			include_once( get_template_directory() . '/admin/customizer/social.php' );
			
		// Single post options
			$wp_customize->add_section( 'skin_single_post', array(
				'title'    => esc_html__( 'Skin Single Post', 'skin' ),
				'priority' => 4
			));
			
			include_once( get_template_directory() . '/admin/customizer/single-post.php' );
			
		// Blog page
			$wp_customize->add_section( 'skin_blog', array(
				'title'    => esc_html__( 'Skin Blog Page', 'skin' ),
				'priority' => 5
			));
			
			include_once( get_template_directory() . '/admin/customizer/blog.php' );
			
		// Archives
			$wp_customize->add_section( 'skin_archives', array(
				'title'    => esc_html__( 'Skin Archives', 'skin' ),
				'priority' => 6
			));
			
			include_once( get_template_directory() . '/admin/customizer/archives.php' );
			
		// Specials
			$wp_customize->add_section( 'skin_specials', array(
				'title'    => esc_html__( 'Skin Special Boxes', 'skin' ),
				'priority' => 7
			));
			
			include_once( get_template_directory() . '/admin/customizer/specials.php' );
			
		// Footer and bottom area
			$wp_customize->add_section( 'skin_sticky_banner', array(
				'title'    => esc_html__( 'Skin Sticky Banner', 'skin' ),
				'priority' => 8
			));
			
			include_once( get_template_directory() . '/admin/customizer/sticky-banner.php' );
			
		// WooCommerce
			if ( SKIN_WOOCOMMERCE_ACTIVE ) {
				$wp_customize->add_section( 'skin_woo', array(
					'title'    => esc_html__( 'Skin WooCommerce options', 'skin' ),
					'priority' => 8
				));
				
				include_once( get_template_directory() . '/admin/customizer/woo.php' );
			}
			
		// Color scheme
			$wp_customize->get_section( 'colors' )->title = esc_html__( 'Skin Colors', 'skin' );
			$wp_customize->get_section( 'colors' )->priority = 9;
			
			include_once( get_template_directory() . '/admin/customizer/colors.php' );
			
		// Typography
			$wp_customize->add_section( 'skin_typography', array(
				'title'    => esc_html__( 'Skin Typography', 'skin' ),
				'priority' => 10
			));
			
			include_once( get_template_directory() . '/admin/customizer/typography.php' );
			
		// Page 404
			$wp_customize->add_section( 'skin_404_page', array(
				'title'    => esc_html__( 'Skin 404 Page', 'skin' ),
				'priority' => 11
			));
			
			include_once( get_template_directory() . '/admin/customizer/page_404.php' );
			
		// Optimization
			$wp_customize->add_section( 'skin_opt', array(
				'title'    => esc_html__( 'Skin Optimization', 'skin' ),
				'priority' => 12
			));
			
			include_once( get_template_directory() . '/admin/customizer/optimization.php' );
			
		// Sidebars
			$wp_customize->add_section( 'skin_sidebars', array(
				'title'    => esc_html__( 'Skin Sidebars and Widgets', 'skin' ),
				'priority' => 13
			));
			
			include_once( get_template_directory() . '/admin/customizer/sidebars.php' );
		}
		
	endif;
	
	add_action( 'customize_register', 'skin_customizer' );
	
/*	Sanitization
=================== */
// Sanitize checkbox
	if ( ! function_exists( 'skin_sanitize_checkbox' ) ) :
		function skin_sanitize_checkbox( $input ) {
			if ( $input === true ) {
				return true;
			} else {
				return false;
			}
		}
	endif;

// Sanitize dropdown selection & Radio buttons
	if ( ! function_exists( 'skin_sanitize_choices' ) ) :
		function skin_sanitize_choices( $input, $setting ) {
			global $wp_customize;
		 
			$control = $wp_customize->get_control( $setting->id );
		 
			if ( array_key_exists( $input, $control->choices ) ) {
				return $input;
				
			} else {
				return $setting->default;
			}
		}
	endif;
	
/*	Callbacks
================ */
// Check the value of blog featured area control
	if ( ! function_exists( 'skin_ctrl_blog_featured' ) ) :
		function skin_ctrl_blog_featured( $control ) {
			$blog_featured = $control->manager->get_setting( 'skin_blog_featured' )->value();
			
			return $blog_featured;
		}
	endif;
	
// Blog featured area is active
	if ( ! function_exists( 'skin_check_blog_has_featured' ) ) :
		function skin_check_blog_has_featured( $control ) {			
			if ( 'skip' !== skin_ctrl_blog_featured( $control ) && 'welcome-mssg' !== skin_ctrl_blog_featured( $control ) ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Blog featured area is active and pulls recent posts
	if ( ! function_exists( 'skin_check_blog_has_featured_recent' ) ) :
		function skin_check_blog_has_featured_recent( $control ) {			
			if ( false !== strpos( skin_ctrl_blog_featured( $control ), 'latest' ) ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Welcome message is active
	if ( ! function_exists( 'skin_check_blog_has_welcome' ) ) :
		function skin_check_blog_has_welcome( $control ) {
			if ( 'welcome-mssg' === skin_ctrl_blog_featured( $control ) ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Enlarged post or grid is active
	if ( ! function_exists( 'skin_check_blog_has_enlarged_or_grid' ) ) :
		function skin_check_blog_has_enlarged_or_grid( $control ) {
			if ( false !== strpos( skin_ctrl_blog_featured( $control ), 'enlarge' ) || false !== strpos( skin_ctrl_blog_featured( $control ), 'grid' ) ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Latest posts slider is active
	if ( ! function_exists( 'skin_check_blog_has_slider_latest' ) ) :
		function skin_check_blog_has_slider_latest( $control ) {
			if ( 'slider-latest' === skin_ctrl_blog_featured( $control ) ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Enlarged post is active
	if ( ! function_exists( 'skin_check_blog_has_enlarged' ) ) :
		function skin_check_blog_has_enlarged( $control ) {
			if ( 'enlarge-featured' === skin_ctrl_blog_featured( $control ) || 'enlarge-latest' === skin_ctrl_blog_featured( $control ) ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Enlarged FEATURED post is active
	if ( ! function_exists( 'skin_check_blog_has_enlarged_custom' ) ) :
		function skin_check_blog_has_enlarged_custom( $control ) {
			if ( 'enlarge-featured' === skin_ctrl_blog_featured( $control ) ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Featured posts grid is active
	if ( ! function_exists( 'skin_check_blog_has_featured_grid' ) ) :
		function skin_check_blog_has_featured_grid( $control ) {
			if ( 'grid-featured' === skin_ctrl_blog_featured( $control ) ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Posts slider is active
	if ( ! function_exists( 'skin_check_blog_has_slider' ) ) :
		function skin_check_blog_has_slider( $control ) {
			if ( 'slider-featured' === skin_ctrl_blog_featured( $control ) || 'slider-latest' === skin_ctrl_blog_featured( $control ) ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Featured posts slider is active
	if ( ! function_exists( 'skin_check_blog_has_slider_custom' ) ) :
		function skin_check_blog_has_slider_custom( $control ) {
			if ( 'slider-featured' === skin_ctrl_blog_featured( $control ) ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Check the value of blog layout type
	if ( ! function_exists( 'skin_ctrl_blog_layout' ) ) :
		function skin_ctrl_blog_layout( $control ) {
			$layout = $control->manager->get_setting( 'skin_blog_layout' )->value();
			
			return $layout;
		}
	endif;
	
// Featured image options on posts list
	if ( ! function_exists( 'skin_check_layout_has_img_shape_ctrls' ) ) :
		function skin_check_layout_has_img_shape_ctrls( $control ) {
			if ( false !== strpos( skin_ctrl_blog_layout( $control ), 'masonry' ) ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Special box activated: Popout (widget)
	if ( ! function_exists( 'skin_check_specials_have_popout' ) ) :
		function skin_check_specials_have_popout( $control ) {
			if ( true === $control->manager->get_setting( 'skin_specials_popout_on' )->value() ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Special box activated: Skin Image Banner (widget)
	if ( ! function_exists( 'skin_check_specials_have_bnnr' ) ) :
		function skin_check_specials_have_bnnr( $control ) {
			if ( true === $control->manager->get_setting( 'skin_specials_bnnr_on' )->value() ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Skin Image Banner 1
	if ( ! function_exists( 'skin_check_specials_have_bnnr_1' ) ) :
		function skin_check_specials_have_bnnr_1( $control ) {
			if (
				true === skin_check_specials_have_bnnr( $control )
				&& '' !== $control->manager->get_setting( 'skin_specials_bnnr_1' )->value()
			) {				
				return true;
			}
			
			return false;
		}
	endif;
	
// Skin Image Banner 2	
	if ( ! function_exists( 'skin_check_specials_have_bnnr_2' ) ) :
		function skin_check_specials_have_bnnr_2( $control ) {
			if (
				true === skin_check_specials_have_bnnr( $control )
				&& '' !== $control->manager->get_setting( 'skin_specials_bnnr_2' )->value()
			) {				
				return true;
			}
			
			return false;
		}
	endif;
	
// Skin Image Banner 3	
	if ( ! function_exists( 'skin_check_specials_have_bnnr_3' ) ) :
		function skin_check_specials_have_bnnr_3( $control ) {
			if (
				true === skin_check_specials_have_bnnr( $control )
				&& '' !== $control->manager->get_setting( 'skin_specials_bnnr_3' )->value()
			) {				
				return true;
			}
			
			return false;
		}
	endif;
	
// Skin Image Banner 4	
	if ( ! function_exists( 'skin_check_specials_have_bnnr_4' ) ) :
		function skin_check_specials_have_bnnr_4( $control ) {
			if (
				true === skin_check_specials_have_bnnr( $control )
				&& '' !== $control->manager->get_setting( 'skin_specials_bnnr_4' )->value()
			) {				
				return true;
			}
			
			return false;
		}
	endif;
	
// Skin Image Banner 5
	if ( ! function_exists( 'skin_check_specials_have_bnnr_5' ) ) :
		function skin_check_specials_have_bnnr_5( $control ) {
			if (
				true === skin_check_specials_have_bnnr( $control )
				&& '' !== $control->manager->get_setting( 'skin_specials_bnnr_5' )->value()
			) {				
				return true;
			}
			
			return false;
		}
	endif;	
	
// Special box activated: Skin Social Profiles (widget)
	if ( ! function_exists( 'skin_check_specials_have_social' ) ) :
		function skin_check_specials_have_social( $control ) {
			if ( true === $control->manager->get_setting( 'skin_specials_social_on' )->value() ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Special box activated: Skin Popular/Latest Posts (widget)
	if ( ! function_exists( 'skin_check_specials_have_popular' ) ) :
		function skin_check_specials_have_popular( $control ) {
			if ( true === $control->manager->get_setting( 'skin_specials_topposts_on' )->value() ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Categories are shown on posts list
	if ( ! function_exists( 'skin_check_blog_shows_cat' ) ) :
		function skin_check_blog_shows_cat( $control ) {
			if ( true === $control->manager->get_setting( 'skin_blog_show_category' )->value() ) {
				return true;
			}
			
			return false;
		}
	endif;
	
// Categories are shown on single posts
	if ( ! function_exists( 'skin_check_single_shows_cat' ) ) :
		function skin_check_single_shows_cat( $control ) {
			if ( true === $control->manager->get_setting( 'skin_cat_in_header' )->value() ) {
				return true;
			}
			
			return false;
		}
	endif;
	
	if ( SKIN_WOOCOMMERCE_ACTIVE ) :
	// Check the value of shop featured area control
		if ( ! function_exists( 'skin_woo_ctrl_shop_featured' ) ) :
			function skin_woo_ctrl_shop_featured( $control ) {
				$blog_featured = $control->manager->get_setting( 'skin_woo_shop_featured' )->value();
				
				return $blog_featured;
			}
		endif;
	
	// Products slider is active
		if ( ! function_exists( 'skin_woo_shop_has_slider' ) ) :
			function skin_woo_shop_has_slider( $control ) {
				if ( false !== strpos( skin_woo_ctrl_shop_featured( $control ), 'slider' ) ) {
					return true;
				}
				
				return false;
			}
		endif;
	endif;
	
/*	Theme inline styles
========================== */
	include_once( get_template_directory() . '/admin/customizer/dynamic-styles.php' );	
	
/*	Customizer assets
========================= */
// Styles   
	add_action( 'customize_controls_print_styles', 'skin_customizer_styles' );
	
	if ( ! function_exists( 'skin_customizer_styles' ) ) :
		function skin_customizer_styles() {
			wp_enqueue_style(
				'skin_customizer',
				get_template_directory_uri() . '/admin/customizer/css/customizer.css'
			);
		}
	endif;
	
// Scripts
	add_action( 'customize_preview_init', 'skin_customizer_preview' );
	
	if ( ! function_exists( 'skin_customizer_preview' ) ) :
		function skin_customizer_preview() {
			wp_enqueue_script(
				'skin_customizer_preview',
				get_template_directory_uri() . '/admin/customizer/js/customizer-preview.js',
				array( 'customize-preview', 'jquery' ),
				false,
				true
			);
		}
	endif;
	
	add_action( 'customize_controls_enqueue_scripts', 'skin_customizer_controls' );
	
	if ( ! function_exists( 'skin_customizer_controls' ) ) :
		function skin_customizer_controls() {			
			wp_register_script(
				'skin_customizer_controls',
				get_template_directory_uri() . '/admin/customizer/js/customizer-controls.js',
				array( 'jquery', 'skin_suggest' ),
				false,
				true
			);
			
			$ctrl_parent = version_compare( $GLOBALS['wp_version'], '4.9-alpha', '<' ) ? 'label' : 'row';
			
			$customizer_args = array(
				'ctrl_parent'	=> $ctrl_parent
			);
			
			wp_localize_script( 'skin_customizer_controls', 'customizer_args', $customizer_args );
			wp_enqueue_script( 'skin_customizer_controls' );
		}
	endif;
?>