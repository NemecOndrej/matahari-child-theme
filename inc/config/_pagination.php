<?php /*ěščřžýáíéúů*/

// constants with posts per page (can be loaded dynamically from options)
define( 'ARTICLES_POSTS_PER_PAGE', 7 );
define( 'GALLERIES_POSTS_PER_PAGE', 9 );

/**
 * Custom pagination base name in URL.
 */
function theme_custom_pagination_base() {
    global $wp_rewrite;

    $wp_rewrite->pagination_base = __( 'strana', THEME_TEXT_DOMAIN );
    $wp_rewrite->flush_rules();
}
add_action( 'init', 'theme_custom_pagination_base', 1 );

/**
 * Setup custom posts per page (main queries). Required to avoid 404 page for pagination.
 * @param WP_Query $query Current query.
 */
function theme_custom_posts_per_page($query) {
    // get main object of the page
    $obj = get_queried_object();

    if ( is_a( $obj, 'WP_Post' ) && $obj->post_type == 'page' && $query->is_page ) {

        // PAGES
        $page_id = $query->queried_object->ID;
        switch ( get_page_template_slug($page_id) ) {
            case '_journal.php':
                $query->set( 'posts_per_page', ARTICLES_POSTS_PER_PAGE );
                break;
            case '_galleries.php':
                $query->set( 'posts_per_page', GALLERIES_POSTS_PER_PAGE );
                break;
        }

    } elseif ( is_a( $obj, 'WP_Term' ) && $query->is_tax ) {

        // CUSTOM TAXONOMIES
        if (
            isset( $query->tax_query ) && 
            isset( $query->tax_query->queries ) && 
            isset( $query->tax_query->queries[0] ) &&
            isset( $query->tax_query->queries[0]['taxonomy'] )
        ) {
            switch ( $query->tax_query->queries[0]['taxonomy'] ) {
                case 'galleries_categories':
                case 'galleries_tags':
                    $query->set( 'posts_per_page', GALLERIES_POSTS_PER_PAGE );
                    break;
            }
        }

    } elseif ( is_a( $obj, 'WP_Term' ) && $query->is_category && isset( $query->query['category_name'] ) ) {

        // CATEGORY
        $query->set('posts_per_page', ARTICLES_POSTS_PER_PAGE);

    } elseif ( is_a( $obj, 'WP_Term' ) && $query->is_tag && isset( $query->query['tag'] ) ) {

        // TAG
        $query->set( 'posts_per_page', ARTICLES_POSTS_PER_PAGE );

    }
}
add_action( 'pre_get_posts', 'theme_custom_posts_per_page' );

?>