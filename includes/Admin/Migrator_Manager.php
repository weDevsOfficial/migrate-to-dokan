<?php

namespace WeDevs\MigrateToDokan\Admin;

use WeDevs\MigrateToDokan\Admin\Migrators\WCFM_Migrator;

class Migrator_Manager {
    
    /**
     * Get the migrator instance
     *
     * @return Migrator_Interface;
     */
    public static function get_migrator() {
        return new WCFM_Migrator();
    }
}
