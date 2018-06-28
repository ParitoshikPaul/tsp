<?php
/* ===============================================
	STANDARD LAYOUT template part
	Skin - Premium WordPress Theme, by NordWood
================================================== */
	$ignore_global			= skin_get_meta( 'skin_ignore_global' );
	$post_format			= get_post_format();
	$featured_area_works 	= function_exists( 'skin_featured_area_get_meta' );
	
	$c_link		= skin_get_meta( 'skin_custom_post_link' );
	$c_target	= skin_get_meta( 'skin_custom_post_link_target' );	
	$p_link		= $c_link ? $c_link : get_permalink();
	$p_target	= ( 'new-tab' === $c_target ) ? '_blank' : '_self';	
	
	$img_url = '';	
	
	if ( skin_get_meta( 'skin_post_img_in_list' ) ) {
		$img_id = skin_get_meta( 'skin_post_img_in_list' );
		$img_url = skin_get_giffy_attachment_url( $img_id, 'medium_large' );
		
	} else if ( has_post_thumbnail() ) {
		$img_url = skin_get_giffy_featured_img_url( get_the_ID(), 'medium_large' );
	}
	
	if ( '' === $img_url && $img_placeholder = get_theme_mod( 'skin_img_placeholder' ) ) {
		$img_url = $img_placeholder;
	}
	
	$show_cat		= get_theme_mod( 'skin_blog_show_category', true );	
	$show_date		= get_theme_mod( 'skin_blog_show_date', true );
	$show_author	= get_theme_mod( 'skin_blog_show_author', true );	
	
	$title_length = get_theme_mod( 'skin_blog_title_length', 13 );	
	$show_excerpt = get_theme_mod( 'skin_blog_show_excerpt', false );
?>
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
			if ( '' != $img_url ) {
		?>
			<div class="featured-img bgr-cover shrinking-img" style="background-image:url('<?php echo esc_url( $img_url ); ?>');">
				<div class="shrinker content-pad-to-border"></div>
				<a href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"><?php
					if ( $post_format ) {
				?>
					<div class="post-format-icon round va-middle bouncer content-pad small-item-bgr-to-svg"><?php echo skin_get_post_format_icon(); ?></div>
				<?php
					}
				?></a>
			</div>
		<?php	
			} else {
		?>
			<div class="featured-img shrinking-img gradient-bgr-vert txt-on-gradient">
				<div class="shrinker content-pad-to-border"></div>
				<a href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"><?php
					if ( $post_format ) {
				?>
					<div class="post-format-icon round va-middle bouncer content-pad small-item-bgr-to-svg"><?php echo skin_get_post_format_icon(); ?></div>
				<?php
					}
				?></a>
			</div>
		<?php
			}
		?></div>
		
		<div class="post-content">
			<header class="post-header">
			<?php
			// Post category
				if ( true === $show_cat ) {
					$p = ( '' !== skin_get_meta( 'skin_prioritize_cats' ) ) ? true : false;
					$l = get_theme_mod( 'skin_blog_limit_cats' );
			?>
				<div class="categories"><?php echo skin_get_post_categories( get_the_ID(), $p, $l ); ?></div>
			<?php
				}
					
			// Quotation in case of quote post format
				if ( 'quote' === $post_format && $featured_area_works && $quote = skin_featured_area_get_meta( 'skin_featured_quote' ) ) {
			?>
				<h3 class="quote shareable-selections">
					<a class="post-title masked-content" href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>">
						<div class="txt cut-by-lines" data-lines-limit="2"><?php echo skin_highlight_searched_terms( esc_html( $quote ) ); ?></div>
						<div class="mask to-top"><div class="mask-txt masked-txt cut-by-lines" data-lines-limit="2"><?php echo skin_highlight_searched_terms( esc_html( $quote ) ); ?></div></div>
					</a>
				</h3>
				<?php	
					if ( $quote_author = skin_featured_area_get_meta( 'skin_featured_quote_author' ) ) {
				?>
					<div class="quote-author post-details"><?php echo skin_highlight_searched_terms( esc_html( $quote_author ) ); ?></div>
				<?php
					}
					
			// Post title for any other format	
				} else if ( get_the_title( get_the_ID() ) ) {
			?>
				<h3>
					<a class="post-title masked-content" href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>">
						<div class="txt cut-by-lines" data-lines-limit="2"><?php echo skin_highlight_searched_terms( esc_html( get_the_title( get_the_ID() ) ) ); ?></div>
						<div class="mask to-top"><div class="mask-txt masked-txt cut-by-lines" data-lines-limit="2"><?php echo skin_highlight_searched_terms( esc_html( get_the_title( get_the_ID() ) ) ); ?></div></div>
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
			?>
				</a>
			</header>				
			<?php							
			// Excerpt
			if ( true === $show_excerpt ) {
			?>
			<div class="post-excerpt small-text shareable-selections clearfix cut-by-lines" data-lines-limit="2"><?php
				skin_post_excerpt();
			?></div>
			<?php
			}
			
			// Post details
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
	</article>