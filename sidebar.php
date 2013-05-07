<?php
/**
 * The Sidebar containing the main widget area.
 *
 * 
 * @package Stark
 * @since Stark 1.0
 */
?>
	<div id="secondary" class="widget-area" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar('sidebar-1')  ) : ?>

			<aside id="search" class="widget widget_search">
			<h2 class="widget-title"><?php _e( 'Search', 'stark' ); ?></h2>
			<?php get_search_form(); ?>
			</aside>

			<aside id="archives" class="widget">
				<h2 class="widget-title"><?php _e( 'Archives', 'stark' ); ?></h2>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

		<?php endif; ?>
	</div>
