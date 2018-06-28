<?php 
/* ==============================================
	SKIN AUTHOR WIDGET
	Skin - Premium WordPress Theme, by NordWood
================================================= */
	add_action( 'widgets_init', 'skin_author_init' );
	
	if ( ! function_exists( 'skin_author_init' ) ) :
		function skin_author_init() {
			register_widget( 'skin_author' );
		}
	endif;

	class Skin_Author extends WP_Widget {
		public function __construct() {
			$widget_ops = array(
				'classname' => 'skin-widget-author',
				'description' => esc_html__( 'Tell something about the site owner', 'skin' )
			);

			parent::__construct( 'skin_author', esc_html__( 'Skin Author Widget', 'skin' ), $widget_ops );

			add_action( 'admin_enqueue_scripts', array( $this, 'skin_author_widget_assets' ) );
		}

		public function skin_author_widget_assets() {
			wp_enqueue_media();
			wp_enqueue_script( 'skin_img_upload' );
		}

/*	Widget frontend
====================== */
		function widget( $args, $instance ) {
			extract( $args );
			
			echo wp_kses(
				$before_widget,
				array(
					'section' => array(
						'id' => array(),
						'class' => array()
					)
				)
			);
			
			$archive = '';
		
			if ( isset( $instance['nick'] ) && '' != $instance['nick'] ) {
				$user = get_user_by( 'login', $instance['nick'] );
				
				if ( $user ) {
					$user_id = $user->ID;				
					$archive = get_author_posts_url( $user_id );
				}
			}
			
			if ( '' != $instance['img_id'] ) {
				$img_id = $instance['img_id'];
				$img_url = skin_get_giffy_attachment_url( $img_id, 'medium_large' );
			
				if ( '' !== $archive ) {
			?>
				<div class="author-image loading-holder promised"><?php echo skin_loading_content(); ?>
					<a href="<?php echo esc_url( $archive ); ?>"><div class="circle bgr-cover worker" style="background-image:url('<?php echo esc_url( $img_url ); ?>');">
						<div class="line-left txt-color-to-bgr"></div>
						<div class="line-right txt-color-to-bgr"></div>
					</div></a>
				</div>
			<?php
					
				} else {
			?>
				<div class="author-image loading-holder promised"><?php echo skin_loading_content(); ?>
					<div class="circle bgr-cover worker" style="background-image:url('<?php echo esc_url( $img_url ); ?>');">
						<div class="line-left txt-color-to-bgr"></div>
						<div class="line-right txt-color-to-bgr"></div>
					</div>
				</div>
			<?php
				}
			}
			
			if ( '' != $instance['title'] ) {
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
			}
			
			if ( '' != $instance['text'] ) {
			?>
			<div class="text small-text"><?php echo esc_html( $instance['text'] ); ?></div>
			<?php
			}
			
			echo wp_kses(
				$after_widget,
				array(
					'section' => array()
				)
			);
		}

/*	Widget backend
===================== */
		public function form( $instance ) {
			$defaults = array(
				'img_id'	=> '',
				'title'		=> '',
				'text'		=> '',
				'nick' 		=> ''
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults );
			?>
			<div class="img-upload-wrapper clearfix">				
				<div class="img-preview"><?php
					if ( '' != $instance['img_id'] ) :
						echo wp_get_attachment_image( absint( $instance['img_id'] ), 'thumbnail' );
					endif;
				?></div>
				
				<p></p>
				
				<input type="hidden" class="img-id"
					name="<?php echo esc_attr( $this->get_field_name( 'img_id' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'img_id' ) ); ?>"						
					value="<?php echo esc_attr( $instance['img_id'] ); ?>"
				>
				<p></p>
				
				<input type="button" class="button upload-img <?php if( '' != $instance['img_id'] ) { echo 'hidden'; } ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'upload_img' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'upload_img' ) ); ?>"
					value="<?php esc_attr_e( 'Upload Image', 'skin' ); ?>"
				>
				
				<input type="button" class="button remove-img <?php if( '' === $instance['img_id'] ) { echo 'hidden'; } ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'remove_img' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'remove_img' ) ); ?>"
					value="<?php esc_attr_e( 'Remove Image', 'skin' ); ?>"
				>
				<p></p>
			</div>
		
			<p><?php esc_html_e( 'Add the author\'s nickname if you want to link the image to author\'s archive.', 'skin' ); ?></p>
			
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name('nick') ); ?>"><?php esc_html_e( 'Nickname:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name('nick') ); ?>"
					id="<?php echo esc_attr( $this->get_field_id('nick') ); ?>"
					value="<?php echo esc_attr( $instance['nick'] ); ?>"
				>
			</p>
		
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					value="<?php echo esc_attr( $instance['title'] ); ?>"
					placeholder="<?php esc_attr_e( 'About the author', 'skin' ); ?>"
				>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text:', 'skin' ); ?></label>
				<textarea class="widefat" rows="7"
					name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"
				><?php echo esc_textarea( $instance['text'] ); ?></textarea>
			</p>
		<?php
		}

/*	Widget update
=================== */
		public function update($new_instance, $old_instance) {
			$instance = $old_instance;
			
			$instance['img_id']	= sanitize_text_field( $new_instance['img_id'] );
			$instance['title']	= sanitize_text_field( $new_instance['title'] );
			$instance['text']	= sanitize_text_field( $new_instance['text'] );
			$instance['nick'] 	= sanitize_text_field( $new_instance['nick'] );
			
			return $instance;
		}	
	}
?>