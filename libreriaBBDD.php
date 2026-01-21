<?php
    /*Todas las páginas tienen que llamar a esta función para poder conectarse a la base de datos. No se le pasan las credenciales por parámetro ya que luego al subirlo a la nube se tendría que cambiarlo en todos los ficheros, de esta manera solo se cambian las credenciales en la librería.*/
	function conexion_bbdd(){
		$server = "sql100.infinityfree.com";
		$user = "if0_40942388";
		$pass = "vDe8NlSnxaN";
		$dbName = "if0_40942388_romerojavier";
		try{
			$link = mysqli_connect($server, $user, $pass, $dbName);
		}
		catch(mysqli_sql_exception $e){
			echo "Conexión fallida" . $e->getMessage();
		}
		return $link;
	}
	
	
	/*Sirve para comprobar si la sesión está activa y guardar el nombre del usuario activo, que se necesita para casi todas  las consultas. Si no se está con la sesión iniciada, te manda para la página de login.*/
	function check_logging(){
		if(isset($_SESSION["usuario"])){
			$current_user = $_SESSION["usuario"];
		}
		else{
			header("Location:login.php");
		}
		return $current_user;
	}
	
	/*Se necesita uno para cada formulario para personalizar los mensajes de error. La idea general es recorrer todos los campos del formulario y si alguno está vacío muestra un mensaje de error al usuario. */
	/*En el registro se necesita saber cuál de los dos es el erróneo*/
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
	
	/*$campos es un array donde va todo el contenido de los campos del formulario que toque*/
	function controlErrores($campos){
		$correcto = true;
		foreach($campos as $campo)
			if (empty($campo)){
				$correcto = false;
			}
		return $correcto;
	}

	/*En la página de “Mi Cuenta” necesitamos recoger los datos del usuario uno a uno para mostrarlos en los campos del formulario de modificación
    Se pide tanto el nombre del usuario como el dato que se pide (mail, nombre de usuario,etc.)*/
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
	
	/*En el apartado de buscar personaje como la búsqueda se hace por el nombre para que sea más intuitiva para el usuario, se necesita buscar el id a partir del nombre para mostrar los datos correspondientes.
    Se pide el nombre del personaje y el usuario al que pertenece*/
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
	
	/*Lo mismo que el apartado anterior, para mostrar datos en el formulario de modificación se puede o sacarlos todos de golpe e ir separando uno a uno y que la búsqueda se hace por el código solo*/
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

	/*Realiza la consulta que se le pasa por parámetro. Aunque la imagen ya no sea obligatoria, mantiene el nombre de una versión anterior.
    Se pide la sentencia sql a ejecutar, los campos que va a pedir la consulta y si uno de los campos es una imagen*/
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
	
	/*Esta función necesita que le pasen el objeto resultado de la consulta, que campos quiere buscar, si uno de ellos es un campo dedicado a una imagen para que la muestre en la celda que toque. Además, tiene implementada la lógica de los botones de borrar y modificar en las tablas que los tienen.*/
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

	/*Ejecuta una sentencia de inserción. Si hay un fallo devuelve una excepción.*/
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

	/*Mueve la imagen exactamente como lo hicimos en clase.
    Se necesita el nombre de la imagen(el que tiene en la base de datos), el origen (tmp_name) y el destino (la ruta a donde se va a mover)*/
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

	/*Se utiliza para el login. Comprueba que un dato existe con los filtros que haya en la consulta que se le pasa por parámetro.*/
	function datos_correctos($link,$consulta){
		$correcto = true;
		$resul = mysqli_query($link,$consulta);
		$numFilas = mysqli_num_rows($resul);
		if ($numFilas == 0){
			$correcto = false;
		}
		return $correcto;
	}
	

	/*Ejecuta una sentencia de borrado. Como el borrado está restringido, puede saltar esa excepción.*/
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
	

	/*Ejecuta una sentencia de modificación. La excepción puede saltar al modificar una clave foránea a una que no existe en la tabla padre.*/
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
	

	/*Comprueba que los campos de las estadísticas tienen contenido numérico.*/
	function checkStat($stat){
		$correcto = false;
		if(is_numeric($stat)){
			$correcto = true;
		}
		return $correcto;
	}
	

	/*Genera la lista de opciones de la lista desplegable de la sección modificar personajes.*/
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
