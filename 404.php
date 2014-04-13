<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Katina
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section id="error-404">
                <h1 id="404-title">
                    Oops! That page cannot be found.
                </h1>

				<div id="404-content">
					<p>
                        <?php _e( 'It looks like nothing was found at this location. Maybe try one of the links above?', 'katina' ); ?>
                    </p>
				</div>
			</section>

		</main>
	</div>

<?php get_footer(); ?>