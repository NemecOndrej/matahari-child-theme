<?php /*ěščřžýáíéúů*/

// REPLACE THESE VALUES + rewrite labels:
// FORMNAME - unique form name (lowercase, non-gap), e.g. contact_form
// FORMSLUG - form slug (lowercase, non-gap), e.g. contact-form
// FORMSHORT - short form name (uppercase, non-gap), e.g. CF

define( 'FORMSHORT_TABLE_NAME', 'FORMNAME_entries' );


#region POST TYPE DEFINITION ----------------------------------------------------

add_action( 'admin_menu', 'FORMNAME_entries_menu_page' );

/**
 * Add admin page to display form entries
 *
 * @return Void
 */
function FORMNAME_entries_menu_page() {
	// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	add_menu_page(
		__('Záznamy kontaktního formuláře',THEME_ADMIN_TEXT_DOMAIN),
		__('Záznamy kontaktního formuláře',THEME_ADMIN_TEXT_DOMAIN),
		'edit_others_posts',
		'FORMSLUG-entries',
		'FORMNAME_entries_table',
		'dashicons-database',
		90
	);
}

/**
 * Render form database entries
 *
 * @return Void
 */
function FORMNAME_entries_table() {

	?><h1><?= __('Výpis záznamů z kontaktního formuláře',THEME_ADMIN_TEXT_DOMAIN); ?></h1><?php

	global $wpdb;

	$table_name = $wpdb->prefix.FORMSHORT_TABLE_NAME;

	// Pagination & limit variables
	$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
	$limit = 10;
	$offset = ( $pagenum - 1 ) * $limit;
	$total = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");
	$num_of_pages = ceil( $total / $limit );

	// Get entries from db
	$entries = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date_time DESC LIMIT $offset, $limit");

	if ( !empty($entries) ) : ?>
	<div class="wrap">
		<table class="wp-list-table widefat fixed striped table-view-list posts">
			<thead>
				<tr>
					<?php // NOTE: edit these columns ?>
					<td>ID</td>
					<td>Čas</td>
					<td>Jméno</td>
					<td>E-mail</td>
					<td>Telefon</td>
					<td>Zpráva</td>
					<td>GDPR</td>
					<td>URL</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $entries as $entry ) : ?>
					<tr>
						<?php // NOTE: edit these columns ?>
						<td><?= $entry->id; ?></td>
						<td><?= $entry->date_time; ?></td>
						<td><?= $entry->name; ?></td>
						<td><?= $entry->email; ?></td>
						<td><?= $entry->phone; ?></td>
						<td><?= $entry->message; ?></td>
						<td><?= $entry->gdpr; ?></td>
						<td><?= $entry->url; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php // Pagination
	$page_links = paginate_links( array(
		'base' => add_query_arg( 'pagenum', '%#%' ),
		'format' => '',
		'prev_text' => __( '&laquo;', THEME_ADMIN_TEXT_DOMAIN ),
		'next_text' => __( '&raquo;', THEME_ADMIN_TEXT_DOMAIN ),
		'total' => $num_of_pages,
		'current' => $pagenum
	) );

	if ( $page_links ) {
		echo '<div class="tablenav" style="width: 99%;"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
	}
	?>
	<?php else : ?>
		<p><?= __('Prozatím žádné záznamy.',THEME_ADMIN_TEXT_DOMAIN); ?></p>
	<?php endif;
}

#endregion

#region ADDING DATA TO DATABASE -----------------------------------------------

/**
 * Add database row with given form data.
 * 
 * Call this function in service file.
 *
 * @param String $name
 * @param String $email
 * @param String $phone
 * @param String $message
 * @param String $gdpr
 * @param String $url
 * @return Void
 */
function add_FORMNAME_database_entry( $name = '', $email = '', $phone = '', $message = '', $gdpr = '', $url = '' ) {

	global $wpdb;

	$table_name = $wpdb->prefix.FORMSHORT_TABLE_NAME;

	$charset_collate = $wpdb->get_charset_collate();

	// Create table if not exist
	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		date_time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
		name varchar(200) NOT NULL,
		email varchar(100) NOT NULL,
		phone varchar(100),
		message longtext,
		gdpr varchar(10) NOT NULL,
		url varchar(500) NOT NULL
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	// Add new entry
	if ( $name && $email && $gdpr ) {

		$wpdb->insert(
			$table_name,
			array(
				'date_time' => current_time( 'mysql' ),
				'name' => $name,
				'email' => $email,
				'phone' => $phone,
				'message' => $message,
				'gdpr' => $gdpr,
				'url' => $url,
			) 
		);

	} else {
		// --> TODO: log data?
	}
}

#endregion

?>