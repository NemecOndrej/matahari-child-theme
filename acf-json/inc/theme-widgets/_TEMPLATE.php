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

        $title = apply_filters( 'widget_title', $instance['title'] );
 
        echo $before_widget;
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
        }
        echo __( 'Hello, World!', THEME_ADMIN_TEXT_DOMAIN );
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
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', THEME_ADMIN_TEXT_DOMAIN );
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', THEME_ADMIN_TEXT_DOMAIN ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
         </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;
    }
 
}

// register widget
add_action( 'widgets_init', function() {
    register_widget( 'Theme_Widget_CLASS_NAME' ); 
} );

?>