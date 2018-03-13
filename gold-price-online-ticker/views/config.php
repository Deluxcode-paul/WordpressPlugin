<link type="text/css" rel="stylesheet" href="<?= plugins_url('res/css/config.css', dirname(__FILE__)) ?>">
<div class="wrap">
	<h2>Gold Price Live Ticker</h2>
	<hr>
	<form action="<?= esc_url(GpltAdmin::get_page_url()) ?>" method="POST">
		<table cellspacing="0" class="form-table">
			<tr>
				<th>
					<label for="price_feed_link">Gold price feed link</label>
				</th>
				<td align="left">
					<input name="price_feed_link" id="price_feed_link" type="url" class="regular-text code" value="<?= $price_feed_link ?>">
				</td>
			</tr>
			<tr>
				<th>
					<label for="update_interval">Update interval</label>
				</th>
				<td>
					<select name="update_interval" id="update_interval">
						<?php foreach ($update_interval_options as $int => $desc) : ?>
						<option value="<?= $int ?>" <?= ($int == $update_interval) ? 'selected="selected"' : "" ?>><?= $desc ?></option>
						<?php endforeach ?>
					</select>
				</td>
			</tr>
			<tr>
				<th>
					<label>Gold price adjustment</label>
				</th>
				<td>
					<table class="gplt-fieldset">
						<tr class="header">
							<td>
								<label>
									<input type="radio" name="price_adjustment[gold][way]" value="percent" <?= ($price_adjustment['gold']['way'] == 'percent') ? 'checked' : "" ?>>
									<span>Based on percent</span>
								</label>
							</td>
							<td class="narrow"></td>
							<td>
								<label>
									<input type="radio" name="price_adjustment[gold][way]" value="override" <?= ($price_adjustment['gold']['way'] == 'override') ? 'checked' : "" ?>>
									<span>Override original price</span>
								</label>
							</td>
						</tr>
						<?php foreach ($purities['gold'] as $purity) : ?>
						<tr>
							<td><input type="number" step="0.1" min="0" name="price_adjustment[gold][percent][<?= $purity ?>]" value="<?= $price_adjustment['gold']['percent'][$purity] ?>" class="small-text price-adjustment">%</td>
							<td class="narrow"><?= $purity ?>er</td>
							<td><input type="number" step="0.1" min="0" name="price_adjustment[gold][override][<?= $purity ?>]" value="<?= $price_adjustment['gold']['override'][$purity] ?>" class="small-text price-adjustment"></td>
						</tr>
						<?php endforeach; ?>
					</table>
				</td>
			</tr>
			<tr>
				<th>
					<label>Silber price adjustment</label>
				</th>
				<td>
					<table class="gplt-fieldset">
						<tr class="header">
							<td>
								<label>
									<input type="radio" name="price_adjustment[silver][way]" value="percent" <?= ($price_adjustment['silver']['way'] == 'percent') ? 'checked' : "" ?>>
									<span>Based on percent</span>
								</label>
							</td>
							<td class="narrow"></td>
							<td>
								<label>
									<input type="radio" name="price_adjustment[silver][way]" value="override" <?= ($price_adjustment['silver']['way'] == 'override') ? 'checked' : "" ?>>
									<span>Override original price</span>
								</label>
							</td>
						</tr>
						<?php foreach ($purities['silver'] as $purity) : ?>
						<tr>
							<td><input type="number" step="0.1" min="0" name="price_adjustment[silver][percent][<?= $purity ?>]" value="<?= $price_adjustment['silver']['percent'][$purity] ?>" class="small-text price-adjustment">%</td>
							<td class="narrow"><?= $purity ?>er</td>
							<td><input type="number" step="0.1" min="0" name="price_adjustment[silver][override][<?= $purity ?>]" value="<?= $price_adjustment['silver']['override'][$purity] ?>" class="small-text price-adjustment"></td>
						</tr>
						<?php endforeach; ?>
					</table>
				</td>
			</tr>
			<tr>
				<th>
					<label>Platin price adjustment</label>
				</th>
				<td>
					<table class="gplt-fieldset">
						<tr class="header">
							<td>
								<label>
									<input type="radio" name="price_adjustment[platinum][way]" value="percent" <?= ($price_adjustment['platinum']['way'] == 'percent') ? 'checked' : "" ?>>
									<span>Based on percent</span>
								</label>
							</td>
							<td class="narrow"></td>
							<td>
								<label>
									<input type="radio" name="price_adjustment[platinum][way]" value="override" <?= ($price_adjustment['platinum']['way'] == 'override') ? 'checked' : "" ?>>
									<span>Override original price</span>
								</label>
							</td>
						</tr>
						<?php foreach ($purities['platinum'] as $purity) : ?>
						<tr>
							<td><input type="number" step="0.1" min="0" name="price_adjustment[platinum][percent][<?= $purity ?>]" value="<?= $price_adjustment['platinum']['percent'][$purity] ?>" class="small-text price-adjustment">%</td>
							<td class="narrow"><?= $purity ?>er</td>
							<td><input type="number" step="0.1" min="0" name="price_adjustment[platinum][override][<?= $purity ?>]" value="<?= $price_adjustment['platinum']['override'][$purity] ?>" class="small-text price-adjustment"></td>
						</tr>
						<?php endforeach; ?>
					</table>
				</td>
			</tr>
			<tr>
				<th>
					<label>Palladium price adjustment</label>
				</th>
				<td>
					<table class="gplt-fieldset">
						<tr class="header">
							<td>
								<label>
									<input type="radio" name="price_adjustment[palladium][way]" value="percent" <?= ($price_adjustment['palladium']['way'] == 'percent') ? 'checked' : "" ?>>
									<span>Based on percent</span>
								</label>
							</td>
							<td class="narrow"></td>
							<td>
								<label>
									<input type="radio" name="price_adjustment[palladium][way]" value="override" <?= ($price_adjustment['palladium']['way'] == 'override') ? 'checked' : "" ?>>
									<span>Override original price</span>
								</label>
							</td>
						</tr>
						<?php foreach ($purities['palladium'] as $purity) : ?>
						<tr>
							<td><input type="number" step="0.1" min="0" name="price_adjustment[palladium][percent][<?= $purity ?>]" value="<?= $price_adjustment['palladium']['percent'][$purity] ?>" class="small-text price-adjustment">%</td>
							<td class="narrow"><?= $purity ?>er</td>
							<td><input type="number" step="0.1" min="0" name="price_adjustment[palladium][override][<?= $purity ?>]" value="<?= $price_adjustment['palladium']['override'][$purity] ?>" class="small-text price-adjustment"></td>
						</tr>
						<?php endforeach; ?>
					</table>
				</td>
			</tr>
		</table>
		<hr>
		<button type="submit" class="button button-primary right">Save Changes</button>
	</form>
</div>