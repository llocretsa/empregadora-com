<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Cariera_Company_Manager {

	/**
	 * Cariera Company Manager CPT
	 *
	 * @var Cariera_Company_Manager_CPT
	 */
	public $post_types;

	/**
	 * Cariera Company Manager Forms Handling
	 *
	 * @var Cariera_Company_Manager_Forms
	 */
	public $forms;

	/**
	 * Cariera Company Manager Settings
	 *
	 * @var Cariera_Company_Manager_Settings
	 */
	public $settings;

	/**
	 * Cariera Company Manager WPJM Integration
	 *
	 * @var Cariera_Company_Manager_WPJM
	 */
	public $wpjm;

	/**
	 * Constructor
	 */
	public function __construct() {
		include_once 'company-manager-functions.php';
		include_once 'company-manager-templates.php';

		// Init classes.
		new Cariera_Company_Manager_Shortcodes();
		new Cariera_Company_Manager_Writepanels();
		new Cariera_Company_Manager_Geocode();
		new Cariera_Company_Manager_Email_Notifications();
		Cariera_Company_Manager_Lifecycle::instance();

		if ( class_exists( 'WP_Job_Manager_Bookmarks' ) ) {
			new Cariera_Company_Manager_Bookmarks();
		}

		$this->post_types = new Cariera_Company_Manager_CPT();
		$this->forms      = new Cariera_Company_Manager_Forms();
		$this->settings   = new Cariera_Company_Manager_Settings();
		$this->wpjm       = new Cariera_Company_Manager_WPJM();

		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );
		add_action( 'rest_api_init', [ $this, 'rest_init' ] );
	}

	/**
	 * Queries companies with certain criteria and returns them.
	 *
	 * @since   1.3.0
	 * @version 1.6.3
	 */
	public function frontend_scripts() {
		$ajax_filter_deps = [ 'jquery', 'jquery-deserialize' ];

		// Ajax Filters.
		wp_register_script( 'company-ajax-filters', CARIERA_URL . '/assets/dist/js/company-ajax-filters.js', $ajax_filter_deps, CARIERA_CORE_VERSION, true );
		wp_localize_script(
			'company-ajax-filters',
			'cariera_company_ajax_filters',
			[
				'ajax_url' => admin_url( 'admin-ajax.php', 'relative' ),
				'is_rtl'   => is_rtl() ? 1 : 0,
				'lang'     => apply_filters( 'wpjm_lang', null ),
			]
		);

		// Company Submission.
		wp_register_script( 'cariera-company-manager-submission', CARIERA_URL . '/assets/dist/js/company-submission.js', [ 'jquery', 'jquery-ui-sortable' ], CARIERA_CORE_VERSION, true );

		// Company Dashboard.
		wp_register_script( 'cariera-company-manager-dashboard', CARIERA_URL . '/assets/dist/js/company-dashboard.js', [ 'jquery' ], CARIERA_CORE_VERSION, true );
		wp_localize_script(
			'cariera-company-manager-dashboard',
			'cariera_company_dashboard',
			[
				'i18n_confirm_delete' => esc_html__( 'Are you sure you want to delete this company listing?', 'cariera' ),
			]
		);
	}

	/**
	 * Loads the REST API functionality.
	 *
	 * @since 1.5.6
	 */
	public function rest_init() {
		Cariera_Company_Manager_REST_API::init();
	}

	/**
	 * Autoload classes and files
	 *
	 * @since  1.3.0
	 */
	public static function autoload( $class ) {

		// Exit autoload if being called by a class.
		if ( false === strpos( $class, 'Cariera_Company_Manager' ) ) {
			return;
		}

		$class_file = str_replace( 'Cariera_Company_Manager_', '', $class );
		$file_array = array_map( 'strtolower', explode( '_', $class_file ) );
		// var_dump( $file_array );

		$dirs = 0;
		$file = untrailingslashit( __DIR__ );

		foreach ( $file_array as $dir ) {
			++$dirs;
			$maybe_file = implode( '-', array_slice( $file_array, $dirs - 1 ) );

			if ( file_exists( $file . '/' . $maybe_file . '.php' ) ) {
				$file .= '/' . $maybe_file;
				break;
			} else {
				$file .= '/' . $dir;
			}
		}

		$file .= '.php';

		if ( ! file_exists( $file ) || $class === 'Cariera_Company_Manager' ) {
			return;
		}

		include $file;
	}
}

spl_autoload_register( [ 'Cariera_Company_Manager', 'autoload' ] );

$GLOBALS['cariera_company_manager'] = new Cariera_Company_Manager();
