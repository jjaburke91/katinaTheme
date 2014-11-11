<!-- Single Project root & content -->
<?php get_header(); ?>

	<div class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
      <?php if ( get_the_content() != ""): ?>
        <div class="project-info"> 
          <h1 class="project-title">
            <?php 
              the_title();
              edit_post_link( __( 'Edit', 'katina' ), '<span id="edit-link">', '</span>' );
            ?> 
          </h1>

          <div class="project-desc">
            <?php 
              the_content(); 
              $categ = wp_get_post_terms($post->ID, 'works');
              echo "<h3>".get_post_meta( $post->ID, 'year', true)." - ".$categ[0]->name."</h3>"; 
            ?>
          </div><!-- .entry-content -->
        </div>

        <div id="project-content">
      <?php else: ?>
        <div id="photography-title"> <?php the_title(); ?> </div>
        <div id="photography-content">
      <?php endif;
          $args = array (
            'post_type' => 'attachment',
            'orderby' => 'title',
            'order' => 'ASC',
            'numberposts' => -1,
            'post_parent' => $post->ID,
            'exclude' => get_post_thumbnail_id()
            );
          $attachments = get_posts($args);

          $youtubeVideos = get_post_meta( $post->ID, 'youtube_video', false);

          if ( count($youtubeVideos) > 0):
            foreach( $youtubeVideos as $youtubeVideoMeta):
              $youtubeMetaSplit = explode("::", $youtubeVideoMeta);
              $youtubeVideoUrl = $youtubeMetaSplit[0];
              $youtubeVideoDescription = $youtubeMetaSplit[1];
      ?>
            <div class="project-video" >
              <?php 
                echo do_shortcode('[iframe src=http://'.$youtubeVideoUrl.'?rel=0&controls=2&modestbranding=1&autohide=1&showinfo=0&wmode=transparent]');
              ?>
              <?php 
                if ($youtubeVideoDescription != "") {
                  echo "<p>".$youtubeVideoDescription."</p>";
                }
              ?>
            </div>

          <?php
            endforeach;
          endif;

          if ($attachments):
            foreach ($attachments as $attachment): 
          ?>
              <div class="project-image" >
                <div class="project-captionGrouper">
                    <?php $img_attributes = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
                    <a href="<?php echo $img_attributes[0]; ?>" rel="lightbox[gallery-1]">
                        <img src="<?php echo $img_attributes[0];?>">
                    </a>
                    <?php if ($attachment->post_excerpt != ''): ?>
                    <div class="project-caption">
                        <?php echo $attachment->post_excerpt; ?>
                    </div>
                    <?php endif; ?>
                </div>
              </div> 
            <?php
            endforeach;
          endif;
          ?>
        </div>
        <div style="clear:both"> </div>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
