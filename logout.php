<?php session_start();?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>BBDD</title>

    <style>
		ul li {
			padding:5px;
		}
    </style>
</head>
<body>
	<?php
		require "libreriaBBDD.php";
		$server = "localhost";
		$user = "root";
		$pass = "";
		$dbName = "romeroJavier";
		$campos = ["nombre_usuario","contrasena"];
		try{
			$link = mysqli_connect($server, $user, $pass, $dbName);
		}
		catch(mysqli_sql_exception $e){
			echo "Conexión fallida" . $e->getMessage();
		}
		
		unset($_SESSION);
		session_destroy();
		header("Location:login.php");
	?>
	<header>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div>
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="index.php">Home</a>
					</li>
					<li class="nav-item ">
						<a class="nav-link" href="registro.php">Registrarse</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="#">Inicio de Sesión</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Cerrar Sesión</a>
					</li>
				</ul>
		  </div>
		</nav>
	</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
