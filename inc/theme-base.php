<?php /*ěščřžýáíéúů*/

/**
 * Theme base class.
 */
class Theme_Base {

	#region PROPERTIES -------------------------------------------------------------------------------

	public static $instance_config;
	/**
	 * General configuration of WP functions.
	 * @var array
	 */
	public $wp_config = array(
		'disallow_file_edit' => true, // disallow editation of WP themes and plugins code in WP admin
		'disable_emojis'     => true, // disable WP emojis
		'disable_comments'   => true,  // disable WP comments
		'email_antispambot'  => true,  // automatic antispambot for email links
		'phone_antispambot'  => true,  // automatic antispambot for phone links
		'frontend_admin_bar' => true, // frontend admin bar for logged users
		'feed_links_meta'    => true, // automatic RSS feed links meta in the front-ends head
		'xml_rpc'            => false, // allow XML RPC
		'disable_search'     => false, // disable search functionality (if website does not contain it)
		'tinymce_css'        => '', // set custom CSS file for admin TinyMCE
		'post_thumbnails'    => array() // enable post thumbnail: true - enable everywhere, array - specific post types
	);

	/**
	 * Navigation menus (key = menu slug, value = menu name).
	 * @var array
	 */
	public $nav_menus = array();

	/**
	 * Disable Guttenberg editor for specific posts by their template.
	 * @var array
	 */
	public $gutenberg_disable = array( 'post_templates' => array(), 'post_types' => array() );

	/**
	 * Extends allowed mime types. ("file extension" => "mime type")
	 * @var array
	 */
	public $extended_upload_mime_types = array();

	/**
	 * Image sizes to add for the theme.
	 * @var array
	 */
	public $image_sizes = array();

	/**
	 * List of servers to preconnect.
	 * @var mixed
	 */
	public $preconnect = array();

	/**
	 * Files to preload.
	 * @var mixed
	 */
	public $preload = array();

	#endregion

	#region CONSTRUCTOR ------------------------------------------------------------------------------

	public function __construct() {
		// WP init
		add_action( 'init', array( &$this, 'wp_hook_init' ) );

		// WP admin init
		add_action( 'admin_init', array( &$this, 'wp_hook_admin_init' ) );

		// After theme setup
		add_action( 'after_setup_theme', array( &$this, 'wp_hook_after_theme_setup' ) );

		// Guttenberg hooks - disable it by needs
		add_filter( 'gutenberg_can_edit_post_type', array( &$this, 'disable_gutenberg_by_page_template' ), 10, 2 );
		add_filter( 'use_block_editor_for_post_type', array( &$this, 'disable_gutenberg_by_page_template' ), 10, 2 );

		// Upload mimes
		add_action( 'upload_mimes', array( &$this, 'wp_hook_upload_mimes' ) );

		// Script tags (add defer)
		// @disabled_since 09/2023, this is built-in functionality from WP > 6.3
		// add_filter( 'script_loader_tag', array( &$this, 'wp_hook_script_loader_tag' ), 10, 2 );

		// Enqueue scripts - add HTTP2 PUSH
		add_action( 'wp_enqueue_scripts', array( &$this, 'wp_hook_wp_enqueue_scripts' ), PHP_INT_MAX );

		// Backend JS and CSS
		add_action( 'admin_enqueue_scripts', array( &$this, 'wp_hook_admin_enqueue_scripts' ) );

		// Login JS and CSS
		add_action( 'login_enqueue_scripts', array( &$this, 'wp_hook_login_enqueue_scripts' ) );

		// Sanitize filenames
		add_filter( 'sanitize_file_name', array( &$this, 'wp_hook_sanitize_file_name' ), 10 );

		// Configure PHP Mailer
		add_action( 'phpmailer_init', array( &$this, 'wp_hook_phpmailer_init' ), PHP_INT_MAX - 1 );

		// Disable emojis
		if ( isset( $this->wp_config['disable_emojis'] ) && $this->wp_config['disable_emojis'] ) {
			$this->disable_emojis();
		}

		// Disable comments
		if ( isset( $this->wp_config['disable_comments'] ) && $this->wp_config['disable_comments'] ) {
			$this->disable_comments();
		}

		// E-mail antispambot
		if ( isset( $this->wp_config['email_antispambot'] ) && $this->wp_config['email_antispambot'] ) {
			$this->email_antispambot();
		}

		// Phone antispambot
		if ( isset( $this->wp_config['phone_antispambot'] ) && $this->wp_config['phone_antispambot'] ) {
			$this->phone_antispambot();
		}

		// Disable search
		if ( isset( $this->wp_config['disable_search'] ) && $this->wp_config['disable_search'] ) {
			if ( !is_admin() ) {
				add_action( 'parse_query', array( &$this, 'wp_hook_parse_query_disable_search' ) );
			}
		}

		// Enable mini admin bar on frontend
		if ( isset( $this->wp_config['enable_mini_admin_bar'] ) && $this->wp_config['enable_mini_admin_bar'] ) {
			if ( !is_admin() ) {
				add_action( 'admin_bar_menu', array( &$this, 'customize_admin_bar_nodes' ), 99999 );
				add_action( 'wp_before_admin_bar_render', array( &$this, 'customize_admin_bar_nodes_before_render' ), 99999 );
			}
		}

		self::$instance_config = $this->wp_config;
	}

