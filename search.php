<?php
/**
 * The template for displaying Search Results pages.
 *
 * 
 * @package Stark
 * @since Stark 1.0
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'stark' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="content">

					<?php get_template_part( 'content', get_post_format() ); ?>

				</div> <!--end of content -->
			<?php endwhile; ?>

			<?php stark_content_nav( 'nav-below' ); ?>

		<?php else : ?>
			<div class="content">
			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'stark' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'stark' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->
			</div> <!--.content-->
		<?php endif; ?>

		</div><!-- main-->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
