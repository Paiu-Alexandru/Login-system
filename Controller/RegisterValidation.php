<?php
namespace Controller;
use \Model\Database;


class RegisterValidation{
    use Database;
    
    protected array $data;
    public array $error = [];
    public array $fields = ['name', 'surname', 'email', 'password', 'new_password', 'confirm_password'];

    public function __construct (array $post_data)
    {
        $this->data = $post_data;
    }

    public function validateForm()
    {
       
       $this->validateFname();
       $this->validateLname();
       $this->validateEmail();
       $this->validatePass();

       
       
    }
    public function validateFname()
    {
       $val = trim($this->data['name']);
       if (empty($val)) {
           $this->addError('name', 'First name is Required');
       }
          //  Start regular /^ end $/        {2,20}-from 2characters to 20
       elseif (!preg_match('/^[a-zA-Z0-9]{2,20}$/', $val) ){
            $this->addError('name', 'Family name must be 2-20 Chars and Alphanumeric!');
               
       }
    }
    private function validateLname()
    {
        $val = trim($this->data['surname']);

        if (empty($val)) {
            $this->addError('surname', 'Last name is Required');
        } else {
           if (!preg_match('/^[a-zA-Z0-9]{2,20}$/', $val)) {
              $this->addError('surname', 'Family name must be 2-20 Chars and Alphanumeric!');
           } 
        }
    }
    protected function validateEmail()
    {
        $val = $this->data['email'];
        $val = trim(htmlentities($val));

        if (empty($val)) {
            $this->addError('email', 'Email required!');
        } else {
            if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
               $this->addError('email', 'Invalid Email!');
            }
            else{

                if( $this->uniqueEmail($val) == true){
                    $this->addError("email", "This email already registered.");
                }
            }   
        }
    }

    public function uniqueEmail($val)
    {
        $conn = $this->connection();
        $sql = $conn->prepare("SELECT email FROM oop_login.users WHERE email = '$val'");
        $sql->execute();
        $sql->setFetchMode(\PDO::FETCH_ASSOC);

            return $sql->rowcount() > 0;
           
    }

    public function validatePass()
    {
        $password = trim($this->data['password']);
        $confirm_password = trim($this->data['confirm_password']);
        if (empty($password)) {
            return $this->addError('password', 'Password required!');

        } elseif (empty($confirm_password)) {
            return $this->addError('confirm_password', 'You forgot to confirm password!');
        }
        elseif (!preg_match('/^[a-zA-Z0-9]{6,20}$/', $password)) {
            return $this->addError('password', 'Password must be longer than 6 chars!');
        }
        elseif ($password !== $confirm_password) {
            return $this->addError('confirm_password', 'Confirmation password does not match!');
        } 
    }
    protected function addError($key, $value)
    {
       return $this->error[$key] = $value;
    }


    public function insert()
    {
       $data = $this->data;
       $insert = new InserUser();
       $insert->insertUser($data);
       
    }

    
}