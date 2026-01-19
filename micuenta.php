<?php session_start();?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="styles.css" rel="stylesheet">
    <title>BBDD</title>
</head>
<body>
	<?php
		require "nav.php";
		require "footer.php";
		require "libreriaBBDD.php";
		$campos = ["nombre_usuario","contrasena"];
		$link = conexion_bbdd();
		$current_user = check_logging();
	?>
	<?php crea_nav()?>
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
	<?php crea_footer()?>
	
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
