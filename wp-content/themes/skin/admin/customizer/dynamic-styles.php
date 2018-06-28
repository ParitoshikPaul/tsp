<?php
/* ==============================================
	DYNAMIC STYLES, Per Customizer settings
	Skin - Premium WordPress Theme, by NordWood
================================================= */
function skin_dynamic_styles() {		
	wp_enqueue_style( 'skin_dynamic_styles' );
	
	$custom_css = "";
		
/* Color Scheme
================== */
// Body background
	$body_bgr = get_theme_mod( 'background_color', '#f3f3f3' );
	
	if ( $body_bgr ) {
		$custom_css .= "
			.body-bgr,
			body {
				background-color: {$body_bgr};
			}
			
			.body-bgr-to-border {
				border-color: {$body_bgr};
			}
		";
	}
	
// Pattern for site background
	$bgr_pattern = skin_get_theme_mod_img_src( 'skin_bgr_pattern' );
	
	if ( $bgr_pattern ) {
		$custom_css .= "
			.body-pattern {
				background-image: url('{$bgr_pattern}');
				background-position: center center;
			}
		";
	}
	
// Opacity for the pattern in site background
	$bgr_pattern_opacity = get_theme_mod( 'skin_bgr_pattern_opacity', 20 );
	
	if ( $bgr_pattern_opacity ) {
		$opacity = 0.01*$bgr_pattern_opacity;
		
		$custom_css .= "
			.body-pattern {
				opacity: {$opacity};
			}
		";
	}
	
// Gradient background
	$gradient_1 = get_theme_mod( 'skin_gradient_color_1', '#f4d7de' );
	$gradient_2 = get_theme_mod( 'skin_gradient_color_2', '#cecfe7' );
	
	if ( is_page() && skin_get_meta( 'skin_page_gradient_color_1' ) ) {
		$gradient_1 = skin_get_meta( 'skin_page_gradient_color_1' );
	}
	
	if ( is_page() && skin_get_meta( 'skin_page_gradient_color_2' ) ) {
		$gradient_2 = skin_get_meta( 'skin_page_gradient_color_2' );
	}
	
	if ( $gradient_1 && $gradient_2 ) {
		$custom_css .= "
			.gradient-bgr {
				background: linear-gradient( 125deg, {$gradient_1} 0%, {$gradient_2} 100% );
			}
			
			.gradient-bgr-vert {
				background: linear-gradient( to bottom, {$gradient_1} 0%, {$gradient_2} 100% );
			}
		";
	}
	
	$header_bgr_h = get_theme_mod( 'skin_top_gradient_height', 0 );
	
	if ( $header_bgr_h ) {
		$custom_css .= "
			.site-header-bgr .pattern,
			.site-header-bgr .gradient-bgr,
			.site-header-bgr {
				height: {$header_bgr_h}px;
			}			
		";
	}
	
// Pattern over the top area
	$top_pattern = skin_get_theme_mod_img_src( 'skin_top_pattern' );
	
	if ( $top_pattern ) {
		$custom_css .= "
			.site-header-bgr .pattern {
				background-image:  url('{$top_pattern}');
			}
		";
	}
	
// Opacity for the pattern at the top area
	$top_pattern_opacity = get_theme_mod( 'skin_top_pattern_opacity', 20 );
	
	if ( $top_pattern_opacity ) {
		$opacity = 0.01*$top_pattern_opacity;
		
		$custom_css .= "
			.site-header-bgr .pattern {
				opacity: {$opacity};
			}
		";
	}
	
// Height of the top area
	$header_bgr_h = get_theme_mod( 'skin_top_gradient_height', 0 );
	
	if ( $header_bgr_h ) {
		$custom_css .= "
			.site-header-bgr {
				height: {$header_bgr_h}px;
			}			
		";
	}
	
// Content pad background
	$pad_bgr = get_theme_mod( 'skin_content_pad', '#fff' );
	
	if ( $pad_bgr ) {
		$custom_css .= "
			.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
			.content-pad {
				background-color: {$pad_bgr};
			}
			
			.woocommerce input[type='submit'],
			.woocommerce-page .add-to-cart-tiny.button,
			.woocommerce .button {
				background-color: {$pad_bgr} !important;
			}
			
			input:-webkit-autofill,
			textarea:-webkit-autofill,
			select:-webkit-autofill {
				-webkit-box-shadow: inset 0 0 0px 9999px {$pad_bgr};
			}
			
			.masonry-item article.product .added_to_cart.wc-forward,
			.content-pad-to-color {
				color: {$pad_bgr};
			}
			
			.woocommerce .out-of-stock,
			.masonry-item article.product .out-of-stock,
			.woocommerce a.remove {
				color: {$pad_bgr} !important;
			}
			
			.content-pad-to-border {
				border-color: {$pad_bgr};
			}
			
			.content-pad-to-svg {
				fill: {$pad_bgr};
			}
		";
	}

// Text color - Main
	$txt_main = get_theme_mod( 'skin_main_txt_color', '#353535' );
	
	if ( $txt_main ) {
		$txt_main_shade = skin_hex2rgba( $txt_main, 0.4 );
		$txt_main_light = skin_hex2rgba( $txt_main, 0.2 );
		$txt_main_pale = skin_hex2rgba( $txt_main, 0.05 );
		
		$custom_css .= "
			body {
				color: {$txt_main};
			}
			
			.woocommerce input[type='submit'],
			.woocommerce-page .add-to-cart-tiny.button,
			.woocommerce .button {
				color: {$txt_main} !important;
			}
			
			::placeholder {
				color: {$txt_main};
			}
			
			::-webkit-input-placeholder {
				color: {$txt_main};
			}
			
			:-moz-placeholder {
				color: {$txt_main};
			}
			
			::-moz-placeholder {
				color: {$txt_main};
			}
			
			:-ms-input-placeholder {
				color: {$txt_main};
			}
			
			::-ms-input-placeholder {
				color: {$txt_main};
			}
			
			.txt-color-to-svg .svg-fill,
			#site-footer .social-icon .svg-fill {
				fill: {$txt_main};
			}
			
			.txt-color-to-svg .svg-stroke,
			#site-footer .social-icon .svg-stroke {
				stroke: {$txt_main};
			}
			
			.woocommerce .out-of-stock,
			.masonry-item article.product .out-of-stock,
			.masonry-item article.product .add-to-cart-tiny .tooltip:after,
			.masonry-item article.product .added_to_cart.wc-forward,
			.txt-color-to-bgr,
			.widget_nav_menu li:before,
			.widget_rss li:before,
			.widget_recent_entries li:before,
			.widget_recent_comments li:before,
			.widget_meta li:before,
			.widget_pages li:before,
			.widget_archive li:before {
				background-color: {$txt_main};
			}
			
			select:focus,
			input[type='date']:focus,
			input[type='tel']:focus,
			input[type='number']:focus,
			input[type='email']:focus,
			input[type='url']:focus,
			input[type='text']:focus,
			input[type='password']:focus,
			input[type='submit']:hover,
			textarea:focus {
				border-color: {$txt_main};
				outline: {$txt_main};
			}
			
			.woocommerce .woocommerce-breadcrumb,
			.post-details {
				color: {$txt_main_shade};
			}
			
			.woocommerce #reviews #comments ol.commentlist li .comment-text,
			.woocommerce .select2-selection,
			.txt-color-light-to-border,
			#site-footer .social-icon {
				border-color: {$txt_main_light};
			}
			
			.woocommerce a.remove {
				background-color: {$txt_main_shade};
			}
			
			.woocommerce table td {
				border-color: {$txt_main_light} !important;
			}
	
			.woocommerce .select2-selection .select2-selection__arrow b {
				border-top-color: {$txt_main_light};
			}
			
			.txt-color-light-to-svg .svg-fill {
				fill: {$txt_main_light};
			}
			
			.txt-color-light-to-svg .svg-stroke {
				stroke: {$txt_main_light};
			}
			
			.txt-color-pale-to-svg .svg-fill {
				fill: {$txt_main_pale};
			}
			
			.txt-color-pale-to-svg .svg-stroke {
				stroke: {$txt_main_pale};
			}
		";
	}

