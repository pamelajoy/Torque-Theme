<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package torque
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function tq_theme_prefix_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'tq_theme_prefix_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function tq_theme_prefix_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'tq_theme_prefix_pingback_header' );
