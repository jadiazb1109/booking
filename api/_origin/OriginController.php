<?php

require_once 'OriginService.php';
require_once 'OriginModel.php';

$response = array(
    "state" => 0,
    "message" => 0,
    "data" => array()
);

$api->get('/v1/origin/origins', 'authenticate', function() use ($api){
    
    $originService = new OriginService();
    
    $resp = $originService->origin();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of origins"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/origin/originsActive','authenticate', function() use ($api){
    
    $originService = new OriginService();
    
    $resp = $originService->originActive();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active origins"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/origin/origins/:id','authenticate', function($id) use ($api){
    
    $originService = new OriginService();
    
    $resp = $originService->originxId($id);
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of origins x id: ". $id; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->post('/v1/origin/origins','authenticate', function() use ($api){

    verifyRequiredParams(array('name', 'active' , 'id_user'));

    $originService = new OriginService();

    $originModel = new OriginModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $originModel->_set("id", 0);
    $originModel->_set("name", $request["name"]);
    $originModel->_set("address", $request["address"]);
    $originModel->_set("notes", $request["notes"]);
    $originModel->_set("active", $request["active"]);
    $originModel->_set("id_user", $request["id_user"]);
    
    $resp = $originService->originCU($originModel);
    if ($resp["state"] == "ok") {

        $originModel->_set("id", $resp["query"]);      
        
        $response["state"] = "ok";
        $response["message"]= "The origin has been created successfully" ; 
        $response["data"] = $originModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $originModel->toJson();

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/origin/origins/:id','authenticate', function($id) use ($api){

    verifyRequiredParams(array('name', 'active' , 'id_user'));

    $originService = new OriginService();

    $originModel = new OriginModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $originModel->_set("id", $id);
    $originModel->_set("name", $request["name"]);
    $originModel->_set("address", $request["address"]);
    $originModel->_set("notes", $request["notes"]);
    $originModel->_set("active", $request["active"]);
    $originModel->_set("id_user", $request["id_user"]);
    
    $resp = $originService->originCU($originModel);
    if ($resp["state"] == "ok") {     
        
        $response["state"] = "ok";
        $response["message"]= "The origin has been updated successfully" ; 
        $response["data"] = $originModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $originModel->toJson();

        echoResponse(200, $response);
    }  
    
});

?>