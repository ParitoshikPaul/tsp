<?php
/* =====================================================
	REGISTER OF THE SCRIPTS AND STYLES USED IN THEME
	Skin - Premium WordPress Theme, by NordWood
======================================================== */	
/*	Front-end
================ */
	add_action( 'wp_enqueue_scripts', 'skin_frontend_scripts_styles' );
	
	if ( ! function_exists( 'skin_frontend_scripts_styles' ) ) :
		function skin_frontend_scripts_styles() {			
		// Assets
			wp_enqueue_script(
				'skin_assets_images_loaded',
				get_template_directory_uri() . '/assets/images-loaded/imagesloaded.pkgd.min.js',
				array( 'jquery' ),
				'4.1.3',
				true
			);
			
			wp_register_script(
				'skin_assets_infinite_scroll',
				get_template_directory_uri() . '/assets/infinite-scroll/jquery.infinitescroll.min.js',
				array( 'jquery' ),
				'2.1.0',
				true
			);
			
			wp_register_script(
				'skin_assets_masonry',
				get_template_directory_uri() . '/assets/masonry/masonry.pkgd.min.js',
				array('jquery'),
				'4.2.0',
				true
			);
			
			wp_enqueue_style(
				'skin_assets_swiper',
				get_template_directory_uri() . '/assets/swiper/css/swiper.min.css'
			);
			
			wp_register_script(
				'skin_assets_swiper',
				get_template_directory_uri() . '/assets/swiper/js/swiper.jquery.min.js',
				array('jquery'),
				'',
				true
			);
			
			wp_register_script(
				'skin_assets_fb_sdk',
				get_template_directory_uri() . '/assets/social/fb-sdk.js',
				null,
				'',
				true
			);
			
		// Main scripts and styles
			$direction = is_rtl() ? 'rtl' : 'ltr';
			
			wp_enqueue_style(
				'skin-google-fonts',
				skin_google_fonts_url(),
				array(),
				null
			);

			wp_enqueue_style(
				'skin_main',
				get_stylesheet_uri()
			);
			
			if ( 'rtl' === $direction ) {
				wp_enqueue_style(
					'skin_rtl', get_template_directory_uri() . '/rtl.css'
				);
			}
			
		// Google Map
			$google_maps_api_key = get_theme_mod( 'skin_google_maps_api_key' );
			
			if ( $google_maps_api_key && '' !== $google_maps_api_key ) {
				wp_enqueue_script(
					'mapAPI',
					'https://maps.googleapis.com/maps/api/js?v=3&key='.$google_maps_api_key,
					array( 'jquery' ),
					null,
					true
				);
			}
			
		// Main scripts
			wp_register_script(
				'skin_main',
				get_template_directory_uri() . '/js/main.js',
				array( 'jquery', 'skin_assets_swiper' ),
				false,
				true
			);
			
			$localize_main = array(
				'direction'		=> $direction,
				'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
				'quoteSVG'		=> skin_get_icon_quote(),
				'submenuSVG'	=> skin_get_icon_arrow_down(),				
				'api_key' 		=> $google_maps_api_key
			);
			
			wp_localize_script(
				'skin_main',
				'mainLoc',
				$localize_main
			);
			
			wp_enqueue_script( 'skin_main' );
			
		// Enable threaded comments
			if (
				(
					( is_single() && false === get_theme_mod( 'skin_disable_wp_comments_on_posts', false ) ) ||
					( is_page() && false === get_theme_mod( 'skin_disable_wp_comments_on_pages', false ) )
				) &&
				get_option( 'thread_comments' )
			) {
				wp_enqueue_script( 'comment-reply' );
			}
			
		// Facebook widget and comments			
			$locale = get_locale();
	
			$localize = array(
				'locale' => $locale
			);
			
			wp_localize_script( 'skin_assets_fb_sdk', 'localize', $localize );
			wp_enqueue_script( 'skin_assets_fb_sdk' );
			
		// Share selected text
			wp_register_script(
				'skin_share_selection', get_template_directory_uri() . '/js/share-selection.js',
				array('jquery'),
				false,
				true
			);
			
			if ( true === get_theme_mod( 'skin_share_selection', true ) ) {
				$icons = array(
					'icon_fb' => skin_get_icon_facebook(),
					'icon_tw' => skin_get_icon_twitter()
				);
				
				wp_localize_script( 'skin_share_selection', 'icons', $icons );
				wp_enqueue_script( 'skin_share_selection' );
			}
			
		// Posts slider
			wp_register_script(
				'skin_posts_slider',
				get_template_directory_uri() . '/js/posts-slider.js',
				array( 'skin_assets_swiper', 'skin_main', 'jquery' ),
				false,
				true
			);
			
			if ( is_page() && 'slider-on' === skin_get_meta( 'skin_slider_on_page' ) ) {
				wp_enqueue_script( 'skin_posts_slider' );
			}
			
		// Top Posts (Popular/Latest) slider
			wp_register_script(
				'skin_top_posts', get_template_directory_uri() . '/js/top-posts.js',
				array( 'jquery' ),
				false,
				true
			);
				
			if ( SKIN_WOOCOMMERCE_ACTIVE ) {			
				wp_enqueue_script('selectWoo');
				wp_enqueue_style( 'select2' );
			
				wp_enqueue_style(
					'skin_woo',
					get_template_directory_uri() . '/woo/css/woo.css'
				);
			
				wp_register_script(
					'skin_woo', get_template_directory_uri() . '/woo/js/woo.js',
					array( 'jquery' ),
					false,
					true
				);
				
				wp_enqueue_script( 'skin_woo' );
			}
			
		// Dynamic styles
			wp_enqueue_style(
				'skin_dynamic_styles',
				get_template_directory_uri() . '/css/dynamic-styles.css'
			);
			
		// Posts List
			wp_register_script(
				'skin_infinite_scroll',
				get_template_directory_uri() . '/js/infinite-scroll.js',
				array(
					'jquery',
					'skin_assets_images_loaded',
					'skin_top_posts',
					'skin_assets_infinite_scroll',
					'skin_assets_masonry'
				),
				'',
				true
			);
			
			wp_register_script(
				'skin_masonry_layout',
				get_template_directory_uri() . '/js/masonry-layout.js',
				array(
					'jquery',
					'skin_assets_images_loaded',
					'skin_top_posts',
					'skin_assets_masonry'
				),
				'',
				true
			);
			
			$l		= 'masonry-3';
			$l_type	= 'masonry';
			$p		= 'infinite';
			$b		= false;
			
			if ( is_home() ) {
				$b = true;
				$l = get_theme_mod( 'skin_blog_layout', 'masonry-3' );
				$p = get_theme_mod( 'skin_blog_pagination_type', 'infinite' );
			}
			
			if ( is_archive() ) {
				if ( is_category() ) {
					$b = true;
					$l = get_theme_mod( 'skin_category_layout', 'masonry-3' );
					$p = get_theme_mod( 'skin_category_pagination', 'infinite' );
					
				} else if ( is_tag() ) {
					$b = true;
					$l = get_theme_mod( 'skin_tag_layout', 'masonry-3' );
					$p = get_theme_mod( 'skin_tag_pagination', 'infinite' );
					
				} else if ( is_date() ) {
					$b = true;
					$l = get_theme_mod( 'skin_date_layout', 'masonry-3' );
					$p = get_theme_mod( 'skin_date_pagination', 'infinite' );
				
				} else if ( is_author() ) {
					$b = true;
					$l = get_theme_mod( 'skin_author_layout', 'masonry-3' );
					$p = get_theme_mod( 'skin_author_pagination', 'infinite' );
					
				} else {
					$b = true;
					$l = get_theme_mod( 'skin_archive_layout', 'masonry-3' );
					$p = get_theme_mod( 'skin_archive_pagination', 'infinite' );
				}
			}
			
			if ( is_search() ) {
				$b = true;
				$l = get_theme_mod( 'skin_search_layout', 'masonry-3' );
				$p = get_theme_mod( 'skin_search_pagination', 'infinite' );
			}
				
			if ( SKIN_WOOCOMMERCE_ACTIVE ) {
				if ( is_shop() ) {
					wp_enqueue_script( 'skin_posts_slider' );
				}
				
				if ( is_shop() || is_product_category() || is_product_tag() || is_cart() ) {
					$b = true;
					$l = get_theme_mod( 'skin_woo_layout', 'masonry-2-sidebar' );
					$p = 'standard-pagination';					
				}
				
				if ( is_singular( 'product' ) ) {
					$b = true;
					$l = 'masonry-3';
					$p = 'standard-pagination';
				}
			}
			
			if ( false !== strpos( $l, 'standard-list' ) ) {
				$l_type = 'standard-list';
			}
			
			$f = get_theme_mod( 'skin_blog_featured', 'skip' );
			
			if ( false !== strpos( $f, 'slider' ) ) {
				wp_enqueue_script( 'skin_posts_slider' );
			}			
			
			if ( $b && 'infinite' === $p ) {
				if ( is_home() ) {
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;	
					$skip_cat = explode( ',', get_theme_mod( 'skin_blog_skip_category' ) );
					$skip_author = explode( ',', get_theme_mod( 'skin_blog_skip_author' ) );
					
				// Posts to skip in the list
					$skip_posts = array();						
					
				// Check if there are sticky posts
					$stickies = get_option( 'sticky_posts' );
					
					if ( 0 < count( $stickies ) ) {
						foreach( $stickies as $s ) {
							$skip_posts[] = $s;
						}
					}
					
				// Check if there are posts in featured area
					$f_slider = get_theme_mod( 'skin_blog_slider_ids' );
					$slides_qty = get_theme_mod( 'skin_blog_slider_count', 5 );
					$skip_featured_posts = get_theme_mod( 'skin_blog_skip_featured', false );
					
					if ( 'skip' !== $f && 'welcome-mssg' !== $f ) {		
					// Enlarged featured post
						if( 'enlarge-featured' === $f && $f_post_id = get_theme_mod( 'skin_blog_enlarged_id' ) ) {
						/*
							If featured post should not repeat in the list,
							add it to 'skip' array
						*/				
							if ( true === $skip_featured_posts ) {
								$skip_posts[] = $f_post_id;
							}
						}
		
					// Grid with featured posts
						if ( 'grid-featured' === $f && $f_grid = get_theme_mod( 'skin_blog_grid_ids' ) ) {				
						// Check if the user's string of IDs can be converted to a valid array
							$f_grid_filter = explode( ',', $f_grid );
							
							if ( is_array( $f_grid_filter ) && 2 < sizeof( $f_grid_filter ) ) {
							/*	
								If the featured posts from the grid should not repeat in the list,
								add them to 'skip' array
							*/				
								if ( true === $skip_featured_posts ) {
									foreach ( $f_grid_filter as $key => $val ) {
										if ( (int)$f_grid_filter[$key] ) {
											$skip_posts[] = (int)$f_grid_filter[$key];
										}
									}
								}
							}
						}
						
					// Slider with featured posts							
						if ( 'slider-featured' === $f && $f_posts = get_theme_mod( 'skin_blog_slider_ids' ) ) {			
						// Check if the user's string of IDs can be converted to a valid array
							$f_filter = explode( ',', $f_posts );
							
							if ( is_array( $f_filter ) && 2 < sizeof( $f_filter ) ) {
							/*	
								If the posts from the slider should not repeat in the list,
								add them to 'skip' array
							*/						
								if ( true === $skip_featured_posts ) {							
									foreach ( $f_filter as $key => $val ) {
										if ( (int)$f_filter[$key] ) {
											$skip_posts[] = (int)$f_filter[$key];
										}
									}
								}
							}
						}
						
					// Latest posts in featured area
						$recent_ids = array();
						
						if ( false !== strpos( $f, 'latest' ) ) {
							$qty = 1;
							
							if ( false !== strpos( $f, 'grid' ) ) {
								$qty = 3;
								
							} else if ( false !== strpos( $f, 'slider' ) ) {
								$qty = get_theme_mod( 'skin_blog_slider_count', 5 );
							}			
							
							$recent_args = array(
								'numberposts' 			=> $qty,
								'orderby' 				=> 'date',
								'post_status' 			=> 'publish',
								'post_type' 			=> 'post',
								'order' 				=> 'DESC',
								'ignore_sticky_posts' 	=> 0,
								'post__not_in'			=> $stickies,
								'category__not_in' 		=> $skip_cat,
								'author__not_in' 		=> $skip_author
							);
							
							$recent_posts = wp_get_recent_posts( $recent_args );
							$recent_ids = array();
							
							foreach ( $recent_posts as $r ) {
								$recent_ids[] = $r["ID"];
							}
							
						// Enlarged latest post
							if ( 'enlarge-latest' === $f && 0 < sizeof( $recent_ids ) ) {
								$latest_id = $recent_ids[0];
								
							/*
								If the latest post should not repeat in the list,
								add it to 'skip' array
							*/
								if ( true === $skip_featured_posts ) {
									$skip_posts[] = $latest_id;
								}
								
						// Grid with latest posts
							} else if ( 'grid-latest' === $f && 2 < sizeof( $recent_ids ) ) {
								
							/*
								If posts from the grid should not repeat in the list,
								add them to 'skip' array
							*/				
								if ( true === $skip_featured_posts ) {
									foreach ( $recent_ids as $rid ) {
										$skip_posts[] = $rid;
									}
								}
								
						// Slider with latest posts
							} else if ( 'slider-latest' === $f && 2 < sizeof( $recent_ids ) ) {
								
							/*
								If posts from the slider should not repeat in the list,
								add them to 'skip' array
							*/
								if ( true === $skip_featured_posts ) {
									foreach ( $recent_ids as $rid ) {
										$skip_posts[] = $rid;
									}
								}
							}
						}
					}					
					
					$skip_posts = array_unique( $skip_posts );
					
					$latest_args = array(
						'post_type' 			=> 'post',
						'post_status' 			=> 'publish',
						'category__not_in'		=> $skip_cat,
						'author__not_in' 		=> $skip_author,
						'posts_per_page' 		=> get_option( 'posts_per_page' ),
						'paged' 				=> $paged,
						'ignore_sticky_posts'	=> 0,
						'post__not_in' 			=> $skip_posts
					);

					$latest_query = new WP_Query( $latest_args );
											
					$infinite = array(
						'share_selection'	=> ( true === get_theme_mod( 'skin_share_selection', true ) ? true : false ),
						'layout_type' 		=> $l_type,
						'max_pages'			=> $latest_query->max_num_pages
					);
				
					wp_localize_script( 'skin_infinite_scroll', 'infinite', $infinite );
					wp_enqueue_script( 'skin_infinite_scroll' );
					
				} else {
					global $wp_query;
					
					$infinite = array(
						'share_selection'	=> ( true === get_theme_mod( 'skin_share_selection', true ) ? true : false ),
						'layout_type' 		=> $l_type,
						'max_pages' 		=> $wp_query->max_num_pages
					);
				
					wp_localize_script( 'skin_infinite_scroll', 'infinite', $infinite );
					wp_enqueue_script( 'skin_infinite_scroll', 'main' );
				}
			}
			
			if ( $b && 'masonry' === $l_type && 'standard-pagination' === $p ) {
				wp_enqueue_script( 'skin_masonry_layout' );
			}
			
			if ( is_active_widget( false, false, 'skin_top_posts', true ) ) {			
				$localize_top_posts = array(
					'direction' => $direction
				);
				
				wp_localize_script(
					'skin_top_posts',
					'topPostsLoc',
					$localize_top_posts
				);
				
				wp_enqueue_script( 'skin_top_posts' );
			}
		}
	endif;
		
