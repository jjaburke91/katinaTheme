<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Katina
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>
