<?php 
/**
 * Stark functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package Stark
 * @since Stark 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 570; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override stark_setup() in a child theme, add your own stark_setup to your child theme's
 * functions.php file.
 *
 * @uses add_editor_style() To style the visual editor.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links, and post formats.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Stark 1.0
 */

if ( ! function_exists( 'stark_setup' ) ):
function stark_setup() {
	/*
	 * Makes Stark available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 *
	 */


	load_theme_textdomain( 'stark', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	/**
	* Custom template tags for this theme.
	*/
	require( get_template_directory() . '/core/stark-template-tags.php' );

	require( get_template_directory(). '/core/tweaks.php' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'stark' ) );

	/**
	* Enable support for the Aside and Link Post Format
	*/
	add_theme_support( 'post-formats', array( 'aside', 'link' ) );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );
}
endif; // stark_setup

/**
 * Tell WordPress to run stark_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'stark_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Stark 1.0
 */
function stark_widgets_init() {
	register_sidebar( array(
		'name'	=> __('Primay Sidebar', 'stark' ),
		'id'    => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
 	) );

	register_sidebar( array(
		'name' => __( 'Footer 1', 'stark' ),
		'id' => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title' => '<h3 class="footer-title">',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Footer 2', 'stark' ),
		'id' => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title' => '<h3 class="footer-title">',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Footer 3', 'stark' ),
		'id' => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title' => '<h3 class="footer-title">',
		'after_title' => '</h3>'
	) );
}
add_action( 'widgets_init', 'stark_widgets_init' );			 
   			 
/**
 * Implement the Custom feature functions
 */
require( get_template_directory() . '/core/core-functions.php' );

/**
 * Enqueue scripts and styles
 */
function stark_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
 
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && wp_attachment_is_image() ) {
	wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'stark_scripts' );


/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Stark 1.0
 *
 * @param string $title Default title text for current view.
 * @return string Filtered title.
 *
 */
function stark_filter_wp_title( $title ) {
    // Get the Site Name
    $site_name = get_bloginfo( 'name' );
    // Prepend it to the default output
    $filtered_title = $site_name . $title;
    // Return the modified title
    return $filtered_title;
}
// Hook into 'wp_title'
add_filter( 'wp_title', 'stark_filter_wp_title', 10, 2);
