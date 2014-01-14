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
          <div class="masthead-imgDiv"> <img id="masthead-imgJordan" src="http://localhost/jordanmuir/wp-content/uploads/styling/header_Jordan.png"></div>
          <div id="masthead-imgMuirDiv" class="masthead-imgDiv"> <img id="masthead-imgMuir" src="http://localhost/jordanmuir/wp-content/uploads/styling/header_Muir.png"> </div>
        </td>

        <td id="nav-tc"> 
          <nav class="main-navigation" role="navigation">
            <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
          </nav>
        </td>

      </tr>
    </table>
	</header>

	<div id="content" class="site-content">
