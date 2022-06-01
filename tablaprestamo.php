<!DOCTYPE html>
<html lang="es">
    <head>
        <title>IOSET</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="Shortcut icon"  href="assets/icons/logo.png"/>
        <script src="js/sweet-alert.min.js"></script>
        <link rel="stylesheet" href="css/sweet-alert.css">
        <link rel="stylesheet" href="css/material-design-iconic-font.min.css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css2/estilo2.css">
        <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
        <script>
            window.jQuery || document.write('<script src="js/jquery-1.11.2.min.js"><\/script>')
        </script>
        <script src="js/modernizr.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="js/main.js"></script>
    </head>
<body>
    <div class="navbar-lateral full-reset">
        <div class="visible-xs font-movile-menu mobile-menu-button"></div>
        <div class="full-reset container-menu-movile custom-scroll-containers">  
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>      
            <div class="full-reset" style="background-color:#2B3D51; padding: 10px 0; color:#fff;">
                <figure>
                    <img src="assets/img/3.png" alt="Biblioteca" class="img-responsive center-box" style="width:60%;">
                </figure>
            </div>
            <div class="full-reset nav-lateral-list-menu">
                <ul class="list-unstyled">
                    <li><a href="inicio.php"><i class="zmdi zmdi-home zmdi-hc-fw"></i>&nbsp;&nbsp; Inicio</a></li>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="content-page-container full-reset custom-scroll-containers">
        <div class="footer-copyright full-reset all-tittles">IOSET</div>
            <div class="container">
                <div class="page-header">
                    <h1 class="all-tittles">
                        <center>
                            <font size="10" face="roboto">Préstamos</font>
                        </center>
                    </h1>
                </div>
            </div>
            <div class="container-fluid" style="margin: 50px 0;">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-3"></div>
                        <?php
                                include_once 'conexion2.php';

                                $sentencia_select = $con->prepare('SELECT 
                                                                        prestamo.cod_prestamo,
                                                                        estudiante.nombre as estudiante,
                                                                        estudiante.grado as grado,
                                                                        articulo.descripcion as descripcion,
                                                                        prestamo.cantidad,
                                                                        prestamo.fecha_reg  as fecha
                                                                        FROM prestamo 
                                                                        left join estudiante on prestamo.id_estudiante=estudiante.id
                                                                        left join articulo on prestamo.cod_articulo=articulo.cod_articulo
                                                                        ORDER BY prestamo.cod_prestamo ');
                                $sentencia_select->execute();
                                $resultado = $sentencia_select->fetchAll();

                                // metodo buscar
                                if (isset($_POST['btn_buscar'])) {
                                    $buscar_text = $_POST['txtbuscar'];
                                    if($buscar_text==""){
                                        $select_buscar = $con->prepare('SELECT 
                                                                            prestamo.cod_prestamo,
                                                                            estudiante.nombre as estudiante,
                                                                            estudiante.grado as grado,
                                                                            articulo.descripcion as descripcion,
                                                                            prestamo.cantidad,
                                                                            prestamo.fecha_reg  as fecha
                                                                        FROM prestamo 
                                                                            left join estudiante on prestamo.id_estudiante=estudiante.id
                                                                            left join articulo on prestamo.cod_articulo=articulo.cod_articulo
                                                                            ORDER BY prestamo.cod_prestamo ');
                                        $select_buscar->execute();
                                    }else{
                                        $select_buscar = $con->prepare('SELECT 
                                                                            prestamo.cod_prestamo,
                                                                            estudiante.nombre as estudiante,
                                                                            estudiante.grado as grado,
                                                                            articulo.descripcion as descripcion,
                                                                            prestamo.cantidad,
                                                                            prestamo.fecha_reg  as fecha
                                                                        FROM prestamo 
                                                                            left join estudiante on prestamo.id_estudiante=estudiante.id
                                                                            left join articulo on prestamo.cod_articulo=articulo.cod_articulo
                                                                        WHERE estudiante.nombre LIKE :campo OR articulo.descripcion LIKE :campo;');



                                        $select_buscar->execute(array(':campo' => "%" . $buscar_text . "%" ));
                                    }                    
                                    $resultado = $select_buscar->fetchAll();
                                }
                        ?>
                        <script>

                        // verificar stock
                        /* public function tieneCantidad($id,  $cantidad){
                            $query = "select cantidad from articulo where cod_estudiante = $cod_estudiante";
                            $res = $this->con->ejecutar($query);
                            $cantidadActual = 0;
                            
                            if($reg = mysql_fetch_array($res)){
                                $cantidadActual = $reg[0];
                            }
                           return $cantidadActual >= $cantidad;
                        }*/
                        </script>
                    <body>
                        <div class="contenedor">
                            <div class="barra__buscador">
                                <form action="" class="formulario" method="post">
                                    <input type="text" name="txtbuscar" placeholder="Buscar Nombre Completo" value="<?php if (isset($buscar_text)) echo $buscar_text; ?>" class="input__text">
                                    <input type="submit" class="btn" name="btn_buscar" value="Buscar">
                                    <a href="insertprestamo.php" class="btn btn__nuevo">Nuevo</a>
                                    <a href="tablaarticulo.php" class="btn btn__warning">Ver Artículos</a>
                                    <a href="tablaestudiantes.php" class="btn btn__dark">Ver Estudiantes</a>
                                </form>
                            </div>
                            <div class="cualquiera">
                                <table>
                                    <tr class="head">
                                        <td>Id</td>
                                        <td>Estudiante</td>
                                        <td>Grado</td>
                                        <td>Artículo</td>     
                                        <td>Cantidad</td>                             
                                        <td>Fecha</td>
                                        <td colspan="2">Acción</td>
                                    </tr>
                                    <?php foreach ($resultado as $fila) : ?>
                                        <tr>
                                            <td><?php echo $fila['cod_prestamo']; ?>    </td>
                                            <td><?php echo $fila['estudiante']; ?>      </td>
                                            <td><?php echo $fila['grado']; ?>      </td>
                                            <td><?php echo $fila['descripcion']; ?>     </td>                                   
                                            <td><?php echo $fila['cantidad']; ?>        </td>
                                            <td><?php echo $fila['fecha']; ?>           </td>
                                            <td><a href="updateprestamo.php?cod_prestamo=<?php echo $fila['cod_prestamo']; ?>" class="btn btn__update">Editar</a></td>
                                            <td><a href="deleteprestamo.php?cod_prestamo=<?php echo $fila['cod_prestamo']; ?>" class="btn btn__delete">Eliminar</a></td>
                                        </tr>
                                    <?php endforeach ?>

                                </table>
                            </div>
                        </div>
                </div>
            </div>
        <div class="container-fluid">
        </div>
        <footer class="footer full-reset">
            <div class="footer-copyright full-reset all-tittles">Promocion 2021</div>
            <footer>
            <p class="footer-copyright full-reset all-tittles">&copy; Felipe Villamizar, Samuel Chamorro, Isabella Arango, Liz Gonzalez, Cristian Polo</p>
            </footer>
        </footer>
        

    </div>
</body>
</html>