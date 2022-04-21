<?php
require_once "../../autoload/autoloader.php";
use Controller\RegisterValidation;


if (isset($_POST['submit'])) {
    $validate = new RegisterValidation($_POST);
    $validate->validateForm();
    $error = $validate->error;
  
    if ($error == null) {
        $error = $validate->insert();
        header('location: home.php');
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <title>Document</title>
</head>
<body>

<div class="container ">
    <div class="py-12">

        <div class="col mt-5 p-3">
            <div class="col-6 mx-auto ">
                <div class="card rounded shadow p-3 mb-5 bg-body rounded">
                    <div class="card-header bg bg-dark text-light p-3">
                        <h4>Register</h4>
                        
                    </div>
                        <div class="card-body ">
                            <form action="#" method="post">
                                <div class="mb-3">
                                    <label for="fname" class="form-label">Name</label>
                                    <input type="text" name="name" value="<?php echo $_POST['name'] ?? '';?>" class="form-control" id="fname" >
                                    <div id="fname" class="form-text text-danger"><?php echo $error['name'] ?? '';?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Surname</label>
                                    <input type="text" name="surname" value="<?php echo $_POST['surname'] ?? '';?>" class="form-control" >
                                    <div id="fname" class="form-text text-danger"><?php echo $error['surname'] ?? '';?></div>
                                </div>
                                <div class="mb-3">
                                    <label  class="form-label">Email address</label>
                                    <input type="text" name="email" value="<?php echo $_POST['email'] ?? '';?>" class="form-control" >
                                    <div id="fname" class="form-text text-danger"><?php echo $error['email'] ?? "We'll never share your email with anyone else.";?></div>
                                </div>
                                <div class="mb-3">
                                    <label  class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" >
                                    <div id="fname" class="form-text text-danger"><?php echo $error['password'] ?? '';?></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="confirm_password" class="form-control" >
                                    <div id="fname" class="form-text text-danger"><?php echo $error['confirm_password'] ?? '';?></div>
                                </div>
                                
                                <button type="submit" name="submit" class="btn btn-primary form-control mb-3">Submit</button>
                            </form>
                            <div class="text-end">
                            <a href="signin.php?out=1" class="text-end m-3">Sign in</a>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require "../footer.php";?>