	#endregion

	#region METHODS ----------------------------------------------------------------------------------
	
	/**
	 * Method for WP hook "init".
	 */
	public function wp_hook_init() {
		// WP config
		if ( isset( $this->wp_config ) && is_array( $this->wp_config ) && count( $this->wp_config ) > 0 ) {
			// enable post thumbnails
			if ( isset( $this->wp_config['post_thumbnails'] ) ) {
				if ( $this->wp_config['post_thumbnails'] === true ) {
					add_theme_support('post-thumbnails');
				}
				if ( is_array( $this->wp_config['post_thumbnails'] ) ) {
					add_theme_support( 'post-thumbnails', $this->wp_config['post_thumbnails'] );
				}
			}

			// frontend admin bar for logged users
			if ( isset( $this->wp_config['frontend_admin_bar'] ) && get_current_user_id() > 0 ) {
				add_filter( 'show_admin_bar', '__return_' . ( $this->wp_config['frontend_admin_bar'] ? 'true' : 'false' ) );
			}
			
			// automatic RSS feed links meta in the front-ends head
			if ( isset( $this->wp_config['feed_links_meta'] ) && $this->wp_config['feed_links_meta'] ) {
				add_theme_support( 'automatic-feed-links' );
			}
			
			// allow XML RPC
			if ( isset( $this->wp_config['xml_rpc'] ) ) {
				add_filter( 'xml_rpc_enabled', '__return_' . ( $this->wp_config['xml_rpc'] ? 'true' : 'false' ) );
			}
			
			// allow XML RPC
			if ( isset( $this->wp_config['xml_rpc'] ) ) {
				add_filter( 'xml_rpc_enabled', '__return_' . ( $this->wp_config['xml_rpc'] ? 'true' : 'false' ) );
			}

			// disallow editation of WP themes and plugins code in WP admin
			if ( isset( $this->wp_config['disallow_file_edit'] ) && is_bool( $this->wp_config['disallow_file_edit'] ) ) {
				define( 'DISALLOW_FILE_EDIT', $this->wp_config['disallow_file_edit'] );
			}
		}

		// add image sizes
		if ( isset( $this->image_sizes ) && is_array( $this->image_sizes ) && count( $this->image_sizes ) > 0 ) {
			foreach ( $this->image_sizes as $image_size ) {
				add_image_size( $image_size['name'], $image_size['width'], $image_size['height'], $image_size['crop'] );
			}
		}

		// flush rewrite rules
		$this->flush_rewrite_rules();
	}

	/**
	 * Method for WP hook "admin_init".
	 */
	public function wp_hook_admin_init() {
		// add TinyMCE custom CSS
		if ( isset( $this->wp_config['tinymce_css'] ) && is_string( $this->wp_config['tinymce_css'] ) &&
			strlen( $this->wp_config['tinymce_css'] ) > 0) {
			add_editor_style( $this->wp_config['tinymce_css'] );
		}
	}

