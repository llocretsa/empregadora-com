<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles core plugin hooks and action setup.
 *
 * @since 1.4.3
 */
class Cariera_Core {

	/**
	 * The single instance of the class.
	 *
	 * @var Cariera_Core
	 */
	private static $instance = null;

	/**
	 * App Rest Class for mobile handling.
	 *
	 * @var Cariera_Core_App_REST
	 */
	protected $app_rest;

	/**
	 * Cariera Custom Post Types
	 *
	 * @var Cariera_Core_CPT
	 */
	protected $cpt;

	/**
	 * Cariera WPJM Custom Fields
	 *
	 * @var Cariera_Core_Fields
	 */
	protected $fields;

	/**
	 * Cariera Custom WPJM Searches
	 *
	 * @var Cariera_Core_Search
	 */
	protected $search;

	/**
	 * Cariera Custom WPJM Settings
	 *
	 * @var Cariera_Core_Settings
	 */
	protected $settings;

	/**
	 * Cariera Notifications
	 *
	 * @var Cariera_Core_Notifications
	 */
	protected $notifications;

	/**
	 * Cariera Admin Settings
	 *
	 * @var Cariera_Core_Admin
	 */
	protected $admin;

	/**
	 * Cariera Email Handling
	 *
	 * @var Cariera_Core_Emails
	 */
	protected $emails;

	/**
	 * Cariera Users
	 *
	 * @var Cariera_Core_Users
	 */
	protected $users;

	/**
	 * Cariera Metaboxes
	 *
	 * @var Cariera_Core_Metabox
	 */
	protected $metabox;

	/**
	 * Cariera Messages
	 *
	 * @var Cariera_Core_Messages
	 */
	protected $messages;

	/**
	 * Main Cariera Core Instance.
	 *
	 * Ensures only one instance of Cariera Core is loaded or can be loaded.
	 *
	 * @since  1.4.3
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor function.
	 *
	 * @since   1.4.3
	 * @version 1.6.2
	 */
	public function __construct() {

		// Includes.
		include_once CARIERA_PATH . '/inc/core/admin.php';
		include_once CARIERA_PATH . '/inc/core/app-rest.php';
		include_once CARIERA_PATH . '/inc/core/cpt.php';
		include_once CARIERA_PATH . '/inc/core/emails.php';
		include_once CARIERA_PATH . '/inc/core/fields.php';
		include_once CARIERA_PATH . '/inc/core/search.php';
		include_once CARIERA_PATH . '/inc/core/settings.php';
		include_once CARIERA_PATH . '/inc/core/notifications.php';
		include_once CARIERA_PATH . '/inc/core/metabox.php';
		include_once CARIERA_PATH . '/inc/core/messages.php';
		include_once CARIERA_PATH . '/inc/core/users.php';

		// Init Classes.
		$this->app_rest      = new Cariera_Core_App_REST();
		$this->cpt           = new Cariera_Core_CPT();
		$this->fields        = new Cariera_Core_Fields();
		$this->search        = new Cariera_Core_Search();
		$this->settings      = new Cariera_Core_Settings();
		$this->notifications = new Cariera_Core_Notifications();
		$this->admin         = Cariera_Core_Admin::instance();
		$this->emails        = Cariera_Core_Emails::instance();
		$this->users         = Cariera_Core_Users::instance();
		$this->metabox       = Cariera_Core_Metabox::instance();
		$this->messages      = Cariera_Core_Messages::instance();

		// Register Assets.
		add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );

