<?php

require_once 'TypeIdetificationService.php';
require_once 'TypeIdetificationModel.php';

$response = array(
    "state" => 0,
    "message" => 0,
    "data" => array()
);

$api->get('/v1/typeIdetification/typeIdetifications', 'authenticate', function() use ($api){
    
    $typeIdetificationService = new TypeIdetificationService();
    
    $resp = $typeIdetificationService->TypeIdetification();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of identification types"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/typeIdetification/typeIdetificationsActive','authenticate', function() use ($api){
    
    $typeIdetificationService = new TypeIdetificationService();
    
    $resp = $typeIdetificationService->typeIdetificationActive();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active identification types"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/typeIdetification/typeIdetifications/:id','authenticate', function($id) use ($api){
    
    $typeIdetificationService = new TypeIdetificationService();
    
    $resp = $typeIdetificationService->typeIdetificationxId($id);
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of identification types x id: ". $id; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->post('/v1/typeIdetification/typeIdetifications','authenticate', function() use ($api){

    verifyRequiredParams(array('name','abbreviation', 'active' , 'id_user'));

    $typeIdetificationService = new TypeIdetificationService();

    $typeIdetificationModel = new TypeIdetificationModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $typeIdetificationModel->_set("id", 0);
    $typeIdetificationModel->_set("name", $request["name"]);
    $typeIdetificationModel->_set("abbreviation", $request["abbreviation"]);
    $typeIdetificationModel->_set("active", $request["active"]);
    $typeIdetificationModel->_set("id_user", $request["id_user"]);
    
    $resp = $typeIdetificationService->typeIdetificationCU($typeIdetificationModel);
    if ($resp["state"] == "ok") {

        $typeIdetificationModel->_set("id", $resp["query"]);      
        
        $response["state"] = "ok";
        $response["message"]= "The identification type has been created successfully" ; 
        $response["data"] = $typeIdetificationModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $typeIdetificationModel->toJson();

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/typeIdetification/typeIdetifications/:id','authenticate', function($id) use ($api){

    verifyRequiredParams(array('name','abbreviation', 'active' , 'id_user'));

    $typeIdetificationService = new TypeIdetificationService();

    $typeIdetificationModel = new TypeIdetificationModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $typeIdetificationModel->_set("id", $id);
    $typeIdetificationModel->_set("name", $request["name"]);
    $typeIdetificationModel->_set("abbreviation", $request["abbreviation"]);
    $typeIdetificationModel->_set("active", $request["active"]);
    $typeIdetificationModel->_set("id_user", $request["id_user"]);
    
    $resp = $typeIdetificationService->typeIdetificationCU($typeIdetificationModel);
    if ($resp["state"] == "ok") {     
        
        $response["state"] = "ok";
        $response["message"]= "The identification type has been updated successfully" ; 
        $response["data"] = $typeIdetificationModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $typeIdetificationModel->toJson();

        echoResponse(200, $response);
    }  
    
});

?>