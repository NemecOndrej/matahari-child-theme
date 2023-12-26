<?php /*ěščřžýáíéúů*/

/**
 * Remove posts.
 */
function theme_remove_posts() { 
    remove_menu_page( 'edit.php' );
}
//add_action('admin_menu', 'theme_remove_posts');

/**
 * Remove classic author.
 */
function theme_remove_posts_author() {
    remove_post_type_support( 'post', 'author' );
}
//add_action('init', 'theme_remove_posts_author');

/**
 * Remove tags functionality.
 */
function theme_remove_post_tags() {
    register_taxonomy( 'post_tag', array() );
}
//add_action('init', 'theme_remove_post_tags');

/**
 * Remove categories functionality.
 */
function theme_remove_post_categories() {
    register_taxonomy( 'category', array() );
}
//add_action('init', 'theme_remove_post_categories');

/**
 * Change default admin icon for posts.
 * @param array $args Post type args.
 * @param string $post_type Post type.
 * @return array Adjusted args.
 */
function theme_change_posts_admin_icon( $args, $post_type ) {
    if ( $post_type == 'post' ) {
        // https://developer.wordpress.org/resource/dashicons/ or base64 encoded SVG
        $args['menu_icon'] = 'dashicons-calendar-alt';
    }
 
    return $args;
}
//add_filter('register_post_type_args', 'theme_change_posts_admin_icon', 10, 2);

/**
 * Change the maximum number of words in a post excerpt.
 * @param int $length Current length.
 * @return int Wanted length.
 */
function theme_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'theme_excerpt_length' );

/**
 * Change endings of cropped excerpts.
 * @param string $text Text of the excerpt.
 * @return string Changed text of the excerpt.
 */
function theme_crop_excerpt_change($text) {
	return str_replace( '[&hellip;]', '...', $text );
}
add_filter( 'get_the_excerpt', 'theme_crop_excerpt_change' );

/**
 * Customize excerpt.
 * @param string $text Current excerpt text.
 * @return string Adjusted excerpt.
 */
function theme_customize_excerpt( $text ) {
	return $text;
}
//add_filter('get_the_excerpt', 'theme_customize_excerpt');

/**
 * Change default post labels.
 */
function theme_change_post_labels() {
    global $wp_post_types;
    $labels = $wp_post_types['post']->labels;

    $labels->name                     = __( 'Články', THEME_ADMIN_TEXT_DOMAIN ); // Posts
    $labels->singular_name            = __( 'Článek', THEME_ADMIN_TEXT_DOMAIN ); // Post
    $labels->add_new                  = __( 'Přidat nový', THEME_ADMIN_TEXT_DOMAIN ); // Add New
    $labels->add_new_item             = __( 'Přidat nový článek', THEME_ADMIN_TEXT_DOMAIN ); // Add New Post
    $labels->edit_item                = __( 'Upravit článek', THEME_ADMIN_TEXT_DOMAIN ); // Edit Post
    $labels->new_item                 = __( 'Nový článek', THEME_ADMIN_TEXT_DOMAIN ); // New Post
    $labels->view_item                = __( 'Zobrazit článek', THEME_ADMIN_TEXT_DOMAIN ); // View Post
    $labels->view_items               = __( 'Zobrazit články', THEME_ADMIN_TEXT_DOMAIN ); // View Posts
    $labels->search_items             = __( 'Hledat články', THEME_ADMIN_TEXT_DOMAIN ); // Search Posts
    $labels->not_found                = __( 'Žádné záznamy nebyly nalezeny', THEME_ADMIN_TEXT_DOMAIN ); // No posts found.
    $labels->not_found_in_trash       = __( 'V koši nejsou žádné články.', THEME_ADMIN_TEXT_DOMAIN ); // No posts found in Trash.
    $labels->parent_item_colon        = __( 'Nadřazený článek:', THEME_ADMIN_TEXT_DOMAIN ); // Parent Page:
    $labels->all_items                = __( 'Všechny články', THEME_ADMIN_TEXT_DOMAIN ); // All Posts
    $labels->archives                 = __( 'Archivy článků', THEME_ADMIN_TEXT_DOMAIN ); // Post Archives
    $labels->attributes               = __( 'Atributy článků', THEME_ADMIN_TEXT_DOMAIN ); // Post Attributes
    $labels->insert_into_item         = __( 'Vložit do článku', THEME_ADMIN_TEXT_DOMAIN ); // Insert into post
    $labels->uploaded_to_this_item    = __( 'Nahrané k tomuto článku', THEME_ADMIN_TEXT_DOMAIN ); // Uploaded to this post
    $labels->featured_image           = __( 'Náhledový obrázek', THEME_ADMIN_TEXT_DOMAIN ); // Featured image
    $labels->set_featured_image       = __( 'Nastavit náhledový obrázek', THEME_ADMIN_TEXT_DOMAIN ); // Set featured image
    $labels->remove_featured_image    = __( 'Odstranit náhledový obrázek', THEME_ADMIN_TEXT_DOMAIN ); // Remove featured image
    $labels->use_featured_image       = __( 'Použít jako náhledový obrázek', THEME_ADMIN_TEXT_DOMAIN ); // Use as featured image
    $labels->filter_items_list        = __( 'Filtrovat seznam článků', THEME_ADMIN_TEXT_DOMAIN ); // Filter posts list
    $labels->filter_by_date           = __( 'Filtrovat podle data', THEME_ADMIN_TEXT_DOMAIN ); // Filter by date
    $labels->items_list_navigation    = __( 'Navigace seznamu článků', THEME_ADMIN_TEXT_DOMAIN ); // Posts list navigation
    $labels->items_list               = __( 'Seznam článků', THEME_ADMIN_TEXT_DOMAIN ); // Posts list
    $labels->item_published           = __( 'Článek byl publikován.', THEME_ADMIN_TEXT_DOMAIN ); // Post published.
    $labels->item_published_privately = __( 'Článek byl publikován jako soukromý.', THEME_ADMIN_TEXT_DOMAIN ); // Post published privately.
    $labels->item_reverted_to_draft   = __( 'Článek byl změněn na koncept.', THEME_ADMIN_TEXT_DOMAIN ); // Post reverted to draft.
    $labels->item_scheduled           = __( 'Článek byl naplánován.', THEME_ADMIN_TEXT_DOMAIN ); // Post scheduled.
    $labels->item_updated             = __( 'Článek byl aktualizován.', THEME_ADMIN_TEXT_DOMAIN ); // Post updated.

    $labels->menu_name = __('Články', THEME_ADMIN_TEXT_DOMAIN);
    $labels->name_admin_bar = __('Vytvořit článek', THEME_ADMIN_TEXT_DOMAIN);
}
add_action( 'init', 'theme_change_post_labels' );

