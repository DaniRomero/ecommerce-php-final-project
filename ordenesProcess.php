<?php 
session_start('supracloudRdmax');
require_once($_SERVER['DOCUMENT_ROOT']."/supracloud/functions/funciones.php");
require_once($_SERVER['DOCUMENT_ROOT']."/supracloud/include/globales.php");
require_once($_SERVER['DOCUMENT_ROOT']."/supracloud/ingreso.php");
require_once($_SERVER['DOCUMENT_ROOT']."/supracloud/restringido.php");
$directorio = "files";
$su = query_global("SELECT id{$ext}, name{$ext}, last{$ext}, nivel{$ext} FROM {$tabla}", "WHERE id{$ext}='".$_SESSION['idUser']."'","LIMIT 1");
$user = friendlyVars($_SERVER['REQUEST_URI'], "supracloud,ordersprocess");
$orden = query_global("SELECT * FROM ordenes o INNER JOIN clientes c ON c.id_clie=o.clie_ord","WHERE o.id_ord='".$user[0]."'","LIMIT 1",1);
$imgOrdenes = query_global("SELECT * FROM imagenes", "WHERE num_img='".$orden[0]['num_ord']."'");
$_SESSION['sesionOrden'] = $orden[0]['id_ord'];
?>
<!DOCTYPE html>
<html lang="es-LA">
<head>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/supracloud/include/cabecera.php");?>
  <link rel="stylesheet" href="<?php echo $dir;?>css/jquery.tagsinput.css" />  
  <link rel="stylesheet" href="<?php echo $dir;?>css/bootstrap-wysihtml5.css" />

  <link href="<?php echo $dir;?>css/jquery.datatables.css" rel="stylesheet">
  <style type="text/css">
  .point{display:block; float:left; background:url(<?php echo $dir;?>images/pointerblanck.png) no-repeat; width:25px; height:28px; text-align:center; padding-top:3px; margin-right:10px; position:absolute; margin-top: -20px;}
  .point:hover{background:url(<?php echo $dir;?>images/pointerblanck2.png);}
  a:link .point{color:#000;}
  a:hover .point{color:#FFFFFF;
  }
  </style>
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
              </div>
              <h4 id="numeroOrden" data-info="<?php echo $orden[0]['num_ord'];?>" class="panel-title">Orden N° <?php echo $orden[0]['num_ord'];?></h4>
              <p>Paciente: <?php echo $orden[0]['last_clie'].", ".$orden[0]['name_clie'];?></p>
            </div>
            <div class="panel-body panel-body-nopadding">
              <!-- BASIC WIZARD -->
              <div id="progressWizard" class="basic-wizard">
                <ul class="nav nav-pills nav-justified">
                  <?php 
                  if($imgOrdenes[0]['total'] >= 1){
                    $io = 0;
                    $cio = count($imgOrdenes);
                    for($io; $io < $cio; ++$io) {
                      echo "\t<li><a href=\"#tab".substr($imgOrdenes[$io]['name'],0,-4)."\" data-toggle=\"tab\"><span>Imagen ".($io+1).":</span> Orden</a></li>\n";
                    }
                    unset($io,$cio);
                  }
                  ?>
                </ul>
                <div class="tab-content">
                  <div class="progress progress-striped active">
                    <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <?php 
                  if($imgOrdenes[0]['total'] >= 1){
                    $io = 0;
                    $cio = count($imgOrdenes);
                    for($io; $io < $cio; ++$io) {
                      $stop = false;
                      do {
                        $c = strtolower(dechex(rand(0x000000, 0xFFFFFF)));
                        if($c != "ffffff" && $c != "000000"){
                          $stop = true;
                        }
                      } while (!$stop);
                      $color[] = $c;
                      $medidas = getimagesize($_SERVER['DOCUMENT_ROOT']."/supracloud/files/".$imgOrdenes[$io]['name']);
                      $imagesize[] = $medidas;
                      echo "\t<div class=\"tab-pane\" id=\"tab".substr($imgOrdenes[$io]['name'],0,-4)."\">\n";
                      echo "\t\t<div class=\"form-group\">\n";
                      echo "\t\t\t<div style=\"display:block;float:left;width:100%;height:".$medidas[1]."px;\">\n";
                      echo "\t\t\t\t<div class=\"draw\" style=\"z-index:129\" id=\"radio".substr($imgOrdenes[$io]['name'],0,-4)."\"></div>";
                      echo "\t\t\t\t<img class=\"img-responsive center-block radio draw\" style=\"z-index:128\" src=\"{$dir}files/".$imgOrdenes[$io]['name']."\"/>\n";
                      echo "\t\t\t</div>\n";
                      echo "\t\t</div>\n";
                      echo "\t\t<div class=\"row\">\n";
                      echo "\t\t<hr>";
                      echo "\t\t\t<div id=\"descripcion-".substr($imgOrdenes[$io]['name'],0,-4)."\" class=\"col-sm-12\" data-principal=\"".substr($imgOrdenes[$io]['name'],0,-4)."\">";
                      echo "\t\t\t</div>";
                      echo "\t\t\t<div class=\"col-sm-11 col-sm-offset-1\">";
                      echo "\t\t\t\t<button data-panel=\"".substr($imgOrdenes[$io]['name'],0,-4)."\" class=\"btn btn-primary mt5 btnAdd\">Añadir descripción</button>\n";
                      echo "\t\t\t\t<button class=\"btn btn-primary\" onclick=clear('".substr($imgOrdenes[$io]['name'],0,-4)."')>Borrar todo</button>";
                      echo "\t\t\t\t<button id=\"editor_draw_erase\" class=\"btn btn-primary\" onclick=erase('".substr($imgOrdenes[$io]['name'],0,-4)."')>Borrar</button>";
                      echo "\t\t\t\t<button class=\"btn btn-primary\" onclick=undo('".substr($imgOrdenes[$io]['name'],0,-4)."')>Deshacer</button>";
                      echo "\t\t\t</div>\n";
                      echo "\t\t</div>\n";
                      echo "\t</div>\n";
                      echo "<input type=\"hidden\" id=\"hiddenradio".substr($imgOrdenes[$io]['name'],0,-4)."\" name=\"hiddenradio".substr($imgOrdenes[$io]['name'],0,-4)."\" />";
                      $_SESSION['imgOrd'][] = substr($imgOrdenes[$io]['name'],0,-4);
                    }
                    unset($io,$cio);
                  }
                  ?>
                </div><!-- tab-content -->
                  <ul class="pager wizard">
                    <li class="previous"><a href="javascript:void(0)">Previo</a></li>
                    <li class="next"><a href="javascript:void(0)">Siguiente</a></li>
                  </ul>
                <div class="form-group">
                  <div class="col-sm-12">
                    <h2>Tus Comentarios del informe</h2>
                    <textarea id="txtwysiwyg" placeholder="Escribe tus comentarios..." class="form-control rtxt" rows="10"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <button id="btnGuardar" class="btn btn-primary btnGuardar">Guardar Informe</button>
                  </div>
                </div>
              </div><!-- #basicWizard -->
            </div><!-- panel-body -->
          </div><!-- panel -->
        </div><!-- tabs -->
      </div>
    </div><!-- contentpanel -->
  </div><!-- mainpanel -->
  <?php
    require_once($_SERVER['DOCUMENT_ROOT']."/supracloud/include/panelRight.php");
  ?>
</section>
<!-- Modal -->
<div class="modal fade" id="descripciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Descripciones</h4>
      </div>
      <div class="modal-body desc">
        <div class="table-responsive">
          <table class="table" id="tableDescripciones">
              <thead>
                 <tr>
                    <th></th>
                    <th>Descripción</th>
                    <th></th>
                 </tr>
              </thead>
              <tbody>
              <?php
              $descripciones = query_global("SELECT id_form,num_form,status_form,pos_form,question_form FROM formularios", "WHERE num_form='1' AND status_form='1'", "ORDER BY pos_form ASC");
              if($descripciones[0]['total'] >= 1){
              $d = 0;
              $cd = count($descripciones);
                for($d; $d < $cd; ++$d){
                  echo "\t<tr class=\"odd gradeX\">\n";
                  echo "\t\t<td>";
                  echo "\t\t\t<div class=\"checkbox block\">\n";
                  echo "\t\t\t<input value=\"".$descripciones[$d]['id']."\"  type=\"checkbox\">\n";
                  echo "\t\t\t<label>&nbsp;</label>";
                  echo "\t\t\t</div>\n";
                  echo "\t\t</td>\n";
                  echo "\t\t<td>".$descripciones[$d]['question']."</td>\n";
                  echo "\t\t<td class=\"center\">";
                  echo "<button data-desc=\"".$descripciones[$d]['question']."\" data-add=\"".$descripciones[$d]['id']."\" class=\"btn btn-primary addDesc\">Añadir</button>";
                  echo "</td>\n";
                  echo "\t</tr>\n";
                }
              }
              unset($descripciones,$d,$cd);
              ?>
              </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->
<!-- Modal -->
<div class="modal fade" id="compartir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Solicitar opinión</h4>
      </div>
      <div class="modal-body comp">
        <div class="table-responsive">
          <table class="table" id="tableCompartir">
              <thead>
                 <tr>
                    <th></th>
                    <th>Doctores</th>
                    <th>Correo electronico</th>
                 </tr>
              </thead>
              <tbody>
              <?php
              $doctores = query_global("SELECT id_doc,name_doc,last_doc,mail_doc FROM doctores", "WHERE nivel_doc='3' AND estado_doc='1'", "ORDER BY name_doc DESC");
              if($doctores[0]['total'] >= 1){
              $d = 0;
              $cd = count($doctores);
                for($d; $d < $cd; ++$d){
                  echo "\t<tr class=\"odd gradeX\">\n";
                  echo "\t\t<td>";
                  echo "\t\t\t<div class=\"checkbox block\">\n";
                  echo "\t\t\t<input value=\"".$doctores[$d]['id']."\"  type=\"checkbox\">\n";
                  echo "\t\t\t<label>&nbsp;</label>";
                  echo "\t\t\t</div>\n";
                  echo "\t\t</td>\n";
                  echo "\t\t<td>".ucfirst(strtolower($doctores[$d]['name'])).", ".ucfirst(strtolower($doctores[$d]['last']))."</td>\n";
                  echo "\t\t<td>".strtolower($doctores[$d]['mail'])."</td>\n";
                  echo "\t</tr>\n";
                }
              }
              unset($doctores,$d,$cd);
              ?>
              </tbody>
          </table>
        </div>
        <div class="col-md-12">
          <textarea id="txtcompartir" name="txtcompartir" class="mt5 mb5 col-md-12" placeholder="Escriba aqui sus comentarios" style="min-height:139px;" data-compartir="<?php echo $user[0];?>"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="compartir(<?php echo $user[0];?>);" data-dismiss="modal">Añadir</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->
<script type="text/javascript" src="<?php echo $dir;?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/jquery-ui-1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/modernizr.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/toggles.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/retina.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/jquery.cookies.js"></script>

<script type="text/javascript" src="<?php echo $dir;?>js/jquery.datatables.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/chosen.jquery.min.js"></script>

<script type="text/javascript" src="<?php echo $dir;?>js/jquery-ui-1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/bootstrap-wizard.min.js"></script>

<script type="text/javascript" src="<?php echo $dir;?>js/wysihtml5-0.3.0.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/custom.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/raphael.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/json2.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/raphael.sketchpad.js"></script>
<script type="text/javascript" src="<?php echo $dir;?>js/script2.php?o=7"></script>
<script type="text/javascript">
<?php
if($imgOrdenes[0]['total'] >= 1){
  $io = 0;
  $cio = count($imgOrdenes);
  for($io; $io < $cio; ++$io) {
    echo "var strokes = [{\n";
    echo "\"type\":\"path\",\n";
    //echo "\"path\":[[\"M\",10,10],[\"L\",390,390]],\n";
    echo "\"fill\":\"none\",\n";
    echo "\"stroke\":\"#".$color[$io]."\"\n";
    //echo "\"stroke-opacity\":1,\n";
    //echo "\"stroke-width\":5,\n";
    //echo "\"stroke-linecap\":\"round\",\n";
    //echo "\"stroke-linejoin\":\"round\"\n";
    echo "}];\n";
    echo "var sp".substr($imgOrdenes[$io]['name'],0,-4)." = Raphael.sketchpad(\"radio".substr($imgOrdenes[$io]['name'],0,-4)."\", {";
    echo "width: ".$imagesize[$io][0].",\n";
    echo "height: ".$imagesize[$io][1].",\n";
    echo "editing: true,\n";
    echo "strokes: strokes\n";
    echo "});";
    echo "sp".substr($imgOrdenes[$io]['name'],0,-4).".change(function() {";
    echo " $(\"#hiddenradio".substr($imgOrdenes[$io]['name'],0,-4)."\").val(sp".substr($imgOrdenes[$io]['name'],0,-4).".json());";
    echo "});";
  }
  unset($i,$io);
}
?>
function cambiaColor(){
  var color = '#'+(Math.floor(Math.random()*16777215).toString(16));
  $(this).attr('data-color',color);
  $(this).css('background-color',color);
}

function usacolor(_v,_editor) {
  console.log(_v);
  <?php
  foreach ($imgOrdenes as $i => $o) {
    echo "if(_editor === \"".substr($o['name'],0,-4)."\"){";
    echo "sp".substr($o['name'],0,-4).".pen().color(_v);";
    echo "}";
  }   
  ?>
};
function clear(_editor) {
  <?php
  foreach ($imgOrdenes as $i => $o) {
    echo "if(_editor === \"".substr($o['name'],0,-4)."\"){";
    echo "sp".substr($o['name'],0,-4).".clear();";
    echo "}";
  }   
  ?>
};
function erase(_editor) {
  <?php
  foreach ($imgOrdenes as $i => $o) {
    echo "if(_editor === \"".substr($o['name'],0,-4)."\"){";
    echo "$(\"#editor_draw_erase\").toggle(function() {";
    echo "$(this).text(\"Borrar\");";
    echo "sp".substr($o['name'],0,-4).".editing(\"erase\");";
    echo "}, function() {";
    echo "$(this).text(\"Dibujar\");";
    echo "sp".substr($o['name'],0,-4).".editing(true);";
    echo "});";
    echo "}";
  }   
  ?>
};
function undo(_editor) {
  <?php
  foreach ($imgOrdenes as $i => $o) {
    echo "if(_editor === \"".substr($o['name'],0,-4)."\"){";
    echo "sp".substr($o['name'],0,-4).".undo();";
    echo "}";
  }   
  ?>
};
</script>
<?php 
    unset($user);
?>
</body>
</html>
