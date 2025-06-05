<?php

include_once './_configurations/Models.php';
/**
 * @Entity
 * @Description: Permite interactuar con los campos de la tabla
 * @Table: ad_m_type_identification
 * @Fields: {
 * id,
 * name,
 * abbreviation,
 * active,
 * id_user
 * }
 **/

class TypeIdetificationModel extends Models {

    public $id;
    public $name;  
    public $abbreviation;
    public $active;
    public $id_user;

    function toJson(){
        return array(
             "id" => $this->_get("id"),
             "name" => $this->_get("name"),
             "abbreviation" => $this->_get("abbreviation"),
             "active" => $this->_get("active"),
             "id_user" => $this->_get("id_user")
         );
     }

}


?>