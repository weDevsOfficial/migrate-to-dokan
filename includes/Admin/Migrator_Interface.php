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
     * Get the statistics of entity's records lik products counts, vendors counts etc
     *
     * @return array
     */
    public function get_statistics();
}