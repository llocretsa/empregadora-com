<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Job Search form shortcode
 *
 * @since   1.4.5
 * @version 1.5.4
 */
if ( ! function_exists( 'cariera_job_search_form' ) ) {
	function cariera_job_search_form( $atts, $content = null ) {
		extract(
			shortcode_atts(
				[
					'search_style' => 'stlye-1',
					'location'     => '',
					'region'       => '',
					'categories'   => '',
				],
				$atts
			)
		);

		// Location field.
		if ( ! empty( $location ) ) {
			$location = '<div class="search-location"><input type="text" id="search_location" name="search_location" placeholder="' . esc_html__( 'Location', 'cariera' ) . '"><div class="geolocation"><i class="geolocate"></i></div></div>';
		}

		// Regions Field.
		if ( class_exists( 'Astoundify_Job_Manager_Regions' ) ) {
			if ( ! empty( $region ) ) {

				ob_start(); ?>

					<div class="search-region">
						<?php
						wp_dropdown_categories(
							apply_filters(
								'job_manager_regions_dropdown_args',
								[
									'show_option_all' => esc_html__( 'All Regions', 'cariera' ),
									'hierarchical'    => true,
									'orderby'         => 'name',
									'taxonomy'        => 'job_listing_region',
									'name'            => 'search_region',
									'class'           => 'search_region',
									'hide_empty'      => 0,
									'selected'        => isset( $atts['selected_region'] ) ? $atts['selected_region'] : '',
								]
							)
						);
						?>
					</div>

				<?php
				$region = ob_get_clean();
			}
		} else {
			$region = '';
		}

		// Categories dropdown.
		if ( ! empty( $categories ) ) {
			ob_start();
			?>

				<div class="search-categories">                    
					<?php
					cariera_job_manager_dropdown_category(
						[
							'taxonomy'        => 'job_listing_category',
							'hierarchical'    => 1,
							'name'            => 'search_category',
							'id'              => 'search_category',
							'orderby'         => 'name',
							'selected'        => '',
							'multiple'        => false,
							'show_option_all' => true,
						]
					);
					?>
				</div>

			<?php
			$categories = ob_get_clean();
		}

		$search_result = '<div class="search-results"><div class="search-loader"><span></span></div><div class="job-listings cariera-scroll"></div></div>';

		// Form.
		$output = '<form method="GET" action="' . esc_url( get_permalink( get_option( 'job_manager_jobs_page_id' ) ) ) . '" class="job-search-form ' . esc_attr( $search_style ) . '">
			<div class="search-keywords"><input type="text" id="search_keywords" name="search_keywords" placeholder="' . esc_html__( 'Keywords', 'cariera' ) . '" autocomplete="off">' . $search_result . '</div>' . $location . $region . $categories . '<div class="search-submit"><input type="submit" class="btn btn-main btn-effect" value="' . esc_html__( 'Search', 'cariera' ) . '"></div>
		</form>';

		return $output;
	}
}

add_shortcode( 'cariera_job_search_form', 'cariera_job_search_form' );

/**
 * List all the bought packages of a user
 *
 * @since  1.5.4
 */
function cariera_core_user_packages() {

	if ( ! class_exists( 'WP_Job_Manager' ) || ! class_exists( 'WooCommerce' ) || ! class_exists( 'WC_Paid_Listings' ) ) {
		return;
	}

	$template_loader = new Cariera_Core_Template_Loader();

	if ( ! is_user_logged_in() ) {
		?>
		<p class="job-manager-message generic">
			<?php esc_html_e( 'You need to be signed in to access this page.', 'cariera' ); ?>
		</p>
		<?php
	} else {
		$template_loader->get_template_part( 'account/user-packages' );
	}
}

add_shortcode( 'cariera_user_packages', 'cariera_core_user_packages' );

/**
 * Job Sidebar Search
 *
 * @since  1.5.5
 * @version 1.6.3
 */
