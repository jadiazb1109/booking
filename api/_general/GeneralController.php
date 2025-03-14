<?php
include_once 'GeneralService.php';
include_once './libs/Slim/Slim.php';
include_once './_message/EnviarCorreoService.php';

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

$api->get('/v1/general/pickUpTimeActive/origin/:origin_id/service/:service_id/date/:date', function ($origin_id,$service_id,$date) use ($api) {

    $generalService = new GeneralService();

    $resp = $generalService->pickUpTimeActivosxServiceId($origin_id,$service_id,$date);

    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active pick up time x orignin_id: ". $origin_id." service_id: ". $service_id; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
});

$api->get('/v1/general/pickUpTimeActiveReturn/origin/:origin_id/service/:service_id/date/:date', function ($origin_id,$service_id,$date) use ($api) {

    $generalService = new GeneralService();

    $resp = $generalService->pickUpTimeActivosReturnxServiceId($origin_id,$service_id,$date);

    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active pick up time return x orignin_id: ". $origin_id." service_id: ". $service_id; 

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

    $currentRideBooking = $request["currentRideBooking"];
    
    $generalService = new GeneralService();

    $resp = $generalService->saveBookingRide($currentRideBooking);
    if ($resp["state"] == "ok") { 

        $currentRideBooking["id"] = $resp["query"];

        $enviarCorreoService = new EnviarCorreoService();
    
        $enviarCorreoService->correoPrueba($currentRideBooking);
        
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

$api->get('/v1/general/listBooking/type/date/:fecha_inicial/:fecha_final', function ($fecha_inicial,$fecha_final) use ($api) {

    $generalService = new GeneralService();

    $resp = $generalService->listBookingActivosxTypexDate($fecha_inicial,$fecha_final);

    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active booking x date: " . $fecha_inicial . " / " . $fecha_final; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
});
