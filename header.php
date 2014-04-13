<!DOCTYPE html>

<!-- Theme Header --> 
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<img src=<?php echo get_template_directory_uri()."/img/Jordan_Muir_Full.jpg";?> style="display:none;">
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
  <header id="masthead" role="banner">
    <div id="header-table" > 
        <div id="masthead-title">
          <a href=<?php echo home_url(); ?> style="border: none; text-decoration:none;">
            <div>
              <img id="masthead-imgJordan" src=<?php echo get_template_directory_uri()."/img/header_Jordan.png" ?> >
              <div class="img-border-trimmer"></div>
            </div>
            <img id="masthead-imgMuir" src=<?php echo get_template_directory_uri()."/img/header_Muir.png"?> > 
          </a>
        </div>
      
      <?php 
            $menuParameters = array (
                'theme_location' => 'primary',
                'container' => false,
                'echo'      => false,
                'items_wrap'=> '%3$s',
                'depth'     => 0, 
                 'before' => '<div class="nav-link">',
                 'after' => '<div class="nav-border-trimmer"></div> </div>'); 
            echo strip_tags( wp_nav_menu( $menuParameters), '<div> <a>' );
       ?>
      
      <div id="social-media-div">
        <a class="social-media-icons"  href="http://twitter.com/JordanMuir91" target="_blank">
          <img width="21px" height="21px" src=<?php echo get_template_directory_uri()."/img/Twitter.png"?> >
        </a>
        <a class="social-media-icons" href="http://www.linkedin.com/pub/jordan-muir/75/447/896" target="_blank">
          <img width="20px" height="20px" src=<?php echo get_template_directory_uri()."/img/Linkedin.png"?> >
        </a>
        <div class="img-border-trimmer"></div>
      </div>

      <span class="stretch"></span>
    </div>
	</header>
