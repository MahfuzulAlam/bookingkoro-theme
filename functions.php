<?php
/**
 * BookingKoro theme functions and definitions.
 *
 * Child theme of GeneratePress for bookingkoro.com
 *
 * @package BookingKoro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bookingkoro_home_topic_cards_file = get_stylesheet_directory() . '/include/includes/inc/class-bookingkoro-home-topic-cards.php';

if ( file_exists( $bookingkoro_home_topic_cards_file ) ) {
	require_once $bookingkoro_home_topic_cards_file;
}

/**
 * Set up child theme.
 */
function bookingkoro_setup() {
	load_theme_textdomain( 'bookingkoro', get_stylesheet_directory() . '/languages' );

	register_nav_menus(
		array(
			'bookingkoro-main' => __( 'Main Menu', 'bookingkoro' ),
		)
	);
}
add_action( 'after_setup_theme', 'bookingkoro_setup' );

/**
 * Fallback when no menu is assigned to Main Menu. Outputs links from home-data.json.
 */
function bookingkoro_main_menu_fallback() {
	$home_data = bookingkoro_get_home_data();
	if ( empty( $home_data['secondary_nav'] ) || ! is_array( $home_data['secondary_nav'] ) ) {
		return;
	}
	echo '<ul class="bkor-nav-sec__list">';
	foreach ( $home_data['secondary_nav'] as $item ) {
		$url   = isset( $item['url'] ) ? $item['url'] : '#';
		$label = isset( $item['label'] ) ? $item['label'] : '';
		echo '<li><a class="bkor-nav-sec__link" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Load a child theme template part with arguments.
 *
 * @param string $parent_template Parent template directory.
 * @param string $child_template  Template filename without extension.
 * @param array  $args            Optional template arguments.
 * @return void
 */
function get_bookingkoro_template( $parent_template, $child_template, $args = array() ) {
	if ( empty( $child_template ) ) {
		return;
	}

	$template_path = '';

	if ( ! empty( $parent_template ) ) {
		$template_path = get_stylesheet_directory() . '/template-parts/' . $parent_template . '/' . $child_template . '.php';
	} else {
		$template_path = get_stylesheet_directory() . '/template-parts/' . $child_template . '.php';
	}

	if ( ! file_exists( $template_path ) ) {
		return;
	}

	load_template( $template_path, false, $args );
}

/**
 * Determine whether the BookingKoro homepage template is active.
 *
 * @return bool
 */
function bookingkoro_is_homepage_template() {
	return is_page_template( 'template-home-bookingkoro.php' );
}

/**
 * Add body class when BookingKoro Homepage template is used.
 *
 * @param array $classes Existing body classes.
 * @return array Modified body classes.
 */
function bookingkoro_body_class( $classes ) {
	if ( bookingkoro_is_homepage_template() ) {
		$classes[] = 'bookingkoro-home-page';
		$classes[] = 'generate-layout-no-sidebar';
	}
	return $classes;
}
add_filter( 'body_class', 'bookingkoro_body_class' );

/**
 * Get homepage data from JSON file. Cached per request.
 *
 * @return array Homepage data. Empty array on failure.
 */
function bookingkoro_get_home_data() {
	static $data = null;

	if ( null !== $data ) {
		return $data;
	}

	$path = get_stylesheet_directory() . '/assets/data/home-data.json';
	if ( ! file_exists( $path ) || ! is_readable( $path ) ) {
		$data = array();
		return $data;
	}

	if ( function_exists( 'wp_json_file_decode' ) ) {
		$decoded = wp_json_file_decode(
			$path,
			array(
				'associative' => true,
			)
		);
	} else {
		$json    = file_get_contents( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$decoded = false !== $json ? json_decode( $json, true ) : null;
	}

	if ( ! is_array( $decoded ) ) {
		$data = array();
		return $data;
	}

	$data = apply_filters( 'bookingkoro_homepage_data', $decoded );
	return $data;
}

/**
 * Get homepage topic-card items for a Directorist directory type.
 *
 * @param string $directory_type_slug Directory-type slug.
 * @param int    $limit               Listings per section.
 * @return array<int, array<string, string>>
 */
function bookingkoro_get_topic_section_items( $directory_type_slug, $limit = 12 ) {
	if ( ! class_exists( 'BookingKoro_Home_Topic_Cards' ) ) {
		return array();
	}

	return BookingKoro_Home_Topic_Cards::get_items_for_directory_type( $directory_type_slug, $limit );
}

/**
 * Resolve an image path to a full URL.
 *
 * Accepts absolute URLs and theme-relative paths such as
 * "assets/img/home/hero/slide.png".
 *
 * @param string $image_path Raw image value from data source.
 * @return string Resolved image URL or empty string.
 */
function bookingkoro_get_image_url( $image_path ) {
	if ( ! is_string( $image_path ) ) {
		return '';
	}

	$image_path = trim( $image_path );
	if ( '' === $image_path ) {
		return '';
	}

	if ( preg_match( '#^https?://#i', $image_path ) ) {
		return esc_url_raw( $image_path );
	}

	return esc_url_raw( get_stylesheet_directory_uri() . '/' . ltrim( $image_path, '/' ) );
}

/**
 * Build a version string for a theme asset.
 *
 * @param string $relative_path Relative path from the child theme root.
 * @return string
 */
function bookingkoro_get_asset_version( $relative_path ) {
	$theme_version = wp_get_theme()->get( 'Version' );
	$asset_path    = get_stylesheet_directory() . '/' . ltrim( $relative_path, '/' );

	return file_exists( $asset_path ) ? (string) filemtime( $asset_path ) : $theme_version;
}

/**
 * Determine whether the current request is a Directorist-heavy frontend screen.
 *
 * @return bool
 */
function bookingkoro_is_directorist_context() {
	$directorist_post_type = defined( 'ATBDP_POST_TYPE' ) ? ATBDP_POST_TYPE : 'at_biz_dir';
	$archive_slugs         = apply_filters(
		'bookingkoro_directorist_archive_page_slugs',
		array(
			'all-listings',
			'search-result',
		)
	);

	if ( is_singular( $directorist_post_type ) || is_post_type_archive( $directorist_post_type ) || is_page( $archive_slugs ) ) {
		return true;
	}

	if ( is_tax( array( 'at_biz_dir-category', 'at_biz_dir-location', 'at_biz_dir-tags' ) ) ) {
		return true;
	}

	$post = get_queried_object();
	if ( $post instanceof WP_Post && has_shortcode( $post->post_content, 'directorist_search_listing' ) ) {
		return true;
	}

	if ( $post instanceof WP_Post && false !== strpos( $post->post_content, '[directorist' ) ) {
		return true;
	}

	return false;
}

/**
 * Get the best account URL for the current install.
 *
 * @return string
 */
function bookingkoro_get_account_url() {
	$my_account_page_id = (int) get_option( 'woocommerce_myaccount_page_id' );

	if ( $my_account_page_id > 0 ) {
		$account_url = get_permalink( $my_account_page_id );
		if ( $account_url ) {
			return $account_url;
		}
	}

	return is_user_logged_in() ? admin_url() : wp_login_url( home_url( '/' ) );
}

/**
 * Return the icon map used across the child theme.
 *
 * @return array<string, array<string, string>>
 */
function bookingkoro_get_icon_map() {
	return array(
		'search'    => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M10 4a6 6 0 1 0 3.874 10.582 1 1 0 0 1 .252.166l4.656 4.656a1 1 0 0 1-1.414 1.414l-4.656-4.656a1 1 0 0 1-.166-.252A6 6 0 0 0 10 4Zm0 2a4 4 0 1 1 0 8 4 4 0 0 1 0-8Z',
		),
		'arrow-right' => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M13.293 5.293a1 1 0 0 1 1.414 0l5.999 6a1 1 0 0 1 0 1.414l-5.999 6a1 1 0 1 1-1.414-1.414L17.586 13H4a1 1 0 1 1 0-2h13.586l-4.293-4.293a1 1 0 0 1 0-1.414Z',
		),
		'offers'    => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M3 7.25A2.25 2.25 0 0 1 5.25 5h13.5A2.25 2.25 0 0 1 21 7.25V9a2 2 0 0 0 0 4v1.75A2.25 2.25 0 0 1 18.75 17H5.25A2.25 2.25 0 0 1 3 14.75V13a2 2 0 0 0 0-4V7.25Zm9.75-.25a.75.75 0 0 0-1.5 0v10a.75.75 0 0 0 1.5 0V7Zm3.5 2.5a1.25 1.25 0 1 0 0 2.5 1.25 1.25 0 0 0 0-2.5Zm-8.5 3a1.25 1.25 0 1 0 0 2.5 1.25 1.25 0 0 0 0-2.5Z',
		),
		'activity'  => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M12 2 5.5 5.5 2 12l3.5 6.5L12 22l6.5-3.5L22 12l-3.5-6.5L12 2Zm4.95 7.636-3.515.9-.899 3.515a.75.75 0 0 1-1.455 0l-.9-3.515-3.515-.899a.75.75 0 0 1 0-1.455l3.515-.9.9-3.515a.75.75 0 0 1 1.455 0l.899 3.515 3.515.9a.75.75 0 0 1 0 1.455Z',
		),
		'event'     => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M7 2a1 1 0 0 1 1 1v1h8V3a1 1 0 1 1 2 0v1h.75A2.25 2.25 0 0 1 21 6.25v11.5A2.25 2.25 0 0 1 18.75 20H5.25A2.25 2.25 0 0 1 3 17.75V6.25A2.25 2.25 0 0 1 5.25 4H6V3a1 1 0 0 1 1-1Zm12 7H5v8.75c0 .138.112.25.25.25h13.5a.25.25 0 0 0 .25-.25V9Zm-4.5 2.25a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3a.75.75 0 0 1 .75-.75Zm-5 0a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3a.75.75 0 0 1 .75-.75Z',
		),
		'service'   => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M14.34 2.002a.75.75 0 0 1 .675.974l-.928 3.065a5.25 5.25 0 0 1 2.872 2.871l3.065-.927a.75.75 0 0 1 .974.675 7.5 7.5 0 0 1-9.373 9.373.75.75 0 0 1-.675-.974l.928-3.065a5.25 5.25 0 0 1-2.872-2.872l-3.065.928a.75.75 0 0 1-.974-.675A7.5 7.5 0 0 1 14.34 2.002ZM4.22 14.22a1 1 0 0 1 1.414 0l4.146 4.146a1 1 0 0 1 0 1.414l-1 1a2 2 0 0 1-2.828 0L2.806 17.634a2 2 0 0 1 0-2.828l1-1a1 1 0 0 1 1.414 0Z',
		),
		'stays'     => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M4 6.5A2.5 2.5 0 0 1 6.5 4h3A2.5 2.5 0 0 1 12 6.5V8h4.5A3.5 3.5 0 0 1 20 11.5V17a1 1 0 1 1-2 0v-1H6v1a1 1 0 1 1-2 0V6.5Zm2 3.5v4h12v-2.5A1.5 1.5 0 0 0 16.5 10H6Zm1-4a.5.5 0 0 0-.5.5V8H10V6.5a.5.5 0 0 0-.5-.5H7Z',
		),
		'vehicle'   => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M7.082 5.5A2.25 2.25 0 0 1 9.157 4h5.686a2.25 2.25 0 0 1 2.074 1.5L18.2 9H19a2 2 0 0 1 2 2v4.5a1.5 1.5 0 0 1-1.5 1.5H18a2.5 2.5 0 1 1-5 0h-2a2.5 2.5 0 1 1-5 0H4.5A1.5 1.5 0 0 1 3 15.5V11a2 2 0 0 1 2-2h.8l1.282-3.5ZM8 14.5a1 1 0 1 0 0 2 1 1 0 0 0 0-2Zm8 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2ZM7.93 9h8.14l-.56-1.53a.25.25 0 0 0-.235-.17H9.157a.25.25 0 0 0-.235.17L7.93 9Z',
		),
		'support'   => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M12 3a7 7 0 0 0-7 7v2.126A3 3 0 0 0 3 15v1a3 3 0 0 0 3 3h1a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1H6v-3a6 6 0 1 1 12 0v3h-1a1 1 0 0 0-1 1v4c0 .188.053.364.145.514A4.501 4.501 0 0 1 12 21h-1a1 1 0 1 0 0 2h1a6.5 6.5 0 0 0 6.377-5.24A3 3 0 0 0 21 16v-1a3 3 0 0 0-2-2.874V10a7 7 0 0 0-7-7Z',
		),
		'refresh'   => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M17.65 6.35A7.95 7.95 0 0 0 12 4a8 8 0 1 0 7.75 10h-2.08A6 6 0 1 1 12 6c1.3 0 2.5.42 3.47 1.13L13 9.5h7V2.5l-2.35 2.35Z',
		),
		'mail'      => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M4.25 5A2.25 2.25 0 0 0 2 7.25v9.5A2.25 2.25 0 0 0 4.25 19h15.5A2.25 2.25 0 0 0 22 16.75v-9.5A2.25 2.25 0 0 0 19.75 5H4.25Zm0 1.5h15.5a.75.75 0 0 1 .742.639L12 12.49 3.508 7.139A.75.75 0 0 1 4.25 6.5Zm-.75 2.283 8.1 5.105a.75.75 0 0 0 .8 0l8.1-5.105v7.967a.75.75 0 0 1-.75.75H4.25a.75.75 0 0 1-.75-.75V8.783Z',
		),
		'facebook'  => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M13.5 21v-7h2.3l.35-2.7H13.5V9.57c0-.78.22-1.31 1.34-1.31H16.3V5.85c-.71-.1-1.41-.15-2.12-.15-2.1 0-3.55 1.28-3.55 3.64v1.96H8.3V14h2.33v7h2.87Z',
		),
		'instagram' => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M7.75 3h8.5A4.75 4.75 0 0 1 21 7.75v8.5A4.75 4.75 0 0 1 16.25 21h-8.5A4.75 4.75 0 0 1 3 16.25v-8.5A4.75 4.75 0 0 1 7.75 3Zm0 1.75A3 3 0 0 0 4.75 7.75v8.5a3 3 0 0 0 3 3h8.5a3 3 0 0 0 3-3v-8.5a3 3 0 0 0-3-3h-8.5Zm8.875 1.375a1.125 1.125 0 1 1 0 2.25 1.125 1.125 0 0 1 0-2.25ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.75A3.25 3.25 0 1 0 12 15.25 3.25 3.25 0 0 0 12 8.75Z',
		),
		'twitter'   => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M18.901 6.539c.008.12.008.241.008.362 0 3.692-2.81 7.949-7.949 7.949A7.9 7.9 0 0 1 6.68 13.6c.248.028.488.04.745.04a5.601 5.601 0 0 0 3.467-1.193 2.8 2.8 0 0 1-2.613-1.94c.173.028.346.04.528.04.254 0 .508-.036.746-.096A2.796 2.796 0 0 1 7.313 7.71v-.036c.373.205.802.33 1.258.346A2.793 2.793 0 0 1 7.707 4.29a7.93 7.93 0 0 0 5.758 2.918 3.152 3.152 0 0 1-.069-.64A2.796 2.796 0 0 1 18.23 4.67a5.497 5.497 0 0 0 1.774-.677 2.779 2.779 0 0 1-1.23 1.538 5.606 5.606 0 0 0 1.61-.435 6.077 6.077 0 0 1-1.483 1.443Z',
		),
		'youtube'   => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M21.58 7.19a2.763 2.763 0 0 0-1.94-1.96C17.93 4.75 12 4.75 12 4.75s-5.93 0-7.64.48A2.763 2.763 0 0 0 2.42 7.19 28.78 28.78 0 0 0 2 12a28.78 28.78 0 0 0 .42 4.81 2.763 2.763 0 0 0 1.94 1.96c1.71.48 7.64.48 7.64.48s5.93 0 7.64-.48a2.763 2.763 0 0 0 1.94-1.96A28.78 28.78 0 0 0 22 12a28.78 28.78 0 0 0-.42-4.81ZM10 15.5v-7l6 3.5-6 3.5Z',
		),
		'linkedin'  => array(
			'viewbox' => '0 0 24 24',
			'path'    => 'M5.335 3.5a1.585 1.585 0 1 1 0 3.17 1.585 1.585 0 0 1 0-3.17ZM3.75 8.25h3.17v12H3.75v-12Zm5.085 0h3.04v1.64h.043c.424-.804 1.46-1.65 3.007-1.65 3.216 0 3.81 2.118 3.81 4.873v7.137h-3.17v-6.327c0-1.51-.027-3.452-2.103-3.452-2.107 0-2.43 1.646-2.43 3.343v6.436h-3.197v-12Z',
		),
	);
}

