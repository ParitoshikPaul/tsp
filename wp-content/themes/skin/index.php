<?php
/* ==============================================
	HOME PAGE TEMPLATE
	Skin - Premium WordPress Theme, by NordWood
================================================= */
	get_header();
	
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	
// Pagination type
	$infinite = ( 'infinite' === get_theme_mod( 'skin_blog_pagination_type', 'infinite' ) ) ? true : false;
	
// Check if there are categories or authors to be excluded
	$skip_cat		= explode( ',', get_theme_mod( 'skin_blog_skip_category' ) );
	$skip_author	= explode( ',', get_theme_mod( 'skin_blog_skip_author' ) );
	
// Posts to skip in the list
	$skip_posts = array();
	
// Check if there are sticky posts
	$stickies = get_option( 'sticky_posts' );
	
// Check if there are posts in featured area	
	$featured				= get_theme_mod( 'skin_blog_featured', 'skip' );
	$featured_post_id		= get_theme_mod( 'skin_blog_enlarged_id' );
	$grid_ids				= get_theme_mod( 'skin_blog_grid_ids' );
	$slider_ids				= get_theme_mod( 'skin_blog_slider_ids' );
	$slider_ids_arr			= array();
	$skip_featured_posts	= get_theme_mod( 'skin_blog_skip_featured', false );
	
	if ( 'welcome-mssg' === $featured ) {
		$welcome_mssg = get_theme_mod( 'skin_blog_welcome_mssg' );
	?>
		<div class="welcome-mssg content-wrapper"><?php echo esc_html( $welcome_mssg ); ?></div>
	<?php
	}
	
	if ( 'skip' !== $featured && 'welcome-mssg' !== $featured ) {
	// Enlarged featured post
		if (
			'enlarge-featured' === $featured && $featured_post_id &&
				skin_post_exist( $featured_post_id ) &&
				( 'post' === get_post_type( $featured_post_id ) || 'page' === get_post_type( $featured_post_id ) ) &&
				! ( 1 < $paged && true === $infinite )
		) {
		?>
			<div class="blog-featured"><?php skin_post_enlarged( $featured_post_id ); ?></div>
		<?php
		/*
			If enlarged post should not repeat in the list,
			add it to 'skip' array
		*/
			if ( true === $skip_featured_posts ) {
				$skip_posts[] = $featured_post_id;
			}
		}
		
	// Grid with featured posts
		if ( 'grid-featured' === $featured && '' != $grid_ids && ! ( 1 < $paged && true === $infinite ) ) {				
		// Check if the user's string of IDs can be converted to a valid array
			$grid_ids_arr = explode( ',', $grid_ids );
			$ids_arr = array();
			
			if ( is_array( $grid_ids_arr ) && 2 < sizeof( $grid_ids_arr ) ) {
				foreach ( $grid_ids_arr as $key => $val ) {
					$id = $grid_ids_arr[$key];
					
					if ( skin_post_exist( $id ) && ( 'post' === get_post_type( $id ) || 'page' === get_post_type( $id ) ) ) {
						$ids_arr[] = $id;						
					/*	
						If featured posts from the grid should not repeat in the list,
						add them to 'skip' array
					*/
						if ( true === $skip_featured_posts ) {
							$skip_posts[] = $id;
						}
					}
				}
			?>
				<div class="blog-featured"><?php skin_posts_grid( $ids_arr ); ?></div>
			<?php
			}
		}
		
	// Slider with featured posts
		if ( 'slider-featured' === $featured && '' != $slider_ids ) {
		// Check if the user's string of IDs can be converted to a valid array
			$slider_ids_arr = explode( ',', $slider_ids );
			
			if ( is_array( $slider_ids_arr ) && 0 < sizeof( $slider_ids_arr ) ) {
				foreach ( $slider_ids_arr as $key => $val ) {
					if ( (int)$slider_ids_arr[$key] ) {
						$ids_arr[] = (int)$slider_ids_arr[$key];						
					/*
						If the posts from the slider should not repeat in the list,
						add them to 'skip' array
					*/
						if ( true === $skip_featured_posts ) {
							$skip_posts[] = (int)$slider_ids_arr[$key];
						}
					}
				}
				
				$autoplay = get_theme_mod( 'skin_blog_slider_auto', false );
				$auto = $autoplay ? 'auto' : '';
				$show_author = get_theme_mod( 'skin_featured_show_author', true );
				$show_date = get_theme_mod( 'skin_featured_show_date', true );
			?>
				<div class="blog-featured"><?php skin_posts_slider( $ids_arr, $auto, $show_author, $show_date ); ?></div>
			<?php
			}
		}
		
	// Latest posts in featured area
		$recent_ids_arr = array();
		
		if ( false !== strpos( $featured, 'latest' ) ) {
			$qty = 1;
			
			if ( false !== strpos( $featured, 'grid' ) ) {
				$qty = 3;				
			}
			
			if ( false !== strpos( $featured, 'slider' ) ) {
				$qty = get_theme_mod( 'skin_blog_slider_count', 5 );
			}
			
			$tag_slug__in = array();
			$recent_by_tag = get_theme_mod( 'skin_blog_feature_recent_by_tag' );
			
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
			$recent_ids_arr = array();
			
			foreach ( $recent_posts as $r ) {
				$recent_ids_arr[] = $r["ID"];
			}
			
		// Enlarged latest post
			if ( 'enlarge-latest' === $featured && 0 < sizeof( $recent_ids_arr ) ) {
				$latest_id = $recent_ids_arr[0];
				
				if ( !( 1 < $paged && true === $infinite ) ) {
					skin_post_enlarged( $latest_id );
				}				
			/*
				If the latest post should not repeat in the list,
				add it to 'skip' array
			*/
				if ( true === $skip_featured_posts ) {
					$skip_posts[] = $latest_id;
				}
				
		// Grid with latest posts
			} else if ( 'grid-latest' === $featured && 2 < sizeof( $recent_ids_arr ) ) {
				skin_posts_grid( $recent_ids_arr );				
			/*
				If posts from the grid should not repeat in the list,
				add them to 'skip' array
			*/
				if ( true === $skip_featured_posts ) {
					foreach( $recent_ids_arr as $rid ) {
						$skip_posts[] = $rid;
					}
				}
				
		// Slider with latest posts
			} else if ( 'slider-latest' === $featured && 2 < sizeof( $recent_ids_arr ) ) {				
				$autoplay = get_theme_mod( 'skin_blog_slider_auto', false );
				$auto = $autoplay ? 'auto' : '';
				$show_author = get_theme_mod( 'skin_featured_show_author', true );
				$show_date = get_theme_mod( 'skin_featured_show_date', true );
				
				skin_posts_slider( $recent_ids_arr, $auto, $show_author, $show_date );
			/*
				If posts from the slider should not repeat in the list,
				add them to 'skip' array
			*/				
				if ( true === $skip_featured_posts ) {
					foreach ( $recent_ids_arr as $rid ) {
						$skip_posts[] = $rid;
					}
				}
			}
		}
	}
	
