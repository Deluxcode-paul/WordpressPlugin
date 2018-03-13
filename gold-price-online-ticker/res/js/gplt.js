var gplt_running = false;
var gplt = {
	_server: null,
	_interval: 60,
	_price: null, 
	
	init: function(server, interval, price) {
		gplt._server = server;
		gplt._interval = interval;
		gplt._price = price;
	},

	_handlers: [],
	on_update: function(handler) {
		if (jQuery.inArray(handler, gplt._handlers) == -1)
			gplt._handlers.push(handler);
	},

	start: function() {
		if (gplt_running)
			return;
		gplt_running = true;
		gplt._restart(1);
	},

	get: function(key, purity) {
		if (!gplt._price || !gplt._price[key])
			return 0;
		if (gplt._price[key][purity])
			return gplt._price[key][purity];
		if (gplt._price[key][999])
			return gplt._price[key][999] * (purity / 999.0);
		return 0;
	},

	_update: function() {
		console.log('Started to update latest price');
		jQuery.ajax({
			url: gplt._server,
			data: { action: 'gplt_latest_price' },
			success: gplt._on_succeeded,
			error: gplt._on_failed,
		});
	},

	_on_succeeded: function(response) {
		var data = {};
		try {
			data = JSON.parse(response);
			if (!data.success) {
				gplt._restart(2);
				return;
			}
		} catch (e) {
			console.log(e);
			gplt._restart(2);
			return;
		}
		
		gplt._interval = data.interval;
		gplt._price = data.price;
		gplt._handlers.forEach(function(handler) {
			handler();
		});
		gplt._restart(1);
	},

	_on_failed: function(XMLHttpRequest, textStatus, errorThrown) {
		console.log(textStatus);
		console.log(errorThrown);
		gplt._restart(3);
	},

	_restart: function(x) {
		console.log('Update will be restarted in ' + gplt._interval + ' seconds');
		setTimeout(gplt._update, gplt._interval * 1000);
	},

	assays: function(metal) {
		if (metal == 'silver')
			return [999, 925, 900, 835, 800, 700, 625];
		else if (metal == 'platinum')
			return [999, 950, 750];
		else if (metal == 'palladium')
			return [999, 950, 500];
		else
			return [999, 916, 900, 750, 585, 333];
	}
};

var gplt_format = function(price, decimal_point, prefix, suffix) {
	if (decimal_point == undefined)
		decimal_point = '.';
	return prefix + price.toFixed(2).replace('.', decimal_point) + suffix;
};
