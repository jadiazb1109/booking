<?php
/* Los headers permiten acceso desde otro dominio (CORS) a nuestro REST API o desde un cliente remoto via HTTP
 * Removiendo las lineas header() limitamos el acceso a nuestro RESTfull API a el mismo dominio
 * Nótese los métodos permitidos en Access-Control-Allow-Methods. Esto nos permite limitar los métodos de consulta a nuestro RESTfull API
 * Mas información: https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
 **/
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: X-Api-Key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header('Content-Type: application/json; charset=utf-8');
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');


//instanciamos la libreria para la aplicacion
require 'libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$api = new \Slim\Slim();


//agregamos los archivos de negocios para su llamado
include_once '_general/GeneralController.php';
include_once '_user/UserController.php';
include_once '_people/PeopleController.php'; 
include_once '_rol/RolController.php';
include_once '_type_idetification/TypeIdetificationController.php';
include_once '_origin/OriginController.php';
include_once '_service/ServiceController.php';
include_once '_origin_service_union/UnionOriginServiceController.php';
include_once '_destiny/DestinyController.php';
include_once '_service_destiny_union/UnionServiceDestinyController.php';
include_once '_service_destiny_union_group/UnionServiceDestinyGroupController.php';

//iniciamos la aplicacion
$api->run();

/*********************** USEFULL FUNCTIONS **************************************/

/**
 * Verificando los parametros requeridos en el metodo o endpoint
 */
function verifyRequiredParams($required_fields)
{
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    $data = "";
    // Handling POST / PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT') {
        $api = \Slim\Slim::getInstance();
        $request_params = json_decode(file_get_contents("php://input"), true);
        $data = json_decode(file_get_contents("php://input"), true);
    }

    foreach ($required_fields as $field) {
        if (!array_key_exists($field, $request_params)) {
            $error = true;
            $error_fields .= $field . ': <required>, ';
        } else {
            if (!is_bool($request_params[$field])) {
                if (strlen(trim($request_params[$field])) <= 0) {
                    $error = true;
                    $error_fields .= $field . ': <is empty>, ';
                }
            }
        }
    }

    if ($error) {
        $response = array();
        $api = \Slim\Slim::getInstance();
        $response["state"] = "ko";
        $response["message"] = 'Required fields: ' . substr($error_fields, 0, -2);
        $response["data"] = $data;
        echoResponse(400, $response);

        $api->stop();
    }
}

function verifyRequiredParamsPost($required_fields)
{
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    $data = "";
    // Handling POST / PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT') {
        $api = \Slim\Slim::getInstance();
        $request_params = $_POST;
        $data = $_POST;
    }
    foreach ($required_fields as $field) {
        if (!array_key_exists($field, $request_params)) {
            $error = true;
            $error_fields .= $field . ': <required>, ';
        } else {
            if (!is_bool($request_params[$field])) {
                if (strlen(trim($request_params[$field])) <= 0 || is_null($request_params[$field]) || strtoupper($request_params[$field]) == 'NULL') {
                    $error = true;
                    $error_fields .= $field . ': <is empty>, ';
                }
            }
        }
    }

    if ($error) {
        $response = array();
        $api = \Slim\Slim::getInstance();
        $response["state"] = "ko";
        $response["message"] = 'Required fields: ' . substr($error_fields, 0, -2);
        $response["data"] = $data;
        echoResponse(400, $response);

        $api->stop();
    }
}


/**
 * Mostrando la respuesta en formato json al cliente o navegador
 */
function echoResponse($statusCode, $response)
{
    $api = \Slim\Slim::getInstance();
    // Http response code
    $api->status($statusCode);

    // setting response content type to json
    $api->contentType('application/json');

    echo json_encode($response, 512);
}

/**
 * Agregando un leyer intermedio e autenticación para uno o todos los metodos, usar segun necesidad
 * Revisa si la consulta contiene un Header "Authorization" para validar
 */
function authenticate(\Slim\Route $route)
{
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $api = \Slim\Slim::getInstance();

    //echo json_encode($headers,512);

    $api_key = "";
    
    if (isset($headers['Api-Key'])) {
        $api_key = $headers['Api-Key'];
    }

    if (isset($headers['api-key'])) {
        $api_key = $headers['api-key'];
    }

    // Verifying Authorization Header
    if ($api_key !== "") {
        //$db = new DbHandler(); //utilizar para manejar autenticacion contra base de datos

        // get the api key
        $token = $api_key;

        $userService = new UserService();

        $validarToken = $userService->userValidateToken($token);

        // validating api key
        if (!$validarToken["query"]->rowCount()) {

            // api key is not present in users table
            $response["state"] = "ko";
            $response["message"] = "Access denied. Incorrect token.";
            $response["data"] = [];
            echoResponse(401, $response);

            $api->stop(); //Detenemos la ejecución del programa al no validar            
        }
    } else {
        // api key is missing in header
        $response["state"] = "ko";
        $response["message"] = "Missing authorization token. Headers <Api-Key: some_key>";
        $response["data"] = [];
        echoResponse(400, $response);

        $api->stop();
    }
}
