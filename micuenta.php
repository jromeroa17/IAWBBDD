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
			<h2 class="text-center">Mi Cuenta<h2>
			<form action="" method="POST">
				<table class="table">
				  <tbody>
					<tr>
					  <th scope="row">Nombre de Usuario</th>
					  <td><?php echo $_SESSION["usuario"]?></td>
					</tr>
					<tr>
					  <th scope="row">Email</th>
					  <td><?php echo get_user_data($link,$_SESSION["usuario"],"email")?></td>
					  <td><input type="submit" class="btn btn-primary" name="cambiar-email" value="Cambiar"></td>
					</tr>
					<tr>
					  <th scope="row">Contraseña</th>
					  <td><?php echo get_user_data($link,$_SESSION["usuario"],"contrasena")?></td>
					  <td><input type="submit" class="btn btn-primary" name="cambiar-contrasena" value="Cambiar"></td>
					</tr>
				  </tbody>
				</table>
				<?php
					if(isset($_POST["cambiar-email"])){
				?>
					<label for="nuevo-email">Email: </label>
					<input id="nuevo-email "type="text" value="<?php echo get_user_data($link,$_SESSION["usuario"],"email")?>" name="nuevo-email">
					<input type="submit" class="btn btn-primary" value="Confirmar" name="enviar-email">
				<?php		
					}
					elseif(isset($_POST["cambiar-contrasena"])){
				?>
					<label for="nueva-contrasena">Contraseña: </label>
					<input id="nueva-contrasena "type="text" value="<?php echo get_user_data($link,$_SESSION["usuario"],"contrasena")?>" name="nueva-contrasena">
					<input type="submit" class="btn btn-primary" value="Confirmar" name="enviar-contrasena">
				<?php		
					}
				?>
				<?php
					if(isset($_POST["enviar-email"])){
						$nuevo_email = $_POST["nuevo-email"];
						$current_user = $_SESSION["usuario"];
						$consulta = "update usuarios set email='$nuevo_email' where nombre_usuario='$current_user'";
						my_update($link,$consulta);
						header("Location:micuenta.php");
					}
					elseif(isset($_POST["enviar-contrasena"])){
						$nueva_contrasena = $_POST["nueva-contrasena"];
						$current_user = $_SESSION["usuario"];
						$consulta = "update usuarios set contrasena='$nueva_contrasena' where nombre_usuario='$current_user'";
						my_update($link,$consulta);
						header("Location:micuenta.php");
					}
				?>
				<p>¿Quieres borrar tu cuenta?</p>
				<input type="submit" class="btn btn-danger" name="borrar" value="Eliminar Cuenta">
				<?php
					if(isset($_POST["borrar"])){
						$current_user = $_SESSION["usuario"];
						$consulta = "delete from usuarios where nombre_usuario='$current_user';";
						my_delete($link,$consulta);
						header("Location:logout.php");
					}
				?>
			</form>
		</div>
		
	</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
