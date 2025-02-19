<?php

include_once 'ApplicationProperties.php';
include_once 'LogModel.php';

class ConexionService
{

    private $_connexion;

    function __construct()
    {
        $this->_connexion = null;
    }


    public function conectarBd()
    {
        try {

            if ($this->_connexion == null) {

                $this->_connexion = new PDO("mysql:host=" . __DB_HOST__ . ";dbname=" . __DB_NAME__ . ";charset=" . __DB_CHARSET__, __DB_USERNAME__, __DB_PASSWORD__);

                $this->_connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->_connexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                $result =  $this->_connexion->prepare("SET time_zone = '-05:00';");
                $result->execute();

                $result =  $this->_connexion->prepare("SET NAMES utf8mb4 COLLATE utf8mb4_general_ci;");
                $result->execute();
            }

            return $this->_connexion;

        } catch (PDOException $ex) {
            die(json_encode(
                array(
                    "state" => "ko",
                    "message" => $ex->getMessage(),
                    "query" => []
                )
            ));
        }
    }

    public function desconectarBd()
    {
        return $this->_connexion = null;
    }

    public function guardarLogErrores(LogModel $LogModel)
    {
        $pdo = $this->conectarBd();

        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }        

        $query = 'INSERT INTO log_errores (date,method,query,code,error) 
                                VALUES (NOW(),:method,:query,:code,:error);';

        $result =  $pdo->prepare($query);
        $result->bindValue(":method", $LogModel->_get("method"));
        $result->bindValue(":query", $LogModel->_get("query"));
        $result->bindValue(":code", $LogModel->_get("code"));
        $result->bindValue(":error", $LogModel->_get("error"));
        $result->execute();

        return $pdo->lastInsertId();
        
    }


    public function encriptarTexto($texto)
    {
        return MD5($texto);
    }

    public function obtenerIp()
    {

        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
            return $_SERVER["HTTP_X_FORWARDED"];
        } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
            return $_SERVER["HTTP_FORWARDED"];
        } else {
            return $_SERVER["REMOTE_ADDR"];
        }
    }
}