/*	Include the font families from Google Fonts
================================================== */
	if ( ! function_exists( 'skin_google_fonts_url' ) ) {
		function skin_google_fonts_url() {
			$fonts_url = '';
			$typos = array();
			
		// Get all the typography settings and split each into array of: family, variants and subsets chosen
			$typos[] = explode( '|', get_theme_mod( 'skin_typo_main', 'Quicksand|regular|latin|15|30|0|none' ) );			
			$typos[] = explode( '|', get_theme_mod( 'skin_typo_h1', 'Quicksand|500|latin|40|53|0|none' ) );			
			$typos[] = explode( '|', get_theme_mod( 'skin_typo_h2', 'Quicksand|500|latin|32|40|0|none' ) );			
			$typos[] = explode( '|', get_theme_mod( 'skin_typo_h3', 'Quicksand|500|latin|21|30|0|none' ) );
			$typos[] = explode( '|', get_theme_mod( 'skin_typo_h4', 'Quicksand|500|latin|18|26|0|none' ) );
			$typos[] = explode( '|', get_theme_mod( 'skin_typo_h5', 'Quicksand|500|latin|15|22|0|none' ) );
			$typos[] = explode( '|', get_theme_mod( 'skin_typo_h6', 'Quicksand|500|latin|10|18|1|none' ) );
			$typos[] = explode( '|', get_theme_mod( 'skin_typo_welcome', 'Quicksand|500|latin|40|53|0|none' ) );
			$typos[] = explode( '|', get_theme_mod( 'skin_typo_dropcaps', 'Quicksand|500|latin|32|30|0|none' ) );
			$typos[] = explode( '|', get_theme_mod( 'skin_typo_details', 'Quicksand|500|latin|12|18|0|none' ) );
			$typos[] = explode( '|', get_theme_mod( 'skin_typo_small_text', 'Quicksand|regular|latin|13|24|0|none' ) );
			$typos[] = explode( '|', get_theme_mod( 'skin_typo_topbar', 'Quicksand|500|latin|17|30|0|none' ) );
			$typos[] = explode( '|', get_theme_mod( 'skin_typo_blockquote', 'Quicksand|500|latin|21|30|0|none' ) );
			
		/*
			For each setting, get the font family, replace the white spaces with "+" sign and add its selected variant.
			Add its chosen subset to the separate array
			(Subsets in the final url should be added after all the families/variants are listed, so they cannot be specified by each individually)
		*/			
			$families_off = true;
			foreach ( $typos as $typo ) {
				$family = str_replace( ' ', '+', $typo[0] );
				
				if ( 'off' != $family ) {
					$families_off = false;
				}
			}
			
		// Set 'latin' as default subset
			$families_variants = array();
			$subsets = array();			
		/*
			Translators: If there are characters in your language that are not supported by Google font, translate it to 'off'.
			Do not translate into your own language.
		*/ 
			if ( !$families_off ) {
				$families_variants = array();
				
				foreach ( $typos as $i => $typo ) {
					$family = str_replace( ' ', '+', $typo[0] );
					
					if ( 'off' !== $family ) {
					/*
						If the family already exists, assign the variants to it.
						Otherwise, add new item to family=>variants array.
					*/
						if ( array_key_exists( $family, $families_variants ) ) {
							$families_variants[$family] .= "," . $typo[1];
							
						} else {
							$families_variants[$family] = $typo[1];
						}					
						
						$subsets[] = $typo[2];
					}
				}
					
			// Remove the duplicates from the variants associated to each family and sort the values
				foreach ( $families_variants as $f => $v ) {
					$v = array_unique( explode( ',', $v ) );
					sort( $v );
					$v = implode( ',', $v );
					$families_variants[$f] = $v;
				}
		
			// Arrange the family=>variants pairs into family:variants strings, separated by "|"
				$families_combined = '';
				
				foreach ( $families_variants as $f => $v ) {
					$families_combined .= $f . ":" . $v . "|";
				}
				
				$families_combined = rtrim( $families_combined, "|" );
				$families_combined = str_replace( ',', '%2C', $families_combined );
				$families_combined = str_replace( '|', '%7C', $families_combined );
			
			// Get all the subsets (not all of them may be available by each family, but that is how the url works :) )
				$subsets = implode( ',', array_unique( $subsets ) );
				$subsets = str_replace( ',', '%2C', $subsets );
			
				$query_args = array(
					'family' => $families_combined,
					'subset' => $subsets
				);
				
				$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
				return esc_url_raw( $fonts_url );
			}
		}
	}	
	