/**
 * Return a BookingKoro SVG icon.
 *
 * @param string $icon Icon key.
 * @param array  $args Optional SVG arguments.
 * @return string
 */
function bookingkoro_get_icon_svg( $icon, $args = array() ) {
	$icon_map = bookingkoro_get_icon_map();

	if ( empty( $icon_map[ $icon ] ) ) {
		return '';
	}

	$args = wp_parse_args(
		$args,
		array(
			'class'      => '',
			'decorative' => true,
			'title'      => '',
		)
	);

	$classes    = trim( 'bkor-icon ' . $args['class'] );
	$aria_hidden = $args['decorative'] ? ' aria-hidden="true"' : '';
	$role        = $args['decorative'] ? '' : ' role="img"';
	$title       = '';

	if ( ! $args['decorative'] && '' !== $args['title'] ) {
		$title = '<title>' . esc_html( $args['title'] ) . '</title>';
	}

	return sprintf(
		'<svg class="%1$s" viewBox="%2$s" xmlns="http://www.w3.org/2000/svg"%3$s%4$s>%5$s<path fill="currentColor" d="%6$s"/></svg>',
		esc_attr( $classes ),
		esc_attr( $icon_map[ $icon ]['viewbox'] ),
		$aria_hidden,
		$role,
		$title,
		esc_attr( $icon_map[ $icon ]['path'] )
	);
}

