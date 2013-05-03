<?php
/**
 * Define our settings sections
 * @since Stark 1.0
 * @author Nithin K R
 * array key=$id, array value=$title in: add_settings_section( $id, $title, $callback, $page );
 * @return array
 */
function stk_options_page_section() {

	$section = array();
	// $sections[$id] 				= __($title, 'stark');
	
	$section['header_section'] = __( 'Header Option', 'stark' );
	$section['logo_section']   = __( 'Logo Option', 'stark' );
	$section['social_section'] = __( 'Social', 'stark' );
	
	return $section;
}

/**
 * Define our form fields (settings) 
 *
 * @return array
 */
function stk_options_page_fields(){


	/**
	Header Section
	-----------------------------
	**/

	$options[] = array(
		"section" => "header_section",
		"id"      => STARK_SHORT . "_header_checkbox_input",
		"title"   => __( 'Disable header color', 'stark' ),
		"desc"    => __( 'Disables the default background color ie Black', 'stark' ),
		"type"    => "checkbox",
		"std"     =>  0 // 0 for off
	);

	/**
	Logo Section
	-----------------------------
	**/

	$options[] = array(
		"section" => "logo_section",
		"id"	  => STARK_SHORT."_logo_input",
		"title"	  => __( 'Logo', 'stark' ),
		"desc"    => __( 'Upload an image from the banner', 'stark' ),
		"type"    => "file",
		"std"	  => __( 'Upload your logo', 'stark' ),
	);
	
	$options[] = array(
		"section" => "logo_section",
		"id"      => STARK_SHORT."_logo_preview",
		"title"   => __( 'Logo Preview', 'stark' ),
		"desc"	  => __( 'Note: The header text should be disabled for the logo to appear.', 'stark' ),
		"type"	  => "file_preview",
		"std"     => __( 'Default preview', 'stark' ),

	);


	/**
	Social Section
	-----------------------------
	**/

	$options[] = array(
		"section" => "social_section",
		"id"	  => STARK_SHORT."_fb_input",
		"title"	  => __( 'Facebook URL', 'stark' ),
		"desc"	  => __( 'Links to your Facebook Page, "Leave the respective fields blank to disable it"', 'stark' ),
		"type"	  => "text",
		"std"	  => __( 'http://www.facebook.com', 'stark' ),
		"class"	  => "url"
	);
	
	$options[] = array(
		"section" => "social_section",
		"id"	  => STARK_SHORT."_tweet_input",
		"title"	  => __( 'Twitter URL', 'stark' ),
		"desc"	  => __( 'Links to your Twitter Page', 'stark' ),
		"type"	  => "text",
		"std"	  => __( 'http://www.twitter.com/', 'stark' ),
		"class"	  => "url"
	);

	$options[] = array(
		"section" => "social_section",
		"id"	  => STARK_SHORT."_gplus_input",
		"title"	  => __( 'Google Plus URL', 'stark' ),
		"desc"	  => __( 'Links to your Google Page', 'stark' ),
		"type"	  => "text",
		"std"	  => __( 'http://google.com', 'stark' ),
		"class"	  => "url"
	);

	$options[] = array(
		"section" => "social_section",
		"id"	  => STARK_SHORT."_ytube_input",
		"title"	  => __( 'Youtube Channel', 'stark' ),
		"desc"	  => __( 'Links to your Youtube Page', 'stark' ),
		"type"	  => "text",
		"std"	  => __( 'http://www.youtube.com', 'stark' ),
		"class"	  => "url"
	);

	$options[] = array(
		"section" => "social_section",
		"id"	  => STARK_SHORT."_email_input",
		"title"	  => __( 'Email', 'stark' ),
		"desc"	  => __( 'Links to your email id, Spam protected.', 'stark' ),
		"type"	  => "text",
		"std"	  => __( 'stark@example.com', 'stark' ),
		"class"	  => "email"
	);
	
	return $options;
}
?>
