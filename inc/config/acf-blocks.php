<?php /*ěščřžýáíéúů*/

// TUTORIAL: https://www.advancedcustomfields.com/blog/acf-5-8-introducing-acf-blocks-for-gutenberg/

// remove Guttenberg block patterns
remove_theme_support( 'core-block-patterns' );

/**
 * Setup Guttenberg blocks size.
 */
function editor_full_width_gutenberg() {
    ?>
    <style>
    body.gutenberg-editor-page .editor-post-title__block, body.gutenberg-editor-page .editor-default-block-appender, body.gutenberg-editor-page .editor-block-list__block {
        max-width: none !important;
    }
    .block-editor__container .wp-block {
        max-width: 100% !important;
    }
    /*code editor*/
    .edit-post-text-editor__body {
        max-width: none !important;	
        margin-left: 2%;
        margin-right: 2%;
    }
    </style>
    <?php
}
add_action( 'admin_head', 'editor_full_width_gutenberg' );

// array of blocks to register
global $blocks, $blocks_js_assets_dir, $blocks_css_assets_dir;
$blocks_js_assets_dir = '/assets/js/acf-blocks/';
$blocks_css_assets_dir = '/assets/css/acf-blocks/';
$blocks = array(
    array(
        'name' => '',
        'title' => __( 'Název', THEME_ADMIN_TEXT_DOMAIN ),
        'description' => '',
        'icon' => 'text',
        'enqueue_assets' => function() {
            global $blocks_js_assets_dir, $blocks_css_assets_dir;
            wp_enqueue_script( 'theme-block-XXXXXX', Theme::get_asset_src( $blocks_js_assets_dir . 'XXXXXX.js' ), array(), null, array('strategy'=>'defer','in_footer'=>true) );
            wp_enqueue_style( 'theme-block-XXXXXX', Theme::get_asset_src( $blocks_css_assets_dir . 'XXXXXX.css' ), array(), null, 'all' );
        },
        // 'post_types' => array()
    ),
);

// ADD CSS / JS of blocks correctly to the head / body end
add_action( 'wp_enqueue_scripts', function() {
    global $blocks;
    foreach ( $blocks as $block ) {
        if ( has_block( 'acf/' . $block['name'] ) ) {
            $block['enqueue_assets']();
        }
    }
}, PHP_INT_MAX );


/**
 * Setup Guttenberg allowed blocks.
 * @param array $allowed_blocks Currently allowed blocks.
 * @return array Allowed blocks.
 */
function setup_gutenberg_allowed_blocks( $allowed_block_types, $block_editor_context ) {

    global $blocks;
    global $uniblocks;

    $allowed = array();

    // Theme blocks
    foreach ( $blocks as $block ) {
        if ( strlen( $block['name'] ) > 0) {
            array_push( $allowed, 'acf/' . $block['name'] );
        }
    }

    // Uniblocks
    if ( !empty($uniblocks) && is_array($uniblocks) ) {
        foreach ( $uniblocks as $block ) {
            if ( strlen( $block['name'] ) > 0) {
                array_push( $allowed, 'acf/' . $block['name'] );
            }
        }
    }

    // Core WP blocks
    // https://developer.wordpress.org/block-editor/reference-guides/core-blocks/
    $core_blocks = array(
        // 'core/archives',
        // 'core/audio',
        // 'core/avatar',
        // 'core/block',
        'core/button',
        'core/buttons',
        // 'core/calendar',
        // 'core/categories',
        'core/code',
        'core/column',
        'core/columns',
        // 'core/comment-author-avatar',
        // 'core/comment-author-name',
        // 'core/comment-content',
        // 'core/comment-date',
        // 'core/comment-edit-link',
        // 'core/comment-reply-link',
        // 'core/comment-template',
        // 'core/comments',
        // 'core/comments-pagination',
        // 'core/comments-pagination-next',
        // 'core/comments-pagination-numbers',
        // 'core/comments-pagination-previous',
        // 'core/comments-title',
        // 'core/cover',
        // 'core/embed',
        'core/file',
        'core/freeform',
        'core/gallery',
        // 'core/group',
        'core/heading',
        // 'core/home-link',
        // 'core/html',
        'core/image',
        // 'core/latest-comments',
        // 'core/latest-posts',
        'core/list',
        'core/list-item',
        // 'core/loginout',
        // 'core/media-text',
        // 'core/missing',
        // 'core/more',
        // 'core/navigation',
        // 'core/navigation-link',
        // 'core/navigation-submenu',
        // 'core/nextpage',
        // 'core/page-list',
        // 'core/page-list-item',
        'core/paragraph',
        // 'core/pattern',
        // 'core/post-author',
        // 'core/post-author-biography',
        // 'core/post-author-name',
        // 'core/post-comments-count',
        // 'core/post-comments-form',
        // 'core/post-comments-link',
        // 'core/post-content',
        // 'core/post-date',
        // 'core/post-excerpt',
        // 'core/post-featured-image',
        // 'core/post-navigation-link',
        // 'core/post-template',
        // 'core/post-terms',
        // 'core/post-title',
        // 'core/preformatted',
        'core/pullquote',
        // 'core/query',
        // 'core/query-no-results',
        // 'core/query-pagination',
        // 'core/query-pagination-next',
        // 'core/query-pagination-numbers',
        // 'core/query-pagination-previous',
        // 'core/query-title',
        'core/quote',
        // 'core/read-more',
        // 'core/rss',
        // 'core/search',
        'core/separator',
        'core/shortcode',
        // 'core/site-logo',
        // 'core/site-tagline',
        // 'core/site-title',
        // 'core/social-link',
        // 'core/social-links',
        // 'core/spacer',
        'core/table',
        'core/table-of-contents',
        // 'core/tag-cloud',
        'core/template-part',
        // 'core/term-description',
        'core/text-columns',
        // 'core/verse',
        'core/video',
    );

    $allowed = array_merge( $allowed, $core_blocks );

    return $allowed;
}
add_filter( 'allowed_block_types', 'setup_gutenberg_allowed_blocks', 10, 2 );

