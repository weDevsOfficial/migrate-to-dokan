$(document).ready(function() {
	$('#start-migration').click(function() {
		migrateData(url);
		// migrateData(orderUrl);
		// migrateData(refundUrl);
	});

	function migrateData(url) {
		return $.get({
        	url: url,
        	success:function(response) {
	          	console.log(response.responseText);
	          	$('#success').html(response.responseText);
        	},
        	error:function(error) {
        		console.log(error.responseText);
	          	$('#success').html(error.responseText);
        	}
       });
	}
})