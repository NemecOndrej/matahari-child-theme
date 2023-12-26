<?php /*ěščřžýáíéúů*/

/**
 * Alter shortcodes.
 * @param string $output Shortcode output.
 * @param string $tag Shortcode tag.
 * @return string Shortcode output.
 */
function theme_wpbakery_alter_shortcodes( $output, $tag ) {

	// -------------------------------------------------------------------------------------
	// vc_row
	// -------------------------------------------------------------------------------------

	if ( 'vc_row' == $tag ) {
		return $output;
	}

	// -------------------------------------------------------------------------------------

	return $output;
}
add_filter( 'do_shortcode_tag', 'theme_wpbakery_alter_shortcodes', 10, 2 );

/**
 * Actions for WPBakery init.
 */
function theme_wpbakery_init() {

	// -------------------------------------------------------------------------------------
	// vc_row - changes
    // -------------------------------------------------------------------------------------

	// remove default parameters
    if ( function_exists('vc_remove_param') ) {
        vc_remove_param( 'vc_row', 'css_animation' );
        vc_remove_param( 'vc_row', 'full_width' );
		vc_remove_param( 'vc_row', 'full_height' );
        vc_remove_param( 'vc_row', 'rtl_reverse' );
		vc_remove_param( 'vc_row', 'content_placement' );
    }

	// add new parameters
	// TODO - set layout parameters
    if ( function_exists('vc_add_params') ) {
		vc_add_params( 'vc_row', array(
			array(
				'param_name' => 'XXXX',
				'heading' => __( 'Row Height', THEME_ADMIN_TEXT_DOMAIN ),
				'description' => '',
				'type' => 'dropdown',
				'value' => array(
					__( 'No paddings', THEME_ADMIN_TEXT_DOMAIN ) => 'auto',
					__( 'Small paddings', THEME_ADMIN_TEXT_DOMAIN ) => 'small',
					__( 'Medium paddings', THEME_ADMIN_TEXT_DOMAIN ) => 'medium',
					__( 'Large paddings', THEME_ADMIN_TEXT_DOMAIN ) => 'large',
					__( 'Huge paddings', THEME_ADMIN_TEXT_DOMAIN ) => 'huge',
					__( 'Full Screen', THEME_ADMIN_TEXT_DOMAIN ) => 'full',
				),
				//'edit_field_class' => 'vc_col-sm-6',
				'weight' => 180,
			),
			array(
				'param_name' => 'YYYYY',
				'heading' => __( 'Row Columns Layout', THEME_ADMIN_TEXT_DOMAIN ),
				'description' => '',
				'type' => 'dropdown',
				'value' => array(
					__( 'With Small gaps', THEME_ADMIN_TEXT_DOMAIN ) => 'small',
					__( 'With Medium gaps', THEME_ADMIN_TEXT_DOMAIN ) => 'medium',
					__( 'With Large gaps', THEME_ADMIN_TEXT_DOMAIN ) => 'large',
					__( 'Boxed and without gaps', THEME_ADMIN_TEXT_DOMAIN ) => 'none',
				),
				//'edit_field_class' => 'vc_col-sm-6',
				'weight' => 170,
			),
		) );
    }

}
add_action( 'vc_after_init', 'theme_wpbakery_init' );

/**
 * Actions before WPBakery init.
 */
function theme_wpbakery_before_init() {

	// set theme dir for adjusted standard shortcodes
	$dir = THEME_ROOT_DIR . '/template-parts/wpbakery-shortcodes/';
	vc_set_shortcodes_templates_dir( $dir );

}
add_action( 'vc_before_init', 'theme_wpbakery_before_init' );

?>