/**
 * Adjust header on admin pages, where ACF is used.
 */
function theme_acf_admin_head() {
    
}
add_action( 'acf/input/admin_head', 'theme_acf_admin_head' );

/**
 * Add Guttenberg blocks categories.
 * @param array $categories Current categories.
 * @param WP_Post $post Current post.
 * @return array Adjusted categories.
 */
function theme_acf_blocks_categories( $categories, $post ) {
    /*if ( $post->post_type !== 'post' ) {
        return $categories;
    }*/
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'theme-blocks',
                'title' => get_bloginfo( 'name' ),
                //'icon'  => 'wordpress',
            ),
        )
    );
}
add_filter('block_categories', 'theme_acf_blocks_categories', 10, 2);

/**
 * Register ACF blocks.
 */
function theme_acf_blocks_init() {
	if ( function_exists('acf_register_block') ) {
		
		// register blocks
        // DOC: https://www.advancedcustomfields.com/resources/acf_register_block/
        // ICONS: https://www.kevinleary.net/wordpress-dashicons-list-custom-post-type-icons/
        global $blocks;
        if ( count( $blocks ) > 0 ) {
            foreach ( $blocks as $block )
            {
                if ( strlen( $block['name'] ) > 0 ) {
                    $block_settings = array(
                        'name'            => $block['name'],
                        'title'           => __( $block['title'], THEME_ADMIN_TEXT_DOMAIN ),
                        'description'     => __( $block['description'], THEME_ADMIN_TEXT_DOMAIN ),
                        'render_callback' => 'theme_acf_block_render_callback',
                        'enqueue_assets'  => $block['enqueue_assets'],
                        'category'        => 'theme-blocks',
                        'icon'            => (!empty($block['icon'])) ? $block['icon'] : 'welcome-add-page',
                        'keywords'        => array(),
                        //'post_types'      => array('post', 'page'),
                        'mode'            => 'preview', //'edit',
                        'align'           => 'wide',
                        'supports'        => array(
                            'align'    => false,
                            'mode'     => true,
                            'multiple' => true,
                            'anchor' => true,
                        ),
                        'example'         => array(
                            'attributes' => array(
                                'mode' => 'preview',
                                'data' => array(
                                    'is_preview' => true
                                )
                            ),
                            'viewportWidth' => 1300
                        )
                    );

                    // Is block enabled only for specified post types?
                    if ( !empty($block['post_types']) ) {
                        $block_settings['post_types'] = $block['post_types'];
                    }

                    acf_register_block( $block_settings );
                }
            }
        }

	}
}
add_action( 'acf/init', 'theme_acf_blocks_init' );

/**
 * Render ACF blocks
 * @param mixed $block Block array.
 * @param mixed $content Content of the block.
 * @param bool $is_preview Is in preview mode?
 * @param int $post_id Id of the post.
 */
function theme_acf_block_render_callback( $block, $content = '', $is_preview = false, $post_id = 0 ) {
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);
	
	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path( "/template-parts/acf-blocks/{$slug}.php" ) ) ) {
		include( get_theme_file_path( "/template-parts/acf-blocks/{$slug}.php" ) );
	}
}

/**
 * Add JS and CSS used for ACF GT blocks in admin.
 */
function enqueue_admin_acf_blocks_scripts_and_styles() {
    wp_enqueue_script( 'jquery-ui-core' ); // enqueue jQuery UI Core
    wp_enqueue_script( 'jquery-ui-tabs' ); // enqueue jQuery UI Tabs
}
add_action( 'admin_enqueue_scripts', 'enqueue_admin_acf_blocks_scripts_and_styles' );

?>