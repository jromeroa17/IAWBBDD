<?php
	function conexion_bbdd(){
		$server = "localhost";
		$user = "root";
		$pass = "";
		$dbName = "romeroJavier";
		try{
			$link = mysqli_connect($server, $user, $pass, $dbName);
		}
		catch(mysqli_sql_exception $e){
			echo "Conexión fallida" . $e->getMessage();
		}
		return $link;
	}
	
	
	
	function check_logging(){
		if(isset($_SESSION["usuario"])){
			$current_user = $_SESSION["usuario"];
		}
		else{
			header("Location:login.php");
		}
		return $current_user;
	}
	
	function controlErrores_registro($nombre,$email){
			$nombrecorrecto = true;
			$emailcorrecto = true;
			if(empty($nombre)){
				$nombrecorrecto = false;
			}
			if(empty($email)){
				$emailcorrecto = false;
			}
			$correcto = ["nombre"=>$nombrecorrecto,"email"=>$emailcorrecto];
			return $correcto;
		}
	
	function controlErrores_login($nombre){
			$correcto = true;
			if(empty($nombre)){
				$correcto = false;
			}
			return $correcto;
		}
	
	function get_user_data($link,$usuario,$dato){
		$consulta = "select $dato from usuarios where nombre_usuario='$usuario'";
		$resul = mysqli_query($link,$consulta);
		$numFilas = mysqli_num_rows($resul);
		if ($numFilas == 0){
			echo "Eso está mal";
		}
		else{
			$fila = mysqli_fetch_assoc($resul);
			$dato_pedido = $fila[$dato];
			return $dato_pedido;
		}
		
	}
	
	function get_codigo_personaje($link,$nombre,$usuario){
		$codigo = false;
		$consulta = "select codigo from personajes where creador='$usuario' and nombre_personaje='$nombre';";
		$resul = mysqli_query($link,$consulta);
		$numFilas = mysqli_num_rows($resul);
		if($numFilas != 0){
			$fila = mysqli_fetch_assoc($resul);
			$codigo = $fila["codigo"];
		}
		return $codigo;
	}
	
	function get_datos_personaje($link,$codigo,$dato){
		$dato_pedido = false;
		$consulta = "select $dato from personajes where codigo='$codigo'";
		$resul = mysqli_query($link,$consulta);
		$numFilas = mysqli_num_rows($resul);
		if ($numFilas != 0){
			$fila = mysqli_fetch_assoc($resul);
			$dato_pedido = $fila[$dato];
		}
		return $dato_pedido;
	}

	function my_image_query($link, $consulta, $campos, $campo_imagen){
		$resul = mysqli_query($link,$consulta);
		$numFilas = mysqli_num_rows($resul);
		if ($numFilas == 0){
			echo "No has creado ningún personaje aún";
		}
		else{
			generateImageTable($resul, $campos, $campo_imagen);
		}
	}
	
	function generateImageTable($resultado, $campos, $campo_imagen){
		echo "<table class='table table-striped'>";
		echo "<thead><tr>";
		foreach($campos as $campo){
			echo "<th scope='col'>$campo</th>";
		}
		echo "</tr></thead>";
		echo "<tbody>";
		
		while($fila = mysqli_fetch_assoc($resultado)){
			echo "<tr>";

			foreach($campos as $campo){
				if($campo == $campo_imagen){
					$nombre = $fila[$campo];
					echo "<td scope='row'><img src='imagenes/$nombre'></td>";
				}
				elseif($campo == "borrar"){
					echo "<td scope='row'>
							<form action='' method='post'>
								<input type='hidden' name='codigo' value='{$fila['codigo']}'>
								<button type='submit' name='accion' value='borrar' class='btn btn-danger'>Borrar</button>
							</form>
						  </td>";
				}
				elseif($campo == "modificar"){
					echo "<td scope='row'>
							<form action='modificarpersonajeformulario.php' method='post'>
								<input type='hidden' name='codigo' value='{$fila['codigo']}'>
								<button type='submit' name='accion' value='modificar' class='btn btn-warning'>Modificar</button>
							</form>
						  </td>";
				}
				else{
					echo "<td scope='row'>{$fila[$campo]}</td>";
				}
			}

			echo "</tr>";
		}

		echo "</tbody></table>";
	}

	
	function my_insert($link,$consulta){
		try{
			$resul = mysqli_query($link,$consulta);
			$correcto = true;
			
		}
		catch(mysqli_sql_exception $e){
			echo "<br>La inserción a fallado: " . $e->getMessage();
			$correcto = false;
		}
		return $correcto;
	}

	function move_image($nombre,$origen,$destino){
		if(file_exists($destino)){
			echo "<br> Fichero $nombre ya existe";
		}
		else{
			if(!move_uploaded_file($origen,$destino)){
				echo "error en la subida";
			}
		}
	}
	function datos_correctos($link,$consulta){
		$correcto = true;
		$resul = mysqli_query($link,$consulta);
		$numFilas = mysqli_num_rows($resul);
		if ($numFilas == 0){
			$correcto = false;
		}
		return $correcto;
	}
	
	function my_delete($link,$consulta){
		try{
			$resul = mysqli_query($link,$consulta);
			$correcto = true;
			
		}
		catch(mysqli_sql_exception $e){
			echo "<br>El borrado a fallado: " . $e->getMessage();
			$correcto = false;
		}
		return $correcto;
	}
	
	function my_update($link,$consulta){
		try{
			$resul = mysqli_query($link,$consulta);
			echo "<br>Registro modificado Correctamente";
			$correcto = true;
			
		}
		catch(mysqli_sql_exception $e){
			echo "<br>La modificación ha fallado: " . $e->getMessage();
			$correcto = false;
		}
		return $correcto;
	}
	
	
	function controlErrores($campos){
		$correcto = true;
		foreach($campos as $campo)
			if (empty($campo)){
				$correcto = false;
			}
		return $correcto;
	}
	
	function checkStat($stat){
		$correcto = false;
		if(is_numeric($stat)){
			$correcto = true;
		}
		return $correcto;
	}
	
	function generate_option($link,$consulta){
		$resultado = mysqli_query($link,$consulta);
		$numFilas = mysqli_num_rows($resultado);
		if($numFilas != 0){
			while($fila = mysqli_fetch_assoc($resultado)){
				$nombre = $fila["nombre_personaje"];
				echo "<option value='$nombre'>$nombre</option>";
			}
		}
	}
	
?>
