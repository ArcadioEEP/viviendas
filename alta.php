<!-- https://www.w3schools.com/php/php_file_upload.asp -->
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
		<div id="cajaAlta">
		<form name="formAlta" id="formAlta" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
			<table id=tablaAlta>
				<tr>
					<td><b>Tipo de vivienda:</b> </td>
					<td>
						<select form="formAlta" id="tipo" name="tipo">
						  <option value="casa">Casa</option>
						  <option value="piso">Piso</option>
						  <option value="adosado">Adosado</option>
						  <option value="chalet">Chalet</option>
						  <option value="chalet">Estudio</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><b>Zona:</b> </td>
					<td>
						<select form="formAlta" id="zona" name="zona">
						  <option value="centro">Centro</option>
						  <option value="norte">Norte</option>
						  <option value="sur">Sur</option>
						  <option value="este">Este</option>
						  <option value="oeste">Oeste</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><b>Dirección:</b> </td>
					<td><input type="text" id="direccion" name="direccion"> </td>
				</tr>
				<tr>
					<td><b>Dormitorios: </b></td>
					<td>
						<input type="radio" name="dormitorios" value="1">1
						<input type="radio" name="dormitorios" value="2">2
						<input type="radio" name="dormitorios" value="3">3
						<input type="radio" name="dormitorios" value="4">4
						<input type="radio" name="dormitorios" value="5">5
					</td>
				</tr>
				<tr>
					<td><b>Precio: </b></td>
					<td><input type="number" id="precio" name="precio"> €</td>
				</tr>
				<tr>
					<td><b>Tamaño: </b></td>
					<td><input type="number" id="tamano" name="tamano"> m<sup>2</sup></td>
				</tr>
				<tr>
					<td><b>Extras: </b></td>
					<td>
						<input type="checkbox" id="piscina" name="piscina" value="piscina">Piscina
						<input type="checkbox" id="jardin" name="jardin" value="jardin">Jardín
						<input type="checkbox" id="garaje" name="garaje" value="garaje">Garaje
						<input type="hidden" name="extras" id="extras">
					</td>
				</tr>
				<tr>
					<td><b>Foto (jpg):</b> </td>
					<td><input type="file" name="foto" id="foto"> </td>
				</tr>
				<tr>
					<td><b>Observaciones: </b></td>
					<td><textarea form="formAlta" id="observaciones" name="observaciones" rows="4" cols="21"></textarea></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="comprobar" id="comprobar">
						<center><input type="button" value="Alta" onClick="validarAlta()" name="darAlta"></center>
						</form>
					</td>
				</tr>
			</table>		
		</form>
		</div><br>
		<center><form class="formVolver" action='index.html'><input class='botonVolver' type='submit' value='Volver'></form></center>


		<?php
		
		if(isset($_POST['comprobar']) && $_POST['comprobar'] == "ok"){
			$tipo = $_POST['tipo'];
			$zona = $_POST['zona'];
			$direccion = $_POST['direccion'];
			$dormitorios = $_POST['dormitorios'];
			$precio = $_POST['precio'];
			$tamano = $_POST['tamano'];
			$extras = $_POST['extras'];
			$nombreFoto = "";
			$observaciones = $_POST['observaciones'];


			$servername = "db5000281397.hosting-data.io";
			$username = "dbu461532";
			$password = "Edgeworth.93";
			$dbname = "dbs274668";

			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			$sql = "SELECT MAX(id) as maximo FROM vivienda";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				 while($row = $result->fetch_assoc()) {
				 	$nombreFoto = ($row["maximo"] + 1);
				 	print_r($nombreFoto);
				 }
				
			} else {
			   	$nombreFoto = 1;			    
			}
			$target_dir = "img/";
			$target_file = $target_dir . basename($_FILES["foto"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$rutaFoto = "img/" . $nombreFoto . ".jpg";
			$check = getimagesize($_FILES["foto"]["tmp_name"]);
		    if($check !== false) {
		        $uploadOk = 1;
		        if ($_FILES[$foto]["size"] > 500000) {
			    echo "La foto es demasiado grande";
			    $uploadOk = 0;
				} else {
					if($imageFileType != "jpg") {
				    echo "El formato de la foto debe ser JPG";
				    $uploadOk = 0;
					} else {
						if ($uploadOk == 0) {
					    echo "No se ha podido subir la foto";
					// if everything is ok, try to upload file
						} else {
						    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
						        echo "La foto ". basename( $_FILES["foto"]["name"]). " se ha subido correctamente.";
						        rename("img/" . $_FILES["foto"]["name"], $rutaFoto);
						        $stmt = $conn->prepare("INSERT INTO vivienda (tipo, zona, direccion, dormitorios, precio, tamano, extras, foto, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
								$stmt->bind_param("sssidisss", $tipo, $zona, $direccion, $dormitorios, $precio, $tamano, $extras, $rutaFoto, $observaciones);
						
								if ($stmt->execute() === TRUE) {
								    echo "<h3>Vivienda creada</h3>";
								} else {
								    echo "Error: " . $stmt . "<br>" . $conn->error;
								}
						    } else {
						        echo "Hubo un error subiendo la foto";
						    }
						}
					}
					// Check if $uploadOk is set to 0 by an error
					
				}
				// Allow certain file formats
				
		    } else {
		        echo "El archivo no es una imagen.";
		        $uploadOk = 0;
		    }
			
			// Check file size
			
			

			$conn->close();			
		}
			?>
		<script src="main.js"></script>
	</body>
</html>