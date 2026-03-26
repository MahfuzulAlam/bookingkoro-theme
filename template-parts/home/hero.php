<?php
/**
 * Template part for the homepage hero carousel (Splide).
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

if ( empty( $hero_slides ) ) {
	return;
}
?>

<section class="splide bkor-hero" id="bkor-hero-splide" aria-label="<?php esc_attr_e( 'Offers', 'bookingkoro' ); ?>">
	<div class="splide__track">
		<ul class="splide__list">
			<?php
			foreach ( $hero_slides as $slide ) {
				$url       = isset( $slide['url'] ) ? $slide['url'] : '#';
				$title     = isset( $slide['title'] ) ? $slide['title'] : '';
				$subtitle  = isset( $slide['subtitle'] ) ? $slide['subtitle'] : '';
				$image_raw = isset( $slide['image'] ) ? $slide['image'] : '';

				$slide_classes = array( 'bkor-hero__slide' );
				$inline_style    = '';

				if ( '' !== $image_raw ) {
					$slide_classes[] = 'bkor-hero__slide--has-image';
					if ( preg_match( '#^https?://#i', $image_raw ) ) {
						$img_url = $image_raw;
					} else {
						$img_url = get_stylesheet_directory_uri() . '/' . ltrim( $image_raw, '/' );
					}
					$img_url       = esc_url( $img_url );
					$inline_style = 'background-image: url(' . $img_url . ');';
				}
				?>
				<li class="splide__slide">
					<a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( implode( ' ', $slide_classes ) ); ?>"<?php echo '' !== $inline_style ? ' style="' . esc_attr( $inline_style ) . '"' : ''; ?>>
						<div class="bkor-hero__content">
							<h2 class="bkor-hero__title"><?php echo esc_html( $title ); ?></h2>
							<?php if ( $subtitle ) : ?>
								<p class="bkor-hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
							<?php endif; ?>
						</div>
						<?php if ( '' === $image_raw ) : ?>
							<div class="bkor-hero__illus" aria-hidden="true"></div>
						<?php endif; ?>
					</a>
				</li>
				<?php
			}
			?>
		</ul>
	</div>
</section>
