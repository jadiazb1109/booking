<?php

require_once 'UnionServiceDestinyGroupModel.php';
require_once 'UnionServiceDestinyGroupService.php';

$response = array(
    "state" => 0,
    "message" => 0,
    "data" => array()
);

$api->get('/v1/unionServiceDestinyGroup/unionServiceDestinyGroups', 'authenticate', function() use ($api){
    
    $unionServiceDestinyGroupService = new UnionServiceDestinyGroupService();
    
    $resp = $unionServiceDestinyGroupService->unionServiceDestinyGroup();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of union services & destinys groups"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/unionServiceDestinyGroup/unionServiceDestinyGroupsActive','authenticate', function() use ($api){
    
    $unionServiceDestinyGroupService = new UnionServiceDestinyGroupService();
    
    $resp = $unionServiceDestinyGroupService->unionServiceDestinyGroupActive();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active union services & destinys groups"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/unionServiceDestinyGroup/unionServiceDestinyGroups/:id','authenticate', function($id) use ($api){
    
    $unionServiceDestinyGroupService = new UnionServiceDestinyGroupService();
    
    $resp = $unionServiceDestinyGroupService->unionServiceDestinyGroupxId($id);
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of union services & destinys groups x id: ". $id; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/unionServiceDestinyGroup/unionServiceDestinyGroups/union/:id_union','authenticate', function($id_union) use ($api){
    
    $unionServiceDestinyGroupService = new UnionServiceDestinyGroupService();
    
    $resp = $unionServiceDestinyGroupService->unionServiceDestinyGroupxIdUnion($id_union);
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of union services & destinys groups x id_union: ". $id_union; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->post('/v1/unionServiceDestinyGroup/unionServiceDestinyGroups','authenticate', function() use ($api){

    verifyRequiredParams(array('service_destiny_union_id','passenger_min','passenger_max', 'price','active' , 'id_user'));

    $unionServiceDestinyGroupService = new UnionServiceDestinyGroupService();

    $unionServiceDestinyGroupModel = new UnionServiceDestinyGroupModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $unionServiceDestinyGroupModel->_set("id", 0);
    $unionServiceDestinyGroupModel->_set("service_destiny_union_id", $request["service_destiny_union_id"]);
    $unionServiceDestinyGroupModel->_set("passenger_min", $request["passenger_min"]);
    $unionServiceDestinyGroupModel->_set("passenger_max", $request["passenger_max"]);
    $unionServiceDestinyGroupModel->_set("price", $request["price"]);
    $unionServiceDestinyGroupModel->_set("additional", $request["additional"]);
    $unionServiceDestinyGroupModel->_set("notes", $request["notes"]);
    $unionServiceDestinyGroupModel->_set("active", $request["active"]);
    $unionServiceDestinyGroupModel->_set("id_user", $request["id_user"]);
    
    $resp = $unionServiceDestinyGroupService->unionServiceDestinyGroupCU($unionServiceDestinyGroupModel);
    if ($resp["state"] == "ok") {

        $unionServiceDestinyGroupModel->_set("id", $resp["query"]);      
        
        $response["state"] = "ok";
        $response["message"]= "The union services & destiny group has been created successfully" ; 
        $response["data"] = $unionServiceDestinyGroupModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $unionServiceDestinyGroupModel->toJson();

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/unionServiceDestinyGroup/unionServiceDestinyGroups/:id','authenticate', function($id) use ($api){

    verifyRequiredParams(array('active' , 'id_user'));

    $unionServiceDestinyGroupService = new UnionServiceDestinyGroupService();

    $unionServiceDestinyGroupModel = new UnionServiceDestinyGroupModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $unionServiceDestinyGroupModel->_set("id", $id);
    $unionServiceDestinyGroupModel->_set("active", $request["active"]);
    $unionServiceDestinyGroupModel->_set("id_user", $request["id_user"]);
    
    $resp = $unionServiceDestinyGroupService->unionServiceDestinyGroupCU($unionServiceDestinyGroupModel);
    if ($resp["state"] == "ok") {

        $unionServiceDestinyGroupModel->_set("id", $resp["query"]);      
        
        $response["state"] = "ok";
        $response["message"]= "The union services & destiny group has been updated successfully" ; 
        $response["data"] = $unionServiceDestinyGroupModel->toJson();  

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $unionServiceDestinyGroupModel->toJson();

        echoResponse(200, $response);
    }  
    
});

?>