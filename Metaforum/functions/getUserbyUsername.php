<?php
    include_once ('../config.php');
    $username = $_REQUEST['username'];
    $conn = getConnection();
    $query = "SELECT * FROM user SET WHERE user.Username = '$username' AND user.Deleted_At IS NULL ";
    $result = mysqli_query($conn,$query);
    if (!$result) {
        echo "Connection error";
    }else {
        echo json_encode($result);
    }
?>