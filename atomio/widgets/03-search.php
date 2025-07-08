<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<style>
	.widget {
		text-align: center;
	}
	.searchForm .form-container {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		gap: 10px;
		padding: 20px;
	}
	.searchForm input[type="text"] {
		padding: 8px;
		width: 100%;
		max-width: 300px;
		border: 1px solid #ccc;
		border-radius: 4px;
	}
	.searchForm input[type="submit"] {
		background-color: #007bff;
		color: white;
		border: none;
		padding: 10px 20px;
		border-radius: 4px;
		cursor: pointer;
		transition: background-color 0.3s ease;
	}
	.searchForm input[type="submit"]:hover {
		background-color: #0056b3;
	}
</style>

<div class="well widget">
	<div class="header">
		<a href="<?= getLink('characters') ?>">Search</a>
	</div>
	<div class="body">
		<form class="searchForm" action="<?= getLink('characters') ?>" method="post">
			<div class="well form-container">
				<input type="text" name="name" placeholder="e.g: John Sheppard">
				<input type="submit" value="Search">
			</div>
		</form>
	</div>
</div>
