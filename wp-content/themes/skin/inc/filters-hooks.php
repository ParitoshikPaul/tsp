<?php
/* =====================================================================
	FILTERS & HOOKS - customizing some native WP styles and behaviors
	Skin - Premium WordPress Theme, by NordWood
======================================================================== */
/*	TABLE OF CONTENTS
======================= */
/*
	0.0 SUPPORT FOR THE MENU ITEMS
	0.1 Description in main menu items
	
	1.0 CUSTOM FIELDS TO EXISTENT ITEMS
	1.1 Custom widget fields
	1.2 Additional image size
	
	2.0 CUSTOM CLASSES TO THE ARRAY OF EXISTENT CLASSES
	2.1 Custom body classes
	2.2 Custom post classes
	2.3 Custom widget classes
	
	3.0 CUSTOM COLUMNS FOR ADMIN SCREENS
	3.1 Custom column for posts: Post featured image
	3.2 Custom column for posts: Post ID
	3.3 Custom column for categories and tags: Category/Tag ID
	3.4 Custom column for categories: Color
	3.5 Custom column for users: User ID
	
	4.0 MODIFY OUTPUT FOR EXISTENT ITEMS
	4.1 Modify tag cloud
	4.2 Modify gallery output to show the slider instead of thumbnails
	4.3 Modify embedded items in post content
	
	5.0 AJAX CALLS
	5.1 Fetching results for Quick Search Overlay
	
	6.0 ADDITIONS TO HEAD TAG
	6.1 Add a pingback url auto-discovery header for singularly identifiable articles
	6.2 Open Graph meta tags
	
	7.0 PERFORMANCE
	7.1 Disable WP Emoji
	7.2 Remove query string from static files
*/

/* 	0.0 SUPPORT FOR THE MENU ITEMS
================================ */
//	0.1 Description in main menu items
	add_filter( 'walker_nav_menu_start_el', 'skin_main_menu_desc', 10, 4 );
	
	if ( ! function_exists( 'skin_main_menu_desc' ) ) :
		function skin_main_menu_desc( $item_output, $item, $depth, $args ) {
			if ( 'main_menu' == $args->theme_location && ! $depth && $item->description ) {
				$item_output = str_replace( '<a ', '<a data-description="' . esc_attr( $item->description ) . '" ', $item_output );
			}
			
			return $item_output;
		}
	endif;
	
