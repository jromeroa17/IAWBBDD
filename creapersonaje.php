<?php session_start();?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>BBDD</title>

    <style>
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
		<div class="container">
			<h2 class="text-center">Crear Personaje<h2>
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="form-group mb-4">
					<label class="" for="nombre">Nombre: </label>
					<input type="text" class="form-control" name="nombre" id="nombre">
				</div>
				<div class="form-group mb-4">
					<label class="" for="clase">Clase: </label>
					<select class="form-select" name="clase" id="clase">
						<option value="guerrero" selected>Guerrero</option>
						<option value="picaro">Pícaro</option>
						<option value="clerigo">Clérigo</option>
						<option value="mago">Mago</option>
					</select>
				</div>
				<div class="form-group mb-4">
					<span> Estadísticas: </span>
					<div>
						<div>
							<input class="stats" type="text" name="fuerza" id="fuerza">
							<label for="fuerza">Fuerza</label>
							<input type="submit" class="btn btn-primary" name="fuerza-generar" value="Generar">
						</div>
						<div>
							<input class="stats" type="text" name="destreza" id="destreza">
							<label for="destreza">Destreza</label>
							<input type="submit" class="btn btn-primary" name="destreza-generar" value="Generar">
						</div>
						<div>
							<input class="stats" type="text" name="constitucion" id="constitucion">
							<label for="constitucion">Constitución</label>
							<input type="submit" name="constitucion-generar" class="btn btn-primary" value="Generar">
						</div>
						<div>
							<input class="stats" type="text" name="inteligencia" id="inteligencia">
							<label for="inteligencia">Inteligencia</label>
							<input type="submit" class="btn btn-primary" name="inteligencia-generar" value="Generar">
						</div>
						<div>
							<input class="stats" type="text" name="sabiduria" id="sabiduria">
							<label for="sabiduria">Sabiduría</label>
							<input type="submit" name="sabiduria-generar" class="btn btn-primary" value="Generar">
						</div>
						<div>
							<input class="stats" type="text" name="carisma" id="carisma">
							<label for="carisma">Carisma</label>
							<input type="submit" name="carisma-generar" class="btn btn-primary" value="Generar">
						</div>
					</div>
				</div>
			</form>
		</div>
		
	</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
