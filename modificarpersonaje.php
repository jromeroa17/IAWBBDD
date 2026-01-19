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
		require "nav.php";
		require "footer.php";
		$campos = ["codigo","nombre_personaje","clase","fuerza","destreza","constitucion","inteligencia","sabiduria","carisma","imagen","borrar","modificar"];		
		$campo_imagen = "imagen";
		$link = conexion_bbdd();
		
		$current_user = check_logging();
	?>
	<?php crea_nav()?>
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
	<?php crea_footer()?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
