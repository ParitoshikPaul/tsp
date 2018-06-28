<?php
/* ================================================
	WOOCOMMERCE FUNCTIONS
	Skin - Premium WordPress Theme, by NordWood
=================================================== */
/*	TABLE OF CONTENTS
======================= */

/*
	GLOBAL
	Adjust the styles when admin bar is active
	Get the layout type for products list
	Custom body classes
	Classes for the "#main" wrapper
	Classes for the products list wrapper
	Product classes
	Hide breadcrumbs
	Modify breadcrumbs
	Display product categories
	Customize placeholder image
	
	LOOP
	Featured area
	Products slider
	Control the page title appearance
	Archive header display
	Modify archive description
	Display archive (sub)categories
	Display archive (sub)category title
	Remove link wrapper from the product in loop
	Hooks before product header in loop
	Display product image in loop
	Display product categories in the loop
	Modify product title in the loop
	Adjust the rating template in loop
	Hooks after product in loop
	
	SINGLE PRODUCT
	Adjust the product heading on single product page
	Tabs on single product
	Hooks after single product
	Limit related products list to 3 items
	Limit upsell products list to 3 items
	
	CART
	Update mini cart total
	Adjust the cart totals heading
	Cart collaterals
	
	SIDEBARS AND WIDGETS
	Control the sidebar appearance
	Products widget
	Modify tag cloud
	
	SVG ICONS
	Shopping bag
*/

/*	GLOBAL
============ */	
/*	Adjust the styles when admin bar is active */
	add_action( 'get_header', 'skin_remove_admin_bar_bump_cb' );
	
	if ( ! function_exists( 'skin_remove_admin_bar_bump_cb' ) ) :
		function skin_remove_admin_bar_bump_cb() {
			remove_action( 'wp_head', '_admin_bar_bump_cb' );
		}
	endif;
	
	add_action( 'wp_head', 'skin_adjust_admin_bar_push' );
	
	if ( ! function_exists( 'skin_adjust_admin_bar_push' ) ) :
		function skin_adjust_admin_bar_push() {
			if ( is_user_logged_in() && is_admin_bar_showing()) {
		?>
			<style type="text/css">
				html { padding-top: 32px !important; }
				* html body { padding-top: 32px !important; }
				@media screen and ( max-width: 782px ) {
					html { padding-top: 46px !important; }
					* html body { padding-top: 46px !important; }
				}
			</style>
		<?php
			}
		}
	endif;
	
/* Get the layout type for products list */
	if ( ! function_exists( 'skin_woo_get_layout_type' ) ) :
		function skin_woo_get_layout_type() {
			$l = 'masonry-3';
			
			if ( is_shop() || is_product_category() || is_product_tag() ) {
				$l = get_theme_mod( 'skin_woo_layout', 'masonry-2-sidebar' );
			}
			
			return $l;
		}
	endif;
	
/* Custom body classes */
	add_filter( 'body_class', 'skin_woo_body_class' );
	
	if ( ! function_exists( 'skin_woo_body_class' ) ) :
		function skin_woo_body_class( $classes ) {
			if ( is_shop() || is_product_category() || is_product_tag() ) {
				$layout_width = 'wrapped';
				$layout = 'masonry-3';
			
				$layout = skin_woo_get_layout_type();
				
				if ( false !== strpos( $layout, 'full-width' ) ) {
					$layout_width = 'full-width';
				}
				
				$classes[] = sanitize_html_class( $layout_width );
			}
			
			return array_unique( $classes );
		}
	endif;
	
