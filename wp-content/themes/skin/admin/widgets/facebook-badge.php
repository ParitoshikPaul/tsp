<?php
/* ==============================================
	SKIN FACEBOOK WIDGET
	Skin - Premium WordPress Theme, by NordWood
================================================= */
	add_action( 'widgets_init', 'skin_fb_badge_init' );
	 
	if ( ! function_exists( 'skin_fb_badge_init' ) ) :
		function skin_fb_badge_init() {
			register_widget( 'Skin_Fb_Badge' );
		}
	endif;
	 
	class Skin_Fb_Badge extends WP_Widget {
		public function __construct() {
			$widget_ops = array(
				'classname'		=> 'skin-widget-fb-badge',
				'description'	=> esc_html__( 'Show facebook profile badge', 'skin' )
			);
	 
			parent::__construct( 'skin_fb_badge', esc_html__( 'Skin Facebook widget', 'skin' ), $widget_ops );
		}       
	 
		function widget( $args, $instance ) {
			extract( $args );
				
			$small_header	= ( isset( $instance['small_header'] ) && 1 == $instance['small_header'] ) ? "true" : "false";
			$hide_cover		= ( isset( $instance['hide_cover'] ) && 1 == $instance['hide_cover'] ) ? "true" : "false";
			$show_facepile	= ( isset( $instance['show_facepile'] ) && 1 == $instance['show_facepile'] ) ? "true" : "false";
			
			$data_tabs = '';
			
			if ( isset( $instance['show_timeline'] ) && 1 == $instance['show_timeline'] ) {
				$data_tabs .= "timeline,";
			}
			
			if ( isset( $instance['show_events'] ) && 1 == $instance['show_events'] ) {
				$data_tabs .= "events,";
			}
			
			if ( isset( $instance['show_messages'] ) && 1 == $instance['show_messages'] ) {
				$data_tabs .= "messages,";
			}
			
			$fb_page_id = isset( $instance['fb_page_id'] ) ? $instance['fb_page_id'] : esc_html__( 'NordWoodThemes', 'skin' );		
				
			echo wp_kses(
				$before_widget,
				array(
					'section' => array(
						'id' => array(),
						'class' => array()
					)
				)
			);
			
			echo skin_loading_content();
		?>
			<div class="fb-page" class="fb-xfbml-parse-ignore"
				data-adapt-container-width="true"
				data-href="<?php echo esc_url( 'https://www.facebook.com/'.$fb_page_id ); ?>"  
				data-small-header=<?php echo esc_attr( $small_header ); ?>
				data-hide-cover=<?php echo esc_attr( $hide_cover ); ?>	
				data-show-facepile=<?php echo esc_attr( $show_facepile ); ?>		  
				data-tabs=<?php echo esc_attr( $data_tabs ); ?>
			>
				<div class="fb-xfbml-parse-ignore">
					<blockquote cite="<?php echo esc_attr( 'https://www.facebook.com/'.$fb_page_id ); ?>">
						<a href="<?php echo esc_url( 'https://www.facebook.com/'.$fb_page_id ); ?>"><?php echo esc_html( $fb_page_id ); ?></a>
					</blockquote>
				</div>
			</div>
		<?php			
			echo wp_kses(
				$after_widget,
				array(
					'section' => array()
				)
			);
		}
	 
		function form( $instance ) {
			$defaults = array(
					'fb_page_id' 	=> 'NordWoodThemes',
					'small_header'	=> 0,
					'hide_cover' 	=> 0,
					'show_facepile' => 0,
					'show_timeline' => 0,
					'show_events' 	=> 0,
					'show_messages' => 0
			);
			$instance = wp_parse_args( (array) $instance, $defaults );		
		?>			
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name('fb_page_id') ); ?>"><?php esc_html_e( 'FB page name:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name('fb_page_id') ); ?>"
					id="<?php echo esc_attr( $this->get_field_id('fb_page_id') ); ?>"
					value="<?php echo esc_attr( $instance['fb_page_id'] ); ?>"
				>
			</p>	
		
			<p>
				<input type="checkbox"
					name="<?php echo esc_attr( $this->get_field_name('small_header') ); ?>"
					id="<?php echo esc_attr( $this->get_field_id('small_header') ); ?>"
					value="1" <?php checked( $instance['small_header'], 1 ); ?>
				>
				<label for="<?php echo esc_attr( $this->get_field_id('small_header') ); ?>"><?php esc_html_e( 'Make header smaller', 'skin' ); ?></label>
			</p>	
		
			<p>
				<input type="checkbox"
					name="<?php echo esc_attr( $this->get_field_name('hide_cover') ); ?>"
					id="<?php echo esc_attr( $this->get_field_id('hide_cover') ); ?>"
					value="1" <?php checked( $instance['hide_cover'], 1 ); ?>
				>
				<label for="<?php echo esc_attr( $this->get_field_id('hide_cover') ); ?>"><?php esc_html_e( 'Hide cover', 'skin' ); ?></label>
			</p>	
		
			<p>
				<input type="checkbox"
					name="<?php echo esc_attr( $this->get_field_name('show_facepile') ); ?>"
					id="<?php echo esc_attr( $this->get_field_id('show_facepile') ); ?>"
					value="1" <?php checked( $instance['show_facepile'], 1 ); ?>
				>
				<label for="<?php echo esc_attr( $this->get_field_id('show_facepile') ); ?>"><?php esc_html_e( 'Show facepile', 'skin' ); ?></label>
			</p>	
		
			<p>
				<input type="checkbox"
					name="<?php echo esc_attr( $this->get_field_name('show_timeline') ); ?>"
					id="<?php echo esc_attr( $this->get_field_id('show_timeline') ); ?>"
					value="1" <?php checked( $instance['show_timeline'], 1 ); ?>
				>
				<label for="<?php echo esc_attr( $this->get_field_id('show_timeline') ); ?>"><?php esc_html_e( 'Show timeline', 'skin' ); ?></label>
			</p>	
		
			<p>
				<input type="checkbox"
					name="<?php echo esc_attr( $this->get_field_name('show_events') ); ?>"
					id="<?php echo esc_attr( $this->get_field_id('show_events') ); ?>"
					value="1" <?php checked( $instance['show_events'], 1 ); ?>
				>
				<label for="<?php echo esc_attr( $this->get_field_id('show_events') ); ?>"><?php esc_html_e( 'Show events', 'skin' ); ?></label>
			</p>	
		
			<p>
				<input type="checkbox"
					name="<?php echo esc_attr( $this->get_field_name('show_messages') ); ?>"
					id="<?php echo esc_attr( $this->get_field_id('show_messages') ); ?>"
					value="1" <?php checked( $instance['show_messages'], 1 ); ?>
				>
				<label for="<?php echo esc_attr( $this->get_field_id('show_messages') ); ?>"><?php esc_html_e( 'Show messages', 'skin' ); ?></label>
			</p>
		<?php
		}
	 
		function update( $new_instance, $old_instance ) {  
			$instance = $old_instance;		
			
			$instance['fb_page_id'] 	= sanitize_text_field( $new_instance['fb_page_id'] );
			$instance['small_header']	= isset( $new_instance['small_header'] ) ? esc_attr( $new_instance['small_header'] ) : 0;
			$instance['hide_cover']		= isset( $new_instance['hide_cover'] ) ? esc_attr( $new_instance['hide_cover'] ) : 0;
			$instance['show_facepile']	= isset( $new_instance['show_facepile'] ) ? esc_attr( $new_instance['show_facepile'] ) : 0;
			$instance['show_timeline']	= isset( $new_instance['show_timeline'] ) ? esc_attr( $new_instance['show_timeline'] ) : 0;
			$instance['show_events']	= isset( $new_instance['show_events'] ) ? esc_attr( $new_instance['show_events'] ) : 0;
			$instance['show_messages']	= isset( $new_instance['show_messages'] ) ? esc_attr( $new_instance['show_messages'] ) : 0;

			return $instance;
		}
	}
?>