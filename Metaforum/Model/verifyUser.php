<?php
include_once ('../config.php');
include_once ('user.php');
    $userID = $_REQUEST['userID'];
    try {
        verifyUser($userID);
        header( "Refresh:2; url=http://localhost/Metaforum/homepage.php", true, 303);
      }catch(Exception $e) {
        echo 'Message: ' .$e->getMessage();
      }
?>