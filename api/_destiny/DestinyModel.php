<?php

include_once './_configurations/Models.php';
/**
 * @Entity
 * @Description: Permite interactuar con los campos de la tabla
 * @Table: destinys
 * @Fields: {
 * id,
 * type_id,
 * name,
 * address,
 * notes,
 * active,
 * id_user
 * }
 **/

class DestinyModel extends Models {

    public $id;
    public $type_id;  
    public $name;
    public $address;
    public $notes;    
    public $active;
    public $id_user;

    function toJson(){
        return array(
             "id" => $this->_get("id"),
             "type_id" => $this->_get("type_id"),
             "name" => $this->_get("name"),
             "address" => $this->_get("address"),
             "notes" => $this->_get("notes"),             
             "active" => $this->_get("active"),
             "id_user" => $this->_get("id_user")
         );
     }

}


?>