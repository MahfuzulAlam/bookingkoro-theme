<?php
/**
 * Template part for the homepage hero carousel.
 *
 * Expects: $home_data (from bookingkoro_get_home_data()).
 *
 * @package BookingKoro
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}
$home_data = bookingkoro_get_home_data();
$hero_slides = isset( $home_data['hero_slides'] ) && is_array( $home_data['hero_slides'] ) ? $home_data['hero_slides'] : array();
?>

<section class="bkor-hero" aria-label="<?php esc_attr_e( 'Offers', 'bookingkoro' ); ?>">
	<div class="bkor-hero__track">
		<?php
		foreach ( $hero_slides as $slide ) {
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
		?>
	</div>
	<div class="bkor-hero__dots">
		<button type="button" class="bkor-hero__dot bkor-hero__dot--active" aria-label="<?php esc_attr_e( 'Slide 1', 'bookingkoro' ); ?>"></button>
	</div>
	<button type="button" class="bkor-carousel-arrow bkor-carousel-arrow--prev" aria-label="<?php esc_attr_e( 'Previous', 'bookingkoro' ); ?>"></button>
	<button type="button" class="bkor-carousel-arrow bkor-carousel-arrow--next" aria-label="<?php esc_attr_e( 'Next', 'bookingkoro' ); ?>"></button>
</section>
