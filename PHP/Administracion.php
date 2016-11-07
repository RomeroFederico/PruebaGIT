<?php

	require_once "Librerias/Funciones.php";
	require_once "Librerias/ManejoDeArchivosSubidos.php";

	if (isset($_POST["opcion"]))
	{
		switch ($_POST["opcion"]) 
		{
			case 'MostrarDB':

				$objetos = TraerDataBase();
				echo json_encode($objetos);

				break;

			case 'AgregarDB':

				$imagenOriginal = $_FILES["imagen"]["name"];
				$rutaTemporal = $_FILES["imagen"]["tmp_name"];
				$rutaFinal = "../Archivos/" . $_FILES["imagen"]["name"];

				if (empty($rutaTemporal))
					echo "No se ha ingresado una imagen.";
				else if (file_exists($rutaFinal))
					echo "La imagen ya se ha subido.";
				else if (!ManejoDeArchivosSubidos::EsImagen($rutaTemporal))
					echo "El archivo no es una imagen.";
				else if (!ManejoDeArchivosSubidos::EsImagenPermitida($imagenOriginal))
					echo "El archivo no es una imagen del tipo permitido.";
				else if (ManejoDeArchivosSubidos::SuperaElPeso($rutaTemporal, 1024 * 1024))
					echo "La imagen supera el peso limite.";
				else if (!ManejoDeArchivosSubidos::GuardarArchivo($rutaTemporal, $rutaFinal))
					echo "La imagen no se pudo guardar.";
				else
					echo AgregarDataBase($_POST["nombre"], "Archivos/" . $imagenOriginal);
				break;

			case 'EliminarDB':

				$resultado = EliminarDataBase($_POST["IDEliminar"]);
				if ($resultado != "ERROR")
					unlink("../" . $_POST["imagenOriginal"]);
				echo $resultado;

				break;

			case 'ModificarDB':

				// if (!isset($_POST["imagen"]))
					echo ModificarDataBase($_POST["IDModificar"], $_POST["nombre"], $_POST["imagenOriginal"]);
				// else
				// {
				// 	$imagenOriginal = $_FILES["imagen"]["name"];
				// 	$rutaTemporal = $_FILES["imagen"]["tmp_name"];
				// 	$rutaFinal = "../Archivos/" . $_FILES["imagen"]["name"];
				// 	if (empty($rutaTemporal))
				// 		echo "No se ha ingresado una imagen.";
				// 	else if (file_exists($rutaFinal))
				// 		echo "La imagen ya se ha subido.";
				// 	else if (!ManejoDeArchivosSubidos::EsImagen($rutaTemporal))
				// 		echo "El archivo no es una imagen.";
				// 	else if (!ManejoDeArchivosSubidos::EsImagenPermitida($imagenOriginal))
				// 		echo "El archivo no es una imagen del tipo permitido.";
				// 	else if (ManejoDeArchivosSubidos::SuperaElPeso($rutaTemporal, 1024 * 1024))
				// 		echo "La imagen supera el peso limite.";
				// 	else if (!ManejoDeArchivosSubidos::GuardarArchivo($rutaTemporal, $rutaFinal))
				// 		echo "La imagen no se pudo guardar.";
				// 	else
				// 	{
				// 		$resultado = ModificarDataBase($_POST["IDModificar"], $_POST["nombre"], "Archivos/" . $imagenOriginal);
				// 		if ($resultado != "ERROR")
				// 			unlink("../" . $_POST["imagenOriginal"]);
				// 		echo $resultado;
				// 	}
				// }
				break;

			default:
				# code...
				break;
		}
	}


?>