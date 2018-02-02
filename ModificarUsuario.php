<?php

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


$errorEmail = "";
$errorNombre = "";
$errorFecha = "";
$errorSexo = "";


include_once 'bd/conexion.php';
    $email = $usuarioLogueado['Email'];
    $nombreUsu = $usuarioLogueado['idUsuario'];
    $nombre = $usuarioLogueado['NombreUsu'];
    $fecha = $usuarioLogueado['FechaNacimiento'];
    $sexo = $usuarioLogueado['Sexo'];
    $administrador = $usuarioLogueado['Administrador'];
$bolErrores=false;

if(isset($_POST['Modificar'])){
    if(isset($_POST['nombreUsu'])){
        $nombreUsu = $_POST['nombreUsu'];
    }
    if(isset($_POST['email'])){
        $email = $_POST['email'];
    }
    if(isset($_POST['nombre'])){
        $nombre = $_POST['nombre'];
    }
    if(isset($_POST['fecha'])){
        $fecha = $_POST['fecha'];
    }
    if(isset($_POST['sexo'])){
        $sexo = $_POST['sexo'];
    }
    if(isset($_POST['administrador'])){
        $administrador = $_POST['administrador'];
    }
    if($nombre == ""){
        $errorNombre = "ERROR: Debe ingresar nombre.";
        $bolErrores=true;
    }
    if($email == ""){
        $errorEmail = "ERROR: Debe ingresar email.";
        $bolErrores=true;
    }
    else{
        //strpos sirve para verficiar si en un string (variable)
        //existe un caracter en específico.
        //en este ejemplo se verifica que en $email exista @
        //si existe, entonces devuelve la posición donde esté
        //si no existe devuelve false
        if(strpos($email, "@")== false){
            $errorEmail = "ERROR: E-mail incorrecto.";
            $bolErrores=true;
        }
        if(strpos($email, ".")== false){
            $errorEmail = "ERROR: E-mail incorrecto.";
            $bolErrores=true;
        }
    }
    
    if($fecha == ""){
        $errorFecha = "ERROR: Debe ingresar fecha.";
        $bolErrores=true;
    }
    else{
        //el explode revisa si existe un caracter dentro de una cadena
        //y si existe, entonces separa la cadena de acuerdo a ese caracter
        //creando un arreglo para cada posición un trozo de la cadena.
        $arrFecha = explode("-", $fecha);
        //count devuelve el tamaño de arreglo
        if(count($arrFecha) != 3){
            $errorFecha = "ERROR: Fecha debe tener el formato aaaa-mm-dd.";
            $bolErrores=true;
        }
        else{
            //strlen devuelve el largo de una cadena
            if(strlen($arrFecha[0])!=4){
                $errorFecha = "ERROR: Fecha debe tener el formato aaaa-mm-dd.";
                $bolErrores=true;
            }
            if(strlen($arrFecha[1])!=2){
                $errorFecha = "ERROR: Fecha debe tener el formato aaaa-mm-dd.";
                $bolErrores=true;
            }
            if(strlen($arrFecha[2])!=2){
                $errorFecha = "ERROR: Fecha debe tener el formato aaaa-mm-dd.";
                $bolErrores=true;
            }
        }
    }
    if($sexo == ""){
        $errorSexo = "ERROR: Debe ingresar un valor para sexo.";
        $bolErrores=true;
    }
    //////////////////////////////////////////////////////
    if($bolErrores==false){
       editarUsuario($nombreUsu,$email,$nombre,$fecha,$sexo,$administrador);
    ///poner mensaje 
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
            <form action="ModificarUsuario.php" method="POST">
                
                <br/>
                <div class="row">
                    <div class="col-md-2 etiqueta">Nombre Usuario:</div>
                    <div class="col-md-3"><input value="<?=isset($_POST['Modificar'])?$nombreUsu:$nombreUsu?>" type="text" placeholder="Nombre" disabled="true" class="form-control" name="nombre"/></div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-2 etiqueta">Nombre:</div>
                    <div class="col-md-3"><input value="<?=isset($_POST['Modificar'])?$nombre:$nombre?>" type="text" placeholder="Nombre" class="form-control" name="nombre"/></div>
                    <?php if($errorNombre != ""):?>
                    <div class="col-md-3 alert-danger"><?=$errorNombre;?></div>
                    <?php endif;?>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-2 etiqueta">E-mail:</div>

                    <div class="col-md-3"><input type="text" value="<?=isset($_POST['Modificar'])?$email:$email?>" placeholder="ejemplo@email.com" class="form-control" name="email"/></div>
                    <?php if($errorEmail != ""):?>
                    <div class="col-md-3 alert-danger"><?=$errorEmail;?></div>
                    <?php endif;?>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-2 etiqueta">Fecha Nacimiento:</div>
                    <div class="col-md-3"><input type="text" placeholder="aaaa-mm-dd" class="form-control" value="<?=isset($_POST['Modificar'])?$fecha:$fecha?>" name="fecha"/></div>
                    <?php if($errorFecha != ""):?>
                    <div class="col-md-3 alert-danger"><?=$errorFecha;?></div>
                    <?php endif;?>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-2 etiqueta">Sexo:</div>
                    <div class="col-md-3">
                        <input type='radio' name='sexo' <?=($sexo == 'M')?"checked":""?> value='M'/> Masculino
                        <input type='radio' name='sexo' <?=($sexo == 'F')?"checked":""?> value='F'/> Femenino</div>
                    <?php if($errorSexo != ""):?>
                    <div class="col-md-3 alert-danger"><?=$errorSexo;?></div>
                    <?php endif;?>
                </div>
                <br/>                         
                
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-6">
                        <input type="submit" value="Modificar" name="Modificar" class="btn btn-primary"/>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