// Link color on hover - Main
	$txt_main_hover = get_theme_mod( 'skin_main_txt_color_hover', '#f18597' );
	
	if ( $txt_main_hover ) {
		$custom_css .= "
			.widget_archive li:hover,
			.post-content > ol li a:hover,
			.post-content > ul li a:hover,
			.post-content > p a:hover,
			.masked-txt,
			.mask-txt {
				color: {$txt_main_hover};
			}
	
			.link-hov-main:hover {
				color: {$txt_main_hover};
			}
		";
	}

// Content color on gradient background
	$txt_on_gradient = get_theme_mod( 'skin_txt_on_gradient_color', '#353535' );
	
	if ( is_page() && skin_get_meta( 'skin_page_gradient_txt_color' ) ) {
		$txt_on_gradient = skin_get_meta( 'skin_page_gradient_txt_color' );
	}
	
	if ( $txt_on_gradient ) {
		$txt_on_gradient_shade = skin_hex2rgba( $txt_on_gradient, 0.4 );
		$txt_on_gradient_light = skin_hex2rgba( $txt_on_gradient, 0.2 );
		$txt_on_gradient_pale = skin_hex2rgba( $txt_on_gradient, 0.05 );
		
		$custom_css .= "
			.txt-on-gradient {
				color: {$txt_on_gradient};
			}
			
			.txt-on-gradient .txt-color-to-svg .svg-fill,
			#site-footer .txt-on-gradient .social-icon .svg-fill {
				fill: {$txt_on_gradient};
			}
			
			.txt-on-gradient .txt-color-to-svg .svg-stroke,
			#site-footer .txt-on-gradient .social-icon .svg-stroke {
				stroke: {$txt_on_gradient};
			}
			
			.txt-on-gradient .txt-color-to-bgr,
			.widget_nav_menu.txt-on-gradient li:before,
			.widget_rss.txt-on-gradient li:before,
			.widget_recent_entries.txt-on-gradient li:before,
			.widget_recent_comments.txt-on-gradient li:before,
			.widget_meta.txt-on-gradient li:before,
			.widget_pages.txt-on-gradient li:before,
			.widget_archive.txt-on-gradient li:before {
				background-color: {$txt_on_gradient};
			}
			
			.txt-on-gradient .post-details {
				color: {$txt_on_gradient_shade};
			}
			
			.txt-on-gradient .txt-color-light-to-border,
			#site-footer .txt-on-gradient .social-icon {
				border-color: {$txt_on_gradient_light};
			}
			
			.txt-on-gradient .txt-color-light-to-svg .svg-fill {
				fill: {$txt_on_gradient_light};
			}
			
			.txt-on-gradient .txt-color-light-to-svg .svg-stroke {
				stroke: {$txt_on_gradient_light};
			}
			
			.txt-on-gradient .txt-color-pale-to-svg .svg-fill {
				fill: {$txt_on_gradient_pale};
			}
			
			.txt-on-gradient .txt-color-pale-to-svg .svg-stroke {
				stroke: {$txt_on_gradient_pale};
			}
		";
	}

