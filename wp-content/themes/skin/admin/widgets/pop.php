<?php 
/* ==============================================
	SKIN POPOUT WIDGET
	Skin - Premium WordPress Theme, by NordWood
================================================= */
	add_action( 'widgets_init', 'skin_pop_init' );
	
	if ( ! function_exists( 'skin_pop_init' ) ) :
		function skin_pop_init() {
			register_widget( 'skin_pop' );
		}
	endif;

	class Skin_Pop extends WP_Widget {
		public function __construct() {
			$widget_ops = array(
				'classname' => 'skin-widget-pop',
				'description' => esc_html__( 'Widget with link to popout page.', 'skin' )
			);

			parent::__construct( 'skin_pop', esc_html__( 'Skin Popout Widget', 'skin' ), $widget_ops );
		}

/*	Widget frontend
====================== */
		function widget( $args, $instance ) {			
			extract( $args );
			
			$pop_id = absint( $instance['pop_page'] );
			$pop_url = get_permalink( $pop_id );
			$pop_label = $instance['label'];
			$pop_img = get_post_meta( $pop_id, 'skin_popout_img_preview', true );
			$img_url = '';
			
			if ( '' != $pop_img ) {
				$img_url = skin_get_giffy_attachment_url( $pop_img, 'medium_large' );
				
			} else if ( has_post_thumbnail( $pop_id ) ) {
				$img_url = skin_get_giffy_featured_img_url( $pop_id, 'medium_large' );
			}
			
			if ( false === $pop_url ) {
				return '';
				
			} else {
				echo wp_kses(
					$before_widget,
					array(
						'section' => array(
							'id' 	=> array(),
							'class' => array()
						),
						'div' => array(
							'id' 	=> array(),
							'class' => array()
						)
					)
				);
				?>				
				<div class="pop-image">					
					<a class="popout-page round" href="<?php echo esc_url( $pop_url ); ?>"><?php
						if ( '' != $img_url ) {
					?>
						<div class="img round bgr-cover" style="background-image:url('<?php echo esc_url( $img_url ); ?>');"></div>
					<?php
						} else {
					?>
						<div class="img round gradient-bgr-vert"></div>
					<?php
						}						
					?>												
						<div class="icon small-item-bgr small-item-color round va-middle"><?php echo skin_get_icon_link(); ?></div>
						<span class="line-left txt-color-to-bgr"></span>
						<span class="line-right txt-color-to-bgr"></span>
					</a>
				</div>
				
				<?php
				if ( '' !==  $pop_label ) {
				?>
				<a class="popout-page link-hov-main" href="<?php echo esc_url( $pop_url ); ?>"><h5><?php
					echo esc_html( $pop_label );
				?></h5></a>
				<?php
				}
					
				echo wp_kses(
					$after_widget,
					array(
						'section' 	=> array(),
						'div'		=> array()
					)
				);
			}
		}

/*	Widget backend
====================== */
		public function form( $instance ) {
			$defaults = array(
				'pop_page'	=> '',
				'label'		=> ''
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults );	
			
			$pop_args = array(
				'post_type' 	=> 'popout',
				'post_status'	=> 'publish'
			);
			
			$pops = get_posts( $pop_args );
			
			if ( !$pops || true != is_plugin_active( 'skin-popout-pages/skin-popout-pages.php' ) ) {
				if ( !is_plugin_active( 'skin-popout-pages/skin-popout-pages.php' ) ) {
					printf(
						'<p>%1$s</p><p><a href="%2$s">%3$s</a></p>',
						esc_html__( 'Oops! You need to activate the Skin Popout Page plugin first.', 'skin' ),
						esc_url( admin_url( 'plugins.php' ) ),
						esc_html__( 'Go to Plugins screen', 'skin' )
					);
					
				} else {
					printf(
						'<p>%1$s</p><p><a href="%2$s">%3$s</a></p>',
						esc_html__( 'Oops! It seems like you don\'t have any Popout page yet. Click on the link below to create a popout.', 'skin' ),
						esc_url( admin_url( 'post-new.php?post_type=popout' ) ),
						esc_html__( 'Add Popout Page', 'skin' )
					);
				}
				
			} else {
		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'pop_page' ) ); ?>"><?php esc_html_e( 'Popout page', 'skin' ); ?></label>
				
				<select name="<?php echo esc_attr( $this->get_field_name( 'pop_page' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'pop_page' ) ); ?>">
			<?php				
				foreach ( $pops as $pop ) {
					$pop_name = $pop->post_title;
					$pop_id = $pop->ID;
			?>
					<option value="<?php echo esc_attr( $pop_id ); ?>" <?php echo ( $pop_id === absint( $instance['pop_page'] ) ) ? 'selected' : ''; ?>><?php
						echo esc_html( $pop_name );
					?></option>
			<?php
				}
			?>
				</select>
			</p>
		
			<p>	
				<label for="<?php echo esc_attr( $this->get_field_name( 'label' ) ); ?>"><?php esc_html_e( 'Popout link title:', 'skin' ); ?></label>			
				<input type="text" class="widefat"
					name="<?php echo esc_attr( $this->get_field_name( 'label' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>"
					value="<?php echo esc_attr( $instance['label'] ); ?>"
					placeholder="<?php esc_attr_e( 'Check this out', 'skin' ); ?>"
				>
			</p>
		<?php		
			}
		}

/*	Widget update
==================== */
		public function update($new_instance, $old_instance) {
			$instance = $old_instance;
			
			$instance['pop_page'] 		= sanitize_text_field( $new_instance['pop_page'] );
			$instance['label'] 			= sanitize_text_field( $new_instance['label'] );
			
			return $instance;
		}	
	}
?>