<?php

	class Ejemplo
	{
		public $ID;
		public $Nombre;
		public $Imagen;

		function __construct($id = "", $nombre = "", $imagen = "")
		{
			$this->ID = $id;
			$this->Nombre = $nombre;
			$this->Imagen = $imagen;
		}

		function RetornarCopia()
		{
			return new Ejemplo($this->ID, $this->Nombre, $this->Imagen);
		}
	}

?>