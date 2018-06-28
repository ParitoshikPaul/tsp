<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product; ?>
	<tr class="hover-trigger">
		<td>
			<span class="order"><span class="txt"></span><span class="line txt-color-to-bgr"></span></span>
		<?php
			$thumb_url = '';
			
			if ( has_post_thumbnail( $product->get_id() ) ) {
				$thumb_url = get_the_post_thumbnail_url( $product->get_id(), 'skin_small' );
				
			} elseif ( ( $parent_id = wp_get_post_parent_id( $product->get_id() ) ) && has_post_thumbnail( $parent_id ) ) {
				$thumb_url = get_the_post_thumbnail_url( $parent_id, 'skin_small' );
				
			} else {
				$thumb_url = wc_placeholder_img_src();				
			}									
		?>
			<a href="<?php echo esc_url( $product->get_permalink() ); ?>"
				class="thumb round bgr-cover shrinking-img"
				style="background-image:url('<?php echo esc_url( $thumb_url ); ?>');"
			><div class="shrinker"></div></a>		
		</td>
		
		<td>
			<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>
			<h5>
				<a class="post-title masked-content" href="<?php echo esc_url( $product->get_permalink() ); ?>">
					<div class="txt cut-by-lines" data-lines-limit="3"><?php echo esc_html( $product->get_name() ); ?></div>
					<div class="mask to-left"><div class="mask-txt masked-txt cut-by-lines" data-lines-limit="3"><?php echo esc_html( $product->get_name() ); ?></div></div>
				</a>
			</h5>
			<div class="post-details"><?php
				if ( ! empty( $show_rating ) ) {
					echo wc_get_rating_html( $product->get_average_rating() );
					
				} else {
					echo $product->get_price_html();
				}
			?></div>
			<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
		</td>
	</tr>