<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Cariera_Job_Manager_Colors {

	private static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		$this->setup_actions();
	}

	private function setup_actions() {
		add_filter( 'job_manager_settings', [ $this, 'job_manager_settings' ] );
		add_action( 'wp_head', [ $this, 'output_colors' ] );

		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', [ $this, 'colorpickers' ] );
			add_action( 'admin_footer', [ $this, 'colorpickersjs' ] );
		}
	}

	public function job_manager_settings( $settings ) {
		$settings['job_colors'] = [
			esc_html__( 'Job Colors', 'cariera' ),
			$this->create_options(),
		];

		return $settings;
	}

	private function create_options() {
		$terms   = get_terms( 'job_listing_type', [ 'hide_empty' => false ] );
		$options = [];

		foreach ( $terms as $term ) {
			$options[] = [
				'name'        => 'job_manager_job_type_' . $term->slug . '_color',
				'std'         => '',
				'placeholder' => '#',
				'label'       => $term->name,
				'desc'        => esc_html__( 'Hex value for the color of this job type.', 'cariera' ),
				'attributes'  => [
					'data-default-color' => '',
					'data-type'          => 'colorpicker',
				],
			];
		}

		return $options;
	}

	public function output_colors() {
		$terms = get_terms( 'job_listing_type', [ 'hide_empty' => false ] );

		echo "<style id='job_manager_colors'>\n";

		foreach ( $terms as $term ) {
			if ( ! empty( get_option( 'job_manager_job_type_' . $term->slug . '_color' ) ) ) {
				printf( ".job-type.term-%s { background-color: %s; } \n", $term->term_id, get_option( 'job_manager_job_type_' . $term->slug . '_color', '#fff' ) );
			}
		}

		echo "</style>\n";
	}

	public function colorpickers( $hook ) {
		$screen = get_current_screen();

		if ( 'job_listing_page_job-manager-settings' !== $screen->id ) {
			return;
		}

		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
	}

	public function colorpickersjs() {
		$screen = get_current_screen();

		if ( 'job_listing_page_job-manager-settings' !== $screen->id ) {
			return;
		} ?>

		<script>
			jQuery(document).ready(function($){
				$( 'input[data-type="colorpicker"]' ).wpColorPicker();
			});
		</script>
		<?php
	}
}

if ( get_option( 'job_manager_enable_types' ) == 1 ) {
	add_action( 'init', [ 'Cariera_Job_Manager_Colors', 'instance' ] );
}
