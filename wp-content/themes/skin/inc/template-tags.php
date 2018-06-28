<?php
/* ==============================================
	TEMPLATE TAGS AND HELPER FUNCTIONS
	Skin - Premium WordPress Theme, by NordWood
================================================= */
/*	TABLE OF CONTENTS
======================= */
/*
	0.0 HELPER FUNCTIONS
	0.1 Sort array by count value
	0.2 Compare elements by relevance
	0.3 Convert HEX color value to RGBA
	0.4 Loading animation
	0.5 Elastic arrows
	0.6 Minify inline CSS
	
	1.0 GIF IMAGE SUPPORT
	1.1 Get giffy image attachment by its URL
	1.2 Get giffy image attachment by its ID
	1.3 Get giffy attachment image URL by attachment ID
	1.4 Get giffy featured image by post ID
	1.5 Get giffy featured image URL by post ID
	
	2.0 SITE LOGO DISPLAY
	2.1 Logo for desktop screens
	2.2 Logo for mobile devices
	
	3.0 POST RELATED HELPERS AND TAGS
	3.1 Get the post ID by its URL
	3.2 Check if a posts exists, by its ID
	3.3.1 Edit post link
	3.3.2 Edit page link
	3.4 Highlight searched term
	3.5 Post excerpt
	3.6 Post author
	3.7 Post date
	
	4.0 SETTINGS AND CLASSES FOR PARTICULAR ITEMS
	4.1 Get the layout type for posts list
	4.2 Get the featured image shape for posts list
	4.3 Classes for "#main" wrapper
	4.4 Classes for "#posts-list" wrapper
	4.5 Classes for featured image

	5.0 SOCIAL
	5.1 Links to social profiles
	5.2 Social share

	6.0 GALLERIES
	6.1 Post gallery slider

	7.0 POST FORMATS
	7.1 Post format icon
	7.2 Post featured media
	
	8.0 POST CATEGORIES DISPLAY
	8.1 Check if the post has a category (excluding 'Uncategorized')
	8.2 Assign category relevance value
	8.3 Get post categories
	
	9.0 POST TAG CLOUD DISPLAY
	9.1 Get post tags, sorted by popularity

	10.0 RELATED POSTS
	10.1 Calculate the post relevance by matching tags
	10.2 Related posts - tabs
	10.3 Related posts - carousel

	11.0 COMMENTS
	11.1 Customize comment output

	12.0 PAGINATION
	12.1 Pagination
	12.2 Loading animation for infinite scroll

	13.0 FEATURED POSTS
	13.1 Enlarged featured post
	13.2 Posts grid
	13.3 Posts slider

	14.0 POPULAR/TRENDY Posts
	14.1 Set post views counter	
	14.2 Get post views by post ID	
	14.3 Get array of IDs for posts with most views	
	14.4 Check if post is trendy, by its ID
	
	15.0 SPECIAL BOXES for masonry layout
	15.1 Special box order
	15.2 Popout page
	15.3.1 Image Banner 1
	15.3.2 Image Banner 2 
	15.3.3 Image Banner 3 
	15.3.4 Image Banner 4
	15.3.5 Image Banner 5
	15.4 Social Profiles 
	15.5 Popular/Latest posts
	15.6 Special widgets
*/

/*	0.0 HELPER FUNCTIONS
========================= */	
//	0.1 Sort array by count value
	if ( ! function_exists( 'skin_sort_by_count' ) ) :
		function skin_sort_by_count( $a, $b ) {
			return $a->count < $b->count;
		}
	endif;
	
//	0.2 Compare elements by relevance
/*
	Used for sorting arrays in some cases
*/
	if ( ! function_exists( 'skin_compare_by_relevance' ) ) :
		function skin_compare_by_relevance( $a, $b ) {
			if(  $a->relevance ==  $b->relevance ) {
				return 0;
			}
			
			return ( $a->relevance > $b->relevance ) ? -1 : 1;
		}
	endif;
	
//	0.3 Convert HEX color value to RGBA
	if ( ! function_exists( 'skin_hex2rgba' ) ) :
		function skin_hex2rgba( $color, $alpha = 1 ) {
			$c = trim( $color, '#' );
			$rgba_arr = array();

			if ( strlen( $c ) === 3 ) {
				$r = hexdec( substr( $c, 0, 1 ).substr( $c, 0, 1 ) );
				$g = hexdec( substr( $c, 1, 1 ).substr( $c, 1, 1 ) );
				$b = hexdec( substr( $c, 2, 1 ).substr( $c, 2, 1 ) );
				
			} else if ( strlen( $c ) === 6 ) {
				$r = hexdec( substr( $c, 0, 2 ) );
				$g = hexdec( substr( $c, 2, 2 ) );
				$b = hexdec( substr( $c, 4, 2 ) );				
			}

			$rgba_arr = array( 'red' => $r, 'green' => $g, 'blue' => $b, 'alpha' => $alpha );
			
			$rgba = vsprintf(
				'rgba(%1$s, %2$s, %3$s, %4$f )',
				$rgba_arr
			);
			
			return $rgba;
		}
	endif;
	
// 0.4 Loading animation
	if ( ! function_exists( 'skin_loading_content' ) ) :
		function skin_loading_content() {
			$loader = '<div class="loading content-loading txt-color-to-svg"><div class="loader"><div class="round colored small-item-bgr-light"></div><div class="round transparent"></div></div></div>';
			
			return $loader;
		}
	endif;
	
// 0.5 Elastic arrows
	if ( ! function_exists( 'skin_get_elastic_arrow_left' ) ) :
		function skin_get_elastic_arrow_left() {
			$arrow = '<div class="elastic-arrow left txt-color-to-svg">';
			$arrow .= skin_get_icon_elastic_arrow_left();			
			$arrow .= '</div>';
			
			return $arrow;
		}
	endif;

	if ( ! function_exists( 'skin_get_elastic_arrow_right' ) ) :
		function skin_get_elastic_arrow_right() {
			$arrow = '<div class="elastic-arrow right txt-color-to-svg">';			
			$arrow .= skin_get_icon_elastic_arrow_right();			
			$arrow .= '</div>';
			
			return $arrow;
		}
	endif;
	
// 0.6 Minify inline CSS	
// Create a constant for the escape character
	define('X', "\x1A");
	
	if ( ! function_exists( 'skin_minify_inline_css' ) ) :	
		function skin_minify_inline_css( $input ) {
			if ( false !== stripos( $input, 'calc(' ) ) {
				/* Keep important white–space(s) in 'calc()' */
				$input = preg_replace_callback('#\b(calc\()\s*(.*?)\s*\)#i', function($m) {
					return $m[1] . preg_replace('#\s+#', X, $m[2]) . ')';
				}, $input);
			}
			$input = preg_replace(array(
			/* Fix case for '#foo<space>[bar="baz"]', '#foo<space>*' and '#foo<space>:first-child' [^1] */
				'#(?<=[\w])\s+(\*|\[|:[\w-]+)#',
			/* Fix case for '[bar="baz"]<space>.foo', '*<space>.foo', ':nth-child(2)<space>.foo' and '@media<space>(foo: bar)<space>and<space>(baz: qux)' [^2] */
				'#([*\]\)])\s+(?=[\w\#.])#', '#\b\s+\(#', '#\)\s+\b#',
			 /* Minify HEX color code [^3] */
				'#\#([a-f\d])\1([a-f\d])\2([a-f\d])\3\b#i',
			/* Remove white–space(s) around punctuation(s) [^4] */
				'#\s*([~!@*\(\)+=\{\}\[\]:;,>\/])\s*#',
			/* Replace zero unit(s) with '0' [^5] */
				'#\b(?<!\d\.)(?:0+\.)?0+(?:[a-z]+\b)#i',
			/* Replace '0.6' with '.6' [^6] */
				'#\b0+\.(\d+)#',
			/* Replace ':0 0', ':0 0 0' and ':0 0 0 0' with ':0' [^7] */
				'#:(0\s+){0,3}0(?=[!,;\)\}]|$)#',
			/* Replace 'background(?:-position)?:(0|none)' with 'background$1:0 0' [^8] */
				'#\b(background(?:-position)?):(?:0|none)([;,\}])#i',
			/* Replace '(border(?:-radius)?|outline):none' with '$1:0' [^9] */
				'#\b(border(?:-radius)?|outline):none\b#i',
			/* Remove empty selector(s) [^10] */
				'#(^|[\{\}])(?:[^\{\}]+)\{\}#',
			/* Remove the last semi–colon and replace multiple semi–colon(s) with a semi–colon [^11] */
				'#;+([;\}])#',
			/* Replace multiple white–space(s) with a space [^12] */
				'#\s+#'
			), array(
			/* [^1] */
				X . '$1',
			/* [^2] */
				' $ 1 '  .  X , X  .  ' ( ' , ' ) '  .  X ,
			/* [^3] */
				'#$1$2$3',
			/* [^4] */
				'$1',
			/* [^5] */
				'0',
			/* [^6] */
				'.$1',
			/* [^7] */
				':0',
			/* [^8] */
				'$1:0 0$2',
			/* [^9] */
				'$1:0',
			/* [^10] */
				'$1',
			/* [^11] */
				'$1',
			/* [^12] */
				' '
			), $input);
			
			return trim( str_replace( X, ' ', $input ) );
		}
	endif;

/*	1.0 GIF IMAGE SUPPORT
========================= */
/*
	These are the modified image related functions to keep the original image size, in case of a gif image.
	Resized gif images generated by WP Media Uploader are all converted to JPG format,
	so in order to keep the animation, the original image should be kept as well.
	For non-gif images, the size declared in template files will be used.
*/
//	1.1 Get giffy image attachment by its URL
	if ( ! function_exists( 'skin_get_giffy_img_by_url' ) ) :
		function skin_get_giffy_img_by_url( $image_url, $size = 'skin_wrapper_width' ) {
			$size = ( "image/gif" === get_post_mime_type( skin_get_post_id_by_url( esc_url( $image_url ) ) ) ) ? 'full' : $size;
			
			return wp_get_attachment_image( skin_get_post_id_by_url( esc_url( $image_url ) ), $size );
		}
	endif;
	
//	1.2 Get giffy image attachment by its ID
	if ( ! function_exists( 'skin_get_giffy_img' ) ) :
		function skin_get_giffy_img( $image_id, $size = 'skin_wrapper_width' ) {
			$size = ( "image/gif" === get_post_mime_type( $image_id ) ) ? 'full' : $size;
			
			return wp_get_attachment_image( $image_id, $size );
		}
	endif;
	
// 	1.3 Get giffy attachment image URL by its ID
	if ( ! function_exists( 'skin_get_giffy_attachment_url' ) ) :
		function skin_get_giffy_attachment_url( $image_id, $size = 'skin_wrapper_width' ) {
			$size = ( "image/gif" === get_post_mime_type( $image_id ) ) ? 'full' : $size;
			$src = wp_get_attachment_image_src( $image_id, $size );
			$url = $src[0];
			
			return $url;
		}
	endif;
	
//	1.4 Get giffy featured image by post ID
	if ( ! function_exists( 'skin_get_giffy_featured_img' ) ) :
		function skin_get_giffy_featured_img( $post_id, $size = 'skin_wrapper_width' ) {
			$size = ( "image/gif" === get_post_mime_type( get_post_thumbnail_id( $post_id ) ) ) ? 'full' : $size;
			
			return get_the_post_thumbnail( $post_id, $size );
		}
	endif;
	
//	1.5 Get giffy featured image URL by post ID
	if ( ! function_exists( 'skin_get_giffy_featured_img_url' ) ) :
		function skin_get_giffy_featured_img_url( $post_id, $size = 'skin_wrapper_width' ) {
			$size = ( "image/gif" === get_post_mime_type( get_post_thumbnail_id( $post_id ) ) ) ? 'full' : $size;
			
			return get_the_post_thumbnail_url( $post_id, $size );
		}
	endif;
	
	if ( ! function_exists( 'skin_get_theme_mod_img_src' ) ) :
		function skin_get_theme_mod_img_src( $control ) {
			return str_replace( array( 'http:', 'https:' ), '', get_theme_mod( $control ) );
		}
	endif;
	
/*	2.0 SITE LOGO DISPLAY
============================ */
//	2.1 Logo for desktop screens
	if ( ! function_exists( 'skin_get_site_logo' ) ) :
		function skin_get_site_logo() {
			if ( $logo_retina_url = get_theme_mod( 'skin_logo_retina' ) ) {
				return skin_get_giffy_img_by_url( esc_url( $logo_retina_url ), 'full' );
				
			} else if ( $logo_url = get_theme_mod( 'skin_logo_regular' ) ) {
				return skin_get_giffy_img_by_url( esc_url( $logo_url ), 'full' );
				
			} else {
				return sprintf(
					'<h1>%s</h1>',
					get_bloginfo( 'name', 'display' )
				);				
			}
		}
	endif;
	
