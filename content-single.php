<?php
/**
 * @package Katina
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
    <?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'katina' ),
				'after'  => '</div>',
			) );
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
  </div><!-- .entry-content -->

  <?php edit_post_link( __( 'Edit', 'katina' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
