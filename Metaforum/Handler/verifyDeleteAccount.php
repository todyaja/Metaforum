<?php 
session_start();
include_once('../config.php');
$userid = $_REQUEST['userid'];
$conn = getConnection();
  $query = "UPDATE user SET Deleted_At = now() WHERE user.UserID LIKE '$userid' AND user.Deleted_At IS NULL ";
    if ($conn->query($query) === TRUE) {
        echo "Change successfull, redirecting to homepage...";
        session_destroy();
        header( "refresh:3;url=../homepage.php" );
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

?>