//	2.2 Logo for mobile devices
	if ( ! function_exists( 'skin_get_site_logo_mobile' ) ) :
		function skin_get_site_logo_mobile() {
			if ( $mobile_logo_retina_url = get_theme_mod( 'skin_logo_mobile_retina' ) ) {
				return skin_get_giffy_img_by_url( esc_url( $mobile_logo_retina_url ), 'full' );
				
			} else if ( $mobile_logo_url = get_theme_mod( 'skin_logo_mobile_regular' ) ) {
				return skin_get_giffy_img_by_url( esc_url( $mobile_logo_url ), 'full' );
				
			} else {
				return skin_get_site_logo();		
			}
		}
	endif;
	
/*	3.0 POST RELATED HELPERS AND TAGS
======================================= */	
//	3.1 Get the post ID by its URL
	if ( ! function_exists( 'skin_get_post_id_by_url' ) ) :
		function skin_get_post_id_by_url( $url ) {
			global $wpdb;
			
			$p = $wpdb->get_col(
				$wpdb->prepare(
					"SELECT ID FROM $wpdb->posts WHERE guid='%s';",
					esc_url_raw( $url )
				)
			);
			
			if ( ! $p ) {
				return;
			}
			
			return $p[0]; 
		}
	endif;
	
//	3.2 Check if a posts exists, by its ID
	if ( ! function_exists( 'skin_post_exist' ) ) :
		function skin_post_exist( $post_id ) {
			return 'publish' === get_post_status( $post_id );
		}
	endif;
	
//	3.3.1 Edit post link
	if ( ! function_exists( 'skin_edit_post' ) ) :
		function skin_edit_post( $post_id = NULL ) {
			$post_id = is_null( $post_id ) ? get_the_ID() : $post_id;
			
			return edit_post_link(
				'<span class="icon">'.skin_get_icon_gear().'</span><span class="text small-text">'.esc_html__( 'Edit post', 'skin' ).'</span>',
				'<div class="edit-link">',
				'</div>',
				$post_id
			);
		}
	endif;
	
//	3.3.2 Edit page link
	if ( ! function_exists( 'skin_edit_page' ) ) :
		function skin_edit_page( $post_id = NULL ) {
			$post_id = is_null( $post_id ) ? get_the_ID() : $post_id;
			
			return edit_post_link(
				'<span class="icon">'.skin_get_icon_gear().'</span><span class="text small-text">'.esc_html__( 'Edit page', 'skin' ).'</span>',
				'<div class="edit-link">',
				'</div>',
				$post_id
			);
		}
	endif;
	
//	3.4 Highlight searched term
	if ( ! function_exists( 'skin_highlight_searched_terms' ) ) :
		function skin_highlight_searched_terms( $text ) {
			$orig	= $text;
			$sr		= get_query_var('s');
			$keys	= explode( " ", $sr );
			$keys	= array_filter( $keys );
			$regEx	= '\'(?!((<.*?)|(<a.*?)))(\b'. implode('|', $keys) . '\b)(?!(([^<>]*?)>)|([^>]*?</a>))\'iu';
			$text	= preg_replace( $regEx, '<span class="search-highlight small-item-color small-item-bgr-light">\0</span>', $text );
			
			$result = is_search() ? $text : $orig;
			
			return $result;
		}
	endif;
	
//	3.5 Post excerpt
	if ( ! function_exists( 'skin_post_excerpt' ) ) :
		function skin_post_excerpt( $post_id = NULL ) {
			$post_id		= is_null( $post_id ) ? get_the_ID() : $post_id;
			$excerpt		= '';
			$get_content	= get_post_field( 'post_content', $post_id );						
			$has_more_tag	= strpos( $get_content, '<!--more-->' );
			
			if ( has_excerpt( $post_id ) ) {
				$excerpt = strip_shortcodes( get_the_excerpt( $post_id ) );
				$excerpt .= '...';
				
			} else if ( false !== $has_more_tag ) {
				$excerpt = strip_shortcodes( get_the_content( '...' ) );
				
			} else {
				$excerpt_length = get_theme_mod( 'skin_blog_excerpt_length', 15 );
				$excerpt = strip_shortcodes( $get_content );
				$excerpt = wp_trim_words( $excerpt, $excerpt_length, '...' );
			}

			echo wp_kses(
				skin_highlight_searched_terms( $excerpt ),
				array(
					'span' => array( 'class' => array() ),
					'a' => array( 'class' => array(), 'href' => array() ),
					'p' => array(),
					'div' => array( 'class' => array() )
				)
			);
		}
	endif;
	
//	3.6 Post author
	if ( ! function_exists( 'skin_post_author' ) ) :
		function skin_post_author( $post_id = NULL ) {
			$post_id = is_null( $post_id ) ? get_the_ID() : $post_id;
			$author_id = get_post_field( 'post_author', $post_id );
			
			$output = sprintf(
				'<div class="post-author"><a class="link-hov-main" href="%1$s">%2$s</a></div>',
				esc_url( get_author_posts_url( $author_id ) ),
				esc_html( get_the_author_meta( "nickname", $author_id ) )
			);
			
			return $output;
		}
	endif;
	
//	3.7 Post date
	if ( ! function_exists( 'skin_post_date' ) ) :
		function skin_post_date( $post_id = NULL ) {
			$post_id	= is_null( $post_id ) ? get_the_ID() : $post_id;
			$year		= get_the_time( 'Y', $post_id );
			$month		= get_the_time( 'm', $post_id );
			$day		= get_the_time( 'd', $post_id );
			
			$output = sprintf(
				'<div class="post-date"><a class="link-hov-main" href="%1$s">%2$s</a></div>',
				esc_url( get_day_link( $year, $month, $day ) ),
				esc_html( get_the_date( '', $post_id ) )
			);
			
			return $output;
		}
	endif;
	
/*	4.0 SETTINGS AND CLASSES FOR PARTICULAR ITEMS
======================================================== */
//	4.1 Get the layout type for posts list
	if ( ! function_exists( 'skin_get_layout_type' ) ) :
		function skin_get_layout_type() {
			$l = 'masonry-3';
			
			if ( is_home() ) {
				$l = get_theme_mod( 'skin_blog_layout', 'masonry-3' );
			}
			
			if ( is_archive() ) {
				if ( is_category() ) {
					$l = get_theme_mod( 'skin_category_layout', 'masonry-3' );
					
				} else if ( is_tag() ) {
					$l = get_theme_mod( 'skin_tag_layout', 'masonry-3' );
					
				} else if ( is_date() ) {
					$l = get_theme_mod( 'skin_date_layout', 'masonry-3' );
					
				} else if ( is_author() ) {
					$l = get_theme_mod( 'skin_author_layout', 'masonry-3' );
					
				} else {
					$l = get_theme_mod( 'skin_archive_layout', 'masonry-3' );
				}
			}
			
			if ( is_search() ) {
				$l = get_theme_mod( 'skin_search_layout', 'masonry-3' );
			}
			
			return $l;
		}
	endif;
	
//	4.2 Get the featured image shape for posts list
	if ( ! function_exists( 'skin_get_featured_img_shape' ) ) :
		function skin_get_featured_img_shape() {
			$shape = 'natural';
			$p_format = get_post_format();
			
			if ( is_home() || is_archive() || is_search() ) {
				$l = skin_get_layout_type();
				$shape = get_theme_mod( 'skin_blog_featured_img_shape', 'natural' );
				
				if ( 'hidden' != $shape && false !== strpos( $l, 'masonry' ) ) {
					if ( 'image' === $p_format ) {
						$shape = 'square';
						
					} else if ( 'link' === $p_format || 'quote' === $p_format ) {
						$shape = 'circle';						
					}
				}
			}
			
			return $shape;
		}
	endif;
	
//	4.3 Classes for "#main" wrapper
	if ( ! function_exists( 'skin_get_main_class' ) ) :
		function skin_get_main_class( $class = '' ) {			
			$classes = array();
			
			$classes[] = 'clearfix';
			
			$l = 'masonry-3';
			$p = 'infinite';
			$s = 'no-sidebar';
			$b = false;
			$push_items	= false;
			
			if ( is_home() ) {
				$b = true;
				$l = get_theme_mod( 'skin_blog_layout', 'masonry-3' );
				$p = get_theme_mod( 'skin_blog_pagination_type', 'infinite' );
			
				if ( false !== strpos( $l, 'sidebar' ) ) {
					$s = get_theme_mod( 'skin_blog_sidebar', 'sidebar-right' );
				}
				
				if ( 'masonry-2-sidebar' === $l && ( 'sidebar-right' === $s || 'sidebar-left' === $s ) ) {
					$push_items = true;
				}
			}
			
			if ( is_archive() ) {
				if ( is_category() ) {
					$b = true;
					$l = get_theme_mod( 'skin_category_layout', 'masonry-3' );
					$p = get_theme_mod( 'skin_category_pagination', 'infinite' );
					
				} else if ( is_tag() ) {
					$b = true;
					$l = get_theme_mod( 'skin_tag_layout', 'masonry-3' );
					$p = get_theme_mod( 'skin_tag_pagination', 'infinite' );
					
				} else if ( is_date() ) {
					$b = true;
					$l = get_theme_mod( 'skin_date_layout', 'masonry-3' );
					$p = get_theme_mod( 'skin_date_pagination', 'infinite' );
					
				} else if ( is_author() ) {
					$b = true;
					$l = get_theme_mod( 'skin_author_layout', 'masonry-3' );
					$p = get_theme_mod( 'skin_author_pagination', 'infinite' );
					
				} else {
					$b = true;
					$l = get_theme_mod( 'skin_archive_layout', 'masonry-3' );
					$p = get_theme_mod( 'skin_archive_pagination', 'infinite' );
				}
			
				if ( false !== strpos( $l, 'sidebar' ) ) {
					$s = get_theme_mod( 'skin_blog_sidebar', 'sidebar-right' );
				}
				
				if ( 'masonry-2-sidebar' === $l && ( 'sidebar-right' === $s || 'sidebar-left' === $s ) ) {
					$push_items = true;
				}
			}
			
			if ( is_search() ) {
				$b = true;
				$l = get_theme_mod( 'skin_search_layout', 'masonry-3' );
				$p = get_theme_mod( 'skin_search_pagination', 'infinite' );
			
				if ( false !== strpos( $l, 'sidebar' ) ) {
					$s = get_theme_mod( 'skin_blog_sidebar', 'sidebar-right' );
				}
				
				if ( 'masonry-2-sidebar' === $l && ( 'sidebar-right' === $s || 'sidebar-left' === $s ) ) {
					$push_items = true;
				}
			}
				
			if ( is_singular( 'post' ) ) {
				$ignore_g = skin_get_meta( 'skin_ignore_global' );				
					
				if ( 'ignore' === $ignore_g ) {
					$s = skin_get_meta( 'skin_post_sidebar' );
					
					if ( 'no-sidebar' !== $s ) {
						$s = get_theme_mod( 'skin_post_sidebar', 'sidebar-right' );
					}
					
				} else {
					$s = get_theme_mod( 'skin_post_sidebar', 'sidebar-right' );
				}
			}
			
			if ( is_page() && ! is_archive() ) {
				$s = skin_get_meta( 'skin_post_sidebar' );
					
				if ( 'no-sidebar' !== $s ) {
					$s = get_theme_mod( 'skin_post_sidebar', 'sidebar-right' );
				}
			}
			
			$classes[] = sanitize_html_class( $s );
			
			if ( $b && 'infinite' === $p ) {
				$classes[] = 'infinite-scroll';
			}
			
			if ( $b && true === $push_items ) {
				$classes[] = 'push-items';
			}
			
			if ( !empty( $class ) ) {
				if ( !is_array( $class ) ) {
					$class = preg_split( '#\s+#', $class );
				}
					
				$classes = array_merge( $classes, $class );
				
			} else {
				$class = array();
			}
		 
			$classes = array_map( 'esc_attr', $classes );			
			$classes = apply_filters( 'skin_main_class', $classes, $class );
		 
			return array_unique( $classes );
		}
	endif;
	
	if ( ! function_exists( 'skin_main_class' ) ) :
		function skin_main_class( $class = '' ) {
			echo 'class="' . join( ' ', skin_get_main_class( $class ) ) . '"';
		}
	endif;

