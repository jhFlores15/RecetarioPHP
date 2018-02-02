<?php
include 'bd/conexion.php';


$id_producto = "";
$idProd="";
$producto="";
$nombre="";
if(isset($_POST['id_producto'])){
    $id_producto = $_POST['id_producto'];
    $resp=eliminarProducto($id_producto);
    echo $resp;
}
if(isset($_POST['idProd'])){
    $idProd = $_POST['idProd'];
    $nombre=$_POST['nombre'];
    editarProducto($idProd,$nombre);
    echo $resp="";
}

    



