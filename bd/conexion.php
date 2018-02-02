<?php

function eliminarProducto($id){
    $resultados="";
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("delete from Producto where idProducto = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
    }
}
function eliminarProductoReceta($idP,$idR){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("delete from Producto_Receta where Producto_idProducto = ? and Receta_idReceta=? ");
        $stmt->bind_param("ii",$idP,$idR);
        $stmt->execute();
    }
    return;
}
function eliminarReceta($id){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("delete from Receta where idReceta = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
    }
}
function cambiarClave($id,$clave){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("update Usuario set Clave = ? where idUsuario = ?");
        $stmt->bind_param("ss", $clave,$id);
        $stmt->execute();
    }
}
function editarProductoReceta($idP,$idR,$cantidad){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("update Producto_Receta set Cantidad=? where Producto_idProducto = ? and Receta_idReceta=? ");
        $stmt->bind_param("iii",$cantidad,$idP,$idR);
        $stmt->execute();
    }
}
function editarUsuario($nombreUsu,$email,$nombre,$fecha_nacimiento,$sexo,$administrador){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("update Usuario set Email = ?,NombreUsu = ?, FechaNacimiento = ?, Sexo = ?,Administrador = ? where idUsuario = ?");
        $stmt->bind_param("ssssii", $email, $nombre,$fecha_nacimiento,$sexo,$administrador,$nombreUsu);
        $stmt->execute();
    }
}
function editarProducto($id,$nombre){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("update Producto set NombreProd=? where idProducto = ?");
        $stmt->bind_param("si", $nombre,$id);
        $stmt->execute();
    }
}
function editarReceta($idReceta,$nombre,$Descripcion){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("update Receta set NombreReceta=?, Descripcion=? where idReceta = ?");
        $stmt->bind_param("ssi", $nombre,$Descripcion,$idReceta);
        $stmt->execute();
    }
}
function agregarReceta($nombreReceta,$descripcion,$idUsuario){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("insert into Receta (NombreReceta,Descripcion,idUsuario) values (?,?,?)");
        $stmt->bind_param("sss", $nombreReceta, $descripcion,$idUsuario);
        $stmt->execute();
    }
}
function insertarProducto_Receta($idProducto,$cantidad,$idUnd,$id){
    
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("insert into Producto_Receta (Producto_idProducto,Cantidad,UndMedida_idUndMedida,Receta_idReceta) values (?,?,?,?)");
        $stmt->bind_param("iiii", $idProducto,$cantidad,$idUnd,$id);
        $stmt->execute();
    }
}
function UltimoIdReceta(){
   $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("SELECT MAX(idReceta) AS id FROM receta");
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}
function agregarProducto($nombre){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("insert into Producto (NombreProd) values (?)");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
    }
}
function seleccionarUsuario($id){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("select * from Usuario where idUsuario = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}
function seleccionarProducto($id){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("select * from Producto where idProducto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}
function seleccionarProductos_Receta($idReceta){
    $productos = array();
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("select * from Producto_Receta where Receta_idReceta = ?");
        $stmt->bind_param("i", $idReceta);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $productos[] = $fila;
        }
    }
    return $productos;
}
function boolExisteProductos_Receta($idReceta,$idUnd){
    $boolExiste=false;
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("select * from Producto_Receta where Receta_idReceta = ? and Producto_idProducto=?");
        $stmt->bind_param("ii", $idReceta,$idUnd);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $boolExiste=true;
        }
    }
    return $boolExiste;
}
function seleccionarReceta($id){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("select * from Receta where idReceta=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
    }
    return null;
}function seleccionarRecetas(){
    //se crea un arreglo
    $recetas = array();
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("select * from Receta");
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $recetas[] = $fila;
        }
    }
    return $recetas;
}
function seleccionarUnidadMedidas(){
    
    //se crea un arreglo
    $unidades = array();
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("select * from UndMedida");
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $unidades[] = $fila;
        }
    }
    return $unidades;
}
function seleccionarProductos(){
    //se crea un arreglo
    $productos = array();
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("select * from Producto");
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $productos[] = $fila;
        }
    }
    return $productos;
}
function productosReceta($id){
    //se crea un arreglo
    $productos = array();
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("select * from Producto_Receta where Receta_idReceta=?  ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $productos[] = $fila;
        }
    }
    return $productos;
}
function CalificacionesReceta($id){
    //se crea un arreglo
    $calificaciones = array();
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("select * from Calificacion where Receta_idReceta=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $calificaciones[] = $fila;
        }
    }
    return $calificaciones;
}
function seleccionarUnidadMedida($id){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("select * from UndMedida where idUndMedida = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}


function seleccionarUsuarios(){
    //se crea un arreglo
    $usuarios = array();
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("select * from usuario");
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $usuarios[] = $fila;
        }
    }
    return $usuarios;
}
function insertarUsuario($email,$nombre,$fecha_nacimiento,$clave,$sexo,$administrador, $nombreUsu){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("insert into Usuario (idUsuario, NombreUsu, Clave, Email, Sexo, FechaNacimiento, Administrador) values (?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssi",$nombreUsu, $nombre, $clave, $email, $sexo, $fecha_nacimiento, $administrador);
        $stmt->execute();


    }
}
function insertarCalificacion($idU,$idR,$calificacion){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("insert into Calificacion (Usuario_idUsuario, Receta_idReceta, Calificacion) values (?,?,?)");
        $stmt->bind_param("sii",$idU,$idR,$calificacion);
        $stmt->execute();
    }
}

function loginUsuario($usuario,$clave){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("select * from Usuario where idUsuario = ? AND Clave = ? ");
        $stmt->bind_param("ss", $usuario, $clave);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return $fila;
        }
        return null;
    }
}
function seleccionarRecetasUsuario($id){
    
    //se crea un arreglo
    $recetas = array();
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("select * from Receta where idUsuario=?  ");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            $recetas[] = $fila;
        }
    }
    return $recetas;
}
function CalificadoPorUsuario($idU,$idR){
    $mysqli = new mysqli("localhost", "root", "", "recetario");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión con MySQL: (" . 
                $mysqli->connect_errno . ") " . 
                $mysqli->connect_error;
    }
    else{
        $stmt = $mysqli->prepare("select * from Calificacion where Usuario_idUsuario=? and Receta_idReceta=?  ");
        $stmt->bind_param("si", $idU,$idR);
        $stmt->execute();
        $resultados = $stmt->get_result();
        while ($fila = $resultados->fetch_assoc()) {
            return true;
        }
    }
    return false;
}




