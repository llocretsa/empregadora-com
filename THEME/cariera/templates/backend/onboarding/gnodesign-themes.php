<?php
/**
 * Onboarding: Gnodesign Themes
 *
 * This template can be overridden by copying it to cariera-child/templates/backend/onboarding/gnodesign-themes.php.
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

<div id="themes" class="content-page">
	<h2 class="title"><?php esc_html_e( 'More Quality Themes', 'cariera' ); ?>
		<a href="https://1.envato.market/MOKEn" class="title-btn envato" target="_blank"><?php echo esc_html( 'Envato Portfolio' ); ?></a> 
	</h2>

	<div class="onboarding-products">
		<!-- Product Item -->
		<div class="product-item">
			<a href="https://1.envato.market/k72Rn" target="_blank">
				<div class="theme-img" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/themes/autohub.jpg' ); ?>');">
					<div class="price"><?php echo esc_html( '69$' ); ?></div>
				</div>
				<div class="title"><?php echo esc_html( 'Autohub - Automotive Directory Theme' ); ?></div>
			</a>
		</div>

		<!-- Product Item -->
		<div class="product-item">
			<a href="https://1.envato.market/qqMaL" target="_blank">
				<div class="theme-img" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/themes/cocoon.jpg' ); ?>');">
					<div class="price"><?php echo esc_html( '59$' ); ?></div>
				</div>
				<div class="title"><?php echo esc_html( 'Cocoon - WooCommerce WordPress Theme' ); ?></div>
			</a>
		</div>
	</div>
</div>
