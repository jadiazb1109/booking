<?php

include_once './_configurations/Models.php';
/**
 * @Entity
 * @Description: Permite interactuar con los campos de la tabla
 * @Table: services_destiny_union
 * @Fields: {
 * id,
 * service_id,
 * destiny_id,
 * date,
 * price,
 * additional,
 * promo_one_x_two,
 * promo_next_pass,
 * promo_next_pass_preci,
 * important_information_initial,
 * terms_and_conditions,
 * notes,
 * active,
 * id_user
 * }
 **/

class UnionServiceDestinyModel extends Models {

    public $id;
    public $type_id; 
    public $service_id;  
    public $destiny_id;
    public $date;
    public $price;
    public $additional;
    public $promo_one_x_two;
    public $promo_next_pass;
    public $promo_next_pass_preci;
    public $important_information_initial;
    public $terms_and_conditions;
    public $notes;
    public $active;
    public $id_user;

    function toJson(){
        return array(
             "id" => $this->_get("id"),
             "service_id" => $this->_get("service_id"),
             "destiny_id" => $this->_get("destiny_id"),
             "date" => $this->_get("date"),
             "price" => $this->_get("price"),
             "additional" => $this->_get("additional"),
             "promo_one_x_two" => $this->_get("promo_one_x_two"),
             "promo_next_pass" => $this->_get("promo_next_pass"),
             "promo_next_pass_preci" => $this->_get("promo_next_pass_preci"),
             "important_information_initial" => $this->_get("important_information_initial"),
             "terms_and_conditions" => $this->_get("terms_and_conditions"),
             "notes" => $this->_get("notes"),
             "active" => $this->_get("active"),
             "id_user" => $this->_get("id_user")
         );
     }

}


?>