<?php

namespace WeDevs\MigrateToDokan\Admin;

interface Migrator_Interface {

    /**
     * Migrate the data to Dokan compatible data
     *
     * @return void
     */
    public function migrate();

    /**
     * Migrate orders by pagination
     *
     * @param int $limit
     * @param int $page
     *
     * @return void
     */
    public function migrate_orders( $limit, $page = 1 );

    /**
     * Migrate withdraws
     *
     * @return void
     */
    public function migrate_withdraws();

    /**
     * Migrate vendors
     *
     * @return void
     */
    public function migrate_vendors();

    /**
     * Migrate Refunds
     *
     * @return void
     */
    public function migrate_refunds();

    /**
     * Get the statistics of entity's records lik products counts, vendors counts etc
     *
     *@param string $name
     *
     * @return array|integer
     */
    public function get_statistics( $key = null );
}
