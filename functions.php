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


/*****************************/
/* Attachments configuraiton */
/*****************************/

add_filter( 'attachments_settings_screen', '__return_false' ); // disable the Settings screen
add_filter( 'attachments_default_instance', '__return_false' ); // disable the default instance

// Adding Attachments to Projects
function my_attachments( $attachments )
{
    $fields         = array(
        array(
            'name'      => 'caption',                       // unique field name
            'type'      => 'textarea',                      // registered field type
            'label'     => __( 'Caption', 'attachments' ),  // label to display
            'default'   => '',                       // default value upon selection
        ),
        // Attachments has funcitonality for sorting already.
        // array(
        //     'name'      => 'order',                            // unique field name
        //     'type'      => 'select',                            // registered field type
        //     'label'     => __( 'Order on project page', 'attachments' ),       // label to display
        //     'meta'      => array(                   // field-specific meta as defined by field class
        //         'allow_null'    => false,            // allow null value? (adds 'empty' <option>)
        //         'multiple'      => false,            // multiple <select>?
        //         'options'       => array(           // the <option>s to use
        //             '1'     => '1',
        //             '2'     => '2',
        //             '3'     => '3',
        //             '4'     => '4',
        //             '5'     => '5',
        //             '6'     => '6',
        //             '7'     => '7',
        //             '8'     => '8',
        //             '9'     => '9',
        //             '10'    => '10',
        //             '11'    => '11',
        //             '12'    => '12'
        //         )
        //     ),
        // ),
        array(
            'name'     => 'size',
            'type'     => 'select',
            'label'    => __('Size of project on home page', 'attachments'),
            'meta'     => array(
                'allow_null' => false,
                'multiple'   => false,
                'options'    => array(
                    '1x1'    => '1x1',
                    '2x2'    => '2x2',
                    '3x3'    => '3x3',
                    '4x4'    => '4x4'
                )
            )
        )
    );

    $args = array(

        // title of the meta box (string)
        'label'         => 'Media',

        // all post types to utilize (string|array)
        'post_type'     => array( 'jm_project'),

        // meta box position (string) (normal, side or advanced)
        'position'      => 'normal',

        // meta box priority (string) (high, default, low, core)
        'priority'      => 'high',

        // allowed file type(s) (array) (image|video|text|audio|application)
        'filetype'      => array('image', 'video'), // consider how to use the video

        // include a note within the meta box (string)
        'note'          => 'Attach files here!',

        // by default new Attachments will be appended to the list
        // but you can have then prepend if you set this to false
        'append'        => true,

        // text for 'Attach' button in meta box (string)
        'button_text'   => __( 'Add Media', 'attachments' ),

        // text for modal 'Attach' button (string)
        'modal_text'    => __( 'Add Media', 'attachments' ),

        // which tab should be the default in the modal (string) (browse|upload)
        'router'        => 'upload',

        // whether Attachments should set 'Uploaded to' (if not already set)
        'post_parent'   => false,

        // fields array
        'fields'        => $fields,

    );

    $attachments->register( 'my_attachments', $args ); // unique instance name
}

add_action( 'attachments_register', 'my_attachments' );



/***********************/
/* WP API Extensions */
/***********************/

add_filter( 'json_prepare_post', function ($data, $post, $context) {
    $attachments = new Attachments( 'my_attachments', 23);
    // $media_attachments = $data['media_attachments'];
    // $data['media_attachments'] = "hello";
    $index = 1;
    while( $attachments->get() ) {
        $data['media_attachments'][$attachments->id()]['img'] = $attachments->url();
        $data['media_attachments'][$attachments->id()]['caption'] = $attachments->field('caption');
        $data['media_attachments'][$attachments->id()]['size'] = $attachments->field('size');
        $data['media_attachments'][$attachments->id()]['order'] = $index;

        $index += 1;
    }

    // $data['custom_field'] = $attachments->get();
    return $data;
}, 10, 3 );

// Custom project route
class custom_routes {
    function __construct() {
        add_filter( 'json_endpoints', array( $this, 'register_routes' ) );
    }

    function register_routes( $routes ) {
        $routes['/projects'] = array(
            array( array( $this, 'new_session'), WP_JSON_Server::CREATABLE | WP_JSON_Server::ACCEPT_JSON )
        );

        return $routes;
    }

    function new_session( $data ) {
        // $data is the data you are sending to the route
        $response = new WP_JSON_Response();
        $response->set_data( $data );
        return $response;
    }
}
new custom_routes();
