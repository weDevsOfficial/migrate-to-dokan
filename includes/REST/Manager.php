<?php 

namespace WeDevs\MigrateToDokan\REST;

use WeDevs\MigrateToDokan\Admin\Migrators\WCFM_Migrator;

class Manager {

	protected $namespace = 'migrate-to-dokan/v1';

	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'get_vendor' ] );
		add_action( 'rest_api_init', [ $this, 'get_withdraw' ] );
		add_action( 'rest_api_init', [ $this, 'get_order' ] );
		add_action( 'rest_api_init', [ $this, 'get_refund' ] );
	}

	public function get_vendor() {
		register_rest_route( 
			$this->namespace, 
			'vendor', 
			[
				'method' => 'GET',
				'callback' => array( $this, 'migrate_vendor' ),
				'permission_callback' => array( $this, 'check_permission' ),
			]
		);
	}

	public function get_withdraw() {
		register_rest_route( $this->namespace, 'withdraw', [
		    'methods' => 'GET',
		    'callback' => array( $this, 'migrate_withdraw' ),
		    'permission_callback' => array( $this, 'check_permission' ),
  		] );
	}

	public function get_order() {
		register_rest_route( $this->namespace, 'order', [
		    'methods' => 'GET',
		    'callback' => array( $this, 'migrate_order' ),
		    'permission_callback' => array( $this, 'check_permission' ),
  		] );
	}

	public function get_refund() {
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
		$migrator = new WCFM_Migrator();
		
		return new \WP_REST_Response( 
			$migrator->migrate_vendors()
		);
	}

	public function migrate_withdraw() {
		$migrator = new WCFM_Migrator();

	    return new \WP_REST_Response( 
			$migrator->migrate_withdraws()
		);
	}

	public function migrate_order() {
		$migrator = new WCFM_Migrator();

	    return new \WP_REST_Response( 
			$migrator->migrate_orders(5)
		);
	}

	public function migrate_refund() {
		$migrator = new WCFM_Migrator();

	    return new \WP_REST_Response( 
			$migrator->migrate_refunds()
		);
	}
}