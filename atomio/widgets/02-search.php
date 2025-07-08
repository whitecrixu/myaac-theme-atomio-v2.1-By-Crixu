<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<style>
	/* Styl głównego kontenera widgetu */
	.widget {
		text-align: center;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		margin: 0 auto;
		max-width: 100%;
	}

	/* Styl całego boxa widgetu */
	.well.widget {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		padding: 20px 0;
	}

	/* Styl formularza wyszukiwania */
	.searchForm .form-container {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		gap: 10px;
		padding: 20px;
		background-color: #1e1e1e;
		border: 1px solid #333;
		border-radius: 8px;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.4);
	}

	.searchForm input[type="text"] {
		padding: 8px;
		width: 100%;
		max-width: 300px;
		border: 1px solid #ccc;
		border-radius: 4px;
		background-color: #2b2b2b;
		color: #fff;
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
		<h3 style="margin: 0; color: #fff;">Search Player</h3>
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
