<?php
/**
 * Template part for the homepage "How it works" block.
 *
 * Expects: $home_data (from bookingkoro_get_home_data()).
 *
 * @package BookingKoro
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}
$home_data = bookingkoro_get_home_data();
$how       = isset( $home_data['how_it_works'] ) && is_array( $home_data['how_it_works'] ) ? $home_data['how_it_works'] : array();
$steps     = isset( $how['steps'] ) && is_array( $how['steps'] ) ? $how['steps'] : array();
$how_title = isset( $how['title'] ) ? $how['title'] : __( 'How it works', 'bookingkoro' );
$how_subtitle = isset( $how['subtitle'] ) ? $how['subtitle'] : '';

if ( empty( $steps ) ) {
	return;
}
?>

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
