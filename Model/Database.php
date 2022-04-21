<?php

namespace Model;

/*
  Database connection
 */
trait Database

{
    private $host;
    private $username;
    private $pass;
    private $dbName;
    private $charset;
    private $conn;

    public function connection()
    {
       $this->host = "localhost";
       $this->username = "root";
       $this->pass = "";
       $this->dbName = "oop_login";
       $this->charset = "utf8mb4";

       try {
            $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName.";charset=".$this->charset;
            // Must instantiate like this (\PDO) class otherwise we got an error.
            $this->conn = new \PDO($dsn, $this->username, $this->pass );
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $this->conn;
       } 
       catch (\Exception $e) {
           echo "Conecction Failed". $e->getMessage();
       }
       
    }
}
