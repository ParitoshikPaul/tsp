<?php 
/* ================================================
	SKIN POPULAR/LATEST POSTS
	Skin - Premium WordPress Theme, by NordWood
=================================================== */
	add_action( 'widgets_init', 'skin_top_posts_init' );

	if ( ! function_exists( 'skin_top_posts_init' ) ) :
		function skin_top_posts_init() {
			register_widget( 'skin_top_posts' );
		}
	endif;

	class Skin_Top_Posts extends WP_Widget {
		public function __construct() {
			$widget_ops = array(
				'classname' => 'skin-widget-top-posts loading-holder promised',
				'description' => esc_html__( 'Show the latest and/or the most visited posts', 'skin' )
			);

			parent::__construct( 'skin_top_posts', esc_html__( 'Skin Popular/Latest Posts', 'skin' ), $widget_ops );
		}

/*	Widget frontend
====================== */
		function widget( $args, $instance ) {
			extract( $args );
			
			$qty			= isset( $instance['qty'] ) ? $instance['qty'] : 4;
			$skip_cat		= isset( $instance['skip_cat'] ) ? $instance['skip_cat'] : '';
			$skip_author	= isset( $instance['skip_author'] ) ? $instance['skip_author'] : '';
			$auto			= isset( $instance['autoplay'] ) && 1 == $instance['autoplay'] ? 'autoplay' : '';
			$show_p			= isset( $instance['show_popular'] ) && 1 == $instance['show_popular'] ? 1 : 0;
			$show_l			= isset( $instance['show_latest'] ) && 1 == $instance['show_latest'] ? 1 : 0;
			
			if ( 1 !== $show_p && 1 !== $show_l ) {
				return '';
				
			} else {
				echo wp_kses(
					$before_widget,
					array(
						'section' => array(
							'id' => array(),
							'class' => array()
						),
						'div' => array(
							'id' => array(),
							'class' => array()
						)
					)
				);
				
				if ( false !== strpos( $before_widget, 'loading-holder' ) ) {
					echo skin_loading_content();
				}
				
				$p_title	= isset( $instance['popular_title'] ) ? $instance['popular_title'] : esc_html__( 'Popular posts', 'skin' );
				$show_views	= isset( $instance['show_views'] ) && 1 == $instance['show_views'] ? 1 : 0;
				$l_title	= isset( $instance['latest_title'] ) ? $instance['latest_title'] : esc_html__( 'Latest posts', 'skin' );
				$show_date	= isset( $instance['show_date'] ) && 1 == $instance['show_date'] ? 1 : 0;
			?>
				<div class="tabs worker clearfix">
				<?php
				if ( 1 === $show_p ) :
				?>
					<div class="popular active tab"><h3><?php echo esc_html( $p_title ); ?></h3></div>
				<?php
				endif;
				
				if ( 1 === $show_l ) :
				?>
					<div class="latest tab"><h3><?php echo esc_html( $l_title ); ?></h3></div>
				<?php
				endif;
				?>
				</div>
			
				<div class="top-posts-slides worker clearfix" data-auto="<?php echo esc_attr( $auto ); ?>">
				<?php
				if ( 1 === $show_p ) :
				?>
					<div class="popular top-posts-slide">
				<?php
					global $post;
					$backup = $post;
					
					$p_args = array(
						'posts_per_page' => $qty,
						'post_status' => 'publish',
						'post_type' => 'post',
						'orderby' => 'meta_value_num',
						'meta_key' => 'skin_post_views_count',
						'order' => 'DESC',
						'ignore_sticky_posts' => 1,
						'category__not_in' => $skip_cat,
						'author__not_in' => $skip_author
					);
						
					$p_query = new WP_Query( $p_args );
					
					if ( $p_query->have_posts() ) :
						$p = 0;
					?>
						<table>
						<?php
						while ( $p_query->have_posts() ) :
							$p_query->the_post();
							$p++;
						?>
							<tr class="hover-trigger">
								<td>
									<span class="order"><span class="txt"><?php echo esc_html( number_format_i18n( $p ) ); ?></span><span class="line txt-color-to-bgr"></span></span>
								<?php
									$thumb_url = '';
									
									if ( skin_get_meta( 'skin_post_tiny_gif' ) ) {
										$thumb_id = skin_get_meta( 'skin_post_tiny_gif' );
										$thumb_url = skin_get_giffy_attachment_url( $thumb_id, 'skin_small' );
										
									} else if ( skin_get_meta( 'skin_post_img_in_list' ) ) {
										$thumb_id = skin_get_meta( 'skin_post_img_in_list' );
										$thumb_url = wp_get_attachment_image_src( $thumb_id, 'skin_small' );
										$thumb_url = $thumb_url[0];
										
									} else if ( has_post_thumbnail( get_the_ID() ) ) {
										$thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'skin_small' );
										
									} else if ( 'gallery' === get_post_format( get_the_ID() ) && function_exists( 'skin_featured_area_get_meta' ) ) {
										$featured_gallery = skin_featured_area_get_meta( 'skin_featured_gallery' );
										$get_gallery_imgs = explode( ', ', $featured_gallery );
										
										if ( [""] === $get_gallery_imgs ) {
											$get_gallery_imgs = [];
										}
										
										if ( is_array( $get_gallery_imgs ) && !empty( $get_gallery_imgs ) ) {
											$thumb_id = $get_gallery_imgs[0];
											$thumb_url = wp_get_attachment_image_src( $thumb_id, 'skin_small' );
											$thumb_url = $thumb_url[0];	
										}										
									}
									
									if ( '' === $thumb_url && $img_placeholder = get_theme_mod( 'skin_img_placeholder' ) ) {
										$thumb_url = $img_placeholder;
									}
									
									$c_link = get_post_meta( get_the_ID(), 'skin_custom_post_link', true );
									$c_target = get_post_meta( get_the_ID(), 'skin_custom_post_link_target', true );	
									$p_link = $c_link ? $c_link : get_permalink( get_the_ID() );
									$p_target = ( 'new-tab' === $c_target ) ? '_blank' : '_self';
									
									if ( '' != $thumb_url ) {
								?>
									<a href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"
										class="thumb round bgr-cover shrinking-img"
										style="background-image:url('<?php echo esc_url( $thumb_url ); ?>');"
									><div class="shrinker"></div></a>								
								<?php
									} else {
								?>
									<a href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"
										class="thumb round shrinking-img gradient-bgr-vert"
									><div class="shrinker"></div></a>								
								<?php
									}
								?>
								</td>
								
								<td>
									<h5>
										<a class="post-title masked-content" href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>">
											<div class="txt cut-by-lines" data-lines-limit="3"><?php echo esc_html( get_the_title( get_the_ID() ) ); ?></div>
											<div class="mask to-left"><div class="mask-txt masked-txt cut-by-lines" data-lines-limit="3"><?php echo esc_html( get_the_title( get_the_ID() ) ); ?></div></div>
										</a>
									</h5>
								<?php
									if ( 1 === $show_views ) {
								?>
									<div class="post-details"><?php
										$views = skin_get_post_views();
										
										printf(
											'%1$s %2$s',
											esc_html( _n( 'view', 'views', $views, 'skin' ) ),
											esc_html( number_format_i18n( $views ) )
										);
									?></div>
								<?php
									}
								?>
								</td>
							</tr>
						<?php
						endwhile;
						
						wp_reset_postdata();
						$post = $backup;
						?>
						</table>
					<?php
					endif;
				?>
					</div>
				<?php
				endif;
				?>
					
				<?php
				if ( 1 === $show_l ) :
				?>
					<div class="latest top-posts-slide">
				<?php
					$l_args = array(
						'numberposts' => $qty,
						'orderby' => 'date',
						'post_status' => 'publish',
						'post_type' => 'post',
						'order' => 'DESC',
						'ignore_sticky_posts' => 1,
						'category__not_in' => $skip_cat,
						'author__not_in' => $skip_author
					);
					
					$l_posts = wp_get_recent_posts( $l_args );
					
					if ( $l_posts ) :
						$l = 0;
					?>
						<table>
						<?php
							foreach( $l_posts as $latest ) :
								$post_id = $latest["ID"];
								$l++;
						?>
							<tr class="hover-trigger">
								<td>
									<span class="order"><span class="txt"><?php echo esc_html( number_format_i18n( $l ) ); ?></span><span class="line txt-color-to-bgr"></span></span>
								<?php
									$thumb_url = '';									
									
									if ( get_post_meta( $post_id, 'skin_post_tiny_gif', true ) ) {
										$thumb_id = get_post_meta( $post_id, 'skin_post_tiny_gif', true );
										$thumb_url = skin_get_giffy_attachment_url( $thumb_id, 'skin_small' );
										
									} else if ( get_post_meta( $post_id, 'skin_post_img_in_list', true ) ) {
										$thumb_id = get_post_meta( $post_id, 'skin_post_img_in_list', true );
										$thumb_url = wp_get_attachment_image_src( $thumb_id, 'skin_small' );
										$thumb_url = $thumb_url[0];
										
									} else if ( has_post_thumbnail( $post_id ) ) {
										$thumb_url = get_the_post_thumbnail_url( $post_id, 'skin_small' );
										
									} else if ( 'gallery' === get_post_format( $post_id ) && function_exists( 'skin_featured_area_get_meta' ) ) {
										$featured_gallery = skin_featured_area_get_meta( 'skin_featured_gallery' );
										$get_gallery_imgs = explode( ', ', $featured_gallery );
										
										if ( [""] === $get_gallery_imgs ) {
											$get_gallery_imgs = [];
										}
										
										if ( is_array( $get_gallery_imgs ) && !empty( $get_gallery_imgs ) ) {
											$thumb_id = $get_gallery_imgs[0];
											$thumb_url = wp_get_attachment_image_src( $thumb_id, 'skin_small' );
											$thumb_url = $thumb_url[0];
										}										
									}
									
									if ( '' === $thumb_url && $img_placeholder = get_theme_mod( 'skin_img_placeholder' ) ) {
										$thumb_url = $img_placeholder;
									}
									
									$c_link = get_post_meta( $post_id, 'skin_custom_post_link', true );
									$c_target = get_post_meta( $post_id, 'skin_custom_post_link_target', true );	
									$p_link = $c_link ? $c_link : get_permalink( $post_id );
									$p_target = ( 'new-tab' === $c_target ) ? '_blank' : '_self';
									
									if ( '' != $thumb_url ) {
								?>
									<a href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"
										class="thumb round bgr-cover shrinking-img"
										style="background-image:url('<?php echo esc_url( $thumb_url ); ?>');"
									><div class="shrinker"></div></a>								
								<?php
									} else {
								?>
									<a href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>"
										class="thumb round shrinking-img gradient-bgr-vert txt-on-gradient"
									><div class="shrinker"></div></a>								
								<?php
									}
								?>
								</td>
								
								<td>
									<h5>
										<a class="post-title masked-content" href="<?php echo esc_url( $p_link ); ?>" target="<?php echo esc_attr( $p_target ); ?>">
											<div class="txt cut-by-lines" data-lines-limit="3"><?php echo esc_html( $latest["post_title"] ); ?></div>
											<div class="mask to-left"><div class="mask-txt masked-txt cut-by-lines" data-lines-limit="3"><?php echo esc_html( $latest["post_title"] ); ?></div></div>
										</a>
									</h5>
									
									<div class="post-details"><?php
									// Post date
										if ( 1 === $show_date ) {
											echo skin_post_date( $post_id );
										}
									?></div>
								</td>
							</tr>
						<?php 
							endforeach;
						?>
						</table>
						<?php
					endif;
					?>
					</div>
				<?php
				endif;
				?>
				</div>
			<?php			
				echo wp_kses(
					$after_widget,
					array(
						'section' => array(),
						'div' => array()
					)
				);
			}		
		}

