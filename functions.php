<?php /*ěščřžýáíéúů*/

#region WP-CONFIG.PHP DEFINITIONS TEMPLATE =============================================================

// DOCS: https://wordpress.org/support/article/editing-wp-config-php/

/*
// Debugging mode
if ( WP_DEBUG ) {
	define( 'WP_DEBUG_DISPLAY', true );
	define( 'WP_DEBUG_LOG', false );
	define( 'WP_DISABLE_FATAL_ERROR_HANDLER', true );
	//define( 'CONCATENATE_SCRIPTS', false ); // disable admin scripts contecation
}

// Custom SMTP configuration (define in wp-config.php or set before wp_mail method for dynamic SMTP)
// (This is custom functionality in Theme_Base connected to phpmailer_init wp hook).
define( 'SMTP_HOST',     'smtp.example.com' );    // The hostname of the SMTP server
define( 'SMTP_AUTH',     true );                  // Use SMTP authentication (true|false)
// optional settings
define( 'SMTP_USER',     'user@example.com' );    // Username for SMTP authentication
define( 'SMTP_PASS',     'smtp password' );       // Password for SMTP authentication
define( 'SMTP_PORT',     465 );                   // SMTP port number - 25 (not secured), 465 (ssl) or 587 (tls)
define( 'SMTP_SECURE',   'ssl' );                 // Encryption system to use - ssl or tls
define( 'SMTP_FROM',     'website@example.com' ); // From email address
define( 'SMTP_FROMNAME', 'e.g. Website Name' );   // From name
define( 'SMTP_REPLYTO',  'replyto@domain.com' );  // Reply to email address

// Force SSL for admin
define( 'FORCE_SSL_ADMIN', true );

// Disable automatic updates
define( 'AUTOMATIC_UPDATER_DISABLED', true );
define( 'WP_AUTO_UPDATE_CORE', false );

// Custom CRON implementation (use only if possible, then run server CRON for http://www.yoursite.com/wp-cron.php?doing_wp_cron=1)
define( 'DISABLE_WP_CRON', true );

// WP CRON timeout
define( 'WP_CRON_LOCK_TIMEOUT', 60 );

// Alter autosave interval (default is 60 seconds)
define( 'AUTOSAVE_INTERVAL', 120 );

// Limit post revisions
define( 'WP_POST_REVISIONS', 4 );

// Disable post revisions
define( 'WP_POST_REVISIONS', false );

// Setup memory limits
define( 'WP_MEMORY_LIMIT', '96M' );
define( 'WP_MAX_MEMORY_LIMIT', '256M' ); // for admin

// Define COOKIES domain
define( 'COOKIE_DOMAIN', 'www.example.com' );

// Force site URL
define( 'WP_SITEURL', 'https://example.com' ); // fixed
define( 'WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST'] ); // dynamically forced by current host

// Force home URL
define( 'WP_HOME', 'http://example.com' ); // fixed
define( 'WP_HOME', 'https://' . $_SERVER['HTTP_HOST'] ); // dynamically forced by current host

// Enable multisite
define( 'WP_ALLOW_MULTISITE', true );

// Redirect nonexisting blogs (for multisite)
define( 'NOBLOGREDIRECT', 'http://example.com' );

// Enable direct updates
define( 'FS_METHOD', 'direct' );

// SQL queries optimalization
define( 'SAVEQUERIES', true );
// Code for footer.php in theme
if ( current_user_can( 'administrator' ) ) {
	global $wpdb;
	echo "<pre>";
	print_r( $wpdb->queries );
	echo "</pre>";
}
*/

#endregion

#region THEME CONSTANTS ================================================================================

// CONFIGURATION CONSTS - dynamic (by each theme)
const THEME_TEXT_DOMAIN = 'theme-text-domain'; // language text domain - bulk replace constant by string in the whole code if needed (for WPML for example)
const THEME_ADMIN_TEXT_DOMAIN = 'theme-admin-text-domain'; // language text domain for admin strings - bulk replace constant by string in the whole code if needed (for WPML for example)

