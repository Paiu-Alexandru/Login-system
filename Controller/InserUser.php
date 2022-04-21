<?php
namespace Controller;
use \Model\Database;

session_start();

class InserUser{
    use Database;

    public function insertUser($data)
    {
        $name =     trim(htmlentities($data['name']));
        $surname =  trim(htmlentities($data['surname']));
        $email =    trim(htmlentities($data['email']));
        $password =  password_hash($data['password'], PASSWORD_BCRYPT);
        $default =  "../../assets/profile_img/default.png";

        $conn = $this->connection();
        $stmt = $conn->prepare("INSERT INTO oop_login.users (name, surname, email, password, profile_image) VALUES(:name, :surname, :email, :password, :profile_image)");
        $stmt->bindParam(":name", $name, \PDO::PARAM_STR);
        $stmt->bindParam(":surname", $surname, \PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, \PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, \PDO::PARAM_STR);
        $stmt->bindParam(":profile_image", $default, \PDO::PARAM_STR);
        
       if ( $stmt->execute()) {
           $last_inserted_id = $conn->lastInsertId();

            $sql = $conn->prepare("SELECT * FROM oop_login.users WHERE id = $last_inserted_id");
            $sql->execute();
            $result = $sql->setFetchMode(\PDO::FETCH_ASSOC);
           
                foreach ($sql->fetchAll() as  $row) {
                   $_SESSION = $row;
                }
       }

      
    }
}