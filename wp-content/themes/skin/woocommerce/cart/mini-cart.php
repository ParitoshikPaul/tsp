<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
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
 * @version 3.3.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>
	
	<div class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
		<table>
		<?php
			do_action( 'woocommerce_before_mini_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					
					<tr class="hover-trigger woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
						<td>
						<?php
							$thumb_url = '';
							
							if ( has_post_thumbnail( $_product->get_id() ) ) {
								$thumb_url = get_the_post_thumbnail_url( $_product->get_id(), 'skin_small' );
								
							} elseif ( ( $parent_id = wp_get_post_parent_id( $_product->get_id() ) ) && has_post_thumbnail( $parent_id ) ) {
								$thumb_url = get_the_post_thumbnail_url( $parent_id, 'skin_small' );
								
							} else {
								$thumb_url = wc_placeholder_img_src();				
							}
						?>
						
						<?php if ( ! $_product->is_visible() ) : ?>
							<div class="thumb round bgr-cover shrinking-img"
								style="background-image:url('<?php echo esc_url( str_replace( array( 'http:', 'https:' ), '', $thumb_url ) ); ?>');"
							><div class="shrinker"></div></div>
						<?php else : ?>
							<a href="<?php echo esc_url( $product_permalink ); ?>"
								class="thumb round bgr-cover shrinking-img"
								style="background-image:url('<?php echo esc_url( str_replace( array( 'http:', 'https:' ), '', $thumb_url ) ); ?>');"
							><div class="shrinker trans-border"></div></a>
						<?php endif; ?>
						</td>
						
						<td>
							<h5>
								<a class="post-title masked-content" href="<?php echo esc_url( $product_permalink ); ?>">
									<div class="txt cut-by-lines" data-lines-limit="3"><?php echo esc_html( $product_name ); ?></div>
									<div class="mask to-left"><div class="mask-txt masked-txt cut-by-lines" data-lines-limit="3"><?php echo esc_html( $product_name ); ?></div></div>
								</a>
							</h5>
							<div class="post-details">
							<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
							<?php
								echo wc_get_formatted_cart_item_data( $cart_item );
							?>
							</div>
						</td>
						
						<td>
						<?php
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							__( 'Remove this item', 'skin' ),
							esc_attr( $product_id ),
							esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key );
						?>
						</td>
					</tr>
					<?php
				}
			}

			do_action( 'woocommerce_mini_cart_contents' );
		?>
		</table>
	</div>
	
	
	<div class="mini-bottom gradient-bgr txt-on-gradient">
		<p class="woocommerce-mini-cart__total total"><strong><?php esc_html_e( 'Subtotal', 'skin' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

		<p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></p>
	</div>

<?php else : ?>

	<div class="mini-bottom">
		<p class="gradient-bgr txt-on-gradient woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'skin' ); ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
