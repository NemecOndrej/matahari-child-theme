<?php /*ěščřžýáíéúů*/

/**
 * Extend TinyMCE allowed HTML elements.
 * @param array $init Initial configuration.
 * @return array Adjusted configuration.
 */
function theme_extend_tinymce( $init ) {
    // Command separated string of extended elements
    $ext = 'span[id|name|class|style]';

    // Add to extended_valid_elements if it alreay exists
    if ( isset( $init['extended_valid_elements'] ) ) {
        $init['extended_valid_elements'] .= ',' . $ext;
    } else {
        $init['extended_valid_elements'] = $ext;
    }

    // Super important: return $init!
    return $init;
}
add_filter( 'tiny_mce_before_init', 'theme_extend_tinymce' );

/**
 * Add tinyMCE formats.
 * @param array $buttons Current toolbar buttons.
 * @return array Adjusted toolbar buttons.
 */
function theme_add_tinymce_formats_select( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter( 'mce_buttons_2', 'theme_add_tinymce_formats_select' );

/**
 * Add tinyMCE custom formats.
 * @param Array $init Initial configuration.
 * @return Array Adjusted configuration.
 */
function theme_add_tinymce_custom_formats( $init ) {

	// Paste as text (to prevent inserting unwanting content into editor.)
	$init['paste_as_text'] = true;

	// DOCS: https://codex.wordpress.org/TinyMCE_Custom_Styles

	$style_formats = array(
		array(
			'title'   => __('Tlačítko', THEME_ADMIN_TEXT_DOMAIN),
			'inline'  => 'a',
			'classes' => 'btn',
			'wrapper' => false
		)
	);
	$init['style_formats'] = wp_json_encode( $style_formats );

	return $init;
}
add_filter( 'tiny_mce_before_init', 'theme_add_tinymce_custom_formats' );

?>