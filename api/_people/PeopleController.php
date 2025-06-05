<?php

require_once 'PeopleService.php';
require_once 'PeopleModel.php';

$response = array(
    "state" => 0,
    "message" => 0,
    "data" => array()
);

$api->get('/v1/tercero/terceros', 'authenticate', function() use ($api){
    
    $thirdPartiesService = new ThirdPartiesService();
    
    $resp = $thirdPartiesService->terceros();
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de terceros"; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/tercero/tercerosActivos','authenticate', function() use ($api){
    
    $thirdPartiesService = new ThirdPartiesService();
    
    $resp = $thirdPartiesService->tercerosActivos();
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de terceros activos"; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/tercero/terceros/:id','authenticate', function($id) use ($api){
    
    $thirdPartiesService = new ThirdPartiesService();
    
    $resp = $thirdPartiesService->tercerosxId($id);
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de tercero x id: ". $id; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

$api->post('/v1/tercero/terceros','authenticate', function() use ($api){

    verifyRequiredParams(array('id_type_identification','number','name','email', 'active' , 'id_user'));

    $peopleService = new PeopleService();

    $peopleModel = new PeopleModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $peopleModel->_set("id", 0);
    $peopleModel->_set("id_type_identification", $request["id_type_identification"]);
    $peopleModel->_set("number", $request["number"]);
    $peopleModel->_set("name", $request["name"]);
    $peopleModel->_set("email", $request["email"]);
    $peopleModel->_set("address", $request["address"]);
    $peopleModel->_set("city", $request["city"]);
    $peopleModel->_set("state", $request["state"]);
    $peopleModel->_set("zip_code", $request["zip_code"]);
    $peopleModel->_set("phone", $request["phone"]);
    $peopleModel->_set("date_birth", $request["date_birth"]);
    $peopleModel->_set("active", $request["active"]);
    $peopleModel->_set("id_user", $request["id_user"]);

    $peopleModel->_set("guardarUsuario", $request["guardarUsuario"]);
    $peopleModel->_set("txtUsuarioUsuario", $request["txtUsuarioUsuario"]);
    $peopleModel->_set("txtUsuarioClave", $request["txtUsuarioClave"]);
    
    $resp = $peopleService->peopleCU($peopleModel);
    if ($resp["state"] == "ok") {

        $peopleModel->_set("id", $resp["query"]);      
        
        $response["state"] = "ok";
        $response["message"]= "The person has been created successfully" ; 
        $response["data"] = $peopleModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $peopleModel;

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/people/people/:id','authenticate', function($id) use ($api){

    verifyRequiredParams(array('id_type_identification','number','name','email', 'active' , 'id_user'));

    $peopleService = new PeopleService();

    $peopleModel = new PeopleModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $peopleModel->_set("id", $id);
    $peopleModel->_set("id_type_identification", $request["id_type_identification"]);
    $peopleModel->_set("number", $request["number"]);
    $peopleModel->_set("name", $request["name"]);
    $peopleModel->_set("email", $request["email"]);
    $peopleModel->_set("address", $request["address"]);
    $peopleModel->_set("city", $request["city"]);
    $peopleModel->_set("state", $request["state"]);
    $peopleModel->_set("zip_code", $request["zip_code"]);
    $peopleModel->_set("phone", $request["phone"]);
    $peopleModel->_set("date_birth", $request["date_birth"]);
    $peopleModel->_set("active", $request["active"]);
    $peopleModel->_set("id_user", $request["id_user"]);;
    
    $resp = $peopleService->peopleCU($peopleModel);
    if ($resp["state"] == "ok") {     
        
        $response["state"] = "ok";
        $response["message"]= "The person has been updated successfully" ; 
        $response["data"] = $peopleModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $peopleModel;

        echoResponse(200, $response);
    }  
    
});

$api->put('/v1/people/people/profile/:id','authenticate', function($id) use ($api){

    verifyRequiredParams(array('email','address','city','state','zip_code','phone', 'id_user'));

    $peopleService = new PeopleService();

    $peopleModel = new PeopleModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $peopleModel->_set("id", $id);
    $peopleModel->_set("email", $request["email"]);
    $peopleModel->_set("address", $request["address"]);
    $peopleModel->_set("city", $request["city"]);
    $peopleModel->_set("state", $request["state"]);
    $peopleModel->_set("zip_code", $request["zip_code"]);
    $peopleModel->_set("phone", $request["phone"]);
    $peopleModel->_set("date_birth", $request["date_birth"]);
    $peopleModel->_set("id_user", $request["id_user"]);
    
    $resp = $peopleService->peopleProfile($peopleModel);
    if ($resp["state"] == "ok") {     
        
        $response["state"] = "ok";
        $response["message"]= "The person has been updated successfully" ; 
        $response["data"] = $peopleModel->toJson(); 

        echoResponse(200, $response);            
    }else{
        $response["state"]= "ko";
        $response["message"]= $resp["message"];
        $response["data"] = $peopleModel;

        echoResponse(200, $response);
    }  
    
});

$api->get('/v1/tercero/tercerosActivosBusqueda/:busqueda','authenticate', function($busqueda) use ($api){
    
    $thirdPartiesService = new ThirdPartiesService();
    
    $resp = $thirdPartiesService->tercerosActivosBusqueda($busqueda);
    if ($resp["estado"] == "ok") {

        $datos = $resp["query"]->fetchAll(PDO::FETCH_ASSOC);      
        
        $response["estado"] = "ok";
        $response["mensaje"]= "No hay datos para mostrar" ; 
        $response["datos"] = $datos;

        if($resp["query"]->rowCount() > 0) 
            $response["mensaje"] = "Listado de terceros x busqueda: ". $busqueda; 

        echoResponse(200, $response);            
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});

?>