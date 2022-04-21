<?php
require "../header.php";
use Controller\UpdateProfile;

$id = $_SESSION['id'];
$getData = new UpdateProfile($_POST);
$output = $getData->getUserData($id);



foreach ($output as $value) {
   $value['name'];
}

?>

<h1>Home page</h1><br>

<h4><?php echo $value['name'] .' '. $output['0']['surname']; ?></h4>
<?php require "../footer.php";?>