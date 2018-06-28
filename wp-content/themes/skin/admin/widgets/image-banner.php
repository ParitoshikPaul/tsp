<?php 
/* ==============================================
	SKIN IMAGE BANNER
	Skin - Premium WordPress Theme, by NordWood
================================================= */
	add_action( 'widgets_init', 'skin_image_banner_init' );
	
	if ( ! function_exists( 'skin_image_banner_init' ) ) :
		function skin_image_banner_init() {
			register_widget( 'skin_image_banner' );
		}
	endif;

	class Skin_Image_Banner extends WP_Widget {
		public function __construct() {
			$widget_ops = array(
				'classname' => 'skin-widget-image-banner',
				'description' => esc_html__( 'Custom image with custom link', 'skin' )
			);

			parent::__construct( 'skin_image_banner', esc_html__( 'Skin Image Banner', 'skin' ), $widget_ops );

			add_action( 'admin_enqueue_scripts', array( $this, 'skin_image_banner_assets' ) );
		}

		public function skin_image_banner_assets() {
			wp_enqueue_media();
			wp_enqueue_script( 'skin_img_upload' );
		}

/*	Widget frontend
====================== */
		function widget( $args, $instance ) {			
			extract( $args );			
		
			if ( '' != $instance['img_id'] ) {			
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
				
				if ( !empty( $instance['img_link'] ) ) {
					$target = isset( $instance['new_tab'] ) && 1 == $instance['new_tab'] ? "_blank" : "_self";
				?>
				<a href="<?php echo esc_url( $instance['img_link'] ); ?>" target="<?php echo esc_attr( $target ); ?>"><?php
					echo skin_get_giffy_img( absint( $instance['img_id'] ), 'medium_large' );
				?></a>
				<?php
				} else {
					echo skin_get_giffy_img( absint( $instance['img_id'] ), 'medium_large' );
				}
			
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
====================== */
		public function form( $instance ) {
			$defaults = array(
				'img_link' 	=> '',
				'new_tab' 	=> 1,
				'img_id' 	=> ''
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults );
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_name( 'img_link' ) ); ?>"><?php esc_html_e( 'Link URL:', 'skin' ); ?></label>			
				<input type="url" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'img_link' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'img_link' ) ); ?>"
					value="<?php echo esc_url( $instance['img_link'] ); ?>"
				>
			</p>
			
			<p>
				<input type="checkbox"
					name="<?php echo esc_attr( $this->get_field_name( 'new_tab' ) ); ?>" 
					id="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>"
					value="1" <?php checked( esc_attr( $instance['new_tab'] ), 1 ); ?>
				>
				<label for="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>"><?php esc_html_e( 'Open link in new tab', 'skin' ); ?></label>
			</p>
			
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
		<?php
		}

/*	Widget update
========================================================================== */
		public function update($new_instance, $old_instance) {
			$instance = $old_instance;
			
			$instance['img_link']	= esc_url_raw( $new_instance['img_link'] );
			$instance['new_tab']	= isset( $new_instance['new_tab'] ) ? esc_attr( $new_instance['new_tab'] ) : 0;
			$instance['img_id'] 	= sanitize_text_field( $new_instance['img_id'] );
			
			return $instance;
		}	
	}
?>