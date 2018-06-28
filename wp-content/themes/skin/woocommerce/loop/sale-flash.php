<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
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
 * @version     1.6.4
 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	global $post, $product;
?>
<?php
	if ( ! $product->is_in_stock() ) :
		echo apply_filters( 'woocommerce_sale_flash', '<h5 class="out-of-stock txt-color-to-bgr content-pad-to-color">' . esc_html__( 'Out of stock', 'skin' ) . '</h5>', $post, $product );
		
	elseif ( $product->is_on_sale() ) :
		echo apply_filters( 'woocommerce_sale_flash', '<h5 class="on-sale small-item-bgr small-item-color">' . esc_html__( 'Sale!', 'skin' ) . '</h5>', $post, $product );
	endif;
	
	if ( $product->is_featured() ) :
		echo '<div class="sticky-badge va-middle txt-color-to-bgr content-pad-to-svg">' . skin_get_icon_sticky() . '</div>';
	endif;

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */