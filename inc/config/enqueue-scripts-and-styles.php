<?php /*ěščřžýáíéúů*/

/**
 * Manage all scripts and styles contained in the theme.
 */
function theme_manage_scripts_and_styles() {

	$post_types = get_post_types( array(), 'names' );
	$taxonomies = get_taxonomies( array(), 'names' );

	// REMOVE STANDARD WP ASSETS -----------------------------------------------------------------------------------------------------

	if ( !is_admin() ) {
		// deregister standard blocks - all are customized
		wp_dequeue_style( 'wp-block-library' );
		wp_deregister_style( 'wp-block-library' );

		// deregister standard jQuery
		wp_dequeue_script( 'jquery' );
		wp_deregister_script('jquery');

		// deregister standard jQuery
		wp_dequeue_script( 'wp-embed' );
		wp_deregister_script( 'wp-embed' );
	}

	// REGISTER SCRIPTS & ENQUEUE GLOBAL SCRIPTS -------------------------------------------------------------------------------------

	$js_assets_dir = '/assets/js/';

	// jquery
	wp_register_script( 'jquery', Theme::get_asset_src( $js_assets_dir . 'library/jquery-3.5.1.min.js' ), array(), null, array('strategy'=>'defer','in_footer'=>true) );
	wp_register_script( 'theme-jquery-migrate', Theme::get_asset_src( $js_assets_dir . 'library/jquery-migrate-1.2.1.min.js' ), array(), null, array('strategy'=>'defer','in_footer'=>true) );
	wp_register_script( 'theme-jquery-ui', Theme::get_asset_src( $js_assets_dir . 'library/jquery-ui-1.12.1.min.js' ), array(), null, array('strategy'=>'defer','in_footer'=>true) );

	// plugins
	wp_register_script( 'theme-icheck', Theme::get_asset_src( $js_assets_dir . 'library/icheck.min.js' ), array(), null, array('strategy'=>'defer','in_footer'=>true) );
	wp_register_script( 'theme-fancybox', Theme::get_asset_src( $js_assets_dir . 'library/fancybox/jquery.fancybox.min.js' ), array(), null, array('strategy'=>'defer','in_footer'=>true) );
	wp_register_script( 'theme-slick', Theme::get_asset_src( $js_assets_dir . 'library/slick/slick.min.js' ), array(), null, array('strategy'=>'defer','in_footer'=>true) );
	// wp_register_script( 'theme-swiper', Theme::get_asset_src( $js_assets_dir . 'library/swiperjs/swiper-bundle.min.js' ), array(), null, array('strategy'=>'defer','in_footer'=>true) );
	wp_register_script( 'theme-jquery-modal', Theme::get_asset_src( $js_assets_dir . 'library/modal/jquery.modal.min.js' ), array(), null, array('strategy'=>'defer','in_footer'=>true) );
	wp_register_script( 'theme-jquery-form', Theme::get_asset_src( $js_assets_dir . 'library/jquery.form.min.js' ), array(), null, array('strategy'=>'defer','in_footer'=>true) );

	// theme main scripts
	wp_register_script( 'theme-app', Theme::get_asset_src( $js_assets_dir . 'app.js' ), array(), null, array('strategy'=>'defer','in_footer'=>true) );

	// localize script
	// @source https://developer.wordpress.org/reference/functions/wp_localize_script/
	// wp_localize_script( '__script_handle__', '__object_name__', array(
	//     '__variable_name__' => '__value__',
	//     'warningText'   => __('Opravte chyby ve formuláři',THEME_TEXT_DOMAIN),
	//     'servicesUrl'	=> THEME_URI . '/services/',
	//     'ajaxUrl'		=> home_url() . '/wp-admin/admin-ajax.php',
	//     'currentLang'	=> apply_filters('wpml_current_language', NULL),
	// ));
	// Example of using in js file:
	// __object_name__.__variable_name__;

	// pages scripts
	$pages_js_dir = THEME_ROOT_DIR . '/assets/js/pages/';
	if ( file_exists( $pages_js_dir ) ) {
		$pages_js = scandir( $pages_js_dir );
		foreach ( $pages_js as $page_js ) {
			if (
				$page_js != '.' && $page_js != '..' && strpos( $page_js, '_' ) !== 0 &&
				strtolower( pathinfo( $page_js, PATHINFO_EXTENSION ) ) == 'js'
			) {
				$page_js = str_replace( '.js', '', $page_js );
				wp_register_script( 'theme-page-' . $page_js, Theme::get_asset_src( $js_assets_dir . 'pages/' . $page_js . '.js' ), array(), null, array('strategy'=>'defer','in_footer'=>true) );
			}
		}
	}

	if ( !is_admin() ) {
		// FRONT-END SCRIPTS

		// enqueue global scripts
		// note: only global items here, other on local page templates
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'theme-jquery-migrate' );
		wp_enqueue_script( 'theme-jquery-ui' );
		wp_enqueue_script( 'theme-icheck' );
		wp_enqueue_script( 'theme-fancybox' );
		wp_enqueue_script( 'theme-slick' );
		// wp_enqueue_script( 'theme-swiper' );
		wp_enqueue_script( 'theme-jquery-form' );
		wp_enqueue_script( 'theme-app' );

		// conditional enqueue by page template
		if ( is_page() ) {
			$slug = get_page_template_slug();
			$slug = str_replace( 'page-templates/', '', $slug );
			$slug = str_replace( '.php', '', $slug );

			if ( strlen( $slug ) > 0 && file_exists( THEME_ROOT_DIR . '/assets/js/pages/' . $slug . '.js' ) ) {
				// conditionail dependencies by slug
				switch ( $slug ) {
					case 'homepage':
						wp_enqueue_script( 'theme-slick' );
						break;
				}

				wp_enqueue_script( 'theme-page-' . $slug );
			}
		}

		// conditional enqueue by post type / taxonomy
		global $wp_scripts;
		if ( is_a( $wp_scripts, 'WP_Scripts' ) && isset( $wp_scripts->registered ) && count( $wp_scripts->registered ) > 0 ) {

			// post type
			foreach ( $post_types as $post_type ) {
				if ( is_singular( $post_type ) ) {
					foreach ( $wp_scripts->registered as $script_registered_name => $script_config ) {
						if ( $script_registered_name == 'theme-page-single-' . $post_type ) {
							// conditionail dependencies by post type
							// switch ( $post_type ) {
							// 	case 'houses':
							// 		wp_enqueue_script( 'theme-image-map-resizer' );
							// 		break;
							// }

							wp_enqueue_script( 'theme-page-single-' . $post_type );
						}
					}
				}
			}

			// taxonomy
			foreach ( $taxonomies as $taxonomy ) {
				if ( is_tax($taxonomy) ) {
					foreach ( $wp_scripts->registered as $script_registered_name => $script_config ) {
						if ( $script_registered_name == 'theme-page-tax-' . $taxonomy ) {
							// conditionail dependencies by post type
							// switch ( $post_type ) {
							// 	case 'houses':
							// 		wp_enqueue_script( 'theme-something' );
							// 		break;
							// }

							wp_enqueue_style( 'theme-page-tax-' . $taxonomy );
						}
					}
				}
			}
		}
	} else {
		// ADMIN SCRIPTS
	}

	// REGISTER STYLES & ENQUEUE GLOBAL STYLES ---------------------------------------------------------------------------------------

	$css_assets_dir = '/assets/css/';

	// global theme css
	wp_register_style( 'theme-main', Theme::get_asset_src( $css_assets_dir . 'style.css' ), array(), null, 'all' );
	wp_register_style( 'theme-fancybox', Theme::get_asset_src( $js_assets_dir . 'library/fancybox/fancybox.min.css' ), array(), null, 'all' );
	wp_register_style( 'theme-jquery-modal', Theme::get_asset_src( $js_assets_dir . 'library/modal/jquery.modal.min.css' ), array(), null, 'all' );
	// wp_register_style( 'theme-swiper', Theme::get_asset_src( $js_assets_dir . 'library/swiperjs/swiper-bundle.min.css' ), array(), null, 'all' );
	// search theme css
	// wp_register_style( 'theme-search', Theme::get_asset_src( $css_assets_dir . 'pages/search.css' ), array(), null, 'all' );

	// pages css
	$pages_css_dir = THEME_ROOT_DIR . '/assets/css/pages/';
	if ( file_exists( $pages_css_dir ) ) {
		$pages_css = scandir( $pages_css_dir );
		foreach ( $pages_css as $page_css ) {
			if (
				$page_css != '.' && $page_css != '..' && strpos( $page_css, '_' ) !== 0 &&
				strtolower( pathinfo( $page_css, PATHINFO_EXTENSION ) ) == 'css' &&
				strpos( $page_css, '.css' ) > 0
			) {
				$page_css = str_replace( '.css', '', $page_css );
				wp_register_style( 'theme-page-' . $page_css, Theme::get_asset_src( $css_assets_dir . 'pages/' . $page_css . '.css' ), array(), null, 'all' );
			}
		}
	}

	if ( !is_admin() ) {
		// FRONT-END STYLES

		// enqueue global styles
		wp_enqueue_style( 'theme-main' );
		wp_enqueue_style( 'theme-fancybox' );
		// wp_enqueue_style( 'theme-swiper' );

		// conditional enqueue by page template
		if ( is_page() ) {
			$slug = get_page_template_slug();
			$slug = str_replace( 'page-templates/', '', $slug );
			$slug = str_replace( '.php', '', $slug );

			if ( strlen( $slug ) > 0 && file_exists( THEME_ROOT_DIR . '/assets/css/pages/' . $slug . '.css' ) ) {
				wp_enqueue_style( 'theme-page-' . $slug );
			}
		}

		// conditional enqueue by post type / taxonomy
		global $wp_styles;
		if ( is_a( $wp_styles, 'WP_Styles' ) && isset( $wp_styles->registered ) && count( $wp_styles->registered ) > 0 ) {

			// post type
			foreach ( $post_types as $post_type ) {
				if ( is_singular( $post_type ) ) {
					foreach ( $wp_styles->registered as $style_registered_name => $style_config ) {
						if ( $style_registered_name == 'theme-page-single-' . $post_type ) {
							wp_enqueue_style( 'theme-page-single-' . $post_type );
						}
					}
				}
			}

			// taxonomy
			foreach ( $taxonomies as $taxonomy ) {
				if ( is_tax($taxonomy) ) {
					foreach ( $wp_styles->registered as $style_registered_name => $script_config ) {
						if ( $style_registered_name == 'theme-page-tax-' . $taxonomy ) {
							wp_enqueue_style( 'theme-page-tax-' . $taxonomy );
						}
					}
				}
			}
		}

		// Search
		if ( is_search() ) {
			// wp_enqueue_style( 'theme-search' );
		}

	} else {
		// ADMIN STYLES
		wp_enqueue_style( 'theme-admin' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_manage_scripts_and_styles', 20 );
add_action( 'admin_enqueue_scripts', 'theme_manage_scripts_and_styles', 20 );

/**
 * AddtoAny plugin related restriction.
 * Load sources only on specific pages.
 * 
 * @since 12/2023
 *
 * @return Void
 */
function theme_manage_addtoany_scripts_and_styles() {

	// add to any script load condition
	// - edit array of post types
	if ( ! is_singular( array('post') ) ) {
		add_filter( 'addtoany_script_disabled', '__return_true' );
	}
}
// add_action( 'wp_enqueue_scripts', 'theme_manage_addtoany_scripts_and_styles', 9 );

/**
 * HTTP2 push for Autoptimize cached files.
 * @param string $fileUrl URL of cached file.
 * @return string Final URL.
 */
function autoptimize_http2push( $fileUrl ) {
	// get file type
	$fileType = substr( $fileUrl, strrpos( $fileUrl, '.' ) + 1 ) === 'js' ? 'script' : 'style';

	// don't push inline CSS
	if ( $fileType == 'style' && ( (bool) get_option( 'autoptimize_css_inline', true ) ) ) return $fileUrl;

	// push
	header( 'Link: <' . $fileUrl . '>; rel=preload; as=' . $fileType, false );

	return $fileUrl;
}
add_filter( 'autoptimize_filter_cache_getname', 'autoptimize_http2push', 1 );



?>