<?php

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
        'rewrite' => array('slug' => '#/project') // Bit hacky but it worksm prefixes project URL with hashbang!
        )
    );
};