		// Enqueue Assets.
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ], 20 );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ], 20 );

		// Actions.
		add_action( 'widgets_init', [ $this, 'widgets_init' ] );
		add_action( 'admin_notices', [ $this, 'admin_notices' ] );

		// AJAX Dropzone.
		add_action( 'wp_ajax_handle_uploaded_media', [ $this, 'uploaded_dropzone_media' ] );
		add_action( 'wp_ajax_nopriv_handle_uploaded_media', [ $this, 'uploaded_dropzone_media' ] );
		add_action( 'wp_ajax_handle_deleted_media', [ $this, 'deleted_dropzone_media' ] );
		add_action( 'wp_ajax_nopriv_handle_deleted_media', [ $this, 'deleted_dropzone_media' ] );

		// Custom Cron Schedules.
		add_filter( 'cron_schedules', [ $this, 'cron_schedules' ] );
	}

	/**
	 * Registering Widgets
	 *
	 * @since  1.2.2
	 */
	public function widgets_init() {
		include_once CARIERA_PATH . '/inc/widgets/social-media-widget.php';
		include_once CARIERA_PATH . '/inc/widgets/recent-posts-widget.php';
		include_once CARIERA_PATH . '/inc/widgets/job-search-widget.php';
		include_once CARIERA_PATH . '/inc/widgets/resume-search-widget.php';
		include_once CARIERA_PATH . '/inc/widgets/company-search-widget.php';
	}

	/**
	 * Register Core Plugin assets.
	 *
	 * @since   1.6.3
	 * @version 1.7.1
	 */
	public function register_assets() {
		$suffix = is_rtl() ? '.rtl' : '';

		// Main Core Frontend.
		wp_register_script( 'cariera-core-main', CARIERA_URL . '/assets/dist/js/frontend.js', [ 'jquery' ], CARIERA_CORE_VERSION, true );

		$args = [
			'ajax_url'      => esc_url( admin_url( 'admin-ajax.php', 'relative' ) ),
			'nonce'         => wp_create_nonce( '_cariera_core_nonce' ),
			'is_rtl'        => is_rtl() ? 1 : 0,
			'home_url'      => esc_url( home_url( '/' ) ),
			'upload_ajax'   => admin_url( 'admin-ajax.php?action=handle_uploaded_media' ),
			'delete_ajax'   => admin_url( 'admin-ajax.php?action=handle_deleted_media' ),
			'max_file_size' => apply_filters( 'cariera_file_max_size', size_format( wp_max_upload_size() ) ),
			'map_provider'  => cariera_get_option( 'cariera_map_provider' ),
			'strings'       => [
				'delete_account_text' => esc_html__( 'Are you sure you want to delete your account?', 'cariera' ),
			],
		];

		wp_localize_script( 'cariera-core-main', 'cariera_core_settings', $args );

		// WPJM Ajax Filters.
		if ( class_exists( 'WP_Job_Manager' ) && defined( 'JOB_MANAGER_VERSION' ) ) {
			wp_dequeue_script( 'wp-job-manager-ajax-filters' );
			wp_deregister_script( 'wp-job-manager-ajax-filters' );
			wp_register_script( 'wp-job-manager-ajax-filters', CARIERA_URL . '/assets/dist/js/jobs-ajax-filters.js', [ 'jquery', 'jquery-deserialize' ], CARIERA_CORE_VERSION, true );
			wp_localize_script(
				'wp-job-manager-ajax-filters',
				'job_manager_ajax_filters',
				[
					'ajax_url'                => WP_Job_Manager_Ajax::get_endpoint(),
					'is_rtl'                  => is_rtl() ? 1 : 0,
					'i18n_load_prev_listings' => esc_html__( 'Load previous listings', 'cariera' ),
					'currency'                => cariera_currency_symbol(),
				]
			);
		}

		// Resume AJAX Filters.
		if ( class_exists( 'WP_Job_Manager' ) && class_exists( 'WP_Resume_Manager' ) ) {
			wp_dequeue_script( 'wp-resume-manager-ajax-filters' );
			wp_deregister_script( 'wp-resume-manager-ajax-filters' );
			wp_register_script( 'wp-resume-manager-ajax-filters', CARIERA_URL . '/assets/dist/js/resumes-ajax-filters.js', [ 'jquery', 'jquery-deserialize' ], CARIERA_CORE_VERSION, true );
			wp_localize_script(
				'wp-resume-manager-ajax-filters',
				'resume_manager_ajax_filters',
				[
					'ajax_url'    => esc_url( admin_url( 'admin-ajax.php', 'relative' ) ),
					'currency'    => cariera_currency_symbol(),
					'showing_all' => esc_html__( 'Showing all resumes', 'cariera' ),
				]
			);
		}

		// Maps.
		wp_register_script( 'cariera-maps', CARIERA_URL . '/assets/dist/js/maps.js', [ 'jquery' ], CARIERA_CORE_VERSION, true );
		wp_localize_script(
			'cariera-maps',
			'cariera_maps',
			[
				'map_provider'        => cariera_get_option( 'cariera_map_provider' ),
				'autolocation'        => 1 === absint( cariera_get_option( 'cariera_job_location_autocomplete' ) ) ? true : false,
				'country'             => cariera_get_option( 'cariera_map_restriction' ),
				'map_autofit'         => cariera_get_option( 'cariera_map_autofit' ),
				'centerPoint'         => cariera_get_option( 'cariera_map_center' ),
				'mapbox_access_token' => cariera_get_option( 'cariera_mapbox_access_token' ),
				'map_type'            => cariera_get_option( 'cariera_maps_type' ),
			]
		);

		// Backend.
		wp_register_style( 'cariera-core-admin', CARIERA_URL . '/assets/dist/css/admin' . $suffix . '.css', [], CARIERA_CORE_VERSION );
		wp_register_script( 'cariera-core-admin', CARIERA_URL . '/assets/dist/js/admin.js', [], CARIERA_CORE_VERSION, true );
		wp_localize_script(
			'cariera-core-admin',
			'cariera_core_admin',
			[
				'ajax_url'     => esc_url( admin_url( 'admin-ajax.php', 'relative' ) ),
				'map_provider' => cariera_get_option( 'cariera_map_provider' ),
				'strings'      => [
					'delete_messages_notice'      => esc_html__( 'Messages Deleted!', 'cariera' ),
					'delete_notifications_notice' => esc_html__( 'Notifications Deleted!', 'cariera' ),
					'delete_demo_notice'          => esc_html__( 'All demo data have been deleted!', 'cariera' ),
				],
			]
		);

		// reCaptcha.
		wp_register_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js', [], false, true );

		// Blog Elementor Element.
		wp_register_style( 'cariera-blog-element', CARIERA_URL . '/assets/dist/css/blog-element' . $suffix . '.css', [], CARIERA_CORE_VERSION );

		// Pricing Tables.
		wp_register_style( 'cariera-pricing-tables', CARIERA_URL . '/assets/dist/css/pricing-tables' . $suffix . '.css', [], CARIERA_CORE_VERSION );

		// Testimonials.
		wp_register_style( 'cariera-testimonials', CARIERA_URL . '/assets/dist/css/testimonials' . $suffix . '.css', [], CARIERA_CORE_VERSION );

		// Listing Categories.
		wp_register_style( 'cariera-companies-list', CARIERA_URL . '/assets/dist/css/companies-list' . $suffix . '.css', [], CARIERA_CORE_VERSION );

		// Listing Categories.
		wp_register_style( 'cariera-listing-categories', CARIERA_URL . '/assets/dist/css/listing-categories' . $suffix . '.css', [], CARIERA_CORE_VERSION );
	}

	/**
	 * Enqueue Core Plugin assets.
	 *
	 * @since   1.6.3
	 * @version 1.6.6
	 */
	public function enqueue_assets() {
		// Main JS File of the core plugin.
		wp_enqueue_script( 'cariera-core-main' );

		// Map Providers.
		$map_provider  = cariera_get_option( 'cariera_map_provider' );
		$gmap_api_key  = cariera_get_option( 'cariera_gmap_api_key' );
		$gmap_language = cariera_get_option( 'cariera_gmap_language' );

		if ( 'google' === $map_provider && $gmap_api_key ) {
			wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $gmap_api_key . '&amp;libraries=places&language=' . $gmap_language . '&callback=Function.prototype', [ 'jquery' ], false, true );
		}

		// Maps.
		wp_enqueue_script( 'cariera-maps' );
	}

	/**
	 * Backend - Enqueue Core Plugin assets.
	 *
	 * @since   1.6.3
	 * @version 1.6.6
	 */
	public function enqueue_admin_assets() {
		// Main JS File of the core plugin.
		wp_enqueue_style( 'cariera-core-admin' );
		wp_enqueue_script( 'cariera-core-admin' );

		// Map Providers.
		$map_provider  = cariera_get_option( 'cariera_map_provider' );
		$gmap_api_key  = cariera_get_option( 'cariera_gmap_api_key' );
		$gmap_language = cariera_get_option( 'cariera_gmap_language' );

		if ( 'google' === $map_provider && $gmap_api_key ) {
			wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $gmap_api_key . '&amp;libraries=places&language=' . $gmap_language . '&callback=Function.prototype', [ 'jquery' ], false, true );
		}
	}

	/**
	 * Upload Media function for dropzone
	 *
	 * @since 1.4.7
	 */
	public function uploaded_dropzone_media() {
		status_header( 200 );

		$upload_dir  = wp_upload_dir();
		$upload_path = $upload_dir['path'] . DIRECTORY_SEPARATOR;
		// $num_files        = count($_FILES['file']['tmp_name']);

		$newupload = 0;

		if ( ! empty( $_FILES ) ) {
			$files = $_FILES;
			foreach ( $files as $file ) {
				$newfile = [
					'name'     => $file['name'],
					'type'     => $file['type'],
					'tmp_name' => $file['tmp_name'],
					'error'    => $file['error'],
					'size'     => $file['size'],
				];

				$_FILES = [ 'upload' => $newfile ];
				foreach ( $_FILES as $file => $array ) {
					$newupload = media_handle_upload( $file, 0 );
				}
			}
		}

		echo $newupload;
		wp_die();
	}

	/**
	 * Delete Media function for dropzone
	 *
	 * @since 1.4.7
	 */
	public function deleted_dropzone_media() {
		if ( isset( $_REQUEST['media_id'] ) ) {
			$post_id = absint( $_REQUEST['media_id'] );
			$status  = wp_delete_attachment( $post_id, true );
			if ( $status ) {
				echo wp_json_encode( [ 'status' => 'OK' ] );
			} else {
				echo wp_json_encode( [ 'status' => 'FAILED' ] );
			}
		}

		wp_die();
	}

	/**
	 * Admin Notices
	 *
	 * @since 1.4.8
	 */
	public function admin_notices() {
		$wpjm_gmaps_api_key = get_option( 'job_manager_google_maps_api_key' );

		if ( ! empty( $wpjm_gmaps_api_key ) || 'none' === cariera_get_option( 'cariera_map_provider' ) || apply_filters( 'cariera_wpjm_gmaps_hide_notice', false ) ) {
			return;
		}
		?>

		<div class="error notice">
			<p><?php esc_html_e( 'Please add an unrestricted Google Maps API key in the "Job Listings->Settings" in order to be able to geocode your listings and show them in the maps.', 'cariera' ); ?> <a href="https://wpjobmanager.com/document/geolocation-with-googles-maps-api/" target="_blank"><?php esc_html_e( 'Learn More', 'cariera' ); ?></a></p>
		</div>
		<?php
	}

	/**
	 * Add schedule to use for cron job. Should not be called externally.
	 *
	 * @since 1.5.0
	 */
	public function cron_schedules( $schedules ) {
		if ( ! isset( $schedules['5min'] ) ) {
			$schedules['5min'] = [
				'interval' => 5 * 60,
				'display'  => esc_html__( 'Once every 5 minutes', 'cariera' ),
			];
		}

		if ( ! isset( $schedules['30min'] ) ) {
			$schedules['30min'] = [
				'interval' => 30 * 60,
				'display'  => esc_html__( 'Once every 30 minutes', 'cariera' ),
			];
		}

		if ( ! isset( $schedules['monthly'] ) ) {
			$schedules['monthly'] = [
				'interval' => 2635200,
				'display'  => esc_html__( 'Once monthly', 'cariera' ),
			];
		}

		return $schedules;
	}
}
