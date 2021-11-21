<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'admin';
    $DATABASE_PASS = 'admin';
    $DATABASE_NAME = 'laravel';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
function template_header($title) {
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">Website Title</a>
					<p class="navbar-text navbar-right">
					<a href="index.php"><img src="assets/icons/house-door-fill.svg" alt="Home"/></a>
					<a href="read.php"><img src="assets/icons/person-badge.svg" alt="Contact"/></a>
					<a href="image.php"><img src="assets/icons/images.svg" alt="Contact"/></a>
					<a href="news.php"><img src="assets/icons/newspaper.svg" alt="Contact"/></a>
					</p>
				</div>
			</div>
		</nav>

		<div class="container-fluid">
EOT;
}
function template_footer() {
echo <<<EOT
		</div>
		<script src="assets/jquery/jquery.min.js" defer></script>
		<script src="assets/js/bootstrap.min.js" defer></script>
    </body>
</html>
EOT;
}
?>