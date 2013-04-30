<?php
/**
 * General Functions
 *
 * @uses add_theme_support() To add support for custom headers,custom background.
 * loads theme-options page
 *
 * @package Stark
 * @since Stark 1.0
 * @author Nithin K R
 */

/**
* Custom Theme Options
*/
if( is_admin() ) {	
	//require only in admin!
	require_once( get_template_directory() . '/inc/stark-theme-options.php' );
}

/**
 * Collects our theme options
 *
 * @return array
 */
function stark_get_global_options(){
	
	$stark_option = array();

	$stark_option 	= get_option( 'stark_options' );
	
return $stark_option;

}

/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...
 *
 * @package Stark
 * @since Stark 1.0
 */

	// Add support for custom headers.
	$custom_header_support = array(
		'flex-width'    => true,
		'width'         => 940,
		'flex-height'    => true,
		'height'        => 200,
		'default-text-color' => '808080',
		'wp-head-callback' => 'stark_header_style',
		// Callback for styling the header preview in the admin.
		'admin-head-callback' => 'stark_admin_header_style',
		//callback use to display the header preview
		'admin-preview-callback' => 'stark_admin_header_image',
	);

	add_theme_support( 'custom-header', $custom_header_support );



	// Add support for custom backgrounds
	$custom_bck_support=array(
		'wp-head-callback' => 'stark_change_custom_background_cb'
	);

function stark_change_custom_background_cb() {
	$background = get_background_image();  
	$color = get_background_color();  
	if ( ! $background && ! $color )  
        	return;  
	$style = $color ? "background-color: #$color;" : '';  $norepeat=''; $attach='';
	if ( $background ) {  
		$image = " background-image: url('$background');";

		$repeat = get_theme_mod( 'background_repeat', 'repeat' );
		if ($repeat == "no-repeat"){ $norepeat = $repeat;}
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
			$repeat = 'repeat';
		$repeat = " background-repeat: $repeat;";

		$position = get_theme_mod( 'background_position_x', 'left' );
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
			$position = 'left';
		$position = " background-position: top $position;";

		$attachment = get_theme_mod( 'background_attachment', 'scroll' );
		 if ( $attachment == "fixed" ) { $attach = $attachment; }
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
			$attachment = 'scroll';
		$attachment = " background-attachment: $attachment;";

		$style .= $image . $repeat . $position . $attachment;
	}

	if ( ( $norepeat != '' ) && ( $attach != '' ) ) {
?>
	<style type="text/css" id="custom-background-css">
	html { <?php echo trim( $style ); ?>
		background-size: cover;
		}
	</style>
<?php
	}
	else {
?>	
<style type="text/css" id="custom-background-css">
html { <?php echo trim( $style ); ?> }
</style> 
<?php
	}//else
} //function end



// Add support for custom backgrounds.
	add_theme_support( 'custom-background', $custom_bck_support);



//Add support for custom header


 
/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backward compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @todo Remove this function when WordPress 3.6 is released.
 * @return stdClass All properties represent attributes of the curent header image.
 *
 * @package Stark
 * @since Stark 1.0
 */
if ( ! function_exists( 'get_custom_header' ) ) {
		// This is all for compatibility with versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR', $custom_header_support['default-text-color'] );
		define( 'HEADER_IMAGE', '' );
		define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
		add_custom_image_header( $custom_header_support['wp-head-callback'], $custom_header_support['admin-head-callback'], $custom_header_support['admin-preview-callback'] );
		add_custom_background();
	}

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @uses stark_header_style()
 * @uses stark_admin_header_style()
 * @uses stark_admin_header_image()
 *
 * @package Stark
 */

if ( ! function_exists( 'stark_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @since Stark 1.0
 */
function stark_header_style() {
	$text_color = get_header_textcolor();


	if ( $text_color == "808080" ) :

?>	<style>
	.site-header{
		background-image: url('<?php header_image(); ?>');
	}
	</style>
<?php

	return;

else:
	// If no custom options for text are set, let's bail.
	if ( $text_color == HEADER_TEXTCOLOR )

		return;

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo $text_color; ?> !important;
		}

	<?php endif; ?>

.site-header{
		background-image: url('<?php header_image(); ?>');
	}
	</style>
	<?php
endif;
}
endif; // stark_header_style

if ( ! function_exists( 'stark_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') 
 *
 * @since Stark 1.0
 */
function stark_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#desc {
		font-family: "Helvetica Neue", Arial, Helvetica, "Nimbus Sans L", sans-serif;
	}
	#headimg h1 {
		margin: 0;
		padding: 20px 0;
	}
	#headimg h1 a {
		font-size: 32px;
		line-height: 36px;
		text-decoration: none;
	}
	#desc {
		font-size: 14px;
		line-height: 23px;
		padding: 0 0 3em;
	}
	<?php
		// If the user has set a custom color for the text use that
		if ( get_header_textcolor() != HEADER_TEXTCOLOR ) :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	#headimg img {
		max-width: 1000px;
		height: auto;
		width: 100%;
	}
	</style>
<?php
}
endif; // stark_admin_header_style

if ( ! function_exists( 'stark_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header')
 *
 * @since Stark 1.0
 */
function stark_admin_header_image() { ?>
	<div id="headimg">
		<?php
		$color = get_header_textcolor();
		$image = get_header_image();
		if ( $color && $color != 'blank' )
			$style = ' style="color:#' . $color . '"';
		else
			$style = ' style="display:none"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( $image ) : ?>
			<img src="<?php echo esc_url( $image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php
}

endif; // stark_admin_header_image


/**
 *
 *To link all Post Thumbnails on your website to the Post Permalink
 */
function stark_post_image_html( $html, $post_id, $post_image_id ) {

	$html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . $html . '</a>';
	return $html;

}

add_filter( 'post_thumbnail_html', 'stark_post_image_html', 10, 3 );

if ( ! function_exists( 'stark_default_menu' ) ) :
/**
 *
 * Default Menu when the primary menu is not assigned
 *
**/

function stark_default_menu() {
?>
	<ul id="navigation">
	<?php wp_list_pages('title_li='); ?> 
	</ul>
<?php
}

endif;

/**
 *
 *	Prints out the Title and Content for the link
 *
**/

if ( ! function_exists( 'stark_display_link' ) ) :

function stark_display_link() {
	$stk = array();
	$stk = stark_link();
	extract( $stk );
?>
	<h2>
		<a href="<?php echo $link_url ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'stark' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?><span></span></a>
	</h2>
<?php
	echo $ctnt;

}

endif;

/**
 Theme Options Header settings
-----------------------------
**/

function stark_header_options() {

$stark_options = stark_get_global_options();

if ( isset( $stark_options['wp_stk_header_checkbox_input'] ) ) {

	if ( $stark_options['wp_stk_header_checkbox_input'] == 1 ){
?>
	<style type="text/css">
	.site-header {
		border: 0;
		background: rgba(0,0,0,0);
		background-repeat: no-repeat;
		background-size: 100%;
		box-shadow: none;


	}
	</style> 
<?php
	} // end of if

} //end of isset

} //end of function

add_action( 'wp_head', 'stark_header_options' );
