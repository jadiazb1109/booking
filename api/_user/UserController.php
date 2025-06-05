<?php

require_once 'UserService.php';
require_once 'UserModel.php';

$response = array(
    "state" => 0,
    "message" => 0,
    "data" => array()
);

$api->get('/v1/user/users/:id','authenticate', function($id) use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->userxId($id);
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "User List x id: ". $id; 

        echoResponse(200, $response);            
    }else{

        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/usuario/usuarios','authenticate', function() use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuarios();
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de usuarios"; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/usuario/usuariosActivos','authenticate', function() use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosActivos();
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de usuarios activos"; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->post('/v1/usuario/usuarios','authenticate', function() use ($api){

    verifyRequiredParams(array('id_tercero','usuario','clave', 'activo' , 'id_usuario'));

    $userService = new UserService();

    $userModel = new UserModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $userModel->_set("id", 0);
    $userModel->_set("id_tercero", $request["id_tercero"]);
    $userModel->_set("usuario", $request["usuario"]);
    $userModel->_set("clave", $request["clave"]);
    $userModel->_set("activo", $request["activo"]);
    $userModel->_set("id_usuario", $request["id_usuario"]);
    
    $resp = $userService->usuariosCU($userModel);
    if ($resp["estado"] == "ok") {

        $userModel->_set("id", $resp["query"]);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "El usuario se ha creado correctamente" ; 
        $response["datos"] = $userModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = $userModel;

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/usuario/usuarios/:id','authenticate', function($id) use ($api){

    verifyRequiredParams(array('id_tercero','usuario', 'activo' , 'id_usuario'));

    $userService = new UserService();

    $userModel = new UserModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $userModel->_set("id", $id);
    $userModel->_set("id_tercero", $request["id_tercero"]);
    $userModel->_set("usuario", $request["usuario"]);
    $userModel->_set("clave", $request["clave"]);
    $userModel->_set("activo", $request["activo"]);
    $userModel->_set("id_usuario", $request["id_usuario"]);
    
    $resp = $userService->usuariosCU($userModel);
    if ($resp["estado"] == "ok") {     
        
        $response["estado"] = "ok";
        $response["mensaje"]= "El usuario se ha actualizado correctamente" ; 
        $response["datos"] = $userModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = $userModel;

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/user/userUpdateAvatar/:id','authenticate', function($id) use ($api){

    verifyRequiredParams(array('avatar','id_usuario'));
    
    $userService = new UserService();

    $userModel = new UserModel();

    $request = json_decode(file_get_contents("php://input"),true);

 
    $userModel->_set("id",  $id);
    $userModel->_set("image",$request["avatar"]);
    $userModel->_set("id_user", $request["id_usuario"]);
    
    $resp = $userService->userUpdateAvatar($userModel);

    if ($resp["state"] == "ok") {

        $response["state"] = "ok";
        $response["message"] = "Avatar was updated successfully" ;
        $response["data"] = $userModel->toJson(); 

        echoResponse(200, $response);
        
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["mensaje"];
        $response["data"] = $userModel;

        echoResponse(200, $response);
    }  
});

$api->put('/v1/user/usersUpdateSidebarColor/:id','authenticate', function($id) use ($api){

    verifyRequiredParams(array('sidebar_color','id_usuario'));
    
    $userService = new UserService();

    $userModel = new UserModel();

    $request = json_decode(file_get_contents("php://input"),true);

 
    $userModel->_set("id",  $id);
    $userModel->_set("sidebar_color",$request["sidebar_color"]);
    $userModel->_set("id_usuario", $request["id_usuario"]);
    
    $resp = $userService->userUpdateSidebarColor($userModel);

    if ($resp["state"] == "ok") {

        $response["state"] = "ok";
        $response["message"] = "User sidebar_color was updated correctly" ;
        $response["data"] = $userModel->toJson(); 

        echoResponse(200, $response);
        
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $userModel;

        echoResponse(200, $response);
    }  
});

$api->put('/v1/user/usersUpdateThemeColor/:id','authenticate', function($id) use ($api){

    verifyRequiredParams(array('theme_color','id_usuario'));
    
    $userService = new UserService();

    $userModel = new UserModel();

    $request = json_decode(file_get_contents("php://input"),true);

 
    $userModel->_set("id",  $id);
    $userModel->_set("theme_color",$request["theme_color"]);
    $userModel->_set("id_usuario", $request["id_usuario"]);
    
    $resp = $userService->userUpdateThemeColor($userModel);

    if ($resp["state"] == "ok") {

        $response["state"] = "ok";
        $response["message"] = "User theme_color was updated correctly" ;
        $response["data"] = $userModel->toJson(); 

        echoResponse(200, $response);
        
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $userModel;

        echoResponse(200, $response);
    }  
});

$api->put('/v1/user/userUpdatePassword/:id','authenticate', function($id) use ($api){

    verifyRequiredParams(array('clave_actual', 'clave_nueva'));
    
    $userService = new UserService();

    $request = json_decode(file_get_contents("php://input"),true);
    
    $resp = $userService->userUpdatePassword($id,$request["clave_actual"],$request["clave_nueva"]);

    if ($resp["state"] == "ok") {

        $response["state"] = "ok";
        $response["message"] = "The password was updated successfully." ;
        $response["data"] = []; 

        echoResponse(200, $response);
        
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
});

$api->get('/v1/usuario/usuariosAsignacionRol/:id_rol','authenticate', function($id_rol) use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionxIdRol($id_rol);
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de usuario x id_rol: ". $id_rol; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/usuario/usuariosAsignacionRol/:id_rol','authenticate', function($id_rol) use ($api){

    verifyRequiredParams(array('id_usuario'));
    
    $userService = new UserService();

    $request = json_decode(file_get_contents("php://input"),true);
    
    $resp = $userService->usuariosAsignacionxRol($id_rol,$request["js_usuarios"],$request["id_usuario"]);

    if ($resp["estado"] == "ok") {

        $response["estado"] = "ok";
        $response["mensaje"] = "El rol se asigno correctamente" ;
        $response["datos"] = []; 

        echoResponse(200, $response);
        
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
});

$api->get('/v1/usuario/usuariosAsignacionRol','authenticate', function() use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionRoles();
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de usuarios con roles asignados: "; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/usuario/usuariosAsignacionProceso/:id_Proceso','authenticate', function($id_Proceso) use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionxIdProceso($id_Proceso);
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de usuario x id_Proceso: ". $id_Proceso; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/usuario/usuariosAsignacionProceso/:id_Proceso','authenticate', function($id_Proceso) use ($api){

    verifyRequiredParams(array('id_usuario'));
    
    $userService = new UserService();

    $request = json_decode(file_get_contents("php://input"),true);
    
    $resp = $userService->usuariosAsignacionxProceso($id_Proceso,$request["js_usuarios"],$request["id_usuario"]);

    if ($resp["estado"] == "ok") {

        $response["estado"] = "ok";
        $response["mensaje"] = "El proceso se asigno correctamente" ;
        $response["datos"] = []; 

        echoResponse(200, $response);
        
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
});

$api->get('/v1/usuario/usuariosAsignacionProceso','authenticate', function() use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionProcesos();
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de usuarios con procesos asignados: "; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/usuario/usuariosAsignacionAgencia/:id_agencia','authenticate', function($id_agencia) use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionxIdAgencia($id_agencia);
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de usuario x id_agencia: ". $id_agencia; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/usuario/usuariosAsignacionAgencia/:id_agencia','authenticate', function($id_agencia) use ($api){
    
    verifyRequiredParams(array('id_usuario'));

    $userService = new UserService();

    $request = json_decode(file_get_contents("php://input"),true);
    
    $resp = $userService->usuariosAsignacionxAgencia($id_agencia,$request["js_usuarios"],$request["id_usuario"]);

    if ($resp["estado"] == "ok") {

        $response["estado"] = "ok";
        $response["mensaje"] = "La agencia se asigno correctamente" ;
        $response["datos"] = []; 

        echoResponse(200, $response);
        
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
});

$api->get('/v1/usuario/usuariosAsignacionAgencia','authenticate', function() use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionAgencias();
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de usuarios con agencias asignadas: "; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/usuario/usuariosAsignacionAgenciaActivos/:id_usuario','authenticate', function($id_usuario) use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionAgenciasActivosxIdUsuario($id_usuario);
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de agencias asignadas x id_usuario: ".$id_usuario; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/usuario/usuariosAsignacionAgenciaGeneral','authenticate', function() use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionAgenciasGeneral();
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de agencias general."; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/usuario/usuariosAsignacionProcesosActivos/:id_usuario/agencia/:id_agencia','authenticate', function($id_usuario,$id_agencia) use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionProcesosActivosxIdUsuarioxIdAgencia($id_usuario,$id_agencia);
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de procesos asignados x id_usuario: ".$id_usuario." y id_agencia: ".$id_agencia; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/usuario/usuariosAsignacionProcesosGeneral/agencia/:id_agencia','authenticate', function($id_agencia) use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionProcesosGeneralxIdAgencia($id_agencia);
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de procesos general x id_agencia: ".$id_agencia; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/usuario/usuariosAsignacionProcesosActivos/agencia/:id_agencia','authenticate', function($id_agencia) use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionProcesosActivosxIdAgencia($id_agencia);
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de procesos asignados a la id_agencia: ".$id_agencia; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/usuario/usuariosAsignacionBodega/:id_bodega','authenticate', function($id_bodega) use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionxIdBodega($id_bodega);
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de usuario x id_bodega: ". $id_bodega; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/usuario/usuariosAsignacionBodega/:id_bodega','authenticate', function($id_bodega) use ($api){

    verifyRequiredParams(array('id_usuario'));
    
    $userService = new UserService();

    $request = json_decode(file_get_contents("php://input"),true);
    
    $resp = $userService->usuariosAsignacionxBodega($id_bodega,$request["js_usuarios"],$request["id_usuario"]);

    if ($resp["estado"] == "ok") {

        $response["estado"] = "ok";
        $response["mensaje"] = "La bodega se asigno correctamente" ;
        $response["datos"] = []; 

        echoResponse(200, $response);
        
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
});

$api->get('/v1/usuario/usuariosAsignacionBodega','authenticate', function() use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionBodegas();
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de usuarios con bodegadas asignadas: "; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/usuario/usuariosAsignacionBodegasActivos/:id_usuario/agencia/:id_agencia','authenticate', function($id_usuario,$id_agencia) use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionBodegasActivosxIdUsuarioxIdAgencia($id_usuario,$id_agencia);
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de bodegas asignadas x id_usuario: ".$id_usuario." y id_agencia: ".$id_agencia; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/usuario/usuariosAsignacionBodegasGeneral/agencia/:id_agencia','authenticate', function($id_agencia) use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionBodegasGeneralxIdAgencia($id_agencia);
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de bodegas general x id_agencia: ".$id_agencia; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/usuario/usuariosAsignacionBodegasActivos/:id_usuario','authenticate', function($id_usuario) use ($api){
    
    $userService = new UserService();
    
    $resp = $userService->usuariosAsignacionBodegasActivosxIdUsuario($id_usuario);
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de bodegas asignadas x id_usuario: ".$id_usuario; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});



?>