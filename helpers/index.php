<?php

if (! function_exists( 'migrate_to_dokan_get_vendors' ) ) {
    function migrate_to_dokan_get_vendors( $roles = [] ) {
        $vendors = [];

        if (! count( $roles ) ) {
            $roles = [
                'wcfm_vendor',
                'disable_vendor', //wcfm disabled vendors
            ];
        }
        // var_dump( $roles);
        $args = [
            'role__in'   => $roles,
            // 'number'     => 10,
            // 'offset'     => 0,
            'orderby'    => 'registered',
            'order'      => 'ASC',
            'status'     => 'approved',
            'featured'   => '', // yes or no
            'meta_query' => [],
        ];

        $user_query = new WP_User_Query( $args );
        $vendors    = $user_query->get_results();

        return $vendors;
    }
}