<?php

	//Info:
	//$destino = "archivos/" . $_FILES["NOMBREINPUT"]["name"];

	//PATHINFO RETORNA UN ARRAY CON INFORMACION DEL PATH
	//RETORNA : NOMBRE DEL DIRECTORIO; NOMBRE DEL ARCHIVO; EXTENSION DEL ARCHIVO
	//PATHINFO_DIRNAME - retorna solo nombre del directorio
	//PATHINFO_BASENAME - retorna solo el nombre del archivo (con la extension)
	//PATHINFO_EXTENSION - retorna solo extension
	//PATHINFO_FILENAME - retorna solo el nombre del archivo (sin la extension)

	//$_FILES["NOMBREINPUT"]["size"] => Tamaño del archivo.
	//$_FILES["NOMBREINPUT"]["tmp_name"] => Nombre en el directiorio temporal.
	//$_FILES["NOMBREINPUT"]["name"] => Nombre del archivo.
	//$_FILES["NOMBREINPUT"]["size"] => Tamaño del archivo.

	class ManejoDeArchivosSubidos
	{

		//Destino => Donde se alojara el archivo.
		//Archivo => El archivo a subir.

		static function ExisteElArchivo($destino)
		{
			return file_exists($destino);
		}

		static function SuperaElPeso($archivo, $pesoMaximo)
		{
			return (filesize($archivo) > $pesoMaximo);
		}

		static function TipoDeArchivo($destino)
		{
			return strtolower(pathinfo($destino, PATHINFO_EXTENSION));
		}

		static function EsImagen($archivo)
		{
			if (getimagesize($archivo) === false)
				return false;
			return true;
		}

		static function EsTipoPermitido($destino)
		{
			$tipoDeArchivo = ManejoDeArchivosSubidos::TipoDeArchivo($destino);
			if ($tipoDeArchivo != "doc" && $tipoDeArchivo != "docx" && $tipoDeArchivo != "txt" && $tipoDeArchivo != "rar")
				return false;
			return true;
		}

		static function EsImagenPermitida($destino)
		{
			$tipoDeArchivo = ManejoDeArchivosSubidos::TipoDeArchivo($destino);
			if($tipoDeArchivo != "jpg" && $tipoDeArchivo != "jpeg" && $tipoDeArchivo != "gif"
			&& $tipoDeArchivo != "png" && $tipoDeArchivo != "bmp")
				return false;
			return true;
		}

		static function GuardarArchivo($archivo, $destino)
		{
			if (move_uploaded_file($archivo, $destino))
				return true;
			return false;
		}

		static function GardarArchivoConVerificacion($archivo, $destino, $pesoMaximo)
		{
			if (ExisteElArchivo($destino))
			{
				echo "<p>El arhivo ya existe. </p>";
				return false;
			}
			if (SuperaElPeso($archivo, $pesoMaximo))
			{
				echo "<p>El archivo supera el tamaño maximo permitido.</p>";
				return false;
			}
			if (EsImagen($archivo))
			{
				if (!EsImagenPermitida($destino))
				{
					echo "Solo son permitidos archivos con extension DOC, TXT o RAR.";
					return false;
				}
			}
			else
			{
				if (!EsTipoPermitido($destino))
				{
					echo "Solo son permitidos archivos con extension DOC, TXT o RAR.";
					return false;
				}
			}
			echo "<p>El archivo se ha subido exitosamente.</p>";
			return true;
		}
	}

?>