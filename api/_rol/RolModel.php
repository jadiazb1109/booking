<?php

include_once './_configurations/Models.php';
/**
 * @Entity
 * @Description: Permite interactuar con los campos de la tabla
 * @Table: ad_roles
 * @Fields: {
 * id,
 * name,
 * active,
 * id_user
 * }
 **/

class RolModel extends Models {

    public $id;
    public $name;  
    public $active;
    public $id_user;
    public $menus;

    function toJson(){
        return array(
             "id" => $this->_get("id"),
             "name" => $this->_get("name"),
             "active" => $this->_get("active"),
             "id_user" => $this->_get("id_user")
         );
     }

}


?>