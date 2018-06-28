<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
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
	
/**
 * skin_woo_before_wrapper hook.
 *
 * @hooked skin_woo_featured_area - 20
 */
	do_action( 'skin_woo_before_wrapper' );
?>
	<div class="main-holder content-wrapper clearfix">
		<main id="main" <?php skin_woo_main_class(); ?>>