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

function get_bookingkoro_template( $parent_template, $child_template, $args = array() ){
	if( $args && count( $args ) > 0 ){
		extract( $args );
	}
	if( ! empty( $parent_template ) && ! empty( $child_template ) ){
		include get_stylesheet_directory() . '/template-parts' . '/' . $parent_template . '/' . $child_template . '.php';
	} elseif( ! empty( $child_template ) ) {
		include get_stylesheet_directory() . '/template-parts' . $child_template . '.php';
	} else {
		return;
	}
}

/**
 * Add body class when BookingKoro Homepage template is used.
 *
 * @param array $classes Existing body classes.
 * @return array Modified body classes.
 */
function bookingkoro_body_class( $classes ) {
	if ( is_page_template( 'template-home-bookingkoro.php' ) ) {
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

	$json = file_get_contents( $path );
	if ( false === $json ) {
		$data = array();
		return $data;
	}

	$decoded = json_decode( $json, true );
	if ( ! is_array( $decoded ) ) {
		$data = array();
		return $data;
	}

	$data = apply_filters( 'bookingkoro_homepage_data', $decoded );
	return $data;
}

/**
 * Enqueue global header/footer styles on all pages. Homepage template gets Splide + home JS.
 */
function bookingkoro_enqueue_styles() {
	$theme   = wp_get_theme();
	$version = $theme->get( 'Version' );
	$uri     = get_stylesheet_directory_uri();
	$path    = get_stylesheet_directory() . '/assets/css/home.css';

	$bookingkoro_home_deps = array( 'generate-style' );

	// Homepage: Splide carousel (hero) — CSS/JS only on BookingKoro home template.
	if ( is_page_template( 'template-home-bookingkoro.php' ) ) {
		$splide_version = '4.1.4';
		wp_enqueue_style(
			'splide',
			'https://cdn.jsdelivr.net/npm/@splidejs/splide@' . $splide_version . '/dist/css/splide.min.css',
			array(),
			$splide_version
		);
		$bookingkoro_home_deps[] = 'splide';

		wp_enqueue_script(
			'splide',
			'https://cdn.jsdelivr.net/npm/@splidejs/splide@' . $splide_version . '/dist/js/splide.min.js',
			array(),
			$splide_version,
			true
		);

		$js_path = get_stylesheet_directory() . '/assets/js/home.js';
		wp_enqueue_script(
			'bookingkoro-home',
			$uri . '/assets/js/home.js',
			array( 'splide' ),
			file_exists( $js_path ) ? filemtime( $js_path ) : $version,
			true
		);
	}

	// Header and footer CSS everywhere for consistent look and feel.
	wp_enqueue_style(
		'bookingkoro-home',
		$uri . '/assets/css/home.css',
		$bookingkoro_home_deps,
		$version && file_exists( $path ) ? filemtime( $path ) : $version
	);

	// Directorist single listing: improved layout and card design.
	if ( is_singular( 'at_biz_dir' ) ) {
		$single_path = get_stylesheet_directory() . '/assets/css/directorist-single.css';
		wp_enqueue_style(
			'bookingkoro-directorist-single',
			$uri . '/assets/css/directorist-single.css',
			array( 'directorist-main-style', 'bookingkoro-home' ),
			file_exists( $single_path ) ? filemtime( $single_path ) : $version
		);
	}

	// Directorist all listings / archive: search, filters, grid and pagination.
	$archive_slugs = array( 'all-listings', 'search-result' );
	$archive_slugs = apply_filters( 'bookingkoro_directorist_archive_page_slugs', $archive_slugs );
	if ( is_page( $archive_slugs ) ) {
		$archive_path = get_stylesheet_directory() . '/assets/css/directorist-archive.css';
		wp_enqueue_style(
			'bookingkoro-directorist-archive',
			$uri . '/assets/css/directorist-archive.css',
			array( 'directorist-main-style', 'bookingkoro-home' ),
			file_exists( $archive_path ) ? filemtime( $archive_path ) : $version
		);
	}
}
add_action( 'wp_enqueue_scripts', 'bookingkoro_enqueue_styles', 15 );


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