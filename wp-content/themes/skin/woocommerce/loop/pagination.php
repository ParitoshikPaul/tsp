<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.1
 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
	$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
	$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
	$format  = isset( $format ) ? $format : '';

	if ( $total <= 1 ) {
		return;
	}

	$arrow_left = skin_get_elastic_arrow_left();				
	$arrow_right = skin_get_elastic_arrow_right();
?>
	<div class="posts-list-pagination pagination clearfix txt-color-to-svg">
	<?php
	if ( is_rtl() ) {
		// Next products link
		if ( get_next_posts_link() ) {
		?>
			<div class="next nav va-middle hover-trigger content-pad"><?php
				next_posts_link( $arrow_left, $total );
			?></div>
		<?php						
		} else {
		?>
			<div class="inactive next nav va-middle content-pad"><?php echo skin_get_icon_arrow_left(); ?></div>
		<?php
		}
			
		// Previous products link
		if ( get_previous_posts_link() ) {
		?>
			<div class="prev nav va-middle hover-trigger content-pad"><?php
				previous_posts_link( $arrow_right );
			?></div>
		<?php
		} else {
		?>
			<div class="inactive prev nav va-middle content-pad"><?php echo skin_get_icon_arrow_right(); ?></div>
		<?php
		}
		
	} else {
		// Next products link
		if ( get_next_posts_link() ) {
		?>
			<div class="next nav va-middle hover-trigger content-pad"><?php
				next_posts_link( $arrow_right, $total );
			?></div>
		<?php						
		} else {
		?>
			<div class="inactive next nav va-middle content-pad"><?php echo skin_get_icon_arrow_right(); ?></div>
		<?php
		}
			
		// Previous products link
		if ( get_previous_posts_link() ) {
		?>
			<div class="prev nav va-middle hover-trigger content-pad"><?php
				previous_posts_link( $arrow_left );
			?></div>
		<?php
		} else {
		?>
			<div class="inactive prev nav va-middle content-pad"><?php echo skin_get_icon_arrow_left(); ?></div>
		<?php
		}
	}
		
	// Pagination
	?>				
		<div class="pages clearfix"><?php
		echo paginate_links( apply_filters( 'woocommerce_pagination_args', array( // WPCS: XSS ok.
			'base'         => $base,
			'format'       => $format,
			'add_args'     => false,
			'current'      => max( 1, $current ),
			'total'        => $total,
			'prev_next'       => false,
			'type'         => 'list',
			'end_size'     => 3,
			'mid_size'     => 3,
			'before_page_number' => '<span class="page-num va-middle">',
			'after_page_number'  => '</span>'
		) ) );
		?></div>
	</div>