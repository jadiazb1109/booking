<?php

include_once './_configurations/ConexionService.php';
include_once './_configurations/LogModel.php';
include_once 'OriginModel.php';

class OriginService extends ConexionService{

    private $response = array(
        "state" => 0,
        "message" => 0,
        "query" => 0
    );  

    function origin(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                id,
                `name`,
                address,
                notes,
                active
                FROM origins
                ORDER BY `name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función origin()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","OriginService/origin()");
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

    function originActive(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                id,
                `name`,
                address,
                notes,
                active
                FROM origins
                WHERE active = 1
                ORDER BY `name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función originActive()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","OriginService/originActive()");
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

    function originxId($id){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                id,
                `name`,
                address,
                notes,
                active
                FROM origins 
                WHERE id = :id;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $id);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función originxId()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","OriginService/originxId()");
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

    function originCU(OriginModel $originModel){

        $pdo = $this->conectarBd();
        
        try{

            $query = '
                SELECT id,`name`,active FROM origins WHERE id <> :id AND `name` = :name;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $originModel->_get("id"));
            $result->bindValue(":name", $originModel->_get("name"));
            $result->execute(); 

            if($result->rowCount()== 0){

                $pdo->beginTransaction();

                $lastInsertId = $originModel->_get("id");
                
                if($originModel->_get("id") > 0){

                    $query = '
                        UPDATE origins SET 
                                `name` = :name, 
                                address = :address, 
                                notes = :notes, 
                                active = :active, 
                                id_user = :id_user 
                        WHERE id = :id; 
                    ';

                    $result = $pdo->prepare($query);
                    $result->bindValue(":id", $originModel->_get("id"));

                }else{

                    $query = '
                        INSERT INTO origins (`name`,address,notes,active,id_user) 
                                    VALUES (:name,:address,:notes,:active,:id_user)
                    ';

                    $result = $pdo->prepare($query);
                }
                
                $result->bindValue(":name", strtoupper( $originModel->_get("name")));
                $result->bindValue(":address", strtoupper( $originModel->_get("address")));
                $result->bindValue(":notes", strtoupper( $originModel->_get("notes")));
                $result->bindValue(":active", $originModel->_get("active") ? 1 : 0);
                $result->bindValue(":id_user", $originModel->_get("id_user"));
                $result->execute();

                if($lastInsertId == 0){
                    $lastInsertId =  $pdo->lastInsertId();
                }                     

                $pdo->commit();

                $this->response["state"]= "ok";
                $this->response["message"]= "Resultado de la función originCU()";
                $this->response["query"]= $lastInsertId;
            }else{

                $this->response["state"]= "ko";
                $this->response["message"]= "The origin is already in the database.";
                $this->response["query"]= $result;
            }      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","OriginService/originCU()");
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