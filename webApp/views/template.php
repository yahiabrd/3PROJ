<!DOCTYPE html>
<html>
<head>
	<title><?= $t; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="<?=URL?>views/images/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="<?=URL?>views/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=URL?>views/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?=URL?>views/css/responsive.css">
</head>
	<body>
		<header>
			<nav class="navbar navbar-expand-lg navbar-light bg-primary">
			 	<div class="container">
			    	<a class="navbar-brand" style="color:white;" href="<?=URL?>">Home</a>
			    	<a class="navbar-brand" style="color:white;float: right;" href="<?=URL?>Monitoring">Monitoring</a>
				</div>
			</nav>
		</header>

		<div class="container">
			<div id="main">
				<?= $content; ?>
			</div>

			<div id="closed">
				
			</div>
		</div>

		<footer class="page-footer font-small bg-primary">
			<div class="footer-copyright text-center py-3 colorWhite">
				&copy; 2020 - Berrada Yahia
			</div>
		</footer>

		<script src="<?=URL?>views/js/jquery.min.js"></script>
		<script src="<?=URL?>views/js/clientWeb.js"></script>
	</body>
</html>