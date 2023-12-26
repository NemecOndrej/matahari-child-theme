<?php /*ěščřžýáíéúů*/

// REPLACE THESE VALUES + rewrite labels:
// POSTTYPE - post type name (lovercase)
// [SLUG] - slug (lovercase)


#region POST TYPE DEFINITION ----------------------------------------------------

/**
 * Add Post type name.
 */
function theme_add_custom_post_type_POSTTYPE() {
    // DOCS: https://developer.wordpress.org/reference/functions/register_post_type/
    register_post_type( 'POSTTYPE', array(
        'public'              => true, 
        'hierarchical'        => false,
        //'exclude_from_search' => true, // default is oposite to 'public'
        'show_ui'             => true, 
        'menu_position'       => 30, 
        'menu_icon'           => 'dashicons-hammer', // https://developer.wordpress.org/resource/dashicons/ or base64 encoded SVG or leave blank and in file /admin/assets/css/icons.css you can use fontawesome
        'rewrite'             => array(
                                     'slug' => __( '[SLUG]', THEME_ADMIN_TEXT_DOMAIN ),
                                     'with_front' => false
                                 ),
        'has_archive'         => false,
        'taxonomies'          => array(),
        'show_in_rest'        => true, // allow Guttenberg
        'supports'            => array( 'title' ), // 'title', 'thumbnail', 'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt', 'page-attributes', 'custom-fields', 'post-formats'
        'labels'              => array(
            'name'                     => __( 'Články', THEME_ADMIN_TEXT_DOMAIN ), // Posts
            'singular_name'            => __( 'Článek', THEME_ADMIN_TEXT_DOMAIN ), // Post
            'add_new'                  => __( 'Přidat nový', THEME_ADMIN_TEXT_DOMAIN ), // Add New
            'add_new_item'             => __( 'Přidat nový článek', THEME_ADMIN_TEXT_DOMAIN ), // Add New Post
            'edit_item'                => __( 'Upravit článek', THEME_ADMIN_TEXT_DOMAIN ), // Edit Post
            'new_item'                 => __( 'Nový článek', THEME_ADMIN_TEXT_DOMAIN ), // New Post
            'view_item'                => __( 'Zobrazit článek', THEME_ADMIN_TEXT_DOMAIN ), // View Post
            'view_items'               => __( 'Zobrazit články', THEME_ADMIN_TEXT_DOMAIN ), // View Posts
            'search_items'             => __( 'Hledat články', THEME_ADMIN_TEXT_DOMAIN ), // Search Posts
            'not_found'                => __( 'Žádné záznamy nebyly nalezeny', THEME_ADMIN_TEXT_DOMAIN ), // No posts found.
            'not_found_in_trash'       => __( 'V koši nejsou žádné články.', THEME_ADMIN_TEXT_DOMAIN ), // No posts found in Trash.
            'parent_item_colon'        => __( 'Nadřazený článek:', THEME_ADMIN_TEXT_DOMAIN ), // Parent Page:
            'all_items'                => __( 'Všechny články', THEME_ADMIN_TEXT_DOMAIN ), // All Posts
            'archives'                 => __( 'Archivy článků', THEME_ADMIN_TEXT_DOMAIN ), // Post Archives
            'attributes'               => __( 'Atributy článků', THEME_ADMIN_TEXT_DOMAIN ), // Post Attributes
            'insert_into_item'         => __( 'Vložit do článku', THEME_ADMIN_TEXT_DOMAIN ), // Insert into post
            'uploaded_to_this_item'    => __( 'Nahrané k tomuto článku', THEME_ADMIN_TEXT_DOMAIN ), // Uploaded to this post
            'featured_image'           => __( 'Náhledový obrázek', THEME_ADMIN_TEXT_DOMAIN ), // Featured image
            'set_featured_image'       => __( 'Nastavit náhledový obrázek', THEME_ADMIN_TEXT_DOMAIN ), // Set featured image
            'remove_featured_image'    => __( 'Odstranit náhledový obrázek', THEME_ADMIN_TEXT_DOMAIN ), // Remove featured image
            'use_featured_image'       => __( 'Použít jako náhledový obrázek', THEME_ADMIN_TEXT_DOMAIN ), // Use as featured image
            'filter_items_list'        => __( 'Filtrovat seznam článků', THEME_ADMIN_TEXT_DOMAIN ), // Filter posts list
            'filter_by_date'           => __( 'Filtrovat podle data', THEME_ADMIN_TEXT_DOMAIN ), // Filter by date
            'items_list_navigation'    => __( 'Navigace seznamu článků', THEME_ADMIN_TEXT_DOMAIN ), // Posts list navigation
            'items_list'               => __( 'Seznam článků', THEME_ADMIN_TEXT_DOMAIN ), // Posts list
            'item_published'           => __( 'Článek byl publikován.', THEME_ADMIN_TEXT_DOMAIN ), // Post published.
            'item_published_privately' => __( 'Článek byl publikován jako soukromý.', THEME_ADMIN_TEXT_DOMAIN ), // Post published privately.
            'item_reverted_to_draft'   => __( 'Článek byl změněn na koncept.', THEME_ADMIN_TEXT_DOMAIN ), // Post reverted to draft.
            'item_scheduled'           => __( 'Článek byl naplánován.', THEME_ADMIN_TEXT_DOMAIN ), // Post scheduled.
            'item_updated'             => __( 'Článek byl aktualizován.', THEME_ADMIN_TEXT_DOMAIN ), // Post updated.
        ),
        // custom capabilities for extended rights management
        /*'capabilities' => array(
            'create_posts'       => 'create_POSTTYPEs',
            'edit_post'          => 'edit_POSTTYPE',
            'edit_posts'         => 'edit_POSTTYPEs',
            'edit_others_posts'  => 'edit_other_POSTTYPEs',
            'publish_posts'      => 'publish_POSTTYPEs',
            'read_post'          => 'read_POSTTYPE',
            'read_private_posts' => 'read_private_POSTTYPEs',
            'delete_post'        => 'delete_POSTTYPE'
        ),*/
    ));
}
add_action( 'init', 'theme_add_custom_post_type_POSTTYPE' );

