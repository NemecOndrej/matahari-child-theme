<?php /*ěščřžýáíéúů*/

// REPLACE THESE VALUES + rewrite labels:
// TAXONOMYNAME - taxonomy name (lovercase)
// [SLUG] - slug (lovercase)

/**
 * Add Taxonomy name.
 */
function theme_add_custom_taxonomy_TAXONOMYNAME() {
    register_taxonomy( 'TAXONOMYNAME', array( 'suported_post_type' ), array(
        'public'            => true,
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array(
            'slug'         => __( '[SLUG]', THEME_ADMIN_TEXT_DOMAIN ),
            'hierarchical' => true
        ),
        'show_in_rest'      => true,
        'labels'            => array(
            'name'                       => __( 'Kategorie', THEME_ADMIN_TEXT_DOMAIN ), // Tags
            'singular_name'              => __( 'Kategorie', THEME_ADMIN_TEXT_DOMAIN ), // Tag
            'search_items'               => __( 'Hledat kategorie', THEME_ADMIN_TEXT_DOMAIN ), // Search Tags
            'popular_items'              => __( 'Populární kategorie', THEME_ADMIN_TEXT_DOMAIN ), // Popular Tags
            'all_items'                  => __( 'Všechny kategorie', THEME_ADMIN_TEXT_DOMAIN ), // All Tags
            'parent_item'                => __( 'Nadřazená kategorie', THEME_ADMIN_TEXT_DOMAIN ), // Parent Category
            'parent_item_colon'          => __( 'Nadřazená kategorie', THEME_ADMIN_TEXT_DOMAIN ) . ':', // Parent Category:
            'edit_item'                  => __( 'Upravit kategorii', THEME_ADMIN_TEXT_DOMAIN ), // Edit Tag
            'view_item'                  => __( 'Zobrazit kategorii', THEME_ADMIN_TEXT_DOMAIN ), // View Tag
            'update_item'                => __( 'Aktualizovat kategorii', THEME_ADMIN_TEXT_DOMAIN ), // Update Tag
            'add_new_item'               => __( 'Přidat novou kategorii', THEME_ADMIN_TEXT_DOMAIN ), // Add New Tag
            'new_item_name'              => __( 'Název nové kategorie', THEME_ADMIN_TEXT_DOMAIN ), // New Tag Name
            'separate_items_with_commas' => __( 'Oddělte kategorie čárkami', THEME_ADMIN_TEXT_DOMAIN ), // Separate tags with commas
            'add_or_remove_items'        => __( 'Přidat nebo odebrat kategorie', THEME_ADMIN_TEXT_DOMAIN ), // Add or remove tags
            'choose_from_most_used'      => __( 'Vyberte si z nejpoužívanějších', THEME_ADMIN_TEXT_DOMAIN ), // Choose from the most used tags
            'not_found'                  => __( 'Žádné kategorie nebyly nalezeny.', THEME_ADMIN_TEXT_DOMAIN ), // No tags found.
            'no_terms'                   => __( 'Žádné kategorie nebyly nalezeny.', THEME_ADMIN_TEXT_DOMAIN ), // No tags
            'filter_by_item'             => __( 'Filtrovat podle kategorie', THEME_ADMIN_TEXT_DOMAIN ), // Filter by category
            'items_list_navigation'      => __( 'Navigace seznamu kategorií', THEME_ADMIN_TEXT_DOMAIN ), // Tags list navigation
            'items_list'                 => __( 'Seznam kategorií', THEME_ADMIN_TEXT_DOMAIN ), // Tags list
            /* translators: Tab heading when selecting from the most used terms. */
            'most_used'                  => __( 'Nejpoužívanější kategorie', THEME_ADMIN_TEXT_DOMAIN ), // Most Used
            'back_to_items'              => __( '&larr; Zpět na seznam kategorií', THEME_ADMIN_TEXT_DOMAIN ), // &larr; Go to Tags
        )
    ));
}
add_action( 'init', 'theme_add_custom_taxonomy_TAXONOMYNAME' );

?>