<?php

include_once './_configurations/ConexionService.php';
include_once './_configurations/LogModel.php';
include_once 'TypeIdetificationModel.php';

class TypeIdetificationService extends ConexionService{

    private $response = array(
        "state" => 0,
        "message" => 0,
        "query" => 0
    );  

    function typeIdetification(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                id,
                `name`,
                abbreviation,
                active
                FROM ad_m_type_identification
                ORDER BY `name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función typeIdetification()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","TypeIdetificationService/typeIdetification()");
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

    function typeIdetificationActive(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                id,
                `name`,
                abbreviation,
                active
                FROM ad_m_type_identification
                WHERE active = 1
                ORDER BY `name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función typeIdetificationActive()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","TypeIdetificationService/typeIdetificationActive()");
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

    function typeIdetificationxId($id){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                id,
                `name`,
                abbreviation,
                active
                FROM ad_m_type_identification 
                WHERE id = :id;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $id);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función typeIdetificationxId()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","TypeIdetificationService/typeIdetificationxId()");
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

    function typeIdetificationCU(TypeIdetificationModel $typeIdetificationModel){

        $pdo = $this->conectarBd();
        
        try{

            $query = '
                SELECT id,`name`,abbreviation,active FROM ad_m_type_identification
                WHERE id <> :id AND (`name` = :name OR abbreviation = :abbreviation);
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $typeIdetificationModel->_get("id"));
            $result->bindValue(":name", $typeIdetificationModel->_get("name"));
            $result->bindValue(":abbreviation", $typeIdetificationModel->_get("abbreviation"));
            $result->execute(); 

            if($result->rowCount()== 0){

                $pdo->beginTransaction();

                $lastInsertId = $typeIdetificationModel->_get("id");
                
                if($typeIdetificationModel->_get("id") > 0){

                    $query = '
                        UPDATE ad_m_type_identification SET 
                                `name` = :name, 
                                abbreviation = :abbreviation, 
                                active = :active, 
                                id_user = :id_user 
                        WHERE id = :id; 
                    ';

                    $result = $pdo->prepare($query);
                    $result->bindValue(":id", $typeIdetificationModel->_get("id"));

                }else{

                    $query = '
                        INSERT INTO ad_m_type_identification (`name`,abbreviation,active,id_user) 
                                    VALUES (:name,:abbreviation,:active,:id_user)
                    ';

                    $result = $pdo->prepare($query);
                }
                
                $result->bindValue(":name", strtoupper( $typeIdetificationModel->_get("name")));
                $result->bindValue(":abbreviation", strtoupper( $typeIdetificationModel->_get("abbreviation")));
                $result->bindValue(":active", $typeIdetificationModel->_get("active") ? 1 : 0);
                $result->bindValue(":id_user", $typeIdetificationModel->_get("id_user"));
                $result->execute();

                if($lastInsertId == 0){
                    $lastInsertId =  $pdo->lastInsertId();
                }                     

                $pdo->commit();

                $this->response["state"]= "ok";
                $this->response["message"]= "Resultado de la función typeIdetificationCU()";
                $this->response["query"]= $lastInsertId;
            }else{

                $this->response["state"]= "ko";
                $this->response["message"]= "The identification type or abbreviation is already in the database.";
                $this->response["query"]= $result;
            }      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","TypeIdetificationService/typeIdetificationCU()");
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