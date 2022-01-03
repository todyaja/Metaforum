<?php

include_once ('../config.php');
include_once ('sendEmail.php');

class User{
  public $UserID;
  public $UserName;
  public $Email;
  public $Password;
  public $Verified;
  public $Role;
  public $Status;
  public $DisplayPicture;
  public $Description;
  public $EmailVisibility;
  public $DeletedAt;
}
function createUser(User $user) {
  $conn = getConnection();
  $query = "INSERT INTO user (UserID,Username, Email, Password, Verified, Role, Status, Display_Picture, Description, Email_Visibility, Deleted_At, isLogin) VALUES ('$user->UserID','$user->UserName', '$user->Email', '$user->Password', $user->Verified, $user->Role, $user->Status, '$user->DisplayPicture', '$user->Description', $user->EmailVisibility, NULL, 0)";
    if ($conn->query($query) === TRUE) {
        sendEmail($user->Email,$user->UserName,$user->UserID);
        echo "Record inserted successfully<br>";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
    
}
function verifyUser($userID) {
  $conn = getConnection();
  $query = "UPDATE user SET Verified = 1 WHERE user.UserID = '$userID'";
    if ($conn->query($query) === TRUE) {
        echo "Verified successfully<br>";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
    
}


?>