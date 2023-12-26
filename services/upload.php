<?php /*ěščřžýáíéúů*/

header( 'Content-Type: text/plain; charset=utf-8' );

require_once '../../../../wp-config.php';
require_once ABSPATH . 'wp-load.php';
require_once ABSPATH . 'wp-includes/wp-db.php';

@ini_set( 'display_errors', 0 );

// prepare save dir in /wp-content/uploads
$upload_dir_config = wp_upload_dir();
$upload_dir_url = $upload_dir_config['baseurl'] . '/web-uploads/';
$upload_dir = $upload_dir_config['basedir'] . '/web-uploads/';
if ( !file_exists( $upload_dir ) ) {
    mkdir( $upload_dir, 0777, true );
}

$files = array();

// save files and add their file names to array
if ( isset( $_FILES ) && is_array( $_FILES ) && count( $_FILES ) > 0 ) {
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
            array_push( $files, array(
                'title'    => $filename,
                'filename' => $final_filename,
                'path'     => $upload_dir . $final_filename,
                'url'      => $upload_dir_url . $final_filename
            ));
        }
    }
}

/* MULTIPLE FILES IN ONE INPUT EXAMPLE
if(isset($_FILES) && isset($_FILES['contracts_upload']) && count($_FILES['contracts_upload']))
{
    for ($i = 0; $i < count($_FILES['contracts_upload']['name']); $i++)
    {
        $fileName = $_FILES['contracts_upload']['name'][$i];
        $fileTmpName = $_FILES['contracts_upload']['tmp_name'][$i];

        // kontrola unikátního názvu souboru
        $index = 0;
        $finalFileName = Theme::sanitize_filename( basename( $fileName ) );
        while (file_exists($uploadDir . $finalFileName))
        {
            $finalFileName = $index . "_" . Theme::sanitize_filename( basename( $fileName ) );
            $index++;
        }
        
        // přesun souboru
        if(move_uploaded_file($fileTmpName, $uploadDir . $finalFileName))
        {
            array_push($files, array(
                "name" => $fileName,
                "file" => $finalFileName,
                "url" => $uploadDirURL . $finalFileName
            ));
        }
    }
}*/

echo json_encode($files, JSON_UNESCAPED_UNICODE);
 
?>