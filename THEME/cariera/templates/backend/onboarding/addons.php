<?php
/**
 * Onboarding: Compatible Plugins
 *
 * This template can be overridden by copying it to cariera-child/templates/backend/onboarding/addons.php.
 *
 * @package     cariera
 * @category    Template
 * @since       1.7.0
 * @version     1.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div id="addons" class="content-page">
	<h2 class="title"><?php esc_html_e( 'Fully Compatible Third Party Plugins', 'cariera' ); ?></h2>
	<div class="onboarding-notice success">
		<p><?php esc_html_e( 'Please contact the author of the plugins regarding any presale or support related questions.', 'cariera' ); ?></p>
		<p><strong><?php echo esc_html( '-5% Coupon for all sMyles products & licenses:' ); ?></strong><span class="coupon-code"><?php echo esc_html( '4carieratheme' ); ?></span></p>
	</div>

	<div class="onboarding-products">
		<!-- Product Item -->
		<div class="product-item">
			<a href="https://plugins.smyl.es/wp-job-manager-search-and-filtering" target="_blank">
				<div class="theme-img" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/plugins/wpjm-sf.jpg' ); ?>');"></div>
				<div class="title"><?php echo esc_html( 'S&F for WPJM' ); ?></div>
			</a>
		</div>

		<!-- Product Item -->
		<div class="product-item">
			<a href="https://plugins.smyl.es/wp-job-manager-field-editor/" target="_blank">
				<div class="theme-img" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/plugins/wpjm-field-editor.jpg' ); ?>');"></div>
				<div class="title"><?php echo esc_html( 'WPJM Field Editor' ); ?></div>
			</a>
		</div>

		<!-- Product Item -->
		<div class="product-item">
			<a href="https://plugins.smyl.es/wp-job-manager-packages/" target="_blank">
				<div class="theme-img" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/plugins/wpjm-packages.jpg' ); ?>');"></div>
				<div class="title"><?php echo esc_html( 'WPJM Packages' ); ?></div>
			</a>
		</div>

		<!-- Product Item -->
		<div class="product-item">
			<a href="https://plugins.smyl.es/wp-job-manager-resume-alerts/" target="_blank">
				<div class="theme-img" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/plugins/wpjm-resume-alerts.jpg' ); ?>');"></div>
				<div class="title"><?php echo esc_html( 'Resume Alerts for WPJM' ); ?></div>
			</a>
		</div>

		<!-- Product Item -->
		<div class="product-item">
			<a href="https://plugins.smyl.es/wp-job-manager-visibility/" target="_blank">
				<div class="theme-img" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/plugins/wpjm-visibility.jpg' ); ?>');"></div>
				<div class="title"><?php echo esc_html( 'WPJM Visibility' ); ?></div>
			</a>
		</div>

		<!-- Product Item -->
		<div class="product-item">
			<a href="https://plugins.smyl.es/wp-job-manager-emails/" target="_blank">
				<div class="theme-img" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/plugins/wpjm-emails.jpg' ); ?>');"></div>
				<div class="title"><?php echo esc_html( 'WPJM Emails' ); ?></div>
			</a>
		</div>

		<!-- Product Item -->
		<div class="product-item">
			<a href="https://1.envato.market/Linkedin-wpjm" target="_blank">
				<div class="theme-img" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/plugins/wpjm-linkedin.jpg' ); ?>');"></div>
				<div class="title"><?php echo esc_html( 'LinkedIn for WPJM' ); ?></div>
			</a>
		</div>

		<!-- Product Item -->
		<div class="product-item">
			<a href="https://1.envato.market/wpjm-essentials" target="_blank">
				<div class="theme-img" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/plugins/wpjm-essentials.jpg' ); ?>');"></div>
				<div class="title"><?php echo esc_html( 'Essentials for WPJM' ); ?></div>
			</a>
		</div>
	</div>
</div>
