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
		.container{
			margin:20px auto;
			width:70%;
		}
		form div {
			margin:10px;
		}
    </style>
</head>
<body>
	<?php
		require "libreriaBBDD.php";
		function controlErrores($nombre){
			$correcto = true;
			if(empty($nombre)){
				$correcto = false;
			}
			return $correcto;
		}
		
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
	?>
	<?php
		$nombre_correcto = null;
		$coincide = null;
		$nombre = "";
		$passwd = "";
		if(isset($_POST["enviar"])){
			$nombre = $_POST["nombre"];
			$passwd = $_POST["password"];
			$correcto = controlErrores($nombre);
			if($correcto){
				$consulta = "select * from usuarios where nombre_usuario='$nombre'";
				$nombre_correcto = datos_correctos($link,$consulta);
				if($nombre_correcto){
					$consulta = "select * from usuarios where nombre_usuario='$nombre' and contrasena='$passwd';";
					$coincide = datos_correctos($link,$consulta);
				}
			}
		}
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
							<a class="dropdown-item" href="#">Crear</a>
							<a class="dropdown-item" href="#">Modificar</a>
							<a class="dropdown-item" href="#">Listar</a>
							<a class="dropdown-item" href="#">Borrar</a>
							<a class="dropdown-item" href="#">Buscar</a>
						</div>
						</li>
					<?php } ?>
				</ul>
		  </div>
		</nav>
	</header>
	<main>
		<div class="container">
			<h2>Inicia Sesión con tu usuario</h2>
			<form action="" method="POST">
				<div class="form-group">
					<label for="nombre">Nombre de Usuario</label>
					<input type="text" class="form-control" id="nombre" placeholder="Pon tu nombre" name="nombre" value="<?php if(isset($nombre)){echo $nombre;}?>">
					<?php
						if(isset($_POST["enviar"])){
							if(empty($nombre)){
								echo "<span>Falta el nombre</span>";
							}
							elseif(!$nombre_correcto){
								echo "<span>No existe un usuario con ese nombre</span>";
							}
						}
					?>
				</div>
				<div class="form-group">
					<label for="passwd">Password</label>
					<input type="password" class="form-control" id="passwd" name="password" value="<?php if(isset($passwd)){echo $passwd;}?>" required>
					<?php
						if(isset($_POST["enviar"])){
							if(!$coincide and !$nombre_correcto){
								echo "<span>Contraseña incorrecta</span>";
							}
						}
					?>
				</div>
				<button type="submit" class="btn btn-primary" name="enviar">Submit</button>
			</form>
			<?php
				if(isset($_POST["enviar"])){
					if($nombre_correcto and $coincide){
						$_SESSION["usuario"] = $nombre;
						header("Location:index.php");
					}
				}
			?>
		</div>
	</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