function cariera_job_sidebar_search() {
	wp_enqueue_script( 'wp-job-manager-ajax-filters' );
	?>

	<form class="job_filters">
		<div class="search_jobs">

			<div class="search_keywords">
				<?php
				if ( ! empty( $_GET['search_keywords'] ) ) {
					$keywords = sanitize_text_field( wp_unslash( $_GET['search_keywords'] ) );
				} else {
					$keywords = '';
				}
				?>
				<label for="search_keywords"><?php esc_html_e( 'Keywords', 'cariera' ); ?></label>
				<input type="text" name="search_keywords" id="search_keywords" placeholder="<?php esc_attr_e( 'Keywords', 'cariera' ); ?>" value="<?php echo esc_attr( $keywords ); ?>" />
			</div>


			<div class="search_location">
				<?php
				if ( ! empty( $_GET['search_location'] ) ) {
					$location = sanitize_text_field( wp_unslash( $_GET['search_location'] ) );
				} else {
					$location = '';
				}
				?>
				<label for="search_location"><?php esc_html_e( 'Location', 'cariera' ); ?></label>
				<input type="text" name="search_location" id="search_location" placeholder="<?php esc_attr_e( 'Location', 'cariera' ); ?>" value="<?php echo esc_attr( $location ); ?>" />
				<div class="geolocation"><i class="geolocate"></i></div>
			</div>

			<?php if ( apply_filters( 'job_manager_job_filters_show_remote_position', get_option( 'job_manager_enable_remote_position', true ) ) ) : ?>
				<div class="search_remote_position checkbox">
					<input type="checkbox" class="input-checkbox" name="remote_position" id="remote_position" placeholder="<?php esc_attr_e( 'Location', 'cariera' ); ?>" value="1" <?php checked( ! empty( $remote_position ) ); ?> />
					<label for="remote_position" id="remote_position_label"><?php esc_html_e( 'Remote positions only', 'cariera' ); ?></label>
				</div>
			<?php endif; ?>

			<?php do_action( 'cariera_wpjm_job_filters_search_radius' ); ?>

			<?php
			if ( ! is_tax( 'job_listing_category' ) && get_terms( [ 'taxonomy' => 'job_listing_category' ] ) ) {
				$show_category_multiselect = get_option( 'job_manager_enable_default_category_multiselect', false );

				if ( ! empty( $_GET['search_category'] ) ) {
					$selected_category = sanitize_text_field( wp_unslash( $_GET['search_category'] ) );
				} else {
					$selected_category = '';
				}
				?>

				<div class="search_categories">
					<label for="search_categories"><?php esc_html_e( 'Category', 'cariera' ); ?></label>
					<?php if ( $show_category_multiselect ) : ?>
						<?php
						job_manager_dropdown_categories(
							[
								'taxonomy'     => 'job_listing_category',
								'hierarchical' => 1,
								'name'         => 'search_categories',
								'orderby'      => 'name',
								'selected'     => $selected_category,
								'hide_empty'   => false,
								'show_count'   => 0,
								'class'        => 'cariera-select2-search',
							]
						);
						?>
					<?php else : ?>
						<?php
						job_manager_dropdown_categories(
							[
								'taxonomy'        => 'job_listing_category',
								'hierarchical'    => 1,
								'show_option_all' => esc_html__( 'Any category', 'cariera' ),
								'name'            => 'search_categories',
								'orderby'         => 'name',
								'selected'        => $selected_category,
								'multiple'        => false,
								'hide_empty'      => false,
								'show_count'      => 0,
								'class'           => 'cariera-select2-search',
							]
						);
						?>
					<?php endif; ?>
				</div>
			<?php } ?>

			<?php do_action( 'cariera_wpjm_sidebar_job_filters_search_jobs_end' ); ?>

			<?php if ( get_option( 'job_manager_enable_types' ) ) { ?>
				<div class="search-job-types">
					<?php if ( ! is_tax( 'job_listing_type' ) ) { ?>
						<label><?php esc_html_e( 'Job Type', 'cariera' ); ?></label>
						<?php
					}

					$selected_job_types = implode( ',', array_values( get_job_listing_types( 'id=>slug' ) ) );

					get_job_manager_template(
						'job-filter-job-types.php',
						[
							'job_types'          => '',
							'atts'               => '',
							'selected_job_types' => is_array( $selected_job_types ) ? $selected_job_types : array_filter( array_map( 'trim', explode( ',', $selected_job_types ) ) ),
						]
					);
				?>
				</div>
			<?php } ?>

		</div>

		<div class="showing_jobs"></div>
	</form>
	<?php
}

add_shortcode( 'cariera_job_sidebar_search', 'cariera_job_sidebar_search' );

/**
 * Resume Sidebar Search
 *
 * @since   1.5.5
 * @version 1.6.2
 */
