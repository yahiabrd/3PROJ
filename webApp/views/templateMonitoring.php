<!DOCTYPE html>
<html>
<head>
	<title><?= $t; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="<?=URL?>views/images/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="<?=URL?>views/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=URL?>views/css/monitoring.css">
</head>
<body>
	<div class="sidenav">
		<a href="<?=URL?>Monitoring/1">Statistics</a>
		<a href="<?=URL?>Monitoring/2">Users data</a>
		<a href="<?=URL?>Monitoring/3">Attack analysis</a>
		<a href="<?=URL?>Monitoring/4">Backup</a>
	</div>

	<div class="main">
		<div class="container">
			<h2>Monitoring - 3PROJ</h2>
			<?= $content; ?>
		</div>
	</div>
</body>
</html> 
