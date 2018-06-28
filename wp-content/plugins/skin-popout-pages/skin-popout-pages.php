<?php /* =======================================================================
	Plugin Name:    Skin Popout Pages
	Description:    Custom post type for displaying a content in lightbox mode
	Version:		1.2
	Author:         NordWood Themes
	Author URI:		http://nordwoodthemes.com/
	Text Domain:	skin-popout-pages
================================================================================ */
/* Create "Popout" post type
============================== */
	add_action( 'init', 'skin_popout_init' );
	
	if ( ! function_exists( 'skin_popout_init' ) ) :
		function skin_popout_init() {
			$labels = array(
				'name'               => esc_html_x( 'Popout page', 'post type general name', 'skin-popout-pages' ),
				'singular_name'      => esc_html_x( 'Popout page', 'post type singular name', 'skin-popout-pages' ),
				'menu_name'          => esc_html_x( 'Popout pages', 'admin menu', 'skin-popout-pages' ),
				'name_admin_bar'     => esc_html_x( 'Popout page', 'add new on admin bar', 'skin-popout-pages' ),
				'add_new'            => esc_html_x( 'Add New', 'add new', 'skin-popout-pages' ),
				'add_new_item'       => esc_html__( 'New Popout page', 'skin-popout-pages' ),
				'new_item'           => esc_html__( 'New Popout page', 'skin-popout-pages' ),
				'edit_item'          => esc_html__( 'Edit Popout page', 'skin-popout-pages' ),
				'view_item'          => esc_html__( 'View Popout page', 'skin-popout-pages' ),
				'all_items'          => esc_html__( 'Popout pages', 'skin-popout-pages' ),
				'search_items'       => esc_html__( 'Search Popout pages', 'skin-popout-pages' ),
				'parent_item_colon'  => esc_html__( 'Parent Popout pages:', 'skin-popout-pages' ),
				'not_found'          => esc_html__( 'No Popout pages found.', 'skin-popout-pages' ),
				'not_found_in_trash' => esc_html__( 'No Popout pages found in Trash.', 'skin-popout-pages' )
			);

			$args = array(
				'labels'              => $labels,
				'has_archive'		  => false,
				'public'              => true,
				'exclude_from_search' => true,
				'show_in_nav_menus'   => true,
				'show_in_menu'        => true,
				'query_var'           => true,
				'rewrite'             => array( 'slug' => 'popout' ),
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'menu_position'       => 5,
				'menu_icon'			  => 'dashicons-testimonial',
				'supports'            => array( 'title', 'editor', 'thumbnail' ),
				'taxonomies'		  => array( 'post_tag' )
			);

			register_post_type( 'popout', $args );
		}
	endif;
	
/* Rewrite flush
================== */
	register_activation_hook( __FILE__, 'skin_popout_rewrite_flush' );	
	
	if ( ! function_exists( 'skin_popout_rewrite_flush' ) ) :
		function skin_popout_rewrite_flush() {
			skin_popout_init();
			flush_rewrite_rules();
		}
	endif;
	
