<?php
include_once './_user/UserService.php';
include_once './_user/UserModel.php';
include_once './_message/EnviarCorreoService.php';
include_once './libs/Slim/Slim.php';

$response = array(
    "estado" => 0,
    "mensaje" => 0,
    "datos" => array()
);

$api->post('/v1/general/validarLogin', function () use ($api) {

    verifyRequiredParams(array('usuario', 'clave'));

    $userService = new UserService();

    $usuarioModel = new UserModel();

    $request = json_decode(file_get_contents("php://input"), true);

    $usuarioModel->_set("usuario", $request["usuario"]);
    $usuarioModel->_set("clave", $request["clave"]);

    $resp = $userService->usuariosValidarLogin($usuarioModel->_get("usuario"), $usuarioModel->_get("clave"));

    if ($resp["estado"] == "ok") {

        if ($resp["query"]->rowCount()) {

            $fila = $resp["query"]->fetch();

            $usuarioModel->_set("id", $fila["id"]);
            $usuarioModel->_set("id_tercero", $fila["id_tercero"]);
            $usuarioModel->_set("tercero", $fila["tercero"]);
            $usuarioModel->_set("usuario", $fila["usuario"]);
            $usuarioModel->_set("clave", $fila["clave"]);
            $usuarioModel->_set("token", $fila["token"]);
            $usuarioModel->_set("activo", $fila["activo"]);

            if ($usuarioModel->_get("activo") == 0) {

                $usuarioModel->_set("token", "");

                $response["estado"] = "bl";
                $response["mensaje"] = "El usuario '" . $usuarioModel->_get("usuario") . "' esta bloqueado.";
                $response["datos"] = $usuarioModel;

                echoResponse(200, $response);
            } else {

                $token = bin2hex(openssl_random_pseudo_bytes(16, $val));

                $usuarioModel->_set("token", $token);

                $respT = $userService->usuariosActualizarToken($usuarioModel);

                if ($respT["estado"] == "ok") {

                    $userService->usuariosRegistrarLog($usuarioModel);

                    $response["estado"] = "ok";
                    $response["mensaje"] = "Bienvenido al sistema " . $usuarioModel->_get("tercero");

                    $usuarioModel->_set("clave", null);

                    $response["datos"] = $usuarioModel->toJsonLogin();

                    echoResponse(200, $response);
                } else {

                    $response["estado"] = "ko";
                    $response["mensaje"] = $respT["mensaje"];
                    $response["datos"] = [];

                    echoResponse(200, $response);
                }
            }
        } else {

            $response["estado"] = "ko";
            $response["mensaje"] = "Usuario y clave errados.";
            $response["datos"] = $usuarioModel->toJsonLogin();

            echoResponse(200, $response);
        }
    } else {
        $response["estado"] = "ko";
        $response["mensaje"] = $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }
});

$api->get('/v1/general/validarToken/:token', function ($token) use ($api) {

    $userService = new UserService();

    $request = json_decode(file_get_contents("php://input"), true);

    $resp = $userService->usuariosValidarToken($token);

    if ($resp["estado"] == "ok") {

        if ($resp["query"]->rowCount()) {

            $response["estado"] = "ok";
            $response["mensaje"] = "Acceso concedido";
            $response["datos"] = $token;

            echoResponse(200, $response);
        } else {

            $response["estado"] = "ko";
            $response["mensaje"] = "Acceso denegado. Token incorrecto.";
            $response["datos"] = [];

            echoResponse(200, $response);
        }
    } else {
        $response["estado"] = "ko";
        $response["mensaje"] = $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }
});

$api->get('/v1/general/restablecerClave/:correo', function($correo) use ($api){
    
    $userService = new UserService();

    $claveNueva = bin2hex(openssl_random_pseudo_bytes(3,$val));
    
    $resp = $userService->usuariosRestablecerClave($correo,base64_encode($claveNueva));

    if ($resp["estado"] == "ok") {

        $fila = $resp["query"];

        $enviarCorreoService = new EnviarCorreoService();
    
        $respCorreo = $enviarCorreoService->correoRestablecerClave($fila["nombres"],$fila["usuario"],$correo,$claveNueva);
    
        if ($respCorreo["estado"] == "ok") {          
            
            $response["estado"] = "ok";
            $response["mensaje"] = "Se ha enviado la información al correo: <". $correo .">";        
            $response["datos"] = []; 
    
            echoResponse(200, $response);
            
        }else{
            $response["estado"]= "ko";
            $response["mensaje"]= $respCorreo["mensaje"];
            $response["datos"] = [];
    
            echoResponse(200, $response);
        }
        
    }else{
        $response["estado"]= "ko";
        $response["mensaje"]= $resp["mensaje"];
        $response["datos"] = [];

        echoResponse(200, $response);
    }  
    
});
