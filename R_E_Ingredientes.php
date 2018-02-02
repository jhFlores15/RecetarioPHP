<?php

    include_once 'bd/conexion.php';

    if (!session_id()) @session_start();
    if(isset($_SESSION['conectado'])){
        $usuarioLogueado = $_SESSION['conectado'];
        if($usuarioLogueado == null){
            header("Location: Login.php");
        }
        else {
            $administrador=$usuarioLogueado['Administrador'];
            if($administrador!=1){
                header("Location: ModificarUsuario.php");
            }
        }
    }
    else{
        header("Location: Login.php");
    }
    
    $errorProducto="";
    
    $usuario=0;
    if(isset($_POST['Producto'])){
        if(isset($_POST['producto'])){
            $producto = $_POST['producto'];
        }
        if($producto==""){
            $errorProducto="Error: Ingrese Nombre";
        }
        else{
            agregarProducto($producto);
            
        }
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
            .etiqueta{
                text-align:right;
            }
            .encabezado{
                font-weight: 700;
                font-size: 14px;
                border-bottom: 4px solid;
            }
            .accion{
                padding-left: 60px;
            }
            .usu{
                font-size: 20px;
                font-weight: 700;
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
                $(document).on('click', '.btnEliminar', function () {
                    var id = $(this).attr('id');
                    var mensaje = confirm("¿Estar Seguro de Eliminar?");
                    //Detectamos si el usuario acepto Eliminar
                    if (mensaje) {
                        $.ajax({
                           method: "POST",
                           url: "Ingredientes.php",
                           data: { id_producto: id }
                        }).done(function( resp ) {
                            console.log(resp);
                            if(resp!==""){
                                alert("No se puede eliminar producto");
                            }
                            else{
                                window.location.href = "R_E_Ingredientes.php";
                            }
                            
                        }); 
                    }
                     
                 }); 
                 $(document).on('click', '.btnEditar', function () {
                var person = prompt("Ingrese nombre para modificar");
                if (person != null && person!="") {
                    var id = $(this).attr('id');
                     $.ajax({
                        method: "POST",
                        url: "Ingredientes.php",
                        data: { idProd: id , nombre:person},
                        success: function (resp) {
                            window.location.href = "R_E_Ingredientes.php";
                        }
                    });

                } else {
                    alert("Debe ingresar un nombre valido");
                }
            });
             });
             
        </script>
        
    </head>
    <body>
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
             <form action="R_E_Ingredientes.php" method="POST">
            <br>
            <div class="col-md-12">
                
                <div class="row">
                    
                    <div class="col-md-2 etiqueta">Ingrediente:</div>
                    <div class="col-md-3  ">
                        <input type="text" class="form-control" name="producto" >
                    </div>
                    <?php if ($errorProducto != ""): ?>
                        <div class="col-md-3 alert-danger"><?= $errorProducto; ?></div>
                    <?php endif; ?>
                        <div class="col-md-2">
                            <input type="submit" value="Agregar" name="Producto" class="btn btn-primary"/>
                        </div>
                </div>
                 
                <br>
                <div class="row encabezado ">
                    <div class="col-md-1">ID</div>
                    <div class="col-md-1">Nombre</div>
                </div>
                <br>
                <?php
                $productos = seleccionarProductos();
                foreach ($productos as $producto) {
                    echo "<div class='row'>";
                    echo "<div class='col-md-1'>" . $producto['idProducto'] . "</div>";
                    echo "<div class='col-md-1'>" . $producto['NombreProd'] . "</div>";
                    echo "<div class='col-md-3'>";
                    echo"<div class='col-md-3 bordeGris espacioBoton btn btn-xs btn-danger btnEliminar' id=" . $producto['idProducto'] .">Eliminar</div>";
                    echo"<div class='col-md-3 bordeGris espacioBoton btn btn-xs btn-danger btnEditar' id=" . $producto['idProducto'] .">Editar</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "<br>";
                }
                ?>

            </div>
            </form>
        </div> 
    </body>
</html>