/* 	1.0 CUSTOM FIELDS TO EXISTENT ITEMS
========================================= */
//	1.1 Custom widget fields
	add_filter( 'in_widget_form', 'skin_add_widget_options', 10, 3 );

	if ( ! function_exists( 'skin_add_widget_options' ) ) :
		function skin_add_widget_options( $widget, $return, $instance ) {			
			if ( 'categories' == $widget->id_base ) {
				$hide_uncategorized = isset( $instance['hide_uncategorized'] ) && 1 == $instance['hide_uncategorized'] ? $instance['hide_uncategorized'] : 0;
		?>
				<p>
					<input class="checkbox"
						type="checkbox"
						id="<?php echo esc_attr( $widget->get_field_id( 'hide_uncategorized' ) ); ?>"
						name="<?php echo esc_attr( $widget->get_field_name( 'hide_uncategorized' ) ); ?>"
						value="1" <?php checked( $hide_uncategorized, true ); ?>
					/>
					<label for="<?php echo esc_attr( $widget->get_field_id( 'hide_uncategorized' ) ); ?>"><?php esc_html_e( 'Hide \'Uncategorized\'', 'skin' ); ?></label>
				</p>
		<?php
			}
			
			$widget_bgr = isset( $instance['widget_bgr'] ) ? $instance['widget_bgr'] : 'content-pad';
		?>
			<h4><?php esc_html_e( 'Background:', 'skin' ); ?></h4>
			<p>
				<input type="radio"
					name="<?php echo esc_attr( $widget->get_field_name( 'widget_bgr' ) ); ?>"
					id="<?php echo esc_attr( $widget->get_field_id( 'widget_bgr' ) . '_0' ); ?>"
					value="content-pad"
					<?php checked( "content-pad" === $widget_bgr, true ) ?>
				>
				<label for="<?php echo esc_attr( $widget->get_field_id( 'widget_bgr' ) . '_0' ); ?>"><?php esc_html_e( 'Same as content pad', 'skin' ); ?></label>
			</p>
			<p>
				<input type="radio"
					name="<?php echo esc_attr( $widget->get_field_name( 'widget_bgr' ) ); ?>"
					id="<?php echo esc_attr( $widget->get_field_id( 'widget_bgr' ) . '_1' ); ?>"
					value="gradient"
					<?php checked( "gradient" === $widget_bgr, true ) ?>
				>
				<label for="<?php echo esc_attr( $widget->get_field_id( 'widget_bgr' ) . '_1' ); ?>"><?php esc_html_e( 'Gradient background', 'skin' ); ?></label>
			</p>
			<p>
				<input type="radio"
					name="<?php echo esc_attr( $widget->get_field_name( 'widget_bgr' ) ); ?>"
					id="<?php echo esc_attr( $widget->get_field_id( 'widget_bgr' ) . '_2' ); ?>"
					value="no-bgr"
					<?php checked( "no-bgr" === $widget_bgr, true ) ?>
				>
				<label for="<?php echo esc_attr( $widget->get_field_id( 'widget_bgr' ) . '_2' ); ?>"><?php esc_html_e( 'No background', 'skin' ); ?></label>
			</p>
		<?php			
			global $wp_registered_sidebars;
			$spec_widgets = wp_get_sidebars_widgets();
			$spec_ids = $spec_widgets['sidebar-specials'];
			
			if ( in_array( $widget->id, $spec_ids  ) ) {
				$start = isset( $instance['start'] ) ? $instance['start'] : 3;
				$repeat = isset( $instance['repeat'] ) ? $instance['repeat'] : 4;
		?>
			<div class="special-widgets-fields">
				<h4><?php esc_html_e( 'Loop', 'skin' ); ?></h4>
				<p>	
					<label for="<?php echo esc_attr( $widget->get_field_name( 'start' ) ); ?>"><?php esc_html_e( 'Starting position:', 'skin' ); ?></label>
					
					<input type="number" class="widefat"
						name="<?php echo esc_attr( $widget->get_field_name( 'start' ) ); ?>"
						id="<?php echo esc_attr( $widget->get_field_id( 'start' ) ); ?>"
						value="<?php echo absint( $start ); ?>"
						placeholder="3"
					>
				</p>
				<p>	
					<label for="<?php echo esc_attr( $widget->get_field_name( 'repeat' ) ); ?>"><?php esc_html_e( 'Repeat on:', 'skin' ); ?></label>
					
					<input type="number" class="widefat"
						name="<?php echo esc_attr( $widget->get_field_name( 'repeat' ) ); ?>"
						id="<?php echo esc_attr( $widget->get_field_id( 'repeat' ) ); ?>"
						value="<?php echo absint( $repeat ); ?>"
						placeholder="4"
					>
				</p>
			</div>
		<?php
			}			
		}
	endif;
	
	add_filter( 'widget_update_callback', 'skin_save_widget_options', 10, 3 );

	if ( ! function_exists( 'skin_save_widget_options' ) ) :
		function skin_save_widget_options( $instance, $new_instance ) {
			$instance['widget_bgr'] = isset( $new_instance['widget_bgr'] ) ? esc_attr( $new_instance['widget_bgr'] ) : 'content-pad';
			
			$instance['hide_uncategorized'] = isset( $new_instance['hide_uncategorized'] ) ? esc_attr( $new_instance['hide_uncategorized'] ) : 0;
			
			$instance['start'] = isset( $new_instance['start'] ) ? absint( $new_instance['start'] ) : 3;
			$instance['repeat'] = isset( $new_instance['repeat'] ) ? absint( $new_instance['repeat'] ) : 4;
			
			return $instance;
		}
	endif;	

