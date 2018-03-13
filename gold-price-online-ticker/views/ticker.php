<div class="gplt ticker-region">
	<div class="gplt ticker">
		<ul class="newsticker" id="gplt_ticker">
			<li>999er  (24,0 kt)  Feingold  <span id="gplt_ticker_gp999"><?= number_format($price['gold'][999], 2, ',', '') ?> €/g</span></li>
			<li>916er  (22,0 kt)  Gold  <span id="gplt_ticker_gp916"><?= number_format($price['gold'][916], 2, ',', '') ?> €/g</span></li>
			<li>900er  (21,0 kt)  Gold  <span id="gplt_ticker_gp900"><?= number_format($price['gold'][900], 2, ',', '') ?> €/g</span></li>
			<li>750er  (18,0 kt)  Gold  <span id="gplt_ticker_gp750"><?= number_format($price['gold'][750], 2, ',', '') ?> €/g</span></li>
			<li>585er  (14,0 kt)  Gold  <span id="gplt_ticker_gp585"><?= number_format($price['gold'][585], 2, ',', '') ?> €/g</span></li>
			<li>333er  (8,0 kt)  Gold  <span id="gplt_ticker_gp333"><?= number_format($price['gold'][333], 2, ',', '') ?> €/g</span></li>
			<li>999er  Silber  <span id="gplt_ticker_sp999"><?= number_format($price['silver'][999], 2, ',', '') ?> €/g</span></li>
			<li>925er  Silber  <span id="gplt_ticker_sp925"><?= number_format($price['silver'][925], 2, ',', '') ?> €/g</span></li>
			<li>900er  Silber  <span id="gplt_ticker_sp900"><?= number_format($price['silver'][900], 2, ',', '') ?> €/g</span></li>
			<li>800er  Silber  <span id="gplt_ticker_sp800"><?= number_format($price['silver'][800], 2, ',', '') ?> €/g</span></li>
		</ul>
		<span class="tickeroverlay-left">&nbsp;</span>
		<span class="tickeroverlay-right">&nbsp;</span>
	</div>
</div>
<script type="text/javascript">
jQuery(function() {
	gplt.init("<?= admin_url('admin-ajax.php')?>", <?= $interval ?>, <?= json_encode($price) ?>);
	gplt.on_update(gpltux.ticker_update);
	gplt.start();
	jQuery('#gplt_ticker').webTicker();
});
</script>