<?php
/**
 * Template part for a single topic section (Activity, Event, Service, Stays, Vehicle) card list.
 *
 * Expects:
 * - $topic_section_config: array with 'label', 'slug', 'key'
 * - $topic_section_items: array of items with 'title', 'meta', 'url'
 *
 * @package BookingKoro
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}
$home_data = bookingkoro_get_home_data();
if ( empty( $topic_section_config ) || ! is_array( $topic_section_config ) ) {
	return;
}

$label = isset( $topic_section_config['label'] ) ? $topic_section_config['label'] : '';
$slug  = isset( $topic_section_config['slug'] ) ? $topic_section_config['slug'] : '';
$items = isset( $topic_section_items ) && is_array( $topic_section_items ) ? $topic_section_items : array();
$heading_id = 'bkor-' . $slug . '-heading';
?>

<section class="bkor-section" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
	<div class="bkor-container">
		<header class="bkor-section-header">
			<h2 id="<?php echo esc_attr( $heading_id ); ?>" class="bkor-section-title"><?php echo esc_html( $label ); ?></h2>
			<a class="bkor-section-link" href="#<?php echo esc_attr( $slug ); ?>"><?php esc_html_e( 'View All', 'bookingkoro' ); ?></a>
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
							<span class="bkor-card__placeholder"><?php echo esc_html( $label ); ?></span>
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
