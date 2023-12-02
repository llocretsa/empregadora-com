<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Cariera_Widget_Company_Search extends WP_Widget {

	/**
	 * Constructor function.
	 *
	 * @since   1.4.0
	 * @version 1.4.0
	 */
	public function __construct() {
		$widget_options = [
			'classname'   => 'company-search-widget',
			'description' => esc_html__( 'Company search form.', 'cariera' ),
		];

		parent::__construct( 'company-search-widget', esc_html__( 'Custom: Company Search Widget', 'cariera' ), $widget_options, 'cariera' );
	}

	// Output the widget content on the front-end.
	public function widget( $args, $instance ) {
		echo wp_kses_post( $args['before_widget'] );

		do_shortcode( '[cariera_company_sidebar_search]' );

		echo wp_kses_post( $args['after_widget'] );
	}

	// Output the option form field in admin Widgets screen.
	public function form( $instance ) {}

	// Save options.
	public function update( $new_instance, $old_instance ) {}
}

register_widget( 'Cariera_Widget_Company_Search' );
