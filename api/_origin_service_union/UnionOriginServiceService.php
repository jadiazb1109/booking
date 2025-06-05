<?php

include_once './_configurations/ConexionService.php';
include_once './_configurations/LogModel.php';
include_once 'UnionOriginServiceModel.php';

class UnionOriginServiceService extends ConexionService{

    private $response = array(
        "state" => 0,
        "message" => 0,
        "query" => 0
    );  

    function unionOriginService(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                u.origin_id,
                o.`name` origin,
                s.type_id,
                t.`name` type,
                u.service_id,
                s.`name` service,
                u.active
                FROM origins_services_union u
                JOIN origins o ON o.id = u.origin_id
                JOIN services s ON s.id = u.service_id
                JOIN type t ON t.id = s.type_id
                ORDER BY s.`name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función unionOriginService()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UnionOriginServiceService/unionOriginService()");
            $logModel->_set("query",$query);
            $logModel->_set("code",$e->getCode());
            $logModel->_set("error",$e->getMessage());

            $logModel->_set("id",$this->guardarLogErrores($logModel));

            $this->response["state"]= "ko";
            $this->response["message"]= "Error executing query. Code: ".$logModel->_get("id");
            $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }  

    function unionOriginServiceActive(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                u.origin_id,
                o.`name` origin,
                s.type_id,
                t.`name` type,
                u.service_id,
                s.`name` service,
                u.active
                FROM origins_services_union u
                JOIN origins o ON o.id = u.origin_id
                JOIN services s ON s.id = u.service_id
                JOIN type t ON t.id = s.type_id
                WHERE u.active = 1
                ORDER BY s.`name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función unionOriginServiceActive()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UnionOriginServiceService/unionOriginServiceActive()");
            $logModel->_set("query",$query);
            $logModel->_set("code",$e->getCode());
            $logModel->_set("error",$e->getMessage());

            $logModel->_set("id",$this->guardarLogErrores($logModel));

            $this->response["state"]= "ko";
            $this->response["message"]= "Error executing query. Code: ".$logModel->_get("id");
            $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    } 

    function unionOriginServicexId($id){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                u.origin_id,
                o.`name` origin,
                s.type_id,
                t.`name` type,
                u.service_id,
                s.`name` service,
                u.active
                FROM origins_services_union u
                JOIN origins o ON o.id = u.origin_id
                JOIN services s ON s.id = u.service_id
                JOIN type t ON t.id = s.type_id 
                WHERE u.id = :id;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $id);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función unionOriginServicexId()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UnionOriginServiceService/unionOriginServicexId()");
            $logModel->_set("query",$query);
            $logModel->_set("code",$e->getCode());
            $logModel->_set("error",$e->getMessage());

            $logModel->_set("id",$this->guardarLogErrores($logModel));

            $this->response["state"]= "ko";
            $this->response["message"]= "Error executing query. Code: ".$logModel->_get("id");
            $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }   

    function unionOriginServiceCU(UnionOriginServiceModel $unionOriginServiceModel){

        $pdo = $this->conectarBd();
        
        try{

            $query = '
                SELECT id,active FROM origins_services_union
                WHERE id <> :id AND origin_id = :origin_id AND service_id = :service_id;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $unionOriginServiceModel->_get("id"));
            $result->bindValue(":origin_id", $unionOriginServiceModel->_get("origin_id"));
            $result->bindValue(":service_id", $unionOriginServiceModel->_get("service_id"));
            $result->execute(); 

            if($result->rowCount()== 0){

                $pdo->beginTransaction();

                $lastInsertId = $unionOriginServiceModel->_get("id");
                
                if($unionOriginServiceModel->_get("id") > 0){

                    $query = '
                        UPDATE origins_services_union SET  
                                active = :active, 
                                id_user = :id_user 
                        WHERE id = :id; 
                    ';

                    $result = $pdo->prepare($query);
                    $result->bindValue(":id", $unionOriginServiceModel->_get("id"));

                }else{

                    $query = '
                        INSERT INTO origins_services_union 
                                    (origin_id,service_id,active,id_user) 
                            VALUES (:origin_id,:service_id,:active,:id_user)
                    ';

                    $result = $pdo->prepare($query);
                    $result->bindValue(":origin_id", $unionOriginServiceModel->_get("origin_id"));
                    $result->bindValue(":service_id", $unionOriginServiceModel->_get("service_id"));
                }                
                
                $result->bindValue(":active", $unionOriginServiceModel->_get("active") ? 1 : 0);
                $result->bindValue(":id_user", $unionOriginServiceModel->_get("id_user"));
                $result->execute();

                if($lastInsertId == 0){
                    $lastInsertId =  $pdo->lastInsertId();
                }                     

                $pdo->commit();

                $this->response["state"]= "ok";
                $this->response["message"]= "Resultado de la función unionOriginServiceCU()";
                $this->response["query"]= $lastInsertId;
            }else{

                $this->response["state"]= "ko";
                $this->response["message"]= "The union origin & service is already in the database.";
                $this->response["query"]= $result;
            }     

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UnionOriginServiceService/unionOriginServiceCU()");
            $logModel->_set("query",$query);
            $logModel->_set("code",$e->getCode());
            $logModel->_set("error",$e->getMessage());

            $logModel->_set("id",$this->guardarLogErrores($logModel));

            $this->response["state"]= "ko";
            $this->response["message"]= "Error executing query. Code: ".$logModel->_get("id");
            $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
    }

}
?>