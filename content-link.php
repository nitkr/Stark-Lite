<?php
/**
 * The template for displaying posts in the Link post format
 *
 * 
 * @package Stark
 * @since Stark 1.0
 */
?>
<div class="content">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header><?php _e( 'LINK', 'stark' ); ?></header>
		<div class="entry-content">
			<?php //the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'stark' ) ); ?>

			<div class="link-post">
				<?php  //display the link

					stark_display_link();
				?>
			</div> <!-- link-post -->

		</div><!-- .entry-content -->

		<footer class="entry-meta">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'stark' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php echo get_the_date(); ?></a>

			<?php if ( comments_open() && ! post_password_required() ) : ?>
			<span class="sep"> | </span>

			<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'stark' ) . '</span>', __( '<b>1</b> Comment', 'stark' ), __( '<b>%</b>  Comments', 'stark' ) ); ?></span>
			<?php endif; // End if comments_open() ?>
			<?php edit_post_link( __( 'Edit', 'stark' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
</div> <!-- CONTENT CLASS -->
