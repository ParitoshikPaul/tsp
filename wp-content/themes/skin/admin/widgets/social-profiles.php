<?php 
/* ================================================
	SKIN SOCIAL PROFILES
	Skin - Premium WordPress Theme, by NordWood
=================================================== */
	add_action( 'widgets_init', 'skin_social_profiles_init' );
	
	if ( ! function_exists( 'skin_social_profiles_init' ) ) :
		function skin_social_profiles_init() {
			register_widget( 'skin_social_profiles' );
		}
	endif;

	class Skin_Social_Profiles extends WP_Widget {
		public function __construct() {
			$widget_ops = array(
				'classname' => 'skin-widget-social-profiles',
				'description' => esc_html__( 'Links to author\'s profiles on social networks', 'skin' )
			);

			parent::__construct( 'skin_social_profiles', esc_html__( 'Skin Social Profiles', 'skin' ), $widget_ops );
		}

/*	Widget frontend
====================== */
		function widget( $args, $instance ) {			
			extract( $args );
			
			if ( $socials = get_theme_mod( 'skin_social_profiles' ) ) :
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
				
				if ( '' != $instance['title'] ) {
				?>
				<h2><?php echo esc_html( $instance['title'] ); ?></h2>
				<?php
				}
				
				if ( '' != $instance['description'] ) {
				?>
				<div class="text"><?php echo esc_html( $instance['description'] ); ?></div>
				<?php
				}
				?>
				<div class="links"><?php echo skin_social_profiles(); ?></div>				
				<?php			
				echo wp_kses(
					$after_widget,
					array(
						'section' => array(),
						'div' => array()
					)
				);
			endif;
		}

/*	Widget backend
===================== */
		public function form( $instance ) {
			$defaults = array(
				'title'			=> '',
				'description'	=> ''
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults );
			?>
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					value="<?php echo esc_attr( $instance['title'] ); ?>"
					placeholder="<?php esc_attr_e( 'Let\'s connect', 'skin' ); ?>"
				>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description:', 'skin' ); ?></label>
				<textarea class="widefat" rows="7"
					name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"
				><?php echo esc_textarea( $instance['description'] ); ?></textarea>
			</p>
		<?php
		}

/*	Widget update
==================== */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance['title']			= sanitize_text_field( $new_instance['title'] );
			$instance['description']	= sanitize_text_field( $new_instance['description'] );
			
			return $instance;
		}	
	}
?>