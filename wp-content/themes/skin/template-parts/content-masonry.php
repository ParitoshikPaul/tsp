<?php
/* ==============================================
	MASONRY LAYOUT template part
	Skin - Premium WordPress Theme, by NordWood
================================================= */
	$ignore_global			= skin_get_meta( 'skin_ignore_global' );
	$p_format				= get_post_format();
	$featured_area_works	= function_exists( 'skin_featured_area_get_meta' );
	
	$c_link		= skin_get_meta( 'skin_custom_post_link' );
	$c_target	= skin_get_meta( 'skin_custom_post_link_target' );	
	$p_link		= $c_link ? $c_link : get_permalink();
	$p_target	= ( 'new-tab' === $c_target ) ? '_blank' : '_self';
	
	$has_img	= false;
	$img_shape	= skin_get_featured_img_shape();
	$img_url	= '';
	$img_ratio	= 1;
	
	if ( 'hidden' !== $img_shape ) {
		$img_id = '';
		
		if ( skin_get_meta( 'skin_post_img_in_list' ) ) {
			$has_img = true;
			$img_id = skin_get_meta( 'skin_post_img_in_list' );
			
		} else if ( has_post_thumbnail() ) {
			$has_img = true;
			$img_id = get_post_thumbnail_id( get_the_ID() );
		}
		
		if ( ( 'link' === $p_format || 'quote' === $p_format ) && skin_get_meta( 'skin_post_tiny_gif' ) ) {
			$has_img = true;
			$img_id = skin_get_meta( 'skin_post_tiny_gif' );
		}
		
		if ( '' !== $img_id ) {
			$img_size = wp_get_attachment_metadata( $img_id );
			
			if ( ! is_array( $img_size ) || ! array_key_exists( "width", $img_size ) || ! array_key_exists( "height", $img_size ) ) {
				$img_url = '';
				
			} else {
				$img_w = $img_size['width'];
				$img_h = $img_size['height'];
				
				if ( 0 < $img_h ) {				
					$img_ratio = $img_w/$img_h;
					
					if ( 'link' === $p_format || 'quote' === $p_format ) {
						$img_url = skin_get_giffy_attachment_url( $img_id, 'skin_small' );
						
					} else {
						$img_url = skin_get_giffy_attachment_url( $img_id, 'medium_large' );
					}
					
				} else {
					$img_url = '';
				}
			}
		}
	}
	
	$featured_gallery = false;
	
	if ( 'gallery' === $p_format && $featured_area_works && '' != skin_featured_area_get_meta( 'skin_featured_gallery' ) ) {
		if ( 'hidden' !== $img_shape && skin_get_meta( 'skin_post_img_in_list' ) ) {
			$has_img = true;
			$img_id = skin_get_meta( 'skin_post_img_in_list' );		
			$img_size = wp_get_attachment_metadata( $img_id );
			
			if ( ! is_array( $img_size ) || ! array_key_exists( "width", $img_size ) || ! array_key_exists( "height", $img_size ) ) {
				$img_url = '';
				
			} else {
				$img_w = $img_size['width'];
				$img_h = $img_size['height'];
				
				if ( 0 < $img_h ) {				
					$img_ratio = $img_w/$img_h;
					
					if ( 'link' === $p_format || 'quote' === $p_format ) {
						$img_url = skin_get_giffy_attachment_url( $img_id, 'skin_small' );
						
					} else {
						$img_url = skin_get_giffy_attachment_url( $img_id, 'medium_large' );
					}
					
				} else {
					$img_url = '';
				}
			}
			
		} else {
			$featured_gallery = true;
			
		}
	}	
	
	$show_cat = get_theme_mod( 'skin_blog_show_category', true );
	
	if ( 'image' === $p_format || 'link' === $p_format ) {
		$show_cat = false;
	}
	
	$show_date = get_theme_mod( 'skin_blog_show_date', true );
	$show_author = get_theme_mod( 'skin_blog_show_author', true );
	
	if ( 'image' === $p_format || 'link' === $p_format || 'quote' === $p_format ) {
		$show_date = false;
		$show_author = false;
	}
	
	$title_length = get_theme_mod( 'skin_blog_title_length', 13 );
	
	$show_excerpt = ( !$p_format || 'audio' === $p_format || 'video' === $p_format || 'gallery' === $p_format ) &&
		get_theme_mod( 'skin_blog_show_excerpt', false );
