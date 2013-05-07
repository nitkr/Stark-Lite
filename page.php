<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Stark
 * @since Stark 1.0
 */

get_header(); ?>

	<div id="content" role="main">	

		<?php while ( have_posts() ) : the_post(); ?>

			<div class="content">

				<?php get_template_part( 'content', 'page' ); ?>

				<?php comments_template( '', true ); ?>

			</div> <!-- CONTENT CLASS -->				

		<?php endwhile; // end of the loop. ?>

	</div> <!--Main div-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