#endregion

#region CUSTOM ADMIN LIST COLUMNS -----------------------------------------------

/**
 * Add custom post type admin list columns.
 * @param array $columns Existing columns.
 * @return array Adjusted columns.
 */
function POSTTYPE_admin_columns( $columns ) {
    // remove date
    unset( $columns["date"] );
    
    $columns['POSTTYPE_customfieldname'] = __( 'Název', THEME_ADMIN_TEXT_DOMAIN );
    $columns['POSTTYPE_thumbnail'] = __( 'Náhledový obrázek', THEME_ADMIN_TEXT_DOMAIN );

    // add date to the end
    //$columns["date"] = __('Datum', THEME_ADMIN_TEXT_DOMAIN);

    return $columns;
}
add_filter( 'manage_POSTTYPE_posts_columns', 'POSTTYPE_admin_columns' );

/**
 * Set content of custom admin columns.
 * @param string $column Name of the column.
 * @param int $post_id Id of the post.
 */
function POSTTYPE_admin_columns_content( $column, $post_id ) {
    switch ( $column )
    {
        case 'POSTTYPE_customfieldname':
            echo get_field( 'customfieldname', $post_id );
            break;
        case 'POSTTYPE_customfieldnamecheckbox':
            echo '<input type="checkbox" ' . ( get_field( 'isXXXXXX', $post_id ) ? 'checked="checked"' : '' ) . ' disabled="disabled" />';
            break;
        case 'POSTTYPE_thumbnail':
            echo '<span style="width:90px;height:70px;display:block;background: url(\'' . 
                Theme::get_thumbnail4post( $post_id, 'thumbnail' ) . 
                '\') no-repeat center center;background-size:cover;">&nbsp;</span>';
            break;
    }
}
add_action( 'manage_POSTTYPE_posts_custom_column' , 'POSTTYPE_admin_columns_content', 10, 2 );

#endregion

#region CUSTOM ADMIN LIST FILTERS -----------------------------------------------

/**
 * Add custom taxonomy post type list filter.
 * (do not need to update query, it is native)
 * @param string $post_type Post type name.
 * @param string $which Placement: top|bottom
 * @return void
 */
