<?php session_start();?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>BBDD</title>

    <style>
		.stats{
			width:25%;
			border-radius:20px;
		}
    </style>
</head>
<body>
	<?php
		require "libreriaBBDD.php";
		$server = "localhost";
		$user = "root";
		$pass = "";
		$dbName = "romeroJavier";
		$campos = ["codigo","nombre_personaje","clase","fuerza","destreza","constitucion","inteligencia","sabiduria","carisma","imagen","creador"];
		
		$link = conexion_bbdd($server,$user,$pass,$dbName);
		
		if(isset($_SESSION["usuario"])){
			$current_user = $_SESSION["usuario"];
		}
		else{
			header("Location:login.php");
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
	<?php
		$codigo = "";
		$nombre = "";
		$clase = "";
		$fuerza = "";
		$destreza = "";
		$constitucion = "";
		$inteligencia = "";
		$sabiduria = "";
		$imagen = "";
		$carisma = "";
	?>
	<?php
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
				$imagen = $_FILES["imagen"]["name"];
				$datos = [$codigo,$nombre,$clase,$fuerza,$destreza,$constitucion,$inteligencia,$sabiduria,$carisma,$imagen];
				$correcto = controlErrores($datos);
				if($correcto){
					$stats = [$fuerza,$destreza,$constitucion,$inteligencia,$sabiduria,$carisma];
					foreach($stats as $stat)
						if (!checkStat($stat)){
							$statsmal = true;
						}
						else{
							$statsmal = false;
						}
				}
			}
		?>
	<main>
		<div class="container">
			<h2 class="text-center">Crear Personaje<h2>
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="form-group mb-4">
					<label class="" for="codigo">Código: </label>
					<input type="text" class="form-control" name="codigo" id="codigo" required value="<?php echo $codigo?>">
				</div>
				<div class="form-group mb-4">
					<label class="" for="nombre">Nombre: </label>
					<input type="text" class="form-control" name="nombre_personaje" id="nombre" value="<?php echo $nombre?>">
				</div>
				<div class="form-group mb-4">
					<label class="" for="clase">Clase: </label>
					<select class="form-select" name="clase" id="clase">
						<option value="guerrero" <?php if($_POST["clase"]=="guerrero"){ echo "selected";}?>>Guerrero</option>
						<option value="picaro" <?php if($_POST["clase"]=="picaro"){ echo "selected";}?>>Pícaro</option>
						<option value="clerigo" <?php if($_POST["clase"]=="clerigo"){ echo "selected";}?>>Clérigo</option>
						<option value="mago" <?php if($_POST["clase"]=="mago"){ echo "selected";}?>>Mago</option>
					</select>
				</div>
				<div class="form-group mb-4">
					<span> Estadísticas: </span>
					<div class="d-flex justify-content-center mt-4">
						<div class="d-flex flex-column justify-content-center">
							<input class="stats" type="text" name="fuerza" id="fuerza" value="<?php echo $fuerza?>">
							<label for="fuerza">Fuerza</label>
							<?php
								if(!checkStat($fuerza)){
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
								if(!checkStat($destreza)){
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
								if(!checkStat($constitucion)){
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
								if(!checkStat($inteligencia)){
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
								if(!checkStat($sabiduria)){
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
								if(!checkStat($carisma)){
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
					<input type="file" class="form-control" name="imagen" id="imagen">
				</div>
				<input type="submit" class="btn btn-primary" name="enviar" value="Crear">
			</form>
			<?php
				if(!$correcto){
			?>
				<span>Alguno de los campos está vacío</span>
			<?php
				}
			?>
		</div>
		<?php
			if(isset($_POST["enviar"])){
				if($correcto and !$statsmal){
					$origen = $_FILES["imagen"]["tmp_name"];
					$destino = $_SERVER["DOCUMENT_ROOT"]."/romeroJavier/IAWBBDD/imagenes/".$imagen;
					move_image($imagen,$origen,$destino);
					$consulta = "insert into personajes values ('$codigo','$nombre','$clase',$fuerza,$destreza,$constitucion,$inteligencia,$sabiduria,$carisma,'$imagen','$current_user');";
					my_insert($link,$consulta);
				}
			}
		?>
	</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
