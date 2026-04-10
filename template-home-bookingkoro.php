<?php
/**
 * Template Name: BookingKoro Homepage
 *
 * Homepage for bookingkoro.com. Data from assets/data/home-data.json.
 * Sections are split into template parts under template-parts/home/.
 *
 * @package BookingKoro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$topic_sections = array(
	'activity' => array(
		'label' => __( 'Activity', 'bookingkoro' ),
		'slug'  => 'activity',
	),
	'event'    => array(
		'label' => __( 'Event', 'bookingkoro' ),
		'slug'  => 'event',
	),
	'service'  => array(
		'label' => __( 'Service', 'bookingkoro' ),
		'slug'  => 'service',
	),
	'stays'    => array(
		'label' => __( 'Stays', 'bookingkoro' ),
		'slug'  => 'stays',
	),
	'vehicle'  => array(
		'label' => __( 'Vehicle', 'bookingkoro' ),
		'slug'  => 'vehicle',
	),
);
?>

<div class="bookingkoro-home-content">

	<?php get_template_part( 'template-parts/home/hero' ); ?>

	<?php get_template_part( 'template-parts/home/categories' ); ?>

	<?php get_template_part( 'template-parts/home/recommended-vehicles' ); ?>

	<?php
	foreach ( $topic_sections as $topic_section_config ) {
		$topic_section_items = bookingkoro_get_topic_section_items( $topic_section_config['slug'] );

		get_template_part(
			'template-parts/home/topic-cards',
			null,
			array(
				'topic_section_config' => $topic_section_config,
				'topic_section_items'  => $topic_section_items,
			)
		);
	}
	?>

	<?php get_template_part( 'template-parts/home/how-it-works' ); ?>

	<?php get_template_part( 'template-parts/home/stream' ); ?>

</div>

<?php
get_footer();
