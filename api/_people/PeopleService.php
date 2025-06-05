<?php

include_once './_configurations/ConexionService.php';
include_once './_configurations/LogModel.php';
include_once 'PeopleModel.php';

class PeopleService extends ConexionService{

    private $response = array(
        "state" => 0,
        "message" => 0,
        "query" => 0
    );    

    function terceros(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                t.id,
                t.id_tipo_identificacion,
                i.descripcion tipo_identificacion,
                t.numero_identificacion,
                t.nombres,
                t.correo,
                t.direccion,
                t.telefono,
                t.fecha_nacimiento,
                t.id_genero,
                g.descripcion genero,
                t.id_estado_civil,
                e.descripcion estado_civil,
                t.activo,
                IFNULL(tp.id,0) id_proveedor,
                IF(tp.id is NULL, false, true) proveedor,
                IFNULL(te.id,0) id_empleado,
                IF(te.id is NULL, false, true) empleado,
                IFNULL(tu.id,0) id_usuario,
                IF(tu.id is NULL, false, true) usuario
                FROM gen_terceros t
                JOIN gen_m_tipos_identificacion i ON i.id = t.id_tipo_identificacion
                LEFT JOIN gen_m_generos g ON g.id = t.id_genero
                LEFT JOIN gen_m_estados_civil e ON e.id = t.id_estado_civil
                LEFT JOIN gen_terceros_proveedores tp ON tp.id_tercero = t.id
                LEFT JOIN gen_terceros_empleados te ON te.id_tercero = t.id
                LEFT JOIN gen_terceros_usuarios tu ON tu.id_tercero = t.id
                ORDER BY t.nombres;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función terceros()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("metodo","ThirdPartiesService/terceros()");
            $logModel->_set("consulta",$query);
            $logModel->_set("codigo",$e->getCode());
            $logModel->_set("error",$e->getMessage());

            $logModel->_set("id",$this->guardarLogErrores($logModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$logModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }  

    function tercerosActivos(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                t.id,
                t.id_tipo_identificacion,
                i.descripcion tipo_identificacion,
                t.numero_identificacion,
                t.nombres,
                t.correo,
                t.direccion,
                t.telefono,
                t.fecha_nacimiento,
                t.id_genero,
                g.descripcion genero,
                t.id_estado_civil,
                e.descripcion estado_civil,
                t.activo,
                IFNULL(tp.id,0) id_proveedor,
                IF(tp.id is NULL, false, true) proveedor,
                IFNULL(te.id,0) id_empleado,
                IF(te.id is NULL, false, true) empleado,
                IFNULL(tu.id,0) id_usuario,
                IF(tu.id is NULL, false, true) usuario
                FROM gen_terceros t
                JOIN gen_m_tipos_identificacion i ON i.id = t.id_tipo_identificacion
                LEFT JOIN gen_m_generos g ON g.id = t.id_genero
                LEFT JOIN gen_m_estados_civil e ON e.id = t.id_estado_civil
                LEFT JOIN gen_terceros_proveedores tp ON tp.id_tercero = t.id
                LEFT JOIN gen_terceros_empleados te ON te.id_tercero = t.id
                LEFT JOIN gen_terceros_usuarios tu ON tu.id_tercero = t.id
                WHERE t.activo = 1
                ORDER BY t.nombres;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función tercerosActivos()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("metodo","ThirdPartiesService/tercerosActivos()");
            $logModel->_set("consulta",$query);
            $logModel->_set("codigo",$e->getCode());
            $logModel->_set("error",$e->getMessage());

            $logModel->_set("id",$this->guardarLogErrores($logModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$logModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    } 

    function tercerosxId($id){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                t.id,
                t.id_tipo_identificacion,
                i.descripcion tipo_identificacion,
                t.numero_identificacion,
                t.nombres,
                t.correo,
                t.direccion,
                t.telefono,
                t.fecha_nacimiento,
                t.id_genero,
                g.descripcion genero,
                t.id_estado_civil,
                e.descripcion estado_civil,
                t.activo,
                IFNULL(tp.id,0) id_proveedor,
                IF(tp.id is NULL, false, true) proveedor,
                IFNULL(te.id,0) id_empleado,
                IF(te.id is NULL, false, true) empleado,
                IFNULL(tu.id,0) id_usuario,
                IF(tu.id is NULL, false, true) usuario
                FROM gen_terceros t
                JOIN gen_m_tipos_identificacion i ON i.id = t.id_tipo_identificacion
                LEFT JOIN gen_m_generos g ON g.id = t.id_genero
                LEFT JOIN gen_m_estados_civil e ON e.id = t.id_estado_civil 
                LEFT JOIN gen_terceros_proveedores tp ON tp.id_tercero = t.id
                LEFT JOIN gen_terceros_empleados te ON te.id_tercero = t.id
                LEFT JOIN gen_terceros_usuarios tu ON tu.id_tercero = t.id
                WHERE t.id = :id;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $id);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función tercerosxId()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("metodo","ThirdPartiesService/tercerosxId()");
            $logModel->_set("consulta",$query);
            $logModel->_set("codigo",$e->getCode());
            $logModel->_set("error",$e->getMessage());

            $logModel->_set("id",$this->guardarLogErrores($logModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$logModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }    

    function peopleCU(PeopleModel $peopleModel){

        $pdo = $this->conectarBd();
        
        try{

            $query = '
                SELECT id,id_type_identification,number,active FROM ad_people
                WHERE id <> :id AND id_type_identification = :id_type_identification AND number = :number;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $peopleModel->_get("id"));
            $result->bindValue(":id_type_identification", $peopleModel->_get("id_type_identification"));
            $result->bindValue(":number", $peopleModel->_get("number"));
            $result->execute(); 

            if($result->rowCount()== 0){

                $query = '
                    SELECT id,email,active FROM ad_people WHERE id <> :id AND email = :email ;
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id", $peopleModel->_get("id"));
                $result->bindValue(":email", $peopleModel->_get("email"));
                $result->execute(); 

                if($result->rowCount() > 0){
                    $this->response["state"]= "ko";
                    $this->response["message"]= "Email is already in the database.";
                    $this->response["query"]= $result;

                }else{

                    $query = '
                        SELECT id,id_people,active FROM ad_people_user
                        WHERE id <> :id AND (id_people = :id_people OR username = :username);
                    ';

                    $result = $pdo->prepare($query);
                    $result->bindValue(":id", 0);
                    $result->bindValue(":id_people",  $peopleModel->_get("id"));
                    $result->bindValue(":username", $peopleModel->_get("txtUsuarioUsuario"));
                    $result->execute(); 

                    if($result->rowCount()> 0 && $peopleModel->_get("guardarUsuario")){
                        $this->response["state"]= "ko";
                        $this->response["message"]= "Username is already in the database.";
                        $this->response["query"]= $result;

                    }else{

                        $pdo->beginTransaction();

                        $lastInsertId = $peopleModel->_get("id");
                        
                        if($peopleModel->_get("id") > 0){

                            $query = '
                                UPDATE ad_people SET 
                                        id_type_identification = :id_type_identification,
                                        number = :number,
                                        name = :name,
                                        email = :email,
                                        address = :address,
                                        city = :city,
                                        state = :state,
                                        zip_code = :zip_code,
                                        phone = :phone,
                                        date_birth = :date_birth, 
                                        active = :active, 
                                        id_user = :id_user 
                                WHERE id = :id; 
                            ';

                            $result = $pdo->prepare($query);
                            $result->bindValue(":id", $peopleModel->_get("id"));

                        }else{

                            $query = '
                                INSERT INTO ad_people (id_type_identification,
                                                            number,
                                                            name,
                                                            email,
                                                            address,
                                                            city,
                                                            state,
                                                            zip_code,
                                                            phone,date_birth,active,id_user) 
                                            VALUES (:id_type_identification,
                                                    :number,
                                                    :name,
                                                    :email,
                                                    :address,
                                                    :city,
                                                    :state,
                                                    :zip_code,
                                                    :phone,:date_birth,:active,:id_user)
                            ';

                            $result = $pdo->prepare($query);
                        }
                        
                        $result->bindValue(":id_type_identification", $peopleModel->_get("id_type_identification"));
                        $result->bindValue(":number", strtoupper( $peopleModel->_get("number")));
                        $result->bindValue(":name", strtoupper( $peopleModel->_get("name")));
                        $result->bindValue(":email", strtoupper( $peopleModel->_get("email")));
                        $result->bindValue(":address", $peopleModel->_get("address"));
                        $result->bindValue(":city", $peopleModel->_get("city"));
                        $result->bindValue(":state", $peopleModel->_get("state"));
                        $result->bindValue(":zip_code", $peopleModel->_get("zip_code") );
                        $result->bindValue(":phone", $peopleModel->_get("phone"));
                        $result->bindValue(":date_birth", $peopleModel->_get("date_birth"));
                        $result->bindValue(":active", $peopleModel->_get("active") ? 1 : 0);
                        $result->bindValue(":id_user", $peopleModel->_get("id_user"));
                        $result->execute();

                        if($lastInsertId == 0){
                            $lastInsertId =  $pdo->lastInsertId();
                        }      
                        
                        if($peopleModel->_get("guardarUsuario")){                    

                            $query = '
                                INSERT INTO ad_people_user (id_people,image,username,password,activo,id_usuario) 
                                            VALUES (:id_people,"01.png",:usuario,:password,1,:id_usuario)
                            ';

                            $result = $pdo->prepare($query);
                            $result->bindValue(":id_people", $lastInsertId);
                            $result->bindValue(":username", strtoupper( $peopleModel->_get("txtUsuarioUsuario")));
                            $result->bindValue(":password", $this->encriptarTexto($peopleModel->_get("txtUsuarioClave")));
                            $result->bindValue(":id_user", $peopleModel->_get("id_user"));
                            $result->execute();                  

                        }

                        $pdo->commit();

                        $this->response["state"]= "ok";
                        $this->response["message"]= "Resultado de la función peopleCU()";
                        $this->response["query"]= $lastInsertId;
                    }
                }
            }else{

                $this->response["state"]= "ko";
                $this->response["message"]= "Type and identification number are already in the database.";
                $this->response["query"]= $result;
            }      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","PeopleService/peopleCU()");
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

    function peopleProfile(PeopleModel $peopleModel){

        $pdo = $this->conectarBd();
        
        try{          
            $query = '
                SELECT id,email,active FROM ad_people WHERE id <> :id AND email = :email ;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $peopleModel->_get("id"));
            $result->bindValue(":email", $peopleModel->_get("email"));
            $result->execute(); 

            if($result->rowCount() > 0){
                $this->response["state"]= "ko";
                $this->response["message"]= "Email is already in the database.";
                $this->response["query"]= $result;

            }else{

                $pdo->beginTransaction();

                $lastInsertId = $peopleModel->_get("id");

                $query = '
                    UPDATE ad_people SET 
                            email = :email,
                            address = :address,
                            city = :city,
                            state = :state,
                            zip_code = :zip_code,
                            phone = :phone,
                            date_birth = :date_birth, 
                            id_user = :id_user 
                    WHERE id = :id; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id", $peopleModel->_get("id"));
                $result->bindValue(":email", $peopleModel->_get("email"));
                $result->bindValue(":address", $peopleModel->_get("address"));
                $result->bindValue(":city", $peopleModel->_get("city"));
                $result->bindValue(":state", $peopleModel->_get("state"));
                $result->bindValue(":zip_code", $peopleModel->_get("zip_code") );
                $result->bindValue(":phone", $peopleModel->_get("phone"));
                $result->bindValue(":date_birth", $peopleModel->_get("date_birth"));
                $result->bindValue(":id_user", $peopleModel->_get("id_user"));
                $result->execute();

                $pdo->commit();

                $this->response["state"]= "ok";
                $this->response["message"]= "Resultado de la función peopleProfile()";
                $this->response["query"]= $lastInsertId;
            } 

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","PeopleService/peopleProfile()");
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

    function tercerosActivosBusqueda($busqueda){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                t.id,
                t.id_tipo_identificacion,
                i.descripcion tipo_identificacion,
                i.abreviatura tipo_identificacion_ab,
                t.numero_identificacion,
                t.nombres,
                CONCAT(i.abreviatura," - ",t.numero_identificacion," - ",t.nombres) tercero,
                t.correo,
                t.direccion,
                t.telefono,
                t.fecha_nacimiento,
                t.id_genero,
                g.descripcion genero,
                t.id_estado_civil,
                e.descripcion estado_civil,
                t.activo
                FROM gen_terceros t
                JOIN gen_m_tipos_identificacion i ON i.id = t.id_tipo_identificacion
                LEFT JOIN gen_m_generos g ON g.id = t.id_genero
                LEFT JOIN gen_m_estados_civil e ON e.id = t.id_estado_civil
                WHERE CONCAT(t.numero_identificacion,t.nombres) like "%'.$busqueda.'%" AND t.activo = 1
                ORDER BY t.nombres
                LIMIT 10;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función tercerosActivosBusqueda()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("metodo","ThirdPartiesService/tercerosActivosBusqueda()");
            $logModel->_set("consulta",$query);
            $logModel->_set("codigo",$e->getCode());
            $logModel->_set("error",$e->getMessage());

            $logModel->_set("id",$this->guardarLogErrores($logModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$logModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    } 

    function tercerosPerfil(ThirdPartiesModel $thirdPartiesModel){

        $pdo = $this->conectarBd();
        
        try{          
            $query = '
                SELECT id,correo,activo FROM gen_terceros WHERE id <> :id AND correo = :correo ;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $thirdPartiesModel->_get("id"));
            $result->bindValue(":correo", $thirdPartiesModel->_get("correo"));
            $result->execute(); 

            if($result->rowCount() > 0){
                $this->response["estado"]= "ko";
                $this->response["mensaje"]= "El correo ya esta en la base de datos.";
                $this->response["query"]= $result;

            }else{

                $pdo->beginTransaction();

                $lastInsertId = $thirdPartiesModel->_get("id");

                $query = '
                    UPDATE gen_terceros SET 
                            correo = :correo,
                            direccion = :direccion,
                            telefono = :telefono,
                            fecha_nacimiento = :fecha_nacimiento,
                            id_genero = :id_genero,
                            id_estado_civil = :id_estado_civil,
                            id_usuario = :id_usuario 
                    WHERE id = :id; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id", $thirdPartiesModel->_get("id"));
                $result->bindValue(":correo", strtoupper( $thirdPartiesModel->_get("correo")));
                $result->bindValue(":direccion", $thirdPartiesModel->_get("direccion"));
                $result->bindValue(":telefono", $thirdPartiesModel->_get("telefono"));
                $result->bindValue(":fecha_nacimiento", $thirdPartiesModel->_get("fecha_nacimiento"));
                $result->bindValue(":id_genero", $thirdPartiesModel->_get("id_genero") );
                $result->bindValue(":id_estado_civil", $thirdPartiesModel->_get("id_estado_civil"));
                $result->bindValue(":id_usuario", $thirdPartiesModel->_get("id_usuario"));
                $result->execute();

                $pdo->commit();

                $this->response["estado"]= "ok";
                $this->response["mensaje"]= "Resultado de la función tercerosPerfil()";
                $this->response["query"]= $lastInsertId;
            } 

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("metodo","ThirdPartiesService/tercerosPerfil()");
            $logModel->_set("consulta",$query);
            $logModel->_set("codigo",$e->getCode());
            $logModel->_set("error",$e->getMessage());

            $logModel->_set("id",$this->guardarLogErrores($logModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$logModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
    }

}
?>