// Link color on hover, over gradient background
	$txt_on_gradient_hover = get_theme_mod( 'skin_txt_on_gradient_color_hover', '#fff' );
	
	if ( is_page() && skin_get_meta( 'skin_page_gradient_link_color' ) ) {
		$txt_on_gradient_hover = skin_get_meta( 'skin_page_gradient_link_color' );
	}
	
	if ( $txt_on_gradient_hover ) {
		$custom_css .= "
			.txt-on-gradient .masked-txt,
			.txt-on-gradient .mask-txt {
				color: {$txt_on_gradient_hover};
			}
			
			.txt-on-gradient .link-hov-main:hover {
				color: {$txt_on_gradient_hover};
			}
		";
	}

// Small items
	$small_item_bgr = get_theme_mod( 'skin_small_item_bgr', '#f18597' );
	
	if ( $small_item_bgr ) {
		$small_item_bgr_light = skin_hex2rgba( $small_item_bgr, 0.5 );
		$small_item_bgr_pale = skin_hex2rgba( $small_item_bgr, 0.2 );
	
		$custom_css .= "
			.select2-container--default .select2-results__option--highlighted[data-selected],
			.select2-container--default .select2-results__option--highlighted[aria-selected],
			.woocommerce.single-product ul.wc-tabs .skin-tooltip:after,
			.woocommerce-MyAccount-navigation li.is-active a:after,
			.woocommerce.single-product ul.wc-tabs li.active .active-tab-line:after,
			.mini-cart-button-wrapper .skin-tooltip:after,
			.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
			.woocommerce a.remove:hover,
			.small-item-bgr,
			.widget_calendar tbody td a:before {
				background-color: {$small_item_bgr};
			}
			
			.woocommerce input[type='submit']:hover,
			.woocommerce-page .add-to-cart-tiny.button:hover,
			.woocommerce .button:hover {
				background-color: {$small_item_bgr} !important;
			}			
			
			.woocommerce .widget_layered_nav ul li.chosen a:before,
			.woocommerce .widget_layered_nav_filters ul li a:before,
			.woocommerce p.stars a:before,
			.woocommerce .star-rating:before,
			.woocommerce .star-rating,
			.woocommerce-notice:before,
			.woocommerce-error:before,
			.woocommerce-info:before,
			.woocommerce-message:before,
			.widget_calendar tbody td#today {
				color: {$small_item_bgr};
			}
			
			.small-item-bgr-to-svg .svg-fill {
				fill: {$small_item_bgr};
			}
			
			.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content,
			.small-item-bgr-light {
				background-color: {$small_item_bgr_light};
			}

			::selection {
				background: {$small_item_bgr_pale};
			}

			::-moz-selection {
				background: {$small_item_bgr_pale};
			}

			::-webkit-selection {
				background: {$small_item_bgr_pale};
			}
			
			mark,
			#add_payment_method #payment,
			.woocommerce-cart #payment,
			.woocommerce-checkout #payment,
			.woocommerce-notice,
			.woocommerce-error,
			.woocommerce-info,
			.woocommerce-message {
				background: {$small_item_bgr_pale};
			}
			
			.woocommerce input[type='submit'],
			.woocommerce .pad-shadow,
			.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
			.woocommerce-page .add-to-cart-tiny.button,
			.woocommerce .button {
				box-shadow: 0 4px 14px {$small_item_bgr_pale} !important;
			}
		";
	}

	$small_item_color = get_theme_mod( 'skin_colors_small_item_content', '#fff' );
	
	if ( $small_item_color ) {
		$custom_css .= "
			.select2-container--default .select2-results__option--highlighted[data-selected],
			.select2-container--default .select2-results__option--highlighted[aria-selected],
			.small-item-color {
				color: {$small_item_color};
			}
			
			.woocommerce input[type='submit']:hover,
			.woocommerce-page .add-to-cart-tiny.button:hover,
			.woocommerce .button:hover {
				color: {$small_item_color} !important;
			}			
			
			.woocommerce-page .add-to-cart-tiny.button:hover .svg-stroke,
			.woocommerce .button:hover .svg-stroke {
				stroke: {$small_item_color} !important;
			}
			
			.small-item-color .svg-fill {
				fill: {$small_item_color};
			}
			
			.small-item-color .svg-stroke {
				stroke: {$small_item_color};
			}
		";
	}

