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


$idReceta=0;
if(isset($_GET["idReceta"])){
    $idReceta= $_GET["idReceta"];
    
}
if($idReceta!=0){
    //1. Captando Todos los datos de la Receta
    $receta=seleccionarReceta($idReceta);
    $NombreReceta=$receta['NombreReceta'];
    $Descripcion=$receta['Descripcion'];
    $UsuarioReceta=$receta['idUsuario'];
    $calificaciones= CalificacionesReceta($idReceta);
    $contador=0;
    if($calificaciones!=null){
        foreach($calificaciones as $calificacion){
            $cont=$calificacion['Calificacion'];
            $contador=$contador+$cont;
        }
    }
    if(sizeof($calificaciones)!=0){
        $PromedioCalificacionReceta=round($contador/(sizeof($calificaciones)));
    }
    else{
        $PromedioCalificacionReceta=0;

    }
}
//identificacion de no recibir idReceta FALTAAA



?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <style>
        .margenTitulo{
            margin-left:450px;
            font-weight:700;
            font-size: 30px;
            font-family:'AR JULIAN';
        }
        .titulos{
            margin-left:200px;
            font-weight:700;
            font-size:medium;
            font-family: 'HP Simplified';
        }
        .lista{
            margin-left:250px;
        }
        .description{
            margin-left: 200px;
        }
        .nomusu{
            margin-left:900px;
        }
        .caja{
            background-color: lavenderblush;
        }
        #form {
          width: 250px;
          margin: 0 auto;
          height: 50px;
        }

        #form p {
          text-align: center;
        }

        #form label {
          font-size: 20px;
        }

        input[type="radio"] {
          display: none;
        }

        label {
          color: grey;
          font-size:40px;
        }

        .clasificacion {
          direction: rtl;
          unicode-bidi: bidi-override;
          text-align: left;
        }
        .prom
        {
          direction: rtl;
          unicode-bidi: bidi-override;
          text-align: left;
        }

        label:hover,
        label:hover ~ label {
          color: orange;
        }

        input[type="radio"]:checked ~ label {
          color: orange;
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
             $(document).on('click', '.btnGuardarPuntuacion', function () {
                var resultado="ninguno";
                var porEstrella = document.getElementsByName("estrellas");
                for (var i = 0; i < porEstrella.length; i++) {
                    if (porEstrella[i].checked)
                        resultado = porEstrella[i].value;
                }
                $.ajax({
                        method: "POST",
                        url: "Receta.php",
                        data: { idU: '<?php echo $usuarioLogueado['idUsuario'] ?>' , idR:<?php echo $idReceta ?> ,calificacion: resultado  },
                        success: function (resp) {
                            
                            window.location.href = "VerReceta.php?idReceta="+<?php echo $idReceta ?>;
                        }
                    });
                
            });
        
        });
       </script>
    </head>





    <div class="container caja">
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
        <div class="row" id="Receta">
            <div class='row'>
                <div class='row margenTitulo'><?php echo $NombreReceta ?></div>
                <br /><br />
                <div class='row titulos'>Ingredientes:</div><br />
            </div>
            
        </div>
        
        <div class="row" id="ListadoIngredientes">
            <?php
            $productos=productosReceta($idReceta);
            foreach($productos as $producto){
                $idUnd=$producto['UndMedida_idUndMedida'];
                $cantidad=$producto['Cantidad'];
                $idprod=$producto['Producto_idProducto'];
                $Und=seleccionarUnidadMedida($idUnd);
                $Ingr=seleccionarProducto($idprod);
                $NombreP = $Ingr['NombreProd'];
                $NombreU=$Und['NombreMed'];
                
                echo "<div class='row lista'>" ;
                echo "<div class='col-md-1'>● &nbsp &nbsp" . $cantidad . "</div>" ;
                echo "<div class='col-md-1'>" . $NombreU . "</div>" ;
                echo "<div class='col-md-1'>" . $NombreP . "</div>" ;
                echo "</div>";
            }
            ?>
        </div>
        <div class="row" id="DescripcionR">
             <br />
            <div class='row'>
                <div class='row titulos'>Descripcion:</div><br />
                <div class='row description'><div class='col-md-8'><?php echo $Descripcion ?></div></div>
            </div>
        </div>
        <div class="row" id="usuario">
            <?php echo $UsuarioReceta ?>
        </div>
        <br><br>
        <div class="row" id="BtnGuardar">
            <div class="col-md-3"></div>
            
            <div class="col-md-4 clasificacion">
                <?php
                if(CalificadoPorUsuario($usuarioLogueado['idUsuario'],$idReceta)=== false && $usuarioLogueado['idUsuario']!==$UsuarioReceta){
                    echo"<div class='row'>";
                    echo'<div class="col-md-8" id="PuntuacionUsuario">';
                    echo '<input id="radio1" type="radio" name="estrellas"  value="5"><!--' .
                                        '--><label for="radio1">★</label><!--' .
                                        '--><input id="radio2" type="radio" name="estrellas" value="4"><!--' .
                                        '--><label for="radio2">★</label><!--' .
                                        '--><input id="radio3" type="radio" name="estrellas" value="3"><!--' .
                                        '--><label for="radio3">★</label><!--' .
                                        '--><input id="radio4" type="radio" name="estrellas" value="2"><!--' .
                                        '--><label for="radio4">★</label><!--' .
                                        '--><input id="radio5" type="radio" name="estrellas"  value="1"><!--' .
                                        '--><label for="radio5">★</label>';
                    echo "</div>";
                    echo "</div>";
                    echo"<div class='row'>";
                    echo "<div class='col-md-4 btn btn-xs btn-info  btnGuardarPuntuacion'>Guardar Puntuacion</div>";
                    echo "</div>"; 
                }
                else{
                    echo"<div class='row'>";
                    echo'<div class="col-md-8" id="PuntuacionUsuario">';
                    echo "</div>";
                    echo "</div>";
                     echo"<div class='row'>";
                    echo "<div class='col-md-4 '></div>";
                     echo "</div>"; 
                }
            ?>
            </div>
            <div class="col-md-4 prom" id="PromClasificar">
                <?php 
                            switch ($PromedioCalificacionReceta) {
                                case 0:
                                    echo'<input id="radio1" type="radio" name="estrellas"  value="5"><!--' .
                                            '--><label for="radio1">★</label><!--' .
                                            '--><input id="radio2" type="radio" name="estrellas" value="4"><!--' .
                                            '--><label for="radio2">★</label><!--' .
                                            '--><input id="radio3" type="radio" name="estrellas" value="3"><!--' .
                                            '--><label for="radio3">★</label><!--' .
                                            '--><input id="radio4" type="radio" name="estrellas" value="2"><!--' .
                                            '--><label for="radio4">★</label><!--' .
                                            '--><input id="radio5" type="radio" name="estrellas" value="1"><!--' .
                                            '--><label for="radio5">★</label>';
                                    break;
                                case 1:
                                    echo'<input id="radio1" type="radio" name="estrellas"  value="5"><!--' .
                                            '--><label for="radio1">★</label><!--' .
                                            '--><input id="radio2" type="radio" name="estrellas" value="4"><!--' .
                                            '--><label for="radio2">★</label><!--' .
                                            '--><input id="radio3" type="radio" name="estrellas" value="3"><!--' .
                                            '--><label for="radio3">★</label><!--' .
                                            '--><input id="radio4" type="radio" name="estrellas" value="2"><!--' .
                                            '--><label for="radio4">★</label><!--' .
                                            '--><input id="radio5" type="radio" name="estrellas" checked="checked" value="1"><!--' .
                                            '--><label for="radio5">★</label>';
                                    break;
                                case 2:
                                    echo'<input id="radio1" type="radio" name="estrellas"  value="5"><!--' .
                                            '--><label for="radio1">★</label><!--' .
                                            '--><input id="radio2" type="radio" name="estrellas" value="4"><!--' .
                                            '--><label for="radio2">★</label><!--' .
                                            '--><input id="radio3" type="radio" name="estrellas" value="3"><!--' .
                                            '--><label for="radio3">★</label><!--' .
                                            '--><input id="radio4" type="radio" name="estrellas" checked="checked" value="2"><!--' .
                                            '--><label for="radio4">★</label><!--' .
                                            '--><input id="radio5" type="radio" name="estrellas"  value="1"><!--' .
                                            '--><label for="radio5">★</label>';
                                    break;
                                case 3:
                                    echo'<input id="radio1" type="radio" name="estrellas"  value="5"><!--' .
                                            '--><label for="radio1">★</label><!--' .
                                            '--><input id="radio2" type="radio" name="estrellas" value="4"><!--' .
                                            '--><label for="radio2">★</label><!--' .
                                            '--><input id="radio3" type="radio" name="estrellas" checked="checked" value="3"><!--' .
                                            '--><label for="radio3">★</label><!--' .
                                            '--><input id="radio4" type="radio" name="estrellas"  value="2"><!--' .
                                            '--><label for="radio4">★</label><!--' .
                                            '--><input id="radio5" type="radio" name="estrellas"  value="1"><!--' .
                                            '--><label for="radio5">★</label>';
                                    break;
                                case 4:
                                    echo'<input id="radio1" type="radio" name="estrellas"  value="5"><!--' .
                                            '--><label for="radio1">★</label><!--' .
                                            '--><input id="radio2" type="radio" name="estrellas" checked="checked" value="4"><!--' .
                                            '--><label for="radio2">★</label><!--' .
                                            '--><input id="radio3" type="radio" name="estrellas" value="3"><!--' .
                                            '--><label for="radio3">★</label><!--' .
                                            '--><input id="radio4" type="radio" name="estrellas" value="2"><!--' .
                                            '--><label for="radio4">★</label><!--' .
                                            '--><input id="radio5" type="radio" name="estrellas"  value="1"><!--' .
                                            '--><label for="radio5">★</label>';
                                    break;
                                case 5:
                                    echo'<input id="radio1" type="radio" name="estrellas" checked="checked" value="5"><!--' .
                                            '--><label for="radio1">★</label><!--' .
                                            '--><input id="radio2" type="radio" name="estrellas" value="4"><!--' .
                                            '--><label for="radio2">★</label><!--' .
                                            '--><input id="radio3" type="radio" name="estrellas" value="3"><!--' .
                                            '--><label for="radio3">★</label><!--' .
                                            '--><input id="radio4" type="radio" name="estrellas"  value="2"><!--' .
                                            '--><label for="radio4">★</label><!--' .
                                            '--><input id="radio5" type="radio" name="estrellas"  value="1"><!--' .
                                            '--><label for="radio5">★</label>';
                                    break;
                                default:
                                    break;
                            }
                ?>
            </div>
            <div class="row col-md-3 " id="Clasificar"> Casificacion Global</div>
            
        </div>
        
    </div>
</html>