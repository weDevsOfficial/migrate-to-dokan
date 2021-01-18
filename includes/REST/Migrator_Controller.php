<?php 

namespace WeDevs\MigrateToDokan\REST;

use WeDevs\MigrateToDokan\Admin\Migrator_Manager;
use WeDevs\MigrateToDokan\Admin\Migrators\WCFM_Migrator;
use WP_REST_Controller;
use WP_REST_Request;

class Migrator_Controller extends WP_REST_Controller{

	protected $migrator;

	protected $namespace = 'migrate-to-dokan/v1';

	public function __construct() {
		$this->migrator = Migrator_Manager::get_migrator();
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
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 5;
		$total = $this->migrator->get_order_counts();
		$next_page = null;

		if ( ($page + 1) * $per_page <= $total ) {
			$next_page = $page + 1;
		}

		$this->migrator->migrate_orders($per_page, $page );

		return new \WP_REST_Response(
			array(
				'status' => 'success',
				'message' => 'Migrated',
				'total' => $total,
				'per_page' => $per_page,
				'next_page' => $next_page,
				'current_page' => $page
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