function cariera_resume_sidebar_search() {
	wp_enqueue_script( 'wp-resume-manager-ajax-filters' );
	?>

	<form class="resume_filters">
		<div class="search_resumes">

			<div class="search_keywords resume-filter">
				<?php
				if ( ! empty( $_GET['search_keywords'] ) ) {
					$keywords = sanitize_text_field( wp_unslash( $_GET['search_keywords'] ) );
				} else {
					$keywords = '';
				}
				?>
				<label for="search_keywords"><?php esc_html_e( 'Keywords', 'cariera' ); ?></label>
				<input type="text" name="search_keywords" id="search_keywords" placeholder="<?php esc_attr_e( 'All Resumes', 'cariera' ); ?>" value="<?php echo esc_attr( $keywords ); ?>" />
			</div>

			<div class="search_location resume-filter">
				<?php
				if ( ! empty( $_GET['search_location'] ) ) {
					$location = sanitize_text_field( wp_unslash( $_GET['search_location'] ) );
				} else {
					$location = '';
				}
				?>
				<label for="search_location"><?php esc_html_e( 'Location', 'cariera' ); ?></label>
				<input type="text" name="search_location" id="search_location" placeholder="<?php esc_attr_e( 'Any Location', 'cariera' ); ?>" value="<?php echo esc_attr( $location ); ?>" />
				<div class="geolocation"><i class="geolocate"></i></div>
			</div>

			<?php do_action( 'cariera_wprm_job_filters_search_radius' ); ?>

			<?php
			if ( get_option( 'resume_manager_enable_categories' ) && ! is_tax( 'resumes_category' ) && get_terms( [ 'taxonomy' => 'resumes_category' ] ) ) {
				$show_category_multiselect = get_option( 'resume_manager_enable_default_category_multiselect', false );

				if ( ! empty( $_GET['search_category'] ) ) {
					$selected_category = sanitize_text_field( wp_unslash( $_GET['search_category'] ) );
				} else {
					$selected_category = '';
				}
				?>

				<div class="search_categories resume-filter">
					<label for="search_categories"><?php esc_html_e( 'Category', 'cariera' ); ?></label>
					<?php if ( $show_category_multiselect ) : ?>
						<?php
						job_manager_dropdown_categories(
							[
								'taxonomy'     => 'resume_category',
								'hierarchical' => 1,
								'name'         => 'search_categories',
								'orderby'      => 'name',
								'selected'     => $selected_category,
								'hide_empty'   => false,
							]
						);
						?>
					<?php else : ?>
						<?php
						job_manager_dropdown_categories(
							[
								'taxonomy'        => 'resume_category',
								'hierarchical'    => 1,
								'show_option_all' => esc_html__( 'Any category', 'cariera' ),
								'name'            => 'search_categories',
								'class'           => 'cariera-select2-search',
								'orderby'         => 'name',
								'selected'        => $selected_category,
								'hide_empty'      => false,
								'multiple'        => false,
							]
						);
						?>
					<?php endif; ?>
				</div>
				<?php
			}

			do_action( 'cariera_wprm_sidebar_job_filters_search_jobs_end' );
			?>
		</div>

		<div class="showing_resumes"></div>
	</form>
	<?php
}

add_shortcode( 'cariera_resume_sidebar_search', 'cariera_resume_sidebar_search' );

/**
 * Company Sidebar Search
 *
 * @since  1.5.5
 * @version 1.6.2
 */
function cariera_company_sidebar_search() {
	wp_enqueue_script( 'company-ajax-filters' );
	?>

	<form class="company_filters">
		<div class="search_companies">

			<div class="search_keywords">
				<?php
				if ( ! empty( $_GET['search_keywords'] ) ) {
					$keywords = sanitize_text_field( wp_unslash( $_GET['search_keywords'] ) );
				} else {
					$keywords = '';
				}
				?>
				<label for="search_keywords"><?php esc_html_e( 'Keywords', 'cariera' ); ?></label>
				<input type="text" name="search_keywords" id="search_keywords" placeholder="<?php esc_attr_e( 'Keywords', 'cariera' ); ?>" value="<?php echo esc_attr( $keywords ); ?>" />
			</div>

			<div class="search_location">
				<?php
				if ( ! empty( $_GET['search_location'] ) ) {
					$location = sanitize_text_field( wp_unslash( $_GET['search_location'] ) );
				} else {
					$location = '';
				}
				?>
				<label for="search_location"><?php esc_html_e( 'Location', 'cariera' ); ?></label>
				<input type="text" name="search_location" id="search_location" placeholder="<?php esc_attr_e( 'Location', 'cariera' ); ?>" value="<?php echo esc_attr( $location ); ?>" />
				<div class="geolocation"><i class="geolocate"></i></div>
			</div>

			<?php if ( get_option( 'cariera_company_category' ) ) { ?>
				<div class="search_categories">
					<label for="search_categories"><?php echo esc_html__( 'Categories', 'cariera' ); ?></label>

					<?php
					if ( ! empty( $_GET['search_category'] ) ) {
						$selected_category = sanitize_text_field( wp_unslash( $_GET['search_category'] ) );
					} else {
						$selected_category = '';
					}

					job_manager_dropdown_categories(
						[
							'taxonomy'        => 'company_category',
							'hierarchical'    => 1,
							'show_option_all' => esc_html__( 'Any category', 'cariera' ),
							'name'            => 'search_categories',
							'class'           => 'cariera-select2-search',
							'orderby'         => 'name',
							'selected'        => $selected_category,
							'hide_empty'      => false,
							'multiple'        => false,
						]
					);
					?>
				</div>
			<?php } ?>
		</div>

		<div class="showing_companies"></div>
	</form>
	<?php
}

add_shortcode( 'cariera_company_sidebar_search', 'cariera_company_sidebar_search' );
