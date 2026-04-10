<?php
/**
 * Template part for a single topic section (Activity, Event, Service, Stays, Vehicle) card list.
 *
 * Expects in $args:
 * - topic_section_config: array with 'label', 'slug', 'key'
 * - topic_section_items: array of items with 'title', 'meta', 'url', 'icon_html', 'image_url'
 *
 * @package BookingKoro
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$topic_section_config = isset( $args['topic_section_config'] ) && is_array( $args['topic_section_config'] )
	? $args['topic_section_config']
	: array();
$topic_section_items  = isset( $args['topic_section_items'] ) && is_array( $args['topic_section_items'] )
	? $args['topic_section_items']
	: array();

if ( empty( $topic_section_config ) ) {
	return;
}

$label = isset( $topic_section_config['label'] ) ? $topic_section_config['label'] : '';
$slug  = isset( $topic_section_config['slug'] ) ? $topic_section_config['slug'] : '';
$items = $topic_section_items;
$heading_id = 'bkor-' . $slug . '-heading';

if ( empty( $items ) ) {
	return;
}
?>

<section id="<?php echo esc_attr( $slug ); ?>" class="bkor-section" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
	<div class="bkor-container">
		<header class="bkor-section-header">
			<h2 id="<?php echo esc_attr( $heading_id ); ?>" class="bkor-section-title"><?php echo esc_html( $label ); ?></h2>
			<a class="bkor-section-link" href="#<?php echo esc_attr( $slug ); ?>">
				<?php esc_html_e( 'View All', 'bookingkoro' ); ?>
				<span class="bkor-section-link__icon" aria-hidden="true"><?php echo bookingkoro_get_icon_svg( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			</a>
		</header>
		<div class="bkor-cards bkor-cards--scroll">
			<?php
			foreach ( $items as $item ) {
				$title     = isset( $item['title'] ) ? $item['title'] : '';
				$meta      = isset( $item['meta'] ) ? $item['meta'] : '';
				$url       = isset( $item['url'] ) ? $item['url'] : '#';
				$icon_html = isset( $item['icon_html'] ) && is_string( $item['icon_html'] ) ? $item['icon_html'] : '';
				$image_url = isset( $item['image_url'] ) && is_string( $item['image_url'] ) ? $item['image_url'] : '';
				?>
				<article class="bkor-card">
					<a href="<?php echo esc_url( $url ); ?>" class="bkor-card__link">
						<div class="bkor-card__img<?php echo '' !== $image_url ? ' has-image' : ''; ?>">
							<?php if ( '' !== $image_url ) : ?>
								<img class="bkor-card__photo" src="<?php echo esc_url( $image_url ); ?>" alt="" loading="lazy" decoding="async">
							<?php endif; ?>
							<span class="bkor-card__icon" aria-hidden="true">
								<?php if ( '' !== $icon_html ) : ?>
									<?php echo $icon_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php else : ?>
									<?php echo bookingkoro_get_icon_svg( $slug ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php endif; ?>
							</span>
							<span class="bkor-card__placeholder"><?php echo esc_html( $label ); ?></span>
						</div>
						<div class="bkor-card__body">
							<h3 class="bkor-card__title"><?php echo esc_html( $title ); ?></h3>
							<?php if ( '' !== $meta ) : ?>
								<p class="bkor-card__meta"><?php echo esc_html( $meta ); ?></p>
							<?php endif; ?>
						</div>
					</a>
				</article>
			<?php }
			?>
		</div>
	</div>
</section>
