<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Katina
 */
?><!DOCTYPE html>
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
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
  <header id="masthead" class="site-header" role="banner">
    <table id="header-table" > 
      <tr>
        <td id="title-tc", class="nav-tableCell">
          <!-- h1 class="site-title"><php bloginfo( 'name' ); ?></h1>-->
          <img id="masthead-img" src="http://localhost/jordanMuir/wp-content/uploads/2013/12/jordanTitleTest.jpg"> 
        </td>

        <td id="nav-tc"> 
          <nav id="site-navigation" class="main-navigation" role="navigation">
            <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
          </nav>
        </td><!-- #site-navigation -->
        
        <!--
        <td>
          <table id="socialMedia-table">
            <tr>
              <td class="socialMedia-tc"> <img src="http://localhost/jordanMuir/wp-content/uploads/socialMediaIcons/PNG/twitter.png" class="socialMedia-img"> </td>
              <td class="socialMedia-tc"> <img src="http://localhost/jordanMuir/wp-content/uploads/socialMediaIcons/PNG/linkedin.png" class="socialMedia-img"> </td>
              <td class="socialMedia-tc"> <img src="http://localhost/jordanMuir/wp-content/uploads/socialMediaIcons/PNG/flickr.png" class="socialMedia-img"> </td>
              <td class="socialMedia-tc"> <img src="http://localhost/jordanMuir/wp-content/uploads/socialMediaIcons/PNG/tumbler.png" class="socialMedia-img"> </td>
            </tr>
          </table>
        </td>
        -->
      </tr>
    </table>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
