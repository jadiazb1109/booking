<?php
include_once 'GeneralService.php';
include_once './libs/Slim/Slim.php';
include_once './_message/EnviarCorreoService.php';
include_once './_user/UserService.php';
include_once './_user/UserModel.php';

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

$api->get('/v1/general/listBooking/type/date/:date_start/:date_end', function ($date_start,$date_end) use ($api) {

    $generalService = new GeneralService();

    $resp = $generalService->listBookingActivosxTypexDate($date_start,$date_end);

    if ($resp["state"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["state"] = "ok";
        $response["message"]= "No data to display" ; 
        $response["data"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["message"] = "List of active booking x date: " . $date_start . " / " . $date_end; 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
});

$api->get('/v1/general/validateLogin/:user/:passw', function ($user,$passw) use ($api) {

    $generalService = new GeneralService();
    $userService = new UserService();
    $userModel = new UserModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $resp = $generalService->userValidateLogin($user, $passw);

    if ($resp["state"] == "ok") {

        if ($resp["query"]->rowCount()) {

            $fila = $resp["query"]->fetch();

            $userModel->_set("id", $fila["id"]);
            $userModel->_set("id_people", $fila["id_people"]);
            $userModel->_set("people", $fila["people"]);
            $userModel->_set("username", $fila["username"]);
            $userModel->_set("password", $fila["password"]);
            $userModel->_set("token", $fila["token"]);
            $userModel->_set("active", $fila["active"]);

            if ($userModel->_get("active") == 0) {

                $userModel->_set("token", "");

                $response["state"] = "bl";
                $response["message"] = "User '" . $userModel->_get("username") . "' is blocked.";
                $response["data"] = $userModel;

                echoResponse(200, $response);
            } else {

                $token = bin2hex(openssl_random_pseudo_bytes(16, $val));

                $userModel->_set("token", $token);

                $respT = $userService->userUpdateToken($userModel);

                if ($respT["state"] == "ok") {

                    $userService->userInsertLog($userModel);

                    $response["state"] = "ok";
                    $response["message"] = "Welcome to the system " . $userModel->_get("people");

                    $userModel->_set("password", null);

                    $response["data"] = $userModel->toJsonLogin();

                    echoResponse(200, $response);
                } else {

                    $response["state"] = "ko";
                    $response["message"] = $respT["message"];
                    $response["data"] = [];

                    echoResponse(200, $response);
                }
            }
        } else {

            $response["state"] = "ko";
            $response["message"] = "Wrong username or password.";
            $response["data"] = $userModel->toJsonLogin();

            echoResponse(200, $response);
        }
    } else {
        $response["state"] = "ko";
        $response["message"] = $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }
});

$api->get('/v1/general/validateToken/:token', function ($token) use ($api) {

    $userService = new UserService();

    $resp = $userService->userValidateToken($token);

    if ($resp["state"] == "ok") {

        if ($resp["query"]->rowCount()) {

            $response["state"] = "ok";
            $response["message"] = "Access granted";
            $response["data"] = $token;

            echoResponse(200, $response);
        } else {

            $response["state"] = "ko";
            $response["message"] = "Access denied. Incorrect token.";
            $response["data"] = [];

            echoResponse(200, $response);
        }
    } else {
        $response["state"] = "ko";
        $response["message"] = $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }
});

$api->get('/v1/general/resetPassword/:email', function($email) use ($api){
    
    $userService = new UserService();

    $claveNueva = bin2hex(openssl_random_pseudo_bytes(3,$val));
    
    $resp = $userService->userResetPassword($email,base64_encode($claveNueva));

    if ($resp["state"] == "ok") {

        $fila = $resp["query"];

        $enviarCorreoService = new EnviarCorreoService();
    
        $respCorreo = $enviarCorreoService->emailResetPassword($fila["name"],$fila["username"],$email,$claveNueva);
    
        if ($respCorreo["state"] == "ok") {          
            
            $response["state"] = "ok";
            $response["message"] = "The information has been sent to the email: <". $email .">";        
            $response["data"] = []; 
    
            echoResponse(200, $response);
            
        }else{
            $response["state"]= "ko";
            $response["message"]= $respCorreo["message"];
            $response["data"] = [];
    
            echoResponse(200, $response);
        }
        
    }else{
        $response["state"] = "ko";
        $response["message"] = $resp["message"];
        $response["data"] = [];

        echoResponse(200, $response);
    }  
    
});

