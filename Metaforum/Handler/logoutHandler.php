<?php 
include_once('../config.php');
$conn = getConnection();
session_start();
$userid = $_SESSION['UserID'];
$isLoginQuery = "UPDATE user set isLogin = 0 WHERE user.UserID LIKE '$userid' AND user.Deleted_At IS NULL ";
mysqli_query($conn,$isLoginQuery);
session_destroy();

header("Location: ../login.php");

?>