?>		
	<div class="masonry-item-wrapper">
		<div class="masonry-item">
			<div class="masonry-content">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php
					// Edit post link
						skin_edit_post();
						
					// Sticky post badge
					if ( is_home() && is_sticky( get_the_ID() ) ) {
				?>
					<div class="sticky-badge va-middle txt-color-to-bgr content-pad-to-svg"><?php echo skin_get_icon_sticky(); ?></div>
				<?php
					}
					// Trendy post badge
					if ( is_home() && true === get_theme_mod( 'skin_blog_trendy', true ) && skin_is_trendy_post() ) {
				?>
					<div class="trendy-badge va-middle small-item-bgr small-item-color"><?php echo skin_get_icon_trendy(); ?></div>
				<?php
					}
				?>
					<div class="featured-media"><?php						
					if ( $featured_gallery ) {
						$get_gallery_imgs = explode( ', ', skin_featured_area_get_meta( 'skin_featured_gallery' ) );
						
						if ( $get_gallery_imgs == [""] ) {
							$get_gallery_imgs = [];
						}
						
						$num_of_gallery_imgs = sizeof( $get_gallery_imgs );
						$gallery_limit = 9;
						
						if ( $num_of_gallery_imgs < 9 ) {
							if ( $num_of_gallery_imgs < 3 ) {
								$gallery_limit = $num_of_gallery_imgs;
								
							} else if ( $num_of_gallery_imgs > 2 && $num_of_gallery_imgs < 6 ) {
								$gallery_limit = 3;
								
							} else if ( $num_of_gallery_imgs > 5 ) {
								$gallery_limit = 6;
							}
						}
					?>
						<a href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>">
							<div class="featured-gallery clearfix"><?php				
								if ( is_array( $get_gallery_imgs ) ) :
									$i = 0;
									
									while ( $i < $gallery_limit ) :
									?>						
									<div class="img-wrapper">
										<?php
											echo wp_get_attachment_image( $get_gallery_imgs[$i], 'skin_small' );
											
											if ( $i == $gallery_limit-1 && $num_of_gallery_imgs > $gallery_limit) :
										?>									
										<div class="overlay va-middle">
											<span class="see-all"><?php
												echo skin_get_icon_eye();
												echo esc_html( number_format_i18n( $num_of_gallery_imgs ) );
											?></span>
										</div>
										<?php
											endif;
										?>
									</div>
									<?php
										$i++;
									endwhile;
								endif;
							?></div>
						</a>
					<?php
					} else {
						if ( $has_img ) {
						?>
							<div <?php skin_featured_img_class(); ?> data-img-ratio="<?php echo esc_attr( $img_ratio ); ?>" 
								style="background-image:url('<?php echo esc_url( $img_url ); ?>');"
							>
							<?php
								if ( ! ( 'image' === $p_format ) ) {
							?>
								<div class="shrinker content-pad-to-border"></div>
							<?php
								}
							?>
								<a href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"><?php
								if ( 'audio' === $p_format || 'video' === $p_format ) {
								?>
									<div class="post-format-icon round bouncer va-middle content-pad"><?php echo skin_get_post_format_icon(); ?></div>
								<?php
								} else if ( 'link' === $p_format || 'quote' === $p_format ) {
								?>
									<div class="post-format-icon round bouncer va-middle small-item-bgr small-item-color"><?php echo skin_get_post_format_icon(); ?></div>
								<?php
								}
								?></a>
							</div>
						<?php
						}
					}
					?></div>
					
					<header class="post-header shareable-selections content-pad"><div class="header-content"><?php
						if ( !$has_img && !$featured_gallery && $p_format ) {
					?>
						<div class="post-format-icon round bouncer va-middle small-item-bgr small-item-color"><?php echo skin_get_post_format_icon(); ?></div>
					<?php
						}
						
					// Post category
						if ( true === $show_cat ) {
							$p = ( '' !== skin_get_meta( 'skin_prioritize_cats' ) ) ? true : false;
							$l = get_theme_mod( 'skin_blog_limit_cats' );
					?>
						<div class="categories"><?php echo skin_get_post_categories( get_the_ID(), $p, $l ); ?></div>
					<?php
						}
						
					// Quotation in case of quote post format
						if ( 'quote' === $p_format && $featured_area_works && $quote = skin_featured_area_get_meta( 'skin_featured_quote' ) ) {
					?>
						<h3 class="quote shareable-selections">
							<a class="post-title masked-content" href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>">
								<div class="txt"><?php echo skin_highlight_searched_terms( esc_html( wp_trim_words( $quote, $title_length, '&hellip;' ) ) ); ?></div>
								<div class="mask to-top"><div class="mask-txt masked-txt"><?php echo skin_highlight_searched_terms( esc_html( wp_trim_words( $quote, $title_length, '&hellip;' ) ) ); ?></div></div>
							</a>
						</h3>
						<?php	
							if ( $quote_author = skin_featured_area_get_meta( 'skin_featured_quote_author' ) ) {
						?>
							<div class="quote-author post-details"><?php echo skin_highlight_searched_terms( esc_html( $quote_author ) ); ?></div>
						<?php
							}
							
					// Post title for image post format
						} else if ( 'image' === $p_format ) {
							if ( get_the_title( get_the_ID() ) ) {
						?>
							<h5>
								<span class="v-line top txt-color-to-bgr"></span>
								<a class="post-title cut-by-lines" data-lines-limit="3" href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"><?php
									echo skin_highlight_searched_terms( esc_html( get_the_title( get_the_ID() ) ) );
								?></a>
								<span class="v-line bottom txt-color-to-bgr"></span>
							</h5>
						<?php
							} else {
						?>
							<h5>
								<span class="v-line top txt-color-to-bgr"></span>
								<div class="post-title"><a class="link-button va-middle skin-outlined-bttn skin-anim-bttn" href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"><?php
									esc_html_e( 'View post', 'skin' );
								?></a></div>
								<span class="v-line bottom txt-color-to-bgr"></span>
							</h5>
						<?php
							}
							
					// Post title for link post format
						} else if ( 'link' === $p_format ) {
							if ( get_the_title( get_the_ID() ) ) {
						?>
							<h3>
								<a class="post-title masked-content" href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>">
									<div class="txt cut-by-lines" data-lines-limit="3"><?php echo skin_highlight_searched_terms( esc_html( get_the_title( get_the_ID() ) ) ); ?></div>
									<div class="mask to-left"><div class="mask-txt masked-txt cut-by-lines" data-lines-limit="3"><?php echo skin_highlight_searched_terms( esc_html( get_the_title( get_the_ID() ) ) ); ?></div></div>
								</a>
							</h3>
						<?php
							} else {
						?>
							<a class="link-button va-middle skin-outlined-bttn skin-anim-bttn" href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"><?php
								esc_html_e( 'View post', 'skin' );
							?></a>
						<?php
							}
							
						} else if ( get_the_title() ) {
					?>
						<h3>
							<a class="post-title masked-content" href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>">
								<div class="txt"><?php echo skin_highlight_searched_terms( esc_html( wp_trim_words( get_the_title(), $title_length, '&hellip;' ) ) ); ?></div>
								<div class="mask to-top"><div class="mask-txt masked-txt"><?php echo skin_highlight_searched_terms( esc_html( wp_trim_words( get_the_title(), $title_length, '&hellip;' ) ) ); ?></div></div>
							</a>
						</h3>
					<?php
					// Edge case: no title & no image
						} else {
					?>
						<a class="link-button va-middle skin-outlined-bttn skin-anim-bttn" href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"><?php
							esc_html_e( 'View post', 'skin' );
						?></a>
					<?php
						}
						
					// Excerpt
					if ( true === $show_excerpt ) {
					?>
					<div class="post-excerpt small-text shareable-selections clearfix"><?php skin_post_excerpt(); ?></div>
					<?php
					}
					?>
					<div class="post-details"><?php
					// Post author
						if ( true === $show_author ) {
							echo skin_post_author();
						}
						
						if ( true === $show_author && true === $show_date ) {
						?>
						<div class="divider-slash"></div>
						<?php
						}
							
					// Post date
						if ( true === $show_date ) {
							echo skin_post_date();
						}
					?></div>
					</div></header><!-- .post-header -->
				</article>
			</div>
		</div>
	</div>