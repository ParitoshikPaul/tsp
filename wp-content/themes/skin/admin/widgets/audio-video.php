<?php 
/* ================================================
	SKIN AUDIO/VIDEO WIDGET
	Skin - Premium WordPress Theme, by NordWood
=================================================== */
	add_action( 'widgets_init', 'skin_audio_video_init' );
	
	//if ( ! function_exists( 'skin_audio_video_init' ) ) :
		function skin_audio_video_init() {
			register_widget( 'Skin_Audio_Video' );
		}
	//endif;

	class Skin_Audio_Video extends WP_Widget {
		public function __construct() {
			$widget_ops = array(
				'classname'		=> 'skin-widget-audio-video',
				'description'	=> esc_html__( 'Embed audio or video file by its URL', 'skin' )
			);

			parent::__construct( 'skin_audio_video', esc_html__( 'Skin Audio/Video', 'skin' ), $widget_ops );
		}

/*	Widget frontend
====================== */
		function widget( $args, $instance ) {			
			extract( $args );			
			
			$url = $instance['media_url'];
			
			if ( '' != $url ) {
				echo wp_kses(
					$before_widget,
					array(
						'section' => array(
							'id' => array(),
							'class' => array()
						)
					)
				);
				
				$title = apply_filters( 'widget_title', $instance['title'] );
				
				if ( '' != $title ) {
					echo wp_kses(
						$before_title,
						array(
							'h3' => array(
								'class' => array()
							)
						)
					);
					
					echo esc_html( $title );
					
					echo wp_kses(
						$after_title,
						array(
							'h3' => array()
						)
					);
				}
				
				echo skin_loading_content();
				
				global $wp_embed;				
				?>
				
				<div class="media"><?php
					echo wp_oembed_get( esc_url( $url ) );
				?></div>
				
				<?php			
				echo wp_kses(
					$after_widget,
					array(
						'section' => array()
					)
				);
			}
		}

/*	Widget backend
====================== */
		public function form( $instance ) {
			$defaults = array(
				'title'		=> '',
				'media_url'	=> ''
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults );
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					value="<?php echo esc_attr( $instance['title'] ); ?>"
					placeholder="<?php esc_attr_e( 'My Music/Video', 'skin' ); ?>"
				>
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_name( 'media_url' ) ); ?>"><?php esc_html_e( 'Audio/Video URL:', 'skin' ); ?></label>			
				<input type="url" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'media_url' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'media_url' ) ); ?>"
					value="<?php echo esc_url_raw( $instance['media_url'] ); ?>"
				>
			</p>
		<?php
		}

/*	Widget update
===================== */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance['title']		= sanitize_text_field( $new_instance['title'] );
			$instance['media_url']	= esc_url_raw( $new_instance['media_url'] );
			
			return $instance;
		}	
	}
?>