<?php /*ěščřžýáíéúů*/
get_header();

$term_id = get_queried_object()->term_id;
$term = get_term( $term_id, 'post_tag' );
?>

<?php
get_footer();
?>