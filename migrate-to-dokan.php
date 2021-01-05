<?php 
/**
 * Plugin Name: Migrate To Dokan
 * Plugin URI: https://wedevs.com/migrate-to-dokan/
 * Description: Migrate Existing Data to Dokan. Powered by weDevs.
 * Version: 1.0
 * Author: weDevs
 * Author URI: https://wedevs.com/
 * License: GPL2
 */


if( ! defined( 'ABSPATH' ) ) exit;

final class Migrate_To_Dokan {
		
	private $plan = 'migrate-to-dokan';

    public $version = '1.0';

	private function __construct() {
		
		require_once __DIR__ . '/vendor/autoload.php';

		$this->define_constants();
		
		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}


	public static function init() {
        
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Migrate_To_Dokan();
        }

        return $instance;
    }

    public function init_plugin() {
		if( is_admin() ) {
			new WeDevs\MigrateToDokan\Admin\Menu();
			// new WeDevs\MigrateToDokan\Admin\Welcome();
		}
	}


	public function define_constants() {
        define( 'MIGRATE_TO_DOKAN_PLUGIN_VERSION', $this->version );
        define( 'MIGRATE_TO_DOKAN_FILE', __FILE__ );
        define( 'MIGRATE_DOKAN_DIR', dirname( MIGRATE_TO_DOKAN_FILE ) );
        define( 'MIGRATE_DOKAN_TEMPLATE_DIR', MIGRATE_DOKAN_DIR . '/templates' );
        define( 'MIGRATE_TO_DOKAN_DIR', dirname( MIGRATE_TO_DOKAN_FILE ) );
        define( 'MIGRATE_TO_DOKAN_INC', MIGRATE_TO_DOKAN_DIR . '/includes' );
        define( 'MIGRATE_TO_DOKAN_ADMIN_DIR', MIGRATE_TO_DOKAN_INC . '/Admin' );
        define( 'MIGRATE_TO_DOKAN_PLUGIN_ASSEST', plugins_url( 'assets', MIGRATE_TO_DOKAN_FILE ) );
    }

	public function activate() {
		// new WeDevs\MigrateToDokan\Admin\Welcome();
	}
}

function migrate_to_dokan() {
    return Migrate_To_Dokan::init();
}

migrate_to_dokan();