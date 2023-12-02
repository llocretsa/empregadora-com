<?php
/**
 * Plugin Name: Cariera Core
 * Plugin URI:  https://themeforest.net/item/cariera-job-board-wordpress-theme/20167356
 * Description: This is the Core plugin of Cariera Theme.
 * Version:     1.7.1
 * Author:      Gnodesign
 * Author URI:  https://themeforest.net/user/gnodesign
 * Text Domain: cariera
 * Domain Path: /lang
 **/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Cariera_Plugin {

	/**
	 * The single instance of the class.
	 *
	 * @var Cariera_Plugin
	 */
	private static $instance = null;

	/**
	 * Plugin version
	 */
	public $version = '1.7.1';

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @since  1.5.5
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
	 * @since 1.5.5
	 */
	public function __construct() {
		// Define Constants.
		$this->define_constants();

		// Require needed files.
		require_once CARIERA_PATH . '/inc/install.php';
		require_once CARIERA_PATH . '/inc/class-cariera-core.php';
		require CARIERA_PATH . '/inc/core/promotions/promotions.php';

		// Cariera Core Global.
		// TODO: This might need to be deleted.
		$GLOBALS['cariera_core'] = self::cariera_core();

		// Main Actions.
		add_action( 'plugins_loaded', [ $this, 'init_plugin' ], 10 );
		add_action( 'plugins_loaded', [ $this, 'include_files' ], 11 );
	}

	/**
	 * Define the constants
	 *
	 * @since 1.5.5
	 */
	public function define_constants() {
		define( 'CARIERA_CORE', __FILE__ );
		define( 'CARIERA_CORE_VERSION', $this->version );
		define( 'CARIERA_URL', plugins_url( '', __FILE__ ) );
		define( 'CARIERA_PATH', __DIR__ );
		define( 'CARIERA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'CARIERA_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
	}

	/**
	 * Initializes plugin.
	 *
	 * @since 1.5.5
	 */
	public function init_plugin() {
		add_action( 'init', [ $this, 'localization_init' ] );
		add_action( 'init', [ $this, 'image_sizes' ] );
	}

	/**
	 * Loading Text Domain file for translations
	 *
	 * @since  1.5.5
	 */
	public function localization_init() {
		load_plugin_textdomain( 'cariera', false, basename( __DIR__ ) . '/lang' );
	}

	/**
	 * Adds image sizes
	 *
	 * @since   1.5.5
	 */
	public function image_sizes() {
		add_image_size( 'cariera-avatar', 500, 500, true );
	}

	/**
	 * Including Plugin Functions
	 *
	 * @since  1.5.5
	 */
	public function include_files() {
		include_once CARIERA_PATH . '/inc/functions.php';
		include_once CARIERA_PATH . '/inc/elementor.php';
		include_once CARIERA_PATH . '/inc/shortcodes.php';

		// Importer.
		include_once CARIERA_PATH . '/inc/importer/core.php';
		include_once CARIERA_PATH . '/inc/importer/importer/cariera-importer.php';
		include_once CARIERA_PATH . '/inc/importer/init.php';

		// Extensions.
		include_once CARIERA_PATH . '/inc/extensions/recaptcha/recaptcha.php';
		include_once CARIERA_PATH . '/inc/extensions/social-share/social.php';
		include_once CARIERA_PATH . '/inc/extensions/testimonials/testimonials.php';
		include_once CARIERA_PATH . '/inc/extensions/dashboard/reports.php';
		include_once CARIERA_PATH . '/inc/extensions/dashboard/views.php';

		// Core Templates.
		if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
			include_once CARIERA_PATH . '/inc/lib/class-gamajo-template-loader.php';
		}
		include_once CARIERA_PATH . '/inc/template-loader.php';

		// Main WPJM related.
		if ( class_exists( 'WP_Job_Manager' ) ) {
			include_once CARIERA_PATH . '/inc/core/wp-job-manager/jobs.php';
			include_once CARIERA_PATH . '/inc/core/wp-job-manager/wp-job-manager-colors.php';
			include_once CARIERA_PATH . '/inc/core/wp-job-manager/wp-job-manager-maps.php';
			include_once CARIERA_PATH . '/inc/core/wp-job-manager/wp-job-manager-writepanels.php';

			// Cariera Company Manager.
			include_once CARIERA_PATH . '/inc/core/wp-company-manager/company-manager.php';

			// Resume Manager.
			if ( class_exists( 'WP_Resume_Manager' ) ) {
				include_once CARIERA_PATH . '/inc/core/wp-resume-manager/resumes.php';
			}
		}
	}

	/**
	 * Assigning Cariera Core class to a global var
	 *
	 * @since 1.4.3
	 */
	public static function cariera_core() {
		// TODO: This might need to be deleted. The whole function.
		return Cariera_Core::instance();
	}
}

/**
 * Get theme status if activated or not
 *
 * @since   1.5.5
 * @version 1.7.0
 */
function cariera_core_theme_status() {
	if ( ! class_exists( '\Cariera\Onboarding\Onboarding' ) ) {
		return;
	}

	$status = \Cariera\Onboarding\Onboarding::activation_status();

	return $status;
}

/**
 * Function to run the plugin.
 *
 * @since 1.5.5
 */
function cariera_plugin() {
	return Cariera_Plugin::instance();
}

cariera_plugin();
