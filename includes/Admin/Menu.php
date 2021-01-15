<?php 

namespace WeDevs\MigrateToDokan\Admin;

class Menu {
	function __construct() {
		add_action( 'admin_menu', [ $this, 'add_migrate_to_dokan_menu' ] );
		
		if (isset($_GET['page']) && $_GET['page'] == 'migrate-to-dokan'){
			add_action( 'admin_init', [ $this, 'setup_wizard' ] );
		}
	
	}

	public function add_migrate_to_dokan_menu() {
		add_menu_page( __( 'Migrate to Dokan', 'weDevs'), __( 'Migrate To Dokan', 'weDevs'), 'manage_options', 'migrate-to-dokan', [ $this, 'migrate' ], 'dashicons-database' );
		add_submenu_page( null, '', '', 'manage_options', 'migrate-to-dokan' );
	}

	public function setup_wizard() {
		$has_setup_wizard = get_option( 'dokan-migrate-setup-wizard', 'no' );

        if ( $has_setup_wizard == 'yes' ) {
			// return;
            //wp_safe_redirect('http://wplearn.test/wp-admin/admin.php?page=migrate-to-dokan1');
        }

		$template = MIGRATE_DOKAN_TEMPLATE_DIR . '/setup-page.php';
		
		include_once $template;
		exit;

		
		update_option( 'dokan-migrate-setup-wizard', 'yes' );
		// exit;
		// if ( $action == 'migrate-to-dokan-menu' ) {
		// 	$template = MIGRATE_DOKAN_TEMPLATE_DIR . '/setup-page.php';
		// }

		// if ( file_exists( $template ) ) {
		// 	include_once $template;
		// }
	}

	public function migrate()
	{
		$migrator = Migrator_Manager::get_migrator();
		$migrator->migrate();
	}
}