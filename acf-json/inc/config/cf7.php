<?php /*ěščřžýáíéúů*/

// fix localhost SMTP spam error for development
if ( 
    isset( $_SERVER['HTTP_HOST'] ) && 
    (
        is_numeric( strpos( $_SERVER['HTTP_HOST'], '.local' ) ) ||
        is_numeric( strpos( $_SERVER['HTTP_HOST'], 'localhost' ) ) ||
        is_numeric( strpos( $_SERVER['HTTP_HOST'], '127.0.0.1' ) )
    )
) {
    add_filter('wpcf7_spam', '__return_false');
}

?>