	/**
	 * Method for WP hook "after_setup_theme".
	 */
	public function wp_hook_after_theme_setup() {
		// load text domain
		load_theme_textdomain( THEME_TEXT_DOMAIN, THEME_URI . '/languages' );

		// register navigation menus
		if ( isset( $this->nav_menus ) && is_array( $this->nav_menus ) && count( $this->nav_menus ) > 0 ) {
			register_nav_menus( $this->nav_menus );
		}
	}

	/**
	 * Method for WP hook "upload_mimes".
	 */
	public function wp_hook_upload_mimes( $existing_mimes ) {
		// extend allowed mime types
		if (
			isset( $this->extended_upload_mime_types ) && 
			is_array( $this->extended_upload_mime_types ) && 
			count( $this->extended_upload_mime_types ) > 0 &&
			isset( $existing_mimes ) && is_array( $existing_mimes )
		) {
			foreach ( $this->extended_upload_mime_types as $key => $value ) {
				$existing_mimes[$key] = $value;
			}
		}

		return $existing_mimes;
	}

	/**
	 * Method for WP hook "script_loader_tag".
	 * @disabled_since 09/2023, this is built-in functionality from WP > 6.3
	 */
	// public function wp_hook_script_loader_tag( $tag, $handle ) {
	// 	// add defer attribute
	// 	if ( !is_admin() ) {
	// 		$tag = str_replace( '<script ', '<script defer ', $tag );
	// 		$tag = str_replace( 'type=\'text/javascript\' ', '', $tag );
	// 	}

	// 	return $tag;
	// }
	
	/**
	 * Method for WP hook "wp_enqueue_scripts".
	 */
	public function wp_hook_wp_enqueue_scripts() {
		// Link: <https://fonts.example.com/font.woff2>; rel=preload; as=font; crossorigin; type='font/woff2'
		// Link: </css/styles.css>; rel=preload; as=style
		// Link: </css/styles.css>; rel=preload; as=style, </js/scripts.js>; rel=preload; as=script, </img/logo.png>; rel=preload; as=image
		// Link: </css/styles.css>; rel=preload; as=style, <https://fonts.gstatic.com>; rel=preconnect
		
		// list of items to push
		$http2push = array();

		// add items to preload
		if ( $this->preload ) {
			foreach ( $this->preload as $item ) {
				$link = '<' . $item['src'] . '>; rel=preload;';
				$link .= ' as=' . $item['as'] . ';';
				$link .= strlen( $item['media'] ) > 0 ? ' media=\'' . $item["media"] . '\';' : '';
				$link .= $item['crossorigin'] ? ' crossorigin;' : '';
				$link .= strlen( $item['type'] ) > 0 ? ' type=\'' . $item["type"] . '\'' : '';

				array_push( $http2push, $link );
			}
		}

		// add items to preconnect
		if ( $this->preconnect ) {
			foreach ( $this->preconnect as $item ) {
				$link = '<' . $item . '>; rel=preconnect';

				array_push( $http2push, $link );
			}
		}

		// add scripts
		global $wp_scripts;
		foreach ( $wp_scripts->queue as $script ) {
			$link = '<' . $wp_scripts->registered[$script]->src . '>; rel=preload; as=script';

			array_push( $http2push, $link );
		}

		// add styles
		global $wp_styles;
		foreach ( $wp_styles->queue as $style ) {
			$link = '<' . $wp_styles->registered[$style]->src . '>; rel=preload; as=style';

			array_push( $http2push, $link );
		}

		// add header
		if ( count( $http2push ) > 0) {
			header( 'Link: ' . implode( ', ', $http2push ), false );
		}
	}

