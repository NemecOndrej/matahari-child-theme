<?php /*ěščřžýáíéúů*/

/**
 * Add theme ACF options pages.
 */
function theme_acf_options_pages() {
	if ( is_admin() && get_current_user_id() > 0 && function_exists('acf_add_options_page') ) {
		$adminMenuIcon = 'dashicons-admin-generic';

		acf_add_options_page(array(
			'page_title'      => __( 'Obecné nastavení vzhledu', THEME_ADMIN_TEXT_DOMAIN ),
			'menu_title'      => __( 'Obecné nastavení', THEME_ADMIN_TEXT_DOMAIN ),
			'menu_slug'       => 'general-config',
			'position'        => 40,
			'redirect'        => false,
			'icon_url'        => $adminMenuIcon,
			'update_button'   => __( 'Uložit', THEME_ADMIN_TEXT_DOMAIN ),
			'updated_message' => __( 'Nastavení bylo uloženo.', THEME_ADMIN_TEXT_DOMAIN ),
		));

		acf_add_options_sub_page(array(
			'page_title'      => __( 'Nastavení hlavičky webu', THEME_ADMIN_TEXT_DOMAIN ),
			'menu_title'      => __( 'Hlavička', THEME_ADMIN_TEXT_DOMAIN ),
			'parent_slug'     => 'general-config',
			'update_button'   => __( 'Uložit', THEME_ADMIN_TEXT_DOMAIN ),
			'updated_message' => __( 'Nastavení bylo uloženo.', THEME_ADMIN_TEXT_DOMAIN ),
		));

		acf_add_options_sub_page(array(
			'page_title'      => __( 'Nastavení patičky webu', THEME_ADMIN_TEXT_DOMAIN ),
			'menu_title'      => __( 'Patička', THEME_ADMIN_TEXT_DOMAIN ),
			'parent_slug'     => 'general-config',
			'update_button'   => __( 'Uložit', THEME_ADMIN_TEXT_DOMAIN ),
			'updated_message' => __( 'Nastavení bylo uloženo.', THEME_ADMIN_TEXT_DOMAIN ),
		));

		acf_add_options_sub_page(array(
			'page_title'      => __( 'Vložené kódy', THEME_ADMIN_TEXT_DOMAIN ),
			'menu_title'      => __( 'Vložené kódy', THEME_ADMIN_TEXT_DOMAIN ),
			'parent_slug'     => 'general-config',
			'update_button'   => __( 'Uložit', THEME_ADMIN_TEXT_DOMAIN ),
			'updated_message' => __( 'Nastavení bylo uloženo.', THEME_ADMIN_TEXT_DOMAIN ),
		));

	}
}
add_action( 'init', 'theme_acf_options_pages' );

?>