<?php

include_once 'Models.php';

/**
 * @Entity
 * @Description: Permite interactuar con los campos de la tabla
 * @Table: log_errores
 * @Fields: {
 * id,
 * metodo,
 * consulta,
 * codigo,
 * error
 * }
 **/
class LogModel extends Models {

    public $id;
    public $metodo;
    public $consulta;
    public $codigo;
    public $error;

    function toJson(){
        return array(
             "id" => $this->_get("id"),
             "metodo" => $this->_get("metodo"),
             "consulta" => $this->_get("consulta"),             
             "codigo" => $this->_get("codigo"),
             "error" => $this->_get("error")
         );
     }

}


?>