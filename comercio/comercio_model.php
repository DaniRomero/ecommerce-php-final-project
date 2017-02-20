<?php
	function connect_bd(){
		$link = @mysql_connect('localhost', 'u545628267_2', '123456789')
			or die('No se pudo conectar: ' . mysql_error());
		//echo 'Connected successfully';
		mysql_select_db('u545628267_2') or die('No se pudo seleccionar la base de datos');
	}

	function close_bd(){
		@mysql_close($link);
	}

	function get_productos(){
		connect_bd();
		$query = "SELECT codigo_barra, nombre, precio_total FROM producto";
		$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
		$productos=array();
		$i=0;
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$productos[$i]=$line;
			$i++;
		}
		return $productos;
		close_bd();
	}

	function get_cod_afiliacion_comercio(){
		connect_bd();
		$query = "SELECT cod_afiliacion_comercio FROM comercio WHERE rif='j201231234'";
		$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
			return $line;
		}
		close_bd();
	}

?>