<?php
/* ==============================================
	SINGLE POST TEMPLATE
	Skin - Premium WordPress Theme, by NordWood
================================================= */
	get_header();
	
	while ( have_posts() ) :
		the_post();
	
		skin_set_post_views();
		
		$ignore_global = skin_get_meta( 'skin_ignore_global' );		
		$post_format = get_post_format( get_the_ID() );
		
	// Check if the Skin Featured Area plugin is activated
		$featured_area_works = function_exists( 'skin_featured_area_get_meta' );
		
	// Post layout (sidebar options)
		$sidebar = 'no-sidebar';
			
		if ( 'ignore' === $ignore_global ) {
			$sidebar = skin_get_meta( 'skin_post_sidebar' );
			
			if ( 'no-sidebar' !== $sidebar ) {
				$sidebar = get_theme_mod( 'skin_post_sidebar', 'sidebar-right' );
			}
			
		} else {
			$sidebar = get_theme_mod( 'skin_post_sidebar', 'sidebar-right' );
		}
		
	// Check if category should appear
		$show_cat = false;
		
		if ( 'ignore' === $ignore_global ) {
			if ( 'show' === skin_get_meta( 'skin_show_category' ) ) {
				$show_cat = true;
			}
			
		} else {
			if ( true === get_theme_mod( 'skin_cat_in_header', true ) ) {
				$show_cat = true;
			}
		}
		
	// Check if date should appear
		$show_date = false;
		
		if ( 'ignore' === $ignore_global ) {
			if ( 'show' === skin_get_meta( 'skin_show_date' ) ) {
				$show_date = true;
			}
			
		} else {
			if ( get_theme_mod( 'skin_date_in_header', true ) ) {
				$show_date = true;
			}
		}
		
	// Check if author should appear
		$show_author = false;
		
		if ( 'ignore' === $ignore_global ) {
			if ( 'show' === skin_get_meta( 'skin_show_author' ) ) {
				$show_author = true;
			}
			
		} else {
			if ( get_theme_mod( 'skin_author_in_header', true ) ) {
				$show_author = true;
			}
		}
