<?php /*ěščřžýáíéúů*/

$current_category = single_cat_title("", false); if (is_month()) { $current_category = get_the_time('F Y'); }
$catID = get_query_var("cat");

get_header();

?>



<?php get_footer(); ?>