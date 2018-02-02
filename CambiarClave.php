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

    $clave_antigua = "";
    $clave_nueva = "";
    $repita_clave = "";
    $usuario = $usuarioLogueado['idUsuario'];
    $clave = $usuarioLogueado['Clave'];

    $errorClaveNueva ="";
    $errorClaveAntigua="";
    $errorRepitaClave = "";

    $bolErrores = false;
    
    
    
    if(isset($_POST['Modificar'])){
        if(isset($_POST['clave_nueva'])){
            $clave_nueva = $_POST['clave_nueva'];
        }
        if(isset($_POST['repita_clave'])){
            $repitaClave = $_POST['repita_clave'];
        }
        if(isset($_POST['clave_antigua'])){
            $clave_antigua = $_POST['clave_antigua'];
        }
        if($clave_antigua == ""){
            $errorClaveAntigua ="ERROR: Ingrese su contraseña.";
            $boolErrores = true;
        }
        else{
            if($clave_antigua != $clave){
                $errorClaveAntigua = "ERROR: Clave incorrecta";
                $boolErrores = true;
            }
            
        }
        
        
        if($clave_nueva == ""){
            $errorClaveNueva = "ERROR: Debe ingresar clave.";
            $bolErrores=true;
        }
        else{

            //verificamos que la clave tenga al menos un número
            $numeros = "0123456789";
            $tieneNumeros = false;
            for($i=0;$i<strlen($clave);$i++){
                $caracter = $clave[$i];
                $posicion = strpos($numeros,$caracter);
                if($posicion != false){
                    $tieneNumeros = true;
                }
            }
        
            //verificamos que la clave tenga al menos un número
            $letras = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
            $tieneLetras = false;
            for($i=0;$i<strlen($clave);$i++){
                $caracter = $clave[$i];
                $posicion = strpos($letras,$caracter);
                if($posicion != false){
                    $tieneLetras = true;
                }
            }

            if($tieneLetras == false || $tieneNumeros == false){
                $errorClave = "ERROR: Clave debe tener letras y números.";
                $bolErrores=true;
            }

            //strlen devuelve el largo de la cadena
            if(strlen($clave) < 6){
                $errorClave = "ERROR: Clave debe tener mínimo 6 caracteres.";
                $bolErrores=true;
            }
            if($clave_nueva != $repitaClave){
                $errorClave = "ERROR: Claves no coinciden.";
                $bolErrores=true;
            }
        }
        if($bolErrores==false){
            cambiarClave($usuario,$clave_nueva);
            header ('Location: ModificarUsuario.php');
        }
        else{
            echo" errores";
        }
    }
    
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
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <style>
            .etiqueta{
                text-align:right;
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
    </head>
    <body>
        <div class="container-fluid">
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
            <form action="CambiarClave.php" method="POST">
                <div class="row">
                    <div class="col-md-2 etiqueta">Clave Antigua:</div>
                    <div class="col-md-3"><input type="password" placeholder="*****" value="" class="form-control" name="clave_antigua"/></div>
                    <?php if($errorClaveAntigua != ""):?>
                        <div class="col-md-3 alert-danger"><?=$errorClaveAntigua;?></div>
                    <?php endif;?>
                </div>
                <div class="row">
                    <div class="col-md-2 etiqueta">Clave Nueva:</div>
                    <div class="col-md-3"><input type="password" placeholder="*****" value="" class="form-control" name="clave_nueva"/></div>
                    <?php if($errorClaveNueva != ""):?>
                        <div class="col-md-3 alert-danger"><?=$errorClaveNueva;?></div>
                    <?php endif;?>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-2 etiqueta">Repita Clave:</div>
                    <div class="col-md-3"><input type="password" placeholder="*****" value="" class="form-control" name="repita_clave"/></div>
                    <?php if($errorRepitaClave != ""):?>
                        <div class="col-md-3 alert-danger"><?=$errorRepitaClave;?></div>
                    <?php endif;?>
                </div>
                <br/>
                
                
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-6">
                        <input type="submit" value="ModificarC" name="Modificar" class="btn btn-primary"/>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