?>	
	<div class="main-holder content-wrapper clearfix">
		<main id="main" <?php skin_main_class(); ?> >
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="post-header"><?php
				// Edit post
					skin_edit_post();
					
				// Post category
					if ( true === $show_cat ) {
						$p = ( '' !== skin_get_meta( 'skin_prioritize_cats' ) ) ? true : false;
						$l = get_theme_mod( 'skin_post_limit_cats' );
				?>
					<div class="categories"><?php echo skin_get_post_categories( get_the_ID(), $p, $l ); ?></div>
				<?php
					}					
				// Post title
				?>
					<h1 class="post-title"><?php
						if ( 'link' === $post_format || 'quote' === $post_format ) {
					?>
						<div class="post-format-icon txt-color-pale-to-svg"><?php echo skin_get_post_format_icon(); ?></div>
					<?php
						}
						
						if ( "quote" === $post_format && $featured_area_works && $quote = skin_featured_area_get_meta( 'skin_featured_quote' ) ) {
							printf(
								'<span>%s</span>',
								esc_html( $quote )
							);
							
						} else {
							printf(
								'<span>%s</span>',
								esc_html( get_the_title() )
							);
						}
					?></h1>
					
				<?php
				// Quote author
					if ( "quote" === $post_format && $featured_area_works && $quote_author = skin_featured_area_get_meta( 'skin_featured_quote_author' ) ) {
						printf(
							'<h3>&dash; %s</h3>',
							esc_html( $quote_author )
						);
					}
					
				// Link URL
					if ( "link" === $post_format && $featured_area_works && $link_url = skin_featured_area_get_meta( 'skin_featured_link' ) ) {
						printf(
							'<h3><a href="%1$s" target="_blank">%2$s</a></h3>',
							esc_url( $link_url ),
							esc_html( $link_url )
						);
					}
				?>					
					<div class="share-details">
					<?php
					// Share
						if ( true === get_theme_mod( 'skin_share_in_header', true ) ) {
							$share_heading = get_theme_mod( 'skin_share_heading', esc_html__( 'Share', 'skin' ) );
							
							$socials = get_theme_mod( 'skin_sharing_links' );
							$profiles = explode( '-network-', $socials );			
							array_shift( $profiles );
							
							$profiles_qty = count( $profiles );
							
							$profiles_qty_class = ( 4 < $profiles_qty ) ? 'wide' : 'small va-middle';
						?>
						<div class="share <?php echo esc_attr( $profiles_qty_class ); ?>">
							<div class="share-heading txt-color-to-svg"><?php echo skin_get_icon_share(); ?><h5><?php echo esc_html( $share_heading ); ?></h5></div>							
							<div class="share-icons"><?php echo skin_share_buttons(); ?></div>
						</div>
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
					</div>
				</header>
				
				<div class="featured-area txt-color-light-to-border"><?php
				if ( function_exists( 'skin_featured_area_get_meta' ) ) {
					skin_post_featured_media();
					
				} else if ( has_post_thumbnail( get_the_ID() ) ) {
					$featured_img = false;
					
					if ( 'ignore' === $ignore_global ) {
						$featured_img = ( 'show' === skin_get_meta( 'skin_featured_img' ) ) ? true : false;						
						
					} else {
						$featured_img = get_theme_mod( 'skin_post_featured_img', true );
					}
					
					if ( true === $featured_img ) {
					?>
						<div class="featured-img"><?php echo skin_get_giffy_featured_img( get_the_ID(), 'skin_wrapper_width' ); ?></div>
					<?php
					}
				}
				?></div>
				
			<?php
				// Get the sidebar '6' if it has active widgets
				if ( is_active_sidebar( 'sidebar-6' )  ) {
			?>
				<div id="sidebar-6" class="sidebar"><?php dynamic_sidebar( 'sidebar-6' ); ?></div>
			<?php
				}
			?>
				
				<div class="post-content main-content shareable-selections clearfix"><?php
					the_content();
					
					wp_link_pages( array(
						'before'      => '<div class="post-pagination pagination"><h5>' . esc_html__( 'Pages:', 'skin' ) . '</h5><div class="pages">',
						'after'       => '</div></div>',
						'link_before' => '<div class="link-button va-middle">',
						'link_after'  => '</div>',
						'pagelink'    => '%',
						'separator'   => '',
					));
				?></div>
				
				<div class="post-footer"><?php					
				// Share
					if ( true === get_theme_mod( 'skin_share_in_post_footer', true ) ) {
						$share_heading = get_theme_mod( 'skin_share_heading', esc_html__( 'Share', 'skin' ) );
					?>
					<div class="share va-middle">
						<div class="share-heading txt-color-to-svg"><?php echo skin_get_icon_share(); ?><h5><?php echo esc_html( $share_heading ); ?></h5></div>						
						<div class="share-icons"><?php echo skin_share_buttons(); ?></div>
					</div>
					<?php
					}					
				// Tagcloud
				?>
					<div class="tagcloud clearfix"><?php
					$show_tagcloud = false;
					
					if ( 'ignore' === $ignore_global ) {
						$show_tagcloud = ( 'show' === skin_get_meta( 'skin_show_tagcloud' ) ) ? true : false;						
						
					} else {
						$show_tagcloud = get_theme_mod( 'skin_show_tagcloud', true );
					}
					
					if ( true === $show_tagcloud ) {
						echo skin_post_tag_cloud();
					}
					?></div>
				</div>				
			<?php
				// Get the sidebar '7' if it has active widgets
				if ( is_active_sidebar( 'sidebar-7' )  ) {
			?>
				<div id="sidebar-7" class="sidebar"><?php dynamic_sidebar( 'sidebar-7' ); ?></div>
			<?php
				}
			?>
			</article>
			
			<div class="related-posts-box content-pad"><?php			
			// Related posts
				if ( true === get_theme_mod( 'skin_post_show_related', true ) ) {
					$heading = get_theme_mod( 'skin_post_related_heading', esc_html__( 'You may also like', 'skin' ) );
					echo skin_related_posts( $heading );
				}
			?></div>
			
			<div class="author-bio gradient-bgr txt-on-gradient clearfix"><?php
			// Author
				$show_author_bio = false;
				
				if ( 'ignore' === $ignore_global ) {
					if ( 'show' === skin_get_meta( 'skin_show_author_bio' ) ) {
						$show_author_bio = true;
					}
					
				} else {
					if ( true === get_theme_mod( 'skin_show_author_bio', false ) ) {
						$show_author_bio = true;
					}
				}
				
				if ( true === $show_author_bio && ( '' !== get_the_author_meta( 'description' ) ) ) {
					$author_id = get_post_field( 'post_author', get_the_ID() );
					$avatar_url = get_avatar_url( $author_id, array( 'size' => 118 ) );
				?>
					<div class="photo"><div class="avatar round bgr-cover" style="background-image:url('<?php echo esc_url( $avatar_url ); ?>');"></div></div>
					
					<div class="text shareable-selections">
						<h3><?php the_author_meta( 'nickname' ) ?></h3>
						<p><?php the_author_meta( 'description' ) ?></p>
					</div>							
				<?php
				}
			?></div>			
			<?php
		// Comments
			if ( false === get_theme_mod( 'skin_disable_wp_comments_on_posts', false ) ) {
				comments_template();
			}			
			?>
			<div id="fb-comments"><?php
			// Facebook comments
				$fb_comments = false;
				
				if ( 'ignore' === $ignore_global ) {
					if ( 'allow' === skin_get_meta( 'skin_allow_fb_comments' ) ) {
						$fb_comments = true;
					}
					
				} else {
					if ( true === get_theme_mod( 'skin_allow_fb_comments', false ) ) {
						$fb_comments = true;
					}
				}
				
				if ( true === $fb_comments ) {
					$clr = get_theme_mod( 'skin_fb_comments_color', 'light' );
				?>
				<div class="fb-comments content-pad" data-href="<?php echo esc_url( get_permalink() ); ?>" data-width="100%" data-numposts="5" data-colorscheme="<?php echo esc_attr( $clr ); ?>"></div>
				<?php
				}
			?></div>
		</main><!-- Close main holder -->
<?php
	if ( 'no-sidebar' !== $sidebar ) {
		get_sidebar();
	}
?>
	</div>
<?php
	endwhile;
	
	get_footer();
?>