// CONFIGURATION CONSTS - static
define('THEME_ROOT_DIR', dirname(__FILE__));
define('THEME_URI', is_child_theme() ? get_stylesheet_directory_uri() : get_template_directory_uri());
define('THEME_PATH', is_child_theme() ? get_stylesheet_directory() : get_template_directory());
define('WP_ROOT_DIR', realpath(dirname(__FILE__) . '/../../../'));
// define( 'WPML_LANG', apply_filters( 'wpml_current_language', null ) );

#endregion

#region AUTOLOAD =======================================================================================

// AUTOLOAD - main codes
// Note: Files beginning with '_' are ignored.
$autoload_dirs = array(
	// WP configuration
	'/inc/config/',

	// custom taxonomies
	'/inc/custom-taxonomies/',

	// custom post types
	'/inc/custom-post-types/',

	// theme base codes
	'/inc/',

	// shortcodes
	'/template-parts/shortcodes/',

	// forms database processing
	'/inc/forms/',
);
foreach ($autoload_dirs as $autoload_dir) {
	$dir = THEME_ROOT_DIR . $autoload_dir;
	if (file_exists($dir)) {
		$files = scandir($dir);
		foreach ($files as $file) {
			if (is_file($dir . '/' . $file) && is_numeric(strpos($file, '.php')) && strpos($file, '_') !== 0) {
				require_once($dir . '/' . $file);
			}
		}
	}
}

// AUTOLOAD - modules
// Note: Directories beginning with '_' are ignored.
$modules_dir = THEME_ROOT_DIR . '/modules/';
if (file_exists($modules_dir)) {
	$modules = scandir($modules_dir);
	foreach ($modules as $module) {
		if (
			$module != '.' && $module != '..' && strpos($module, '_') !== 0 &&
			is_dir($modules_dir . $module) &&
			is_file($modules_dir . $module . '/' . $module . '.php')
		) {
			require_once($modules_dir . $module . '/' . $module . '.php');
		}
	}
}

#endregion

#region MAIN THEME CLASS AND CONFIG ====================================================================

/**
 * Theme main class.
 */
class Theme extends Theme_Base {
	// traits with static methods
	use Theme_General_Methods, Theme_Specific_Methods;

	function __construct() {
		// general config
		$this->wp_config = array(
			'disallow_file_edit' => true,  // disallow editation of WP themes and plugins code in WP admin
			'disable_emojis'     => true,  // disable WP emojis
			'disable_comments'   => true,  // disable WP comments
			'email_antispambot'  => true,  // automatic antispambot for email links
			'phone_antispambot'  => true,  // automatic antispambot for phone links
			'frontend_admin_bar' => true,  // frontend admin bar for logged users
			'feed_links_meta'    => true,  // automatic RSS feed links meta in the front-ends head
			'xml_rpc'            => false, // allow XML RPC
			'disable_search'     => false, // disable search functionality (if website does not contain it)
			'tinymce_css'        => Theme::get_asset_src('/assets/css/tinymce_styles.css'), // set custom CSS file for admin TinyMCE
			'post_thumbnails'    => array('post', 'page'), // enable post thumbnails: true - enable everywhere, array - specific post types
			'enable_mini_admin_bar' => false, // disable frontend admin bar
		);

		// navigation menus to register
		$this->nav_menus = array(
			'menu-primary' => __('Hlavní menu', THEME_ADMIN_TEXT_DOMAIN),
			'menu-footer' => __('Menu v patičce', THEME_ADMIN_TEXT_DOMAIN),
		);

		// add image sizes (calls add_image_size in WP init hook)
		//$this->add_image_size( 'sizename', 700, 0 );
		//$this->add_image_size( 'sizename', 0, 500 );
		//$this->add_image_size( 'sizename', 700, 500, array('center', 'center') );

		// disable gutenberg by needs
		$this->gutenberg_disable = array(
			'post_templates' => array(
				// post template file names e.g. 'homepage.php'
			),
			'post_types' => array(
				// post type names e.g. 'gallery' ; NOTE: better way to do this is by settting show_in_rest = false in register_post_type
			),
			'page_ids' => array(
				// post ID - global options, or acf option pages - pairing
				// get_option( 'page_on_front' ),
				// get_option( 'page_for_posts' ),
			)
		);

		// extend allowed MIME types (for upload in WP admin)
		$this->extended_upload_mime_types = array(
			'vcf' => 'text/x-vcard',
			'zip' => 'application/zip',
		);

		// preload headers
		//$this->add_file2preload( THEME_URI . '/assets/css/fonts/open-sans/open-sans-v18-latin-ext_latin-regular.woff2', 'font', '', true );

		// preconnect headers (DNS lookup, TCP handshake, TLS evaluation); not supported in IE - for IE use dns-prefetch instead
		//$this->add_uri2preconnect( 'https://fonts.gstatic.com' );

		// setup admin dashboard
		if (is_admin()) {
			add_action('wp_dashboard_setup', array(&$this, 'setup_admin_dashboard'), 500);

			wp_enqueue_style('fontawesome', get_template_directory_uri() . "/admin/assets/css/fontawesome.css");
			wp_enqueue_style('icons', get_template_directory_uri() . "/admin/assets/css/icons.css");
		}

		// call parent constructor
		parent::__construct();
	}

