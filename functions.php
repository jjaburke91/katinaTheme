<?php
/**
 * Katina functions and definitions
 *
 * @package Katina
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 * e.g. Limits the width of an image so it doesn't overflowing the content areaing the content area
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'katina_setup' ) ) :
  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   */
  function katina_setup() {

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Katina, use a find and replace
     * to change 'katina' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'katina', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
    add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
      'primary' => __( 'Primary Menu', 'katina' ),
    ) );

    // Enable support for Post Formats.
    add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

    // Setup the WordPress core custom background feature.
    add_theme_support( 'custom-background', apply_filters( 'katina_custom_background_args', array(
      'default-color' => 'ffffff',
      'default-image' => '',
    ) ) );
  }
endif; // katina_setup

add_action( 'after_setup_theme', 'katina_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function katina_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'katina' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'katina_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function katina_scripts() {
	wp_enqueue_style( 'katina-style', get_stylesheet_uri() );

	wp_enqueue_script( 'katina-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'katina-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'katina_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * PHP function to log information to console
 */

function debugToConsole( $data) {
  if (is_array( $data ) )
    $output = "<script>console.log('debug: " . implode( ',', $data) . "' ); </script>";  
  else
    $output = "<script>console.log('debug: " . $data . "' )</script>";
  echo $output;
} 













/**
 * Portfolium functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 */


/**
 * Portfolium setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 */
function portfolium_setup() {
	// This theme uses its own gallery styles.
	add_filter('use_default_gallery_style', '__return_false');
}
/**
 * Changes default image size when theme is activated
 */

/**
 * Custom Posts
 */
function portfolium_portfolio_init() {
	register_taxonomy(
		'works',
		'portfolio',
		array(
			'label' => __('Project Categories', 'portfolium'),
			'singular_label' => __('Project Category', 'portfolium'),
			'hierarchical' => true,
			'query_var' => true,
			'rewrite' => true,
			'show_in_nav_menus' => true,
		)
	);

	register_post_type(
		'portfolio',
		array(
			'label' => __('Projects', 'portfolium'),
			'singular_label' => __('Work', 'portfolium'),
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => true,
			'query_var' => true,
			'show_in_nav_menus' => true,
			'menu_position' => 3,
			'taxonomies' => array('portfolio'),
			'supports' => array('title', 'editor', 'author', 'thumbnail', 'custom-fields'),
			'_builtin' => false, // It's a custom post type, not built in!
		)
	);
}
add_action('init', 'portfolium_portfolio_init');

/**
 * Commentlist
 */
function commentlist($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	?>
	<li id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" <?php comment_class('comment_item clear'); ?>>
			<div class="comment_meta"><?php printf(__('Posted on %s by <cite class="fn">%s</cite>', 'portfolium'), get_comment_date(), get_comment_author_link()); ?></div>
			<div class="comment_text"><?php comment_text() ?></div>
		</div>
	<?php
}

function commentdata_fix($commentdata) {
	if ($commentdata['comment_author_url'] == 'WWW') {
		$commentdata['comment_author_url'] = '';
	}
	if ($commentdata['comment_content'] == 'Write your comment') {
		$commentdata['comment_content'] = '';
	}
	return $commentdata;
}
add_filter('preprocess_comment', 'commentdata_fix');

function getTinyUrl($url) {
	$remote = wp_remote_get('http://tinyurl.com/api-create.php?url='.$url);
	if ($remote instanceof WP_Error || $remote['response']['code'] != 200) {
		return 'tinyurl-error';
	}
	return $remote['body'];
}

function get_blogurl() {
	if (get_option('show_on_front') == 'page' && get_option('page_for_posts') != 0) {
		$blogpage = get_page(get_option('page_for_posts'));
		echo $blogpage->guid;
	}
	else {
		echo home_url();
	}
}

function catlist() {
	?>
	<ul class="tags jsddm">
		<li>
			<a href="#">Blog categories</a>
			<ul class="taglist">
				<?php wp_list_categories('title_li=&hierarchical=0&'); ?>
			</ul>
		</li>where is the xorg.conf
	</ul>
	<?php
}

function n_posts_link_attributes() {
	return 'class="nextpostslink"';
}
function p_posts_link_attributes() {
	return 'class="previouspostslink"';
}
add_filter('next_posts_link_attributes', 'n_posts_link_attributes');
add_filter('next_comments_link_attributes', 'n_posts_link_attributes');
add_filter('previous_posts_link_attributes', 'p_posts_link_attributes');
add_filter('previous_comments_link_attributes', 'p_posts_link_attributes');


function getOrderedListOfProjectVideos( $customFields) {
	$youtubeVideos = $customFields;

	foreach ($customFields as $field) {
		if ($field) {
			
		}
	}

	return $youtubeVideos;
}