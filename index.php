<html>

	<head>

		<title>ABM CON DATABASE</title>

		<meta charset="UTF-8">

		<script type="text/javascript" src = "AJAX/jquery.js"></script>

		<script type="text/javascript" src = "JS/Funciones.js"></script>

	</head>

	<body>

		Nombre : <input type = 'text' id = 'txtNombre'/>
		<br> Imagen : <input type = "file" name = "img" id = "img"/>
		<br>

		<input type = 'button' value = "Agregar" id = 'btnAgregar' onclick = 'Agregar()'/>
		<input type = 'button' value = "Modificar" id = 'btnModificar' onclick = 'Modificar()' style ='display:none'/>
		<input type = 'button' value = "Mostrar" id = 'btnMostrar' onclick = 'MostrarTabla()'/>

		<input type = "hidden" id = "hiddenID" value = '0'/> 
		<input type = "hidden" id = "hiddenImagen" value = '0'/> 

		<div id = 'divTabla'></div>

	</body>

</html>