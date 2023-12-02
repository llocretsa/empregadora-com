<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Cariera_Social_Links_Widget extends WP_Widget {
	protected $default;
	protected $socials;

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->socials = [
			'facebook'  => esc_html__( 'Facebook', 'cariera' ),
			'twitter'   => esc_html__( 'Twitter', 'cariera' ),
			'youtube'   => esc_html__( 'Youtube', 'cariera' ),
			'tumblr'    => esc_html__( 'Tumblr', 'cariera' ),
			'linkedin'  => esc_html__( 'Linkedin', 'cariera' ),
			'pinterest' => esc_html__( 'Pinterest', 'cariera' ),
			'flickr'    => esc_html__( 'Flickr', 'cariera' ),
			'instagram' => esc_html__( 'Instagram', 'cariera' ),
			'dribbble'  => esc_html__( 'Dribbble', 'cariera' ),
		];
		$this->default = [
			'title' => '',
		];
		foreach ( $this->socials as $k => $v ) {
			$this->default[ "{$k}_title" ] = $v;
			$this->default[ "{$k}_url" ]   = '';
		}

		$widget_options = [
			'classname'   => 'cariera-social-media',
			'description' => esc_html__( 'This widget displays social media icons.', 'cariera' ),
		];

		parent::__construct( 'cariera-social-media', esc_html__( 'Custom: Social Media Widget', 'cariera' ), $widget_options );
	}

	/**
	 * Front-End Display of the Widget
	 *
	 * @param [type] $args
	 * @param [type] $instance
	 * @return void
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->default );

		echo wp_kses_post( $args['before_widget'] );

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		if ( $title ) {
			echo $before_title . esc_html( $title ) . $after_title;
		}

		echo '<ul class="social-btns">';

		foreach ( $this->socials as $social => $label ) {
			if ( ! empty( $instance[ $social . '_url' ] ) ) {
				$social_title = esc_attr( $instance[ $social . '_title' ] );
				$social_url   = esc_url( $instance[ $social . '_url' ] );

				printf(
					'<li class="list-inline-item">
                       <a href="' . esc_url( $social_url ) . '" class="social-btn-roll ' . esc_attr( $social ) . '" target="_blank">
                           <div class="social-btn-roll-icons">
                                <i class="social-btn-roll-icon fab fa-' . esc_attr( $social ) . '"></i>
                                <i class="social-btn-roll-icon fab fa-' . esc_attr( $social ) . '"></i>
                            </div>
                       </a>
                    </li>'
				);
			}
		}

		echo '</ul>';

		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Back-End display of the Widget
	 *
	 * @param [type] $instance
	 * @return void
	 *
	 * @since 1.4.0
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->default ); ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'cariera' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
		</p>
		<?php
		foreach ( $this->socials as $social => $label ) {
			printf(
				'<div class="mr-recent-box">
					<label>%s</label>
					<p><input type="text" class="widefat" name="%s" placeholder="%s" value="%s"></p>
				</div>',
				esc_html( $label ),
				$this->get_field_name( $social . '_url' ),
				esc_html__( 'URL', 'cariera' ),
				$instance[ $social . '_url' ]
			);
		}
	}
}

register_widget( 'Cariera_Social_Links_Widget' );
