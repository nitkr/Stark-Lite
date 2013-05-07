<?php
/**
 * The default template for displaying content
 *
 * 
 * @package Stark
 * @since Stark 1.0
 */
?>
<div class="content">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'stark' ); ?>
		</div>
		<?php endif; ?>
		<header class="entry-header">
			<?php 		// check if the post has a Post Thumbnail assigned to it.
				if ( has_post_thumbnail() ) { ?>
					<div class="featured-image">
					<?php the_post_thumbnail( 'large' );?> 
					</div>
			<?php
				}
			?>
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'stark' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>	

		<?php if ( 'post' == get_post_type() ) : ?>

			<div class="entry-meta">
				<?php stark_posted_on(); ?>
			</div>

		<?php endif; ?>

			<?php //edit_post_link('Edit','<span class="comment-count">&nbsp;&nbsp;','</span>'); ?>
			
		</header> <!-- .entry-header -->

		<?php if ( is_archive() || is_search() ) : //only displays excerpts for archive and search ?>	
			<div class="entry-summary">
			<?php the_excerpt(); ?>	
			</div> <!-- .entry-summary -->
		<?php else : ?>
		
		<div class="entry-content">
			<?php the_content( __( 'Read more <span>&rarr;</span>', 'stark' ) ); ?>		
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'stark' ) . '</span>', 'after' => '</div>' ) ); ?>	
		</div> <!-- .entry-content -->

		<?php endif; ?>

		<footer class="entry-meta">
			<?php $show_sep = false; ?>
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'stark' ) );
				if ( $categories_list ): //&& stark_categorized_blog()
			?>
			<span class="cat-links">
				<?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'stark' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
				$show_sep = true; ?>
			</span>
			<?php endif; // End if categories ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list();
				if ( $tags_list ):
				if ( $show_sep ) : ?>
			<span class="sep"> | </span>
				<?php endif; // End if $show_sep ?>
			<span class="tag-links">
				<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'stark' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
				$show_sep = true; ?>
			</span>
			<?php endif; // End if $tags_list ?>
			<?php endif; // End if 'post' == get_post_type() ?>

			<?php if ( comments_open() && ! post_password_required() ) : ?>
			<?php if ( $show_sep ) : ?>
			<span class="sep"> | </span>
			<?php endif; // End if $show_sep ?>
			<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'stark' ) . '</span>', __( '<b>1</b> Comment', 'stark' ), __( '<b>%</b>  Comments', 'stark' ) ); ?></span>
			<?php endif; // End if comments_open() ?>
			<?php  edit_post_link( __( 'Edit', 'stark' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- #entry-meta -->
	</article>	<!-- post -->
</div> <!-- CONTENT CLASS -->