/* WP messages
================ */
	add_filter( 'post_updated_messages', 'skin_popout_update_messages' );
	
	if ( ! function_exists( 'skin_popout_update_messages' ) ):
		function skin_popout_update_messages( $messages ) {
			global $post;

			$post_ID = $post->ID;
			$post_type = get_post_type( $post_ID );

			$obj = get_post_type_object( $post_type );
			$singular = $obj->labels->singular_name;

			$messages[$post_type] = array(
				0 => '',
				1 => sprintf(
						wp_kses(
							__( '%1$s updated. <a href="%2$s" target="_blank">View %3$s</a>', 'skin-popout-pages' ),
							array( 'a' => array( 'href' => array(), 'target' => array() ) )
						),
						esc_attr( $singular ),
						esc_url( get_permalink( $post_ID ) ),
						strtolower( $singular )
					),
				2 => esc_html__( 'Custom field updated.', 'skin-popout-pages' ),
				3 => esc_html__( 'Custom field deleted.', 'skin-popout-pages' ),
				4 => sprintf(
						esc_html__( '%s updated.', 'skin-popout-pages' ),
						esc_attr( $singular )
					),
				5 => isset( $_GET['revision']) ?
						sprintf(
							esc_html__( '%2$s restored to revision from %1$s', 'skin-popout-pages' ),
							wp_post_revision_title( (int) $_GET['revision'], false ),
							esc_attr( $singular )
						) :
						false,
				6 => sprintf(
						wp_kses(
							__( '%1$s published. <a href="%2$s" target="_blank">View %3$s</a>', 'skin-popout-pages' ),
							array( 'a' => array( 'href' => array(), 'target' => array() ) )
						),
						$singular,
						esc_url( get_permalink( $post_ID ) ),
						strtolower( $singular )
					),
				7 => sprintf(
						esc_html__( '%s saved.', 'skin-popout-pages' ),
						esc_attr( $singular )
					),
				8 => sprintf(
						wp_kses(
							__( '%1$s submitted. <a href="%2$s" target="_blank">Preview %3$s</a>', 'skin-popout-pages' ),
							array( 'a' => array( 'href' => array(), 'target' => array() ) )
						),
						$singular,
						esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ),
						strtolower( $singular )
					),
				9 => sprintf(
						wp_kses(
							__( '%1$s scheduled for: <strong>%2$s</strong>. <a href="%3$s" target="_blank">Preview %4$s</a>', 'skin-popout-pages' ),
							array(
								'strong' => array(),
								'a' => array( 'href' => array(), 'target' => array() )
							)
						),
						$singular,
						date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ),
						esc_url( get_permalink( $post_ID ) ),
						strtolower( $singular )
					),
				10 => sprintf(
						wp_kses(
							__( '%1$s draft updated. <a href="%2$s" target="_blank">Preview %3$s</a>', 'skin-popout-pages' ),
							array( 'a' => array( 'href' => array(), 'target' => array() ) )
						),						
						$singular,
						esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ),
						strtolower( $singular )
					)
			);

			return $messages;
		}
	endif;
	
/* Get custom fields
====================== */
	if ( ! function_exists( 'skin_popout_get_meta' ) ):
		function skin_popout_get_meta( $value ) {
			global $post;

			$field = get_post_meta( $post->ID, $value, true );
			if ( ! empty( $field ) ) {
				return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
				
			} else {
				return false;
			}
		}
	endif;

/* Create meta boxes
====================== */
	add_action( 'add_meta_boxes', 'skin_popout_add_meta_box' );
	
	if ( ! function_exists( 'skin_popout_add_meta_box' ) ):
		function skin_popout_add_meta_box() {
			add_meta_box(
				'skin_popout_pages_meta_box-skin-popout-pages-meta-boxes',
				esc_html__( 'Options', 'skin-popout-pages' ),
				'skin_popout_html',
				'popout',
				'normal',
				'default'
			);
		}
	endif;

