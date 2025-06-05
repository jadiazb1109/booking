<?php

include_once './_configurations/Models.php';
/**
 * @Entity
 * @Description: Permite interactuar con los campos de la tabla
 * @Table: services_destiny_union_groups
 * @Fields: {
 * id,
 * service_destiny_union_id,
 * passenger_min,
 * passenger_max,
 * price,
 * additional,
 * notes,
 * active,
 * id_user
 * }
 **/

class UnionServiceDestinyGroupModel extends Models {

    public $id;
    public $service_destiny_union_id;  
    public $passenger_min;
    public $passenger_max;
    public $price;
    public $additional;
    public $notes;
    public $active;
    public $id_user;

    function toJson(){
        return array(
             "id" => $this->_get("id"),
             "service_destiny_union_id" => $this->_get("service_destiny_union_id"),
             "passenger_min" => $this->_get("passenger_min"),
             "passenger_max" => $this->_get("passenger_max"),
             "price" => $this->_get("price"),
             "additional" => $this->_get("additional"),
             "notes" => $this->_get("notes"),
             "active" => $this->_get("active"),
             "id_user" => $this->_get("id_user")
         );
     }

}


?>