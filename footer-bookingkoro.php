<?php
/**
 * Footer template for BookingKoro homepage.
 *
 * @package BookingKoro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$home_data = bookingkoro_get_home_data();
$footer    = isset( $home_data['footer'] ) && is_array( $home_data['footer'] ) ? $home_data['footer'] : array();
?>
	<footer class="bkor-footer">
		<div class="bkor-footer__top">
			<div class="bkor-container">
				<p class="bkor-footer__cta">
					<?php echo esc_html( isset( $footer['list_show_text'] ) ? $footer['list_show_text'] : '' ); ?>
					<a class="bkor-btn bkor-btn--contact" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php echo esc_html( isset( $footer['contact_btn'] ) ? $footer['contact_btn'] : '' ); ?></a>
				</p>
				<div class="bkor-footer__row">
					<div class="bkor-footer__col"><?php echo esc_html( isset( $footer['support'] ) ? $footer['support'] : '' ); ?></div>
					<div class="bkor-footer__col"><?php echo esc_html( isset( $footer['resend'] ) ? $footer['resend'] : '' ); ?></div>
					<div class="bkor-footer__col"><?php echo esc_html( isset( $footer['newsletter'] ) ? $footer['newsletter'] : '' ); ?></div>
				</div>
			</div>
		</div>
		<div class="bkor-footer__mid">
			<div class="bkor-container">
				<div class="bkor-footer__links">
					<div class="bkor-footer__link-col">
						<h4 class="bkor-footer__heading"><?php esc_html_e( 'MOVIES NOW SHOWING', 'bookingkoro' ); ?></h4>
						<a href="#"><?php esc_html_e( 'View All', 'bookingkoro' ); ?></a>
					</div>
					<div class="bkor-footer__link-col">
						<h4 class="bkor-footer__heading"><?php esc_html_e( 'UPCOMING MOVIES', 'bookingkoro' ); ?></h4>
						<a href="#"><?php esc_html_e( 'View All', 'bookingkoro' ); ?></a>
					</div>
					<div class="bkor-footer__link-col">
						<h4 class="bkor-footer__heading"><?php esc_html_e( 'EVENTS BY GENRE', 'bookingkoro' ); ?></h4>
						<a href="#"><?php esc_html_e( 'View All', 'bookingkoro' ); ?></a>
					</div>
					<div class="bkor-footer__link-col">
						<h4 class="bkor-footer__heading"><?php esc_html_e( 'SPORTS', 'bookingkoro' ); ?></h4>
						<a href="#"><?php esc_html_e( 'View All', 'bookingkoro' ); ?></a>
					</div>
					<div class="bkor-footer__link-col">
						<h4 class="bkor-footer__heading"><?php esc_html_e( 'ABOUT BOOKINGKORO', 'bookingkoro' ); ?></h4>
						<a href="#"><?php esc_html_e( 'Help', 'bookingkoro' ); ?></a>
					</div>
				</div>
				<div class="bkor-footer__social">
					<a href="#" class="bkor-footer__social-link" aria-label="Facebook">f</a>
					<a href="#" class="bkor-footer__social-link" aria-label="Instagram">ig</a>
					<a href="#" class="bkor-footer__social-link" aria-label="Twitter">t</a>
					<a href="#" class="bkor-footer__social-link" aria-label="YouTube">yt</a>
					<a href="#" class="bkor-footer__social-link" aria-label="LinkedIn">in</a>
				</div>
			</div>
		</div>
		<div class="bkor-footer__bottom">
			<div class="bkor-container">
				<p class="bkor-footer__copy"><?php echo esc_html( isset( $footer['copyright'] ) ? $footer['copyright'] : '' ); ?></p>
			</div>
		</div>
	</footer>

<?php wp_footer(); ?>
</body>
</html>
