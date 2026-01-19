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

	?>
	<?php
		$nombre_correcto = null;
		$coincide = null;
		$nombre = "";
		$passwd = "";
		if(isset($_POST["enviar"])){
			$nombre = $_POST["nombre"];
			$passwd = $_POST["password"];
			$correcto = controlErrores_login($nombre);
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
	<?php crea_nav()?>
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
							if(!$coincide and $nombre_correcto){
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
	<?php crea_footer()?>
	
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
