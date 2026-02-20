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
			<button type="button" class="bkor-location" aria-expanded="false" aria-haspopup="listbox">
				<span class="bkor-location__name"><?php echo esc_html( isset( $home_data['city_name'] ) ? $home_data['city_name'] : '' ); ?></span>
				<svg class="bkor-location__arrow" width="12" height="12" viewBox="0 0 12 12" aria-hidden="true"><path fill="currentColor" d="M6 8L2 4h8L6 8z"/></svg>
			</button>
			<form class="bkor-search" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" method="get">
				<label for="bkor-search-input" class="screen-reader-text"><?php esc_html_e( 'Search', 'bookingkoro' ); ?></label>
				<span class="bkor-search__icon" aria-hidden="true">&#128269;</span>
				<input id="bkor-search-input" type="search" class="bkor-search__input" name="s" placeholder="<?php echo esc_attr( isset( $home_data['search_placeholder'] ) ? $home_data['search_placeholder'] : '' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
			</form>
			<div class="bkor-header__right">
				<button type="button" class="bkor-lang" aria-expanded="false">English <svg width="12" height="12" viewBox="0 0 12 12"><path fill="currentColor" d="M6 8L2 4h8L6 8z"/></svg></button>
				<a class="bkor-btn bkor-btn--signin" href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>"><?php esc_html_e( 'Sign In', 'bookingkoro' ); ?></a>
				<button type="button" class="bkor-menu-btn" aria-label="<?php esc_attr_e( 'Menu', 'bookingkoro' ); ?>">
					<span class="bkor-menu-btn__line"></span>
					<span class="bkor-menu-btn__line"></span>
					<span class="bkor-menu-btn__line"></span>
				</button>
			</div>
		</div>
	</header>

	<nav class="bkor-nav-sec" aria-label="<?php esc_attr_e( 'Main', 'bookingkoro' ); ?>">
		<div class="bkor-container">
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
