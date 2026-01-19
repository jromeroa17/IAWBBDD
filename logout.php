<?php session_start();?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>BBDD</title>
</head>
<body>
	<?php
		require "libreriaBBDD.php";
		$campos = ["nombre_usuario","contrasena"];
		$link = conexion_bbdd();
		
		
		unset($_SESSION);
		session_destroy();
		header("Location:login.php");
	?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
