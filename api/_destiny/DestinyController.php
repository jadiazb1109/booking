<?php

require_once 'DestinyService.php';
require_once 'DestinyModel.php';

$response = array(
    "state" => 0,
    "message" => 0,
    "data" => array()
);

$api->get('/v1/destiny/destinys', 'authenticate', function() use ($api){
    
    $destinyService = new DestinyService();
    
    $resp = $destinyService->destiny();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of destinys"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/destiny/destinysActive','authenticate', function() use ($api){
    
    $destinyService = new DestinyService();
    
    $resp = $destinyService->destinyActive();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active destinys"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/destiny/destinys/:id','authenticate', function($id) use ($api){
    
    $destinyService = new DestinyService();
    
    $resp = $destinyService->destinyxId($id);
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of destinys x id: ". $id; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/destiny/destinys/type/:id_type','authenticate', function($id_type) use ($api){
    
    $destinyService = new DestinyService();
    
    $resp = $destinyService->destinyxIdType($id_type);
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of destinys x id_type: ". $id_type; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->post('/v1/destiny/destinys','authenticate', function() use ($api){

    verifyRequiredParams(array('type_id','name','active' , 'id_user'));

    $destinyService = new DestinyService();

    $destinyModel = new DestinyModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $destinyModel->_set("id", 0);
    $destinyModel->_set("type_id", $request["type_id"]);
    $destinyModel->_set("name", $request["name"]);
    $destinyModel->_set("address", $request["address"]);
    $destinyModel->_set("notes", $request["notes"]);
    $destinyModel->_set("active", $request["active"]);
    $destinyModel->_set("id_user", $request["id_user"]);
    
    $resp = $destinyService->destinyCU($destinyModel);
    if ($resp["state"] == "ok") {

        $destinyModel->_set("id", $resp["query"]);      
        
        $response["state"] = "ok";
        $response["message"]= "The destiny has been created successfully" ; 
        $response["data"] = $destinyModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $destinyModel->toJson();

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/destiny/destinys/:id','authenticate', function($id) use ($api){

    verifyRequiredParams(array('type_id','name','active' , 'id_user'));

    $destinyService = new DestinyService();

    $destinyModel = new DestinyModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $destinyModel->_set("id", $id);
    $destinyModel->_set("type_id", $request["type_id"]);
    $destinyModel->_set("name", $request["name"]);
    $destinyModel->_set("address", $request["address"]);
    $destinyModel->_set("notes", $request["notes"]);
    $destinyModel->_set("active", $request["active"]);
    $destinyModel->_set("id_user", $request["id_user"]);
    
    $resp = $destinyService->destinyCU($destinyModel);
    if ($resp["state"] == "ok") {     
        
        $response["state"] = "ok";
        $response["message"]= "The destiny has been updated successfully" ; 
        $response["data"] = $destinyModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $destinyModel->toJson();

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/service/typeActive','authenticate', function() use ($api){
    
    $serviceService = new ServiceService();
    
    $resp = $serviceService->typeActive();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active types"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

?>