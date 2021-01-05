<?php 

namespace WeDevs\MigrateToDokan\Admin;

Class Welcome {
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'dokan_admin_menus' ) );
		add_action( 'admin_init', array( $this, 'dokan_redirect' ) );
		add_action( 'admin_init', array( $this, 'dokan_migration' ) );
	}

	public function dokan_admin_menus() {
		add_dashboard_page( '', '', 'manage_options', 'migrate-to-dokan' );
	}

	public function dokan_redirect() {
		wp_redirect( admin_url('?page=migrate-to-dokan') );
	}

	public function dokan_migration() {
		if ( filter_input(INPUT_GET, 'page') == 'migrate-to-dokan') {
			// error_log(print_r('Hello', true));
			include_once MIGRATE_DOKAN_TEMPLATE_DIR . '/setup-page.php';
		}
	}
}