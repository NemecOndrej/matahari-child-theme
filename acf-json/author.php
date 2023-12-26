<?php /*ěščřžýáíéúů*/

$curauth = get_userdata(get_query_var('author'));
$current_link = get_author_posts_url($curauth->ID);

get_header();

?>

<?php get_footer(); ?>