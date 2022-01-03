<?php
    include_once 'config.php';
    session_start();
    $userid = $_SESSION['UserID'];
    $conn = getConnection();
    $username = $_REQUEST['username'];
    $query = "SELECT * FROM user WHERE Username LIKE '$username' AND UserID NOT LIKE '$userid' AND user.Deleted_At IS NULL ";
    $result = mysqli_query($conn,$query);
    if(!$result){
        echo("Connection error");
    }
    else{
        echo($result->num_rows);
    }
?>