// Box shadows
	if ( SKIN_WOOCOMMERCE_ACTIVE ) {
		$shadow_color = get_theme_mod( 'skin_woo_shadow_color', '#f18597' );
		$shadow_opacity = get_theme_mod( 'skin_woo_shadow_opacity', 20 ) ? 0.01*get_theme_mod( 'skin_woo_shadow_opacity', 20 ) : 0.2;
		
		if ( $shadow_color || $shadow_opacity ) {
			$shadow_clr = skin_hex2rgba( $shadow_color, $shadow_opacity );
		
			$custom_css .= "
				.woocommerce input[type='submit'],
				.woocommerce .pad-shadow,
				.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
				.woocommerce-page .add-to-cart-tiny.button,
				.woocommerce .button {
					box-shadow: 0 4px 14px {$shadow_clr} !important;
				}
			";
		}
	}

// Top bar
	$top_bar_bgr = get_theme_mod( 'skin_top_bar_bgr', '#fff' );
	
	if ( $top_bar_bgr ) {
		$top_bar_bgr_light = skin_hex2rgba( $top_bar_bgr, 0.3 );
		$top_bar_bgr_medium = skin_hex2rgba( $top_bar_bgr, 0.6 );
		
		$custom_css .= "
			.top-bar.desktop .main-menu .sub-menu a:before,
			.top-bar-bgr {
				background-color: {$top_bar_bgr};
			}
			
			.top-bar.desktop .main-menu .sub-menu a:hover,
			.top-bar-bgr-to-color {
				color: {$top_bar_bgr};
			}
			
			.top-bar-bgr-to-svg .svg-fill {
				fill: {$top_bar_bgr};
			}
			
			.top-bar-bgr-medium-to-color {
				color: {$top_bar_bgr_medium};
			}
			
			.top-bar-bgr-light-to-border {
				border-color: {$top_bar_bgr_light};
			}
			
			.top-bar-bgr-light {
				background-color: {$top_bar_bgr_light};
			}
			
			.top-bar-bgr-light-to-svg .svg-fill {
				fill: {$top_bar_bgr_light};
			}
		";
	}
	
	$top_bar_content = get_theme_mod( 'skin_top_bar_txt_color', '#353535' );
	
	if ( $top_bar_content ) {
		$top_bar_content_light = skin_hex2rgba( $top_bar_content, 0.6 );
		$top_bar_content_pale = skin_hex2rgba( $top_bar_content, 0.2 );
		
		$custom_css .= "
			.top-bar-color {
				color: {$top_bar_content};
			}
			
			.top-bar-color-to-bgr {
				background-color: {$top_bar_content};
			}
			
			.top-bar-color-to-svg .svg-fill {
				fill: {$top_bar_content};
			}
			
			.top-bar-color-to-svg .svg-stroke {
				stroke: {$top_bar_content};
			}
			
			.top-bar.desktop .main-menu > ul > li > a > .description {
				color: {$top_bar_content_light};
			}
			
			.top-bar-color-pale-to-border {
				border-color: {$top_bar_content_pale};
			}
			
			.top-bar-color-pale-to-svg .svg-stroke {
				stroke: {$top_bar_content_pale};
			}
		";
	}
	
	$reading_progress = get_theme_mod( 'skin_colors_reading_progress', '#fbe0e5' );
	
	if ( $reading_progress ) {
		$custom_css .= "
			.progress {
				background-color: {$reading_progress};
			}
		";
	}

