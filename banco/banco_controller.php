<?php
	require_once "../lib/nusoap.php";
    require_once "servicio_banco_model.php";
    
    $datos_form=array();
    $datos_form['monto']=intval($_POST["monto"]);
    $datos_form['cod_comercio']=$_POST["cod_comercio"];
    $datos_form['tipo_tarjeta']=$_POST["tipo_tarjeta"];
    $datos_form['num_tarjeta']=$_POST["num_tarjeta"];
    $datos_form['fecha_venc']=$_POST["fecha_venc"];
    $datos_form['cod_seguridad']=intval($_POST["cod_seguridad"]);
    $datos_form['ci_titular']=$_POST["ci_titular"];
    
    $numero=$datos_form['num_tarjeta'];
    $cod_banco=md5(substr($numero, 1, 3));
    $url=get_url_servicio($cod_banco);

    $cliente = new nusoap_client($url['url_servicio'], 'wsdl');
        
    $error = $cliente->getError();
    if ($error) {
        echo "<h4> Pago procesado sin &eacute;xito</h4>";
        echo "<pre class='pre-no-exito'>Otros<br></pre>";
        /*echo "<h4>Error en el constructor del cliente del Web Service:</h4>";
        echo "<pre class='pre-no-exito'>$error<br></pre>";*/         
    }
    
    $result = $cliente->call("pagar_al_banco",$datos_form);

      
    if ($cliente->fault) {
        echo "<h4> Pago procesado sin &eacute;xito</h4>";
        echo "<pre class='pre-no-exito'>Otros<br></pre>";
        /*echo "<h4>Falla en el cliente del WS</h4>";
        echo "<pre class='pre-no-exito'>";  
        print_r($result);
        echo "</pre>";*/
    }
    else {
        $error = $cliente->getError();
        if ($error) {
            echo "<h4> Pago procesado sin &eacute;xito</h4>";
            echo "<pre class='pre-no-exito'>Otros<br></pre>";
            /*echo "<h4>Error del objeto cliente del Web Service: </h4>";
            echo "<pre class='pre-no-exito'>$error <br></pre>";*/ 
        }
        else {
            //echo $result."<br>";
            //echo $result['cod_operacion']."<br>";

            if($result=='00'){

                echo "<h4> Pago procesado con &eacute;xito</h4>";
                echo "<pre class='pre-exito'>Aceptado<br></pre>";
                $rif=get_datos_comercio($datos_form['cod_comercio']);
                $saldo= get_saldo_cuenta_comercio($rif['rif']);
                $saldo_actual=$saldo['saldo']+$datos_form['monto'];
                update_saldo_cuenta_comercio($rif['rif'],$saldo_actual);

            }elseif($result=='10'){

                echo "<h4> Pago procesado sin &eacute;xito</h4>";
                echo "<pre class='pre-no-exito'>Datos Inv&aacute;lidos<br></pre>";

            }elseif($result=='01'){

                echo "<h4> Pago procesado sin &eacute;xito</h4>";
                echo "<pre class='pre-no-exito'>Cr&eacute;dito Insuficiente<br></pre>";

            }elseif($result=='11'){

                echo "<h4> Pago procesado sin &eacute;xito</h4>";
                echo "<pre class='pre-no-exito'>Tarjeta Bloqueada<br></pre>";

            }
        }
    }

    //echo '<h2>Request</h2><pre>' . htmlspecialchars($cliente->request, ENT_QUOTES) . '</pre>';
    //echo '<h2>Response</h2><pre>' . htmlspecialchars($cliente->response, ENT_QUOTES) . '</pre>';
        
?>