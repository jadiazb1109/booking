<?php

require_once 'RolService.php';
require_once 'RolModel.php';

$response = array(
    "state" => 0,
    "message" => 0,
    "data" => array()
);

$api->get('/v1/rol/roles', 'authenticate', function() use ($api){
    
    $rolService = new RolService();
    
    $resp = $rolService->roles();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of roles"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/rol/rolesActive','authenticate', function() use ($api){
    
    $rolService = new RolService();
    
    $resp = $rolService->rolesActive();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active roles"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/rol/roles/:id','authenticate', function($id) use ($api){
    
    $rolService = new RolService();
    
    $resp = $rolService->rolesxId($id);
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of rol x id: ". $id; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->post('/v1/rol/roles','authenticate', function() use ($api){

    verifyRequiredParams(array('name', 'active' , 'id_user'));

    $rolService = new RolService();

    $rolModel = new RolModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $rolModel->_set("id", 0);
    $rolModel->_set("name", $request["name"]);
    $rolModel->_set("active", $request["active"]);
    $rolModel->_set("id_user", $request["id_user"]);
    
    $resp = $rolService->rolesCU($rolModel);
    if ($resp["state"] == "ok") {

        $rolModel->_set("id", $resp["query"]);      
        
        $response["state"] = "ok";
        $response["message"]= "The role has been created successfully" ; 
        $response["data"] = $rolModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $rolModel;

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/rol/roles/:id','authenticate', function($id) use ($api){

    verifyRequiredParams(array('name', 'active' , 'id_user'));

    $rolService = new RolService();

    $rolModel = new RolModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $rolModel->_set("id", $id);
    $rolModel->_set("name", $request["name"]);
    $rolModel->_set("active", $request["active"]);
    $rolModel->_set("id_user", $request["id_user"]);
    
    $resp = $rolService->rolesCU($rolModel);
    if ($resp["state"] == "ok") {     
        
        $response["state"] = "ok";
        $response["message"]= "The role has been updated successfully" ; 
        $response["datos"] = $rolModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["datos"] = $rolModel;

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/rol/roles/modulesActive/user/:id_user','authenticate', function($id_user) use ($api){
    
    $rolService = new RolService();
    
    $resp = $rolService->rolesModuleActivexIdUser($id_user);
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active modules assigned to the user: ". $id_user; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/rol/roles/menusActive/user/:id_user','authenticate', function($id_user) use ($api){
    
    $rolService = new RolService();
    
    $resp = $rolService->rolesMenusActivexIdUser($id_user);
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active menus assigned to the user: ". $id_user; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/rol/roles/menus/:id_menu/user/:id_user','authenticate', function($id_menu,$id_user) use ($api){
    
    $rolService = new RolService();
    
    $resp = $rolService->rolesMenusxIdMenuxIdUser($id_menu,$id_user);
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of options in a menu assigned to the user: ". $id_user; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/rol/roles/asignation/menu/:id_rol','authenticate', function($id_rol) use ($api){
    
    $rolService = new RolService();
    
    $resp = $rolService->rolesAsignationMenuxIdRol($id_rol);
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of menus assigned to the role: ". $id_rol; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/rol/roles/asignation/menu/:id_rol','authenticate', function($id_rol) use ($api){

    verifyRequiredParams(array('id_user'));
    
    $rolService = new RolService();

    $request = json_decode(file_get_contents("php://input"),true);
    
    $resp = $rolService->rolesAsignationMenuxIdRolCU($id_rol,$request["js_permisos"],$request["id_user"]);
    if ($resp["state"] == "ok") {

        $response["state"] = "ok";
        $response["message"]= "The options were assigned correctly" ;
        $response["data"] = []; 

        echoResponse(200, $response);
        
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
});

?>