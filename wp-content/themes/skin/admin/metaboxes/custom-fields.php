<?php
/* ===============================================
	CUSTOM FIELDS AND METABOXES
	Skin - Premium WordPress Theme, by NordWood
================================================== */
/*	Get custom fields
========================= */	
// General (posts and pages)
	if ( ! function_exists( 'skin_get_meta' ) ):
		function skin_get_meta( $value ) {
			global $post;

			$field = get_post_meta( $post->ID, $value, true );
			if ( !empty( $field ) ) {
				return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
				
			} else {
				return false;
			}
		}
	endif;

/*	Create meta boxes
========================= */
// General (posts and pages)
	add_action( 'add_meta_boxes', 'skin_meta_box' );
	
	if ( ! function_exists( 'skin_meta_box' ) ):
		function skin_meta_box($post_types) {
			$show_on = array ( 'post', 'page' );
			if ( in_array( $post_types, $show_on ) ){
				add_meta_box(
					'skin_meta_box-skin-meta-box',
					esc_html__( 'Skin Post/Page Options', 'skin' ),
					'skin_metabox_html',
					$post_types,
					'advanced',
					'default'
				);
			}	
		}
	endif;
	
// Pages only
	add_action( 'add_meta_boxes_page', 'skin_page_meta_box' );
	
	if ( ! function_exists( 'skin_page_meta_box' ) ):
		function skin_page_meta_box() {
			add_meta_box(
				'skin_page_meta_box-skin-page-meta-box',
				esc_html__( 'Skin Page Options', 'skin' ),
				'skin_page_metabox_html',
				'page',
				'normal',
				'default'
			);
		}
	endif;
	
// Posts only
	add_action( 'add_meta_boxes_post', 'skin_post_meta_box' );
	
	if ( ! function_exists( 'skin_post_meta_box' ) ):
		function skin_post_meta_box() {
			add_meta_box(
				'skin_meta_boxes_posts_off_global-skin-meta-boxes-posts-off-global',
				esc_html__( 'Ignore global settings', 'skin' ),
				'skin_posts_off_global_metabox_html',
				'post',
				'normal',
				'default'
			);
			
			add_meta_box(
				'skin_post_meta_box-skin-post-meta-box',
				esc_html__( 'Skin Post Options', 'skin' ),
				'skin_post_metabox_html',
				'post',
				'normal',
				'default'
			);
		}
	endif;

/*	Create custom fields
=========================== */
// Ignore gloabl settings (for posts only)
	if ( ! function_exists( 'skin_posts_off_global_metabox_html' ) ):	
		function skin_posts_off_global_metabox_html( $post) {
			wp_nonce_field( '_skin_posts_off_global_metabox_html_nonce', 'skin_posts_off_global_metabox_html_nonce' );
			?>			
			<div class="skin-metabox-section clearfix">
				<fieldset>
					<input type="checkbox"
						name="skin_ignore_global"
						id="skin_ignore_global"
						value="ignore" <?php checked( skin_get_meta( 'skin_ignore_global' ), "ignore" ); ?>
					>
					<label for="skin_ignore_global"><?php
						esc_html_e( 'Ignore global settings (Check this to give the below options priority over the chosen settings in "Skin Single Post".)', 'skin' );
					?></label>
				</fieldset>
			</div>
		<?php
		}
	endif;
	
