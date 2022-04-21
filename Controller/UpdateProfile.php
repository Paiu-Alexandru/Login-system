<?php
namespace Controller;
use model\Database;
class UpdateProfile extends RegisterValidation 
{
    use Database;


    public function __construct(array $inserted_data)
    {
        $this->data = $inserted_data;
    }

    public function takeData($id)
    {
        foreach ($this->getUserData($id) as $row) {
           $row;
        }
        
   
            foreach ($this->data as $key => $value) {
                
                    //check if form have any changes
                    if($key == 'name' && $row['name'] != $value){
                        $db_colum ='name';
                        if (!empty($value)) {

                            $this->update($id, $value, $db_colum);
                        }else{
                            $this->addError('name', 'Name cannot be  Empty!');
                        }

                    }elseif($key == 'surname' && $row['surname'] != $value){
                        $db_colum ='surname';
                        if (!empty($value)) {

                            $this->update($id, $value, $db_colum);
                        }else{
                            $this->addError('surname', 'Surname cannot be  Empty!');
                        }
                    }
                    elseif($key == 'email' && $row['surname'] != $value){
                        $db_colum ='email';
                        //email must be unique
                        if (!empty($value)) {
                        
                            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {

                                    if ($this->uniqueEmail($value) == false) {
                                        $this->update($id, $value, $db_colum);
                                    }   
                            }else{
                                $this->addError('email', 'Invalid Email!'); 
                            }
                        }else{
                            $this->addError('email', 'Email cannot be  Empty!');
                        } 
                        
                    }  
                    else{
                        $this->addError('empty', 'Nothing to Updated!'); 
                    }
                
            }
    }

    public function passwordUpdate($id)
    {
         // Values comme frome DATABASE
        foreach ($this->getUserData($id) as $row) {
            $db_pass = $row['password'];
         }
         // Values comme frome INPUT FIELD 
         $input_password = $this->data['password'];
         $new_password = $this->data['new_password'];
         $confirm_password = $this->data['confirm_password'];

         //echo $password.'<hr>'.$new_password.'<hr>'.$confirm_password;

        if (!empty($input_password)) {
            
            if (password_verify($input_password, $db_pass)) {
                if (!empty($new_password)) {

                        if (!preg_match('/^[a-zA-Z0-9]{6,20}$/', $new_password) && empty($confirm_password)) {

                            $this->addError('new_password', 'New Password must be longer than 6 chars!');
                            $this->addError('confirm_password', 'You forgot to confirm password!');
                        }
                        elseif($new_password === $confirm_password){

                            $value = trim(htmlentities($new_password));
                            $value = password_hash($value, PASSWORD_BCRYPT);
                            $db_colum = "password";

                            $this->update($id, $value, $db_colum);//cr7@gmail.com

                        }else{

                            return $this->addError('confirm_password', 'Confirmation password does not match!');
                        }   
                }
            }else{

                $this->addError('password', 'Password incorect.');
            }
        }
    }

    public function uploadProfileImg($file, $id)
    {
        $conn = $this->connection();
        $file_name = $file['profile_image']['name'];
        $tmp_name = $file['profile_image']['tmp_name'];
        $type = $file['profile_image']['type'];
        $size = $file['profile_image']['size'];
        $unique_name = "profile_".$id;  //it is designed in this way because a user must have a single image.
                                        //And it is not necessary to generate a unique name for each image.

        $get_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $filtered_extensioin = strtolower($get_extension);
        $allowed_extension = array("jpg", "jpeg", "png");

        if (in_array($filtered_extensioin, $allowed_extension)) {
            $allowed_size = (1024*1024) * 4; // approximative 4mb
            if ($size < 5000000) { //5000000 = 5MB

                $new_file_name = $unique_name.".". $filtered_extensioin;
                $path = "../../assets/profile_img/".$new_file_name;
                $db_colum = "profile_image";

                $sql = "SELECT profile_image FROM oop_login.users WHERE id = $id";
                $sql = $conn->prepare($sql);
                $sql->execute();
                $sql->setFetchMode(\PDO::FETCH_ASSOC);

                    foreach ($sql->fetchAll() as  $row) {
                      
                    }
                    $value = $path;
                    if ($row['profile_image'] ==  "../../assets/profile_img/default.png") {
                       
                        move_uploaded_file($tmp_name, $value);
                        $this->update($id, $value, $db_colum);
                    } 
                    if ($row['profile_image'] !=  "../../assets/profile_img/default.png"){
    
                        unlink($row['profile_image']);
                        move_uploaded_file($tmp_name, $value);
                            
                            
                            //1$original_image  the parameter ich I want to cut
                            //2$cropped_image  destination image where to save after cropping if will be the same name will replace the original image
                            //3 Width
                            //4 heght
                            if ($filtered_extensioin ==  "jpeg" || $filtered_extensioin ==  "png") {
                                $image = new Image();
                                if($image->squareImage($value, $value, 800, 800, $filtered_extensioin) == true){
                                    
                                    $image->squareImage($value, $value, 800, 800, $filtered_extensioin);
                                }
                            }
                        
                        $this->update($id, $value, $db_colum);
                    }
                    
            } else {
                $this->addError('profileImage', 'Your file is too big!');
            }
        }else {
            $this->addError('profileImage', 'Allowed just  .jpg .jpeg .png extension!');
        }
        
    }


    public function update($id, $value, $db_colum)
    {
        $value = trim(htmlentities( $value));
        $conn = $this->connection();
        $sql = $conn->prepare("UPDATE oop_login.users SET $db_colum=:$db_colum WHERE id = $id");
        $sql->bindParam(':'.$db_colum, $value);

        if($sql->execute()){
            $this->addError('updated', 'Profile Updated!'); 
            
        }

    }

    public function getUserData($id)
    {
        $sql = "SELECT * FROM oop_login.users  WHERE id = $id";
        $sql = $this->connection()->prepare($sql);
        $sql->execute();
        $sql->setFetchMode(\PDO::FETCH_ASSOC);

        return $sql->fetchAll();
        
    }

    public function alertMessage($error)
    {
        if (isset($this->error['updated'])){
            ?>
             <div class="alert alert-success" role="alert">
                 <div ><?php echo $this->error['updated'] ?? ''; ?></div>
             </div>
             <?php
         }
         elseif (isset($this->error['empty'])){
             ?>
              <div class="alert alert-primary" role="alert">
                  <div ><?php echo $this->error['empty'] ?? ''; ?></div>
              </div>
              <?php
          }
    }

    public function deleteProfileImage($id)
    {
        $conn = $this->connection();
        $sql = "SELECT profile_image FROM oop_login.users WHERE id = $id";
        $sql = $conn->prepare($sql);
        $sql->execute();
        $sql->setFetchMode(\PDO::FETCH_ASSOC);

            foreach ($sql->fetchAll() as  $row) {
              
            }
            $value = "../../assets/profile_img/default.png";
            $db_colum = "profile_image";
            if ($row['profile_image'] == $value) {
                $this->addError('deleteImage', 'You cannot delete default Image!');
            }else{
                unlink($row['profile_image']);
                $this->update($id, $value, $db_colum);
            }
           
        
    }
}
?>