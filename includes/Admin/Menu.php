<?php 

namespace weDevs\MigrateToDokan\Admin;

class Menu {
	function __construct() {
		add_action( 'admin_menu', [ $this, 'add_migrate_to_dokan_menu' ] );
	}

	public function add_migrate_to_dokan_menu() {
		// 1st page title, 
		// 2nd menu title, 
		// 3rd who manage it, 
		// 4th slug url, 
		// 5th callback method, 
		// 6th menu icon.
		add_menu_page( __( 'Migrate to Dokan', 'weDevs'), __( 'Migrate To Dokan', 'weDevs'), 'manage_options', 'migrate-to-dokan-menu', [ $this, 'add_migrate_to_dokan_page' ], 'dashicons-buddicons-buddypress-logo' );
	}


	public function add_migrate_to_dokan_page() {
		return 'Welcome!';
	}
}