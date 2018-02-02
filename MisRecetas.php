<?php
include_once 'bd/conexion.php';
if (!session_id()) @session_start();
    if(isset($_SESSION['conectado'])){
        $usuarioLogueado = $_SESSION['conectado'];
        if($usuarioLogueado == null){
            header("Location: Login.php");
        }
    }
    else{
        header("Location: Login.php");
    }
    
?>
<html>
    
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <style>
        .textonegrita{
            font-weight:700;
        }
        .sangriaizq{
            margin-left: 60px;
        }
        .sangriacolumnas{
            border-bottom: 1px solid lightgray;
            margin-left: 1px;
            margin-top: 2px;
        }
        .espacioBoton{
            margin-bottom: 6px;

        }
        .bordeGris{
            border-bottom: 1px solid lightgray;
        }
        .espacioBtnEliminar{
            margin-right: 5px;
        }
        .labelError{
            color: red;
            font-weight:700;
        }
   .black{
                background: black;
            }
        </style>
        		<style type="text/css">
			
			* {
				margin:0px;
				padding:0px;
			}
			
			#header {
				margin:auto;
				width:100%;
				font-family:Arial, Helvetica, sans-serif;
			}
			
			ul, ol {
				list-style:none;
			}
			
			.nav > li {
				float:left;
			}
			
			.nav li a {
				background-color:#000;
				color:#fff;
				text-decoration:none;
				padding:10px 12px;
				display:block;
			}
			
			.nav li a:hover {
				background-color:#434343;
			}
			
			.nav li ul {
				display:none;
				position:absolute;
				min-width:140px;
			}
			
			.nav li:hover > ul {
				display:block;
			}
			
			.nav li ul li {
				position:relative;
			}
			
			.nav li ul li ul {
				right:-140px;
				top:0px;
			}
			
		</style>
    <script>
        $(document).ready(function (e) {
            $(document).on('click', '.btnEditar', function () {
                var id = $(this).attr('id');
                window.location.href = "EditarReceta.php?idReceta="+id;
            });
            $(document).on('click', '.btnVer', function () {
                var id = $(this).attr('id');
                window.location.href = "VerReceta.php?idReceta=" + id;
            });  

            $(document).on('click', '.btnEliminar', function () {
                var id = $(this).attr('id');
                //verificar eliminacion de solo mis recetas
                console.log(id);
                var mensaje = confirm("¿Estar Seguro de Eliminar?");
                if (mensaje) {
                    $.ajax({
                        method: "POST",
                        url: "Receta.php",
                        data: { idReceta: id },
                        success: function (resp) {
                            console.log(resp);
                            window.location.href = "MisRecetas.php";
                        }
                    });
                }
            });
        });
    </script>
    </head>
    <div class="container">
        <div  id="header">
                <ul class="nav black">
                        <?php 
                            if($usuarioLogueado!=null){
                                if($usuarioLogueado['Administrador']==1){
                                    echo '<li><a href="R_E_Ingredientes.php">Ingredientes</a></li>';
                                    echo '<li><a href="RegistroUsuario.php">Registrar Administradores</a></li>';
                                }
                                
                                echo '<li><a href="ModificarUsuario.php">Mi Perfil</a></li>';
                                echo '<li><a href="CrearReceta.php">Crear Receta</a></li>';
                                echo '<li><a href="MisRecetas.php">Mis Recetas</a></li>';
                                echo '<li><a href="RankingRecetas.php">Ranking</a></li>';
                                echo '<li><a href="CambiarClave.php">Cambiar Clave</a></li>';
                                echo '<li><a href="CerrarSesion.php">Cerrar Sesion</a></li>';
                            }
                            else{
                                echo '<li><a href="Login.php">Login</a></li>';
                                echo '<li><a href="RegistroUsuario.php">Registrarse</a></li>';
                            }
                            
                        ?>
                </ul>
            </div>
    <div class="row " id="ListadeRecetasUsuario">
        <div class="row encabezado ">
                    <div class="col-md-1">NombreReceta</div>
                    <div class="col-md-1">Calificacion</div>
                </div>
                <br>
                <?php
                $idUsuario=$usuarioLogueado['idUsuario'];
                $recetas = seleccionarRecetasUsuario($idUsuario);
                foreach ($recetas as $receta) {
                    $idReceta=$receta['idReceta'];
                    $calificaciones= CalificacionesReceta($idReceta);
                    $contador=0;
                    if($calificaciones!=null){
                        foreach($calificaciones as $calificacion){
                            $cont=$calificacion['Calificacion'];
                            $contador=$contador+$cont;
                        }
                    }
                    $PromedioCalificacionReceta=$contador/(sizeof($calificaciones)+1);
                    echo "<div class='row'>";
                    echo "<div class='col-md-1'>" . $receta['NombreReceta'] . "</div>";
                    echo "<div class='col-md-1'>" . round($PromedioCalificacionReceta). "</div>";
                    echo "<div class='col-md-3'>";
                    echo"<div class='col-md-3 bordeGris espacioBoton btn btn-xs btn-danger btnEliminar' id=" . $receta['idReceta'] .">Eliminar</div>";
                    echo"<div class='col-md-3 bordeGris espacioBoton btn btn-xs btn-danger btnEditar' id=" . $receta['idReceta'] .">Editar</div>";
                    echo"<div class='col-md-3 bordeGris espacioBoton btn btn-xs btn-danger btnVer' id=" . $receta['idReceta'] .">Ver</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "<br>";
                }
                ?>

            </div>
    </div>
</html>


    