//	4.4 Classes for "#posts-list" wrapper
	if ( ! function_exists( 'skin_get_posts_list_class' ) ) :
		function skin_get_posts_list_class( $class = '' ) {
			$classes = array();
			
			$classes[] = 'clearfix';
			$classes[] = 'posts-list';
			
			$l_type = 'masonry';
			$cols = 'cols-3';
			
			$l = skin_get_layout_type();
			
			if ( false !== strpos( $l, 'standard-list' ) ) {
				$l_type = 'standard-list';
				$cols = 'cols-1';
			}
			
			if ( false !== strpos( $l, '2' ) ) {
				$cols = 'cols-2';
				
			} else if ( false !== strpos( $l, '3' ) ) {
				$cols = 'cols-3';
				
			} else if ( false !== strpos( $l, '4' ) ) {
				$cols = 'cols-4';
				
			} else if ( false !== strpos( $l, '5' ) ) {
				$cols = 'cols-5';				
			}
			
			$classes[] = sanitize_html_class( $l_type );
			$classes[] = sanitize_html_class( $cols );
		 
			if ( !empty( $class ) ) {
				if ( !is_array( $class ) ) {
					$class = preg_split( '#\s+#', $class );
				}
				
				$classes = array_merge( $classes, $class );
				
			} else {
				$class = array();
			}
		 
			$classes = array_map( 'esc_attr', $classes );			
			$classes = apply_filters( 'skin_posts_list_class', $classes, $class );
		 
			return array_unique( $classes );
		}
	endif;
	
	if ( ! function_exists( 'skin_posts_list_class' ) ) :
		function skin_posts_list_class( $class = '' ) {
			echo 'class="' . join( ' ', skin_get_posts_list_class( $class ) ) . '"';
		}
	endif;  

//	4.5 Classes for featured image
/*
	Note: Currently used in certain cases on masonry layout, only
*/
	if ( ! function_exists( 'skin_get_featured_img_class' ) ) :
		function skin_get_featured_img_class( $class = '' ) {
			$classes = array();
			
			$classes[] = 'featured-img';
			$classes[] = 'bgr-cover';
			$classes[] = 'shrinking-img';
				
			$shape = skin_get_featured_img_shape();
				
			$classes[] = sanitize_html_class( $shape );
		 
			if ( !empty( $class ) ) {
				if ( !is_array( $class ) ) {
					$class = preg_split( '#\s+#', $class );
				}
					
				$classes = array_merge( $classes, $class );
				
			} else {
				$class = array();
			}
		 
			$classes = array_map( 'esc_attr', $classes );			
			$classes = apply_filters( 'skin_featured_img_class', $classes, $class );
		 
			return array_unique( $classes );
		}
	endif;
	
	if ( ! function_exists( 'skin_featured_img_class' ) ) :
		function skin_featured_img_class( $class = '' ) {
			echo 'class="' . join( ' ', skin_get_featured_img_class( $class ) ) . '"';
		}
	endif;
	
/*	5.0 SOCIAL
================= */
//	5.1 Links to social profiles
	if ( ! function_exists( 'skin_social_profiles' ) ) :
		function skin_social_profiles() {
			$links = '';;
			
			if ( $socials = get_theme_mod( 'skin_social_profiles' ) ) {				
				$profiles = explode( '-network-', $socials );
				
				array_shift( $profiles );
				
				foreach ( $profiles as $profile ) {
					$pair = explode( '-link-', $profile );
					$network = $pair[0];
					$profile_url = $pair[1];
					
					$links .= sprintf(
						'<a class="social-icon round va-middle" href="%s" target="_blank">',
						esc_url( $profile_url )
					);
					
					$links .= call_user_func( 'skin_get_icon_'.strtolower( $network ) );					
					$links .= '</a>';
				}
			}
			
			return $links;
		}
	endif;
	
//	5.2 Social share	
	if ( ! function_exists( 'skin_share_buttons' ) ) :
		function skin_share_buttons( $post_id = NULL ) {
			$socials = get_theme_mod( 'skin_sharing_links' );
			$profiles = explode( '-network-', $socials );			
			array_shift( $profiles );
			
			$post_id = is_null( $post_id ) ? get_the_ID() : $post_id;
			$share = '';
			
			$post_title = get_the_title( $post_id );
			$post_title = str_replace( ' ', '%20', $post_title );
		
		// Twitter			
			if ( in_array( "Twitter", $profiles ) || '' === $socials || ! $socials ) {
				$post_tags = '';
				
				if ( $get_post_tags = get_the_tags( $post_id ) ) {				
					foreach ( $get_post_tags as $tag ) {
						$post_tags .= $tag->name . ','; 
					}
				  
					$post_tags = '&hashtags=' . rtrim( $post_tags, "," );
				}
				
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="https://twitter.com/intent/tweet?url=%1$s&text=%2$s%3$s" target="_blank">%4$s</a>',
					esc_url_raw( get_the_permalink( $post_id ) ),
					esc_attr( $post_title ),
					rtrim( $post_tags, "," ),
					skin_get_icon_twitter()
				);
			}
			
		// Facebook
			if ( in_array( "Facebook", $profiles ) || '' === $socials || ! $socials ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="https://www.facebook.com/sharer/sharer.php?u=%1$s" target="_blank">%2$s</a>',
					esc_url_raw( get_the_permalink( $post_id ) ),
					skin_get_icon_facebook()
				);
			}
			
		// Pinterest
			if ( in_array( "Pinterest", $profiles ) || '' === $socials || ! $socials ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" data-pin-do="buttonPin" data-pin-count="above" data-pin-custom="true" 
						href="https://www.pinterest.com/pin/create/button/?url=%1$s&media=%2$s" target="_blank">%3$s</a>',
					esc_url_raw( get_the_permalink( $post_id ) ),
					esc_url_raw( skin_get_giffy_featured_img_url( $post_id, 'large' ) ),
					skin_get_icon_pinterest()
				);
			}
			
		// Google Plus
			if ( in_array( "GooglePlus", $profiles ) || '' === $socials || ! $socials ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="https://plus.google.com/share?url=%1$s" target="_blank">%2$s</a>',
					esc_url_raw( get_the_permalink( $post_id ) ),
					skin_get_icon_googleplus()
				);
			}
			
		// Blogger
			if ( in_array( "Blogger", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="https://www.blogger.com/blog-this.g?u=%1$s&n=%2$s&t=%3$s" target="_blank">%4$s</a>',
					rawurlencode( get_the_permalink() ),
					get_the_title(),
					strip_tags( get_the_excerpt( get_the_ID() ) ),
					skin_get_icon_blogger()
				);
			}
			
		// Digg
			if ( in_array( "Digg", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="http://digg.com/submit?url=%1$s&title=%2$s" target="_blank">%3$s</a>',
					rawurlencode( get_the_permalink() ),
					get_the_title(),
					skin_get_icon_digg()
				);
			}
			
		// EverNote
			if ( in_array( "EverNote", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="http://www.evernote.com/clip.action?url=%1$s" target="_blank">%2$s</a>',
					rawurlencode( get_the_permalink() ),
					skin_get_icon_evernote()
				);
			}
			
		// Flattr
			if ( in_array( "Flattr", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="https://flattr.com/submit/auto?user_id=account&url=%1$s&title=%2$s" target="_blank">%3$s</a>',
					rawurlencode( get_the_permalink() ),
					get_the_title(),
					skin_get_icon_flattr()
				);
			}
			
		// Gmail
			if ( in_array( "Gmail", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="https://mail.google.com/mail/?view=cm&fs=1&su=%2$s&body=%1$s" target="_blank">%3$s</a>',
					rawurlencode( get_the_permalink() ),
					get_the_title(),
					skin_get_icon_gmail()
				);
			}
			
		// HackerNews
			if ( in_array( "HackerNews", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="https://news.ycombinator.com/submitlink?u=%1$s&t=%2$s" target="_blank">%3$s</a>',
					rawurlencode( get_the_permalink() ),
					get_the_title(),
					skin_get_icon_hackernews()
				);
			}
			
		// Line
			if ( in_array( "Line", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="https://lineit.line.me/share/ui?url=%1$s" target="_blank">%2$s</a>',
					rawurlencode( get_the_permalink() ),
					skin_get_icon_line()
				);
			}
			
		// LinkedIn
			if ( in_array( "LinkedIn", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="http://www.linkedin.com/shareArticle?url=%1$s&title=%2$s" target="_blank">%3$s</a>',
					rawurlencode( get_the_permalink() ),
					get_the_title(),
					skin_get_icon_linkedin()
				);
			}
			
		// LiveJournal
			if ( in_array( "LiveJournal", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="http://www.livejournal.com/update.bml?subject=%2$s&event=%1$s" target="_blank">%3$s</a>',
					rawurlencode( get_the_permalink() ),
					get_the_title(),
					skin_get_icon_livejournal()
				);
			}
			
		// MySpace
			if ( in_array( "MySpace", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="https://myspace.com/post?u=%1$s&t=%2$s&%3$s" target="_blank">%4$s</a>',
					rawurlencode( get_the_permalink() ),
					get_the_title(),
					'custom caption',
					skin_get_icon_myspace()
				);
			}
			
		// OKru
			if ( in_array( "OKru", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl=%1$s&title=%2$s" target="_blank">%3$s</a>',
					rawurlencode( get_the_permalink() ),
					get_the_title(),
					skin_get_icon_okru()
				);
			}
			
		// Pocket
			if ( in_array( "Pocket", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="https://getpocket.com/save?url=%1$s" target="_blank">%2$s</a>',
					rawurlencode( get_the_permalink() ),
					skin_get_icon_pocket()
				);
			}
			
		// Reddit
			if ( in_array( "Reddit", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="https://reddit.com/submit?url=%1$s&title=%2$s" target="_blank">%3$s</a>',
					rawurlencode( get_the_permalink() ),
					get_the_title(),
					skin_get_icon_reddit()
				);
			}
			
		// StumbleUpon
			if ( in_array( "StumbleUpon", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="http://www.stumbleupon.com/submit?url=%1$s&title=%2$s" target="_blank">%3$s</a>',
					rawurlencode( get_the_permalink() ),
					get_the_title(),
					skin_get_icon_stumbleupon()
				);
			}
			
		// Telegram
			if ( in_array( "Telegram", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="https://telegram.me/share/url?url=%1$s&text=%2$s" target="_blank">%3$s</a>',
					rawurlencode( get_the_permalink() ),
					get_the_title(),
					skin_get_icon_telegram()
				);
			}
			
		// Tumblr
			if ( in_array( "Tumblr", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="https://www.tumblr.com/widgets/share/tool?canonicalUrl=%1$s&title=%2$s&caption=%3$s" target="_blank">%4$s</a>',
					rawurlencode( get_the_permalink() ),
					get_the_title(),
					'custom caption',
					skin_get_icon_tumblr()
				);
			}
			
		// Viber
			if ( in_array( "Viber", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="viber://forward?text=%1$s" target="_blank">%2$s</a>',
					rawurlencode( get_the_permalink() ),
					skin_get_icon_viber()
				);
			}
			
		// WhatsApp
			if ( in_array( "WhatsApp", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="whatsapp://send?text=%1$s" target="_blank">%2$s</a>',
					rawurlencode( get_the_permalink() ),
					skin_get_icon_whatsapp()
				);
			}
			
		// VK
			if ( in_array( "VK", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="http://vk.com/share.php?url=%1$s" target="_blank">%2$s</a>',
					rawurlencode( get_the_permalink() ),
					skin_get_icon_vk()
				);
			}
			
		// XING
			if ( in_array( "XING", $profiles ) ) {
				$share .= sprintf(
					'<a class="social-icon round va-middle" href="https://www.xing.com/app/user?op=share&url=%1$s" target="_blank">%2$s</a>',
					rawurlencode( get_the_permalink() ),
					skin_get_icon_xing()
				);
			}
			
		// Output
			return $share;
		}
	endif;

/*	6.0 GALLERIES
=================== */
//	6.1 Post gallery slider
	if ( ! function_exists( 'skin_gallery_slider' ) ) :
		function skin_gallery_slider( $img_ids ) {
			$get_images = explode(', ', $img_ids);
			
			if ( is_array( $get_images ) ) {
				if ( [""] === $get_images ) {
					$get_images = array();
				}
				
				if ( empty( $get_images ) ) {
					return '';
				}
			?>
			<div class="skin-gallery">
				<div class="skin-gallery-slider swiper-container">
					<div class="swiper-wrapper"><?php
					foreach( $get_images as $image_id ) :
						$image_id = absint( $image_id );
						$img_url = skin_get_giffy_attachment_url( $image_id );
					?>
						<div class="swiper-slide bgr-contain" style="background-image:url('<?php echo esc_url( $img_url ); ?>');"></div>
					<?php
					endforeach;
					?></div>
					
					<div class="swiper-button-white swiper-button-prev"></div>
					<div class="swiper-button-white swiper-button-next"></div>
				</div>
				
				<div class="skin-gallery-thumbs clearfix"><?php
					foreach( $get_images as $image_id ) :
						$image_id = absint( $image_id );
						$img_url = wp_get_attachment_image_src( $image_id, 'skin_small' );
						$img_url = $img_url[0];
					?>
						<div class="gallery-thumb bgr-contain" style="background-image:url('<?php echo esc_url( $img_url ); ?>');"></div>
					<?php
					endforeach;
				?></div>
			</div>
			<?php
			}
		}	
	endif;

