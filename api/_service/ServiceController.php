<?php

require_once 'ServiceService.php';
require_once 'ServiceModel.php';

$response = array(
    "state" => 0,
    "message" => 0,
    "data" => array()
);

$api->get('/v1/service/services', 'authenticate', function() use ($api){
    
    $serviceService = new ServiceService();
    
    $resp = $serviceService->service();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of services"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/service/servicesActive','authenticate', function() use ($api){
    
    $serviceService = new ServiceService();
    
    $resp = $serviceService->serviceActive();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active services"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/service/services/:id','authenticate', function($id) use ($api){
    
    $serviceService = new ServiceService();
    
    $resp = $serviceService->servicexId($id);
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of services x id: ". $id; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->post('/v1/service/services','authenticate', function() use ($api){

    verifyRequiredParams(array('type_id','name','return','room_number','active' , 'id_user'));

    $serviceService = new ServiceService();

    $serviceModel = new ServiceModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $serviceModel->_set("id", 0);
    $serviceModel->_set("type_id", $request["type_id"]);
    $serviceModel->_set("name", $request["name"]);
    $serviceModel->_set("notes", $request["notes"]);
    $serviceModel->_set("return", $request["return"]);
    $serviceModel->_set("room_number", $request["room_number"]);
    $serviceModel->_set("active", $request["active"]);
    $serviceModel->_set("id_user", $request["id_user"]);
    
    $resp = $serviceService->serviceCU($serviceModel);
    if ($resp["state"] == "ok") {

        $serviceModel->_set("id", $resp["query"]);      
        
        $response["state"] = "ok";
        $response["message"]= "The service has been created successfully" ; 
        $response["data"] = $serviceModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $serviceModel->toJson();

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/service/services/:id','authenticate', function($id) use ($api){

    verifyRequiredParams(array('type_id','name','return','room_number','active' , 'id_user'));

    $serviceService = new ServiceService();

    $serviceModel = new ServiceModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $serviceModel->_set("id", $id);
    $serviceModel->_set("type_id", $request["type_id"]);
    $serviceModel->_set("name", $request["name"]);
    $serviceModel->_set("notes", $request["notes"]);
    $serviceModel->_set("return", $request["return"]);
    $serviceModel->_set("room_number", $request["room_number"]);
    $serviceModel->_set("active", $request["active"]);
    $serviceModel->_set("id_user", $request["id_user"]);
    
    $resp = $serviceService->serviceCU($serviceModel);
    if ($resp["state"] == "ok") {     
        
        $response["state"] = "ok";
        $response["message"]= "The service has been updated successfully" ; 
        $response["data"] = $serviceModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $serviceModel->toJson();

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