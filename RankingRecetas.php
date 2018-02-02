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
            .margen {
                margin-left: 50px;
            }
            .botones{
                width: 150px;
                margin-right: 10px;
            }
            .margenboton{
                margin-left: 90px;
            }
            .bordeGris{
                border-bottom: 1px solid lightgray;
            }
            .textonegrita{
                font-weight:700;
            }
            .tituloreceta{
                margin-left: 450px;
                font-size: 30px;
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
                window.onload= function CargarDatos() {
                    $.ajax({
                        method: "POST",
                        url: "Receta.php",
                        data: { RankingReceta:""},
                        success: function (resp) {
                            var Recetas=$.parseJSON(resp);
                            //Ordena Mayor a Menor
                            //Ordenar descendentemente por atributo
                            Recetas.sort(function (a, b){
                                return (b.Promedio - a.Promedio)
                            });
                            var html = "";
                            html += "<br /><div class='row'>" +
                                "<div class='col-md-2 btn btn-xs btn-success btnAscendentePromedioRecetas botones margenboton' >Orden Ascendente</div>" +
                                "<div class='col-md-2 btn btn-xs btn-success btnRecetasPromedioRecetas botones'>Orden Descendente</div>" +
                                "</div > <br /><br />" +
                                "<div class='row margen textonegrita'>" +
                                "<div class='col-md-2 bordeGris'>Nombre de Receta</div>" +
                                "<div class='col-md-2 bordeGris'>Creado Por</div>" +
                                "<div class='col-md-3 bordeGris'>Promedio De Estrellas</div>" +
                                "</div>" +
                                "<br />";
                            //Relleno de Listado
                            for (var i = 0; i < Recetas.length; i++) {
                                html += "<div class='row margen'>" +
                                    " <div class='col-md-2 bordeGris'>" + Recetas[i].Nombre + "</div>" +
                                    " <div class='col-md-2 bordeGris'>" + Recetas[i].idUsuario + "</div>" +
                                    " <div class='col-md-2 bordeGris'>" + Recetas[i].Promedio + "</div>" +
                                    " <div class='col-md-1 btn btn-xs btn-info btnVer' id='" + Recetas[i].idReceta + "'>Ver Receta</div>" +
                                    " </div>";
                            }
                            $('#Listado').html(html);
                        }
                    });
                };
                $(document).on('click', '.btnVer', function () {
                    var id = $(this).attr('id');
                    window.location.href = "VerReceta.php?idReceta=" + id;
                });
                $(document).on('click', '.btnRecetasPromedioRecetas', function () {
                    $.ajax({
                        method: "POST",
                        url: "Receta.php",
                        data: { RankingReceta:""},
                        success: function (resp) {
                            var Recetas=$.parseJSON(resp);
                            //Ordena Mayor a Menor
                            //Ordenar descendentemente por atributo
                            Recetas.sort(function (a, b){
                                return (b.Promedio - a.Promedio)
                            });
                            var html = "";
                            html += "<br /><div class='row'>" +
                                "<div class='col-md-2 btn btn-xs btn-success btnAscendentePromedioRecetas botones margenboton' >Orden Ascendente</div>" +
                                "<div class='col-md-2 btn btn-xs btn-success btnRecetasPromedioRecetas botones'>Orden Descendente</div>" +
                                "</div > <br /><br />" +
                                "<div class='row margen textonegrita'>" +
                                "<div class='col-md-2 bordeGris'>Nombre de Receta</div>" +
                                "<div class='col-md-2 bordeGris'>Creado Por</div>" +
                                "<div class='col-md-3 bordeGris'>Promedio De Estrellas</div>" +
                                "</div>" +
                                "<br />";
                            //Relleno de Listado
                            for (var i = 0; i < Recetas.length; i++) {
                                html += "<div class='row margen'>" +
                                    " <div class='col-md-2 bordeGris'>" + Recetas[i].Nombre + "</div>" +
                                    " <div class='col-md-2 bordeGris'>" + Recetas[i].idUsuario + "</div>" +
                                    " <div class='col-md-2 bordeGris'>" + Recetas[i].Promedio + "</div>" +
                                    " <div class='col-md-1 btn btn-xs btn-info btnVer' id='" + Recetas[i].idReceta + "'>Ver Receta</div>" +
                                    " </div>";
                            }
                            $('#Listado').html(html);
                        }
                    });
                });
                $(document).on('click', '.btnAscendentePromedioRecetas', function () {
                    $.ajax({
                        method: "POST",
                        url: "Receta.php",
                        data: { RankingReceta:""},
                        success: function (resp) {
                            console.log(resp);
                            var Recetas=$.parseJSON(resp);
                            //Ordenar ascendentemente por atributo
                            Recetas.sort(function (a, b) {
                                return (a.Promedio - b.Promedio)
                            });
                            var html = "";
                            html += "<br /><div class='row'>" +
                                "<div class='col-md-2 btn btn-xs btn-success btnAscendentePromedioRecetas botones margenboton' >Orden Ascendente</div>" +
                                "<div class='col-md-2 btn btn-xs btn-success btnRecetasPromedioRecetas botones'>Orden Descendente</div>" +
                                "</div > <br /><br />" +
                                "<div class='row margen textonegrita'>" +
                                "<div class='col-md-2 bordeGris'>Nombre de Receta</div>" +
                                "<div class='col-md-2 bordeGris'>Creado Por</div>" +
                                "<div class='col-md-3 bordeGris'>Promedio De Estrellas</div>" +
                                "</div>" +
                                "<br />";
                            //Relleno de Listado
                            for (var i = 0; i < Recetas.length; i++) {
                                html += "<div class='row margen'>" +
                                    " <div class='col-md-2 bordeGris'>" + Recetas[i].Nombre + "</div>" +
                                    " <div class='col-md-2 bordeGris'>" + Recetas[i].idUsuario + "</div>" +
                                    " <div class='col-md-2 bordeGris'>" + Recetas[i].Promedio + "</div>" +
                                    " <div class='col-md-1 btn btn-xs btn-info btnVer' id='" + Recetas[i].idReceta + "'>Ver Receta</div>" +
                                    " </div>";
                            }
                            $('#Listado').html(html);
                        }
                    });
                });
                $(document).on('click', '.btnCocinerosRecetas', function () {
                    $.ajax({
                        method: "POST",
                        url: "Receta.php",
                        data: { RankingCocinerosReceta:""},
                        success: function (resp) {
                            var RecetasCocineros=$.parseJSON(resp);
                            //Ordenar descendentemente por atributo
                            RecetasCocineros.sort(function (a, b) {
                                return (b.CantidadRecetas - a.CantidadRecetas)
                            });
                            var html = "";
                            html += "<br /><div class='row'>" +
                                "<div class='col-md-2 btn btn-xs btn-success btnAscendenteRecetas botones margenboton' >Orden Ascendente</div>" +
                                "<div class='col-md-2 btn btn-xs btn-success btnCocinerosRecetas botones'>Orden Descendente</div>" +
                                "</div > <br /><br />" +
                                "<div class='row margen textonegrita'>" +
                                "<div class='col-md-2 bordeGris'>Nombre Usuario</div>" +
                                "<div class='col-md-2 bordeGris'>Cantidad de Recetas</div>" +
                                "</div>" +
                                "<br />";
                            //Relleno de Listado
                            for (var i = 0; i < RecetasCocineros.length; i++) {
                                html += "<div class='row margen'>" +
                                    " <div class='col-md-2 bordeGris'>" + RecetasCocineros[i].idUsuario + "</div>" +
                                    " <div class='col-md-2 bordeGris'>" + RecetasCocineros[i].CantidadRecetas + "</div>" +
                                    "</div>";
                            }
                            $('#Listado').html(html);
                            $('#ListadoRecetas').html("");
                            
                            
                        }
                    });
                });
                $(document).on('click', '.btnAscendenteRecetas', function () {
                    $.ajax({
                        method: "POST",
                        url: "Receta.php",
                        data: { RankingCocinerosReceta:""},
                        success: function (resp) {
                            var RecetasCocineros=$.parseJSON(resp);
                            //Ordenar descendentemente por atributo
                            RecetasCocineros.sort(function (a, b) {
                                return (a.CantidadRecetas - b.CantidadRecetas)
                            });
                            var html = "";
                            html += "<br /><div class='row'>" +
                                "<div class='col-md-2 btn btn-xs btn-success btnCocinerosRecetas botones margenboton' >Orden Ascendente</div>" +
                                "<div class='col-md-2 btn btn-xs btn-success btnDescendenteRecetas botones'>Orden Descendente</div>" +
                                "</div > <br /><br />" +
                                "<div class='row margen textonegrita'>" +
                                "<div class='col-md-2 bordeGris'>Nombre Usuario</div>" +
                                "<div class='col-md-2 bordeGris'>Cantidad de Recetas</div>" +
                                "</div>" +
                                "<br />";
                            //Relleno de Listado
                            for (var i = 0; i < RecetasCocineros.length; i++) {
                                html += "<div class='row margen'>" +
                                    " <div class='col-md-2 bordeGris'>" + RecetasCocineros[i].idUsuario + "</div>" +
                                    " <div class='col-md-2 bordeGris'>" + RecetasCocineros[i].CantidadRecetas + "</div>" +
                                    "</div>";
                            }
                            $('#Listado').html(html);
                            $('#ListadoRecetas').html("");
                            
                            
                        }
                    });
                });
                $(document).on('click', '.btnCocinerosEstrellas', function () {
                    $.ajax({
                        method: "POST",
                        url: "Receta.php",
                        data: { RankingCocinerosEstrellas:""},
                        success: function (resp) {
                            var EstrellasCocineros=$.parseJSON(resp);
                            
                            //Ordenar descendente por atributo
                            EstrellasCocineros.sort(function (a, b) {
                                return (b.PromedioEstrellas - a.PromedioEstrellas)
                            });
                            var html = "";
                            html +="<br /><div class='row'>"+
                                "<div class='col-md-2 btn btn-xs btn-success btnAscendenteEstrellas botones margenboton' >Orden Ascendente</div>" +
                                "<div class='col-md-2 btn btn-xs btn-success btnCocinerosEstrellas botones'>Orden Descendente</div>" +
                                "</div ><br /> <br /> "+
                                "<div class='row margen'>" +
                                "<div class='col-md-2 bordeGris textonegrita'>Nombre Usuario</div>" +
                                "<div class='col-md-2 bordeGris textonegrita'>Cantidad de Estrellas</div>" +
                                "</div>" +
                                "<br />";
                            //Relleno de Listado
                            for (var i = 0; i < EstrellasCocineros.length; i++) {
                                html += "<div class='row margen'>" +
                                    " <div class='col-md-2 bordeGris'>" + EstrellasCocineros[i].idUsuario + "</div>" +
                                    " <div class='col-md-2 bordeGris'>" + EstrellasCocineros[i].PromedioEstrellas + "</div>" +
                                    "</div>";
                            }
                            $('#Listado').html(html);
                            $('#ListadoRecetas').html("");
                        }
                    });
                });
                $(document).on('click', '.btnAscendenteEstrellas', function () {
                    $.ajax({
                        method: "POST",
                        url: "Receta.php",
                        data: { RankingCocinerosEstrellas:""},
                        success: function (resp) {
                            var EstrellasCocineros=$.parseJSON(resp);
                            
                            //Ordenar descendente por atributo
                            EstrellasCocineros.sort(function (a, b) {
                                return (a.PromedioEstrellas - b.PromedioEstrellas)
                            });
                            var html = "";
                            html +="<br /><div class='row'>"+
                                "<div class='col-md-2 btn btn-xs btn-success btnAscendenteEstrellas botones margenboton' >Orden Ascendente</div>" +
                                "<div class='col-md-2 btn btn-xs btn-success btnCocinerosEstrellas botones'>Orden Descendente</div>" +
                                "</div ><br /> <br /> "+
                                "<div class='row margen'>" +
                                "<div class='col-md-2 bordeGris textonegrita'>Nombre Usuario</div>" +
                                "<div class='col-md-2 bordeGris textonegrita'>Cantidad de Estrellas</div>" +
                                "</div>" +
                                "<br />";
                            //Relleno de Listado
                            for (var i = 0; i < EstrellasCocineros.length; i++) {
                                html += "<div class='row margen'>" +
                                    " <div class='col-md-2 bordeGris'>" + EstrellasCocineros[i].idUsuario + "</div>" +
                                    " <div class='col-md-2 bordeGris'>" + EstrellasCocineros[i].PromedioEstrellas + "</div>" +
                                    "</div>";
                            }
                            $('#Listado').html(html);
                            $('#ListadoRecetas').html("");
                        }
                    });
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
        <br /><br />
        <div class="row"></div>
        <div class="row margen">
            <div class='col-md-2 btn btn-sm btn-primary btnCocinerosEstrellas'>Cocineros Con Mas Estrellas</div>
            <div class="col-md-1"></div>
            <div class='col-md-2 btn btn-sm btn-primary btnCocinerosRecetas'>Cocinero Con Mas Recetas</div>
            <div class="col-md-1"></div>    
            <div class='col-md-3 btn btn-sm btn-primary btnRecetasPromedioRecetas'>Recetas con Mejor Promedio de Estrellas</div>

        </div>
        <div class="row" id="Listado"></div>
        
        <br />
        <div class="row" id="ListadoRecetas"></div>



    </div>

</head>  
</html>
