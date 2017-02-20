<?php
	function connect_bd(){
		$link = @mysql_connect('localhost', 'u545628267_comer', '123456789')
			or die('No se pudo conectar: ' . mysql_error());
		//echo 'Connected successfully';
		mysql_select_db('u545628267_comer');
	}

	function close_bd(){
		@mysql_close($link);
	}

	function get_url_servicio($cod){
		connect_bd();
		$query = "SELECT url_servicio FROM cod_bancos WHERE cod_cifrado='$cod'";
		$result = mysql_query($query);
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
			return $line;
		}
		close_bd();
	}

	function existe_tarjeta($numero){
		connect_bd();
		$query = "SELECT numero_tarjeta FROM tarjeta WHERE numero_tarjeta='$numero' ";
		$result = mysql_query($query);
		if (mysql_num_rows($result) >= 1){
			return 1;
		}else{
			return 0;
		}
		close_bd();
	}

	function existe_cliente($ci){
		connect_bd();
		$query = "SELECT ci FROM cliente WHERE ci='$ci' ";
		$result = mysql_query($query) ;
		if (mysql_num_rows($result) >= 1){
			return 1;
		}else{
			return 0;
		}
		close_bd();
	}

	function get_tarjeta($numero){
		connect_bd();
		$query = "SELECT * FROM tarjeta WHERE numero_tarjeta='$numero' ";
		$result = mysql_query($query);
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
			return $line;
		}
		close_bd();
	}

	function get_cliente($ci){
		connect_bd();
		$query = "SELECT * FROM cliente WHERE ci='$ci' ";
		$result = mysql_query($query);
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
			return $line;
		}
		close_bd();
	}

	function update_credito_disponible($numero,$credito){
		connect_bd();
		$query = "UPDATE tarjeta SET credito_disponible=$credito WHERE numero_tarjeta=$numero";
		mysql_query($query) ;
		close_bd();
	}

	function update_saldo($numero,$saldo){
		connect_bd();
		$query = "UPDATE tarjeta SET saldo=$saldo WHERE numero_tarjeta=$numero";
		mysql_query($query) ;
		close_bd();
	}

	function insert_transaccion($numero,$fecha,$monto,$cod_operacion){
		connect_bd();
		$query = "INSERT INTO transaccion VALUES ($numero,'$fecha',$monto,'$cod_operacion',NULL) ";
		mysql_query($query) ;
		close_bd();
	}

	function get_datos_comercio($cod_afiliacion_comercio){
		connect_bd();
		$query = "SELECT rif, razon_social FROM cliente_juridico WHERE cod_afiliacion_comercio='$cod_afiliacion_comercio' ";
		$result = mysql_query($query) ;
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
			return $line;
		}
		close_bd();
	}

	function get_saldo_cuenta_comercio($rif){
		connect_bd();
		$query = "SELECT saldo FROM cuenta WHERE id_cliente='$rif' ";
		$result = mysql_query($query) /*or die('Consulta fallida: ' . mysql_error())*/;
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
			return $line;
		}
		close_bd();
	}

	function update_saldo_cuenta_comercio($rif,$saldo){
		connect_bd();
		$query = "UPDATE cuenta SET saldo=$saldo WHERE id_cliente='$rif'";
		mysql_query($query) /*or die('Consulta fallida: ' . mysql_error())*/;
		close_bd();
	}

?>