/*	7.0 POST FORMATS
====================== */
//	7.1 Post format icon
	if ( ! function_exists( 'skin_get_post_format_icon' ) ) :   
		function skin_get_post_format_icon( $post_id = NULL ) {
			$post_id = is_null( $post_id ) ? get_the_ID() : $post_id;
			$p_format = get_post_format( $post_id );
			$icon = '';
			
			switch ( $p_format ) {
				case 'image':
					$icon = skin_get_icon_image();
					break;
					
				case 'gallery':
					$icon = skin_get_icon_gallery();
					break;
					
				case 'video':
					$icon = skin_get_icon_video();
					break;
					
				case 'audio':
					$icon = skin_get_icon_audio();
					break;
					
				case 'quote':
					$icon = skin_get_icon_quote();
					break;
					
				case 'link':
					$icon = skin_get_icon_link();
					break;
					
				default:
					$icon = '';
			}
			
			return $icon;
		}
	endif;
	
//	7.2 Post featured media
	if ( ! function_exists( 'skin_post_featured_media' ) ) :
		function skin_post_featured_media( $post_id = NULL, $img_force_featured = false ) {
			$post_id = is_null( $post_id ) ? get_the_ID() : $post_id;
			$p_format = get_post_format( $post_id );
			
			$ignore_g	= get_post_meta( $post_id, 'skin_ignore_global', true );
			$video		= get_post_meta( $post_id, 'skin_featured_video_url', true );
			$audio		= get_post_meta( $post_id, 'skin_featured_audio_url', true );
			$gallery	= get_post_meta( $post_id, 'skin_featured_gallery', true );
			
			global $wp_embed;
			
			switch( $p_format ) :
				case 'video':
					if ( $video && ( 0 === strpos( $video, 'http' ) ) ) {
				?>
					<div class="featured-media video skin-embed-holder promised"><?php echo wp_oembed_get( esc_url( $video ) ); echo skin_loading_content(); ?></div>
				<?php
					}
					break;
					
				case 'audio':					
					if ( $audio && ( 0 === strpos( $audio, 'http' ) ) ) {
				?>
					<div class="featured-media audio skin-embed-holder promised"><?php echo wp_oembed_get( esc_url( $audio ) ); echo skin_loading_content(); ?></div>
				<?php
					}
					break;
					
				case 'gallery':				
					if ( $gallery ) {
						skin_gallery_slider( $gallery );
					}
					break;
					
				default:
					$img = false;
					
					if ( 'ignore' === $ignore_g ) {
						$img = ( 'show' === get_post_meta( $post_id, 'skin_featured_img', true ) ) ? true : false;						
						
					} else {
						$img = get_theme_mod( 'skin_post_featured_img', true );
					}
					
					if ( true === $img ) {
						if ( !is_single() && true !== $img_force_featured && $img_id = get_post_meta( $post_id, 'skin_post_img_in_list', true ) ) {
						?>
							<div class="featured-img"><?php echo skin_get_giffy_img( $img_id, 'skin_wrapper_width' ); ?></div>
						<?php
							
						} else if ( has_post_thumbnail( $post_id ) ) {
						?>
							<div class="featured-img"><?php echo skin_get_giffy_featured_img( $post_id, 'skin_wrapper_width' ); ?></div>
						<?php
						}
					}
					break;
			endswitch;
		}
	endif;

/*	8.0 POST CATEGORIES DISPLAY
================================= */
//	8.1 Check if the post has a category (excluding 'Uncategorized')
	if ( ! function_exists( 'skin_is_categorized' ) ) :   
		function skin_is_categorized( $post_id ) {
			$has_cats = false;
			$terms = wp_get_object_terms( $post_id, 'category' );
			
			if ( is_array( $terms ) ) :
				foreach( $terms as $index => $term ) :
					if ( 'uncategorized' === $term->slug ) {
						unset( $terms[ $index ] );
					}
				endforeach;
				
				if ( 0 < count( $terms ) ) {
					$has_cats = true;
				}
			endif;
			
			return $has_cats;
		}
	endif;
	
//	8.2 Assign category relevance value
/*
	Calculation is performed by matching the category ID
	with any ID from the array in second argument
*/
	if ( ! function_exists( 'skin_relevant_cats' ) ) :
		function skin_relevant_cats( $cat, $priority = array() ) {
			$match = 0;
			$cat_id = $cat->term_id;
						
			if ( in_array( $cat_id, $priority ) ) {				
				$match++;
			}
			
			return $match;
		}
	endif;
	
//	8.3 Get post categories
/*
	Retrieve assigned categories, excluding "Uncategorized".
	Categories are displayed as links to their archives, each in a specific color assigned by user.
	When no particular color is assigned for a category, the "Small item" color is inherited. 
	If some categories are prioritized by user, they are pushed higher in array.
	If the number of categories is limited by user, the array is sliced accordingly.
*/
	if ( ! function_exists( 'skin_get_post_categories' ) ) :
		function skin_get_post_categories( $post_id = NULL, $prioritize = false, $limit = -1 ) {
			$post_id = is_null( $post_id ) ? get_the_ID() : $post_id;
			$catlist = '';			
			$limited = ( 0 < $limit ) ? true : false;
			
			if ( skin_is_categorized( $post_id ) ) :
				$cats = get_the_category( $post_id );				
			/*
				Check if some categories should be prioritized,
				sort by category count (number of assigned posts) otherwise
			*/
				if ( true === $prioritize ) {
					$push_cats = skin_get_meta( 'skin_prioritize_cats' );
					$push_cats = explode( ',', $push_cats );						
					array_pop( $push_cats );
					
				// Calculate the relevance for each category
					foreach( $cats as $cat ) {
						$cat->relevance = skin_relevant_cats( $cat, $push_cats );				
					}
					
					usort( $cats, 'skin_compare_by_relevance' );
					
				} else {
					usort( $cats, 'skin_sort_by_count' );
				}
				
				if ( $limited ) {
					$cats = array_slice( $cats, 0, $limit );
				}
				
				foreach( $cats as $cat ) {
					$cat_slug = $cat->slug;
					
					if ( $cat_slug != 'uncategorized' ) {
						$cat_color = get_theme_mod( 'skin_colors_cat_'.$cat_slug, '#f18597' );
						
						$catlist .= sprintf(
							'<a href="%1$s" style="background:%3$s"><h6>%2$s</h6></a>',
							esc_url( get_category_link( $cat->term_id ) ),
							esc_html( $cat->name ),
							esc_attr( $cat_color )
						);
					}
				}
				
				return $catlist;
			endif;
		}
	endif;
	
/*	9.0 POST TAG CLOUD DISPLAY
================================ */
//	9.1 Get post tags, sorted by popularity
	if ( ! function_exists( 'skin_post_tag_cloud' ) ) :
		function skin_post_tag_cloud( $post_id = NULL ) {
			$post_id = is_null( $post_id ) ? get_the_ID() : $post_id;
			$tags = wp_get_post_tags( $post_id );
			
			if ( $tags ) {
				usort( $tags, 'skin_sort_by_count' );
			
				foreach( $tags as $tag ) {
				?>
				<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag link-button va-middle skin-outlined-bttn"><?php
					echo esc_html( $tag->name );
				?></a>
				<?php
				}
			}
		}
	endif;
	
/*	10.0 RELATED POSTS
======================== */
//	10.1 Calculate the post relevance by matching tags
	if ( ! function_exists( 'skin_post_matches_tags' ) ) :
		function skin_post_matches_tags( $post_id, $tags_ids ) {
			$match = 0;
			
			foreach ( $tags_ids as $tagid ) {
				if ( has_tag( $tagid, $post_id ) ) {
					$match++;
				}
			}
			
			return $match;
		}
	endif;
	
//	10.2 Related posts - tabs
	if ( ! function_exists( 'skin_related_posts_tabs' ) ) :
		function skin_related_posts_tabs() {
			$output = '';			
			$qty = get_theme_mod( 'skin_related_in_topbar_qty', 3 );
			
		// Get matches by same tag
			$tags = wp_get_post_tags( get_the_ID() );
			
			if ( $tags && ( 0 < $qty ) ) {
				$tags_ids = array();
				
				foreach ( $tags as $tag ) {
					$tags_ids[] = $tag->term_id;
				}
				
				$r_args = array(
					'post_type' 		=> 'post',
					'post_status'		=> 'publish',
					'posts_per_page' 	=> -1,
					'tag__in' 			=> $tags_ids,
					'post__not_in' 		=> array( get_the_ID() )
				);
				
				$r_query = new WP_Query( $r_args );
			
				if ( $r_query->have_posts() ) {
					$heading = get_theme_mod( 'skin_related_in_topbar_heading', esc_html__( 'Related posts', 'skin' ) );
					
					if ( '' !== $heading ) {
						$output .= sprintf(
							'<div class="heading"><h5>%s</h5></div>',
							esc_html( $heading )
						);
					}
					
				// Calculate the relevance (by tag) for each post
					$r_posts = $r_query->posts;
					
					foreach ( $r_posts as $post ) {
						$post_id = $post->ID;
						$post->relevance = skin_post_matches_tags( $post_id, $tags_ids );
					}
					
				// Sort the posts by relevance (matching tags)
					usort( $r_posts, 'skin_compare_by_relevance' );
					array_slice( $r_posts, 0, $qty, true );
					
				// Open the related posts wrapper
					$output .= '<div class="related-posts tabs va-middle">';
					
					$limit = 0;
					
					while ( $r_query->have_posts() && $limit < $qty ) :
						$r_query->the_post();
					
					// Add the post thumbnail, if it has one
						$thumb_url = '';
						
						if ( get_post_meta( get_the_ID(), 'skin_post_tiny_gif', true ) ) {
							$thumb_id = get_post_meta( get_the_ID(), 'skin_post_tiny_gif', true );
							$thumb_url = skin_get_giffy_attachment_url( $thumb_id, 'skin_small' );
							
						} else if ( skin_get_meta( 'skin_post_img_in_list' ) ) {
							$thumb_id = skin_get_meta( 'skin_post_img_in_list' );
							$thumb_url = skin_get_giffy_attachment_url( $thumb_id, 'thumbnail' );
							
						} else if ( has_post_thumbnail( get_the_ID() ) ) {
							$thumb_url = skin_get_giffy_featured_img_url( get_the_ID(), 'thumbnail' );
							
						} else if (
							'gallery' === get_post_format( get_the_ID() )
							&& function_exists( 'skin_featured_area_get_meta' )
							&& get_post_meta( get_the_ID(), 'skin_featured_gallery', true )
						) {
							$gallery = skin_featured_area_get_meta( 'skin_featured_gallery' );
							
							$get_gallery_imgs = explode( ', ', $gallery );
							
							if ( [""] === $get_gallery_imgs ) {
								$get_gallery_imgs = [];
							}
							
							if ( is_array( $get_gallery_imgs ) && !empty( $get_gallery_imgs ) ) {
								$thumb_id = $get_gallery_imgs[0];
								$thumb_url = skin_get_giffy_attachment_url( $thumb_id, 'thumbnail' );
							}							
						}
						
						if ( '' === $thumb_url && $img_placeholder = skin_get_theme_mod_img_src( 'skin_img_placeholder' ) ) {
							$thumb_url = $img_placeholder;							
						}
						
						$c_link = get_post_meta( get_the_ID(), 'skin_custom_post_link', true );
						$c_target = get_post_meta( get_the_ID(), 'skin_custom_post_link_target', true );
						$p_link = $c_link ? $c_link : get_permalink( get_the_ID() );
						$p_target = ( 'new-tab' === $c_target ) ? '_blank' : '_self';
						
					// Open the thumb wrapper	
						$output .= '<div class="thumb">';
						
					// Add the linked image
						$output .= sprintf(
							'<a href="%1$s" target="%2$s" class="round bgr-cover small-item-bgr" style="background-image:url(\'%3$s\');"></a>',
							esc_url( $p_link ),
							esc_attr( $p_target ),
							esc_url( $thumb_url )
						);
						
					// Append the post title
						$output .= sprintf(
							'<span class="title hidden">%s</span>',
							esc_html( get_the_title( get_the_ID() ) )
						);
						
					// Close the thumb wrapper
						$output .= '</div>';
						
						$limit++;
					endwhile;
					
					wp_reset_postdata();
					
				// Open the content wrapper
					$output .= '<div class="content-box"><div class="content top-bar-bgr">';
					
				// Holder for the post title
					$output .= '<div class="post-title"><a class="link-hov-main" href="#"><h5 class="cut-by-lines" data-lines-limit="2"></h5></a></div>';					
					
				// Close the content wrapper
					$output .= '</div></div>';					
					
				// Close the related posts wrapper
					$output .= '</div>';
				}
			}
		
			return $output;			
		}	
	endif;
	
