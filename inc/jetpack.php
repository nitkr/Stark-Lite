<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Stark Lite
 * @since 1.0.5
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function stark_infinite_scroll_setup() {
	add_theme_support( 'infinite-scroll', array(

		'container' => 'content',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'stark_infinite_scroll_setup' );
