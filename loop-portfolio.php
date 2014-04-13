<!--Home page, display projects and categories  -->

<div id="categories-wrapper">

  <?php  
    $cats = get_categories( array('taxonomy'=>'works') );
    foreach ( $cats as $category) {
  ?>
    <div class="category_header">
      <div id="category-header-text-div">
        <?php echo ' <h1>'. $category->name .'</h1>'; ?>
        <div id="category-border-trimmer"> </div> 
      </div>
    </div>

    <div id="category_content"> 
      <?php
      $args = array(
              'post_type' => 'portfolio',
              'tax_query' => array( 
                              array( 
                                'taxonomy' => 'works',
                                'field' => 'slug',
                                'terms' => $category->name
                                ))
              );
      $my_query = new WP_Query( $args);
      $i=0;
      while ($my_query->have_posts()) :  
        $i++; 
        if ($i%5 == 0) { 
          // Insert new line after every 4th post. Increment counter.
          echo '<div style="clear:both;"></div>'; 
          $i++; 
        }
        $my_query->the_post(); 
      ?>
        <div class="post_home">
          <a href="<?php the_permalink() ?>" class="thumb" title="<?php the_title(); ?>">
            <?php 
              if (has_post_thumbnail()) : 
                the_post_thumbnail( 'full'); 
              endif; 
            ?>
          </a>
          <h2> <a href="<?php the_permalink() ?>"><?php the_title(); ?></a> </h2>
          <?php 
            foreach ( get_post_meta( $post->ID, 'tag', false) as $meta ): 
              echo "<h3>". strtoupper($meta)."</h3>"; 
            endforeach;
          ?>
        </div>
    <?php endwhile; wp_reset_query(); ?>
    </div>

  <?php } ?>
</div>
