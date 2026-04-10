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
$home_data   = bookingkoro_get_home_data();
$hero_slides = isset( $home_data['hero_slides'] ) && is_array( $home_data['hero_slides'] ) ? $home_data['hero_slides'] : array();
$logo_text   = isset( $home_data['logo_text'] ) ? $home_data['logo_text'] : __( 'BookingKoro', 'bookingkoro' );

if ( empty( $hero_slides ) ) {
	return;
}
?>

<section class="bkor-hero" id="bkor-hero-carousel" aria-label="<?php esc_attr_e( 'Offers', 'bookingkoro' ); ?>">
	<div class="bkor-hero__viewport">
		<ul class="bkor-hero__list">
			<?php
			foreach ( $hero_slides as $index => $slide ) {
				$url       = isset( $slide['url'] ) ? $slide['url'] : '#';
				$title     = isset( $slide['title'] ) ? $slide['title'] : '';
				$subtitle  = isset( $slide['subtitle'] ) ? $slide['subtitle'] : '';
				$image_url = bookingkoro_get_image_url( isset( $slide['image'] ) ? $slide['image'] : '' );
				$loading   = 0 === $index ? 'eager' : 'lazy';
				?>
				<li class="bkor-hero__item<?php echo 0 === $index ? ' is-active' : ''; ?>">
					<a href="<?php echo esc_url( $url ); ?>" class="bkor-hero__slide">
						<?php if ( '' !== $image_url ) : ?>
							<span class="bkor-hero__media">
								<img
									class="bkor-hero__image"
									src="<?php echo esc_url( $image_url ); ?>"
									alt="<?php echo esc_attr( $title ); ?>"
									loading="<?php echo esc_attr( $loading ); ?>"
									decoding="async"
									<?php echo 0 === $index ? 'fetchpriority="high"' : ''; ?>
								>
							</span>
						<?php endif; ?>
						<div class="bkor-hero__content">
							<span class="bkor-hero__eyebrow"><?php echo esc_html( $logo_text ); ?></span>
							<h2 class="bkor-hero__title"><?php echo esc_html( $title ); ?></h2>
							<?php if ( $subtitle ) : ?>
								<p class="bkor-hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
							<?php endif; ?>
						</div>
						<?php if ( '' === $image_url ) : ?>
							<div class="bkor-hero__illus" aria-hidden="true"><?php echo bookingkoro_get_icon_svg( 'offers' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
						<?php endif; ?>
					</a>
				</li>
				<?php
			}
			?>
		</ul>
	</div>
	<?php if ( count( $hero_slides ) > 1 ) : ?>
		<div class="bkor-hero__controls">
			<button type="button" class="bkor-carousel-arrow bkor-hero__arrow bkor-hero__arrow--prev" data-direction="prev" aria-label="<?php esc_attr_e( 'Previous slide', 'bookingkoro' ); ?>"></button>
			<button type="button" class="bkor-carousel-arrow bkor-hero__arrow bkor-hero__arrow--next" data-direction="next" aria-label="<?php esc_attr_e( 'Next slide', 'bookingkoro' ); ?>"></button>
		</div>
		<div class="bkor-hero__pagination" aria-label="<?php esc_attr_e( 'Hero pagination', 'bookingkoro' ); ?>">
			<?php foreach ( $hero_slides as $index => $slide ) : ?>
				<button type="button" class="bkor-hero__dot<?php echo 0 === $index ? ' is-active' : ''; ?>" data-slide-index="<?php echo esc_attr( (string) $index ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Go to slide %d', 'bookingkoro' ), $index + 1 ) ); ?>"></button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
