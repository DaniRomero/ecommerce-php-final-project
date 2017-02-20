<?php
    require_once "servicio_banco_model.php";
    $monto=intval($_POST["monto_total"]);;
    $cod_comercio=$_POST["cod_afiliacion"];
    
    //$monto=1000;
    //$cod_comercio='1l2j3d';
    //$cod_comercio='hola';

?>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Bancomercio</title>
    <!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/banco/freelancer.css" rel="stylesheet">

    <link href="../css/banco/banco.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body id="page-top" class="index">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#page-top">Bancomercio</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="page-scroll">
                        <a href="#page-top">Inicio</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#pago">Pagar</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-responsive" src="../img/banco/bancomercio.png" alt="">
                    <div class="intro-text">
                        <span class="name">Bancomercio</span>
                        <span class="skills">Centro de Pago</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
        <section id="pago">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Formulario de Pago</h2>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">       
                    <?php
                        $comercio=get_datos_comercio($cod_comercio);
                        if ($comercio!=NULL){
                            echo "
                                <form action='pago.php' role='form' method = 'post' class='col-lg-8 col-lg-offset-2'>
                                <div class='form-group'>
                                <h4>Comercio:".$comercio['razon_social']."</h4>
                                <h3> Monto a Pagar: $monto Bs. </h3>
                                <input style='visibility:hidden;'' type='text' name='monto' value='$monto'>
                                <input style='visibility:hidden;'' type='text' name='cod_comercio' value='$cod_comercio'>
                                </div>
                                  <div class='form-group'>
                                    <label for='tipo_tarjeta'>Tipo de Tarjeta</label>
                                    <div class='row'>
                                        <div class='col-xs-3'>
                                            <input type='radio' name='tipo_tarjeta'  value='visa' required>
                                                <img src='../img/banco/visa.png' widht='50' height='30'>
                                            </input>
                                        </div>
                                        <div class='col-xs-3'>
                                            <input type='radio' name='tipo_tarjeta'  value='mastercard' required>
                                                <img src='../img/banco/mastercard.png' widht='50' height='30'>
                                            </input>
                                        </div>
                                    </div>
                                  </div>
                                   <div class='form-group'>
                                    <label for='num_tarjeta'>N&uacute;mero de Tarjeta de Cr&eacute;dito</label>
                                    <input type='text' class='form-control' name='num_tarjeta' 
                                    placeholder='Ejemplo: 4777122261785791' pattern='(4|5)(000|111|222|333|444|555|666|777|888|999)[0-9]{12}'
                                     required>
                                  </div>

                                  <div class='form-group'>
                                    <label>Fecha de Vencimiento</label>
                                    <input type='text' class='form-control' name='fecha_venc' 
                                    placeholder='Ejemplo: 02/2016' 
                                    pattern='(0[1-9]|1[0-2])/20(1[6-9]|2[0-6])' required>
                                  </div>

                                  <div class='form-group'>
                                    <label for='cod_seguridad'>C&oacute;digo de Seguridad</label>
                                        <input type='text'  class='form-control' name='cod_seguridad' 
                                        placeholder='Ejemplo: 158' pattern='[0-9]{3}' required>
                                  </div>

                                  <div class='form-group'>
                                    <label for='ci_titular'>C&eacute;dula del Titular</label>
                                        <input type='text' class='form-control' name='ci_titular' 
                                        placeholder='Ejemplo: 23123678' required>                          
                                  </div>
                                  <br>
                                  <!--div class='form-group'-->
                                        <div class='row'>
                                            <div class='col-lg-6'>
                                                <input type='submit'  value='Pagar' name='btn_pagar' class='btn btn-success btn-lg col-lg-8 col-lg-offset-2'/>
                                            </div>
                                            <div class='col-lg-6'>
                                                <a type='button'  value='Cancelar' name='btn_cancelar' href='../comercio/' class='btn btn-success btn-lg col-lg-8 col-lg-offset-2'/>Cancelar</a>
                                            </div>
                                        </div>
                                  <!--/div-->
                                </form> 
                                ";                                        
                        }else{
                            echo "  <h4> Lo Sentimos, no podemos procesar su compra.</h4>
                                    <pre class='pre-no-exito'>Comercio no identificado. <br></pre><br><br>
                                    <div class='col-lg-12'>
                                        <a type='button'  name='btn_cancelar' href='../comercio/' class='btn btn-success btn-lg col-lg-4 col-lg-offset-4'/>Volver</a>
                                    </div>
                                ";
                        }  
                    ?>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; CedAx 2018
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll visible-xs visible-sm">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="../js/banco/classie.js"></script>
    <script src="../js/banco/cbpAnimatedHeader.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="../js/banco/jqBootstrapValidation.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../js/banco/freelancer.js"></script>

    <!-- Banco Theme JavaScript -->
    <script src="../js/banco/banco.js"></script>

</body>

</html>





    