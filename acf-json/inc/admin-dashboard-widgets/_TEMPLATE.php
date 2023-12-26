<?php /*ěščřžýáíéúů*/

/**
 * Add custom admin dashboard widget.
 */
function theme_custom_admin_dashboard_widget() {
    ?>
    <p>Lorem ipsum dolor sit amet.</p>
    <?php
}
wp_add_dashboard_widget( 'theme-custom-dashboard-widget', __( 'Widget title', THEME_ADMIN_TEXT_DOMAIN ), 'theme_custom_admin_dashboard_widget' );
?>