// Categories
	$cats = get_categories();
	
	foreach ( $cats as $cat ) {
		$cat_slug = $cat->slug;
		$cat_id = $cat->term_id;
		
		$cat_color = get_theme_mod( 'skin_colors_cat_'.$cat_slug, '#f18597' );
	
		if ( $cat_color ) {
			$custom_css .= "
				.archive-header .cat-title[data-cat-id='{$cat_id}'],
				.widget_categories li.cat-item-{$cat_id}:before {
					background: {$cat_color};
				}
				
				.widget_categories li.cat-item-{$cat_id}:hover > .qty,
				.widget_categories li.cat-item-{$cat_id}:hover > a {
					color: {$cat_color};
				}
			";
		}
	}

// Woocommerce product categories		
	if ( SKIN_WOOCOMMERCE_ACTIVE ) {
		$cats = get_terms( array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false
		) );
		
		foreach ( $cats as $cat ) {
			$cat_slug = $cat->slug;
			$cat_id = $cat->term_id;
		
			$cat_color = get_theme_mod( 'skin_woo_colors_cat_'.$cat_slug, '#f18597' );
		
			if ( $cat_color ) {
				$custom_css .= "				
					.widget_product_categories li.cat-item-{$cat_id}:before,
					.woocommerce .archive-header .cat-title[data-cat-id='{$cat_id}'] {
						background: {$cat_color};
					}
				
					.widget_product_categories li.cat-item-{$cat_id}:hover > .count,
					.widget_product_categories li.cat-item-{$cat_id}:hover > a {
						color: {$cat_color};
					}
				";
			}
		}	
	}
		
/* Sticky banner
================== */
	$sticky_banner_h = get_theme_mod( 'skin_sticky_banner_height', 78 );
	
	if ( 1 > $sticky_banner_h ) {
		$sticky_banner_h = 78;
	}	
	
	if ( $sticky_banner_h ) {
		$custom_css .= "
			.sticky-banner img {
				height: {$sticky_banner_h}px;
			}
		";
	}
	
	$sticky_banner_pos = get_theme_mod( 'skin_sticky_banner_position', 'bottom-right' );
	
	if ( 'bottom-right' === $sticky_banner_pos ) {
		$custom_css .= "
			.sticky-banner {
				right: 0; left: auto;
			}
		";		
	}
	
	if ( 'bottom-left' === $sticky_banner_pos ) {
		$custom_css .= "
			.sticky-banner {
				left: 0; right: auto;
			}
		";		
	}
		
