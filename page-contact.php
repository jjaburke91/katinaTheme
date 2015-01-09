<?php get_header(); ?>

<div class="content-area">
  <div id="contact-Img">
    <?php the_post_thumbnail('full');
          $page=get_page_by_title('contact'); ?>
  </div>
  <div id="contact-content">
    <div id="contact-meta">
      <div id="contact-meta-left">
        <div>
          <h3>Name: </h3>
          <?php echo get_post_meta( $page->ID, 'Name', true); ?>
        </div>

        <div>
          <h3>Location: </h3>
          <?php echo get_post_meta( $page->ID, 'Location', true); ?>
        </div>
      </div>
      
      <div id="contact-meta-right">
        <div>
          <h3>Email: </h3>
          <?php echo get_post_meta( $page->ID, 'E-mail', true); ?>
        </div>
        <div>
          <h3>Mobile: </h3>
          <?php echo get_post_meta( $page->ID, 'Number', true); ?> 
        </div>
      </div>
    </div>
      
    <?php $content= apply_filters('the_content', $page->post_content); echo $content; ?>

  </div>
</div>


