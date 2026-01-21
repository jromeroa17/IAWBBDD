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
		$server = "localhost";
		$user = "root";
		$pass = "";
		$dbName = "romeroJavier";
		$campos = ["codigo","nombre_personaje","clase","fuerza","destreza","constitucion","inteligencia","sabiduria","carisma","imagen","borrar","modificar"];		
		$campo_imagen = "imagen";
		$link = conexion_bbdd();
		
		$current_user = check_logging();
		
		$codigo = "";
		$nombre = "";
		$clase = "";
		$fuerza = "";
		$destreza = "";
		$constitucion = "";
		$inteligencia = "";
		$sabiduria = "";
		$carisma = "";
		$imagen = "";
		$statsmal = false;
		$correcto = false;
		
		if(isset($_POST["mostrar"], $_POST["nombre"])){
			$nombre = $_POST["nombre"];
			$consulta = "SELECT * FROM personajes WHERE nombre_personaje='$nombre'";
			$resultado = mysqli_query($link, $consulta);
			$fila = mysqli_fetch_assoc($resultado);

			if($fila){
				$codigo = $fila['codigo'];
				$clase = $fila['clase'];
				$fuerza = $fila['fuerza'];
				$destreza = $fila['destreza'];
				$constitucion = $fila['constitucion'];
				$inteligencia = $fila['inteligencia'];
				$sabiduria = $fila['sabiduria'];
				$carisma = $fila['carisma'];
				$imagen = $fila['imagen'];
			}
		}
		
		elseif(isset($_POST["accion"]) and isset($_POST["codigo"])){
			$codigo = $_POST["codigo"];
			if($_POST["accion"] == "modificar"){
				$consulta = "SELECT * FROM personajes WHERE codigo='$codigo'";
				$resultado = mysqli_query($link, $consulta);
				$fila = mysqli_fetch_assoc($resultado);

				if($fila){
					$nombre = $fila['nombre_personaje'];
					$clase = $fila['clase'];
					$fuerza = $fila['fuerza'];
					$destreza = $fila['destreza'];
					$constitucion = $fila['constitucion'];
					$inteligencia = $fila['inteligencia'];
					$sabiduria = $fila['sabiduria'];
					$carisma = $fila['carisma'];
					$imagen = $fila['imagen'];
				}
			}
		}
		
		
		if(isset($_POST["enviar"])){
			$codigo = $_POST["codigo"];
			$nombre = $_POST["nombre_personaje"];
			$clase = $_POST["clase"];
			$fuerza = $_POST["fuerza"];
			$destreza = $_POST["destreza"];
			$constitucion = $_POST["constitucion"];
			$inteligencia = $_POST["inteligencia"];
			$sabiduria = $_POST["sabiduria"];
			$carisma = $_POST["carisma"];

			$datos = [$codigo,$nombre,$clase,$fuerza,$destreza,$constitucion,$inteligencia,$sabiduria,$carisma];
			$correcto = controlErrores($datos);

			if($correcto){
				$stats = [$fuerza,$destreza,$constitucion,$inteligencia,$sabiduria,$carisma];
				$statsmal = false;
				foreach($stats as $stat){
					if(!checkStat($stat)){
						$statsmal = true;
						break;
					}
				}
			}

			if($correcto && !$statsmal){
				$update_imagen = "";
				if(isset($_FILES["imagen"]) && $_FILES["imagen"]["tmp_name"] != ""){
					$imagen = $_FILES["imagen"]["name"];
					$origen = $_FILES["imagen"]["tmp_name"];
					$destino = $_SERVER["DOCUMENT_ROOT"]."/imagenes/".$imagen;
					move_image($imagen, $origen, $destino);
					$update_imagen = ", imagen='$imagen'";
				}

				$consulta = "UPDATE personajes SET 
					nombre_personaje='$nombre',
					clase='$clase',
					fuerza=$fuerza,
					destreza=$destreza,
					constitucion=$constitucion,
					inteligencia=$inteligencia,
					sabiduria=$sabiduria,
					carisma=$carisma
					$update_imagen
					WHERE codigo='$codigo';";

				my_update($link,$consulta);
				header("Location: modificarpersonaje.php");
			}
		}

	?>
	<?php crea_nav()?>
	<main>
		<div class="container mt-4">
			<h2>Modificar Personaje</h2>
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="form-group mb-4">
					<input type="hidden" name="codigo" value="<?= $codigo ?>">
				</div>
				<div class="form-group mb-4">
					<label class="" for="nombre">Nombre: </label>
					<input type="text" class="form-control" name="nombre_personaje" id="nombre" value="<?php echo $nombre?>">
				</div>
				<div class="form-group mb-4">
					<label class="" for="clase">Clase: </label>
					<select class="form-select" name="clase" id="clase">
						<option value="guerrero" <?php if($clase=="guerrero"){ echo "selected";}?>>Guerrero</option>
						<option value="picaro" <?php if($clase=="picaro"){ echo "selected";}?>>Pícaro</option>
						<option value="clerigo" <?php if($clase=="clerigo"){ echo "selected";}?>>Clérigo</option>
						<option value="mago" <?php if($clase=="mago"){ echo "selected";}?>>Mago</option>
					</select>
				</div>
				<div class="form-group mb-4">
					<span> Estadísticas: </span>
					<div class="d-flex justify-content-center mt-4">
						<div class="d-flex flex-column justify-content-center">
							<input class="stats" type="text" name="fuerza" id="fuerza" value="<?php echo $fuerza?>">
							<label for="fuerza">Fuerza</label>
							<?php
								if(isset($_POST["enviar"]) and !checkStat($fuerza)){
							?>
							<span>Introduce un valor numérico</span>
							<?php
								}
							?>
						</div>
						<div class="d-flex flex-column">
							<input class="stats" type="text" name="destreza" id="destreza" value="<?php echo $destreza?>">
							<label for="destreza">Destreza</label>
							<?php
								if(isset($_POST["enviar"]) and !checkStat($destreza)){
							?>
							<span>Introduce un valor numérico</span>
							<?php
								}
							?>
						</div>
						<div class="d-flex flex-column">
							<input class="stats" type="text" name="constitucion" id="constitucion" value="<?php echo $constitucion?>">
							<label for="constitucion">Constitución</label>
							<?php
								if(isset($_POST["enviar"]) and !checkStat($constitucion)){
							?>
							<span>Introduce un valor numérico</span>
							<?php
								}
							?>
						</div>
						<div class="d-flex flex-column">
							<input class="stats" type="text" name="inteligencia" id="inteligencia" value="<?php echo $inteligencia?>">
							<label for="inteligencia">Inteligencia</label>
							<?php
								if(isset($_POST["enviar"]) and !checkStat($inteligencia)){
							?>
							<span>Introduce un valor numérico</span>
							<?php
								}
							?>
						</div>
						<div class="d-flex flex-column">
							<input class="stats" type="text" name="sabiduria" id="sabiduria" value="<?php echo $sabiduria?>">
							<label for="sabiduria">Sabiduría</label>
							<?php
								if(isset($_POST["enviar"]) and !checkStat($sabiduria)){
							?>
							<span>Introduce un valor numérico</span>
							<?php
								}
							?>
						</div>
						<div class="d-flex flex-column">
							<input class="stats" type="text" name="carisma" id="carisma" value="<?php echo $carisma?>">
							<label for="carisma">Carisma</label>
							<?php
								if(isset($_POST["enviar"]) and !checkStat($carisma)){
							?>
							<span>Introduce un valor numérico</span>
							<?php
								}
							?>
						</div>
					</div>
				</div>
				<div class="form-group mb-4">
					<label class="" for="imagen">Imagen: </label>
					<img src="imagenes/<?php echo $imagen?>">
					<input type="file" class="form-control" name="imagen" id="imagen">
				</div>
				<input type="submit" class="btn btn-primary" name="enviar" value="Modificar">
			</form>
		</div>
	</main>
	<?php crea_footer()?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
