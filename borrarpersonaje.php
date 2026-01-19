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
		$campos = ["codigo","nombre_personaje","clase","fuerza","destreza","constitucion","inteligencia","sabiduria","carisma","imagen","borrar","modificar"];		
		$campo_imagen = "imagen";
		$link = conexion_bbdd();
		$current_user = check_logging();
		
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
		<div class="container text-center">
		<h2>Borrar Personajes</h2>
			<form action="" method="POST">
			<?php
				$consulta = "select * from personajes where creador='$current_user';";
				my_image_query($link, $consulta, $campos, $campo_imagen);
			?>
			</form>
		</div>
	</main>
	<?php crea_footer()?>
	
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
