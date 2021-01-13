<?php

namespace WeDevs\MigrateToDokan\Admin\Migrators;

use WeDevs\MigrateToDokan\Admin\Dokan;
use WeDevs\MigrateToDokan\Admin\Migrator_Interface;

class WCFM_Migrator implements Migrator_Interface {

    public function get_statistics()
    {
        $product_counts = $this->get_product_counts();
        $vendor_counts = $this->get_vendor_counts();

        return [
            'Total Products' => $product_counts,
            'Total Vendors' => $vendor_counts,
        ];
    }

    /**
     * Get the count of all products
     *
     * @return int
     */
    protected function get_product_counts()
    {
		$count_products = array();
		// dokan_get_sellers()
		$current_user_id = 0;
		$count_products['publish'] = wcfm_get_user_posts_count( $current_user_id, 'product', 'publish' );
		$count_products['pending'] = wcfm_get_user_posts_count( $current_user_id, 'product', 'pending' );
		$count_products['draft']   = wcfm_get_user_posts_count( $current_user_id, 'product', 'draft' );
		$count_products['private'] = wcfm_get_user_posts_count( $current_user_id, 'product', 'private' );
        $count_products['any'] = 0;
        
		foreach( $count_products as $count_product ) {
			$count_products['any']  += $count_product;
        }

        return $count_products['any'];
    }

    /**
     * Get the counts of all vendors
     *
     * @return int
     */
    protected function get_vendor_counts()
    {
		$vendors = $this->get_all_vendors();
		
        return is_array($vendors) ? count($vendors) : 0;
	}
	
	protected function get_all_vendors()
	{
		$wcfm_all_vendors = migrate_to_dokan_get_vendors( [ 'wcfm_vendor', 'disable_vendor' ]);

		return $wcfm_all_vendors;
	}

    public function migrate()
    {
		$this->migrate_withdraw();

		$this->migrate_vendor();

		$this->migrate_orders(5);
	}

	public function migrate_orders( $limit, $page = 1 ) {
		$orders = wc_get_orders( [ 
			'limit' => $limit,
			'page' => $page,
			'order' => 'ASC'
		] );

		// foreach ( $orders as $order ) {
		// 	Dokan::migrate_order( $order->ID );
		// }

		return $orders;
	}
	
	public function migrate_withdraw() {
		global $wpdb;
		
		$query = "SELECT * FROM `{$wpdb->prefix}wcfm_marketplace_withdraw_request`";

		$results = $wpdb->get_results( $query );
		
		foreach ( $results as $request ) {
			$status = 0;
			switch ( $request->withdraw_status ) {
				case 'pending': 
					$status = 0;
					break;
				case 'completed': 
					$status = 1;
					break;
				case 'cancelled': 
					$status = 2;
					break;
				default: 
					$status = 0;
					break;
			}
			$vendor_id = $request->vendor_id;
			$amount = $request->withdraw_amount;

			$status = $request->withdraw_status;
			$payment_method = $request->payment_method;
			$date = $request->created;
			$note = $request->withdraw_note;

			Dokan::migrate_withdraw( $vendor_id, $amount, $status, $payment_method, $date, $note);
		} 
	}

	/**
	 * Migrate a vendor to dokan vendor
	 *
	 * @param int $vendor_id
	 * @return void
	 */
	public function migrate_vendor() {
		$vendors = $this->get_all_vendors();

		if ( ! count( $vendors ) ) {
			return false;
		}
		
		foreach ( $vendors as $vendor ) {
			$vendor_id = $vendor->ID;

			$vendor_meta = $this->map_vendor_meta( $vendor_id );

			Dokan::migrate_vendor( $vendor_id, $vendor_meta );
		}
		
		return true;
	}

