<?php 
/* ===============================================
	SKIN INSTAGRAM GRID
	Skin - Premium WordPress Theme, by NordWood
================================================== */
	add_action( 'widgets_init', 'skin_instagram_grid_init' );
	
	if ( ! function_exists( 'skin_instagram_grid_init' ) ) :
		function skin_instagram_grid_init() {
			register_widget( 'skin_instagram_grid' );
		}
	endif;

	class Skin_Instagram_Grid extends WP_Widget {
		public function __construct() {
			$widget_ops = array(
				'classname' => 'skin-widget-instagram-grid skin-widget-instagram loading-holder promised',
				'description' => esc_html__( 'Instagram feed in grid layout', 'skin' )
			);

			parent::__construct( 'skin_instagram_grid', esc_html__( 'Skin Instagram Grid', 'skin' ), $widget_ops );
		}

/*	Widget frontend
====================== */
		function widget( $args, $instance ) {			
			extract( $args );
			
			$username = isset( $instance['username'] ) ? $instance['username'] : 'nordwood';			
			$profile = wp_remote_get( esc_url_raw( 'http://instagram.com/'.$username ) );			
			$qty = isset( $instance['qty'] ) ? $instance['qty'] : 9;			
			$qty_in_range = ( 2 < $qty ) && ( 13 > $qty );			
			
			if ( is_wp_error( $profile ) || empty( $instance['username'] ) || !$qty_in_range ) {
				return '';
				
			} else if ( 200 === wp_remote_retrieve_response_code( $profile ) ) {
				$get_body = wp_remote_retrieve_body( $profile );
				
				if ( is_array( $profile ) && !empty( $get_body ) ) {
					$body		= explode( 'window._sharedData = ', $profile['body'] );
					$body_json 	= explode( ';</script>', $body[1] );
					$profile 	= json_decode( $body_json[0], TRUE );
					
					$classes = array();
				
					if ( '' != $instance['title'] ) {
						$classes[] = 'has-title';
					}
					
					$before_widget = str_replace(
						'class="',
						'class="' . join( ' ', $classes ) . ' ',
						$before_widget
					);
					
					echo wp_kses(
						$before_widget,
						array(
							'section' => array(
								'id' => array(),
								'class' => array()
							)
						)
					);
				
					if ( '' != $instance['title'] ) {
						$title = apply_filters( 'widget_title', $instance['title'] );
					?>							
						<h5 class="widget-title txt-color-to-svg">
							<a href="<?php echo esc_url( 'http://instagram.com/'.$username ); ?>" target="_blank">
								<span><?php echo skin_get_icon_instagram() . esc_html( $title ); ?></span>
								<span><?php esc_html_e( 'Follow me @ ', 'skin' ); echo esc_html( $username ); ?></span>
							</a>
						</h5>
					<?php
					}
					
					echo skin_loading_content();
						
					$items = $profile['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
					$count = $profile['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['count'];
					
					if ( $count < $qty ) {
						$qty = $count;
					}
					
					if ( $qty > 0 ) {
						$show_counts = isset( $instance['show_counts'] ) && 1 == $instance['show_counts'] ? 1 : 0;
					?>
					<div class="items worker clearfix"><?php
					if ( 1 === $show_counts ) {
						for ( $i = 0; $i < $qty; $i++ ) {
							$item = $items[$i]['node'];
						?>
							<a class="item square bgr-cover" style="background-image: url('<?php echo esc_url( $item['thumbnail_src'] ); ?>');"
								href="<?php echo esc_url('http://instagram.com/p/'.$item['shortcode']); ?>"
								target="_blank"
							>
								<div class="overlay va-middle">
									<div class="stats">
										<span><?php echo skin_get_icon_heart(); ?></span>
										<span><?php echo esc_html( number_format_i18n( $item['edge_liked_by']['count'] ) ); ?></span>
									</div>
									
									<div class="stats">
										<span><?php echo skin_get_icon_comment_filled(); ?></span>
										<span><?php echo esc_html( number_format_i18n( $item['edge_media_to_comment']['count'] ) ); ?></span>
									</div>
								</div>
							</a>
						<?php
						}
						
					} else {
						for ( $i = 0; $i < $qty; $i++ ) {
							$item = $items[$i];						
						?>
							<a class="item square bgr-cover" style="background-image: url('<?php echo esc_url( $item['thumbnail_src'] ); ?>');"
								href="<?php echo esc_url('http://instagram.com/p/'.$item['shortcode']); ?>" target="_blank"
							></a>
						<?php
						}
					}
					?></div>
					<?php
					}
				
					echo wp_kses(
						$after_widget,
						array(
							'section' => array()
						)
					);
					
				} else {
					return '';
				}
				
			} else {
				return '';
			}
		}

/*	Widget backend
===================== */
		public function form( $instance ) {
			$defaults = array(
				'title'			=> '',
				'username'		=> '',
				'qty'			=> 9,
				'show_counts'	=> 1
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults );			
			
			$username = isset( $instance['username'] ) ? $instance['username'] : 'nordwood';			
			$profile = wp_remote_get( esc_url_raw( 'http://instagram.com/'.$username ) );			
			$qty = $instance['qty'];
			
			if ( is_wp_error( $profile ) ) {
				$error_message = $profile->get_error_message();
			?>
				<p style="color: #f00;"><?php esc_html_e( 'Oops! Something went wrong with connection to Instagram.', 'skin' ); ?></p>
				<p style="color: #f00;"><?php echo esc_html( $error_message ); ?></p>
			<?php
			}			
			
			$get_body = wp_remote_retrieve_body( $profile );
			
			if ( 200 !== wp_remote_retrieve_response_code( $profile ) ) {
			?>
				<p style="color: #f00;"><?php esc_html_e( 'No such profile found.', 'skin' ); ?></p>
			<?php			
			} else if ( is_array( $profile ) && !empty( $get_body ) ) {
				$body		= explode( 'window._sharedData = ', wp_remote_retrieve_body( $profile ) );
				$body_json 	= explode( ';</script>', $body[1] );
				$profile 	= json_decode( $body_json[0], TRUE );
				
				if ( array_key_exists( "ProfilePage", $profile['entry_data'] ) ) {
					if ( $profile['entry_data']['ProfilePage'][0]['graphql']['user']['is_private'] ) {
					?>
						<p style="color: #f00;"><?php esc_html_e( 'Your profile needs to be set as \'public\', for the images to appear in the widget.', 'skin' ); ?></p>
					<?php
					}
				}
			}
			
			if ( ( 3 > $qty ) || ( 12 < $qty ) ) {
			?>
				<p style="color: #f00;"><?php esc_html_e( 'Number of items should be in between 3 and 12.', 'skin' ); ?></p>
			<?php
			}
			?>
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					value="<?php echo esc_attr( $instance['title'] ); ?>"
					placeholder="<?php esc_attr_e( 'My Instagram feed', 'skin' ); ?>"
				>
			</p>
			
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>"><?php esc_html_e( 'Instagram username:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"
					value="<?php echo esc_attr( $instance['username'] ); ?>"
					placeholder="<?php esc_attr_e( 'nordwood', 'skin' ); ?>"
				>
			</p>
			
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'qty' ) ); ?>"><?php esc_html_e( 'Number of items to show:', 'skin' ); ?></label>			
				<input type="number" class="widefat" min="3" max="12"
					name="<?php echo esc_attr( $this->get_field_name( 'qty' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'qty' ) ); ?>"
					value="<?php echo absint( $instance['qty'] ); ?>"
					placeholder="9"
				>
			</p>
			
			<p>
				<input type="checkbox"
					name="<?php echo esc_attr( $this->get_field_name( 'show_counts' ) ); ?>" 
					id="<?php echo esc_attr( $this->get_field_id( 'show_counts' ) ); ?>"
					value="1" <?php checked( esc_attr( $instance['show_counts'] ), 1 ); ?>
				>
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_counts' ) ); ?>"><?php esc_html_e( 'Show likes & comments count', 'skin' ); ?></label>
			</p>
		<?php
		}

/*	Widget update
==================== */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance['title']			= sanitize_text_field( $new_instance['title'] );
			$instance['username']		= sanitize_text_field( $new_instance['username'] );
			$instance['qty']			= absint( $new_instance['qty'] );
			$instance['show_counts']	= isset( $new_instance['show_counts'] ) ? esc_attr( $new_instance['show_counts'] ) : 0;
			
			return $instance;
		}	
	}
?>