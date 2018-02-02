<?php
include 'bd/conexion.php';
if (!session_id()) @session_start();
    if(isset($_SESSION['conectado'])){
        $usuarioLogueado = $_SESSION['conectado'];
    }
if(isset($_POST['idIngrediente'])&& isset($_POST['idUnidadMedida'])){
    //boolExisteProductos_Receta($id_producto,$idUnd);
    $id_producto = $_POST['idIngrediente'];
    $idUnd=$_POST['idUnidadMedida'];
    $Und= seleccionarUnidadMedida($idUnd);
    $Ingr= seleccionarProducto($id_producto);
    $NombreP = $Ingr['NombreProd'];
    $NombreU=$Und['NombreMed'];

    $arr = array('nombreP'=>$NombreP,'nombreU'=>$NombreU);
    $respuesta = json_encode($arr);
    echo $respuesta;
}
//guardarReceta
if(isset($_POST['NombreReceta'])&& isset($_POST['Preparacion']) && isset($_POST['ListaIngredientes'])){
    
        $nombreR= $_POST['NombreReceta'];
        $Prep=$_POST['Preparacion'];
        $Ing=$_POST['ListaIngredientes'];
        $Us=$usuarioLogueado['idUsuario'];
        agregarReceta($nombreR, $Prep, $Us);
        $idArr= UltimoIdReceta();
        $id = implode(",", $idArr);
        foreach ($Ing as $ingrediente) {
            
            $idProd=$ingrediente['ingrediente'];
            $idUndM=$ingrediente['undMedida'];
            $Cant=$ingrediente['Cantidad'];
            insertarProducto_Receta($idProd,$Cant,$idUndM,$id);
        }
        $respuesta = json_encode($Ingredientes);
        echo "pepe";
}
//EditarReceta
if(isset($_POST['NombreR'])&& isset($_POST['Prep']) && isset($_POST['ListaIng']) && isset($_POST['id'])){
        $c=0;
        $nombreReceta = $_POST['NombreR'];
        $Preparacion=$_POST['Prep'];
        $Ingredientes=$_POST['ListaIng'];
        $Usuario=$usuarioLogueado['idUsuario'];
        $idReceta = $_POST['id'];
        editarReceta($idReceta,$nombreReceta,$Preparacion);
        
        foreach ($Ingredientes as $ingrediente) {
            if($ingrediente!=""){
                $c++;
                $idP=$ingrediente['ingrediente'];
                $idU=$ingrediente['undMedida'];
                $Cantidad=$ingrediente['Cantidad'];
                insertarProducto_Receta($idP,$Cantidad,$idU,$idReceta);
            }
            
        }
                echo $c;
}


