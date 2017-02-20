<?php 
session_start('supracloudRdmax');
require_once($_SERVER['DOCUMENT_ROOT']."/supracloud/functions/funciones.php");
require_once($_SERVER['DOCUMENT_ROOT']."/supracloud/include/globales.php");
require_once($_SERVER['DOCUMENT_ROOT']."/supracloud/ingreso.php");
require_once($_SERVER['DOCUMENT_ROOT']."/supracloud/restringido.php");
$su = query_global("SELECT id{$ext}, name{$ext}, last{$ext}, nivel{$ext} FROM {$tabla}", "WHERE id{$ext}='".$_SESSION['idUser']."'","LIMIT 1");
$_SESSION['nivelSistema'];
if($_SESSION['nivelSistema'] == 5){
  $todos = query_global("SELECT * FROM ordenes");
} else {
  $todos = query_global("SELECT * FROM ordenes", "WHERE doc_ord='".$_SESSION['idUser']."'");
}
//var_dump($todos);
?>
<!DOCTYPE html>
<html lang="es-LA">
<head>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/supracloud/include/cabecera.php");?>
  <link href="<?php echo $dir;?>css/jquery.datatables.css" rel="stylesheet">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="<?php echo $dir;?>js/html5shiv.js"></script>
  <script src="<?php echo $dir;?>js/respond.min.js"></script>
  <![endif]-->
</head>

<body>
<div id="mensaje_ee"></div>
<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>

<section>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/supracloud/include/menu.php");?>
  <div class="mainpanel">
<?php 
  require_once($_SERVER['DOCUMENT_ROOT']."/supracloud/include/headerBar.php");
  require_once($_SERVER['DOCUMENT_ROOT']."/supracloud/include/pageheader.php");
?>
    <div class="contentpanel">
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <div class="panel-btns">
                <a href="#" class="panel-close">&times;</a>
                <a href="#" class="minimize">&minus;</a>
              </div><!-- panel-btns -->
              <h3 class="panel-title">Clientes</h3>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
              <table class="table" id="table1">
                  <thead>
                     <tr>
                        <th>Nombre paciente</th>
                        <th>Fecha</th>
                        <th>Estado informe</th>
                        <th>Aprovación</th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                    <?php
                        if($todos[0]['total'] >= 1){
                            $t = 0;
                            $ct = count($todos);
                            $opcion = "odd";
                            for($t; $t < $ct; ++$t){
								$usuario2 = query_global("SELECT id_clie,name_clie,last_clie,sexo_clie,cedula_clie FROM clientes", "WHERE id_clie='".$todos[$t]['clie_ord']."'", "LIMIT 1");
                                if($opcion == "even"){$opcion="odd";}
                                else{$opcion="even";}
                                echo "\t<tr class=\"$opcion gradeA fila-".$todos[$t]['id_ord']."\">\n";
                                echo "\t\t<td>";
                                echo $usuario2[0]['name']." ".$usuario2[0]['last']."\n";
                                echo "\t\t</td>\n";
                                echo "\t\t<td>";
                                echo date("d/m/Y",$todos[$t]['freg_ord'])."\n";
                                echo "\t\t</td>\n";
                                echo "\t\t<td>";
                                if($todos[$t]['estado_ord']){
                                  echo "Terminado\n";
                                } else{
                                  echo "En proceso\n";
                                }
                                echo "\t\t</td>\n";
                                echo "\t\t<td>";
                                if($todos[$t]['mod_ord']){
                                  echo "Aprobado\n";
                                  $apr = 0;
                                } else{
                                  echo "Por aprobación\n";
                                  $apr = 1;
                                }
                                echo "\t\t</td>\n";
                                echo "\t\t<td class=\"center\">";
                                echo "<a href=\"javascript:void(0)\" onclick=\"aprobar(".$todos[$t]['id_ord'].",{$apr})\" class=\"btn btn-success glyphicon glyphicon-ok mr5\"></a>";
                                echo "<a href=\"../m/".$todos[$t]['id_ord']."/\" class=\"btn btn-info glyphicon glyphicon-edit mr5\"></a>";
                                echo "<a href=\"javascript:void(0);\" class=\"btn btn-danger glyphicon glyphicon-remove quitarOrden\" data-info=\"".$todos[$t]['id_ord']."\"></a>";
                                echo "\t\t</td>\n";
                                echo "\t</tr>\n";
                                unset($usuarios2);
                            }
                        }
                    ?>
                  </tbody>
              </table>
              </div><!-- table-responsive -->
            </div><!-- panel-body -->
          </div><!-- panel -->
        </div>
      </div>
    </div><!-- contentpanel -->

  </div><!-- mainpanel -->
  <?php
    require_once($_SERVER['DOCUMENT_ROOT']."/supracloud/include/panelRight.php");
  ?>
</section>
<script type="text/javascript" src="<?php echo $dir;?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/modernizr.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/toggles.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/retina.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/jquery.cookies.js"></script>

<script type="text/javascript" src="<?php echo $dir;?>js/jquery.datatables.min.js"></script>

<script type="text/javascript" src="<?php echo $dir;?>js/custom.js"></script>

<script type="text/javascript" src="<?php echo $dir;?>js/script.php?o=2"></script>
</body>
</html>
