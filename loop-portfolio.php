<!--Home page listing all projects.
      Check portfolium for example
  TO-DO: Consider a default thumbnail image
-->

<?php  
  $cats = get_categories( array('taxonomy'=>'works') );
  foreach ( $cats as $category) {
?>

  <div id="category_div"> 
  <?php 
    echo "<h1>". $category->name ."<h1>";
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
    while ($my_query->have_posts()) :  $my_query->the_post(); 
    ?>
      <div class="post_home">
        <a href="<?php the_permalink() ?>" class="thumb" title="<?php the_title(); ?>">
          <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail( array(200, 200)); ?>
          <?php else : ?>
            <img src="<?php wp_upload_dir(); ?>/jordanMuir/wp-content/uploads/stylingImages/defaultThumb.png" width=150 height="150" />
          <?php endif; ?>
        </a>
        <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
      </div>
  <?php endwhile; wp_reset_query(); ?>
  </div>
<?php } 
?>
