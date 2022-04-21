<?php
require "../header.php";

use Controller\UpdateProfile;

$id = $_SESSION['id'];
$db_profile_img = $_SESSION['profile_image'];

/*get Data from DB befor submit*/
$update = new UpdateProfile($_POST);
if(isset($_GET['delete']) && $_GET['delete'] == "profile_img"){
    $update->deleteProfileImage($id);
}
$getData = $update->getUserData($id);

/*
echo "<pre>";
print_r($_FILES);
echo "</pre>";
*/

if (isset($_POST['update'])) {
    $update = new UpdateProfile($_POST);
    $update->takeData($id);

    if ($_FILES['profile_image']['name']) {
        $update->uploadProfileImg($_FILES, $id);
      
    }

    /*get Data from DB after submit*/
    $getData = $update->getUserData($id);

    $update->passwordUpdate($id);
}
    $error = $update->error;



    

?>


<!-- style="border:1px solid red;" -->

<div class="container rounded container-fluid  mt-5 mb-5">

    <div class="row justify-content-center" >
        <div class="text-center mb-3">
            <h2 class="text-right">Profile Settings</h2>
        </div>

           <!--GET USER DATA START FOREACH-->
           <?php foreach ($getData as $row) { ?>
        
                <div class="col-xl-3 col-sm-6" >
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5 shadow p-3 mb-5 bg-body rounded">
                        <div class="shadow p-2 mb-5 bg-body rounded rounded-circle bg bg-dark" style="width:170px; height:170px; overflow:hidden;"> 
                            <img class="rounded-circle m-1 rounded" width="150" height="150"  src="<?php echo $row['profile_image']?>"><br>
                           
                        </div>
                         <a href="?delete=profile_img" style="text-decoration:none; color:#7e42f5;">Delete Image</a>
                         <div class="form-text text-danger"><?php echo $error['deleteImage'] ?? '';?></div>
                         <div class="rounded border border-secondary px-3 py-2">
                            <span class="font-weight-bold"><?php echo $row['name']?></span><br>
                            <span class="text-black-50"><?php echo $row['email']?></span>
                        </div>
                    </div>
                </div>
                

                <div class="col-xl-7 col-sm-10" >
                    <!-- Card start-->
                    
                        <!-- Alert Updated or Not-->
                        <?php if (isset($error)){ $update->alertMessage($error);}?>
                    <div class="card shadow p-3 mb-5 bg-body rounded">
                        
                        
                        <div class="text-end">
                            <a href="home.php" class="btn btn-dark mb-4">Close</a>
                        </div>
                        

                            <form class="px-4 pb-3" action="<?php echo htmlentities('?update='.$id)?>" method="post" enctype="multipart/form-data">

                                <div class="row mt-2">

                                    <div class="col-md-6">
                                        <label class="labels">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="<?php echo $row['name']?>"  value="<?php echo $row['name']?>">
                                        <div class="form-text text-danger"><?php echo $error['name'] ?? '';?></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="labels">Surname</label>
                                        <input type="text" name="surname" class="form-control" placeholder="<?php echo $row['surname']?>" value="<?php echo $row['surname']?>">
                                        <div class="form-text text-danger"><?php echo $error['surname'] ?? '';?></div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                            
                                    <div class="col-md-12">
                                        <label class="labels" >Email </label>
                                        <input type="text" name="email" class="form-control" placeholder="<?php echo $row['email']?>" value="<?php echo $row['email']?>">
                                        <div class="form-text text-danger"><?php echo $error['email'] ?? '';?></div>

                                    </div>
                            
                                </div>
                                <div class="row mt-3">
                            
                                    <div class="col-md-12">
                                        <label class="labels">Set new Profile Image </label>
                                        <input type="file" name="profile_image"  class="form-control">
                                        <div  class="form-text text-danger"><?php echo $error['profileImage'] ?? '';?></div>

                                    </div>
                            
                                </div>

                                <div class="mt-3">
                                    <label  class="labels">Curent Password</label>
                                    <input type="password" name="password" class="form-control" >
                                    <div  class="form-text text-danger"><?php echo $error['password'] ?? '';?></div>
                                </div>

                                <div class="mt-3">
                                    <label  class="labels">New Password</label>
                                    <input type="password" name="new_password" class="form-control" >
                                    <div class="form-text text-danger"><?php echo $error['new_password'] ?? '';?></div>
                                </div>

                                <div class="mt-3">
                                    <label class="labels">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" >
                                    <div class="form-text text-danger"><?php echo $error['confirm_password'] ?? '';?></div>
                                </div>
                                
                                <div class="mt-5 text-center">
                                    <button type="submit" name="update" class="form-control btn btn-primary profile-button" >Update Profile</button>
                                </div>
                        

                        </form>      

                    <!-- Card end-->
                    </div>
                </div>
             
            
      <!-- END FOREACH-->
      <?php } ?>      
    </div>
</div>

<?php require "../footer.php";?>