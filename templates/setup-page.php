<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="<?php echo MIGRATE_TO_DOKAN_PLUGIN_ASSEST . '/css/style.css'; ?>">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
	<script type="text/javascript" src="<?php echo MIGRATE_TO_DOKAN_PLUGIN_ASSEST . '/js/main.js'; ?>"></script>
    <style>
        
    </style>
</head>
<body>
	<div class="container">
        <div class="setup-wizard">
            <div class="row">
                <div class="card pt-4 pb-0 mt-3 mb-3">
                    <div class="migrate-to-dokan">
                        <ul id="progressbar">
                            <li class="active" id="setup"><strong>Setup</strong></li>
                            <li id="migrate"><strong>Migrate</strong></li>
                            <li id="complete"><strong>Complete</strong></li>
                        </ul>

                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                        </div><br>

                        <section>
                            <div class="card-section">
                                <p><strong>Product: </strong></p>
                                <p><strong>Vendor: </strong></p>
                                <p><strong>Order: </strong></p>
                                <p>Please <a href=""><strong>Backup</strong></a> Your Database.</p>
                            </div> 
                            <!-- <div class="btn-group"> -->
                                <button class="next action-button">Next</button>
                            <!-- </div> -->
                        </section>

                        <section>
                            <div class="card-section">
                                <form action="">
                                    <p><input type="checkbox"> I have taken Database Backup.</p>
                                </form>
                            </div> 
                            <div class="btn-group">
                                <button class="previous action-button-previous">Previous</button>
                                <button class="next action-button">Next</button>
                            </div>
                        </section>

                        <section>
                            <div class="card-section">
                                <strong>Success Message</strong>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 
        // $migrator = new WeDevs\MigrateToDokan\REST\Manager();
        // $migration_start = $migrator->migration_start();

    ?>
    <script>
        // var vendor   = "<?php //echo $vendor->data; ?>";
        var order    = "<?php echo home_url( 'wp-json/migrate-to-dokan/v1/order' ); ?>";
        var refund   = "<?php echo home_url( 'wp-json/migrate-to-dokan/v1/refund' ); ?>";
        var migrateUrl = "<?php echo home_url( 'wp-json/migrate-to-dokan/v1/start-migration' ); ?>";
        var url      = "<?php echo admin_url( 'admin.php?page=migrate-to-dokan' ); ?>"
    </script>
    <script src="<?php echo MIGRATE_TO_DOKAN_PLUGIN_ASSEST . '/js/dokan-loader.js'; ?>"></script>
</body>
</html>