//	10.3 Related posts - carousel
	if ( ! function_exists( 'skin_related_posts' ) ) :
		function skin_related_posts( $heading = '', $qty = NULL ) {
			$output = '';
			$qty = is_null( $qty ) ? get_theme_mod( 'skin_related_qty', 6 ) : $qty;
			
		// Get matches by same tag
			$tags = wp_get_post_tags( get_the_ID() );			
				
			if ( $tags ) {
				$tags_ids = array();
				
				foreach ( $tags as $tag ) {
					$tags_ids[] = $tag->term_id;
				}
				
				$r_args = array(
					'post_type' 		=> 'post',
					'post_status'		=> 'publish',
					'posts_per_page' 	=> -1,
					'tag__in' 			=> $tags_ids,
					'post__not_in' 		=> array( get_the_ID() )
				);
				
				$r_query = new WP_Query( $r_args );
	
				if ( $r_query->have_posts() ) {					
				// Get the number of all matched posts
					$matched = $r_query->post_count;
					
				// Calculate the relevance (by tag) for each post
					$r_posts = $r_query->posts;
					
					foreach ( $r_posts as $post ) {
						$post_id = $post->ID;
						$post->relevance = skin_post_matches_tags( $post_id, $tags_ids );
					}
					
				// Sort the posts by relevance (matching tags)
					usort( $r_posts, 'skin_compare_by_relevance' );
					
				// Open the related posts wrapper
					$output .= '<div class="related-posts carousel swiper-container">';
					
				// Open the header
					$output .= '<div class="related-header clearfix">';
					$output .= '<div class="h-line txt-color-to-bgr"></div>';
					
					$output .= sprintf(
						'<h3 class="content-pad">%s</h3>',
						esc_html( $heading )
					);
					
					if ( $matched > 2 ) {						
						$output .= '<div class="nav content-pad txt-color-to-svg">';
						
						if ( is_rtl() ) {
							$output .= '<div class="prev icon va-middle">' . skin_get_elastic_arrow_right() . '</div>';
							$output .= '<div class="next icon va-middle">' . skin_get_elastic_arrow_left() . '</div>';
							
							
						} else {
							$output .= '<div class="prev icon va-middle">' . skin_get_elastic_arrow_left() . '</div>';
							$output .= '<div class="next icon va-middle">' . skin_get_elastic_arrow_right() . '</div>';
						}
						
						$output .= '</div>';
					}
					
				// Close the header
					$output .= '</div>';					
					
				// Open the slider wrapper
					$output .= '<div class="related-slider swiper-wrapper clearfix">';
					
					$limit = 0;
					
					while ( $r_query->have_posts() && $limit < $qty ) :
						$r_query->the_post();
						
					// Open a single slide wrapper, after each pair of posts
						if ( 0 === $r_query->current_post%2 ) {
							$output .= '<div class="related-slide swiper-slide clearfix">';
						}						
						
					// Open related post wrapper
						$output .= '<div class="related-post hover-trigger">';
					
					// Add the post thumbnail, if it has one. Otherwise, add the post format icon
						$thumb_url = '';
						
						if ( skin_get_meta( 'skin_post_tiny_gif' ) ) {
							$thumb_id = skin_get_meta( 'skin_post_tiny_gif' );
							$thumb_url = skin_get_giffy_attachment_url( $thumb_id, 'skin_small' );
							
						} else if ( skin_get_meta( 'skin_post_img_in_list' ) ) {
							$thumb_id = skin_get_meta( 'skin_post_img_in_list' );
							$thumb_url = skin_get_giffy_attachment_url( $thumb_id, 'skin_small' );
							
						} else if ( has_post_thumbnail( get_the_ID() ) ) {
							$thumb_url = skin_get_giffy_featured_img_url( get_the_ID(), 'skin_small' );
							
						} else if ( 'gallery' === get_post_format( get_the_ID() ) && function_exists( 'skin_featured_area_get_meta' ) ) {
							$featured_gallery = skin_featured_area_get_meta( 'skin_featured_gallery' );
							$get_gallery_imgs = explode( ', ', $featured_gallery );
							
							if ( [""] === $get_gallery_imgs ) {
								$get_gallery_imgs = [];
							}
							
							if ( is_array( $get_gallery_imgs ) && !empty( $get_gallery_imgs ) ) {
								$thumb_id = $get_gallery_imgs[0];
								$thumb_url = skin_get_giffy_attachment_url( $thumb_id, 'skin_small' );
							}							
						}						
						
						if ( '' === $thumb_url && $img_placeholder = skin_get_theme_mod_img_src( 'skin_img_placeholder' ) ) {
							$thumb_url = $img_placeholder;							
						}
						
						$c_link = get_post_meta( get_the_ID(), 'skin_custom_post_link', true );
						$c_target = get_post_meta( get_the_ID(), 'skin_custom_post_link_target', true );	
						$p_link = $c_link ? $c_link : get_permalink( get_the_ID() );
						$p_target = ( 'new-tab' === $c_target ) ? '_blank' : '_self';
						
						if ( '' != $thumb_url ) {
							$output .= sprintf(
								'<div class="thumb"><a href="%1$s" target="%2$s" class="round bgr-cover shrinking-img" style="background-image:url(\'%3$s\');"><div class="shrinker content-pad-to-border"></div></a></div>',
								esc_url( $p_link ),
								esc_attr( $p_target ),
								esc_url( $thumb_url )
							);
							
						} else {
							$output .= sprintf(
								'<div class="thumb"><a href="%1$s" target="%2$s" class="round shrinking-img gradient-bgr-vert"><div class="shrinker content-pad-to-border"></div></a></div>',
								esc_url( $p_link ),
								esc_attr( $p_target )
							);
						}						
						
					// Add the post content
						$output .= '<div class="related-content">';
						
						$title = get_the_title( get_the_ID() );
						
						$output .= sprintf(
							'<h5><a class="masked-content" href="%1$s" target="%2$s"><div class="txt cut-by-lines" data-lines-limit="3">%3$s</div><div class="mask to-left"><div class="mask-txt masked-txt cut-by-lines" data-lines-limit="3">%3$s</div></div></a></h5>',
							esc_url( $p_link ),
							esc_attr( $p_target ),
							esc_html( $title )
						);
						
						$output .= '<div class="post-details">';
						$output .= skin_post_date();
						
					// Close the post details wrapper
						$output .= '</div>';
							
					// Close the post content wrapper
						$output .= '</div>';
						
					// Close the related post wrapper
						$output .= '</div>';
						
					// Close the single slide wrapper, after each pair of posts
						if ( 1 === $r_query->current_post%2 || $r_query->current_post == $r_query->post_count-1 ) {
							$output .= '</div>';
						}
						
						$limit++;
					endwhile;
					
					wp_reset_postdata();
					
				// Close the slider wrapper
					$output .= '</div>';
					
				// Close the related posts wrapper
					$output .= '</div>';
				}
			}
		
			return $output;			
		}
	endif;
	
/*	11.0 COMMENTS
=================== */
//	11.1 Customize comment output
	if ( ! function_exists( 'skin_comments_list' ) ) :
		function skin_comments_list( $comment, $args, $depth ) {
			$GLOBALS['comment'] = $comment;
			
			switch ( $comment->comment_type ) :
				case 'pingback' :
				case 'trackback' :
			?>
			<li class="post pingback">
				<div class="comment-box content-pad">
					<div class="comment-header clearfix">
						<div class="comment-author">
							<h3 class="author-name"><?php
								esc_html_e( 'Pingback:', 'skin' );
							?></h3>
						</div>
						
						<div class="edit-reply va-middle"><?php
							edit_comment_link( esc_html__( 'Edit', 'skin' ), '<span class="comment-edit-button">', '</span>' );
						?></div>
					</div>
					
					<div class="comment-text shareable-selections"><?php
						if ( 0 ==  $comment->comment_approved ) :
							printf(
								'<em>%s</em>',
								esc_html__( 'Comment awaiting approval', 'skin' )
							);
						endif;
						
						comment_author_link();
					?></div>
				</div>
			<?php
				break;
				
				default :
			
				$get_comment = get_comment( $comment );
				$comment_author_email = get_object_vars( $get_comment )['comment_author_email'];
				$comment_class[] = "clearfix";
			?>
				<li <?php comment_class( $comment_class ); ?> id="comment-<?php comment_ID() ?>">
					<div class="comment-box content-pad">
						<div class="comment-header clearfix">
							<div class="avatar-holder round"><?php echo get_avatar( $comment, $args['avatar_size'] ); ?></div>
							
							<div class="comment-author">
								<h3 class="author-name"><?php
									echo wp_kses(
										get_comment_author_link(),
										array(
											'a' => array(
												'href' => array(),
												'rel' => array(),
												'class' => array()
											)
										)
									);
								?></h3>
								
								<span class="meta post-details"><?php printf( '%1$s %3$s %2$s', esc_html( get_comment_date() ),  esc_html( get_comment_time() ), esc_html_x( 'at', 'preposition, as in March 12, 2013 at 1:17 pm', 'skin' ) ); ?></span>
							</div>
							
							<div class="edit-reply va-middle">					
								<span class="comments-reply-button"><?php
									comment_reply_link(
										array_merge(
											$args,
											array(
												'reply_text' => esc_html__( 'Reply', 'skin' ),
												'depth' => $depth,
												'max_depth' => $args['max_depth']
											)
										),
										$comment->comment_ID
									);
								?></span>
								
								<span class="comments-edit-button"><?php
									edit_comment_link( esc_html__( 'Edit', 'skin' ) );
								?></span>
							</div>
						</div>
						
						<div class="comment-text shareable-selections"><?php
							if ( 0 ==  $comment->comment_approved ) :
								printf(
									'<em>%s</em>',
									esc_html__( 'Comment awaiting approval', 'skin' )
								);
							endif;
							
							comment_text();
						?></div>
					</div>
			<?php 
				break;
			endswitch;
		}
	endif;
	
/*	12.0 PAGINATION
====================== */
//	12.1 Pagination
	if ( ! function_exists( 'skin_posts_pagination' ) ) :
		function skin_posts_pagination( $numpages = '', $pagerange = '', $paged = '' ) {			
			if ( empty( $pagerange ) ) {
				$pagerange = 1;
			}
			
			global $paged;
			
			if ( empty( $paged ) ) {
				$paged = 1;
			}
			
			if ( '' === $numpages ) {
				global $wp_query;
				
				$numpages = intval( $wp_query->max_num_pages );
				
				if ( !$numpages ) {
					$numpages = 1;
				}
			}
			
			$add_args = false;
			
			if ( get_option( 'permalink_structure' ) ) {
				$format = 'page/%#%/';
				
				if ( is_search() ) {
					$base = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ).$format, 'paged' );
					$add_args = array( 's' => get_query_var( 's' ) );
					
				} else {
					$base = get_pagenum_link(1) . $format;
				}
				
			} else {
				$format = '?paged=%#%';
				$base = '%_%';
			}
			
			$p_args = array(
				'base'            => $base,
				'format'          => $format,
				'total'           => $numpages,
				'current'		  => max( 1, get_query_var( 'paged' ) ),
				'end_size'        => 1,
				'mid_size'        => $pagerange,
				'prev_next'       => false,
				'type'            => 'list',
				'add_args'        => $add_args,
				'before_page_number' => '<span class="page-num va-middle">',
				'after_page_number'  => '</span>'
			);
			
			$pages = paginate_links( $p_args );

			if ( $pages ) :		
				$arrow_left = skin_get_elastic_arrow_left();				
				$arrow_right = skin_get_elastic_arrow_right();
			?>
			<div class="posts-list-pagination pagination clearfix txt-color-to-svg">
			<?php
			if ( is_rtl() ) {
				// Next posts link
				if ( get_next_posts_link() ) {
				?>
					<div class="next nav va-middle hover-trigger content-pad"><?php
						next_posts_link( $arrow_left, $numpages );
					?></div>
				<?php						
				} else {
				?>
					<div class="inactive next nav va-middle content-pad"><?php echo skin_get_icon_arrow_left(); ?></div>
				<?php
				}
					
				// Previous posts link
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
				// Next posts link
				if ( get_next_posts_link() ) {
				?>
					<div class="next nav va-middle hover-trigger content-pad"><?php
						next_posts_link( $arrow_right, $numpages );
					?></div>
				<?php						
				} else {
				?>
					<div class="inactive next nav va-middle content-pad"><?php echo skin_get_icon_arrow_right(); ?></div>
				<?php
				}
					
				// Previous posts link
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
					echo paginate_links( $p_args );
				?></div>
			</div>
			<?php
			endif;
		}
	endif;
	
