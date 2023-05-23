<?php
function template_header($title) {
$dir_prefix = isset($GLOBALS['is_dir_prefix']) && $GLOBALS['is_dir_prefix'];
$assets = $dir_prefix?'../assets':'assets';
$index = $dir_prefix?'../index.php':'index.php';
$image = $dir_prefix?'../image.php':'image.php';
$news = $dir_prefix?'../news.php':'news.php';
$mysql = $dir_prefix?'../mysql':'mysql';
$sqlite = $dir_prefix?'../sqlite':'sqlite';
// echo '<script>console.log('.json_encode(isset($is_dir_prefix) && $is_dir_prefix, JSON_HEX_TAG).');</script>';;
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="$assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">Website Title</a>
					<p class="navbar-text navbar-right">
					<a href="$index"><img src="$assets/icons/house-door-fill.svg" alt="Home"/></a>
					<a href="$image"><img src="$assets/icons/images.svg" alt="Contact"/></a>
					<a href="$news"><img src="$assets/icons/newspaper.svg" alt="Contact"/></a>
					<a href="$mysql"><img src="$assets/icons/mysql-icon.svg" alt="MySQL" width=16 height=16/></a>
					<a href="$sqlite"><img src="$assets/icons/sqlite-icon.svg" alt="Sqlite" width=16 height=16/></a>
					</p>
				</div>
			</div>
		</nav>

		<div class="container-fluid">
EOT;
}
function template_footer() {
	$dir_prefix = isset($GLOBALS['is_dir_prefix']) && $GLOBALS['is_dir_prefix'];
	$assets = $dir_prefix?'../assets':'assets';
echo <<<EOT
		</div>
		<script src="$assets/jquery/jquery.min.js" defer></script>
		<script src="$assets/js/bootstrap.min.js" defer></script>
    </body>
</html>
EOT;
}
?>