// General (posts and pages)
	if ( ! function_exists( 'skin_metabox_html' ) ):	
		function skin_metabox_html( $post) {
			wp_nonce_field( '_skin_metabox_html_nonce', 'skin_metabox_html_nonce' );
			?>			
			<div class="skin-metabox-section clearfix">
				<fieldset>
					<h4><?php esc_html_e( 'Layout', 'skin' ); ?></h4>
					
					<input type="radio"
						name="skin_post_sidebar"
						id="skin_post_sidebar_0"
						value="include-sidebar"
						<?php
							echo ( !skin_get_meta( 'skin_post_sidebar' ) || 'include-sidebar' === skin_get_meta( 'skin_post_sidebar' ) ) ? 'checked' : '';
						?>
					>
					<label for="skin_post_sidebar_0"><?php esc_html_e( 'Include sidebar', 'skin' ); ?></label>
					
					<input type="radio"
						name="skin_post_sidebar"
						id="skin_post_sidebar_1"
						value="no-sidebar"
						<?php echo ( 'no-sidebar' === skin_get_meta( 'skin_post_sidebar' ) ) ? 'checked' : ''; ?>
					>
					<label for="skin_post_sidebar_1"><?php esc_html_e( 'No sidebar', 'skin' ); ?></label>
					
					<p></p>
				</fieldset>
				
				<fieldset>
					<h4><?php esc_html_e( 'Content elements', 'skin' ); ?></h4>
					
					<input type="checkbox"
						name="skin_drop_caps"
						id="skin_drop_caps"
						value="drop-caps" <?php checked( skin_get_meta( 'skin_drop_caps' ), "drop-caps" ); ?>
					>
					<label for="skin_drop_caps"><?php esc_html_e( 'Drop caps', 'skin' ); ?></label>
					
					<input type="checkbox"
						name="skin_featured_img"
						id="skin_featured_img"
						value="show" <?php checked( skin_get_meta( 'skin_featured_img' ), "show" ); ?>
					>
					<label for="skin_featured_img"><?php esc_html_e( 'Show featured image', 'skin' ); ?></label>
					
					<input type="checkbox"
						name="skin_enlarge_media"
						id="skin_enlarge_media"
						value="enlarge-media" <?php checked( skin_get_meta( 'skin_enlarge_media' ), "enlarge-media" ); ?>
					>
					<label for="skin_enlarge_media"><?php esc_html_e( 'Enlarge embedded media', 'skin' ); ?></label>
				</fieldset>
				
				<fieldset>
					<h4><?php esc_html_e( 'Comments', 'skin' ); ?></h4>
					<p><?php esc_html_e( 'To allow default WordPress comments, check that option under the Discussion section of this page. If it\'s not visible on your screen, you can include it via Screen Options tab in the top right corner.', 'skin' ); ?></p>
					
					<input type="checkbox"
						name="skin_allow_fb_comments"
						id="skin_allow_fb_comments"
						value="allow" <?php checked( skin_get_meta( 'skin_allow_fb_comments' ), "allow" ); ?>
					>
					<label for="skin_allow_fb_comments"><?php esc_html_e( 'Allow Facebook comments', 'skin' ); ?></label>
				</fieldset>
			</div>
		<?php
		}
	endif;
   
