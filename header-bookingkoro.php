<?php
/**
 * Header template for BookingKoro homepage.
 *
 * @package BookingKoro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$home_data = bookingkoro_get_home_data();
$search_results_url = home_url( '/search-result/' );
$search_query_value = '';
$selected_directory_type = '';
$directory_type_terms    = bookingkoro_get_directory_type_terms();

if ( isset( $_GET['q'] ) ) {
	$search_query_value = sanitize_text_field( wp_unslash( $_GET['q'] ) );
}

if ( isset( $_GET['directory_type'] ) ) {
	$selected_directory_type = sanitize_title( wp_unslash( $_GET['directory_type'] ) );
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

	<header class="bkor-header">
		<div class="bkor-header__inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="bkor-logo">
				<span class="bkor-logo__text"><?php echo esc_html( isset( $home_data['logo_text'] ) ? $home_data['logo_text'] : '' ); ?></span>
				<span class="bkor-logo__tagline"><?php echo esc_html( isset( $home_data['tagline'] ) ? $home_data['tagline'] : '' ); ?></span>
			</a>

			<div class="bkor-header__searchbar-wrapper">
				<button type="button" class="bkor-menu-btn bkor-nav-toggle" aria-controls="bkor-nav-sec" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open menu', 'bookingkoro' ); ?>">
					<span class="bkor-menu-btn__line"></span>
					<span class="bkor-menu-btn__line"></span>
					<span class="bkor-menu-btn__line"></span>
				</button>

				<form class="bkor-search" action="<?php echo esc_url( $search_results_url ); ?>" role="search" method="get">
					<label for="bkor-directory-type" class="screen-reader-text"><?php esc_html_e( 'Directory type', 'bookingkoro' ); ?></label>
					<div class="bkor-search__select-wrap">
						<select id="bkor-directory-type" class="bkor-search__select" name="directory_type">
							<option value=""><?php esc_html_e( 'All Types', 'bookingkoro' ); ?></option>
							<?php foreach ( $directory_type_terms as $directory_type_term ) : ?>
								<option value="<?php echo esc_attr( $directory_type_term->slug ); ?>" <?php selected( $selected_directory_type, $directory_type_term->slug ); ?>>
									<?php echo esc_html( $directory_type_term->name ); ?>
								</option>
							<?php endforeach; ?>
						</select>
						<span class="bkor-search__select-icon" aria-hidden="true"><?php echo bookingkoro_get_icon_svg( 'chevron-down' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					</div>
					<label for="bkor-search-input" class="screen-reader-text"><?php esc_html_e( 'Search', 'bookingkoro' ); ?></label>
					<input id="bkor-search-input" type="search" class="bkor-search__input" name="q" placeholder="<?php echo esc_attr( isset( $home_data['search_placeholder'] ) ? $home_data['search_placeholder'] : '' ); ?>" value="<?php echo esc_attr( $search_query_value ); ?>">
				</form>
			</div>

			<?php if ( is_user_logged_in() ) : ?>
				<a class="bkor-btn bkor-btn--account" href="<?php echo esc_url( bookingkoro_get_account_url() ); ?>"><?php esc_html_e( 'Account', 'bookingkoro' ); ?></a>
			<?php else : ?>
				<a class="bkor-btn bkor-btn--signin" href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>"><?php esc_html_e( 'Sign In', 'bookingkoro' ); ?></a>
			<?php endif; ?>
		</div>
	</header>

	<nav id="bkor-nav-sec" class="bkor-nav-sec" aria-label="<?php esc_attr_e( 'Main', 'bookingkoro' ); ?>">
		<div class="bkor-container">
			<button type="button" class="bkor-nav-sec__close" aria-label="<?php esc_attr_e( 'Close menu', 'bookingkoro' ); ?>">&times;</button>
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'bookingkoro-main',
					'menu_class'      => 'bkor-nav-sec__list',
					'container'       => false,
					'fallback_cb'     => 'bookingkoro_main_menu_fallback',
					'depth'           => 1,
					'item_spacing'    => 'discard',
				)
			);
			?>
		</div>
	</nav>
	<div class="bkor-nav-overlay" aria-hidden="true"></div>
