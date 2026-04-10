<?php
/**
 * Homepage topic-card data provider for Directorist listings.
 *
 * @package BookingKoro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BookingKoro_Home_Topic_Cards' ) ) {
	/**
	 * Build homepage topic-card data from Directorist listings.
	 */
	class BookingKoro_Home_Topic_Cards {

		/**
		 * Default number of listings to render in each topic section.
		 *
		 * @var int
		 */
		const DEFAULT_LIMIT = 12;

		/**
		 * Get listing cards for a homepage directory-type section.
		 *
		 * @param string $directory_type_slug Directory-type term slug.
		 * @param int    $limit               Listings per section.
		 * @return array<int, array<string, string>>
		 */
		public static function get_items_for_directory_type( $directory_type_slug, $limit = self::DEFAULT_LIMIT ) {
			$directory_type_slug = sanitize_title( $directory_type_slug );
			$limit               = absint( $limit );

			if ( '' === $directory_type_slug || 0 === $limit || ! self::is_available() ) {
				return array();
			}

			$query_args = array(
				'post_type'              => self::get_post_type(),
				'post_status'            => 'publish',
				'posts_per_page'         => $limit,
				'orderby'                => 'date',
				'order'                  => 'DESC',
				'ignore_sticky_posts'    => true,
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'tax_query'              => array(
					array(
						'taxonomy' => self::get_directory_type_taxonomy(),
						'field'    => 'slug',
						'terms'    => array( $directory_type_slug ),
					),
				),
			);

			/**
			 * Filters homepage topic-card listing query arguments.
			 *
			 * @param array  $query_args          WP_Query arguments.
			 * @param string $directory_type_slug Directory-type slug.
			 */
			$query_args = apply_filters( 'bookingkoro_home_topic_cards_query_args', $query_args, $directory_type_slug );

			$listings = new WP_Query( $query_args );

			if ( empty( $listings->posts ) ) {
				return array();
			}

			$items = array();

			foreach ( $listings->posts as $listing ) {
				if ( ! $listing instanceof WP_Post ) {
					continue;
				}

				$item = self::build_card_item( $listing );

				if ( empty( $item ) ) {
					continue;
				}

				$items[] = $item;
			}

			return $items;
		}

		/**
		 * Determine if Directorist topic-card queries can run safely.
		 *
		 * @return bool
		 */
		private static function is_available() {
			return post_type_exists( self::get_post_type() )
				&& taxonomy_exists( self::get_directory_type_taxonomy() )
				&& taxonomy_exists( self::get_category_taxonomy() );
		}

		/**
		 * Build one card item from a listing post.
		 *
		 * @param WP_Post $listing Listing post object.
		 * @return array<string, string>
		 */
		private static function build_card_item( WP_Post $listing ) {
			$title = get_the_title( $listing );
			$url   = get_permalink( $listing );

			if ( '' === $title || ! $url ) {
				return array();
			}

			$category_term = self::get_listing_category_term( $listing->ID );
			$meta          = $category_term instanceof WP_Term
				? $category_term->name
				: self::get_listing_summary( $listing );
			$icon_html     = $category_term instanceof WP_Term
				? self::get_category_icon_html( $category_term )
				: '';

			return array(
				'title'     => $title,
				'meta'      => $meta,
				'url'       => $url,
				'icon_html' => $icon_html,
				'image_url' => self::get_listing_image_url( $listing->ID ),
			);
		}

		/**
		 * Get a short fallback summary for a listing.
		 *
		 * @param WP_Post $listing Listing post object.
		 * @return string
		 */
		private static function get_listing_summary( WP_Post $listing ) {
			$excerpt = has_excerpt( $listing )
				? $listing->post_excerpt
				: wp_strip_all_tags( $listing->post_content );

			$excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ) );

			if ( '' === $excerpt ) {
				return '';
			}

			return wp_trim_words( $excerpt, 6, '...' );
		}

		/**
		 * Get the first assigned listing category term.
		 *
		 * @param int $listing_id Listing ID.
		 * @return WP_Term|null
		 */
		private static function get_listing_category_term( $listing_id ) {
			$terms = wp_get_post_terms(
				$listing_id,
				self::get_category_taxonomy(),
				array(
					'number' => 1,
				)
			);

			if ( is_wp_error( $terms ) || empty( $terms[0] ) || ! $terms[0] instanceof WP_Term ) {
				return null;
			}

			return $terms[0];
		}

		/**
		 * Render category icon HTML.
		 *
		 * @param WP_Term $category_term Category term.
		 * @return string
		 */
		private static function get_category_icon_html( WP_Term $category_term ) {
			$icon = get_term_meta( $category_term->term_id, 'category_icon', true );

			if ( ! is_string( $icon ) || '' === trim( $icon ) || ! function_exists( 'directorist_icon' ) ) {
				return '';
			}

			$icon_html = directorist_icon( $icon, false );

			return is_string( $icon_html ) ? $icon_html : '';
		}

		/**
		 * Resolve a listing image URL from Directorist media helpers.
		 *
		 * Fallback order:
		 * 1. Listing preview image.
		 * 2. First gallery image.
		 * 3. Listing-type default preview image.
		 * 4. Directorist default preview image, with a child-theme asset URL fallback.
		 *
		 * @param int $listing_id Listing ID.
		 * @return string
		 */
		private static function get_listing_image_url( $listing_id ) {
			$image_id = 0;

			if ( function_exists( 'directorist_get_listing_preview_image' ) ) {
				$image_id = absint( directorist_get_listing_preview_image( $listing_id ) );
			}

			if ( 0 === $image_id && function_exists( 'directorist_get_listing_gallery_images' ) ) {
				$gallery_images = directorist_get_listing_gallery_images( $listing_id );

				if ( is_array( $gallery_images ) && ! empty( $gallery_images[0] ) ) {
					$image_id = absint( $gallery_images[0] );
				}
			}

			if ( $image_id > 0 ) {
				$image_url = wp_get_attachment_image_url( $image_id, 'medium_large' );

				if ( is_string( $image_url ) && '' !== $image_url ) {
					return $image_url;
				}
			}

			$listing_type_id = self::get_listing_directory_id( $listing_id );

			if ( $listing_type_id > 0 && function_exists( 'directorist_get_directory_general_settings' ) ) {
				$directory_settings = directorist_get_directory_general_settings( $listing_type_id );

				if ( ! empty( $directory_settings['preview_image'] ) && is_string( $directory_settings['preview_image'] ) ) {
					return esc_url_raw( $directory_settings['preview_image'] );
				}
			}

			if ( function_exists( 'get_directorist_option' ) ) {
				$default_image = get_directorist_option( 'default_preview_image', self::get_theme_default_image_url() );

				if ( is_string( $default_image ) && '' !== $default_image ) {
					return esc_url_raw( $default_image );
				}
			}

			return self::get_theme_default_image_url();
		}

		/**
		 * Get the listing directory type ID.
		 *
		 * @param int $listing_id Listing ID.
		 * @return int
		 */
		private static function get_listing_directory_id( $listing_id ) {
			if ( function_exists( 'directorist_get_listing_directory' ) ) {
				return absint( directorist_get_listing_directory( $listing_id ) );
			}

			$terms = wp_get_post_terms(
				$listing_id,
				self::get_directory_type_taxonomy(),
				array(
					'number' => 1,
					'fields' => 'ids',
				)
			);

			if ( is_wp_error( $terms ) || empty( $terms[0] ) ) {
				return 0;
			}

			return absint( $terms[0] );
		}

		/**
		 * Get the child-theme fallback preview image URL.
		 *
		 * @return string
		 */
		private static function get_theme_default_image_url() {
			return esc_url_raw( get_stylesheet_directory_uri() . '/assets/img/defaults/listing_preview_image.png' );
		}

		/**
		 * Resolve the Directorist listing post type.
		 *
		 * @return string
		 */
		private static function get_post_type() {
			return defined( 'ATBDP_POST_TYPE' ) ? ATBDP_POST_TYPE : 'at_biz_dir';
		}

		/**
		 * Resolve the Directorist directory-type taxonomy.
		 *
		 * @return string
		 */
		private static function get_directory_type_taxonomy() {
			return defined( 'ATBDP_DIRECTORY_TYPE' ) ? ATBDP_DIRECTORY_TYPE : 'atbdp_listing_types';
		}

		/**
		 * Resolve the Directorist category taxonomy.
		 *
		 * @return string
		 */
		private static function get_category_taxonomy() {
			return defined( 'ATBDP_CATEGORY' ) ? ATBDP_CATEGORY : self::get_post_type() . '-category';
		}
	}
}
