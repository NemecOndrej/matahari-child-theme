<?php /*ěščřžýáíéúů*/

/**
 * Add custom widgets sidebar.
 */
function theme_widgets_init() {

	register_sidebar( array(
		'name'           => __( 'Widgety napravo', THEME_ADMIN_TEXT_DOMAIN ), // (string) The name or title of the sidebar displayed in the Widgets interface. Default 'Sidebar $instance'.
		'id'             => 'theme_widgets', // (string) The unique identifier by which the sidebar will be called. Default 'sidebar-$instance'.
        'description'    => __( '', THEME_ADMIN_TEXT_DOMAIN ), // (string) Description of the sidebar, displayed in the Widgets interface. Default empty string.
        'class'          => '', // (string) Extra CSS class to assign to the sidebar in the Widgets interface.
		'before_widget'  => '<section id="%1$s" class="widget %2$s">', // (string) HTML content to prepend to each widget's HTML output when assigned to this sidebar. Receives the widget's ID attribute as %1$s and class name as %2$s. Default is an opening list item element.
		'after_widget'   => '</section>', // (string) HTML content to append to each widget's HTML output when assigned to this sidebar. Default is a closing list item element.
		'before_title'   => '<h3>', // (string) HTML content to prepend to the sidebar title when displayed. Default is an opening h2 element.
		'after_title'    => '</h3>', // (string) HTML content to append to the sidebar title when displayed. Default is a closing h2 element.
        'before_sidebar' => '', // (string) HTML content to prepend to the sidebar when displayed. Receives the $id argument as %1$s and $class as %2$s. Outputs after the 'dynamic_sidebar_before' action. Default empty string.
        'after_sidebar'  => '', // (string) HTML content to append to the sidebar when displayed. Outputs before the 'dynamic_sidebar_after' action. Default empty string.
	) );
}
add_action( 'widgets_init', 'theme_widgets_init' );

/**
 * Unregister all default widgets.
 */
function theme_unregister_default_widgets() {
    // default WP widgets
    unregister_widget( 'WP_Widget_Pages' );
    unregister_widget( 'WP_Widget_Calendar' );
    unregister_widget( 'WP_Widget_Archives' );
    unregister_widget( 'WP_Widget_Links' );
    unregister_widget( 'WP_Widget_Meta' );
    unregister_widget( 'WP_Widget_Search' );
    unregister_widget( 'WP_Widget_Text' );
    unregister_widget( 'WP_Widget_Categories' );
    unregister_widget( 'WP_Widget_Recent_Posts' );
    unregister_widget( 'WP_Widget_Recent_Comments' );
    unregister_widget( 'WP_Widget_RSS' );
    unregister_widget( 'WP_Widget_Media_Audio' );
    unregister_widget( 'WP_Widget_Media_Video' );
    unregister_widget( 'WP_Widget_Media_Gallery' );
    unregister_widget( 'WP_Widget_Media_Image' );
    unregister_widget( 'WP_Widget_Tag_Cloud' );
    unregister_widget( 'WP_Nav_Menu_Widget' );
    unregister_widget( 'WP_Widget_Custom_HTML' );

    // WPML widgets
    unregister_widget( 'WP_Widget_Text_Icl' );
    unregister_widget( 'WPML_LS_Widget' );
}
add_action( 'widgets_init', 'theme_unregister_default_widgets', 22 );

// get list of all registered widgets (use in theme):
/*
$widgets = array_keys( $GLOBALS['wp_widget_factory']->widgets );
print '<pre>$widgets = ' . esc_html( var_export( $widgets, TRUE ) ) . '</pre>';
*/

// sidebar implementation in the theme:
/*
if ( is_active_sidebar( 'theme_widgets' ) ) {
    // if sidebar contains widgets, display it
    dynamic_sidebar( 'theme_widgets' );
}
*/

?>