/* Create custom fields
========================= */
	if ( ! function_exists( 'skin_popout_html' ) ):
		function skin_popout_html( $post) {
			wp_nonce_field( '_skin_popout_html_nonce', 'skin_popout_html_nonce' );
		?>			
			<div class="skin-metabox-section">
				<fieldset>
					<h5><strong><?php esc_html_e( 'Featured image position', 'skin-popout-pages' ); ?></strong></h5>

					<input type="radio"
						name="skin_popout_img_position"
						id="skin_popout_img_position_0"
						value="img-top"
						checked <?php echo ( 'img-top' === skin_popout_get_meta( 'skin_popout_img_position' ) ) ? 'checked' : ''; ?>
					>
					<label for="skin_popout_img_position_0"><?php esc_html_e( 'top', 'skin-popout-pages' ); ?></label>

					<input type="radio"
						name="skin_popout_img_position"
						id="skin_popout_img_position_1"
						value="img-right"
						<?php echo ( 'img-right' === skin_popout_get_meta( 'skin_popout_img_position' ) ) ? 'checked' : ''; ?>
					>
					<label for="skin_popout_img_position_1"><?php esc_html_e( 'right', 'skin-popout-pages' ); ?></label>
				</fieldset>
				
				<fieldset>
					<h5><strong><?php esc_html_e( 'Featured image shape', 'skin-popout-pages' ); ?></strong></h5>
					
					<input type="radio"
						name="skin_popout_img_shape"
						id="skin_popout_img_shape_0"
						value="img-natural"
						checked <?php echo ( 'img-natural' === skin_popout_get_meta( 'skin_popout_img_shape' ) ) ? 'checked' : ''; ?>
					>
					<label for="skin_popout_img_shape_0"><?php esc_html_e( 'natural', 'skin-popout-pages' ); ?></label>

					<input type="radio"
						name="skin_popout_img_shape"
						id="skin_popout_img_shape_1"
						value="img-circle"
						<?php echo ( 'img-circle' === skin_popout_get_meta( 'skin_popout_img_shape' ) ) ? 'checked' : ''; ?>
					>
					<label for="skin_popout_img_shape_1"><?php esc_html_e( 'circle', 'skin-popout-pages' ); ?></label>				
				</fieldset>
				
				<fieldset>
					<p><label for="skin_popout_img_link"><?php esc_html_e( 'Featured image links to (insert URL):', 'skin-popout-pages' ); ?></label>
					<input type="url" class="widefat"
						name="skin_popout_img_link"
						id="skin_popout_img_link"
						value="<?php echo esc_url_raw( skin_popout_get_meta( 'skin_popout_img_link' ) ); ?>"
					></p>
					
					<input type="checkbox"
						name="skin_popout_img_link_new_tab"
						id="skin_popout_img_link_new_tab"
						value="new-tab"
						<?php echo ( 'new-tab' === skin_popout_get_meta( 'skin_popout_img_link_new_tab' ) ) ? 'checked' : ''; ?>
					>
					<label for="skin_popout_img_link_new_tab"><?php esc_html_e( 'Open link in new tab', 'skin-popout-pages' ); ?></label>
				</fieldset>
				
				<fieldset>
					<h4><?php esc_html_e( 'Featured image for widget and special box', 'skin-popout-pages' ); ?></h4>
					<p class="small"><?php esc_html_e( 'If no image is uploaded, featured image will be used.', 'skin-popout-pages' ); ?></p>
					
					<div class="img-upload-wrapper clearfix">
						<div class="img-preview"><?php
							if ( '' != skin_popout_get_meta( 'skin_popout_img_preview' ) ) {
								echo wp_get_attachment_image( skin_popout_get_meta( 'skin_popout_img_preview' ), 'thumbnail' );
							}
						?></div>
						
						<input type="hidden" class="img-id"
							name="skin_popout_img_preview"
							id="skin_popout_img_preview"						
							value="<?php echo esc_attr( skin_popout_get_meta( 'skin_popout_img_preview' ) ); ?>"
						>				
						
						<input type="button" class="button upload-img <?php if( '' != skin_popout_get_meta( 'skin_popout_img_preview' ) ) echo 'hidden'; ?>"
							name="skin_popout_img_preview_upload"
							id="skin_popout_img_preview_upload"
							value="<?php esc_attr_e( 'Upload image', 'skin-popout-pages' ); ?>"
						>
						
						<input type="button" class="button remove-img <?php if( '' == skin_popout_get_meta( 'skin_popout_img_preview' ) ) echo 'hidden'; ?>"
							name="skin_popout_img_preview_remove"
							id="skin_popout_img_preview_remove"
							value="<?php esc_attr_e( 'Remove image', 'skin-popout-pages' ); ?>"
						>
					</div>
				</fieldset>
			</div>
			
			<div class="skin-metabox-section">
				<h4><?php esc_html_e( 'Auto popout', 'skin-popout-pages' ); ?></h4>
				<fieldset>
					<input type="checkbox"
						name="skin_popout_on_load"
						id="skin_popout_on_load"
						value="on-load"
						<?php echo ( 'on-load' === skin_popout_get_meta( 'skin_popout_on_load' ) ) ? 'checked' : ''; ?>
					>
					<label for="skin_popout_on_load"><h5><?php esc_html_e( 'Show on site load', 'skin-popout-pages' ); ?></h5></label>
				
					<p><label for="skin_popout_on_load_timeout"><?php esc_html_e( 'Show pop-out X seconds after the site loads', 'skin-popout-pages' ); ?></label>
					<input type="number"
						name="skin_popout_on_load_timeout"
						id="skin_popout_on_load_timeout"
						placeholder="0"
						value="<?php echo absint( skin_popout_get_meta( 'skin_popout_on_load_timeout' ) ); ?>"
					></p>
				
					<p><label for="skin_popout_on_load_expire"><?php esc_html_e( 'Show pop-out again in X hours', 'skin-popout-pages' ); ?></label>
					<input type="number"
						name="skin_popout_on_load_expire"
						id="skin_popout_on_load_expire"
						placeholder="24"
						value="<?php echo absint( skin_popout_get_meta( 'skin_popout_on_load_expire' ) ); ?>"
					></p>
					
					<input type="checkbox"
						name="skin_popout_on_load_skip_front"
						id="skin_popout_on_load_skip_front"
						value="skip-front"
						<?php echo ( 'skip-front' === skin_popout_get_meta( 'skin_popout_on_load_skip_front' ) ) ? 'checked' : ''; ?>
					>
					<label for="skin_popout_on_load_skip_front"><h5><?php esc_html_e( 'Do not show on Front Page', 'skin-popout-pages' ); ?></h5></label>
					
					<p><?php esc_html_e( 'The options above control appearing of popout, when the site is visited by landing on any of its post, page, posts list etc. To bind popout to particular pages / category archives only, use the Advanced settings below.', 'skin-popout-pages' ); ?></p>
					
					<h4><?php esc_html_e( 'Advanced settings for auto popout', 'skin-popout-pages' ); ?></h4>
					
					<input type="checkbox"
						name="skin_popout_on_selected"
						id="skin_popout_on_selected"
						value="on-selected"
						<?php echo ( 'on-selected' === skin_popout_get_meta( 'skin_popout_on_selected' ) ) ? 'checked' : ''; ?>
					>
					<label for="skin_popout_on_selected"><h5><?php esc_html_e( 'Show only on specific pages / category archives', 'skin-popout-pages' ); ?></h5></label>
					
					<h5><?php esc_html_e( 'Make this popout load on particular pages only.', 'skin-popout-pages' ); ?></h5>
					<p><?php esc_html_e( 'Select the pages on which you want this popout to show up.', 'skin-popout-pages' ); ?></p>
					
					<div class="skin-pages-list">
					<?php
						$p_pages = skin_popout_get_meta( 'skin_popout_on_load_pages' );
						$p_pages = explode( ',', $p_pages );						
						array_pop( $p_pages );
					
						$pages = get_pages();
						
						foreach( $pages as $page ) {
							$page_id = $page->ID;
							$page_name = $page->post_name;
							
							if( in_array( $page_id, $p_pages ) ) {
								$page_on = "on";
								
							} else {
								$page_on = "off";
							}
					?>
						<span class="skin-choose-page va-middle">
							<span class="skin-page" data-page-id=<?php echo esc_attr( $page_id ); ?> data-page-on=<?php echo esc_attr( $page_on ); ?>><?php echo esc_html( $page_name ); ?></span>		
						</span>
					<?php
						}
					?>
						<input type="hidden"
							name="skin_popout_on_load_pages"
							id="skin_popout_on_load_pages"
							value="<?php echo esc_attr( skin_popout_get_meta( 'skin_popout_on_load_pages' ) ); ?>"
						>
					</div>
					
					<h5><?php esc_html_e( 'Make this popout load on particular category archives only.', 'skin-popout-pages' ); ?></h5>
					<p><?php esc_html_e( 'Select the category archives on which you want this popout to show up.', 'skin-popout-pages' ); ?></p>
					
					<div class="skin-cats-list">
					<?php
						$p_cats = skin_popout_get_meta( 'skin_popout_on_load_cats' );
						$p_cats = explode( ',', $p_cats );						
						array_pop( $p_cats );
					
						$cats = get_categories();
						
						foreach( $cats as $cat ) {
							$cat_id = $cat->term_id;
							$cat_name = $cat->name;
							
							if( in_array( $cat_id, $p_cats ) ) {
								$cat_on = "on";
								
							} else {
								$cat_on = "off";
							}
					?>
						<span class="skin-choose-cat va-middle">
							<span class="skin-cat" data-cat-id=<?php echo esc_attr( $cat_id ); ?> data-cat-on=<?php echo esc_attr( $cat_on ); ?>><?php echo esc_html( $cat_name ); ?></span>		
						</span>
					<?php
						}
					?>
						<input type="hidden"
							name="skin_popout_on_load_cats"
							id="skin_popout_on_load_cats"
							value="<?php echo esc_attr( skin_popout_get_meta( 'skin_popout_on_load_cats' ) ); ?>"
						>
					</div>
				</fieldset>
			</div>
		<?php
		}
	endif;

