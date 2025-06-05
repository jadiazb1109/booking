<?php

include_once './_configurations/Models.php';
/**
 * @Entity
 * @Description: Permite interactuar con los campos de la tabla
 * @Table: services
 * @Fields: {
 * id,
 * type_id,
 * name,
 * notes,
 * return,
 * room_number,
 * active,
 * id_user
 * }
 **/

class ServiceModel extends Models {

    public $id;
    public $type_id;  
    public $name;
    public $notes;
    public $return;
    public $room_number;
    public $active;
    public $id_user;

    function toJson(){
        return array(
             "id" => $this->_get("id"),
             "type_id" => $this->_get("type_id"),
             "name" => $this->_get("name"),
             "notes" => $this->_get("notes"),
             "return" => $this->_get("return"),
             "room_number" => $this->_get("room_number"),
             "active" => $this->_get("active"),
             "id_user" => $this->_get("id_user")
         );
     }

}


?>