<?php 

namespace WeDevs\MigrateToDokan\Admin;

class Dokan {
    public static function migrate_withdraw( $vendor_id, $amount, $status, $payment_method, $date, $note,  $ip = null ) {
        $data = [
            'id' => 0,
            'user_id' => $vendor_id,
            'amount' => $amount,
            'status' => $status,
            'method' => $payment_method,
            'date' => $date,
            'note' => $note,
            'ip' => $ip
        ];

        $withdraw = dokan()->withdraw->create( $data );
        
        self::create_vendor_balance_by_withdraw($withdraw);

        return $withdraw;
    }

    public static function create_vendor_balance_by_withdraw( $withdraw ) {
        global $wpdb;

        if ( $withdraw->status != 1 ) {
            return;
        }

        $balance_result = $wpdb->get_row(
            $wpdb->prepare(
                "select * from {$wpdb->dokan_vendor_balance} where trn_id = %d and trn_type = %s",
                $withdraw->get_id(),
                'dokan_withdraw'
            )
        );

        if ( empty( $balance_result ) ) {
            $wpdb->insert(
                $wpdb->dokan_vendor_balance,
                array(
                    'vendor_id'     => $withdraw->get_user_id(),
                    'trn_id'        => $withdraw->get_id(),
                    'trn_type'      => 'dokan_withdraw',
                    'perticulars'   => 'Approve withdraw request',
                    'debit'         => 0,
                    'credit'        => $withdraw->get_amount(),
                    'status'        => 'approved',
                    'trn_date'      => $withdraw->get_date(),
                    'balance_date'  => current_time( 'mysql' ),
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%s',
                    '%f',
                    '%f',
                    '%s',
                    '%s',
                    '%s',
                )
            );
        }
    }

    public static function migrate_order( $order_id ) {
        if ( dokan_is_order_already_exists( $order_id ) ) {
            return;
        }

        dokan()->order->maybe_split_orders( $order_id );

        $has_sub_order = get_post_meta( $order_id, 'has_sub_order', true);

        if ( $has_sub_order == '1' ) {
            return;
        }

        dokan_sync_insert_order($order_id);
    }

    public static function migrate_vendor( $vendor_id, $vendor_meta ) {
		if ( !$vendor_id ) {
			return false;
		}

		$vendor_user = get_userdata( $vendor_id );

        $vendor_user->set_role('seller');

        foreach ( (array) $vendor_meta as $key => $value ) {
			update_user_meta( $vendor_id, $key, $value );
		}

		return true;
    }
}
