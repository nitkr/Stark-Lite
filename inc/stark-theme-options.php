<?php
/**
 * Stark Theme Options
 *
 */


/**
 * Define Constants
 */
define( 'STARK_SHORT', 'wp_stk' );				// used to prefix the individual setting field id see stk_options_page_fields()
define( 'STARK_PAGE_BASENAME', 'stark-theme-settings' );	// the settings page slug

/**
 * Include the required files
 */
	// page settings sections & fields as well as the contextual help text.
	require_once( get_template_directory(). '/core/stark-settings.php' );

/**
 *	Admin Page
 */
function stark_add_menu(){
	global $stark_settings_page;
	$stark_settings_page = add_theme_page( 
		__( 'Theme Options', 'stark' ),    //  Page title
		__( 'Theme Options', 'stark' ),   // Menu title
		'edit_theme_options',			   //Capability
		STARK_PAGE_BASENAME, 			  //Menu slug
		'stark_settings_page'			 //Function that renders the options page
	);
}

/**
 * Specify Hooks/Filterrs
 */
add_action( 'admin_menu', 'stark_add_menu' );

/**
 * Function for defining variables for the current page
 *
 * @return array
 */
function stark_get_settings() {

	$output=array();

	$output['wp_option_name']   = 'stark_options';					//option name
	$output['wp_page_title']    = __( 'Stark Settings Page', 'stark' );  //Page title
	$output['wp_page_sections'] = stk_options_page_section();		      //The section settings
	$output['wp_page_fields']   = stk_options_page_fields();		     //The field settings
	
	return $output;
}


/*
 * Function for registering form field settings
 *
 */

function stark_create_settings_field( $args = array() ) {
	// default array to overwrite when calling the function
	$defaults = array(
		'id'      => 'default_field', 				// the ID of the setting in our options array, and the ID of the HTML form element
		'title'   => 'Default Field', 			       // the label for the HTML form element
		'desc'    => 'This is a default description.', 	      // the description displayed under the HTML form element
		'std'     => '', 				     // the default value for this setting
		'type'    => 'text', 				    // the HTML form element to use
		'section' => 'main_section',			   // the section this setting belongs to must match the array key of a section in stk_options_page_sections()
		//'choices' => array(), 		          // (optional): the values in radio buttons or a drop-down menu
		'class'   => '' 				 // the HTML form element class. Is used for validation purposes and may be also use for styling if needed.
	);
	
	// "extract" to be able to use the array keys as variables in our function output below
	extract( wp_parse_args( $args, $defaults ) );
	
	// additional arguments for use in form field output in the function stark_form_field_fn!
	$field_args = array(
		'type'      => $type,
		'id'        => $id,
		'desc'      => $desc,
		'std'       => $std,
		//'choices'   => $choices,
		'label_for' => $id,
		'class'     => $class
	);

	add_settings_field( $id, $title, 'stark_form_field_fn', __FILE__, $section, $field_args );
}

/**
 * Register our setting, settings sections and settings fields
 */

function stark_register_settings() {
	//get the settings
	$settings_output = stark_get_settings();
	$wp_options_name = $settings_output['wp_option_name'];
	
	register_setting( $wp_options_name, $wp_options_name, 'stark_validate_options' ); 	//settings

	//sections
	if( !empty( $settings_output['wp_page_sections'] ) ) {

		foreach( $settings_output['wp_page_sections'] as $id => $title ) {

			add_settings_section( $id, $title, 'stark_section_fn', __FILE__ );		
		}
	}

	//fields
	if( !empty( $settings_output['wp_page_fields'] )  ){
		
		foreach( $settings_output['wp_page_fields'] as $option ) {
			
			stark_create_settings_field($option);			

		}
	}
}

/**
 * Specify Hooks/Filterrs
 */
add_action( 'admin_init', 'stark_register_settings' );

/**
 * Admin Settings Page HTML
 * 
 * @return echoes output
 */

function stark_settings_page() {
	//get the settings
	$settings_output = stark_get_settings();
?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"></div>
		<h2><?php echo $settings_output['wp_page_title']; ?></h2>
		<?php settings_errors( 'stark-settings-errors' ); ?>

		<form action="options.php" method="post" enctype="multipart/form-data">
		<div id="theme-options-wrap" class="widefat">

			<?php 
				// http://codex.wordpress.org/Function_Reference/settings_fields	
				settings_fields( $settings_output['wp_option_name'] );

				// http://codex.wordpress.org/Function_Reference/do_settings_sections
				do_settings_sections(__FILE__); 
			?>
		</div> <!--themeoptions-wrap-->
			<p class="submit">
				<input name="stark_options['submit']" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'stark'); ?>" />
			</p>

		</form>

	</div><!-- wrap -->
