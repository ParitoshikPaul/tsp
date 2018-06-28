<?php 
/* ==============================================
	SKIN CONTACT WIDGET
	Skin - Premium WordPress Theme, by NordWood
================================================= */
	add_action( 'widgets_init', 'skin_contact_init' );

	if ( ! function_exists( 'skin_contact_init' ) ) :
		function skin_contact_init() {
			register_widget( 'skin_contact' );
		}
	endif;

	class Skin_Contact extends WP_Widget {
		public function __construct() {
			$widget_ops = array(
				'classname' => 'skin-widget-contact',
				'description' => esc_html__( 'Insert Google Map and other contact information', 'skin' )
			);

			parent::__construct( 'skin_contact', esc_html__( 'Skin Contact Widget', 'skin' ), $widget_ops );

			add_action( 'admin_enqueue_scripts', array( $this, 'skin_contact_widget_assets' ) );
		}

		public function skin_contact_widget_assets() {
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
			
			if ( '' != $instance['title'] ) {
				$title = apply_filters( 'widget_title', $instance['title'] );
				
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
			
			$text = $instance['text'];
			
			$lat		= ( isset( $instance['latitude'] ) && '' != $instance['latitude'] ) ? $instance['latitude'] : '';
			$lng		= ( isset( $instance['longitude'] ) && '' != $instance['longitude'] ) ? $instance['longitude'] : '';
			$address	= ( isset( $instance['address'] ) && '' != $instance['address'] ) ? $instance['address'] : '';
			$zoom		= ( isset( $instance['zoom'] ) && '' != $instance['zoom'] ) ? $instance['zoom'] : 15;
			$height		= ( isset( $instance['height'] ) && '' != $instance['height'] ) ? $instance['height'] : 188;
			$pin_title	= ( isset( $instance['pin_title'] ) && '' != $instance['pin_title'] ) ? $instance['pin_title'] : '';
			$pin_url	= 'https://chart.googleapis.com/chart?chst=d_map_pin_icon&chld=location|2b2b2b';
			
			if ( isset( $instance['img_id'] ) && '' != $instance['img_id'] ) {
				$pin_id = $instance['img_id'];
				$pin_url = skin_get_giffy_attachment_url( $pin_id, 'skin_small' );
			}
			
			$has_map = ( '' != $lat && '' != $lng ) || '' != $address;
			$has_text = '' != $text;
			
			if ( $has_map ) {
			?>
				<div class="skin-map-holder loading-holder promised"><?php echo skin_loading_content(); ?><div id="<?php echo esc_attr( uniqid("map_",true) ); ?>"
					class="google-map" style="height:<?php echo esc_attr( $height ); ?>px"
					data-map-zoom="<?php echo esc_attr( $zoom ); ?>"
					data-map-lat="<?php echo esc_attr( $lat ); ?>"
					data-map-lng="<?php echo esc_attr( $lng ); ?>"
					data-map-address="<?php echo esc_attr( $address ); ?>"
					data-map-title="<?php echo esc_attr( $pin_title ); ?>"
					data-map-pin="<?php echo esc_url( $pin_url ); ?>"
				></div></div>
			<?php
			}
			
			if ( $has_text ) {			
			?>
				<div class="text small-text"><?php echo do_shortcode( wp_kses_post( $text ) ); ?></div>
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
				'title' 		=> '',
				'text' 			=> '',
				'latitude' 		=> '',
				'longitude' 	=> '',
				'address' 		=> '',
				'zoom' 			=> '15',
				'height' 		=> '188',
				'pin_title' 	=> '',
				'img_id'		=> ''
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults );
			?>
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					value="<?php echo esc_attr( $instance['title'] ); ?>"
					placeholder="<?php esc_attr_e( 'Contact Info', 'skin' ); ?>"
				>
			</p>
			
			<h4><?php esc_html_e( 'Google Map (optional)', 'skin' ); ?></h4>
			<p><?php esc_html_e( 'Map requires either both the latitude & longitude coordinates, or a full address.', 'skin' ); ?></p>
			
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'latitude' ) ); ?>"><?php esc_html_e( 'Latitude:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'latitude' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'latitude' ) ); ?>"
					value="<?php echo esc_attr( $instance['latitude'] ); ?>"
				>
			</p>
			
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'longitude' ) ); ?>"><?php esc_html_e( 'Longitude:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'longitude' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'longitude' ) ); ?>"
					value="<?php echo esc_attr( $instance['longitude'] ); ?>"
				>
			</p>
			
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>"><?php esc_html_e( 'Address:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"
					value="<?php echo esc_attr( $instance['address'] ); ?>"
				>
			</p>
			
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'zoom' ) ); ?>"><?php esc_html_e( 'Map zoom (1-20):', 'skin' ); ?></label>			
				<input type="number" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'zoom' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'zoom' ) ); ?>"
					value="<?php echo esc_attr( $instance['zoom'] ); ?>"
				>
			</p>
			
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>"><?php esc_html_e( 'Map height:', 'skin' ); ?></label>			
				<input type="number" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"
					value="<?php echo esc_attr( $instance['height'] ); ?>"
				>
			</p>
			
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'pin_title' ) ); ?>"><?php esc_html_e( 'Pin title:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'pin_title' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'pin_title' ) ); ?>"
					value="<?php echo esc_attr( $instance['pin_title'] ); ?>"
				>
			</p>
			
			<p><?php esc_html_e( 'Custom pin:', 'skin' ); ?></p>
			
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
					value="<?php esc_attr_e( 'Upload Pin Image', 'skin' ); ?>"
				>
				
				<input type="button" class="button remove-img <?php if( '' === $instance['img_id'] ) { echo 'hidden'; } ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'remove_img' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'remove_img' ) ); ?>"
					value="<?php esc_attr_e( 'Remove Pin Image', 'skin' ); ?>"
				>
				<p></p>
			</div>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text (can also contain a shortcode for contact form):', 'skin' ); ?></label>
				<textarea class="widefat" rows="7"
					name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"
				><?php echo esc_textarea( $instance['text'] ); ?></textarea>
			</p>
		<?php
		}

/*	Widget update
==================== */
		public function update($new_instance, $old_instance) {
			$instance = $old_instance;
			
			$new_instance['zoom']	= ( '' != $new_instance['zoom'] ) ? $new_instance['zoom'] : 15;
			$new_instance['height'] = ( '' != $new_instance['height'] ) ? $new_instance['height'] : 188;
			
			$instance['title'] 		= sanitize_text_field( $new_instance['title'] );
			$instance['text'] 		= wp_kses_post( $new_instance['text'] );
			$instance['latitude'] 	= sanitize_text_field( $new_instance['latitude'] );
			$instance['longitude'] 	= sanitize_text_field( $new_instance['longitude'] );
			$instance['address'] 	= sanitize_text_field( $new_instance['address'] );
			$instance['zoom'] 		= absint( $new_instance['zoom'] );
			$instance['height'] 	= absint( $new_instance['height'] );
			$instance['pin_title'] 	= sanitize_text_field( $new_instance['pin_title'] );
			$instance['img_id']		= sanitize_text_field( $new_instance['img_id'] );
			
			return $instance;
		}	
	}
?>