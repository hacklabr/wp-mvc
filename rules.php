<?php

/**
 * Rewrite rules
 *
 * Define the array of rewrite rules and the query variables they match. Don't
 * use `index.php?` in front of the query string.
 */
function _query_rules () {
    return array(
        '^sample-query/([^/]+)/?$' => 'sample_query=$matches[1]',
    );
}
