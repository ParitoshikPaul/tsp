<?php
/* ==============================================
	QUICK SEARCH RESULTS template part
	Skin - Premium WordPress Theme, by NordWood
================================================= */
//	Get the typed term
	$qs_query = $_POST['search_string'];
	
	if ( '' === $qs_query ) {
		return '';
	
	} else {
	
// Get the results from post content	
	$a1 = array(
		'post_type'				=> 'post',
		'posts_per_page'		=> -1,
		'post_status'			=> 'publish',
		's'						=> $qs_query,
		'ignore_sticky_posts'	=> 1
	);
	
// Get the results from quote and link fields
	$a2 = array(
		'post_type'				=> 'post',
		'posts_per_page'		=> -1,
		'post_status'			=> 'publish',
		'meta_query'			=> array(
			'relation' => 'OR',
			array(
			   'key'		=> 'skin_featured_quote',
			   'value'		=> $qs_query,
			   'compare'	=> 'LIKE'
			),
			array(
			   'key'		=> 'skin_featured_quote_author',
			   'value'		=> $qs_query,
			   'compare'	=> 'LIKE'
			),
			array(
			   'key'		=> 'skin_featured_link',
			   'value'		=> $qs_query,
			   'compare'	=> 'LIKE'
			)
		),
		'ignore_sticky_posts'	=> 1
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
			   'terms'		=> $qs_query
			),			
			array(
			   'taxonomy'	=> 'post_tag',
			   'field'		=> 'name',
			   'terms'		=> $qs_query
			)
		),
		'ignore_sticky_posts'	=> 1
	);	

// Compile all the search results and remove the duplicates
	$q1 = new WP_Query( $a1 );
	$q2 = new WP_Query( $a2 );
	$q3 = new WP_Query( $a3 );
	
	$total = array();
	$total = array_merge( $q1->posts, $q2->posts, $q3->posts );

	$ids = array();
	
	foreach ( $total as $item ) {
		$ids[] = $item->ID;
	}
	
	$s = array_unique( $ids );
	
	if ( !empty( $s ) ) :
		$all_results = array(
			'post_type'				=> 'post',
			'post_status'			=> 'publish',
			'post__in'				=> $s,
			'posts_per_page'		=> -1,
			'ignore_sticky_posts'	=> 1
		);
		
		$results = new WP_Query( $all_results );
						
		if ( $results->have_posts() ) :		
			$qty = count( $s );			
		?>		
		<div class="clearfix">
		<?php 
			while ( $results->have_posts() ) :
				$results->the_post();
				
				$thumb_url = '';				
				
				if ( get_post_meta( get_the_ID(), 'skin_post_tiny_gif', true ) ) {
					$thumb_id = get_post_meta( get_the_ID(), 'skin_post_tiny_gif', true );
					$thumb_url = skin_get_giffy_attachment_url( $thumb_id, 'skin_small' );
					
				} else if ( skin_get_meta( 'skin_post_img_in_list' ) ) {
					$thumb_id = skin_get_meta( 'skin_post_img_in_list' );
					$thumb_url = skin_get_giffy_attachment_url( $thumb_id, 'skin_small' );
					
				} else if ( has_post_thumbnail( get_the_ID() ) ) {
					$thumb_url = skin_get_giffy_featured_img_url( get_the_ID(), 'skin_small' );	
					
				} else if ( 'gallery' === get_post_format( get_the_ID() ) && function_exists( 'skin_featured_area_get_meta' ) ) {					
					$featured_gallery = skin_featured_area_get_meta( 'skin_featured_gallery' );
					$get_gallery_imgs = explode( ', ', $featured_gallery );
					
					if ( [""] === $get_gallery_imgs ) {
						$get_gallery_imgs = [];
					}
					
					if ( is_array( $get_gallery_imgs ) && !empty( $get_gallery_imgs ) ) {
						$thumb_id = $get_gallery_imgs[0];
						$thumb_url = skin_get_giffy_attachment_url( $thumb_id, 'skin_small' );	
					}					
				}
				
				if ( '' == $thumb_url && $img_placeholder = get_theme_mod( 'skin_img_placeholder' ) ) {
					$thumb_url = $img_placeholder;
				}
				
				$c_link		= get_post_meta( get_the_ID(), 'skin_custom_post_link', true );
				$c_target	= get_post_meta( get_the_ID(), 'skin_custom_post_link_target', true );	
				$p_link		= $c_link ? $c_link : get_permalink( get_the_ID() );
				$p_target	= ( 'new-tab' === $c_target ) ? '_blank' : '_self';
			?>
				<div class="post-item clearfix">
					<table>
						<td class="thumb"><?php	
							if ( '' != $thumb_url ) {
						?>
							<a href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"
								class="round bgr-cover"
								style="background-image:url('<?php echo esc_url( $thumb_url ); ?>');"
							></a>								
						<?php
							} else {
						?>
							<a href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"
								class="round gradient-bgr-vert txt-on-gradient"
							></a>								
						<?php
							}
						?></td>
						
						<td class="text">
							<h5><a class="link-hov-main" data-lines-limit="3" href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"><?php
								echo esc_html( get_the_title( get_the_ID() ) );
							?></a></h5>
							
							<div class="post-details"><?php
							if ( true === get_theme_mod( 'skin_blog_show_date', true ) ) {
								echo skin_post_date();
							}
							?></div>
						</td>
					</table>
				</div>
			<?php
			endwhile;
			
			wp_reset_postdata();
		endif;
	?>
		</div>	
	<?php
	endif;
	}
?>