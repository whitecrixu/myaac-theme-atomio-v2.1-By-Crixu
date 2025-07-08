<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<style>
	.smedia {
		display: flex;
		justify-content: center;
		align-items: center;
		gap: 20px;
		padding: 10px 0;
	}

	.smedia a {
		color: #fff;
		font-size: 24px;
		transition: color 0.3s ease;
	}

	.smedia a:hover {
		color: #1e90ff;
	}
</style>

<div class="well widget">
	<div class="header">
		<h3 style="margin: 0; color: #fff;">Follow Us</h3>
	</div>
	<div class="body">
		<div class="smedia">
			<a href="<?= config('follow_facebook') ?>" target="_blank" aria-label="Facebook">
				<i class="fa fa-facebook"></i>
			</a>
			<a href="<?= config('follow_twitter') ?>" target="_blank" aria-label="Twitter">
				<i class="fa fa-twitter"></i>
			</a>
			<a href="<?= config('follow_youtube') ?>" target="_blank" aria-label="YouTube">
				<i class="fa fa-youtube"></i>
			</a>
			<a href="<?= config('follow_twitch') ?>" target="_blank" aria-label="Twitch">
				<i class="fa fa-twitch"></i>
			</a>
		</div>
	</div>
</div>
