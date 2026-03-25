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

$home_data = bookingkoro_get_home_data();

$topic_sections = array(
	'activity' => array(
		'key'   => 'activity_items',
		'label' => __( 'Activity', 'bookingkoro' ),
		'slug'  => 'activity',
	),
	'event'    => array(
		'key'   => 'event_items',
		'label' => __( 'Event', 'bookingkoro' ),
		'slug'  => 'event',
	),
	'service'  => array(
		'key'   => 'service_items',
		'label' => __( 'Service', 'bookingkoro' ),
		'slug'  => 'service',
	),
	'stays'    => array(
		'key'   => 'stays_items',
		'label' => __( 'Stays', 'bookingkoro' ),
		'slug'  => 'stays',
	),
	'vehicle'  => array(
		'key'   => 'vehicle_items',
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
		$topic_section_items = isset( $home_data[ $topic_section_config['key'] ] ) && is_array( $home_data[ $topic_section_config['key'] ] )
			? $home_data[ $topic_section_config['key'] ]
			: array();
			get_bookingkoro_template( 'home', 'topic-cards', array( 'topic_section_config' => $topic_section_config, 'topic_section_items' => $topic_section_items ) );
	}
	?>

	<?php get_template_part( 'template-parts/home/how-it-works' ); ?>

	<?php get_template_part( 'template-parts/home/stream' ); ?>

</div>

<?php
get_footer();
