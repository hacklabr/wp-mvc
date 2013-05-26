<?php

/* Controller */

require_once( get_stylesheet_directory() . '/router.php' );

add_action( 'init', '_init_query_object' );

add_action( 'query_vars', '_query_vars' );
function _query_vars ( $query_vars ) {
    $vars = array();
    foreach( _query_rules() as $rule => $query ) {
        parse_str( $query, $qs );
        foreach ( array_keys( $qs ) as $q ) {
            $vars[] = $q;
        }
    }
    return array_unique( $vars ) + $query_vars;
}

add_action( 'rewrite_rules_array', '_rewrite_rules' );
function _rewrite_rules( $rules ) {
    $prefix = 'index.php?';
    $rules = array();
    foreach( _query_rules() as $rule => $query ) {
        $rules[ $rule ] = $prefix . $query;
    }
}

add_action( 'pre_get_posts', '_pre_get_posts', 1 );
function _pre_get_posts ( $query ) {
    if ( !$query->is_main_query() )
        return;
    _query_processor( $query );
    add_action( 'template_redirect', '_template_redirect' );
}

function _template_redirect( $template ) {
    global $rpctvcom;
    $file = locate_template( $_query->template . '.php' );
    if ( !empty( $file ) ) {
        include( $file );
        exit();
    }
}

/* Model */

$modelsdir = get_stylesheet_directory() . '/models/';
$handle = opendir( $modelsdir );
while( $f = readdir( $handle ) ) {
    if ( !in_array( $f, array( '.', '..' ) )
        && preg_match( '/\.php$/', $f ) )
        require_once( $modelsdir . $f );
}

?>