	public function map_vendor_settings( $vendor_settings )
	{
		$dokan_settings = array();

		$dokan_settings['store_name']                           = $vendor_settings['store_name'];
		$dokan_settings['social']                               = $vendor_settings['social'];
		$dokan_settings['social']['flickr']                     = $vendor_settings[''];
		$dokan_settings['payment']['bank']                      = $vendor_settings['payment']['bank'];
		$dokan_settings['payment']['paypal']                    = $vendor_settings['payment']['paypal'];
		$dokan_settings['phone']                                = $vendor_settings['phone'];
		$dokan_settings['show_email']                           = $vendor_settings[''];
		$dokan_settings['address']                              = $vendor_settings['address'];
		$dokan_settings['location']                             = $vendor_settings[''];
		$dokan_settings['banner']                               = $vendor_settings['banner'];
		$dokan_settings['icon']                                 = $vendor_settings[''];
		$dokan_settings['gravatar']                             = $vendor_settings['gravatar'];
		$dokan_settings['show_more_ptab']                       = 'yes';
		$dokan_settings['store_ppp']                            = $vendor_settings['store_ppp'];
		$dokan_settings['enable_tnc']                           = 'off';
		$dokan_settings['store_tnc']                            = $vendor_settings[''];
		$dokan_settings['show_min_order_discount']              = 'no';
		$dokan_settings['store_seo']['dokan-seo-meta-title']    = $vendor_settings['store_seo']['wcfmmp-seo-meta-title'];
		$dokan_settings['store_seo']['dokan-seo-meta-desc']     = $vendor_settings['store_seo']['wcfmmp-seo-meta-desc'];
		$dokan_settings['store_seo']['dokan-seo-meta-keywords'] = $vendor_settings['store_seo']['wcfmmp-seo-meta-keywords'];
		$dokan_settings['store_seo']['dokan-seo-og-title']      = $vendor_settings['store_seo']['wcfmmp-seo-og-title'];
		$dokan_settings['store_seo']['dokan-seo-og-desc']       = $vendor_settings['store_seo']['wcfmmp-seo-og-desc'];
		$dokan_settings['store_seo']['dokan-seo-og-image']      = $vendor_settings['store_seo']['wcfmmp-seo-og-image'];
		$dokan_settings['store_seo']['dokan-seo-twitter-title'] = $vendor_settings['store_seo']['wcfmmp-seo-twitter-title'];
		$dokan_settings['store_seo']['dokan-seo-twitter-desc']  = $vendor_settings['store_seo']['wcfmmp-seo-twitter-desc'];
		$dokan_settings['store_seo']['dokan-seo-twitter-image'] = $vendor_settings['store_seo']['wcfmmp-seo-twitter-image'];
		$dokan_settings['dokan_store_time_enabled']             = 'yes';
		$dokan_settings['dokan_store_open_notice']              = $vendor_settings[''];
		$dokan_settings['dokan_store_close_notice']             = $vendor_settings[''];
		$dokan_settings['dokan_store_time']                     = $vendor_settings['wcfm_store_hours'];
	
		return $dokan_settings;
	}

	public function map_vendor_meta( $vendor_id )
	{
		$vendor_meta = array();

		$wcfm_settings = get_user_meta( $vendor_id, 'wcfmmp_profile_settings', true );

		$vendor_meta['dokan_store_name'] = get_user_meta( $vendor_id, 'wcfmmp_store_name' ) ?: get_user_meta( $vendor_id, 'store_name' );
		$vendor_meta['dokan_enable_selling'] = user_can( $vendor_id, 'wcfm_vendor' ) ? 'yes' : 'no';
		$vendor_meta['dokan_publishing'] = 'no';
		$vendor_meta['dokan_profile_settings'] = $this->map_vendor_settings( $wcfm_settings );
		$vendor_meta['dokan_feature_seller'] = 'no';

		if (isset($wcfm_settings['commission'])) {
			$commission_type = $wcfm_settings['commission']['commission_mode'];
			$commission_value = 0;
			if ($commission_type == 'percent') {
				$commission_value = $wcfm_settings['commission']['commission_percent'];
			} else if(isset($wcfm_settings['commission']['commission_fixed'])) {
				$commission_value = $wcfm_settings['commission']['commission_fixed'];
			}

			$vendor_meta['dokan_admin_percentage'] = $commission_value;
			$vendor_meta['dokan_admin_percentage_type'] = $commission_type;
		}
	
		return $vendor_meta;
	}
}