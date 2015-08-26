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
function project_attachments( $attachments )
{
    $fields         = array(
        array(
            'name'      => 'caption',                       // unique field name
            'type'      => 'textarea',                      // registered field type
            'label'     => __( 'Caption', 'attachments' ),  // label to display
            'default'   => '',                       // default value upon selection
        ),
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

    $attachments->register( 'project_attachments', $args ); // unique instance name
}

add_action( 'attachments_register', 'project_attachments' );




/***********************/
/* WP API Extensions */
/***********************/


function katina_api_init() {
    global $Katina_API_Projects;

    $Katina_API_Projects = new Katina_API_Projects();
    add_filter( 'json_endpoints', array( $Katina_API_Projects, 'register_routes' ) );
}

add_action( 'wp_json_server_before_serve', 'katina_api_init' );

class Katina_API_Projects {

    public function register_routes( $routes ) {
        $routes['/katinaAPI/projects'] = array(
            array( array( $this, 'get_projects'), WP_JSON_Server::READABLE )
        );
        $routes['/katinaAPI/project/(?P<id>\d+)'] = array(
            array (array( $this, 'get_project'), WP_JSON_Server::READABLE )
        );

        return $routes;
    }

    public function get_projects() {
        $query = new WP_Query(
            array(
                'post_type' => 'jm_project'
            )
        );
        $response = array();

        while ($query->have_posts() ){
            $query->the_post();
            $post_id = $query->post->ID;

            $attachments = new Attachments( 'project_attachments', $post_id );
            $attachments->get();

            $image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );


            $project = new Json_Project(
                $post_id,
                $query->post->post_title,
                $query->post->post_name,
                $image_array[0]
            );

            $project->setGridSize($attachments->field('size'));

            array_push($response, $project);
        }

        return $response;
    }

    public function get_project($id) {
        $query = new WP_Query(
            array(
                'post_type' => 'jm_project',
                'p' => $id
            )
        );

        while ($query->have_posts()) {
            $query->the_post();

            // $attachments->get();

            $image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full' );

            $project = new Json_Project(
                $id,
                $query->post->post_title,
                $query->post->post_name,
                $image_array[0]
            );
            $project->setProjectDescription($query->post->post_content);

            $project->setAttachments( new Attachments('project_attachments', $id) );

        }

        return $project;
    }
}

class Json_Project {

    public function __construct($id, $title, $slug, $img) {
        $this->id = $id;
        $this->title = $title;
        $this->slug = $slug;
        $this->thumbnail_img = $img;
    }

    public function setGridSize($grid_size) {
        $this->grid_size = $grid_size;
    }

    public function setProjectDescription($desc) {
        $this->description = $desc;
    }

    public function setAttachments($attach) {
        $index = 1;
        $this->attachments = array();
        while( $attach->get() ) {
            $newAttachment;
            $newAttachment['img'] = $attach->url();
            $newAttachment['caption'] = $attach->field('caption');
            $newAttachment['grid_size'] = $attach->field('size');
            $newAttachment['order'] = $index;
            $index += 1;
            array_push($this->attachments, $newAttachment);
        }
    }

}
