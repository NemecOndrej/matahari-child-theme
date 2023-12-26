<?php /*ěščřžýáíéúů*/

/**
 * File autoloaded since 09/2023
 */


#region GRAVITY FORMS RELATED CODE ----------------------------------------------------

/**
 * Diable automatic scroll to gravity form after submit.
 * (vypnutí poskočení gravity forms po odeslání)
 */
add_filter( 'gform_confirmation_anchor', '__return_false' );

/**
 * Gravity forms submit button override
 * 
 * @since 09/2023
 *
 * @param String $button
 * @param Array $form
 * @return String
 */
function gform_submit_markup( $button, $form ) {

	$button = "<button type='submit' id='gform_submit_button_{$form['id']}' class='gform_button btn sendBtn'>".__("Odeslat", THEME_TEXT_DOMAIN)."</button>";

	return $button;
}
// add_filter( 'gform_submit_button', 'gform_submit_markup', 10, 2 );

/**
 * GF dynamically populated form field - page url.
 * 'gform_field_value_{parameter_name}'
 * 
 * @since 09/2023
 *
 * @param String $value
 * @return String
 */
function gform_field_dynamic_population( $value ) {

	// Example to fill current post url
	return get_the_permalink();
}
// add_filter( 'gform_field_value_PARAMETER-NAME', 'gform_field_dynamic_population' );

/**
 * Override default GF validation message.
 */
function gform_custom_validation_message( $message, $form ) {

}
// add_filter( 'gform_validation_message', 'gform_custom_validation_message', 10, 2 );

/**
 * GF fix for tabindexer - if there are multiple forms on single page.
 * GF starts tab index with the same value for each form in default state.
 * 
 * @source https://www.webdesign101.net/tab-key-not-working-properly-in-gravity-forms/
 * 
 * @since 10/2023
 *
 * @param Integer $tab_index
 * @param Boolean $form
 * @return Integer
 */
function gform_tabindexer_fix( $tab_index, $form = false ) {

	$starting_index = 1000;

	if ( $form ) {
		add_filter( 'gform_tabindex_' . $form['id'], 'gform_tabindexer_fix' );
	}

	return GFCommon::$tab_index >= $starting_index ? GFCommon::$tab_index : $starting_index;
}
add_filter( 'gform_tabindex', 'gform_tabindexer_fix', 10, 2 );

#endregion

?>