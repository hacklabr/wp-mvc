<?php

/**
 * Query object
 *
 * As the query processor relies on a global `$_query` object, we should
 * declare it and document each of the attributes of this object here.
 */
add_action( 'init', '_init_query_object' );
function _init_query_object() {

    global $_query;
    $_query = (object) array(

        // Choose a different template
        'template' => false,

        // The same query
        'sample_query' => false

    );

}

/**
 * Query processor
 *
 * All requests will pass throught this function to receive more custom data in
 * a set of `if` conditions. These conditions can either be defined by default
 * WordPress queries or by the custom rewrite rule of the theme's router.
 *
 * To modify the main WordPress query, replace the `$wp_query` for a new
 * `WP_Query` instance. For example:
 * $wp_query = new WP_Query( $new_query_vars );
 *
 * To get data from a custom query set in the rewrite rule, simply do the same
 * with the $_query object:
 * $_query = new WP_Query( $query_vars );
 *
 * If there's something to be given at all queries like footer menus or sidebar
 * items, just put it in the end outside the `if` condition.
 */
function _query_processor( &$query ) {

    global $_query, $post, $wpdb, $wp_query;

    /* Main home */

    if ( $query->is_home() && !$_query ) {


    /* Search page */

    } elseif( $query->get( 's' ) ) {


    /* Archives */

    } elseif ( $query->is_archive() ) {


    /* Singles */

    } elseif ( $query->is_single() ) {


    /* 404 error */

    } elseif ( $query->is_404() ) {


    /* The sample query */

    } elseif ( $q = get_query_var( 'sample_query' ) ) {

        $_query->sample_query = 'Nice!';

    }

    /* Template redirect */

    $_query->template = get_query_var( 'template' );

    /* Put something here to do suff in all queries */

}
