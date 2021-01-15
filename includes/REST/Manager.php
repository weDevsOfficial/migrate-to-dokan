<?php 

namespace WeDevs\MigrateToDokan\REST;

use WeDevs\MigrateToDokan\Admin\Migrators\WCFM_Migrator;

class Manager {

	protected $migrator;
	protected $namespace = 'migrate-to-dokan/v1';

	public function __construct() {
		$this->migrator = new WCFM_Migrator();

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
		return new \WP_REST_Response( 
			$this->migrator->migrate_vendors()
		);
	}

	public function migrate_withdraw() {
	    return new \WP_REST_Response( 
			$this->migrator->migrate_withdraws()
		);
	}

	public function migrate_order() {
	    return new \WP_REST_Response( 
			$this->migrator->migrate_orders(5)
		);
	}

	public function migrate_refund() {
	    return new \WP_REST_Response( 
			$this->migrator->migrate_refunds()
		);
	}
}