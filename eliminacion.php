<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "
http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="style.css">
		<title>Formulario web</title>
	</head>
	<body>
		<?php
		$servername = "";
		$username = "";
		$password = "";
		$dbname = "";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		$sql = "SELECT * FROM vivienda";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    // output data of each row
		    echo "<br><form id='formBaja' action=" . $_SERVER['PHP_SELF'] . " method='post'><table id=tablaBaja>";
		    echo "<tr><td class='cabecera'>Id</td><td class='cabecera'>Tipo</td><td class='cabecera'>Zona</td><td class='cabecera'>Dirección</td><td class='cabecera'>Dormitorios</td><td class='cabecera'>Precio</td><td class='cabecera'>Tamaño</td><td class='cabecera'>Extras</td><td class='cabecera'>Foto</td><td class='cabecera'>Eliminar</td></tr>"; 
		    while($row = $result->fetch_assoc()) {

		    	echo "<tr><td class='celda'>" . $row["id"] . "</td><td class='celda'>" . $row["tipo"] . "</td><td class='celda'>" . $row["zona"] . "</td><td class='celda'>" . $row["direccion"] . "</td><td class='celda'>" . $row["dormitorios"] . "</td><td class='celda'>" . $row["precio"] . "</td><td class='celda'>" . $row["tamano"] . "</td><td class='celda'>" . $row["extras"] . "</td><td class='celda'><a href='" . $row["foto"] . "'>" . $row["foto"] . "</a></td><td class='celda'><input type='checkbox' name='seleccionado[]' value='" . $row["id"] . "'</td class='celda'></tr>";
		    }
		    echo "</table><center><input type='submit' name='darBaja' value='Eliminar'></table></form> <form class='formVolver' action='index.html'><br><input type='submit' value='Volver'></form><center>";
		} else {
		    echo "No se ha introducido nada en la base de datos";
		}
		if(isset($_POST["darBaja"])){
			if(!empty($_POST["seleccionado"])){
				foreach($_POST['seleccionado'] as $selected){
					$sql = "DELETE FROM vivienda WHERE id=" . $selected;
					if ($conn->query($sql) === TRUE) {
					    echo "Se ha eliminado la vivienda " . $selected . "<br>";
					    $file_pointer = "img/" . $selected . ".jpg";
					    unlink($file_pointer);

					} else {
					    echo "Error: " . $conn->error;
					}
				}
			} else{
				echo "No has seleccionado ninguna vivienda.";
			}
		}


		$conn->close();

		?>
		<script src="main.js"></script>
	</body>
</html>