	/**
	 * Setup admin dashboard.
	 */
	public function setup_admin_dashboard() {
		global $wp_meta_boxes;

		// remove YoastSEO widget
		unset($wp_meta_boxes['dashboard']['normal']['core']['wpseo-dashboard-overview']);

		// remove standard meta boxes
		//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health']);
		//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
		unset($wp_meta_boxes['dashboard']['normal']['high']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['normal']['default']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['normal']['low']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

		// load custom WP dashboard metaboxes
		$dir = THEME_ROOT_DIR . '/inc/admin-dashboard-widgets/';
		$files = scandir($dir);
		foreach ($files as $file) {
			if (is_file($dir . '/' . $file) && is_numeric(strpos($file, ".php")) && strpos($file, "_") !== 0) {
				require_once $dir . $file;
			}
		}
	}
}

global $theme;
$theme = new Theme();

#endregion

/**
 * This function tells where Yoast SEO metabox should appear
 *
 * @return Void
 */
function yoast_seo_metabox_position() {
	return 'low';
}
add_filter('wpseo_metabox_prio', 'yoast_seo_metabox_position');

/**
 * Enable wpml capabilities to all administrator users.
 *
 * @return Void
 */
function wpml_reset_wpml_capabilities() {

	if (function_exists('icl_enable_capabilities')) {
		icl_enable_capabilities();
	}
}
// add_action( 'shutdown', 'wpml_reset_wpml_capabilities' );

function my_admin_menu() {
	add_menu_page(
		__('Uložené formuláře', THEME_ADMIN_TEXT_DOMAIN),
		__('Uložené formuláře', THEME_ADMIN_TEXT_DOMAIN),
		'manage_options',
		'saved-forms',
		'theme_saved_forms_page',
		'dashicons-schedule',
		45
	);
}

add_action('admin_menu', 'my_admin_menu');


function theme_saved_forms_page() {
	echo '<div class="wrap">';
	echo '<h1>Uložené formuláře</h1>';
	echo '<table class="wp-list-table widefat fixed striped table-view-list posts">';
	echo '<thead>';
	echo '<tr>';
	echo '<td>FORM ID</td>';
	echo '<td>Datum a Čas</td>';
	echo '<td>E-mail</td>';
	echo '</tr>';
	echo '</thead>';
	$entries = THEME::get_form_entries();
	if ($entries) {
		foreach ($entries as $entry) {
			echo '<tr>';
			echo '<td>' . $entry["form_id"] . '</td>';
			echo '<td>' . date("d. m. Y - H:i:s", strtotime($entry["date"])) . '</td>';
			echo '<td>' . $entry["email"] . '</td>';
			echo '</tr>';
		}
	}
	echo '</table>';
	//var_dump(THEME::save_form_entry_to_database("test", "leos.lang@unifer.cz", serialize(array("email" => "leos.lang@unifer.cz", "phone" => "123456789"))));
	echo '</div>';
}

/**
 * Update robots.txt content.
 */
function theme_robots_txt_update($output, $public) {

	// Add sitemap
	// @NOTE this is not needed, added by YOAST already
	// $site_url = parse_url( site_url() );
	// $output .= "Sitemap: {$site_url[ 'scheme' ]}://{$site_url[ 'host' ]}/sitemap_index.xml\n";

	// Disallow search results
	// $output .= "User-agent: *\n";
	// $output .= "Disallow: /?s=\n";

	return $output;
}
// add_filter( 'robots_txt', 'theme_robots_txt_update', 99, 2 );

function default_limit_upload_size($file) {

	$size = $file['size'];
	$size = $size / 1024;
	$type = $file['type'];
	$is_image = strpos($type, 'image') !== false;
	$limit = 5000;
	$limit_output = '5MB';

	if ($is_image && $size > $limit) {
		$file['error'] = 'Obrázek je příliš velký. Nahrajte prosím obrázek menší než ' . $limit_output . ". Pro zmenšení obrázku můžete například využít službu www.iloveimg.com/compress-image";
	}

	return $file;
}
add_filter('wp_handle_upload_prefilter', 'default_limit_upload_size');

/**
 * Red background setting menu if blog not public.
 *
 * @return Void
 */
function blog_public_warning() {
	if (get_option("blog_public") == 0) {
		echo '<style>
			#menu-settings,
			#menu-settings ul li:nth-child(4) {
				background: #c00 !important;
			}
		</style>';
	} else {

		if (strpos($_SERVER['SERVER_NAME'], "test") !== false) {
			add_action('admin_notices', 'unifer_robost_are_allowed_warning');
		}

		echo '<style>
			#menu-settings,
			#menu-settings ul li:nth-child(4) {
				background: #4caf50 !important;
			}
		</style>';
	}
}
add_action('admin_head', 'blog_public_warning');