/* Typography
================ */
/*
	Split the Google Fonts variant value into array of the font weight and font style values
*/
	if ( ! function_exists( 'skin_adjust_font_variant' ) ) :
		function skin_adjust_font_variant( $font_variant ) {
		// Set the font weight and style initially to "normal"
			$weight_style = array( 'weight' => 'normal', 'style' => 'normal' );
			
		// If the variant value contains the italic styling, split it from the weight
			if ( substr_count( $font_variant, 'italic' ) ) {
				$weight_style['style'] = 'italic';
				
				if ( 0 < strlen( stristr( $font_variant, 'italic', true ) ) ) {
				// If there is a font-weight value before the "italic" substring, update the font weight
					$weight_style['weight'] = stristr( $font_variant, 'italic', true );
				}
				
		// Otherwise, update the font weight only. In case of 'regular', convert it to css friendly value 'normal'
			} else {
				$weight_style['weight'] = ( 'regular' === $font_variant ) ? 'normal' : $font_variant;
			}
			
			return $weight_style;
		}
	endif;
	
/*
	Apply dynamic styles to particular tag, per its typography control
*/
	if ( ! function_exists( 'skin_dynamic_typography' ) ) :
		function skin_dynamic_typography( $control, $target, $important = false ) {
			$typo			= explode( '|', $control );
			$font_family	= $typo[0];
			$font_size		= $typo[3];
			$line_height	= $typo[4];
			$letter_spacing	= $typo[5];
			$text_transform	= $typo[6];
			$font_variant	= $typo[1];
			$weight_style	= skin_adjust_font_variant( $font_variant );
			$font_weight	= $weight_style['weight'];
			$font_style		= $weight_style['style'];
			
			if ( true === $important ) {
				$css = "
					{$target} {
						font-family: '{$font_family}' !important;
						font-weight: {$font_weight} !important;
						font-size: {$font_size}px !important;
						line-height: {$line_height}px !important;
						letter-spacing: {$letter_spacing}px !important;
						text-transform: {$text_transform} !important;
						font-style: {$font_style} !important;
					}
				";
				
			} else {
				$css = "
					{$target} {
						font-family: '{$font_family}';
						font-weight: {$font_weight};
						font-size: {$font_size}px;
						line-height: {$line_height}px;
						letter-spacing: {$letter_spacing}px;
						text-transform: {$text_transform};
						font-style: {$font_style};
					}
				";
			}
			
			return $css;
		}
	endif;
	
// Main (body)	
	$typo_main_ctrl = get_theme_mod( 'skin_typo_main', 'Quicksand|regular|latin|15|30|0|none' );
	
	if ( $typo_main_ctrl ) {
		$custom_css .= skin_dynamic_typography( $typo_main_ctrl, 'body' );
	}

//	h1 heading
	$typo_h1_ctrl = get_theme_mod( 'skin_typo_h1', 'Quicksand|500|latin|40|53|0|none' );
	
	if ( $typo_h1_ctrl ) {
		$custom_css .= skin_dynamic_typography( $typo_h1_ctrl, 'h1' );
		$custom_css .= skin_dynamic_typography( $typo_h1_ctrl, '.archive-header .search-field' );
		$custom_css .= skin_dynamic_typography( $typo_h1_ctrl, '#search-overlay .search-field' );
	}

//	h2 heading
	$typo_h2_ctrl = get_theme_mod( 'skin_typo_h2', 'Quicksand|500|latin|32|40|0|none' );
	
	if ( $typo_h2_ctrl ) {
		$custom_css .= skin_dynamic_typography( $typo_h2_ctrl, 'h2' );
	}

//	h3 heading
	$typo_h3_ctrl = get_theme_mod( 'skin_typo_h3', 'Quicksand|500|latin|21|30|0|none' );
	
	if ( $typo_h3_ctrl ) {
		$custom_css .= skin_dynamic_typography( $typo_h3_ctrl, 'h3' );
		$custom_css .= skin_dynamic_typography( $typo_h3_ctrl, '.widget_search .search-field' );
		$custom_css .= skin_dynamic_typography( $typo_h3_ctrl, '.widget_product_search .search-field' );
	}

