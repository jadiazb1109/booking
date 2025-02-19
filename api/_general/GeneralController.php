<?php
include_once 'GeneralService.php';
include_once './libs/Slim/Slim.php';

$response = array(
    "state" => 0,
    "message" => 0,
    "data" => array()
);

$api->get('/v1/general/originActive', function () use ($api) {

    $generalService = new GeneralService();

    $resp = $generalService->originActivos();

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

$api->get('/v1/general/serviceActive/origin/:origin_id', function ($origin_id) use ($api) {

    $generalService = new GeneralService();

    $resp = $generalService->serviceActivosxOriginId($origin_id);

    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active services x origin_id: ". $origin_id; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
});
