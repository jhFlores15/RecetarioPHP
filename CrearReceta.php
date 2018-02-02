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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.5/sweetalert2.all.min.js"></script>
    <style>
        .margen{
            margin-left: 30px;
        }
        .masmargen{
           margin-left:1px;
        }
        .textonegrita{
            font-weight: 700;
        }
        .titulos{
            font-weight: 700;
            font-size: medium;
            color: dodgerblue;
        }
        .margenlista{
            margin-left: 16px;
        }
        .bordeGris{
            border-bottom: 1px solid lightgray;
        }
        .espacioBoton{
            margin-bottom: 6px;
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
        var contador=0;
        var ListaIngredientes=[];
        var ArrayHtmlIngredientes=[];
        $(document).on('click', '.btnAgregarProductos', function () {
            var html = "";
            var idIngrediente = $('#prod').val();
            var idUnidadMedida = $('#und').val();
            var CantidadIngrediente = parseInt($('#txtCantidadIngrediente').val());
            console.log(idIngrediente+CantidadIngrediente+idUnidadMedida);
            var boolExisteProducto=false;
            for(var i=0;i<ListaIngredientes.length;i++){
                if(ListaIngredientes[i].ingrediente===idIngrediente){
                    boolExisteProducto=true;
                }
            }
            if(boolExisteProducto===true){
                alert("ERROR: Este Producto Ya Esta Ingresado");
            }
            else{
                if (isNaN(CantidadIngrediente) || CantidadIngrediente===0) {
                    alert("ERROR:Ingrese Valores Correctos");
                } else {
                    if (idIngrediente !== "" && (isNaN(CantidadIngrediente) === false && CantidadIngrediente !== "") && idUnidadMedida !== "" && boolExisteProducto===false) {
                        $.ajax({
                            method: "POST",
                            url: "Receta.php",
                            data: { idIngrediente: idIngrediente, idUnidadMedida:idUnidadMedida }
                        }).done(function( resp ) {
                            console.log(resp);
                            var objeto = $.parseJSON(resp);
                            var nombre_producto = objeto.nombreP;
                            var nombre_unidad = objeto.nombreU;

                            console.log(nombre_producto+nombre_unidad);
                                html += "<div class='row margen'>" +
                                        "<div class='col-md-3 bordeGris'>" + nombre_producto + "</div>" +
                                        "<div class='col-md-2 bordeGris'>" + CantidadIngrediente +"</div>" +
                                        "<div class='col-md-2 bordeGris'>" + nombre_unidad + "</div>" +
                                        "<div class='col-md-1 bordeGris espacioBoton btn btn-xs btn-danger btnQuitar' id='" + String(contador) + "'>Quitar</div>"+
                                        "</div>";
                                $('#ListadoIngredientes').append(html);
                                contador++; 
                                console.log(contador);
                                RellenoIngrediente();
                                ArrayHtmlIngredientes.push(html);
                        });

                    }
                    else {
                        alert("ERROR:Ingrese Valores Correctos");
                    }
                }
            }
        });
        $(document).on('click', '.btnQuitar', function () {
            var html = "";
            //captura index para despues eliminar el html y el nombre del producto de las listas
            var id = $(this).attr('id');
            delete ArrayHtmlIngredientes[id];
            delete ListaIngredientes[id];
            //recorre el arrayHtml rellenar la lista de productos html nuevamente
            ArrayHtmlIngredientes.forEach(function (item, index, array) {
                html += ArrayHtmlIngredientes[index];
            });
            $('#ListadoIngredientes').html(html);

        });
        function RellenoIngrediente(){
            var ingrediente={};
            ingrediente['Cantidad']= parseInt($('#txtCantidadIngrediente').val());
            ingrediente['ingrediente']= $('#prod').val();
            ingrediente['undMedida']= $('#und').val();
            ListaIngredientes.push(ingrediente);
        }
        $(document).on('click', '.btnGuardarReceta', function () {
            var hayIngredientes = false;
            
            var NombreReceta = $('#txtReceta').val();
            var Preparacion = $('#txtDescripcion').val();
            for (var i = 0; i < ArrayHtmlIngredientes.length; i++) {
                console.log(ArrayHtmlIngredientes[i]);
                //verificar que hayan campos rellenados eln la lista html de productos
                if (ArrayHtmlIngredientes[i] !== undefined) {
                    hayIngredientes = true;
                }
            }
            console.log(hayIngredientes);
            if (NombreReceta===""|| hayIngredientes === false || Preparacion==="" ) {
                alert("Ingrese Todos los datos o Datos Correctos");
            }
            else {
                    $.ajax({
                        method: "POST",
                        url: "Receta.php",
                        data: { NombreReceta: NombreReceta, Preparacion:Preparacion, ListaIngredientes:ListaIngredientes }
                    }).done(function( resp ) {
                       
                        window.location.href = "MisRecetas.php";
                    });
            }

        });
        
        });
        
    
    </script>
    <div class="row container margen">
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
        <form action="CrearReceta.php" method="post">
       
        <br />
        <div class="row NombreReceta textonegrita">
            <div class="col-md-2">
                Nombre Receta
            </div>
            <div class="col-md-2">
                <input type="text" id="txtReceta" class="form-control" Width="250px" Height="30px" name="txtReceta" >
            </div>
        </div>
        <br />
        <div class="row TituloIngredientes masmargen titulos">Ingredientes</div>
        <br />
        <div class="row CuadroIngredientes">
            <div class="row TituloIngredientesAgregar masmargen">
                <div class="col-md-1 textonegrita">Nombre Producto</div>
                <div class="col-md-2">
                    <!--<asp:DropDownList ID="ddlProducto" CssClass="form-control" runat="server" Width="150px" Height="30px"></asp:DropDownList>-->
                    <select id="prod" class="form-control" name="prod">
                    <option></option>
                        <?php
                        $productos = seleccionarProductos();
                        foreach($productos as $producto){
                        echo "<option value='".$producto['idProducto']."'>".$producto['NombreProd']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-1 textonegrita">Cantidad</div>
                <div class="col-md-1">
                    <input id="txtCantidadIngrediente"type="number" class="form-control" Width="60px" Height="25px" name="txtCantidadIngrediente" >
                    <!--<asp:TextBox ID="txtCantidadIngrediente"  CssClass="form-control" runat="server" Width="60px" Height="25px"></asp:TextBox>-->
                </div>
                <div class="col-md-1 textonegrita">Unidad</div>
                <div class="col-md-2">
                    
                    <!--<asp:DropDownList ID="ddlUMedida" runat="server" Width="150px" Height="30px" CssClass="form-control"></asp:DropDownList>-->
                    <select id="und" class="form-control" name="und">
                    <option></option>
                        <?php
                        $unidades = seleccionarUnidadMedidas();
                        foreach($unidades as $unidad){
                        echo "<option value='".$unidad['idUndMedida']."'>".$unidad['NombreMed']."</option>";
                        }
                        ?>
                    </select>
                    
                </div>
                <div class="col-md-2 btn btn-sm btn-success btnAgregarProductos">Agregar Ingredientes</div>
            </div>
            <br />
            <div class="row " id="Ingredientes">
                <div class="row tituloIngredientes margenlista">
                    <div class="col-md-3 textonegrita bordeGris">Nombre</div>
                    <div class="col-md-2 textonegrita bordeGris">Cantidad</div>
                    <div class="col-md-2 textonegrita bordeGris">Unidad de Medida</div>
                    <div class="col-md-1 textonegrita bordeGris">Botones</div>
                </div>
                <br />
                <div class="row" id="ListadoIngredientes">
                </div>
            </div>
        </div>
        <br />
        <div class="Cuadro Descripcion">
            <div class="row TituloDescripcion titulos masmargen">Descripcion</div>
            <br />
            <div class="row masmargen">
                <textarea type="text" id="txtDescripcion" class="form-control" Rows="10" Columns="150" name="txtDescripcion" ></textarea>
                <!--<asp:Textbox ID="txtDescripcion" TextMode="MultiLine" Rows="10" Columns="150" runat="server"  CssClass="form-control"/>-->
            </div>
        </div>
        <br />
        <div class="row boton masmargen">
            <div class="col-md-2 btn btn-sm btn-primary btnGuardarReceta">Guardar Receta</div>
        </div>
        </form>
    </div>
</head>
</html>