/**
 * Add admin notice about robots (not) allowed.
 *
 * @return Void
 */
function unifer_robost_are_allowed_warning() {
	$class = 'notice notice-error';
	$message = __('Bacha!! Máš povolenou indexaci, je to určitě dobře?');

	printf('<div class="%1$s"><p><strong>%2$s</strong></p></div>', esc_attr($class), esc_html($message));
}

add_filter('acf/fields/wysiwyg/toolbars', 'my_toolbars');
function my_toolbars($toolbars) {
	// Uncomment to view format of $toolbars

	/* 	echo '< pre >';
		print_r($toolbars);
	echo '< /pre >';
	die;

 */
	$toolbars['zaklad'] = array();
	$toolbars['zaklad'][1] = array('bold', 'italic', 'underline', 'strikethrough', 'link');

	$toolbars['zaklad_bez_linku'] = array();
	$toolbars['zaklad_bez_linku'][1] = array('bold', 'italic', 'underline', 'strikethrough');

	$toolbars['mirne_pokrocily'] = array();
	$toolbars['mirne_pokrocily'][1] = array('bold', 'italic', 'underline', 'strikethrough', 'link', 'bullist', 'numlist',);

	$toolbars['pokrocily'] = array();
	$toolbars['pokrocily'][1] = array('formatselect', 'bold', 'italic', 'underline', 'strikethrough', 'link', 'bullist', 'numlist',);

	unset($toolbars['Full']);
	unset($toolbars['Basic']);

	// return $toolbars - IMPORTANT!
	return $toolbars;
}

function theme_print_wysiwyg($content, $leave_p = true, $type = "zaklad") {

	$allowed_tags = array(
		"zaklad" => array("<strong>", "<em>", "<span>", "<del>", "<a>"),
		"zaklad_bez_linku" => array("<strong>", "<em>", "<span>", "<del>"),
		"mirne_pokrocily" => array("<strong>", "<em>", "<span>", "<del>", "<a>", "<ul>", "<ol>", "<li>"),
		"pokrocily" => array("<strong>", "<em>", "<span>", "<del>", "<a>", "<ul>", "<ol>", "<li>", "<h1>", "<h2>", "<h3>", "<h4>", "<h5>", "<h6>"),
	);

	if ($leave_p) {
		foreach ($allowed_tags as $key => $value) {
			$allowed_tags[$key][] = "<p>";
		}
	}


	$content = strip_tags($content, $allowed_tags[$type]);
	echo $content;
}

