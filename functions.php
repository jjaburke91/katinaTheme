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
// http://www.sitepoint.com/adding-custom-meta-boxes-to-wordpress/

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
        if ($_POST["grid-row-size-input"] < 6) {
            $grid_row_size = $_POST["grid-row-size-input"];
        } else {
            $grid_row_size = 6;
        }
    }
    update_post_meta($post_id, "grid-row-size-input", $grid_row_size);

    if( isset($_POST["grid-col-size-input"])) {
        // Maximum width is 6
        if ($_POST["grid-col-size-input"] < 6) {
            $grid_col_size = $_POST["grid-col-size-input"];
        } else {
           $grid_col_size = 6;
       }
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
        $routes['/katinaAPI/project/(?P<slug>[\w-]+)'] = array(
            array( array( $this, 'get_project'), WP_JSON_Server::READABLE )
        );
        $routes['/katinaAPI/contact'] = array(
            array( array( $this, "post_contact_form"), WP_JSON_Server::CREATABLE
                                                     | WP_JSON_Server::ACCEPT_JSON
                                                     | WP_JSON_Server::HIDDEN_ENDPOINT // Hides end-point from API index
            )
        );
        $routes['/katinaAPI/nextPost/(?P<id>[\w-]+)'] = array(
            array( array( $this, 'get_next_post'), WP_JSON_Server::READABLE )
        );

        return $routes;
    }

    public function get_projects() {
        // TODO: Max posts per page? Sync this with front end.
        $query = new WP_Query(
            array(
                'post_type' => 'jm_project',
                'posts_per_page' => '50'
            )
        );
        $response = array();

        while ($query->have_posts() ){
            $query->the_post();
            $post_id = $query->post->ID;

            $image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'large');

            $project = new Json_Project(
                $post_id,
                $query->post->post_title,
                $query->post->post_name,
                $image_array[0]
            );

            $project->setGridSize(
                get_post_meta($post_id, "grid-row-size-input", TRUE),
                get_post_meta($post_id, "grid-col-size-input", TRUE)
            );

            // Be cautious!! This returns localhost on dev env.
            $project->setUrl( get_permalink($post_id) );

            array_push($response, $project);
        }

        return $response;
    }

    public function get_project($slug) {
        $query = new WP_Query(
            array(
                'post_type' => 'jm_project',
                'name' => $slug
            )
        );

        if ($query->have_posts()) {
            $query->the_post();

            $image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $query->post->ID ), 'large' );

            $project = new Json_Project(
                $query->post->ID,
                $query->post->post_title,
                $query->post->post_name,
                $image_array[0]
            );
            $project->setProjectDescription($query->post->post_content);

            $project->setAttachments( new Attachments('project_attachments', $query->post->ID) );

            if ( get_next_post())
                $project->setNextPostUrl( get_permalink( get_next_post()->ID) );
            if ( get_previous_post())
                $project->setPreviousPostUrl( get_permalink( get_previous_post()->ID) );
        }

        if ( !isset($project) )
            return "Project '" . $slug . "' was not found.";
        else
            return $project;
    }

    public function post_contact_form($data) {
        $response = new FormResponse();

        if ( isset($data) ) {
            if ( isset( $data['name']) ) {
                if (strlen( $data['name']) > 100 || strlen($data['name']) < 5) {
                    $response->setSuccess(false);
                    $response->setFormError('name', 'Name field must be between 5 and 100 characters long.');
                } else {
                    $name = $data['name'];
                }

            }

            if ( isset( $data['email']) && $response->success ) {
                if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim( $data['email'] )) ){
                    $response->setSuccess(false);
                    $response->setFormError('email', 'Please enter a valid email address.');
                } else {
                    $email = $data['email'];
                }

            }

            if ( isset( $data['subject']) && $response->success ) {
                if (strlen( $data['subject']) > 200 || strlen( $data['subject']) < 5) {
                    $response->setSuccess(false);
                    $response->setFormError('subject', 'Subject field must be between 6 and 200 characters.');
                } else {
                    $subject = $data['subject'];
                }

            }

            if (isset( $data['message']) && $response->success ) {
                $message = trim($data['message']);

                if ( strlen($message) > 1000 || strlen($message) < 20) {
                    $response->setSuccess(false);
                    $response->setFormError('message', 'Message field must be between 20 and 1000 characters.');
                }

            }

        }

        if ( $response->success) {
            $emailTo = get_option('tz_email');

            if (!isset($emailTo) || ($emailTo == '') ){
                $emailTo = get_option('admin_email');
            }

            $emailTo = "jamesjburke91@gmail.com";

            $subject = '[jordanmuir.co.uk] Message From '.$name;
            $body = "Name: $name \n\nEmail: $email \n\nMessage:\n $message";
            $headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

            wp_mail($emailTo, $subject, $body, $headers);
            $emailSent = true;
        }

        return $response;
    }

    public function get_next_post($id) {
        $query = new WP_Query(
            array(
                'post_type' => 'jm_project',
                'p' => $id
            )
        );

        if( $query->have_posts() ) {
            $query->the_post();
            $previous_post = get_previous_post();
            $next_post = get_next_post();
        }
        if ( !is_null($next_post) )
            return $previous_post;
        else
            return -1;
    }
}

class FormResponse {
    public function  __construct() {
        $this->success = true;
    }

    public function setSuccess($success) {
        $this->success = $success;
    }

    public function setFormError($field, $message) {
        $this->formError = new StdClass();
        $this->formError->field = $field;
        $this->formError->message = $message;
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

    public function setUrl($url) {
        $this->url = $url;
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

    public function setNextPostUrl($slug){
        $this->next_post = $slug;
    }

    public function setPreviousPostUrl($slug) {
        $this->previous_post = $slug;
    }

}