//	1.2 Additional image size
	add_filter( 'image_size_names_choose', 'skin_img_sizes' );
	
	if ( ! function_exists( 'skin_img_sizes' ) ) :
		function skin_img_sizes( $sizes ) {
			return array_merge( $sizes, array(
				'skin_wrapper_width' => esc_html__( 'Extra large', 'skin' )
			));
		}
	endif;
	
/* 	2.0 CUSTOM CLASSES TO THE ARRAY OF EXISTENT CLASSES
========================================================= */
//	2.1 Custom body classes
	add_filter( 'body_class', 'skin_body_class' );
	
	if ( ! function_exists( 'skin_body_class' ) ) :
		function skin_body_class( $classes ) {
			if ( is_home() || is_archive() || is_search() ) {
				$layout_width = 'wrapped';
				$layout = 'masonry-3';
			
				$layout = skin_get_layout_type();
				
				if ( false !== strpos( $layout, 'full-width' ) ) {
					$layout_width = 'full-width';
				}
				
				$classes[] = 'posts-list';
				$classes[] = sanitize_html_class( $layout_width );
			}
			
			return $classes;
		}
	endif;
	
//	2.2 Custom post classes
	add_filter( 'post_class', 'skin_post_classes', 10, 3 );
	
	if ( ! function_exists( 'skin_post_classes' ) ) :
		function skin_post_classes( $classes, $class, $post_id ) {
			$post_type = get_post_type( $post_id );
			
			$classes[] = 'clearfix';
			
			if( 'post' === $post_type || 'page' === $post_type ) {
				$classes[] = 'content-pad';
				
				$dropcaps = false;
				$enlarge_media = false;
				
				if ( is_single() ) {				
					$ignore_global = skin_get_meta( 'skin_ignore_global' );
				
					if ( 'ignore' === $ignore_global ) {
						if ( 'drop-caps' === skin_get_meta( 'skin_drop_caps' ) ) {
							$dropcaps = true;
						}
						
						if ( 'enlarge-media' === skin_get_meta( 'skin_enlarge_media' ) ) {
							$enlarge_media = true;
						}
						
					} else {
						if ( true === get_theme_mod( 'skin_drop_caps', false ) ) {
							$dropcaps = true;
						}
						
						if ( true === get_theme_mod( 'skin_enlarge_media', true ) ) {
							$enlarge_media = true;
						}
					}
				}
				
				if ( is_page() ) {
					if ( 'drop-caps' === skin_get_meta( 'skin_drop_caps' ) ) {
						$dropcaps = true;
					}
					
					if ( 'enlarge-media' === skin_get_meta( 'skin_enlarge_media' ) ) {
						$enlarge_media = true;
					}
				}			
				
				if ( is_home() || is_archive() || is_search() ) {
					$post_format = get_post_format();
					$layout = skin_get_layout_type();
					
					$classes[] = 'hover-trigger';
					
					if ( ( false !== strpos( $layout, 'masonry' ) ) && ( 'image' === $post_format ) ) {
						$classes[] = 'square';
					}
				
					if ( is_home() && in_array( get_the_ID(), skin_get_trendy_posts() ) ) {
						$classes[] = 'trendy';
					}
				}
				
				if ( $dropcaps ) {
					$classes[] = 'drop-caps';
				}
				
				if ( $enlarge_media ) {
					$classes[] = 'enlarge-media';
				}
			}
			
			return $classes;
		}
	endif;
	
