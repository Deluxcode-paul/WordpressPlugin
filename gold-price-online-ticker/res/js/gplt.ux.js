var gpltux = {

	gold_update: function() {
		jQuery('[id=gplt_gold_gp999]').text(gplt_format(gplt.get('gold', 999), ',', '', ' €/g'));
		jQuery('[id=gplt_gold_gp916]').text(gplt_format(gplt.get('gold', 916), ',', '', ' €/g'));
		jQuery('[id=gplt_gold_gp900]').text(gplt_format(gplt.get('gold', 900), ',', '', ' €/g'));
		jQuery('[id=gplt_gold_gp750]').text(gplt_format(gplt.get('gold', 750), ',', '', ' €/g'));
		jQuery('[id=gplt_gold_gp585]').text(gplt_format(gplt.get('gold', 585), ',', '', ' €/g'));
		jQuery('[id=gplt_gold_gp333]').text(gplt_format(gplt.get('gold', 333), ',', '', ' €/g'));
	},

	ticker_update: function() {
		jQuery('[id=gplt_ticker_gp999]').text(gplt_format(gplt.get('gold', 999), ',', '', ' €/g'));
		jQuery('[id=gplt_ticker_gp916]').text(gplt_format(gplt.get('gold', 916), ',', '', ' €/g'));
		jQuery('[id=gplt_ticker_gp900]').text(gplt_format(gplt.get('gold', 900), ',', '', ' €/g'));
		jQuery('[id=gplt_ticker_gp750]').text(gplt_format(gplt.get('gold', 750), ',', '', ' €/g'));
		jQuery('[id=gplt_ticker_gp585]').text(gplt_format(gplt.get('gold', 585), ',', '', ' €/g'));
		jQuery('[id=gplt_ticker_gp333]').text(gplt_format(gplt.get('gold', 333), ',', '', ' €/g'));
		jQuery('[id=gplt_ticker_sp999]').text(gplt_format(gplt.get('silver', 999), ',', '', ' €/g'));
		jQuery('[id=gplt_ticker_sp925]').text(gplt_format(gplt.get('silver', 925), ',', '', ' €/g'));
		jQuery('[id=gplt_ticker_sp900]').text(gplt_format(gplt.get('silver', 900), ',', '', ' €/g'));
		jQuery('[id=gplt_ticker_sp800]').text(gplt_format(gplt.get('silver', 800), ',', '', ' €/g'));
	},

	scalc_bind: function() {
		jQuery('#gplt_calc_metal').keyup(gpltux.scalc_on_metal);
		jQuery('#gplt_calc_metal').change(gpltux.scalc_on_metal);
		jQuery('#gplt_calc_assay').keyup(gpltux.scalc_update);
		jQuery('#gplt_calc_assay').change(gpltux.scalc_update);
		jQuery('#gplt_calc_weight').keyup(gpltux.scalc_update);
		jQuery('#gplt_calc_weight').change(gpltux.scalc_update);
	},

	scalc_update: function() {
		var metal  = jQuery('#gplt_calc_metal').val();
		var assay  = jQuery('#gplt_calc_assay').val();
		var weight = jQuery('#gplt_calc_weight').val();
		var result = gplt.get(metal, assay) * weight;
		jQuery('#gplt_calc_result').html(gplt_format(result, '.', '', ' €'));
	},

	__old_metal: 'gold',
	scalc_on_metal: function() {
		var metal = jQuery('#gplt_calc_metal').val();
		if (metal == gpltux.__old_metal)
			return;
		
		var assays = gplt.assays(metal); 
		{
			var assay = jQuery('#gplt_calc_assay').val();
			if (jQuery.inArray(parseInt(assay), assays) == -1)
				assay = assays[0];
			jQuery('#gplt_calc_assay').find('option').remove().end();
			jQuery.each(assays, function(i, v) {
				jQuery('#gplt_calc_assay').append(
					jQuery('<option/>')
						.attr('value', v)
						.text(v + 'er'));
			});
			jQuery('#gplt_calc_assay').val(assay);
			jcf.refresh('#gplt_calc_assay');
		}

		gpltux.__old_metal = metal;
		gpltux.scalc_update();
	},

	xcalc_bind: function() {
		jQuery('#gplt_xcalc_gp999').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_gp999').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_gp916').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_gp916').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_gp900').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_gp900').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_gp750').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_gp750').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_gp585').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_gp585').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_gp333').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_gp333').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_sp999').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_sp999').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_sp925').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_sp925').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_sp900').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_sp900').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_sp835').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_sp835').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_sp800').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_sp800').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_sp700').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_sp700').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_sp625').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_sp625').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_tp999').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_tp999').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_tp950').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_tp950').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_tp750').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_tp750').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_pp999').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_pp999').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_pp950').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_pp950').change(gpltux.xcalc_update);
		jQuery('#gplt_xcalc_pp500').keyup(gpltux.xcalc_update);	jQuery('#gplt_xcalc_pp500').change(gpltux.xcalc_update);
		
		jQuery('#gplt_xcalc_open').click(function() {
	        jQuery('#gplt_scalc').toggle();
	        jQuery('#gplt_xcalc').toggle();
        });
        jQuery('#gplt_xcalc_close').click(function() {
	        jQuery('#gplt_scalc').toggle();
	        jQuery('#gplt_xcalc').toggle();
        });
	},

	xcalc_update: function() {
		var result = gplt.get('gold', 999) * jQuery('#gplt_xcalc_gp999').val()
				   + gplt.get('gold', 916) * jQuery('#gplt_xcalc_gp916').val()
				   + gplt.get('gold', 900) * jQuery('#gplt_xcalc_gp900').val()
				   + gplt.get('gold', 750) * jQuery('#gplt_xcalc_gp750').val()
				   + gplt.get('gold', 585) * jQuery('#gplt_xcalc_gp585').val()
				   + gplt.get('gold', 333) * jQuery('#gplt_xcalc_gp333').val()
				   + gplt.get('silver', 999) * jQuery('#gplt_xcalc_sp999').val()
				   + gplt.get('silver', 925) * jQuery('#gplt_xcalc_sp925').val()
				   + gplt.get('silver', 900) * jQuery('#gplt_xcalc_sp900').val()
				   + gplt.get('silver', 835) * jQuery('#gplt_xcalc_sp835').val()
				   + gplt.get('silver', 800) * jQuery('#gplt_xcalc_sp800').val()
				   + gplt.get('silver', 700) * jQuery('#gplt_xcalc_sp700').val()
				   + gplt.get('silver', 625) * jQuery('#gplt_xcalc_sp625').val()
				   + gplt.get('platinum', 999) * jQuery('#gplt_xcalc_tp999').val()
				   + gplt.get('platinum', 950) * jQuery('#gplt_xcalc_tp950').val()
				   + gplt.get('platinum', 750) * jQuery('#gplt_xcalc_tp750').val()
				   + gplt.get('palladium', 999) * jQuery('#gplt_xcalc_pp999').val()
				   + gplt.get('palladium', 950) * jQuery('#gplt_xcalc_pp950').val()
				   + gplt.get('palladium', 500) * jQuery('#gplt_xcalc_pp500').val();
		jQuery('#gplt_xcalc_result').html(gplt_format(result, '.', '', ' €'));
	},

};