/**
 * Change posts menu labels.
 */
function theme_change_posts_menu() {
    global $menu;
    global $submenu;
    $menu[5][0] = __('Články', THEME_ADMIN_TEXT_DOMAIN);
    $submenu['edit.php'][5][0] = __('Přehled článků', THEME_ADMIN_TEXT_DOMAIN);
    $submenu['edit.php'][10][0] = __('Přidat článek', THEME_ADMIN_TEXT_DOMAIN);
    $submenu['edit.php'][15][0] = __('Rubriky', THEME_ADMIN_TEXT_DOMAIN);
    $submenu['edit.php'][16][0] = __('Štítky', THEME_ADMIN_TEXT_DOMAIN);
}
add_action( 'admin_menu', 'theme_change_posts_menu' );

/**
 * Generate excerpt from content if excerpt field is empty - support for Guttenberg content.
 * @param string $post_excerpt Existing content of the excerpt.
 * @return string Content of the excerpt.
 */
function theme_generate_excerpt4empty_gutenberg( $post_excerpt ) {
    global $post;

    // fix for content filter, that adds fix space entitity to empty content
    $post_excerpt = str_replace( '&nbsp;', ' ', $post_excerpt );

    if ( isset( $post ) && is_object( $post ) && strlen( trim( $post_excerpt ) ) == 0 ) {
        global $wpdb;
        $generated_excerpt = $wpdb->get_var("SELECT post_content FROM {$wpdb->prefix}posts WHERE ID = {$post->ID}");
        if ( isset( $generated_excerpt ) && strlen( trim( $generated_excerpt ) ) > 0 ) {
            if ( has_blocks( $generated_excerpt ) ) {
                $blocks = parse_blocks( $generated_excerpt );
                $generated_excerpt = '';
                foreach ( $blocks as $block ) {
                    if ( $block['blockName'] == 'acf/text' ) // change block if needed
                    {
                        $generated_excerpt .= $block['attrs']['data']['content'] . ' ';
                    }
                }
            }
            $generated_excerpt = strip_tags( $generated_excerpt );
            $generated_excerpt = trim( str_replace( "\n", ' ', $generated_excerpt ) );
            $generated_excerpt = wp_trim_words( $generated_excerpt, 18, '...' );
            return $generated_excerpt;
        } elseif ( $post->post_type == 'galleries' ) { // customization for custom post type without content / blocks
            $generated_excerpt = get_field( 'description', $post->ID );
            if ( strlen( $generated_excerpt ) > 10 ) {
                $generated_excerpt = strip_tags( $generated_excerpt );
                $generated_excerpt = trim( str_replace( '\n', ' ', $generated_excerpt ) );
                $generated_excerpt = wp_trim_words( $generated_excerpt, 18, '...' );
                return $generated_excerpt;
            }
        }
    }

    return $post_excerpt;
}
add_filter( 'get_the_excerpt', 'theme_generate_excerpt4empty_gutenberg' );

#region CUSTOM ADMIN LIST COLUMNS -----------------------------------------------

/**
 * Customize default post columns in admin list.
 * @param array $columns Current admin list columns.
 * @return array Adjusted columns.
 */
function theme_post_admin_columns( $columns ) {
    // remove date
    unset( $columns['date'] );
    
    //$columns['posts_customfieldname'] = __('Název extra políčka', THEME_ADMIN_TEXT_DOMAIN);

    // add date to the end
    $columns['date'] = __( 'Datum', THEME_ADMIN_TEXT_DOMAIN );

    return $columns;
}
add_filter( 'manage_post_posts_columns', 'theme_post_admin_columns' );

/**
 * Set admin list columns content.
 * @param string $column Column name.
 * @param int $post_id Id of the post.
 */
function theme_post_admin_columns_content( $column, $post_id ) {
    switch ( $column ) {
        case 'posts_customfieldname':
            echo get_field( 'XXXX', $post_id );
            break;
        case 'posts_customfieldnamecheckbox':
            echo '<input type="checkbox" ' . ( get_field( 'isXXXXXX', $post_id ) ? 'checked="checked"' : '' ) . ' disabled="disabled" />';
            break;
        case 'posts_thumbnail':
            echo '<span style="width:90px;height:70px;display:block;background: url(\'' . 
                Theme::get_thumbnail4post( $post_id, 'thumbnail' ) . 
                '\') no-repeat center center;background-size:cover;">&nbsp;</span>';
            break;
    }
}
add_action( 'manage_post_posts_custom_column' , 'theme_post_admin_columns_content', 10, 2 );

#endregion

?>