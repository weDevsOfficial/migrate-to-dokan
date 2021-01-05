<?php 

namespace WeDevs\MigrateToDokan\Admin;

class Menu {
	function __construct() {
		add_action( 'admin_menu', [ $this, 'add_migrate_to_dokan_menu' ] );
	}

	public function add_migrate_to_dokan_menu() {
		add_menu_page( __( 'Migrate to Dokan', 'weDevs'), __( 'Migrate To Dokan', 'weDevs'), 'manage_options', 'migrate-to-dokan-menu', [ $this, 'add_migrate_to_dokan_page' ], 'dashicons-database' );
	}

	public function add_migrate_to_dokan_page() {
		$action = isset( $_GET['page'] ) ? $_GET['page'] : '';
		
		if ( $action == 'migrate-to-dokan-menu' ) {
			$template = MIGRATE_DOKAN_TEMPLATE_DIR . '/setup-page.php';
		}

		if ( file_exists( $template ) ) {
			include_once $template;
		}
	}
}