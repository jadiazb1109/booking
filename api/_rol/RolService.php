<?php

include_once './_configurations/ConexionService.php';
include_once './_configurations/LogModel.php';
include_once 'RolModel.php';

class RolService extends ConexionService{

    private $response = array(
        "state" => 0,
        "message" => 0,
        "query" => 0
    );    

    function roles(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                id,
                `name`,
                active
                FROM ad_roles
                ORDER BY `name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función roles()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","RolService/roles()");
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

    function rolesActive(){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                id,
                `name`,
                active
                FROM ad_roles
                WHERE active = 1
                ORDER BY `name`;
            ';

            $result = $pdo->prepare($query);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función rolesActive()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","RolService/rolesActive()");
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

    function rolesxId($id){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                id,
                `name`,
                active
                FROM ad_roles 
                WHERE id = :id;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $id);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función rolesxId()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","RolService/rolesxId()");
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

    function rolesCU(RolModel $RolModel){

        $pdo = $this->conectarBd();
        
        try{

            $query = '
                SELECT id,`name`,active FROM ad_roles
                WHERE id <> :id AND `name` = :name;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id", $RolModel->_get("id"));
            $result->bindValue(":name", $RolModel->_get("name"));
            $result->execute(); 

            if($result->rowCount()== 0){

                $pdo->beginTransaction();

                $lastInsertId = $RolModel->_get("id");
                
                if($RolModel->_get("id") > 0){

                    $query = '
                        UPDATE ad_roles SET 
                                `name` = :name, 
                                active = :active, 
                                id_user = :id_user 
                        WHERE id = :id; 
                    ';

                    $result = $pdo->prepare($query);
                    $result->bindValue(":id", $RolModel->_get("id"));

                }else{

                    $query = '
                        INSERT INTO ad_roles (`name`,active,id_user) 
                                    VALUES (:name,:active,:id_user)
                    ';

                    $result = $pdo->prepare($query);
                }
                
                $result->bindValue(":name", strtoupper( $RolModel->_get("name")));
                $result->bindValue(":active", $RolModel->_get("active") ? 1 : 0);
                $result->bindValue(":id_user", $RolModel->_get("id_user"));
                $result->execute();

                if($lastInsertId == 0){
                    $lastInsertId =  $pdo->lastInsertId();
                }                     

                $pdo->commit();

                $this->response["state"]= "ok";
                $this->response["message"]= "Resultado de la función rolesCU()";
                $this->response["query"]= $lastInsertId;
            }else{

                $this->response["state"]= "ko";
                $this->response["message"]= "The '". strtoupper($RolModel->_get("descripcion")) ."' rol, is already in the database.";
                $this->response["query"]= $result;
            }      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","RolService/roles()");
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

    function rolesModuleActivexIdUser($id_user){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                m.id id_module,
                m.`name` module,
                m.active
                FROM ad_people_user_roles ru
                JOIN ad_roles_menu_options rm ON rm.id_rol = ru.id_rol
                JOIN ad_modules_menus mm ON mm.id = rm.id_menu
                JOIN ad_modules_menus_options mmo ON mmo.id = rm.id_option
                JOIN ad_modules m ON m.id = mm.id_module
                WHERE ru.id_user = :id_user AND rm.id_option = 1 AND mm.active = 1 AND mmo.active = 1 AND m.active = 1
                GROUP BY m.id
                ORDER BY m.id;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_user", $id_user);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["mensaje"]= "Resultado de la función rolesModuleActivexIdUser()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","RolService/rolesModuleActivexIdUser()");
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

    function rolesMenusActivexIdUser($id_user){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                m.id id_module,
                m.`name` module,
                mm.id id_menu,
                mm.`name` menu,
                mm.father,
                mm.orden,
                mmo.id id_option,
                mmo.`name` opcion
                FROM ad_people_user_roles ru
                JOIN ad_roles_menu_options rm ON rm.id_rol = ru.id_rol
                JOIN ad_modules_menus mm ON mm.id = rm.id_menu
                JOIN ad_modules_menus_options mmo ON mmo.id = rm.id_option
                JOIN ad_modules m ON m.id = mm.id_module
                WHERE ru.id_user = :id_user AND rm.id_option = 1 AND mm.active = 1 AND mmo.active = 1 AND m.active = 1
                GROUP BY rm.id_menu
                ORDER BY mm.orden;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_user", $id_user);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función rolesMenusActivexIdUser()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","RolService/rolesMenusActivexIdUser()");
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

    function rolesMenusxIdMenuxIdUser($id_menu,$id_user ){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                mmo.id id_option,
                mmo.`name` opcion
                FROM ad_people_user_roles ru
                JOIN ad_roles_menu_options rm ON rm.id_rol = ru.id_rol
                JOIN ad_modules_menus mm ON mm.id = rm.id_menu
                JOIN ad_modules_menus_options mmo ON mmo.id = rm.id_option
                JOIN ad_modules m ON m.id = mm.id_module
                WHERE ru.id_user = :id_user AND rm.id_menu = :id_menu AND mm.active = 1 AND mmo.active = 1 AND m.active = 1
                GROUP BY mmo.id
                ORDER BY mmo.id;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_menu", $id_menu);
            $result->bindValue(":id_user", $id_user);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función rolesMenusxIdMenuxIdUser()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","RolService/rolesMenusActivexIdUser()");
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

    function rolesAsignationMenuxIdRol($id_rol){

        $pdo = $this->conectarBd();

        try{

            $query = '
                SELECT
                mmo.id,
                mm.id_module,
                m.`name` module,
                UPPER(gmm.`name`) menu_father,
                mm.id id_menu,
                UPPER(mm.`name`) menu,
                CONCAT(m.`name`," - ",UPPER(IFNULL(gmm.`name`,""))," - ",UPPER(mm.`name`))menu_option,
                mmo.id_option,
                mmop.`name` `option`,
                IF(IFNULL(rmo.id,0)>0,TRUE,FALSE) asignation
                FROM ad_modules_menus mm
                JOIN ad_modules m ON m.id = mm.id_module
                LEFT JOIN ad_modules_menus gmm ON gmm.id = mm.father
                JOIN ad_modules_menus_option mmo ON mmo.id_menu = mm.id
                JOIN ad_modules_menus_options mmop ON mmop.id = mmo.id_option
                LEFT JOIN ad_roles_menu_options rmo ON rmo.id_menu = mm.id AND rmo.id_option = mmop.id AND rmo.id_rol = :id_rol
                WHERE mm.active = 1 AND mm.father >= 0
                ORDER BY mm.orden, mmo.id_option;
            ';

            $result = $pdo->prepare($query);
            $result->bindValue(":id_rol", $id_rol);
            $result->execute(); 
            
            $this->response["state"]= "ok";
            $this->response["message"]= "Resultado de la función rolesAsignationMenuxIdRol()";
            $this->response["query"]= $result;
           
        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","RolService/rolesAsignationMenuxIdRol()");
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

    function rolesAsignationMenuxIdRolCU($id_rol, $permisos, $id_user){

        $pdo = $this->conectarBd();
        
        try{
                $pdo->beginTransaction();


                $query = '
                    DELETE FROM ad_roles_menu_options WHERE id_rol = :id_rol; 
                ';

                $result = $pdo->prepare($query);
                $result->bindValue(":id_rol", $id_rol);
                $result->execute();   
                
                $query = '
                    INSERT INTO ad_roles_menu_options (id_rol,id_menu,id_option,id_user) VALUES (?, ?, ?, ?); 
                ';

                $result3 = $pdo->prepare( $query);

                foreach ($permisos as $permiso) {
                    $result3->execute(array($id_rol, $permiso["id_menu"],$permiso["id_option"],$id_user));
                }   
                $pdo->commit();

                $this->response["state"]= "ok";
                $this->response["message"]= "Resultado de la función rolesAsignationMenuxIdRolCU()";
                $this->response["query"]= $result;      

        }catch(PDOException $e){

            $logModel = new LogModel();

            $logModel->_set("method","RolService/rolesAsignationMenuxIdRolCU()");
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