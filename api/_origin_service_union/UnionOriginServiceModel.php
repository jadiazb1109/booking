<?php

include_once './_configurations/Models.php';
/**
 * @Entity
 * @Description: Permite interactuar con los campos de la tabla
 * @Table: origins_services_union
 * @Fields: {
 * id,
 * origin_id,
 * service_id,
 * active,
 * id_user
 * }
 **/

class UnionOriginServiceModel extends Models {

    public $id;
    public $origin_id;  
    public $service_id;
    public $active;
    public $id_user;

    function toJson(){
        return array(
             "id" => $this->_get("id"),
             "origin_id" => $this->_get("origin_id"),
             "service_id" => $this->_get("service_id"),
             "active" => $this->_get("active"),
             "id_user" => $this->_get("id_user")
         );
     }

}


?>