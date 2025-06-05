<?php

include_once './_configurations/ConexionService.php';
include_once './_configurations/LogModel.php';
include_once 'UserModel.php';

class UserService extends ConexionService{

    private $response = array(
        "state" => 0,
        "message" => 0,
        "query" => []
    );       

    function userxId($id){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                u.id_people,
                t.id_type_identification,
                i.`name` type_identification,
                t.number,
                t.`name` people,
                t.email,
                t.address,
                t.city,
                t.state,
                t.zip_code,
                t.phone,
                t.date_birth,
                u.image,
                u.username,
                u.active,
                u.sidebar_color,
                u.theme_color
                FROM ad_people_user u
                JOIN ad_people t ON t.id = u.id_people
                JOIN ad_m_type_identification i ON i.id = t.id_type_identification
                WHERE u.id = :id;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $id);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función userxId()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UserService/userxId()");
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

    function usuariosValidarLogin($usuario,$clave){

        $pdo = $this->conectarBd();

        try{
            $query = '
                SELECT  
                u.id,
                u.id_tercero,
                t.nombres tercero,
                u.usuario,  
                u.imagen,              
                u.clave,
                u.token,
                u.activo
                FROM gen_terceros_usuarios u
                JOIN gen_terceros t ON t.id = u.id_tercero
                WHERE u.usuario = :usuario AND u.clave = :clave;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":usuario", $usuario);
            $result->bindValue(":clave", $this->encriptarTexto($clave));
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosValidarLogin()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosValidarLogin()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }

