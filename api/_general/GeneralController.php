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

$api->get('/v1/general/destinyUnionActive/service/:service_id/date/:date', function ($service_id,$date) use ($api) {

    $generalService = new GeneralService();

    $resp = $generalService->destinyUnionActivosxServiceIdDate($service_id,$date);

    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active destiny x service_id: ". $service_id; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
});

$api->get('/v1/general/pickUpTimeActive/service/:service_id/date/:date', function ($service_id,$date) use ($api) {

    $generalService = new GeneralService();

    $resp = $generalService->pickUpTimeActivosxServiceId($service_id,$date);

    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active pick up time x service_id: ". $service_id; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
});

$api->get('/v1/general/pickUpTimeActiveReturn/service/:service_id/date/:date', function ($service_id,$date) use ($api) {

    $generalService = new GeneralService();

    $resp = $generalService->pickUpTimeActivosReturnxServiceId($service_id,$date);

    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active pick up time return x service_id: ". $service_id; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
});

$api->post('/v1/general/booking/ride', function() use ($api){

    $request = json_decode(file_get_contents("php://input"), true);
    
    $generalService = new GeneralService();

    $resp = $generalService->saveBookingRide($request["currentRideBooking"]);
    if ($resp["state"] == "ok") { 
        
        $response["state"] = "ok";
        $response["message"]= "successful booking" ; 
        $response["data"] = $request; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $request;

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/general/listBooking/type/2', function () use ($api) {

    $generalService = new GeneralService();

    $resp = $generalService->listBookingActivosxTypeId2();

    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active booking x type 2"; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
});

$api->get('/v1/general/passengerGroupActive/destiny/:destiny_id', function ($destiny_id) use ($api) {

    $generalService = new GeneralService();

    $resp = $generalService->passengerGroupActivosxDestinyId($destiny_id);

    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active passenger group x destiny_id: ". $destiny_id; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
});
