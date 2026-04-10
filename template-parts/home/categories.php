<?php
/**
 * Template part for the homepage main categories (Explore: Activity, Event, Service, Stays, Vehicle).
 *
 * Expects: $home_data (from bookingkoro_get_home_data()).
 *
 * @package BookingKoro
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}
$home_data = bookingkoro_get_home_data();
$main_categories = isset( $home_data['main_categories'] ) && is_array( $home_data['main_categories'] ) ? $home_data['main_categories'] : array();
?>

<section id="offers" class="bkor-section" aria-labelledby="bkor-categories-heading">
	<div class="bkor-container">
		<h2 id="bkor-categories-heading" class="bkor-section-title bkor-section-title--standalone"><?php esc_html_e( 'Explore', 'bookingkoro' ); ?></h2>
		<div class="bkor-live-cats">
			<?php
			foreach ( $main_categories as $cat ) {
				$url       = isset( $cat['url'] ) ? $cat['url'] : '#';
				$label     = isset( $cat['label'] ) ? $cat['label'] : '';
				$icon      = isset( $cat['icon'] ) ? $cat['icon'] : '';
				$image_url = bookingkoro_get_image_url( isset( $cat['image'] ) ? $cat['image'] : '' );
				?>
				<a href="<?php echo esc_url( $url ); ?>" class="bkor-live-cat"<?php echo '' !== $image_url ? ' style="background-image: url(' . esc_url( $image_url ) . ');"' : ''; ?>>
					<?php if ( $icon ) : ?>
						<span class="bkor-live-cat__icon" aria-hidden="true"><?php echo bookingkoro_get_icon_svg( $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php endif; ?>
					<span class="bkor-live-cat__label"><?php echo esc_html( $label ); ?></span>
				</a>
			<?php }
			?>
		</div>
	</div>
</section>
