<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Cariera_Widget_Resume_Search extends WP_Widget {

	public function __construct() {
		$widget_options = [
			'classname'   => 'resume-search-widget',
			'description' => esc_html__( 'Resume search form.', 'cariera' ),
		];

		parent::__construct( 'resume-search-widget', esc_html__( 'Custom: Resume Search Widget', 'cariera' ), $widget_options, 'cariera' );
	}

	// Output the widget content on the front-end.
	public function widget( $args, $instance ) {
		echo wp_kses_post( $args['before_widget'] );

		do_shortcode( '[cariera_resume_sidebar_search]' );

		echo wp_kses_post( $args['after_widget'] );
	}

	// Output the option form field in admin Widgets screen.
	public function form( $instance ) {}

	// Save options.
	public function update( $new_instance, $old_instance ) {}
}

register_widget( 'Cariera_Widget_Resume_Search' );
