<?php
    include_once 'user.php';
    include_once '../config.php';
    $user = new User();
    $user->UserID = uniqid();
    $user->UserName = $_POST['Username'];
    $user->Email = $_POST['Email'];
    $user->Password = password_hash($_POST['Password'],PASSWORD_DEFAULT);
    $user->Verified = 0;
    $user->Role = 2;
    $user->Status = 0;
    $user->DisplayPicture = "guest.jpg";
    $user->Description = "";
    $user->EmailVisibility = 0;
    try {
        createUser($user);
        echo 'User Created Succesfully';
      }catch(Exception $e) {
        echo 'Message: ' .$e->getMessage();
      }
?>