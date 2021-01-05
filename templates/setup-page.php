<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="<?php echo MIGRATE_TO_DOKAN_PLUGIN_ASSEST . '/css/style.css'; ?>">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
	<script type="text/javascript" src="<?php echo MIGRATE_TO_DOKAN_PLUGIN_ASSEST . '/js/main.js'; ?>"></script>
</head>
<body>
	<div class="container">
    	<div class="row">
            <div class="card col-md-10 pt-4 pb-0 mt-3 mb-3">
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
                            <p><strong>Product:</strong></p>
                            <p><strong>Vendor:</strong></p>
                            <p><strong>Order:</strong></p>
                            <p>Please <a href=""><strong>Backup</strong></a> Your Database.</p>
                        </div> 

                        <button class="next action-button">Next</button>
                    </section>

                    <section>
                        <div class="card-section">
                            <form action="">
                            	<p><input type="checkbox"> I have taken Database Backup.</p>
                            	<p><input type="button" value="Migrate"></p>
                            </form>
                        </div> 

                        <button class="next action-button">Next</button>
                        <button class="previous action-button-previous">Previous</button>
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
</body>
</html>