// Get the sidebar '3' if it has active widgets
	if ( is_active_sidebar( 'sidebar-3' )  ) {
?>
		<div id="sidebar-3" class="sidebar"><?php dynamic_sidebar( 'sidebar-3' ); ?></div>
<?php
	}
	
// Start the query for posts list
	$skip_posts = array_unique( $skip_posts );
	
	$latest_args = array(
		'post_type' 			=> 'post',
		'post_status' 			=> 'publish',
		'category__not_in'		=> $skip_cat,
		'author__not_in' 		=> $skip_author,
		'posts_per_page' 		=> get_option( 'posts_per_page' ),
		'paged' 				=> $paged,
		'ignore_sticky_posts'	=> 0,
		'post__not_in'			=> $skip_posts
	);

	$latest_query = new WP_Query( $latest_args );
	
	if ( $latest_query->have_posts() ) :
		$layout = get_theme_mod( 'skin_blog_layout', 'masonry-3' );
		$layout_type = 'masonry';
		$sidebar = 'no-sidebar';
		
		if ( false !== strpos( $layout, 'sidebar' ) ) {
			$sidebar = get_theme_mod( 'skin_blog_sidebar', 'sidebar-right' );
		}
		
		if ( false !== strpos( $layout, 'standard' ) ) {
			$layout_type = 'standard';
		}
		
		$post_order = 0;
	?>
		<div class="main-holder content-wrapper clearfix">
			<main id="main" <?php skin_main_class(); ?>>
				<div id="posts-list" <?php skin_posts_list_class(); ?>><?php
				// Posts list
					if ( 'masonry' === $layout_type ) {
				?>
					<div class="masonry-item-sizer"></div>
					<?php
					// List the sticky posts first (first page only)
						if ( 1 == $paged && !empty( $stickies ) ) {
							global $post;
							$bckp = $post;
							$sticky_args = array(
								'post_type'			=> 'post',
								'post_status'		=> 'publish',
								'category__not_in'	=> $skip_cat,
								'author__not_in'	=> $skip_author,
								'post__in'			=> $stickies
							);
								
							$sticky_query = new WP_Query( $sticky_args );
							
							if ( $sticky_query->have_posts() ) :
								while ( $sticky_query->have_posts() ) :
									$sticky_query->the_post();
									
									get_template_part( 'template-parts/content', 'masonry' );
								endwhile;
								
								wp_reset_postdata();
								$post = $bckp;
								
							endif;
						}
						
					// Check if the Image special boxes are activated and get the position for each:
						$s_image_1 = get_theme_mod( 'skin_specials_bnnr_on', false ) && get_theme_mod( 'skin_specials_bnnr_1' );
						$s_image_1_start = get_theme_mod( 'skin_specials_bnnr_s_1', 3 );
						$s_image_1_step = get_theme_mod( 'skin_specials_bnnr_i_1', 5 );
						
						$s_image_2 = get_theme_mod( 'skin_specials_bnnr_on', false ) && get_theme_mod( 'skin_specials_bnnr_2' );
						$s_image_2_start = get_theme_mod( 'skin_specials_bnnr_s_2', 3 );
						$s_image_2_step = get_theme_mod( 'skin_specials_bnnr_i_2', 5 );
						
						$s_image_3 = get_theme_mod( 'skin_specials_bnnr_on', false ) && get_theme_mod( 'skin_specials_bnnr_3' );
						$s_image_3_start = get_theme_mod( 'skin_specials_bnnr_s_3', 3 );
						$s_image_3_step = get_theme_mod( 'skin_specials_bnnr_i_3', 5 );
						
						$s_image_4 = get_theme_mod( 'skin_specials_bnnr_on', false ) && get_theme_mod( 'skin_specials_bnnr_4' );
						$s_image_4_start = get_theme_mod( 'skin_specials_bnnr_s_4', 3 );
						$s_image_4_step = get_theme_mod( 'skin_specials_bnnr_i_4', 5 );
						
						$s_image_5 = get_theme_mod( 'skin_specials_bnnr_on', false ) && get_theme_mod( 'skin_specials_bnnr_5' );
						$s_image_5_start = get_theme_mod( 'skin_specials_bnnr_s_5', 3 );
						$s_image_5_step = get_theme_mod( 'skin_specials_bnnr_i_5', 5 );
					
					// Check if the Popout special box is activated and get its positions
						$s_popout = get_theme_mod( 'skin_specials_popout_on', false );
						$s_popout_start = get_theme_mod( 'skin_specials_popout_s', 3 );
						$s_popout_step = get_theme_mod( 'skin_specials_popout_i', 5 );
					
					// Check if the Social special box is activated and get its positions
						$s_social = get_theme_mod( 'skin_specials_social_on', false );
						$s_social_start = get_theme_mod( 'skin_specials_social_s', 3 );
						$s_social_step = get_theme_mod( 'skin_specials_social_i', 5 );
					
					// Check if the Popular/Latest Posts box is activated and get its positions
						$s_topposts = get_theme_mod( 'skin_specials_topposts_on', false );
						$s_topposts_start = get_theme_mod( 'skin_specials_topposts_s', 3 );
						$s_topposts_step = get_theme_mod( 'skin_specials_topposts_i', 5 );
						
					// Start the loop for masonry layout
						while ( $latest_query->have_posts() ) :
							$latest_query->the_post();
							
							if ( !in_array( get_the_ID(), $skip_posts ) && !( in_array( get_the_ID(), $stickies ) && 1 == $paged ) ) {
								$item_order = ( $paged-1 )*get_option( 'posts_per_page' ) + $post_order;
								
								skin_render_special_widgets( $item_order );
				
							// Render Popout box, if it's its turn to show up
								if ( skin_specials_item_order( $s_popout, $s_popout_start, $s_popout_step, $item_order ) ) {
									skin_specials_render_popout();
								}
								
							// Render each of the Image Banner boxes, if it's its turn to show up
								if ( skin_specials_item_order( $s_image_1, $s_image_1_start, $s_image_1_step, $item_order ) ) {
									skin_specials_render_image_1();
								}
				
								if ( skin_specials_item_order( $s_image_2, $s_image_2_start, $s_image_2_step, $item_order ) ) {
									skin_specials_render_image_2();
								}
				
								if ( skin_specials_item_order( $s_image_3, $s_image_3_start, $s_image_3_step, $item_order ) ) {
									skin_specials_render_image_3();
								}
				
								if ( skin_specials_item_order( $s_image_4, $s_image_4_start, $s_image_4_step, $item_order ) ) {
									skin_specials_render_image_4();
								}
				
								if ( skin_specials_item_order( $s_image_5, $s_image_5_start, $s_image_5_step, $item_order ) ) {
									skin_specials_render_image_5();
								}
				
							// Render Social box, if it's its turn to show up
								if ( skin_specials_item_order( $s_social, $s_social_start, $s_social_step, $item_order ) ) {
									skin_specials_render_social();
								}
					
							// Render Popular/Latest Posts box, if it's its turn to show up
								if ( skin_specials_item_order( $s_topposts, $s_topposts_start, $s_topposts_step, $item_order ) ) {
									skin_specials_render_topposts();
								}
								
							// Get the next post from the list
								get_template_part( 'template-parts/content', 'masonry' );
								
								$post_order++;
							}
							
						endwhile;
							
					} else {
						
					// List the sticky posts first (first page only)
						if ( 1 == $paged && !empty( $stickies ) ) {
							global $post;
							$bckp = $post;
							
							$sticky_args = array(
								'post_type' 			=> 'post',
								'post_status' 			=> 'publish',
								'category__not_in'		=> $skip_cat,
								'author__not_in' 		=> $skip_author,
								'ignore_sticky_posts'	=> 0,
								'post__in' 				=> $stickies
							);
								
							$sticky_query = new WP_Query( $sticky_args );
							
							if ( $sticky_query->have_posts() ) :
							
								while ( $sticky_query->have_posts() ) :
									$sticky_query->the_post();
									
									get_template_part( 'template-parts/content', 'standard' );
								endwhile;
								
								wp_reset_postdata();
								$post = $bckp;
								
							endif;
						}
						
					// Start the loop for standard layout
						while ( $latest_query->have_posts() ) :
							$latest_query->the_post();
							
							if ( !in_array( get_the_ID(), $skip_posts ) && !( in_array( get_the_ID(), $stickies ) && 1 == $paged ) ) {
								get_template_part( 'template-parts/content', 'standard' );
							}
						
						endwhile;
					}
						
				?></div><!-- End posts list -->
			<?php
				skin_posts_pagination( $latest_query->max_num_pages, "1", $paged );
				wp_reset_postdata();
				
				echo skin_loading_posts();
			?>
			</main><!-- Close main holder -->			
	<?php
		if ( 'no-sidebar' !== $sidebar ) {
			get_sidebar();
		}
	?>
		</div>
	<?php
	else :
		get_template_part( 'template-parts/content', 'none' );
	endif;	
	
	get_footer();
?>