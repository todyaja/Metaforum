<?php 
include_once('../config.php');
$password = $_REQUEST['password'];
$userid = $_REQUEST['userid'];
$hashpassword = password_hash($password,PASSWORD_DEFAULT) ;
$conn = getConnection();
  $query = "UPDATE user SET Password = '$hashpassword' WHERE user.UserID = '$userid' AND user.Deleted_At IS NULL ";
    if ($conn->query($query) === TRUE) {
        echo "Change successfull";
        header( "refresh:3;url=../homepage.php" );
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

?>