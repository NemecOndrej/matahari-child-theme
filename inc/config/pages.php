<?php /*ěščřžýáíéúů*/

/**
 * Add excerpt field to pages.
 */
function theme_add_excerpts2pages() {
    add_post_type_support( 'page', 'excerpt' );
}
//add_action('init', 'theme_add_excerpts2pages');

/**
 * Remove classic author.
 */
function theme_remove_pages_author() {
    remove_post_type_support( 'page', 'author' );
}
add_action( 'init', 'theme_remove_pages_author' );


?>