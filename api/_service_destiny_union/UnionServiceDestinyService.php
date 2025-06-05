<?php

include_once './_configurations/ConexionService.php';
include_once './_configurations/LogModel.php';
include_once 'UnionServiceDestinyModel.php';

class UnionServiceDestinyService extends ConexionService{

    private $response = array(
        "state" => 0,
        "message" => 0,
        "query" => 0
    );  

    function unionServiceDestiny(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                s.type_id type_id_service,
                ts.`name` type_service,
                u.service_id,
                s.`name` service,
                d.type_id type_id_destiny,
                td.`name` type_destiny,
                u.destiny_id,
                d.`name` destiny,
                u.date,
                u.price,
                u.additional,
                u.promo_one_x_two,
                u.promo_next_pass,
                u.promo_next_pass_preci,
                u.important_information_initial,
                u.terms_and_conditions,
                u.notes,
                u.active
                FROM services_destiny_union u
                JOIN services s ON s.id = u.service_id
                JOIN type ts ON ts.id = s.type_id
                JOIN destinys d ON d.id = u.destiny_id
                JOIN type td ON td.id = d.type_id
                ORDER BY d.`name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función unionServiceDestiny()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UnionServiceDestinyService/unionServiceDestiny()");
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

    function unionServiceDestinyActive(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                s.type_id type_id_service,
                ts.`name` type_service,
                u.service_id,
                s.`name` service,
                d.type_id type_id_destiny,
                td.`name` type_destiny,
                u.destiny_id,
                d.`name` destiny,
                u.date,
                u.price,
                u.additional,
                u.promo_one_x_two,
                u.promo_next_pass,
                u.promo_next_pass_preci,
                u.important_information_initial,
                u.terms_and_conditions,
                u.notes,
                u.active
                FROM services_destiny_union u
                JOIN services s ON s.id = u.service_id
                JOIN type ts ON ts.id = s.type_id
                JOIN destinys d ON d.id = u.destiny_id
                JOIN type td ON td.id = d.type_id
                WHERE u.active = 1
                ORDER BY d.`name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función unionServiceDestinyActive()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UnionServiceDestinyService/unionServiceDestinyActive()");
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

    function unionServiceDestinyxId($id){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                s.type_id type_id_service,
                ts.`name` type_service,
                u.service_id,
                s.`name` service,
                d.type_id type_id_destiny,
                td.`name` type_destiny,
                u.destiny_id,
                d.`name` destiny,
                u.date,
                u.price,
                u.additional,
                u.promo_one_x_two,
                u.promo_next_pass,
                u.promo_next_pass_preci,
                u.important_information_initial,
                u.terms_and_conditions,
                u.notes,
                u.active
                FROM services_destiny_union u
                JOIN services s ON s.id = u.service_id
                JOIN type ts ON ts.id = s.type_id
                JOIN destinys d ON d.id = u.destiny_id
                JOIN type td ON td.id = d.type_id 
                WHERE u.id = :id;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $id);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función unionServiceDestinyxId()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UnionServiceDestinyService/unionServiceDestinyxId()");
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

    function unionServiceDestinyCU(UnionServiceDestinyModel $unionServiceDestinyModel){

        $pdo = $this->conectarBd();
        
        try{

            $unionQuery = "";

            if($unionServiceDestinyModel->_get("type_id") == 1) {
                $unionQuery .= ' AND date = :date ';
            };

            $query = '
                SELECT id,active FROM services_destiny_union WHERE id <> :id '.$unionQuery.'AND service_id = :service_id AND destiny_id = :destiny_id;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $unionServiceDestinyModel->_get("id"));
            $result->bindValue(":service_id", $unionServiceDestinyModel->_get("service_id"));
            $result->bindValue(":destiny_id", $unionServiceDestinyModel->_get("destiny_id"));
            if($unionServiceDestinyModel->_get("type_id") == 1) {
                $result->bindValue(":date", $unionServiceDestinyModel->_get("date"));
            };
            $result->execute(); 

            if($result->rowCount()== 0){

                $pdo->beginTransaction();

                $lastInsertId = $unionServiceDestinyModel->_get("id");
                
                if($unionServiceDestinyModel->_get("id") > 0){

                    $unionQuery = "";

                    if($unionServiceDestinyModel->_get("type_id") == 1) {
                        $unionQuery .= ' date = :date, ';
                    };

                    if($unionServiceDestinyModel->_get("type_id") == 1 || $unionServiceDestinyModel->_get("type_id") == 3) {

                        $unionQuery .= ' price = :price,  additional = :additional,';

                        if($unionServiceDestinyModel->_get("type_id") == 3) {

                            $unionQuery .= ' promo_one_x_two = :promo_one_x_two,
                                            promo_next_pass = :promo_next_pass,
                                            promo_next_pass_preci = :promo_next_pass_preci,
                                            important_information_initial = :important_information_initial,
                                            terms_and_conditions = :terms_and_conditions,';
                        }
                    };

                    $query = '
                        UPDATE services_destiny_union SET  
                                active = :active, '.
                                $unionQuery
                                .'notes = :notes,
                                id_user = :id_user 
                        WHERE id = :id; 
                    ';

                    $result = $pdo->prepare($query);
                    $result->bindValue(":id", $unionServiceDestinyModel->_get("id"));
                    

                }else{

                    $unionQuery = "";
                    $unionQueryParam = "";

                    if($unionServiceDestinyModel->_get("type_id") == 1) {
                        $unionQuery .= ' date, ';
                        $unionQueryParam .= ' :date, ';
                    };

                    if($unionServiceDestinyModel->_get("type_id") == 1 || $unionServiceDestinyModel->_get("type_id") == 3) {

                        $unionQuery .= ' price,  additional,';
                        $unionQueryParam .= ' :price,:additional,';

                        if($unionServiceDestinyModel->_get("type_id") == 3) {
                            
                            $unionQuery .= ' promo_one_x_two, promo_next_pass, promo_next_pass_preci, important_information_initial,
                                            terms_and_conditions,';

                            $unionQueryParam .= ' :promo_one_x_two, :promo_next_pass, :promo_next_pass_preci, :important_information_initial,
                                            :terms_and_conditions,';
                        }
                    };

                    $query = '
                        INSERT INTO services_destiny_union 
                                    (service_id,destiny_id,'.$unionQuery.'notes,active,id_user) 
                            VALUES (:service_id,:destiny_id,'.$unionQueryParam.':notes,:active,:id_user)
                    ';

                    $result = $pdo->prepare($query);
                    $result->bindValue(":service_id", $unionServiceDestinyModel->_get("service_id"));
                    $result->bindValue(":destiny_id", $unionServiceDestinyModel->_get("destiny_id"));
                }
                
                if($unionServiceDestinyModel->_get("type_id") == 1) {
                    $result->bindValue(":date", $unionServiceDestinyModel->_get("date"));
                };

                if($unionServiceDestinyModel->_get("type_id") == 1 || $unionServiceDestinyModel->_get("type_id") == 3) {

                    $result->bindValue(":price", $unionServiceDestinyModel->_get("price"));
                    $result->bindValue(":additional", $unionServiceDestinyModel->_get("additional"));

                    if($unionServiceDestinyModel->_get("type_id") == 3) {

                        $result->bindValue(":promo_one_x_two", $unionServiceDestinyModel->_get("promo_one_x_two"));
                        $result->bindValue(":promo_next_pass", $unionServiceDestinyModel->_get("promo_next_pass"));
                        $result->bindValue(":promo_next_pass_preci", $unionServiceDestinyModel->_get("promo_next_pass_preci"));
                        $result->bindValue(":important_information_initial", $unionServiceDestinyModel->_get("important_information_initial"));
                        $result->bindValue(":terms_and_conditions", $unionServiceDestinyModel->_get("terms_and_conditions"));
                    }
                };

                $result->bindValue(":notes", strtoupper( $unionServiceDestinyModel->_get("notes")));
                $result->bindValue(":active", $unionServiceDestinyModel->_get("active") ? 1 : 0);
                $result->bindValue(":id_user", $unionServiceDestinyModel->_get("id_user"));
                $result->execute();

                if($lastInsertId == 0){
                    $lastInsertId =  $pdo->lastInsertId();
                }                     

                $pdo->commit();

                $this->response["state"]= "ok";
                $this->response["message"]= "Resultado de la función unionServiceDestinyCU()";
                $this->response["query"]= $lastInsertId;
            }else{

                $this->response["state"]= "ko";
                $this->response["message"]= "The union service & destiny is already in the database.";
                $this->response["query"]= $result;
            }     

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UnionServiceDestinyService/unionServiceDestinyCU()");
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