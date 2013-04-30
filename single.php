<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Stark
 * @since Stark 1.0
 */
get_header(); ?>

		<div id="content" role="main">	

			<?php while ( have_posts() ) : the_post(); ?>

				<div class="content">
					
					<?php get_template_part( 'content', 'single' ); ?>

						<nav id="nav-single">

							<h3 class="assistive-text"><?php _e( 'Post navigation', 'stark' ); ?></h3>
							<span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav"></span> PREVIOIUS', 'stark' ) ); ?></span>							<span class="nav-next"><?php next_post_link( '%link', __( 'NEXT <span class="meta-nav"></span>', 'stark' ) ); ?></span>
						</nav><!-- #nav-single -->

					<?php comments_template( '', true ); ?>

				</div> <!-- CONTENT CLASS -->				


			<?php endwhile; ?>

		</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
			
