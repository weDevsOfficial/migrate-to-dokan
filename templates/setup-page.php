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

                        <section id='step-1'>
                            <div class="card-section">

                                <?php 
                                    $wcfm_migrator = new WeDevs\MigrateToDokan\Admin\Migrators\WCFM_Migrator();
                                ?>
                                <p><strong>Product: <?php echo $wcfm_migrator->get_statistics()['total_products']; ?></strong></p>
                                <p><strong>Vendor: <?php echo $wcfm_migrator->get_statistics()['total_vendors']; ?></strong></p>
                                <p><strong>Order: </strong></p>
                                <p>Please <a href=""><strong>Backup</strong></a> Your Database.</p>
                            </div> 
                            <!-- <div class="btn-group"> -->
                                <button id="start-migration" class="next action-button">Start Migration</button>
                            <!-- </div> -->
                        </section>

                        <section id="step-2">
                            <div class="card-section">
                                <ul id="success">

                                </ul>
                            </div> 
                            <div class="btn-group">
                                <span id="migration-success" class="next"></span>
                            </div>
                        </section>

                        <section id="step-3">
                            <div class="card-section" style="margin-bottom: 50px;">
                                <h2 style="text-align:center">
                                <span class="success"> Congratulation! </span>You have successfully migrated to Dokan</h2>
                            </div>
                            <a href="<?php echo admin_url(); ?>" class="action-button">Go to Dashboard</a>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var vendorUrl = "<?php echo home_url( 'wp-json/migrate-to-dokan/v1/vendor' ); ?>";
        var orderUrl    = "<?php echo home_url( 'wp-json/migrate-to-dokan/v1/order' ); ?>";
        var refundUrl   = "<?php echo home_url( 'wp-json/migrate-to-dokan/v1/refund' ); ?>";
        var withdrawUrl   = "<?php echo home_url( 'wp-json/migrate-to-dokan/v1/withdraw' ); ?>";
    </script>
    <script src="<?php echo MIGRATE_TO_DOKAN_PLUGIN_ASSEST . '/js/dokan-loader.js'; ?>"></script>
</body>
</html>