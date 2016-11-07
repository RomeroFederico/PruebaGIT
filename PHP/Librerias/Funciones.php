<?php

	require_once "Ejemplo.php";

	function TraerDataBase()
	{
		$objetos = array();

		try
		{
			$objetoPDO = new PDO('mysql:host=localhost;dbname=abm_db;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			$objetoPDO->exec("SET CHARACTER SET utf8");

			$consulta = $objetoPDO->prepare("SELECT * FROM ejemplo");
			$consulta->execute();

			// $consulta->setFetchMode(PDO::FETCH_INTO, new Ejemplo);

			// foreach ($consulta as $ejemplo)
			// {
			// 	array_push($objetos, $ejemplo->RetornarCopia());
			// }

			$consulta->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Ejemplo'); //Primero constructor, luego la asignacion de variables

			foreach ($consulta as $ejemplo)
			{
				array_push($objetos, $ejemplo);
			}
		} 
		catch (Exception $e) 
		{
			return $objetos;
		}

		return $objetos;
	}

	function AgregarDataBase($nombre, $imagen)
	{
		$IDMaximo =  TraerIDMaximo();

		if ($IDMaximo == "ERROR")
			return $IDMaximo;
		try
		{
			$objetoPDO = new PDO('mysql:host=localhost;dbname=abm_db;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			$objetoPDO->exec("SET CHARACTER SET utf8");

			$consulta = $objetoPDO->prepare("INSERT INTO ejemplo (ID, Nombre, Imagen) VALUES(:ID, :Nombre, :Imagen)");

			$consulta->bindValue(':ID', $IDMaximo + 1, PDO::PARAM_INT);
			$consulta->bindValue(':Nombre', $nombre, PDO::PARAM_STR);
			$consulta->bindValue(':Imagen', $imagen, PDO::PARAM_STR);

			$consulta->execute();
		}
		catch (Exception $e) 
		{
			return "ERROR";
		}

		return "Exito al agregar el registro.";
	}

	function EliminarDataBase($IDEliminar)
	{
		try
		{
			$objetoPDO = new PDO('mysql:host=localhost;dbname=abm_db;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			$objetoPDO->exec("SET CHARACTER SET utf8");

			$consulta = $objetoPDO->prepare("DELETE FROM ejemplo WHERE (ID = :ID)");

			$consulta->bindValue(':ID', $IDEliminar, PDO::PARAM_INT);

			$consulta->execute();
		}
		catch (Exception $e) 
		{
			return "ERROR";
		}

		return "Exito al eliminar el registro.";
	}

	function ModificarDataBase($IDModificar, $nombre, $imagen)
	{
		try
		{
			$objetoPDO = new PDO('mysql:host=localhost;dbname=abm_db;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			$objetoPDO->exec("SET CHARACTER SET utf8");

			$consulta = $objetoPDO->prepare("UPDATE ejemplo SET Nombre = :Nombre, Imagen = :Imagen 
											 WHERE (ID = :ID)");

			$consulta->bindValue(':ID', $IDModificar, PDO::PARAM_INT);
			$consulta->bindValue(':Nombre', $nombre, PDO::PARAM_STR);
			$consulta->bindValue(':Imagen', $imagen, PDO::PARAM_STR);

			$consulta->execute();
		}
		catch (Exception $e) 
		{
			return "ERROR";
		}

		return "Exito al modificar el registro.";
	}

	function TraerIDMaximo()
	{
		try
		{
			$objetoPDO = new PDO('mysql:host=localhost;dbname=abm_db;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			$objetoPDO->exec("SET CHARACTER SET utf8");

			$sql = $objetoPDO->query('SELECT MAX(ID) FROM ejemplo');

			$resultado = $sql->fetchall();

			foreach ($resultado as $fila) 
				return $fila[0];

			return 0;
		}
		catch (Exception $e) 
		{
			return "ERROR";
		}
	}

?>