//	2.3 Custom widget classes
	add_filter( 'dynamic_sidebar_params', 'skin_widget_classes' );
	
	if ( ! function_exists( 'skin_widget_classes' ) ) :
		function skin_widget_classes( $params ) {
			global $wp_registered_widgets;
			
			$classes = array();			
			$sidebar_id = $params[0]['id'];			
			$widget_id   = $params[0]['widget_id'];
			$instance_id = $params[1]['number'];
			$settings    = $wp_registered_widgets[$widget_id]['callback'][0]->get_settings();
			$base_name    = $wp_registered_widgets[$widget_id]['callback'][0]->id_base;
			
			if ( empty( $settings[ $instance_id ] ) ) {
				return $params;
			}
			
			if ( 'sidebar-specials' != $sidebar_id ) {
				$loaders = array( 'skin_audio_video', 'skin_fb_badge' );
				
				if ( in_array( $base_name, $loaders ) ) {			
					$classes[] = 'loading-holder';
					$classes[] = 'promised';
				}
			}
			
			if ( 'categories' == $base_name ) {			
				if ( !empty( $settings[$instance_id]['hide_uncategorized'] ) ) {
					if ( 1 == $settings[$instance_id]['hide_uncategorized'] ) {
						$classes[] = 'hide-uncat';
					}
				}
			}
			
			if ( !empty( $settings[$instance_id]['widget_bgr'] ) ) {
				if ( 'gradient' === $settings[$instance_id]['widget_bgr'] ) {
					$classes[] = 'gradient-bgr';
					$classes[] = 'txt-on-gradient';
				}
				
				if ( 'no-bgr' === $settings[$instance_id]['widget_bgr'] ) {
					$classes[] = 'no-bgr';
				}
			}

			if ( empty( $classes ) ) {
				return $params;
			}

			$params[0]['before_widget'] = str_replace(
				'class="',
				'class="' . join( ' ', $classes ) . ' ',
				$params[0]['before_widget']
			);

			return $params;
		}
	endif;
	
	
/*	3.0 CUSTOM COLUMNS FOR ADMIN SCREENS
=========================================== */
//	3.1 Custom column for posts: Post featured image
	add_filter( 'manage_post_posts_columns', 'skin_add_posts_col_featured_img', 5 );
	
	if ( ! function_exists( 'skin_add_posts_col_featured_img' ) ) :
		function skin_add_posts_col_featured_img( $columns ) {
			$b = array_slice( $columns , 0, 2 );
			$a = array_slice( $columns , 2 );
			
			$c['skin_posts_col_featured_img'] = esc_html__( 'Featured image', 'skin' );
			
			$columns = array_merge( $b, $c, $a );

			return $columns;
		}
	endif;

	add_action( 'manage_post_posts_custom_column', 'skin_posts_col_featured_img', 5, 2 );
	
	if ( ! function_exists( 'skin_posts_col_featured_img' ) ) :
		function skin_posts_col_featured_img( $column_name, $post_id ) {
			if ( 'skin_posts_col_featured_img' === $column_name ) :
				if ( get_the_post_thumbnail( $post_id, 'thumbnail' ) ) {
					printf(
						'<table class="skin-img-row"><tr><td style="background-image:url(%2$s)"><span>%1$s</span></td></tr></table>',
						esc_html__( 'Single post', 'skin' ),
						esc_url( skin_get_giffy_featured_img_url( $post_id, 'skin_small' ) )
					);
				}
				
				if ( $img_id = get_post_meta( $post_id, 'skin_post_img_in_list', true ) ) {
					printf(
						'<table class="skin-img-row"><tr><td style="background-image:url(%2$s)"><span>%1$s</span></td></tr></table>',
						esc_html__( 'Posts list', 'skin' ),
						esc_url( skin_get_giffy_attachment_url( $img_id, 'skin_small' ) )
					);
				}
				
				if ( $img_id = get_post_meta( $post_id, 'skin_post_img_in_slider', true ) ) {
					printf(
						'<table class="skin-img-row"><tr><td style="background-image:url(%2$s)"><span>%1$s</span></td></tr></table>',
						esc_html__( 'Posts slider', 'skin' ),
						esc_url( skin_get_giffy_attachment_url( $img_id, 'skin_small' ) )
					);
				}
				
				if ( $img_id = get_post_meta( $post_id, 'skin_post_tiny_gif', true ) ) {
					printf(
						'<table class="skin-img-row"><tr><td style="background-image:url(%2$s)"><span>%1$s</span></td></tr></table>',
						esc_html__( 'Tiny', 'skin' ),
						esc_url( skin_get_giffy_attachment_url( $img_id, 'skin_small' ) )
					);
				}
			endif;
		}
	endif;
	
