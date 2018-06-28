<?php /* =======================================================================
	Plugin Name:    Skin Featured Area
	Description:    Custom fields for the featured area related to post format
	Version:		1.0
	Author:         NordWood Themes
	Author URI:		http://nordwoodthemes.com/
	Text Domain:	skin-featured-area
================================================================================ */
/* Get custom fields
===================== */
	if ( ! function_exists( 'skin_featured_area_get_meta' ) ) :
		function skin_featured_area_get_meta( $value ) {
			global $post;

			$field = get_post_meta( $post->ID, $value, true );
			if( !empty( $field ) ) {
				return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
				
			} else {
				return false;
			}
		}
	endif;

/* Add meta boxes
=================== */
	add_action( 'add_meta_boxes', 'skin_featured_area_add_meta' );
	
	if ( ! function_exists( 'skin_featured_area_add_meta' ) ) :
		function skin_featured_area_add_meta() {
			add_meta_box(
				'skin_featured_area_meta_box-skin-featured-area-meta-box',
				esc_html__( 'Featured Area', 'skin-featured-area' ),
				'skin_featured_area_html',
				'post',
				'after_title',
				'high'
			);
		}
	endif;
	
/* Create custom fields
========================= */
	if ( ! function_exists( 'skin_featured_area_html' ) ) :
		function skin_featured_area_html( $post) {
			wp_nonce_field( '_skin_featured_area_nonce', 'skin_featured_area_nonce' );
		?>			
			<div id="skin-featured-image" class="skin-featured-metabox">
				<?php esc_html_e( 'Please scroll down to the "Featured Image" section to upload your photo.', 'skin-featured-area' ); ?>
			</div><!-- post format: image -->
			
			<div id="skin-featured-gallery" class="skin-featured-metabox">
				<label for="skin_featured_gallery"><?php esc_html_e( 'Gallery images', 'skin-featured-area' ); ?></label>
				
				<div class="gallery-preview clearfix"><?php
				$get_images = explode( ', ', skin_featured_area_get_meta( 'skin_featured_gallery' ) );
				
				$gall_is_array = is_array( $get_images );
				
				if( [""] == $get_images ) {
					$get_images = array();
				}
				
				if ( $gall_is_array ) :
					foreach( $get_images as $img_id ) : 
						$img_src = wp_get_attachment_image_src( $img_id, 'thumbnail' );
					?>			
						<div class="img-wrapper">
							<span class="remove-image"><span class="close-button dashicons dashicons-no-alt"></span></span>
							
							<img src="<?php echo esc_url( $img_src[0] ); ?>" class="gallery-img" />
							
							<input type="hidden" class="img-id"
								id="img-id-<?php echo absint( $img_id ); ?>"
								name="img-id-<?php echo absint( $img_id ); ?>"
								value="<?php echo absint( $img_id ); ?>"
							>
						</div>
					<?php
					endforeach;
				endif;				
				?></div>
				
				<input type="button" class="button add-images"
					id="skin_featured_area_add_to_gallery"
					name="skin_featured_area_add_to_gallery"
					value="<?php esc_attr_e( 'Add images', 'skin-featured-area' ); ?>"
				>
				
				<input type="button" class="button remove-all"
					id="skin_featured_area_remove_from_gallery"
					name="skin_featured_area_remove_from_gallery"
					value="<?php esc_attr_e( 'Remove all images', 'skin-featured-area' ); ?>"
				>
					
				<div class="gallery-data">
					<input type="hidden" class="widefat gallery-ids"
						id="skin_featured_gallery"
						name="skin_featured_gallery"
						value="<?php echo esc_attr( skin_featured_area_get_meta( 'skin_featured_gallery' ) ); ?>"
					>
				</div>
			</div><!-- post format: gallery -->
			
			<div id="skin-featured-video" class="skin-featured-metabox">
				<label for="skin_featured_video_url"><?php esc_html_e( 'Video URL', 'skin-featured-area' ); ?></label>
				<input type="url" class="widefat"
					name="skin_featured_video_url"
					id="skin_featured_video_url"
					value="<?php echo esc_url_raw( skin_featured_area_get_meta( 'skin_featured_video_url' ) ); ?>"
				>
			</div><!-- post format: video -->
			
			<div id="skin-featured-audio" class="skin-featured-metabox">
				<label for="skin_featured_audio_url"><?php esc_html_e( 'Audio URL', 'skin-featured-area' ); ?></label>
				<input type="url" class="widefat"
					name="skin_featured_audio_url"
					id="skin_featured_audio_url"		
					value="<?php echo esc_url_raw( skin_featured_area_get_meta( 'skin_featured_audio_url' ) ); ?>"
				>
			</div><!-- post format: audio -->
			
			<div id="skin-featured-link" class="skin-featured-metabox">
				<label for="skin_featured_link"><?php esc_html_e( 'Link (URL)', 'skin-featured-area' ); ?></label>
				<input type="url" class="widefat"
					name="skin_featured_link"
					id="skin_featured_link"
					value="<?php echo esc_url_raw( skin_featured_area_get_meta( 'skin_featured_link' ) ); ?>"
				>
			</div><!-- post format: link -->
			
			<div id="skin-featured-quote" class="skin-featured-metabox">
				<label for="skin_featured_quote"><?php esc_html_e( 'Quote', 'skin-featured-area' ); ?></label><br>
				<textarea class="widefat" rows="5"
					name="skin_featured_quote"
					id="skin_featured_quote"
				><?php echo esc_textarea( skin_featured_area_get_meta( 'skin_featured_quote' ) ); ?></textarea>
				
				<label for="skin_featured_quote_author"><?php esc_html_e( 'Author', 'skin-featured-area' ); ?></label><br>	
				<input type="text" class="widefat"
					name="skin_featured_quote_author"
					id="skin_featured_quote_author"
					value="<?php echo esc_attr( skin_featured_area_get_meta( 'skin_featured_quote_author' ) ); ?>"
				>		
			</div><!-- post format: quote -->
	<?php
		}
	endif;	
	
