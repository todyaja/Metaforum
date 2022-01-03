<?php
    include_once ('../config.php');
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $conn = getConnection();
    $query = "SELECT * FROM user WHERE user.Username LIKE '$username' AND user.Deleted_At IS NULL LIMIT 1;";
    $result = mysqli_query($conn,$query);
    if ($result->num_rows==0) {
        echo "Username does not exist.";
        die;
    }else {
        $data = mysqli_fetch_assoc($result);
        if(password_verify($password,$data['Password'])){
            $isLoginQuery = "UPDATE user set isLogin = 1 WHERE user.Username LIKE '$username' AND user.Deleted_At IS NULL ";
            mysqli_query($conn,$isLoginQuery);
            session_start();
            $_SESSION['UserID'] = $data['UserID'];
            $_SESSION['Role'] = $data['Role'];
            echo("Login Success");
            exit;
        }
        else{
            echo("Invalid Password");
        }
    }
?>