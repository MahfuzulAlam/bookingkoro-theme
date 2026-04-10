<?php
/**
 * Template part for the homepage recommended vehicles section (distinct design).
 *
 * Expects: $home_data (from bookingkoro_get_home_data()).
 *
 * @package BookingKoro
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}
$home_data = bookingkoro_get_home_data();
$recommended_vehicles = isset( $home_data['recommended_vehicles'] ) && is_array( $home_data['recommended_vehicles'] ) ? $home_data['recommended_vehicles'] : array();
?>

<section id="vehicle" class="bkor-section bkor-section--vehicles" aria-labelledby="bkor-recommended-vehicles-heading">
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
			foreach ( $recommended_vehicles as $item ) {
				$title = isset( $item['title'] ) ? $item['title'] : '';
				$meta  = isset( $item['meta'] ) ? $item['meta'] : '';
				$url   = isset( $item['url'] ) ? $item['url'] : '#';
				?>
				<article class="bkor-vehicle-card">
					<a href="<?php echo esc_url( $url ); ?>" class="bkor-vehicle-card__link">
						<div class="bkor-vehicle-card__img">
							<span class="bkor-vehicle-card__ribbon"><?php esc_html_e( 'Pick', 'bookingkoro' ); ?></span>
							<span class="bkor-vehicle-card__icon" aria-hidden="true"><?php echo bookingkoro_get_icon_svg( 'vehicle' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<span class="bkor-vehicle-card__placeholder"><?php esc_html_e( 'Vehicle', 'bookingkoro' ); ?></span>
						</div>
						<div class="bkor-vehicle-card__body">
							<h3 class="bkor-vehicle-card__title"><?php echo esc_html( $title ); ?></h3>
							<p class="bkor-vehicle-card__meta"><?php echo esc_html( $meta ); ?></p>
						</div>
					</a>
				</article>
			<?php }
			?>
		</div>
	</div>
</section>