//	3.2 Custom column for posts: Post ID
	add_filter( 'manage_post_posts_columns', 'skin_add_posts_col_id', 5 ); 
	
	if ( ! function_exists( 'skin_add_posts_col_id' ) ) :
		function skin_add_posts_col_id( $columns ){
			$b = array_slice( $columns , 0, 3 );
			$a = array_slice( $columns , 3 );
			
			$c['skin_posts_col_id'] = esc_html__( 'Post ID', 'skin' );
			
			$columns = array_merge( $b, $c, $a );

			return $columns;
		}
	endif;

	add_action( 'manage_post_posts_custom_column', 'skin_posts_col_id', 5, 2 );
	
	if ( ! function_exists( 'skin_posts_col_id' ) ) :
		function skin_posts_col_id( $column_name, $post_id ) {
			if ( 'skin_posts_col_id' === $column_name ) :				
				echo absint( $post_id );
			endif;
		}
	endif;
	
//	3.3 Custom column for categories and tags: Category/Tag ID
	add_filter( 'manage_edit-category_columns', 'skin_add_tax_col_id' );
	add_filter( 'manage_edit-post_tag_columns', 'skin_add_tax_col_id' );
	
	if ( ! function_exists( 'skin_add_tax_col_id' ) ) :
		function skin_add_tax_col_id( $columns ) {
			$b = array_slice( $columns , 0, 2 );
			$a = array_slice( $columns , 2 );
			
			$c['skin_tax_col_id'] = esc_html__( 'ID', 'skin' );
			
			$columns = array_merge( $b, $c, $a );

			return $columns;
		}
	endif;
	
	add_action( 'manage_category_custom_column', 'skin_tax_col_id', 10, 3 );
	add_action( 'manage_post_tag_custom_column', 'skin_tax_col_id', 10, 3 );
	
	if ( ! function_exists( 'skin_tax_col_id' ) ) :  
		function skin_tax_col_id( $value, $column_name, $tax_id ) {
			if ( 'skin_tax_col_id' === $column_name ) :
				echo absint( $tax_id );
			endif;
		}
	endif;
	
//	3.4 Custom column for categories: Color
	add_filter( 'manage_edit-category_columns', 'skin_add_cat_col_color' );
	
	if ( ! function_exists( 'skin_add_cat_col_color' ) ) :
		function skin_add_cat_col_color( $columns ) {
			$b = array_slice( $columns , 0, 3 );
			$a = array_slice( $columns , 3 );
			
			$c['skin_cat_col_color'] = esc_html__( 'Color', 'skin' );
			
			$columns = array_merge( $b, $c, $a );

			return $columns;
		}
	endif;
	
	add_action( 'manage_category_custom_column', 'skin_cat_col_color', 10, 3 );
	
	if ( ! function_exists( 'skin_cat_col_color' ) ) :  
		function skin_cat_col_color( $value, $column_name, $tax_id ) {
			if ( 'skin_cat_col_color' === $column_name ) :				
				$cat = get_category( $tax_id );
				$slug = $cat->slug;
				$color = get_theme_mod( 'skin_colors_cat_'.$slug, '#f18597' );
				
				printf(
					'<div style="%1$s background-color:%2$s;"></div>',
					esc_attr( 'width: 16px; height: 16px; margin-top: 4px; webkit-border-radius:50%; -moz-border-radius:50%; border-radius:50%; overflow:hidden; color:#fff;' ),
					esc_attr( $color )
				);
			endif;
		}
	endif;
	
