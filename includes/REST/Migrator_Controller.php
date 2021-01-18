<?php 

namespace WeDevs\MigrateToDokan\REST;

use WeDevs\MigrateToDokan\Admin\Migrators\WCFM_Migrator;
use WP_REST_Controller;

class Migrator_Controller extends WP_REST_Controller{

	protected $migrator;

	protected $namespace = 'migrate-to-dokan/v1';

	public function __construct() {
		$this->migrator = new WCFM_Migrator();
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	public function register_routes() {
		register_rest_route( 
			$this->namespace, 'vendor', [
				'method' => 'GET',
				'callback' => array( $this, 'migrate_vendor' ),
				'permission_callback' => array( $this, 'check_permission' ),
			]
		);

		register_rest_route( $this->namespace, 'withdraw', [
		    'methods' => 'GET',
		    'callback' => array( $this, 'migrate_withdraw' ),
		    'permission_callback' => array( $this, 'check_permission' ),
		] );

		register_rest_route( $this->namespace, 'order', [
			'methods' => 'GET',
			'callback' => array( $this, 'migrate_order' ),
			'permission_callback' => array( $this, 'check_permission' ),
		] );
		
		register_rest_route( $this->namespace, 'refund', [
			'methods' => 'GET',
			'callback' => array( $this, 'migrate_refund' ),
			'permission_callback' => array( $this, 'check_permission' ),
		] );
	}

	public function check_permission() {
		return true;
		// return current_user_can( 'manage_options' );
	}

	public function migrate_vendor() {

		$this->migrator->migrate_vendors();
		
		return new \WP_REST_Response(
			array(
				'status' => 'success',
				'message' => 'Migrated'
			)
		);
	}

	public function migrate_withdraw() {

		$this->migrator->migrate_withdraws();

	    return new \WP_REST_Response(
			array(
				'status' => 'success',
				'message' => 'Migrated'
			)
		);
	}

	public function migrate_order() {

		$this->migrator->migrate_orders(5);

		return new \WP_REST_Response(
			array(
				'status' => 'success',
				'message' => 'Migrated'
			)
		);
	}

	public function migrate_refund() {
		$this->migrator->migrate_refunds();

	    return new \WP_REST_Response(
			array(
				'status' => 'success',
				'message' => 'Migrated'
			)
		);
	}

}