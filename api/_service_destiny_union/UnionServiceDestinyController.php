<?php

require_once 'UnionServiceDestinyService.php';
require_once 'UnionServiceDestinyModel.php';

$response = array(
    "state" => 0,
    "message" => 0,
    "data" => array()
);

$api->get('/v1/unionServiceDestiny/unionServiceDestinys', 'authenticate', function() use ($api){
    
    $unionServiceDestinyService = new UnionServiceDestinyService();
    
    $resp = $unionServiceDestinyService->unionServiceDestiny();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of union services & destinys"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/unionServiceDestiny/unionServiceDestinysActive','authenticate', function() use ($api){
    
    $unionServiceDestinyService = new UnionServiceDestinyService();
    
    $resp = $unionServiceDestinyService->unionServiceDestinyActive();
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active union services & destinys"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/unionServiceDestiny/unionServiceDestinys/:id','authenticate', function($id) use ($api){
    
    $unionServiceDestinyService = new UnionServiceDestinyService();
    
    $resp = $unionServiceDestinyService->unionServiceDestinyxId($id);
    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of union services & destinys x id: ". $id; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->post('/v1/unionServiceDestiny/unionServiceDestinys','authenticate', function() use ($api){

    verifyRequiredParams(array('type_id','service_id','destiny_id','active' , 'id_user'));

    $unionServiceDestinyService = new UnionServiceDestinyService();

    $unionServiceDestinyModel = new UnionServiceDestinyModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $unionServiceDestinyModel->_set("id", 0);
    $unionServiceDestinyModel->_set("type_id", $request["type_id"]);
    $unionServiceDestinyModel->_set("service_id", $request["service_id"]);
    $unionServiceDestinyModel->_set("destiny_id", $request["destiny_id"]);
    $unionServiceDestinyModel->_set("date", $request["date"]);
    $unionServiceDestinyModel->_set("price", $request["price"]);
    $unionServiceDestinyModel->_set("additional", $request["additional"]);
    $unionServiceDestinyModel->_set("promo_one_x_two", $request["promo_one_x_two"]);
    $unionServiceDestinyModel->_set("promo_next_pass", $request["promo_next_pass"]);
    $unionServiceDestinyModel->_set("promo_next_pass_preci", $request["promo_next_pass_preci"]);
    $unionServiceDestinyModel->_set("important_information_initial", $request["important_information_initial"]);
    $unionServiceDestinyModel->_set("terms_and_conditions", $request["terms_and_conditions"]);
    $unionServiceDestinyModel->_set("active", $request["active"]);
    $unionServiceDestinyModel->_set("id_user", $request["id_user"]);
    
    $resp = $unionServiceDestinyService->unionServiceDestinyCU($unionServiceDestinyModel);
    if ($resp["state"] == "ok") {

        $unionServiceDestinyModel->_set("id", $resp["query"]);      
        
        $response["state"] = "ok";
        $response["message"]= "The union services & destiny has been created successfully" ; 
        $response["data"] = $unionServiceDestinyModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $unionServiceDestinyModel->toJson();

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/unionServiceDestiny/unionServiceDestinys/:id','authenticate', function($id) use ($api){

    verifyRequiredParams(array('type_id','service_id','destiny_id','active' , 'id_user'));
  
    $unionServiceDestinyService = new UnionServiceDestinyService();

    $unionServiceDestinyModel = new UnionServiceDestinyModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $unionServiceDestinyModel->_set("id", $id);
    $unionServiceDestinyModel->_set("type_id", $request["type_id"]);
    $unionServiceDestinyModel->_set("service_id", $request["service_id"]);
    $unionServiceDestinyModel->_set("destiny_id", $request["destiny_id"]);
    $unionServiceDestinyModel->_set("date", $request["date"]);
    $unionServiceDestinyModel->_set("price", $request["price"]);
    $unionServiceDestinyModel->_set("additional", $request["additional"]);
    $unionServiceDestinyModel->_set("promo_one_x_two", $request["promo_one_x_two"]);
    $unionServiceDestinyModel->_set("promo_next_pass", $request["promo_next_pass"]);
    $unionServiceDestinyModel->_set("promo_next_pass_preci", $request["promo_next_pass_preci"]);
    $unionServiceDestinyModel->_set("important_information_initial", $request["important_information_initial"]);
    $unionServiceDestinyModel->_set("terms_and_conditions", $request["terms_and_conditions"]);
    $unionServiceDestinyModel->_set("active", $request["active"]);
    $unionServiceDestinyModel->_set("id_user", $request["id_user"]);
    
    $resp = $unionServiceDestinyService->unionServiceDestinyCU($unionServiceDestinyModel);
    if ($resp["state"] == "ok") {

        $unionServiceDestinyModel->_set("id", $resp["query"]);      
        
        $response["state"] = "ok";
        $response["message"]= "The union services & destiny has been updated successfully" ; 
        $response["data"] = $unionServiceDestinyModel->toJson();  

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $unionServiceDestinyModel->toJson();

        echoResponse(200, $response);
    }  
    
});

?>