<?php
/**
 * The Header template for the theme.
 * 
 * Displays all of the <head> section and everything up till <div id="wrapper">
 *
 * @package Stark
 * @since Stark 1.0
 *
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title(); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php $stark_options = stark_get_global_options(); ?>

	<?php do_action( 'stark_header' ); ?>

	<header id="masthead" class="site-header" role="banner">
	<?php	$text_color = get_header_textcolor(); ?>
		<?php if( ( isset( $stark_options['wp_stk_logo_input'] ) != '' ) && ( 'blank' == $text_color ) )  : ?>
		<div id="logo">  
			<a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo $stark_options['wp_stk_logo_input']; ?>" alt="logo" />
			</a>
		</div>  
          
		<?php else : ?>

			<hgroup>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</hgroup>
		<?php  endif; ?>
	</header>	<!-- Header content -->
		
			<!-- navigation -->
	<nav id="site-navigation" class="main-navigation" role="navigation">
		<h3 class="assistive-text"><?php _e( 'Menu', 'stark' ); ?></h3>
		<a class="assistive-text" href="#main" title="<?php esc_attr_e( 'Skip to content', 'stark' ); ?>"><?php _e( 'Skip to content', 'stark' ); ?></a>
		<?php wp_nav_menu( array (
				'menu_id'   => 'navigation',
				'theme_location'  => 'primary',
				'fallback_cb'     => 'stark_default_menu'
			)); 
		?>
	</nav>

	<div id="wrapper">