//	12.2 Loading animation for infinite scroll
	if ( ! function_exists( 'skin_loading_posts' ) ) :
		function skin_loading_posts() {
			$loader = '<div class="loading posts-list-pagination txt-color-to-svg"><div class="loader"><div class="round colored small-item-bgr-light"></div><div class="round transparent body-bgr"></div></div></div>';
			
			return $loader;
		}
	endif;
	
/*	13.0 FEATURED POSTS
========================= */
//	13.1 Enlarged featured post
	if ( ! function_exists( 'skin_post_enlarged' ) ) :
		function skin_post_enlarged( $post_id ) {			
			$featured_area_works = function_exists( 'skin_featured_area_get_meta' );
			$p_format = get_post_format( $post_id );
			
			$c_link = get_post_meta( $post_id, 'skin_custom_post_link', true );
			$c_target = get_post_meta( $post_id, 'skin_custom_post_link_target', true );
			$p_link = $c_link ? $c_link : get_permalink( $post_id );
			$p_target = ( 'new-tab' === $c_target ) ? '_blank' : '_self';
		?>
			<div class="enlarged-post content-wrapper content-pad">
				<article data-post-id="<?php echo esc_attr( $post_id ); ?>" <?php post_class( '', $post_id ); ?>><?php	
				// Trendy post badge
					if ( true === get_theme_mod( 'skin_blog_trendy', true ) && skin_is_trendy_post( $post_id ) ) {
				?>
					<div class="trendy-badge va-middle small-item-bgr small-item-color"><?php echo skin_get_icon_trendy(); ?></div>
				<?php
					}
				?>
					<div class="featured-area">
						<a href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"><?php
						if ( $featured_area_works ) {
							skin_post_featured_media( $post_id, true );
							
						} else {
							$img = false;
							
							if ( 'ignore' === $ignore_g ) {
								$img = ( 'show' === get_post_meta( $post_id, 'skin_featured_img', true ) ) ? true : false;						
								
							} else {
								$img = get_theme_mod( 'skin_post_featured_img', true );
							}
							
							if ( true === $img && has_post_thumbnail( $post_id ) ) {
							?>
								<div class="featured-img"><?php echo skin_get_giffy_featured_img( $post_id, 'skin_wrapper_width' ); ?></div>
							<?php
							}
						}
						?></a>
					</div>
					
					<header class="post-header"><?php
					// Edit post
						skin_edit_post( $post_id );
						
					// Post category
						if ( true === get_theme_mod( 'skin_featured_show_cat', true ) ) {
							$p = ( '' !== get_post_meta( $post_id, 'skin_prioritize_cats', true ) ) ? true : false;
							$l = get_theme_mod( 'skin_blog_limit_cats' );
					?>
						<div class="categories"><?php echo skin_get_post_categories( $post_id, $p, $l ); ?></div>
					<?php
						}
						
					// Post title
					?>
						<h1>
							<a href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"><?php
								if ( 'link' === $p_format || 'quote' === $p_format ) {
							?>
								<div class="post-format-icon txt-color-pale-to-svg"><?php echo skin_get_post_format_icon( $post_id ); ?></div>
							<?php
								}
								
								if ( 'quote' === $p_format && $featured_area_works && $quote = get_post_meta( $post_id, 'skin_featured_quote', true ) ) {
									printf(
										'<span>%s</span>',
										esc_html( $quote )
									);
									
								} else {
									printf(
										'<span>%s</span>',
										esc_html( get_the_title( $post_id ) )
									);
								}
							?></a>
						</h1>					
					<?php
					// Quote author
						if ( "quote" === $p_format && $featured_area_works && $quote_author = get_post_meta( $post_id, 'skin_featured_quote_author', true ) ) {
							printf(
								'<h3>&dash; %s</h3>',
								esc_html( $quote_author )
							);
						}
						
					// Link URL
						if ( "link" === $p_format && $featured_area_works && $link_url = get_post_meta( $post_id, 'skin_featured_link', true ) ) {
							printf(
								'<h3><a href="%1$s" target="_blank">%2$s</a></h3>',
								esc_url( $link_url ),
								esc_html( $link_url )
							);
						}
					
					// Post excerpt
						if ( true === get_theme_mod( 'skin_featured_show_excerpt', true ) ) {
						?>
						<div class="post-excerpt shareable-selections clearfix"><?php
							skin_post_excerpt( $post_id );
						?></div>
						<?php
						}
						?>
						
						<div class="post-details"><?php
							$show_author = get_theme_mod( 'skin_featured_show_author', true );
							$show_date = get_theme_mod( 'skin_featured_show_date', true );
							
						// Post author
							if ( true === $show_author ) {								
								echo skin_post_author( $post_id );
							}
							
							if ( true === $show_author && true === $show_date ) {
							?>
							<div class="divider-slash"></div>
							<?php
							}
								
						// Post date
							if ( true === $show_date ) {
								echo skin_post_date( $post_id );
							}
						?></div>
					</header>
				</article>
			</div>
	<?php
		}
	endif;
	
//	13.2 Posts grid
	if ( ! function_exists( 'skin_posts_grid' ) ) :
		function skin_posts_grid( $post_ids = array() ) {
			if ( 3 !== count( $post_ids ) ) {
				return '';
				
			} else {
				$post_0_id = $post_ids[0];
				$post_1_id = $post_ids[1];
				$post_2_id = $post_ids[2];
				
				$featured_area_works = function_exists( 'skin_featured_area_get_meta' );
				$show_cats = get_theme_mod( 'skin_featured_show_cat', true );
				$show_author = get_theme_mod( 'skin_featured_show_author', true );
				$show_date = get_theme_mod( 'skin_featured_show_date', true );								
				$limit_cats = get_theme_mod( 'skin_blog_limit_cats' );
				$img_placeholder = skin_get_theme_mod_img_src( 'skin_img_placeholder' );
				$show_trendy = get_theme_mod( 'skin_blog_trendy', true );
			?>
				<div class="skin-posts-grid content-wrapper clearfix">
					<article data-post-id="<?php echo esc_attr( $post_0_id ); ?>" class="post-larger content-pad"><?php	
					// Trendy post badge
						if ( true === $show_trendy && skin_is_trendy_post( $post_0_id ) ) {
					?>
						<div class="trendy-badge va-middle small-item-bgr small-item-color"><?php echo skin_get_icon_trendy(); ?></div>
					<?php
						}
					?>
						<div class="featured-area gradient-bgr-vert txt-on-gradient">
					<?php
						$img_0_url = '';
						
						if ( has_post_thumbnail( $post_0_id ) ) {
							$img_0_url = skin_get_giffy_featured_img_url( $post_0_id, 'skin_wrapper_width' );
							
						} else if ( 'gallery' === get_post_format( $post_0_id ) && $featured_area_works ) {
							$featured_gallery = get_post_meta( $post_0_id, 'skin_featured_gallery', true );
							$get_gallery_imgs = explode( ', ', $featured_gallery );
							
							if ( [""] === $get_gallery_imgs ) {
								$get_gallery_imgs = [];
							}
							
							if ( is_array( $get_gallery_imgs ) && !empty( $get_gallery_imgs ) ) {
								$img_0_id = $get_gallery_imgs[0];
								$img_0_url = skin_get_giffy_attachment_url( $img_0_id, 'medium_large' );
							}
							
						} else if ( '' !== $img_placeholder ) {
							$img_0_url = $img_placeholder;							
						}
						
						if ( '' != $img_0_url ) {
					?>
						<div class="featured-img bgr-cover" style="background-image:url('<?php echo esc_url( $img_0_url ); ?>');"></div>
					<?php
						}
					?>
						</div>
						
						<header class="post-header"><?php
						// Edit link
							skin_edit_post( $post_0_id );
							
							$p_format = get_post_format( $post_0_id );
							
						// Post category
							if ( true === $show_cats ) {
								$p = ( '' !== get_post_meta( $post_0_id, 'skin_prioritize_cats', true ) ) ? true : false;
						?>
							<div class="categories"><?php echo skin_get_post_categories( $post_0_id, $p, $limit_cats ); ?></div>
						<?php
							}
							
						// Post title
							$c_link_0 = get_post_meta( $post_0_id, 'skin_custom_post_link', true );
							$c_target_0 = get_post_meta( $post_0_id, 'skin_custom_post_link_target', true );
							$p_link_0 = $c_link_0 ? $c_link_0 : get_permalink( $post_0_id );
							$p_target_0 = ( 'new-tab' === $c_target_0 ) ? '_blank' : '_self';
						?>
							<h2>
								<a href="<?php echo esc_url( $p_link_0 ); ?>" target="<?php echo esc_attr( $p_target_0 ); ?>" class="cut-by-lines" data-lines-limit="2"><?php
									echo esc_html( get_the_title( $post_0_id ) );
								?></a>
							</h2>
							
							<div class="post-details"><?php
							// Post author
								if ( true === $show_author ) {
									echo skin_post_author( $post_0_id );
								}
								
								if ( true === $show_author && true === $show_date ) {
								?>
								<div class="divider-slash"></div>
								<?php
								}
									
							// Post date
								if ( true === $show_date ) {
									echo skin_post_date( $post_0_id );
								}
							?></div>
						</header>
					</article>
					
					<article data-post-id="<?php echo esc_attr( $post_1_id ); ?>" class="post-smaller post-smaller-0 content-pad"><?php	
					// Trendy post badge
						if ( true === $show_trendy && skin_is_trendy_post( $post_1_id ) ) {
					?>
						<div class="trendy-badge va-middle small-item-bgr small-item-color"><?php echo skin_get_icon_trendy(); ?></div>
					<?php
						}
					?>
						<div class="featured-area gradient-bgr-vert txt-on-gradient"><?php
							$img_1_url = '';
							
							if ( $img_1_id = get_post_meta( $post_1_id, 'skin_post_img_in_list', true ) ) {
								$img_1_url = skin_get_giffy_attachment_url( $img_1_id, 'medium_large' );
							
							} else if ( has_post_thumbnail( $post_1_id ) ) {
								$img_1_url = skin_get_giffy_featured_img_url( $post_1_id, 'medium_large' );
								
							} else if ( 'gallery' === get_post_format( $post_1_id ) && $featured_area_works ) {
								$featured_gallery = get_post_meta( $post_1_id, 'skin_featured_gallery', true );
								$get_gallery_imgs = explode( ', ', $featured_gallery );
								
								if ( [""] === $get_gallery_imgs ) {
									$get_gallery_imgs = [];
								}
								
								if ( is_array( $get_gallery_imgs ) && !empty( $get_gallery_imgs ) ) {
									$img_1_id = $get_gallery_imgs[0];
									$img_1_url = skin_get_giffy_attachment_url( $img_1_id, 'medium_large' );
								}
								
							} else if ( '' !== $img_placeholder ) {
								$img_1_url = $img_placeholder;							
							}
							
							if ( '' != $img_1_url ) {
						?>
							<div class="featured-img bgr-cover" style="background-image:url('<?php echo esc_url( $img_1_url ); ?>');"></div>
						<?php
							}
						?></div>
						
						<header class="post-header"><?php
						// Edit post
							skin_edit_post( $post_1_id );
							
						// Post category
							if ( true === $show_cats ) {
								$p = ( '' !== get_post_meta( $post_1_id, 'skin_prioritize_cats', true ) ) ? true : false;
						?>
							<div class="categories"><?php echo skin_get_post_categories( $post_1_id, $p, $limit_cats ); ?></div>
						<?php
							}
							
						// Post title
							$c_link_1 = get_post_meta( $post_1_id, 'skin_custom_post_link', true );
							$c_target_1 = get_post_meta( $post_1_id, 'skin_custom_post_link_target', true );
							$p_link_1 = $c_link_1 ? $c_link_1 : get_permalink( $post_1_id );
							$p_target_1 = ( 'new-tab' === $c_target_1 ) ? '_blank' : '_self';
						?>
							<h3>
								<a href="<?php echo esc_url( $p_link_1 ); ?>" target="<?php echo esc_attr( $p_target_1 ); ?>" class="cut-by-lines" data-lines-limit="2"><?php
									echo esc_html( get_the_title( $post_1_id ) );
								?></a>
							</h3>
						</header>
					</article>
					
					<article data-post-id="<?php echo esc_attr( $post_2_id ); ?>" class="post-smaller content-pad"><?php	
					// Trendy post badge
						if ( true === $show_trendy && skin_is_trendy_post( $post_2_id ) ) {
					?>
						<div class="trendy-badge va-middle small-item-bgr small-item-color"><?php echo skin_get_icon_trendy(); ?></div>
					<?php
						}
					?>
						<div class="featured-area gradient-bgr-vert txt-on-gradient"><?php
						$img_2_url = '';
							
						if ( $img_2_id = get_post_meta( $post_2_id, 'skin_post_img_in_list', true ) ) {
							$img_2_url = skin_get_giffy_attachment_url( $img_2_id, 'medium_large' );
						
						} else if ( has_post_thumbnail( $post_2_id ) ) {
							$img_2_url = skin_get_giffy_featured_img_url( $post_2_id, 'medium_large' );
							
						} else if ( 'gallery' === get_post_format( $post_2_id ) && $featured_area_works ) {
							$featured_gallery = get_post_meta( $post_2_id, 'skin_featured_gallery', true );
							$get_gallery_imgs = explode( ', ', $featured_gallery );
							
							if ( [""] === $get_gallery_imgs ) {
								$get_gallery_imgs = [];
							}
							
							if ( is_array( $get_gallery_imgs ) && !empty( $get_gallery_imgs ) ) {
								$img_2_id = $get_gallery_imgs[0];
								$img_2_url = skin_get_giffy_attachment_url( $img_2_id, 'medium_large' );
							}
							
						} else if ( '' !== $img_placeholder ) {
							$img_2_url = $img_placeholder;							
						}
						
						if ( '' != $img_2_url ) {
					?>
						<div class="featured-img bgr-cover" style="background-image:url('<?php echo esc_url( $img_2_url ); ?>');"></div>
					<?php
						}
					?>
						</div>
						
						<header class="post-header"><?php
						// Edit link
							skin_edit_post( $post_2_id );
							
						// Post category
							if ( true === $show_cats ) {
								$p = ( '' !== get_post_meta( $post_2_id, 'skin_prioritize_cats', true ) ) ? true : false;
						?>
							<div class="categories"><?php echo skin_get_post_categories( $post_2_id, $p, $limit_cats ); ?></div>
						<?php
							}
							
						// Post title
							$c_link_2 = get_post_meta( $post_2_id, 'skin_custom_post_link', true );
							$c_target_2 = get_post_meta( $post_2_id, 'skin_custom_post_link_target', true );
							$p_link_2 = $c_link_2 ? $c_link_2 : get_permalink( $post_2_id );
							$p_target_2 = ( 'new-tab' === $c_target_2 ) ? '_blank' : '_self';
						?>
							<h3>
								<a href="<?php echo esc_url( $p_link_2 ); ?>" target="<?php echo esc_attr( $p_target_2 ); ?>" class="cut-by-lines" data-lines-limit="2"><?php
									echo esc_html( get_the_title( $post_2_id ) );
								?></a>
							</h3>
						</header>
					</article>					
				</div>
			<?php
			}
		}
	endif;
	
