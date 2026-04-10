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
$footer_link_groups = isset( $footer['link_groups'] ) && is_array( $footer['link_groups'] ) ? $footer['link_groups'] : array();
$footer_social_links = isset( $footer['social_links'] ) && is_array( $footer['social_links'] ) ? $footer['social_links'] : array();

if ( empty( $footer_link_groups ) ) {
	$footer_link_groups = array(
		array(
			'title' => __( 'Explore', 'bookingkoro' ),
			'links' => array(
				array(
					'label' => __( 'Activities', 'bookingkoro' ),
					'url'   => '#activity',
				),
				array(
					'label' => __( 'Events', 'bookingkoro' ),
					'url'   => '#event',
				),
			),
		),
		array(
			'title' => __( 'Stay & Travel', 'bookingkoro' ),
			'links' => array(
				array(
					'label' => __( 'Stays', 'bookingkoro' ),
					'url'   => '#stays',
				),
				array(
					'label' => __( 'Vehicles', 'bookingkoro' ),
					'url'   => '#vehicle',
				),
			),
		),
		array(
			'title' => __( 'Services', 'bookingkoro' ),
			'links' => array(
				array(
					'label' => __( 'Home Services', 'bookingkoro' ),
					'url'   => '#service',
				),
				array(
					'label' => __( 'Book a Provider', 'bookingkoro' ),
					'url'   => '#service',
				),
			),
		),
		array(
			'title' => __( 'Booking Help', 'bookingkoro' ),
			'links' => array(
				array(
					'label' => __( 'Support Center', 'bookingkoro' ),
					'url'   => '#',
				),
				array(
					'label' => __( 'Manage Booking', 'bookingkoro' ),
					'url'   => '#',
				),
			),
		),
		array(
			'title' => __( 'Company', 'bookingkoro' ),
			'links' => array(
				array(
					'label' => __( 'About BookingKoro', 'bookingkoro' ),
					'url'   => '#',
				),
				array(
					'label' => __( 'Contact Us', 'bookingkoro' ),
					'url'   => home_url( '/#contact' ),
				),
			),
		),
	);
}

if ( empty( $footer_social_links ) ) {
	$footer_social_links = array(
		array(
			'label' => 'Facebook',
			'icon'  => 'facebook',
			'url'   => '#',
		),
		array(
			'label' => 'Instagram',
			'icon'  => 'instagram',
			'url'   => '#',
		),
		array(
			'label' => 'Twitter',
			'icon'  => 'twitter',
			'url'   => '#',
		),
		array(
			'label' => 'YouTube',
			'icon'  => 'youtube',
			'url'   => '#',
		),
		array(
			'label' => 'LinkedIn',
			'icon'  => 'linkedin',
			'url'   => '#',
		),
	);
}

$footer_support_items = array(
	array(
		'icon' => 'support',
		'text' => isset( $footer['support'] ) ? $footer['support'] : '',
	),
	array(
		'icon' => 'refresh',
		'text' => isset( $footer['resend'] ) ? $footer['resend'] : '',
	),
	array(
		'icon' => 'mail',
		'text' => isset( $footer['newsletter'] ) ? $footer['newsletter'] : '',
	),
);
?>
	<footer class="bkor-footer">
		<div class="bkor-footer__top">
			<div class="bkor-container">
				<div class="bkor-footer__cta">
					<div class="bkor-footer__cta-copy">
						<span class="bkor-footer__cta-label"><?php echo esc_html( isset( $footer['list_show_text'] ) ? $footer['list_show_text'] : '' ); ?></span>
						<?php if ( ! empty( $footer['brand_description'] ) ) : ?>
							<span class="bkor-footer__cta-note"><?php echo esc_html( $footer['brand_description'] ); ?></span>
						<?php endif; ?>
					</div>
					<a class="bkor-btn bkor-btn--contact" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php echo esc_html( isset( $footer['contact_btn'] ) ? $footer['contact_btn'] : '' ); ?></a>
				</div>
				<div class="bkor-footer__row">
					<?php foreach ( $footer_support_items as $support_item ) : ?>
						<?php if ( empty( $support_item['text'] ) ) : ?>
							<?php continue; ?>
						<?php endif; ?>
						<div class="bkor-footer__col">
							<span class="bkor-footer__col-icon" aria-hidden="true"><?php echo bookingkoro_get_icon_svg( $support_item['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<span class="bkor-footer__col-text"><?php echo esc_html( $support_item['text'] ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="bkor-footer__mid">
			<div class="bkor-container">
				<div class="bkor-footer__mid-grid">
					<div class="bkor-footer__brand">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="bkor-logo">
							<span class="bkor-logo__text"><?php echo esc_html( isset( $home_data['logo_text'] ) ? $home_data['logo_text'] : '' ); ?></span>
							<span class="bkor-logo__tagline"><?php echo esc_html( isset( $home_data['tagline'] ) ? $home_data['tagline'] : '' ); ?></span>
						</a>
						<?php if ( ! empty( $footer['brand_description'] ) ) : ?>
							<p class="bkor-footer__brand-copy"><?php echo esc_html( $footer['brand_description'] ); ?></p>
						<?php endif; ?>
						<div class="bkor-footer__social">
							<?php foreach ( $footer_social_links as $social_link ) : ?>
								<a href="<?php echo esc_url( isset( $social_link['url'] ) ? $social_link['url'] : '#' ); ?>" class="bkor-footer__social-link" aria-label="<?php echo esc_attr( isset( $social_link['label'] ) ? $social_link['label'] : '' ); ?>">
									<?php echo bookingkoro_get_icon_svg( isset( $social_link['icon'] ) ? $social_link['icon'] : '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="bkor-footer__links">
						<?php foreach ( $footer_link_groups as $link_group ) : ?>
							<?php
							$group_title = isset( $link_group['title'] ) ? $link_group['title'] : '';
							$group_links = isset( $link_group['links'] ) && is_array( $link_group['links'] ) ? $link_group['links'] : array();
							?>
							<div class="bkor-footer__link-col">
								<?php if ( $group_title ) : ?>
									<h4 class="bkor-footer__heading"><?php echo esc_html( $group_title ); ?></h4>
								<?php endif; ?>
								<?php if ( ! empty( $group_links ) ) : ?>
									<ul class="bkor-footer__link-list">
										<?php foreach ( $group_links as $link_item ) : ?>
											<?php
											$link_label = isset( $link_item['label'] ) ? $link_item['label'] : '';
											$link_url   = isset( $link_item['url'] ) ? $link_item['url'] : '#';
											?>
											<?php if ( ! $link_label ) : ?>
												<?php continue; ?>
											<?php endif; ?>
											<li><a href="<?php echo esc_url( $link_url ); ?>"><?php echo esc_html( $link_label ); ?></a></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
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