function POSTTYPE_admin_taxonomy_filter( $post_type, $which ) {
    if ( 'POSTTYPE' !== $post_type ) {
        return;
    }
 
    $taxonomy_slug = 'custom-taxonomy-slug';
    $taxonomy      = get_taxonomy( $taxonomy_slug );
    $selected      = '';
  
    if ( isset( $_GET[$taxonomy_slug] ) ) {
        $selected = $_GET[$taxonomy_slug]; //in case the current page is already filtered
    }
     
    wp_dropdown_categories( array(
        'show_option_all' =>  $taxonomy->label . ' - ' . __( 'Vše', THEME_ADMIN_TEXT_DOMAIN ),
        'taxonomy'        =>  $taxonomy_slug,
        'name'            =>  $taxonomy_slug,
        'value_field'     => 'slug',
        'orderby'         =>  'name',
        'selected'        =>  $selected,
        'hierarchical'    =>  true,
        'depth'           =>  3,
        'show_count'      =>  true, // Show number of post in parent term
        'hide_empty'      =>  false, // Don't show posts w/o terms
    ) );
}
add_action( 'restrict_manage_posts', 'POSTTYPE_admin_taxonomy_filter', 10, 2 );

/**
 * Add custom post type filters in admin list.
 * @param string $post_type Post type name.
 * @param string $which Placement: top|bottom
 * @return void
 */
function POSTTYPE_admin_custom_filters( $post_type, $which ) {
    // check post type
    if ( 'POSTTYPE' !== $post_type ) {
        return;
    }

    global $wpdb;

    $filter_name = 'pages'; // name of the filter: get attribute + name & id of the html element
    $selected = '';
    if ( isset( $_GET[$filter_name] ) ) {
        $selected = $_GET[$filter_name];
    }
    
    // load data and write select
    $sql = "SELECT ID, post_title FROM {$wpdb->prefix}posts WHERE post_type = 'page' ORDER BY post_title ASC"; // use $wpdb->prepare or esc_sql
    $results = $wpdb->get_results( $sql, ARRAY_A );
    if ( isset( $results ) && is_array( $results ) && count( $results ) > 0 ) {
        echo '<select id="' . $filter_name . '" name="' . $filter_name . '">';
        echo '<option value="">' . __( 'Vše', THEME_ADMIN_TEXT_DOMAIN ) . '</option>';
        foreach ( $results as $result ) {
            echo '<option value="' . $result['ID'] . '"' . ( $result['ID'] == $selected ? ' selected="selected"' : '' ) . '>';
            echo $result['post_title'] . '</option>';
        }
        echo '</select>';
    }
}
add_action( 'restrict_manage_posts', 'POSTTYPE_admin_custom_filters', 10, 2 );

/**
 * Adjust current query by custom filters.
 * @param mixed $query Current WP_Query.
 * @return mixed Adjusted query.
 */
function POSTTYPE_admin_custom_filters_adjust_query( $query ) {

    $filter_name = 'pages'; // name of the filter: get attribute + name & id of the html element

    // check location - admin and main query
    if ( 
        !is_admin() || 
        !$query->is_main_query() || 
        'POSTTYPE' != $query->query['post_type'] ||
        !isset( $_GET[$filter_name] )
    ) { 
        return $query;
    }

    $filter_value = $_GET[$filter_name];

    // don't filter for empty value
    if ( strlen( $filter_value ) == 0 ) {
        return $query;
    }

    // set conditions

    // EXAMPLE 1: filter by single meta field's value
    //$query->query_vars['meta_key'] = 'meta_name';
    //$query->query_vars['meta_value'] = $filter_value;

    // EXAMPLE 2: filter by complex meta query
    /*$query->set( 'meta_query', array(
                'relation' => 'OR',
                array(
                    'key'       => 'meta_name1',
                    'value'     => $filter_value1,
                    'compare'   => '='
                ),
                array(
                    'key'       => 'meta_name2',
                    'value'     => $filter_value2,
                    'compare'   => '='
                )
            ) );*/

    return $query;
}
add_filter( 'parse_query', 'POSTTYPE_admin_custom_filters_adjust_query' , 10);

#endregion

?>