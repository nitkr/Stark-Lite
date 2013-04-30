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

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() ); ?>

			<?php endwhile; ?>

			<?php stark_content_nav('nav-below'); ?>


		<?php else : ?>

			<div class="content">
				<article id="post-0" class="post no-results not-found"> <!-- id 0 -->
			
				<?php if ( current_user_can( 'edit_posts' ) ) :
				// Show a different message to a logged-in user who can add posts.
				?>
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'No posts to display', 'stark' ); ?></h1>
					</header>

					<div class="entry-content">
						<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'stark' ), admin_url( 'post-new.php' ) ); ?></p>
					</div><!-- .entry-content -->

				<?php else: ?>

					<header>
						<h1><?php _e( 'Nothing Found', 'stark' ); ?></h1>	
					</header>
					
					<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'stark' ); ?></p>
					<?php get_search_form(); ?>
				<?php endif; ?>
				</article> <!-- article id 0 -->	    
			</div> <!--end of content else -->
		<?php endif; ?>

	</div> <!-- #main -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
