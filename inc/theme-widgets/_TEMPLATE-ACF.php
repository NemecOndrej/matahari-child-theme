<?php /*ěščřžýáíéúů*/

/*
VALUES TO REPLACE:
CLASS_NAME
NAME
DESCRIPTION
*/

/**
 * Adds CLASS_NAME widget.
 */
class Theme_Widget_CLASS_NAME extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            strtolower( 'theme_widget_CLASS_NAME' ), // Base ID
            __( 'NAME', THEME_ADMIN_TEXT_DOMAIN ), // Name
            array(
                'classname' => 'CLASS_NAME',
                'description' => __( 'DESCRIPTION', THEME_ADMIN_TEXT_DOMAIN ),
            ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        /*
        EXTRACTED ARGS

        SIDEBAR:
        $name
        $id
        $description
        $class
        $before_sidebar - code to put before the sidebar
        $after_sidebar  - code to put after the sidebar

        WIDGET:
        $widget_id     - ID of the widget
        $widget_name   - name of the widget
        $before_widget - code to put before the widget
        $after_widget  - code to put after the widget
        $before_title  - code to put before the widget title
        $after_title   - code to put after the widget title
        */

        echo $before_widget;
        the_field( 'my_field_name', 'widget_' . $widget_id );
        echo $after_widget;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        // must be implemented or Save button will not appear

        // widget admin title from ACF field (WP takes value of this field by JS)
        echo '<input type="hidden" value="' . get_field( 'my_field4title', 'widget_' . $this->id ) . '" name="' . $this->get_field_name( 'title' ) . '" id="' . $this->get_field_id( 'title' ) . '" />';
    }
 
}

// register widget
add_action( 'widgets_init', function() {
    register_widget( 'Theme_Widget_CLASS_NAME' ); 
} );

?>