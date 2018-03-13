<div class="gplt gold">
	<h3>Goldkurs</h3>
	<p>Aktuelle Ankaufspreise für Geschäftskunden</p>
	<ul>
		<li>999er  (24 kt)  <span id="gplt_gold_gp999"><?= number_format($price['gold'][999], 2, ',', '') ?> €/g</span></li>
		<li>916er  (22 kt)  <span id="gplt_gold_gp916"><?= number_format($price['gold'][916], 2, ',', '') ?> €/g</span></li>
		<li>900er  (21 kt)  <span id="gplt_gold_gp900"><?= number_format($price['gold'][900], 2, ',', '') ?> €/g</span></li>
		<li>750er  (18 kt)  <span id="gplt_gold_gp750"><?= number_format($price['gold'][750], 2, ',', '') ?> €/g</span></li>
		<li>585er  (14 kt)  <span id="gplt_gold_gp585"><?= number_format($price['gold'][585], 2, ',', '') ?> €/g</span></li>
		<li>333er  (8 kt)   <span id="gplt_gold_gp333"><?= number_format($price['gold'][333], 2, ',', '') ?> €/g</span></li>
	</ul>
</div>
<script type="text/javascript">
jQuery(function() {
	gplt.init("<?= admin_url('admin-ajax.php')?>", <?= $interval ?>, <?= json_encode($price) ?>);
	gplt.on_update(gpltux.gold_update);
	gplt.start();
});
</script>