/**
 * Enqueue theme assets.
 *
 * Splits site shell styles from homepage-specific assets and keeps Directorist
 * icon dependencies available on pages that rely on legacy icon classes.
 *
 * @return void
 */
function bookingkoro_enqueue_assets() {
	$uri = get_stylesheet_directory_uri();

	wp_enqueue_style(
		'bookingkoro-site-shell',
		$uri . '/assets/css/site-shell.css',
		array( 'generate-style' ),
		bookingkoro_get_asset_version( 'assets/css/site-shell.css' )
	);

	if ( bookingkoro_is_homepage_template() ) {
		wp_enqueue_style(
			'bookingkoro-home',
			$uri . '/assets/css/home.css',
			array( 'bookingkoro-site-shell' ),
			bookingkoro_get_asset_version( 'assets/css/home.css' )
		);

		wp_enqueue_script(
			'bookingkoro-home',
			$uri . '/assets/js/home.js',
			array(),
			bookingkoro_get_asset_version( 'assets/js/home.js' ),
			true
		);
	}

	if ( bookingkoro_is_directorist_context() ) {
		foreach ( array( 'directorist-font-awesome', 'directorist-line-awesome', 'directorist-unicons' ) as $icon_style_handle ) {
			if ( wp_style_is( $icon_style_handle, 'registered' ) ) {
				wp_enqueue_style( $icon_style_handle );
			}
		}
	}

	if ( is_singular( 'at_biz_dir' ) ) {
		wp_enqueue_style(
			'bookingkoro-directorist-single',
			$uri . '/assets/css/directorist-single.css',
			array( 'directorist-main-style', 'bookingkoro-site-shell' ),
			bookingkoro_get_asset_version( 'assets/css/directorist-single.css' )
		);
	}

	$archive_slugs = apply_filters(
		'bookingkoro_directorist_archive_page_slugs',
		array(
			'all-listings',
			'search-result',
		)
	);

	if ( is_page( $archive_slugs ) ) {
		wp_enqueue_style(
			'bookingkoro-directorist-archive',
			$uri . '/assets/css/directorist-archive.css',
			array( 'directorist-main-style', 'bookingkoro-site-shell' ),
			bookingkoro_get_asset_version( 'assets/css/directorist-archive.css' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'bookingkoro_enqueue_assets', 15 );

/**
 * Handle homepage stream subscription submissions.
 *
 * @return void
 */
function bookingkoro_handle_stream_subscription() {
	$redirect_url = wp_get_referer();

	if ( ! $redirect_url ) {
		$redirect_url = home_url( '/' );
	}

	$redirect_url = remove_query_arg( 'bkor_subscribed', $redirect_url );
	$redirect_url = add_query_arg( 'bkor_stream', '1', $redirect_url );

	if ( ! isset( $_POST['bookingkoro_stream_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bookingkoro_stream_nonce'] ) ), 'bookingkoro_stream_subscribe' ) ) {
		wp_safe_redirect( add_query_arg( 'bkor_subscribed', 'invalid', $redirect_url ) );
		exit;
	}

	$email = isset( $_POST['bkor_subscriber_email'] ) ? sanitize_email( wp_unslash( $_POST['bkor_subscriber_email'] ) ) : '';

	if ( '' === $email || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'bkor_subscribed', 'invalid', $redirect_url ) );
		exit;
	}

	$site_name = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	$subject   = sprintf(
		/* translators: %s: site name. */
		__( 'New BookingKoro subscription from %s', 'bookingkoro' ),
		$site_name
	);
	$message   = sprintf(
		/* translators: 1: subscriber email, 2: site name, 3: date and time. */
		__( "A new homepage subscription was submitted.\n\nSubscriber email: %1\$s\nSite: %2\$s\nSubmitted at: %3\$s", 'bookingkoro' ),
		$email,
		$site_name,
		wp_date( 'Y-m-d H:i:s T' )
	);
	$headers   = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $email,
	);
	$sent      = wp_mail( 'subscription@bookingkoro.com', $subject, $message, $headers );

	wp_safe_redirect( add_query_arg( 'bkor_subscribed', $sent ? 'success' : 'failed', $redirect_url ) );
	exit;
}
add_action( 'admin_post_nopriv_bookingkoro_stream_subscription', 'bookingkoro_handle_stream_subscription' );
add_action( 'admin_post_bookingkoro_stream_subscription', 'bookingkoro_handle_stream_subscription' );