/* Classes for the "#main" wrapper */
	if ( ! function_exists( 'skin_woo_get_main_class' ) ) :
		function skin_woo_get_main_class( $class = '' ) {			
			$classes = array();
			
			$classes[] = 'clearfix';
			
			$s = 'no-sidebar';
			$push_items = false;
			
			if ( is_shop() || is_product_category() || is_product_tag() ) {
				$l = get_theme_mod( 'skin_woo_layout', 'masonry-2-sidebar' );				
		
				if ( false !== strpos( $l, 'sidebar' ) ) {
					$s = get_theme_mod( 'skin_woo_sidebar', 'sidebar-right' );
					$push_items = true;
				}
			}
			
			$classes[] = sanitize_html_class( $s );
			
			if ( true === $push_items ) {
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
	
	if ( ! function_exists( 'skin_woo_main_class' ) ) :
		function skin_woo_main_class( $class = '' ) {
			echo 'class="' . join( ' ', skin_woo_get_main_class( $class ) ) . '"';
		}
	endif;

/* Classes for the products list wrapper */
	if ( ! function_exists( 'skin_woo_get_products_list_class' ) ) :
		function skin_woo_get_products_list_class( $class = '' ) {
			$classes = array();
			
			$classes[] = 'clearfix';
			$classes[] = 'posts-list';
			
			$l_type = 'masonry';
			$cols = 'cols-3';
			
			$l = skin_woo_get_layout_type();
			
			if ( false !== strpos( $l, '2' ) ) {
				$cols = 'cols-2';
				
			} else if ( false !== strpos( $l, '3' ) ) {
				$cols = 'cols-3';				
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
			$classes = apply_filters( 'skin_woo_products_list_class', $classes, $class );
		 
			return array_unique( $classes );
		}
	endif;
	
	if ( ! function_exists( 'skin_woo_products_list_class' ) ) :
		function skin_woo_products_list_class( $class = '' ) {
			echo 'class="' . join( ' ', skin_woo_get_products_list_class( $class ) ) . '"';
		}
	endif;
	
/* Product classes */
	add_filter( 'post_class', 'skin_woo_product_class', 10, 3 );
	
	if ( ! function_exists( 'skin_woo_product_class' ) ) :
		function skin_woo_product_class( $classes, $class, $post_id ) {
			$post_type = get_post_type( $post_id );
			
			$classes[] = 'clearfix';
			
			if ( 'product' === $post_type ) {
				$classes[] = 'content-pad';
				
				if ( is_shop() || is_product_category() || is_product_tag() ) {
					$classes[] = 'hover-trigger';
				}
			}
			
			return array_unique( $classes );
		}
	endif;
	
/* Hide breadcrumbs */
	if ( false === get_theme_mod( 'skin_woo_breadcrumbs_on', false ) ) {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}
	
/* Modify breadcrumbs */
	add_filter( 'woocommerce_breadcrumb_defaults', 'skin_woo_breadcrumbs_args' );
	
	if ( ! function_exists( 'skin_woo_breadcrumbs_args' ) ) :
		function skin_woo_breadcrumbs_args( $defaults ) {
			$defaults['delimiter'] = '&nbsp;&#47;&nbsp;';
			$defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb content-pad small-text">';
			$defaults['wrap_after'] = '</nav>';
			$defaults['before'] = '';
			$defaults['after'] = '';
			$defaults['home'] = esc_html_x( 'Home', 'breadcrumb', 'skin' );
			
			return $defaults;
		}
	endif;
	
/* Display product categories */			
	if ( ! function_exists( 'skin_woo_product_categories' ) ) :
		function skin_woo_product_categories( $post_id = NULL ) {
			$post_id = is_null( $post_id ) ? get_the_ID() : $post_id;			
			$cats = get_the_terms( $post_id, 'product_cat' );
			
			if ( $cats ) {
				echo '<div class="categories">';
				
				usort( $cats, 'skin_sort_by_count' );
				
				foreach( $cats as $cat ) {
					$cat_slug = $cat->slug;				
					$cat_color = get_theme_mod( 'skin_woo_colors_cat_'.$cat_slug, '#f18597' );
					
					printf(
						'<a href="%1$s" style="background:%3$s"><h6>%2$s</h6></a>',
						esc_url( get_term_link( $cat->term_id, 'product_cat' ) ),
						esc_html( $cat->name ),
						esc_attr( $cat_color )
					);
				}
				
				echo '</div>';
			}
		}
	endif;
	
/* Customize placeholder image */
	add_action( 'init', 'skin_woo_replace_placeholder_img', 100 );
 
	if ( ! function_exists( 'skin_woo_replace_placeholder_img' ) ) :
		function skin_woo_replace_placeholder_img() {
			$img_src = get_theme_mod( 'skin_woo_img_placeholder' );
			
			if ( $img_src && '' !== $img_src ) {
				add_filter( 'woocommerce_placeholder_img_src', 'skin_woo_placeholder_img_src', 100 );
			}
		}
	endif;
 
	if ( ! function_exists( 'skin_woo_placeholder_img_src' ) ) :
		function skin_woo_placeholder_img_src( $img_src ) {
			$img_src = get_theme_mod( 'skin_woo_img_placeholder' );
			
			if ( $img_src && '' !== $img_src ) {
				return $img_src;
			}
		}
	endif;
	
/*	LOOP
========== */	
/*	Featured area */	
	add_action( 'skin_woo_before_wrapper', 'skin_woo_featured_area', 20 );
	
	if ( ! function_exists( 'skin_woo_featured_area' ) ) :
		function skin_woo_featured_area() {
			if ( is_shop() ) {
				$featured = get_theme_mod( 'skin_woo_shop_featured', 'skip' );
				
				$qty = 1;
				
			// Slider with featured posts
				if ( 'slider-featured' === $featured ) {
					$qty = get_theme_mod( 'skin_woo_shop_slider_count', 5 );					
					$ids_arr = array();
				
					$meta_query  = WC()->query->get_meta_query();
					$tax_query   = WC()->query->get_tax_query();
					$tax_query[] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
						'operator' => 'IN',
					);

					$args = array(
						'post_type'           => 'product',
						'post_status'         => 'publish',
						'ignore_sticky_posts' => 1,
						'posts_per_page'      => $qty,
						'orderby'             => 'modified',
						'order'               => 'DESC',
						'meta_query'          => $meta_query,
						'tax_query'           => $tax_query,
					);
					
					$loop = new WP_Query( $args );
					
					while ( $loop->have_posts() ) : $loop->the_post();
						global $product;
						
						$ids_arr[] = $product->get_id();
					endwhile;
					wp_reset_query();
					
					if ( 0 < sizeof( $ids_arr ) ) {
						$autoplay = get_theme_mod( 'skin_woo_shop_slider_auto', false );
						$auto = $autoplay ? 'auto' : '';
						$show_cat = get_theme_mod( 'skin_woo_featured_show_cat', true );
						$show_price = get_theme_mod( 'skin_woo_featured_show_price', true );
						
						skin_woo_products_slider( $ids_arr, $auto, $show_cat, $show_price );
					}
				}
			}
			
			if ( is_page() ) {			
				$auto = skin_get_meta( 'skin_slider_on_page_auto' );			
				$show_cat = "show" === skin_get_meta( 'skin_products_slider_on_page_show_cat' ) ?  true : false;
				$show_price = "show" === skin_get_meta( 'skin_products_slider_on_page_show_price' ) ?  true : false;
				
				if ( 'featured-products' === skin_get_meta( 'skin_slider_on_page_type' ) ) {
					$qty = skin_get_meta( 'skin_products_slider_on_page_qty' );					
					$ids_arr = array();
				
					$meta_query  = WC()->query->get_meta_query();
					$tax_query   = WC()->query->get_tax_query();
					$tax_query[] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
						'operator' => 'IN',
					);

					$args = array(
						'post_type'           => 'product',
						'post_status'         => 'publish',
						'ignore_sticky_posts' => 1,
						'posts_per_page'      => $qty,
						'orderby'             => 'modified',
						'order'               => 'DESC',
						'meta_query'          => $meta_query,
						'tax_query'           => $tax_query,
					);
					
					$loop = new WP_Query( $args );
					
					while ( $loop->have_posts() ) : $loop->the_post();
						global $product;
						
						$ids_arr[] = $product->get_id();
					endwhile;
					wp_reset_query();
					
					if ( 0 < sizeof( $ids_arr ) ) {						
						skin_woo_products_slider( $ids_arr, $auto, $show_cat, $show_price );
					}
				}
			}
		}
	endif;
	
//	Products slider
	if ( ! function_exists( 'skin_woo_products_slider' ) ) :
		function skin_woo_products_slider( $products_ids = array(), $auto = '', $show_cat = true, $show_price = true ) {
			$qty = count( $products_ids );
			
			if ( 1 > $qty ) {
				return '';
				
			} else {
		?>
			<div class="products-slider skin-posts-slider content-wrapper" data-autoplay="<?php echo esc_attr( $auto ); ?>">
				<div class="slider-images swiper-container">
					<div class="swiper-wrapper"><?php
					foreach ( $products_ids as $product_id ) :
						$img_url = '';
						
						if ( has_post_thumbnail( $product_id ) ) {
							$img_url = skin_get_giffy_featured_img_url( $product_id );
							
						} else {
							$img_url = wc_placeholder_img_src();
						}
					?>
						<div class="swiper-slide start va-middle"><a href="#">
							<div class="post-image round bgr-cover" style="background-image:url('<?php echo esc_url( $img_url ); ?>');"><?php
								$_product = wc_get_product( $product_id );
								
								if ( ! $_product->is_in_stock() ) :
									echo apply_filters( 'woocommerce_sale_flash', '<h5 class="out-of-stock txt-color-to-bgr content-pad-to-color">' . esc_html__( 'Out of stock', 'skin' ) . '</h5>' );
									
								elseif ( $_product->is_on_sale() ) :
									echo apply_filters( 'woocommerce_sale_flash', '<h5 class="on-sale small-item-bgr small-item-color">' . esc_html__( 'Sale!', 'skin' ) . '</h5>' );
								endif;
							?></div>
						</a></div>
					<?php
					endforeach;
					?></div>
				</div>
				
				<div class="slider-content swiper-container content-wrapper">
					<div class="swiper-wrapper"><?php
					foreach ( $products_ids as $product_id ) :
						$_product = wc_get_product( $product_id );						
						$p_link = get_permalink( $product_id );
					?>
						<div class="swiper-slide">						
							<div class="post-wrapper clearfix">
								<div class="post-title">
								<?php
									if ( true === $show_cat ) {
										skin_woo_product_categories( $product_id );
									}
								?>
									<h1>
										<a class="cut-by-lines post-link" data-lines-limit="2" href="<?php echo esc_url( $p_link ); ?>"><?php
											echo esc_html( get_the_title( $product_id ) );
										?></a>
									</h1>
								<?php
									if ( true === $show_price ) {
										printf(
											'<h5 class="price">%s</h5>',
											$_product->get_price_html()
										);
									}
								?>
								</div>
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
	
/* Control the page title appearance */
	add_filter( 'woocommerce_show_page_title' , 'skin_woo_show_page_title' );
	
	if ( ! function_exists( 'skin_woo_show_page_title' ) ) :
		function skin_woo_show_page_title() {
			if ( is_shop() ) {
				return false;
				
			} else {
				return true;
			}
		}
	endif;
	
/* Archive header display */
	add_action( 'skin_woo_archive_header', 'skin_woo_archive_title', 10 );
	
	if ( ! function_exists( 'skin_woo_archive_title' ) ) {
		function skin_woo_archive_title() {
			global $wp_query;
			$qty = $wp_query->found_posts;
			
			if ( is_product_category() ) {
				$cat = $wp_query->get_queried_object();
				$cat_id = $cat->term_id;
			?>
			<table>
				<tr>
					<td class="cat-title qty" data-cat-id="<?php echo esc_attr( $cat_id ); ?>">
						<h1><?php echo esc_html( number_format_i18n( $qty ) ); ?></h1>
						<h3><?php esc_html_e( 'Results', 'skin' ); ?></h3>
					</td>
					
					<td>
						<div class="content-pad">
							<h3>&nbsp;</h3>
							<h1 class="woocommerce-products-header__title page-title content-pad"><?php woocommerce_page_title(); ?></h1>
						</div>
					</td>
				</tr>
			</table>
			<?php } else if ( is_search() ) { ?>
			<table>
				<tr>
					<td class="content-pad">
						<h1><?php echo esc_html( number_format_i18n( $qty ) ); ?></h1>
						<h3><?php esc_html_e( 'Results', 'skin' ); ?></h3>
					</td>
					
					<td>
						<div class="content-pad"><?php get_search_form(); ?></div>
					</td>
				</tr>
			</table>
			<?php } else if ( apply_filters( 'woocommerce_show_page_title', true ) ) { ?>
			<table>
				<tr>
					<td class="content-pad qty">
						<h1><?php echo esc_html( number_format_i18n( $qty ) ); ?></h1>
						<h3><?php esc_html_e( 'Results', 'skin' ); ?></h3>
					</td>
					
					<td>
						<div class="content-pad">
							<h3>&nbsp;</h3>
							<h1 class="woocommerce-products-header__title page-title content-pad"><?php woocommerce_page_title(); ?></h1>
						</div>
					</td>
				</tr>
			</table>
		<?php } ?>
	<?php
		}
	}
	
// Modify archive description
	remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
	remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
	add_action( 'woocommerce_archive_description', 'skin_woo_taxonomy_archive_description', 10 );
	add_action( 'woocommerce_archive_description', 'skin_woo_product_archive_description', 10 );
	
	if ( ! function_exists( 'skin_woo_taxonomy_archive_description' ) ) {
		function skin_woo_taxonomy_archive_description() {
			if ( is_product_taxonomy() && 0 === absint( get_query_var( 'paged' ) ) ) {
				$description = wc_format_content( term_description() );
				
				if ( $description ) {
					echo '<div class="term-description content-pad">' . $description . '</div>';
				}
			}
		}
	}
	
	if ( ! function_exists( 'skin_woo_product_archive_description' ) ) {
		function skin_woo_product_archive_description() {
			// Don't display the description on search results page
			if ( is_search() ) {
				return;
			}

			if ( is_post_type_archive( 'product' ) && 0 === absint( get_query_var( 'paged' ) ) ) {
				$shop_page   = get_post( wc_get_page_id( 'shop' ) );
				if ( $shop_page ) {
					$description = wc_format_content( $shop_page->post_content );
					
					if ( $description ) {
						echo '<div class="page-description content-pad">' . wc_format_content( $shop_page->post_content ) . '</div>';
					}
				}
			}
		}
	}
	
/* Display archive (sub)categories */
	remove_action( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories', 10 );
	remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
	add_action( 'woocommerce_before_subcategory_title', 'skin_woo_subcategory_thumbnail', 10 );
	
	if ( !function_exists( 'skin_woo_subcategory_thumbnail' ) ) :
		function skin_woo_subcategory_thumbnail( $category ) {
		?>
			<div class="featured-media hover-trigger">
			<?php
				$img_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
				
				if ( $img_id ) {
					$img_url = skin_get_giffy_attachment_url( $img_id, 'medium_large' );
					
				} else {
					$img_url = wc_placeholder_img_src();
				}
			?>		
				<div class="featured-img bgr-cover shrinking-img circle" data-img-ratio="1" 
					style="background-image:url('<?php echo esc_url( $img_url ); ?>');"
				>
					<div class="shrinker content-pad-to-border"></div>
				</div>
			</div>
		<?php
		}
	endif;
	
/* Display archive (sub)category title */
	remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
	add_action( 'woocommerce_shop_loop_subcategory_title', 'skin_woo_loop_category_title', 10 );
	
	if ( !function_exists( 'skin_woo_loop_category_title' ) ) :
		function skin_woo_loop_category_title( $category ) {
			$cat_slug = $category->slug;
			
			$cat_color = get_theme_mod( 'skin_woo_colors_cat_'.$cat_slug, '#f18597' );
			
			printf(
				'<h6 style="background:%3$s">%2$s</h6>',
				esc_url( get_term_link( $category->term_id, 'product_cat' ) ),
				esc_html( $category->name ),
				esc_attr( $cat_color )
			);

			if ( $category->count > 0 ) {
				echo apply_filters( 'woocommerce_subcategory_count_html', ' <h3 class="count">' . $category->count . '</h3>', $category );
			}
		}
	endif;	
	
/* Remove link wrapper from the productin loop */
	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
	
/* Hooks before product header in loop */
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	
	add_action( 'skin_woo_before_shop_loop_item_header', 'woocommerce_show_product_loop_sale_flash', 10 );
	add_action( 'skin_woo_before_shop_loop_item_header', 'skin_woo_loop_product_thumbnail', 10 );
	add_action( 'skin_woo_before_shop_loop_item_header', 'skin_edit_post', 10 );
	
/* Display product image in loop */	
	if ( !function_exists( 'skin_woo_loop_product_thumbnail' ) ) :
		function skin_woo_loop_product_thumbnail() {
			$has_img = false;
		?>
			<div class="featured-media"><?php
			if ( has_post_thumbnail() ) {
				$img_id = get_post_thumbnail_id( get_the_ID() );
				$has_img = true;
			}
			
			if ( true === $has_img ) {
				$img_size = wp_get_attachment_metadata( $img_id );
				$img_ratio = 1;
			
				if ( ! is_array( $img_size ) || ! array_key_exists( "width", $img_size ) || ! array_key_exists( "height", $img_size ) ) {
					$img_url = '';
					
				} else {
					$img_w = $img_size['width'];
					$img_h = $img_size['height'];
					
					if ( 0 < $img_h ) {				
						$img_ratio = $img_w/$img_h;						
						$img_url = skin_get_giffy_attachment_url( $img_id, 'medium_large' );
						
					} else {
						$img_url = '';
					}
				}
			?>		
				<div class="featured-img bgr-cover shrinking-img natural" data-img-ratio="<?php echo esc_attr( $img_ratio ); ?>" 
					style="background-image:url('<?php echo esc_url( $img_url ); ?>');"
				>
					<div class="shrinker content-pad-to-border"></div>
					<a href="<?php echo esc_url( get_permalink() ); ?>"></a>
				</div>
			<?php
			}
			
			woocommerce_template_loop_add_to_cart();
			?></div>
		<?php
		}
	endif;
	
/* Display product categories in the loop */
	add_action( 'skin_woo_before_shop_loop_item_title', 'skin_woo_shop_loop_product_categories', 10 );
	
	if ( ! function_exists( 'skin_woo_shop_loop_product_categories' ) ) :
		function skin_woo_shop_loop_product_categories() {
			skin_woo_product_categories();
		}
	endif;
	
/* Modify product title in the loop */
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	add_action( 'woocommerce_shop_loop_item_title', 'skin_woo_loop_product_title', 10 );
	
	if ( ! function_exists( 'skin_woo_loop_product_title' ) ) :
		function skin_woo_loop_product_title() {
			printf(
				'<h3><a class="post-title masked-content" href="%1$s"><div class="txt">%2$s</div><div class="mask to-top"><div class="mask-txt masked-txt">%2$s</div></div></a></h3>',
				esc_url( get_permalink() ),
				skin_highlight_searched_terms( esc_html( get_the_title() ) )				
			);	
		}
	endif;
	
/* Adjust the rating template in loop */
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	add_action( 'woocommerce_after_shop_loop_item_title', 'skin_woo_template_loop_rating', 5 );
	
	if ( ! function_exists( 'skin_woo_template_loop_rating' ) ) :
		function skin_woo_template_loop_rating() {
		?>
			<div class="product-rating"><?php wc_get_template( 'loop/rating.php' ); ?></div>
			<div class="clearfix"></div>
		<?php
		}
	endif;
	
/* Hooks after product in loop */
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	
/*	SINGLE PRODUCT
==================== */
/* Adjust the product heading on single product page */
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	add_action( 'woocommerce_single_product_summary', 'skin_woo_template_single_title', 5 );
	
	if ( ! function_exists( 'skin_woo_template_single_title' ) ) :
		function skin_woo_template_single_title() {			
			skin_woo_product_categories();
			
			the_title( '<h1 class="post-title">', '</h1>' );
		}
	endif;
	
/* Tabs on single product */
	add_filter( 'woocommerce_product_tabs', 'skin_woo_product_tabs', 10, 1 );
	
	function skin_woo_product_tabs( $tabs = array() ) {
		global $product, $post;

		// Description tab - shows product content
		if ( $post->post_content ) {
			$tabs['description'] = array(
				'title'    => esc_html__( 'Description', 'skin' ),
				'priority' => 10,
				'callback' => 'woocommerce_product_description_tab',
			);
		}

		// Additional information tab - shows attributes
		if ( $product && ( $product->has_attributes() || apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ) ) ) {
			$tabs['additional_information'] = array(
				'title'    => esc_html__( 'Additional information', 'skin' ),
				'priority' => 20,
				'callback' => 'woocommerce_product_additional_information_tab',
			);
		}

		// Reviews tab - shows comments
		if ( comments_open() ) {
			$tabs['reviews'] = array(
				'title'    => esc_html__( 'Reviews', 'skin' ),
				'priority' => 30,
				'callback' => 'comments_template',
			);
		}

		return $tabs;
	}
	
/* Hooks after single product */
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	add_action( 'woocommerce_after_single_product', 'woocommerce_upsell_display', 15 );
	add_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products', 20 );
	
/* Limit related products list to 3 items */
	add_filter( 'woocommerce_output_related_products_args', 'skin_woo_related_products_args', 20 );
	
	if ( ! function_exists( 'skin_woo_related_products_args' ) ) :
		function skin_woo_related_products_args( $args ) {
			$args['posts_per_page'] = 3;
			return $args;
		}
	endif;

/* Limit upsell products list to 3 items */
	add_filter( 'woocommerce_upsell_display_args', 'skin_woo_upsell_display_args', 15 );
	
	if ( ! function_exists( 'skin_woo_upsell_display_args' ) ) :
		function skin_woo_upsell_display_args( $args ) {
			$args['posts_per_page'] = 3;
			return $args;
		}
	endif;
	
/*	CART
========== */
/* Update mini cart total */
	add_filter( 'woocommerce_add_to_cart_fragments', 'skin_woo_add_to_cart_fragment' );
	 
	function skin_woo_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		
		ob_start();		
	?>
		<span class="count mini-cart-mini-total"><?php echo $woocommerce->cart->cart_contents_count; ?></span>
	<?php		
		$fragments['.mini-cart-mini-total'] = ob_get_clean();
		
		return $fragments;		
	}
	
/* Adjust the cart totals heading */
	add_action( 'woocommerce_before_cart_totals', 'skin_woo_before_cart_totals', 5 );
	
	if ( ! function_exists( 'skin_woo_before_cart_totals' ) ) :
		function skin_woo_before_cart_totals() {
			printf(
				'<h3>%s</h3>',
				esc_html__( 'Cart totals', 'skin' )
			);
		}
	endif;

/* Cart collaterals */	
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
	add_action( 'woocommerce_cart_collaterals', 'skin_woo_cart_totals', 10 );
	add_action( 'skin_woo_cart_collaterals', 'skin_woo_cart_collaterals_start' );
	add_action( 'skin_woo_cart_collaterals', 'woocommerce_cross_sell_display' );
	add_action( 'skin_woo_cart_collaterals', 'skin_woo_cart_collaterals_end', 10 );
	
	if ( ! function_exists( 'skin_woo_cart_totals' ) ) :
		function skin_woo_cart_totals() {
			if ( is_checkout() ) {
				return;
			}
		?>
			<div class="cart-totals pad-shadow"><?php wc_get_template( 'cart/cart-totals.php' ); ?></div>		
		<?php
		}
	endif;
	
	if ( ! function_exists( 'skin_woo_cart_collaterals_start' ) ) :
		function skin_woo_cart_collaterals_start() {
			echo '<div class="cart-collaterals">'; 
		}
	endif;
	
	if ( ! function_exists( 'skin_woo_cart_collaterals_end' ) ) :
		function skin_woo_cart_collaterals_end() {
			echo '</div>'; 
		}
	endif;
	
/*	SIDEBARS AND WIDGETS
========================== */
/* Control the sidebar appearance */		
	add_action( 'template_redirect', 'skin_woo_sidebar', 10 );
	
	if ( ! function_exists( 'skin_woo_sidebar' ) ) :
		function skin_woo_sidebar() {
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
		}
	endif;
	
/* Products widget */
	add_filter( 'woocommerce_before_widget_product_list', 'skin_woo_before_widget_product_list', 10, 1 );
	add_filter( 'woocommerce_after_widget_product_list', 'skin_woo_after_widget_product_list', 10, 1 );
	
	if ( ! function_exists( 'skin_woo_before_widget_product_list' ) ) :
		function skin_woo_before_widget_product_list( $ul_class_product_list_widget ) {
			return '<table class="product_list_widget">'; 
		}
	endif;
	
	if ( ! function_exists( 'skin_woo_after_widget_product_list' ) ) :
		function skin_woo_after_widget_product_list() {
			return '</table>'; 
		}
	endif;
	
/* Modify tag cloud */
	add_filter( 'woocommerce_product_tag_cloud_widget_args', 'skin_woo_product_normalize_tag_cloud' );
	
	if( ! function_exists( 'skin_woo_product_normalize_tag_cloud' ) ) :
		function skin_woo_product_normalize_tag_cloud( $args ) {
			$args['largest'] 	= 15;
			$args['smallest'] 	= 15;
			$args['unit'] 		= 'px';
			$args['separator'] 	= '';
			$args['link'] 		= 'view';
			
			return $args;
		}
	endif;

/*	SVG ICONS
================ */
/* Shopping bag */
	if ( ! function_exists( 'skin_woo_get_icon_bag' ) ) :
		function skin_woo_get_icon_bag() {
			return '<svg width="265px" height="300px" viewBox="0 0 265 300" enable-background="new 0 0 265 300"><path class="svg-fill" fill="#212121" d="M260.463,246.75L247.52,87.41c-1.08-13.349-12.422-23.805-25.82-23.805h-46.168V48.105 c0-22.902-18.628-41.53-41.53-41.53c-22.903,0-41.53,18.627-41.53,41.53v15.499H46.303c-13.399,0-24.741,10.457-25.82,23.805 L7.538,246.75c-0.97,11.983,3.146,23.924,11.292,32.77c8.154,8.837,19.715,13.905,31.74,13.905h166.862 c12.025,0,23.586-5.068,31.74-13.905C257.318,270.674,261.433,258.733,260.463,246.75z M109.74,48.105 c0-13.374,10.887-24.26,24.261-24.26s24.261,10.887,24.261,24.26v15.499H109.74V48.105z M236.473,267.814 c-4.958,5.38-11.721,8.34-19.041,8.34H50.569c-7.319,0-14.082-2.96-19.041-8.34c-4.958-5.388-7.37-12.37-6.771-19.664L37.701,88.81 c0.354-4.453,4.141-7.935,8.602-7.935h46.168v20.685c0,4.772,3.862,8.635,8.635,8.635c4.773,0,8.635-3.862,8.635-8.635V80.875 h48.521v20.685c0,4.772,3.861,8.635,8.635,8.635c4.772,0,8.635-3.862,8.635-8.635V80.875h46.168c4.461,0,8.246,3.482,8.601,7.935 l12.944,159.341C243.843,255.444,241.431,262.427,236.473,267.814z"/></svg>';
		}
	endif;	
?>