<?php

include_once './_configurations/Models.php';
/**
 * @Entity
 * @Description: Permite interactuar con los campos de la tabla
 * @Table: origins
 * @Fields: {
 * id,
 * name,
 * address,
 * notes,
 * active
 * }
 **/

class OriginModel extends Models {

    public $id;
    public $name;  
    public $address;
    public $notes;
    public $active;

    function toJson(){
        return array(
             "id" => $this->_get("id"),
             "name" => $this->_get("name"),
             "address" => $this->_get("address"),
             "notes" => $this->_get("notes"),
             "active" => $this->_get("active")
         );
     }

}


?>