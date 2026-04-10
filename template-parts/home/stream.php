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
$subscription_status = isset( $_GET['bkor_subscribed'] ) ? sanitize_key( wp_unslash( $_GET['bkor_subscribed'] ) ) : '';

$notice_messages = array(
	'success' => __( 'Thanks. You are on the list and we will keep you posted.', 'bookingkoro' ),
	'invalid' => __( 'Enter a valid email address and try again.', 'bookingkoro' ),
	'failed'  => __( 'The subscription could not be sent right now. Please try again shortly.', 'bookingkoro' ),
);

$notice_class = 'is-info';
if ( in_array( $subscription_status, array( 'invalid', 'failed' ), true ) ) {
	$notice_class = 'is-error';
}
?>

<section id="bkor-stream" class="bkor-stream" aria-labelledby="bkor-stream-heading">
	<div class="bkor-container">
		<div class="bkor-stream__inner">
			<div class="bkor-stream__content">
				<h2 id="bkor-stream-heading" class="bkor-stream__logo"><?php echo esc_html( $stream_heading ); ?></h2>
				<p class="bkor-stream__tagline"><?php echo esc_html( $stream_tagline ); ?></p>
			</div>
			<div class="bkor-stream__cta">
				<form class="bkor-stream__form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
					<input type="hidden" name="action" value="bookingkoro_stream_subscription">
					<?php wp_nonce_field( 'bookingkoro_stream_subscribe', 'bookingkoro_stream_nonce' ); ?>
					<label class="screen-reader-text" for="bkor-subscriber-email"><?php esc_html_e( 'Email address', 'bookingkoro' ); ?></label>
					<div class="bkor-stream__field">
						<?php echo bookingkoro_get_icon_svg( 'mail', array( 'class' => 'bkor-stream__field-icon' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<input
							id="bkor-subscriber-email"
							class="bkor-stream__input"
							type="email"
							name="bkor_subscriber_email"
							placeholder="<?php echo esc_attr__( 'Enter your email for updates', 'bookingkoro' ); ?>"
							autocomplete="email"
							required
						>
						<button class="bkor-btn bkor-btn--light bkor-stream__submit" type="submit"><?php esc_html_e( 'Subscribe', 'bookingkoro' ); ?></button>
					</div>
				</form>
				<?php if ( isset( $notice_messages[ $subscription_status ] ) && isset( $_GET['bkor_stream'] ) ) : ?>
					<p class="bkor-stream__notice <?php echo esc_attr( $notice_class ); ?>" role="status"><?php echo esc_html( $notice_messages[ $subscription_status ] ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