//	13.3 Posts slider
	if ( ! function_exists( 'skin_posts_slider' ) ) :
		function skin_posts_slider( $post_ids = array(), $auto = '', $show_author = true, $show_date = true ) {
			$qty = count( $post_ids );
			
			if ( 1 > $qty ) {
				return '';
				
			} else {
				$img_placeholder = skin_get_theme_mod_img_src( 'skin_img_placeholder' );
			?>
			<div class="skin-posts-slider content-wrapper" data-autoplay="<?php echo esc_attr( $auto ); ?>">
				<div class="slider-images swiper-container">
					<div class="swiper-wrapper"><?php
					foreach ( $post_ids as $post_id ) :
						$img_url = '';
						
						if ( $img_id = get_post_meta( $post_id, 'skin_post_img_in_slider', true ) ) {
							$img_url = skin_get_giffy_attachment_url( $img_id );
							
						} else if ( $img_id = get_post_meta( $post_id, 'skin_post_img_in_list', true ) ) {
							$img_url = skin_get_giffy_attachment_url( $img_id, 'medium_large' );
						
						} else if ( has_post_thumbnail( $post_id ) ) {
							$img_url = skin_get_giffy_featured_img_url( $post_id );
							
						} else if ( 'gallery' === get_post_format( $post_id ) && function_exists( 'skin_featured_area_get_meta' ) ) {
							$featured_gallery = get_post_meta( $post_id, 'skin_featured_gallery', true );
							$get_gallery_imgs = explode( ', ', $featured_gallery );
							
							if ( [""] === $get_gallery_imgs ) {
								$get_gallery_imgs = [];
							}
							
							if ( is_array( $get_gallery_imgs ) && !empty( $get_gallery_imgs ) ) {
								$img_id = $get_gallery_imgs[0];
								$img_url = skin_get_giffy_attachment_url( $img_id, 'medium_large' );
							}										
						}
						
						if ( '' === $img_url && '' !== $img_placeholder ) {
							$img_url = $img_placeholder;							
						}
					?>
						<div class="swiper-slide start va-middle"><a href="#"><?php
							if ( '' !== $img_url ) {								
						?>
							<div class="post-image round bgr-cover" style="background-image:url('<?php echo esc_url( $img_url ); ?>');"><?php
								if ( true === get_theme_mod( 'skin_blog_trendy', true ) && skin_is_trendy_post( $post_id ) ) {
							?>
								<div class="trendy-badge round va-middle small-item-bgr small-item-color"><?php echo skin_get_icon_trendy(); ?></div>
							<?php
								}
							?></div>
						<?php
							} else {
						?>
							<div class="post-image round small-item-bgr"><?php
								if ( true === get_theme_mod( 'skin_blog_trendy', true ) && skin_is_trendy_post( $post_id ) ) {
							?>
								<div class="trendy-badge round va-middle small-item-bgr small-item-color"><?php echo skin_get_icon_trendy(); ?></div>
							<?php
								}
							?></div>
						<?php
							}
						?></a></div>
					<?php
					endforeach;
					?></div>
				</div>
				
				<div class="slider-content swiper-container content-wrapper">
					<div class="swiper-wrapper"><?php
						foreach ( $post_ids as $post_id ) :
	
						$c_link = get_post_meta( $post_id, 'skin_custom_post_link', true );
						$c_target = get_post_meta( $post_id, 'skin_custom_post_link_target', true );	
						$p_link = $c_link ? $c_link : get_permalink( $post_id );
						$p_target = ( 'new-tab' === $c_target ) ? '_blank' : '_self';
					?>
						<div class="swiper-slide">						
							<div class="post-wrapper clearfix">
								<div class="post-title"><h1>
									<a class="cut-by-lines post-link" data-lines-limit="2"
										href="<?php echo esc_url( $p_link ); ?>"
										target="<?php echo esc_attr( $p_target ); ?>"
									><?php
										echo get_the_title( $post_id );
									?></a>
								</h1></div>
								
								<div class="details"><h5><?php
									if ( true === $show_author ) {
										echo skin_post_author( $post_id );
									}
						
									if ( true === $show_date ) {
										echo skin_post_date( $post_id );	
									}
								?></h5></div>
							</div>						
						</div>
					<?php
						endforeach;
					?></div>
					
					<div class="navigation va-middle">
						<div class="nav-wheel content-pad txt-color-to-svg"><a class="va-middle" href="" target=""><?php echo skin_get_icon_eye(); ?></a></div>						
					<?php
						if ( 1 < $qty ) {
					?>
						<div class="prev nav txt-color-to-svg"><?php echo skin_get_elastic_arrow_left(); ?></div>
						<div class="next nav txt-color-to-svg"><?php echo skin_get_elastic_arrow_right(); ?></div>
					<?php
						}
					?>
					</div>
				</div>
					
				<div class="separator"><div class="v-line txt-color-to-bgr"></div></div>
			</div>
			<?php
			}
		}
	endif;
	
/*	14.0 POPULAR/TRENDY POSTS
=============================== */
//	14.1 Set post views counter	
	if ( ! function_exists( 'skin_set_post_views' ) ) :   
		function skin_set_post_views( $post_id = NULL ) {
			$post_id	= is_null( $post_id ) ? get_the_ID() : $post_id;
			$count_key	= 'skin_post_views_count';
			$count		= get_post_meta( $post_id, $count_key, true );
			
			if ( '' === $count ) {
				$count = 0;
				delete_post_meta( $post_id, $count_key );
				add_post_meta( $post_id, $count_key, '0' );
				
			} else {
				$count++;
				update_post_meta( $post_id, $count_key, $count );
			}
		}
	endif;	

//	14.2 Get post views by post ID	
	if ( ! function_exists( 'skin_get_post_views' ) ) :
		function skin_get_post_views( $post_id = NULL ) {
			$post_id	= is_null( $post_id ) ? get_the_ID() : $post_id;
			$count_key	= 'skin_post_views_count';
			$count		= get_post_meta( $post_id, $count_key, true );
			
			if ( '' === $count ) {
				delete_post_meta( $post_id, $count_key );
				add_post_meta( $post_id, $count_key, '0' );
				return "0";
			}
			
			return $count;
		}
	endif;
	
//	14.3 Get array of IDs for posts with most views
	if ( ! function_exists( 'skin_get_trendy_posts' ) ) :
		function skin_get_trendy_posts( $qty = 4 ) {
			$trendy_ids = array();
			$qty = get_theme_mod( 'skin_blog_trendy_qty', 5 );
			
			$t_args = array(
				'post_type'        		=> 'post',
				'post_status'      		=> 'publish',
				'ignore_sticky_posts' 	=> 1,
				'posts_per_page'   		=> $qty,
				'orderby' 				=> 'meta_value_num',
				'meta_key' 				=> 'skin_post_views_count',
				'order' 				=> 'DESC'
			);
			
			$trendy_posts = get_posts( $t_args );
			
			foreach( $trendy_posts as $trendy ) {
				$trendy_id = $trendy->ID;
				$trendy_ids[] = $trendy_id;
			}
			
			return $trendy_ids;
		}
	endif;
	
//	14.4 Check if post is trendy, by its ID
	if ( ! function_exists( 'skin_is_trendy_post' ) ) :
		function skin_is_trendy_post( $post_id = NULL ) {
			$post_id = is_null( $post_id ) ? get_the_ID() : $post_id;
			
			if ( in_array( $post_id, skin_get_trendy_posts() ) ) {
				return true;
				
			} else {
				return false;
			}
		}
	endif;
	
/*	15.0 SPECIAL BOXES for masonry layout
=========================================== */
//	15.1 Special box order
/*
	Check if the special box should show up in the list,
	depending on its start/interval settings
	and the order of the current post
*/
	if ( ! function_exists( 'skin_specials_item_order' ) ) :
		function skin_specials_item_order( $allow, $start, $interval, $order ) {
			if ( 1 > $interval ) {
				return false;
				
			} else {
				$order++;
				
				$show_special = $allow && ( ( $start === $order ) || ( $order > $start && ( 0 === ( $order - $start ) % $interval ) ) );
				
				if ( !$show_special ) {
					return false;
					
				} else {
					return true;
				}
			}
		}
	endif;

//	15.2 Popout page
	if ( ! function_exists( 'skin_specials_render_popout' ) ) :
		function skin_specials_render_popout() {
			$pop_page_id = get_theme_mod( 'skin_specials_popout_id' );
				
			if ( ! function_exists( 'skin_popout_init' ) || 'publish' != get_post_status( $pop_page_id ) ) {
				return '';
				
			} else {
				$c = 'widget skin-widget-pop content-pad';
				
				$bgr = get_theme_mod( 'skin_specials_popout_bgr', 'content-pad' );
				
				if ( 'gradient-bgr' === $bgr ) {
					$c = 'widget skin-widget-pop gradient-bgr txt-on-gradient';
				}
				
				if ( 'no-bgr' === $bgr ) {
					$c = 'widget skin-widget-pop';
				}
				
				$widget_args = sprintf(
					'before_widget=<div class="%s">',
					esc_attr( $c )
				);
			
				$label = get_theme_mod( 'skin_specials_popout_label' );			
			?>
				<div class="masonry-item-wrapper">
					<div class="masonry-item">
						<div class="masonry-content"><?php
							$instance = array(
								'pop_page'	=> $pop_page_id,
								'label'		=> $label
							);
							
							the_widget( 'skin_pop', $instance, $widget_args );
						?></div>
					</div>
				</div>
			<?php
			}
		}
	endif;
	
