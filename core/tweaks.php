<?php
/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since Stark 1.0
 */
function stark_page_menu_args( $args ) {
    $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'stark_page_menu_args' );
 
/**
 * Adds custom classes to the array of body classes.
 *
 * @since Stark 1.0
 */
function stark_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }
 
    return $classes;
}
add_filter( 'body_class', 'stark_body_classes' );
 
/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since Stark 1.0
 */
function stark_enhanced_image_navigation( $url, $id ) {
    if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
        return $url;
 
    $image = get_post( $id );
    if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
        $url .= '#main';
//	$url .= '.content';
 
    return $url;
}
add_filter( 'attachment_link', 'stark_enhanced_image_navigation', 10, 2 );


/**
 *
 * Extract the occurance of text from a string
 */
function stark_extract_string($start, $end, $string) {
	$string = stristr($string, $start);
	$trimmed = stristr($string, $end);
	return substr($string, strlen($start), -strlen($trimmed));
}


// Get the text & url from the first link in the content

function stark_link() {
	$output = array();	
	$content = get_the_content();
	$output['ctnt'] = stristr($content,'<a href=',true );
	$link_string = stark_extract_string('<a href=', '/a>', $content);
	$link_bits = explode('"', $link_string);
	foreach( $link_bits as $bit ) {
		if( substr($bit, 0, 1) == '>') $link_text = substr($bit, 1, strlen($bit)-2);
		if( substr($bit, 0, 4) == 'http') $link_url = $bit;
	}

	if( isset($link_text)) {
		$output['link_text'] = $link_text;
	}

	 if ( isset($link_url) ) {
		$output['link_url'] = $link_url;
	}

	if ( isset($output['link_url'] ) ) {
		return $output;
	}

	else {
		return false;
	}
}

//add social icons
function stark_social_options_header() {
	$stark_options = stark_get_global_options();
?>
	<div id="social"><ul>
	<?php 
		if( !empty( $stark_options['wp_stk_fb_input'] ) ) { ?>
		<li><a href="<?php echo $stark_options['wp_stk_fb_input']; ?>" target="_blank" ><img src="<?php echo get_template_directory_uri(); ?>/images/social/facebook.png" alt="facebook" /></a></li>
	<?php
		} //if loop end

		if( !empty( $stark_options['wp_stk_tweet_input'] ) ) { ?>
		<li><a href="<?php echo $stark_options['wp_stk_tweet_input']; ?>" target="_blank" ><img src="<?php echo get_template_directory_uri(); ?>/images/social/twitter.png" alt="Twitter" /></a></li>
	<?php
		} //if loop end

		if( !empty($stark_options['wp_stk_gplus_input'] ) ) { ?>
		<li><a href="<?php echo $stark_options['wp_stk_gplus_input']; ?>" target="_blank" ><img src="<?php echo get_template_directory_uri(); ?>/images/social/gplus.png" alt="GooglePlus" /></a></li>
	<?php
		} //if loop end

		if( !empty($stark_options['wp_stk_ytube_input'] ) ) { ?>
		<li><a href="<?php echo $stark_options['wp_stk_ytube_input']; ?>" ><img src="<?php echo get_template_directory_uri(); ?>/images/social/youtube.png" alt="youtube" /></a></li>
	<?php
		} //if loop end

		if( !empty($stark_options['wp_stk_email_input'] ) ) { ?>
		<li><a href="mailto:<?php echo antispambot( $stark_options['wp_stk_email_input'], 1 ); ?>" ><img src="<?php echo get_template_directory_uri(); ?>/images/social/email.png" alt="email" /></a></li>
	<?php
		} //if loop end ?>

	</ul>
	</div>
<?php
}

add_action( 'stark_header', 'stark_social_options_header' );
