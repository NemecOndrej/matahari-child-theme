<?php /*ěščřžýáíéúů*/

add_action( 'send_headers', 'theme_send_security_headers' );

function theme_send_security_headers() {

    // Block putting website into iframes
    header( 'X-Frame-Options: SAMEORIGIN' );

    // Force correct MIME type (don't exec TXT as JS etc.)
    header( 'X-Content-Type-Options: nosniff' );

    // HSTS settings - force loading by HTTPS
    // if ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ) {
        // header( "Strict-Transport-Security: max-age=31536000; includeSubdomains; preload" );
    // }
}

?>