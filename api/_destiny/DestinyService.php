<?php

include_once './_configurations/ConexionService.php';
include_once './_configurations/LogModel.php';
include_once 'DestinyModel.php';

class DestinyService extends ConexionService{

    private $response = array(
        "state" => 0,
        "message" => 0,
        "query" => 0
    );  

    function destiny(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                d.id,
                d.type_id,
                t.`name` type,
                d.`name` destiny,
                CONCAT(d.`name`, " - ", t.`name`) union_destiny,
                d.address,
                d.notes,
                d.active
                FROM destinys d
                JOIN type t ON t.id = d.type_id
                ORDER BY d.`name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función destiny()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","DestinyService/destiny()");
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

    function destinyActive(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                d.id,
                d.type_id,
                t.`name` type,
                d.`name` destiny,
                CONCAT(d.`name`, " - ", t.`name`) union_destiny,
                d.address,
                d.notes,
                d.active
                FROM destinys d
                JOIN type t ON t.id = d.type_id
                WHERE d.active = 1
                ORDER BY d.`name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función destinyActive()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","DestinyService/destinyActive()");
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

    function destinyxId($id){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                d.id,
                d.type_id,
                t.`name` type,
                d.`name` destiny,
                CONCAT(d.`name`, " - ", t.`name`) union_destiny,
                d.address,
                d.notes,
                d.active
                FROM destinys d
                JOIN type t ON t.id = d.type_id 
                WHERE d.id = :id;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $id);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función destinyxId()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","DestinyService/destinyxId()");
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
    
    function destinyxIdType($id_type){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                d.id,
                d.type_id,
                t.`name` type,
                d.`name` destiny,
                CONCAT(d.`name`, " - ", t.`name`) union_destiny,
                d.address,
                d.notes,
                d.active
                FROM destinys d
                JOIN type t ON t.id = d.type_id 
                WHERE d.type_id = :id_type
                ORDER BY d.`name`;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_type", $id_type);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función destinyxId()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","DestinyService/destinyxId()");
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

    function destinyCU(DestinyModel $destinyModel){

        $pdo = $this->conectarBd();
        
        try{

            $query = '
                SELECT id,`name`,type_id,active FROM destinys WHERE id <> :id AND type_id = :type_id  AND `name` = :name;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $destinyModel->_get("id"));
            $result->bindValue(":type_id", $destinyModel->_get("type_id"));
            $result->bindValue(":name", $destinyModel->_get("name"));
            $result->execute(); 

            if($result->rowCount()== 0){

                $pdo->beginTransaction();

                $lastInsertId = $destinyModel->_get("id");
                
                if($destinyModel->_get("id") > 0){

                    $query = '
                        UPDATE destinys SET 
                                type_id = :type_id,
                                `name` = :name,
                                address = :address, 
                                notes = :notes,                                
                                active = :active, 
                                id_user = :id_user 
                        WHERE id = :id; 
                    ';

                    $result = $pdo->prepare($query);
                    $result->bindValue(":id", $destinyModel->_get("id"));

                }else{

                    $query = '
                        INSERT INTO destinys (type_id,`name`,notes,address,active,id_user) 
                                    VALUES (:type_id,:name,:notes,:address,:active,:id_user)
                    ';

                    $result = $pdo->prepare($query);
                }
                
                $result->bindValue(":type_id", $destinyModel->_get("type_id"));
                $result->bindValue(":name", strtoupper( $destinyModel->_get("name")));
                $result->bindValue(":address", strtoupper( $destinyModel->_get("address")));
                $result->bindValue(":notes", strtoupper( $destinyModel->_get("notes")));
                $result->bindValue(":active", $destinyModel->_get("active") ? 1 : 0);
                $result->bindValue(":id_user", $destinyModel->_get("id_user"));
                $result->execute();

                if($lastInsertId == 0){
                    $lastInsertId =  $pdo->lastInsertId();
                }                     

                $pdo->commit();

                $this->response["state"]= "ok";
                $this->response["message"]= "Resultado de la función destinyCU()";
                $this->response["query"]= $lastInsertId;
            }else{

                $this->response["state"]= "ko";
                $this->response["message"]= "The destiny is already in the database.";
                $this->response["query"]= $result;
            }      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","DestinyService/destinyCU()");
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