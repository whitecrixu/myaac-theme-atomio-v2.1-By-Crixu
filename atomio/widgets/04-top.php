<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<div class="well widget">
	<div class="header">
		<h3 style="margin: 0; color: #fff;">Top Players</h3>
	</div>
	<div class="body">
		<table class="table-100">
			<?php
			$i = 0;
			foreach (getTopPlayers(5) as $player) {
				?>
				<tr>
					<td><?= ++$i; ?>.</td>
					<td><?= getPlayerLink($player['name']); ?> (<?= $player['level']; ?>)</td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>
