<?php
require_once 'includes/class.user.php';
require_once 'includes/config.php';

$user = new User($pdo);

if(isset($_GET['logout'])){
    $user->logout();
}
?>

<!DOCTYPE html>
<html>
<head>

	<title>Login page</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script defer src="js/javascript.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
</head>

<body>
<div class="container">
<div id="nav">
	<div>
		<h2>Login page</h2>
		<ul>
            <li><a href="home.php">Home</a></li>
			<li><a href="index.php">Login</a></li>
            <li><a href="?logout=1">Logout</a></li>
		</ul>
	</div>
</div><br>