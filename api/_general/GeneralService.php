<?php

include_once './_configurations/ConexionService.php';
include_once './_configurations/LogModel.php';

class GeneralService extends ConexionService{

    private $response = array(
        "state" => 0,
        "message" => 0,
        "query" => []
    );    

    function originActivos(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                id,
                name,
                address,
                notes,
                active
                FROM origins 
                WHERE active = 1
                ORDER BY name;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función originActivos()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","GeneralService/originActivos()");
            $logModel->_set("query",$query);
            $logModel->_set("code",$e->getCode());
            $logModel->_set("error",$e->getMessage());

            $logModel->_set("id",$this->guardarLogErrores($logModel));

           $this->response["state"]= "ko";
           $this->response["message"]= "Error al ejecutar la sentencia. Codigo: ".$logModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }

    function serviceActivosxOriginId($origin_id){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                s.id,
                u.origin_id,
                s.type_id,
                t.name type,
                s.name,
                s.notes,
                s.active
                FROM services s
                JOIN type t ON t.id = s.type_id
                JOIN origins_services_union u ON u.service_id = s.id
                WHERE s.active = 1 AND u.origin_id = :origin_id
                ORDER BY s.name;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":origin_id", $origin_id);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función serviceActivosxOriginId()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","GeneralService/serviceActivosxOriginId()");
            $logModel->_set("query",$query);
            $logModel->_set("code",$e->getCode());
            $logModel->_set("error",$e->getMessage());

            $logModel->_set("id",$this->guardarLogErrores($logModel));

           $this->response["state"]= "ko";
           $this->response["message"]= "Error al ejecutar la sentencia. Codigo: ".$logModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }

}
?>