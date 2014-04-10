<?php

/* Post Types */

add_action( 'init', '_post_types' );
function _post_types() {

    global $wp_post_types;

    $post_types = array(

        /*
        'sample_post_type' => array(
            'labels' => array(
                'name' => 'Sample',
                'singular_name' => 'Sample',
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'sample',
                'with_front' => false,
            ),
            'capability_type' => 'post',
            'has_archive' => 'produtos',
            'hierarchical' => false,
            'menu_position' => 6,
            'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' )
        ),
        */

    );

    foreach ($post_types as $type => $args) {
        register_post_type( $type, $args );
    }

}

/* Taxonomias */

add_action( 'init', '_taxonomies' );
function _taxonomies() {

    $taxonomies = array(

    );

    foreach ( $taxonomies as $taxonomy_name => $taxonomy_args ) {
        foreach ( $taxonomy_args['post_types'] as $post_type ) {
            register_taxonomy( $taxonomy_name, $post_type, $taxonomy_args );
        }
    }

}
