<?php
    require_once "comercio_model.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bachaquero.com</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bootstrap-comercio/dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/comercio/comercio.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../fonts/font-awesome-comercio/css/font-awesome.css" rel="stylesheet" type="text/css" >

</head>

<body oncontextmenu="return false" onkeydown="return false">
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top barra-top" role="navigation" style="margin-bottom: 0">
            
            <!-- /.navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand ff-enigma" href="index.php">
                    Bachaquero.com
                </a>
            </div>
            
            <!-- /.navbar-top-links -->
            <ul class="nav navbar-top-links navbar-right">
                <li id='ventanaCarrito'  class="dropdown">
                    <a class="dropdown-toggle menu-derecha" data-toggle="dropdown" href="#">
                        <b id='totalProductos'>0</b><i class="fa fa-shopping-cart fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>         
                    <!-- /.dropdown-alerts -->
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle menu-derecha" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->

            </ul>


            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a class="seccion-activa" href="index.php"><i class="fa fa-home fa-fw"></i>Inicio</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-tags fa-fw"></i> Categorías<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Todo las categorías</a>
                                </li>
                                <li>
                                    <a href="#">Video</a>
                                </li>
                                <li>
                                    <a href="#">Audio</a>
                                </li>
                                <li>
                                    <a href="#">Electr&oacute;nica</a>
                                </li>
                                <li>
                                    <a href="#">Computaci&oacute;n</a>
                                </li>
                                <li>
                                    <a href="#">L&iacute;nea Blanca</a>
                                </li>
                                <li>
                                    <a href="#">Electrodom&eacute;sticos</a>
                                </li>
                                <li>
                                    <a href="#">Celulares</a>
                                </li>
                                <li>
                                    <a href="#">Videojuegos</a>
                                </li>
                                <li>
                                    <a href="#">Accesorios</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-star fa-fw"></i> M&aacute;s Vendidos</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-clock-o  fa-fw"></i> Recientes</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="container-contenido">
                            <div class="row">
                                <div class="col-xs-12">
                                    <ul class="nav navbar-nav navbar-right">
                                        <li >
                                            <a href="#" onclick="increaseSize()">
                                                <i class="fa fa-search-plus fa-fw"></i> A+
                                            </a>
                                        </li>
                                        <li >
                                            <a href="#" onclick="decreaseSize()">
                                                <i class="fa fa-search-minus fa-fw"></i> A-
                                            </a>
                                        </li>
                                        <li >
                                            <a href="#">
                                                <i class="fa fa-eye fa-fw"></i> Constraste
                                            </a>
                                        </li>
                                        <li >
                                            <a href="#">
                                                <i class="fa fa-volume-up fa-fw"></i> Audio
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>    
                            
                            
                            <div class="separador"></div>

                            <h1 class="titulo ff-enigma">Bienvenido al Bachaquero.com</h1>

                            <div class="container-img">
                                <img  src="../img/comercio/profile.png">
                            </div>
                            <br>
                            <h1 class="titulo ff-enigma">Recomendaciones</h1>
                            
                            <div class="row">
                                <div class="col-xs-12">
                                    <ul class="nav navbar-nav navbar-left">
                                        <?php
                                            $productos=get_productos();
                                            for ($i = 0; $i < count($productos); $i++) {
                                                echo "<li >
                                                        <a href='#'>
                                                            <div id='".$productos[$i]['codigo_barra']."' class='container-producto'>
                                                                <div class='container-credito-img'>
                                                                    <img class='img-producto' src='../img/comercio/productos/".$productos[$i]['codigo_barra'].".jpg'>
                                                                </div>
                                                                <br>
                                                                <p id='nombre_producto'>".$productos[$i]['nombre']."</p>
                                                                <p id='precio_producto'>".$productos[$i]['precio_total']." Bs.</p>
                                                 
                                                                <div class='art-carrito' onclick='agregarACarrito(".$productos[$i]['codigo_barra'].")'>
                                                                   <i  class = 'fa fa-shopping-cart fa-fw' >
                                                                    </i> Agregar a Carrito
                                                                </div>
                                                            </div>
                                                        </a>
                                                     </li>
                                                     ";
                                            }
                                        ?>                                   
                                    </ul>
                                </div>
                            </div>
                                                        
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

        
            <div class="container-footer">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p class="text-footer ff-enigma">Licencia Creative Commons</p>
                        <a href="https://creativecommons.org/licenses/by-nc-sa/3.0/ve/" target="_blank">
                            <img id="logo-licencia" src="../img/comercio/cc.png">
                        </a>
                    </div>
                </div>
                
            </div>
        
        <?php
            $cod_afiliacion=get_cod_afiliacion_comercio();

            echo "
                <form action='../banco/index.php' method='post' id='form_boton_pago' name='form_boton_pago'>
                 <input type='hidden' name='cod_afiliacion' value='".$cod_afiliacion['cod_afiliacion_comercio']."'>
                 <input type='hidden' name='monto_total' value=''>
                </form> 
                ";
        ?>



    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bootstrap-comercio/dist/js/bootstrap.min.js"></script>

    <!-- Menu Plugin JavaScript -->
    <script src="../js/comercio/menu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../js/comercio/comercio.js"></script>

</body>

</html>
