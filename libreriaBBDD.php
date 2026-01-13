<?php
	function my_query($link, $consulta, $campos){
		$resul = mysqli_query($link,$consulta);
		$numFilas = mysqli_num_rows($resul);
		if ($numFilas == 0){
			echo "Empty set";
		}
		else{
			generateTable($resul, $campos);
		}
	}

	function generateTable($resultado, $campos){
		echo "<table border=1 class='datos'>";
		echo "<tr>";
		foreach($campos as $valor)
			echo "<th>$valor</th>";
		echo "</tr>";
		while($fila = mysqli_fetch_assoc($resultado)){
			echo "<tr>";
			for($i = 0; $i < count($campos); $i++){
				echo "<td>" . $fila[$campos[$i]] . "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}


	function my_image_query($link, $consulta, $campos, $baseDir){
		$resul = mysqli_query($link,$consulta);
		$numFilas = mysqli_num_rows($resul);
		if ($numFilas == 0){
			echo "Empty set";
		}
		else{
			generateImageTable($resul, $campos, $baseDir);
		}
	}
	
	function generateImageTable($resultado, $campos, $baseDir){
		echo "<table border=1 class='datos' >";
		echo "<tr>";
		while($fila = mysqli_fetch_assoc($resultado)){
			for($i = 0; $i < count($campos); $i++){
				if($i == count($campos) - 1){
					$nombre = $fila[$campos[$i]];
					echo "<td><img src='imagenes/$nombre'></td>";					
				}
				else{
					echo "<td>" . $fila[$campos[$i]] . "</td>";					
				}
			}
			echo "</tr>";
		}
		echo "</table>";
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
			echo "<br>Registro Borrado Correctamente";
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
	
?>