    function userUpdateToken(UserModel $userModel){
        
        $pdo = $this->conectarBd();

        try{           


            $query = '
                SELECT  
                u.id,
                u.id_people,
                t.`name` people,
                u.username,             
                u.`password`,
                u.token,
                u.active
                FROM ad_people_user u
                JOIN ad_people t ON t.id = u.id_people
                WHERE u.username = :username AND u.`password` = :password AND u.active = 1;
            ';

            $result = $pdo->prepare($query);            
            $result->bindValue(":username", $userModel->_get("username"));
            $result->bindValue(":password", $userModel->_get("password"));
            $result->execute(); 

            if($result->rowCount() > 0){ 

                $query = '
                    UPDATE ad_people_user SET token = :token, token_date = now() WHERE id = :id; 
                ';                 
                

                $result = $pdo->prepare($query);
                $result->bindValue(":id",  $userModel->_get("id"));
                $result->bindValue(":token",  strtoupper($userModel->_get("token")));
                $result->execute();

                $this->response["state"]= "ok";
                $this->response["message"]= "Resultado de la función userUpdateToken()";
                $this->response["query"]= $result;    
                
            }else{

                $this->response["state"]= "ko";
                $this->response["message"]= "User '". strtoupper($userModel->_get("username")) ."' can't perform this operation.";
                $this->response["query"]= $result;
            }   

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UserService/userUpdateToken()");
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

    function userInsertLog(UserModel $userModel){

        $pdo = $this->conectarBd();
        
        try{
            $query = '
                INSERT INTO ad_people_user_session (id_user,date,ip,token) VALUES (:id_user,now(),:ip,:token)
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_user",  $userModel->_get("id"));            
            $result->bindValue(":ip", $this->obtenerIp());
            $result->bindValue(":token",  $userModel->_get("token"));
            $result->execute();

            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función userInsertLog()";
            $this->response["query"]= $result;

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UserService/userInsertLog()");
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
    
    function userValidateToken($token){

        $pdo = $this->conectarBd();

        try{
            $query = '
                SELECT  
                u.id,
                u.token,
                u.active
                FROM ad_people_user u
                WHERE u.token = :token AND u.active = 1;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":token", $token);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función userValidateToken()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UserService/userValidateToken()");
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

    function userResetPassword($email, $passw){

        $pdo = $this->conectarBd();
        
        try{             

            $query = ' 
            SELECT t.id,t.`name`,t.email,u.id id_user, u.username FROM ad_people t 
                            JOIN ad_people_user u ON u.id_people = t.id WHERE t.email = :email AND u.active = 1; ';

            $resultTercero = $pdo->prepare($query);
            $resultTercero->bindValue(":email", $email);
            $resultTercero->execute();              
            

            if($resultTercero->rowCount() > 0){  
                
                $fila = $resultTercero->fetch();                

                $query = '
                    UPDATE ad_people_user SET `password` = :password  WHERE id = :id_user;
                ';

                $result = $pdo->prepare($query); 
                $result->bindValue(":id_user", $fila["id_user"]);
                $result->bindValue(":password", $this->encriptarTexto($passw));                
                $result->execute();

                $this->response["estado"]= "ok";
                $this->response["mensaje"]= "Resultado de la función userResetPassword()";
                $this->response["query"]= $fila;

            }else{

                $this->response["estado"]= "ko";
                $this->response["mensaje"]= "Email <". $email ."> is not registered or is not active.";
                $this->response["query"]= [];

            }      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UserService/userResetPassword()");
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

    function usuarios(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                u.id_tercero,
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
                es.descripcion estado_civil,
                e.id_cargo,
                c.descripcion cargo,
                u.imagen,
                u.usuario,
                u.activo
                FROM gen_terceros_usuarios u
                JOIN gen_terceros t ON t.id = u.id_tercero
                LEFT JOIN gen_terceros_empleados e ON e.id_tercero = t.id
                LEFT JOIN gen_m_cargos c ON c.id = e.id_cargo
                JOIN gen_m_tipos_identificacion i ON i.id = t.id_tipo_identificacion
                LEFT JOIN gen_m_generos g ON g.id = t.id_genero
                LEFT JOIN gen_m_estados_civil es ON es.id = t.id_estado_civil
                ORDER BY t.nombres;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuarios()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("metodo","UserService/usuarios()");
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

    function usuariosActivos(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                u.id_tercero,
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
                es.descripcion estado_civil,
                e.id_cargo,
                c.descripcion cargo,
                u.imagen,
                u.usuario,
                u.activo
                FROM gen_terceros_usuarios u
                JOIN gen_terceros t ON t.id = u.id_tercero
                LEFT JOIN gen_terceros_empleados e ON e.id_tercero = t.id
                LEFT JOIN gen_m_cargos c ON c.id = e.id_cargo
                JOIN gen_m_tipos_identificacion i ON i.id = t.id_tipo_identificacion
                LEFT JOIN gen_m_generos g ON g.id = t.id_genero
                LEFT JOIN gen_m_estados_civil es ON es.id = t.id_estado_civil
                WHERE u.activo = 1
                ORDER BY t.nombres;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuarios()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("metodo","UserService/usuarios()");
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

    function usuariosCU(UserModel $userModel){

        $pdo = $this->conectarBd();
        
        try{

            $query = '
                SELECT id,id_tercero,activo FROM gen_terceros_usuarios
                WHERE id <> :id AND (id_tercero = :id_tercero OR usuario = :usuario);
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $userModel->_get("id"));
            $result->bindValue(":id_tercero", $userModel->_get("id_tercero"));
            $result->bindValue(":usuario", $userModel->_get("usuario"));
            $result->execute(); 

            if($result->rowCount()== 0){

                $pdo->beginTransaction();

                $lastInsertId = $userModel->_get("id");
                
                if($userModel->_get("id") > 0){

                    if ($userModel->_get("clave") != "") {

                        $query = '
                            UPDATE gen_terceros_usuarios SET 
                                    id_tercero = :id_tercero, 
                                    usuario = :usuario,
                                    clave = :clave,
                                    activo = :activo, 
                                    id_usuario = :id_usuario 
                            WHERE id = :id; 
                        ';
                    }else{
                        $query = '
                            UPDATE gen_terceros_usuarios SET 
                                    id_tercero = :id_tercero, 
                                    usuario = :usuario,
                                    activo = :activo, 
                                    id_usuario = :id_usuario 
                            WHERE id = :id; 
                        ';
                    }

                    $result = $pdo->prepare($query);
                    $result->bindValue(":id", $userModel->_get("id"));

                }else{

                    $query = '
                        INSERT INTO gen_terceros_usuarios (id_tercero,imagen,usuario,clave,activo,id_usuario) 
                                    VALUES (:id_tercero,"01.png",:usuario,:clave,:activo,:id_usuario)
                    ';

                    $result = $pdo->prepare($query);
                }
                
                $result->bindValue(":id_tercero", $userModel->_get("id_tercero"));
                $result->bindValue(":usuario", strtoupper( $userModel->_get("usuario")));   
                if ($userModel->_get("clave") != "") {
                    $result->bindValue(":clave", $this->encriptarTexto($userModel->_get("clave")));
                }               
                $result->bindValue(":activo", $userModel->_get("activo") ? 1 : 0);
                $result->bindValue(":id_usuario", $userModel->_get("id_usuario"));
                $result->execute();

                if($lastInsertId == 0){
                    $lastInsertId =  $pdo->lastInsertId();
                }                     

                $pdo->commit();

                $this->response["estado"]= "ok";
                $this->response["mensaje"]= "Resultado de la función usuariosCU()";
                $this->response["query"]= $lastInsertId;
            }else{

                $this->response["estado"]= "ko";
                $this->response["mensaje"]= "El tercero seleccionado o el nombre de usuario ya esta en la base de datos como usuario.";
                $this->response["query"]= $result;
            }      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("metodo","UserService/usuariosCU()");
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

    function userUpdateAvatar(UserModel $userModel){

        $pdo = $this->conectarBd();
        
        try{

            $query = '
                SELECT id,id_people,active FROM ad_people_user  WHERE id = :id ;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $userModel->_get("id"));
            $result->execute(); 

            if($result->rowCount() > 0){

                $pdo->beginTransaction();

                $query = '
                    UPDATE ad_people_user SET image = :image, id_user =:id_user  WHERE id = :id; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id", $userModel->_get("id"));
                $result->bindValue(":image", $userModel->_get("image"));
                $result->bindValue(":id_user", $userModel->_get("id_user"));
                $result->execute();                    

                $pdo->commit();

                $this->response["state"]= "ok";
                $this->response["message"]= "Resultado de la función userUpdateImage()";
                $this->response["query"]= $result;
            }else{

                $this->response["state"]= "ko";
                $this->response["message"]= "ID : ".$userModel->_get("id")." does not exist";
                $this->response["query"]= $result;
            }      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UserService/userUpdateImage()");
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

    function userUpdateSidebarColor(UserModel $userModel){

        $pdo = $this->conectarBd();
        
        try{

            $query = '
                SELECT id,id_people,active FROM ad_people_user  WHERE id = :id ;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $userModel->_get("id"));
            $result->execute(); 

            if($result->rowCount() > 0){

                $pdo->beginTransaction();

                $query = '
                    UPDATE ad_people_user SET sidebar_color = :sidebar_color, id_user = :id_user WHERE id = :id; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id", $userModel->_get("id"));
                $result->bindValue(":id_user", $userModel->_get("id"));
                $result->bindValue(":sidebar_color", $userModel->_get("sidebar_color"));
                $result->execute();                    

                $pdo->commit();

                $this->response["state"]= "ok";
                $this->response["message"]= "Resultado de la función userUpdateSidebarColor()";
                $this->response["query"]= $result;
            }else{

                $this->response["state"]= "ko";
                $this->response["message"]= "ID : ".$userModel->_get("id")." does not exist";
                $this->response["query"]= $result;
            }      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UserService/userUpdateSidebarColor()");
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

    function userUpdateThemeColor(UserModel $userModel){

        $pdo = $this->conectarBd();
        
        try{

            $query = '
                SELECT id,id_people,active FROM ad_people_user  WHERE id = :id ;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $userModel->_get("id"));
            $result->execute(); 

            if($result->rowCount() > 0){

                $pdo->beginTransaction();

                $query = '
                    UPDATE ad_people_user SET theme_color = :theme_color, id_user = :id_user WHERE id = :id; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id", $userModel->_get("id"));
                $result->bindValue(":id_user", $userModel->_get("id"));
                $result->bindValue(":theme_color", $userModel->_get("theme_color"));
                $result->execute();                    

                $pdo->commit();

                $this->response["state"]= "ok";
                $this->response["message"]= "Resultado de la función userUpdateThemeColor()";
                $this->response["query"]= $result;
            }else{

                $this->response["state"]= "ko";
                $this->response["message"]= "ID : ".$userModel->_get("id")." does not exist";
                $this->response["query"]= $result;
            }      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UserService/userUpdateThemeColor()");
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

    function userUpdatePassword($id_user, $password_current, $password_new){

        $pdo = $this->conectarBd();
        
        try{

            $query = '
                SELECT id,id_people,active FROM ad_people_user  WHERE id = :id AND `password` = :password;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $id_user);
            $result->bindValue(":password", $this->encriptarTexto($password_current));
            $result->execute(); 

            if($result->rowCount() > 0){

                $pdo->beginTransaction();

                $query = '
                    UPDATE ad_people_user SET `password` = :password, token = null, 
                                                token_date = null, id_user =:id_user WHERE id = :id; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id", $id_user);
                $result->bindValue(":password", $this->encriptarTexto($password_new));
                $result->bindValue(":id_user", $id_user);
                $result->execute();                    

                $pdo->commit();

                $this->response["state"]= "ok";
                $this->response["message"]= "Resultado de la función userUpdatePassword()";
                $this->response["query"]= $result;

            }else{

                $this->response["state"]= "ko";
                $this->response["message"]= "The current password does not match the one registered in the system";
                $this->response["query"]= $result;
            }      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","UserService/userUpdatePassword()");
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

    function usuariosAsignacionxIdRol($id_rol){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                IF(ur.id_rol is null,false,true) seleccion,
                u.id,
                u.id_tercero,
                t.id_tipo_identificacion,
                i.descripcion tipo_identificacion,
                t.numero_identificacion,
                t.nombres,
                t.correo,
                u.usuario,
                u.activo
                FROM gen_terceros_usuarios u
                JOIN gen_terceros t ON t.id = u.id_tercero
                JOIN gen_m_tipos_identificacion i ON i.id = t.id_tipo_identificacion
                LEFT JOIN gen_terceros_usuarios_roles ur ON ur.id_usuario = u.id AND ur.id_rol = :id_rol
                ORDER BY t.nombres;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_rol", $id_rol);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacioxIdRol()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacioxIdRol()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    } 

    function usuariosAsignacionxRol($id_rol, $usuarios, $id_usuario){

        $pdo = $this->conectarBd();
        
        try{
                $pdo->beginTransaction();


                $query = '
                    DELETE FROM gen_terceros_usuarios_roles WHERE id_rol = :id_rol; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id_rol", $id_rol);
                $result->execute();   
                
                $query = '
                    INSERT INTO gen_terceros_usuarios_roles (id_rol,id_usuario,id_usuario_c) VALUES (?, ?, ?); 
                ';

                $result3 = $pdo->prepare( $query);

                foreach ($usuarios as $usuario) {
                    if($usuario["seleccion"] == 1){
                        $result3->execute(array($id_rol, $usuario["id"], $id_usuario));
                    }                    
                }   
                $pdo->commit();

                $this->response["estado"]= "ok";
                $this->response["mensaje"]= "Resultado de la función usuariosAsignacionxRol()";
                $this->response["query"]= $result;      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("metodo","UserService/usuariosAsignacionxRol()");
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

    function usuariosAsignacionRoles(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                ur.id_rol,
                rl.descripcion rol,
                u.id,
                u.id_tercero,
                t.id_tipo_identificacion,
                i.descripcion tipo_identificacion,
                t.numero_identificacion,
                t.nombres,
                t.correo,
                u.usuario,
                u.activo
                FROM gen_terceros_usuarios u
                JOIN gen_terceros t ON t.id = u.id_tercero
                JOIN gen_m_tipos_identificacion i ON i.id = t.id_tipo_identificacion
                JOIN gen_terceros_usuarios_roles ur ON ur.id_usuario = u.id 
                JOIN gen_roles rl ON rl.id = ur.id_rol
                ORDER BY u.usuario;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacionRoles()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacionRoles()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }

    function usuariosAsignacionxIdProceso($id_proceso){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                IF(ur.id_union_agencia_proceso is null,false,true) seleccion,
                u.id,
                u.id_tercero,
                t.id_tipo_identificacion,
                i.descripcion tipo_identificacion,
                t.numero_identificacion,
                t.nombres,
                t.correo,
                u.usuario,
                u.activo
                FROM gen_terceros_usuarios u
                JOIN gen_terceros t ON t.id = u.id_tercero
                JOIN gen_m_tipos_identificacion i ON i.id = t.id_tipo_identificacion
                LEFT JOIN gen_terceros_usuarios_procesos ur ON ur.id_usuario = u.id AND ur.id_union_agencia_proceso = :id_proceso
                ORDER BY t.nombres;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_proceso", $id_proceso);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacionxIdProceso()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacionxIdProceso()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    } 

    function usuariosAsignacionxProceso($id_proceso, $usuarios,$id_usuario){

        $pdo = $this->conectarBd();
        
        try{
                $pdo->beginTransaction();


                $query = '
                    DELETE FROM gen_terceros_usuarios_procesos WHERE id_union_agencia_proceso = :id_proceso; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id_proceso", $id_proceso);
                $result->execute();   
                
                $query = '
                    INSERT INTO gen_terceros_usuarios_procesos (id_union_agencia_proceso,id_usuario,id_usuario_c) VALUES (?, ?, ?); 
                ';

                $result3 = $pdo->prepare( $query);

                foreach ($usuarios as $usuario) {
                    if($usuario["seleccion"] == 1){
                        $result3->execute(array($id_proceso, $usuario["id"],$id_usuario));
                    }                    
                }   
                $pdo->commit();

                $this->response["estado"]= "ok";
                $this->response["mensaje"]= "Resultado de la función usuariosAsignacionxProceso()";
                $this->response["query"]= $result;      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("metodo","UserService/usuariosAsignacionxProceso()");
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

    function usuariosAsignacionProcesos(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                uap.id_proceso,
                fp.descripcion proceso,
                ua.id_agencia,
                oa.descripcion agencia,
                ua.id_sucursal,
                os.descripcion sucursal,
                ua.id_empresa,
                oe.nit,
                oe.nombre empresa,
                u.id,
                u.id_tercero,
                t.id_tipo_identificacion,
                i.descripcion tipo_identificacion,
                t.numero_identificacion,
                t.nombres,
                t.correo,
                u.usuario,
                u.activo
                FROM gen_terceros_usuarios u
                JOIN gen_terceros t ON t.id = u.id_tercero
                JOIN gen_m_tipos_identificacion i ON i.id = t.id_tipo_identificacion
                JOIN gen_terceros_usuarios_procesos ur ON ur.id_usuario = u.id 
                JOIN gen_o_union_agencias_procesos uap ON uap.id = ur.id_union_agencia_proceso
                JOIN gen_o_union_agencias ua ON ua.id = uap.id_union_agencia
                JOIN gen_o_agencias oa ON oa.id = ua.id_agencia
                JOIN gen_o_sucursales os ON os.id = ua.id_sucursal
                JOIN gen_o_empresas oe ON oe.id = ua.id_empresa
                JOIN gen_m_factura_procesos fp ON fp.id = uap.id_proceso
                ORDER BY u.usuario;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacionProcesos()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacionProcesos()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }

    function usuariosAsignacionxIdAgencia($id_agencia){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                IF(ur.id_union_agencia is null,false,true) seleccion,
                u.id,
                u.id_tercero,
                t.id_tipo_identificacion,
                i.descripcion tipo_identificacion,
                t.numero_identificacion,
                t.nombres,
                t.correo,
                u.usuario,
                u.activo
                FROM gen_terceros_usuarios u
                JOIN gen_terceros t ON t.id = u.id_tercero
                JOIN gen_m_tipos_identificacion i ON i.id = t.id_tipo_identificacion
                LEFT JOIN gen_terceros_usuarios_agencias ur ON ur.id_usuario = u.id AND ur.id_union_agencia = :id_agencia
                ORDER BY t.nombres;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_agencia", $id_agencia);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacionxIdAgencia()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacionxIdAgencia()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    } 

    function usuariosAsignacionxAgencia($id_agencia, $usuarios,$id_usuario){

        $pdo = $this->conectarBd();
        
        try{
                $pdo->beginTransaction();


                $query = '
                    DELETE FROM gen_terceros_usuarios_agencias WHERE id_union_agencia = :id_agencia; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id_agencia", $id_agencia);
                $result->execute();   
                
                $query = '
                    INSERT INTO gen_terceros_usuarios_agencias (id_union_agencia,id_usuario,id_usuario_c) VALUES (?, ?, ?); 
                ';

                $result3 = $pdo->prepare( $query);

                foreach ($usuarios as $usuario) {
                    if($usuario["seleccion"] == 1){
                        $result3->execute(array($id_agencia, $usuario["id"],$id_usuario));
                    }                    
                }   
                $pdo->commit();

                $this->response["estado"]= "ok";
                $this->response["mensaje"]= "Resultado de la función usuariosAsignacionxAgencia()";
                $this->response["query"]= $result;      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("metodo","UserService/usuariosAsignacionxAgencia()");
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

    function usuariosAsignacionAgencias(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                ua.id_agencia,
                oa.descripcion agencia,
                ua.id_sucursal,
                os.descripcion sucursal,
                ua.id_empresa,
                oe.nit,
                oe.nombre empresa,
                u.id,
                u.id_tercero,
                t.id_tipo_identificacion,
                i.descripcion tipo_identificacion,
                t.numero_identificacion,
                t.nombres,
                t.correo,
                u.usuario,
                u.activo
                FROM gen_terceros_usuarios u
                JOIN gen_terceros t ON t.id = u.id_tercero
                JOIN gen_m_tipos_identificacion i ON i.id = t.id_tipo_identificacion
                JOIN gen_terceros_usuarios_agencias ur ON ur.id_usuario = u.id 
                JOIN gen_o_union_agencias ua ON ua.id = ur.id_union_agencia
                JOIN gen_o_agencias oa ON oa.id = ua.id_agencia
                JOIN gen_o_sucursales os ON os.id = ua.id_sucursal
                JOIN gen_o_empresas oe ON oe.id = ua.id_empresa
                ORDER BY u.usuario;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacionAgencias()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacionAgencias()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }

    function usuariosAsignacionAgenciasActivosxIdUsuario($id_usuario){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                u.id_empresa,
                e.nit,
                e.nombre empresa,
                u.id_sucursal,
                s.descripcion sucursal,
                u.id_agencia,
                a.descripcion agencia,
                u.activo
                FROM gen_o_union_agencias u
                JOIN gen_o_empresas e ON e.id = u.id_empresa
                JOIN gen_o_sucursales s ON s.id = u.id_sucursal
                JOIN gen_o_agencias a ON a.id = u.id_agencia
                JOIN gen_terceros_usuarios_agencias ua ON ua.id_union_agencia = u.id
                WHERE u.activo = 1 AND ua.id_usuario = :id_usuario
                ORDER BY a.descripcion;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_usuario", $id_usuario);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacionAgenciasActivosxIdUsuario()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacionAgenciasActivosxIdUsuario()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }

    function usuariosAsignacionAgenciasGeneral(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                u.id_empresa,
                e.nit,
                e.nombre empresa,
                u.id_sucursal,
                s.descripcion sucursal,
                u.id_agencia,
                a.descripcion agencia,
                u.activo
                FROM gen_o_union_agencias u
                JOIN gen_o_empresas e ON e.id = u.id_empresa
                JOIN gen_o_sucursales s ON s.id = u.id_sucursal
                JOIN gen_o_agencias a ON a.id = u.id_agencia
                ORDER BY a.descripcion;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacionAgenciasGeneral()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacionAgenciasGeneral()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }

    function usuariosAsignacionProcesosActivosxIdUsuarioxIdAgencia($id_usuario,$id_agencia){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                u.id_union_agencia,
                ua.id_empresa,
                e.nit,
                e.nombre empresa,
                ua.id_sucursal,
                s.descripcion sucursal,
                ua.id_agencia,
                a.descripcion agencia,
                u.id_proceso,
                p.descripcion proceso,
                u.activo
                FROM gen_o_union_agencias_procesos u
                JOIN gen_o_union_agencias ua ON	ua.id = u.id_union_agencia
                JOIN gen_o_empresas e ON e.id = ua.id_empresa
                JOIN gen_o_sucursales s ON s.id = ua.id_sucursal
                JOIN gen_o_agencias a ON a.id = ua.id_agencia
                JOIN gen_m_factura_procesos p ON p.id = u.id_proceso
                JOIN gen_terceros_usuarios_procesos up ON up.id_union_agencia_proceso = u.id
                WHERE u.activo = 1 AND up.id_usuario = :id_usuario AND u.id_union_agencia = :id_agencia
                ORDER BY p.descripcion;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_usuario", $id_usuario);
            $result->bindValue(":id_agencia", $id_agencia);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacionProcesosActivosxIdUsuarioxIdAgencia()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacionProcesosActivosxIdUsuarioxIdAgencia()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }

    function usuariosAsignacionProcesosGeneralxIdAgencia($id_agencia){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                u.id_union_agencia,
                ua.id_empresa,
                e.nit,
                e.nombre empresa,
                ua.id_sucursal,
                s.descripcion sucursal,
                ua.id_agencia,
                a.descripcion agencia,
                u.id_proceso,
                p.descripcion proceso,
                u.activo
                FROM gen_o_union_agencias_procesos u
                JOIN gen_o_union_agencias ua ON	ua.id = u.id_union_agencia
                JOIN gen_o_empresas e ON e.id = ua.id_empresa
                JOIN gen_o_sucursales s ON s.id = ua.id_sucursal
                JOIN gen_o_agencias a ON a.id = ua.id_agencia
                JOIN gen_m_factura_procesos p ON p.id = u.id_proceso
                WHERE u.id_union_agencia = :id_agencia
                ORDER BY p.descripcion;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_agencia", $id_agencia);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacionProcesosGeneralxIdAgencia()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacionProcesosGeneralxIdAgencia()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }

    function usuariosAsignacionProcesosActivosxIdAgencia($id_agencia){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                u.id_union_agencia,
                ua.id_empresa,
                e.nit,
                e.nombre empresa,
                ua.id_sucursal,
                s.descripcion sucursal,
                ua.id_agencia,
                a.descripcion agencia,
                u.id_proceso,
                p.descripcion proceso,
                u.activo
                FROM gen_o_union_agencias_procesos u
                JOIN gen_o_union_agencias ua ON	ua.id = u.id_union_agencia
                JOIN gen_o_empresas e ON e.id = ua.id_empresa
                JOIN gen_o_sucursales s ON s.id = ua.id_sucursal
                JOIN gen_o_agencias a ON a.id = ua.id_agencia
                JOIN gen_m_factura_procesos p ON p.id = u.id_proceso
                WHERE u.activo = 1 AND u.id_union_agencia = :id_agencia
                ORDER BY p.descripcion;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_agencia", $id_agencia);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacionProcesosActivosxIdAgencia()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacionProcesosActivosxIdAgencia()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }

    function usuariosAsignacionxIdBodega($id_bodega){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                IF(ur.id_union_agencia_bodega is null,false,true) seleccion,
                u.id,
                u.id_tercero,
                t.id_tipo_identificacion,
                i.descripcion tipo_identificacion,
                t.numero_identificacion,
                t.nombres,
                t.correo,
                u.usuario,
                u.activo
                FROM gen_terceros_usuarios u
                JOIN gen_terceros t ON t.id = u.id_tercero
                JOIN gen_m_tipos_identificacion i ON i.id = t.id_tipo_identificacion
                LEFT JOIN gen_terceros_usuarios_bodegas ur ON ur.id_usuario = u.id AND ur.id_union_agencia_bodega = :id_bodega
                ORDER BY t.nombres;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_bodega", $id_bodega);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacionxIdBodega()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacionxIdBodega()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    } 

    function usuariosAsignacionxBodega($id_bodega, $usuarios,$id_usuario){

        $pdo = $this->conectarBd();
        
        try{
                $pdo->beginTransaction();


                $query = '
                    DELETE FROM gen_terceros_usuarios_bodegas WHERE id_union_agencia_bodega = :id_bodega; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id_bodega", $id_bodega);
                $result->execute();   
                
                $query = '
                    INSERT INTO gen_terceros_usuarios_bodegas (id_union_agencia_bodega,id_usuario,id_usuario_c) VALUES (?, ?, ?); 
                ';

                $result3 = $pdo->prepare( $query);

                foreach ($usuarios as $usuario) {
                    if($usuario["seleccion"] == 1){
                        $result3->execute(array($id_bodega, $usuario["id"],$id_usuario));
                    }                    
                }   
                $pdo->commit();

                $this->response["estado"]= "ok";
                $this->response["mensaje"]= "Resultado de la función usuariosAsignacionxBodega()";
                $this->response["query"]= $result;      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("metodo","UserService/usuariosAsignacionxBodega()");
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

    function usuariosAsignacionBodegas(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                u.id_union_agencia,
                ua.id_empresa,
                e.nit,
                e.nombre empresa,
                ua.id_sucursal,
                s.descripcion sucursal,
                ua.id_agencia,
                a.descripcion agencia,
                u.id_almacen,
                al.descripcion almacen,
                u.id_bodega,
                bo.descripcion bodega,
                u.activo
                FROM gen_m_inventario_union_agencias_bodegas u
                JOIN gen_o_union_agencias ua ON	ua.id = u.id_union_agencia
                JOIN gen_o_empresas e ON e.id = ua.id_empresa
                JOIN gen_o_sucursales s ON s.id = ua.id_sucursal
                JOIN gen_o_agencias a ON a.id = ua.id_agencia
                JOIN gen_m_inventario_almacenes al ON al.id = u.id_almacen
                JOIN gen_m_inventario_bodegas bo ON bo.id = u.id_bodega
                ORDER BY bo.descripcion;;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacionProcesos()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacionProcesos()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }

    function usuariosAsignacionBodegasActivosxIdUsuarioxIdAgencia($id_usuario,$id_agencia){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                u.id_union_agencia,
                ua.id_empresa,
                e.nit,
                e.nombre empresa,
                ua.id_sucursal,
                s.descripcion sucursal,
                ua.id_agencia,
                a.descripcion agencia,
                u.id_almacen,
                al.descripcion almacen,
                u.id_bodega,
                bo.descripcion bodega,
                u.activo
                FROM gen_m_inventario_union_agencias_bodegas u
                JOIN gen_o_union_agencias ua ON	ua.id = u.id_union_agencia
                JOIN gen_o_empresas e ON e.id = ua.id_empresa
                JOIN gen_o_sucursales s ON s.id = ua.id_sucursal
                JOIN gen_o_agencias a ON a.id = ua.id_agencia
                JOIN gen_m_inventario_almacenes al ON al.id = u.id_almacen
                JOIN gen_m_inventario_bodegas bo ON bo.id = u.id_bodega
                JOIN gen_terceros_usuarios_bodegas up ON up.id_union_agencia_bodega = u.id
                WHERE u.activo = 1 AND up.id_usuario = :id_usuario AND u.id_union_agencia = :id_agencia
                ORDER BY bo.descripcion;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_usuario", $id_usuario);
            $result->bindValue(":id_agencia", $id_agencia);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacionBodegasActivosxIdUsuarioxIdAgencia()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacionBodegasActivosxIdUsuarioxIdAgencia()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }

    function usuariosAsignacionBodegasGeneralxIdAgencia($id_agencia){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                u.id_union_agencia,
                ua.id_empresa,
                e.nit,
                e.nombre empresa,
                ua.id_sucursal,
                s.descripcion sucursal,
                ua.id_agencia,
                a.descripcion agencia,
                u.id_almacen,
                al.descripcion almacen,
                u.id_bodega,
                bo.descripcion bodega,
                u.activo
                FROM gen_m_inventario_union_agencias_bodegas u
                JOIN gen_o_union_agencias ua ON	ua.id = u.id_union_agencia
                JOIN gen_o_empresas e ON e.id = ua.id_empresa
                JOIN gen_o_sucursales s ON s.id = ua.id_sucursal
                JOIN gen_o_agencias a ON a.id = ua.id_agencia
                JOIN gen_m_inventario_almacenes al ON al.id = u.id_almacen
                JOIN gen_m_inventario_bodegas bo ON bo.id = u.id_bodega
                WHERE u.id_union_agencia = :id_agencia
                ORDER BY bo.descripcion;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_agencia", $id_agencia);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacionProcesosGeneralxIdAgencia()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacionProcesosGeneralxIdAgencia()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }

    function usuariosAsignacionBodegasActivosxIdUsuario($id_usuario){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                u.id,
                u.id_union_agencia,
                ua.id_empresa,
                e.nit,
                e.nombre empresa,
                ua.id_sucursal,
                s.descripcion sucursal,
                ua.id_agencia,
                a.descripcion agencia,
                u.id_almacen,
                al.descripcion almacen,
                u.id_bodega,
                bo.descripcion bodega,
                u.activo
                FROM gen_m_inventario_union_agencias_bodegas u
                JOIN gen_o_union_agencias ua ON	ua.id = u.id_union_agencia
                JOIN gen_o_empresas e ON e.id = ua.id_empresa
                JOIN gen_o_sucursales s ON s.id = ua.id_sucursal
                JOIN gen_o_agencias a ON a.id = ua.id_agencia
                JOIN gen_m_inventario_almacenes al ON al.id = u.id_almacen
                JOIN gen_m_inventario_bodegas bo ON bo.id = u.id_bodega
                JOIN gen_terceros_usuarios_bodegas up ON up.id_union_agencia_bodega = u.id
                WHERE u.activo = 1 AND up.id_usuario = :id_usuario
                ORDER BY bo.descripcion;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_usuario", $id_usuario);
            $result->execute(); 
            
            $this->response["estado"]= "ok";
            $this->response["mensaje"]= "Resultado de la función usuariosAsignacionBodegasActivosxIdUsuario()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $LogModel = new LogModel();

            $LogModel->_set("metodo","UserService/usuariosAsignacionBodegasActivosxIdUsuario()");
            $LogModel->_set("consulta",$query);
            $LogModel->_set("codigo",$e->getCode());
            $LogModel->_set("error",$e->getMessage());

            $LogModel->_set("id",$this->guardarLogErrores($LogModel));

           $this->response["estado"]= "ko";
           $this->response["mensaje"]= "Error al ejecutar la sentencia. Codigo: ".$LogModel->_get("id");
           $this->response["query"]= [];
        } 

        $pdo = $this->desconectarBd();

        return $this->response;
          
    }

}
?>