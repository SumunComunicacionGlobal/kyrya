<?php
/**
 * Understrap enqueue scripts
 *
 * @package understrap
 */

if ( ! function_exists( 'understrap_scripts' ) ) {
	/**
	 * Load theme's JavaScript sources.
	 */
	function understrap_scripts() {
		// Get the theme data.
		$the_theme = wp_get_theme();
		wp_enqueue_style( 'animaciones', get_stylesheet_directory_uri() . '/css/animate.css', array(), '3.6.0', false );
		wp_enqueue_style( 'kyrya', get_stylesheet_directory_uri() . '/css/theme.min.css', array(), $the_theme->get( 'Version' ), false );
		wp_enqueue_script( 'jquery');
		// wp_enqueue_script( 'popper-scripts', get_template_directory_uri() . '/js/popper.min.js', array(), true);
		wp_enqueue_script( 'understrap-scripts', get_template_directory_uri() . '/js/theme.min.js', array(), $the_theme->get( 'Version' ), true );
		wp_enqueue_script( 'viewport-checker', get_template_directory_uri() . '/js/jquery.viewportchecker.min.js', array('jquery') , '1.8.8', true );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
} // endif function_exists( 'understrap_scripts' ).

add_action( 'wp_enqueue_scripts', 'understrap_scripts' );

function wpdocs_dequeue_script() {
    wp_dequeue_script( 'uacf7-country-select-script' );
}
add_action( 'wp_print_scripts', 'wpdocs_dequeue_script', 100 );