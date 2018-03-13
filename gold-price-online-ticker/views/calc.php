<div class="gplt calc">
	<div class="grid padding">
		<div class="v320-1 v320-1">
			<p><span class="mobile-hide">Schneller</span> Goldrechner</p>
		</div>
		<div class="v320-1 v768-1-of-2">
			<select class="gray form-select jcf-hidden" id="gplt_calc_metal" data-jcf='{"wrapNative": false, "wrapNativeOnMobile": false}'>
				<option value="gold">GOLD</option>
				<option value="silver">SILBER</option>
				<option value="platinum">PLATIN</option>
				<option value="palladium">PALLADIUM</option>
			</select>
		</div>
		<p class="v320-1 v768-1-of-2">
			<select class="gray form-select jcf-hidden" id="gplt_calc_assay" data-jcf='{"wrapNative": false, "wrapNativeOnMobile": false}'>
				<option value="999">999er</option>
				<option value="916">916er</option>
				<option value="900">900er</option>
				<option value="750">750er</option>
				<option value="585">585er</option>
				<option value="333">333er</option>
			</select>
		</p>

		<p class="v320-1 v768-1-of-2">
			<label class="relative" style="display: inline-block; width: 100%; height: 100%">
				<input class="gray quantity form-text" type="number" id="gplt_calc_weight" value="" size="60" maxlength="128" placeholder="Gramm angeben">
			</label>
		</p>

		<div class="v320-1 v768-1-of-2">
			<p class="fake-input result-price" id="gplt_calc_result">SUMME<span>*</span></p>
		</div>

		<div class="v320-1 v768-1">
			<div class="grid padding rtl">
				<div class="v320-1 v768-1 v1024-1-of-2">
					<button class="button secondary block text-center" type="button" id="gplt_calc_button">Goldwert Berechnen</button>
				</div>

				<div class="v320-1 v768-1 v1024-1-of-2">
					<p class="small">
						<span>*</span> Dieser Wert kann bis zur richtigen Auswertung abweichen.
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(function() {
	gplt.init("<?= admin_url('admin-ajax.php')?>", <?= $interval ?>, <?= json_encode($price) ?>);
	gplt.on_update(gpltux.scalc_update);
	gplt.start();
	gpltux.scalc_bind();
});
</script>