//	h4 heading
	$typo_h4_ctrl = get_theme_mod( 'skin_typo_h4', 'Quicksand|500|latin|18|26|0|none' );
	
	if ( $typo_h4_ctrl ) {
		$custom_css .= skin_dynamic_typography( $typo_h4_ctrl, 'h4' );
	}

//	h5 heading
	$typo_h5_ctrl = get_theme_mod( 'skin_typo_h5', 'Quicksand|500|latin|15|22|0|none' );
	
	if ( $typo_h5_ctrl ) {
		$custom_css .= skin_dynamic_typography( $typo_h5_ctrl, 'h5' );
		$custom_css .= skin_dynamic_typography( $typo_h5_ctrl, '.woocommerce-page .add-to-cart-tiny.button', true );
		$custom_css .= skin_dynamic_typography( $typo_h5_ctrl, '.woocommerce input[type="submit"]', true );
		$custom_css .= skin_dynamic_typography( $typo_h5_ctrl, '.woocommerce .button', true );
	}

//	h6 heading
	$typo_h6_ctrl = get_theme_mod( 'skin_typo_h6', 'Quicksand|500|latin|10|18|1|none' );
	
	if ( $typo_h6_ctrl ) {
		$custom_css .= skin_dynamic_typography( $typo_h6_ctrl, 'h6' );
	}

//	Welcome message
	$typo_welcome_ctrl = get_theme_mod( 'skin_typo_welcome', 'Quicksand|500|latin|40|53|0|none' );
	
	if ( $typo_welcome_ctrl ) {
		$custom_css .= skin_dynamic_typography( $typo_welcome_ctrl, '.welcome-mssg' );
	}

//	Drop caps
	$typo_dropcaps_ctrl = get_theme_mod( 'skin_typo_dropcaps', 'Quicksand|500|latin|32|30|0|none' );
	
	if ( $typo_dropcaps_ctrl ) {
		$custom_css .= skin_dynamic_typography( $typo_dropcaps_ctrl, '.page #main .drop-caps .post-content > p:first-of-type::first-letter' );
		$custom_css .= skin_dynamic_typography( $typo_dropcaps_ctrl, '.single #main .drop-caps .post-content > p:first-of-type::first-letter' );
	}

//	Blockquote
	$typo_blockquote_ctrl = get_theme_mod( 'skin_typo_blockquote', 'Quicksand|500|latin|21|30|0|none' );
	
	if ( $typo_blockquote_ctrl ) {
		$custom_css .= skin_dynamic_typography( $typo_blockquote_ctrl, '.post-content blockquote .quotation' );
	}

//	Details
	$typo_details_ctrl = get_theme_mod( 'skin_typo_details', 'Quicksand|500|latin|12|18|0|none' );
	
	if ( $typo_details_ctrl ) {
		$custom_css .= skin_dynamic_typography( $typo_details_ctrl, '.post-details' );
	}

//	Small text
	$typo_small_text_ctrl = get_theme_mod( 'skin_typo_small_text', 'Quicksand|regular|latin|13|24|0|none' );
	
	if ( $typo_small_text_ctrl ) {
		$custom_css .= skin_dynamic_typography( $typo_small_text_ctrl, '.small-text' );
	}

//	Main menu
	$typo_main_menu_ctrl = get_theme_mod( 'skin_typo_topbar', 'Quicksand|500|latin|17|30|0|none' );
	
	if ( $typo_main_menu_ctrl ) {
		$custom_css .= skin_dynamic_typography( $typo_main_menu_ctrl, '.top-bar.desktop' );
	}
	
//	Minify dynamic css, if needed
	if ( true === get_theme_mod( 'skin_opt_minify_dynamic_inline_css', false ) ) {
		$dynamic_css = skin_minify_inline_css( $custom_css );
		
	} else {
		$dynamic_css = $custom_css;
	}
	
// Apply all the styles above
	wp_add_inline_style( 'skin_dynamic_styles', $dynamic_css );
}

add_action( 'wp_enqueue_scripts', 'skin_dynamic_styles' );
?>