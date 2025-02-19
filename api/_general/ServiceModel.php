<?php

include_once './_configurations/Models.php';
/**
 * @Entity
 * @Description: Permite interactuar con los campos de la tabla
 * @Table: services
 * @Fields: {
 * id,
 * name,
 * price,
 * additional,
 * active
 * }
 **/

class ServiceModel extends Models {

    public $id;
    public $name;  
    public $price;
    public $additional;
    public $active;

    function toJson(){
        return array(
             "id" => $this->_get("id"),
             "name" => $this->_get("name"),
             "price" => $this->_get("price"),
             "additional" => $this->_get("additional"),
             "active" => $this->_get("active")
         );
     }

}


?>