/*	Widget backend
===================== */
		public function form( $instance ) {
			$defaults = array(
				'qty'				=> 4,
				'skip_cat'			=> '',
				'skip_author'		=> '',
				'autoplay'			=> 0,
				'show_popular'		=> 1,
				'popular_title'		=> esc_attr__( 'Popular posts', 'skin' ),
				'show_views'		=> 1,
				'show_latest'		=> 1,
				'latest_title'		=> esc_attr__( 'Latest posts', 'skin' ),
				'show_date'			=> 1
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults );
			?>
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'qty' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'skin' ); ?></label>			
				<input type="number" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'qty' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'qty' ) ); ?>"
					value="<?php echo absint( $instance['qty'] ); ?>"
					placeholder="4"
				>
			</p>
						
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'skip_cat' ) ); ?>"><?php esc_html_e( 'Exclude category:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'skip_cat' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'skip_cat' ) ); ?>"
					value="<?php echo esc_attr( $instance['skip_cat'] ); ?>"
				>
			</p>
						
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'skip_author' ) ); ?>"><?php esc_html_e( 'Exclude author:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'skip_author' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'skip_author' ) ); ?>"
					value="<?php echo esc_attr( $instance['skip_author'] ); ?>"
				>
			</p>
			
			<p>
				<input type="checkbox"
					name="<?php echo esc_attr( $this->get_field_name( 'autoplay' ) ); ?>" 
					id="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>"
					value="1" <?php checked( esc_attr( $instance['autoplay'] ), 1 ); ?>
				>
				<label for="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>"><?php esc_html_e( 'Allow autoplay', 'skin' ); ?></label>
			</p>
			
			<h4><?php esc_html_e( 'Popular Posts', 'skin' ); ?></h4>
			
			<p>
				<input type="checkbox"
					name="<?php echo esc_attr( $this->get_field_name( 'show_popular' ) ); ?>" 
					id="<?php echo esc_attr( $this->get_field_id( 'show_popular' ) ); ?>"
					value="1" <?php checked( esc_attr( $instance['show_popular'] ), 1 ); ?>
				>
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_popular' ) ); ?>"><?php esc_html_e( 'Show the most visited posts', 'skin' ); ?></label>
			</p>
			
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'popular_title' ) ); ?>"><?php esc_html_e( 'Title for the most visited posts:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'popular_title' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'popular_title' ) ); ?>"
					value="<?php echo esc_attr( $instance['popular_title'] ); ?>"
					placeholder="<?php esc_attr_e( 'Popular posts', 'skin' ); ?>"
				>
			</p>
			
			<p>
				<input type="checkbox"
					name="<?php echo esc_attr( $this->get_field_name( 'show_views' ) ); ?>" 
					id="<?php echo esc_attr( $this->get_field_id( 'show_views' ) ); ?>"
					value="1" <?php checked( esc_attr( $instance['show_views'] ), 1 ); ?>
				>
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_views' ) ); ?>"><?php esc_html_e( 'Show views count', 'skin' ); ?></label>
			</p>
			
			<h4><?php esc_html_e( 'Latest Posts', 'skin' ); ?></h4>
			
			<p>
				<input type="checkbox"
					name="<?php echo esc_attr( $this->get_field_name( 'show_latest' ) ); ?>" 
					id="<?php echo esc_attr( $this->get_field_id( 'show_latest' ) ); ?>"
					value="1" <?php checked( esc_attr( $instance['show_latest'] ), 1 ); ?>
				>
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_latest' ) ); ?>"><?php esc_html_e( 'Show the latest posts', 'skin' ); ?></label>
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_name( 'latest_title' ) ); ?>"><?php esc_html_e( 'Title for the latest posts:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'latest_title' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'latest_title' ) ); ?>"
					value="<?php echo esc_attr( $instance['latest_title'] ); ?>"
					placeholder="<?php esc_attr_e( 'Latest posts', 'skin' ); ?>"
				>
			</p>
			
			<p>
				<input type="checkbox"
					name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" 
					id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"
					value="1" <?php checked( esc_attr( $instance['show_date'] ), 1 ); ?>
				>
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Show post date', 'skin' ); ?></label>
			</p>
		<?php
		}

/*	Widget update
==================== */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance['qty']			= absint( $new_instance['qty'] );
			$instance['skip_cat']		= sanitize_text_field( $new_instance['skip_cat'] );
			$instance['skip_author']	= sanitize_text_field( $new_instance['skip_author'] );			
			$instance['autoplay']		= isset( $new_instance['autoplay'] ) ? esc_attr( $new_instance['autoplay'] ) : 0;
			$instance['show_popular']	= isset( $new_instance['show_popular'] ) ? esc_attr( $new_instance['show_popular'] ) : 0;
			$instance['popular_title']	= sanitize_text_field( $new_instance['popular_title'] );
			$instance['show_views']		= isset( $new_instance['show_views'] ) ? esc_attr( $new_instance['show_views'] ) : 0;
			$instance['show_latest']	= isset( $new_instance['show_latest'] ) ? esc_attr( $new_instance['show_latest'] ) : 0;
			$instance['latest_title']	= sanitize_text_field( $new_instance['latest_title'] );
			$instance['show_date']		= isset( $new_instance['show_date'] ) ? esc_attr( $new_instance['show_date'] ) : 0;
			
			return $instance;
		}	
	}
?>