/*	Back-end
=============== */
	add_action( 'admin_enqueue_scripts', 'skin_admin_scripts_styles' );
	
	if ( ! function_exists( 'skin_admin_scripts_styles' ) ) :
		function skin_admin_scripts_styles() {
			wp_register_script(
				'skin_img_upload',
				get_template_directory_uri() . '/admin/js/img-upload.js',
				array('jquery'),
				false,
				true
			);
			
			wp_enqueue_script(
				'skin_suggest',
				get_template_directory_uri() . '/admin/js/suggest.min.js',
				array( 'jquery', 'suggest' ),
				false,
				true
			);
			
			wp_register_script(
				'skin_metaboxes',
				get_template_directory_uri() . '/admin/metaboxes/js/metaboxes.js',
				array( 'jquery' ),
				false,
				true
			);
				
			wp_enqueue_style(
				'skin_admin_styles',
				get_template_directory_uri() . '/admin/css/admin-styles.css'
			);
		
			wp_enqueue_style(
				'skin_welcome_screen',
				get_template_directory_uri() . '/admin/welcome/css/welcome.css'
			);
		}
	endif;
	
// Enqueue scripts for particular admin pages
	add_action( 'current_screen', 'skin_admin_screen_scripts' );
	
	if ( ! function_exists( 'skin_admin_screen_scripts' ) ) :
		function skin_admin_screen_scripts() {
			wp_register_script(
				'skin_widgets_screen',
				get_template_directory_uri() . '/admin/widgets/js/widgets-screen.js',
				array('jquery'),
				null,
				true
			);
			
			$screen = get_current_screen();
		
		// "Widgets" screen			
			if ( "widgets" === $screen->id ) {
				$spec_desc = sprintf(
					'<h3>%1$s</h3><p>%2$s</p><p>%3$s</p><p>%4$s</p>',
					esc_html__( 'Special widgets', 'skin' ),
					esc_html__( 'The widgets from \'Blog Specials\' and \'WooCommerce Specials\' sidebars will appear among the posts in blog page (with masonry layout), or among the products on shop page, respectively.', 'skin' ),
					esc_html__( 'Though other widgets may work as well, those signed with &#9733; are marked as being fully compatible and best candidates for this feature.', 'skin' ),
					esc_html__( 'Use the two additional fields to control their positions :)', 'skin' )
				);
				
				$desc = sprintf(
					'<h3>%1$s</h3><p>%2$s</p><p>%3$s</p>',
					esc_html__( 'AdSense areas', 'skin' ),
					esc_html__( 'Drag the widgets to the sidebars above, in which you want them to appear.', 'skin' ),
					esc_html__( 'Adsense code can be included via \'Custom HTML\' widget.', 'skin' )
				);
				
				$l_title = esc_html__( 'Posts list', 'skin' );
				$l_preview = get_template_directory_uri() . '/admin/widgets/img/list.png';
				
				$s_title = esc_html__( 'Single post/page', 'skin' );
				$s_preview = get_template_directory_uri() . '/admin/widgets/img/single.png';
		
				$areas = array(
					'spec_desc'	=> $spec_desc,
					'desc'		=> $desc,
					'l_title'	=> $l_title,
					'l_preview'	=> $l_preview,
					's_title'	=> $s_title,
					's_preview'	=> $s_preview
				);
				
				wp_localize_script( 'skin_widgets_screen', 'areas', $areas );
				wp_enqueue_script( 'skin_widgets_screen' );
				
				wp_enqueue_style(
					'skin_widgets_screen',
					get_template_directory_uri() . '/admin/widgets/css/widgets-screen.css'
				);
			}
		}
	endif;
?>