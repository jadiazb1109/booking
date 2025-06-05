<?php

require_once 'UnionOriginServiceService.php';
require_once 'UnionOriginServiceModel.php';

$response = array(
    "state" => 0,
    "message" => 0,
    "data" => array()
);

$api->get('/v1/unionOriginService/unionOriginServices', 'authenticate', function() use ($api){
    
    $unionOriginServiceService = new UnionOriginServiceService();
    
    $resp = $unionOriginServiceService->unionOriginService();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of union origins & services"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/unionOriginService/unionOriginServicesActive','authenticate', function() use ($api){
    
   $unionOriginServiceService = new UnionOriginServiceService();
    
    $resp = $unionOriginServiceService->unionOriginServiceActive();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active union origins & services"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/unionOriginService/unionOriginServices/:id','authenticate', function($id) use ($api){
    
    $unionOriginServiceService = new UnionOriginServiceService();
    
    $resp = $unionOriginServiceService->unionOriginServicexId($id);
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of union origins & services x id: ". $id; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->post('/v1/unionOriginService/unionOriginServices','authenticate', function() use ($api){

    verifyRequiredParams(array('origin_id','service_id','active' , 'id_user'));

    $unionOriginServiceService = new UnionOriginServiceService();

    $unionOriginServiceModel = new UnionOriginServiceModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $unionOriginServiceModel->_set("id", 0);
    $unionOriginServiceModel->_set("origin_id", $request["origin_id"]);
    $unionOriginServiceModel->_set("service_id", $request["service_id"]);
    $unionOriginServiceModel->_set("active", $request["active"]);
    $unionOriginServiceModel->_set("id_user", $request["id_user"]);
    
    $resp = $unionOriginServiceService->unionOriginServiceCU($unionOriginServiceModel);
    if ($resp["state"] == "ok") {

        $unionOriginServiceModel->_set("id", $resp["query"]);      
        
        $response["state"] = "ok";
        $response["message"]= "The union origins & services has been created successfully" ; 
        $response["data"] = $unionOriginServiceModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $unionOriginServiceModel->toJson();

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/unionOriginService/unionOriginServices/:id','authenticate', function($id) use ($api){

    verifyRequiredParams(array('origin_id','service_id','active' , 'id_user'));

    $unionOriginServiceService = new UnionOriginServiceService();

    $unionOriginServiceModel = new UnionOriginServiceModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $unionOriginServiceModel->_set("id", $id);
    $unionOriginServiceModel->_set("origin_id", $request["origin_id"]);
    $unionOriginServiceModel->_set("service_id", $request["service_id"]);
    $unionOriginServiceModel->_set("active", $request["active"]);
    $unionOriginServiceModel->_set("id_user", $request["id_user"]);
    
    $resp = $unionOriginServiceService->unionOriginServiceCU($unionOriginServiceModel);
    if ($resp["state"] == "ok") {

        $unionOriginServiceModel->_set("id", $resp["query"]);      
        
        $response["state"] = "ok";
        $response["message"]= "The union origins & services has been updated successfully" ; 
        $response["data"] = $unionOriginServiceModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $unionOriginServiceModel->toJson();

        echoResponse(200, $response);
    }  
    
});

?>