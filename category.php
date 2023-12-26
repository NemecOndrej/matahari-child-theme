<?php /*ěščřžýáíéúů*/
get_header();

$term_id = get_queried_object()->term_id;
$term = get_term( $term_id, 'category' );


get_footer();
?>