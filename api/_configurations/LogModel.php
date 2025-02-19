<?php

include_once 'Models.php';

/**
 * @Entity
 * @Description: Permite interactuar con los campos de la tabla
 * @Table: log_errores
 * @Fields: {
 * id,
 * method,
 * query,
 * code,
 * error
 * }
 **/
class LogModel extends Models {

    public $id;
    public $method;
    public $query;
    public $code;
    public $error;

    function toJson(){
        return array(
             "id" => $this->_get("id"),
             "method" => $this->_get("method"),
             "query" => $this->_get("query"),             
             "code" => $this->_get("code"),
             "error" => $this->_get("error")
         );
     }

}


?>