<?php /*ěščřžýáíéúů*/
global $wp_query;

$current_page = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$max = $wp_query->max_num_pages;

$big = 999999999; // need an unlikely integer
$links = paginate_links( array(
	'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format'    => '?paged=%#%',
	'current'   => max( 1, $current_page ),
	'total'     => $max,
    'prev_next' => false,
    'prev_text' => '',
	'next_text' => '',
    'type'      => 'list'
) );

$first = $_SERVER['REQUEST_URI'];
$first = str_replace( '/page/' . $current_page . '/', '/page/1/', $first );
if ( $current_page == 1 ) {
    $first = '';
}

$last = $_SERVER['REQUEST_URI'];
$last = str_replace( '/page/' . $current_page . '/', '/page/' . $wp_query->max_num_pages . '/', $last );
if ( $current_page == $wp_query->max_num_pages ) {
    $last = "";
}


if ( $wp_query->max_num_pages > 1 ) :
?>
<span class="clear"></span>
<nav class="pagination" aria-label="<?= __('Stránkování',THEME_TEXT_DOMAIN); ?>">
    <?php
    $prev = get_previous_posts_link( __( 'Předchozí strana', THEME_TEXT_DOMAIN ) );
    if ($prev) {
        echo str_replace('<a', '<a class="prev page-numbers"', $prev);
    } else {
        echo '<a class="prev page-numbers disabled" href="#">' . __( 'Předchozí strana', THEME_TEXT_DOMAIN ) . '</a>';
    }

    echo $links;

    $next = get_next_posts_link( __( 'Další strana', THEME_TEXT_DOMAIN ) );
    if ($next) {
        echo str_replace('<a', '<a class="next page-numbers"', $next);
    } else {
        echo '<a class="next page-numbers disabled" href="#">' . __( 'Další strana', THEME_TEXT_DOMAIN ) . '</a>';
    }
    ?>
</nav><!-- /.pagination -->
<?php endif; ?>