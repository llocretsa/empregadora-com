<?php
/**
 * ELEMENTOR WIDGET - RESUME SLIDER
 *
 * @since    1.4.0
 * @version  1.6.6
 **/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Cariera_Resume_Slider extends Widget_Base {

	/**
	 * Get widget's name.
	 */
	public function get_name() {
		return 'resume_slider';
	}

	/**
	 * Get widget's title.
	 */
	public function get_title() {
		return esc_html__( 'Resume Slider', 'cariera' );
	}

	/**
	 * Get widget's icon.
	 */
	public function get_icon() {
		return 'eicon-post-slider';
	}

	/**
	 * Get widget's categories.
	 */
	public function get_categories() {
		return [ 'cariera-elements' ];
	}

	/**
	 * Register the controls for the widget
	 */
	protected function register_controls() {

		// SECTION.
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'cariera' ),
			]
		);

		// CONTROLS.
		$this->add_control(
			'version',
			[
				'label'       => esc_html__( 'Layout Version', 'cariera' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'1' => esc_html__( 'Version 1', 'cariera' ),
					'2' => esc_html__( 'Version 2', 'cariera' ),
				],
				'default'     => '1',
				'description' => '',
			]
		);
		$this->add_control(
			'per_page',
			[
				'label'       => esc_html__( 'Total Resumes', 'cariera' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => esc_html__( 'Leave it blank to display all featured resumes.', 'cariera' ),
			]
		);
		$this->add_control(
			'columns',
			[
				'label'       => esc_html__( 'Visible Resumes', 'cariera' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '1',
				'min'         => '1',
				'max'         => '10',
				'description' => esc_html__( 'This will change how many resumes will be visible per slide.', 'cariera' ),
			]
		);
		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__( 'Autoplay', 'cariera' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'cariera' ),
				'label_off'    => esc_html__( 'Disable', 'cariera' ),
				'return_value' => 'enable',
				'default'      => '',
			]
		);
		$this->add_control(
			'orderby',
			[
				'label'       => esc_html__( 'Order by', 'cariera' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'featured' => esc_html__( 'Featured', 'cariera' ),
					'date'     => esc_html__( 'Date', 'cariera' ),
					'ID'       => esc_html__( 'ID', 'cariera' ),
					'author'   => esc_html__( 'Author', 'cariera' ),
					'title'    => esc_html__( 'Title', 'cariera' ),
					'modified' => esc_html__( 'Modified', 'cariera' ),
					'rand'     => esc_html__( 'Random Order', 'cariera' ),
				],
				'default'     => 'featured',
				'description' => '',
			]
		);
		$this->add_control(
			'order',
			[
				'label'       => esc_html__( 'Order', 'cariera' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'DESC' => esc_html__( 'Descending', 'cariera' ),
					'ASC'  => esc_html__( 'Ascending', 'cariera' ),
				],
				'default'     => 'DESC',
				'description' => '',
			]
		);
		$this->add_control(
			'featured',
			[
				'label'       => esc_html__( 'Featured', 'cariera' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'true'  => esc_html__( 'Show only featured', 'cariera' ),
					'false' => esc_html__( 'Hide featured', 'cariera' ),
					'null'  => esc_html__( 'Show all', 'cariera' ),
				],
				'default'     => 'null',
				'description' => '',
			]
		);
		$this->add_control(
			'custom_class',
			[
				'label'       => esc_html__( 'Custom Class', 'cariera' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Get Style Dependency
	 *
	 * @since 1.7.0
	 */
	public function get_style_depends() {
		return [ 'cariera-resume-listings' ];
	}

	/**
	 * Widget output
	 */
	protected function render() {
		if ( ! class_exists( 'WP_Job_Manager' ) || ! class_exists( 'WP_Resume_Manager' ) ) {
			return;
		}

		wp_enqueue_style( 'cariera-resume-listings' );

		$settings = $this->get_settings();

		if ( 'null' !== $settings['featured'] ) {
			$featured = ( is_bool( $settings['featured'] ) && $settings['featured'] ) || in_array( $settings['featured'], [ '1', 'true', 'yes' ], true ) ? true : false;
		} else {
			$featured = null;
		}

		$resumes = get_resumes(
			[
				'orderby'        => $settings['orderby'],
				'order'          => $settings['order'],
				'posts_per_page' => $settings['per_page'],
				'featured'       => $featured,
			]
		);

		if ( 'enable' === $settings['autoplay'] ) {
			$autoplay = '1';
		} else {
			$autoplay = '0';
		}

		if ( $resumes->have_posts() ) { ?>
			<div class="resume-carousel resume-carousel-<?php echo esc_attr( $settings['version'] ) . ' ' . esc_attr( $settings['custom_class'] ); ?>" data-columns="<?php echo esc_attr( $settings['columns'] ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">

				<?php
				while ( $resumes->have_posts() ) :
					$resumes->the_post();
					$id = get_the_id();
					?>
					<div class="single-resume">
						<a href="<?php the_resume_permalink(); ?>" class="resume-link">

							<!-- Candidate Photo -->
							<div class="candidate-photo-wrapper">
								<div class="candidate-photo">
								<?php cariera_the_candidate_photo(); ?>
								</div>
							</div>

							<?php if ( '1' === $settings['version'] ) { ?>
								<div class="candidate-title">
									<h5><?php the_title(); ?></h5>
								</div>

								<div class="candidate-info">
									<span class="occupation">
										<i class="icon-bulb"></i>
										<?php the_candidate_title(); ?>
									</span> 

									<span class="location">
										<i class="icon-location-pin"></i>
										<?php the_candidate_location( false ); ?>
									</span>
								</div>
							<?php } ?>

						</a>
					</div>
				<?php endwhile; ?>
			</div>
			<?php
		}

		wp_reset_postdata();
	}
}
