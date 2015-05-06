<?php
add_theme_support('post-thumbnails');

// Create Project post type
add_action( 'init', 'create_post_type' );
function create_post_type() {
    register_post_type( 'jm_project',
        array(
            'labels' => array(
                'name' => __( 'Projects' ),
                'singular_name' => __( 'Project' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => '#/project'), // Bit hacky but it worksm prefixes project URL with hashbang!
            'menu_position' => 5,
            'supports' => array(
                'title',
                'editor',
                'thumbnail'
                // 'custom-fields'
            )
        )
    );
};

// Create custom meta box for Projects. http://code.tutsplus.com/tutorials/reusable-custom-meta-boxes-part-1-intro-and-basic-fields--wp-23259
function add_custom_meta_box() {
    add_meta_box(
        'custom_meta_box', // $id
        'Project Meta', // $title
        'show_custom_meta_box', // $callback
        'jm_project', // $page
        'normal', // $context
        'high'
    ); // $priority
}
add_action('add_meta_boxes', 'add_custom_meta_box');

// Defines the HTML visible for the meta box
function show_custom_meta_box( $post) {
    $value = get_post_meta( $post->ID, '_my_meta_value_key', true );

    echo '<label for="project_date_field" >';
    _e( 'Completion Date', 'project_date' );
    echo '</label> ';
    echo '<input style="text-align: left; width: 40em;" type="text" id="project_date_field" name="project_date_field" value="' . esc_attr( $value ) . '" size="25" />';
}

// Field Array
$prefix = 'custom_';
$custom_meta_fields = array(
    array(
        'label'=> 'Project Completion Date',
        'desc'  => 'Date the project was completed.',
        'id'    => $prefix.'text',
        'type'  => 'text'
    )
);

// Create Project Category taxonomy
add_action('init', 'jm_category_init');
function jm_category_init() {
    register_taxonomy(
        'jm_category',
        'jm_project',
        array(
            'label' => __( 'Category' ),
            'rewrite' => array( 'slug' => 'category' )
        )
    );
}

// Removes Posts and Comments section from Admin menu.
add_action( 'admin_menu', 'my_remove_admin_menus' );
function my_remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' );
    remove_menu_page( 'edit.php' );
}

// Removes comments from post and pages.
add_action('init', 'remove_comment_support', 100);
function remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
    remove_post_type_support( 'jm_project', 'comments' );
}
