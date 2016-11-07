function MostrarTabla() 
{
	//alert($("#img")[0].files.length);
	TraerYMostrarTablaDB("PHP/Administracion.php");
}

function Agregar()
{
	if (ValidarCadena($("#txtNombre").val()) && ValidarCadena($("#img").val()))
	{
		if ($("hiddenID").val() != '0')
		{
			$("#btnModificar").hide();
			$("#hiddenID").val('0');
			$("#hiddenImagen").val('0');
		}
		AgregarTablaDB("PHP/Administracion.php");
	}
	else
		alert("No se han completado todos los campos.");
}

function Eliminar(objeto)
{
	if (confirm("¿Desea eliminar este registro?") === true)
	{
		if ($("hiddenID").val() != '0')
		{
			$("#btnModificar").hide();
			$("#hiddenID").val('0');
			$("#hiddenImagen").val('0');
		}
		EliminarTablaDB("PHP/Administracion.php", objeto.ID, objeto.Imagen);
	}
}

function AgregarModificar(objeto)
{
	$("#txtNombre").val(objeto.Nombre);
	$("#hiddenID").val(objeto.ID);
	$("#hiddenImagen").val(objeto.Imagen);
	$("#btnModificar").show();
}

function Modificar()
{
	if (ValidarCadena($("#txtNombre").val()))
	{
		ModificarTablaDB("PHP/Administracion.php");
		$("#btnModificar").hide();
		$("#hiddenID").val('0');
		$("#hiddenImagen").val('0');
	}
	else
		alert("No se han completado todos los campos.");
}

function ValidarCadena(cadenaAValidar)
{
	return cadenaAValidar != null && cadenaAValidar != "" && cadenaAValidar != undefined;
}

function TraerYMostrarTablaDB(URL)
{
	$.ajax({
		type: "POST",
		url: URL,
		dataType: "JSON",
		data: {opcion : 'MostrarDB'},
		async: true
	})
	.done(function (objeto) {
		var tabla = ArmarTabla(objeto);
		$("#divTabla").html(tabla);
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function AgregarTablaDB(URL)
{
	var formData = new FormData();

	var imagen = $("#img")[0];
	formData.append("imagen", imagen.files[0]);
	formData.append("nombre", $("#txtNombre").val());
	formData.append("opcion", "AgregarDB");

	$.ajax({
		type: "POST",
		url: URL,
		dataType: "text",
		data: formData,
		contentType: false,
		processData: false,
		async: true
	})
	.done(function (objeto) {
		alert(objeto);
		if (objeto != "ERROR")
			MostrarTabla();
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function EliminarTablaDB(URL, IDEliminar, imagenOriginal)
{
	var formData = new FormData();

	formData.append("IDEliminar", IDEliminar); 
	formData.append("opcion", "EliminarDB");
	formData.append("imagenOriginal", imagenOriginal);

	$.ajax({
		type: "POST",
		url: URL,
		dataType: "text",
		data: formData,
		contentType: false,
		processData: false,
		async: true
	})
	.done(function (objeto) {
		alert(objeto);
		if (objeto != "ERROR")
			MostrarTabla();
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function ModificarTablaDB(URL)
{
	var formData = new FormData();

	// if ($("#img").val() != $("hiddenImagen").val())
	// {
	// 	var imagen = $("#img")[0];
	// 	formData.append("imagen", imagen.files[0]);
	// }

	formData.append("nombre", $("#txtNombre").val());
	formData.append("opcion", "ModificarDB");
	formData.append("IDModificar", parseInt($("#hiddenID").val()));
	formData.append("imagenOriginal", $("#hiddenImagen").val());

	$.ajax({
		type: "POST",
		url: URL,
		dataType: "text",
		data: formData,
		contentType: false,
		processData: false,
		async: true
	})
	.done(function (objeto) {
		alert(objeto);
		if (objeto != "ERROR")
			MostrarTabla();
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function ArmarTabla(coleccionJSON)
{
	var tabla = "<table border = '2'><tr>";

	var objeto = coleccionJSON[0];

	tabla += "<th>ID</th>";
	tabla += "<th>Nombre</th>";
	tabla += "<th>Imagen</th>";
	tabla += "<th>Accion</th>";

	for (var i = 0; i < coleccionJSON.length; i++) 
	{
		tabla += "<tr>";

		tabla += "<td align = 'center'>" + coleccionJSON[i].ID + "</td>";
		tabla += "<td align = 'center'>" + coleccionJSON[i].Nombre + "</td>";
		tabla += "<td align = 'center'><img src = '" + coleccionJSON[i].Imagen + "' height = '100' width = '100'/></td>";
		tabla += "<td align = 'center'>";
			tabla += "<input type = 'button' value = 'Eliminar' onclick = 'Eliminar(" + JSON.stringify(coleccionJSON[i]) + ")'/>";
			tabla += "<input type = 'button' value = 'Modificar' onclick = 'AgregarModificar(" + JSON.stringify(coleccionJSON[i]) + ")'/>";
		tabla += "</tr>";
	}

	tabla += "</table>";

	return tabla;
}