//EliminarReceta
if(isset($_POST['idReceta'])){
    $idReceta=$_POST['idReceta'];
    eliminarReceta($idReceta);
    echo "";
}
//GuardarCalificacion
if(isset($_POST['idU']) && isset($_POST['idR']) && isset($_POST['calificacion'])){
    $idReceta=$_POST['idR'];
    $idUsuario=$_POST['idU'];
    $calificacion=$_POST['calificacion'];
    insertarCalificacion($idUsuario,$idReceta,$calificacion);
    echo "";
}
//RankingRecetas
if(isset($_POST['RankingReceta'])){
    //Necesitar NombreReceta //Promedio//UsuarioCreador//idReceta
    $Ranking=[];
    $recetas= seleccionarRecetas();
    foreach ($recetas as $receta) {
        $Receta=[];
        $idReceta=$receta['idReceta'];
        //calcular Promedio
        $calificaciones= CalificacionesReceta($idReceta);
        $contador=0;
        if($calificaciones!=null){
            foreach($calificaciones as $calificacion){
                $cont=$calificacion['Calificacion'];
                $contador=$contador+$cont;
            }
        }
        if($contador!=0){
            $PromedioCalificacionReceta=round($contador/(sizeof($calificaciones)));
        }
        else{
            $PromedioCalificacionReceta=0;
        }
        
        $Receta['Promedio']=$PromedioCalificacionReceta;
        //identificar UsuarioCreador
        $rc=seleccionarReceta($idReceta);
        $Receta['idUsuario']=$rc['idUsuario'];
        //IdentificarNombre Receta
        $Receta['Nombre']=$rc['NombreReceta'];
        $Receta['idReceta']=$idReceta;
        //incluir objeto receta en un array
        $Ranking[]=$Receta;
    }
    
    $respuesta = json_encode($Ranking);
    echo $respuesta;
}
if(isset($_POST['RankingCocinerosReceta'])){
    $RankingRecetasUsuarios=[];
    $usuarios=seleccionarUsuarios();
    foreach ($usuarios as $Usuario){
        $user=[];
        $idUsuario=$Usuario['idUsuario'];
        $RecetasUsuario=seleccionarRecetasUsuario($idUsuario);
        //relleno objeto user
        $user['idUsuario']=$idUsuario;
        $user['CantidadRecetas']=count($RecetasUsuario);
        $RankingRecetasUsuarios[]=$user;
    }
    $respuesta = json_encode($RankingRecetasUsuarios);
    echo $respuesta;
}
if(isset($_POST['RankingCocinerosEstrellas'])){
    $Ranking=[];
    $usuarios=seleccionarUsuarios();
    foreach ($usuarios as $Usuario){
        $user=[];
        $idUsuario=$Usuario['idUsuario'];
        $user['idUsuario']=$idUsuario;
        $RecetasUsuario=seleccionarRecetasUsuario($idUsuario);
        if(count($RecetasUsuario)==0){
            $user['PromedioEstrellas']=0;
        }
        else{
            $contador=0;
            $k=0;
            foreach($RecetasUsuario as $receta){
                $Receta=[];
                $idReceta=$receta['idReceta'];
                //calcular Promedio
                $calificaciones= CalificacionesReceta($idReceta);
                if($calificaciones!=null){
                    foreach($calificaciones as $calificacion){
                        $k++;
                        $cont=$calificacion['Calificacion'];
                        $contador=$contador+$cont;
                    }
                }
                else{
                }
            }
            if($contador==0){
                $user['PromedioEstrellas']=0;
            }
            else{
                $user['PromedioEstrellas']=round($contador/$k);
            }
        }
        $Ranking[]=$user;
    }
    $respuesta = json_encode($Ranking);
    echo $respuesta;

}
if(isset($_POST['DatosRecetaModificar'])){
    $Receta_and_Productos=[];
    $idReceta=$_POST['DatosRecetaModificar'];
    $receta=seleccionarReceta($idReceta);
    $productos= seleccionarProductos();
    $unidades= seleccionarUnidadMedidas();
    $productosReceta=seleccionarProductos_Receta($idReceta);
    //Relleno
    $Receta_and_Productos['Receta']=$receta;
    $Receta_and_Productos['ProductosReceta']=$productosReceta;
    $Receta_and_Productos['Productos']=$productos;
    $Receta_and_Productos['Unidades']=$unidades;
    
    //ENVIO DE OBJETOS POR JSON
    $respuesta = json_encode($Receta_and_Productos);
    echo $respuesta;
    
}
///Elminar Producto_Receta
if(isset($_POST['idP']) && isset($_POST['idRe'])){
    $idP=$_POST['idP'];
    $idR=$_POST['idRe'];
    eliminarProductoReceta($idP, $idR);
    echo "";
}
//Modificar cantidad Producto_Receta
if(isset($_POST['idPr']) && isset($_POST['idRec']) && isset($_POST['cantidad'])){
    $idPr=$_POST['idPr'];
    $idR=$_POST['idRec'];
    $cantidad=$_POST['cantidad'];
    editarProductoReceta($idPr, $idR,$cantidad);
    echo "id"+$idP;
}



 
    