//	3.5 Custom column for users: User ID
	add_filter( 'manage_users_columns' , 'skin_add_users_col_id' );

	if ( ! function_exists( 'skin_add_users_col_id' ) ) :  
		function skin_add_users_col_id( $columns ) {
			$b = array_slice( $columns , 0, 3 );
			$a = array_slice( $columns , 3 );
			
			$c['skin_users_col_id'] = esc_html__( 'ID', 'skin' );
			
			$columns = array_merge( $b, $c, $a );

			return $columns;
		}
	endif;
	
	add_action( 'manage_users_custom_column', 'skin_users_col_id', 10, 3 );
	
	if ( ! function_exists( 'skin_users_col_id' ) ) :  
		function skin_users_col_id( $value, $column_name, $user_id ) {
			if ( 'skin_users_col_id' === $column_name ) :
				return $user_id;
			endif;
		}
	endif;
	
/*	4.0 MODIFY OUTPUT FOR EXISTENT ITEMS
========================================== */
//	4.1 Modify tag cloud
	add_filter( 'widget_tag_cloud_args', 'skin_normalize_tag_cloud' );
	
	if( ! function_exists( 'skin_normalize_tag_cloud' ) ) :
		function skin_normalize_tag_cloud( $args ) {
			$args['largest'] 	= 15;
			$args['smallest'] 	= 15;
			$args['unit'] 		= 'px';
			$args['separator'] 	= '';
			$args['link'] 		= 'view';
			
			return $args;
		}
	endif;
	
//	4.2 Modify gallery output to show the slider instead of thumbnails
	if ( "skin-gallery-slider" === get_theme_mod( 'skin_post_galleries', 'skin-gallery-slider' ) ) {
		add_filter( 'post_gallery', 'skin_thumbs_to_slider', 10, 3 );
	}
	
	if ( ! function_exists( 'skin_thumbs_to_slider' ) ) :
		function skin_thumbs_to_slider( $out, $attr ) {
			global $post;

			if ( isset( $attr['orderby'] ) ) {
				$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
				
				if ( !$attr['orderby'] ) {
					unset($attr['orderby']);
				}
			}
			
			extract( shortcode_atts(
				array(
					'order'		=> 'ASC',
					'orderby'	=> 'post__in',
					'id'		=> $post->ID,
					'size' 		=> 'skin_small',
					'include' 	=> '',
					'exclude' 	=> ''
				), $attr )
			);

			$id = intval($id);
			
			if ( 'RAND' === $order ) {
				$orderby = 'none';
			}
			
			if ( !empty( $include ) ) {
				$include = preg_replace( '/[^0-9,]+/', '', $include );
				$_attachments = get_posts(
					array(
						'include'			=> $include,
						'post_status'		=> 'inherit',
						'post_type' 		=> 'attachment',
						'post_mime_type'	=> 'image',
						'order' 			=> $order,
						'orderby' 			=> $orderby
					)
				);

				$attachments = array();
				
				foreach ( $_attachments as $key => $val ) {
					$attachments[$val->ID] = $_attachments[$key];
				}
			}

			if ( empty( $attachments ) ) {
				return '';
			}
			
			$enlarge = '';
			
			if ( isset( $attr['size'] ) && "skin_wrapper_width" === $attr['size'] ) {
				$enlarge = "enlarged";
			}
		
		// Open the gallery container
			$out .= '<div class="skin-gallery '. $enlarge .'">';
		
		// Open the slider container
			$out .= '<div class="skin-gallery-slider swiper-container">';
			
		// Open the slider wrapper
			$out .= '<div class="swiper-wrapper">';
			
			// Loop through the images
				foreach ( $attachments as $id => $attachment ) {
					$img_url = skin_get_giffy_attachment_url( $id, 'skin_wrapper_width' );
					
			// Open the slide wrapper
					$out .= sprintf(
						'<div class="swiper-slide bgr-contain" style="background-image:url(\'%s\');"></div>',
						esc_url( $img_url )
					);
					
			// End the loop
				}
			
		// Close the slider wrapper
			$out .= '</div>';
			
		// Add the navigation buttons
			$out .= '<div class="swiper-button-white swiper-button-prev"></div>';
			$out .= '<div class="swiper-button-white swiper-button-next"></div>';
			
		// Close the slider container
			$out .= '</div>';			
		
		// Open the thumbnails conatiner container
			$out .= '<div class="skin-gallery-thumbs clearfix">';
			
		// Loop through the same images to generate the thumbnails
			foreach ( $attachments as $id => $attachment ) {					
				$img_src = wp_get_attachment_image_src( $id, 'skin_small' );
				$img_url = $img_src[0];
				
		// Open the slide wrapper
				$out .= sprintf(
					'<div class="gallery-thumb bgr-cover" style="background-image:url(\'%s\');"></div>',
					esc_url( $img_url )
				);				
		// End the loop
			}
			
		// Close the thumbnails container
			$out .= '</div>';
			
		// Close the gallery container
			$out .= '</div>';
			
		// Return the gallery slider
			return $out;
		}
	endif;
	