/* Updating custom fields
=========================== */
	add_action( 'save_post', 'skin_featured_area_save' );
	
	if ( ! function_exists( 'skin_featured_area_save' ) ):
		function skin_featured_area_save( $post_id ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			
			if (
				! isset( $_POST['skin_featured_area_nonce'] ) ||
				! wp_verify_nonce( $_POST['skin_featured_area_nonce'], '_skin_featured_area_nonce' )
			) {
				return;
			}
			
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

		// Video
			if ( isset( $_POST['skin_featured_video_url'] ) ) {
				update_post_meta( $post_id, 'skin_featured_video_url', esc_url_raw( $_POST['skin_featured_video_url'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_featured_video_url', null );
			}
			
		// Gallery
			if ( isset( $_POST['skin_featured_gallery'] ) ) {
				update_post_meta( $post_id, 'skin_featured_gallery', sanitize_text_field( $_POST['skin_featured_gallery'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_featured_gallery', null );
			}
		
		// Audio
			if ( isset( $_POST['skin_featured_audio_url'] ) ) {
				update_post_meta( $post_id, 'skin_featured_audio_url', esc_url_raw( $_POST['skin_featured_audio_url'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_featured_audio_url', null );
			}
		
		// Link
			if ( isset( $_POST['skin_featured_link'] ) ) {
				update_post_meta( $post_id, 'skin_featured_link', esc_url_raw( $_POST['skin_featured_link'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_featured_link', null );
			}
			
		// Quote
			if ( isset( $_POST['skin_featured_quote'] ) ) {
				update_post_meta( $post_id, 'skin_featured_quote', sanitize_text_field( $_POST['skin_featured_quote'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_featured_quote', null );
			}
			
		// Quote author
			if ( isset( $_POST['skin_featured_quote_author'] ) ) {
				update_post_meta( $post_id, 'skin_featured_quote_author', sanitize_text_field( $_POST['skin_featured_quote_author'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_featured_quote_author', null );				
			}
		}
	endif;	
	
/* Place metaboxes above the main editor
========================================== */
	add_action( 'edit_form_after_title', 'skin_featured_area_position' );
	
	if ( ! function_exists( 'skin_featured_area_position' ) ):
		function skin_featured_area_position() {
			global $post, $wp_meta_boxes;
			
			do_meta_boxes( get_current_screen(), 'after_title', $post );
		}
	endif;
	
/* Shortcodes
=============== */	
// Featured video
	add_shortcode( 'skin-shortcode-featured-video', 'skin_shortcode_featured_area_video' );
	
	if ( ! function_exists( 'skin_shortcode_featured_area_video' ) ):
		function skin_shortcode_featured_area_video() {
			if( $video_url = skin_featured_area_get_meta( 'skin_featured_video_url' ) ) {
				global $wp_embed;
				
				return $wp_embed->run_shortcode('[embed]' . esc_url( $video_url ) . '[/embed]');
			}
		}
	endif;
	
// Featured audio
	add_shortcode( 'skin-shortcode-featured-audio', 'skin_shortcode_featured_area_audio' );	
	
	if ( ! function_exists( 'skin_shortcode_featured_area_audio' ) ):
		function skin_shortcode_featured_area_audio() {
			if( $audio_url = skin_featured_area_get_meta( 'skin_featured_audio_url' ) ) {
				global $wp_embed;
				
				return $wp_embed->run_shortcode('[embed]' . esc_url( $audio_url ) . '[/embed]');
			}
		}
	endif;
	
// Featured link
	add_shortcode( 'skin-shortcode-featured-link', 'skin_shortcode_featured_area_link' );
	
	if ( ! function_exists( 'skin_shortcode_featured_area_link' ) ):
		function skin_shortcode_featured_area_link() {	
			if( $link_url = skin_featured_area_get_meta( 'skin_featured_link' ) ) {
				return sprintf(
					'<a href="%s" target="_blank">%s</a>',
					esc_url( $link_url )
				);
			}
		}
	endif;
	
// Featured gallery
	add_shortcode( 'skin-shortcode-featured-gallery', 'skin_shortcode_featured_area_gallery' );
	
	if ( ! function_exists( 'skin_shortcode_featured_area_gallery' ) ):
		function skin_shortcode_featured_area_gallery() {
			if( $gallery_ids = skin_featured_area_get_meta( 'skin_featured_gallery' ) ) {
				return do_shortcode( '[gallery include="' . esc_html( $gallery_ids ) . '"]' );
			}
		}
	endif;
	
// Featured quote
	add_shortcode( 'skin-shortcode-featured-quote', 'skin_shortcode_featured_area_quote' );
	
	if ( ! function_exists( 'skin_shortcode_featured_area_quote' ) ):
		function skin_shortcode_featured_area_quote() {
			if( $quotation = skin_featured_area_get_meta( 'skin_featured_quote' ) ) {		
				$quote = '<span class="quotation">&ldquo;' . esc_html( $quotation ) . '&rdquo;</span>';
				
				if( $author = skin_featured_area_get_meta( 'skin_featured_quote_author' ) ) {
					$quote .= '&mdash;<span class="quote-author">' . esc_html( $author ) . '</span>';
				}
				
				return $quote;
			}
		}
	endif;

/* Scripts & Styles
===================== */
	add_action( 'admin_enqueue_scripts', 'skin_featured_area_scripts' );
	
	if ( ! function_exists( 'skin_featured_area_scripts' ) ):
		function skin_featured_area_scripts($hook) {
			if ( 'post.php' != $hook && 'post-new.php' != $hook ) {
				return;
			}
			
			wp_enqueue_style(
				'skin_featured_area',
				plugin_dir_url( __FILE__ ) . '/css/featured-area.css'
			);
			
			global $post;
			
		// Switch active featured area metabox as the post format changes		
			wp_enqueue_script(
				'skin_featured_area_switch',
				plugin_dir_url( __FILE__ ) . '/js/featured-area-switch.js',
				array( 'jquery' ),
				'',
				true
			);
			
		// Prepare the WordPress Media Uploader
			wp_enqueue_media();
			wp_register_script(
				'skin_featured_gallery',
				plugin_dir_url( __FILE__ ) . '/js/images-to-gallery.js',
				array( 'jquery' ),
				'',
				true
			);
			
		// Pass the selected gallery images data to the JavaScript above
			$get_images = explode( ', ', skin_featured_area_get_meta( 'skin_featured_gallery' ) );
			$gall_is_array = is_array( $get_images );
			
			if ( [""] == $get_images ) {
				$get_images = [];				
			}
			
			$gallargs = array(
				'get_images' => $get_images
			);
				
			wp_localize_script( 'skin_featured_gallery', 'gallargs', $gallargs );			
			wp_enqueue_script( 'skin_featured_gallery' );			
		}
	endif;
?>