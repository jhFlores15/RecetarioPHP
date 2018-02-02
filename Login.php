<?php
$usuario="";
$contrasena="";
$boolErrores=false; 
$errorUsuario="";
$errorPass="";
$usuarioLogueado=null;    
include_once 'bd/conexion.php';
    $usuario=0;
    if(isset($_POST['Login'])){
        if(isset($_POST['usuario'])){
            $usuario = $_POST['usuario'];
        }
        if(isset($_POST['contrasena'])){
            $contrasena = $_POST['contrasena'];
        }   
        
        if($contrasena == ""){
            $errorPass = "ERROR: Debe ingresar password.";
        }
        if($usuario == ""){
            $errorUsuario = "ERROR: Debe ingresar nombre de usuario.";
        }
        if($contrasena!="" && $usuario!=""){
            $usuarioLogueado=seleccionarUsuario($usuario);
            if($usuarioLogueado!=null){
                $claveUsuario=$usuarioLogueado['Clave'];
                
                if(password_verify($contrasena, $claveUsuario)){
                    if (!session_id()) @session_start();
                    $_SESSION['conectado'] = $usuarioLogueado;
                    header("Location: ModificarUsuario.php");
                }
                else{
                    $boolErrores=true;
                }
            }
            else{
                $boolErrores=true;
            }
        }
    }


?>

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
                                echo '<li><a href="ModificarUsuario.php">Bienvenid@ '+$usuarioLogueado['NombreUsu']+'</a></li>';
                            }
                            else{
                                echo '<li><a href="Login.php">Login</a></li>';
                                echo '<li><a href="RegistroUsuario.php">Registrarse</a></li>';
                            }
                            
                        ?>
                </ul>
            </div>
            <form action="Login.php" method="POST">
                <div class="row">
                    <br>
                    <div class="row">
                        <div class="col-md-2 etiqueta">Nombre Usuario:</div>
                        <div class="col-md-3  ">
                            <input type="text" class="form-control" name="usuario" >
                        </div>
                        <?php if($errorUsuario != ""):?>
                        <div class="col-md-3 alert-danger"><?=$errorUsuario;?></div>
                        <?php endif;?>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2 etiqueta">Contraseña:</div>
                        <div class="col-md-3">
                            <input type="password" class="form-control" placeholder="********" name="contrasena">
                        </div>
                        <?php if($errorPass != ""):?>
                        <div class="col-md-3 alert-danger"><?=$errorPass;?></div>
                        <?php endif;?>
                    </div>
                    <br>
                    
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-6">
                            <input type="submit" value="Login" name="Login" class="btn btn-primary"/>
                        </div>
                    </div>
                    <br>
                    <?php
                    if($boolErrores==true){
                    ?>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2 alert-danger">Rut y/o Contraseña Incorrecta</div>
                    </div>
                    <?php }?>
                </div>
            </form>
        </div>
    </body>
</html>