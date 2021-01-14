<?php 

namespace WeDevs\MigrateToDokan\Admin;

class Dokan {
    public static function migrate_withdraw( $vendor_id, $amount, $status, $payment_method, $date, $note,  $ip = null, $approve_date = null ) {
        global $wpdb;

        $data = [
            'user_id' => $vendor_id,
            'amount'  => $amount,
            'status'  => $status,
            'method'  => $payment_method,
            'date'    => $date,
            'note'    => $note,
            'ip'      => $ip ?: ''
        ];
        
        $wpdb->insert(
            $wpdb->dokan_withdraw,
            $data,
            array(
                '%d',
                '%f',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s'
            )
        );

        if ( $wpdb->insert_id && $status == 1 ) {
            self::create_vendor_balance_by_withdraw( $wpdb->insert_id, $vendor_id, $amount, $date, $approve_date );
        }

        return $wpdb->insert_id;
    }

    public static function create_vendor_balance_by_withdraw( $withdraw_id, $vendor_id, $amount, $trn_date, $approve_date ) {
        global $wpdb;

        $balance_result = $wpdb->get_row(
            $wpdb->prepare(
                "select * from {$wpdb->dokan_vendor_balance} where trn_id = %d and trn_type = %s",
                $withdraw_id,
                'dokan_withdraw'
            )
        );

        if ( empty( $balance_result ) ) {
            $wpdb->insert(
                $wpdb->dokan_vendor_balance,
                array(
                    'vendor_id'     => $vendor_id,
                    'trn_id'        => $withdraw_id,
                    'trn_type'      => 'dokan_withdraw',
                    'perticulars'   => 'Approve withdraw request migrated',
                    'debit'         => 0,
                    'credit'        => $amount,
                    'status'        => 'approved',
                    'trn_date'      => $trn_date,
                    'balance_date'  => $approve_date ?: current_time( 'mysql' ),
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

    public static function migrate_refund($vendor_id, $order_id, $refund_amount, $refund_reason,$item_qtys, $item_totals, $item_tax_totals, $status, $date, $restock_items,  $payment_method, $approved_date = null) {
        global $wpdb;

        if ( is_array( $item_qtys ) ) {
            $item_qtys = json_encode($item_qtys);
        }

        if ( is_array( $item_totals ) ) {
            $item_totals = json_encode($item_totals);
        }

        if ( is_array( $item_tax_totals ) ) {
            $item_tax_totals = json_encode($item_tax_totals);
        }

        if ( empty( $balance_result ) ) {
            $wpdb->insert(
                $wpdb->dokan_refund,
                array(
                    'order_id'        => $order_id,
                    'seller_id'       => $vendor_id,
                    'refund_amount'   => $refund_amount,
                    'refund_reason'   => $refund_reason,
                    'item_qtys'       => $item_qtys,
                    'item_totals'     => $item_totals,
                    'item_tax_totals' => $item_tax_totals,
                    'restock_items'   => $restock_items,
                    'date'            => $date,
                    'status'          => $status,
                    'method'          => $payment_method,
                ),
                array(
                    '%d',
                    '%d',
                    '%f',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%d',
                    '%s',
                )
            );
        }
        $trn_id = $wpdb->insert_id;

        if ( $trn_id && $status == 1 ) {
            self::create_vendor_balance_refund($vendor_id, $trn_id, $refund_amount, $date, $approved_date);
        }
    }

    public static function create_vendor_balance_refund( $vendor_id, $trn_id, $amount, $date, $approved_date = null ) {
        global $wpdb;

        $balance_result = $wpdb->get_row(
            $wpdb->prepare(
                "select * from {$wpdb->dokan_vendor_balance} where trn_id = %d and trn_type = %s",
                $trn_id,
                'dokan_refund'
            )
        );

        if ( empty( $balance_result ) ) {
            $wpdb->insert(
                $wpdb->dokan_vendor_balance,
                array(
                    'vendor_id'     => $vendor_id,
                    'trn_id'        => $trn_id,
                    'trn_type'      => 'dokan_refund',
                    'perticulars'   => 'Approve request migrated',
                    'debit'         => $amount,
                    'credit'        => 0,
                    'status'        => 'wc-completed',
                    'trn_date'      => $date,
                    'balance_date'  => $approved_date ?: $date
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

        return $wpdb->insert_id;
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