/* Posts only */
	if ( ! function_exists( 'skin_post_metabox_html' ) ):
		function skin_post_metabox_html( $post) {
			wp_nonce_field( '_skin_post_metabox_html_nonce', 'skin_post_metabox_html_nonce' );
			?>
			<div class="skin-metabox-section clearfix">
				<fieldset>
					<input type="checkbox"
						name="skin_top_gradient_single"
						id="skin_top_gradient_single"
						value="gradient-bgr" <?php checked( skin_get_meta( 'skin_top_gradient_single' ), "gradient-bgr" ); ?>
					>
					<label for="skin_top_gradient_single"><?php esc_html_e( 'Apply gradient background on top', 'skin' ); ?></label>
					
					<input type="checkbox"
						name="skin_show_category"
						id="skin_show_category"
						value="show" <?php checked( skin_get_meta( 'skin_show_category' ), "show" ); ?>
					>
					<label for="skin_show_category"><?php esc_html_e( 'Show category', 'skin' ); ?></label>
					
					<input type="checkbox"
						name="skin_show_date"
						id="skin_show_date"
						value="show" <?php checked( skin_get_meta( 'skin_show_date' ), "show" ); ?>
					>
					<label for="skin_show_date"><?php esc_html_e( 'Show date', 'skin' ); ?></label>
					
					<input type="checkbox"
						name="skin_show_author"
						id="skin_show_author"
						value="show" <?php checked( skin_get_meta( 'skin_show_author' ), "show" ); ?>
					>
					<label for="skin_show_author"><?php esc_html_e( 'Show author\'s name', 'skin' ); ?></label>
					
					<input type="checkbox"
						name="skin_show_tagcloud"
						id="skin_show_tagcloud"
						value="show" <?php checked( skin_get_meta( 'skin_show_tagcloud' ), "show" ); ?>
					>
					<label for="skin_show_tagcloud"><?php esc_html_e( 'Show tagcloud', 'skin' ); ?></label>
				</fieldset>
				
				<fieldset>
					<h4><?php esc_html_e( 'Prioritize categories', 'skin' ); ?></h4>
					<p><?php esc_html_e( 'Select the categories you\'d prefer to show, if their number is limited per Customizer settings. By default, they will be prioritized by the number of posts each one is assigned to.', 'skin' ); ?></p>
					
					<div class="skin-cats-list">
					<?php
						$p_cats = skin_get_meta( 'skin_prioritize_cats' );
						$p_cats = explode( ',', $p_cats );						
						array_pop( $p_cats );
					
						$cats = get_the_category( get_the_ID() );
						
						foreach ( $cats as $cat ) {
							$cat_id = $cat->term_id;
							$cat_name = $cat->name;
							
							if ( in_array( $cat_id, $p_cats ) ) {
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
							name="skin_prioritize_cats"
							id="skin_prioritize_cats"
							value="<?php echo esc_attr( skin_get_meta( 'skin_prioritize_cats' ) ); ?>"
						>
					</div>
				</fieldset>
				
				<fieldset>
					<h4><?php esc_html_e( 'Author\'s bio', 'skin' ); ?></h4>
					
					<input type="checkbox"
						name="skin_show_author_bio"
						id="skin_show_author_bio"
						value="show" <?php checked( skin_get_meta( 'skin_show_author_bio' ), "show" ); ?>
					>
					<label for="skin_show_author_bio"><?php esc_html_e( 'Show author\'s bio below the post', 'skin' ); ?></label>
				</fieldset>
				
				<fieldset>
					<h4><?php esc_html_e( 'Custom post link', 'skin' ); ?></h4>					
					<p class="small"><?php esc_html_e( 'Applies to posts list. Leave blank to keep default link (post permalink).', 'skin' ); ?></p>
					
					<label for="skin_custom_post_link"><?php esc_html_e( 'URL:', 'skin' ); ?></label>
					<input type="url" class="widefat"
						name="skin_custom_post_link"
						id="skin_custom_post_link"
						value="<?php echo esc_url_raw( skin_get_meta( 'skin_custom_post_link' ) ); ?>"
					>
					
					<input type="checkbox"
						name="skin_custom_post_link_target"
						id="skin_custom_post_link_target"
						value="new-tab" <?php checked( skin_get_meta( 'skin_custom_post_link_target' ), "new-tab" ); ?>
					>
					<label for="skin_custom_post_link_target"><?php esc_html_e( 'Open link in new tab', 'skin' ); ?></label>
				</fieldset>
				
				<fieldset>
					<h4><?php esc_html_e( 'Featured image for posts list', 'skin' ); ?></h4>
					<p class="small"><?php esc_html_e( 'If no image is uploaded, featured image will be used.', 'skin' ); ?></p>
					
					<div class="img-upload-wrapper clearfix">
						<div class="img-preview"><?php
							if ( skin_get_meta( 'skin_post_img_in_list' ) != '' ) :
								echo wp_get_attachment_image( skin_get_meta( 'skin_post_img_in_list' ), 'thumbnail' );
							endif;
						?></div>
						
						<input type="hidden" class="img-id"
							name="skin_post_img_in_list"
							id="skin_post_img_in_list"						
							value="<?php echo esc_attr( skin_get_meta( 'skin_post_img_in_list' ) ); ?>"
						>				
						
						<input type="button" class="button upload-img <?php if ( '' != skin_get_meta( 'skin_post_img_in_list' ) ) { echo 'hidden'; } ?>"
							name="skin_post_img_in_list_upload"
							id="skin_post_img_in_list_upload"
							value="<?php esc_attr_e( 'Upload image', 'skin' ); ?>"
						>
						
						<input type="button" class="button remove-img <?php if ( '' == skin_get_meta( 'skin_post_img_in_list' ) ) { echo 'hidden'; } ?>"
							name="skin_post_img_in_list_remove"
							id="skin_post_img_in_list_remove"
							value="<?php esc_attr_e( 'Remove image', 'skin' ); ?>"
						>
					</div>
				</fieldset>
				
				<fieldset>
					<h4><?php esc_html_e( 'Featured image for posts slider', 'skin' ); ?></h4>					
					<p class="small"><?php esc_html_e( 'If no image is uploaded, featured image will be used.', 'skin' ); ?></p>
					
					<div class="img-upload-wrapper clearfix">
						<div class="img-preview"><?php
							if ( skin_get_meta( 'skin_post_img_in_slider' ) != '' ) :
								echo wp_get_attachment_image( skin_get_meta( 'skin_post_img_in_slider' ), 'thumbnail' );
							endif;
						?></div>
						
						<input type="hidden" class="img-id"
							name="skin_post_img_in_slider"
							id="skin_post_img_in_slider"						
							value="<?php echo esc_attr( skin_get_meta( 'skin_post_img_in_slider' ) ); ?>"
						>				
						
						<input type="button" class="button upload-img <?php if ( '' != skin_get_meta( 'skin_post_img_in_slider' ) ) { echo 'hidden'; } ?>"
							name="skin_post_img_in_slider_upload"
							id="skin_post_img_in_slider_upload"
							value="<?php esc_attr_e( 'Upload image', 'skin' ); ?>"
						>
						
						<input type="button" class="button remove-img <?php if ( '' == skin_get_meta( 'skin_post_img_in_slider' ) ) { echo 'hidden'; } ?>"
							name="skin_post_img_in_slider_remove"
							id="skin_post_img_in_slider_remove"
							value="<?php esc_attr_e( 'Remove image', 'skin' ); ?>"
						>
					</div>
				</fieldset>
				
				<fieldset>
					<h4><?php esc_html_e( 'Tiny gif', 'skin' ); ?></h4>					
					<p class="small"><?php esc_html_e( 'To be used in \'Popular/Latest posts\' and \'Related posts\'. Recommended size iz 100x100 px.', 'skin' ); ?></p>
					<p class="small"><?php esc_html_e( 'If no image is uploaded, \'Featured image for posts list\' will be used.', 'skin' ); ?></p>
					
					<div class="img-upload-wrapper clearfix">
						<div class="img-preview"><?php
							if ( skin_get_meta( 'skin_post_tiny_gif' ) != '' ) :
								echo wp_get_attachment_image( skin_get_meta( 'skin_post_tiny_gif' ), 'thumbnail' );
							endif;
						?></div>
						
						<input type="hidden" class="img-id"
							name="skin_post_tiny_gif"
							id="skin_post_tiny_gif"						
							value="<?php echo esc_attr( skin_get_meta( 'skin_post_tiny_gif' ) ); ?>"
						>				
						
						<input type="button" class="button upload-img <?php if ( '' != skin_get_meta( 'skin_post_tiny_gif' ) ) { echo 'hidden'; } ?>"
							name="skin_post_tiny_gif_upload"
							id="skin_post_tiny_gif_upload"
							value="<?php esc_attr_e( 'Upload image', 'skin' ); ?>"
						>
						
						<input type="button" class="button remove-img <?php if ( '' == skin_get_meta( 'skin_post_tiny_gif' ) ) { echo 'hidden'; } ?>"
							name="skin_post_tiny_gif_remove"
							id="skin_post_tiny_gif_remove"
							value="<?php esc_attr_e( 'Remove image', 'skin' ); ?>"
						>
					</div>
				</fieldset>
			</div>
		<?php
		}
	endif;
   
/* Pages only */
	if ( ! function_exists( 'skin_page_metabox_html' ) ):
		function skin_page_metabox_html( $post) {
			wp_nonce_field( '_skin_page_metabox_html_nonce', 'skin_page_metabox_html_nonce' );
			?>
			<div class="skin-metabox-section clearfix">
				<fieldset>
					<h4><?php esc_html_e( 'Gradient in top area', 'skin' ); ?></h4>
					
					<p><?php esc_html_e( 'If this option is not checked, or the color choice is cleared, global settings will be used.', 'skin' ); ?></p>
					
					<input type="checkbox"
						name="skin_top_gradient_page"
						id="skin_top_gradient_page"
						value="gradient-bgr" <?php checked( skin_get_meta( 'skin_top_gradient_page' ), "gradient-bgr" ); ?>
					>
					<label for="skin_top_gradient_page"><?php esc_html_e( 'Apply gradient background on top', 'skin' ); ?></label>					
					
					<label for="skin_top_gradient_page_color_1"><?php esc_html_e( 'Color 1', 'skin' )?></label>
					
					<input type="text" class="meta-color"
						name="skin_page_gradient_color_1"
						id="skin_page_gradient_color_1"
						value="<?php echo skin_get_meta( 'skin_page_gradient_color_1' ) ? esc_attr( skin_get_meta( 'skin_page_gradient_color_1' ) ) : esc_attr( get_theme_mod( 'skin_gradient_color_1', '#f4d7de' ) ); ?>"
					/>
					
					<label for="skin_page_gradient_color_2"><?php esc_html_e( 'Color 2', 'skin' )?></label>
					
					<input type="text" class="meta-color"
						name="skin_page_gradient_color_2"
						id="skin_page_gradient_color_2"
						value="<?php echo skin_get_meta( 'skin_page_gradient_color_2' ) ? esc_attr( skin_get_meta( 'skin_page_gradient_color_2' ) ) : esc_attr( get_theme_mod( 'skin_gradient_color_2', '#cecfe7' ) ); ?>"
					/>
					
					<label for="skin_page_gradient_txt_color"><?php esc_html_e( 'Text color over gradient', 'skin' )?></label>
					
					<input type="text" class="meta-color"
						name="skin_page_gradient_txt_color"
						id="skin_page_gradient_txt_color"
						value="<?php echo skin_get_meta( 'skin_page_gradient_txt_color' ) ? esc_attr( skin_get_meta( 'skin_page_gradient_txt_color' ) ) : esc_attr( get_theme_mod( 'skin_txt_on_gradient_color', '#353535' ) ); ?>"
					/>
					
					<label for="skin_page_gradient_link_color"><?php esc_html_e( 'Link color over gradient', 'skin' )?></label>
					
					<input type="text" class="meta-color"
						name="skin_page_gradient_link_color"
						id="skin_page_gradient_link_color"
						value="<?php echo skin_get_meta( 'skin_page_gradient_link_color' ) ? esc_attr( skin_get_meta( 'skin_page_gradient_link_color' ) ) : esc_attr( get_theme_mod( 'skin_txt_on_gradient_color_hover', '#ffffff' ) ); ?>"
					/>
				</fieldset>
				
				<fieldset>
					<h4><?php esc_html_e( 'Posts slider', 'skin' ); ?></h4>
					
					<input type="checkbox"
						name="skin_slider_on_page"
						id="skin_slider_on_page"
						value="slider-on" <?php checked( skin_get_meta( 'skin_slider_on_page' ), "slider-on" ); ?>
					>
					<label for="skin_slider_on_page"><?php esc_html_e( 'Add posts slider above this page', 'skin' ); ?></label>
					
					<p><?php esc_html_e( 'Slider type:', 'skin' ); ?></p>
					
					<input type="radio"
						name="skin_slider_on_page_type"
						id="skin_slider_on_page_type_0"
						value="latest"
						<?php
							echo ( !skin_get_meta( 'skin_slider_on_page_type' ) || 'latest' === skin_get_meta( 'skin_slider_on_page_type' ) ) ? 'checked' : '';
						?>
					>
					<label for="skin_slider_on_page_type_0"><?php esc_html_e( 'Latest posts', 'skin' ); ?></label>
					
					<input type="radio"
						name="skin_slider_on_page_type"
						id="skin_slider_on_page_type_1"
						value="featured"
						<?php echo ( 'featured' === skin_get_meta( 'skin_slider_on_page_type' ) ) ? 'checked' : ''; ?>
					>
					<label for="skin_slider_on_page_type_1"><?php esc_html_e( 'Featured posts', 'skin' ); ?></label>
					
					<?php if ( SKIN_WOOCOMMERCE_ACTIVE ) { ?>
						<input type="radio"
							name="skin_slider_on_page_type"
							id="skin_slider_on_page_type_2"
							value="featured-products"
							<?php echo ( 'featured-products' === skin_get_meta( 'skin_slider_on_page_type' ) ) ? 'checked' : ''; ?>
						>
						<label for="skin_slider_on_page_type_2"><?php esc_html_e( 'Featured products', 'skin' ); ?></label>
						
						<div class="shop-slider-ctrl">
							<p><label for="skin_products_slider_on_page_qty"><?php esc_html_e( 'Number of products:', 'skin' ); ?></label>
							<input type="number"
								name="skin_products_slider_on_page_qty"
								id="skin_products_slider_on_page_qty"
								value="<?php echo esc_attr( skin_get_meta( 'skin_products_slider_on_page_qty' ) ); ?>"
							></p>
							
							<input type="checkbox"
								name="skin_products_slider_on_page_show_cat"
								id="skin_products_slider_on_page_show_cat"
								value="show" <?php checked( skin_get_meta( 'skin_products_slider_on_page_show_cat' ), "show" ); ?>
							>
							<label for="skin_products_slider_on_page_show_cat"><?php esc_html_e( 'Show category', 'skin' ); ?></label>
							
							<input type="checkbox"
								name="skin_products_slider_on_page_show_price"
								id="skin_products_slider_on_page_show_price"
								value="show" <?php checked( skin_get_meta( 'skin_products_slider_on_page_show_price' ), "show" ); ?>
							>
							<label for="skin_products_slider_on_page_show_price"><?php esc_html_e( 'Show price', 'skin' ); ?></label>
						</div>
					<?php } ?>
					
					<div class="blog-slider-ctrl">
						<div class="slider-latest-ctrl">
							<label for="skin_slider_on_page_qty"><?php esc_html_e( 'Number of posts:', 'skin' ); ?></label>
							<input type="number"
								name="skin_slider_on_page_qty"
								id="skin_slider_on_page_qty"
								value="<?php echo esc_attr( skin_get_meta( 'skin_slider_on_page_qty' ) ); ?>"
							>
							
							<label for="skin_slider_feature_recent_by_tag"><?php esc_html_e( 'Show posts with tag(s) (separated with comma):', 'skin' ); ?></label>
							<input type="text"
								name="skin_slider_feature_recent_by_tag"
								id="skin_slider_feature_recent_by_tag"
								value="<?php echo esc_attr( skin_get_meta( 'skin_slider_feature_recent_by_tag' ) ); ?>"
							>
						</div>					
						
						<div class="slider-featured-ctrl">
							<label for="skin_slider_on_page_ids"><?php esc_html_e( 'Posts IDs (separated with comma):', 'skin' ); ?></label>
							<input type="text"
								name="skin_slider_on_page_ids"
								id="skin_slider_on_page_ids"
								value="<?php echo esc_attr( skin_get_meta( 'skin_slider_on_page_ids' ) ); ?>"
							>
						</div>
						
						<input type="checkbox"
							name="skin_slider_on_page_show_author"
							id="skin_slider_on_page_show_author"
							value="show" <?php checked( skin_get_meta( 'skin_slider_on_page_show_author' ), "show" ); ?>
						>
						<label for="skin_slider_on_page_show_author"><?php esc_html_e( 'Show author', 'skin' ); ?></label>
						
						<input type="checkbox"
							name="skin_slider_on_page_show_date"
							id="skin_slider_on_page_show_date"
							value="show" <?php checked( skin_get_meta( 'skin_slider_on_page_show_date' ), "show" ); ?>
						>
						<label for="skin_slider_on_page_show_date"><?php esc_html_e( 'Show date', 'skin' ); ?></label>
					</div>
						
					<input type="checkbox"
						name="skin_slider_on_page_auto"
						id="skin_slider_on_page_auto"
						value="auto" <?php checked( skin_get_meta( 'skin_slider_on_page_auto' ), "auto" ); ?>
					>
					<label for="skin_slider_on_page_auto"><?php esc_html_e( 'Autoplay', 'skin' ); ?></label>
				</fieldset>
				
				<fieldset>
					<h4><?php esc_html_e( 'Page title', 'skin' ); ?></h4>
					
					<input type="checkbox"
						name="skin_hide_page_title"
						id="skin_hide_page_title"
						value="hide-title" <?php checked( skin_get_meta( 'skin_hide_page_title' ), "hide-title" ); ?>
					>
					<label for="skin_hide_page_title"><?php esc_html_e( 'Hide title on this page', 'skin' ); ?></label>					
				</fieldset>
			</div>
		<?php
		}
	endif;
	
/*	Update custom fields
=========================== */		
// General (posts and pages)
	add_action( 'save_post', 'skin_save_meta' );
	
	if ( ! function_exists( 'skin_save_meta' ) ):
		function skin_save_meta( $post_id ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			
			if ( !isset( $_POST['skin_metabox_html_nonce'] ) || !wp_verify_nonce( $_POST['skin_metabox_html_nonce'], '_skin_metabox_html_nonce' ) ) {
				return;
			}
			
			if ( !current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		
		// Sidebar
			if ( isset( $_POST['skin_post_sidebar'] ) ) {
				update_post_meta( $post_id, 'skin_post_sidebar', esc_attr( $_POST['skin_post_sidebar'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_post_sidebar', null );
			}
		
		// Drop caps
			if ( isset( $_POST['skin_drop_caps'] ) ) {
				update_post_meta( $post_id, 'skin_drop_caps', esc_attr( $_POST['skin_drop_caps'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_drop_caps', null );
			}
		
		// Featured image
			if ( isset( $_POST['skin_featured_img'] ) ) {
				update_post_meta( $post_id, 'skin_featured_img', esc_attr( $_POST['skin_featured_img'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_featured_img', null );
			}
		
		// Enlarge embedded media
			if ( isset( $_POST['skin_enlarge_media'] ) ) {
				update_post_meta( $post_id, 'skin_enlarge_media', esc_attr( $_POST['skin_enlarge_media'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_enlarge_media', null );
			}
			
		// Allow Facebook comments
			if ( isset( $_POST['skin_allow_fb_comments'] ) ) {
				update_post_meta( $post_id, 'skin_allow_fb_comments', esc_attr( $_POST['skin_allow_fb_comments'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_allow_fb_comments', null );
			}
		}
	endif;
	
// Posts only	
	add_action( 'save_post', 'skin_save_post_meta' );
	
	if ( ! function_exists( 'skin_save_post_meta' ) ):
		function skin_save_post_meta( $post_id ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			
			if ( !isset( $_POST['skin_post_metabox_html_nonce'] ) || !wp_verify_nonce( $_POST['skin_post_metabox_html_nonce'], '_skin_post_metabox_html_nonce' ) ) {
				return; 
			}
			
			if ( !current_user_can( 'edit_post', $post_id ) ) {
				return; 
			}
			
			if ( !isset( $_POST['skin_posts_off_global_metabox_html_nonce'] )
				|| !wp_verify_nonce( $_POST['skin_posts_off_global_metabox_html_nonce'], '_skin_posts_off_global_metabox_html_nonce' )
			) {
				return; 
			}
			
		// Ignore global settings
			if ( isset( $_POST['skin_ignore_global'] ) ) {
				update_post_meta( $post_id, 'skin_ignore_global', esc_attr( $_POST['skin_ignore_global'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_ignore_global', null );
			}
		
		// Gradient bgr on top
			if ( isset( $_POST['skin_top_gradient_single'] ) ) {
				update_post_meta( $post_id, 'skin_top_gradient_single', esc_attr( $_POST['skin_top_gradient_single'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_top_gradient_single', null );
			}
			
		// Show category
			if ( isset( $_POST['skin_show_category'] ) ) {
				update_post_meta( $post_id, 'skin_show_category', esc_attr( $_POST['skin_show_category'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_show_category', null );
			}
			
		// Show date
			if ( isset( $_POST['skin_show_date'] ) ) {
				update_post_meta( $post_id, 'skin_show_date', esc_attr( $_POST['skin_show_date'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_show_date', null );
			}
			
		// Show author's name
			if ( isset( $_POST['skin_show_author'] ) ) {
				update_post_meta( $post_id, 'skin_show_author', esc_attr( $_POST['skin_show_author'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_show_author', null );
			}
			
		// Show tagcloud
			if ( isset( $_POST['skin_show_tagcloud'] ) ) {
				update_post_meta( $post_id, 'skin_show_tagcloud', esc_attr( $_POST['skin_show_tagcloud'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_show_tagcloud', null );
			}
			
		// Show author's bio
			if ( isset( $_POST['skin_show_author_bio'] ) ) {
				update_post_meta( $post_id, 'skin_show_author_bio', esc_attr( $_POST['skin_show_author_bio'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_show_author_bio', null );
			}
			
		// Prioritize categories
			if ( isset( $_POST['skin_prioritize_cats'] ) ) {
				update_post_meta( $post_id, 'skin_prioritize_cats', sanitize_text_field( $_POST['skin_prioritize_cats'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_prioritize_cats', null );
			}
			
		// Custom post link
			if ( isset( $_POST['skin_custom_post_link'] ) ) {
				update_post_meta( $post_id, 'skin_custom_post_link', esc_url_raw( $_POST['skin_custom_post_link'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_custom_post_link', null );
			}
			
		// Custom post link target
			if ( isset( $_POST['skin_custom_post_link_target'] ) ) {
				update_post_meta( $post_id, 'skin_custom_post_link_target', esc_attr( $_POST['skin_custom_post_link_target'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_custom_post_link_target', null );
			}
			
		// Featured image for posts list
			if ( isset( $_POST['skin_post_img_in_list'] ) ) {
				update_post_meta( $post_id, 'skin_post_img_in_list', sanitize_text_field( $_POST['skin_post_img_in_list'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_post_img_in_list', null );
			}
			
		// Featured image for posts slider
			if ( isset( $_POST['skin_post_img_in_slider'] ) ) {
				update_post_meta( $post_id, 'skin_post_img_in_slider', sanitize_text_field( $_POST['skin_post_img_in_slider'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_post_img_in_slider', null );
			}
			
		// Tiny gif
			if ( isset( $_POST['skin_post_tiny_gif'] ) ) {
				update_post_meta( $post_id, 'skin_post_tiny_gif', sanitize_text_field( $_POST['skin_post_tiny_gif'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_post_tiny_gif', null );
			}
		}
	endif;
	
// Pages only
	add_action( 'save_post', 'skin_save_page_meta' );
	
	if ( ! function_exists( 'skin_save_page_meta' ) ):
		function skin_save_page_meta( $post_id ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			
			if ( !isset( $_POST['skin_page_metabox_html_nonce'] ) || !wp_verify_nonce( $_POST['skin_page_metabox_html_nonce'], '_skin_page_metabox_html_nonce' ) ) {
				return; 
			}
			
			if ( !current_user_can( 'edit_post', $post_id ) ) {
				return; 
			}
			
		// Gradient in top area
			if ( isset( $_POST['skin_top_gradient_page'] ) ) {
				update_post_meta( $post_id, 'skin_top_gradient_page', esc_attr( $_POST['skin_top_gradient_page'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_top_gradient_page', null );
			}
			
		// Page gradient color 1
			if ( isset( $_POST['skin_page_gradient_color_1'] ) ) {
				update_post_meta( $post_id, 'skin_page_gradient_color_1', sanitize_text_field( $_POST['skin_page_gradient_color_1'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_page_gradient_color_1', null );
			}
			
		// Page gradient color 2
			if ( isset( $_POST['skin_page_gradient_color_2'] ) ) {
				update_post_meta( $post_id, 'skin_page_gradient_color_2', sanitize_text_field( $_POST['skin_page_gradient_color_2'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_page_gradient_color_2', null );
			}
			
		// Text color over gradient
			if ( isset( $_POST['skin_page_gradient_txt_color'] ) ) {
				update_post_meta( $post_id, 'skin_page_gradient_txt_color', sanitize_text_field( $_POST['skin_page_gradient_txt_color'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_page_gradient_txt_color', null );
			}
			
		// Link color over gradient
			if ( isset( $_POST['skin_page_gradient_link_color'] ) ) {
				update_post_meta( $post_id, 'skin_page_gradient_link_color', sanitize_text_field( $_POST['skin_page_gradient_link_color'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_page_gradient_link_color', null );
			}
			
		// Slider above the page
			if ( isset( $_POST['skin_slider_on_page'] ) ) {
				update_post_meta( $post_id, 'skin_slider_on_page', esc_attr( $_POST['skin_slider_on_page'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_slider_on_page', null );
			}
			
		// Slider type
			if ( isset( $_POST['skin_slider_on_page_type'] ) ) {
				update_post_meta( $post_id, 'skin_slider_on_page_type', esc_attr( $_POST['skin_slider_on_page_type'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_slider_on_page_type', null );
			}
			
		// Number of products in slider
			if ( isset( $_POST['skin_products_slider_on_page_qty'] ) ) {
				update_post_meta( $post_id, 'skin_products_slider_on_page_qty', absint( $_POST['skin_products_slider_on_page_qty'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_products_slider_on_page_qty', null );
			}
			
		// Show category in products slider
			if ( isset( $_POST['skin_products_slider_on_page_show_cat'] ) ) {
				update_post_meta( $post_id, 'skin_products_slider_on_page_show_cat', esc_attr( $_POST['skin_products_slider_on_page_show_cat'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_products_slider_on_page_show_cat', null );
			}
			
		// Show price in products slider
			if ( isset( $_POST['skin_products_slider_on_page_show_price'] ) ) {
				update_post_meta( $post_id, 'skin_products_slider_on_page_show_price', esc_attr( $_POST['skin_products_slider_on_page_show_price'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_products_slider_on_page_show_price', null );
			}
			
		// Number of posts in slider
			if ( isset( $_POST['skin_slider_on_page_qty'] ) ) {
				update_post_meta( $post_id, 'skin_slider_on_page_qty', absint( $_POST['skin_slider_on_page_qty'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_slider_on_page_qty', null );
			}
			
		// Filter posts slider by tag
			if ( isset( $_POST['skin_slider_feature_recent_by_tag'] ) ) {
				update_post_meta( $post_id, 'skin_slider_feature_recent_by_tag', sanitize_text_field( $_POST['skin_slider_feature_recent_by_tag'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_slider_feature_recent_by_tag', null );
			}
			
		// IDs of slider featured posts
			if ( isset( $_POST['skin_slider_on_page_ids'] ) ) {
				update_post_meta( $post_id, 'skin_slider_on_page_ids', sanitize_text_field( $_POST['skin_slider_on_page_ids'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_slider_on_page_ids', null );
			}
			
		// Slider autoplay
			if ( isset( $_POST['skin_slider_on_page_auto'] ) ) {
				update_post_meta( $post_id, 'skin_slider_on_page_auto', esc_attr( $_POST['skin_slider_on_page_auto'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_slider_on_page_auto', null );
			}
			
		// Show author on posts in slider
			if ( isset( $_POST['skin_slider_on_page_show_author'] ) ) {
				update_post_meta( $post_id, 'skin_slider_on_page_show_author', esc_attr( $_POST['skin_slider_on_page_show_author'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_slider_on_page_show_author', null );
			}
			
		// Show date on posts in slider
			if ( isset( $_POST['skin_slider_on_page_show_date'] ) ) {
				update_post_meta( $post_id, 'skin_slider_on_page_show_date', esc_attr( $_POST['skin_slider_on_page_show_date'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_slider_on_page_show_date', null );
			}
			
		// Hide page title
			if ( isset( $_POST['skin_hide_page_title'] ) ) {
				update_post_meta( $post_id, 'skin_hide_page_title', esc_attr( $_POST['skin_hide_page_title'] ) );
				
			} else {
				update_post_meta( $post_id, 'skin_hide_page_title', null );
			}
		}
	endif;
	
/* Scripts and styles
======================== */
	add_action( 'admin_enqueue_scripts', 'skin_metabox_scripts' );
	
	if ( ! function_exists( 'skin_metabox_scripts' ) ):
		function skin_metabox_scripts( $hook ) {
			if ( 'post.php' != $hook && 'post-new.php' != $hook ) {
				return;
			}
			
			global $typenow;
			
			if( 'page' == $typenow  ) {
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'wp-color-picker' );
			}
			
			wp_enqueue_style(
				'skin_metaboxes',
				get_template_directory_uri() . '/admin/metaboxes/css/metaboxes.css'
			);
		
			wp_enqueue_media();
			wp_enqueue_script( 'skin_img_upload' );
			
			wp_enqueue_script( 'skin_metaboxes' );
		}
	endif;
	
	
?>