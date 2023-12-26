<?php /*ěščřžýáíéúů*/

/**
 * Add new custom shortcode.
 * @param array|string $atts Shortcode attributes. (array = attributes provided, string - empty string => no attributes provided)
 * @param string|null $content Content of enclosing shortcode.
 */
function theme_shortcode_xxxxx( $atts, $content = null ) {
	$params = shortcode_atts( array(
		'attr_1' => 'attribute 1 default',
		'attr_2' => 'attribute 2 default',
		// ...etc
	), $atts );

	echo '...';
}
add_shortcode( 'shortcodename', 'theme_shortcode_xxxxx' );


/**
 * Alter existing shortcodes functionality.
 * @param string $output Shortcode output.
 * @param string $tag Shortcode tag.
 * @return string Shortcode output.
 */
function theme_alter_shortcodes( $output, $tag ) {

	// ---------------------------------------------------------------------------------
	// shortcodetag
	// ---------------------------------------------------------------------------------

	if ( 'shortcodetag' == $tag ) {
		return $output;
	}

	// ---------------------------------------------------------------------------------

	return $output;
}
add_filter( 'do_shortcode_tag', 'theme_alter_shortcodes', 10, 2 );

?>