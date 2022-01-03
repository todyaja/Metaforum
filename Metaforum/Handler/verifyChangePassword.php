<?php 
include_once('../config.php');
$password = $_REQUEST['password'];
$userid = $_REQUEST['userid'];
$conn = getConnection();
  $query = "UPDATE user SET Password = '$password' WHERE user.UserID LIKE '$userid' AND user.Deleted_At IS NULL ";
    if ($conn->query($query) === TRUE) {
        echo "Change successfull, redirecting to homepage...";
        header( "refresh:3;url=../homepage.php" );
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

?>