<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "
http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="style.css">
		<title>Formulario web</title>
	</head>
	<body>
		<br>
		<form action='<?php echo $_SERVER['PHP_SELF'];?>' name="formConsulta" id=formConsulta method="post">
			<p align="center">Mostrar viviendas de tipo: 
			<select name="buscar" form="formConsulta">
				<option value="todos">Todos</option>
				<option value="casa">Casa</option>
				<option value="piso">Piso</option>
				<option value="adosado">Adosado</option>
				<option value="chalet">Chalet</option>
				<option value="chalet">Estudio</option>
			</select>
			<input type="submit" name="actualizar" value="Actualizar">
			</p>
		</form>
		<?php
		$servername = "db5000281397.hosting-data.io";
		$username = "dbu461532";
		$password = "Edgeworth.93";
		$dbname = "dbs274668";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		if(!isset($_POST["actualizar"])){
			$sql = "SELECT * FROM vivienda";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			    // output data of each row
			    echo "<table id=tablaConsulta>";
			    echo "<tr><td class='cabecera'>Id</td><td class='cabecera'>Tipo</td><td class='cabecera'>Zona</td><td class='cabecera'>Dirección</td><td class='cabecera'>Dormitorios</td><td class='cabecera'>Precio</td><td class='cabecera'>Tamaño</td><td class='cabecera'>Extras</td><td class='cabecera'>Foto</td><td class='cabecera'>Resumen</td></tr>"; 
			    while($row = $result->fetch_assoc()) {

			    	echo "<tr><td class='celda'>" . $row["id"] . "</td><td class='celda'>" . $row["tipo"] . "</td><td class='celda'>" . $row["zona"] . "</td><td class='celda'>" . $row["direccion"] . "</td><td class='celda'>" . $row["dormitorios"] . "</td><td class='celda'>" . $row["precio"] . "</td><td class='celda'>" . $row["tamano"] . "</td><td class='celda'>" . $row["extras"] . "</td><td class='celda'><a href='" . $row["foto"] . "'>" . $row["foto"] . "</a></td><td class='celda'><form action=" . $_SERVER['PHP_SELF'] . " method='post'><input name='cogerId' type='hidden' value=" . $row["id"] . "><input type='submit' name='generar' value='Generar'></form></td></tr>";
			    }

			    echo "</table>";
			    echo"<center>";
			    echo "<form class='formVolver' action='index.html'><div class='botonVolver'><input class='botonVolver' type='submit' value='Volver'></div></form></center>";
			} else {
			    echo "No se ha introducido nada en la base de datos";
			}
		} else {
			if($_POST["buscar"] == "todos"){
				$sql = "SELECT * FROM vivienda ORDER BY precio ASC";
			} else {
				$sql = "SELECT * FROM vivienda WHERE tipo='" . $_POST["buscar"] . "' ORDER BY precio ASC";
			}
			
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			    // output data of each row
			    echo "<table id=tablaConsulta>";
			    echo "<tr><td class='cabecera'>Id</td><td class='cabecera'>Tipo</td><td class='cabecera'>Zona</td><td class='cabecera'>Dirección</td><td class='cabecera'>Dormitorios</td><td class='cabecera'>Precio</td><td class='cabecera'>Tamaño</td><td class='cabecera'>Extras</td><td class='cabecera'>Foto</td><td class='cabecera'>Resumen</td></tr>"; 
			    while($row = $result->fetch_assoc()) {

			    	echo "<tr><td class='celda'>" . $row["id"] . "</td><td class='celda'>" . $row["tipo"] . "</td><td class='celda'>" . $row["zona"] . "</td><td class='celda'>" . $row["direccion"] . "</td><td class='celda'>" . $row["dormitorios"] . "</td><td class='celda'>" . $row["precio"] . "</td><td class='celda'>" . $row["tamano"] . "</td><td class='celda'>" . $row["extras"] . "</td><td class='celda'><a href='" . $row["foto"] . "'>" . $row["foto"] . "</a></td><td class='celda'><form action=" . $_SERVER['PHP_SELF'] . " method='post'><input name='cogerId' type='hidden' value='" . $row["id"] . "'><input type='submit' name='generar' value='Generar'></form></td></tr>";
			    }
			    echo "</table>";
			    echo "<center><form class='formVolver' action='index.html'><input type='submit' value='Volver'></form></center>";
			} else {
			    echo "No hay viviendas de ese tipo.";
			}
		}
 		if(isset($_POST["generar"])){
 			$sql = "SELECT * FROM vivienda WHERE id=" . $_POST["cogerId"];
 			$result = $conn->query($sql);
 			if ($result->num_rows > 0){
 				while($row = $result->fetch_assoc()) {
 					$myfile = fopen("txt/" . $_POST["cogerId"] . ".txt", "w") or die("Unable to open file!");
					$txt = "Id: " . $row["id"] . "\n" . "Tipo: " . $row["tipo"] . "\n" . "Zona: " . $row["zona"] . "\n" .
					"Direccion: " . $row["direccion"] . "\n" . "Dormitorios: " . $row["dormitorios"] . "\n" .
					"Precio: " . $row["precio"] . "\n" . "Tamano: " . $row["tamano"] . "\n" .
					"Extras: " . $row["extras"] . "\n";
					fwrite($myfile, $txt);
					fclose($myfile);
					echo "<center>Tu informe se ha generado, haz click <a href='txt/" . $_POST["cogerId"] . ".txt'>aquí</a> para abrirlo.</center>";
			    }
 			}
 		}
		
		$conn->close();

		?>
		<script src="main.js"></script>
	</body>
</html>