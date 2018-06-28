<?php
/* ===========================
	SINGLE POPOUT TEMPLATE
	Skin Popout Pages plugin
=============================== */
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
		?>		
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php
			// Featured image				
				if ( has_post_thumbnail() ) {
					$img_id = get_post_thumbnail_id( get_the_ID() );					
					$img_size = wp_get_attachment_metadata( $img_id );
					$img_w = $img_size['width'];
					$img_h = $img_size['height'];
					$img_ratio = $img_w/$img_h;
					
					$img_url = skin_get_giffy_attachment_url( $img_id );
				?>
					<div class="popout-featured-image"
						data-img-w="<?php echo esc_attr( $img_w ); ?>"
						data-img-ratio="<?php echo esc_attr( $img_ratio ); ?>"
						style="background-image:url('<?php echo esc_url( $img_url ); ?>');">
					<?php				
						if ( $img_link = esc_url( skin_popout_get_meta( 'skin_popout_img_link' ) ) ) {
							$img_link_target = ( 'new-tab' === skin_popout_get_meta( 'skin_popout_img_link_new_tab' ) ) ? '_blank' : '_self';
					?>
						<a href="<?php echo esc_url( $img_link ); ?>" target="<?php echo esc_attr( $img_link_target ); ?>"></a>
					<?php
						}				
					?>
					</div>
				<?php
				}				
			// Main content
			?>
				<div class="popout-content post-content clearfix"><?php the_content(); ?></div>
			<?php			
			// Edit popout
				if ( function_exists( 'skin_edit_post' ) ) {
					skin_edit_post();
					
				} else {
					edit_post_link(
						esc_html__( 'Edit this popout', 'skin-popout-pages' ),
						'<span class="edit-link">',
						'</span>'
					);
				}
			?></article>
		<?php
		endwhile;
	endif;
?>