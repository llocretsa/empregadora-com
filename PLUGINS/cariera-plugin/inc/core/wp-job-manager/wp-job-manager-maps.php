<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Cariera_WPJM_Maps {

	/**
	 * Constructor
	 *
	 * @since   1.2.0
	 * @version 1.5.3
	 */
	public function __construct() {
		add_shortcode( 'cariera-map', [ $this, 'show_map' ] );
	}

	/**
	 * Constructor
	 *
	 * @since   1.2.0
	 * @version 1.5.3
	 */
	public function show_map( $atts ) {

		$atts = shortcode_atts(
			[
				'class'  => '',
				'type'   => 'job_listing',
				'height' => '',
			],
			$atts
		);

		$query_args = [
			'post_type'      => $atts['type'],
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		];

		if ( empty( $atts['height'] ) ) {
			$map_height = cariera_get_option( 'cariera_map_height' );
		} else {
			$map_height = $atts['height'];
		}

		$output = '<div id="map-container" class="' . esc_attr( $atts['class'] ) . '"><div id="cariera-map" style="height:' . esc_attr( $map_height ) . '" ></div></div>';

		return $output;
	}
}

new Cariera_WPJM_Maps();
