<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<div class="archive-header">
		<?php
			/**
			 * skin_woo_archive_header hook.
			 *
			 * @hooked skin_woo_archive_title - 10
			 */
			do_action( 'skin_woo_archive_header' );
		?>

		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked skin_woo_taxonomy_archive_description - 10
			 * @hooked skin_woo_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="loop-controls content-pad clearfix">
			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked wc_print_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
			</div>

			<div class="archive-cats clearfix"><?php
				woocommerce_output_product_categories();
			?></div>
			
			<?php
				woocommerce_product_loop_start();
				$post_order = 0;
				
				while ( have_posts() ) : the_post();
				
					/**
					 * woocommerce_shop_loop hook.
					 *
					 * @hooked WC_Structured_Data::generate_product_data() - 10
					 */
					do_action( 'woocommerce_shop_loop' );
					
					if ( ! is_search() ) {
						$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
						$item_order = ( $paged-1 )*get_option( 'posts_per_page' ) + $post_order;
						
						skin_render_special_widgets( $item_order, 'sidebar-woo-specials' );
					}				
					
					wc_get_template_part( 'content', 'product' );
					
					$post_order++;
				
				endwhile; // end of the loop.

				woocommerce_product_loop_end();
			?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php else : ?>

			<?php
				/**
				 * woocommerce_no_products_found hook.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
			?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>