/* Save custom fields
======================= */
	add_action( 'save_post', 'skin_popout_save_meta' );
	
	if ( ! function_exists( 'skin_popout_save_meta' ) ) :
		function skin_popout_save_meta( $post_id ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			
			if (
				! isset( $_POST['skin_popout_html_nonce'] ) || ! wp_verify_nonce( $_POST['skin_popout_html_nonce'], '_skin_popout_html_nonce' )
			) {
				return;
			}
			
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;	
			}

			if ( isset( $_POST['skin_popout_img_position'] ) ) {
				update_post_meta( $post_id, 'skin_popout_img_position', esc_attr( $_POST['skin_popout_img_position'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_popout_img_position', null );
			}

			if ( isset( $_POST['skin_popout_img_shape'] ) ) {
				update_post_meta( $post_id, 'skin_popout_img_shape', esc_attr( $_POST['skin_popout_img_shape'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_popout_img_shape', null );
			}

			if ( isset( $_POST['skin_popout_img_link'] ) ) {
				update_post_meta( $post_id, 'skin_popout_img_link', esc_url_raw( $_POST['skin_popout_img_link'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_popout_img_link', null );
			}

			if ( isset( $_POST['skin_popout_img_link_new_tab'] ) ) {
				update_post_meta( $post_id, 'skin_popout_img_link_new_tab', esc_attr( $_POST['skin_popout_img_link_new_tab'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_popout_img_link_new_tab', null );
			}
			
			if ( isset( $_POST['skin_popout_img_preview'] ) ) {
				update_post_meta( $post_id, 'skin_popout_img_preview', sanitize_text_field( $_POST['skin_popout_img_preview'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_popout_img_preview', null );
			}

			if ( isset( $_POST['skin_popout_on_load'] ) ) {
				update_post_meta( $post_id, 'skin_popout_on_load', esc_attr( $_POST['skin_popout_on_load'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_popout_on_load', null );
			}

			if ( isset( $_POST['skin_popout_on_load_timeout'] ) ) {
				update_post_meta( $post_id, 'skin_popout_on_load_timeout', absint( $_POST['skin_popout_on_load_timeout'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_popout_on_load_timeout', null );
			}

			if ( isset( $_POST['skin_popout_on_load_expire'] ) ) {
				update_post_meta( $post_id, 'skin_popout_on_load_expire', absint( $_POST['skin_popout_on_load_expire'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_popout_on_load_expire', null );
			}
			
			if ( isset( $_POST['skin_popout_on_load_skip_front'] ) ) {
				update_post_meta( $post_id, 'skin_popout_on_load_skip_front', sanitize_text_field( $_POST['skin_popout_on_load_skip_front'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_popout_on_load_skip_front', null );
			}
			
			if ( isset( $_POST['skin_popout_on_selected'] ) ) {
				update_post_meta( $post_id, 'skin_popout_on_selected', sanitize_text_field( $_POST['skin_popout_on_selected'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_popout_on_selected', null );
			}
			
			if ( isset( $_POST['skin_popout_on_load_pages'] ) ) {
				update_post_meta( $post_id, 'skin_popout_on_load_pages', sanitize_text_field( $_POST['skin_popout_on_load_pages'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_popout_on_load_pages', null );
			}
			
			if ( isset( $_POST['skin_popout_on_load_cats'] ) ) {
				update_post_meta( $post_id, 'skin_popout_on_load_cats', sanitize_text_field( $_POST['skin_popout_on_load_cats'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_popout_on_load_cats', null );
			}
		}
	endif;
	
/* Custom templates
===================== */
	add_filter( 'template_include', 'skin_popout_template', 1 );
	
	if ( ! function_exists( 'skin_popout_template' ) ) :
		function skin_popout_template( $template_path ) {		
			if ( 'popout' == get_post_type() ) {
				if ( is_single() ) {
					$template_path = plugin_dir_path( __FILE__ ) . 'single-popout.php';
				}
			}
			
			return $template_path;
		}
	endif;	
	
/* Scripts & styles
===================== */
	add_action( 'admin_enqueue_scripts', 'skin_popout_admin' );
	
	if ( ! function_exists( 'skin_popout_admin' ) ):
		function skin_popout_admin( $hook ) {
			if( 'post.php' != $hook && 'post-new.php' != $hook ) {
				return;
			}
			
			wp_enqueue_media();
			
			if( ( 'skin' === wp_get_theme()->get( 'TextDomain' ) ) || ( 'skin-child' === wp_get_theme()->get( 'TextDomain' ) ) ) {
				wp_enqueue_style( 'skin_metaboxes' );
				wp_enqueue_script( 'skin_img_upload' );
				
			} else {
				wp_enqueue_style(
					'skin_popout_metaboxes',
					plugins_url( '/css/metaboxes.css' , __FILE__ )
				);
			
				wp_enqueue_script(
					'skin_popout_img_upload',
					plugins_url( '/js/img-upload.js' , __FILE__ ),
					array( 'jquery' ),
					false,
					true
				);
			}
			
			wp_enqueue_script(
				'skin_popout_metaboxes',
				plugin_dir_url( __FILE__ ) . '/js/metaboxes.js',
				array('jquery'),
				'',
				true
			);
		}
	endif;
	
	add_action( 'wp_enqueue_scripts', 'skin_popout_register' );
	
	if ( ! function_exists( 'skin_popout_register' ) ) :
		function skin_popout_register() {
			wp_enqueue_style(
				'skin_popout',
				plugins_url( '/css/popout.css' , __FILE__ )
			);
			
			wp_register_script(
				'skin_assets_images_loaded',
				plugins_url( '/assets/images-loaded/imagesloaded.pkgd.min.js' , __FILE__ ),
				array( 'jquery' ),
				'',
				true
			);
			
			wp_register_script(
				'skin_popout',
				plugins_url( '/js/popout.js' , __FILE__ ),
				array( 'jquery', 'skin_assets_images_loaded' ),
				false,
				false
			);
			
			wp_register_script(
				'skin_popout_onload',
				plugins_url( '/js/popout-onload.js' , __FILE__ ),
				array( 'jquery', 'skin_assets_images_loaded', 'skin_popout' ),
				false,
				false
			);
			
	/* Popout on load
	===================*/
		$mob_off = true === get_theme_mod( 'skin_opt_no_popout_on_mobile', false ) ? 'onload-off' : 'onload-on';
		
		/* Load popout on particular pages */
			$reserved_pages = array();
			
			$onload_pages_args = array(
				'post_type' => 'popout',
				'posts_per_page' => -1,
				'order' => 'ASC',
				'meta_query' => array(
					'relation' => 'AND',
					array(
					   'key' => 'skin_popout_on_load',
					   'value' => 'on-load',
					   'compare' => 'LIKE'
					),
					array(
					   'key' => 'skin_popout_on_selected',
					   'value' => 'on-selected',
					   'compare' => 'LIKE'
					),
					array(
					   'key' => 'skin_popout_on_load_pages',
					   'value' => '',
					   'compare' => '!='
					)
				)
			);

			$onload_pages_query = new WP_Query( $onload_pages_args );
				
			if ( $onload_pages_query->have_posts() ) :
				while ( $onload_pages_query->have_posts() ) :
					$onload_pages_query->the_post();
					
					$chosen_pages = skin_popout_get_meta( 'skin_popout_on_load_pages' );
					$chosen_pages = explode( ',', $chosen_pages );						
					array_pop( $chosen_pages );
					
					foreach( $chosen_pages as $chosen_page ) {
						$reserved_pages[] = $chosen_page;
					}
					
					if ( is_page() ) {
						$page = get_queried_object();
						$page_id = $page->ID;
						
						if ( in_array( $page_id, $chosen_pages ) ) {
							$permalink = get_permalink();
							
							$timeout = skin_popout_get_meta( 'skin_popout_on_load_timeout' ) ?
								absint( skin_popout_get_meta( 'skin_popout_on_load_timeout' ) ) :
								1;
							
							$expires = skin_popout_get_meta( 'skin_popout_on_load_expire' ) ?
								absint( skin_popout_get_meta( 'skin_popout_on_load_expire' ) ) :
								24;
				
							$on_load = array(
								'is_page'	=> true,
								'page_id'	=> $page_id,
								'is_cat'	=> false,
								'permalink'	=> $permalink,
								'timeout' 	=> $timeout,
								'expires' 	=> $expires,
								'mob_off'	=> $mob_off
							);
							
							wp_localize_script( 'skin_popout_onload', 'on_load', $on_load );
							wp_enqueue_script( 'skin_popout_onload' );
						}
					}					
				endwhile;
			endif;
		
			wp_reset_postdata();
			
			$reserved_pages = array_unique( $reserved_pages );
			
		/* Load popout on particular categories */
			$reserved_cats = array();
			
			$onload_cats_args = array(
				'post_type' => 'popout',
				'posts_per_page' => -1,
				'order' => 'ASC',
				'meta_query' => array(
					'relation' => 'AND',
					array(
					   'key' => 'skin_popout_on_load',
					   'value' => 'on-load',
					   'compare' => 'LIKE'
					),
					array(
					   'key' => 'skin_popout_on_selected',
					   'value' => 'on-selected',
					   'compare' => 'LIKE'
					),
					array(
					   'key' => 'skin_popout_on_load_cats',
					   'value' => '',
					   'compare' => '!='
					)
				)
			);

			$onload_cats_query = new WP_Query( $onload_cats_args );
				
			if ( $onload_cats_query->have_posts() ) :
				while ( $onload_cats_query->have_posts() ) :
					$onload_cats_query->the_post();
					
					$chosen_cats = skin_popout_get_meta( 'skin_popout_on_load_cats' );
					$chosen_cats = explode( ',', $chosen_cats );						
					array_pop( $chosen_cats );
					
					foreach ( $chosen_cats as $chosen_cat ) {
						$reserved_cats[] = $chosen_cat;
					}
					
					if ( is_category() ) {
						$cat = get_queried_object();
						$cat_id = $cat->term_id;
						
						if ( in_array( $cat_id, $chosen_cats ) ) {
							$permalink = get_permalink();
							
							$timeout = skin_popout_get_meta( 'skin_popout_on_load_timeout' ) ?
								absint( skin_popout_get_meta( 'skin_popout_on_load_timeout' ) ) :
								1;
							
							$expires = skin_popout_get_meta( 'skin_popout_on_load_expire' ) ?
								absint( skin_popout_get_meta( 'skin_popout_on_load_expire' ) ) :
								24;
				
							$on_load = array(
								'is_page'	=> false,
								'is_cat'	=> true,
								'cat_id'	=> $cat_id,
								'permalink'	=> $permalink,
								'timeout'	=> $timeout,
								'expires'	=> $expires,
								'mob_off'	=> $mob_off
							);
							
							wp_localize_script( 'skin_popout_onload', 'on_load', $on_load );
							wp_enqueue_script( 'skin_popout_onload' );
						}
					}					
				endwhile;
			endif;
		
			wp_reset_postdata();
			
			$reserved_cats = array_unique( $reserved_cats );			
			
		/* Load default popout on any site location, appart from reserved ones */
			if( is_category() ) {
				$q = get_queried_object();
				$q_id = $q->term_id;
			}
			
			if( is_page() ) {
				$p_id = get_the_ID();
			}
			
			if( ! (
				( is_category() && in_array( $q_id, $reserved_cats ) ) ||
				( is_page() && in_array( $p_id, $reserved_pages ) )
			) ) {
				$onload_args = array(
					'post_type' => 'popout',
					'posts_per_page' => -1,
					'order' => 'ASC',
					'meta_query' => array(
						'relation' => 'AND',
						array(
						   'key' => 'skin_popout_on_load',
						   'value' => 'on-load',
						   'compare' => 'LIKE'
						)
					)					
				);

				$onload_query = new WP_Query( $onload_args );
				
				if( $onload_query->have_posts() ) :
					while( $onload_query->have_posts() ) :
						$onload_query->the_post();
						
						if(
							'on-selected' !== skin_popout_get_meta( 'skin_popout_on_selected' ) &&
							! ( is_front_page() && 'skip-front' === skin_popout_get_meta( 'skin_popout_on_load_skip_front' ) )
						) {							
							$permalink = get_permalink();
							
							$timeout = skin_popout_get_meta( 'skin_popout_on_load_timeout' ) ?
								absint( skin_popout_get_meta( 'skin_popout_on_load_timeout' ) ) :
								1;
							
							$expires = skin_popout_get_meta( 'skin_popout_on_load_expire' ) ?
								absint( skin_popout_get_meta( 'skin_popout_on_load_expire' ) ) :
								24;
						
							$on_load = array(
								'is_page'	=> false,
								'is_cat'	=> false,
								'permalink'	=> $permalink,
								'timeout' 	=> $timeout,
								'expires' 	=> $expires,
								'mob_off'	=> $mob_off
							);
							
							wp_localize_script( 'skin_popout_onload', 'on_load', $on_load );
							wp_enqueue_script( 'skin_popout_onload' );
						}						
					endwhile;
				endif;
			
				wp_reset_postdata();
			}
			
			wp_reset_postdata();
			
			$ajaxvars = array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			);
			
			wp_localize_script( 'skin_popout', 'ajaxvars', $ajaxvars);
			wp_enqueue_script( 'skin_popout' );
		}
	endif;
	
/* Filters and hooks
====================== */
	add_filter( 'post_class', 'skin_popout_post_classes' );
	
	if ( ! function_exists( 'skin_popout_post_classes' ) ) :
		function skin_popout_post_classes( $classes ) {
			if( 'popout' === get_post_type() ) {
				$classes[] = 'clearfix';
				
				$classes[] = skin_popout_get_meta( 'skin_popout_img_position' );
				$classes[] = skin_popout_get_meta( 'skin_popout_img_shape' );
				
				if( ! get_the_content() ) {
					$classes[] = 'img-only';
				}				
			}
			
			return $classes;
		}
	endif;
?>