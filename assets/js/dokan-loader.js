var DokanMigrator = {
	init: function() {
		this.bindEvents();
	},
	bindEvents: function() {
		var self = this;

		$('#start-migration').click(function() {

			window.onbeforeunload = self.confirmReload;

			self.migrateVendor();
		});
	},
	confirmReload: function(event) {
		return confirm("Confirm refresh");
	},
	migrateVendor: function() {
		this.showMessage('Migrating vendor, please wait..')

		this.migrateData(vendorUrl, this.migrateRefund.bind(this));
	},
	migrateRefund: function() {
		this.showMessage('Vendor migration complete', 'success')
		this.showMessage('Migrating refund, please wait..')
		
		this.migrateData(refundUrl, this.migrateWithdraw.bind(this));
	},
	migrateWithdraw: function() {
		var self = this;
		this.showMessage('Refund migration complete', 'success')
		this.showMessage('Migrating withdraw, please wait..')

		self.migrateData(withdrawUrl, self.migrateOrder.bind(self))
	},
	migrateOrder: function() {
		this.showMessage('Withdraw migration complete', 'success')
		this.showMessage(' Migrating order <span class="success" id="order-progress">0%</span>, please wait..')
		this.migrateOrderByPage(1);
	},
	migrateOrderByPage: function(page) {
		page = page || 1;

		var self = this;

		$.get(orderUrl + '?page=' + page, function(response) {
			var total = response.total;
			var page_total = response.per_page * response.current_page;
			if (page_total > total) {
				page_total = total;
			}
			var percent =  (page_total || 1) / (total || 1) * 100;

			$(document).find('#order-progress').text(percent + '%')
			if (response.next_page  && response.next_page > 0) {
				self.migrateOrderByPage(response.next_page);
			} else {
				self.onMigrationSuccess()
			}
		})
		.fail(function(error) {
			console.log(error.responseText);
			$('#success').html(error.responseText);
		});
	},

	showMessage: function(msg, styleClass) {
		styleClass = styleClass || ''
		$('#success').append('<li class="' + styleClass +'">' + msg +'</li>')

	},
	onMigrationSuccess: function() {
		this.showMessage('Order migration complete', 'success')
		// alert('Migrate Order')
		window.onbeforeunload = null;
		setTimeout( function() {
			$('#migration-success').trigger('click');
			$('#step-2,#step-1').hide(200);
			$('#step-3').show(300);
		}, 3000);
	},
	migrateData: function(url, callback) {
		$.get(url, function(response) {
			console.log('Success');
			if (callback) {
				callback();
			}
		})
		.fail(function(error) {
			console.log(error.responseText);
			$('#success').html(error.responseText);
		});
	}
}

DokanMigrator.init();