<?php /*ěščřžýáíéúů*/

/**
 * Add template SLUG as class to menu items.
 * @param array $classes Current classes.
 * @param object $item Menu item.
 * @return array Final classes.
 */
function theme_adjust_nav_menu_css_class( $classes, $item ) {
    // only check pages
    if ( 'page' == $item->object ) {
        // if this page has a template assigned
        $slug = get_page_template_slug( $item->object_id );
        if ( $slug ) {
            $classes[] = sanitize_html_class( $slug );
        }
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'theme_adjust_nav_menu_css_class', 10, 2 );

/**
 * Add custom attribute to all menu items.
 * @param mixed $atts Current attributes.
 * @param mixed $item Menu item.
 * @param mixed $args Args
 * @return mixed Changed attributes.
 */
function theme_adjust_nav_menu_link_attributes( $atts, $item, $args ) {
    // object ID
    $atts['data-id'] = $item->object_id;

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'theme_adjust_nav_menu_link_attributes', 10, 3 );

?>