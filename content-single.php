<?php
/**
 * The default template for displaying content in single.php template
 *
 * 
 * @package Stark
 * @since Stark 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php 		// check if the post has a Post Thumbnail assigned to it.
				if ( has_post_thumbnail() ) { ?>
					<div class="featured-image">
					<?php the_post_thumbnail( 'large' );?> 
					</div>
			<?php
				}
			?>
			<h1 class="entry-title"><?php the_title(); ?></h1>

				<?php if ( 'post' == get_post_type() ) : ?>

				<div class="entry-meta">
					<?php stark_posted_on(); ?>
				</div>

				<?php endif; ?>

			<?php edit_post_link( __( 'Edit', 'stark' ), '<span class="edit-link">', '</span>' ); ?>
		</header>

		<div class="entry-content">
			<?php the_content(); ?>		
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'stark' ) . '</span>', 'after' => '</div>' ) ); ?>
		</div> <!-- .entry-content -->

		<footer class="entry-meta">			<div class="space"></div>
			<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'stark' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'stark' ) );
			if ( '' != $tag_list ) {
				$utility_text = __( 'This entry was posted in %1$s and tagged %2$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'stark' );
			} elseif ( '' != $categories_list ) {
				$utility_text = __( 'This entry was posted in %1$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'stark' );
			} else {
				$utility_text = __( 'This entry was posted by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'stark' );
			}

			printf(
				$utility_text,
				$categories_list,
				$tag_list,
				esc_url( get_permalink() ),
				the_title_attribute( 'echo=0' ),
				get_the_author(),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
			);
			?>
			<?php edit_post_link( __( 'Edit', 'stark' ), '<span class="edit-link">', '</span>' ); ?>

		<?php if ( get_the_author_meta( 'description' ) && ( ! function_exists( 'is_multi_author' ) || is_multi_author() ) ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries ?>
		<div class="author-info">
			<div class="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'stark_author_bio_avatar_size', 68 ) ); ?>
			</div><!-- #author-avatar -->
			<div class="author-description">
				<h2><?php printf( __( 'About %s', 'stark' ), get_the_author() ); ?></h2>
				<?php the_author_meta( 'description' ); ?>
				<div class="author-link">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
						<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'stark' ), get_the_author() ); ?>
					</a>
				</div><!-- #author-link	-->
			</div><!-- #author-description -->
		</div><!-- #author-info -->
		<?php endif; ?>
		</footer><!-- #entry-meta -->
	</article>	<!-- post -->				