	/**
	 * Method for WP hook "admin_enqueue_scripts".
	 */
	public function wp_hook_admin_enqueue_scripts() {
		// Register style
		wp_register_style( 'custom-wp-admin-css', get_stylesheet_directory_uri() . '/assets/css/admin_css.css?v=' . filemtime(get_stylesheet_directory() . '/assets/css/admin_css.css'), false);

		// Enqueue style
		wp_enqueue_style( 'custom-wp-admin-css' );
	}

	/**
	 * Method for WP hook "login_enqueue_scripts".
	 */
	public function wp_hook_login_enqueue_scripts() {
		// Register style
		wp_register_style( 'custom-wp-login-css', get_stylesheet_directory_uri() . '/assets/css/login_css.css?v=' . filemtime(get_stylesheet_directory() . '/assets/css/login_css.css'), false);

		// Enqueue style
		wp_enqueue_style( 'custom-wp-login-css' );


		// Custom login logo
		$logo_path = get_template_directory() . '/assets/images/logo.svg';

		if (file_exists($logo_path)) {
			echo '<style type="text/css">
				#login h1 a, .login h1 a {
					background-image: url(' . get_template_directory_uri() . '/assets/images/logo.svg);
					height:65px;
					width:320px;
					background-size: 320px 65px;
					background-repeat: no-repeat;
					padding-bottom: 30px;
					pointer-events: none;
				}
			</style>';
		}
	}

	/**
	 * Method for WP hook "sanitize_file_name".
	 * @param string $filename Filename to sanitize.
	 * @return string Sanitized filename.
	 */
	public function wp_hook_sanitize_file_name( $filename ) {
		return Theme_General_Methods::sanitize_filename( $filename );
	}

	/**
	 * Method for WP hook "phpmailer_init". Configure by defined constants.
	 * @param mixed $phpmailer PHP Mailer instance.
	 */
	public function wp_hook_phpmailer_init( $phpmailer ) {
		// Hook DOC: https://developer.wordpress.org/reference/hooks/phpmailer_init/
		// PHP Mailer DOC: https://github.com/PHPMailer/PHPMailer/

		/*
		// constants to be defined in wp-config.php
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
		*/

		if ( defined( 'SMTP_HOST' ) && defined( 'SMTP_AUTH' ) ) {
			$phpmailer->Mailer = 'smtp';
			$phpmailer->Host = SMTP_HOST;
			$phpmailer->SMTPAuth = SMTP_AUTH;

			if ( defined( 'SMTP_USER' ) ) {
				$phpmailer->Username = SMTP_USER;
			}
			if ( defined( 'SMTP_PASS' ) ) {
				$phpmailer->Password = SMTP_PASS;
			}
			if ( defined( 'SMTP_PORT' ) ) {
				$phpmailer->Port = SMTP_PORT;
			}
			if ( defined( 'SMTP_SECURE' ) ) {
				$phpmailer->SMTPSecure = SMTP_SECURE;
			}
			if ( defined( 'SMTP_FROM' ) ) {
				$phpmailer->Sender = SMTP_FROM;
				$phpmailer->From = SMTP_FROM;
			}
			if ( defined( 'SMTP_FROMNAME' ) ) {
				$phpmailer->FromName= SMTP_FROMNAME;
			}
			if ( defined( 'SMTP_REPLYTO' ) ) {
				$phpmailer->clearReplyTos();
				$phpmailer->addReplyTo(SMTP_REPLYTO);
			}
		}
	}

	/**
	 * Disable WP emojis functionality.
	 */
	protected function disable_emojis() {
		// Prevent Emoji from loading on the front-end
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );

		// Remove from admin area also
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );

		// Remove from RSS feeds also
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

		// Remove from Embeds
		remove_filter( 'embed_head', 'print_emoji_detection_script' );

		// Remove from emails
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		// Disable from TinyMCE editor. Currently disabled in block editor by default
		add_filter( 'tiny_mce_plugins', function ( $plugins ) {
			if ( is_array( $plugins ) ) {
				$plugins = array_diff( $plugins, array( 'wpemoji' ) );
			}
			return $plugins;
		});

		/** Finally, prevent character conversion too
		 ** without this, emojis still work 
		 ** if it is available on the user's device
		 */
		add_filter( 'option_use_smilies', '__return_false' );
	}

	/**
	 * Disable comments functionality.
	 */
	protected function disable_comments() {

		// remove widget
		add_action( 'widgets_init', function() {
			unregister_widget( 'WP_Widget_Recent_Comments' );
			add_filter( 'show_recent_comments_widget_style', '__return_false' );
		});

		// remove x-pingback header
		add_filter( 'wp_headers', function( $headers ) {
			unset( $headers['X-Pingback'] );
			return $headers;
		});

		// disable comments feed
		add_action( 'template_redirect', function() {
			if ( is_comment_feed() ) {
				wp_die( __( 'Komentáře jsou uzavřeny.', THEME_ADMIN_TEXT_DOMAIN ), '', array( 'response' => 403 ) );
			}
		}, 9);

		// disable comments REST API endpoint
		add_filter( 'rest_endpoints', function( $endpoints ) {
			unset( $endpoints['comments'] );
			return $endpoints;
		});

		// remove comment method in xmlrpc
		add_filter( 'xmlrpc_methods', function( $methods ) {
			unset( $methods['wp.newComment'] );
			return $methods;
		});

		add_action( 'admin_init', function () {
			// redirect comments page
			global $pagenow;
			if ( $pagenow === 'edit-comments.php' ) {
				wp_redirect(admin_url());
				exit;
			}

			// remove dashboard metabox
			remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

			// disable support for all post types
			foreach ( get_post_types() as $post_type ) {
				if ( post_type_supports( $post_type, 'comments' ) ) {
					remove_post_type_support( $post_type, 'comments' );
					remove_post_type_support( $post_type, 'trackbacks' );
				}
			}
		}, PHP_INT_MAX);

		// remove menu pages
		add_action( 'admin_menu', function () {
			remove_menu_page( 'edit-comments.php' );
			remove_submenu_page( 'options-general.php', 'options-discussion.php' );
		}, PHP_INT_MAX );

		// close comments on the front-end
		add_filter( 'comments_open', '__return_false', 20, 2 );
		add_filter( 'pings_open', '__return_false', 20, 2 );

		// hide existing comments
		add_filter( 'comments_array', '__return_empty_array', 10, 2 );

		// remove comments links from admin bar
		add_action( 'wp_before_admin_bar_render', function () {
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu('comments');
		});
	}

	/**
	 * Antispambot for email links.
	 */
	protected function email_antispambot() {
		if ( is_admin() ) {
			return false;
		}

		add_action( 'init', function() { 
			ob_start( function( $content ) {
				$regex_mailto = '`\<a([^>]+)href\=\"mailto\:([^">]+)\"([^>]*)\>(.*?)\<\/a\>`ism';
				return preg_replace_callback( $regex_mailto, function ( $match ) {
					$link = $match[0];
					$email_href = $match[2];
					$email_content = $match[4];
					
					$link = str_replace( 'mailto:' . $email_href, antispambot( 'mailto:' . $email_href ), $link );
					$link = str_replace( $email_href, antispambot( $email_href ), $link );

					return $link;
				}, $content );
			} );
		} );

		$filter_hooks = array(
			'the_title', 
			'the_content', 
			'the_excerpt', 
			'get_the_excerpt',

			'comment_text', 
			'comment_excerpt', 
			'comment_url',
			'get_comment_author_url',
			'get_comment_author_url_link',

			'widget_title',
			'widget_text',
			'widget_content',
			'widget_output',
		);

		foreach ( $filter_hooks as $filter_hook ) {
			add_filter( $filter_hook, function( $content ) {
				$regex_mailto = '`\<a([^>]+)href\=\"mailto\:([^">]+)\"([^>]*)\>(.*?)\<\/a\>`ism';
				return preg_replace_callback( $regex_mailto, function ( $match ) {
					$link = $match[0];
					$email_href = $match[2];
					$email_content = $match[4];
					
					$link = str_replace( 'mailto:' . $email_href, antispambot( 'mailto:' . $email_href ), $link );
					$link = str_replace( $email_href, antispambot( $email_href ), $link );

					return $link;
				}, $content );
			}, PHP_INT_MAX );
		}
	}

	/**
	 * Antispambot for phone links.
	 */
	protected function phone_antispambot() {
		if ( is_admin() ) {
			return false;
		}

		add_action( 'init', function() { 
			ob_start( function( $content ) {
				$regex_tel = '`\<a([^>]+)href\=\"tel\:([^">]+)\"([^>]*)\>(.*?)\<\/a\>`ism';
				return preg_replace_callback( $regex_tel, function ( $match ) {
					$link = $match[0];
					$phone_href = $match[2];
					$phone_content = $match[4];
					
					$link = str_replace( 'tel:' . $phone_href, antispambot( 'tel:' . str_replace(" ", "", $phone_href) ), $link );
					$link = str_replace( $phone_href, antispambot( $phone_href ), $link );

					return $link;
				}, $content );
			} );
		} );

		$filter_hooks = array(
			'the_title', 
			'the_content', 
			'the_excerpt', 
			'get_the_excerpt',

			'comment_text', 
			'comment_excerpt', 
			'comment_url',
			'get_comment_author_url',
			'get_comment_author_url_link',

			'widget_title',
			'widget_text',
			'widget_content',
			'widget_output',
		);

		foreach ( $filter_hooks as $filter_hook ) {
			add_filter( $filter_hook, function( $content ) {
				$regex_tel = '`\<a([^>]+)href\=\"tel\:([^">]+)\"([^>]*)\>(.*?)\<\/a\>`ism';
				return preg_replace_callback( $regex_tel, function ( $match ) {
					$link = $match[0];
					$phone_href = $match[2];
					$phone_content = $match[4];
					
					$link = str_replace( 'tel:' . $phone_href, antispambot( 'tel:' . str_replace(" ", "", $phone_href) ), $link );
					$link = str_replace( $phone_href, antispambot( $phone_href ), $link );

					return $link;
				}, $content );
			}, PHP_INT_MAX );
		}
	}

	/**
	 * Disable gutenberg editor by post template or post type.
	 * @param bool $can_edit Current settings.
	 * @param string $post_type Post type name.
	 * @return bool Can be the post edited by gutenberg.
	 */
	public function disable_gutenberg_by_page_template( $can_edit, $post_type ) {
		if ( !isset( $this->gutenberg_disable ) ) {
			return $can_edit;
		}

		/*if( !( is_admin() && !empty( $_GET['post'] ) ) ) {
			return $can_edit;
		}*/

		// disable by post type
		if (
			isset( $this->gutenberg_disable ) && isset( $this->gutenberg_disable['post_types'] ) &&
			is_array( $this->gutenberg_disable['post_types'] ) && 
			count( $this->gutenberg_disable['post_types'] ) > 0
		) {
			if ( in_array( $post_type, $this->gutenberg_disable['post_types'] ) ) {
				return false;
			}
		}

		// disable by post template
		if (
			isset( $this->gutenberg_disable ) && isset( $this->gutenberg_disable['post_templates'] ) &&
			is_array( $this->gutenberg_disable['post_templates'] ) && 
			count( $this->gutenberg_disable['post_templates'] ) > 0
		) {
			$post_id = 0;

			if ( !empty( $_GET['post'] ) ) {
				$post_id = intval( $_GET['post'] );
				if ( $post_id <= 0 ) {
					return $can_edit;
				}
			}

			$template_filename = get_page_template_slug($post_id);
			if ( in_array( $template_filename, $this->gutenberg_disable['post_templates'] ) ) {
				return false;
			}
		}

		// disable by post ID
		if (
			isset( $this->gutenberg_disable ) && isset( $this->gutenberg_disable['page_ids'] ) &&
			is_array( $this->gutenberg_disable['page_ids'] ) && 
			count( $this->gutenberg_disable['page_ids'] ) > 0
		) {
			$post_id = intval( $_GET['post'] );
			if ( $post_id <= 0 ) {
				return $can_edit;
			}

			if ( in_array( $post_id, $this->gutenberg_disable['page_ids'] ) ) {
				return false;
			}
		}

		return $can_edit;
	}

	/**
	 * Disable search functionality in parse_query hook.
	 * @param mixed $query Current WP_Query.
	 * @param bool $error Error identificator.
	 */
	public function wp_hook_parse_query_disable_search( $query, $error = true ) {
		if ( is_search() ) {
			$query->is_search = false;
			$query->query_vars['s'] = false;
			$query->query['s'] = false;

			if ( $error == true ) {
				$query->is_404 = true;
			}
		}
	}

	/**
	 * Register a new image size.
	 * @param string     $name   Image size identifier.
	 * @param int        $width  Optional. Image width in pixels. Default 0.
	 * @param int        $height Optional. Image height in pixels. Default 0.
	 * @param bool|array $crop   Optional. Image cropping behavior. If false, the image will be scaled (default),
	 *                           If true, image will be cropped to the specified dimensions using center positions.
	 *                           If an array, the image will be cropped using the array to specify the crop location.
	 *                           Array values must be in the format: array( x_crop_position, y_crop_position ) where:
	 *                               - x_crop_position accepts: 'left', 'center', or 'right'.
	 *                               - y_crop_position accepts: 'top', 'center', or 'bottom'.
	 */
	public function add_image_size( $name, $width = 0, $height = 0, $crop = false ) {
		array_push( $this->image_sizes, array(
			"name"   => $name,
			"width"  => $width,
			"height" => $height,
			"crop"   => $crop
		) );
	}

	/**
	 * Add file to preload in header / HTTP2 PUSH.
	 * @param string $src Source of the file.
	 * @param string $as Type of the file (audio, document, embed, fetch, font, image, object, script, style, worker, video).
	 * @param string $mime_type MIME TYPE
	 * @param bool $crossorigin Allow file cross origin (use always for font).
	 * @param string $media Media definition e.g. "(min-width: 640px)"
	 */
	public function add_file2preload( $src, $as, $mime_type = '', $crossorigin = false, $media = '' ) {
		array_push($this->preload, array(
			'src'         => $src,
			'as'          => $as,
			'type'        => $mime_type,
			'crossorigin' => $crossorigin,
			'media'       => $media
		));
	}

	/**
	 * Add URI to preconnect in header.
	 * @param string $uri URI to preconnect e.g. "https://fonts.gstatic.com"
	 */
	public function add_uri2preconnect( $uri ) {
		array_push( $this->preconnect, $uri );
	}

	/**
	 * Get asset src in theme with version attribute.
	 * @param string $path Relative path to the asset in the theme.
	 * @return string Path to the asset with absolute URI and version attribute.
	 */
	public static function get_asset_src( $path ) {

		if ( file_exists( THEME_ROOT_DIR . $path ) ) {
			return THEME_URI . $path . '?ver=' . date( 'YmdHis', filemtime( THEME_ROOT_DIR . $path ) );
		}

		return THEME_URI . $path . '?error=FILENOTFOUND';
	}

	/**
	 * Flush rewrite rules.
	 * (Needed for custom post types.)
	 */
	protected function flush_rewrite_rules()
	{
		flush_rewrite_rules( true );
	}

	/**
	* Customize admin bar - make mini-admin bar on frontend
	*
	* @param WP_Admin_Bar $admin_bar
	* @return Void
	*/
	public function customize_admin_bar_nodes( $wp_admin_bar ) {

		$this->customize_admin_bar( $wp_admin_bar );
	}

	/**
	 * Customize admin bar - make mini-admin bar on frontend
	 *
	 * @return Void
	 */
	public function customize_admin_bar_nodes_before_render() {

		global $wp_admin_bar;

		$this->customize_admin_bar( $wp_admin_bar );
	}

	/**
	 * This function customizes admin bar.
	 *
	 * @param WP_Admin_Bar $wp_admin_bar
	 * @return Void
	 */
	public function customize_admin_bar( $wp_admin_bar ) {

		if ( ! $wp_admin_bar ) return;

		// DOCS: https://developer.wordpress.org/reference/classes/wp_admin_bar/add_menu/
		// DOCS: https://developer.wordpress.org/reference/classes/wp_admin_bar/add_node/
		// DOCS: https://developer.wordpress.org/reference/classes/wp_admin_bar/remove_node/

		// Enabled nodes, customization included
		$customized_nodes = array(
			'wp-logo' => array(
				'href' => home_url('/wp-admin/')
			),
		);

		$customized_nodes = apply_filters( 'theme_base_admin_bar_customized_nodes', $customized_nodes );

		// Get all nodes
		$all_nodes = $wp_admin_bar->get_nodes();

		// Removing & updating the nodes
		foreach ( $all_nodes as $key => $val ) {

			$current_node = $all_nodes[ $key ];

			// At first - remove this node
			$wp_admin_bar->remove_node($key);

			// If this node is in $customized_nodes array, add it back
			if ( array_key_exists($key, $customized_nodes) ) {

				foreach ( $customized_nodes[ $key ] as $property => $new_value ) {
					$current_node->$property = $new_value;
				}

				// Add customized node back to the admin bar
				$wp_admin_bar->add_node($current_node);
			}
		}

		// Add new custom nodes

		// Dashboard
		$wp_admin_bar->add_menu( array(
			'id'		=> 'admin-dashboard',
			'parent'	=> 'wp-logo',
			'title'		=> __('Nástěnka'),
			'href'		=> home_url('/wp-admin/')
		));

		if ( is_tax() ) {

			$term_id = get_queried_object_id();
			$term = get_term( $term_id );

			// Edit term
			$wp_admin_bar->add_menu( array(
				'id'		=> 'edit-term',
				'parent'	=> 'wp-logo',
				'title'		=> __('Upravit'),
				'href'		=> get_edit_term_link($term_id, $term->taxonomy)
			));

		} elseif ( is_archive() ) {
			// Nothing to do, archive cannot be edited

		} else {

			global $post;

			if ( $post_type = get_post_type_object( get_post_type($post) ) ) {

			$post_type_label = $post_type->labels->edit_item;

			// Edit post
			$wp_admin_bar->add_menu( array(
				'id'		=> 'edit-post',
				'parent'	=> 'wp-logo',
				'title'		=> ($post_type_label) ? $post_type_label : __('Upravit'),
				'href'		=> get_edit_post_link(get_the_ID())
			));
			}
		}

		// Logout
		$wp_admin_bar->add_menu( array(
			'id'		=> 'logout',
			'parent'	=> 'wp-logo',
			'title'		=> __('Odhlásit se'),
			'href'		=> wp_logout_url()
		));

		$wp_admin_bar = do_action( 'theme_base_wp_admin_bar_object', $wp_admin_bar );
	}

	public function save_form_entry_to_database($form_id, $email, $values) {
		global $wpdb;

		$table = $wpdb->prefix.'saved_forms';
		$data = array('form_id' => $form_id, 'email' => $email, 'values' => $values);
		$format = array('%s','%s', '%s');
		$wpdb->insert($table,$data,$format);
	}

	public function get_form_entries($form_id = "") {
		global $wpdb;
		if($form_id != "") {
			return $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}saved_forms WHERE form_id = \"{$form_id}\"", ARRAY_A );
		}else {
			return $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}saved_forms", ARRAY_A );
		}
	}

	public static function get_wp_config($name) {
		return self::$instance_config[$name];
	}

	public static function get_image_size_info($size) {
		$sizes_infos = wp_get_registered_image_subsizes();

		$text = "";
		if($sizes_infos && $sizes_infos[$size]) {
			$info = $sizes_infos[$size];
			$width = $info["width"]*2;
			$height = $info["height"]*2;
			$text = "Nahrajte obrázek ideálně o velikosti ".$width."x".$height."px nebo ve stejném poměru stran.";
			if($info["crop"]) {
				$text .= " Obrázek se ořízne na střed.";
			}else {
				$text .= " Obrázek si zachová poměr stran.";
			}
		}
		return $text;
	}

	#endregion
}

?>