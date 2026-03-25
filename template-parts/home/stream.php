<?php
/**
 * Template part for the homepage stream / discover banner.
 *
 * Expects: $home_data (from bookingkoro_get_home_data()).
 *
 * @package BookingKoro
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}
$home_data = bookingkoro_get_home_data();
$stream_heading  = isset( $home_data['stream_heading'] ) ? $home_data['stream_heading'] : __( 'Discover', 'bookingkoro' );
$stream_tagline  = isset( $home_data['stream_tagline'] ) ? $home_data['stream_tagline'] : '';
?>

<section class="bkor-stream" aria-labelledby="bkor-stream-heading">
	<div class="bkor-container">
		<div class="bkor-stream__inner">
			<h2 id="bkor-stream-heading" class="bkor-stream__logo"><?php echo esc_html( $stream_heading ); ?></h2>
			<p class="bkor-stream__tagline"><?php echo esc_html( $stream_tagline ); ?></p>
		</div>
	</div>
	<button type="button" class="bkor-carousel-arrow bkor-carousel-arrow--light bkor-carousel-arrow--prev" aria-label="<?php esc_attr_e( 'Previous', 'bookingkoro' ); ?>"></button>
	<button type="button" class="bkor-carousel-arrow bkor-carousel-arrow--light bkor-carousel-arrow--next" aria-label="<?php esc_attr_e( 'Next', 'bookingkoro' ); ?>"></button>
</section>
