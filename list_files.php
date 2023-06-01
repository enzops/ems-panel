<?php
require "config/limited.php";
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<title>Hopital de Viceroy - Home</title>
	<link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

	<!-- Include our stylesheet -->
	<link href="assets/css/styles.css" rel="stylesheet"/>
	<?php include 'inc/head.php'; ?>
</head>
<body>
<?php include 'inc/navbar.php'; ?>
<div class="container-xl mb-4">
	<div class="filemanager">

		<div class="search">
			<input type="search" placeholder="Find a file.." />
		</div>

		<div class="breadcrumbs"></div>

		<ul class="data"></ul>

		<div class="nothingfound">
			<div class="nofiles"></div>
			<span>Aucun fichier ici.</span>
		</div>

	</div>

	<footer>
        <!-- <a class="tz" href="http://tutorialzine.com/2014/09/cute-file-browser-jquery-ajax-php/">Cute File Browser with jQuery, AJAX and PHP</a>
        <div id="tzine-actions"></div>
        <span class="close"></span> -->
    </footer>

	<!-- Include our script files -->
	<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="assets/js/script.js"></script>
</div>
<footer class="footer mt-auto py-3 bg-dark">
    <div class="container">
        <span class="text-muted">@ Wqnted</span>
    </div>
</footer>
</body>
</html>