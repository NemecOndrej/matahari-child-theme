<?php /*ěščřžýáíéúů*/

header( 'Content-Type: text/plain; charset=utf-8' );

require_once '../../../../wp-config.php';
require_once ABSPATH . 'wp-load.php';
require_once ABSPATH . 'wp-includes/wp-db.php';

@ini_set( 'display_errors', 0 );

// prepare result
$result = array(
    'status'  => 'error',
    'message' => '',
    'data'    => null
);

// input parameters
$identification_number = isset( $_POST['identification_number'] ) ? $_POST['identification_number'] : '';

// allow GET
if ( strlen( $identification_number ) == 0 ) {
    $identification_number = isset( $_GET['identification_number'] ) ? $_GET['identification_number'] : '';
}

// validate input parameters
if ( strlen( $identification_number ) == 0 )
{
    $result['message'] = __( 'Neplatné vstupní parametry.', THEME_TEXT_DOMAIN );
    echo json_encode($result);
    die();
}

// load data
$data = @file_get_contents( 'http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=' . $identification_number);

// parse data
if ( $data ) {

    $xml = @simplexml_load_string( $data );
    if ( $xml ) {

        $ns = $xml->getDocNamespaces();
        $data = $xml->children( $ns['are'] );
        $el = $data->children( $ns['D'] )->VBAS;

        if ( strval( $el->ICO ) == $identification_number ) {

            $result['status'] = 'ok';
            $result['data'] = array(
                'company' => strval( $el->OF ),
                'ic' => strval( $el->ICO ),
                'dic' => strval( $el->DIC ),
                'street' => strval( $el->AA->NU ),
                'street_number' => strval( $el->AA->CD ) . ( isset( $el->AA->CO ) ? '/' . $el->AA->CO : '' ),
                'city' => strval( $el->AA->N ),
                'zip' => strval( $el->AA->PSC )
            );

            if ( strlen( $result['data']['street'] ) == 0 ) {
                // fix places without streets
                $result['data']['street'] = $result['data']['city'];
            }

        } else {
            $result['message'] = __( 'IČO nebylo nalezeno.', THEME_TEXT_DOMAIN );
        }

    } else {
        $result['message'] = __( 'Databáze ARES není dostupná.', THEME_TEXT_DOMAIN );
    }

} else {
    $result['message'] = __( 'Databáze ARES není dostupná.', THEME_TEXT_DOMAIN );
}

echo json_encode($result);
?>