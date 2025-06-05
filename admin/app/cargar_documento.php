<?php
if (isset($_POST['opcion']) and $_POST["opcion"] == "cambiar_avatar" ) {   

    $resultado = array(
        "state" => 0,
        "message" => 0,
        "data" => array(
                'ruta' => "",
                'archivo' => "",
                'extension' => "",
                'nombre'  => "",
                'tipo'  => "",
                'nombre_temporal' => "",
                'error'  => "",
                'tamaño'  => "",
            )
    );

    $ruta = "../assets/images/avatars/";

    $archivo = "";
 

    if ($_FILES['upload']['name'] != "") {

        $tmp = explode('.', $_FILES['upload']['name']);
        $extension = end( $tmp );
        $archivo = uniqid('AVT_') . "." . $extension;
        $destino = $ruta . $archivo;
        while (file_exists($destino)) {
            $archivo = uniqid('AVT_') . "." . $extension;
        }
        $destino = $ruta . $archivo;
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $destino)) {
            $resultado["state"] = "ok";
            $resultado["message"] = "File information" ;
            $resultado["data"]["ruta"] = $ruta.$archivo; 
            $resultado["data"]["archivo"] = $archivo;
            $resultado["data"]["extension"] = $extension;
            $resultado["data"]["nombre"] = $_FILES['upload']['name'];
            $resultado["data"]["tipo"] = $_FILES['upload']['type'];
            $resultado["data"]["nombre_temporal"] = $_FILES['upload']['tmp_name'];
            $resultado["data"]["error"] = $_FILES['upload']['error'];
            $resultado["data"]["tamaño"] = $_FILES['upload']['size']; 
            
        }else {
            $resultado["state"]= "ko";
            $resultado["message"]= "Can't change the avatar" ;
            $resultado["data"] = [];
        }
    }

    echo json_encode($resultado,512);


}else if (isset($_POST['opcion']) and $_POST["opcion"] == "eliminar_avatar" ) {   

    $resultado = array(
        "state" => 0,
        "message" => 0,
        "data" => array(
                'ruta' => "",
            )
    );

    if(strpos($_POST["avatar"], "01.png") === false){

        try {
            
            unlink($_POST["avatar"]);
            $resultado["state"] = "ok";
            $resultado["message"] = "File was deleted successfully" ;
            $resultado["data"]["ruta"] = $_POST["avatar"]; 

        } catch (Exception $e) {

            $resultado["state"] = "ko";
            $resultado["message"] = $e->getMessage() ;
            $resultado["data"]["ruta"] = $_POST["avatar"];
        }
    }else{
        $resultado["state"] = "ok";
        $resultado["message"] = "File is by default" ;
        $resultado["data"]["ruta"] = $_POST["avatar"]; 
    }
    
    echo json_encode($resultado,512);    

}else if (isset($_POST['opcion']) and $_POST["opcion"] == "cargar_soporte_factura" ) {   

    $resultado = array(
        "estado" => 0,
        "mensaje" => 0,
        "datos" => array(
                'ruta' => "",
                'archivo' => "",
                'extension' => "",
                'nombre'  => "",
                'tipo'  => "",
                'nombre_temporal' => "",
                'error'  => "",
                'tamaño'  => "",
            )
    );

    $ruta = "../upload/facturas/";

    $archivo = "";
 

    if ($_FILES['uplDocumento']['name'] != "") {

        $tmp = explode('.', $_FILES['uplDocumento']['name']);
        $extension = end( $tmp );
        $archivo = uniqid('SOP_') . "." . $extension;
        $destino = $ruta . $archivo;
        while (file_exists($destino)) {
            $archivo = uniqid('SOP_') . "." . $extension;
        }
        $destino = $ruta . $archivo;
        if (move_uploaded_file($_FILES['uplDocumento']['tmp_name'], $destino)) {
            $resultado["estado"] = "ok";
            $resultado["mensaje"] = "informacion del documento" ;
            $resultado["datos"]["ruta"] = $ruta.$archivo; 
            $resultado["datos"]["archivo"] = $archivo;
            $resultado["datos"]["extension"] = $extension;
            $resultado["datos"]["nombre"] = $_FILES['uplDocumento']['name'];
            $resultado["datos"]["tipo"] = $_FILES['uplDocumento']['type'];
            $resultado["datos"]["nombre_temporal"] = $_FILES['uplDocumento']['tmp_name'];
            $resultado["datos"]["error"] = $_FILES['uplDocumento']['error'];
            $resultado["datos"]["tamaño"] = $_FILES['uplDocumento']['size']; 
            
        }else {
            $resultado["estado"]= "ko";
            $resultado["mensaje"]= "No se puedo cargar el documento" ;
            $resultado["datos"] = [];
        }
    }

    echo json_encode($resultado,512);


}else if (isset($_POST['opcion']) and $_POST["opcion"] == "cargar_imagen_producto" ) {   

    $resultado = array(
        "estado" => 0,
        "mensaje" => 0,
        "datos" => array(
                'ruta' => "",
                'archivo' => "",
                'extension' => "",
                'nombre'  => "",
                'tipo'  => "",
                'nombre_temporal' => "",
                'error'  => "",
                'tamaño'  => "",
            )
    );

    $ruta = "../upload/productos/";

    $archivo = "";
 

    if ($_FILES['uplImagen']['name'] != "") {

        $tmp = explode('.', $_FILES['uplImagen']['name']);
        $extension = end( $tmp );
        $archivo = uniqid('PROD_') . "." . $extension;
        $destino = $ruta . $archivo;
        while (file_exists($destino)) {
            $archivo = uniqid('PROD_') . "." . $extension;
        }
        $destino = $ruta . $archivo;
        if (move_uploaded_file($_FILES['uplImagen']['tmp_name'], $destino)) {
            $resultado["estado"] = "ok";
            $resultado["mensaje"] = "informacion de la imagen" ;
            $resultado["datos"]["ruta"] = $ruta.$archivo; 
            $resultado["datos"]["archivo"] = $archivo;
            $resultado["datos"]["extension"] = $extension;
            $resultado["datos"]["nombre"] = $_FILES['uplImagen']['name'];
            $resultado["datos"]["tipo"] = $_FILES['uplImagen']['type'];
            $resultado["datos"]["nombre_temporal"] = $_FILES['uplImagen']['tmp_name'];
            $resultado["datos"]["error"] = $_FILES['uplImagen']['error'];
            $resultado["datos"]["tamaño"] = $_FILES['uplImagen']['size']; 
            
        }else {
            $resultado["estado"]= "ko";
            $resultado["mensaje"]= "No se puedo cargar la imagen" ;
            $resultado["datos"] = [];
        }
    }

    echo json_encode($resultado,512);


}else if (isset($_POST['opcion']) and $_POST["opcion"] == "cargar_soporte_tercero" ) {   

    $resultado = array(
        "estado" => 0,
        "mensaje" => 0,
        "datos" => array(
                'ruta' => "",
                'archivo' => "",
                'extension' => "",
                'nombre'  => "",
                'tipo'  => "",
                'nombre_temporal' => "",
                'error'  => "",
                'tamaño'  => "",
            )
    );

    $ruta = "../upload/terceros/";

    $archivo = "";
 

    if ($_FILES['uplDocumento']['name'] != "") {

        $tmp = explode('.', $_FILES['uplDocumento']['name']);
        $extension = end( $tmp );
        $archivo = uniqid('SOP_') . "." . $extension;
        $destino = $ruta . $archivo;
        while (file_exists($destino)) {
            $archivo = uniqid('SOP_') . "." . $extension;
        }
        $destino = $ruta . $archivo;
        if (move_uploaded_file($_FILES['uplDocumento']['tmp_name'], $destino)) {
            $resultado["estado"] = "ok";
            $resultado["mensaje"] = "informacion del documento" ;
            $resultado["datos"]["ruta"] = $ruta.$archivo; 
            $resultado["datos"]["archivo"] = $archivo;
            $resultado["datos"]["extension"] = $extension;
            $resultado["datos"]["nombre"] = $_FILES['uplDocumento']['name'];
            $resultado["datos"]["tipo"] = $_FILES['uplDocumento']['type'];
            $resultado["datos"]["nombre_temporal"] = $_FILES['uplDocumento']['tmp_name'];
            $resultado["datos"]["error"] = $_FILES['uplDocumento']['error'];
            $resultado["datos"]["tamaño"] = $_FILES['uplDocumento']['size']; 
            
        }else {
            $resultado["estado"]= "ko";
            $resultado["mensaje"]= "No se puedo cargar el documento" ;
            $resultado["datos"] = [];
        }
    }

    echo json_encode($resultado,512);
    
}else if (isset($_POST['opcion']) and $_POST["opcion"] == "cargar_soporte_movimiento" ) {   

    $resultado = array(
        "estado" => 0,
        "mensaje" => 0,
        "datos" => array(
                'ruta' => "",
                'archivo' => "",
                'extension' => "",
                'nombre'  => "",
                'tipo'  => "",
                'nombre_temporal' => "",
                'error'  => "",
                'tamaño'  => "",
            )
    );

    $ruta = "../upload/movimientos/";

    $archivo = "";
 

    if ($_FILES['uplDocumento']['name'] != "") {

        $tmp = explode('.', $_FILES['uplDocumento']['name']);
        $extension = end( $tmp );
        $archivo = uniqid('MOV_') . "." . $extension;
        $destino = $ruta . $archivo;
        while (file_exists($destino)) {
            $archivo = uniqid('MOV_') . "." . $extension;
        }
        $destino = $ruta . $archivo;
        if (move_uploaded_file($_FILES['uplDocumento']['tmp_name'], $destino)) {
            $resultado["estado"] = "ok";
            $resultado["mensaje"] = "informacion del documento" ;
            $resultado["datos"]["ruta"] = $ruta.$archivo; 
            $resultado["datos"]["archivo"] = $archivo;
            $resultado["datos"]["extension"] = $extension;
            $resultado["datos"]["nombre"] = $_FILES['uplDocumento']['name'];
            $resultado["datos"]["tipo"] = $_FILES['uplDocumento']['type'];
            $resultado["datos"]["nombre_temporal"] = $_FILES['uplDocumento']['tmp_name'];
            $resultado["datos"]["error"] = $_FILES['uplDocumento']['error'];
            $resultado["datos"]["tamaño"] = $_FILES['uplDocumento']['size']; 
            
        }else {
            $resultado["estado"]= "ko";
            $resultado["mensaje"]= "No se puedo cargar el documento" ;
            $resultado["datos"] = [];
        }
    }

    echo json_encode($resultado,512);

}else{
    echo "Esta no es una opcion ".$_POST['opcion'];
}


?>