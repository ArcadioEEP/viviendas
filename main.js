function validarAlta(){
	var radios = document.getElementsByName("dormitorios");
	var validarRadio = false;
	for (var i = 0; i < radios.length; i++){
		if (radios[i].checked){
			validarRadio = true;
		} 
	} 
	var ex = "";
	document.getElementById("extras").value = "";
	if(document.getElementById("piscina").checked == true){
		ex += " Piscina";
	}
	if(document.getElementById("jardin").checked == true){
		ex += " Jardin";
	}
	if(document.getElementById("garaje").checked == true){
		ex += " Garaje";
	}
	document.getElementById("extras").value = ex;
	if (document.getElementById("direccion").value == "" || !validarRadio || document.getElementById("precio").value == "" || document.getElementById("tamano").value == "" || document.getElementById("foto").value == ""){
		alert("Debes rellenar los campos (excepto extras y observaciones, en su caso)");
	} else {
		document.getElementById("comprobar").value = "ok";
		document.getElementById("formAlta").submit();

	}
}