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
		
		$campos = ["codigo","nombre_personaje","clase","fuerza","destreza","constitucion","inteligencia","sabiduria","carisma","imagen","borrar","modificar"];		
		$campo_imagen = "imagen";
		$link = conexion_bbdd();
		
		$current_user = check_logging();
		
		if(isset($_POST["buscar"])){
			$nombre = $_POST["nombre_personaje"];
			$correcto = controlErrores([$nombre]);
			if($correcto){
				$codigo = get_codigo_personaje($link,$nombre,$current_user);
			}
		}
		
		if(isset($_POST["accion"]) and isset($_POST["codigo"])){
			$codigo = $_POST["codigo"];
			if ($_POST["accion"] == "borrar"){
				$consulta = "delete from personajes where codigo='$codigo'";
				my_delete($link,$consulta);
				header("Location:borrarpersonaje.php");
			}
		}
		
	?>
	<?php crea_nav()?>
	<main>
		<div class="container mt-4 text-center">
			<h2>Busca uno de tus personajes</h2>
			<form action="" method="POST">
				<div class="form-group ">
					<input type="text" name="nombre_personaje" class="">
					<input type="submit" name="buscar" class="btn btn-success">
					<?php
						if(isset($_POST["buscar"]) and !$correcto){
					?>
					<span>Introduce un nombre</span>
					<?php		
						}
					?>
					<?php
						if(isset($_POST["buscar"]) and !$codigo){
					?>
					<span>No existe ese personaje</span>
					<?php		
						}
					?>
				</div>
			</form>
			<?php
				if(!empty($codigo)){
					$consulta = "select * from personajes where codigo='$codigo';";
					my_image_query($link, $consulta, $campos, $campo_imagen);
				}
			?>
		</div>
		
	</main>
	<?php crea_footer()?>
	
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
