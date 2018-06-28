<?php
/* ===================================================
	SEARCH RESULTS TEMPLATE
	Skin - Premium WordPress Theme, by NordWood
====================================================== */
	get_header();	

//	Get the queried term
	$search_query = get_search_query();
	
// Get the results from post content
	$a1 = array(
		'post_type'				=> 'post',
		'posts_per_page'		=> -1,
		'post_status'			=> 'publish',
		's'						=> $search_query,
		'ignore_sticky_posts'	=> 1
	);
	
// Get the results from quote and link fields
	$a2 = array(
		'post_type' => 'post',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'meta_query' => array(
			'relation' => 'OR',
			array(
			   'key'		=> 'skin_featured_quote',
			   'value'		=> $search_query,
			   'compare'	=> 'LIKE'
			),
			array(
			   'key'		=> 'skin_featured_quote_author',
			   'value'		=> $search_query,
			   'compare'	=> 'LIKE'
			),
			array(
			   'key'		=> 'skin_featured_link',
			   'value'		=> $search_query,
			   'compare'	=> 'LIKE'
			)
		 ),
		'ignore_sticky_posts' => 1
	);
	
// Get the results from categories and tags
	$a3 = array(
		'post_type'				=> 'post',
		'posts_per_page'		=> -1,
		'post_status'			=> 'publish',
		'tax_query'				=> array(
			'relation' => 'OR',
			array(
			   'taxonomy'	=> 'category',
			   'field'		=> 'name',
			   'terms'		=> $search_query
			),			
			array(
			   'taxonomy'	=> 'post_tag',
			   'field'		=> 'name',
			   'terms'		=> $search_query
			)
		),
		'ignore_sticky_posts'	=> 1
	);	

