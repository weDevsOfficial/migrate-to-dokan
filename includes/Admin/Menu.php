<?php

namespace WeDevs\MigrateToDokan\Admin;

class Menu {
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'add_migrate_to_dokan_menu' ] );

        if ( isset( $_GET['page'] ) && $_GET['page'] == 'migrate-to-dokan' ) {
            add_action( 'admin_init', [ $this, 'setup_wizard' ] );
        }
    }

    public function add_migrate_to_dokan_menu() {
        add_menu_page( __( 'Migrate to Dokan', 'weDevs' ), __( 'Migrate To Dokan', 'weDevs' ), 'manage_options', 'migrate-to-dokan', [ $this, 'migrate' ], 'dashicons-database' );
        add_submenu_page( null, '', '', 'manage_options', 'migrate-to-dokan' );
    }

    public function setup_wizard() {
        $migrator = Migrator_Manager::get_migrator();

        $template = MIGRATE_DOKAN_TEMPLATE_DIR . '/setup-page.php';

        include_once $template;
        exit;
    }
}
