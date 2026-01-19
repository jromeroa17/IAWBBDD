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
		$campos = ["nombre_usuario","email","contrasena"];		
		$campo_imagen = "imagen";
		$link = conexion_bbdd();
		
		
		$current_user = check_logging();
		
	?>
	<?php crea_nav()?>
	<main>
		<div class="container">
			<h2 class="text-center">Usuarios Dados de alta</h2>
			<?php
				$consulta = "select * from usuarios;";
				my_image_query($link, $consulta, $campos, $campo_imagen);
			?>
		</div>
		
	</main>
	<?php crea_footer()?>
	
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