//	15.3.1 Image Banner 1
	if ( ! function_exists( 'skin_specials_render_image_1' ) ) :
		function skin_specials_render_image_1() {
			$widget_args = 'before_title=<h5 class="widget-title">&after_title=</h5>';
			$image_url = get_theme_mod( 'skin_specials_bnnr_1' );
			$image_id = skin_get_post_id_by_url( $image_url );
			$image_link = get_theme_mod( 'skin_specials_bnnr_link_1' );
			$new_tab = true === get_theme_mod( 'skin_specials_bnnr_newtab_1', true ) ? 1 : 0;
		?>	
			<div class="masonry-item-wrapper">
				<div class="masonry-item">
					<div class="masonry-content"><?php
						$instance = array(
							'img_link'	=> $image_link,
							'new_tab'	=> $new_tab,
							'img_id'	=> $image_id
						);
						
						the_widget( 'skin_image_banner', $instance, $widget_args );
					?></div>
				</div>
			</div>
		<?php
		}
	endif;
	
//	15.3.2 Image Banner 2
	if ( ! function_exists( 'skin_specials_render_image_2' ) ) :
		function skin_specials_render_image_2() {
			$widget_args = 'before_title=<h5 class="widget-title">&after_title=</h5>';
			$image_url = get_theme_mod( 'skin_specials_bnnr_2' );
			$image_id = skin_get_post_id_by_url( $image_url );
			$image_link = get_theme_mod( 'skin_specials_bnnr_link_2' );
			$new_tab = true === get_theme_mod( 'skin_specials_bnnr_newtab_2', true ) ? 1 : 0;
		?>	
			<div class="masonry-item-wrapper">
				<div class="masonry-item">
					<div class="masonry-content"><?php
						$instance = array(
							'img_link'	=> $image_link,
							'new_tab'	=> $new_tab,
							'img_id'	=> $image_id
						);
						
						the_widget( 'skin_image_banner', $instance, $widget_args );
					?></div>
				</div>
			</div>
		<?php
		}
	endif;
	
//	15.3.3 Image Banner 3
	if ( ! function_exists( 'skin_specials_render_image_3' ) ) :
		function skin_specials_render_image_3() {
			$widget_args = 'before_title=<h5 class="widget-title">&after_title=</h5>';
			$image_url = get_theme_mod( 'skin_specials_bnnr_3' );
			$image_id = skin_get_post_id_by_url( $image_url );
			$image_link = get_theme_mod( 'skin_specials_bnnr_link_3' );
			$new_tab = true === get_theme_mod( 'skin_specials_bnnr_newtab_3', true ) ? 1 : 0;
		?>	
			<div class="masonry-item-wrapper">
				<div class="masonry-item">
					<div class="masonry-content"><?php
						$instance = array(
							'img_link'	=> $image_link,
							'new_tab'	=> $new_tab,
							'img_id'	=> $image_id
						);
						
						the_widget( 'skin_image_banner', $instance, $widget_args );
					?></div>
				</div>
			</div>
		<?php
		}
	endif;
	
//	15.3.4 Image Banner 4
	if ( ! function_exists( 'skin_specials_render_image_4' ) ) :
		function skin_specials_render_image_4() {
			$widget_args = 'before_title=<h5 class="widget-title">&after_title=</h5>';
			$image_url = get_theme_mod( 'skin_specials_bnnr_4' );
			$image_id = skin_get_post_id_by_url( $image_url );
			$image_link = get_theme_mod( 'skin_specials_bnnr_link_4' );
			$new_tab = true === get_theme_mod( 'skin_specials_bnnr_newtab_4', true ) ? 1 : 0;
		?>	
			<div class="masonry-item-wrapper">
				<div class="masonry-item">
					<div class="masonry-content"><?php
						$instance = array(
							'img_link'	=> $image_link,
							'new_tab'	=> $new_tab,
							'img_id'	=> $image_id
						);
						
						the_widget( 'skin_image_banner', $instance, $widget_args );
					?></div>
				</div>
			</div>
		<?php
		}
	endif;
	
//	15.3.5 Image Banner 5
	if ( ! function_exists( 'skin_specials_render_image_5' ) ) :
		function skin_specials_render_image_5() {
			$widget_args = 'before_title=<h5 class="widget-title">&after_title=</h5>';
			$image_url = get_theme_mod( 'skin_specials_bnnr_5' );
			$image_id = skin_get_post_id_by_url( $image_url );
			$image_link = get_theme_mod( 'skin_specials_bnnr_link_5' );
			$new_tab = true === get_theme_mod( 'skin_specials_bnnr_newtab_5', true ) ? 1 : 0;
		?>	
			<div class="masonry-item-wrapper">
				<div class="masonry-item">
					<div class="masonry-content"><?php
						$instance = array(
							'img_link'	=> $image_link,
							'new_tab'	=> $new_tab,
							'img_id'	=> $image_id
						);
						
						the_widget( 'skin_image_banner', $instance, $widget_args );
					?></div>
				</div>
			</div>
		<?php
		}
	endif;
	
//	15.4 Social Profiles
	if ( ! function_exists( 'skin_specials_render_social' ) ) :
		function skin_specials_render_social() {
			$c = 'widget skin-widget-social-profiles content-pad';			
			$bgr = get_theme_mod( 'skin_specials_social_bgr', 'content-pad' );
			
			if ( 'gradient-bgr' === $bgr ) {
				$c = 'widget skin-widget-social-profiles gradient-bgr txt-on-gradient';
			}
			
			if ( 'no-bgr' === $bgr ) {
				$c = 'widget skin-widget-social-profiles';
			}
			
			$widget_args = sprintf(
				'before_widget=<div class="%s">',
				esc_attr( $c )
			);
			
			$title = get_theme_mod( 'skin_specials_social_title', esc_html__( 'Connect', 'skin' ) );
			$desc = get_theme_mod( 'skin_specials_social_desc', esc_html__( 'Follow me', 'skin' ) );
		?>	
			<div class="masonry-item-wrapper">
				<div class="masonry-item">
					<div class="masonry-content"><?php
						$instance = array(
							'title'			=> $title,
							'description'	=> $desc
						);
						
						the_widget( 'skin_social_profiles', $instance, $widget_args );
					?></div>
				</div>
			</div>
		<?php
		}
	endif;
	
//	15.5 Popular/Latest posts
	if ( ! function_exists( 'skin_specials_render_topposts' ) ) :
		function skin_specials_render_topposts() {
			$c = 'widget skin-widget-top-posts  content-pad';			
			$bgr = get_theme_mod( 'skin_specials_topposts_bgr', 'content-pad' );
			
			if ( 'gradient-bgr' === $bgr ) {
				$c = 'widget skin-widget-top-posts gradient-bgr txt-on-gradient';
			}
			
			if ( 'no-bgr' === $bgr ) {
				$c = 'widget skin-widget-top-posts';
			}
			
			$widget_args = sprintf(
				'before_widget=<div class="%s">&before_title=<h5 class="widget-title">&after_title=</h5>',
				esc_attr( $c )
			);
			
			$qty 			= get_theme_mod( 'skin_specials_topposts_qty', 4 );
			$skip_cat 		= get_theme_mod( 'skin_specials_topposts_skip_cat', '' );
			$skip_author	= get_theme_mod( 'skin_specials_topposts_skip_author', '' );
			$show_p 		= true === get_theme_mod( 'skin_specials_topposts_popular', true ) ? 1 : 0;
			$p_title 		= get_theme_mod( 'skin_specials_topposts_popular_title', esc_html__( 'Popular posts', 'skin' ) );
			$p_views 		= true === get_theme_mod( 'skin_specials_topposts_views', true ) ? 1 : 0;									
			$show_l 		= true === get_theme_mod( 'skin_specials_topposts_latest', true ) ? 1 : 0;
			$l_title 		= get_theme_mod( 'skin_specials_topposts_latest_title', esc_html__( 'Latest posts', 'skin' ) );
			$l_dates 		= true === get_theme_mod( 'skin_specials_topposts_dates', true ) ? 1 : 0;
			$autoplay 		= ( true === get_theme_mod( 'skin_specials_topposts_auto', false ) && 1 === $show_p && 1 === $show_l ) ? 1 : '';
		?>	
			<div class="masonry-item-wrapper">
				<div class="masonry-item">
					<div class="masonry-content"><?php
						$instance = array(
							'qty'				=> $qty,
							'skip_cat'			=> $skip_cat,
							'skip_author'		=> $skip_author,
							'autoplay'			=> $autoplay,
							'show_popular'		=> $show_p,
							'popular_title'		=> $p_title,
							'show_views'		=> $p_views,
							'show_latest'		=> $show_l,
							'latest_title'		=> $l_title,
							'show_date'			=> $l_dates
						);
						
						the_widget( 'skin_top_posts', $instance, $widget_args );
					?></div>
				</div>
			</div>
		<?php
		}
	endif;

//	15.6 Special widgets
	if ( ! function_exists( 'skin_render_special_widgets' ) ) :
		function skin_render_special_widgets( $item_order, $sidebar_id = 'sidebar-specials' ) {
			global $wp_registered_sidebars;
			global	$wp_registered_widgets;

			$output = array();
			$sidebars_widgets = wp_get_sidebars_widgets();
			
			if( ! isset( $sidebars_widgets[$sidebar_id] ) ) {
				return $output;
			}

			$widget_ids = $sidebars_widgets[$sidebar_id];

			if( ! $widget_ids ) {
				return array();
			}

			foreach( $widget_ids as $widget_id ) {
				if( ! isset( $wp_registered_widgets[$widget_id] ) || ! isset( $wp_registered_widgets[$widget_id]['params'][0] ) ) {
					continue;
				}
				
				$option_name = $wp_registered_widgets[$widget_id]['callback'][0]->option_name;
				
				$widget_data = get_option( $option_name );
				
				$key = $wp_registered_widgets[$widget_id]['params'][0]['number'];

				$params = array();
				$params[] = $widget_data[$key];

				$start = $params[0]['start'];
				$repeat = $params[0]['repeat'];

				if ( skin_specials_item_order( true, $start, $repeat, $item_order ) ) {
			?>
				<div class="masonry-item-wrapper">
				<div class="masonry-item">
				<div class="masonry-content"><?php
					skin_show_widget_by_sidebar( $sidebar_id, $widget_id );
				?></div>
				</div>
				</div>
			<?php
				}
			}
		}
	endif;
	
/* Output single widget, by its sidebar ID */
	if ( ! function_exists( 'skin_show_widget_by_sidebar' ) ) :
		function skin_show_widget_by_sidebar( $sidebar_id, $widget_id ) {
			global $wp_registered_widgets;
			global $wp_registered_sidebars;
			
			$rendered = false;

			if( ! isset( $wp_registered_widgets[$widget_id] ) || ! isset( $wp_registered_widgets[$widget_id]['params'][0] ) ) {
				return false;
			}

			$sidebars_widgets = wp_get_sidebars_widgets();
			
			if ( empty( $wp_registered_sidebars[ $sidebar_id ] ) || empty( $sidebars_widgets[ $sidebar_id ] ) || ! is_array( $sidebars_widgets[ $sidebar_id ] ) ) {
				return false;
			}

			$sidebar = $wp_registered_sidebars[$sidebar_id];
			
			$params = array_merge(
				array( array_merge( $sidebar, array('widget_id' => $widget_id, 'widget_name' => $wp_registered_widgets[$widget_id]['name']) ) ),
				(array) $wp_registered_widgets[$widget_id]['params']
			);

			$classname_ = '';
			
			foreach ( (array) $wp_registered_widgets[$widget_id]['classname'] as $class_name ) {
				if ( is_string( $class_name ) ) {
					$classname_ .= '_' . $class_name;
					
				} elseif ( is_object( $class_name ) ) {
					$classname_ .= '_' . get_class( $class_name );
				}
			}
			
			$classname_ = ltrim( $classname_, '_' );
			
			$params[0]['before_widget'] = sprintf( $params[0]['before_widget'], $widget_id, $classname_ );         
			$params = apply_filters( 'dynamic_sidebar_params', $params );

			$callback = $wp_registered_widgets[$widget_id]['callback'];
			
			if ( is_callable( $callback ) ) {
				call_user_func_array( $callback, $params );
				$rendered = true;
			}

			return $rendered;
		}
	endif;
?>