<?php
}


/**
* Validate Function
*
*/function stark_validate_options($input) {
	$input_array = array();

		// collect only the values we expect and fill the new $valid_input array i.e. whitelist our option IDs
	
		// get the settings sections array
		$settings_output = stark_get_settings();
		
		$options = $settings_output['wp_page_fields'];

	foreach ( $options as $option ) {
		
		switch( $option['type'] ) {
			case 'text':

				switch( $option['class'] ) {

					case 'url':  
                            				//accept the input only when the url has been sanited for database usage with esc_url_raw()  
                           				 $input[$option['id']]       = trim($input[$option['id']]); // trim whitespace  
                           				$input_array[$option['id']] = esc_url_raw($input[$option['id']]);  
		                        break;
			
				 	case 'email':  
                            				//accept the input only after the email has been validated  
                           				$input[$option['id']]       = trim($input[$option['id']]); // trim whitespace  
                            				if($input[$option['id']] != '') {  
                                				$input_array[$option['id']] = (is_email($input[$option['id']])!== FALSE) ? $input[$option['id']] : __('Invalid email! Please re-enter!','stark');  
                            				}
							elseif( empty( $input[$option['id']] ) ) {
								$input_array[$option['id']] = esc_attr( $input[$option['id']] );
                           				}  
                              
                            				// register error  
                            				if(is_email($input[$option['id']]) == FALSE && $input[$option['id']] != '' ) {  
                                				add_settings_error(  
                                    					$option['id'], // setting title  
                                    					STARK_SHORT . '_txt_email_error', // error ID  
                                    					__('Please enter a valid email address.','stark'), // error message  
                                    					'error' // type of message  
                                				);  
                            				}  
                        		break;  
					
					default:  
				
					$input_array[$option['id']] = esc_attr( $input[$option['id']] );
				}
								
			break;

			case 'file':
				$input[$option['id']]       = trim($input[$option['id']]); // trim whitespace  
                            	$input_array[$option['id']] = esc_url_raw($input[$option['id']]); 

			break;

			case 'checkbox':
					// if it's not set, default to null!
					if (!isset($input[$option['id']])) {
						$input[$option['id']] = null;
					}
					// Our checkbox value is either 0 or 1
					$input_array[$option['id']] = ( $input[$option['id']] == 1 ? 1 : 0 );
			break;
						
		}

	}

	return $input_array;
}

/**
 * Section HTML, displayed before the first option
 * @return echoes output
 */

function stark_section_fn() {

	//echo "<p>" . __( 'Settings for this section', 'stark' ) . "</p>";
	echo "<p>" . __( 'Settings', 'stark' ) . "</p>";
}

/*
 * Form Fields HTML
 * All form field types share the same function!!
 * @return echoes output
 */
function stark_form_field_fn( $args = array() ) {
	
	extract($args);

	//get the settings section array 
	$settings_output = stark_get_settings();
	
	$wp_option_name = $settings_output['wp_option_name'];
	$options = get_option($wp_option_name);

	// pass the standard value if the option is not yet set in the database
	if ( !isset( $options[$id] ) && 'type' != 'checkbox' ) {
		$options[$id] = $std;
	}

	// additional field class. output only if the class is defined in the create_setting arguments
	$field_class = ($class != '') ? ' ' . $class : '';

	// switch html display based on the setting type.	
	switch ( $type ) {
		case 'text' :
			$options[$id] = stripslashes($options[$id]);
			$options[$id] = esc_attr( $options[$id]);
			echo "<input class='regular-text-$field_class' type='text' id='$id' name='" . $wp_option_name . "[$id]' value='$options[$id]' />";
			echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
			
		break;
			
		case 'file' :
			if( $options[$id] == $std ) :
			echo "<input type='text' id='$id' name='".$wp_option_name."[$id]' value='' placeholder='".$std."' />";
			else:

			echo "<input type='text' id='$id' name='".$wp_option_name."[$id]' value='".$options[$id]."'  placeholder='".$std."' />";

			endif;
		 ?>

			<input id="upload_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo', 'stark' ); ?>" />

			<?php 
				echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
		break;
		
		case 'file_preview' :  
				
			echo "<div id='$id' style='min-height: 100px;'>";
			echo "<br>";
			?>
        		<img style="max-width:100%;" src="<?php echo esc_url( $options['wp_stk_logo_input'] ); ?>" />  
   	 		</div> 
			<?php echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
		break;

		case 'checkbox':
			echo "<input class='checkbox$field_class' type='checkbox' id='$id' name='" . $wp_option_name . "[$id]' value='1' " . checked( $options[$id], 1, false ) . " />";
			echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
		break;
		
	}
}



 /** 
 * Helper function for creating admin messages 
 * src: http://www.wprecipes.com/how-to-show-an-urgent-message-in-the-wordpress-admin-area 
 * 
 * @param (string) $message The message to echo 
 * @param (string) $msgclass The message class 
 * @return echoes the message 
 */  