/* 4.3 Modify embedded items in post content */
	add_filter( 'embed_oembed_html', 'skin_wrap_content_media', 99, 4 );

	if ( ! function_exists( 'skin_wrap_content_media' ) ) :
		function skin_wrap_content_media( $html, $url, $attr, $post_id ) {
			return '<div class="skin-embed-holder promised">' . $html . skin_loading_content() . '</div>';
		}
	endif;	
	
//	4.4 Modify category widget
	add_filter( 'widget_categories_args', 'skin_widget_categories_args', 10, 1 );
	add_filter( 'widget_categories_dropdown_args', 'skin_widget_categories_args', 10, 1 );
	
	if( ! function_exists( 'skin_widget_categories_args' ) ) :
		function skin_widget_categories_args( $cat_args ) {
			$exclude_arr = array();
			
			if ( isset( $cat_args['exclude'] ) && !empty( $cat_args['exclude'] ) ) {
				$exclude_arr = array_unique( array_merge( explode( ',', $cat_args['exclude'] ), $exclude_arr ) );
			}
			
			if ( $hide_cats = get_theme_mod( 'skin_sidebars_cats_widget_hide_cats' ) ) {
				$exclude_arr = array_unique( array_merge( explode( ',', $hide_cats ), $exclude_arr ) );
			}
			
			$cat_args['exclude'] = implode( ',', $exclude_arr );
			
			return $cat_args;
		}
	endif;
	
/*	5.0 AJAX CALLS
===================== */
//	5.1 Fetching results for Quick Search Overlay
	add_action( 'wp_ajax_nopriv_skin_ajax_quick_search', 'skin_ajax_quick_search' );
	add_action( 'wp_ajax_skin_ajax_quick_search', 'skin_ajax_quick_search' );
	
	if ( ! function_exists( 'skin_ajax_quick_search' ) ) :
		function skin_ajax_quick_search() {
			get_template_part( 'template-parts/search', 'results' );

			exit;
		}
	endif;
	
/*	6.0 ADDITIONS TO HEAD TAG
================================ */
//	6.1 Add a pingback url auto-discovery header for singularly identifiable articles
	add_action( 'wp_head', 'skin_pingback_header' );
	
	if ( ! function_exists( 'skin_pingback_header' ) ) :
		function skin_pingback_header() {
			if ( is_singular() && pings_open( get_queried_object() ) ) {
				printf(
					'<link rel="pingback" href="%s">',
					get_bloginfo( 'pingback_url', 'display' )
				);
			}
		}
	endif;
	
