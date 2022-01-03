<?php
    include_once ('../config.php');
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $conn = getConnection();
    $query = "SELECT * FROM user WHERE user.Email LIKE '$email' LIMIT 1;";
    $result = mysqli_query($conn,$query);
    if ($result->num_rows==0) {
        echo "E-mail is not associated with an account";
        die;
    }else {
        $data = mysqli_fetch_assoc($result);
        if(password_verify($password,$data['Password'])){
            $isLoginQuery = "UPDATE user set isLogin = 1 WHERE user.Username LIKE '$email' AND user.Deleted_At IS NULL ";
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