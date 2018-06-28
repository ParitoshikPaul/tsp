<?php
/* ==============================================
	SINGLE PAGE TEMPLATE
	Skin - Premium WordPress Theme, by NordWood
================================================= */
	get_header();
	
	while( have_posts() ) :
		the_post();
		
		if ( 'slider-on' === skin_get_meta( 'skin_slider_on_page' ) ) {		
			if ( SKIN_WOOCOMMERCE_ACTIVE ) {
			/**
			 * skin_woo_before_wrapper hook.
			 *
			 * @hooked skin_woo_featured_area - 20
			 */
				do_action( 'skin_woo_before_wrapper' );
			}
			
			$auto = skin_get_meta( 'skin_slider_on_page_auto' );			
			$show_author = "show" === skin_get_meta( 'skin_slider_on_page_show_author' ) ?  true : false;
			$show_date = "show" === skin_get_meta( 'skin_slider_on_page_show_date' ) ?  true : false;
				
			if ( 'latest' === skin_get_meta( 'skin_slider_on_page_type' ) && 0 != skin_get_meta( 'skin_slider_on_page_qty' ) ) {
				$skip_cat		= explode( ',', get_theme_mod( 'skin_blog_skip_category' ) );
				$skip_author	= explode( ',', get_theme_mod( 'skin_blog_skip_author' ) );
				$qty			= skin_get_meta( 'skin_slider_on_page_qty' );
			
				$tag_slug__in = array();
				$recent_by_tag = skin_get_meta( 'skin_slider_feature_recent_by_tag' );
				
				if ( '' !== $recent_by_tag ) {
					$recent_by_tag_arr = explode( ',', $recent_by_tag );
					
					if ( is_array( $recent_by_tag_arr ) && 0 < sizeof( $recent_by_tag_arr ) ) {
						foreach ( $recent_by_tag_arr as $key => $val ) {
							if ( $recent_by_tag_arr[$key] ) {
								$tag_slug__in[] = $recent_by_tag_arr[$key];
							}
						}
					}
				}
				
				$recent_args = array(
					'numberposts' 			=> $qty,
					'orderby' 				=> 'date',
					'post_status' 			=> 'publish',
					'post_type' 			=> 'post',
					'order' 				=> 'DESC',
					'ignore_sticky_posts' 	=> 0,
					'category__not_in' 		=> $skip_cat,
					'author__not_in' 		=> $skip_author,
					'tag_slug__in' 			=> $tag_slug__in
				);
				
				$recent_posts = wp_get_recent_posts( $recent_args );
				$recent_ids = array();
				
				foreach ( $recent_posts as $r ) {
					$recent_ids[] = $r["ID"];
				}
				
				if( 1 > sizeof( $recent_ids ) ) {
					return '';
					
				} else {
					skin_posts_slider( $recent_ids, $auto, $show_author, $show_date );
				}
				
			} else if ( 'featured' === skin_get_meta( 'skin_slider_on_page_type' ) && '' != skin_get_meta( 'skin_slider_on_page_ids' ) ) {
				$featured_ids = skin_get_meta( 'skin_slider_on_page_ids' );
				$ids_arr = explode( ',', $featured_ids );
				
				if( !is_array( $ids_arr ) || 1 > sizeof( $ids_arr ) ) {
					return '';
					
				} else {
					foreach ( $ids_arr as $key => $val ) {
						if ( (int)$ids_arr[$key] ) {
							$ids[] = (int)$ids_arr[$key];
						}
					}
					
					skin_posts_slider( $ids, $auto, $show_author, $show_date );
				}
			}
		}
		
	// Post layout (sidebar options)
		$sidebar = skin_get_meta( 'skin_post_sidebar' );
		
		if ( 'no-sidebar' !== $sidebar ) {
			$sidebar = get_theme_mod( 'skin_post_sidebar', 'sidebar-right' );
		}
?>		
	<div class="main-holder content-wrapper clearfix">
		<main id="main" <?php skin_main_class(); ?>>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php skin_edit_page(); ?>
				
				<header class="post-header"><?php
					if ( 'hide-title' !== skin_get_meta( 'skin_hide_page_title' ) ) {
						the_title( '<h1>', '</h1>' );
					}					
				?></header>
				
				<div class="featured-area txt-color-light-to-border"><?php
				if ( has_post_thumbnail( get_the_ID() ) ) {
					$featured_img = ( 'show' === skin_get_meta( 'skin_featured_img' ) ) ? true : false;		
					
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
				<div class="post-content shareable-selections clearfix"><?php
					the_content();
					
					wp_link_pages( array(
						'before'      => '<div class="post-pagination pagination"><h5>' . esc_html__( 'Pages:', 'skin' ) . '</h5><div class="pages">',
						'after'       => '</div></div>',
						'link_before' => '<div class="link-button va-middle txt-color-light-to-border">',
						'link_after'  => '</div>',
						'pagelink'    => '%',
						'separator'   => '',
					));
				?></div>
				
			<?php
				// Get the sidebar '7' if it has active widgets
				if ( is_active_sidebar( 'sidebar-7' )  ) {
			?>
				<div id="sidebar-7" class="sidebar"><?php dynamic_sidebar( 'sidebar-7' ); ?></div>
			<?php
				}
			?>
			</article>
			
			<?php
				/**
				 * skin_woo_cart_collaterals hook.
				 *
				 * @hooked skin_woo_cart_collaterals_start
				 * @hooked woocommerce_cross_sell_display
				 * @hooked woocommerce_cart_totals - 10
				 * @hooked skin_woo_cart_collaterals_end - 10
				 */
				if ( SKIN_WOOCOMMERCE_ACTIVE ) {
					if ( is_cart() ) {
						do_action( 'skin_woo_cart_collaterals' );
					}
				}
			?>
			
			<?php						
		// Comments
			if ( false === get_theme_mod( 'skin_disable_wp_comments_on_pages', false ) ) {
				comments_template();
			}
			
		// Facebook comments
			$fb_comments = ( 'allow' === skin_get_meta( 'skin_allow_fb_comments' ) ) ? true : false;
			
			if ( true === $fb_comments ) {
				$clr = get_theme_mod( 'skin_fb_comments_color', 'light' );
			?>
			<div class="fb-comments content-pad" data-href="<?php echo esc_url( get_permalink() ); ?>" data-width="100%" data-numposts="5" data-colorscheme="<?php echo esc_attr( $clr ); ?>"></div>
			<?php
			}
			?>
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