//	6.2 Open Graph meta tags
	if ( true === get_theme_mod( 'skin_open_graph', false ) ) {
		if ( ! function_exists( 'skin_add_og_xml_ns' ) ) :
			function skin_add_og_xml_ns( $content ) {
				return ' xmlns:og="http://ogp.me/ns#" ' . $content;
			}
		endif;
		
		add_filter( 'language_attributes', 'skin_add_og_xml_ns' );

		if ( ! function_exists( 'skin_add_fb_xml_ns' ) ) :
			function skin_add_fb_xml_ns( $content ) {
				return ' xmlns:fb="https://www.facebook.com/2008/fbml" ' . $content;
			}
		endif;
		
		add_filter( 'language_attributes', 'skin_add_fb_xml_ns' );

		if ( ! function_exists( 'skin_og_meta_tags' ) ) :
			function skin_og_meta_tags() {
				echo '<meta property="fb:app_id" content="966242223397117" />';
				
				$thumb_src = '';
				$site_title = get_bloginfo( 'name' );
				
				if ( is_singular() ) {
					$url = get_the_permalink( get_the_ID() );
					$title = get_the_title( get_the_ID() );
					$desc = get_the_excerpt( get_the_ID() );
				
					if ( has_post_thumbnail( get_the_ID() ) ) {
						$thumb_src = skin_get_giffy_featured_img_url( get_the_ID() );
						
					} else if ( get_theme_mod( 'skin_open_graph_img' ) ) {
						$thumb_src = get_theme_mod( 'skin_open_graph_img' );
					}
					
				} else {
					global $wp;
					$url = home_url( add_query_arg( array(), $wp->request ) );
					$title = get_bloginfo( 'name' );
					$desc = get_bloginfo( 'description' );
					
					if ( get_theme_mod( 'skin_open_graph_img' ) ) {
						$thumb_src = get_theme_mod( 'skin_open_graph_img' );
					}
				}
				
				echo '<meta property="og:url" content="' . esc_url( $url ) . '"/>';
				echo '<meta property="og:type" content="article"/>';
				echo '<meta property="og:title" content="' . esc_attr( $title ) . '"/>';
				echo '<meta property="og:description" content="'. strip_tags( $desc ) .'" />';
				echo '<meta property="og:site_name" content="' . esc_attr( $site_title ) . '"/>';
				
				echo '<meta name="twitter:card" content="summary" />';
				echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">';
				echo '<meta name="twitter:description" content="'. strip_tags( $desc ) .'">';
				
				if( '' !== $thumb_src ) {
					echo '<meta property="og:image" content="' . esc_url( $thumb_src ) . '"/>';				
					echo '<meta property="og:image:width" content="1200"/>';
					
					echo '<meta name="twitter:image" content="' . esc_url( $thumb_src ) . '">';
				}
				
			}
		endif;
		
		add_action( 'wp_head', 'skin_og_meta_tags', 5 );
	}
	
/*	7.0 PERFORMANCE
================================ */
//	7.1 Disable WP Emoji
	if ( true === get_theme_mod( 'skin_opt_no_emojis', false ) ) {
		add_action( 'init', 'skin_disable_emojis', 4 );		
	}
	
	if ( ! function_exists( 'skin_disable_emojis' ) ) :
		function skin_disable_emojis() {
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
			remove_action( 'admin_print_styles', 'print_emoji_styles' );
			remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
			remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
			remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
			add_filter( 'tiny_mce_plugins', 'skin_disable_emojis_tinymce' );

			/* Remove DNS prefetch s.w.org (used for emojis, since WP 4.7) */
			add_filter( 'emoji_svg_url', '__return_false' );

			if ( get_site_option( 'initial_db_version' ) >= 32453 ) {
			/* Remove the ASCII to smiley convertion */
				remove_action( 'init', 'smilies_init', 5 );
			}
		}
	endif;

	if ( ! function_exists( 'skin_disable_emojis_tinymce' ) ) :
		function skin_disable_emojis_tinymce( $plugins ) {
			if ( is_array( $plugins ) ) {
				return array_diff( $plugins, array( 'wpemoji' ) );
				
			} else {
				return array();
			}
		}
	endif;
	
//	7.2 Remove query string from static files
	if ( true === get_theme_mod( 'skin_opt_no_queries_on_static_files', false ) ) {
		add_filter( 'style_loader_src', 'skin_remove_cssjs_ver', 10, 2 );
		add_filter( 'script_loader_src', 'skin_remove_cssjs_ver', 10, 2 );
	}

	if ( ! function_exists( 'skin_remove_cssjs_ver' ) ) :
		function skin_remove_cssjs_ver( $src ) {
			if ( strpos( $src, '?ver=' ) ) {
				$src = remove_query_arg( 'ver', $src );
			}
			
			return $src;
		}
	endif;
?>