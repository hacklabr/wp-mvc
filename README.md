## WP-MVC Theme

My experience developing in WordPress is that the callback orientation of hooks
allow developers to design any structure to a theme, easilly turning it into a
mess, and for the cases os complex websites, a huge mess. That way it's
dificult to know how a theme is changing the custom WordPress behavior.

Trying to solve this problem, the proposal is to _change the WordPress behavior
always the same way_. This simple theme aims to be a guideline for complex
WordPress themes with lots of queries and custom rewrite rules relying in the
MVC architecture, then you can explicitly define where, how and when queries
are chosen and executed.

### MVC architecture

Translating from the Wordpress theme dictionary, we get something like this:

* Model: Custom post types and taxonomies used by the theme;
* View: WordPress templates of the theme according to the [template hierarchy](http://codex.wordpress.org/Template_Hierarchy);
* Controller: The [rewrite rules](http://codex.wordpress.org/Class_Reference/WP_Rewrite) and [query variables](http://codex.wordpress.org/WordPress_Query_Vars).

### Post types

Organize your post types and taxonomies inside the `models` directory,
declaring each one of them in its`<entity>.php` file. All files in this
directory will be automatically included.

### Queries

To link queries from URLs to views you'll use the `router.php` file:

1. Define a rewrite rule in the `_query_rules` function:

    return array(
        '^sample-rule/([^/]+)/?$' => 'custom_query=$matches[1]', // sample rule
        // another rule here
        // one more rule here
        // ..
    );

2. Create a variable in the `$_query` object in the `_init_query_object`
   function:

    $_query = (object) array(

        // built-in template var
        'template' = false,

        // My custom query
        'custom_query' = false,

        /* other variables here ... */

    );

3. Define the condition to use this variable in the `_query_processor`
   function.

    function _query_processor( &$query ) {

        global $_query, $post, $wpdb, $wp_query;

        /* other conditions /*

        } elseif ( $custom_query = get_query_var( 'custom_query' ) ) {

            /* Define the template to be used. If left to false, then WordPress
               will choose the template */
            $_query->template = 'custom-template';

            /* Define a new query maybe ysing $custom_query */
            $args = array( /* custom args */ );
            $_query->custom_query = new WP_Query( $args );

        }

    }

Like this, the `custom-template.php` will be loaded with the `$_query` object
containing a `$_query->custom_query` attribute to be used.

    <?php global $_query; ?>
    <?php wp_header(); ?>

        <!-- lots of stuff here -->

        <?php if ( $_query->custom_query->have_posts() ) : ?>

            <?php while ( $_query->custom_query->have_posts() ) : ?>
            
                <?php $_query->custom_query->the_post(); ?>

                <!-- post loop like any other -->

            <?php endwhile; ?>

        <?php else : ?>

            <p><code>$_query->custom_query</code> has no posts.</p>

        <?php endif; ?>

    <?php wp_footer(); ?>