// Compile all the search results and remove the duplicates
	$q1 = new WP_Query( $a1 );
	$q2 = new WP_Query( $a2 );
	$q3 = new WP_Query( $a3 );
	
	$total = array();
	$total = array_merge($q1->posts,$q2->posts,$q3->posts );

	$ids = array();
	
	foreach ( $total as $item ) {
		$ids[] = $item->ID;
	}
	
	$s = array_unique( $ids );
	
	if ( !empty( $s ) ) :
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		
		$all_results = array(
			'post_type'				=> 'post',
			'post_status'			=> 'publish',
			'post__in'				=> $s,
			'posts_per_page'		=> get_option( 'posts_per_page' ),
			'paged'					=> $paged,		
			'ignore_sticky_posts'	=> 1
		);
		
		$results = new WP_Query( $all_results );
						
		if ( $results->have_posts() ) :
			$layout			= get_theme_mod( 'skin_search_layout', 'masonry-3' );
			$layout_type	= 'masonry';
			$sidebar		= 'no-sidebar';
			
			if ( false !== strpos( $layout, 'sidebar' ) ) {
				$sidebar = get_theme_mod( 'skin_blog_sidebar', 'sidebar-right' );
			}
			
			if ( false !== strpos( $layout, 'standard' ) ) {
				$layout_type = 'standard';
			}
		
			$qty = count( $s );			
			$post_order = 0;		
			$header_wrapper = 'normal';
			
			if ( false !== strpos( $layout, 'full' ) ) {
				$header_wrapper = 'full';
			}
			
			if ( false !== strpos( $layout, 'standard' ) && 'no-sidebar' === $sidebar ) {
				$header_wrapper = 'narrow';
			}
	?>
		<div class="archive-header" data-wrapper="<?php echo esc_attr( $header_wrapper ); ?>">
			<div class="content-wrapper">
				<table>
					<tr>
						<td class="content-pad">
							<h1><?php echo esc_html( number_format_i18n( $qty ) ); ?></h1>
							<h3><?php esc_html_e( 'Results', 'skin' ); ?></h3>
						</td>
						
						<td>
							<div class="content-pad"><?php get_search_form(); ?></div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	<?php	
	// Get the sidebar '3' if it has active widgets
		if ( is_active_sidebar( 'sidebar-3' )  ) {
	?>
		<div id="sidebar-3" class="sidebar"><?php dynamic_sidebar( 'sidebar-3' ); ?></div>
	<?php
		}
	?>		
		<div class="main-holder content-wrapper clearfix">			
			<main id="main" <?php skin_main_class(); ?>>			
				<div id="posts-list" <?php skin_posts_list_class(); ?>><?php 			
					if ( 'masonry' === $layout_type ) {
					// Check if the Popout special box is activated and get its positions
						$s_popout = get_theme_mod( 'skin_specials_popout_on', false ) && get_theme_mod( 'skin_search_specials_popout', false );
						$s_popout_start = get_theme_mod( 'skin_specials_popout_s', 3 );
						$s_popout_step = get_theme_mod( 'skin_specials_popout_i', 5 );
						
					// Check if the Image special boxes are activated and get the position for each:
						$s_image_1 = get_theme_mod( 'skin_specials_bnnr_on', false ) &&
							get_theme_mod( 'skin_specials_bnnr_1' ) &&
							get_theme_mod( 'skin_search_specials_bnnr_1' );
							
						$s_image_1_start = get_theme_mod( 'skin_specials_bnnr_s_1', 3 );
						$s_image_1_step = get_theme_mod( 'skin_specials_bnnr_i_1', 5 );
						
						$s_image_2 = get_theme_mod( 'skin_specials_bnnr_on', false ) &&
							get_theme_mod( 'skin_specials_bnnr_2' ) &&
							get_theme_mod( 'skin_search_specials_bnnr_2' );
							
						$s_image_2_start = get_theme_mod( 'skin_specials_bnnr_s_2', 3 );
						$s_image_2_step = get_theme_mod( 'skin_specials_bnnr_i_2', 5 );
						
						$s_image_3 = get_theme_mod( 'skin_specials_bnnr_on', false ) &&
							get_theme_mod( 'skin_specials_bnnr_3' ) &&
							get_theme_mod( 'skin_search_specials_bnnr_3' );
							
						$s_image_3_start = get_theme_mod( 'skin_specials_bnnr_s_3', 3 );
						$s_image_3_step = get_theme_mod( 'skin_specials_bnnr_i_3', 5 );
						
						$s_image_4 = get_theme_mod( 'skin_specials_bnnr_on', false ) &&
							get_theme_mod( 'skin_specials_bnnr_4' ) &&
							get_theme_mod( 'skin_search_specials_bnnr_4' );
							
						$s_image_4_start = get_theme_mod( 'skin_specials_bnnr_s_4', 3 );
						$s_image_4_step = get_theme_mod( 'skin_specials_bnnr_i_4', 5 );
						
						$s_image_5 = get_theme_mod( 'skin_specials_bnnr_on', false ) &&
							get_theme_mod( 'skin_specials_bnnr_5' ) &&
							get_theme_mod( 'skin_search_specials_bnnr_5' );
							
						$s_image_5_start = get_theme_mod( 'skin_specials_bnnr_s_5', 3 );
						$s_image_5_step = get_theme_mod( 'skin_specials_bnnr_i_5', 5 );
						
					// Check if the Social special box is activated and get its positions
						$s_social = get_theme_mod( 'skin_specials_social_on', false ) && get_theme_mod( 'skin_search_specials_social', false );
						$s_social_start = get_theme_mod( 'skin_specials_social_s', 3 );
						$s_social_step = get_theme_mod( 'skin_specials_social_i', 5 );
					
					// Check if the Popular/Latest Posts box is activated and get its positions
						$s_topposts = get_theme_mod( 'skin_specials_topposts_on', false ) && get_theme_mod( 'skin_search_specials_topposts', false );
						$s_topposts_start = get_theme_mod( 'skin_specials_topposts_s', 3 );
						$s_topposts_step = get_theme_mod( 'skin_specials_topposts_i', 5 );
				?>
					<div class="masonry-item-sizer"></div>
					<?php
					// Start the loop for masonry layout
						while ( $results->have_posts() ) :
							$results->the_post();
							
							$item_order = ($paged-1)*get_option( 'posts_per_page' ) + $post_order;
				
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
							
							get_template_part( 'template-parts/content', 'masonry' );
							
							$post_order++;
						endwhile;
							
					} else {
					// Start the loop for standard layout
						while ( $results->have_posts() ) :
							$results->the_post();
							
							get_template_part( 'template-parts/content', 'standard' );
						endwhile;
					}			
				?></div><!-- End posts list -->
			<?php
				skin_posts_pagination( $results->max_num_pages, "2", $paged );
				wp_reset_postdata();
				
				echo skin_loading_posts();
			?>
			</main><!-- Close main holder -->
	<?php			
		endif;
	
		if( 'no-sidebar' !== $sidebar ) {
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