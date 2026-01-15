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
		$campos = ["codigo","nombre_personaje","clase","fuerza","destreza","constitucion","inteligencia","sabiduria","carisma","imagen","borrar","modificar"];		
		$campo_imagen = "imagen";
		$link = conexion_bbdd($server,$user,$pass,$dbName);
		
		if(isset($_SESSION["usuario"])){
			$current_user = $_SESSION["usuario"];
		}
		else{
			header("Location:login.php");
		}
	?>
	<header>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div>
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="index.php">Home</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="registro.php">Registrarse</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="login.php">Inicio de Sesión</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="logout.php">Cerrar Sesión</a>
					</li>
					<?php if (isset($_SESSION["usuario"])) { ?>
					<li class="nav-item">
						<a class="nav-link" href="micuenta.php">Mi Cuenta</a>
					</li>
					<li class="nav-item dropdown">
					  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Personajes
					  </a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="creapersonaje.php">Crear</a>
							<a class="dropdown-item" href="modificarpersonaje.php">Modificar</a>
							<a class="dropdown-item" href="listarpersonajes.php">Listar</a>
							<a class="dropdown-item" href="borrarpersonaje.php">Borrar</a>
							<a class="dropdown-item" href="buscarpersonajes.php">Buscar</a>
						</div>
						</li>
					<?php } ?>
				</ul>
		  </div>
		</nav>
	</header>
	<main>
		<div class="container mt-4">
			<h2>Modificar Personajes</h2>
			<form action="modificarpersonajeformulario.php" method="POST">
				<select name="nombre" class="form-select mb-3" required>
					<option value="">-- Selecciona un personaje --</option>
					<?php
						$consulta = "SELECT nombre_personaje FROM personajes WHERE creador='$current_user'";
						generate_option($link, $consulta);
					?>
				</select>
				<input type="submit" name="mostrar" value="Mostrar Datos" class="btn btn-success">
			</form>
		</div>
	</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