function stark_show_msg($message, $msgclass = 'info') {  
	echo "<div id='message' class='$msgclass'>$message</div>";  
} 



 /** 
 * Callback function for displaying admin messages 
 * 
 * @return calls stark_show_msg() 
 */  
function stark_admin_msgs() {  
        // check for our settings page - need this in conditional further down  
	$stark_settings_pg = FALSE;
	if( isset( $_GET['page'] ) ) {
	$stark_settings_pg = strpos( $_GET['page'], STARK_PAGE_BASENAME );
	}
	// collect setting errors/notices: 
	$set_errors = get_settings_errors();

	//display admin message only for the admin to see, only on our settings page and only when setting errors/notices are returned!  
	if(current_user_can ('manage_options') && $stark_settings_pg !== FALSE && !empty($set_errors)) {
		// have our settings succesfully been updated?  
		if($set_errors[0]['code'] == 'settings_updated' && isset($_GET['settings-updated'])) {  
			stark_show_msg("<p>" . $set_errors[0]['message'] . "</p>", 'updated');  
			// have errors been found?  
		}
		
		else {  
			// there maybe more than one so run a foreach loop.  
			foreach($set_errors as $set_error){  
				// set the title attribute to match the error "setting title" - need this in js file  
				stark_show_msg("<p class='setting-error-message' title='" . $set_error['setting'] . "'>" . $set_error['message'] . "</p>", 'error');  
			}
		}
	}
}  

// admin messages hook!
add_action('admin_notices', 'stark_admin_msgs');


/**
*
*load styles and scripts
**/
function stark_options_enqueue_scripts() {  
	wp_register_style( 'stark-custom-style', get_template_directory_uri() . '/inc/stark-custom-style.css' );
        wp_register_script( 'stark-upload', get_template_directory_uri() .'/inc/stark-upload.js', array('jquery','media-upload','thickbox') );  
	if ( 'appearance_page_stark-theme-settings' == get_current_screen() -> id ) {  
		wp_enqueue_script('jquery');
		wp_enqueue_script('thickbox');

		wp_enqueue_style('thickbox');

		wp_enqueue_script('media-upload');
		wp_enqueue_script('stark-upload');

		wp_enqueue_style( 'stark-custom-style' );
        }
}
add_action('admin_enqueue_scripts', 'stark_options_enqueue_scripts');

/**
 * Adding Thickbox for logo upload
 *
 */
function stark_replace_thickbox_text($translated_text, $text, $domain) {
	if ('Insert into Post' == $text) { 
		$referer = strpos( wp_get_referer(), 'stark-set' );
		if ( $referer != '' ) {
			return __('I want this to be my logo!', 'stark' );
		}
	}
    return $translated_text;
}

/**
 * Media Upload
 */
function stark_options_setup() {  
	global $pagenow;  
	if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
		// Now we'll replace the 'Insert into Post Button' inside Thickbox
		add_filter( 'gettext', 'stark_replace_thickbox_text'  , 1, 3 );
    	}
} 
add_action( 'admin_init', 'stark_options_setup' );

/**
 *
 * Contextual Help
 */
function stark_theme_contextual_help($text, $screen_id, $screen) {

		global $stark_settings_page;

		if ($screen_id == $stark_settings_page) {  

		$text="<h3>".__('Stark Theme Settings - Contextual Help','stark')."</h3>";
		$text .="<p>" . __('Your current theme, Stark - Severely Simple, provides the following Theme Options: Logo and Social media Links.','stark') . "</p>";
		$text .="<p>" . __('Leave the field blank to disable certain functions.','stark') . "</p>";		
		$text .="<p>" . __('Remember to click "Save Changes" to save any changes you have made to the theme options.','stark') . "</p>";   
		}
		//return text
 		return $text;
}

add_filter('contextual_help', 'stark_theme_contextual_help', 10, 3);
