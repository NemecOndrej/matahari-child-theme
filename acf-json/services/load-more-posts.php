<?php /*ěščřžýáíéúů*/

header( 'Content-Type: text/plain; charset=utf-8' );

require_once '../../../../wp-config.php';
require_once ABSPATH . 'wp-load.php';
require_once ABSPATH . 'wp-includes/wp-db.php';

@ini_set( 'display_errors', 0 );

// pagination settings
$page = intval( $_POST['page']);
$posts_per_page = intval( get_option( 'posts_per_page', 8 ) );
if ( isset( $_POST['postsperpage'] ) ) {
    $posts_per_page = intval( $_POST['postsperpage'] );
}

// default parameters for WP_Query
$args = array(
    'post_type'      => 'post',
    'status'         => 'publish',
    'posts_per_page' => $posts_per_page,
    'paged'          => $page,
    'order'          => 'DESC',
    'orderby'        => 'date'
);

// set post ids to exclude
if ( isset( $_POST['ids'] ) && strlen( $_POST['ids'] ) > 0 ) {
    $ids2exclude = array();
    $ids = explode( ',', $_POST['ids'] );
    foreach ( $ids as $id ) {
        if ( intval( $id ) > 0) {
            array_push( $ids2exclude, intval( $id ) );
        }
    }
    if ( count( $ids ) > 0 ) {
        $args['post__not_in'] = $ids2exclude;
    }
}

// set category
if ( isset( $_POST['category'] ) ) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => intval( $_POST['category'] )
        ),
    );
}

// set tag
if ( isset( $_POST['tag'] ) ) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'post_tag',
            'field'    => 'term_id',
            'terms'    => intval( $_POST['tag'] )
        ),
    );
}

// set search
if ( isset( $_POST['search'] ) ) {
    $args['s'] = $_POST['search'];
}

$posts = new WP_Query($args);
while ( $posts->have_posts() ) {
    $posts->the_post();

    include THEME_ROOT_DIR . '/template-parts/article.php';
}
?>