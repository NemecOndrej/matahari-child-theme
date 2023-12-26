<?php /*ěščřžýáíéúů*/

header( 'Content-Type: text/plain; charset=utf-8' );

require_once '../../../../wp-config.php';
require_once ABSPATH . 'wp-load.php';
require_once ABSPATH . 'wp-includes/wp-db.php';

@ini_set( 'display_errors', 0 );

// load recipient's e-mail
$recipient = get_option('admin_email');
if ( isset( $_POST['contact_recipient'] ) && strlen( $_POST['contact_recipient'] ) > 0 ) {
    $recipient = $_POST['contact_recipient'];
} elseif ( get_field( 'forms_email', 'option' ) && strlen( get_field( 'forms_email', 'option' ) ) > 0 ) {
    $recipient = get_field( 'forms_email', 'option' );
}

// input parameters
$name = isset( $_POST['contact_name'] ) ? sanitize_text_field( $_POST['contact_name'] ) : '';
$email = isset( $_POST['contact_email'] ) ? sanitize_email( $_POST['contact_email'] ) : '';
$phone = isset( $_POST['contact_phone'] ) ? sanitize_text_field( $_POST['contact_phone'] ) : '';
$message = isset( $_POST['contact_message'] ) ? sanitize_text_field( $_POST['contact_message'] ) : '';
$gdpr = isset( $_POST['contact_gdpr'] ) ? $_POST['contact_gdpr'] : '';
$gdpr = ($contact_gdpr=='on') ? 'ano' : 'ne';
$url = isset( $_POST['url'] ) ? esc_url_raw( $_POST['url'] ) : '';

// Add entry to database
// add_FORMNAME_database_entry( $name, $email, $phone, $message, $gdpr, $url );
// TODO / IMPROVEMENT: use just one argument - array with values?
// add_FORMNAME_database_entry( array(
//     'name' => $name,
//     'email' => $email,
//     'phone' => $phone,
//     'message' => $message,
//     'gdpr' => $gdpr,
//     'url' => $url
// ) );

// subject
$subject = 'Kontakt z webu';

// content
$content = '<strong>Jméno:</strong> ' . $name . '<br />';
$content .= '<strong>E-mail:</strong> ' . $email . '<br />';
$content .= '<strong>Telefon:</strong> ' . $phone . '<br />';
$content .= '<strong>Zpráva:</strong><br />' . str_replace( "\n", '<br />', $message ) . '<br />';
$content .= '<strong>URL:</strong> ' . $url . '<br />';
$content .= '<strong>GDPR:</strong> ' . $gdpr ;

// prepare save dir in /wp-content/uploads
$upload_dir_config = wp_upload_dir();
$upload_dir_url = $upload_dir_config['baseurl'] . '/email-attachments/';
$upload_dir = $upload_dir_config['basedir'] . '/email-attachments/';
if ( !file_exists( $upload_dir ) ) {
    mkdir( $upload_dir, 0777, true );
}

// prepare attachments
$attachments = array();
if ( isset( $_FILES ) ) {
    foreach($_FILES as $file) {

        $filename = $file['name'];

        // check unique file name
        $index = 0;
        $final_filename = Theme::sanitize_filename( basename( $filename ) );
        while ( file_exists( $upload_dir . $final_filename ) ) {
            $final_filename = $index . "_" . Theme::sanitize_filename( basename( $filename ) );
            $index++;
        }
        
        // move uploaded file from temp
        if ( move_uploaded_file( $file['tmp_name'], $upload_dir . $final_filename ) )
        {
            $attachments[] = $upload_dir . $final_filename;
        }
    }
}

// set email content type to HTML
add_filter( 'wp_mail_content_type', function() { return 'text/html'; } );

// set custom email sender
// add_filter( 'wp_mail_from_name', function() { return 'Název webu'; } );

// send email
wp_mail( $recipient, $subject, $content, '', $attachments );
?>