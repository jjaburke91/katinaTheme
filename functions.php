<?php
add_theme_support('post-thumbnails');

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


/********************/
/* Custom Post Type */
/********************/

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
            'rewrite' => array('slug' => '#/project'), // Bit hacky but it works prefixes project URL with hashbang!
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



/************/
/* Meta Box */
/************/

/* Adds a meta box to the post edit screen */
add_action( 'add_meta_boxes', 'project_meta_box' );
function project_meta_box() {
    $screens = array( 'jm_project', 'my_cpt' );
    foreach ( $screens as $screen ) {
        add_meta_box(
            'project_meta_id',          // Unique ID
            'Project Information',      // Box title
            'project_meta_callback',    // Content callback
            $screen                     // post type
        );
    }
}

// Defines the look and content of the meta box.
function project_meta_callback ($object) {
    wp_nonce_field( basename(__FILE__), 'meta-box-nonce');

    ?>
        <div>
            <label for="completion-date-input">Completion Date:</label>
            <input name="completion-date-input" type="text"
                   value="<?php echo get_post_meta($object->ID, "completion-date-input", true); ?>">
            </input>
        </div>

        <div>
            <label for="grid-row-size-input">Home Page Row Size:</label>
            <input name="grid-row-size-input" type="text"
                   value="<?php echo get_post_meta($object->ID, "grid-row-size-input", true); ?>">
            </input>
        </div>

        <div>
            <label for="grid-col-size-input">Home Page Column Size:</label>
            <input name="grid-col-size-input" type="text"
                   value="<?php echo get_post_meta($object->ID, "grid-col-size-input", true); ?>">
            </input>
        </div>
    <?php

}

add_action("save_post", "project_meta_save", 10, 3);
function project_meta_save( $post_id, $post, $update ) {

    // Verify nonce, don't save if fails.
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__))) return $post_id;

    // Verify user has permissions to save post.
    if(!current_user_can("edit_post", $post_id)) return $post_id;

    // Don't re-save if autosaving is occuring.
    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) return $post_id;

    // Don't save if meta post type doesn't match post type.
    $slug = "jm_project";
    if($slug != $post->post_type) return $post_id;

    // Following defines default values for meta content.
    $completion_date_value = "";
    $grid_row_size = "2";
    $grid_col_size = "2";

    // Check if required valuese are set.
    if( isset($_POST["completion-date-input"])) {
        $completion_date_value = $_POST["completion-date-input"];
    }
    update_post_meta($post_id, "completion-date-input", $completion_date_value);

    if( isset($_POST["grid-row-size-input"])) {
        // Maximum column is 6
        if ($_POST["grid-row-size-input"] < 6)
            $grid_row_size = $_POST["grid-row-size-input"];
    }
    update_post_meta($post_id, "grid-row-size-input", $grid_row_size);

    if( isset($_POST["grid-col-size-input"])) {
        // Maximum width is 6
        if ($_POST["grid-col-size-input"] < 6)
            $grid_col_size = $_POST["grid-col-size-input"];
    }
    update_post_meta($post_id, "grid-col-size-input", $grid_col_size);

}



/***************************/
/* Custom Project Taxonomy */
/***************************/

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



/*****************************/
/* Attachments Configuration */
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
        'priority'      => 'default',

        //TODO: Consider how to use the video
        // allowed file type(s) (array) (image|video|text|audio|application)
        'filetype'      => array('image', 'video'),


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

            $image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );

            $project = new Json_Project(
                $post_id,
                $query->post->post_title,
                $query->post->post_name,
                $image_array[0]
            );

            // $post_meta = get_post_meta($post_id, "", FALSE);
            $project->setGridSize(
                get_post_meta($post_id, "grid-row-size-input", TRUE),
                get_post_meta($post_id, "grid-col-size-input", TRUE)
            );

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

    // Defaults to 2x2
    public function setGridSize($rows, $columns) {
        if ( !isset($rows) || empty($rows) || is_null($rows) )
            $rows = 2;
        if ( !isset($columns) || empty($columns) || is_null($columns))
            $columns = 2;
        $this->grid_size = $rows . "x" . $columns;
    }

    public function setProjectDescription($desc) {
        $this->description = $desc;
    }

    public function setAttachments($attach) {
        $index = 1;
        $this->attachments = array();
        while( $attach->get() ) {
            $newAttachment['img'] = $attach->url();
            $newAttachment['caption'] = $attach->field('caption');
            $newAttachment['order'] = $index;
            $index += 1;
            array_push($this->attachments, $newAttachment);
        }
    }

}
