<?php 
session_start();
include_once ('../config.php');
$conn = getConnection();
$userid = $_SESSION['UserID'];
$username = $_REQUEST['username'];
$desc = $_REQUEST['description'];
$email_visibilty = $_REQUEST['email-visibility'];
if($email_visibilty=='true'){
    $ev=0;
}else{
    $ev=1;
}
if($_FILES['image']){
    $displaypic = uniqid();
    $tmp_name = $_FILES['image']['tmp_name'];
    $path = $_FILES['image']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $image = $displaypic.'.'.$ext;
    move_uploaded_file($tmp_name, "../assets/$image");
}
else{
    $image = 'guest.jpg';
}
    $query = "UPDATE user SET Username = '$username', Display_Picture = '$image', Description = '$desc', Email_Visibility = $ev, lastChangedUsername = now() WHERE user.UserID = '$userid' AND user.Deleted_At IS NULL ";
  
if ($conn->query($query) === TRUE) {
    echo "Change account successfully";
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
?>