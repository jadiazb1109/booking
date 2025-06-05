<?php

include_once './_configurations/ConexionService.php';
include_once './_configurations/LogModel.php';
include_once 'UnionServiceDestinyGroupModel.php';

class UnionServiceDestinyGroupService extends ConexionService{

    private $response = array(
        "state" => 0,
        "message" => 0,
        "query" => 0
    );  

    function unionServiceDestinyGroup(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                sdg.id,
                sdg.service_destiny_union_id,
                s.type_id type_id_service,
                ts.`name` type_service,
                u.service_id,
                s.`name` service,
                d.type_id type_id_destiny,
                td.`name` type_destiny,
                u.destiny_id,
                d.`name` destiny,
                sdg.passenger_min,
                sdg.passenger_max,
                sdg.price,
                sdg.additional,
                sdg.notes,
                sdg.active
                FROM services_destiny_union_groups sdg
                JOIN services_destiny_union u ON u.id = sdg.service_destiny_union_id
                JOIN services s ON s.id = u.service_id
                JOIN type ts ON ts.id = s.type_id
                JOIN destinys d ON d.id = u.destiny_id
                JOIN type td ON td.id = d.type_id
                ORDER BY d.`name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función unionServiceDestinyGroup()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UnionServiceDestinyGroupService/unionServiceDestinyGroup()");
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

    function unionServiceDestinyGroupActive(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                sdg.id,
                sdg.service_destiny_union_id,
                s.type_id type_id_service,
                ts.`name` type_service,
                u.service_id,
                s.`name` service,
                d.type_id type_id_destiny,
                td.`name` type_destiny,
                u.destiny_id,
                d.`name` destiny,
                sdg.passenger_min,
                sdg.passenger_max,
                sdg.price,
                sdg.additional,
                sdg.notes,
                sdg.active
                FROM services_destiny_union_groups sdg
                JOIN services_destiny_union u ON u.id = sdg.service_destiny_union_id
                JOIN services s ON s.id = u.service_id
                JOIN type ts ON ts.id = s.type_id
                JOIN destinys d ON d.id = u.destiny_id
                JOIN type td ON td.id = d.type_id
                WHERE sdg.active = 1
                ORDER BY d.`name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función unionServiceDestinyGroupActive()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UnionServiceDestinyGroupService/unionServiceDestinyGroupActive()");
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

    function unionServiceDestinyGroupxId($id){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                sdg.id,
                sdg.service_destiny_union_id,
                s.type_id type_id_service,
                ts.`name` type_service,
                u.service_id,
                s.`name` service,
                d.type_id type_id_destiny,
                td.`name` type_destiny,
                u.destiny_id,
                d.`name` destiny,
                sdg.passenger_min,
                sdg.passenger_max,
                sdg.price,
                sdg.additional,
                sdg.notes,
                sdg.active
                FROM services_destiny_union_groups sdg
                JOIN services_destiny_union u ON u.id = sdg.service_destiny_union_id
                JOIN services s ON s.id = u.service_id
                JOIN type ts ON ts.id = s.type_id
                JOIN destinys d ON d.id = u.destiny_id
                JOIN type td ON td.id = d.type_id
                WHERE sdg.id = :id;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $id);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función unionServiceDestinyGroupxId()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UnionServiceDestinyGroupService/unionServiceDestinyGroupxId()");
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

    function unionServiceDestinyGroupxIdUnion($id_union){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                sdg.id,
                sdg.service_destiny_union_id,
                s.type_id type_id_service,
                ts.`name` type_service,
                u.service_id,
                s.`name` service,
                d.type_id type_id_destiny,
                td.`name` type_destiny,
                u.destiny_id,
                d.`name` destiny,
                sdg.passenger_min,
                sdg.passenger_max,
                sdg.price,
                sdg.additional,
                sdg.notes,
                sdg.active
                FROM services_destiny_union_groups sdg
                JOIN services_destiny_union u ON u.id = sdg.service_destiny_union_id
                JOIN services s ON s.id = u.service_id
                JOIN type ts ON ts.id = s.type_id
                JOIN destinys d ON d.id = u.destiny_id
                JOIN type td ON td.id = d.type_id
                WHERE sdg.service_destiny_union_id = :id_union AND sdg.active = 1
                ORDER BY sdg.passenger_min;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_union", $id_union);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función unionServiceDestinyGroupxIdUnion()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UnionServiceDestinyGroupService/unionServiceDestinyGroupxIdUnion()");
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

    function unionServiceDestinyGroupCU(UnionServiceDestinyGroupModel $unionServiceDestinyGroupModel){

        $pdo = $this->conectarBd();
        
        try{

            $query = '
                SELECT max(passenger_max) max FROM services_destiny_union_groups 
                    WHERE service_destiny_union_id = :service_destiny_union_id AND active = 1;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":service_destiny_union_id", $unionServiceDestinyGroupModel->_get("service_destiny_union_id"));
            $result->execute(); 

            if($result->rowCount() > 0){

                $fila = $result->fetch();

                if($fila["max"] >= $unionServiceDestinyGroupModel->_get("passenger_min") && $unionServiceDestinyGroupModel->_get("id") == 0){

                    $this->response["state"]= "ko";
                    $this->response["message"]= "The minimum number of passengers must be greater than the maximum number of passengers.";
                    $this->response["query"]= [];
                    return $this->response;
                }else{

                    $pdo->beginTransaction();

                    $lastInsertId = $unionServiceDestinyGroupModel->_get("id");
                    
                    if($unionServiceDestinyGroupModel->_get("id") > 0){                        

                        $query = '
                            UPDATE services_destiny_union_groups SET  
                                    active = :active,
                                    id_user = :id_user 
                            WHERE id = :id; 
                        ';

                        $result = $pdo->prepare($query);
                        $result->bindValue(":id", $unionServiceDestinyGroupModel->_get("id"));
                        

                    }else{                        

                        $query = '
                            INSERT INTO services_destiny_union_groups 
                                        (service_destiny_union_id,passenger_min,passenger_max,price,additional,notes,active,id_user) 
                                VALUES (:service_destiny_union_id,:passenger_min,:passenger_max,:price,:additional,:notes,:active,:id_user)
                        ';

                        $result = $pdo->prepare($query);
                        $result->bindValue(":service_destiny_union_id", $unionServiceDestinyGroupModel->_get("service_destiny_union_id"));
                        $result->bindValue(":passenger_min", $unionServiceDestinyGroupModel->_get("passenger_min"));
                        $result->bindValue(":passenger_max", $unionServiceDestinyGroupModel->_get("passenger_max"));
                        $result->bindValue(":price", $unionServiceDestinyGroupModel->_get("price"));
                        $result->bindValue(":additional", $unionServiceDestinyGroupModel->_get("additional"));
                        $result->bindValue(":notes", strtoupper( $unionServiceDestinyGroupModel->_get("notes")));
                    }  

                    $result->bindValue(":active", $unionServiceDestinyGroupModel->_get("active") ? 1 : 0);
                    $result->bindValue(":id_user", $unionServiceDestinyGroupModel->_get("id_user"));
                    $result->execute();

                    if($lastInsertId == 0){
                        $lastInsertId =  $pdo->lastInsertId();
                    }                     

                    $pdo->commit();

                    $this->response["state"]= "ok";
                    $this->response["message"]= "Resultado de la función unionServiceDestinyGroupCU()";
                    $this->response["query"]= $lastInsertId;
                }
            }else{

                $this->response["state"]= "ko";
                $this->response["message"]= "The union service & destiny isn't exists in the database.";
                $this->response["query"]= $result;
            }     

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UnionServiceDestinyGroupService/unionServiceDestinyGroupCU()");
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