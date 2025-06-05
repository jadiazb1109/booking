<?php

include_once './_configurations/Models.php';
/**
 * @Entity
 * @Description: Permite interactuar con los campos de la tabla
 * @Table: gen_terceros_usuarios
 * @Fields: {
 * id,
 * id_people,
 * username
 * image,
 * password,
 * token,
 * active,
 * id_user,
 * sidebar_color,
 * theme_color
 * }
 **/

class UserModel extends Models {

    public $id;
    public $id_people;
    public $people;
    public $username;
    public $image;
    public $password;
    public $token;    
    public $active;
    public $id_user;
    public $roles;
    public $sidebar_color;
    public $theme_color;

    function toJson(){
        return array(
             "id" => $this->_get("id"),
             "id_people" => $this->_get("id_people"),
             "people" => $this->_get("people"),
             "username" => $this->_get("username"),
             "image" => $this->_get("image"),
             "password" => $this->_get("password"),            
             "token" => $this->_get("token"),
             "active" => $this->_get("active"),
             "id_user" => $this->_get("id_user")
         );
    }
    function toJsonLogin(){
        return array(
             "id" => $this->_get("id"),
             "id_people" => $this->_get("id_people"),
             "people" => $this->_get("people"),
             "username" => $this->_get("username"),         
             "token" => $this->_get("token"),
             "active" => $this->_get("active")
         );
    }

}


?>