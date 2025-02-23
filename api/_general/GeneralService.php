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
                s.return,               
                s.room_number,
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

    function destinyUnionActivosxServiceIdDate($service_id,$date){

        $pdo = $this->conectarBd();

        $whereDate = '';

        if ($date != "null") {
            $whereDate = ' AND sdu.date = "'.$date.'"';
        }

        try{

            $query = '
                SELECT 
                sdu.id,
                sdu.service_id,
                s.name serivce,
                d.type_id,
                t.name type,
                sdu.destiny_id,
                d.name destiny,
                d.address,
                sdu.date,
                sdu.price,
                sdu.additional,
                sdu.important_information_initial,
                sdu.terms_and_conditions,
                sdu.notes,
                sdu.active
                FROM services_destiny_union sdu
                JOIN services s ON s.id = sdu.service_id
                JOIN destinys d ON d.id = sdu.destiny_id
                JOIN type t ON t.id = d.type_id
                WHERE sdu.active = 1 AND sdu.service_id = :service_id '.$whereDate.'
                ORDER BY d.name;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":service_id", $service_id);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función destinyUnionActivosxServiceIdDate()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","GeneralService/destinyUnionActivosxServiceIdDate()");
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

    function pickUpTimeActivosxServiceId($service_id,$date){

        $pdo = $this->conectarBd();

        date_default_timezone_set("America/Bogota");
        $whereDate = '';

        if ( date($date) == date("Y-m-d")) {
            $whereDate = ' AND sput.time BETWEEN TIME_FORMAT(NOW() , "%H:%i:%ss") AND TIME_FORMAT("23:59:00" , "%H:%i:%ss")';
        }

        try{

            $query = '
                SELECT
                sput.id,
                sput.service_id,
                s.name service,
                sput.time,
                TIME_FORMAT(sput.time , "%h:%i %p")time_format,
                sput.active
                FROM services_pick_up_time sput
                JOIN services s ON s.id = sput.service_id
                WHERE sput.active = 1 AND sput.service_id = :service_id AND sput.return = 0
                    '.$whereDate.'
                ORDER BY sput.time;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":service_id", $service_id);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función pickUpTimeActivosxServiceId()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","GeneralService/pickUpTimeActivosxServiceId()");
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

    function pickUpTimeActivosReturnxServiceId($service_id,$date){

        $pdo = $this->conectarBd();

        date_default_timezone_set("America/Bogota");
        $whereDate = '';

        if ( date($date) == date("Y-m-d")) {
            $whereDate = ' AND sput.time BETWEEN TIME_FORMAT(NOW() , "%H:%i:%ss") AND TIME_FORMAT("23:59:00" , "%H:%i:%ss")';
        }

        try{

            $query = '
                SELECT
                sput.id,
                sput.service_id,
                s.name service,
                sput.time,
                TIME_FORMAT(sput.time , "%h:%i %p")time_format,
                sput.active
                FROM services_pick_up_time sput
                JOIN services s ON s.id = sput.service_id
                WHERE sput.active = 1 AND sput.service_id = :service_id AND sput.return = 1
                    '.$whereDate.'
                ORDER BY sput.time;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":service_id", $service_id);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función pickUpTimeActivosReturnxServiceId()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","GeneralService/pickUpTimeActivosReturnxServiceId()");
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

    function saveBookingRide($currentRideBooking){

        $pdo = $this->conectarBd();
        
        try{

            $pdo->beginTransaction();


            $query = '
                    INSERT INTO booking (uuid,date,type_id,date_departure,pick_up_time,origin_id,service_id,destiny_id,passenger,state) 
                                VALUES (:uuid,now(),:type_id,:date_departure,:pick_up_time,:origin_id,:service_id,:destiny_id,:passenger,"SCHEDULER")
                ';

            $result = $pdo->prepare($query);
            $result->bindValue(":uuid", $currentRideBooking["uuid"]);
            $result->bindValue(":type_id", $currentRideBooking["service"]["type_id"]);
            $result->bindValue(":date_departure", $currentRideBooking["date"]);
            $result->bindValue(":pick_up_time", $currentRideBooking["pick_up_time"]["time"]);
            $result->bindValue(":origin_id", $currentRideBooking["origin"]["id"]);
            $result->bindValue(":service_id", $currentRideBooking["service"]["id"]);
            $result->bindValue(":destiny_id", $currentRideBooking["destiny"]["destiny_id"]);
            $result->bindValue(":passenger", $currentRideBooking["passenger_qty"]);
            $result->execute();

            $lastInsertId =  $pdo->lastInsertId();

            if ($currentRideBooking["service"]["room_number"] == 1) {
                
                $query = '
                    UPDATE booking SET 
                            room_number = :room_number
                    WHERE id = :id; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id", $lastInsertId);
                $result->bindValue(":room_number", $currentRideBooking["room_number"]);
                $result->execute();

            }

            $pdo->commit();

            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función saveBookingRide()";
            $this->response["query"]= $lastInsertId;     

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","GeneralService/saveBookingRide()");
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

    function listBookingActivosxTypeId2(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                b.id,
                b.uuid,
                b.date,
                b.type_id,
                t.name type,
                b.date_departure,
                b.pick_up_time,
                TIME_FORMAT(b.pick_up_time , "%h:%i %p")pick_up_time_format,
                b.origin_id,
                o.name origin,
                b.service_id,
                s.name service,
                b.destiny_id,
                d.name destiny,
                b.passenger,
                b.room_number,
                b.state,
                b.active
                FROM booking b
                JOIN type t ON t.id = b.type_id
                JOIN origins o ON o.id = b.origin_id
                JOIN services s ON s.id = b.service_id
                JOIN destinys d ON d.id = b.destiny_id
                WHERE b.type_id = 2 AND b.date_departure = DATE_FORMAT(NOW(),"%Y-%m-%d") AND b.active = 1
                ORDER BY b.pick_up_time;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función listBookingActivosxTypeId2()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","GeneralService/listBookingActivosxTypeId2()");
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