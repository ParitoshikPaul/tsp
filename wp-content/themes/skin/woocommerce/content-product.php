<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div class="masonry-item-wrapper">
	<div class="masonry-item">
		<div class="masonry-content">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
			/**
			 * woocommerce_before_shop_loop_item hook.
			 */
			do_action( 'woocommerce_before_shop_loop_item' );

			/**
			 * skin_woo_before_shop_loop_item_header hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @included 'Out of stock' notice, with loop/sale-flash template
			 * @hooked skin_woo_loop_product_thumbnail - 10
			 * @hooked skin_edit_post - 10
			 * @included woocommerce_template_loop_add_to_cart
			 */
			do_action( 'skin_woo_before_shop_loop_item_header' );
			?>
			<header class="post-header content-pad"><div class="header-content">
				<?php
				/**
				 * skin_woo_before_shop_loop_item_title hook.
				 *
				 * @hooked skin_woo_shop_loop_product_categories - 10
				 */
				do_action( 'skin_woo_before_shop_loop_item_title' );
				
				/**
				 * woocommerce_before_shop_loop_item_title hook.
				 *
				 * @UNhooked woocommerce_show_product_loop_sale_flash - 10
				 * @UNhooked woocommerce_template_loop_product_thumbnail - 10
				 */
				do_action( 'woocommerce_before_shop_loop_item_title' );
				
				/**
				 * woocommerce_shop_loop_item_title hook.
				 *
				 * @hooked skin_woo_loop_product_title - 10
				 */
				do_action( 'woocommerce_shop_loop_item_title' );

				/**
				 * woocommerce_after_shop_loop_item_title hook.
				 *
				 * @hooked woocommerce_template_loop_rating - 5
				 * @hooked woocommerce_template_loop_price - 10
				 */
				do_action( 'woocommerce_after_shop_loop_item_title' );			
				?>
			</div></header>
			<?php			
			/**
			 * woocommerce_after_shop_loop_item hook.
			 */
			do_action( 'woocommerce_after_shop_loop_item' );
			?>
			</article>
		</div>
	</div>
</div>
