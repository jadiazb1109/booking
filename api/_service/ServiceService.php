<?php

include_once './_configurations/ConexionService.php';
include_once './_configurations/LogModel.php';
include_once 'ServiceModel.php';

class ServiceService extends ConexionService{

    private $response = array(
        "state" => 0,
        "message" => 0,
        "query" => 0
    );  

    function service(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                s.id,
                s.type_id,
                t.`name` type,
                s.`name` service,
                CONCAT(s.`name`, " - ", t.`name`) union_service,
                s.notes,
                s.`return`,
                s.room_number,
                s.active
                FROM services s
                JOIN type t ON t.id = s.type_id
                ORDER BY s.`name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función service()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","ServiceService/service()");
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

    function serviceActive(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                s.id,
                s.type_id,
                t.`name` type,
                s.`name` service,
                CONCAT(s.`name`, " - ", t.`name`) union_service,
                s.notes,
                s.`return`,
                s.room_number,
                s.active
                FROM services s
                JOIN type t ON t.id = s.type_id
                WHERE s.active = 1
                ORDER BY s.`name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función serviceActive()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","ServiceService/serviceActive()");
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

    function servicexId($id){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                s.id,
                s.type_id,
                t.`name` type,
                s.`name` service,
                CONCAT(s.`name`, " - ", t.`name`) union_service,
                s.notes,
                s.`return`,
                s.room_number,
                s.active
                FROM services s
                JOIN type t ON t.id = s.type_id 
                WHERE s.id = :id;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $id);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función servicexId()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","ServiceService/servicexId()");
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

    function serviceCU(ServiceModel $serviceModel){

        $pdo = $this->conectarBd();
        
        try{

            $query = '
                SELECT id,`name`,type_id,active FROM services WHERE id <> :id AND `name` = :name;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $serviceModel->_get("id"));
            $result->bindValue(":name", $serviceModel->_get("name"));
            $result->execute(); 

            if($result->rowCount()== 0){

                $pdo->beginTransaction();

                $lastInsertId = $serviceModel->_get("id");
                
                if($serviceModel->_get("id") > 0){

                    $query = '
                        UPDATE services SET 
                                type_id = :type_id,
                                `name` = :name, 
                                notes = :notes, 
                                `return` = :return, 
                                room_number = :room_number, 
                                active = :active, 
                                id_user = :id_user 
                        WHERE id = :id; 
                    ';

                    $result = $pdo->prepare($query);
                    $result->bindValue(":id", $serviceModel->_get("id"));

                }else{

                    $query = '
                        INSERT INTO services (type_id,`name`,notes,`return`,room_number,active,id_user) 
                                    VALUES (:type_id,:name,:notes,:return,:room_number,:active,:id_user)
                    ';

                    $result = $pdo->prepare($query);
                }
                
                $result->bindValue(":type_id", $serviceModel->_get("type_id"));
                $result->bindValue(":name", strtoupper( $serviceModel->_get("name")));
                $result->bindValue(":notes", strtoupper( $serviceModel->_get("notes")));
                $result->bindValue(":return", $serviceModel->_get("return") ? 1 : 0);
                $result->bindValue(":room_number", $serviceModel->_get("room_number") ? 1 : 0);
                $result->bindValue(":active", $serviceModel->_get("active") ? 1 : 0);
                $result->bindValue(":id_user", $serviceModel->_get("id_user"));
                $result->execute();

                if($lastInsertId == 0){
                    $lastInsertId =  $pdo->lastInsertId();
                }                     

                $pdo->commit();

                $this->response["state"]= "ok";
                $this->response["message"]= "Resultado de la función serviceCU()";
                $this->response["query"]= $lastInsertId;
            }else{

                $this->response["state"]= "ko";
                $this->response["message"]= "The service is already in the database.";
                $this->response["query"]= $result;
            }      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","ServiceService/serviceCU()");
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

    function typeActive(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                id,
                `name`,
                active
                FROM type
                WHERE active = 1
                ORDER BY `name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función typeActive()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","OriginService/typeActive()");
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