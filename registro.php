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
		require "libreriaBBDD.php";
		require "footer.php";
		require "nav.php";
		$campos = ["nombre_usuario","contrasena"];
		$link = conexion_bbdd();	
	?>
	<?php
		$correcto = ["nombre"=>null,"email"=>null];
		$consulta_correcta = null;
		$nombre = "";
		$email = "";
		$passwd = "";
		if(isset($_POST["enviar"])){
			$nombre = $_POST["nombre"];
			$email = $_POST["email"];
			$passwd = $_POST["password"];
			$correcto = controlErrores_registro($nombre,$email);
			$existe = get_user_data($link,$nombre,"nombre_usuario");
			if($correcto["nombre"] and $correcto["email"] and empty($existe)){
				$consulta = "insert into usuarios values('$nombre','$email','$passwd');";
				$consulta_correcta = my_insert($link,$consulta);
			}
		}
	?>
	<?php crea_nav()?>
	<main>
		<div class="container">
			<h2>Regístrate en nuestra página</h2>
			<form action="" method="POST">
				<div class="form-group">
					<label for="nombre">Nombre de Usuario</label>
					<input type="text" class="form-control" id="nombre" placeholder="Pon tu nombre" name="nombre" value="<?php if(isset($nombre)){echo $nombre;}?>">
					<?php
						if(!$correcto["nombre"] and isset($_POST["enviar"])){
							echo "<span>Falta el nombre</span>";
						}
						elseif(!empty($existe)){
							echo "<span>Ya existe un usuario con esa cuenta</span>";
						}
					?>
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" placeholder="Escribe tu email" name="email" value="<?php if(isset($email)){echo $email;}?>">
					<?php
						if(!$correcto["email"] and isset($_POST["enviar"])){
							echo "<span>Falta el email</span>";
						}
					?>
				</div>
				<div class="form-group">
					<label for="passwd">Password</label>
					<input type="password" class="form-control" id="passwd" name="password" value="<?php if(isset($passwd)){echo $passwd;}?>" required>
				</div>
				<button type="submit" class="btn btn-primary" name="enviar">Submit</button>
			</form>
			<?php
				if($consulta_correcta){
					echo "<span>Usuario Creado!!!</span>";
					header("Location:login.php");
				}
			?>
		</div>
	</main>
	<?php crea_footer()?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
