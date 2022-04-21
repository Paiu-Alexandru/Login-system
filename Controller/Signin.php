<?php
namespace Controller;
use \Model\Database;

class Signin{

    use Database;

    private array $data;
    public array $error = [];
    private static $inputs = ['email', 'password'];

    
    public function __construct(array $post_data)
    {
        $this->data = $post_data;
    }

    public function validateUpdateProfile()
    {
        foreach (self::$inputs as $input) {
            if (!array_key_exists($input, $this->data)) {
               trigger_error("Error");
            }
        }
   
    }
    public function signIn()
    {
        $conn = $this->connection();

        $email = trim(htmlentities( $this->data['email']));
        $password = trim(htmlentities($this->data['password']));
        $hash_pass = password_hash($password, PASSWORD_BCRYPT);

        
        $sql = $conn->prepare("SELECT * FROM oop_login.users WHERE email = '$email'");
        $sql->execute();
        $sql->setFetchMode(\PDO::FETCH_ASSOC);

            if (!$sql->rowcount() > 0)
            {
                return $this->addError("email", "No users with this email registered.");
            }
            else 
            {
                if(isset($password)){
                    return  $this->checkPassword($password, $sql);
                }else {
                    return $this->addError("password", "Password incorect.");
                }
            }
                 
    }
    public function checkPassword($password, $sql)
    {

        foreach ($sql->fetchAll() as  $row) {
             $row['password'];// Take out password And verify. If is true create a full session If not throw error

            if (password_verify($password,  $row['password'])) {
                $_SESSION = $row;// Generate full session
                header('location: home.php');
            }else {
                return $this->addError("password", "Password incorect.");
            }
        }
    }

    public function addError($key, $value)
    {
       return $this->error[$key] = $value;
    }
}