/**
 * Automatic ACF image field type description with prefered image size.
 * Including possibility to skip this field description with key [skip-image-size-info] in that description.
 *
 * @param Array $field
 * @return Array
 */
function theme_add_image_size_info_to_instructions( $field ) {

	$skip_key = '[skip-image-size-info]';
	$preview_size = $field["preview_size"];

	if ( strpos($field["instructions"],$skip_key) === false ) {
		$field["instructions"] .= " ".THEME::get_image_size_info($preview_size);
	} else {
		$field["instructions"] = str_replace( $skip_key, '', $field["instructions"] );
	}

	return $field;
}
add_filter('acf/prepare_field/type=image', 'theme_add_image_size_info_to_instructions');

// Funkce pro deaktivaci oprvánění pro custom roli Web Manažer
if (is_plugin_active('klient-web-manager/role-web-manager.php')) {
	function custom_cap_for_web_manager() {
		return array(
			//'read' => false,
			//'edit_posts' => false,
			//'publish_posts' => false,
			//'delete_posts' => false,
			//'edit_pages' => false,
			//'publish_pages' => false,
			//'delete_pages' => false,
			//'edit_others_posts' => false,
			//'edit_others_pages' => false,
			//'delete_others_posts' => false,
			//'delete_others_pages' => false,
			//'edit_published_posts' => false,
			//'edit_published_pages' => false,
			//'delete_published_posts' => false,
			//'delete_published_pages' => false,
			//'edit_private_posts' => false,
			//'edit_private_pages' => false,
			//'delete_private_posts' => false,
			//'delete_private_pages' => false,
			//'edit_others_cpts' => false,
			//'edit_cpts' => false,
			//'publish_cpts' => false,
			//'delete_others_cpts' => false,
			//'delete_cpts' => false,
			//'edit_published_cpts' => false,
			//'delete_published_cpts' => false,
			//'edit_private_cpts' => false,
			//'delete_private_cpts' => false,
			//'edit_theme_options' => false,
			//'upload_files' => false,
			//'list_users' => false,
			//'create_users' => false,
			//'edit_users' => false,
			//'delete_users' => false,
			//'promote_users' => false,
			//'manage_options' => false,
			//'manage_categories' => false,
			//'read_private_posts' => false,
			//'read_private_pages' => false
		);
	}

	function custom_role_restriction() {
		global $custom_menu_restrictions;

		$custom_menu_restrictions = array(
			'hide' => array(
				'options-general.php' => array('options-writing.php', 'options-reading.php', 'options-general.php', 'options-media.php', 'options-permalink.php', 'bozimediazalomeni', 'duplicatepost', 'scporder-settings', 'webp_express_settings_page', 'option-folder', 'admin.php?page=menu_editor', 'options-privacy.php'),
				'edit.php' => array('edit-tags.php?taxonomy=category'),
				'themes.php' => array('themes.php', 'customize.php?return=%2Fwp-admin%2Foptions-general.php%3Fpage%3Dmenu_editor', 'customize.php?return=%2Fwp-admin%2F', 'customize.php?return=%2Fwp-admin%2Fnav-menus.php', 'customize.php?return=%2Fwp-admin%2Fadmin.php%3Fpage%3Dmenu_editor'),
				'tools.php' => array('export-personal-data.php', 'tools.php', 'erase-personal-data.php'),
				'admin.php' => array('admin.php?page=menu_editor')
			),
		);
	}

	add_action('init', 'custom_role_restriction');

	// přidává práva pro gravity form
	function change_permission_for_gravity_form() {
		global $permission_gravity_form;

		// Pro změnu práv pro gravity form změnit hodnotu v permission_gravity_form buďto na 'entries' nebo na 'full_access'
		$permission_gravity_form = 'entries';
	}

	add_action('init', 'change_permission_for_gravity_form');
}
