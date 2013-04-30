<?php
/**
* The template for displaying the footer.
*
* Contains the closing of the id=wrapper div and all content after
*
* @package Stark
* @since Stark 1.0
*/
?>
 

	</div> <!-- #wrapper -->
		<footer id="colophon" class="site-footer" role="contentinfo">
			
				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>

					<div class="footer-sidebar">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</div>

				<?php endif;?>

				<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
		
					<div class="footer-sidebar">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</div>

				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>

					<div class="footer-sidebar">
						<?php dynamic_sidebar( 'footer-3' ); ?>
					</div>

				<?php endif; ?>
		<div class="site-info">

<div id="theme-credit">
				<?php do_action( 'stark_credits' ); ?>
					<a href="<?php echo esc_url( 'http://www.starkthemes.wordpress.com' ); ?>" target="_blank" title="<?php _e( 'Stark Theme by Nithin K R' , 'stark' ); ?>"><?php _e( 'Stark Theme by Nithin K R' , 'stark' ); ?></a> |
			<?php _e( 'Copyright &copy;' , 'stark' ) ?> <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?> |
			<a href="http://www.wordpress.org" target="_blank" title="<?php _e( 'Powered by WordPress' , 'stark' ); ?>"><?php _e( 'Powered by WordPress' , 'stark' ); ?></a>
</div>
			</div><!-- .site-info -->
		</footer><!-- #colophon .site-footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

