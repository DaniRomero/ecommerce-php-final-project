<?php
    require_once "../lib/nusoap.php";
    require_once "servicio_banco_model.php";

    //$ns='http://ecomerce.byethost15.com';
    $server = new nusoap_server();
    $server->configureWSDL('banco','urn:banco_ws');
    //$server->wsdl->schemaTargetNamespace=$ns;

    
    $server->register('pagar_al_banco',
        array('monto' => 'xsd:int','cod_comercio' => 'xsd:string','tipo_tarjeta'=>'xsd:string','num_tarjeta'=>'xsd:string','fecha_venc'=>'xsd:string','cod_seguridad'=>'xsd:int','ci_titular'=>'xsd:string'),
        array('cod_operacion' => 'xsd:string'),
        'urn:banco_ws',
        'urn:bancowsdl#pagar_al_banco',
        'rpc',
        'encoded',
        'La siguiente funcion recibe los datos de la tarjeta y procesa el pago'
        );

		function pagar_al_banco($monto,$cod_comercio,$tipo,$numero,$fecha_venc,$codigo,$ci){
				$result=array();

	            $fecha=date("Y")."-".date("m")."-".date("d");

	            $existe_tarjeta = existe_tarjeta($numero);
	            $existe_cliente = existe_cliente($ci);
	            $tarjeta = get_tarjeta($numero);
	            $cliente = get_cliente($ci);

	            $result=array();

	            if( $existe_cliente==1 && $existe_tarjeta==1 && $tarjeta['ci_cliente']==$cliente['ci'] && $monto>0){
	            	if($tarjeta['estado']=='activa'){

	            		if($numero==$tarjeta['numero_tarjeta'] && $tipo==$tarjeta['tipo_tarjeta'] && $fecha_venc==$tarjeta['fecha_expiracion'] && $codigo==$tarjeta['cod_seguridad'] && $ci==$cliente['ci']){

	            			if($monto<=$tarjeta['credito_disponible']){
	                      
		                    	$credito=$tarjeta['credito_disponible']-$monto;
		                    	update_credito_disponible($numero,$credito);

		                    	$saldo=$tarjeta['saldo']+$monto;
		                    	update_saldo($numero,$saldo);
		 
		                    	insert_transaccion($numero,$fecha,$monto,'00');
		                      	
		                      	
		                      	$result['cod_operacion']='00';
		                      	return "00";

	                    	}else{
	                      			//Credito Insuficiente
	                      			insert_transaccion($numero,$fecha,$monto,'01');
	                      			$result['cod_operacion']='01';
		                      		return "01";
	                    		}                  	
	                	}
	                  	else{
	                    		//Datos Invalidos
	                    		insert_transaccion($numero,$fecha,$monto,'10'); 
	                      		$result['cod_operacion']='10';
		                      	return "10";
	                  		}
	            	}else{
	            			//Tarjeta No esta "activa", tarjeta esta "bloqueada"
	                		insert_transaccion($numero,$fecha,$monto,'11');
	                      	$result['cod_operacion']='11';
		                    return "11";
	            		}           			              
	            }
	            else{
	              		//Datos Invalidos
	              		//No existe Numero de Tarjeta o Cedula de Cliente
	              		//Numero de Tarjeta y Nombre del titular no coinciden
	              		insert_transaccion($numero,$fecha,$monto,'10');              
	              		$result['cod_operacion']='10';
		                return "10";
	            	}
        }

		$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
        $server->service($HTTP_RAW_POST_DATA);
        //exit(); 

?>