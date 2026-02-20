<?php
/**
 * Template Name: BookingKoro Homepage
 *
 * Homepage for bookingkoro.com. Data from assets/data/home-data.json.
 * Topics: Activity, Event, Service, Stays, Vehicle.
 *
 * @package BookingKoro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$home_data = bookingkoro_get_home_data();

$topic_sections = array(
	'activity' => array(
		'key'   => 'activity_items',
		'label' => __( 'Activity', 'bookingkoro' ),
		'slug'  => 'activity',
	),
	'event'    => array(
		'key'   => 'event_items',
		'label' => __( 'Event', 'bookingkoro' ),
		'slug'  => 'event',
	),
	'service'  => array(
		'key'   => 'service_items',
		'label' => __( 'Service', 'bookingkoro' ),
		'slug'  => 'service',
	),
	'stays'    => array(
		'key'   => 'stays_items',
		'label' => __( 'Stays', 'bookingkoro' ),
		'slug'  => 'stays',
	),
	'vehicle'  => array(
		'key'   => 'vehicle_items',
		'label' => __( 'Vehicle', 'bookingkoro' ),
		'slug'  => 'vehicle',
	),
);
?>

<div class="bookingkoro-home-content">

	<!-- Hero carousel -->
	<section class="bkor-hero" aria-label="<?php esc_attr_e( 'Offers', 'bookingkoro' ); ?>">
		<div class="bkor-hero__track">
			<?php
			if ( ! empty( $home_data['hero_slides'] ) && is_array( $home_data['hero_slides'] ) ) {
				foreach ( $home_data['hero_slides'] as $slide ) {
					$url      = isset( $slide['url'] ) ? $slide['url'] : '#';
					$title    = isset( $slide['title'] ) ? $slide['title'] : '';
					$subtitle = isset( $slide['subtitle'] ) ? $slide['subtitle'] : '';
					?>
					<a href="<?php echo esc_url( $url ); ?>" class="bkor-hero__slide">
						<div class="bkor-hero__content">
							<h2 class="bkor-hero__title"><?php echo esc_html( $title ); ?></h2>
							<?php if ( $subtitle ) : ?>
								<p class="bkor-hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
							<?php endif; ?>
						</div>
						<div class="bkor-hero__illus" aria-hidden="true"></div>
					</a>
				<?php }
			}
			?>
		</div>
		<div class="bkor-hero__dots">
			<button type="button" class="bkor-hero__dot bkor-hero__dot--active" aria-label="<?php esc_attr_e( 'Slide 1', 'bookingkoro' ); ?>"></button>
		</div>
		<button type="button" class="bkor-carousel-arrow bkor-carousel-arrow--prev" aria-label="<?php esc_attr_e( 'Previous', 'bookingkoro' ); ?>"></button>
		<button type="button" class="bkor-carousel-arrow bkor-carousel-arrow--next" aria-label="<?php esc_attr_e( 'Next', 'bookingkoro' ); ?>"></button>
	</section>

	<!-- Stream / Discover banner -->
	<section class="bkor-stream" aria-labelledby="bkor-stream-heading">
		<div class="bkor-container">
			<div class="bkor-stream__inner">
				<h2 id="bkor-stream-heading" class="bkor-stream__logo"><?php echo esc_html( isset( $home_data['stream_heading'] ) ? $home_data['stream_heading'] : __( 'Discover', 'bookingkoro' ) ); ?></h2>
				<p class="bkor-stream__tagline"><?php echo esc_html( isset( $home_data['stream_tagline'] ) ? $home_data['stream_tagline'] : '' ); ?></p>
			</div>
		</div>
		<button type="button" class="bkor-carousel-arrow bkor-carousel-arrow--light bkor-carousel-arrow--prev" aria-label="<?php esc_attr_e( 'Previous', 'bookingkoro' ); ?>"></button>
		<button type="button" class="bkor-carousel-arrow bkor-carousel-arrow--light bkor-carousel-arrow--next" aria-label="<?php esc_attr_e( 'Next', 'bookingkoro' ); ?>"></button>
	</section>

	<!-- Main categories: Activity, Event, Service, Stays, Vehicle -->
	<section class="bkor-section" aria-labelledby="bkor-categories-heading">
		<div class="bkor-container">
			<h2 id="bkor-categories-heading" class="bkor-section-title bkor-section-title--standalone"><?php esc_html_e( 'Explore', 'bookingkoro' ); ?></h2>
			<div class="bkor-live-cats">
				<?php
				if ( ! empty( $home_data['main_categories'] ) && is_array( $home_data['main_categories'] ) ) {
					foreach ( $home_data['main_categories'] as $cat ) {
						$url   = isset( $cat['url'] ) ? $cat['url'] : '#';
						$label = isset( $cat['label'] ) ? $cat['label'] : '';
						$icon  = isset( $cat['icon'] ) ? $cat['icon'] : '';
						?>
						<a href="<?php echo esc_url( $url ); ?>" class="bkor-live-cat">
							<span class="bkor-live-cat__icon bkor-live-cat__icon--<?php echo esc_attr( $icon ); ?>"></span>
							<span class="bkor-live-cat__label"><?php echo esc_html( $label ); ?></span>
						</a>
					<?php }
				}
				?>
			</div>
		</div>
	</section>

	<!-- Recommended Vehicles (distinct design) -->
	<section class="bkor-section bkor-section--vehicles" aria-labelledby="bkor-recommended-vehicles-heading">
		<div class="bkor-container">
			<header class="bkor-section-header bkor-section-header--light">
				<div class="bkor-vehicles-heading-wrap">
					<span class="bkor-vehicles-badge"><?php esc_html_e( 'Recommended', 'bookingkoro' ); ?></span>
					<h2 id="bkor-recommended-vehicles-heading" class="bkor-section-title bkor-section-title--light"><?php esc_html_e( 'Vehicles', 'bookingkoro' ); ?></h2>
				</div>
				<a class="bkor-section-link bkor-section-link--light" href="#vehicle"><?php esc_html_e( 'View All', 'bookingkoro' ); ?></a>
			</header>
			<div class="bkor-vehicles-track">
				<?php
				if ( ! empty( $home_data['recommended_vehicles'] ) && is_array( $home_data['recommended_vehicles'] ) ) {
					foreach ( $home_data['recommended_vehicles'] as $item ) {
						$title = isset( $item['title'] ) ? $item['title'] : '';
						$meta  = isset( $item['meta'] ) ? $item['meta'] : '';
						$url   = isset( $item['url'] ) ? $item['url'] : '#';
						?>
						<article class="bkor-vehicle-card">
							<a href="<?php echo esc_url( $url ); ?>" class="bkor-vehicle-card__link">
								<div class="bkor-vehicle-card__img">
									<span class="bkor-vehicle-card__ribbon"><?php esc_html_e( 'Pick', 'bookingkoro' ); ?></span>
									<span class="bkor-vehicle-card__placeholder"><?php esc_html_e( 'Vehicle', 'bookingkoro' ); ?></span>
								</div>
								<div class="bkor-vehicle-card__body">
									<h3 class="bkor-vehicle-card__title"><?php echo esc_html( $title ); ?></h3>
									<p class="bkor-vehicle-card__meta"><?php echo esc_html( $meta ); ?></p>
								</div>
							</a>
						</article>
					<?php }
				}
				?>
			</div>
		</div>
	</section>

	<?php
	foreach ( $topic_sections as $topic => $config ) {
		$items = isset( $home_data[ $config['key'] ] ) && is_array( $home_data[ $config['key'] ] ) ? $home_data[ $config['key'] ] : array();
		$heading_id = 'bkor-' . $config['slug'] . '-heading';
		?>
	<section class="bkor-section" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
		<div class="bkor-container">
			<header class="bkor-section-header">
				<h2 id="<?php echo esc_attr( $heading_id ); ?>" class="bkor-section-title"><?php echo esc_html( $config['label'] ); ?></h2>
				<a class="bkor-section-link" href="#<?php echo esc_attr( $config['slug'] ); ?>"><?php esc_html_e( 'View All', 'bookingkoro' ); ?></a>
			</header>
			<div class="bkor-cards bkor-cards--scroll">
				<?php
				foreach ( $items as $item ) {
					$title = isset( $item['title'] ) ? $item['title'] : '';
					$meta  = isset( $item['meta'] ) ? $item['meta'] : '';
					$url   = isset( $item['url'] ) ? $item['url'] : '#';
					?>
					<article class="bkor-card">
						<a href="<?php echo esc_url( $url ); ?>" class="bkor-card__link">
							<div class="bkor-card__img">
								<span class="bkor-card__placeholder"><?php echo esc_html( $config['label'] ); ?></span>
							</div>
							<div class="bkor-card__body">
								<h3 class="bkor-card__title"><?php echo esc_html( $title ); ?></h3>
								<p class="bkor-card__meta"><?php echo esc_html( $meta ); ?></p>
							</div>
						</a>
					</article>
				<?php }
				?>
			</div>
		</div>
	</section>
	<?php } ?>

	<?php
	$how = isset( $home_data['how_it_works'] ) && is_array( $home_data['how_it_works'] ) ? $home_data['how_it_works'] : array();
	$steps = isset( $how['steps'] ) && is_array( $how['steps'] ) ? $how['steps'] : array();
	if ( ! empty( $steps ) ) :
		$how_title    = isset( $how['title'] ) ? $how['title'] : __( 'How it works', 'bookingkoro' );
		$how_subtitle = isset( $how['subtitle'] ) ? $how['subtitle'] : '';
		?>
	<!-- How it works -->
	<section class="bkor-section bkor-how" aria-labelledby="bkor-how-heading">
		<div class="bkor-container">
			<h2 id="bkor-how-heading" class="bkor-section-title bkor-section-title--standalone"><?php echo esc_html( $how_title ); ?></h2>
			<?php if ( $how_subtitle ) : ?>
				<p class="bkor-how__subtitle"><?php echo esc_html( $how_subtitle ); ?></p>
			<?php endif; ?>
			<div class="bkor-how__steps">
				<?php
				foreach ( $steps as $i => $step ) {
					$step_title = isset( $step['title'] ) ? $step['title'] : '';
					$step_desc  = isset( $step['description'] ) ? $step['description'] : '';
					$num        = $i + 1;
					?>
					<div class="bkor-how__step">
						<span class="bkor-how__num" aria-hidden="true"><?php echo esc_html( (string) $num ); ?></span>
						<h3 class="bkor-how__step-title"><?php echo esc_html( $step_title ); ?></h3>
						<p class="bkor-how__step-desc"><?php echo esc_html( $step_desc ); ?></p>
					</div>
				<?php }
				?>
			</div>
		</div>
	</section>
	<?php endif; ?>

</div>

<?php
get_footer();
