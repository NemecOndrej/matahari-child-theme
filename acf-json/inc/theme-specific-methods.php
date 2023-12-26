<?php /*ěščřžýáíéúů*/

/**
 * Methods specific for the theme.
 */
trait Theme_Specific_Methods
{
    /**
     * Breadcrumb path HTML generator.
     */
    public static function breadcrumbs() {
        global $post;

        // html breadcrumbs variables
        $html = '';
        $before = '<li>';
        $after = '</li>';

        // root element
        $home_url = apply_filters( 'wpml_home_url', get_option( 'home' ) );
        $html .= $before . '<a href="' . $home_url . '">' . __( 'Domů', THEME_TEXT_DOMAIN ) . '</a>' . $after;

        $queried_object = get_queried_object();

        if ( is_category() ) {

            // POST CATEGORY

            // custom posts root page
            //$articles_page_id = Theme_General_Methods::get_page_id_by_template('_articles.php');
            //$html .= $before . '<a href="' . get_permalink($articles_page_id) . '">' . get_the_title($articles_page_id) . '</a>' . $after;

            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $current_category = $cat_obj->term_id;
            $current_category = get_category( $current_category );
            if ( $current_category->parent != 0 ) {
                $html .= $before . get_category_parents( $current_category->parent, true, $after . $before ) . $after;
            }
            $html .= $before . single_cat_title('', false) . $after;

        } elseif ( is_day() ) {

            // ARCHIVE - DAY

            // custom posts root page
            //$articles_page_id = Theme_General_Methods::get_page_id_by_template('_articles.php');
            //$html .= $before . '<a href="' . get_permalink($articles_page_id) . '">' . get_the_title($articles_page_id) . '</a>' . $after;

            $html .= $before . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $after;
            $html .= $before . '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a>' . $after;
            $html .= $before . get_the_time('d') . $after;

        } elseif ( is_month() ) {

            // ARCHIVE - MONTH

            // custom posts root page
            //$articles_page_id = Theme_General_Methods::get_page_id_by_template('_articles.php');
            //$html .= $before . '<a href="' . get_permalink($articles_page_id) . '">' . get_the_title($articles_page_id) . '</a>' . $after;

            $html .= $before . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $after;
            $html .= $before . get_the_time('F') . $after;

        } elseif ( is_year() ) {

            // ARCHIVE - YEAR

            // custom posts root page
            //$articles_page_id = Theme_General_Methods::get_page_id_by_template('_articles.php');
            //$html .= $before . '<a href="' . get_permalink($articles_page_id) . '">' . get_the_title($articles_page_id) . '</a>' . $after;

            $html .= $before . get_the_time('Y') . $after;

        } elseif ( is_single() && !is_attachment() ) {
                
            // SINGLE (post and custom post types)

            if (get_post_type() == 'custom_post_type') {

                // SINGLE - [CUSTOM POST TYPE NAME]
                
                // custom root page
                //$articles_page_id = Theme_General_Methods::get_page_id_by_template('_articles.php');
                //$html .= $before . '<a href="' . get_permalink($articles_page_id) . '">' . get_the_title($articles_page_id) . '</a>' . $after;

                // empty root page
                //$html .= $before . 'Name' . $after;

                $html .= $before . get_the_title($post->ID) . $after;
            } elseif (get_post_type() == 'post') {

                // SINGLE - POST
                
                // custom posts root page
                //$articles_page_id = Theme_General_Methods::get_page_id_by_template('_articles.php');
                //$html .= $before . '<a href="' . get_permalink($articles_page_id) . '">' . get_the_title($articles_page_id) . '</a>' . $after;

                $html .= $before . get_the_title() . $after;
            }
            else
            {
                // CUSTOM POST TYPE - general solution

                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                $html .= $before . '<a href="' . $home_url . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>' . $after;
                $html .= $before . get_the_title() . $after;
            }

        } elseif (!is_single() && !is_page() && isset($queried_object) && isset($queried_object->taxonomy) && $queried_object->taxonomy == 'custom_taxonomy') {
            
            // [CUSTOM TAXONOMY]
                
            // root page
            $parent_page_id = Theme_General_Methods::get_page_id_by_template('_galleries.php');
            $html .= $before . '<a href="' . get_permalink($parent_page_id) . '">' . get_the_title($parent_page_id) . '</a>' . $after;

            // get current item
            $termId = $queried_object->term_id;
            $term = get_term($termId, 'galleries_tags');

            $html .= $before . __( 'Galerie se štítkem', THEME_TEXT_DOMAIN ) . ' "' . $term->name . '"' . $after;

        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {

            $post_type = get_post_type_object( get_post_type() );
            $html .= $before . $post_type->labels->singular_name . $after;

        } elseif ( is_attachment() ) {

            // ATTACHMENT PAGE (commonly this is redirected to the file by YoastSEO)

            $html .= $before . get_the_title() . $after;

        } elseif ( is_page() && !$post->post_parent ) {

            // PAGE - without parent

            $html .= $before . get_the_title() . $after;

        } elseif ( is_page() && $post->post_parent ) {

            // PAGE - with parent structure

            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ( isset( $parent_id ) && $parent_id > 0 ) {
                $page = get_post( $parent_id );
                $breadcrumbs[] = $before . '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>' . $after;
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) $html .= $crumb;
            $html .= $before . get_the_title() . $after;

        } elseif ( is_search() ) {

            // SEARCH RESULTS

            $html .= $before . __( 'Výsledky vyhledávání výrazu', THEME_TEXT_DOMAIN ) . ' "' . get_search_query() . '"' . $after;

        } elseif ( is_tag() ) {

            // POST TAG
            
            // custom posts root page
            //$articles_page_id = Theme_General_Methods::get_page_id_by_template('_articles.php');
            //$html .= $before . '<a href="' . get_permalink($articles_page_id) . '">' . get_the_title($articles_page_id) . '</a>' . $after;

            $html .= $before . __( 'Články se štítkem', THEME_TEXT_DOMAIN ) . ' "' . single_tag_title('', false) . '"' . $after;

        } elseif ( is_author() ) {

            // AUTHOR PAGE (user page)

            global $author;
            $userdata = get_userdata($author);
            $html .= $before . __( 'Články autora ', THEME_TEXT_DOMAIN ) . $userdata->display_name . $after;

        } elseif ( is_404() ) {

            // 404

            $html .= $before . __( 'Stránka nenalezena', THEME_TEXT_DOMAIN ) . $after;

        }

        if ( get_query_var('paged') && !is_404() ) {

            // PAGINATION

            $html .= $before . __( 'Strana', THEME_TEXT_DOMAIN ) . ' ' . get_query_var('paged') . $after;
        }

        echo '<ul id="breadcrumbs">' . $html . '</ul>';
    }
}

?>