// add_filter( 'atbdp_listing_search_query_argument', 'directorist_custom_order_by_event_date_desc' );
// add_filter( 'directorist_all_listings_query_arguments', 'directorist_custom_order_by_event_date_desc' );

// function directorist_custom_order_by_event_date_desc( $args ) {
// 	$per_page = $args['posts_per_page'];
// 	$args1 = $args2 = $args;
// 	$args1['meta_query']['_custom-date'] = 
// 		[
// 			'key' => '_custom-date',
// 			'compare' => 'EXISTS',
// 		];
// 	$args1['orderby'] = '_custom-date';
// 	$args1['order'] = 'DESC';
// 	$args1['fields'] = 'ids';
// 	$args1['posts_per_page'] = -1;

// 	$listings1 = new WP_Query($args1);
	
// 	$args2['meta_query']['_custom-date'] = 
// 		[
// 			'key' => '_custom-date',
// 			'compare' => 'NOT EXISTS',
// 		];
// 	$args2['fields'] = 'ids';
// 	$args2['posts_per_page'] = -1;

// 	$listings2 = new WP_Query($args2);

// 	$listings = array_merge($listings1->posts, $listings2->posts);

// 	if( count($listings) > 0 ){
// 		$args['post__in'] = $listings;
// 		$args['orderby'] = 'post__in';
// 		$args['posts_per_page'] = $per_page;
// 	}

// 	return $args;
// }
