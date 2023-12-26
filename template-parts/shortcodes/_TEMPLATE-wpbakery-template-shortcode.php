<?php /*ěščřžýáíéúů*/

class VcSodaBlockquote extends WPBakeryShortCode {

    function __construct() {
        add_action( 'init', array( $this, 'create_shortcode' ), 999 );
        add_shortcode( 'vc_soda_blockquote', array( $this, 'render_shortcode' ) );

    }

    public function create_shortcode() {
        // Stop all if VC is not enabled
        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }

        // Map blockquote with vc_map()
        vc_map( array(
            'name'          => __('Blockquote', THEME_TEXT_DOMAIN),
            'base'          => 'vc_soda_blockquote',
            'description'  	=> __( '', THEME_TEXT_DOMAIN ),
            'category'      => __( 'SodaWebMedia Modules', THEME_TEXT_DOMAIN),
            'params' => array(

                array(
                    "type" => "textarea_html",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __( "Blockquote Content", THEME_TEXT_DOMAIN ),
                    "param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
                    "value" => __( "<p>I am test text block. Click edit button to change this text.</p>", THEME_TEXT_DOMAIN ),
                    "description" => __( "Enter content.", THEME_TEXT_DOMAIN )
                ),

                array(
                    'type'          => 'textfield',
                    'holder'        => 'div',
                    'heading'       => __( 'Author Quote', THEME_TEXT_DOMAIN ),
                    'param_name'    => 'quote_author',
                    'value'         => __( '', THEME_TEXT_DOMAIN ),
                    'description'   => __( 'Add Author Quote.', THEME_TEXT_DOMAIN ),
                ),


                array(
                    "type" => "vc_link",
                    "class" => "",
                    "heading" => __( "Blockquote Cite", THEME_TEXT_DOMAIN ),
                    "param_name" => "blockquote_cite",
                    "description" => __( "Add Citiation Link and Source Name", THEME_TEXT_DOMAIN ),
                ),

                array(
                    'type'          => 'textfield',
                    'heading'       => __( 'Element ID', THEME_TEXT_DOMAIN ),
                    'param_name'    => 'element_id',
                    'value'             => __( '', THEME_TEXT_DOMAIN ),
                    'description'   => __( 'Enter element ID (Note: make sure it is unique and valid).', THEME_TEXT_DOMAIN ),
                    'group'         => __( 'Extra', THEME_TEXT_DOMAIN),
                ),

                array(
                    'type'          => 'textfield',
                    'heading'       => __( 'Extra class name', THEME_TEXT_DOMAIN ),
                    'param_name'    => 'extra_class',
                    'value'             => __( '', THEME_TEXT_DOMAIN ),
                    'description'   => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', THEME_TEXT_DOMAIN ),
                    'group'         => __( 'Extra', THEME_TEXT_DOMAIN),
                ),
            ),
        ));

    }

    public function render_shortcode( $atts, $content, $tag ) {
        $atts = (shortcode_atts(array(
            'blockquote_cite'   => '',
            'quote_author'      => '',
            'extra_class'       => '',
            'element_id'        => ''
        ), $atts));


        //Content 
        $content            = wpb_js_remove_wpautop($content, true);
        $quote_author       = esc_html($atts['quote_author']);

        //Cite Link
        $blockquote_source  = vc_build_link( $atts['blockquote_cite'] );
        $blockquote_title   = esc_html($blockquote_source["title"]);
        $blockquote_url     = esc_url( $blockquote_source['url'] );

        //Class and Id
        $extra_class        = esc_attr($atts['extra_class']);
        $element_id         = esc_attr($atts['element_id']);



        $output = '';
        $output .= '<div class="blockquote ' . $extra_class . '" id="' . $element_id . '" >';
        $output .= '<blockquote cite="' . $blockquote_url . '">';
        $output .= $content;
        $output .= '<footer>' . $quote_author . ' - <cite><a href="' . $blockquote_url . '">' . $blockquote_title . '</a></cite></footer>';
        $output .= '</blockquote>';
        $output .= '</div>';

        return $output;

    }

}

new VcSodaBlockquote();

?>