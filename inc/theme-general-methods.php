<?php /*ěščřžýáíéúů*/

/**
 * Global custom methods.
 */
trait Theme_General_Methods {

    /**
     * Method for calling REST API.
     * @param string $method HTTP method (GET, POST, PUT).
     * @param string $url API URL.
     * @param mixed $data Data to send.
     * @param string $username User name.
     * @param string $password Password.
     * @return string CURL exec response.
     */
    public static function call_rest_api( $method, $url, $data, $username = '', $password = '' ) {
        $curl = curl_init();

        switch ($method) {
            case 'POST':
                curl_setopt( $curl, CURLOPT_POST, 1 );
                if ( $data ) {
                    curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
                }
                break;
            case 'PUT':
                curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'PUT' );
                if ( $data ) {
                    curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
                }
                break;
            default:
                if ( $data ) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
        }

        curl_setopt( $curl, CURLOPT_URL, $url );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );

        if ( strlen( $username . $password ) > 0 ) {
            curl_setopt( $curl, CURLOPT_USERPWD, $username . ':' . $password );
        }

        $result = curl_exec( $curl );

        if ( $result === false ) {
            curl_close( $curl );
            return json_encode( array(
                "status" => "error",
                "error"  => curl_error( $curl )
            ) );
        }

        curl_close( $curl );
        return $result;
    }

    /**
     * Check if remote file exists (by HTTP code 200).
     * @param string $url URL to check.
     * @return bool File exists (URL found).
     */
    public static function remote_file_exists( $url ) {
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_NOBODY, true );
	    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
	    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_exec( $ch );
        $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        curl_close( $ch );
        return $http_code == 200;
    }

    /**
     * Read contents of the file.
     * @param string $path Path to the file.
     * @param bool $echo Echo contents of the file (otherwise return).
     * @return string|null Contents of the file.
     */
    public static function read_file( $path, $echo = true ) {
        if ( !isset( $path ) ) {
            return null;
        }
        if ( strlen( $path ) == 0) {
            return null;
        }

        if ( file_exists( $path ) )
        {
            $content = '';
            $fh = fopen( $path, 'r' );
            while ( $line = fgets( $fh ) ) {
              $content .= $line;
            }
            fclose($fh);

            if ( $echo ) {
                echo $content;
            } else {
                return $content;
            }
        }

        return null;
    }

    /**
     * Read contents of SVG file.
     * @param string $path Path to the file.
     * @param bool $echo Echo contents of the file (otherwise return).
     * @param bool $remove_ids Remove id attribute of all elements.
     * @param bool $remove_xml_header Remove XML header.
     * @param bool $remove_comments Remove HTML comments in the file.
     * @param bool $compress Remove spaces between tags.
     * @return string Contents of the file.
     */
    public static function read_svg( $path, $replace_fill = true, $replace_stroke = true, $echo = true, $remove_ids = true, $remove_xml_header = true, $remove_comments = true, $compress = true ) {
        $svg = Theme_General_Methods::read_file($path, false);

        if ( !isset( $svg ) ) {
            return null;
        }
        if ( strlen( $svg ) == 0 ) {
            return null;
        }

        // optimize SVG content
        if ( $remove_ids ) {
            $svg = preg_replace( '#\s(id)="[^"]+"#', '', $svg );
        }
        if ( $remove_xml_header ) {
            $svg = preg_replace( '/<\\?xml.*\\?>/', '', $svg );
        }
        if ( $remove_comments ) {
            $svg = preg_replace( '/<!--(.|\s)*?-->/', '', $svg );
        }
        if ( $compress ) {
            $svg = str_replace( "\t", ' ', $svg );
            $svg = Theme_General_Methods::strip_spaces_between_tags( $svg );
        }

        if( $replace_fill ) {
            $svg = preg_replace( '/fill=\"#(.|\s)*?\"/', 'fill="currentcolor"', $svg );
        }

        if( $replace_stroke ) {
            $svg = preg_replace( '/stroke=\"#(.|\s)*?\"/', 'stroke="currentcolor"', $svg );
        }
        
        if ( $echo ) {
            echo $svg;
            return true;
        } else {
            return $svg;
        }
    }

    
	/**
	 * Checks, whether given file id is svg.
	 *
	 * @param Int $file_id
	 * @return Boolean
	 */
	public static function is_svg( $file_id ) {
		$image_url  = wp_get_attachment_url( $file_id );
		$file_ext   = pathinfo( $image_url, PATHINFO_EXTENSION );
		return 'svg' == $file_ext;
	}

	/**
	 * If given image id is svg, print svg code, image tag otherwise.
	 *
	 * @param Int $image_id
	 * @param String $size
	 * @param Array $attr
	 * @return Void
	 */
	public static function print_image( $image_id, $size = "fullsize", $attr = array() ) {
		if ( THEME::is_svg($image_id) ) {
			THEME::read_svg(wp_get_original_image_path($image_id));
		} else {
			echo wp_get_attachment_image( $image_id, $size, false, $attr );
		}
	}

    /**
     * Current full URL.
     * @return string String with URL.
     */
    public static function get_current_url() {
        $url = '';
        // protocol
        $url .= ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http' ) . "://";
        // host
        $url .= $_SERVER['HTTP_HOST'];
        // uri
        $url .= $_SERVER['REQUEST_URI'];

        return $url;
    }

    /**
     * Get current user's IP address.
     * @return string IP address or UNKNOWN.
     */
    public static function get_current_client_ip() {
        $ip = '';
        if ( getenv( 'HTTP_CLIENT_IP' ) ) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
            $ip = getenv( 'HTTP_X_FORWARDED_FOR' );
        } elseif ( getenv( 'REMOTE_ADDR' ) ) {
            $ip = getenv( 'REMOTE_ADDR' );
        } else {
            $ip = 'UNKNOWN';
        }
        return $ip;
    }

    /**
     * Formatting of content from TinyMCE editor.
     * @param mixed $content Content string to format.
     */
    public static function format_content($content) {
        $content = apply_filters( 'the_content', $content );
        $content = str_replace( ']]>', ']]&gt;', $content );
        return $content;
    }

    /**
     * Get thumbnail image src.
     * @param $attachment_id int Id of the attachment.
     * @param $size string|array Array or name of the size.
     * @return string|bool Image src if ok, false if error.
     */
    public static function get_thumbnail( $attachment_id, $size ) {
        if ( !is_int( $attachment_id ) ) {
            if ( is_string( $attachment_id ) && ctype_digit( $attachment_id ) ) {
                $attachment_id = intval( $attachment_id );
            } else {
                return false;
            }
        }

        $thumb_src = wp_get_attachment_image_src( intval( $attachment_id ), $size );
        if ( $thumb_src === false ) {
            return false;
        }
        $thumb_src = $thumb_src[0];

        if ( !is_string( $thumb_src ) ) {
            return false;
        }
            
        if ( is_string( $thumb_src ) && strlen( $thumb_src ) == 0 ) {
            return false;
        }

        return $thumb_src;
    }

    /**
     * Get thumbnail image src - for the post.
     * @param $post_id mixed Id of the post.
     * @param $size string|array Array or name of the size.
     * @return string|bool Image src if ok, false if error.
     */
    public static function get_thumbnail4post( $post_id, $size ) {
        $attachment_id = get_post_thumbnail_id( $post_id );
        return Theme_General_Methods::get_thumbnail( $attachment_id, $size );
    }

    /**
     * Strip spaces between html tags.
     * @param $html string HTML to strip spaces in.
     * @return string Adjusted HTML.
     */
    public static function strip_spaces_between_tags( $html ) {
        return preg_replace( '~>\s+<~', '><', $html );
    }

    public static function convert_youtube_link_to_embed($url) {
        $urlParts = parse_url($url);
        if($urlParts['host'] == 'youtu.be') {
            // pro kratší URL youtu.be
            return 'https://www.youtube.com/embed' . $urlParts['path'];
        } else if($urlParts['host'] == 'www.youtube.com' || $urlParts['host'] == 'youtube.com') {
            // pro běžné URL www.youtube.com
            parse_str($urlParts['query'], $queryParts);
            if(isset($queryParts['v'])) {
                return 'https://www.youtube.com/embed/' . $queryParts['v'];
            }
        }
        return $url;
    }

    /**
     * Sanitizes filename by converting chars to latin.
     * @param string $filename Input filename.
     * @return string Sanitized filename.
     */
    public static function sanitize_filename( $filename ) {
        $chars_table = array(
            // Cyrillic alphabet
            '/А/' => 'a', '/Б/' => 'b', '/В/' => 'v', '/Г/' => 'g', '/Д/' => 'd',
            '/а/' => 'a', '/б/' => 'b', '/в/' => 'v', '/г/' => 'g', '/д/' => 'd',
            '/Е/' => 'e', '/Ж/' => 'zh', '/З/' => 'z', '/И/' => 'i', '/Й/' => 'j',
            '/е/' => 'e', '/ж/' => 'zh', '/з/' => 'z', '/и/' => 'i', '/й/' => 'j',
            '/К/' => 'k', '/Л/' => 'l', '/М/' => 'm', '/Н/' => 'n', '/О/' => 'o',
            '/к/' => 'k', '/л/' => 'l', '/м/' => 'm', '/н/' => 'n', '/о/' => 'o',
            '/П/' => 'p', '/Р/' => 'r', '/С/' => 's', '/Т/' => 't', '/У/' => 'u',
            '/п/' => 'p', '/р/' => 'r', '/с/' => 's', '/т/' => 't', '/у/' => 'u',
            '/Ф/' => 'f', '/Х/' => 'h', '/Ц/' => 'c', '/Ч/' => 'ch', '/Ш/' => 'sh',
            '/ф/' => 'f', '/х/' => 'h', '/ц/' => 'c', '/ч/' => 'ch', '/ш/' => 'sh',
            '/Щ/' => 'shch', '/Ь/' => '', '/Ю/' => 'ju', '/Я/' => 'ja',
            '/щ/' => 'shch', '/ь/' => '', '/ю/' => 'ju', '/я/' => 'ja',
            // Ukrainian
            '/Ґ/' => 'g', '/Є/' => 'ye', '/І/' => 'i', '/Ї/' => 'yi',
            '/ґ/' => 'g', '/є/' => 'ye', '/і/' => 'i', '/ї/' => 'yi',
            // Russian
            '/Ё/' => 'yo', '/Ы/' => 'y', '/Ъ/' => '', '/Э/' => 'e',
            '/ё/' => 'yo', '/ы/' => 'y', '/ъ/' => '', '/э/' => 'e',
            // Belorussian
            '/Ў/' => 'u',
            '/ў/' => 'u',
            // Polish
            '/Ą/' => 'a', '/Ć/' => 'c', '/Ę/' => 'e', '/Ł/' => 'l', '/Ń/' => 'n',
            '/ą/' => 'a', '/ć/' => 'c', '/ę/' => 'e', '/ł/' => 'l', '/ń/' => 'n',
            '/Ó/' => 'o', '/Ś/' => 's', '/Ź/' => 'z', '/Ż/' => 'z',
            '/ó/' => 'o', '/ś/' => 's', '/ź/' => 'z', '/ż/' => 'z',
            // Swedish, Finnish, Hungarian, Estonian
            '/Ä/' => 'a',
            '/ä/' => 'a',
            '/Ö/' => 'o',
            '/ö/' => 'o',
            '/Ü/' => 'u',
            '/ü/' => 'u',
            // Hungarian
            '/Ő/' => 'o',
            '/ő/' => 'o',
            '/Ű/' => 'u',
            '/ű/' => 'u',
            // Czech
            '/Ě/' => 'e', '/Š/' => 's', '/Č/' => 'c', '/Ř/' => 'r', '/Ž/' => 'z',
            '/ě/' => 'e', '/š/' => 's', '/č/' => 'c', '/ř/' => 'r', '/ž/' => 'z',
            '/Ý/' => 'y', '/Á/' => 'a', '/É/' => 'e', '/Ď/' => 'd', '/Ť/' => 't',
            '/ý/' => 'y', '/á/' => 'a', '/é/' => 'e', '/ď/' => 'd', '/ť/' => 't',
            '/Ň/' => 'n', '/Ú/' => 'u', '/Ů/' => 'u',
            '/ň/' => 'n', '/ú/' => 'u', '/ů/' => 'u',
            // Latvian
            '/Ā/' => 'aa', '/Ē/' => 'ee', '/Ū/' => 'uu', '/Ī/' => 'ii',
            '/ā/' => 'aa', '/ē/' => 'ee', '/ū/' => 'uu', '/ī/' => 'ii',
            '/Ō/' => 'o', '/Ŗ/' => 'r', '/Ģ/' => 'g',
            '/ō/' => 'o', '/ŗ/' => 'r', '/ģ/' => 'g',
            '/Ķ/' => 'k', '/Ļ/' => 'l',
            '/ķ/' => 'k', '/ļ/' => 'l',
            '/Ņ/' => 'n', '/ņ/' => 'n',
            // Slovak
            '/Ĺ/' => 'l', '/Ľ/' => 'l', '/Ŕ/' => 'r',
            '/ĺ/' => 'l', '/ľ/' => 'l', '/ŕ/' => 'r',
        
            // Bosnian, Croatian, Serbian, Montenegrin
            '/Đ/' => 'dj',
            '/đ/' => 'dj',
            // Greek alphabet & modern polytonic characters
            '/Α/' => 'a', '/Β/' => 'v', '/Γ/' => 'g', '/Δ/' => 'd', '/Ε/' => 'e',
            '/α/' => 'a', '/β/' => 'v', '/γ/' => 'g', '/δ/' => 'd', '/ε/' => 'e',
            '/Ζ/' => 'z', '/Η/' => 'i', '/Θ/' => 'th', '/Ι/' => 'i', '/Κ/' => 'k',
            '/ζ/' => 'z', '/η/' => 'i', '/θ/' => 'th', '/ι/' => 'i', '/κ/' => 'k',
            '/Λ/' => 'l', '/Μ/' => 'm', '/Ν/' => 'n', '/Ξ/' => 'x', '/Ο/' => 'o',
            '/λ/' => 'l', '/μ/' => 'm', '/ν/' => 'n', '/ξ/' => 'x', '/ο/' => 'o',
            '/Π/' => 'p', '/Ρ/' => 'r', '/Σ/' => 's', '/Τ/' => 't', '/Υ/' => 'y',
            '/π/' => 'p', '/ρ/' => 'r', '/σ/' => 's', '/τ/' => 't', '/υ/' => 'y',
            '/Φ/' => 'f', '/Χ/' => 'ch', '/Ψ/' => 'ps', '/Ω/' => 'o', '/Ά/' => 'a',
            '/φ/' => 'f', '/χ/' => 'ch', '/ψ/' => 'ps', '/ω/' => 'o', '/ά/' => 'a',
            '/Έ/' => 'e', '/Ή/' => 'i', '/Ί/' => 'i', '/Ό/' => 'o', '/Ύ/' => 'y',
            '/έ/' => 'e', '/ή/' => 'i', '/ί/' => 'i', '/ό/' => 'o', '/ύ/' => 'y',
            '/Ώ/' => 'o', '/Ϊ/' => 'i', '/Ϋ/' => 'y',
            '/ώ/' => 'o', '/ς/' => 's', '/ΐ/' => 'i', '/ϊ/' => 'i', '/ϋ/' => 'y', '/ΰ/' => 'y',
            // Extra chars (http://www.atm.ox.ac.uk/user/iwi/charmap.html)
            '/À/' => 'a', '/Â/' => 'a', '/Ã/' => 'a', '/Å/' => 'a',
            '/à/' => 'a', '/â/' => 'a', '/ã/' => 'a', '/å/' => 'a',
            '/å/' => 'a', '/Å/' => 'a',
            '/Æ/' => 'ae', '/Ç/' => 'c', '/È/' => 'e', '/Ê/' => 'e',
            '/æ/' => 'ae', '/ç/' => 'c', '/è/' => 'e', '/ê/' => 'e',
            '/Ë/' => 'e', '/Ì/' => 'i', '/Í/' => 'i', '/Î/' => 'i', '/Ï/' => 'i',
            '/ë/' => 'e', '/ì/' => 'i', '/í/' => 'i', '/î/' => 'i', '/ï/' => 'i',
            '/Ð/' => 'd', '/Ñ/' => 'n', '/Ò/' => 'o', '/Ô/' => 'o', '/Õ/' => 'o',
            '/ð/' => 'd', '/ñ/' => 'n', '/ò/' => 'o', '/ô/' => 'o', '/õ/' => 'o',
            '/ó/' => 'o', '/Ó/' => 'o',
            '/×/' => 'x', '/Ø/' => 'o', '/Ù/' => 'u', '/Û/' => 'u',
            '/×/' => 'x', '/ø/' => 'o', '/ù/' => 'u', '/û/' => 'u',
            '/Þ/' => 'p', '/Ÿ/' => 'y',
            '/þ/' => 'p', '/ÿ/' => 'y',
            // Other
            '/№/' => '', '/“/' => '', '/”/' => '', '/«/' => '', '/»/' => '',
            '/„/' => '', '/@/' => '', '/%/' => '', '/‘/' => '', '/’/' => '',
            '/`/' => '', '/´/' => '', '/º/' => 'o', '/ª/' => 'a',
        );
        // override some chars for some languages
        $locale = get_locale();
        switch ( $locale ) {
            case 'uk_UA': // Ukrainian
            case 'uk_ua':
            case 'uk':
                $chars_table_ext = array(
                    '/Г/' => 'h',
                    '/г/' => 'h',
                    '/И/' => 'y',
                    '/и/' => 'y'
                );
                $chars_table = array_merge( $chars_table, $chars_table_ext );
                break;
            case 'bg_BG': // Bulgarian
            case 'bg_bg':
                $chars_table_ext = array(
                    '/Щ/' => 'sht',
                    '/щ/' => 'sht',
                    '/Ъ/' => 'a',
                    '/ъ/' => 'a'
                );
                $chars_table = array_merge( $chars_table, $chars_table_ext );
                break;
            case 'lv_LV': // Latvian
            case 'lv_lv':
            case 'lv':
                $chars_table_ext = array(
                    '/Š/' => 'sh',
                    '/š/' => 'sh',
                    '/Ž/' => 'zh',
                    '/ž/' => 'zh',
                    '/Č/' => 'ch',
                    '/č/' => 'ch'
                );
                $chars_table = array_merge( $chars_table, $chars_table_ext );
                break;
            case 'mn': // Mongolian
                $chars_table_ext = array(
                    '/Е/' => 'ye',
                    '/е/' => 'ye',
                    '/Ё/' => 'yo',
                    '/ё/' => 'yo',
                    '/Ж/' => 'j',
                    '/ж/' => 'j',
                    '/Й/' => 'i',
                    '/й/' => 'i',
                    '/Х/' => 'kh',
                    '/х/' => 'kh',
                    '/Ъ/' => 'i',
                    '/ъ/' => 'i',
                    '/Ь/' => 'i',
                    '/ь/' => 'i',
                    '/Ц/' => 'ts',
                    '/ц/' => 'ts',
                    '/Ю/' => 'yu',
                    '/ю/' => 'yu',
                    '/Я/' => 'ya',
                    '/я/' => 'ya',
                    '/Ө/' => 'o',
                    '/ө/' => 'o',
                    '/Ү/' => 'u',
                    '/ү/' => 'u'
                );
                $chars_table = array_merge( $chars_table, $chars_table_ext );
                break;
            case 'de': // German
            case 'de_DE':
            case 'de_AT': // German (Austria)
            case 'de_CH': // German (Switzerland)
                $chars_table_ext = array(
                    '/Ä/' => 'ae',
                    '/ä/' => 'ae',
                    '/Ö/' => 'oe',
                    '/ö/' => 'oe',
                    '/Ü/' => 'ue',
                    '/ü/' => 'ue',
                    '/ß/' => 'ss'
                );
                $chars_table = array_merge( $chars_table, $chars_table_ext );
                break;
        }
        $friendly_filename = preg_replace( array_keys( $chars_table ), array_values( $chars_table ), $filename ); // replace original chars in filename with friendly chars
        return strtolower( $friendly_filename );
    }

    /**
     * Get menu object by location in template.
     * @param $location string Location of the menu.
     * @return object|bool Menu object if found. If not found returns false.
     */
    public static function get_menu_by_location( $location ) {
        if ( empty( $location ) ) {
            return false;
        }

        $locations = get_nav_menu_locations();
        if( !isset( $locations[$location] ) ) {
            return false;
        }

        $menu_obj = get_term( $locations[$location], 'nav_menu' );
        if ( is_wp_error( $menu_obj ) ) {
            return false;
        }
        if ( $menu_obj == null ) {
            return false;
        }

        return $menu_obj;
    }

    /**
     * Converts bytes into readable file size.
     *
     * @param int $bytes Bytes aquired from file_size.
     * @return string String with largest units of file size (1,5 TB).
     */
    public static function get_file_size_string( $bytes ) {
        $datasizes = array(
            array(
                'unit' => 'TB',
                'datasize' => pow(1024, 4)
            ),
            array(
                'unit' => 'GB',
                'datasize' => pow(1024, 3)
            ),
            array(
                'unit' => 'MB',
                'datasize' => pow(1024, 2)
            ),
            array(
                'unit' => 'KB',
                'datasize' => 1024
            ),
            array(
                'unit' => 'B',
                'datasize' => 1
            ),
        );

        foreach( $datasizes as $datasize ) {
            if ( $bytes >= $datasize['datasize'] ) {
                $result = $bytes / $datasize['datasize'];
                $result = str_replace( '.', ',', strval( round( $result, 2 ) ) ) . ' ' . $datasize['unit'];
                break;
            }
        }
        return $result;
    }

    /**
     * Returns Id of the page by its template file name.
     * @param string $template Name of the template file.
     */
    public static function get_page_id_by_template( $template ) {
        $pages = get_posts( array(
            'post_type'        => 'page',
            'meta_key'         => '_wp_page_template',
            'meta_value'       => $template,
            'suppress_filters' => false,
            'numberposts'      => 1
        ) );
        foreach ( $pages as $page ) {
            return intval( $page->ID );
        }

        return -1;
    }

    /**
    * Check if current user is in role.
    * @param string $roleName Name of the role.
    * @return bool Is current user in the role?
    */
    public static function is_current_user_in_role( $role_name ) {
        $user = wp_get_current_user();
        return in_array( $role_name, (array)$user->roles );
    }

    /**
     * Check if ACF field is valid Repeater Field.
     * @param mixed $field Value of the ACF field.
     * @return bool Is valid.
     */
    public static function is_valid_acf_repeater( $field ) {
        return isset( $field ) && is_array( $field ) && count( $field ) > 0;
    }

    /**
     * Check if session started.
     * @return bool True if session already started.
     */
    public static function session_started() {
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                return session_status() === PHP_SESSION_ACTIVE ? true : false;
            } else {
                return session_id() === '' ? false : true;
            }
        }
        return false;
    }

	/**
	 * Returns file uri for given filename.
	 *
	 * @param String $filename
	 *
	 * @return String
	 */
	public static function image( $filename = '' ) {

		if ( !$filename ) return;

		return get_stylesheet_directory_uri() . '/assets/images/' . $filename;
	}

	/**
	 * Returns file path for given filename.
	 *
	 * @param String $filename
	 *
	 * @return String
	 */
	public static function image_path( $filename = '' ) {

		if ( !$filename ) return;

		return get_stylesheet_directory() . '/assets/images/' . $filename;
	}

    public static function get_primary_category($post_id, $tax = "category") {
        if(class_exists('WPSEO_Primary_Term')) {
          $wpseo_primary_term = new WPSEO_Primary_Term( $tax, $post_id );
          $wpseo_primary_term = $wpseo_primary_term->get_primary_term();
          $the_primary_term = get_term( $wpseo_primary_term );
      
          if(!empty($the_primary_term) && !is_wp_error($the_primary_term)) {
            return $the_primary_term;
          }
        }
      
        return false;
    }
}

?>