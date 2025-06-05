<?php

include_once './_configurations/Models.php';
/**
 * @Entity
 * @Description: Permite interactuar con los campos de la tabla
 * @Table: ad_people
 * @Fields: {
 * id,
 * id_type_identification,
 * number,
 * name,
 * email,
 * address,
 * city,
 * state,
 * zip_code,
 * phone,
 * date_birth,
 * active,
 * id_user
 * }
 **/

class PeopleModel extends Models {

    public $id;
    public $id_type_identification; 
    public $number; 
    public $name; 
    public $email; 
    public $address; 
    public $city; 
    public $state;  
    public $zip_code; 
    public $phone; 
    public $date_birth; 
    public $active;
    public $id_user;

    public $guardarUsuario; 
    public $txtUsuarioUsuario; 
    public $txtUsuarioClave;

    function toJson(){
        return array(
             "id" => $this->_get("id"),
             "id_type_identification" => $this->_get("id_type_identification"),
             "number" => $this->_get("number"),
             "name" => $this->_get("name"),
             "email" => $this->_get("email"),
             "address" => $this->_get("address"),
             "city" => $this->_get("city"),
             "state" => $this->_get("state"),
             "zip_code" => $this->_get("zip_code"),
             "phone" => $this->_get("phone"),
             "date_birth" => $this->_get("date_birth"),
             "active" => $this->_get("active"),
             "id_user" => $this->_get("id_user")
         );
     }

}


?>