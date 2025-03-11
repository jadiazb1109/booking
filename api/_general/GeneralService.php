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

            $lastInsertId = 0;

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

            if ($currentRideBooking["return"] != null) {
                

                if ($currentRideBooking["return"]["return"] == true) {
                    $query = '
                        UPDATE booking SET 
                            `return` = 1,
                            return_date = :return_date,
                            return_destiny = :return_destiny,
                            return_pick_up_time = :return_pick_up_time
                        WHERE id = :id; 
                    ';

                    $result = $pdo->prepare($query);
                    $result->bindValue(":id", $lastInsertId);
                    $result->bindValue(":return_date", $currentRideBooking["return"]["date"]);
                    $result->bindValue(":return_destiny", $currentRideBooking["return"]["to"]);
                    $result->bindValue(":return_pick_up_time", $currentRideBooking["return"]["pick_up_time"]["time"]);
                    $result->execute();
                }

            }

            if ($currentRideBooking["destiny"] != null && $currentRideBooking["pay"] != null && $currentRideBooking["passenger_group"] == null) {
                
                $query = '
                    UPDATE booking SET 
                            price = :price,
                            additional = :additional,
                            pay = :pay
                    WHERE id = :id; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id", $lastInsertId);
                $result->bindValue(":price", $currentRideBooking["destiny"]["price"]);
                $result->bindValue(":additional", $currentRideBooking["destiny"]["additional"]);
                $result->bindValue(":pay", $currentRideBooking["pay"]);
                $result->execute();

            }

            if ($currentRideBooking["passenger_group"] != null) {
                
                $query = '
                    UPDATE booking SET 
                            passenger_min = :passenger_min,
                            passenger_max = :passenger_max,
                            `group` = 1,
                            price = :price,
                            additional = :additional,
                            pay = :pay
                    WHERE id = :id; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id", $lastInsertId);
                $result->bindValue(":passenger_min", $currentRideBooking["passenger_group"]["passenger_min"]);
                $result->bindValue(":passenger_max", $currentRideBooking["passenger_group"]["passenger_max"]);
                $result->bindValue(":price", $currentRideBooking["passenger_group"]["price"]);
                $result->bindValue(":additional", $currentRideBooking["passenger_group"]["additional"]);
                $result->bindValue(":pay", $currentRideBooking["pay"]);
                $result->execute();

            }

            if ($currentRideBooking["service"]["room_number"] == 1) {
                
                $query = '
                    UPDATE booking SET 
                        room_number = :room_number,
                        price = :price,
                        additional = :additional,
                        pay = :pay
                    WHERE id = :id; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id", $lastInsertId);
                $result->bindValue(":room_number", $currentRideBooking["room_number"]);
                $result->bindValue(":price", $currentRideBooking["destiny"]["price"]);
                $result->bindValue(":additional", $currentRideBooking["destiny"]["additional"]);
                $result->bindValue(":pay", $currentRideBooking["pay"]);
                $result->execute();

            }

            if ($currentRideBooking["client"] != null) {
                
                $query = '
                    UPDATE booking SET 
                        client_name = :client_name,
                        client_email = :client_email,
                        client_phone_number = :client_phone_number,
                        client_destiny = :client_destiny
                    WHERE id = :id; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id", $lastInsertId);
                $result->bindValue(":client_name", $currentRideBooking["client"]["name"]);
                $result->bindValue(":client_email", $currentRideBooking["client"]["email"]);
                $result->bindValue(":client_phone_number", $currentRideBooking["client"]["phone"]);
                $result->bindValue(":client_destiny", $currentRideBooking["client"]["destiny"]);
                $result->execute();

            }

            $pdo->commit();

            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función saveBookingRide()";
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

    function listBookingActivosxTypexDate($fecha_inicial, $fecha_final){

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
                b.return,
                b.return_date,
                b.return_pick_up_time,
                b.return_destiny,
				b.room_number,
                b.group,
                b.passenger,
                b.passenger_min,
                b.passenger_max,
                if(b.group = 0, b.passenger, CONCAT(b.passenger_min," - ",b.passenger_max))passengers,
                b.price,
                b.additional,
                b.pay,
                b.client_name,
                b.client_phone_number,
                b.client_email,
                b.client_destiny,
                b.state,
                b.active
                FROM booking b
                JOIN type t ON t.id = b.type_id
                JOIN origins o ON o.id = b.origin_id
                JOIN services s ON s.id = b.service_id
                JOIN destinys d ON d.id = b.destiny_id
                WHERE b.active = 1 AND
					b.date_departure BETWEEN :fecha_inicial AND :fecha_final 
                ORDER BY b.date_departure desc,b.pick_up_time;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":fecha_inicial", $fecha_inicial);
            $result->bindValue(":fecha_final", $fecha_final);
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

    function passengerGroupActivosxDestinyId($destiny_id){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                id,
                service_destiny_union_id,
                passenger_min,
                passenger_max,
                price,
                additional,
                notes,
                active
                FROM services_destiny_union_groups
                WHERE active = 1 AND service_destiny_union_id = :destiny_id
                ORDER BY passenger_min;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":destiny_id", $destiny_id);
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